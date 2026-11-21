#!/usr/bin/env bash
set -euo pipefail

# Return an empty string only if the registry explicitly reports a missing tag.
digest() {
    local reference=$1 capture
    capture=$(mktemp -d)
    if skopeo inspect --raw "docker://$reference" >"$capture/manifest" 2>"$capture/error"; then
        sha256sum "$capture/manifest" | awk '{print "sha256:" $1}'
    elif ! grep -Eqi 'manifest unknown|manifest not found|name unknown' "$capture/error"; then
        cat "$capture/error" >&2
        rm -f "$capture/manifest" "$capture/error"
        rmdir "$capture"
        return 1
    fi
    rm -f "$capture/manifest" "$capture/error"
    rmdir "$capture"
}

source_image="$GHCR_IMAGE:$VERSION"
source_digest=$(digest "$source_image")
if [[ -z "$source_digest" ]]; then
    candidates=()
    for arch in amd64 arm64; do
        docker load -i "loghog-$arch.tar.gz"
        candidate="$GHCR_IMAGE:build-$GITHUB_RUN_ID-$GITHUB_RUN_ATTEMPT-$arch"
        docker tag "loghog:release-$arch" "$candidate"
        docker push "$candidate"
        candidates+=("$GHCR_IMAGE@$(digest "$candidate")")
    done
    docker buildx imagetools create --tag "$source_image" "${candidates[@]}"
    source_digest=$(digest "$source_image")
fi
test -n "$source_digest"

# Validate both entries, including when retrying a partially published release.
for arch in amd64 arm64; do
    skopeo --override-os linux --override-arch "$arch" inspect --config \
        "docker://$GHCR_IMAGE@$source_digest" |
        jq -e --arg arch "$arch" --arg version "$VERSION" --arg revision "$REVISION" \
            '.architecture == $arch and .os == "linux"
            and .config.Labels["org.opencontainers.image.version"] == $version
            and .config.Labels["org.opencontainers.image.revision"] == $revision' >/dev/null
done

hub_version="$HUB_IMAGE:$VERSION"
hub_digest=$(digest "$hub_version")
if [[ -z "$hub_digest" ]]; then
    skopeo copy --all --preserve-digests "docker://$GHCR_IMAGE@$source_digest" "docker://$hub_version"
elif [[ "$hub_digest" != "$source_digest" ]]; then
    echo "Docker Hub tag $hub_version already points to another release image" >&2
    exit 1
fi
test "$(digest "$hub_version")" = "$source_digest"

# A rerun for an older release must not move either latest tag backwards.
advance_latest=true
for image in "$GHCR_IMAGE" "$HUB_IMAGE"; do
    latest_digest=$(digest "$image:latest")
    if [[ -n "$latest_digest" ]]; then
        latest_version=$(skopeo --override-os linux --override-arch amd64 inspect --config \
            "docker://$image@$latest_digest" | jq -r '.config.Labels["org.opencontainers.image.version"] // ""')
        if [[ "$latest_version" =~ ^[0-9]+\.[0-9]+(\.[0-9]+)?$ ]] &&
            [[ "$latest_version" != "$VERSION" ]] &&
            [[ "$(printf '%s\n' "$VERSION" "$latest_version" | sort -V | tail -1)" == "$latest_version" ]]; then
            advance_latest=false
        fi
    fi
done
if [[ "$advance_latest" == true ]]; then
    for image in "$GHCR_IMAGE" "$HUB_IMAGE"; do
        if [[ "$(digest "$image:latest")" != "$source_digest" ]]; then
            skopeo copy --all --preserve-digests "docker://$GHCR_IMAGE@$source_digest" "docker://$image:latest"
        fi
        test "$(digest "$image:latest")" = "$source_digest"
    done
fi
printf 'digest=%s\n' "$source_digest" >> "$GITHUB_OUTPUT"

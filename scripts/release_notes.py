"""Prepare, verify, and publish the same release notes in each format."""

import argparse
import html
from pathlib import Path
import re


ROOT = Path(__file__).resolve().parents[1]
CONFIG = ROOT / "core/php/configStatic.php"
START = "    // BEGIN CURRENT RELEASE NOTES\n"
END = "    // END CURRENT RELEASE NOTES\n"
VERSION = r"(?:0|[1-9]\d*)\.(?:0|[1-9]\d*)(?:\.(?:0|[1-9]\d*))?"
APP_VERSION = re.compile(r"(?m)^(  'version'\s*=>\s*')([^']+)(',$)")
WIKI_HEADING = re.compile(r"(?m)^#{2,3} (" + VERSION + r")[ \t]*$")


def read_notes(version):
    notes = (ROOT / "release-notes" / f"{version}.md").read_text(encoding="utf-8")
    lines = notes.strip().splitlines()
    if (len(lines) < 3 or not lines[0].startswith("# ") or not lines[0][2:].strip()
            or lines[1] != "" or any(not re.fullmatch(r"- \S.*", line) for line in lines[2:])):
        raise ValueError("Release notes need a title, blank line, and one plain-text bullet per line")
    return lines[0][2:], [line[2:] for line in lines[2:]]


def php_string(value):
    return "'" + value.replace("\\", "\\\\").replace("'", "\\'") + "'"


def render_entry(version, title, bullets):
    items = "".join(
        "        . " + php_string("<li>" + html.escape(item) + "</li>") + "\n"
        for item in bullets
    )
    return (
        f"    '{version}' => array(\n"
        f"      'title' => {php_string(html.escape(title))},\n"
        "      'releaseNotes' =>\n"
        "        '<ul>'\n" + items +
        "        . '</ul>',\n"
        "    ),\n"
    )


def expected_config(source, version, title, bullets):
    before, current = source.split(START)
    entry, after = current.split(END)
    match = APP_VERSION.search(before)
    if not match:
        raise ValueError("Cannot find the app version in configStatic.php")
    old_version = match[2]
    if old_version != version:
        version_key = re.compile(r"(?<![\w.])'" + re.escape(version) + r"'\s*=>\s*array\(")
        if version_key.search(source):
            raise ValueError(f"Version {version} already exists in the historical changelog")
        before = APP_VERSION.sub(lambda part: part[1] + version + part[3], before, count=1)
        before += entry
    return before + START + render_entry(version, title, bullets) + END + after


def update_wiki(source, version, title, bullets):
    heading = "##" if version.count(".") == 1 else "###"
    section = f"{heading} {version}\n\n**{title}**\n\n"
    section += "\n".join(f"- {item}" for item in bullets)
    matches = list(WIKI_HEADING.finditer(source))
    existing = [index for index, match in enumerate(matches) if match[1] == version]
    if len(existing) > 1:
        raise ValueError(f"Wiki has multiple sections for {version}")
    if existing:
        index = existing[0]
        end = matches[index + 1].start() if index + 1 < len(matches) else len(source)
        return source[:matches[index].start()] + section + "\n\n" + source[end:]
    version_parts = tuple(map(int, version.split(".")))
    for match in matches:
        if tuple(map(int, match[1].split("."))) < version_parts:
            return source[:match.start()] + section + "\n\n" + source[match.start():]
    return source.rstrip() + "\n\n" + section + "\n" if source.strip() else section + "\n"


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("command", choices=["prepare", "check", "wiki"])
    parser.add_argument("version")
    parser.add_argument("--wiki-file", type=Path)
    args = parser.parse_args()
    if not re.fullmatch(VERSION, args.version):
        parser.error("Version must look like 9.0 or 9.0.1, without a v prefix")
    try:
        title, bullets = read_notes(args.version)
        current = CONFIG.read_text(encoding="utf-8")
        expected = expected_config(current, args.version, title, bullets)
        if args.command == "prepare":
            CONFIG.write_text(expected, encoding="utf-8")
        elif current != expected:
            parser.error(f"In-app notes or version are out of date. Run prepare {args.version} and commit the result.")
        elif args.command == "wiki":
            if args.wiki_file is None:
                parser.error("wiki requires --wiki-file")
            raw = args.wiki_file.read_bytes().decode("utf-8")
            previous = raw.replace("\r\n", "\n")
            updated = update_wiki(previous, args.version, title, bullets)
            if updated != previous:
                if "\r\n" in raw and "\n" not in raw.replace("\r\n", ""):
                    updated = updated.replace("\n", "\r\n")
                args.wiki_file.write_bytes(updated.encode("utf-8"))
    except (OSError, ValueError) as error:
        parser.error(str(error))


if __name__ == "__main__":
    main()

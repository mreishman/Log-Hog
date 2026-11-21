# Log-Hog

Log-Hog watches log files and folders from a browser. Use it to follow updates across multiple logs, filter output, and save log history on a development machine.

## Screenshots

The screenshots show three sample logs with synthetic data.

### Web access

![Log-Hog showing HTTP requests, response codes, and request times](docs/screenshots/web-access.png)

### Application

![Log-Hog showing application events and a cache latency warning](docs/screenshots/application.png)

### Background worker

![Log-Hog showing report jobs and a delivery retry](docs/screenshots/background-worker.png)

## Run with Docker

Install Docker Engine with Compose on Linux, or use Docker Desktop on Windows. If you run Docker commands from Ubuntu on Windows, enable Docker Desktop integration for that WSL distribution and confirm that `docker compose version` works in the same shell. [Docker Desktop WSL integration](https://docs.docker.com/desktop/features/wsl/)

The [Compose file](docker-compose.yml) builds Log-Hog on the official PHP 8.6.0 Apache image. From the repository directory, set `LOGHOG_LOG_DIR` to an existing host folder that contains your logs. Set it in the same shell where you run Compose.

| Where you run Compose | Example command |
| --- | --- |
| Windows PowerShell | `$env:LOGHOG_LOG_DIR = 'C:/Logs'` |
| WSL with logs on the Windows C: drive | `export LOGHOG_LOG_DIR=/mnt/c/Logs` |
| Linux | `export LOGHOG_LOG_DIR=/home/me/logs` |

Compose defaults to `/var/www/logs` on the host if the variable is unset. The container sees the mounted folder at `/var/www/logs` in all three cases.

```sh
docker compose up -d --build
```

Open [http://localhost:1337](http://localhost:1337), complete setup, and add a path such as `/var/www/logs/nginx/access.log` to the watch list. The default port mapping publishes port 1337 on all host interfaces. For access from this machine only, change the mapping to `"127.0.0.1:1337:80"`.

### Run from the Docker Desktop Images screen

Use **Images → Run** to create a standalone container. If `loghog:local` is missing from the Images list, build it from the repository directory with `docker compose build`. [Docker Desktop Images](https://docs.docker.com/desktop/use-desktop/images/#run-an-image-as-a-container)

To keep your settings and history in folders you can browse in Explorer, prepare the host folders before opening the dialog. For a new installation, run these commands in PowerShell. Use a new data directory so the example can copy the image's starter files into it.

```powershell
New-Item -ItemType Directory -Path C:/LogHogData
$seed = docker create loghog:local
docker cp "${seed}:/var/www/html/local" C:/LogHogData/local
docker cp "${seed}:/var/www/html/tmp" C:/LogHogData/history
docker rm $seed
```

For an existing installation, use your backed-up `local` and `tmp` directories instead. The `local` host folder must contain the complete profile tree and `layout.php`. An empty folder mounted there hides the image's starter files.

1. In Docker Desktop, open **Images**, find `loghog:local`, select **Run**, and expand **Optional settings**.
2. Set **Container name** to `loghog-desktop`. In **Ports**, enter `1337` as the **Host port** for `80/tcp`. Choose an unused port such as `1338` if Compose is already using `1337`.
3. Under **Volumes**, enter the host and container paths below. Use **+** to add rows. Add another row with a distinct container path for each additional log folder.

   | Host path | Container path | Purpose |
   | --- | --- | --- |
   | `C:/Logs/nginx` | `/var/www/logs/nginx` | Existing folder with web server logs |
   | `D:/Services/my-app/logs` | `/var/www/logs/my-app` | Optional second log folder |
   | `C:/LogHogData/local` | `/var/www/html/local` | Writable settings, profiles, and setup state |
   | `C:/LogHogData/history` | `/var/www/html/tmp` | Writable saved history and archives |

4. Leave **Environment variables** empty. `LOGHOG_LOG_DIR` is a Compose setting for choosing a host mount. The volume rows provide those paths in Docker Desktop.
5. Select **Run**, open `http://localhost:1337` (or the host port you chose), and add the container paths to the Log-Hog watch list. For example, add `/var/www/logs/nginx` to watch the entire mounted nginx folder.

Reuse the same host data folders when replacing the container. The Apache user (`www-data`) must be able to read the log folders and write to both data folders. The dialog shown here exposes host and container paths only. Use the Compose example below if you want Docker to enforce read-only log mounts.

### Watch multiple host folders

If your logs share a parent folder, mount that parent once using `LOGHOG_LOG_DIR`, then add its subfolders to the watch list. For logs in separate locations, replace the default log mount under `services.loghog.volumes` with one bind mount per host folder. Keep both named volume entries and their declarations at the bottom of the file.

This example uses WSL paths. For PowerShell, use paths such as `C:/Logs/nginx` and `D:/Services/my-app/logs` as the sources.

```yaml
    volumes:
      - loghog-local:/var/www/html/local
      - loghog-history:/var/www/html/tmp
      - type: bind
        source: /mnt/c/Logs/nginx
        target: /var/www/logs/nginx
        read_only: true
        bind:
          create_host_path: false
      - type: bind
        source: /mnt/d/Services/my-app/logs
        target: /var/www/logs/my-app
        read_only: true
        bind:
          create_host_path: false
```

Run `docker compose config` to check the resolved paths, then `docker compose up -d` to apply them. Add `/var/www/logs/nginx` and `/var/www/logs/my-app` in Log-Hog. Keep container paths stable when changing host paths, since the watch list stores the container paths. `create_host_path: false` makes Compose report a missing host folder at startup. [Compose volume syntax](https://docs.docker.com/reference/compose-file/services/#volumes)

The Apache user (`www-data`) needs permission to list the mounted folders and read the files. Keep mounts read-only for monitoring. To use Log-Hog's clear, trim, or delete actions, enable write access on the specific mount and grant the corresponding host filesystem permissions.

If a folder appears empty, check the paths and permissions from inside the container:

```sh
docker compose exec --user www-data loghog ls -la /var/www/logs
```

### Keep and back up settings

| Named volume | Container path | What's saved |
| --- | --- | --- |
| `loghog-local` | `/var/www/html/local` | Setup state, profiles, watch lists, settings, and custom themes |
| `loghog-history` | `/var/www/html/tmp` | Saved log history and archives |

Both volumes survive `docker compose stop`, `docker compose down`, and container recreation. Reuse the same Compose project name so Compose attaches the same volumes. `docker compose down -v` deletes the project's named volumes. [Docker volume lifecycle](https://docs.docker.com/engine/storage/volumes/#a-volumes-lifecycle)

To make a host-side backup, run these commands from the Compose project directory. Use a new backup directory for each backup. The container must still exist for `docker compose cp` to read it.

```sh
docker compose stop loghog
mkdir loghog-backup
docker compose cp loghog:/var/www/html/local ./loghog-backup/local
docker compose cp loghog:/var/www/html/tmp ./loghog-backup/tmp
docker compose start loghog
```

If you want live configuration files in a host folder you can browse in Explorer, back up the `local` volume first. Replace its mount entry with a writable bind mount of the copied `local` directory at `/var/www/html/local`. Use a directory containing the full backup, including `layout.php`, `conf/`, and `profiles/`. A bind mount hides the files already at its container destination. Verify that `www-data` can write to the mounted directory before resuming normal use. [Docker bind mounts](https://docs.docker.com/engine/storage/bind-mounts/)

### Upgrade or migrate

For upgrades with the current Compose layout, back up both volumes, check out the desired Log-Hog version, and run `docker compose up -d --build` from the same Compose project. Log-Hog applies configuration, layout, and theme migrations as needed. To roll back, rebuild the previous version and restore the corresponding data backup if migrations changed it.

For older installs, copy `local/` and `tmp/` before replacing the old container. The legacy Dockerfile stored them under `/srv/app`. Legacy Compose bind-mounted the checkout at `/var/www/html`, so its data may already be in your checkout. Transfer the saved contents into the new volumes and make them writable by `www-data`. Recreate the original container-side log paths or update the watch list after migration.

## Manual install and upgrade

Deploy Log-Hog to an Apache document root running PHP 8.6. Give the web server write access to `local/`, `session/`, and `tmp/`, and read access to the logs you want to watch. Adapt the directory paths in the bundled [Apache configuration](Docker/apache2/loghog.conf) to protect configuration, sessions, and saved history from direct HTTP access.

To upgrade, deploy a clean copy of the chosen version and transfer your `local/` and `tmp/` data. For a legacy 1.x install, back up its `config.php` and migrate through a compatible intermediate release first.

## Included projects

- [Visibility.js](https://github.com/ai/visibilityjs)

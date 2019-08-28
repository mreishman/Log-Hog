# Log-Hog

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/33c02c41a5d348559469717895379db1)](https://www.codacy.com/app/matthew.reishman/Log-Hog?utm_source=github.com&utm_medium=referral&utm_content=mreishman/Log-Hog&utm_campaign=badger)

A simple log monitoring tool that is intended for use on dev boxes.

![Index Screenshot](https://raw.githubusercontent.com/mreishman/Log-Hog/master/core/img/index.png)

If you need Log Hog to watch Apache's logs, see this: https://stackoverflow.com/questions/9568118/apache-access-log-automatically-set-permissions

# Install

## Manual

Copy the main folder to the main directory
i.e. /html/Log-Hog/

## Docker
In the base directory of Log-Hog:

```
chown -R www-data:www-data .
docker build -t loghog:latest .
docker run -td -p 1337:80 --name loghog loghog
```

Add volumes for logs you want to monitor. I.E.
```
docker run -td -p 1337:80 --name loghog  -v /var/www/:/var/www -v /var/log/nginx/:/var/log/nginx loghog
```

The url for Log-Hog is set to lan.loghog.com. You will need to edit your hosts file to point the ip address of the host machine to this url.
I.E.

Edit the file:
Ubuntu / Mac: `/etc/hosts`
PC: edit `c:\windows\system32\drivers\etc\hosts`
and add  `127.0.0.1   lan.loghog.com` (where the IP is 127.0.0.1 if it's on your local computer, another ip address if it's not)

Docker version is currently build using php7.0 and apache to match my dev environment. This will be updated later to a newer version of php when I can test Log-Hog with it.

# Upgrade

## Required Stuff:

- ZipArchive

## 1.0 - 2.0

1. Backup the current config.php
2. Download new version of Log-Hog
3. Move backup of old config.php to local/default/conf

## 2.0 - 4.0

1. Go to settings (gear icon) and then click update.
2. This will download the latested version from github and copy over only the changed files / new vars.


## 2.3.5+

1. Because of a change in how upgrade scripts work, cloning the repo and doing a git pull will correctly update the config file. (But you can also upgrade through the update page)


## 4.0+

1. Go to main menu (hamburger icon top left)
2. Click update in left sidebar then either check for update or install


## Includes files from the following project:

https://github.com/ai/visibilityjs
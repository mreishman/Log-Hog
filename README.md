# Log-Hog

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/33c02c41a5d348559469717895379db1)](https://www.codacy.com/app/matthew.reishman/Log-Hog?utm_source=github.com&utm_medium=referral&utm_content=mreishman/Log-Hog&utm_campaign=badger)

A simple log monitoring tool that is intended for use on dev boxes.

If you need Log Hog to watch Apache's logs, see this: https://stackoverflow.com/questions/9568118/apache-access-log-automatically-set-permissions

# Install

Copy the main folder to the main directory
i.e. /html/Log-Hog/

# Upgrade

## Required Stuff:

- ZipArchive

## From Pre Version 2.0

1. Backup the current config.php
2. Download new version of Log-Hog
3. Move backup of old config.php to local/default/conf

## From Version 2.0+

1. Go to settings (gear icon) and then click update.
2. This will download the latested version from github and copy over only the changed files / new vars.


## Version 2.3.5+

1. Because of a change in how upgrade scripts work, cloning the repo and doing a git pull will correctly update the config file. (But you can also upgrade through gear icon)

## 4.0+

1. Go to main menu (hamburger icon top left)
2. Click update in left sidebar then either check for update or install


## Includes files from the following project:

https://github.com/ai/visibilityjs  
https://loading.io/progress/

# Log-Hog

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/33c02c41a5d348559469717895379db1)](https://www.codacy.com/app/matthew.reishman/Log-Hog?utm_source=github.com&utm_medium=referral&utm_content=mreishman/Log-Hog&utm_campaign=badger)

A simple log monitoring tool that is intended for use on dev boxes.

If you need Log Hog to watch Apache's logs, see this: https://stackoverflow.com/questions/9568118/apache-access-log-automatically-set-permissions

# Install

Copy the main folder to the main directory
i.e. /html/Log-Hog/

# Upgrade

## Pre Version 2.0

Copy all of the files, except for config.php
When upgrading, look at the config.php to compair var's 
copy missing var's from the new file into the old file

## Version 2.0

Copy all of the files, except for config.php file (located in local/default/conf/
Move the config.php file from the conf dir to the local/default/conf

## Version 2.0+

Go to settings (gear icon) and then click update.
This will download the latested version from github and copy over only the changed files / new vars.


## Includes files from the following project:

https://github.com/ai/visibilityjs  

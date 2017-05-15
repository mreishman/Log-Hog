# Log-Hog
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


## "You are currently on a beta branch" 

Usually only shown internal, but if your current version is > newest version this message will show up. Either change configstatic.php
to reflect newest version or click check for update. 

<?php

$versionCheckArray = array(
	'version'		=> '5.1.0.1',
	'versionList'		=> array(
		'2.0.1'	        => array(
			'branchName'	=> '2.0.1Update',
			'releaseNotes'	=> '<ul><li>Bug Fixes<ul><li>Adds check for header redirect</li><li>Fixed Unpause - on focus (if default paused) Bug</li><li>Adds remove directory / watch folder button</li></ul></li></ul>'
		),
		'2.0.2'	        => array(
			'branchName'	=> '2.0.2Update',
			'releaseNotes'	=> '<ul><li>Bug Fixes<ul><li>Renamed titles for settings pages</li><li>Moved changelog info from update page to seperate php file.</li><li>File extractor now extracts files other than php, includes:<ul><li>.css</li><li>.html</li><li>.js</li><li>.png</li><li>.jpg</li><li>.jpeg</li></ul></li><li>Moved var loading part in update scripts to seperate file. Helps updating vars in future.</li></ul></li></ul>'
		),
		'2.0.3'		=> array(
			'branchName'	=> '2.0.3Update',
			'releaseNotes' 	=> '<ul><li>Fixed issues with saving removed files</li><li>Fixed bug where remove file button was not showing up for new files</li><li>Update page only shows relevant release notes under the new releas notes tab</li><li>Added file / folder not found warning in settings page</li><li>Added checks for vars which might not have been there, reducing notices in log files generated when on update.php</li><li>Fixed bug with remove file/folder button</li><li>Added redirect pages for /settings and /update to correct pages.</li><li>Started adding custom error screens for some of the known errors</li></ul>'
		),
		'2.1'		=> array(
			'branchName'	=> '2.1Update',
			'releaseNotes' 	=> '<ul><li>Features<ul><li>Added Exp. Features Tab</li><li>Added Clear log button<ul><li>Clear logs button in menu</li><li>Setting to change button in menu to all or single log</li><li>Button at bottom row for single log clear</li></ul></li><li>Added link to gitStatus (if installed)</li><li>Added popup warnings for removing file/folders, save actions and blank folders.</li></ul></li><li>Bug Fixes<ul><li>Added text descriptions to some settings in main.php</li><li>Added stopFlashTitle to unpause on focus</li><li>Adding new file/folder does not overwrite previously non saved folders</li><li>Improved look of buttons for watch list</li><li>Added max height to main log menu</li></ul></li></ul>'
		),
		'2.2'		=> array(
			'branchName'	=> '2.2Update',
			'releaseNotes'	=> '<ul><li>Features<ul><li>Ability to trim log files by default to either set num of lines or file size</li><li>Groups folders by colors<ul><li>Ability to pick color profile for folders</li><li>Buttons match first folder color</li></ul></li><li>Added messages for empty files / unknown error</li><li>Adds ability to hide empty logs</li><li>Adds file permissions to file view</li><li>Ability to switch between ms and s for poll rate</li><li>Added delete log button</li><li>Added popup warnings for removing file/folders, save actions and blank folders.</li></ul></li><li>Bug Fixes<ul><li>Checks for updates every 7 days by default insted of each day</li><li>Adds ability to change github url</li></ul></li></ul>'
		),
		'2.2.1'		=> array(
			'branchName'	=> '2.2.1Update',
			'releaseNotes'	=> '<ul><li>Features<ul><li>Added D-Bug info (turned off by default)</li><li>Changed check for update form normal to ajax. </li><li>Added right click menu to some icons<ul><li>Settings Icon</li><li>Clear Log(s) Icon</li><li>Update Notice Icon</li></ul></li></ul></li><li>Bug Fixes<ul><li>Slight adjustments to poll logic. Should be faster in some situations.</li><li>Small code changes to menu on settings pages</li><li>Updated error screen with correct files</li><li>Fixed bug with the verify write status action</li></ul></li></ul>'
		),
		'2.3'		=> array(
			'branchName'	=> '2.3Update',
			'releaseNotes'	=> '<ul><li>Features<ul><li>Process Monitoring tab added. Monitors: <ul><li>CPU usage</li><li>Ram / swap usage</li><li>Disk usage / IO</li><li>PHP User time used / system time used</li><li>Network Interface receive / transmit</li><li>Shows list of processes</li></ul></li><li>Added setting to disable right click menu. </li></ul></li><li>Bug Fixes<ul><li>Fixes bug where the delete log button did not remove the log from the top bar. </li><li>Fixes bug where log files could not be deleted or cleared when seeing poll information. </li><li>Fixes bug where update changelog would sometimes give error depending on version numbering. </li></ul></li></ul>'
		),
		'2.3.1'		=> array(
			'branchName'	=> '2.3.1Update',
			'releaseNotes'	=> '<ul><li>Features<ul><li>New poll logic added (~ 25% improvement)</li></ul></li><li>Bug Fixes<ul><li>Fixed issue with ram not showing correct information on some servers</li><li>Fixed issue where clear / delete buttons didn not work properly. </li></ul></li></ul>'
		),
		'2.3.2'		=> array(
			'branchName'	=> '2.3.2Update',
			'releaseNotes'	=> '<ul><li>Features<ul><li>Added setup to first launch</li><li>Added version check to poll logic, popup if version changed</li></ul></li><li>Bug Fixes<ul><li>Fixed compatability issues with php 7</li><li>Updated poll logic again, should be slightly faster.</li><li>Added buffer to trim logic, less trim calls made</li></ul></li></ul>'
		),
		'2.3.3'		=> array(
			'branchName'	=> '2.3.3Update',
			'releaseNotes'	=> '<ul><li>Features<ul><li>Downloading Monitor is now part of the setup process</li><li>Added reset changes buttons for some settings pages</li><li>Added ability to reset all (non monitor) vars back to default</li></ul></li><li>Bug Fixes<ul><li>Fixed some bugs wih setup process</li><li>Fixed some bugs with the start of update logic</li></ul></li></ul>'
		),
		'2.3.4'		=> array(
			'branchName'	=> '2.3.4Update',
			'releaseNotes'	=> '<ul><li>Features<ul><li>Added a setting to hide / show bottom bar on index page.</li><li>Added sub menu for main settings page.</li><li>Added ability to customise location of status / monitor</li><li>Added dev setting to change local version number</li><li>Added ability to download / remove monitor after setup process</li><li>Added ability to restore to previous version of Log-Hog</li></ul></li></ul>'
		),
		'2.3.5'		=> array(
			'branchName'	=> '2.3.5Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Reduced poll times by an average of 20ms</li><li>Added advanced poll options</li><li>Updated updater, now with more ajax!</li></ul></li><li>Bug Fixes<ul><li>Saving now does not refresh page, also adds check if save worked</li><li>Checking for update checks if update information was saved</li><li>fixed style issues with process table in monitor</li><li>Fixed bug with poll logic if first poll failed</li><li>Fixed bug with pause icon when loading with pause by default</li><li>Fixed bug with pause on focus not always following settings if disabled</li><li>Fixed bug with some forms not resetting correctly</li><li>Fixed bug with some forms giving false positives for changes in form data</li><li>Fixed issues with ajax update check on index page not waiting for file to refresh contents</li><li>Fixed issues with ajax update check on update page not refreshing install button</li><li>Fixed issues with ajax update check on update page sometimes not display proper changelog</li><li>Fixed bug where deleting file then adding file would result in a save error</li></ul></li></ul>"
		),
		'2.3.5.1'		=> array(
			'branchName'	=> '2.3.5.1Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes</li></ul>"
		),
		'2.3.6'		=> array(
			'branchName'	=> '2.3.6Update',
			'releaseNotes'	=> "<ul><li>Added option to switch to beta branch for earlier testing of new features!</li></ul>"
		),
		'3.0'		=> array(
			'branchName'	=> '3.0Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Loading bar on first load</li><li>Themes!</li><ul><li>More custom style options</li><li>Three new themes!</li></ul><li>Watchlist look improved for settings page</li><li>Added option for background refresh rate (if not using pause on not focus)</li><li>Added option to disable / reset update notifications</li></ul></li><li>Bug Fixes<ul><li>Clicking refresh forces refresh of all information</li><li>Devtab bugfixes</li><li>Tabs on sub-menus are now highlighted</li><li>Fixed issue with resizing the window while in the settings pages</li><li>Added reset changes to more pages when editing vars</li><li>Fixed issue with custom popup settings options not correctly displaying on first switch</li><li>Versioned css / js files (most of them anyway)</li></ul></li></ul>"
		),
		'3.0.1'		=> array(
			'branchName'	=> '3.0.1Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bug with settings for top</li><li>Fixed popup bug with updater</li><li>Fixed rightclick menu bug</li><li>Fixed restore popup</li><li>Fixed some bugs with settings pages</li></ul></li></ul>"
		),
		'3.0.2'		=> array(
			'branchName'	=> '3.0.2Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bug with updating css / js</li><li>Added feedback popup for errors for beta branch users</li><li>Fixed some image issues</li></ul></li></ul>"
		),
		'3.0.3'		=> array(
			'branchName'	=> '3.0.3Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed issue with update in progress page</li><li>Fixed bug with download monitor because of version 1.1</li><li>Fixed some style issues with right click menu</li></ul></li></ul>"
		),
		'3.0.4'		=> array(
			'branchName'	=> '3.0.4Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Seperated options for main font color and log font color</li></ul></li><li>Bug Fixes<ul><li>Fixed issues with setup process</li><li>Fixed some css issues</li><li>Small text changes to update page</li></ul></li></ul>"
		),
		'3.1'		=> array(
			'branchName'	=> '3.1Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Search addon added!<ul><li>Use search to visually grep your current repo</li><li>Can be downloaded from the admin page</li></ul></li><li>Added setup access from advanced page</li><li>More theme style options</li></ul></li><li>Bug Fixes<ul><li>Added refresh to more saves that change styles</li><li>Fixed some issues with monitor download from setup</li><li>Added monitor remove to setup (if installed)</li></ul></li></ul>"
		),
		'3.1.1'		=> array(
			'branchName'	=> '3.1.1Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed updater in search addon</li><li>Poll logic changes</li><li>First load logic changes</li></ul></li></ul>"
		),
		'3.1.2'		=> array(
			'branchName'	=> '3.1.2Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Changed redirects for upgrade files.</li></ul></li></ul>"
		),
		'3.2'		=> array(
			'branchName'	=> '3.2Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Addons page (page for addons)</li><li>Added new font options</li><li>Selenium monitor addon</li><li>Config restore options</li></ul></li><li>Bug Fixes<ul><li>Fixed delay when resetting update notification</li><li>Improved images for areo theme</li></ul></li></ul>"
		),
		'3.2.1'		=> array(
			'branchName'	=> '3.2.1Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed possible issue with update validation at end of update</li></ul></li></ul>"
		),
		'3.3'		=> array(
			'branchName'	=> '3.3Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Added notification count for tabs</li><li>Added no logs to display message when filtered / or no logs are visible</li><li>Added on hover to tabs to show last line</li><li>Added clear all button for notifications</li><li>Added new ocean theme!</li><li>View some files from Log-Hog (dev tools)</li></ul></li><li>Bug Fixes<ul><li>Cleaned up / grouped settings.</li></ul></li></ul>"
		),
		'3.3.1'		=> array(
			'branchName'	=> '3.3Update',
			'releaseNotes'	=> "<ul><li>Re-Install of 3.3</li></ul>"
		),
		'3.4'		=> array(
			'branchName'	=> '3.4Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Added content search for logs (ability to toggle between title and content for searching)</li><li>Added option to disable scroll to bottom on update</li><li>Redesigned bottom bar (now sidebar)</li><li>Added more options on how to restore defaults (all, just watchlist...)</li><li>Save custom themes</li></ul></li><li>Bug Fixes<ul><li>Updated right click menu for settings icon for new contents</li><li>Fixed bug with switching dev tools on / off.</li><li>Chaged save logic to only save changed vars</li></ul></li></ul>"
		),
		'3.5'		=> array(
			'branchName'	=> '3.5Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Added option to change highlight color (of content filter)</li><li>Added option to change hover content for log titles (last line or full path)</li><li>Added option for php or shell (php by default)</li><li>Highlights new lines of logs (for 1 sec) (with options to change color)</li><li>Added right click menus for log titles and pause icon<ul><li>Adds option to hide log until refresh of page</li><li>Clear / delete log by rightclick</li><li>Copy file name / file path on rightclick</li><li>Toggle auto pause option with rightclick on pause icon</li></ul></li><li>Added file size to loadbar on first load</li><li>Added option to not scroll on update if already scrolled up in log</li><li>Added brightness slider to themes settings page</li><li>Added new theme! (Steampunk)</li></ul></li><li>Bug Fixes<ul><li>Fixed issue with right click clicking not registering sometimes. </li><li>Fixed bug with counter for log showing undefined if log is new</li><li>Fixed some bugs with expermential feature log display</li><li>Fixed bug with pause on unfocus still pausing</li><li>Fixed rare poll js bug</li><li>Added loading icon between switch of logs (although, still to fast to show up)</li><li>Fixed bug where clear notifications would not fully clear notification counter</li><li>Fixed some style issues<ul><li>right click menu / info popup background and font for some themes</li><li>Fixed small style bug with select font</li><li>Fixed issue with load bar for default theme not reflecting correct color</li></ul></li><li>Loading theme preview loads smoother</li></ul></li></ul>"
		),
		'3.6'		=> array(
			'branchName'	=> '3.6Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Added quick setting change for filter content (changes settings tmp for current window)</li><li>Added addon page to setup</li><li>Notice is shown for connectivity issues on index</li><li>Option to change position of log tabs (top, bottom, left, right)</li><li>New Theme! (Terminal)</li><li>Added internal notifications</li></ul></li><li>Bug Fixes<ul><li>Addon page does not redirect when installing or removing addons</li><li>More fixes for expermential feature log display</li><li>Changed verification counter to check for 2 success verifications in a row</li></ul></li></ul>"
		),
		'3.6.2'		=> array(
			'branchName'	=> '3.6.2Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed issue with setup</li></ul></li></ul>"
		),
		'4.0'		=> array(
			'branchName'	=> '4.0Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>New Log Format!<ul><li>Changed format, allowing for more custom options for each entry in watchlist</li><li>Added dropdown option for recursive log finding in a folder</li><li>Option to delete logs in a folder after x days since last modification</li><li>Better visibility of log read/write status</li><li>Added option to ignore some files within folders</li><li>Option to split files in a folder into individual files</li><li>Option to exclude files within a folder from trim logic</li><li>Added option to add custom names for logs</li><li>Added option to change the order of logs in watchlist</li></ul></li><li>New main menu system!<ul><li>New flyout system allows for viewing about pages without reload</li><li>Added names to other apps instead of just icon</li><li>Cleans up visible menu icons on homepage</li></ul></li><li>Grouped Groups!<ul><li>Group logs / folders into groups</li><li>Show / hide groups of logs from select in header</li></ul></li><li>Other<ul><li>Custom options for how log titles display (no extension, last folder in path, etc)</li></ul></li></ul></li><li>Bug Fixes<ul><li>Removes log from display if file does not exist</li><li>Removed save verify from 2nd layer nav (same page nav)</li><li>Fixed small bug with update check.</li><li>Fixed bug with notification dot positioning when height changed</li><li>Fixed bug with redirect of update page after update</li><li>Fixed bug with notification not cleared when log is removed</li></ul></li></ul>"
		),
		'4.1.1'		=> array(
			'branchName'	=> '4.1.1Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed some update issues with new updater</li></ul></li></ul>"
		),
		'4.2'		=> array(
			'branchName'	=> '4.2Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Changed how watchlist loads, more visual</li><li>Added file format filter to file popup</li><li>Added option to disable auto check for update on error page</li><li>Moved addons to iframe (option to disable in settings)</li><li>Added archive to watchlist</li><li>Added view options for logs in watchlist (condensed / expanded)</li><li>Added option for filters on logs</li></ul></li><li>Bug Fixes<ul><li>Fixed bug with logs being added after load (new logs)</li><li>Added option for hiding / autoCheckUpdate php file open errors in log (off by default)</li><li>Now shows correct file info when splitting files from folder in watchlist</li><li>Fixed issue with file folder dropdown showign up on initial scroll (not that noticable though)</li><li>Fixed issue with notification count not displaying above full screen menu</li><li>Fixed bug where height of notification list could be off screen, addex max height of 300px</li><li>Fixed bug with popup not being over menu on index page</li><li>Properly shows no logs available when initial load returns empty array</li></ul></li></ul>"
		),
		'4.2.1'		=> array(
			'branchName'	=> '4.2.1Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed issue with dropdown file typing in watchlist</li><li>Fixed bug with formatting on some logs</li><li>Fixed bug with popup settings not loadign correctly with new js loader</li><li>Fixed issue with setup and watchlist</li><li>Fixed possible issue with clearning logs?</li></ul></li></ul>"
		),
		'4.2.2'		=> array(
			'branchName'	=> '4.2.2Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Added link to watchlist to main menu (in prep for 5.0 release)</li></ul></li><li>Bug Fixes<ul><li>Possibly fixed issue with updater not redirecting correctly?</li><li>Possibly fixed issue with updater not setting percent bar correctly if more than one version in update</li></ul></li></ul>"
		),
		'4.2.3'		=> array(
			'branchName'	=> '4.2.3Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed issue with popup and menu on home page</li><li>Fixed menu style issues with firefox</li><li>Fixed bug with reszie menu bar on delete log</li><li>Fixed bug with viewing individual whats new / changelog / about page.</li><li>Fixed bugs with nested new lines in lines for logs (should fix some display issues)</li><li>Fixed bug with spinner not showing up between switch of logs (need to fix time though)</li></ul></li></ul>"
		),
		'4.2.4'		=> array(
			'branchName'	=> '4.2.4Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bug in setup (also in 4.1.1.1)</li><li>Fixed issue with some selectors in settings not showing sub content correctly on toggle</li></ul></li></ul>"
		),
		'4.2.5'		=> array(
			'branchName'	=> '4.2.5Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed issue with clear log not hiding after clear</li></ul></li></ul>"
		),
		'4.2.6'		=> array(
			'branchName'	=> '4.2.6Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed issue with setup watchlist</li></ul></li></ul>"
		),
		'4.2.7'		=> array(
			'branchName'	=> '4.2.7Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bugs with file verification in clear log and delete log functions</li><li>Fixed bug with clear all logs not working correctly</li></ul></li></ul>"
		),
		'4.2.8'		=> array(
			'branchName'	=> '4.2.8Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bugs with file verification in clear log and delete log functions</li></ul></li></ul>"
		),
		'4.2.8.1'		=> array(
			'branchName'	=> '4.2.8.1Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bugs with file verification in clear log and delete log functions</li></ul></li></ul>"
		),
		'5.0'		=> array(
			'branchName'	=> '5.0Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Multi-Log<ul><li>View 1 log or up to 9 logs in different arrangements  (i.e. 1x1, 2x1, 2x2, etc)</li><li>Switch between views quickly with multi-log button in menu</li></ul></li><li>Log Layouts<ul><li>Added option to select what log is loaded first</li><li>With multi-log enabled, have up to 3 different layout versions per grid layout (1x1 Layout A, 1x1 Layout B, etc.)</li><li>Switch between layouts in top nav by clicking on MultiLog then Log Layout A B or C.</li></ul></li><li>Added watchlist to main menu (Update watchlist without refresh)</li><li>Reduced initial load times by reducing the transfer ammount on initial load from 697KB to 318KB (with default theme, including 83KB for poll log requests)</li><li>Added option to pin windows when using filter/search</li><li>Added Experimental Log Formatting (in advanced tab)</li><li>Added log line padding options (default 2px, min 0px, max 20px)</li><li>Added option to set fadeout start time for log highlight</li></ul></li><li>Bug Fixes<ul><li>Fixed issue with updating logs sometimes requiring a refresh of index</li><li>Fixed issue with adding folders that are unreadable not generating proper error message</li><li>Fixed bug with search while using groups</li><li>Fixed bug with pause on page load interfering with the pause on unfocus logic.</li><li>Fixed possible bug with remove notification</li><li>Fixed bug with counter if line count changed for log before refresh (sorta)</li></ul></li></ul>"
		),
		'5.0.1'		=> array(
			'branchName'	=> '5.0.1Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bug with main font color for logs not being applied correctly</li><li>Fixed bug with highlight font color for logs not being applied correctly</li><li>Fixed bug with multi log settings still showing up if disabled</li></ul></li></ul>"
		),
		'5.0.2'		=> array(
			'branchName'	=> '5.0.2Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bug with poll not working correctly if no logs on initial load.</li><li>Fixed bug with php file trim breaking poll logic by throwing errors on files that are too big to open.</li><li>Fixed bug with right click on log in menu not respecting right click menu enabled option</li><li>Fixed bug with setup stuff</li></ul></li></ul>"
		),
		'5.0.3'		=> array(
			'branchName'	=> '5.0.3Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bug with temporarily hiding logs showing up when toggling groups</li><li>Fixed possible bug with restore CSS not being versioned</li><li>Fixed bug with groups not updating correctly when changing groups in watchlist (without reload)</li><li>Fixed bug with log names that include groups not updating correctly (without reload)</li><li>Fixed bug with group selector not updating correctly when removing logs (without reload)</li><li>Fixed bug with group selector not updating correctly temporary hiding logs</li><li>Fixed font style issue with some themes and error / no log messages</li></ul></li></ul>"
		),
		'5.0.4'		=> array(
			'branchName'	=> '5.0.4Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed flickering of reset button on scroll in settings pages</li><li>Changed load of watchlist buttons until after load</li><li>Fixed bug with watchlist reset and adding after reset</li><li>Fixed small style bug on theme page</li><li>Fixed styling bug with upgrade config and upgrade layout pages</li><li>Shows popup message if an error occurs when trying to clear a log or delete a log</li><li>Fixed display bug with notification count icon with poll notice banner</li><li>Fixed bug with ajax request and closing file list popup too quickly</li><li>Fixed bug with ajax request and update sub files display of folder</li><li>Fixed bug with reset watchlist and default display of expanded / condensed</li><li>Fixed bug with archive / delete log not reflecting until refresh of page</li></ul></li></ul>"
		),
		'5.0.5'		=> array(
			'branchName'	=> '5.0.5Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed bug with poll update broken in 5.0.4 update</li></ul></li></ul>"
		),
		'5.0.6'		=> array(
			'branchName'	=> '5.0.6Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Bug fix with poll logic and content filter</li><li>Possibly decreased save times by reducing the number of failed save checks</li><li>Bugfix for check for update with addons</li><li>Fixed bug with update versions where version is greater than 10</li><li>Style fix for sub files in folders on watchlist</li><li>Fixed bug with possible redirect loop on upgrade theme</li></ul></li></ul>"
		),
		'5.0.7'		=> array(
			'branchName'	=> '5.0.7Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>Fixed styling issue on logs with spacing</li><li>Fixed bug with restore popup</li><li>Fixed bug with clicking off of watchlist before load ends</li><li>Fixed bug with not checking for save before toggle menu</li><li>Fixed restore downloading wrong branch</li><li>Fixed style issue with watchlist dropdown</li><li>Fixed bug with not being able to select file type selector in watchlist dropdown</li><li>Fixed bug with sub file lists causing errors when recursive is enabled</li></ul></li></ul>"
		),
		'5.1'		=> array(
			'branchName'	=> '5.1Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Added filter icon for a grouped logs drop down in header</li><li>Added option to slow down the poll rate or pause the poll on index when viewing full screen menu</li><li>Added style option for log side bar display</li><li>Moved addons page to full screen menu</li><li>Added more noticeable notification for off screen logs</li><li>Added option to change max height of log tabs area on index</li><li>Added option in watchlist to add new file or folder from a previous file or folder base folder</li><li>Added link to themes in full screen menu</li><li>Added right click clear all notifications on notification button</li><li>When clearing or deleting logs, a temporary version is saved (of the last n lines) in a log-hog folder. These are view-able from the history icon.</li><li>Added new space theme</li><li>Add more than one group to a folder in watchlist, just add spaces!</li></ul></li></ul>"
		),
		'5.1.0.1'		=> array(
			'branchName'	=> '5.1.0.1Update',
			'releaseNotes'	=> "<ul><li>Bug Fixes<ul><li>See Release Notes For 5.0.7</li></ul></li></ul>"
		),
	)
);


?>

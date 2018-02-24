<?php

$versionCheckArray = array(
	'version'		=> '3.4',
	'versionList'		=> array(
		'2.0.1'	        => array(
			'branchName'	=> '2.0.1Update',
			'releaseNotes'	=> '<ul><li>Bug Fixes<ul><li>Adds check for header redirect</li><li>Fixed Unpause - on focus (if default paused) Bug</li><li>Adds remove directory / watch folder button</li></ul></li></ul>'
		),
		'2.0.2'	        => array(
			'branchName'	=> '2.0.2Update',
			'releaseNotes'	=> '<ul><li>Bug Fixes<ul><li>Renamed titles for settings pages</li><li>Moved changelog info from update page to separate php file.</li><li>File extractor now extracts files other than php, includes:<ul><li>.css</li><li>.html</li><li>.js</li><li>.png</li><li>.jpg</li><li>.jpeg</li></ul></li><li>Moved var loading part in update scripts to separate file. Helps to update vars in future.</li></ul></li></ul>'
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
		'3.4'		=> array(
			'branchName'	=> '3.4Update',
			'releaseNotes'	=> "<ul><li>Features<ul><li>Added content search for logs (ability to toggle between title and content for searching)</li><li>Added option to disable scroll to bottom on update</li><li>Redesigned bottom bar (now sidebar)</li><li>Added more options on how to restore defaults (all, just watchlist...)</li><li>Save custom themes</li></ul></li><li>Bug Fixes<ul><li>Updated right click menu for settings icon for new contents</li><li>Fixed bug with switching dev tools on / off.</li><li>Chaged save logic to only save changed vars</li></ul></li></ul>"
		),
	)
);
?>

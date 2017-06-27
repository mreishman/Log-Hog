<?php

$versionCheckArray = array(
	'version'		=> '2.3.1',
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
		)
	)
);
?>

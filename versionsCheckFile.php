<?php

$versionCheckArray = array(
	'version'		=> '2.2',
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
		)
	)
);
?>

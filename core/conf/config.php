<?php

$defaultConfig = array(
	'sliceSize'		=> 500,
	'pollingRate'	=> 500,
	'pausePoll'		=> 'false',
	'pauseOnNotFocus' => 'true',
	'autoCheckUpdate' => 'true',
	'autoCheckDaysUpdate'	=>	'7',
	'developmentTabEnabled' => 'false',
	'enableDevBranchDownload' => 'false',
	'enableSystemPrefShellOrPhp'	=> 'false',
	'enableHtopLink'	=> 'false',
	'expSettingsAvail'	=> 'true',
	'truncateLogButtonAll'	=> 'true',
	'popupSettings'	=>	'all',
	'flashTitleUpdateLog'	=> 'false',
	'pollingRateType'	=> 'Milliseconds',
	'logTrimOn'	=> 'true',
	'logSizeLimit'	=>	2000,
	'logTrimMacBSD'	=> 'false',
	'baseUrlUpdate'	=> 'https://github.com/mreishman/Log-Hog/archive/',
	'logTrimType'	=>	'lines',
	'TrimSize'	=> 'K',
	'popupSettingsCustom'	=> array(
		'saveSettings'	=>	'true',
		'blankFolder'	=>	'true',
		'deleteLog'	=>	'true',
		'removeFolder'	=> 	'true'
		),
	'folderColorArrays'	=> array(
		'theme-default-1'	=> array('#2A912A',"#32CD32","#9ACD32","#556B2F","#6B8E23"),
		),
	'watchList'		=> array(
		'/var/www/html/var/log/system.log'	        => '',
		'/var/log/hhvm/error.log'	=> '',
		'/var/log/apache2'			=> '\.log$'
	)
);
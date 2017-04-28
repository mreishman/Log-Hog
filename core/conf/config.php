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
	'popupSettingsCustom'	=> array(
		'saveSettings'	=>	'true',
		'blankFolder'	=>	'true',
		'deleteLog'	=>	'true',
		'removeFolder'	=> 	'true'
		),
	'watchList'		=> array(
		'/var/www/html/var/log/system.log'	        => '',
		'/var/log/hhvm/error.log'	=> '',
		'/var/log/apache2'			=> '\.log$'
	)
);
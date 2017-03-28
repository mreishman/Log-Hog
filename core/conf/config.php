<?php

$defaultConfig = array(
	'sliceSize'		=> 500,
	'pollingRate'	=> 500,
	'pausePoll'		=> 'false',
	'pauseOnNotFocus' => 'true',
	'autoCheckUpdate' => 'true',
	'developmentTabEnabled' => 'false',
	'enableDevBranchDownload' => 'false',
	'enableSystemPrefShellOrPhp'	=> 'false',
	'expSettingsAvail'	=> 'true',
	'watchList'		=> array(
		'/var/www/html/var/log/system.log'	        => '',
		'/var/log/hhvm/error.log'	=> '',
		'/var/log/apache2'			=> '\.log$'
	)
);
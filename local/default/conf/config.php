
	<?php
		$config = array(
			'sliceSize' => 500,
			'pollingRate' => 500,
			'pausePoll' => 'false',
			'pauseOnNotFocus' => 'true',
			'autoCheckUpdate' => 'true',
			'developmentTabEnabled' => 'false',
			'enableDevBranchDownload' => 'false',
			'enableSystemPrefShellOrPhp'   => 'false',
			'expSettingsAvail'	=> 'true',
			'flashTitleUpdateLog'	=> 'false',
			'popupSettings'	=>	'all',
			'popupSettingsCustom'	=> array(
			
		'saveSettings'	=>	'true',
		'blankFolder'	=>	'true',
		'removeFolder'	=> 	'true'
		),
			'watchList' => array(
			'/var/www/html/var/log/system.log' => '','/var/log/hhvm/error.log' => '','/var/log/apache2' => '\.log$','/var/www/html/var/log/exception.log' => '')
		);
	?>

	<?php
		$config = array(
			'sliceSize' => 500,
			'pollingRate' => 500,
			'pausePoll' => 'false',
			'pauseOnNotFocus' => 'true',
			'autoCheckUpdate' => 'true',
			'autoCheckDaysUpdate'	=>	'7',
			'developmentTabEnabled' => 'true',
			'enableDevBranchDownload' => 'false',
			'enableSystemPrefShellOrPhp'   => 'true',
			'enableHtopLink'	=> 'false',
			'expSettingsAvail'	=> 'true',
			'flashTitleUpdateLog'	=> 'false',
			'truncateLogButtonAll' => 'true',
			'popupSettings'	=>	'all',
			'pollingRateType'	=> 'Milliseconds',
			'logTrimOn'	=> 'true',
			'logSizeLimit'	=>	2000,
			'logTrimMacBSD'	=> 'false',
			'baseUrlUpdate'	=> 'https://github.com/mreishman/Log-Hog/archive/',
			'logTrimType'	=>	'lines',
			'TrimSize'	=> 'K',
			'hideEmptyLog'	=>	'true',
			'groupByType'	=> 'folder',
			'currentFolderColorTheme'	=> 'theme-default-4',
			'groupByColorEnabled'	=> 'true',
			'folderColorArrays'	=> 	array(
			'theme-default-1'	=>	array('#2A912A','#32CD32','#9ACD32','#556B2F','#6B8E23'),'theme-default-2'	=>	array('#6B8E23','#556B2F','#2E8B57','#3CB371','#8FBC8F'),'theme-default-3'	=>	array('#228B22','#008000','#006400'),'theme-default-4'	=>	array('#2E8B57','#20B2AA','#3CB371','#8FBC8F'),'theme-default-5'	=>	array('#9ACD32','#32CD32','#2A912A','#2E8B57','#9ACD32'),),
			'popupSettingsCustom'	=> array(
			
		'saveSettings'	=>	'true',
		'blankFolder'	=>	'true',
		'deleteLog'	=>	'true',
		'removeFolder'	=> 	'true'
		),
			'watchList' => array(
			'/var/www/html/var/log' => '.log$','/var/log/hhvm/error.log' => '','/var/log/apache2' => '.log$','/var/www/html/Log-Hog/logs' => '.log$','/tmp' => '.log$')
		);
	?>
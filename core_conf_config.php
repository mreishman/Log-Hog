<?php

$defaultConfig = array(
	'configVersion'	=> 1,
	'layoutVersion'	=> 1,
	'cssVersion'	=> 1,
	'themeVersion'	=> 3,
	'sendCrashInfoJS'	=> 'true',
	'sendCrashInfoPHP'	=> 'true',
	'themesEnabled'		=> 'true',
	'updateNotificationEnabled'	=> 'true',
	'currentTheme'		=> 'Default',
	'sliceSize'		=> 500,
	'pollingRate'	=> 500,
	'buffer'		=> 500,
	'backgroundPollingRate'	=> 5000,
	'pollRefreshAll'	=> 120,
	'pollRefreshAllBool'	=> 'true',
	'pollForceTrue'		=> 60,
	'pollForceTrueBool'	=> 'true',
	'pausePoll'		=> 'false',
	'pauseOnNotFocus' => 'true',
	'autoCheckUpdate' => 'true',
	'autoCheckDaysUpdate'	=>	'7',
	'developmentTabEnabled' => 'false',
	'enableDevBranchDownload' => 'false',
	'enableSystemPrefShellOrPhp'	=> 'false',
	'rightClickMenuEnable'	=> 'true',
	'enableHtopLink'	=> 'false',
	'expSettingsAvail'	=> 'true',
	'truncateLog'	=> 'true',
	'popupWarnings'	=>	'all',
	'flashTitleUpdateLog'	=> 'false',
	'pollingRateType'	=> 'Milliseconds',
	'backgroundPollingRateType'	=> 'Milliseconds',
	'logTrimOn'	=> 'true',
	'logSizeLimit'	=>	2000,
	'logTrimMacBSD'	=> 'false',
	'baseUrlUpdate'	=> 'https://github.com/mreishman/Log-Hog/archive/',
	'branchSelected'	=> 'default',
	'logTrimType'	=>	'lines',
	'TrimSize'	=> 'K',
	'hideEmptyLog'	=> 'false',
	'groupByType'	=> 'folder',
	'currentFolderColorTheme'	=> 'theme-default-2',
	'groupByColorEnabled'	=> 'true',
	'enableLogging'	=> 'false',
	'dontNotifyVersion'	=> '0',
	'updateNoticeMeter'	=> 'every',
	'locationForStatus'	=> '',
	'locationForMonitor'	=> '',
	'locationForSearch'		=> '',
	'bottomBarIndexShow'	=> 'true',
	'enablePollTimeLogging'	=> 'false',
	'popupSettingsArray'	=> array(
		'saveSettings'	=>	'true',
		'blankFolder'	=>	'true',
		'deleteLog'	=>	'true',
		'removeFolder'	=> 	'true',
		'versionCheck'	=> 'true'
		),
	'folderColorArrays'	=> array(
		'theme-default-1'	=> array(
			'main' 		=> array(
				'main-1'		=> array(
					'background'	=> '#2A912A',
					'fontColor'		=> '#FFFFFF'
					),
				'main-2'		=> array(
					'background'	=> "#32CD32",
					'fontColor'		=> "#FFFFFF"
					),
				'main-3'		=> array(
					'background'	=> "#9ACD32",
					'fontColor'		=> '#FFFFFF'
					),
				'main-4'		=> array(
					'background'	=> "#556B2F",
					'fontColor'		=> "#FFFFFF"
					),
				'main-5'		=> array(
					'background'	=> "#6B8E23",
					'fontColor'		=> "#FFFFFF"
					)
				),
			'highlight' => array(
				'highlight-1'	=> array(
					'background'	=> '#FFFFFF',
					'fontColor'		=> '#000000'
					)
				),
			'active'	=> array(
				'active-1'		=> array(
					'background'	=> '#912A2C',
					'fontColor'		=> '#000000'
					)
				),
			'highlightActive'	=> array(
				'highlightActive-1'	=> array(
					'background'	=> '#FFDDFF',
					'fontColor'		=> '#000000'
					)
				)
			),
		'theme-default-2'	=> array(
			'main' 		=> array(
				'main-1'		=> array(
					'background'	=> '#6B8E23',
					'fontColor'		=> '#FFFFFF'
					),
				'main-2'		=> array(
					'background'	=> "#556B2F",
					'fontColor'		=> "#FFFFFF"
					),
				'main-3'		=> array(
					'background'	=> "#2E8B57",
					'fontColor'		=> '#FFFFFF'
					),
				'main-4'		=> array(
					'background'	=> "#3CB371",
					'fontColor'		=> "#FFFFFF"
					),
				'main-5'		=> array(
					'background'	=> "#8FBC8F",
					'fontColor'		=> "#FFFFFF"
					)
				),
			'highlight' => array(
				'highlight-1'	=> array(
					'background'	=> '#FFFFFF',
					'fontColor'		=> '#000000'
					)
				),
			'active'	=> array(
				'active-1'		=> array(
					'background'	=> '#912A2C',
					'fontColor'		=> '#000000'
					)
				),
			'highlightActive'	=> array(
				'highlightActive-1'	=> array(
					'background'	=> '#FFDDFF',
					'fontColor'		=> '#000000'
					)
				)
			),
		'theme-default-3'	=> array(
			'main' 		=> array(
				'main-1'		=> array(
					'background'	=> '#228B22',
					'fontColor'		=> '#FFFFFF'
					),
				'main-2'		=> array(
					'background'	=> "#008000",
					'fontColor'		=> "#FFFFFF"
					),
				'main-3'		=> array(
					'background'	=> "#006400",
					'fontColor'		=> '#FFFFFF'
					)
				),
			'highlight' => array(
				'highlight-1'	=> array(
					'background'	=> '#FFFFFF',
					'fontColor'		=> '#000000'
					)
				),
			'active'	=> array(
				'active-1'		=> array(
					'background'	=> '#912A2C',
					'fontColor'		=> '#000000'
					)
				),
			'highlightActive'	=> array(
				'highlightActive-1'	=> array(
					'background'	=> '#FFDDFF',
					'fontColor'		=> '#000000'
					)
				)
			),
		'theme-default-4'	=> array(
			'main' 		=> array(
				'main-1'		=> array(
					'background'	=> '#2E8B57',
					'fontColor'		=> '#FFFFFF'
					),
				'main-2'		=> array(
					'background'	=> "#20B2AA",
					'fontColor'		=> "#FFFFFF"
					),
				'main-3'		=> array(
					'background'	=> "#3CB371",
					'fontColor'		=> '#FFFFFF'
					),
				'main-4'		=> array(
					'background'	=> "#8FBC8F",
					'fontColor'		=> "#FFFFFF"
					)
				),
			'highlight' => array(
				'highlight-1'	=> array(
					'background'	=> '#FFFFFF',
					'fontColor'		=> '#000000'
					)
				),
			'active'	=> array(
				'active-1'		=> array(
					'background'	=> '#912A2C',
					'fontColor'		=> '#000000'
					)
				),
			'highlightActive'	=> array(
				'highlightActive-1'	=> array(
					'background'	=> '#FFDDFF',
					'fontColor'		=> '#000000'
					)
				)
			),
		'theme-default-5'	=> array(
			'main' 		=> array(
				'main-1'		=> array(
					'background'	=> '#9ACD32',
					'fontColor'		=> '#FFFFFF'
					),
				'main-2'		=> array(
					'background'	=> "#32CD32",
					'fontColor'		=> "#FFFFFF"
					),
				'main-3'		=> array(
					'background'	=> "#2A912A",
					'fontColor'		=> '#FFFFFF'
					),
				'main-4'		=> array(
					'background'	=> "#2E8B57",
					'fontColor'		=> "#FFFFFF"
					)
				),
			'highlight' => array(
				'highlight-1'	=> array(
					'background'	=> '#FFFFFF',
					'fontColor'		=> '#000000'
					)
				),
			'active'	=> array(
				'active-1'		=> array(
					'background'	=> '#912A2C',
					'fontColor'		=> '#000000'
					)
				),
			'highlightActive'	=> array(
				'highlightActive-1'	=> array(
					'background'	=> '#FFDDFF',
					'fontColor'		=> '#000000'
					)
				)
			),
		),
	'backgroundColor'	=> "#292929",
	'mainFontColor'		=> '#FFFFFF',
	'invertMenuImages'	=> 'false',
	'backgroundHeaderColor'	=> "#222222",
	'watchList'		=> array(
		'/var/www/html/var/log/system.log'	        => '',
		'/var/log/hhvm/error.log'	=> '',
		'/var/log/apache2'			=> '.log$'
	)
);
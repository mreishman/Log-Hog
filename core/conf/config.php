<?php

$defaultConfig = array(
	'autoCheckDaysUpdate'			=>	'7',
	'autoCheckUpdate' 				=> 'true',
	'autoMoveUpdateLog'				=> 'false',
	'backgroundColor'				=> "#292929",
	'backgroundHeaderColor'			=> "#222222",
	'backgroundPollingRate'			=> 5000,
	'backgroundPollingRateType'		=> 'Milliseconds',
	'backupNumConfig'				=> 5,
	'backupNumConfigEnabled'		=> 'true',
	'baseUrlUpdate'					=> 'https://github.com/mreishman/Log-Hog/archive/',
	'bottomBarIndexShow'			=> 'true',
	'branchSelected'				=> 'default',
	'buffer'						=> 500,
	'caseInsensitiveSearch'			=> 'true',
	'configVersion'					=> 2,
	'cssVersion'					=> 1,
	'currentFolderColorTheme'		=> 'theme-default-2',
	'currentTheme'					=> 'Default',
	'currentThemeBase'				=> 'Default',
	'developmentTabEnabled'			=> 'false',
	'dontNotifyVersion'				=> '0',
	'displayName'					=> 'forThemesOnly',
	'enableDevBranchDownload' 		=> 'false',
	'enableHtopLink'				=> 'false',
	'enableLogging'					=> 'false',
	'enablePollTimeLogging'			=> 'false',
	'expSettingsAvail'				=> 'true',
	'filterDefault'					=> 'title',
	'filterContentHighlight'		=> 'true',
	'filterContentLimit'			=> 'true',
	'filterContentLinePadding'		=> 3,
	'filterTitleIncludePath'		=> 'true',
	'flashTitleUpdateLog'			=> 'false',
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
	'fontFamily'					=> 'monospace',
	'groupByColorEnabled'			=> 'true',
	'groupByType'					=> 'folder',
	'hideEmptyLog'					=> 'false',
	'highlightColorBG'				=> '#FFFF00',
	'highlightColorFont'			=> '#000000',
	'highlightNew'					=> 'true',
	'highlightNewColorBG'			=> '#FFFF00',
	'highlightNewColorFont'			=> '#000000',
	'invertMenuImages'				=> 'false',
	'layoutVersion'					=> 1,
	'loadingBarVersion'				=> 1,
	'locationForMonitor'			=> '',
	'locationForSearch'				=> '',
	'locationForSeleniumMonitor'	=> '',
	'locationForStatus'				=> '',
	'logFontColor'					=> '#FFFFFF',
	'logSizeLimit'					=>	2000,
	'logTitle'						=> 'lastLine',
	'logTrimMacBSD'					=> 'false',
	'logTrimOn'						=> 'true',
	'logTrimType'					=> 'lines',
	'mainFontColor'					=> '#FFFFFF',
	'notificationCountVisible'		=> 'true',
	'overallBrightness'				=> 100,
	'pauseOnNotFocus'				=> 'true',
	'pausePoll'						=> 'false',
	'pollingRate'					=> 500,
	'pollingRateType'				=> 'Milliseconds',
	'pollForceTrue'					=> 60,
	'pollForceTrueBool'				=> 'true',
	'pollRefreshAll'				=> 120,
	'pollRefreshAllBool'			=> 'true',
	'popupWarnings'					=> 'all',
	'popupSettingsArray'	=> array(
		'saveSettings'		=>	'true',
		'blankFolder'		=>	'true',
		'deleteLog'			=>	'true',
		'removeFolder'		=> 	'true',
		'versionCheck'		=> 'true'
		),
	'rightClickMenuEnable'			=> 'true',
	'scrollBarHandle'				=> 'background: #CCC;',
	'scrollBarHandleHover'			=> 'background: #FFF;',
	'scrollBarTrack'				=> 'background: #222;',
	'scrollOnUpdate'				=> 'true',
	'scrollEvenIfScrolled'			=> 'true',
	'sendCrashInfoJS'				=> 'true',
	'sendCrashInfoPHP'				=> 'true',
	'shellOrPhp'					=> 'phpPreferred',
	'sliceSize'						=> 500,
	'themesEnabled'					=> 'true',
	'themeVersion'					=> 7,
	'TrimSize'						=> 'K',
	'truncateLog'					=> 'true',
	'updateNoticeMeter'				=> 'every',
	'updateNotificationEnabled'		=> 'true',
	'watchList'		=> array(
		'/var/www/html/var/log/system.log'	        => '',
		'/var/log/hhvm/error.log'	=> '',
		'/var/log/apache2'			=> '.log$'
	),
	'windowConfig'					=> '1x1'
);
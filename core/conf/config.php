<?php

$defaultConfig = array(
	'addonsAsIframe'				=> 'true',
	'allLogsVisible'				=> 'true',
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
	'bottomBarIndexType'			=> 'center',
	'branchSelected'				=> 'default',
	'buffer'						=> 500,
	'caseInsensitiveSearch'			=> 'true',
	'configVersion'					=> 4,
	'cssVersion'					=> 1,
	'currentFolderColorTheme'		=> 'theme-default-2',
	'currentTheme'					=> 'Default',
	'currentThemeBase'				=> 'Default',
	'dateTextFormat'				=> 'MM/|DD/|YYYY |hh:|mm:|ss',
	'dateTextFormatCustom'			=> '',
	'defaultNewAddAlertEnabled'		=>	'true',
	'defaultNewAddAutoDeleteFiles'	=>	'',
	'defaultNewAddExcludeTrim'		=>	'false',
	'defaultNewAddPattern'			=>	'.log$',
	'defaultNewAddRecursive'		=>	'false',
	'defaultNewPathFile'			=>	'/var/',
	'defaultNewPathFolder'			=>	'/var/',
	'defaultNewPathOther'			=>	'/var/',
	'developmentTabEnabled'			=> 'false',
	'dontNotifyVersion'				=> '0',
	'displayName'					=> 'forThemesOnly',
	'enableDevBranchDownload' 		=> 'false',
	'enableHistory'					=> 'true',
	'enableLogging'					=> 'false',
	'enableMultiLog'				=> 'true',
	'enablePollTimeLogging'			=> 'false',
	'expFormatEnabled'				=> 'false',
	'expSettingsAvail'				=> 'true',
	'filterDefault'					=> 'content',
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
	'fullScreenMenuPollSwitchDelay'	=> 0,
	'fullScreenMenuPollSwitchType'	=> 'BGrate',
	'groupByColorEnabled'			=> 'true',
	'groupByType'					=> 'folder',
	'groupDropdownInHeader'			=> 'false',
	'hideClearAllNotifications'		=> 'true',
	'hideEmptyLog'					=> 'false',
	'hideNotificationIcon'			=> 'true',
	'highlightColorBG'				=> '#FFFF00',
	'highlightColorFont'			=> '#000000',
	'highlightNew'					=> 'true',
	'highlightNewColorBG'			=> '#FFFF00',
	'highlightNewColorFont'			=> '#000000',
	'invertMenuImages'				=> 'false',
	'jsVersion'						=> 300,
	'layoutVersion'					=> 1,
	'lineCountFromJS'				=> "true",
	'loadingBarVersion'				=> 1,
	'locationForMonitor'			=> '',
	'locationForSearch'				=> '',
	'locationForSeleniumMonitor'	=> '',
	'locationForStatus'				=> '',
	'logFontColor'					=> '#FFFFFF',
	'logFontSize'					=> 100,
	'logLinePadding'				=> 4,
	'logMenuLocation'				=> 'top',
	'logNameExtension'				=> 'true',
	'logNameFormat'					=> 'default',
	'logNameGroup'					=> 'false',
	'logLoadLayout'					=> array(),
	'logSelectedFirstLoad'			=> '',
	'logShowMoreOptions'			=> 'false',
	'logSizeLimit'					=>	2000,
	'logSwitchABCClearAll'			=> 'false',
	'logSwitchKeepCurrent'			=> 'true',
	'logTitle'						=> 'lastLine',
	'logTrimMacBSD'					=> 'false',
	'logTrimOn'						=> 'false',
	'logTrimType'					=> 'lines',
	'mainFontColor'					=> '#FFFFFF',
	'maxHeightLogTabs'				=> 134,
	'multiLogOnIndex'				=> 'false',
	'notificationCountViewedOnly'	=> 'true',
	'notificationCountVisible'		=> 'true',
	'notificationGroupType'			=> 'OnlyRead',
	'notificationPreviewHeight'		=> 100,
	'notificationPreviewShow'		=> 'true',
	'offscreenLogNotify'			=> 'true',
	'oneLogEnable'					=> 'true',
	'oneLogHighlight'				=> 'titleBar',
	'oneLogLogMaxHeight'			=> 205,
	'oneLogMaxLength'				=> 20,
	'oneLogMergeLast'				=> 'true',
	'oneLogNewBlockClick'			=> 'true',
	'oneLogVisible'					=> 'true',
	'oneLogVisibleDisableUpdate'	=> 'false',
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
	'popupSettingsArray'			=> '{"saveSettings":"true","blankFolder":"true","deleteLog":"true","removeFolder":"true","versionCheck":"true"}',
	'rightClickMenuEnable'			=> 'true',
	'saveTmpLogOnClear'				=> 'true',
	'scrollBarHandle'				=> 'background: #CCC;',
	'scrollBarHandleHover'			=> 'background: #FFF;',
	'scrollBarTrack'				=> 'background: #222;',
	'scrollOnUpdate'				=> 'true',
	'scrollEvenIfScrolled'			=> 'true',
	'sendCrashInfoJS'				=> 'true',
	'sendCrashInfoPHP'				=> 'true',
	'shellOrPhp'					=> 'phpPreferred',
	'showErrorPhpFileOpen'			=> 'false',
	'sideBarOnlyIcons'				=> 'true',
	'sliceSize'						=> 500,
	'sortTypeFileFolderPopup'		=> 'startsWithAndcontains',
	'successVerifyNum'				=> 2,
	'themesEnabled'					=> 'true',
	'themeVersion'					=> 21,
	'timeoutHighlight'				=> 30,
	'TrimSize'						=> 'K',
	'truncateLog'					=> 'true',
	'updateNoticeMeter'				=> 'every',
	'updateNotificationEnabled'		=> 'true',
	'watchList'		=> array(
		'System Log'	    => array(
			"AlertEnabled"		=>	"true",
			"AutoDeleteFiles"	=>	"",
			"ExcludeTrim"		=>	"false",
			"FileInformation"	=>	'{}',
			"FileType"			=>	"folder",
			"GrepFilter"		=>	'',
			"Group"				=>	"",
			"Location"			=>	"/var/www/html/var/log/",
			"Name"				=>	"",
			"Pattern"			=>	".log$",
			"Recursive"			=>	"false",
			"SaveGroup"			=>	"false"
		),
		'HHVM'				=> array( /* Do NOT delete, this is used for base of loading watchlist keys */
			"AlertEnabled"		=>	"true",
			"AutoDeleteFiles"	=>	"",
			"ExcludeTrim"		=>	"false",
			"FileInformation"	=>	'{}',
			"FileType"			=>	"file",
			"GrepFilter"		=>	'',
			"Group"				=>	"",
			"Location"			=>	"/var/log/hhvm/error.log",
			"Name"				=>	"",
			"Pattern"			=>	"",
			"Recursive"			=>	"false",
			"SaveGroup"			=>	"false"
		),
		'Apache2'			=> array(
			"AlertEnabled"		=>	"true",
			"AutoDeleteFiles"	=>	"",
			"ExcludeTrim"		=>	"false",
			"FileInformation"	=>	'{"/var/log/apache2/access.log" : { "Include": "true" ,  "Trim":  "false" ,  "Delete":  "false",  "Name":  "",  "Alert":  "false"  },"/var/log/apache2/error.log" : { "Include": "true" ,  "Trim":  "false" ,  "Delete":  "false",  "Name":  "",  "Alert":  "true"  },"/var/log/apache2/other_vhosts_access.log" : { "Include": "true" ,  "Trim":  "false" ,  "Delete":  "false",  "Name":  "",  "Alert":  "false"  },"/var/log/apache2/ssl_access.log" : { "Include": "true" ,  "Trim":  "false" ,  "Delete":  "false",  "Name":  "",  "Alert":  "false"  },"/var/log/apache2/ssl_error.log" : { "Include": "true" ,  "Trim":  "false" ,  "Delete":  "false",  "Name":  "",  "Alert":  "true"  }}',
			"FileType"			=>	"folder",
			"GrepFilter"		=>	'',
			"Group"				=>	"",
			"Location"			=>	"/var/log/apache2",
			"Name"				=>	"",
			"Pattern"			=>	".log$",
			"Recursive"			=>	"false",
			"SaveGroup"			=>	"false"
		),
		'Nginx'			=> array(
			"AlertEnabled"		=>	"true",
			"AutoDeleteFiles"	=>	"",
			"ExcludeTrim"		=>	"false",
			"FileInformation"	=>	'{"/var/log/nginx/access.log" : { "Include": "true" ,  "Trim":  "false" ,  "Delete":  "false",  "Name":  "",  "Alert":  "false"  },"/var/log/nginx/error.log" : { "Include": "true" ,  "Trim":  "false" ,  "Delete":  "false",  "Name":  "",  "Alert":  "true"  }}',
			"FileType"			=>	"folder",
			"GrepFilter"		=>	'',
			"Group"				=>	"",
			"Location"			=>	"/var/log/nginx",
			"Name"				=>	"",
			"Pattern"			=>	".log$",
			"Recursive"			=>	"false",
			"SaveGroup"			=>	"false"
		)
	),
	'windowConfig'					=> '1x1'
);

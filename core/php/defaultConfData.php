<?php

$oneToTenArr = array();
for ($i=0; $i < 10; $i++)
{
	$oneToTenArr[$i] = array(
	"value" 					=> $i,
	"name" 						=> $i);
}

$saveVerifyArr = array();
for ($j=1; $j <= 5; $j++)
{
	$saveVerifyArr[$j] = array(
	"value" 					=> $j,
	"name" 						=> $j);
}


$arrayOfwindowConfigOptions = array();
$counter = 0;
for ($k=0; $k < 3; $k++)
{
	for ($l=0; $l < 3; $l++)
	{
		$arrayOfwindowConfigOptions[$counter] = array(
		"value" 					=> "".($k+1)."x".($l+1),
		"name" 						=> "".($k+1)."x".($l+1));
		$counter++;
	}
}

$fontSizeVars = array();
$brightessVars = array();
$logPaddingVars = array();
for ($m=0; $m < 20; $m++)
{
	if($m >= 5)
	{
		$fontSizeVars[$m] = array(
			"value" 					=> ($m*10),
			"name" 						=> ($m*10)."%");
	}

	if($m >= 2 && $m <= 15)
	{
		$brightessVars[$m] = array(
			"value" 					=> ($m*10),
			"name" 						=> ($m*10)."%");
	}

	$logPaddingVars[$m] = array(
			"value" 					=> $m,
			"name" 						=> $m."px");
}

$branchOptionsArr = array(
0 					=> array(
	"value" 			=> "default",
	"name" 				=> "Stable"),
1 					=> array(
	"value" 			=> "beta",
	"name" 				=> "Beta")
);

if($enableDevBranchDownload == 'true')
{
	$branchOptionsArr[2] = array(
	"value" 			=> "dev",
	"name" 				=> "Dev");
}

$fontChoices = array(
	0 			=> 	array(
		"name" 		=> 'monospace',
		"value" 	=> 'monospace'),
	1 			=>	array(
		"name" 		=>	'sans-serif',
		"value"		=>	'sans-seri'),
	2			=>	array(
		"name"		=>	'Courier',
		"value"		=>	'Courier'),
	3			=>	array(
		"name"		=>	'Monaco',
		"value"		=>	'Monaco'),
	4			=>	array(
		"name" 		=>	'Verdana',
		"value"		=>	'Verdana'),
	5			=>	array(
		"name"		=>	'Geneva',
		"value"		=>	'Geneva'),
	6			=>	array(
		"name"		=>	'Helvetica',
		"value"		=>	'Helvetica'),
	7			=>	array(
		"name"		=>	'Tahoma',
		"value"		=>	'Tahoma'),
	8			=>	array(
		"name"		=>	'Charcoal',
		"value"		=>	'Charcoal'),
	9			=>	array(
		"name"		=>	'Impact',
		"value"		=>	'Impact'),
	10			=>	array(
		"name"		=>	'cursive',
		"value"		=>	'cursive'),
	11			=>	array(
		"name"		=>	'Gadget',
		"value"		=>	'Gadget'),
	12			=>	array(
		"name"		=>	'Arial',
		"value"		=>	'Arial')
	);

$dateFormatOptions = array(
	0 			=> 	array(
		"name" 		=> 'Default',
		"value" 	=> 'default'),
	1 			=>	array(
		"name" 		=>	'Hidden',
		"value"		=>	'hidden'),
	2			=>	array(
		"name"		=>	'hh:mm:ss',
		"value"		=>	'hh:|mm:|ss'),
	3			=>	array(
		"name"		=>	'DD/MM/YYYY',
		"value"		=>	'DD/|MM/|YYYY'),
	4			=>	array(
		"name" 		=>	'MM/DD/YYYY',
		"value"		=>	'MM/|DD/|YYYY'),
	5			=>	array(
		"name"		=>	'DD/MM',
		"value"		=>	'DD/|MM'),
	6			=>	array(
		"name"		=>	'MM/DD/YYYY hh:mm:ss',
		"value"		=>	'MM/|DD/|YYYY |hh:|mm:|ss'),
	7			=>	array(
		"name"		=>	'DD/MM/YYYY hh:mm:ss',
		"value"		=>	'DD/|MM/|YYYY |hh:|mm:|ss'),
	8			=>	array(
		"name"		=>	'YYYY/MM/DD hh:mm:ss',
		"value"		=>	'YYYY/|MM/|DD |hh:|mm:|ss'),
	9			=>	array(
		"name"		=>	'Custom',
		"value"		=>	'custom')
	);


$customForFirstLogSelect = "<span class=\"settingsBuffer\" > First Log Select: </span><span id=\"logSelectedFirstLoad\" >";
if ($logSelectedFirstLoad === "")
{
	$customForFirstLogSelect .=	"No Log Selected";
}
else
{
	$customForFirstLogSelect .= $logSelectedFirstLoad;
}
$customForFirstLogSelect .= "</span>  <span onclick=\"selectLogPopup('logSelectedFirstLoad');\" class=\"link\">Select Log</span> <span id=\"unselectLogButtonlogSelectedFirstLoad\" onclick=\"unselectLog('logSelectedFirstLoad')\" class=\"link\" >Un-Select Log</span>";
if ($logSelectedFirstLoad === "")
{
	$customForFirstLogSelect .= "<input type=\"hidden\" name=\"logSelectedFirstLoad\" value=\"\" >";
}
else
{
	$customForFirstLogSelect .= "<input type=\"hidden\" name=\"logSelectedFirstLoad\" value=\"".$logSelectedFirstLoad."\" >";
}

$customPostTextLogSize = "<span id=\"logTrimTypeText\" >";
if($logTrimType == 'lines')
{
	$customPostTextLogSize .= "Lines";
}
elseif($logTrimType == 'size')
{
	$customPostTextLogSize .= $TrimSize;
}
$customPostTextLogSize .= "</span>";

$customVarPopup = array();
$popupSettingsInArray = json_decode($popupSettingsArray);
$counterPopup = 0;
foreach ($popupSettingsInArray as $key => $value)
{
	$customVarPopup[$counterPopup]	= array(
		"type"								=>	"single",
		"var"								=>	array(
			"function"							=>	"updateJsonForPopupTheme",
			"id"								=>	"popup".$key,
			"key"								=>	$key,
			"name"								=>	$key,
			"options"							=>	$trueFalsVars,
			"type"								=>	"dropdown",
			"value"								=>	$value
		)
	);
	$counterPopup++;
}

$defaultConfigMoreData = array(
	"archive"							=>	array(
		"id"								=>	"archiveConfig",
		"name"								=>	"Archive",
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"saveTmpLogOnClear",
					"name"								=>	"Save Tmp Log on Clear / Delete",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
		)
	),
	"config"							=>	array(
		"id"								=>	"advancedConfig",
		"name"								=>	"Config",
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"branchSelected",
					"name"								=>	"Branch",
					"options"							=>	$branchOptionsArr,
					"type"								=>	"dropdown"
				)
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"developmentTabEnabled",
					"name"								=>	"Enable Development Tools",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"themesEnabled",
					"name"								=>	"Enable Themes",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"enableMultiLog",
					"name"								=>	"Enable Multi-Log",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			4									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"rightClickMenuEnable",
					"name"								=>	"Right Click Menu Enabled",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			5									=>	array(
				"bool"								=>	($backupNumConfigEnabled == 'false'),
				"id"								=>	"versionSaveContentSettings",
				"name"								=>	"Backup Config Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideVersionSaveConfig",
					"id"								=>	"backupNumConfigEnabled",
					"key"								=>	"backupNumConfigEnabled",
					"name"								=>	"Enable Backup Config Files",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"backupNumConfig",
							"name"								=>	"Number of versions saved",
							"options"							=>	$oneToTenArr,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			6									=>	array(
				"info"								=>	"This is for platforms where saving files might not be in sync with containers. Increasing from one will make saves take longer, but it will be more accurate if there is that sync delay",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"successVerifyNum",
					"name"								=>	"Save verification number",
					"options"							=>	$saveVerifyArr,
					"type"								=>	"dropdown"
				)
			),
			7									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"enableHistory",
					"name"								=>	"Enable History",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
		)
	),
	"fileLocations"						=>	array(
		"id"								=>	"locationOtherApps",
		"name"								=>	"File Locations",
		"vars"								=>	array(
			0									=> array(
				"info"								=>	"Default = https://".$_SERVER['SERVER_NAME']."/status",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"locationForStatus",
					"name"								=>	"Status Location",
					"type"								=>	"text"
				)
			),
			1									=> array(
				"info"								=>	"Default = https://".$_SERVER['SERVER_NAME']."/monitor",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"locationForMonitor",
					"name"								=>	"Monitor Location",
					"type"								=>	"text"
				)
			),
			2									=> array(
				"info"								=>	"Default = https://".$_SERVER['SERVER_NAME']."/search",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"locationForSearch",
					"name"								=>	"Search Location",
					"type"								=>	"text"
				)
			),
			3									=> array(
				"info"								=>	"Default = https://".$_SERVER['SERVER_NAME']."/seleniumMonitor",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"locationForSeleniumMonitor",
					"name"								=>	"Selenium Monitor Location",
					"type"								=>	"text"
				)
			),
		)
	),
	"filterVars"						=>	array(
		"id"								=>	"settingsFilterVars",
		"name"								=>	"Filter Settings",
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"filterDefault",
					"name"								=>	"Default Filter By",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "title",
							"name" 								=> "Title"),
						1 									=> array(
							"value" 							=> "content",
							"name" 								=> "Content")
					),
					"type"								=>	"dropdown"
				)
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"caseInsensitiveSearch",
					"name"								=>	"Case Insensitive Search",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"filterTitleIncludePath",
					"name"								=>	"Filter Title Includes Path",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=>	array(
				"bool"								=>	($filterContentHighlight == 'false'),
				"id"								=>	"highlightContentSettings",
				"name"								=>	"Filter Highlight Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideFilterHighlightSettings",
					"id"								=>	"filterContentHighlight",
					"key"								=>	"filterContentHighlight",
					"name"								=>	"Highlight Content match",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"highlightColorBG",
							"name"								=>	"Background",
							"type"								=>	"text"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"highlightColorFont",
							"name"								=>	"Font",
							"type"								=>	"text"
						)
					)
				)
			),
			4									=>	array(
				"bool"								=>	($filterContentLimit == 'false'),
				"info"								=>	"When filtering by content, only show the line (or some sorrounding lines) containing the search content",
				"id"								=>	"filterContentSettings",
				"name"								=>	"Filter Content Match Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideFilterContentSettings",
					"id"								=>	"filterContentLimit",
					"key"								=>	"filterContentLimit",
					"name"								=>	"Filter Content match",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"filterContentLinePadding",
							"name"								=>	"Line Padding",
							"options"							=>	$oneToTenArr,
							"type"								=>	"dropdown"
						)
					)
				)
			)
		)
	),
	"generalThemeOptions"				=>	array(
		"id"								=>	"generalThemeOptions",
		"name"								=>	"Main Theme Options [Refresh Required]",
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"backgroundColor",
					"name"								=>	"Background",
					"type"								=>	"text"
				)
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"fontFamily",
					"name"								=>	"Font",
					"options"							=>	$fontChoices,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"mainFontColor",
					"name"								=>	"Main Font Color",
					"type"								=>	"text"
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFontColor",
					"name"								=>	"Log Font Color",
					"type"								=>	"text"
				)
			),
			4									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFontSize",
					"name"								=>	"Log Font Size",
					"options"							=>	$fontSizeVars,
					"type"								=>	"dropdown"
				)
			),
			5									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logLinePadding",
					"name"								=>	"Log Line Padding",
					"options"							=>	$logPaddingVars,
					"type"								=>	"dropdown"
				)
			),
			6									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"backgroundHeaderColor",
					"name"								=>	"Header Background",
					"type"								=>	"text"
				)
			),
			7									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"invertMenuImages",
					"name"								=>	"Invert Header Images",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			8									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"overallBrightness",
					"name"								=>	"Overall Brightness",
					"options"							=>	$brightessVars,
					"type"								=>	"dropdown"
				)
			),
			9									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"maxHeightLogTabs",
					"name"								=>	"Max height of log tabs",
					"postText"							=>	"Pixles",
					"type"								=>	"number"
				)
			),
		),
	),
	"logFormatVars"						=>	array(
		"id"								=>	"settingsLogFormatVars",
		"name"								=>	"Log Format Settings ",
		"vars"								=>	array(
			0									=> array(
				"bool"								=>	"($dateTextFormat != 'custom')",
				"bool2"								=>	"custom",
				"id"								=>	"settingsPopupVars",
				"name"								=>	"Custom Date Text Format",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"toggleUpdateLogFormat",
					"functionForToggle"					=>	"showOrHideLogFormat",
					"id"								=>	"dateTextFormat",
					"key"								=>	"dateTextFormat",
					"name"								=>	"Date Text Format",
					"options"							=>	$dateFormatOptions,
					"type"								=>	"dropdown"
				),
				"vars"								=>	$customVarPopup
			),
			1									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"id"								=>	"dateTextFormatCustom",
					"key"								=>	"dateTextFormatCustom",
					"type"								=>	"hidden"
				)
			)
		)
	),
	"loggingVars"						=>	array(
		"id"								=>	"loggingDisplay",
		"name"								=>	"Log Settings ",
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"info"								=>	"This will increase poll times",
					"key"								=>	"enableLogging",
					"name"								=>	"File Info Logging",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"enablePollTimeLogging",
					"name"								=>	"Poll Time Logging",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"sendCrashInfoJS",
					"name"								=>	"Send anonymous information about Log-Hog specific javascript errors",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
		)
	),
	"logVars"							=>	array(
		"id"								=>	"settingsLogVars",
		"name"								=>	"Log Settings ",
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"sliceSize",
					"name"								=>	"Number of lines to display",
					"type"								=>	"number"
				)
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"flashTitleUpdateLog",
					"name"								=>	"Flash title on log update",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"info"								=>	"If a log updates, when the above value is true it will automatically switch to that log in the main view",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"autoMoveUpdateLog",
					"name"								=>	"Auto show log on update",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=>	array(
				"bool"								=>	($scrollOnUpdate == 'false'),
				"id"								=>	"scrollLogOnUpdateSettings",
				"name"								=>	"Scroll Log On Update Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideScrollLogSettings",
					"id"								=>	"scrollOnUpdate",
					"key"								=>	"scrollOnUpdate",
					"name"								=>	"Scroll Log on update",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"scrollEvenIfScrolled",
							"name"								=>	"Scroll even if Scrolled:",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			4									=>	array(
				"bool"								=>	($highlightNew == 'false'),
				"id"								=>	"highlightNewSettings",
				"name"								=>	"Highlight New Lines Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideHighlightNewLinesSettings",
					"id"								=>	"highlightNew",
					"key"								=>	"highlightNew",
					"name"								=>	"Temp Highlight New Lines",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"highlightNewColorBG",
							"name"								=>	"Background",
							"type"								=>	"text"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"highlightNewColorFont",
							"name"								=>	"Font",
							"type"								=>	"text"
						)
					),
					2									=> array(
						"info"								=>	"Default 30 ms",
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"timeoutHighlight",
							"name"								=>	"Timeout for fade",
							"type"								=>	"number"
						)
					)
				)
			),
			5									=>	array(
				"bool"								=>	($logTrimOn == 'false'),
				"id"								=>	"settingsLogTrimVars",
				"info"								=>	"This could increase poll times by 2x to 4x depending on size of files, file or line trim, etc.",
				"name"								=>	"Log Trim Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideLogTrimSubWindow",
					"id"								=>	"logTrimOn",
					"key"								=>	"logTrimOn",
					"name"								=>	"Log trim",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"function"							=>	"changeDescriptionLineSize",
							"id"								=>	"logTrimTypeToggle",
							"key"								=>	"logTrimType",
							"name"								=>	"Trim based off of",
							"options"							=>	array(
								0 									=> array(
									"value" 							=> "lines",
									"name" 								=> "Line Count"),
								1 									=> array(
									"value" 							=> "size",
									"name" 								=> "File Size")
							),
							"type"								=>	"dropdown"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logSizeLimit",
							"name"								=>	"Maximum of",
							"postText"							=>	$customPostTextLogSize,
							"type"								=>	"number"
						)
					),
					2									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"buffer",
							"name"								=>	"Buffer Size",
							"type"								=>	"number"
						)
					),
					3									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logTrimMacBSD",
							"name"								=>	"Use Mac/Free BSD Command",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					4									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"function"							=>	"changeDescriptionLineSize",
							"id"								=>	"TrimSize",
							"key"								=>	"TrimSize",
							"name"								=>	"File size is measured in",
							"options"							=>	array(
								0 									=> array(
									"value" 							=> "KB",
									"name" 								=> "KB"),
								1 									=> array(
									"value" 							=> "K",
									"name" 								=> "K"),
								2 									=> array(
									"value" 							=> "MB",
									"name" 								=> "MB"),
								3 									=> array(
									"value" 							=> "M",
									"name" 								=> "M")
							),
							"type"								=>	"dropdown"
						)
					),
				)
			),
			6									=>	array(
				"custom"							=>	$customForFirstLogSelect,
				"info"								=>	"If Multi-Log is enabled, and a variable is set for intial load logs there, this var will be overridden",
				"type"								=>	"custom"
			)
		)
	),
	"menuVars"							=>	array(
		"id"								=>	"settingsMenuVars",
		"name"								=>	"Menu Settings",
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"truncateLog",
					"name"								=>	"Truncate Log Button",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "true",
							"name" 								=> "All Logs"),
						1 									=> array(
							"value" 							=> "false",
							"name" 								=> "Current Log"),
						2 									=> array(
							"value" 							=> "hide",
							"name" 								=> "Hide")
					),
					"type"								=>	"dropdown"
				)
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"hideClearAllNotifications",
					"name"								=>	"Show Notification Clear Button",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"bool"								=>	($bottomBarIndexShow == 'false'),
				"id"								=>	"sidebarContentSettings",
				"name"								=>	"Sidebar Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideSideBarSettings",
					"id"								=>	"bottomBarIndexShow",
					"key"								=>	"bottomBarIndexShow",
					"name"								=>	"Show Side Bar",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"bottomBarIndexType",
							"name"								=>	"Sidebar Type",
							"options"							=>	array(
								0 									=> array(
									"value" 							=> "center",
									"name" 								=> "Center"),
								1 									=> array(
									"value" 							=> "top",
									"name" 								=> "Top"),
								2 									=> array(
									"value" 							=> "bottom",
									"name" 								=> "Bottom"),
								3 									=> array(
									"value" 							=> "full",
									"name" 								=> "Full"),
							),
							"type"								=>	"dropdown"
						)
					)
				)
			),
			3									=> array(
				"type"								=>	"linked",
				"vars"								=>	array(
					0									=>	array(
						"key"								=>	"groupByType",
						"name"								=>	"Group by Color",
						"options"							=>	array(
							0 									=> array(
								"value" 							=> "folder",
								"name" 								=> "Folder"),
							1 									=> array(
								"value" 							=> "file",
								"name" 								=> "File")
						),
						"type"								=>	"dropdown"
					),
					1								=>	array(
						"key"								=>	"groupByColorEnabled",
						"options"							=>	$trueFalsVars,
						"type"								=>	"dropdown"
					)
				)
			),
			4									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"hideEmptyLog",
					"name"								=>	"Hide logs that are empty",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			5									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"notificationCountVisible",
					"name"								=>	"Enable Notification Count",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			6									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logTitle",
					"name"								=>	"On Log Title Hover Show",
					"options"							=>	array(
							0 									=> array(
								"value" 							=> "lastLine",
								"name" 								=> "Last Line In Log"),
							1 									=> array(
								"value" 							=> "filePath",
								"name" 								=> "Full Path Of Log")
						),
					"type"								=>	"dropdown"
				)
			),
			7									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logMenuLocation",
					"name"								=>	"Log List Location",
					"options"							=>	array(
							0 									=> array(
								"value" 							=> "top",
								"name" 								=> "Top"),
							1 									=> array(
								"value" 							=> "bottom",
								"name" 								=> "Bottom"),
							2 									=> array(
								"value" 							=> "left",
								"name" 								=> "Left"),
							3 									=> array(
								"value" 							=> "right",
								"name" 								=> "Right")
						),
					"type"								=>	"dropdown"
				)
			),
			8									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logNameFormat",
					"name"								=>	"Log Name Format",
					"options"							=>	array(
							0 									=> array(
								"value" 							=> "default",
								"name" 								=> "Default"),
							1 									=> array(
								"value" 							=> "firstFolder",
								"name" 								=> "First Folder"),
							2 									=> array(
								"value" 							=> "lastFolder",
								"name" 								=> "Last Folder"),
							3 									=> array(
								"value" 							=> "fullPath",
								"name" 								=> "Full Path")
						),
					"type"								=>	"dropdown"
				)
			),
			9									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logNameExtension",
					"name"								=>	"Show Log Name Extension",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			10									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logNameGroup",
					"name"								=>	"Show Log Name Group",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			11									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"addonsAsIframe",
					"name"								=>	"Addons as Iframe",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			12									=>	array(
				"info"								=>	"If a log tab is not visible (either below of above scroll area), a bar will flash as notification",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"offscreenLogNotify",
					"name"								=>	"Show notification for offscreen log tabs",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			13									=>	array(
				"info"								=>	"1400 Breakpoint shows only images on full screen sidebar, 1000 breakpoint is the same but moves the inner sidebar to the top",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"sideBarOnlyIcons",
					"name"								=>	"Full Screen Menu Side Bar Options",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "true",
							"name" 								=> "Default"),
						1 									=> array(
							"value" 							=> "breakpointone",
							"name" 								=> "1400 Breakpoint"),
						2 									=> array(
							"value" 							=> "breakpointtwo",
							"name" 								=> "1000 Breakpoint")
					),
					"type"								=>	"dropdown"
				)
			),
		)
	),
	"multiLogVars"						=>	array(
		"id"								=>	"settingsMultiLogVars",
		"name"								=>	"Multi-Log Settings",
		"vars"								=> array(
			0									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"windowConfig",
					"name"								=>	"Log Layout",
					"options"							=>	$arrayOfwindowConfigOptions,
					"type"								=>	"dropdown"
				)
			),
			1									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"multiLogOnIndex",
					"name"								=>	"Enable tmp Multilog (button in menu)",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=> array(
				"type"								=>	"single",
				"info"								=>	"When switching between layouts, keep current selected windows over config",
				"var"								=>	array(
					"key"								=>	"logSwitchKeepCurrent",
					"name"								=>	"Keep Current on Switch",
					"options"							=>	array(
							0 									=> array(
								"value" 							=> "true",
								"name" 								=> "True"),
							1 									=> array(
								"value" 							=> "onlyIfPresetDefined",
								"name" 								=> "Only If Preset Is Not Defined"),
							2									=> array(
								"value" 							=> "false",
								"name" 								=> "False")
						),
					"type"								=>	"dropdown"
				)
			),
			3									=> array(
				"info"								=>	"When switching between A B or C layouts, either clear all windows, OR keep current selected windows IF not defined in config",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logSwitchABCClearAll",
					"name"								=>	"Clear windows if not in config",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			)
		)
	),
	"otherVars"							=>	array(
		"id"								=>	"settingsMainVars",
		"name"								=>	"Other Settings",
		"vars"								=> array(
			0									=> array(
				"bool"								=>	"($popupWarnings != 'custom')",
				"bool2"								=>	"custom",
				"id"								=>	"settingsPopupVars",
				"name"								=>	"Popup Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"toggleUpdateDisplayCheck",
					"functionForToggle"					=>	"showOrHidePopupSubWindow",
					"id"								=>	"popupSelect",
					"key"								=>	"popupWarnings",
					"name"								=>	"Popup Warnings",
					"options"							=>	array(
							0 									=> array(
								"value" 							=> "true",
								"name" 								=> "True"),
							1 									=> array(
								"value" 							=> "custom",
								"name" 								=> "Custom"),
							2									=> array(
								"value" 							=> "false",
								"name" 								=> "False")
						),
					"type"								=>	"dropdown"
				),
				"vars"								=>	$customVarPopup
			),
			1									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"id"								=>	"popupSettingsArray",
					"key"								=>	"popupSettingsArray",
					"type"								=>	"hidden"
				)
			)
		),
	),
	"pollVars"							=>	array(
		"id"								=>	"settingsPollVars",
		"name"								=>	"Poll Settings",
		"vars"								=> array(
			0									=> array(
				"type"								=>	"linked",
				"vars"								=>	array(
					0									=>	array(
						"key"								=>	"pollingRate",
						"name"								=>	"Polling Rate",
						"type"								=>	"number"
					),
					1								=>	array(
						"key"								=>	"pollingRateType",
						"options"							=>	array(
							0 									=> array(
								"value" 							=> "Milliseconds",
								"name" 								=> "Milliseconds"),
							1 									=> array(
								"value" 							=> "Seconds",
								"name" 								=> "Seconds")
						),
						"type"								=>	"dropdown"
					)
				)
			),
			1									=> array(
				"type"								=>	"linked",
				"vars"								=>	array(
					0									=>	array(
						"key"								=>	"backgroundPollingRate",
						"name"								=>	"Background Poll Rate",
						"type"								=>	"number"
					),
					1								=>	array(
						"key"								=>	"backgroundPollingRateType",
						"options"							=>	array(
							0 									=> array(
								"value" 							=> "Milliseconds",
								"name" 								=> "Milliseconds"),
							1 									=> array(
								"value" 							=> "Seconds",
								"name" 								=> "Seconds")
						),
						"type"								=>	"dropdown"
					)
				)
			),
			2									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"fullScreenMenuPollSwitchDelay",
					"name"								=>	"Full Screen Menu delay",
					"postText"							=>	"Seconds",
					"type"								=>	"number"
				)
			),
			3									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"fullScreenMenuPollSwitchType",
					"name"								=>	"Full Screen Menu Click",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "BGrate",
							"name" 								=> "Use Background Rate"),
						1 									=> array(
							"value" 							=> "Pause",
							"name" 								=> "Pause Poll")
					),
					"type"								=>	"dropdown"
				)
			),
			4									=> array(
				"info"								=>	"PHP method is more accurate, but will increase poll times",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"lineCountFromJS",
					"name"								=>	"Line count from",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "true",
							"name" 								=> "JS"),
						1 									=> array(
							"value" 							=> "false",
							"name" 								=> "PHP")
					),
					"type"								=>	"dropdown"
				)
			),
			5									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"pauseOnNotFocus",
					"name"								=>	"Pause On Not Focus",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			6									=>	array(
				"type"								=>	"single",
				"var"									=>	array(
					"key"								=>	"pausePoll",
					"name"								=>	"Pause Poll On Load",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			7									=> array(
				"type"								=>	"linked",
				"vars"								=>	array(
					0									=>	array(
						"key"								=>	"pollRefreshAll",
						"name"								=>	"Poll refresh all data every",
						"postText"							=>	"poll requests",
						"type"								=>	"number"
					),
					1								=>	array(
						"key"								=>	"pollRefreshAllBool",
						"options"							=>	$trueFalsVars,
						"type"								=>	"dropdown"
					)
				)
			),
			8									=> array(
				"type"								=>	"linked",
				"vars"								=>	array(
					0									=>	array(
						"key"								=>	"pollForceTrue",
						"name"								=>	"Force poll refresh after",
						"postText"							=>	"skipped poll requests",
						"type"								=>	"number"
					),
					1								=>	array(
						"key"								=>	"pollForceTrueBool",
						"options"							=>	$trueFalsVars,
						"type"								=>	"dropdown"
					)
				)
			),
			9									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"shellOrPhp",
					"name"								=>	"Function preference shell/php",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "shellPreferred",
							"name" 								=> "Shell Preferred"),
						1 									=> array(
							"value" 							=> "phpPreferred",
							"name" 								=> "Php Preferred"),
						2 									=> array(
							"value" 							=> "shellOnly",
							"name" 								=> "Shell Only"),
						3 									=> array(
							"value" 							=> "phpOnly",
							"name" 								=> "Php Only"),
					),
					"type"								=>	"dropdown"
				)
			),
			10									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"showErrorPhpFileOpen",
					"name"								=>	"Show Php errors from file open fails",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			)
		)
	),
	"updateVars"						=>	array(
		"id"								=>	"settingsUpdateVars",
		"name"								=>	"Update Settings ",
		"vars"								=> array(
			0									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"updateNotificationEnabled",
					"name"								=>	"Show Update Notification",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			1									=>	array(
				"bool"								=>	($autoCheckUpdate == 'false'),
				"id"								=>	"settingsAutoCheckVars",
				"name"								=>	"Auto Check Update Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideUpdateSubWindow",
					"id"								=>	"settingsSelect",
					"key"								=>	"autoCheckUpdate",
					"name"								=>	"Auto Check Update",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"autoCheckDaysUpdate",
							"name"								=>	"Check for update every",
							"postText"							=>	"Days",
							"type"								=>	"number"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"updateNoticeMeter",
							"name"								=>	"Notify Updates on",
							"options"							=>	array(
								0 									=> array(
									"value" 							=> "every",
									"name" 								=> "Every Update"),
								1 									=> array(
									"value" 							=> "major",
									"name" 								=> "Only Major Updates")
							),
							"type"								=>	"dropdown"
						)
					)
				)
			)
		)
	),
	"watchlistVars"						=>	array(
		"id"								=>	"settingsWatchlistVars",
		"name"								=>	"Watchlist Settings",
		"vars"								=> array(
			0									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"defaultNewAddAlertEnabled",
					"name"								=>	"Default AlertEnabled",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			1									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"defaultNewAddAutoDeleteFiles",
					"name"								=>	"Default AutoDeleteFiles",
					"postText"							=>	"Days",
					"type"								=>	"number"
				)
			),
			2									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"defaultNewAddExcludeTrim",
					"name"								=>	"Default ExcludeTrim",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"defaultNewAddPattern",
					"name"								=>	"Default Pattern",
					"type"								=>	"text"
				)
			),
			4									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"defaultNewAddRecursive",
					"name"								=>	"Default Recursive",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			5									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"sortTypeFileFolderPopup",
					"name"								=>	"File popup sort",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "startsWithAndcontains",
							"name" 								=> "Starts With > Contains > Other"),
						1 									=> array(
							"value" 							=> "startsWith",
							"name" 								=> "Starts With > Other"),
						2 									=> array(
							"value" 							=> "none",
							"name" 								=> "None")
					),
					"type"								=>	"dropdown"
				)
			),
			6									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logShowMoreOptions",
					"name"								=>	"Default View",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "true",
							"name" 								=> "Expanded"),
						1 									=> array(
							"value" 							=> "false",
							"name" 								=> "Condensed")
					),
					"type"								=>	"dropdown"
				)
			),
		)
	)
);
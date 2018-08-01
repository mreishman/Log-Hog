<?php

$oneToTenArr = array();
for ($i=0; $i < 10; $i++)
{
	$oneToTenArr[$i] = array(
	"value" 					=> $i,
	"name" 						=> $i);
}

$saveVerifyArr = array();
for ($j=0; $j < 5; $j++)
{
	$saveVerifyArr[$j] = array(
	"value" 					=> $j,
	"name" 						=> $j);
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


$customForFirstLogSelect = "<span class=\"settingsBuffer\" > First Log Select: </span><span id=\"logSelectedFirstLoad\" >";
if ($logSelectedFirstLoad === "")
{
	$customForFirstLogSelect .=	"No Log Selected";
}
else
{
	$customForFirstLogSelect .= $logSelectedFirstLoad;
}
$customForFirstLogSelect .= "</span>  <span onclick=\"selectLogPopup('logSelectedFirstLoad');\" class=\"link\">Select Log</span>";
if ($logSelectedFirstLoad === "")
{
	$customForFirstLogSelect .= "<input type=\"hidden\" name=\"logSelectedFirstLoad\" value=\"\" >";
}
else
{
	$customForFirstLogSelect .= "<input type=\"hidden\" name=\"logSelectedFirstLoad\" value=\"".$logSelectedFirstLoad."\" >";
}



$defaultConfigMoreData = array(
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
				"function"							=>	"showOrHideVersionSaveConfig",
				"id"								=>	"versionSaveContentSettings",
				"name"								=>	"Backup Config Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
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
			)
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
				"function"							=>	"showOrHideFilterHighlightSettings",
				"id"								=>	"highlightContentSettings",
				"name"								=>	"Filter Highlight Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
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
				"function"							=>	"showOrHideFilterContentSettings",
				"info"								=>	"When filtering by content, only show the line (or some sorrounding lines) containing the search content",
				"id"								=>	"filterContentSettings",
				"name"								=>	"Filter Content Match Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
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
				"function"							=>	"showOrHideScrollLogSettings",
				"id"								=>	"scrollLogOnUpdateSettings",
				"name"								=>	"Scroll Log On Update Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
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
				"function"							=>	"showOrHideHighlightNewLinesSettings",
				"id"								=>	"highlightNewSettings",
				"name"								=>	"Highlight New Lines Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
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
				"function"							=>	"showOrHideSideBarSettings",
				"id"								=>	"sidebarContentSettings",
				"name"								=>	"Sidebar Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
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
			)
		)
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
					"name"								=>	"Line count from",
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
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
		)
	)
);
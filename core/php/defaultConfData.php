<?php

$linePaddingOptions = array();
for ($i=0; $i < 10; $i++)
{
	$linePaddingOptions[$i] = array(
	"value" 					=> $i,
	"name" 						=> $i);
}

$defaultConfigMoreData = array(
	"filterVars"						=>	array(
		"id"								=>	"settingsFilterVars",
		"name"								=>	"Filter Settings ",
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
				"id"								=>	"filterContentSettings",
				"name"								=>	"Filter Content Match Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"id"								=>	"filterContentLimit",
					"info"								=>	"When filtering by content, only show the line (or some sorrounding lines) containing the search content",
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
							"options"							=>	$linePaddingOptions,
							"type"								=>	"dropdown"
						)
					),
				)
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
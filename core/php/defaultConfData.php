<?php

$oneToTenArr = array();
$oneToFiveArr = array();
$zeroToFiveArr = array();
for ($i=0; $i < 10; $i++)
{
	$oneToTenArr[$i] = array(
	"value" 					=> $i,
	"name" 						=> $i);
	if($i > 0 && $i <= 5)
	{
		$oneToFiveArr[$i] = array(
		"value" 					=> $i,
		"name" 						=> $i);
	}

	if($i <= 5)
	{
		$zeroToFiveArr[$i] = array(
		"value" 					=> $i,
		"name" 						=> $i);
	}
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
$oneLogNum = array();
$oneLogLogMaxHeightArr = array();
for ($m=0; $m < 40; $m++)
{
	if($m >= 5 && $m < 31)
	{
		$fontSizeVars[$m] = array(
			"value" 					=> ($m*10),
			"name" 						=> ($m*10)."%");
	}

	if($m >= 1 && $m <= 10)
	{
		$oneLogNum[$m] = array(
			"value" 					=> ($m*10),
			"name" 						=> ($m*10));
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

	if ($m < 21)
	{
		$oneLogLogMaxHeightArr[$m] = array(
			"value" 					=> (($m*15)+100),
			"name" 						=> (($m*15)+100)."px");
	}
}
$oneLogLogMaxHeightArr[20] = array(
			"value" 					=> 400,
			"name" 						=> "400px");

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

$customForFirstLogSelect .= "<span id=\"unselectLogButtonlogSelectedFirstLoad\" onclick=\"unselectLog('logSelectedFirstLoad')\" class=\"link\" ";
if ($logSelectedFirstLoad === "")
{
	$customForFirstLogSelect .= " style=\"display: none;\" ";
}
$customForFirstLogSelect .= ">Un-Select Log</span>";

if ($logSelectedFirstLoad === "")
{
	$customForFirstLogSelect .= "<input autocomplete=\"off\" type=\"hidden\" name=\"logSelectedFirstLoad\" value=\"\" >";
}
else
{
	$customForFirstLogSelect .= "<input autocomplete=\"off\" type=\"hidden\" name=\"logSelectedFirstLoad\" value=\"".$logSelectedFirstLoad."\" >";
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

$sectionChoices = json_decode(file_get_contents($core->baseURL()."core/json/sectionChoices.json"), true);
$delimiterChoices = json_decode(file_get_contents($core->baseURL()."core/json/delimiterChoices.json"), true);

$customDateFormatVars = array(
	0	=> array(
	"type"								=>	"linked",
	"vars"								=>	array())
);
$CDFVExternalCounter = 0;
$dateTextFormatCustomVars = explode("|", $dateTextFormatCustom);
for($CDFVcount = 0; $CDFVcount < 10; $CDFVcount++)
{
	$currentBracket = "";
	if(isset($dateTextFormatCustomVars[$CDFVcount]))
	{
		$currentBracket = $dateTextFormatCustomVars[$CDFVcount];
	}
	$D1Value = "none";
	$MValue = "none";
	$D2Value = "none";
	if($currentBracket !== "" && strlen($currentBracket) > 0)
	{
		foreach ($delimiterChoices as $delChoice)
		{
			$checkValue = $delChoice["value"];
			if(isset($delChoice["checkValue"]))
			{
				$checkValue = $delChoice["checkValue"];
			}
			if(substr($currentBracket, 0, strlen($checkValue)) === $checkValue)
			{
				//starts with this
				$D1Value = $checkValue;
			}
			if(substr($currentBracket, -strlen($checkValue)) === $checkValue)
			{
				//ends with this
				$D2Value = $checkValue;
			}
		}
		foreach ($sectionChoices as $secChoices)
		{
			$checkValue = $secChoices["value"];
			if(strpos($currentBracket, $checkValue) > -1)
			{
				$MValue = $checkValue;
				break;
			}
		}
	}
	$customDateFormatVars[0]["vars"][$CDFVExternalCounter] = array(
		"key"								=>	"DateFormat-".$CDFVcount."-D1",
		"name"								=>	"",
		"function"							=>	"updateJsonForCustomDateFormat",
		"id"								=>	"DateFormat-".$CDFVcount."-D1",
		"options"							=>	$delimiterChoices,
		"type"								=>	"dropdown",
		"value"								=>	$D1Value
	);
	$CDFVExternalCounter++;
	$customDateFormatVars[0]["vars"][$CDFVExternalCounter] = array(
		"key"								=>	"DateFormat-".$CDFVcount."-M",
		"name"								=>	"",
		"function"							=>	"updateJsonForCustomDateFormat",
		"id"								=>	"DateFormat-".$CDFVcount."-M",
		"options"							=>	$sectionChoices,
		"type"								=>	"dropdown",
		"value"								=>	$MValue
	);
	$CDFVExternalCounter++;
	$customDateFormatVars[0]["vars"][$CDFVExternalCounter] = array(
		"key"								=>	"DateFormat-".$CDFVcount."-D2",
		"name"								=>	"",
		"function"							=>	"updateJsonForCustomDateFormat",
		"id"								=>	"DateFormat-".$CDFVcount."-D2",
		"options"							=>	$delimiterChoices,
		"type"								=>	"dropdown",
		"value"								=>	$D2Value
	);
	$CDFVExternalCounter++;
}

$leftMod = json_decode(file_get_contents($core->baseURL()."core/json/leftMod.json"), true);
$rightMod = json_decode(file_get_contents($core->baseURL()."core/json/rightMod.json"), true);

$exampleLog = json_encode(explode("\n", file_get_contents($core->baseURL()."core/Themes/example.html")));

$customStyleSectionLogs = "
<div class=\"settingsHeader\">Example:</div>
<div class=\"settingsDiv\"><div style=\"max-height: 300px; overflow: auto;\" id=\"exampleStyleLogSpan\"></span></div>
<script>var exampleLogForCustomStyle = ".$exampleLog.";</script>
";

$customStyleSectionTimestamp = "
<div class=\"settingsHeader\">Example:</div>
<div class=\"settingsDiv\"><div style=\"max-height: 300px; overflow: auto;\" id=\"exampleStyleTimestampSpan\"></span></div>
<script>var exampleLineForTimestampStyle = '2021-10-18T20:22:18+00:00 : [hphp] [29] all servers started';</script>
";

$filePathAlternativeSettingsHtml = file_get_contents($core->baseUrl()."core/html/filePathAlternativesSettings.html");


$arraysToDecode = array(
	"onLoadTableContent"		=> array(
		"data"		=> $filePathAlternatives,
		"onchange"	=> 'updateJsonStringOfFilePathAlternatives();',
		"delete"	=> 'removeFilePathAlternativeRow(',	
	),
	"onLoadTableContentView"	=> array(
		"data"		=> $filePathViewAlternatives,
		"onchange"	=> 'updateJsonStringOfFilePathViewAlternatives();',
		"delete"	=> 'removeFilePathViewAlternativeRow(',	
	)
);
foreach($arraysToDecode as $replaceKey => $arrayValue)
{
	$jsonArray = json_decode($arrayValue["data"], true);

	$onLoadContent = "";
	if(!empty($jsonArray))
	{
		$startOfTag = true;
		foreach($jsonArray as $jsonData)
		{
			$i = explode("]", explode("[", $jsonData["name"])[1])[0];
			if($startOfTag)
			{
				$onLoadContent .= "<tr class=\"generatedRow\"><td>".$i."</td>";
			}
			$onLoadContent .= "<td><input value=\"".$jsonData["value"]."\" onchange=\"".$arrayValue["onchange"]."\" type=\"text\" name=\"".$jsonData["name"]."\"></td>";
			if(!$startOfTag)
			{
				$onLoadContent .= "<td><span class=\"linkSmall\" onclick=\"".$arrayValue["delete"].$i.");\">Remove Row</span></td></tr>";
			}
			$startOfTag = !$startOfTag;
		}
	}
	$filePathAlternativeSettingsHtml = implode($onLoadContent, explode("{{".$replaceKey."}}", $filePathAlternativeSettingsHtml));
}

$dynamicModuleList = array (
	0									=>	array(
		"type"								=>	"single",
		"var"								=>	array(
			"id"								=>	"moduleDisabledList",
			"key"								=>	"moduleDisabledList",
			"type"								=>	"hidden"
		)
	)
);

foreach ($modulesList as $moduleEntry)
{
	array_push($dynamicModuleList,
		array(
			"type"								=>	"single",
			"var"								=>	array_merge($moduleEntry, array(
				"options"							=> array(
					0 					=> array(
						"value" 			=> "true",
						"name" 				=> "Enabled"),
					1 					=> array(
						"value" 			=> "false",
						"name" 				=> "Disabled")
				),
				"type"								=> "dropdown",
				"function"							=> "updateListOfDisabledModules"
			))
		)
	);
}



$fullScreenMenuGroups = array(
	"main"	=> array (
		"name"		=> "Main",
		"display"	=>	true,
		"subGroups"	=> array()
	),
	"logs"	=> array (
		"name"		=> "Logs",
		"display"	=>	true,
		"subGroups"	=> array()
	),
	"style"	=> array (
		"name"		=> "Style",
		"display"	=>	true,
		"subGroups"	=> array()
	),
	"formatting"	=> array (
		"name"		=> "Log Format",
		"display"	=>	(!in_array('advancedLogFormatEnabled', $arrayOfDisabledModules)),
		"subGroups"	=> array()
	),
	"multilog"	=> array (
		"name"		=> "Multi-Log",
		"display"	=>	!(in_array('enableMultiLog', $arrayOfDisabledModules)),
		"subGroups"	=> array()
	),
	"notifications"	=> array (
		"name"		=> "Notifications",
		"display"	=>	true,
		"subGroups"	=> array()
	),
	"advanced"	=> array (
		"name"		=> "Advanced",
		"display"	=>	true,
		"subGroups"	=> array()
	),
	"global"	=> array (
		"name"		=> "Global",
		"display"	=>	true,
		"subGroups"	=> array()
	)
);

$defaultConfigMoreData = array(
	"actions"							=>	array(
		"id"								=>	"settingsAdvancedAdvanced",
		"name"								=>	"Actions",
		"menu"								=> 	array(
			"groups"							=>	array(
				"advanced"
			),
			"id"								=>	"settingsAdvancedActions",
			"display"							=>	true,
			"name"								=>	"Actions"
		),
		"vars"								=>	array(
			1									=>	array(
				"type"								=>	"action",
				"var"								=>	array(
					"name"								=>	"Re-do Setup",
					"href"								=>	$settingsUrlModifier."setup/step1.php"
				)
			),
			2									=>	array(
				"type"								=>	"action",
				"var"								=>	array(
					"name"								=>	"Revert Version",
					"onClick"							=>	"revertPopup();"
				)
			),
			3									=>	array(
				"type"								=>	"action",
				"var"								=>	array(
					"name"								=>	"Reset Update Notification",
					"onClick"							=>	"resetUpdateNotification();"
				)
			),
			4									=>	array(
				"type"								=>	"action",
				"var"								=>	array(
					"name"								=>	"View restore options for config",
					"onClick"							=>	"showConfigPopup();"
				)
			),
			5									=>	array(
				"type"								=>	"action",
				"var"								=>	array(
					"name"								=>	"Clear Backup Config Files",
					"onClick"							=>	"clearBackupFiles();",
					"outerId"							=>	"showConfigClearButton"
				)
			),
			6									=>	array(
				"type"								=>	"action",
				"var"								=>	array(
					"name"								=>	"Reset Settings back to Default",
					"onClick"							=>	"resetSettingsPopup();"
				)
			)
		)
	),
	"archive"							=>	array(
		"id"								=>	"archiveConfig",
		"name"								=>	"Archive",
		"menu"								=> 	array(
			"groups"							=>	array(
				"main"
			),
			"id"								=>	"settingsMainArchive",
			"display"							=>	true,
			"name"								=>	"Archive"
		),
		"vars"								=>	array(
			0									=>	array(
				"bool"								=>	($saveTmpLogOnClear == 'false'),
				"id"								=>	"saveTmpLogOnClearSettings",
				"name"								=>	"Tmp Log Save Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidesaveTmpLogOnClearSettings",
					"id"								=>	"saveTmpLogOnClear",
					"key"								=>	"saveTmpLogOnClear",
					"name"								=>	"Save Tmp Log on Clear / Delete",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"saveTmpLogNum",
							"name"								=>	"Number of backups",
							"options"							=>	$oneToFiveArr,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			1									=>	array(
				"bool"								=>	($saveArchiveLogLimit == 'false'),
				"id"								=>	"saveArchiveLogLimitSettings",
				"name"								=>	"Archive Log Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidesaveArchiveLogLimitSettings",
					"id"								=>	"saveArchiveLogLimit",
					"key"								=>	"saveArchiveLogLimit",
					"name"								=>	"Limit Archive Log Save Count",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"saveArchiveLogNum",
							"name"								=>	"Number of backups",
							"options"							=>	$oneToFiveArr,
							"type"								=>	"dropdown"
						)
					)
				)
			),
		)
	),
	"config"							=>	array(
		"id"								=>	"advancedConfig",
		"name"								=>	"Config",
		"menu"								=> 	array(
			"groups"							=>	array(
				"advanced"
			),
			"id"								=>	"settingsAdvancedConfig",
			"display"							=>	true,
			"name"								=>	"Config"
		),
		"vars"								=>	array(
			0									=> array(
				"bool"								=>	($popupWarnings != 'custom'),
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
			),
			2									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"saveButtonAlwaysVisible",
					"name"								=>	"Force save button visibility",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=>	array(
				"info"								=>	"Refresh to run upgrade scripts",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"configVersion",
					"name"								=>	"Config Version",
					"type"								=>	"number"
				)
			),
			4									=>	array(
				"info"								=>	"Refresh to run upgrade scripts",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"themeVersion",
					"name"								=>	"Theme Version",
					"type"								=>	"number"
				)
			),
			5									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"info"								=>	"This will increase poll times",
					"key"								=>	"enableLogging",
					"name"								=>	"File Info Logging",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			6									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"enablePollTimeLogging",
					"name"								=>	"Poll Time Logging",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			7									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"enableInitialFileLoadLogging",
					"name"								=>	"Index File Load Logging",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			8									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"pollForceTrueNotice",
					"name"								=>	"Show notice of poll error after",
					"postText"							=>	"skipped poll requests",
					"type"								=>	"number"
				)
			),
			9									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"pollForceTrueWarning",
					"name"								=>	"Show warning of poll error after",
					"postText"							=>	"skipped poll requests",
					"type"								=>	"number"
				)
			),
			10									=> array(
				"info"								=>	"Use shell or php for reading logs and files",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"shellOrPhp",
					"name"								=>	"Poll function preference",
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
			11									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logLayoutSettingsInfo",
					"name"								=>	"Default show options for multi-log layout settings",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "all",
							"name" 								=> "All"),
						1 									=> array(
							"value" 							=> "expandWithValues",
							"name" 								=> "If current window has value"),
						2 									=> array(
							"value" 							=> "expandWithValue",
							"name" 								=> "If any window has value"),
						3 									=> array(
							"value" 							=> "none",
							"name" 								=> "None")
					),
					"type"								=>	"dropdown"
				)
			),
			12									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"backupNumConfig",
					"name"								=>	"Number of config backup versions saved",
					"options"							=>	$oneToTenArr,
					"type"								=>	"dropdown"
				)
			)
		)
	),
	"filterVars"						=>	array(
		"id"								=>	"settingsFilterVars",
		"name"								=>	"Filter Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"main"
			),
			"id"								=>	"settingsMainFilter",
			"display"							=>	!(in_array('filterEnabled', $arrayOfDisabledModules)),
			"name"								=>	"Filter"
		),
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
				"info"								=>	"Default value, current session is changed in settings sidebar",
				"var"								=>	array(
					"key"								=>	"caseInsensitiveSearch",
					"name"								=>	"Case Insensitive Search",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"type"								=>	"single",
				"info"								=>	"Default value, current session is changed in settings sidebar",
				"var"								=>	array(
					"key"								=>	"filterInvert",
					"name"								=>	"Invert Search",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"info"								=>	"Default value, current session is changed in settings sidebar",
				"var"								=>	array(
					"key"								=>	"filterTitleIncludePath",
					"name"								=>	"Filter Title Includes Path",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			4									=>	array(
				"type"								=>	"single",
				"info"								=>	"Default value, current session is changed in settings sidebar",
				"var"								=>	array(
					"key"								=>	"filterTitleIncludeGroup",
					"name"								=>	"Filter Title Includes Group",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			5									=>	array(
				"bool"								=>	($filterContentHighlight == 'false'),
				"id"								=>	"highlightContentSettings",
				"name"								=>	"Filter Highlight Settings",
				"type"								=>	"grouped",
				"info"								=>	"Default value, current session is changed in settings sidebar",
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
							"type"								=>	"color"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"highlightColorFont",
							"name"								=>	"Font",
							"type"								=>	"color"
						)
					),
					2									=>	array(
						"type"								=>	"single",
						"info"								=>	"Default value, current session is changed in settings sidebar",
						"var"								=>	array(
							"key"								=>	"filterContentHighlightLine",
							"name"								=>	"Hilight Entire Line",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			6									=>	array(
				"bool"								=>	($filterContentLimit == 'false'),
				"info"								=>	"When filtering by content, only show the line (or some sorrounding lines) containing the search content. Default value, current session is changed in settings sidebar",
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
						"info"								=>	"Default value, current session is changed in settings sidebar",
						"var"								=>	array(
							"key"								=>	"filterContentLinePadding",
							"name"								=>	"Line Padding",
							"options"							=>	$oneToTenArr,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			7									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"clearFilterValueOnClose",
					"name"								=>	"Clear filter value on close",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
		)
	),
	"generalThemeOptions"				=>	array(
		"id"								=>	"generalThemeOptions",
		"name"								=>	"Main Style Options",
		"menu"								=> 	array(
			"groups"							=>	array(
				"style"
			),
			"id"								=>	"fullScreenMenuThemeGeneralStyle",
			"display"							=>	true,
			"name"								=>	"Main Style"
		),
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"mainFontColor",
					"name"								=>	"Main Font Color",
					"type"								=>	"color"
				)
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"backgroundHeaderColor",
					"name"								=>	"Header Background",
					"type"								=>	"color"
				)
			),
			2									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"invertMenuImages",
					"name"								=>	"Invert Header Images",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"overallBrightness",
					"name"								=>	"Overall Brightness",
					"options"							=>	$brightessVars,
					"type"								=>	"dropdown"
				)
			),
			4									=>	array(
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
	"globalConfig"						=>	array(
		"id"								=>	"globalAdvanced",
		"name"								=>	"Global Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"global"
			),
			"id"								=>	"settingsGlobalAdvanced",
			"display"							=>	true,
			"name"								=>	"Global"
		),
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
				"info"								=>	"This is for platforms where saving files might not be in sync with containers. Increasing from one will make saves take longer, but it will be more accurate if there is that sync delay",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"successVerifyNum",
					"name"								=>	"Save verification number",
					"options"							=>	$oneToFiveArr,
					"type"								=>	"dropdown"
				)
			),
			2									=> array(
				"info"								=>	"Base url hit when downloading Log-Hog version list. Default: https://github.com/mreishman/Log-Hog/archive/",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"baseUrlUpdate",
					"name"								=>	"Base Update Url",
					"type"								=>	"text"
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"info"								=>	"Only for development",
					"key"								=>  "enableDevBranchDownload",
					"name"								=>	"Enable Dev Branch",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			4									=>	array(
				"info"								=>	"Refresh to run upgrade scripts",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"layoutVersion",
					"name"								=>	"Layout Version",
					"type"								=>	"number"
				)
			),
			5									=> array(
				"info"								=>	"Comma seperated list of ips (wild cards valid like 192.168.*.*",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"ipWhitelist",
					"name"								=>	"Whitelist ips",
					"type"								=>	"text"
				)
			)
		)
	),
	"logFormatVars"				=>	array(
		"id"								=>	"logStyle",
		"name"								=>	"Log Style Options",
		"menu"								=> 	array(
			"groups"							=>	array(
				"style"
			),
			"id"								=>	"fullScreenMenuLogStyle",
			"display"							=>	true,
			"name"								=>	"Log Style"
		),
		"vars"								=>	array(
			0									=>	array(
				"custom"							=>	$customStyleSectionLogs,
				"type"								=>	"custom"
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"backgroundColor",
					"name"								=>	"Background",
					"type"								=>	"color"
				)
			),
			2									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"fontFamily",
					"name"								=>	"Font",
					"options"							=>	json_decode(file_get_contents($core->baseURL()."core/json/fontChoices.json"), true),
					"type"								=>	"dropdown"
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFontColor",
					"name"								=>	"Log Font Color",
					"type"								=>	"color"
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
				"bool"								=>	($logLineBorder == 'false'),
				"id"								=>	"logLineBorderSettings",
				"name"								=>	"Log Line Border Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidelogLineBorderSettings",
					"id"								=>	"logLineBorder",
					"key"								=>	"logLineBorder",
					"name"								=>	"Show border between log lines",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logLineBorderColor",
							"name"								=>	"Border Color",
							"type"								=>	"color"
						)
					),
					1									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logLineBorderHeight",
							"name"								=>	"Border Height",
							"options"							=>	$oneToFiveArr,
							"postText"							=>	" px",
							"type"								=>	"dropdown"
						)
					)
				)
			)
		),
	),
	"logFormatVarsAdvanced"				=>	array(
		"id"								=>	"settingsLogFormatVars",
		"name"								=>	"Log Format Settings ",
		"menu"								=> 	array(
			"groups"							=>	array(
				"formatting"
			),
			"id"								=>	"settingsMainLogFormat",
			"display"							=>	(!in_array('advancedLogFormatEnabled', $arrayOfDisabledModules)),
			"name"								=>	"General"
		),
		"vars"								=>	array(
			0									=>	array(
				"id"								=>	"dateTextFormatEnableSettings",
				"name"								=>	"Log Date Text Format Settings",
				"type"								=>	"single",
				"var"								=>	array(
					"function"							=>	"showOrHideLogTimestamp",
					"id"								=>	"dateTextFormatEnable",
					"key"								=>	"dateTextFormatEnable",
					"name"								=>	"Format Timestamps",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			1									=>	array(
				"id"								=>	"logFormatFileEnableSettings",
				"name"								=>	"Log File Link Settings",
				"type"								=>	"single",
				"var"								=>	array(
					"function"							=>	"showOrHidelogLinkedFileSettings",
					"id"								=>	"logFormatFileEnable",
					"key"								=>	"logFormatFileEnable",
					"name"								=>	"Link files in logs",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"bool"								=>	($logFormatPhpEnable == 'false'),
				"id"								=>	"logFormatPhpEnableSettings",
				"name"								=>	"Log Php Message Format Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidelogFormatPhpEnableSettings",
					"id"								=>	"logFormatPhpEnable",
					"key"								=>	"logFormatPhpEnable",
					"name"								=>	"Format php message errors",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logFormatPhpHideExtra",
							"name"								=>	"Only Show Main Error Message",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					1									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logFormatPhpShowImg",
							"name"								=>	"Show Severify Image",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			3									=>	array(
				"bool"								=>	($logFormatReportEnable == 'false'),
				"id"								=>	"logFormatReportEnableSettings",
				"name"								=>	"Log Report Message Format Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidelogFormatReportEnableSettings",
					"id"								=>	"logFormatReportEnable",
					"key"								=>	"logFormatReportEnable",
					"name"								=>	"Format report message errors",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logFormatReportShowImg",
							"name"								=>	"Show Severify Image",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			4									=>	array(
				"bool"								=>	($logFormatShowMoreButton == 'false'),
				"id"								=>	"logFormatShowMoreButtonSettings",
				"name"								=>	"Log Show More Button Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidelogFormatShowMoreButtonSettings",
					"id"								=>	"logFormatShowMoreButton",
					"key"								=>	"logFormatShowMoreButton",
					"name"								=>	"Show the Show More Button",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logFormatShowMoreExtraInfo",
							"name"								=>	"Always show extra info immediately",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			5									=>	array(
				"bool"								=>	($logFormatJsObjectEnable == 'false'),
				"id"								=>	"logFormatJsObjectEnableSettings",
				"name"								=>	"Log JS encoded object Message Format Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidelogFormatJsObjectEnableSettings",
					"id"								=>	"logFormatJsObjectEnable",
					"key"								=>	"logFormatJsObjectEnable",
					"name"								=>	"Format js objects",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logFormatJsObjectArrEnable",
							"name"								=>	"Also format JS array",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					1									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logFormatJsDefaultUnformatted",
							"name"								=>	"Show unformatted by default",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			)
		)
	),
	"logFormatVarsDateTime"				=>	array(
		"id"								=>	"settingsLogFormatVarsDateTime",
		"name"								=>	"Log Date Time Settings ",
		"menu"								=> 	array(
			"groups"							=>	array(
				"formatting"
			),
			"id"								=>	"settingsMainLogDateTimeFormat",
			"display"							=>	(!in_array('advancedLogFormatEnabled', $arrayOfDisabledModules) && $dateTextFormatEnable == 'true'),
			"name"								=>	"Timestamp"
		),
		"vars"								=>	array(
			0									=>	array(
				"custom"							=>	$customStyleSectionTimestamp,
				"type"								=>	"custom"
			),
			1									=> array(
				"bool"								=>	($dateTextFormat != 'custom'),
				"bool2"								=>	"custom",
				"id"								=>	"dateTextFormatSelector",
				"name"								=>	"Custom Date Text Format",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"toggleUpdateLogFormat",
					"functionForToggle"					=>	"showOrHideLogFormat",
					"id"								=>	"dateTextFormat",
					"key"								=>	"dateTextFormat",
					"name"								=>	"Date Text Format",
					"options"							=>	json_decode(file_get_contents($core->baseURL()."core/json/dateFormatOptions.json"), true),
					"type"								=>	"dropdown"
				),
				"vars"								=>	$customDateFormatVars
			),
			2									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"id"								=>	"dateTextFormatCustom",
					"key"								=>	"dateTextFormatCustom",
					"type"								=>	"hidden"
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"dateTextFormatColumn",
					"name"								=>	"Show log date / time in seperate column",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "true",
							"name" 								=> "Always"),
						1 									=> array(
							"value" 							=> "auto",
							"name" 								=> "On larger screens"),
						2 									=> array(
							"value" 							=> "false",
							"name" 								=> "Never")
					),
					"type"								=>	"dropdown"
				)
			),
			4									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"info"								=>	"Only displays top timestamp when more than one in a row are same",
					"key"								=>	"dateTextGroup",
					"name"								=>	"Group Same Timestamps",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "true",
							"name" 								=> "Group by formatted time stamp"),
						1 									=> array(
							"value" 							=> "preFormat",
							"name" 								=> "Group by pre format timestamp"),
						2 									=> array(
							"value" 							=> "false",
							"name" 								=> "False")
					),
					"type"								=>	"dropdown"
				)
			),
			5									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"dateTextBold",
					"name"								=>	"Bold Timestamps",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			6									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"dateTimePadding",
					"name"								=>	"Timestamp Padding",
					"options"							=>	$logPaddingVars,
					"type"								=>	"dropdown"
				)
			),
		)
	),
	"logFormatVarsLinkedFiles"			=>	array(
		"id"								=>	"settingsLogLinkedFilesVars",
		"name"								=>	"Linked Files Settings ",
		"menu"								=> 	array(
			"groups"							=>	array(
				"formatting"
			),
			"id"								=>	"settingsLinkedLogLogFormat",
			"display"							=>	(!in_array('advancedLogFormatEnabled', $arrayOfDisabledModules) && $logFormatFileEnable == "true"),
			"name"								=>	"Linked Files"
		),
		"vars"								=>	array(
			
				
			0									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFormatFileBackground",
					"name"								=>	"Background",
					"type"								=>	"color"
				)
			),
			1									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFormatFileFontColor",
					"name"								=>	"Font",
					"type"								=>	"color"
				)
			),
			2									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFormatFileLineCount",
					"name"								=>	"Show line count",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFormatFileLinePadding",
					"name"								=>	"Line Padding +/-",
					"options"							=>	$zeroToFiveArr,
					"type"								=>	"dropdown"
				)
			),
			4									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFormatFileMaxHeight",
					"name"								=>	"Max Height",
					"options"							=>	$oneLogLogMaxHeightArr,
					"type"								=>	"dropdown"
				)
			),
			5									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFormatFilePermissions",
					"name"								=>	"Show File Permissions",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "always",
							"name" 								=> "Always"),
						1 									=> array(
							"value" 							=> "sometimes",
							"name" 								=> "If warning shown"),
						2 									=> array(
							"value" 							=> "never",
							"name" 								=> "Never")
					),
					"type"								=>	"dropdown"
				)
			),
			6									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFormatFileHideError",
					"name"								=>	"Hide Error if line is no longer in file",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			7									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logFormatFileHideReadError",
					"name"								=>	"Hide Error if file is present but not readable",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			8									=>	array(
				"bool"								=>	($logTrimOn == 'false'),
				"id"								=>	"settingsLogFormatFileTitleSeperateLine",
				"name"								=>	"Linked Log Header Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideLogFormatFileTitleSeperateLine",
					"id"								=>	"logFormatFileTitleSeperateLine",
					"key"								=>	"logFormatFileTitleSeperateLine",
					"name"								=>	"Show File as a seperate line in log",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logFormatTitleBackground",
							"name"								=>	"Background",
							"type"								=>	"color"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logFormatTitleFontColor",
							"name"								=>	"Font",
							"type"								=>	"color"
						)
					)
				)
			),
			9									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"id"								=>	"filePathAlternatives",
					"key"								=>	"filePathAlternatives",
					"type"								=>	"hidden"
				)
			),
			10									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"id"								=>	"filePathViewAlternatives",
					"key"								=>	"filePathViewAlternatives",
					"type"								=>	"hidden"
				)
			),
			11									=>	array(
				"custom"							=>	$filePathAlternativeSettingsHtml,
				"type"								=>	"custom"
			),
		)
	),
	"logVars"							=>	array(
		"id"								=>	"settingsLogVars",
		"name"								=>	"General Log Settings ",
		"menu"								=> 	array(
			"groups"							=>	array(
				"logs"
			),
			"id"								=>	"settingsMainLogs",
			"display"							=>	true,
			"name"								=>	"General"
		),
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
				"bool"								=>	($logLoadType != 'Visible - Poll'),
				"bool2"								=>	"Visible - Poll",
				"id"								=>	"logLoadTypeSettings",
				"name"								=>	"Log Load Type Settings",
				"type"								=>	"grouped",
				"info"								=>	"When rendering logs, either render entire log on load, or render visible and slowly render rest in background",
				"var"								=>	array(
					"function"							=>	"showOrHidelogLoadTypeSettings",
					"id"								=>	"logLoadType",
					"key"								=>	"logLoadType",
					"name"								=>	"Log Load Type",
					"options"							=>	array(
								0 									=> array(
									"value" 							=> "Full",
									"name" 								=> "Full"),
								1 									=> array(
									"value" 							=> "Visible - Poll",
									"name" 								=> "Visible - Poll")
							),
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"linked",
						"vars"								=>	array(
							0									=>	array(
								"key"								=>	"logLoadPollRate",
								"name"								=>	"Polling Rate",
								"type"								=>	"number"
							),
							1								=>	array(
								"key"								=>	"logLoadPollRateType",
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
								"key"								=>	"logLoadPollBackgroundRate",
								"name"								=>	"Background Polling Rate",
								"type"								=>	"number"
							),
							1								=>	array(
								"key"								=>	"logLoadPollBackgroundRateType",
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
							"key"								=>	"logLoadForceScrollToBot",
							"name"								=>	"Force log update to scroll to bottom",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					3									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logLoadPollDisplayType",
							"name"								=>	"Log Loading Poll Display Type",
							"options"							=>	array(
									0 									=> array(
										"value" 							=> "percent",
										"name" 								=> "Percentage"),
									1 									=> array(
										"value" 							=> "linecount",
										"name" 								=> "Line Count")
								),
							"type"								=>	"dropdown"
						)
					),
					4									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logLoadPollLineSize",
							"name"								=>	"Number of lines to unhide per poll",
							"type"								=>	"number"
						)
					),
				)
			),
			2									=>	array(
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
			3									=>	array(
				"custom"							=>	$customForFirstLogSelect,
				"info"								=>	"If Multi-Log is enabled, and a variable is set for intial load logs there, this var will be overridden",
				"type"								=>	"custom"
			),
			4									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logLoadPrevious",
					"name"								=>	"Load last window config on initial load",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			5									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logDirectionInvert",
					"name"								=>	"Reverse log text (most recent at top)",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			)
		)
	),
	"logVarsOnUpdate"					=>	array(
		"id"								=>	"settingsLogOnUpdateVars",
		"name"								=>	"On Log Update Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"logs"
			),
			"id"								=>	"settingsLogsOnUpdate",
			"display"							=>	true,
			"name"								=>	"On Update"
		),
		"vars"								=>	array(
			0									=>	array(
				"info"								=>	"If a log updates, when the above value is true it will automatically switch to that log in the main view",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"autoMoveUpdateLog",
					"name"								=>	"Auto show log on update",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			1									=>	array(
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
							"name"								=>	"Scroll even if Scrolled",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			2									=>	array(
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
							"type"								=>	"color"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"highlightNewColorFont",
							"name"								=>	"Font",
							"type"								=>	"color"
						)
					),
					2									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"timeoutHighlight",
							"name"								=>	"Timeout for fade",
							"type"								=>	"number",
							"postText"							=>	"ms"
						)
					)
				)
			)
		)
	),
	"menuVars"							=>	array(
		"id"								=>	"settingsMenuVars",
		"name"								=>	"Menu Actions Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"main"
			),
			"id"								=>	"settingsMainActionMenu",
			"display"							=>	true,
			"name"								=>	"Menu Actions"
		),
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
					"name"								=>	"Hide Notification Clear Button",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"groupDropdownInHeader",
					"name"								=>	"Show Group dropdown in header",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"filterSearchInHeader",
					"name"								=>	"Show filter search in header",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			4									=>	array(
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
			)
		)
	),
	"menuLogVars"							=>	array(
		"id"								=>	"settingsMenuLogVars",
		"name"								=>	"Menu Logs Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"logs"
			),
			"id"								=>	"settingsMainMenuLogs",
			"display"							=>	true,
			"name"								=>	"Menu Logs"
		),
		"vars"								=>	array(
			0									=>	array(
				"bool"								=>	($groupByColorEnabled == 'false'),
				"id"								=>	"GroupByColorContentSettings",
				"name"								=>	"Group By Color Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideGroupByColorContentSettings",
					"id"								=>	"groupByColorEnabled",
					"key"								=>	"groupByColorEnabled",
					"name"								=>	"Group By Color",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
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
						)
					)
				)
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"hideEmptyLog",
					"name"								=>	"Hide logs that are empty",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"bool"								=>	($notificationCountVisible == 'false'),
				"id"								=>	"notificationCountVisibleSettings",
				"name"								=>	"Notification Count Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidenotificationCountVisible",
					"id"								=>	"notificationCountVisible",
					"key"								=>	"notificationCountVisible",
					"name"								=>	"Enable Log Diff Count",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logDiffCountLeftMod",
							"name"								=>	"Left Mod",
							"options"							=>	$leftMod,
							"type"								=>	"dropdown"
						)
					),
					1									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logDiffCountRightMod",
							"name"								=>	"Right Mod",
							"options"							=>	$rightMod,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			3									=>	array(
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
			4									=>	array(
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
			5									=>	array(
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
			6									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logNameExtension",
					"name"								=>	"Show Log Name Extension",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			7									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logNameGroup",
					"name"								=>	"Show Log Name Group",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			8									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"allLogsVisible",
					"name"								=>	"Log tabs visible on load",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			)
		)
	),
	"menuFullScreenVars"				=>	array(
		"id"								=>	"settingsFullScreenMenuVars",
		"name"								=>	"Full Screen Menu Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"advanced"
			),
			"id"								=>	"settingsMainMenuFullScreen",
			"display"							=>	true,
			"name"								=>	"Full Screen Menu"
		),
		"vars"								=>	array(
			0									=>	array(
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
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"fullScreenMenuDefaultPage",
					"name"								=>	"Full screen menu default page",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "none",
							"name" 								=> "None"),
						1 									=> array(
							"value" 							=> "about",
							"name" 								=> "About"),
						2 									=> array(
							"value" 							=> "history",
							"name" 								=> "History"),
						3 									=> array(
							"value" 							=> "notifications",
							"name" 								=> "Notifications"),
						4 									=> array(
							"value" 							=> "settings",
							"name" 								=> "Settings"),
						5 									=> array(
							"value" 							=> "themes",
							"name" 								=> "Themes"),
						6 									=> array(
							"value" 							=> "update",
							"name" 								=> "Update"),
						7 									=> array(
							"value" 							=> "watchlist",
							"name" 								=> "Watchlist")
					),
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"bool"								=>	($samePageSettings == 'true'),
				"bool2"								=>	"false",
				"id"								=>	"enableMultiLogSettings",
				"name"								=>	"External Settings Page settings",
				"info"								=>	"Show settings on same page as index (no redirect). Refresh Required",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidesamePageSettings",
					"id"								=>	"samePageSettings",
					"key"								=>	"samePageSettings",
					"name"								=>	"Same Page Settings",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"samePageSettingsNewTab",
							"name"								=>	"Settings tabs open in new tab",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
		)
	),
	"modules"							=>	array(
		"id"								=>	"modules",
		"name"								=>	"Modules",
		"menu"								=> 	array(
			"groups"							=>	array(
				"advanced"
			),
			"id"								=>	"settingsAdvancedModules",
			"display"							=>	true,
			"name"								=>	"Modules"
		),
		"vars"								=>	$dynamicModuleList
	),
	"multiLogVars"						=>	array(
		"id"								=>	"settingsMultiLogVars",
		"name"								=>	"Multi-Log Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"multilog"
			),
			"id"								=>	"settingsMainMultiLog",
			"display"							=>	!(in_array('enableMultiLog', $arrayOfDisabledModules)),
			"name"								=>	"Multi-Log"
		),
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
			2									=> array(
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
	"notificationVars"					=>	array(
		"id"								=>	"settingsNotificationVars",
		"name"								=>	"Notification Settings ",
		"menu"								=> 	array(
			"groups"							=>	array(
				"notifications"
			),
			"id"								=>	"settingsMainNotifications",
			"display"							=>	true,
			"name"								=>	"General"
		),
		"vars"								=> array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"flashTitleUpdateLog",
					"name"								=>	"Flash title when notifications",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			1									=>	array(
				"bool"								=>	($notificationCountVisibleTitle == 'false'),
				"id"								=>	"notificationCountVisibleTitleSettings",
				"name"								=>	"Notification Window Title Count Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidenotificationCountVisible",
					"id"								=>	"notificationCountVisibleTitle",
					"key"								=>	"notificationCountVisibleTitle",
					"name"								=>	"Show notification count in title of web page",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationTitleCountLeftMod",
							"name"								=>	"Left Mod",
							"options"							=>	$leftMod,
							"type"								=>	"dropdown"
						)
					),
					1									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationTitleCountRightMod",
							"name"								=>	"Right Mod",
							"options"							=>	$rightMod,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			2									=> array(
				"info"								=>	"Only shows count of notifications that were not viewed",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"notificationCountViewedOnly",
					"name"								=>	"Notification Count only unviewed",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			3									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"notificationGroupType",
					"name"								=>	"Merge Like Log Notifications",
					"options"							=>	array(
						0 									=> array(
							"value" 							=> "Never",
							"name" 								=> "Never"),
						1 									=> array(
							"value" 							=> "OnlyRead",
							"name" 								=> "Only Read"),
						2									=> array(
							"value" 							=> "Always",
							"name" 								=> "Always")
					),
					"type"								=>	"dropdown"
				)
			),
			4									=>	array(
				"bool"								=>	($notificationPreviewShow == 'false'),
				"id"								=>	"notificationPreviewSettings",
				"name"								=>	"Notification Log Preview Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideNotificationPreviewSettings",
					"id"								=>	"notificationPreviewShow",
					"key"								=>	"notificationPreviewShow",
					"name"								=>	"Show Log Preview Action in Notification",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationPreviewOnlyNew",
							"name"								=>	"Only show most recent new lines in preview",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationPreviewLineCount",
							"name"								=>	"Max line count for log preview",
							"type"								=>	"number"
						)
					),
					2									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationPreviewHideWidth",
							"name"								=>	"Hide if small screen width",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			5									=>	array(
				"bool"								=>	($notificationInlineShow == 'false'),
				"id"								=>	"notificationInlineSettings",
				"name"								=>	"Notification Inline Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideNotificationInlineSettings",
					"id"								=>	"notificationInlineShow",
					"key"								=>	"notificationInlineShow",
					"name"								=>	"Show Notification Dropdown Alert",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationInlineLocation",
							"name"								=>	"Location of notification",
							"options"							=>	array(
								0 									=> array(
									"value" 							=> "center",
									"name" 								=> "Center"),
								1 									=> array(
									"value" 							=> "topLeft",
									"name" 								=> "Top Left"),
								2									=> array(
									"value" 							=> "topRight",
									"name" 								=> "Top Right"),
								3									=> array(
									"value" 							=> "bottomLeft",
									"name" 								=> "Bottom Left"),
								4									=> array(
									"value" 							=> "bottomRight",
									"name" 								=> "Bottom Right")
							),
							"type"								=>	"dropdown"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationInlineButtonHover",
							"name"								=>	"Show action buttons only after hover",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					2									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationInlineDisplayTime",
							"name"								=>	"Show notification for ",
							"postText"							=>	" seconds",
							"type"								=>	"number"
						)
					),
					3									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationInlineBGColor",
							"name"								=>	"Background",
							"type"								=>	"color"
						)
					),
					4									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationInlineFontColor",
							"name"								=>	"Font",
							"type"								=>	"color"
						)
					),
				)
			),
		)
	),
"notificationTypes"					=>	array(
		"id"								=>	"settingsNotificationTypes",
		"name"								=>	"Notification Type Settings ",
		"menu"								=> 	array(
			"groups"							=>	array(
				"notifications"
			),
			"id"								=>	"settingsTypeNotifications",
			"display"							=>	true,
			"name"								=>	"Types"
		),
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
				"bool"								=>	($notificationNewLine == 'false'),
				"id"								=>	"notificationNewLineSettings",
				"name"								=>	"New Line Notification Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidenotificationNewLineSettings",
					"id"								=>	"notificationNewLine",
					"key"								=>	"notificationNewLine",
					"name"								=>	"Show New Line Notification",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationNewLineHighlight",
							"name"								=>	"Highlight Label",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationNewLineBadge",
							"name"								=>	"Update Badge",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					2									=> array(
						"info"								=>	"Will be overridden by show dropdown alert setting if false, wont if true",
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationNewLineDropdown",
							"name"								=>	"Show Dropdown",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			2									=>	array(
				"bool"								=>	($notificationNewLog == 'false'),
				"id"								=>	"notificationNewLogSettings",
				"name"								=>	"New Log Notification Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidenotificationNewLogSettings",
					"id"								=>	"notificationNewLog",
					"key"								=>	"notificationNewLog",
					"name"								=>	"Show New Log Notification",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationNewLogHighlight",
							"name"								=>	"Highlight Label",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationNewLogBadge",
							"name"								=>	"Update Badge",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					2									=> array(
						"info"								=>	"Will be overridden by show dropdown alert setting if false, wont if true",
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationNewLogDropdown",
							"name"								=>	"Show Dropdown",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					)
				)
			),
			3									=>	array(
				"info"								=>	"If a log tab is not visible (either below of above scroll area), a bar will flash as notification",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"offscreenLogNotify",
					"name"								=>	"Show notification for offscreen log tabs",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			)
		)
	),
	"oneLogVars"						=>	array(
		"id"								=>	"settingsOneLogVars",
		"name"								=>	"One Log Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"main"
			),
			"id"								=>	"settingsMainOneLog",
			"display"							=>	(!(in_array('oneLogEnable', $arrayOfDisabledModules))),
			"name"								=>	"One Log"
		),
		"vars"								=> array(
			0									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"oneLogVisible",
					"name"								=>	"One Log Visible",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			1									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"oneLogMaxLength",
					"name"								=>	"Max logs in one log",
					"options"							=>	$oneLogNum,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"bool"								=>	($oneLogCustomStyle == 'false'),
				"id"								=>	"oneLogNewBlockClickContentSettings",
				"name"								=>	"Custom Style for OneLog logs Settings",
				"info"								=>  "Refresh Required if change to false",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideOneLogCustomStyleSettings",
					"id"								=>	"oneLogCustomStyle",
					"key"								=>	"oneLogCustomStyle",
					"name"								=>	"Custom Style for OneLog logs",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"oneLogColorBG",
							"name"								=>	"Background",
							"type"								=>	"color"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"oneLogColorFont",
							"name"								=>	"Font",
							"type"								=>	"color"
						)
					)
				)
			),
			3									=> array(
				"info"								=>	"When one log is visible and open, log updates wont trigger notifactions or highlight the tab.",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"oneLogVisibleDisableUpdate",
					"name"								=>	"Hide update log notifications if one log visible",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			4									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"oneLogLogMaxHeight",
					"name"								=>	"Max height of log",
					"options"							=>	$oneLogLogMaxHeightArr,
					"type"								=>	"dropdown"
				)
			),
			5									=> array(
				"info"								=>	"when updating, if the last log is the same as the new log, it will merge the new lines into that box",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"oneLogMergeLast",
					"name"								=>	"Merge same last log on update",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			6									=> array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"oneLogHighlight",
					"name"								=>	"One Log Highlight",
					"options"							=>	array(
							0 									=> array(
								"value" 							=> "none",
								"name" 								=> "None"),
							1 									=> array(
								"value" 							=> "titleBar",
								"name" 								=> "Just Title Bar"),
							2									=> array(
								"value" 							=> "body",
								"name" 								=> "Just Body"),
							3									=> array(
								"value" 							=> "all",
								"name" 								=> "All")
						),
					"type"								=>	"dropdown"
				)
			),
			7									=>	array(
				"bool"								=>	($oneLogNewBlockClick == 'false'),
				"id"								=>	"oneLogNewBlockClickContentSettings",
				"info"								=>	"when clicking on a title in one log, it will attempt to open in a new block, not the same as onelog",
				"name"								=>	"One log open new log options",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideOneLogNewBlockClickSettings",
					"id"								=>	"oneLogNewBlockClick",
					"key"								=>	"oneLogNewBlockClick",
					"name"								=>	"New block on log click",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"oneLogNewBlockLocation",
							"name"								=>	"New Log Position",
							"options"							=>	array(
								0 									=> array(
									"value" 							=> "auto",
									"name" 								=> "Auto Left/Bottom"),
								1 									=> array(
									"value" 							=> "left",
									"name" 								=> "Always Left"),
								2 									=> array(
									"value" 							=> "bottom",
									"name" 								=> "Always Bottom")
							),
							"type"								=>	"dropdown"
						)
					)
				)
			),
			8									=> array(
				"info"								=>	"Clears data for one log when clicking clear all logs",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"oneLogAllLogClear",
					"name"								=>	"Clear onelog data on clear all log action",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
		)
	),
	"updateSettings"					=>	array(
		"id"								=>	"settingsMainVars",
		"name"								=>	"Update Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"main"
			),
			"id"								=>	"settingsMainOther",
			"display"							=>	(!(in_array('updaterEnabled', $arrayOfDisabledModules))),
			"name"								=>	"Update"
		),
		"vars"								=> array(
			0									=>	array(
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
		),
	),
	"pollVars"							=>	array(
		"id"								=>	"settingsPollVars",
		"name"								=>	"Poll Settings",
		"menu"								=> 	array(
			"groups"							=>	array(
				"main"
			),
			"id"								=>	"settingsMainPoll",
			"display"							=>	true,
			"name"								=>	"Poll"
		),
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
				"bool"								=>	($pollRefreshAllBool == 'false'),
				"id"								=>	"pollRefreshAllBoolSettings",
				"name"								=>	"Poll refresh all data",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidePollRefreshAllSettings",
					"id"								=>	"pollRefreshAllBool",
					"key"								=>	"pollRefreshAllBool",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown",
					"name"								=>	"Allow poll refresh all data"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"pollRefreshAll",
							"name"								=>	"Poll refresh all data every",
							"postText"							=>	"poll requests",
							"type"								=>	"number"
						)
					)
				)
			),
			8									=> array(
				"bool"								=>	($pollForceTrueBool == 'false'),
				"id"								=>	"PollForceTrueSettings",
				"name"								=>	"Poll force refresh",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidePollForceSettings",
					"id"								=>	"pollForceTrueBool",
					"key"								=>	"pollForceTrueBool",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown",
					"name"								=>	"Allow Force poll refresh"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"pollForceTrue",
							"name"								=>	"Force poll refresh after",
							"postText"							=>	"skipped poll requests",
							"type"								=>	"number"
						)
					)
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
		"menu"								=> 	array(
			"groups"							=>	array(
				"advanced"
			),
			"id"								=>	"settingsMainWatchlist",
			"display"							=>	true,
			"name"								=>	"Watchlist"
		),
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
					"info"								=>	"leave blank to not auto delete",
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

//Vars just needed for menu and not dynamically created like the above section
$customConfigSections = array(
	"colorScheme"	=> array(
		"id"	=> "settingsColorFolderGroupVars",
		"name"	=> "Log Tabs Color Scheme",
		"menu"								=> 	array(
			"groups"							=>	array(
				"style"
			),
			"id"								=>	"fullScreenMenuColorScheme",
			"display"							=>	true,
			"name"								=>	"Log Tabs Colors"
		)
	),
	"configStatic"	=> array(
		"id"	=> "devConfig",
		"name"	=> "Config Static",
		"menu"								=> 	array(
			"groups"							=>	array(
				"global"
			),
			"id"								=>	"settingsAdvancedDevConfig",
			"display"							=>	true,
			"name"								=>	"Config Static"
		)
	),
	"multiLogLogLayout"	=> array(
		"id"	=> "settingsInitialLoadLayoutVars",
		"name"	=> "Multi-Log Layout",
		"menu"								=> 	array(
			"groups"							=>	array(
				"multilog"
			),
			"id"								=>	"settingsMainLogLayout",
			"display"							=>	!(in_array('enableMultiLog', $arrayOfDisabledModules)),
			"name"								=>	"Multi-Log Layout"
		)
	)
);

//sort groups
foreach($fullScreenMenuGroups as $fsmgKey => $fsmgData)
{
	$fullScreenMenuGroups[$fsmgKey]["menu_items"] = array();
	foreach([$defaultConfigMoreData, $customConfigSections] as $settingsSectionsArray)
	{
		foreach($settingsSectionsArray as $settingsSectionKey => $settingsSectionsArrayRowData)
		{
			if([$fsmgKey] !== $settingsSectionsArrayRowData["menu"]["groups"])
			{
				continue;
			}
			$fullScreenMenuGroups[$fsmgKey]["menu_items"][$settingsSectionKey] = $settingsSectionsArrayRowData;
		}
	}
	ksort($fullScreenMenuGroups[$fsmgKey]["menu_items"]);
}
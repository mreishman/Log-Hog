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
for ($m=0; $m < 20; $m++)
{
	if($m >= 5)
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

	$oneLogLogMaxHeightArr[$m] = array(
			"value" 					=> (($m*15)+100),
			"name" 						=> (($m*15)+100)."px");
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

$sectionChoices = array(
	0 			=> 	array(
		"name" 		=> 'none',
		"value" 	=> 'none'),
	1 			=> 	array(
		"name" 		=> 'hh',
		"value" 	=> 'hh'),
	2 			=>	array(
		"name" 		=>	'mm',
		"value"		=>	'mm'),
	3			=>	array(
		"name"		=>	'ss',
		"value"		=>	'ss'),
	4			=>	array(
		"name"		=>	'DD',
		"value"		=>	'DD'),
	5			=>	array(
		"name" 		=>	'MM',
		"value"		=>	'MM'),
	6			=>	array(
		"name"		=>	'YYYY',
		"value"		=>	'YYYY'),
	7			=>	array(
		"name"		=>	'PartDay',
		"value"		=>	'PartDay'),
	8			=>	array(
		"name"		=>	'FullDay',
		"value"		=>	'FullDay'),
	9			=>	array(
		"name"		=>	'PartMonth',
		"value"		=>	'PartMonth'),
	10			=>	array(
		"name"		=>	'FullMonth',
		"value"		=>	'FullMonth'),
	11			=>	array(
		"name"		=>	'mili',
		"value"		=>	'mili'),
	12			=>	array(
		"name"		=>	'hh-12',
		"value"		=>	'hh12'),
	13			=>	array(
		"name"		=>	'AM/PM',
		"value"		=>	'AMPM')
	);

$delimiterChoices = array(
	0 			=> 	array(
		"name" 		=> 'none',
		"value" 	=> 'none',
		"checkValue"=> ''),
	1 			=>	array(
		"name" 		=>	'/',
		"value"		=>	'/'),
	2			=>	array(
		"name"		=>	'~',
		"value"		=>	'~'),
	3			=>	array(
		"name"		=>	'space',
		"value"		=>	'space',
		"value"		=>	' '),
	4			=>	array(
		"name" 		=>	'[',
		"value"		=>	'['),
	5			=>	array(
		"name"		=>	']',
		"value"		=>	']'),
	6			=>	array(
		"name"		=>	'(',
		"value"		=>	'('),
	7			=>	array(
		"name"		=>	')',
		"value"		=>	')'),
	8			=>	array(
		"name"		=>	'-',
		"value"		=>	'-'),
	9			=>	array(
		"name"		=>	':',
		"value"		=>	':'),
	10			=>	array(
		"name"		=>	'.',
		"value"		=>	'.'),
	11			=>	array(
		"name"		=>	',',
		"value"		=>	','),
	12			=>	array(
		"name"		=>	'+',
		"value"		=>	'+')
	);


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
	if($currentBracket !== "" && count($currentBracket) > 0)
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

$defaultConfigMoreData = array(
	"archive"							=>	array(
		"id"								=>	"archiveConfig",
		"name"								=>	"Archive",
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
					"key"								=>	"saveButtonAlwaysVisible",
					"name"								=>	"Force save button visibility",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"info"								=>	"This is for platforms where saving files might not be in sync with containers. Increasing from one will make saves take longer, but it will be more accurate if there is that sync delay",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"successVerifyNum",
					"name"								=>	"Save verification number",
					"options"							=>	$oneToFiveArr,
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
			)
		)
	),
	"generalThemeOptions"				=>	array(
		"id"								=>	"generalThemeOptions",
		"name"								=>	"Main Theme Options",
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"backgroundColor",
					"name"								=>	"Background",
					"type"								=>	"color"
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
					"type"								=>	"color"
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
			),
			7									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"backgroundHeaderColor",
					"name"								=>	"Header Background",
					"type"								=>	"color"
				)
			),
			8									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"invertMenuImages",
					"name"								=>	"Invert Header Images",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			9									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"overallBrightness",
					"name"								=>	"Overall Brightness",
					"options"							=>	$brightessVars,
					"type"								=>	"dropdown"
				)
			),
			10									=>	array(
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
			0									=>	array(
				"bool"								=>	($dateTextFormatEnable == 'false'),
				"id"								=>	"dateTextFormatEnableSettings",
				"name"								=>	"Log Date Text Format Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidedateTextFormatEnableSettings",
					"id"								=>	"dateTextFormatEnable",
					"key"								=>	"dateTextFormatEnable",
					"name"								=>	"Format Date Text",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
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
							"options"							=>	$dateFormatOptions,
							"type"								=>	"dropdown"
						),
						"vars"								=>	$customDateFormatVars
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"id"								=>	"dateTextFormatCustom",
							"key"								=>	"dateTextFormatCustom",
							"type"								=>	"hidden"
						)
					),
					2									=>	array(
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
					3									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"info"								=>	"Only displays top timestamp when more than one in a row are same",
							"key"								=>	"dateTextGroup",
							"name"								=>	"Group Same Timestamps",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
				)
			),
			4									=>	array(
				"bool"								=>	($logFormatFileEnable == 'false'),
				"id"								=>	"logFormatFileEnableSettings",
				"name"								=>	"Log File Link Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHidelogFormatFileEnableSettings",
					"id"								=>	"logFormatFileEnable",
					"key"								=>	"logFormatFileEnable",
					"name"								=>	"Link files in logs",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
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
				)
			),
			5									=>	array(
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
			6									=>	array(
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
			7									=>	array(
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
			8									=>	array(
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
				)
			),
			4									=>	array(
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
			5									=>	array(
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
			7									=>	array(
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
			3									=>	array(
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
			4									=>	array(
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
			5									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"hideEmptyLog",
					"name"								=>	"Hide logs that are empty",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			6									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"notificationCountVisible",
					"name"								=>	"Enable Log Diff Count",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			7									=>	array(
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
			8									=>	array(
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
			9									=>	array(
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
			10									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logNameExtension",
					"name"								=>	"Show Log Name Extension",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			11									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"logNameGroup",
					"name"								=>	"Show Log Name Group",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			12									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"addonsAsIframe",
					"name"								=>	"Addons as Iframe",
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
			14									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"allLogsVisible",
					"name"								=>	"Log tabs visible on load",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			15									=>	array(
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
							"value" 							=> "addons",
							"name" 								=> "Addons"),
						3 									=> array(
							"value" 							=> "history",
							"name" 								=> "History"),
						4 									=> array(
							"value" 							=> "notifications",
							"name" 								=> "Notifications"),
						5 									=> array(
							"value" 							=> "settings",
							"name" 								=> "Settings"),
						6 									=> array(
							"value" 							=> "themes",
							"name" 								=> "Themes"),
						7 									=> array(
							"value" 							=> "update",
							"name" 								=> "Update"),
						8 									=> array(
							"value" 							=> "watchlist",
							"name" 								=> "Watchlist")
					),
					"type"								=>	"dropdown"
				)
			),
		)
	),
	"modules"							=>	array(
		"id"								=>	"modules",
		"name"								=>	"Modules",
		"vars"								=>	array(
			0									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"developmentTabEnabled",
					"name"								=>	"Enable Development Tools",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			1									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"themesEnabled",
					"name"								=>	"Enable Themes",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			2									=>	array(
				"bool"								=>	($enableMultiLog == 'false'),
				"id"								=>	"enableMultiLogSettings",
				"name"								=>	"Multi-Log settings settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideenableMultiLog",
					"id"								=>	"enableMultiLog",
					"key"								=>	"enableMultiLog",
					"name"								=>	"Enable Multi-Log",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=>	array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"logLayoutSettingsInfo",
							"name"								=>	"Default show options for log layout settings",
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
					)
				)
			),
			3									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"enableHistory",
					"name"								=>	"Enable History",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			4									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"oneLogEnable",
					"name"								=>	"Enable One Log",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			5									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"filterEnabled",
					"name"								=>	"Enable Filters",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			6									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"rightClickMenuEnable",
					"name"								=>	"Enable Right Click Menu",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			7									=>	array(
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"advancedLogFormatEnabled",
					"name"								=>	"Enable Advanced Log Format Options",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			8									=>	array(
				"bool"								=>	($backupNumConfigEnabled == 'false'),
				"id"								=>	"versionSaveContentSettings",
				"name"								=>	"Backup Config Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideVersionSaveConfig",
					"id"								=>	"backupNumConfigEnabled",
					"key"								=>	"backupNumConfigEnabled",
					"name"								=>	"Enable Config Backup",
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
			)
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
				"info"								=>	"Button in header menu. Because this is the same as the settings button, this will be removed at some pont. Requires Refresh",
				"var"								=>	array(
					"key"								=>	"multiLogOnIndex",
					"name"								=>	"Enable tmp Multilog",
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
	"notificationVars"					=>	array(
		"id"								=>	"settingsNotificationVars",
		"name"								=>	"Notification Settings ",
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
			),
			4									=> array(
				"info"								=>	"Only shows count of notifications that were not viewed",
				"type"								=>	"single",
				"var"								=>	array(
					"key"								=>	"notificationCountViewedOnly",
					"name"								=>	"Notification Count only unviewed",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				)
			),
			5									=> array(
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
			6									=>	array(
				"bool"								=>	($notificationPreviewShow == 'false'),
				"id"								=>	"notificationPreviewSettings",
				"name"								=>	"Notification Log Preview Settings",
				"type"								=>	"grouped",
				"var"								=>	array(
					"function"							=>	"showOrHideNotificationPreviewSettings",
					"id"								=>	"notificationPreviewShow",
					"key"								=>	"notificationPreviewShow",
					"name"								=>	"Show Log Preview in Notification",
					"options"							=>	$trueFalsVars,
					"type"								=>	"dropdown"
				),
				"vars"								=>	array(
					0									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationPreviewHeight",
							"name"								=>	"Notification Log Preview Max Height",
							"options"							=>	$oneLogLogMaxHeightArr,
							"type"								=>	"dropdown"
						)
					),
					1									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationPreviewOnlyNew",
							"name"								=>	"Only show most recent new lines in preview",
							"options"							=>	$trueFalsVars,
							"type"								=>	"dropdown"
						)
					),
					2									=> array(
						"type"								=>	"single",
						"var"								=>	array(
							"key"								=>	"notificationPreviewLineCount",
							"name"								=>	"Max line count for log preview",
							"type"								=>	"number"
						)
					),
					3									=> array(
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
			7									=>	array(
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
	"oneLogVars"						=>	array(
		"id"								=>	"settingsOneLogVars",
		"name"								=>	"One Log Settings",
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
				"name"								=>	"One log open new log options",
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
	"otherVars"							=>	array(
		"id"								=>	"settingsMainVars",
		"name"								=>	"Other Settings",
		"vars"								=> array(
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
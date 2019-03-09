<?php

function forEachAddVars($variable)
{
	$returnText = "array(";
	foreach ($variable as $key => $value)
	{
		$returnText .= " '".$key."' => ";
		if(is_array($value) || is_object($value))
		{
			$returnText .= forEachAddVars($value);
		}
		else
		{
			$returnText .= "'".$value."',";
		}
	}
	$returnText .= "),";
	return $returnText;
}

function checkIfShouldLoad($loadCustomConfigVars, $key)
{
	if(!$loadCustomConfigVars)
	{
		$type = $_POST['resetConfigValuesBackToDefault'];
		if($type === "all")
		{
			return false;
		}

		if($type === "justWatch")
		{
			if($key === "watchList")
			{
				return false;
			}
			return true;
		}

		if($type === "allButWatch")
		{
			if($key !== "watchList")
			{
				return false;
			}
			return true;
		}
	}
	return true;
}

$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."error.php"))
{
  $varToIndexDir .= "../";
}

$baseUrl = $varToIndexDir."core/";
if(file_exists($varToIndexDir.'local/layout.php'))
{
  $baseUrl = $varToIndexDir."local/";
  //there is custom information, use this
  require_once($varToIndexDir.'local/layout.php');
  $baseUrl .= $currentSelectedTheme."/";
}
$boolForUpgrade = true;
if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($baseUrl.'conf/config.php');
}
else
{
	$config = array();
	$boolForUpgrade = false;
}
require_once($varToIndexDir.'core/conf/config.php');
$URI = $_SERVER['REQUEST_URI'];
if($boolForUpgrade && (strpos($URI, 'upgradeLayout') === false) && (strpos($URI, 'upgradeConfig') === false) && (strpos($URI, 'core/php/template/upgrade') === false) && (strpos($URI, 'upgradeTheme') === false) && (strpos($URI, 'themeChangeLogic') === false) && (strpos($URI, 'settingsSaveAjax') === false) && (strpos($URI, 'example') === false) && (strpos($URI, 'setup') === false)  && (strpos($URI, 'upgradeDelete') === false) && (strpos($URI, 'restore') === false))
{
	$themeVersion = 0;
	if(isset($config['themeVersion']))
	{
		$themeVersion = $config['themeVersion'];
	}
	if($themeVersion !== $defaultConfig['themeVersion'] || !is_file($baseUrl."/template/theme.css"))
	{
		//redirect to themeVersion upgrade script (copy over theme files to local)
		header("Location: ".$varToIndexDir."core/php/template/upgradeTheme.php");
		exit();

	}

	//check if upgrade script is needed
	$layoutVersion = 0;
	if(isset($config['layoutVersion']))
	{
		$layoutVersion = $config['layoutVersion'];
	}
	if($layoutVersion !== $defaultConfig['layoutVersion'])
	{
		//redirect to upgrade script for layoutVersion page
		header("Location: ".$varToIndexDir."core/php/template/upgradeLayout.php");
		exit();
	}

	$configVersion = 0;
	if(isset($config['configVersion']))
	{
		$configVersion = $config['configVersion'];
	}
	if($configVersion !== $defaultConfig['configVersion'])
	{
		//redirect to upgrade script for config page
		header("Location: ".$varToIndexDir."core/php/template/upgradeConfig.php");
		exit();
	}

	//check if any files need to be removed
	require_once($varToIndexDir."core/php/staticDeletedFiles.php");
	foreach ($arrayOfFilesDeleted as $fileOrFolder)
	{
		if(is_file($varToIndexDir.$fileOrFolder["fullPath"]))
		{
			header("Location: ".$varToIndexDir."core/php/template/upgradeDelete.php");
			exit();
		}
	}
}
//start loading vars
$loadCustomConfigVars = true;
if(isset($_POST['resetConfigValuesBackToDefault']))
{
	$loadCustomConfigVars = false;
}
$loadVarsArray = array();
foreach ($defaultConfig as $key => $value)
{
	$$key = $value;
	if(isset($_POST[$key]))
	{
		$$key = $_POST[$key];
	}
	elseif(array_key_exists($key, $config) && checkIfShouldLoad($loadCustomConfigVars, $key))
	{
		$$key = $config[$key];
	}
	elseif(isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings))
	{
		$$key = $themeDefaultSettings[$key];
	}
	$loadVarsArray[$key] = $$key;
}


foreach ($folderColorArrays as $key => $value)
{
	if($key == $currentFolderColorTheme)
	{
		$currentSelectedThemeColorValues = $value;
	}
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$arrayWatchList = "";
	if(isset($_POST['numberOfRows']))
	{
		$baseKeys = $defaultConfig["watchList"]["HHVM"];
		$baseKeysCount = count($baseKeys);
		for($i = 1; $i <= $_POST['numberOfRows']; $i++ )
		{
			$arrayWatchList .= "'".$_POST['watchListKey'.$i]."' => array(";
			$baseKeyCounter = 0;
			foreach ($baseKeys as $key => $value)
			{
				$baseKeyCounter++;
				$arrayWatchList .= "'".$key."' => '".$_POST['watchListKey'.$i.$key]."'";
				if($baseKeyCounter !== $baseKeysCount)
				{
					$arrayWatchList .= ",";
				}
			}
			$arrayWatchList .= ")";
			if($i != $_POST['numberOfRows'])
			{
				$arrayWatchList .= ",";
			}
		}
	}
	else
	{
		$numberOfRows = count($watchList);
		$i = 0;
		foreach ($watchList as $key => $value)
		{
			$i++;
			if(is_array($value))
			{
				$arrayWatchList .= "'".$key."' => array(";
				$numberOfRows2 = count($value);
				$j = 0;
				foreach ($value as $key2 => $value2)
				{
					$j++;
					$arrayWatchList .= "'".$key2."' => '".$value2."'";
					if($j != $numberOfRows2)
					{
						$arrayWatchList .= ",";
					}
				}
				$arrayWatchList .= ")";
			}
			else
			{
				$arrayWatchList .= "'".$key."' => '".$value."'";
			}
			if($i != $numberOfRows)
			{
				$arrayWatchList .= ",";
			}
		}
	}
	$watchList = $arrayWatchList;

	$folderColorArraysSave = "";
	if(isset($_POST['folderThemeCount']))
	{
		$intFolderThemeCount = intval($_POST['folderThemeCount']);
		for($i = 0; $i < $intFolderThemeCount; $i++ )
		{
			$folderColorArraysSave .= "'".$_POST['folderColorThemeNameForPost'.($i+1)]."'	=>	array(";

				//main
				$folderColorArraysSave .= " 'main' => array(";

					$colorCount = 0;
					while (isset($_POST['folderColorValueMainBackground'.($i+1).'-'.($colorCount+1)]))
					{
						$colorCount++;
						$folderColorArraysSave .= " 'main-".($colorCount)."' => array(";
						$folderColorArraysSave .= " 'background' => '".$_POST['folderColorValueMainBackground'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= " 'fontColor' => '".$_POST['folderColorValueMainFont'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= "),";
					}

				$folderColorArraysSave .= "),";

				//highlight
				$folderColorArraysSave .= " 'highlight' => array(";

					$colorCount = 0;
					while (isset($_POST['folderColorValueHighlightBackground'.($i+1).'-'.($colorCount+1)]))
					{
						$colorCount++;
						$folderColorArraysSave .= " 'highlight-".($colorCount)."' => array(";
						$folderColorArraysSave .= " 'background' => '".$_POST['folderColorValueHighlightBackground'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= " 'fontColor' => '".$_POST['folderColorValueHighlightFont'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= "),";
					}

				$folderColorArraysSave .= "),";

				//active
				$folderColorArraysSave .= " 'active' => array(";

					$colorCount = 0;
					while (isset($_POST['folderColorValueActiveBackground'.($i+1).'-'.($colorCount+1)]))
					{
						$colorCount++;
						$folderColorArraysSave .= " 'active-".($colorCount)."' => array(";
						$folderColorArraysSave .= " 'background' => '".$_POST['folderColorValueActiveBackground'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= " 'fontColor' => '".$_POST['folderColorValueActiveFont'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= "),";
					}

				$folderColorArraysSave .= "),";

				//highlightActive
				$folderColorArraysSave .= " 'highlightActive' => array(";

					$colorCount = 0;
					while (isset($_POST['folderColorValueActiveHighlightBackground'.($i+1).'-'.($colorCount+1)]))
					{
						$colorCount++;
						$folderColorArraysSave .= " 'highlightActive-".($colorCount)."' => array(";
						$folderColorArraysSave .= " 'background' => '".$_POST['folderColorValueActiveHighlightBackground'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= " 'fontColor' => '".$_POST['folderColorValueActiveHighlightFont'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= "),";
					}

				$folderColorArraysSave .= "),";

			$folderColorArraysSave .= "),";
		}
	}
	else
	{
		foreach ($folderColorArrays as $key => $value)
		{
			$folderColorArraysSave .= "'".$key."'	=>	";
			$folderColorArraysSave .= forEachAddVars($value);
		}
	}
	$folderColorArrays = $folderColorArraysSave;


	$arrayLogLoadLayout = "";
	if(isset($_POST['logLoad1x1-0-A']))
	{
		$counterOne = 1;
		$counterTwo = 1;
		$windowCounter = 0;
		$arrayOfLetters = array(1 => "A", 2 => "B", 3 => "C", 4 => "D", 5 => "E", 6 => "F", 7 => "G");
		$letterCounter = 1;
		while (isset($_POST["logLoad".$counterOne."x".$counterTwo."-".$windowCounter."-".$arrayOfLetters[$letterCounter]]))
		{
			while (isset($_POST["logLoad".$counterOne."x".$counterTwo."-".$windowCounter."-".$arrayOfLetters[$letterCounter]]))
			{
				$arrayLogLoadLayout .= "'".$counterOne."x".$counterTwo."' => array(";
				while (isset($_POST["logLoad".$counterOne."x".$counterTwo."-".$windowCounter."-".$arrayOfLetters[$letterCounter]]))
				{
					$arrayLogLoadLayout .= "".$windowCounter." => array(";
					while (isset($_POST["logLoad".$counterOne."x".$counterTwo."-".$windowCounter."-".$arrayOfLetters[$letterCounter]]))
					{
						$arrayLogLoadLayout .= "'".$arrayOfLetters[$letterCounter]."' => '".$_POST["logLoad".$counterOne."x".$counterTwo."-".$windowCounter."-".$arrayOfLetters[$letterCounter]]."',";
						$letterCounter++;
					}
					$arrayLogLoadLayout .= "),";
					$letterCounter = 1;
					$windowCounter++;
				}
				$arrayLogLoadLayout .= "),";
				$windowCounter = 0;
				$counterTwo++;
			}
			$counterTwo = 1;
			$counterOne++;
		}
	}
	else
	{
		foreach ($logLoadLayout as $key => $value)
		{
			$arrayLogLoadLayout .= "'".$key."'	=>	";
			$arrayLogLoadLayout .= forEachAddVars($value);
		}
	}
	$logLoadLayout = $arrayLogLoadLayout ;
}
else
{
	// Image Vars

	$arrayOfImages = array(
		"addons"			=> array(
			"alt"			=>	"Addons",
			"src"			=>	"",
			"title"			=>	"Addons",
			"baseName"		=>	"addon.png"
		),
		"backArrow"			=> array(
			"alt"			=>	"Back",
			"src"			=>	"",
			"title"			=>	"Back",
			"baseName"		=>	"backArrow.png"
		),
		"close"				=> array(
			"alt"			=>	"Close",
			"src"			=>	"",
			"title"			=>	"Close",
			"baseName"		=>	"close.png"
		),
		"downArrowSideBar"	=> array(
			"alt"			=>	"Down",
			"src"			=>	"",
			"title"			=>	"Scroll To Bottom",
			"baseName"		=>	"downArrowSideBar.png"
		),
		"eraser"			=> array(
			"alt"			=>	"Clear",
			"src"			=>	"",
			"title"			=>	"Clear",
			"baseName"		=>	"eraser.png"
		),
		"eraserMulti"			=> array(
			"alt"			=>	"Clear All",
			"src"			=>	"",
			"title"			=>	"Clear All",
			"baseName"		=>	"eraserMulti.png"
		),
		"eraserSideBar"		=> array(
			"alt"			=>	"Clear",
			"src"			=>	"",
			"title"			=>	"Clear",
			"baseName"		=>	"eraserSideBar.png"
		),
		"externalLink"		=> array(
			"alt"			=>	"External Link",
			"src"			=>	"",
			"title"			=>	"External Link",
			"baseName"		=>	"externalLink.png"
		),
		"fileIcon"			=> array(
			"alt"			=>	"File",
			"src"			=>	"",
			"title"			=>	"File",
			"baseName"		=>	"fileIcon.png"
		),
		"fileIconNW"		=> array(
			"alt"			=>	"File Not Writeable",
			"src"			=>	"",
			"title"			=>	"File Not Writeable",
			"baseName"		=>	"fileIconNW.png"
		),
		"fileIconNR"		=> array(
			"alt"			=>	"File Not Readable",
			"src"			=>	"",
			"title"			=>	"File Not Readable",
			"baseName"		=>	"fileIconNR.png"
		),
		"filter"			=> array(
			"alt"			=>	"Filter",
			"src"			=>	"",
			"title"			=>	"Filter",
			"baseName"		=>	"filter.png"
		),
		"folderIcon"		=> array(
			"alt"			=>	"Folder",
			"src"			=>	"",
			"title"			=>	"Folder",
			"baseName"		=>	"folderIcon.png"
		),
		"folderIconNR"		=> array(
			"alt"			=>	"Folder Not Readable",
			"src"			=>	"",
			"title"			=>	"Folder Not Readable",
			"baseName"		=>	"folderIconNR.png"
		),
		"folderIconNW"		=> array(
			"alt"			=>	"Folder Not Writeable",
			"src"			=>	"",
			"title"			=>	"Folder Not Writeable",
			"baseName"		=>	"folderIconNW.png"
		),
		"gear"				=> array(
			"alt"			=>	"Settings",
			"src"			=>	"",
			"title"			=>	"Settings",
			"baseName"		=>	"Gear.png"
		),
		"gitStatus"			=> array(
			"alt"			=> "gitStatus",
			'src'			=> "",
			"title"			=> "gitStatus",
			"baseName"		=> 'gitStatus.png'
		),
		"greenCheck"		=> array(
			"alt"			=>	"Ok",
			"src"			=>	"",
			"title"			=>	"Ok!",
			"baseName"		=>	"greenCheck.png"
		),
		"history"			=> array(
			"alt"			=>	"History",
			"src"			=>	"",
			"title"			=>	"History",
			"baseName"		=>	"history.png"
		),
		"historySideBar"	=> array(
			"alt"			=>	"History",
			"src"			=>	"",
			"title"			=>	"History",
			"baseName"		=>	"historySideBar.png"
		),
		"info"			=> array(
			"alt"			=>	"Info",
			"src"			=>	"",
			"title"			=>	"Info",
			"baseName"		=>	"info.png"
		),
		"infoSideBar"		=> array(
			"alt"			=>	"Info",
			"src"			=>	"",
			"title"			=>	"Info",
			"baseName"		=>	"infoSideBar.png"
		),
		"loading"			=> array(
			"alt"			=>	"Loading",
			"src"			=>	"",
			"title"			=>	"Loading...",
			"baseName"		=>	"loading.gif"
		),
		"loadingImg"		=> array(
			"alt"			=>	"Loading",
			"src"			=>	"",
			"title"			=>	"Loading...",
			"baseName"		=>	"loading.gif"
		),
		"menu"	=> array(
			"alt"			=>	"Menu",
			"src"			=>	"",
			"title"			=>	"Menu",
			"baseName"		=>	"menu.png"
		),
		"menuSideBar"	=> array(
			"alt"			=>	"Menu",
			"src"			=>	"",
			"title"			=>	"Menu",
			"baseName"		=>	"menuSideBar.png"
		),
		"multiLog"	=> array(
			"alt"			=>	"Multi-Log",
			"src"			=>	"",
			"title"			=>	"Multi-Log",
			"baseName"		=>	"multiLog.png"
		),
		"notification"	=> array(
			"alt"			=>	"Notifications",
			"src"			=>	"",
			"title"			=>	"Notifications",
			"baseName"		=>	"notification.png"
		),
		"notificationClear"	=> array(
			"alt"			=>	"Clear Notifications",
			"src"			=>	"",
			"title"			=>	"Clear Notifications",
			"baseName"		=>	"notificationClear.png"
		),
		"notificationFull"	=> array(
			"alt"			=>	"Notifications",
			"src"			=>	"",
			"title"			=>	"Notifications",
			"baseName"		=>	"notificationFull.png"
		),
		"pause"			=> array(
			"alt"			=>	"Pause",
			"src"			=>	"",
			"title"			=>	"Pause",
			"baseName"		=>	"Pause.png"
		),
		"pin"				=> array(
			"alt"			=>	"Pin",
			"src"			=>	"",
			"title"			=>	"Pin",
			"baseName"		=>	"pin.png"
		),
		"pinPinned"			=> array(
			"alt"			=>	"Pin",
			"src"			=>	"",
			"title"			=>	"Pin",
			"baseName"		=>	"pinPinned.png"
		),
		"play"			=> array(
			"alt"			=>	"Play",
			"src"			=>	"",
			"title"			=>	"Play",
			"baseName"		=>	"Play.png"
		),
		"redWarning"		=> array(
			"alt"			=>	"Warning!",
			"src"			=>	"",
			"title"			=>	"Warning!!",
			"baseName"		=>	"redWarning.png"
		),
		"refresh"			=> array(
			"alt"			=>	"Refresh",
			"src"			=>	"",
			"title"			=>	"Refresh",
			"baseName"		=>	"Refresh.png"
		),
		"saveSideBar"		=> array(
			"alt"			=>	"Save",
			"src"			=>	"",
			"title"			=>	"Save",
			"baseName"		=>	"saveSideBar.png"
		),
		"search"			=> array(
			"alt"			=>	"Search",
			"src"			=>	"",
			"title"			=>	"Search",
			"baseName"		=>	"search.png"
		),
		"searchSideBar"		=> array(
			"alt"			=>	"Search",
			"src"			=>	"",
			"title"			=>	"Search",
			"baseName"		=>	"searchSideBar.png"
		),
		"seleniumMonitor"	=> array(
			"alt"			=>	"Selenium Monitor",
			"src"			=>	"",
			"title"			=>	"Selenium Monitor",
			"baseName"		=>	"seleniumMonitor.png"
		),
		"taskManager"		=> array(
			"alt"			=>	"TaskManager",
			"src"			=>	"",
			"title"			=>	"TaskManager",
			"baseName"		=>	"task-manager.png"
		),
		"theme"				=> array(
			"alt"			=>	"Themes",
			"src"			=>	"",
			"title"			=>	"Themes",
			"baseName"		=>	"theme.png"
		),
		"trashCan"			=> array(
			"alt"			=>	"Delete",
			"src"			=>	"",
			"title"			=>	"Delete",
			"baseName"		=>	"trashCan.png"
		),
		"trashCanMulti"			=> array(
			"alt"			=>	"Delete Multiple",
			"src"			=>	"",
			"title"			=>	"Delete Multiple",
			"baseName"		=>	"trashCanMulti.png"
		),
		"trashCanSideBar"	=> array(
			"alt"			=>	"Delete",
			"src"			=>	"",
			"title"			=>	"Delete",
			"baseName"		=>	"trashCanSideBar.png"
		),
		"updateYellow"		=> array(
			"alt"			=>	"Update",
			"src"			=>	"",
			"title"			=>	"Update",
			"baseName"		=>	"updateYellow.png"
		),
		"updateRed"		=> array(
			"alt"			=>	"Update",
			"src"			=>	"",
			"title"			=>	"Update",
			"baseName"		=>	"updateRed.png"
		),
		"watchList"	=> array(
			"alt"			=>	"Watch List",
			"src"			=>	"",
			"title"			=>	"WatchList",
			"baseName"		=>	"watchlist.png"
		),
		"yellowWarning"		=> array(
			"alt"			=>	"Notice",
			"src"			=>	"",
			"title"			=>	"Notice!",
			"baseName"		=>	"yellowWarning.png"
		)
	);



	foreach ($arrayOfImages as $key => $value)
	{
		$src = "core/img/".$value["baseName"];

		if(file_exists($varToIndexDir."local/".$currentSelectedTheme."/img/".$value["baseName"]))
		{
			//check for local version
			$src = "local/".$currentSelectedTheme."/img/".$value["baseName"];
		}
		elseif(file_exists($varToIndexDir."local/Themes/".$currentTheme."/img/".$value["baseName"]))
		{
			//check for current theme in local
			$src = "local/Themes/".$currentTheme."/img/".$value["baseName"];
		}
		elseif(file_exists($varToIndexDir."core/Themes/".$currentTheme."/img/".$value["baseName"]))
		{
			//check for current theme in core
			$src = "core/Themes/".$currentTheme."/img/".$value["baseName"];
		}
		elseif(file_exists($varToIndexDir."core/Themes/".$currentThemeBase."/img/".$value["baseName"]))
		{
			//check for base theme
			$src = "core/Themes/".$currentThemeBase."/img/".$value["baseName"];
		}

		$arrayOfImages[$key]["src"] = $src;
	}

	echo "<script>";
	echo "var successVerifyNum = ".$successVerifyNum.";";
	echo "var arrayOfImages = ".json_encode($arrayOfImages);
	echo "</script>";

	$loadingBarStyle = "";

	$loadingBarDefaultWidth = "data-stroke-width=\"3\" data-stroke-trail-width=\"3\"";

	if($loadingBarVersion === 1)
	{
		$loadingBarStyle = "data-type=\"stroke\" data-stroke=\"".$currentSelectedThemeColorValues['main']['main-2']['background']."\" data-stroke-trail=\"".$currentSelectedThemeColorValues['main']['main-1']['background']."\" ".$loadingBarDefaultWidth;
	}
	elseif($loadingBarVersion === 2)
	{
		$loadingBarStyle = "data-type=\"stroke\" data-stroke=\"data:ldbar/res,stripe(#fff,#4fb3f0,1)\" data-stroke-trail=\"#082a36\" data-pattern-size=\"10\" ".$loadingBarDefaultWidth;
	}
	elseif($loadingBarVersion === 3)
	{
		$loadingBarStyle = "data-type=\"stroke\" data-stroke=\"data:ldbar/res,gradient(0,1,#3E8486,#A5F1F1)\" data-stroke-trail=\"#082a36\" ".$loadingBarDefaultWidth;
	}
	elseif($loadingBarVersion === 4)
	{
		$loadingBarStyle = "data-type=\"stroke\"  data-stroke=\"data:ldbar/res,bubble(#248,#fff,50,1)\" data-stroke-trail=\"#082a36\" data-pattern-size=\"10\" ".$loadingBarDefaultWidth;
	}
	elseif($loadingBarVersion === 5)
	{
		$loadingBarStyle = "data-type=\"stroke\" data-stroke=\"green\" data-stroke-trail=\"#063305\" "."data-stroke-width=\"3\" data-stroke-trail-width=\"1\"";
	}
	elseif($loadingBarVersion === 6)
	{
		$loadingBarStyle = "data-type=\"stroke\"  data-stroke=\"data:ldbar/res,bubble(#ffae42,#000,50,2)\" data-stroke-trail=\"#924012\" data-pattern-size=\"20\" ".$loadingBarDefaultWidth;
	}

	$trueFalsVars = array(
		0 					=> array(
			"value" 			=> "true",
			"name" 				=> "True"),
		1 					=> array(
			"value" 			=> "false",
			"name" 				=> "False")
	);
}

$arrayOfCustomConfig = array(
	'themeVersion' => 1,
	'layoutVersion'	=> 1,
	'cssVersion'	=> 1,
	'configVersion'	=> 1
);
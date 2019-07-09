<?php

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
require_once($varToIndexDir."core/php/class/vars.php");
$vars = new vars();
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
	$jsonFiles = file_get_contents($varToIndexDir."core/json/staticDeletedFiles.json");
	$arrayOfFilesDeleted = json_decode($jsonFiles, true);
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
	elseif(array_key_exists($key, $config) && $vars->checkIfShouldLoad($loadCustomConfigVars, $key))
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
			$arrayWatchList .= "'".$vars->escapeTheEscapes($_POST['watchListKey'.$i])."' => array(";
			$baseKeyCounter = 0;
			foreach ($baseKeys as $key => $value)
			{
				$baseKeyCounter++;
				$arrayWatchList .= "'".$key."' => '".$vars->escapeTheEscapes($_POST['watchListKey'.$i.$key])."'";
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
			$folderColorArraysSave .= $vars->forEachAddVars($value);
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
			$arrayLogLoadLayout .= $vars->forEachAddVars($value);
		}
	}
	$logLoadLayout = $arrayLogLoadLayout ;
}
else
{
	// Image Vars

	$jsonImages = file_get_contents($varToIndexDir."core/json/images.json");
	$arrayOfImages = json_decode($jsonImages, true);


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
		$arrayOfImages[$key]["version"] = $cssVersion;
	}

	echo "<script>";
	echo "var successVerifyNum = ".$successVerifyNum.";";
	echo "var arrayOfImages = ".json_encode($arrayOfImages);
	echo "</script>";

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
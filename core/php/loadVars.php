<?php

require_once('verifyWriteStatus.php');
checkForUpdate($_SERVER['REQUEST_URI']);

//check for previous update, if failed

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
require_once($baseUrl.'conf/config.php'); 
require_once($varToIndexDir.'core/conf/config.php');


if(array_key_exists('watchList', $config))
{
	$watchList = $config['watchList'];
}
else
{
	$watchList = $defaultConfig['watchList'];
}
if(isset($_POST['sliceSize']))
{
	$sliceSize = $_POST['sliceSize'];
}
elseif(array_key_exists('sliceSize', $config))
{
	$sliceSize = $config['sliceSize'];
}
else
{
	$sliceSize = $defaultConfig['sliceSize'];
} 
if(isset($_POST['pollingRate']))
{
	$pollingRate = $_POST['pollingRate'];
}
elseif(array_key_exists('pollingRate', $config))
{
	$pollingRate = $config['pollingRate'];
}
else
{
	$pollingRate = $defaultConfig['pollingRate'];
} 
if(isset($_POST['pausePoll']))
{
	$pausePoll = $_POST['pausePoll'];
}
elseif(array_key_exists('pausePoll', $config))
{
	$pausePoll = $config['pausePoll'];
}
else
{
	$pausePoll = $defaultConfig['pausePoll'];
}
if(isset($_POST['pauseOnNotFocus']))
{
	$pauseOnNotFocus = $_POST['pauseOnNotFocus'];
}
elseif(array_key_exists('pauseOnNotFocus', $config))
{
	$pauseOnNotFocus = $config['pauseOnNotFocus'];
}
else
{
	$pauseOnNotFocus = $defaultConfig['pauseOnNotFocus'];
}
if(isset($_POST['autoCheckUpdate']))
{
	$autoCheckUpdate = $_POST['autoCheckUpdate'];
}
elseif(array_key_exists('autoCheckUpdate', $config))
{
	$autoCheckUpdate = $config['autoCheckUpdate'];
}
else
{
	$autoCheckUpdate = $defaultConfig['autoCheckUpdate'];
}
if(isset($_POST['developmentTabEnabled']))
{
	$developmentTabEnabled = $_POST['developmentTabEnabled'];
}
elseif(array_key_exists('developmentTabEnabled', $config))
{
	$developmentTabEnabled = $config['developmentTabEnabled'];
}
else
{
	$developmentTabEnabled = $defaultConfig['developmentTabEnabled'];
}
if(isset($_POST['enableDevBranchDownload']))
{
	$enableDevBranchDownload = $_POST['enableDevBranchDownload'];
}
elseif(array_key_exists('enableDevBranchDownload', $config))
{
	$enableDevBranchDownload = $config['enableDevBranchDownload'];
}
else
{
	$enableDevBranchDownload = $defaultConfig['enableDevBranchDownload'];
}
if(isset($_POST['truncateLog']))
{
	$truncateLog = $_POST['truncateLog'];
}
elseif(array_key_exists('truncateLogButtonAll', $config))
{
	$truncateLog = $config['truncateLogButtonAll'];
}
else
{
	$truncateLog = $defaultConfig['truncateLogButtonAll'];
}
if(isset($_POST['popupWarnings']))
{
	$popupWarnings = $_POST['popupWarnings'];
}
elseif(array_key_exists('popupSettings', $config))
{
	$popupWarnings = $config['popupSettings'];
}
else
{
	$popupWarnings = $defaultConfig['popupSettings'];
}
if(array_key_exists('expSettingsAvail', $config))
{
	$expSettingsAvail = $config['expSettingsAvail'];
}
else
{
	$expSettingsAvail = $defaultConfig['expSettingsAvail'];
}
if(isset($_POST['flashTitleUpdateLog']))
{
	$flashTitleUpdateLog = $_POST['flashTitleUpdateLog'];
}
elseif(array_key_exists('flashTitleUpdateLog', $config))
{
	$flashTitleUpdateLog = $config['flashTitleUpdateLog'];
}
else
{
	$flashTitleUpdateLog = $defaultConfig['flashTitleUpdateLog'];
}
if(isset($_POST['enableSystemPrefShellOrPhp']))
{
	$enableSystemPrefShellOrPhp = $_POST['enableSystemPrefShellOrPhp'];
}
elseif(array_key_exists('enableSystemPrefShellOrPhp', $config))
{
	$enableSystemPrefShellOrPhp = $config['enableSystemPrefShellOrPhp'];
}
else
{
	$enableSystemPrefShellOrPhp = $defaultConfig['enableSystemPrefShellOrPhp'];
}
if(array_key_exists('popupSettingsCustom', $config))
{
	$popupSettingsArray = $config['popupSettingsCustom'];
}
else
{
	$popupSettingsArray = $defaultConfig['popupSettingsCustom'];
}
if(isset($_POST['pollingRateType']))
{
	$pollingRateType = $_POST['pollingRateType'];
}
elseif(array_key_exists('pollingRateType', $config))
{
	$pollingRateType = $config['pollingRateType'];
}
else
{
	$pollingRateType = $defaultConfig['pollingRateType'];
}
if(isset($_POST['autoCheckDaysUpdate']))
{
	$autoCheckDaysUpdate = $_POST['autoCheckDaysUpdate'];
}
elseif(array_key_exists('autoCheckDaysUpdate', $config))
{
	$autoCheckDaysUpdate = $config['autoCheckDaysUpdate'];
}
else
{
	$polliautoCheckDaysUpdatengRateType = $defaultConfig['autoCheckDaysUpdate'];
}
if(isset($_POST['enableHtopLink']))
{
	$enableHtopLink = $_POST['enableHtopLink'];
}
elseif(array_key_exists('enableHtopLink', $config))
{
	$enableHtopLink = $config['enableHtopLink'];
}
else
{
	$enableHtopLink = $defaultConfig['enableHtopLink'];
}
if(isset($_POST['logTrimOn']))
{
	$logTrimOn = $_POST['logTrimOn'];
}
elseif(array_key_exists('logTrimOn', $config))
{
	$logTrimOn = $config['logTrimOn'];
}
else
{
	$logTrimOn = $defaultConfig['logTrimOn'];
}
if(isset($_POST['logSizeLimit']))
{
	$logSizeLimit = $_POST['logSizeLimit'];
}
elseif(array_key_exists('logSizeLimit', $config))
{
	$logSizeLimit = $config['logSizeLimit'];
}
else
{
	$logSizeLimit = $defaultConfig['logSizeLimit'];
}
if(isset($_POST['logTrimMacBSD']))
{
	$logTrimMacBSD = $_POST['logTrimMacBSD'];
}
elseif(array_key_exists('logTrimMacBSD', $config))
{
	$logTrimMacBSD = $config['logTrimMacBSD'];
}
else
{
	$logTrimMacBSD = $defaultConfig['logTrimMacBSD'];
}
if(isset($_POST['baseUrlUpdate']))
{
	$baseUrlUpdate = $_POST['baseUrlUpdate'];
}
elseif(array_key_exists('baseUrlUpdate', $config))
{
	$baseUrlUpdate = $config['baseUrlUpdate'];
}
else
{
	$baseUrlUpdate = $defaultConfig['baseUrlUpdate'];
}
if(isset($_POST['logTrimType']))
{
	$logTrimType = $_POST['logTrimType'];
}
elseif(array_key_exists('logTrimType', $config))
{
	$logTrimType = $config['logTrimType'];
}
else
{
	$logTrimType = $defaultConfig['logTrimType'];
}
if(isset($_POST['TrimSize']))
{
	$TrimSize = $_POST['TrimSize'];
}
elseif(array_key_exists('TrimSize', $config))
{
	$TrimSize = $config['TrimSize'];
}
else
{
	$TrimSize = $defaultConfig['TrimSize'];
}
if(isset($_POST['groupByColorEnabled']))
{
	$groupByColorEnabled = $_POST['groupByColorEnabled'];
}
elseif(array_key_exists('groupByColorEnabled', $config))
{
	$groupByColorEnabled = $config['groupByColorEnabled'];
}
else
{
	$groupByColorEnabled = $defaultConfig['groupByColorEnabled'];
}
if(array_key_exists('folderColorArrays', $config))
{
	$folderColorArrays = $config['folderColorArrays'];
}
else
{
	$folderColorArrays = $defaultConfig['folderColorArrays'];
}
if(isset($_POST['currentFolderColorTheme']))
{
	$currentFolderColorTheme = $_POST['currentFolderColorTheme'];
}
elseif(array_key_exists('currentFolderColorTheme', $config))
{
	$currentFolderColorTheme = $config['currentFolderColorTheme'];
}
else
{
	$currentFolderColorTheme = $defaultConfig['currentFolderColorTheme'];
}





$arrayWatchList = "";
if(isset($_POST['numberOfRows']))
{
	for($i = 1; $i <= $_POST['numberOfRows']; $i++ )
	{
		$arrayWatchList .= "'".$_POST['watchListKey'.$i]."' => '".$_POST['watchListItem'.$i]."'";
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
		$arrayWatchList .= "'".$key."' => '".$value."'";
		if($i != $numberOfRows)
		{
			$arrayWatchList .= ",";
		}
	}
}

$popupSettingsArraySave = "";
if($popupWarnings == "all")
{
	$popupSettingsArraySave = "
		'saveSettings'	=>	'true',
		'blankFolder'	=>	'true',
		'deleteLog'	=>	'true',
		'removeFolder'	=> 	'true'
		";
}
elseif($popupWarnings == "none")
{
	$popupSettingsArraySave = "
		'saveSettings'	=>	'false',
		'blankFolder'	=>	'false',
		'deleteLog'	=>	'false',
		'removeFolder'	=> 	'false'
		";
}
else
{
	if(isset($_POST['saveSettings']))
	{
		$popupSettingsArraySave = "
		'saveSettings'	=>	'".$_POST['saveSettings']."',
		'blankFolder'	=>	'".$_POST['blankFolder']."',
		'deleteLog'	=>	'".$_POST['deleteLog']."',
		'removeFolder'	=> 	'".$_POST['removeFolder']."'
		";
	}
	else
	{
		$popupSettingsArraySave = "";
		$count = 0;
		foreach ($popupSettingsArray as $key => $value)
		{
			$popupSettingsArraySave .= "'".$key."'	=>	'".$value."'";
			$count++;
			if($count != 3)
			{
				$popupSettingsArraySave .= ",";
			}
		}
	}
}

?>
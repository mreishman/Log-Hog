<?php

require_once('verifyWriteStatus.php');
checkForUpdate($_SERVER['REQUEST_URI']);

//check for previous update, if failed

$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
  $baseUrl = "../../local/";
  //there is custom information, use this
  require_once('../../local/layout.php');
  $baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('../conf/config.php');


if(array_key_exists('watchList', $config))
{
	$watchList = $config['watchList'];
}
else
{
	$watchList = $defaultConfig['watchList'];
}
if(array_key_exists('sliceSize', $config))
{
	$sliceSize = $config['sliceSize'];
}
else
{
	$sliceSize = $defaultConfig['sliceSize'];
} 
if(array_key_exists('pollingRate', $config))
{
	$pollingRate = $config['pollingRate'];
}
else
{
	$pollingRate = $defaultConfig['pollingRate'];
} 
if(array_key_exists('pausePoll', $config))
{
	$pausePoll = $config['pausePoll'];
}
else
{
	$pausePoll = $defaultConfig['pausePoll'];
}
if(array_key_exists('pauseOnNotFocus', $config))
{
	$pauseOnNotFocus = $config['pauseOnNotFocus'];
}
else
{
	$pauseOnNotFocus = $defaultConfig['pauseOnNotFocus'];
}
if(array_key_exists('autoCheckUpdate', $config))
{
	$autoCheckUpdate = $config['autoCheckUpdate'];
}
else
{
	$autoCheckUpdate = $defaultConfig['autoCheckUpdate'];
}
if(array_key_exists('developmentTabEnabled', $config))
{
	$developmentTabEnabled = $config['developmentTabEnabled'];
}
else
{
	$developmentTabEnabled = $defaultConfig['developmentTabEnabled'];
}
if(array_key_exists('enableDevBranchDownload', $config))
{
	$enableDevBranchDownload = $config['enableDevBranchDownload'];
}
else
{
	$enableDevBranchDownload = $defaultConfig['enableDevBranchDownload'];
}

$arrayWatchList = "";
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



?>
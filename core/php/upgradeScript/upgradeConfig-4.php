<?php
require_once("../class/core.php");
$core = new core();
require_once("../class/upgrade.php");
$upgrade = new upgrade();
require_once("../class/session.php");
$session = new session();
$session->startSession();
$baseBaseUrl = $core->baseURL();
$baseUrl = $baseBaseUrl."local/";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl .= $currentSelectedTheme."/";
include($baseUrl.'conf/config.php');
include($baseBaseUrl.'core/conf/config.php');
$watchlist = $defaultConfig["watchList"];
$arrayForNewStuff = array(
	"configVersion" => (Int)$_POST['version']
);
$alreadyRan = false;
if (isset($config["watchList"]))
{
	$watchlist = $config["watchList"];
	$arrayWatchList = "";
	$countOfWatchlist = count($watchlist);
	$count = 0;
	foreach ($watchlist as $key => $value)
	{
		$count++;
		if(!isset($value["grepFilter"]))
		{
			$arrayWatchList .= "'".$key."' => array(";
			$arrayWatchList .= "'AlertEnabled' => '".$value["AlertEnabled"]."',";
			$arrayWatchList .= "'AutoDeleteFiles' => '".$value["AutoDeleteFiles"]."',";
			$arrayWatchList .= "'ExcludeTrim' => '".$value["ExcludeTrim"]."',";
			$arrayWatchList .= "'FileInformation' => '".$value["FileInformation"]."',";
			$arrayWatchList .= "'FileType' => '".$value["FileType"]."',";
			$arrayWatchList .= "'GrepFilter' => '',";
			$arrayWatchList .= "'Group' => '".$value["Group"]."',";
			$arrayWatchList .= "'Location' => '".$value["Location"]."',";
			$arrayWatchList .= "'Name' => '".$value["Name"]."',";
			$arrayWatchList .= "'Pattern' => '".$value["Pattern"]."',";
			$arrayWatchList .= "'Recursive' => '".$value["Recursive"]."',";
			$arrayWatchList .= "'SaveGroup' => 'false',";
			$arrayWatchList .= ")";
			if($count != $countOfWatchlist)
			{
				$arrayWatchList .= ",";
			}
		}
		else
		{
			$alreadyRan = true;
			break;
		}
	}
	$arrayForNewStuff["watchList"] = $arrayWatchList;
}
if($alreadyRan)
{
	$arrayForNewStuff = array(
		"configVersion" => (Int)$_POST['version']
	);
}
$upgrade->upgradeConfig($arrayForNewStuff);
echo json_encode($_POST['version']);
<?php
require_once("../commonFunctions.php");
$baseBaseUrl = baseURL();
$baseUrl = $baseBaseUrl."local/";
include($baseUrl.'layout.php');
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
		if(!is_array($value))
		{
			$arrayWatchList .= "'".$key."' => array(";
			$arrayWatchList .= "'AutoDeleteFiles' => '',";
			$arrayWatchList .= "'ExcludeTrim' => 'false',";
			$arrayWatchList .= "'FileType' => 'auto',";
			$arrayWatchList .= "'Group' => '',";
			$arrayWatchList .= "'Location' => '".$key."',";
			$arrayWatchList .= "'Pattern' => '".$value."'";
			$arrayWatchList .= "'Recursive' => 'false'";
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
upgradeConfig($arrayForNewStuff);
echo json_encode($_POST['version']); 
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
if (isset($config["watchList"]))
{
	$watchlist = $config["watchList"];
	$arrayWatchList = "";
	$countOfWatchlist = count($watchlist);
	$count = 0;
	foreach ($watchlist as $key => $value)
	{
		$count++;
		$arrayWatchList .= "'".$key."' => array(";
		$arrayWatchList .= "'ExcludeTrim' => 'false',";
		$arrayWatchList .= "'FileType' => 'auto',";
		$arrayWatchList .= "'Location' => '".$key."',";
		$arrayWatchList .= "'Pattern' => '".$value."'";
		$arrayWatchList .= "'Recursive' => 'false'";
		$arrayWatchList .= ")";
		if($count != $countOfWatchlist)
		{
			$arrayWatchList .= ",";
		}
	}
	$arrayForNewStuff["watchList"] = $arrayWatchList;
}
upgradeConfig($arrayForNewStuff);
echo json_encode($_POST['version']); 
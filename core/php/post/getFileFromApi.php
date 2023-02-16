<?php
require_once("../class/core.php");
$core = new core();
require_once("../class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
if(!$session->validate())
{
	echo json_encode(array("error" => 18));
	exit();
}



$baseModifier = "../../../";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = $baseModifier."local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once($baseModifier.'core/conf/config.php');
require_once('../configStatic.php');
require_once('../class/poll.php');
$poll = new poll();

$varsLoadLite = array("apiToFileInnerSettingsBC");

foreach ($varsLoadLite as $varLoadLite)
{
	$$varLoadLite = $defaultConfig[$varLoadLite];
	if(array_key_exists($varLoadLite, $config))
	{
		$$varLoadLite = $config[$varLoadLite];
	}
}




$returnData = array(
  "success"   => "true"
);

try
{
	$apiToFileInnerSettingsBC = json_decode($apiToFileInnerSettingsBC, true);
	foreach ($apiToFileInnerSettingsBC as $apiData)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.bigcommerce.com/stores/".$apiData["store_hash"]."/v3/store/systemlogs",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"X-Auth-Token: " .$apiData["auth_token"]
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		file_put_contents($apiData["output"], $response['data']);
	}

catch (Exception $e)
{
	$response[$path]["log"] = "Error - ".$e." ";
	$response[$path]["data"] = " Limit: ".$logSizeLimit."(".($logSizeLimit+$buffer).") ".$modifier." | Line Count: --- | Time: ---";
	$response[$path]["lineCount"] = "---";
}



echo json_encode($returnData);

?>
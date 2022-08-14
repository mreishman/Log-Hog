<?php
$jsonFiles = file_get_contents($core->baseURL()."core/json/staticFilesRequired.json");
$arrayOfFiles = json_decode($jsonFiles, true);
$jsonFiles = file_get_contents($core->baseURL()."core/json/staticFilesOptional.json");
$arrayOfFilesExtra = json_decode($jsonFiles, true);
if($samePageSettings === "true")
{
	$arrayOfFiles[] = $arrayOfFilesExtra['advanced'];
	$arrayOfFiles[] = $arrayOfFilesExtra['colorScheme'];
	$arrayOfFiles[] = $arrayOfFilesExtra['devTools'];
	$arrayOfFiles[] = $arrayOfFilesExtra['globalConfig'];
	$arrayOfFiles[] = $arrayOfFilesExtra['jsColor'];
	$arrayOfFiles[] = $arrayOfFilesExtra['resetSettings'];
}
if(!(in_array('updaterEnabled', $arrayOfDisabledModules)))
{
	$arrayOfFiles[] = $arrayOfFilesExtra['update'];
}
if(!(in_array('filterEnabled', $arrayOfDisabledModules)))
{
	$arrayOfFiles[] = $arrayOfFilesExtra['filter'];
}
if(!in_array('advancedLogFormatEnabled', $arrayOfDisabledModules))
{
	if($logFormatPhpEnable === "true")
	{
		$arrayOfFiles[] = $arrayOfFilesExtra['formatPhp'];
	}
	if($logFormatFileEnable === "true")
	{
		$arrayOfFiles[] = $arrayOfFilesExtra['formatFile'];
	}
	if($logFormatReportEnable === "true")
	{
		$arrayOfFiles[] = $arrayOfFilesExtra['formatReport'];
	}
	if($logFormatJsObjectEnable === "true")
	{
		$arrayOfFiles[] = $arrayOfFilesExtra['formatJsObject'];
	}
	$arrayOfFiles[] = $arrayOfFilesExtra['format'];
	$arrayOfFiles[] = $arrayOfFilesExtra['dateFormat.min'];
	$directory = array_diff(scandir($core->baseURL()."core/js/formatObjects/"), array('..', '.'));
	foreach ($directory as $file) {
		$arrayOfFiles[] =  array(
			"name" => "core/js/formatObjects/".$file,
			"type" => "js"
		);
	}
}
if(in_array('themesEnabled', $arrayOfDisabledModules))
{
	$arrayOfFiles[] = $arrayOfFilesExtra['themes'];
	$arrayOfFiles[] = $arrayOfFilesExtra['upgradeTheme'];
}
if(!(in_array('oneLogEnable', $arrayOfDisabledModules)))
{
	$arrayOfFiles[] = $arrayOfFilesExtra['oneLog'];
}
if($flashTitleUpdateLog === "true")
{
	$arrayOfFiles[] = $arrayOfFilesExtra['titleFlash'];
}
if(!in_array('enableHistory', $arrayOfDisabledModules))
{
	$arrayOfFiles[] = $arrayOfFilesExtra['archive'];
}
if(!(in_array('enableMultiLog', $arrayOfDisabledModules)))
{
	$arrayOfFiles[] = $arrayOfFilesExtra['multilog'];
}
if($hideEmptyLog === "true")
{
	$arrayOfFiles[] = $arrayOfFilesExtra['hideEmptyLog'];
}
if($truncateLog === "true")
{
	$arrayOfFiles[] = $arrayOfFilesExtra['eraserMulti'];
}
if($truncateLog === "false")
{
	$arrayOfFiles[] = $arrayOfFilesExtra['eraser'];
}
if($hideClearAllNotifications !== "true")
{
	$arrayOfFiles[] = $arrayOfFilesExtra['notificationClear'];
}
if($hideNotificationIcon !== "true")
{
	$arrayOfFiles[] = $arrayOfFilesExtra['notification'];
}
$currentSessionValue = $windowConfig;
if(isset($_COOKIE["windowConfig"]) && $logLoadPrevious === "true")
{
	$cookieData = json_decode($_COOKIE["windowConfig"]);
	$currentSessionValue = $cookieData;
}
if(in_array('enableMultiLog', $arrayOfDisabledModules))
{
	$windowConfig = "1x1";
	$currentSessionValue = $windowConfig;
}
if($currentSessionValue !== "1x1")
{
	$arrayOfFiles[] = $arrayOfFilesExtra['pin'];
	$arrayOfFiles[] = $arrayOfFilesExtra['pinPinned'];
}
if ($filterSearchInHeader === "true" && !(in_array('filterEnabled', $arrayOfDisabledModules)))
{
	$arrayOfFiles[] = $arrayOfFilesExtra['search'];
}
$counter = 0;
foreach ($arrayOfFiles as $file)
{
	if($file["type"] !== "js" && strpos($file["name"], "core/") === false)
	{
		$arrayOfFiles[$counter]["name"] = $baseUrl . $file["name"];
	}
	$counter++;
}

function compareByName($a, $b) {
  return strcmp($a["name"], $b["name"]);
}
function compareByType($a, $b) {
  return strcmp($a["type"], $b["type"]);
}
usort($arrayOfFiles, 'compareByName');
usort($arrayOfFiles, 'compareByType');

foreach ($arrayOfFiles as $key => $value)
{
	$filePath = $value["name"];
	$arrayOfFiles[$key]["ver"] = $core->getFileTime($filePath, $configStatic["version"]);
	$arrayOfFiles[$key]["size"] = filesize($filePath);
}

?>
<script type="text/javascript">
	var arrOfMoreInfo = {};
	var arrayOfJsFiles = <?php echo json_encode($arrayOfFiles); ?>;
	var arrayOfJsFilesKeys = Object.keys(arrayOfJsFiles);
	var lengthOfArrayOfJsFiles = arrayOfJsFilesKeys.length;
	var onLoadJsFiles = {
		watchlist: {
			name: "core/js/settingsWatchlist.js",
			type: "js",
			ver : <?php echo $core->getFileTime("core/js/settingsWatchlist.js",$configStatic["version"]); ?>
		}
	};
</script>
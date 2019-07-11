<?php
$arrayOfFiles = array(
	array(
		"name" => "core/template/base.css",
		"type" => "css",
	),
	array(
		"name" => "template/theme.css",
		"type" => "css"
	),
	array(
		"name" => "visibility.core.js",
		"type" =>"js"
	),
	array(
		"name" => "visibility.fallback.js",
		"type" =>"js"
	),
	array(
		"name" => "visibility.timers.js",
		"type" =>"js"
	),
	array(
		"name" => "main.js",
		"type" =>"js"
	),
	array(
		"name" => "settingsMain.js",
		"type" =>"js"
	),
	array(
		"name" => "advanced.js",
		"type" =>"js"
	),
	array(
		"name" => "resetSettingsJs.js",
		"type" =>"js"
	),
	array(
		"name" => "rightClickJS.js",
		"type" =>"js"
	),
	array(
		"name" => "update.js",
		"type" =>"js"
	),
	array(
		"name" => "settings.js",
		"type" =>"js"
	),
	array(
		"name" => "groups.js",
		"type" =>"js"
	),
	array(
		"name" => "loghogDownloadJS.js",
		"type" =>"js"
	),
	array(
		"name" => "jscolor.js",
		"type" =>"js"
	),
	array(
		"name" => "formatLog.js",
		"type" =>"js"
	),
	array(
		"name" => "showLog.js",
		"type" =>"js"
	),
	array(
		"name" => "poll.js",
		"type" =>"js"
	),
	array(
		"name" => "settingsSideBar.js",
		"type" =>"js"
	),
	array(
		"name" => "colorScheme.js",
		"type" =>"js"
	),
	array(
		"name" => "addons.js",
		"type" =>"js"
	),
	array(
		"name" => "menu.js",
		"type" =>"js"
	),
	array(
		"name" => "notifications.js",
		"type" =>"js"
	),
	array(
		"name" => "fullscreenMenu.js",
		"type" =>"js"
	),
	array(
		"name" => "img/menu.png",
		"type" =>"img",
		"class" =>"menuImageForLoad"
	),
	array(
		"name" => "img/Play.png",
		"type" =>"img",
		"class" =>"playImageForLoad"
	),
	array(
		"name" => "img/Pause.png",
		"type" =>"img",
		"class" =>"pauseImageForLoad"
	),
	array(
		"name" => "img/Refresh.png",
		"type" =>"img",
		"class" =>"refreshImageForLoad"
	),
	array(
		"name" => "img/info.png",
		"type" =>"img",
		"class" =>"infoSideBarImageForLoad"
	),
	array(
		"name" => "img/search.png",
		"type" =>"img",
		"class" =>"searchSideBarImageForLoad"
	),
	array(
		"name" => "img/eraser.png",
		"type" =>"img",
		"class" =>"eraserSideBarImageForLoad"
	),
	array(
		"name" => "img/trashCan.png",
		"type" =>"img",
		"class" =>"trashCanSideBarImageForLoad"
	),
	array(
		"name" => "img/downArrowSideBar.png",
		"type" =>"img",
		"class" =>"downArrowSideBarImageForLoad"
	),
	array(
		"name" => "img/Gear.png",
		"type" =>"img",
		"class" =>"gearImageForLoad"
	),
	array(
		"name" => "img/history.png",
		"type" =>"img",
		"class" =>"historySideBarImageForLoad"
	),
	array(
		"name" => "img/saveSideBar.png",
		"type" =>"img",
		"class" =>"historyAddSideBarImageForLoad"
	),
	array(
		"name" => "img/close.png",
		"type" =>"img",
		"class" =>"closeImageForLoad"
	),
);

if($filterEnabled === "true")
{
	$arrayOfFiles[] = array(
		"name" => "filter.js",
		"type" =>"js"
	);
}
if($sendCrashInfoJS === "true")
{
	$arrayOfFiles[] = array(
		"name" =>"sentry.js",
		"type" => "js"
	);
}
if($advancedLogFormatEnabled === "true")
{
	if($logFormatPhpEnable === "true")
	{
		$arrayOfFiles[] =  array(
			"name" => "formatPhp.js",
			"type" => "js"
		);
	}
	if($logFormatFileEnable === "true")
	{
		$arrayOfFiles[] =  array(
			"name" => "formatFile.js",
			"type" => "js"
		);
	}
	if($logFormatReportEnable === "true")
	{
		$arrayOfFiles[] =  array(
			"name" => "formatReport.js",
			"type" => "js"
		);
	}
	if($logFormatJsObjectEnable === "true")
	{
		$arrayOfFiles[] =  array(
			"name" => "formatJsObject.js",
			"type" => "js"
		);
	}
	$arrayOfFiles[] =  array(
		"name" => "format.js",
		"type" => "js"
	);
	$arrayOfFiles[] =  array(
		"name" => "dateFormat.min.js",
		"type" => "js"
	);
	$directory = array_diff(scandir($core->baseURL()."core/js/formatObjects/"), array('..', '.'));
	foreach ($directory as $file) {
		$arrayOfFiles[] =  array(
			"name" => "formatObjects/".$file,
			"type" => "js"
		);
	}
}
if($themesEnabled === "true")
{
	$arrayOfFiles[] = array(
		"name" => "themes.js",
		"type" => "js"
	);
	$arrayOfFiles[] = array(
		"name" => "upgradeTheme.js",
		"type" => "js"
	);
}
if($oneLogEnable === "true")
{
	$arrayOfFiles[] = array(
		"name" => "oneLog.js",
		"type" => "js"
	);
}
if($flashTitleUpdateLog === "true")
{
	$arrayOfFiles[] = array(
		"name" => "titleFlash.js",
		"type" => "js"
	);
}
if($enableHistory === "true")
{
	$arrayOfFiles[] = array(
		"name" => "archive.js",
		"type" => "js"
	);
}
if($enableMultiLog === "true")
{
	$arrayOfFiles[] = array(
		"name" => "multilog.js",
		"type" => "js"
	);
}
if($hideEmptyLog === "true")
{
	$arrayOfFiles[] = array(
		"name" => "hideEmptyLog.js",
		"type" => "js"
	);
}
if($truncateLog === "true")
{
	$arrayOfFiles[] = array(
		"name" => "img/eraserMulti.png",
		"type" => "img",
		"class" => "eraserMultiImageForLoad"
	);
}
if($truncateLog === "false")
{
	$arrayOfFiles[] = array(
		"name" => "img/eraser.png",
		"type" => "img",
		"class" => "eraserForLoad"
	);
}
if($hideClearAllNotifications !== "true")
{
	$arrayOfFiles[] = array(
		"name" => "img/notificationClear.png",
		"type" => "img",
		"class" => "notificationClearImageForLoad"
	);
}
if($hideNotificationIcon !== "true")
{
	$arrayOfFiles[] = array(
		"name" => "img/notification.png",
		"type" => "img",
		"class" => "notificationImageForLoad"
	);
}
$currentSessionValue = $windowConfig;
if(isset($_COOKIE["windowConfig"]) && $logLoadPrevious === "true")
{
	$cookieData = json_decode($_COOKIE["windowConfig"]);
	$currentSessionValue = $cookieData;
}
if($enableMultiLog === "false")
{
	$windowConfig = "1x1";
	$currentSessionValue = $windowConfig;
}
if($currentSessionValue !== "1x1")
{
	$arrayOfFiles[] = array(
		"name" => "img/pin.png",
		"type" => "img",
		"class" => "pinImageForLoad"
	);
	$arrayOfFiles[] = array(
		"name" => "img/pinPinned.png",
		"type" => "img",
		"class" => "pinPinnedImageForLoad"
	);
}
if ($filterSearchInHeader === "true" && $filterEnabled === "true")
{
	$arrayOfFiles[] = array(
		"name" => "img/search.png",
		"type" => "img",
		"class" => "showFilterTopBarImageForLoad"
	);
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
	if($value["type"] === "js")
	{
		$filePath = "core/js/".$filePath;
	}
	$arrayOfFiles[$key]["ver"] = $core->getFileTime($filePath, $configStatic["version"]);
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
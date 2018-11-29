<?php
$arrayOfFiles = array(
	array(
		"name" => "core/template/base.css",
		"type" => "css"
	),
	array(
		"name" => "core/template/loading-bar.css",
		"type" => "css"
	),
	array(
		"name" => $baseUrl . "template/theme.css",
		"type" => "css"
	),
	array(
		"name" => "jquery.js",
		"type" =>"js"
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
		"name" => "loading-bar.min.js",
		"type" =>"js"
	),
	array(
		"name" => "main.js",
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
		"name" => "loghogDownloadJS.js",
		"type" =>"js"
	),
	array(
		"name" => "jscolor.js",
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
		"name" => $baseUrl . "img/menu.png",
		"type" =>"img",
		"class" =>"menuImageForLoad"
	),
	array(
		"name" => $baseUrl . "img/play.png",
		"type" =>"img",
		"class" =>"playImageForLoad"
	),
	array(
		"name" => $baseUrl . "img/pause.png",
		"type" =>"img",
		"class" =>"pauseImageForLoad"
	),
	array(
		"name" => $baseUrl . "img/refresh.png",
		"type" =>"img",
		"class" =>"refreshImageForLoad"
	),
	array(
		"name" => $baseUrl . "img/infoSideBar.png",
		"type" =>"img",
		"class" =>"infoSideBarImageForLoad"
	),
	array(
		"name" => $baseUrl . "img/eraserSideBar.png",
		"type" =>"img",
		"class" =>"eraserSideBarImageForLoad"
	),
	array(
		"name" => $baseUrl . "img/trashCanSideBar.png",
		"type" =>"img",
		"class" =>"trashCanSideBarImageForLoad"
	),
	array(
		"name" => $baseUrl . "img/downArrowSideBar.png",
		"type" =>"img",
		"class" =>"downArrowSideBarImageForLoad"
	),
	array(
		"name" => $baseUrl . "img/gear.png",
		"type" =>"img",
		"class" =>"gearImageForLoad"
	)
);

if($sendCrashInfoJS === "true")
{
	$arrayOfFiles[] = array("name" =>"Raven.js", "type" => "js");
}
if($expFormatEnabled === "true")
{
	$arrayOfFiles[] =  array("name" => "format.js", "type" => "js");
	$arrayOfFiles[] =  array("name" => "dateFormat.min.js", "type" => "js");
}
if($themesEnabled === "true")
{
	$arrayOfFiles[] = array("name" => "themes.js", "type" => "js");
}
if($oneLogEnable === "true")
{
	$arrayOfFiles[] = array("name" => "oneLog.js", "type" => "js");
}
if($enableHistory === "true")
{
	$arrayOfFiles[] = array("name" => "archive.js", "type" => "js");
}
if($enableMultiLog === "true")
{
	$arrayOfFiles[] = array("name" => "multilog.js", "type" => "js");
}
if($hideEmptyLog === "true")
{
	$arrayOfFiles[] = array("name" => "hideEmptyLog.js", "type" => "js");
}
if($truncateLog === "true")
{
	$arrayOfFiles[] = array("name" => $baseUrl . "img/eraserMulti.png", "type" => "img", "class" => "eraserMultiImageForLoad");
}
if($truncateLog === "false")
{
	$arrayOfFiles[] = array("name" => $baseUrl . "img/eraser.png", "type" => "img", "class" => "eraserForLoad");
}
if($enableMultiLog === "true" && $multiLogOnIndex === "true")
{
	$arrayOfFiles[] = array("name" => $baseUrl . "img/multiLog.png", "type" => "img", "class" => "multiLogImageForLoad");
}
if($hideClearAllNotifications !== "true")
{
	$arrayOfFiles[] = array("name" => $baseUrl . "img/notificationClear.png", "type" => "img", "class" => "notificationClearImageForLoad");
}
if($hideNotificationIcon !== "true")
{
	$arrayOfFiles[] = array("name" => $baseUrl . "img/notification.png", "type" => "img", "class" => "notificationImageForLoad");
}
if($windowConfig !== "1x1")
{
	$arrayOfFiles[] = array("name" => $baseUrl . "img/pin.png", "type" => "img", "class" => "pinImageForLoad");
	$arrayOfFiles[] = array("name" => $baseUrl . "img/pinPinned.png", "type" => "img", "class" => "pinPinnedImageForLoad");
}
if($enableHistory === "true")
{
	$arrayOfFiles[] = array("name" => $baseUrl . "img/history.png", "type" => "img", "class" => "historyImageForLoad");
}


?>
<script type="text/javascript">
	var arrayOfJsFiles = <?php echo json_encode($arrayOfFiles); ?>;
	var arrayOfJsFilesKeys = Object.keys(arrayOfJsFiles);
	var lengthOfArrayOfJsFiles = arrayOfJsFilesKeys.length;
</script>
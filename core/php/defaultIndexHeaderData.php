<?php

$styleStringPlay = "display: inline-block;";
$styleStringPause = "display: none;";
if($pausePoll !== 'true')
{
	$styleStringPlay = "display: none;";
	$styleStringPause = "display: inline-block;";
}

$imageForClear = $core->generateImage(
	$arrayOfImages["loadingImg"],
	$imageConfig = array(
		"id"		=>	"deleteImage",
		"class"		=>	"menuImage eraserMultiImageForLoad",
		"height"	=>	"30px",
		"data-src"	=>	$arrayOfImages["eraserMulti"]
	)
);
if($truncateLog == 'false')
{
	$imageForClear = $core->generateImage(
		$arrayOfImages["loadingImg"],
		$imageConfig = array(
			"id"		=>	"deleteImage",
			"class"		=>	"menuImage eraserForLoad",
			"height"	=>	"30px",
			"data-src"	=>	$arrayOfImages["eraser"]
		)
	);
}

$defaultIndexHeaderConfig = array(
	"mainMenu"	=> array(
		"id"		=> "mainMenuDiv",
		"class"		=> "menuImageDiv",
		"onClick"	=> "toggleFullScreenMenu();",
		"type"		=> 1,
		"visible"	=> "true",
		"position"	=> 1,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"menuImage",
				"class"		=>	"menuImage menuImageForLoad",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["menu"]
			)
		)
	),
	"notifications"	=> array(
		"id"		=> "notificationDiv",
		"class"		=> "menuImageDiv",
		"onClick"	=> "toggleNotifications();",
		"type"		=> 1,
		"visible"	=> ($hideNotificationIcon === "true") ? "false" : "true",
		"position"	=> 10,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"notificationNotClicked",
				"class"		=>	"menuImage notificationImageForLoad",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["notification"]
			)
		)
	),
	"settingsSideBar"	=> array(
		"class"		=> "menuImageDiv",
		"onClick"	=> "toggleSettingsSidebar();",
		"type"		=> 1,
		"visible"	=> "true",
		"position"	=> 20,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"gearImage",
				"class"		=>	"menuImage gearImageForLoad",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["gear"]
			)
		)
	),
	"pause"	=> array(
		"class"		=> "menuImageDiv",
		"onClick"	=> "pausePollAction();",
		"type"		=> 1,
		"visible"	=> "true",
		"position"	=> 30,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"playImage",
				"class"		=>	"menuImage playImageForLoad",
				"height"	=>	"30px",
				"style"		=>	$styleStringPlay,
				"data-src"	=>	$arrayOfImages["play"]
			)
		).
		$core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"pauseImage",
				"class"		=>	"menuImage pauseImageForLoad",
				"height"	=>	"30px",
				"style"		=>	$styleStringPause,
				"data-src"	=>	$arrayOfImages["pause"]
			)
		)
	),
	"refresh"	=> array(
		"class"		=> "menuImageDiv",
		"onClick"	=> "refreshAction();",
		"type"		=> 1,
		"visible"	=> "true",
		"position"	=> 40,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"refreshImage",
				"class"		=>	"menuImage refreshImageForLoad",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["refresh"]
			)
		).
		$core->generateImage(
			$arrayOfImages["loading"],
			$imageConfig = array(
				"id"		=>	"refreshingImage",
				"class"		=>	"menuImage",
				"height"	=>	"30px",
				"style"		=>	"display: none;"
			)
		)
	),
	"truncateLog"	=> array(
		"class"		=> "menuImageDiv",
		"onClick"	=> "deleteImageAction();",
		"type"		=> 1,
		"visible"	=> ($truncateLog === 'hide') ? "false" : "true",
		"position"	=> 50,
		"content"	=> $imageForClear
	),
	"clearNotifications"	=> array(
		"id"		=> "clearNotificationsImage",
		"class"		=> "menuImageDiv",
		"onClick"	=> "removeAllNotifications();",
		"type"		=> 2,
		"visible"	=> "false",
		"outerId"	=> "clearNotificationsImageHolder",
		"outerVisible"	=> ($hideClearAllNotifications === "true") ? "false" : "true",
		"position"	=> 100,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"notificationClearImage",
				"class"		=>	"menuImage notificationClearImageForLoad",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["notificationClear"]
			)
		)
	),
);	


$sortedIndexHeaderConfig = array();

foreach ($defaultIndexHeaderConfig as $indexHeaderConfigItem)
{
	$key = $indexHeaderConfigItem["position"] * 1000000;
	while(isset($sortedIndexHeaderConfig[$key])) {
		$key++;
	}
	$sortedIndexHeaderConfig[$key] = $indexHeaderConfigItem;
}
ksort($sortedIndexHeaderConfig);
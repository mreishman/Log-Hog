<?php

$defaultIndexHeaderConfig = array(
	"mainMenu"	=> array(
		"id"		=> "mainMenuDiv",
		"class"		=> "menuImageDiv",
		"onClick"	=> "toggleFullScreenMenu();",
		"type"		=> "image",
		"visible"	=> "true",
		"position"	=> 1,
		"image"		=> $core->generateImage(
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
		"type"		=> "image",
		"visible"	=> !$hideNotificationIcon,
		"position"	=> 10,
		"image"		=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"notificationNotClicked",
				"class"		=>	"menuImage notificationImageForLoad",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["notification"]
			)
		)
	),
	"settingsSIdeBar"	=> array(
		"class"		=> "menuImageDiv",
		"onClick"	=> "toggleSettingsSidebar();",
		"type"		=> "image",
		"visible"	=> "true",
		"position"	=> 20,
		"image"		=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"gearImage",
				"class"		=>	"menuImage gearImageForLoad",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["gear"]
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
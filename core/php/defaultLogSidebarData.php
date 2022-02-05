<?php

$defaultLogSidebarConfig = array(
	"info"	=> array(
		"id"		=> "showInfoLink{{counter}}",
		"onClick"	=> "showInfo('{{counter}}');",
		"type"		=> "image",
		"visible"	=> "true",
		"position"	=> 1,
		"image"		=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"class"		=>	"infoSideBarImageForLoad altImage",
				"style"		=>	"margin: 5px;",
				"title"		=>	"More Info",
				"data-src"	=>	$arrayOfImages["info"]
			)
		)
	),
	"pause"	=> array(
		"id"		=> "pauseSingleLog{{counter}}",
		"onClick"	=> "toggleSingleLogPause('{{counter}}');",
		"type"		=> "image",
		"visible"	=> "true",
		"position"	=> 10,
		"image"		=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"class"		=>	"pauseImageForLoad altImage",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Pause",
				"data-src"	=>	$arrayOfImages["pause"]
			)
		)
	),
	"play"	=> array(
		"id"		=> "playSingleLog{{counter}}",
		"onClick"	=> "toggleSingleLogPause('{{counter}}');",
		"type"		=> "image",
		"visible"	=> "false",
		"position"	=> 10,
		"image"		=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"class"		=>	"playImageForLoad altImage",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Play",
				"data-src"	=>	$arrayOfImages["play"]
			)
		)
	),
	"refresh"	=> array(
		"id"		=> "singleLogRefresh{{counter}}",
		"onClick"	=> "singleLogRefresh('{{counter}}');",
		"type"		=> "image",
		"visible"	=> "true",
		"position"	=> 20,
		"image"		=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"class"		=>	"refreshImageForLoad altImage",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Refresh",
				"data-src"	=>	$arrayOfImages["refresh"]
			)
		)
	),
	"refreshLoading"	=> array(
		"id"		=> "singleLogRefreshLoading{{counter}}",
		"type"		=> "image",
		"visible"	=> "false",
		"style"		=> "cursor: default;",
		"position"	=> 20,
		"image"		=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"class"		=>	"altImage",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Refreshing",
			)
		)
	),
	"individualFilter"	=> array(
		"id"		=> "showLogWindowFilter{{counter}}",
		"onClick"	=> "showLogWindowFilter('{{counter}}');",
		"type"		=> "image",
		"visible"	=> "true",
		"style"		=> "{{customfilterstyle}}",
		"position"	=> 30,
		"image"		=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"class"		=>	"searchSideBarImageForLoad altImage",
				"style"		=>	"margin: 5px;",
				"title"		=>	"More Info",
				"data-src"	=>	$arrayOfImages["search"]
			)
		)
	),
);

$sortedDefaultLogSidebarConfig = array();

foreach ($defaultLogSidebarConfig as $logSidebarConfigItem)
{
	$key = $logSidebarConfigItem["position"] * 1000000;
	while(isset($sortedDefaultLogSidebarConfig[$key])) {
		$key++;
	}
	$sortedDefaultLogSidebarConfig[$key] = $logSidebarConfigItem;
}
ksort($sortedDefaultLogSidebarConfig);
<?php

/** logSidebarBlock.php */

$defaultLogSidebarConfig = array(
	"info"	=> array(
		"id"		=> "showInfoLink{{counter}}",
		"onClick"	=> "showInfo('{{counter}}');",
		"position"	=> 1,
		"content"	=> $core->generateImage(
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
		"position"	=> 10,
		"content"	=> $core->generateImage(
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
		"visible"	=> "false",
		"position"	=> 10,
		"content"	=> $core->generateImage(
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
		"position"	=> 20,
		"content"	=> $core->generateImage(
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
		"visible"	=> "false",
		"style"		=> "cursor: default;",
		"position"	=> 20,
		"content"	=> $core->generateImage(
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
		"style"		=> "{{customfilterstyle}}",
		"position"	=> 30,
		"content"	=> $core->generateImage(
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
	"pinWindow"	=> array(
		"id"		=> "pinWindow{{counter}}",
		"onClick"	=> "pinWindow('{{counter}}');",
		"class"		=> "pinWindowContainer",
		"position"	=> 40,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Pin Window",
				"class"		=>	"pinWindow pinImageForLoad multiLogGreaterThanOne altImage",
				"data-src"	=>	$arrayOfImages["pin"]
			)
		).
		$core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px; display: none;",
				"title"		=>	"Un-Pin Window",
				"class"		=>	"unPinWindow pinPinnedImageForLoad multiLogGreaterThanOne altImage",
				"data-src"	=>	$arrayOfImages["pinPinned"]
			)
		)
	),
	"clearLogSideBar"	=> array(
		"id"		=> "clearLogSideBar{{counter}}",
		"onClick"	=> "clearLog('{{counter}}');",
		"position"	=> 50,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Clear Log",
				"class"		=>	"eraserSideBarImageForLoad altImage",
				"data-src"	=>	$arrayOfImages["eraser"]
			)
		)
	),
	"deleteLogSideBar"	=> array(
		"id"		=> "deleteLogSideBar{{counter}}",
		"onClick"	=> "deleteLogPopup('{{counter}}');",
		"position"	=> 60,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Delete Log",
				"class"		=>	"trashCanSideBarImageForLoad altImage",
				"data-src"	=>	$arrayOfImages["trashCan"]
			)
		)
	),
	"historySideBar"	=> array(
		"id"		=> "historySideBar{{counter}}",
		"onClick"	=> "viewBackupFromCurrentLog('{{counter}}');",
		"position"	=> 70,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px;",
				"title"		=>	"View Backup",
				"class"		=>	"historySideBarImageForLoad altImage",
				"data-src"	=>	$arrayOfImages["history"]
			)
		)
	),
	"saveArchiveSideBar"	=> array(
		"id"		=> "saveArchiveSideBar{{counter}}",
		"onClick"	=> "saveArchivePopup('{{counter}}');",
		"position"	=> 80,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Save Backup",
				"class"		=>	"historyAddSideBarImageForLoad altImage",
				"data-src"	=>	$arrayOfImages["saveSideBar"]
			)
		)
	),
	"logSelector"	=> array(
		"onClick"	=> "toggleLogPopup(this,'{{counter}}');",
		"position"	=> 90,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Select Log",
				"class"		=>	"menuImageForLoad altImage",
				"data-src"	=>	$arrayOfImages["menu"]
			)
		)
	),
	"removeLogFromDisplay"	=> array(
		"id"		=> "closeLogSideBar{{counter}}",
		"onClick"	=> "removeLogFromDisplay('{{counter}}');",
		"visible"	=> "false",
		"position"	=> 100,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px;",
				"class"		=>	"closeImageForLoad archiveLogImages altImage",
				"data-src"	=>	$arrayOfImages["close"]
			)
		)
	),
	"scrollToTop"	=> array(
		"onClick"	=> "scrollToTop('{{counter}}');",
		"position"	=> 500,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px; -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -o-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); ",
				"title"		=>	"Scroll to Top",
				"class"		=>	"downArrowSideBarImageForLoad altImage",
				"data-src"	=>	$arrayOfImages["downArrowSideBar"]
			)
		)
	),
	"scrollToBottom"	=> array(
		"onClick"	=> "scrollToBottom('{{counter}}');",
		"position"	=> 500,
		"content"	=> $core->generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"height"	=>	"20px",
				"style"		=>	"margin: 5px;",
				"title"		=>	"Scroll to Bottom",
				"class"		=>	"downArrowSideBarImageForLoad altImage",
				"data-src"	=>	$arrayOfImages["downArrowSideBar"]
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
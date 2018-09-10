<?php
require_once('core/php/errorCheckFunctions.php');
$currentPage = "index.php";
checkIfFilesExist(
	array("core/conf/config.php","core/php/configStatic.php","core/php/loadVars.php","core/php/loadVarsToJs.php","core/php/updateCheck.php","core/js/jquery.js","core/template/loading-bar.css","core/js/loading-bar.min.js","core/php/customCSS.php","core/php/template/popup.php","core/js/main.js","core/js/rightClickJS.js","core/js/update.js","core/php/commonFunctions.php","setup/setupProcessFile.php","error.php"),
	 "",
	 $currentPage);
checkIfFilesAreReadable(
	array("core/conf/config.php","core/php/configStatic.php","core/php/loadVars.php","core/php/loadVarsToJs.php","core/php/updateCheck.php","core/js/jquery.js","core/template/loading-bar.css","core/js/loading-bar.min.js","core/php/customCSS.php","core/php/template/popup.php","core/js/main.js","core/js/rightClickJS.js","core/js/update.js","core/php/commonFunctions.php","setup/setupProcessFile.php","error.php"),
	 "",
	 $currentPage);
require_once('core/php/commonFunctions.php');

setCookieRedirect();
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "local/".$currentSelectedTheme."/";

if(!file_exists($baseUrl.'conf/config.php'))
{
	require_once("setup/setupProcessFile.php");
	if($setupProcess !== "finished")
	{
		if($setupProcess === 'preStart')
		{
			$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
			if(strpos($partOfUrl, "index.php") !== false)
			{
				$partOfUrl = str_replace("index.php", "", $partOfUrl);
			}
			$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/welcome.php";
			header('Location: ' . $url, true, 302);
			exit();
		}
		else
		{
			//setup either errored out, or was incomplete. throw error.
			//throwSetupError("");
		}
	}
}
require_once($baseUrl.'conf/config.php');
require_once('core/conf/config.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
$defaultSettingsDir = 'core/Themes/'.$currentTheme."/defaultSetting.php";
if(is_dir('local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	$defaultSettingsDir = 'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php";
}
require_once($defaultSettingsDir);
require_once('core/php/configStatic.php');
require_once('core/php/loadVars.php');
require_once('core/php/loadVarsToJs.php');
require_once('core/php/updateCheck.php');

if(!class_exists('ZipArchive') && $autoCheckUpdate === "true")
{
	echoErrorJavaScript("", "ZipArchive is not installed", 11);
}

$daysSince = calcuateDaysSince($configStatic['lastCheck']);

$locationForStatusIndex = checkForStatusInstall($locationForStatus, "./");

$locationForMonitorIndex = checkForMonitorInstall($locationForMonitor, "./");

$locationForSearchIndex = checkForSearchInstall($locationForSearch, "./");

$locationForSeleniumMonitorIndex = checkForSeleniumMonitorInstall($locationForSeleniumMonitor, "./");

/* USED IN ABOUT PAGE (template/about.php) */
$aboutImage = generateImage(
	$arrayOfImages["loadingImg"],
	$imageConfig = array(
		"class"		=>	"mainMenuImage",
		"style"		=>	"margin-bottom: -40px;",
		"data-src"	=>	"core/img/LogHog.png",
		"width"		=>	"100px"
	)
);
/* Override window config if multi log is disabled */
if($enableMultiLog === "false")
{
	$windowConfig = "1x1";
}
$windowDisplayConfig = explode("x", $windowConfig);

/* Used for full screen menu */
$externalLinkImage = generateImage(
	$arrayOfImages["externalLink"],
	$imageConfig = array(
		"height"	=>	"15px",
		"style"		=>	"margin-bottom: -10px;"
		)
	);
?>
<!doctype html>
<head>
	<title>Log Hog | Index</title>
	<?php echo loadCSS("", $baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script src="core/js/jquery.js"></script>
	<?php
		echo loadSentryData($sendCrashInfoJS, $branchSelected);
		echo loadVisibilityJS(baseURL());
	?>
	<link rel="stylesheet" type="text/css" href="core/template/loading-bar.css"/>
	<script type="text/javascript" src="core/js/loading-bar.min.js"></script>
</head>
<body>
	<?php require_once("core/php/customCSS.php");
	require_once("core/php/customIndexCSS.php");
	if($enablePollTimeLogging != "false"): ?>
		<div id="loggTimerPollStyle" class="noticeBar"><span id="loggingTimerPollRate" >### MS /<?php echo $pollingRate; ?> MS</span> | <span id="loggSkipCount" >0</span>/<?php echo $pollForceTrue; ?> | <span id="loggAllCount" >0</span>/<?php echo $pollRefreshAll; ?></div>
	<?php endif; ?>
		<div id="noticeBar" class="noticeBar" style="display: none;" >
			<span id="connectionNotice" style="color: yellow;" >
				Notice  - <?php echo ($pollForceTrue * 2); ?> poll requests have failed. Please check server connectivity or refresh page.
			</span>
			<span id="connectionWarning" style="color: red;">
				Warning - <?php echo ($pollForceTrue * 4); ?> poll requests have failed. Please check server connectivity or refresh page.
			</span>
		</div>
	<?php require_once("core/php/template/indexHeader.php"); ?>
	<div class="backgroundForMenus" id="menu" style="position: absolute;"></div>
	<div style="display: inline-block; position: absolute; top: 0; left: 0; z-index: 30;" >
		<div id="notificationIcon">
			<span onclick="toggleNotifications();" id="notificationCount"></span>
			<span onclick="toggleNotifications();" id="notificationBadge"></span>
		</div>
		<div id="notifications">
			<div class="notificationTriangle"></div>
			<div id="notificationHolder"></div>
		</div>
	</div>
	<div id="main">
		<table id="log" style="display: none; margin: 0px;padding: 0px; border-spacing: 0px; width: 100%;" >
			<tbody><tr><td></td></tr></tbody>
		</table>
		<div id="firstLoad" style="width: 100%; height: 100%;">
			<h1 id="progressBarMainInfo" style="margin-right: auto; margin-left: auto; width: 100%; text-align: center;  margin-top: 100px; font-size: 150%;" >Loading...</h1>
			<div id="divForProgressBar" style="width: 80%; height: 100px; margin-left: auto; margin-right: auto; margin-top: -15px; margin-bottom: -15px;">
				<div <?php echo $loadingBarStyle; ?> class="ldBar label-center" id="progressBar" data-value="0" style="width: 100%; height: 100%; margin: auto;"></div>
			</div>
			<h3 id="progressBarSubInfo" style="margin-right: auto; margin-left: auto; width: 100%; text-align: center;  margin-top: 10px; font-size: 150%;" >Loading Javascript</h3>
		</div>
		<div id="noLogToDisplay" class='errorMessageLog errorMessageGreenBG' style="display: none; margin-top: 2%;" > There are currently no logs to display. </div>
	</div>
	<div id="storage">
		<?php
			readfile('core/html/indexStorage.html');
			require_once('core/php/template/indexStorage.php');
		?>
	</div>
	<div id="fullScreenMenu" style="display: none;">
		<div style="padding: 5px 5px 10px 5px; border-bottom: 1px solid white;" >
			<div onclick="toggleFullScreenMenu();"  class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["menu"],
					$imageConfig = array(
						"id"		=>	"menuImage",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
						)
					);
				?>
			</div>
			<div onclick="toggleNotifications();"  class="menuImageDiv">
				<?php echo generateImage(
					$arrayOfImages["notification"],
					$imageConfig = array(
						"id"		=>	"notificationNotClicked",
						"class"		=>	"menuImage",
						"height"	=>	"30px"
						)
					);
				?>
			</div>
		</div>
		<ul class="settingsUl settingsUlFS fullScreenMenuUL">
			<li class="menuTitle" style="text-align: center;" >
				Log-Hog
			</li>
			<li class="menuTitle" style="background-color: #999; color: black;" >
				Main Menu
			</li>
			<li id="mainMenuAbout" class="selected" onclick="toggleAbout();" >
				<div class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["loadingImg"],
						$imageConfig = array(
							"id"		=>	"aboutImage",
							"class"		=>	"menuImage mainMenuImage",
							"height"	=>	"30px",
							"data-src"	=>	$arrayOfImages["info"]
							)
						);
					?>
				</div>
				About
			</li>
			<li id="mainMenuAddons" onclick="window.location.href = './settings/addons.php';" >
				<div class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["loadingImg"],
						$imageConfig = array(
							"id"		=>	"addonsImage",
							"class"		=>	"menuImage mainMenuImage",
							"height"	=>	"30px",
							"data-src"	=>	$arrayOfImages["addons"]
							)
						);
					?>
				</div>
				Addons
				<?php echo $externalLinkImage; ?>
			</li>
			<li onclick="window.location.href = './settings/main.php';"  >
				<div class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["loadingImg"],
						$imageConfig = array(
							"id"		=>	"gear",
							"class"		=>	"menuImage mainMenuImage",
							"height"	=>	"30px",
							"data-src"	=> 	$arrayOfImages["gear"]
							)
						);
					?>
				</div>
				Settings
				<?php echo $externalLinkImage; ?>
			</li>
			<li id="mainMenuUpdate" onclick="toggleUpdateMenu();" >
				<div class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["loadingImg"],
						$imageConfig = array(
							"id"		=>	"update",
							"class"		=>	"menuImage mainMenuImage",
							"height"	=>	"30px",
							"title"		=>	"Update",
							"data-src"	=>	$arrayOfImages["refresh"]
							)
						);
					?>
				</div>
				Update
				<?php
				if($levelOfUpdate !== 0 && $configStatic["version"] !== $dontNotifyVersion && $updateNotificationEnabled === "true")
				{
					if($updateNoticeMeter === "every" || $levelOfUpdate > 1)
					{
						if($levelOfUpdate == 1)
						{
							echo generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"id"		=>	"updateMenuImage",
									"class"		=>	"menuImage mainMenuImage",
									"height"	=>	"30px",
									"title"		=>	"Minor Update",
									"data-src"	=>	$arrayOfImages["yellowWarning"]
								)
							);
						}
						elseif($levelOfUpdate == 2 || $levelOfUpdate == 3)
						{
							echo "<div class=\"menuImageDiv\">";
							echo generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"id"		=>	"updateMenuImage",
									"class"		=>	"menuImage mainMenuImage",
									"height"	=>	"30px",
									"title"		=>	"Major Update",
									"data-src"	=>	$arrayOfImages["redWarning"]
								)
							);
							echo "</div>";
						}
					}
				}
				?>
			</li>
			<li id="watchListMenu" onclick="toggleWatchListMenu();" >
				<div class="menuImageDiv">
					<?php echo generateImage(
						$arrayOfImages["loadingImg"],
						$imageConfig = array(
							"id"		=>	"watchList",
							"class"		=>	"menuImage mainMenuImage",
							"height"	=>	"30px",
							"title"		=>	"WatchList",
							"data-src"	=>	$arrayOfImages["watchList"]
							)
						);
					?>
				</div>
				Watchlist
			</li>
				<li id="menuOtherApps" class="menuTitle" style="background-color: #999; color: black;
				<?php if(!($locationForMonitorIndex["loc"] || $locationForSearchIndex["loc"] || $locationForSeleniumMonitorIndex["loc"] || $locationForStatusIndex["loc"]))
					{
						echo " display: none; ";
					}
					?>
				" >
					Other Apps
				</li>
			<?php if ($locationForStatusIndex["loc"]):?>
				<?php if($addonsAsIframe === "true"): ?>
					<li id="menuStatusAddon" onclick="toggleIframe('<?php echo $locationForStatusIndex["loc"]; ?>','menuStatusAddon');" >
				<?php else: ?>
					<li id="menuStatusAddon" onclick="window.location.href='<?php echo $locationForStatusIndex["loc"]; ?>'" >
				<?php endif; ?>
					<div class="menuImageDiv">
						<?php echo generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"id"		=>	"gitStatusImage",
								"class"		=>	"menuImage mainMenuImage",
								"height"	=>	"30px",
								"data-src"	=>	$arrayOfImages["gitStatus"]
								)
							);
						?>
					</div>
					gitStatus
					<?php
					if($addonsAsIframe !== "true")
					{
						echo $externalLinkImage;
					}
					?>
				</li>
			<?php endif; ?>
			<?php if($locationForMonitorIndex["loc"]): ?>
				<?php if($addonsAsIframe === "true"): ?>
					<li id="menuMonitorAddon" onclick="toggleIframe('<?php echo $locationForMonitorIndex["loc"]; ?>','menuMonitorAddon');" >
				<?php else: ?>
					<li id="menuMonitorAddon" onclick="window.location.href='<?php echo $locationForMonitorIndex["loc"]; ?>'" >
				<?php endif; ?>
					<div class="menuImageDiv">
						<?php echo generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"id"		=>	"taskmanagerImage",
								"class"		=>	"menuImage mainMenuImage",
								"height"	=>	"30px",
								"data-src"	=>	$arrayOfImages["taskManager"]
								)
							);
						?>
					</div>
					Monitor
					<?php
					if($addonsAsIframe !== "true")
					{
						echo $externalLinkImage;
					}
					?>
				</li>
			<?php endif; ?>
			<?php if($locationForSearchIndex["loc"]): ?>
				<?php if($addonsAsIframe === "true"): ?>
					<li id="menuSearchAddon" onclick="toggleIframe('<?php echo $locationForSearchIndex["loc"]; ?>','menuSearchAddon');" >
				<?php else: ?>
					<li id="menuSearchAddon" onclick="window.location.href='<?php echo $locationForSearchIndex["loc"]; ?>'" >
				<?php endif; ?>
					<div class="menuImageDiv">
						<?php echo generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"id"		=>	"searchImage",
								"class"		=>	"menuImage mainMenuImage",
								"height"	=>	"30px",
								"data-src"	=>	$arrayOfImages["search"]
								)
							); 
						?>
					</div>
					Search
					<?php
					if($addonsAsIframe !== "true")
					{
						echo $externalLinkImage;
					}
					?>
				</li>
			<?php endif; ?>
			<?php if($locationForSeleniumMonitorIndex["loc"]): ?>
				<?php if($addonsAsIframe === "true"): ?>
					<li id="menuSeleniumMonitorAddon" onclick="toggleIframe('<?php echo $locationForSeleniumMonitorIndex["loc"]; ?>','menuSeleniumMonitorAddon');" >
				<?php else: ?>
					<li id="menuSeleniumMonitorAddon" onclick="window.location.href='<?php echo $locationForSeleniumMonitorIndex["loc"]; ?>'" >
				<?php endif; ?>
					<div class="menuImageDiv">
						<?php echo generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"id"		=>	"seleniumMonitorImage",
								"class"		=>	"menuImage mainMenuImage",
								"height"	=>	"30px",
								"data-src"	=>	$arrayOfImages["seleniumMonitor"]
								)
							); 
						?>
					</div>
					Selenium Monitor
					<?php
					if($addonsAsIframe !== "true")
					{
						echo $externalLinkImage;
					}
					?>
				</li>
			<?php endif; ?>
		</ul>

		<ul id="aboutSubMenu" class="settingsUl fullScreenMenuUL settingsUlSub">
			<li class="menuTitle" style="text-align: center;" >
				About
			</li>
			<li id="aboutSubMenuAbout" onclick="toggleAboutLogHog();" class="selected">
				About Log-Hog
			</li>
			<li id="aboutSubMenuWhatsNew" onclick="toggleWhatsNew();">
				What's New
			</li>
			<li id="aboutSubMenuChangelog" onclick="toggleChangeLog();">
				Changelog
			</li>
		</ul>
		<ul id="watchListSubMenu" class="settingsUl fullScreenMenuUL settingsUlSub" style="display: none;">
			<li class="menuTitle" style="text-align: center;" >
				Watchlist
			</li>
			<li onclick="addFile();" >
				Add File
			</li>
			<li onclick="addFolder();" >
				Add Folder
			</li>
			<li onclick="addOther();" >
				Add Other
			</li>
			<li id="condensedLink" onclick="toggleCondensed(true);" >
			<?php if($logShowMoreOptions === "false"): ?>
				Show More Options</li>
				<style type="text/css">
					.condensed
					{
						display: none;
					}
				</style>
			<?php else: ?>
				Show Condensed Options</li>
			<?php endif; ?>
		</ul>
		<ul id="settingsSubMenu" class="settingsUl fullScreenMenuUL settingsUlSub" style="display: none;">
			<li class="menuTitle" style="text-align: center;">
				Settings
			</li>
		</ul>
		<div id="mainContentFullScreenMenu">
			<div class="settingsHeader" style="position: fixed;width: 100%;z-index: 10;top: 0; margin: 0; border-bottom: 1px solid white; display: none;top: 46px;" id="fixedPositionMiniMenu" >
			</div>
			<div id="fullScreenMenuChangeLog" style="display: none;" >
				<?php require_once("core/php/template/changelog.php"); ?>
			</div>
			<div id="fullScreenMenuWhatsNew" style="display: none;" >
				<?php
				$imageDirModifierAbout = "";
				require_once('core/php/template/whatsNew.php');
				?>
			</div>
			<div id="fullScreenMenuAbout" >
				<?php require_once('core/php/template/about.php'); ?>
			</div>
			<div id="fullScreenMenuUpdate" style="display: none;">
				<?php require_once('core/php/template/update.php'); ?>
			</div>
			<div id="fullScreenMenuIFrame" style="display: none;">
				<iframe style="border: 0;" id="iframeFullScreen" src=""></iframe>
			</div>
			<div id="fullScreenMenuWatchList" style="display: none;">
				<?php
				$imageUrlModifier = "";
				require_once('core/php/settingsMainWatchFunctions.php');
				require_once('core/php/template/settingsMainWatch.php');
				?>
			</div>
		</div>
	</div>

	<form id="settingsInstallUpdate" action="update/updater.php" method="post" style="display: none"></form>
	<script>

		<?php
		if($rightClickMenuEnable == "true"): ?>
			var Rightclick_ID_list = [];
			if(document.getElementById('deleteImage'))
			{
				Rightclick_ID_list.push('deleteImage');
			}
			if(document.getElementById('pauseImage'))
			{
				Rightclick_ID_list.push('pauseImage');
			}
			<?php
		endif;
		if($levelOfUpdate !== 0 && $configStatic["version"] !== $dontNotifyVersion && $updateNotificationEnabled === "true"):
			if($updateNoticeMeter === "every" || $levelOfUpdate > 1):
				$updateImage = "";
				if($levelOfUpdate == 1)
				{
					$updateImage = json_encode(generateImage(
						$arrayOfImages["yellowWarning"],
						$imageConfig = array(
							"id"		=>	"updateImage",
							"class"		=>	"menuImage",
							"height"	=>	"15px"
						)
					));
				}
				elseif($levelOfUpdate == 2 || $levelOfUpdate == 3)
				{
					$updateImage = json_encode(generateImage(
						$arrayOfImages["redWarning"],
						$imageConfig = array(
							"id"		=>	"updateImage",
							"class"		=>	"menuImage",
							"height"	=>	"15px"
						)
					));
				}

				?>
				function addUpdateNotification()
				{
					var currentId = notifications.length;
					notifications[currentId] = new Array();
					notifications[currentId]["id"] = currentId;
					notifications[currentId]["name"] = "New Update: <?php echo $configStatic['newestVersion'];?>";
					notifications[currentId]["time"] = formatAMPM(new Date());
					notifications[currentId]["action"] = "toggleFullScreenMenu(); toggleUpdateMenu();";
					notifications[currentId]["image"] = <?php echo $updateImage; ?>;
				}
			<?php endif;
		endif;
		echo "var colorArrayLength = ".count($currentSelectedThemeColorValues).";";
		echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
		echo "var daysSinceLastCheck = '".$daysSince."';";
		echo "var windowDisplayConfigRowCount = ".$windowDisplayConfig[0].";";
		echo "var windowDisplayConfigColCount = ".$windowDisplayConfig[1].";";
		$srcForLoadImage = "core/img/loading.gif";
		if(isset($arrayOfImages))
		{
			$srcForLoadImage = $arrayOfImages["loading"]["src"];
		}
		?>
		var srcForLoadImage = "<?php echo $srcForLoadImage; ?>";
		var currentVersion = "<?php echo $configStatic['version'];?>";
		var baseUrl = "<?php echo $baseUrl;?>";
		var saveVerifyImage = <?php echo json_encode(generateImage(
			$arrayOfImages["greenCheck"],
			array(
				"height"		=>	"50px"
			)
		)); ?>
	</script>
	<?php require_once('core/php/template/popup.php') ?>
	<script src="core/js/lazyLoadImg.js?v=<?php echo $cssVersion?>"></script>
	<script src="core/js/main.js?v=<?php echo $cssVersion?>"></script>
	<script src="core/js/format.js?v=<?php echo $cssVersion?>"></script>
	<script src="core/js/rightClickJS.js?v=<?php echo $cssVersion?>"></script>
	<script src="core/js/update.js?v=<?php echo $cssVersion?>"></script>
	<script src="core/js/settings.js?v=<?php echo $cssVersion?>"></script>
	<nav id="context-menu" class="context-menu">
	  <ul id="context-menu-items" class="context-menu__items">
	  </ul>
	</nav>
</body>
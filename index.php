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
require_once("core/php/defaultConfData.php");

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
	$arrayOfImages["loadingImg"],
	$imageConfig = array(
		"height"	=>	"15px",
		"class"		=>	"mainMenuImage",
		"style"		=>	"margin-bottom: -10px;",
		"data-src"	=>  $arrayOfImages["externalLink"]
		)
	);
?>
<!doctype html>
<head>
	<title>Log Hog | Index</title>
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script type="text/javascript">
		var baseUrl = "<?php echo $baseUrl;?>";
		var Rightclick_ID_list = [];
	</script>
	<script src="core/js/lazyLoadImg.js?v=<?php echo $jsVersion?>"></script>
	<script src="core/js/jquery.js?v=<?php echo $jsVersion?>"></script>
	<script src="core/js/indexJs.js?v=<?php echo $jsVersion?>"></script>
	<?php
		echo loadSentryData($sendCrashInfoJS, $branchSelected);
		require_once("core/php/indexJsObjectCreator.php");
	?>
</head>
<body>
	<span id="mainContent" style="display: none;"  >
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
		<div id="inlineNotifications" class="inlineNotificationsClass" ></div>
		<div style="overflow: hidden; display: block;">
			<?php require_once("core/php/template/indexHeader.php"); ?>
			<div class="backgroundForMenus" id="menu" style="position: absolute; display: none;"></div>
			<span id="stars" style="display: block;" ></span>
			<span id="stars2" style="display: block;" ></span>
			<span id="stars3" style="display: block;" ></span>
		</div>
		<div id="popupSelectContainer" class="backgroundForMenus addBorder menu"  style="position: fixed;width: 200px; z-index: 99; display: none;"></div>
		<div style="display: inline-block; position: absolute; top: 0; left: 0; z-index: 30;" >
			<div id="notificationIcon">
				<span onclick="toggleNotifications();" id="notificationBadge"></span>
			</div>
			<div id="historyDropdown" class="dropdownMenu" >
				<div class="notificationTriangle"></div>
				<div id="historyHolder" class="innerContentDropdownMenu dropdownHolder"></div>
			</div>
		</div>
		<div id="main">
			<div id="settingsSideBar" class="fullScreenMenuLeftSidebar" style="display: none; position: absolute; width: 200px; overflow-y: auto;overflow-x: hidden; border: none;">
				<?php require_once('core/php/template/settingsSideBar.php'); ?>
			</div>
			<table id="log" style="display: none; margin: 0px;padding: 0px; border-spacing: 0px; width: 100%;" cellspacing="0" cellpadding="0">
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
		<div id="fullScreenMenu" class="smallBlur" style="display: none;">
			<?php require_once('core/php/template/fullScreenMenu.php'); ?>
		</div>

		<form id="settingsInstallUpdate" action="update/updater.php" method="post" style="display: none"></form>
		<form id="localLayout" style="display: none;" >
			<?php include("core/php/template/logLayoutInner.php"); ?>
		</form>
		<script>

			<?php
			if($rightClickMenuEnable == "true"): ?>
				if(document.getElementById('deleteImage'))
				{
					Rightclick_ID_list.push('deleteImage');
				}
				if(document.getElementById('pauseImage'))
				{
					Rightclick_ID_list.push('pauseImage');
				}
				if(document.getElementById('notificationBadge'))
				{
					Rightclick_ID_list.push('notificationBadge');
				}
				if(document.getElementById("notificationCount"))
				{
					Rightclick_ID_list.push('notificationCount');
				}
				if(document.getElementById("notificationBadge"))
				{
					Rightclick_ID_list.push('notificationBadge');
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
						notifications[currentId]["action"] = "toggleUpdateMenu();";
						notifications[currentId]["image"] = <?php echo $updateImage; ?>;
					}
				<?php endif;
			endif;
			echo "var colorArrayLength = ".count($currentSelectedThemeColorValues).";";
			echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
			echo "var daysSinceLastCheck = '".$daysSince."';";
			echo "var windowDisplayConfigRowCount = ".$windowDisplayConfig[0].";";
			echo "var windowDisplayConfigColCount = ".$windowDisplayConfig[1].";";
			echo "var updateIconYellowSrc = '".$arrayOfImages["updateYellow"]["src"]."';";
			echo "var updateIconRedSrc = '".$arrayOfImages["updateRed"]["src"]."';";
			$srcForLoadImage = "core/img/loading.gif";
			if(isset($arrayOfImages))
			{
				$srcForLoadImage = $arrayOfImages["loading"]["src"];
			}
			?>
			var srcForLoadImage = "<?php echo $srcForLoadImage; ?>";
			var currentVersion = "<?php echo $configStatic['version'];?>";
			var saveVerifyImage = <?php echo json_encode(generateImage(
				$arrayOfImages["greenCheck"],
				array(
					"height"		=>	"50px"
				)
			)); ?>
		</script>
		<?php require_once('core/php/template/popup.php'); ?>
		<nav id="context-menu" class="context-menu">
		  <ul id="context-menu-items" class="context-menu__items">
		  </ul>
		</nav>
	</span>
	<span id="initialLoadContent" style="background-color: #222; color: #EEE; -webkit-transition: 1s ease-in-out; -moz-transition: 1s ease-in-out; -ms-transition: 1s ease-in-out; -o-transition: 1s ease-in-out; position: absolute; z-index: 1000; left: 0; right: 0; top: 0; bottom: 0;" >
		<table style="width: 100%; height: 100%;">
			<tr>
				<th>
					<h2>Loading</h2>
					<p><img id="initialLoadSpinner" src="<?php echo $srcForLoadImage; ?>" width="100" height="100"></p>
					<h4 id="initialLoadContentInfo" >Loading CSS Files</h4>
					<p><progress id="initialLoadProgress" value="0" max="100"></progress></p>
					<h4 id="initialLoadContentMoreInfo" ></h4>
					<h5 id="initialLoadContentCountInfo" ></h5>
					<h5 id="initialLoadContentEvenMoreInfo" >File Check <span id="initialLoadCountCheck" >1</span> of 1000</h5>
					<h4 style="color: red; display: none;" id="initialLoadContentEvenEvenMoreInfo" >This file looks like it is taking a while to load</h4>
				</th>
			</tr>
		</table>
		<script type="text/javascript">
			document.addEventListener("DOMContentLoaded", function(event)
			{
				arrayOfJsFilesKeys = Object.keys(arrayOfJsFiles);
				lengthOfArrayOfJsFiles = arrayOfJsFilesKeys.length;
			  	setTimeout(function() {
					timerForLoadJS = setInterval(tryLoadJSStuff, 25);
				}, 25);
			});
		</script>
	</span>
</body>
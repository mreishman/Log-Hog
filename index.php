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
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script src="core/js/lazyLoadImg.js?v=<?php echo $cssVersion?>"></script>
	<?php
		echo loadSentryData($sendCrashInfoJS, $branchSelected);
	?>
</head>
<body>
	<span id="mainContent" style="display: none;" >
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
		<div style="overflow: hidden; display: block;">
			<?php require_once("core/php/template/indexHeader.php"); ?>
			<div class="backgroundForMenus" id="menu" style="position: static;"></div>
			<span id="stars" style="display: block;" ></span>
			<span id="stars2" style="display: block;" ></span>
			<span id="stars3" style="display: block;" ></span>
		</div>
		<div style="display: inline-block; position: absolute; top: 0; left: 0; z-index: 30;" >
			<div id="notificationIcon">
				<span onclick="toggleNotifications();" id="notificationCount"></span>
				<span onclick="toggleNotifications();" id="notificationBadge"></span>
			</div>
			<div id="notifications" class="dropdownMenu" >
				<div class="notificationTriangle"></div>
				<div id="notificationHolder" class="innerContentDropdownMenu dropdownHolder"></div>
			</div>
			<div id="historyDropdown" class="dropdownMenu" >
				<div class="notificationTriangle"></div>
				<div id="historyHolder" class="innerContentDropdownMenu dropdownHolder"></div>
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
			<?php require_once('core/php/template/fullScreenMenu.php'); ?>
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
				if(document.getElementById('notificationNotClicked'))
				{
					Rightclick_ID_list.push('notificationNotClicked');
				}
				if(document.getElementById('notificationClicked'))
				{
					Rightclick_ID_list.push('notificationClicked');
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
					<h5 id="initialLoadContentEvenMoreInfo" >File Check <span id="initialLoadCountCheck" >1</span> of 1000</h5>
					<h4 style="color: red; display: none;" id="initialLoadContentEvenEvenMoreInfo" >This file looks like it is taking a while to load</h4>
				</th>
			</tr>
		</table>
		<script type="text/javascript">
			var timerForLoadJS = null;
			var counterForJSLoad = 0;
			var loadedFile = false;
			var arrayOfJsFiles = {
				0:  {name: "core/template/base.css", type: "css"},
				1:  {name: "core/template/loading-bar.css", type: "css"},
				2:  {name: "<?php echo $baseUrl; ?>template/theme.css", type: "css"},
				3:  {name: "jquery.js", type: "js"},
				4:  {name: "visibility.core.js", type: "js"},
				5:  {name: "visibility.fallback.js", type: "js"},
				6:  {name: "visibility.timers.js", type: "js"},
				7:  {name: "loading-bar.min.js", type: "js"},
				8:  {name: "main.js", type: "js"},
				9:  {name: "format.js", type: "js"},
				10:  {name: "rightClickJS.js", type: "js"},
				11:  {name: "update.js", type: "js"},
				12:  {name: "settings.js", type: "js"},
				13: {name: "loghogDownloadJS.js", type: "js"},
				14: {name: "local/default/img/menu.png", type: "img", class:"menuImageForLoad"},
				15: {name: "local/default/img/notification.png", type: "img", class:"notificationImageForLoad"}
			};
			var countForCheck = 1;
			if(sendCrashInfoJS === "true")
			{
				var lengthOfArrayOfJsFiles = Object.keys(arrayOfJsFiles).length;
				arrayOfJsFiles[lengthOfArrayOfJsFiles] = {name: "Raven.js"};
			}
			var arrayOfJsFilesKeys = Object.keys(arrayOfJsFiles);
			var lengthOfArrayOfJsFiles = arrayOfJsFilesKeys.length;
			function tryLoadJSStuff()
			{
				if(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["type"] === "js")
				{
					if(document.getElementById("initialLoadContentInfo").innerHTML !== "Loading Javascript Files")
					{
						document.getElementById("initialLoadContentInfo").innerHTML = "Loading Javascript Files";
					}
				}
				else if(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["type"] === "css")
				{
					if(document.getElementById("initialLoadContentInfo").innerHTML !== "Loading CSS Files")
					{
						document.getElementById("initialLoadContentInfo").innerHTML = "Loading CSS Files";
					}
				}
				else if(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["type"] === "img")
				{
					if(document.getElementById("initialLoadContentInfo").innerHTML !== "Loading Images")
					{
						document.getElementById("initialLoadContentInfo").innerHTML = "Loading Images";
					}
				}
				if(typeof script === "function")
				{
					clearInterval(timerForLoadJS);
					loadedFile = false;
					timerForLoadJS = setInterval(checkIfJSLoaded, 25);
					var nameOfCurrentFile = arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["name"];
					document.getElementById("initialLoadContentMoreInfo").innerHTML = nameOfCurrentFile;
					var nameOfFile = nameOfCurrentFile+"?v=<?php echo $cssVersion?>";
					if(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["type"] === "js")
					{
						nameOfFile = "core/js/"+nameOfFile;
						script(nameOfFile);
						document.getElementById(nameOfFile.replace(/[^a-z0-9]/g, "")).addEventListener('load', function() {
							loadedFile = true;
						}, false);
					}
					else if(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["type"] === "css")
					{
						css(nameOfFile)
						document.getElementById(nameOfFile.replace(/[^a-z0-9]/g, "")).addEventListener('load', function() {
							loadedFile = true;
						}, false);
					}
					else if(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["type"] === "img")
					{
						loadImgFromData(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["class"]);
						document.getElementsByClassName(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["class"])[0].addEventListener('load', function() {
							loadedFile = true;
						}, false);
					}
				}
			}
			function checkIfJSLoaded()
			{
				if(loadedFile === true)
				{
					if(document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display !== "none")
					{
						document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display = "none";
					}
					countForCheck = 1;
					clearInterval(timerForLoadJS);
					counterForJSLoad++;
					document.getElementById("initialLoadProgress").value = ((counterForJSLoad/lengthOfArrayOfJsFiles) * 100);
					if(counterForJSLoad >= lengthOfArrayOfJsFiles)
					{
						document.getElementById("mainContent").style.display = "block";
						if(sendCrashInfoJS === "true")
						{
							startSentryStuff();
						}
						mainReady();
						$('#initialLoadContent').addClass("hidden");
						setTimeout(function()
						{
							if($("#initialLoadContent").hasClass("hidden"))
							{
								document.getElementById('initialLoadContent').style.display = "none";
							}
						}, 1000);
					}
					else
					{
						setTimeout(function() {
							timerForLoadJS = setInterval(tryLoadJSStuff, 25);
						}, 25);
					}
				}
				else
				{
					countForCheck++;
					document.getElementById("initialLoadCountCheck").innerHTML = countForCheck;
					if(countForCheck > 100)
					{
						if(document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display === "none")
						{
							document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display = "block";
						}
					}
					if(countForCheck > 1000)
					{
						//error
						clearInterval(timerForLoadJS);
						window.location.href = "error.php?error=15&page="+arrayOfJsFiles[counterForJSLoad];
					}
				}
			}
			document.addEventListener("DOMContentLoaded", function(event) { 
			  	setTimeout(function() {
					timerForLoadJS = setInterval(tryLoadJSStuff, 25);
				}, 25);
			});
		</script>
	</span>
</body>
<?php
require_once('core/php/commonFunctions.php');

$baseUrl = "core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = "local/";
	//there is custom information, use this
	require_once('local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
if(!file_exists($baseUrl.'conf/config.php'))
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/welcome.php";
	header('Location: ' . $url, true, 302);
	exit();
}
require_once($baseUrl.'conf/config.php');
require_once('core/conf/config.php');
require_once('core/php/configStatic.php');
require_once('core/php/loadVars.php');
require_once('core/php/updateCheck.php');

$daysSince = calcuateDaysSince($configStatic['lastCheck']);

if($pollingRateType == 'Seconds')
{
	$pollingRate *= 1000;
}
if($backgroundPollingRateType == 'Seconds')
{
	$backgroundPollingRate *= 1000;
}

$locationForStatusIndex = "";
if($locationForStatus != "")
{
	$locationForStatusIndex = $locationForStatus;
}
elseif (is_dir("../status"))
{
	$locationForStatusIndex = "../status/";
}
elseif (is_dir("../Status"))
{
	$locationForStatusIndex = "../Status/";
}

$locationForMonitorIndex = "";
if($locationForMonitor != "")
{
	$locationForMonitorIndex = $locationForMonitor;
}
elseif (is_dir("../monitor"))
{
	$locationForMonitorIndex = "../monitor/";
}
elseif (is_dir("../Monitor"))
{
	$locationForMonitorIndex = "../Monitor/";
}

?>
<!doctype html>
<head>
	<title>Search | Index</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>img/favicon.png" />
	<script src="core/js/jquery.js"></script>
	<?php
		echo loadSentryData($sendCrashInfoJS);
	?>
</head>
<body>
	<?php require_once("core/php/customCSS.php");
	if($enablePollTimeLogging != "false"): ?>
		<div id="loggTimerPollStyle" style="width: 100%;background-color: black;text-align: center; line-height: 200%;" ><span id="loggingTimerPollRate" >### MS /<?php echo $pollingRate; ?> MS</span> | <span id="loggSkipCount" >0</span>/<?php echo $pollForceTrue; ?> | <span id="loggAllCount" >0</span>/<?php echo $pollRefreshAll; ?></div>
	<?php endif; 
	require_once('core/php/template/menu.php');?>
	
	<div style="z-index: 5; bottom: 0;" id="main">

		<div style="height: 50px; z-index: 5;">
		</div>
		<?php
		$showNewSearch = false; 
		if(is_dir("savedSearches/")):
			$dir = "savedSearches/";
			$dir = array_diff(scandir($dir), array('..', '.'));
			if(count($dir) > 0):
				//show saved stuff
			else:
				$showNewSearch = true;
			endif;
		else:
			$showNewSearch = true;
		endif;
		?>
		<div class="containerMain" style="display: <?php if(!$showNewSearch){ echo "none"; }else{ echo "block"; }?> " id="newSearch" >
			<div onclick="showGrepPopup();" style="width: 100px; height: 100px; margin: 25px; display: inline-block; cursor: pointer;">
				<img src="core/img/search.png" style="width: 100px; height: 100px;">
				<p style="width: 100%; text-align: center;">New Grep</p>
			</div>
		</div>
	</div>

	<div id="newGrep" style="position: absolute; left: 5%; right: 5%; top: 10%; background-color: rgba(15,15,15,.9); border: 1px solid white; z-index: 10; display: none; box-shadow: 5px 5px 5px rgba(0,0,0,.5); backdrop-filter: blur(10px);" >
		<div class="paddingDiv">
			<p><span class="widthBreak">Directory:</span><input id="directoryInput" type="text" name="directory" style="width: 400px;" ></p> 
			<p><span class="widthBreak">Search For:</span><input id="searchInput" type="text" name="searchFor" style="width: 400px;"></p> 
		</div>
		<div class="paddingDiv" id="advanced" style="display: none;">
			<input type="checkbox" name="ignoreCase"> Ignore Case
		</div>
		<dir class="paddingDiv">
			<button onclick="scanDirCreate();">Run Grep</button>
			|
			<button onclick="hideNewGrep();">Cancel</button>
			<!-- 
			|
			<button onclick="showAdvanced();">Advanced</button>
			-->
		</dir>
	</div>

	<div id="storage">
		<div class="container">
			<div style="background-color: white; border: 1px solid black;" id="{{id}}" class="scanBar containerMain">
				<div>
					<progress style="color: white; background: #000000; width: 100%;" id="{{id}}Progress" value="0" max="1"></progress>
				</div>
				<div style="color: black; width: 100%; text-align: left;" id="{{id}}Title">
					<h3>
						<span id="{{id}}Folder">{{folder}}</span> - 
						"<span id="{{id}}Search">{{search}}</span>"
						<span id="{{id}}ProgressTxt" >--</span>%
						<div style="float: right;">
							<img id="{{id}}SaveSearch" onclick="saveSearch('{{id}'})" src="core/img/save.png" style="width: 25px; height: 25px; display: none; cursor: pointer; padding-right: 3px;">
							<img id="{{id}}Expand" style="width: 25px; height: 25px; margin-top: -4px; cursor: pointer; display: none;" onclick="toggleMainExpand('{{id}}');" src="core/img/expand.png">
							<img id="{{id}}Loading" style="width: 25px; height: 25px; margin-top: -4px; display: none;" src="core/img/loading.gif">
							<img id="{{id}}Contract" onclick="toggleMainExpand('{{id}}');" src="core/img/contract.png" style="width: 25px; height: 25px; margin-top: -4px; cursor: pointer; display: none;">
							<img onclick="deleteSearch('{{id}}');" src="core/img/trashCan2.png" style="width: 25px; height: 25px; margin-top: -4px; cursor: pointer;">
						</div>
					</h3>
				</div>
				<div id="{{id}}FoundThings" style="background-color: grey; max-height: 400px; border: 1px solid black; margin-top: 10px; overflow-y: scroll; display: none;">

				</div>
			</div>
		</div>
		<div class="notificationContainer">
			<div id="{{id}}">
				<span style="width: 100%;">
					<table style="width: 100%; padding-top: 5px; padding-bottom: 5px;" >
						<tr>
							<td style="border-right: 1px solid black; width: 65px;"> {{time}} </td>
							<td onclick="removeNotification('{{idNum}}'); {{action}}" style="padding-left: 5px; cursor: pointer; word-wrap:break-word;  word-break: break-all;"> {{name}} </td>
						</tr>
					</table>
				</span>
			</div>
		</div>
		<div class="notificationButtons">
			<div>
				<table style="width: 100%; border-top: 1px solid #aaa; padding-bottom: 3px; padding-top: 3px;">
					<tr>
						<th>
							<span style="cursor: pointer;" onclick="toggleNotifications();">Close</span>
						</th>
						<th>
							<span style="cursor: pointer;" onclick="removeAllNotifications();">Clear</span>
						</th>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<form id="settingsInstallUpdate" action="update/updater.php" method="post" style="display: none"></form>
	<script>
		
		var notifications = new Array(); //ID , Message , Action, Time
		<?php
		echo "var autoCheckUpdate = ".$autoCheckUpdate.";";
		echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
		echo "var daysSinceLastCheck = '".$daysSince."';";
		echo "var daysSetToUpdate = '".$autoCheckDaysUpdate."';";
		if($levelOfUpdate !== 0 && $configStatic["version"] !== $dontNotifyVersion): 
			if($updateNoticeMeter === "every" || $levelOfUpdate > 1): ?>
				function addUpdateNotification()
				{
					var currentId = notifications.length;

					notifications[currentId] = new Array();
					notifications[currentId]["id"] = currentId;
					notifications[currentId]["name"] = "New update available: <?php echo $configStatic['newestVersion'];?>";
					notifications[currentId]["time"] = formatAMPM(new Date());
					notifications[currentId]["action"] = "window.location = './settings/update.php';";
				}
			<?php endif; 
		endif; ?>
		var dontNotifyVersion = "<?php echo $dontNotifyVersion;?>";
		var currentVersion = "<?php echo $configStatic['version'];?>";
		var enableLogging = "<?php echo $enableLogging; ?>";
		var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray); ?>');
		var updateNoticeMeter = "<?php echo $updateNoticeMeter;?>";
		var baseUrl = "<?php echo $baseUrl;?>";
		var counter = 1;

	</script>
	<?php readfile('core/html/popup.html') ?>
	<script src="core/js/main.js?v=<?php echo $cssVersion?>"></script>

	<nav id="context-menu" class="context-menu">
	  <ul id="context-menu-items" class="context-menu__items">
	  </ul>
	</nav>


</body>
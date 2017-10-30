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
elseif(is_file("monitor/index.php"))
{
	$locationForMonitorIndex = './monitor/';
}
elseif (is_dir("../monitor"))
{
	$locationForMonitorIndex = "../monitor/";
}
elseif (is_dir("../Monitor"))
{
	$locationForMonitorIndex = "../Monitor/";
}

$locationForSearchIndex = "";
if($locationForSearch != "")
{
	$locationForSearchIndex = $locationForSearch;
}
elseif(is_file("search/index.php"))
{
	$locationForSearchIndex = './search/';
}
elseif (is_dir("../search"))
{
	$locationForSearchIndex = "../search/";
}
elseif (is_dir("../Search"))
{
	$locationForSearchIndex = "../Search/";
}

?>
<!doctype html>
<head>
	<title>Log Hog | Index</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>img/favicon.png" />
	<script src="core/js/jquery.js"></script>
	<?php
		echo loadSentryData($sendCrashInfoJS, $branchSelected);
		echo loadVisibilityJS(baseURL());
	?>
</head>
<body>
	<?php require_once("core/php/customCSS.php");
	if($enablePollTimeLogging != "false"): ?>
		<div id="loggTimerPollStyle" style="width: 100%;background-color: black;text-align: center; line-height: 200%;" ><span id="loggingTimerPollRate" >### MS /<?php echo $pollingRate; ?> MS</span> | <span id="loggSkipCount" >0</span>/<?php echo $pollForceTrue; ?> | <span id="loggAllCount" >0</span>/<?php echo $pollRefreshAll; ?></div>
	<?php endif; ?>
	<div class="backgroundForMenus" id="menu">
		<div id="menuButtons" style="display: block;">
			<div onclick="pausePollAction();" class="menuImageDiv">
				<img id="playImage" class="menuImage" src="<?php echo $baseUrl; ?>img/Play.png"
					<?php if($pausePoll !== 'true'):?>
						style="display: none;"
					<?php else: ?>
						style="display: inline-block;"
					<?php endif;?>
				height="30px">
				<img id="pauseImage" class="menuImage" src="<?php echo $baseUrl; ?>img/Pause.png"
					<?php if($pausePoll === 'true'):?>
						style="display: none;"
					<?php else: ?>
						style="display: inline-block;"
					<?php endif;?>
				height="30px">
			</div>
			<div onclick="refreshAction();" class="menuImageDiv">
				<img id="refreshImage" class="menuImage" src="<?php echo $baseUrl; ?>img/Refresh.png" height="30px">
				<img id="refreshingImage" class="menuImage" style="display: none;" src="<?php echo $baseUrl; ?>img/loading.gif" height="30px">
			</div>
			<?php if($truncateLog == 'true'): ?>
			<div onclick="deleteAction();"  class="menuImageDiv">
				<img id="deleteImage" class="menuImage" src="<?php echo $baseUrl; ?>img/trashCanMulti.png" height="30px">
			</div>
			<?php else: ?>
			<div onclick="clearLog();" class="menuImageDiv">
				<img id="deleteImage" class="menuImage" src="<?php echo $baseUrl; ?>img/trashCan.png" height="30px">
			</div>
			<?php endif; ?>
			<?php if($locationForMonitorIndex != ""): ?>
			<div onclick="window.location.href = '<?php echo $locationForMonitorIndex; ?>'"  class="menuImageDiv">
				<img id="taskmanagerImage" class="menuImage" src="<?php echo $baseUrl; ?>img/task-manager.png" height="30px">
			</div>
			<?php endif; ?>
			<?php if($locationForSearchIndex != ""): ?>
			<div onclick="window.location.href = '<?php echo $locationForSearchIndex; ?>'"  class="menuImageDiv">
				<img id="searchImage" class="menuImage" src="<?php echo $baseUrl; ?>img/search.png" height="30px">
			</div>
			<?php endif; ?>
			<div onclick="window.location.href = './settings/main.php';"  class="menuImageDiv">
				<img data-id="1" id="gear" class="menuImage" src="<?php echo $baseUrl; ?>img/Gear.png" height="30px">
				<?php if($updateNotificationEnabled === "true")
				{
					if($levelOfUpdate == 1)
					{
						echo '<img id="updateImage" src="'.$baseUrl.'img/yellowWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';
					}
					elseif($levelOfUpdate == 2 || $levelOfUpdate == 3)
					{
						echo '<img id="updateImage" src="'.$baseUrl.'img/redWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';
					}
				}?>
			</div>
			<?php if ($locationForStatusIndex != ""):?>
				<div class="menuImage" style="display: inline-block; cursor: pointer;" onclick="window.location.href='<?php echo $locationForStatusIndex; ?>'" >
					gS
				</div>
			<?php endif; ?>
			<div style="float: right;">
				<select name="searchType" style="display: none;">
					<option selected value="title">Title</option>
				</select>
				<input id="searchFieldInput" type="search" name="search" placeholder="filter title" style="height: 30px; width: 200px;">
			</div>
		</div>
	</div>
	
	<div id="main">
		<div id="log"></div>
		<div id="firstLoad" style="width: 100%; height: 100%;">
			<h1 style="margin-right: auto; margin-left: auto; width: 100%; text-align: center;  margin-top: 100px; font-size: 150%;" >Loading...</h1>
			<div style="width: 80%; height: 50px; background-color: #999; border: 1px solid white; margin-left: auto; margin-right: auto;">
				<progress id="progressBar" value="0" max="100" style="width: 100%; height: 100%; -webkit-appearance: none; appearance: none;" ></progress>
			</div>
			<h3 id="progressBarSubInfo" style="margin-right: auto; margin-left: auto; width: 100%; text-align: center;  margin-top: 10px; font-size: 150%;" >Loading Javascript</h3>
		</div>
	</div>
	
	<div id="storage">
		<div class="menuItem">
			<a class="{{id}}Button {{class}}" onclick="show(this, '{{id}}')">{{title}}</a>
		</div>
	</div>
	
	<div
		class="backgroundForMenus" 
		style=" 
		<?php
		if($bottomBarIndexShow == 'false')
		{
			echo 'display: none;';
		}
		?>"
		id="titleContainer"
	>
		<div id="title">
			&nbsp;
		</div>
		&nbsp;&nbsp;
		<form style="display: inline-block; float: right;" >
			<a class="linkSmall" onclick="clearLog()" >
				Clear Log
			</a>
			<a class="linkSmall" onclick="deleteLogPopup()" >
				Delete Log
			</a>
		</form>
	</div>
	<form id="settingsInstallUpdate" action="update/updater.php" method="post" style="display: none"></form>
	<script>

		<?php
		if($rightClickMenuEnable == "true"): ?>
			var Rightclick_ID_list = [];
			if(document.getElementById('gear'))
			{
				Rightclick_ID_list.push('gear');
			}
			if(document.getElementById('deleteImage'))
			{
				Rightclick_ID_list.push('deleteImage');
			}
			<?php
			if($levelOfUpdate == 1 || $levelOfUpdate == 2 || $levelOfUpdate == 3)
			{
				echo "Rightclick_ID_list.push('updateImage');";
			}
		endif;
		echo "var colorArrayLength = ".count($currentSelectedThemeColorValues).";";
		echo "var pausePollOnNotFocus = ".$pauseOnNotFocus.";";
		echo "var autoCheckUpdate = ".$autoCheckUpdate.";";
		echo "var flashTitleUpdateLog = ".$flashTitleUpdateLog.";";
		echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
		echo "var daysSinceLastCheck = '".$daysSince."';";
		echo "var daysSetToUpdate = '".$autoCheckDaysUpdate."';";
		echo "var pollingRate = ".$pollingRate.";";
		echo "var backgroundPollingRate = ".$backgroundPollingRate.";";
		echo "var pausePollFromFile = ".$pausePoll.";";
		echo "var groupByColorEnabled = ".$groupByColorEnabled.";";
		echo "var pollForceTrue = ".$pollForceTrue.";";
		echo "var pollRefreshAll = ".$pollRefreshAll.";";
		?>
		var dontNotifyVersion = "<?php echo $dontNotifyVersion;?>";
		var currentVersion = "<?php echo $configStatic['version'];?>";
		var enablePollTimeLogging = "<?php echo $enablePollTimeLogging;?>";
		var enableLogging = "<?php echo $enableLogging; ?>";
		var groupByType = "<?php echo $groupByType; ?>";
		var hideEmptyLog = "<?php echo $hideEmptyLog; ?>";
		var currentFolderColorTheme = "<?php echo $currentFolderColorTheme; ?>";
		var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray); ?>');
		var updateNoticeMeter = "<?php echo $updateNoticeMeter;?>";
		var pollRefreshAllBool = "<?php echo $pollRefreshAllBool;?>";
		var pollForceTrueBool = "<?php echo $pollRefreshAllBool;?>";
		var baseUrl = "<?php echo $baseUrl;?>";

	</script>
	<?php readfile('core/html/popup.html') ?>
	<script src="core/js/main.js?v=<?php echo $cssVersion?>"></script>
	<script src="core/js/rightClickJS.js?v=<?php echo $cssVersion?>"></script>	
	<script src="core/js/update.js?v=<?php echo $cssVersion?>"></script>
	<nav id="context-menu" class="context-menu">
	  <ul id="context-menu-items" class="context-menu__items">
	  </ul>
	</nav>


</body>
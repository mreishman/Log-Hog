<?php
function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
}

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

$today = date('Y-m-d');
$old_date = $configStatic['lastCheck'];
$old_date_array = preg_split("/-/", $old_date);
$old_date = $old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1];

$datetime1 = date_create($old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1]);
$datetime2 = date_create($today);
$interval = date_diff($datetime1, $datetime2);
$daysSince = $interval->format('%a');

if($pollingRateType == 'Seconds')
{
	$pollingRate *= 1000;
}

require_once('top/statusTest.php');
$withLogHog = $monitorStatus['withLogHog'];

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
elseif($withLogHog == 'true')
{
	$locationForMonitorIndex = './top/index.php';
}

?>
<!doctype html>
<head>
	<title>Log Hog | Index</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<script src="core/js/jquery.js"></script>
	<script src="core/js/visibility.core.js"></script>
	<script src="core/js/visibility.fallback.js"></script>
	<script src="core/js/visibility.js"></script>
	<script src="core/js/visibility.timers.js"></script>
</head>
<body>
<style type="text/css">
	#menu a, .link, .linkSmall, .context-menu{
		background-color: <?php echo $currentSelectedThemeColorValues[0]?>;
	}
</style>
	<?php if($enablePollTimeLogging != "false"): ?>
		<div id="loggTimerPollStyle" style="width: 100%;background-color: black;text-align: center; line-height: 200%;" ><span id="loggingTimerPollRate" >### MS /<?php echo $pollingRate; ?> MS</span> | <span id="loggSkipCount" >0</span>/<?php echo $pollForceTrue; ?> | <span id="loggAllCount" >0</span>/<?php echo $pollRefreshAll; ?></div>
	<?php endif; ?>
	<div id="menu">
		<div onclick="pausePollAction();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<?php if($pausePoll == 'true'):?>
				<img id="pauseImage" class="menuImage" src="core/img/Play.png" height="30px">
			<?php else: ?>
				<img id="pauseImage" class="menuImage" src="core/img/Pause.png" height="30px">
			<?php endif;?>
		</div>
		<div onclick="refreshAction();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="refreshImage" class="menuImage" src="core/img/Refresh.png" height="30px">
		</div>
		<?php if($truncateLog == 'true'): ?>
		<div onclick="deleteAction();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="deleteImage" class="menuImage" src="core/img/trashCanMulti.png" height="30px">
		</div>
		<?php else: ?>
		<div onclick="clearLog();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="deleteImage" class="menuImage" src="core/img/trashCan.png" height="30px">
		</div>
		<?php endif; ?>
		<?php if($locationForMonitorIndex != ""): ?>
		<div onclick="window.location.href = '<?php echo $locationForMonitorIndex; ?>'" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="taskmanagerImage" class="menuImage" src="core/img/task-manager.png" height="30px">
		</div>
		<?php endif; ?>
		<div onclick="window.location.href = './settings/main.php';" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img data-id="1" id="gear" class="menuImage" src="core/img/Gear.png" height="30px">
			<?php  if($levelOfUpdate == 1){echo '<img id="updateImage" src="core/img/yellowWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';} ?> <?php if($levelOfUpdate == 2 || $levelOfUpdate == 3){echo '<img id="updateImage" src="core/img/redWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';} ?>
		</div>
		<?php if ($locationForStatusIndex != ""):?>
			<div style="display: inline-block; cursor: pointer; " onclick="window.location.href='<?php echo $locationForStatusIndex; ?>'" >gS</div>
		<?php endif; ?>
	</div>
	
	<div id="main">
		<div id="log"></div>
		<!-- 
		<div id="firstLoad" style="width: 100%; height: 100%;">
			<h1 style="margin-right: auto; margin-left: auto; width: 100%; text-align: center;  margin-top: 100px; font-size: 150%;" >Loading...</h1>
			<div style="width: 80%; height: 50px; background-color: #999; border: 1px solid white; margin-left: auto; margin-right: auto;">
			
			</div>
		</div>
		-->
	</div>
	
	<div id="storage">
		<div class="menuItem">
			<a style="{{style}}" class="{{id}}Button" onclick="show(this, '{{id}}')">{{title}}</a>
		</div>
	</div>
	
	<div style=" <?php if($bottomBarIndexShow == 'false'){echo 'display: none;';}?> " id="titleContainer"><div id="title">&nbsp;</div>&nbsp;&nbsp;<form style="display: inline-block; float: right;" ><a class="linkSmall" onclick="clearLog()" >Clear Log</a><a class="linkSmall" onclick="deleteLogPopup()" >Delete Log</a></form></div>
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
		echo "var currentFolderColorThemeArrayOfColors = JSON.parse('".json_encode($currentSelectedThemeColorValues)."');";
		echo "var pausePollOnNotFocus = ".$pauseOnNotFocus.";";
		echo "var autoCheckUpdate = ".$autoCheckUpdate.";";
		echo "var flashTitleUpdateLog = ".$flashTitleUpdateLog.";";
		echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
		echo "var daysSinceLastCheck = '".$daysSince."';";
		echo "var daysSetToUpdate = '".$autoCheckDaysUpdate."';";
		echo "var pollingRate = ".$pollingRate.";";
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

	</script>
	<?php readfile('core/html/popup.html') ?>
	<script src="core/js/main.js"></script>
	<script src="core/js/rightClickJS.js"></script>	

	<nav id="context-menu" class="context-menu">
	  <ul id="context-menu-items" class="context-menu__items">
	  </ul>
	</nav>


</body>
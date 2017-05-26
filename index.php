<?php
$baseUrl = "core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = "local/";
	//there is custom information, use this
	require_once('local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('core/conf/config.php');
require_once('core/php/configStatic.php');  

$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update

$newestVersionCount = count($newestVersion);
$versionCount = count($version);

for($i = 0; $i < $newestVersionCount; $i++)
{
	if($i < $versionCount)
	{
		if($i == 0)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 3;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		elseif($i == 1)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 2;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		else
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 1;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
	}
	else
	{
		$levelOfUpdate = 1;
		break;
	}
}

require_once('core/php/loadVars.php');

$today = date('Y-m-d');
$old_date = $configStatic['lastCheck'];
$old_date_array = split("-", $old_date);
$old_date = $old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1];

$datetime1 = date_create($old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1]);
$datetime2 = date_create($today);
$interval = date_diff($datetime1, $datetime2);
$daysSince = $interval->format('%a');

if($pollingRateType == 'Seconds')
{
	$pollingRate *= 1000;
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
		<div id="loggTimerPollStyle" style="width: 100%;background-color: black;text-align: center; line-height: 200%;" ><span id="loggingTimerPollRate" >### MS /<?php echo $pollingRate; ?> MS</span></div>
	<?php endif; ?>
	<div id="menu">
		<div onclick="pausePollAction();" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="pauseImage" class="menuImage" src="core/img/Pause.png" height="30px">
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
		<?php if($enableHtopLink == 'true'): ?>
			<div onclick="window.location.href = './core/php/statusTest.php'" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
				<img id="taskmanagerImage" class="menuImage" src="core/img/task-manager.png" height="30px">
			</div>
		<?php endif; ?>
		<div onclick="window.location.href = './settings/main.php';" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img data-id="1" id="gear" class="menuImage" src="core/img/Gear.png" height="30px">
			<?php  if($levelOfUpdate == 1){echo '<img src="core/img/yellowWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';} ?> <?php if($levelOfUpdate == 2 || $levelOfUpdate == 3){echo '<img src="core/img/redWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';} ?>

			 <div class="task__actions">
		        <i class="fa fa-eye"></i>
		        <i class="fa fa-edit"></i>
		        <i class="fa fa-times"></i>
		      </div>

		</div>
		<?php if (is_dir("../status")):?>
			<div style="display: inline-block; cursor: pointer; " onclick="window.location.href='../status/'" >gS</div>
		<?php endif; ?>
	</div>
	
	<div id="main">
		<div id="log"></div>
	</div>
	
	<div id="storage">
		<div class="menuItem">
			<a style="{{style}}" class="{{id}}Button" onclick="show(this, '{{id}}')">{{title}}</a>
		</div>
	</div>
	
	<div id="titleContainer"><div id="title">&nbsp;</div>&nbsp;&nbsp;<form style="display: inline-block;" ><a class="linkSmall" onclick="clearLog()" >Clear Log</a><a class="linkSmall" onclick="deleteLogPopup()" >Delete Log</a></form></div>
	<form id="settingsInstallUpdate" action="../update/updater.php" method="post" style="display: none"></form>
	<script>
		<?php
			
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
		?>
		var dontNotifyVersion = "<?php echo $dontNotifyVersion;?>";
		var currentVersion = "<?php echo $configStatic['version'];?>";
		var enablePollTimeLogging = "<?php echo $enablePollTimeLogging;?>";
		var enableLogging = "<?php echo $enableLogging; ?>";
		var groupByType = "<?php echo $groupByType; ?>";
		var hideEmptyLog = "<?php echo $hideEmptyLog; ?>";
		var currentFolderColorTheme = "<?php echo $currentFolderColorTheme; ?>";
		var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray); ?>');
		var pausePoll = false;
		var refreshActionVar;
		var refreshPauseActionVar;
		var userPaused = false;
		var refreshing = false;
	</script>
	<?php readfile('core/html/popup.html') ?>
	<script src="core/js/main.js"></script>
	<script src="core/js/rightClickJS.js"></script>	

	<nav id="context-menu" class="context-menu">
	  <ul class="context-menu__items">
	    <li class="context-menu__item">
	      <a href="#" class="context-menu__link">
	        <i class="fa fa-eye"></i> View Task
	      </a>
	    </li>
	    <li class="context-menu__item">
	      <a href="#" class="context-menu__link">
	        <i class="fa fa-edit"></i> Edit Task
	      </a>
	    </li>
	    <li class="context-menu__item">
	      <a href="#" class="context-menu__link">
	        <i class="fa fa-times"></i> Delete Task
	      </a>
	    </li>
	  </ul>
	</nav>


</body>
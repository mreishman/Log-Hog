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
$beta = false;

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
				$beta = true;
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
				$beta = true;
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
				$beta = true;
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
if(array_key_exists('truncateLogButtonAll', $config))
{
	$truncateLog = $config['truncateLogButtonAll'];
}
else
{
	$truncateLog = $defaultConfig['truncateLogButtonAll'];
}

if(array_key_exists('autoCheckDaysUpdate', $config))
{
	$autoCheckDaysUpdate = $config['autoCheckDaysUpdate'];
}
else
{
	$polliautoCheckDaysUpdatengRateType = $defaultConfig['autoCheckDaysUpdate'];
}
if(array_key_exists('enableHtopLink', $config))
{
	$enableHtopLink = $config['enableHtopLink'];
}
else
{
	$enableHtopLink = $defaultConfig['enableHtopLink'];
}
if(array_key_exists('popupSettingsCustom', $config))
{
	$popupSettingsArray = $config['popupSettingsCustom'];
}
else
{
	$popupSettingsArray = $defaultConfig['popupSettingsCustom'];
}

$today = date('Y-m-d');
$old_date = $configStatic['lastCheck'];
$old_date_array = split("-", $old_date);
$old_date = $old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1];
//$old_date = date_format( $old_date ,"Y-m-d");          
//$old_date_timestamp = strtotime($old_date);
//$new_date = date('Y-m-d', $old_date_timestamp); 

$datetime1 = date_create($old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1]);
$datetime2 = date_create($today);
$interval = date_diff($datetime1, $datetime2);
$daysSince = $interval->format('%a');


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
	<?php if($beta): ?>
		<div style="width: 100%;color: red;background-color: black;text-align: center; line-height: 200%;" >You are currently on a beta branch. - Only intended for development purposes</div>
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
			<img id="gear" class="menuImage" src="core/img/Gear.png" height="30px">
			<?php  if($levelOfUpdate == 1){echo '<img src="core/img/yellowWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';} ?> <?php if($levelOfUpdate == 2){echo '<img src="core/img/redWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';} ?>
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
	
	<script>
		<?php
			if(array_key_exists('pollingRate', $config))
			{
				echo "var pollingRate = ".$config['pollingRate'].";";
			}
			else
			{
				echo "var pollingRate = ".$defaultConfig['pollingRate'].";";
			} 
			if(array_key_exists('pollingRateType', $config))
			{
				$pollingRateType = $config['pollingRateType'];
			}
			else
			{
				$pollingRateType = $defaultConfig['pollingRateType'];
			}
			if($pollingRateType == 'Seconds')
			{
				echo "pollingRate *= 1000;";
			}
			if(array_key_exists('pausePoll', $config))
			{
				echo "var pausePollFromFile = ".$config['pausePoll'].";";
			}
			else
			{
				echo "var pausePollFromFile = ".$defaultConfig['pausePoll'].";";
			}
			if(array_key_exists('pauseOnNotFocus', $config))
			{
				echo "var pausePollOnNotFocus = ".$config['pauseOnNotFocus'].";";
			}
			else
			{
				echo "var pausePollOnNotFocus = ".$defaultConfig['pauseOnNotFocus'].";";
			}
			if(array_key_exists('autoCheckUpdate', $config))
			{
				echo "var autoCheckUpdate = ".$config['autoCheckUpdate'].";";
			}
			else
			{
				echo "var autoCheckUpdate = ".$defaultConfig['autoCheckUpdate'].";";
			}
			if(array_key_exists('flashTitleUpdateLog', $config))
			{
				echo "var flashTitleUpdateLog = ".$config['flashTitleUpdateLog'].";";
			}
			else
			{
				echo "var flashTitleUpdateLog = ".$defaultConfig['flashTitleUpdateLog'].";";
			}
		echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
		echo "var daysSinceLastCheck = '".$daysSince."';";
		echo "var daysSetToUpdate = '".$autoCheckDaysUpdate."';";
		?>
		var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
		var pausePoll = false;
		var refreshActionVar;
		var refreshPauseActionVar;
		var userPaused = false;
		var refreshing = false;
	</script>
	
	<script src="core/js/main.js"></script>
	<?php readfile('core/html/popup.html') ?>	
</body>
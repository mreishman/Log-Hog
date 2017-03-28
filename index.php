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
		<div onclick="window.location.href = './settings/main.php';" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="gear" class="menuImage" src="core/img/Gear.png" height="30px">
			<?php  if($levelOfUpdate == 1){echo '<img src="core/img/yellowWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';} ?> <?php if($levelOfUpdate == 2){echo '<img src="core/img/redWarning.png" height="15px" style="position: absolute;margin-left: 13px;margin-top: -34px;">';} ?>
		</div>
	</div>
	
	<div id="main">
		<div id="log"></div>
	</div>
	
	<div id="storage">
		<div class="menuItem">
			<a class="{{id}}Button" onclick="show(this, '{{id}}')">{{title}}</a>
		</div>
	</div>
	
	<div id="title">&nbsp;</div>
	
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
		echo "var dateOfLastUpdate = '".$configStatic['lastCheck']."';";
		?>

		var pausePoll = false;
		var refreshActionVar;
		var refreshPauseActionVar;
		var userPaused = false;
		var refreshing = false;
	</script>
	
	<script src="core/js/main.js"></script>
</body>
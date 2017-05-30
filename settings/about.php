<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');

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

require_once('../core/php/loadVars.php');
?>
<!doctype html>
<head>
	<title>Settings | About</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
		<div class="settingsHeader">
			About
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Version - <?php echo $configStatic['version'];?></h2>
				</li>
			</ul>
		</div>
		<div class="settingsHeader">
			Info
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Log-Hog</h2>
				</li>
				<li>
					<p>A simple log monitoring tool that is intended for use on dev boxes.</p>

					<p>If you need Log Hog to watch Apache's logs, see this: <a href="https://stackoverflow.com/questions/9568118/apache-access-log-automatically-set-permissions">https://stackoverflow.com/questions/9568118/apache-access-log-automatically-set-permissions</a></p>
				</li>
				<li>
					<p>Includes files from the following project: </p>

					<p> <a href="https://github.com/ai/visibilityjs">https://github.com/ai/visibilityjs </a> </p> 
				</li>
			</ul>
		</div>
		<div class="settingsHeader">
			GitHub
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Github</h2>
				</li>
				<li>
					<p>View the project on github: <a href="https://github.com/mreishman/Log-Hog">https://github.com/mreishman/Log-Hog</a> </p>

					<p>Add an issue: <a href="https://github.com/mreishman/Log-Hog/issues">https://github.com/mreishman/Log-Hog/issues</a></p>
				</li>
			</ul>
		</div>
	</div>
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
	function goToUrl(url)
	{
		window.location.href = url;
	}
</script>
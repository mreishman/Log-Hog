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
require_once('../core/php/configStatic.php');
//$timestamp = date('m-d-Y');

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

?>
<!doctype html>
<head>
	<title>Log Hog | Settings</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<div id="menu">
		<div onclick="window.location.href = '../index.php'" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
			<img id="pauseImage" class="menuImage" src="../core/img/backArrow.png" height="30px">
		</div>
		<a onclick="window.location.href = 'main.php';" >Main</a>
		<a onclick="window.location.href = 'about.php';">About</a>
		<a class="active">Update</a>
	</div>
	
	

	<div id="main">
		<div class="settingsHeader">
			Update
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Current Version - <?php echo $configStatic['version'];?></h2>
				</li>	
				<li>
					<h2>Last Check for updates -  <?php echo $configStatic['lastCheck'];?></h2>
				</li>
				<li>
					<form id="settingsCheckForUpdate" action="../core/php/settingsCheckForUpdate.php" method="post">
					<button onclick="checkForUpdates();">Check for updates</button>
					</form>
				</li>
				<li id="noUpdate" <?php if($levelOfUpdate != 0){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage1" src="../core/img/greenCheck.png" height="15px"> &nbsp; No new updates - You are on the current version!</h2>
				</li>
				<li id="minorUpdate" <?php if($levelOfUpdate != 1){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage2" src="../core/img/yellowWarning.png" height="15px"> &nbsp; Minor Updates - <?php echo $configStatic['newestVersion'];?> - bug fixes </h2>
				</li>
				<li id="majorUpdate" <?php if($levelOfUpdate != 2){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage3" src="../core/img/redWarning.png" height="15px"> &nbsp; Major Updates - <?php echo $configStatic['newestVersion'];?> - new features!</h2>
				</li>
				<li id="NewXReleaseUpdate" <?php if($levelOfUpdate != 3){echo "style='display: none;'";} ?> >
					<h2><img id="statusImage3" src="../core/img/redWarning.png" height="15px"><img id="statusImage3" src="../core/img/redWarning.png" height="15px"><img id="statusImage3" src="../core/img/redWarning.png" height="15px"> &nbsp; Very Major Updates - <?php echo $configStatic['newestVersion'];?> - a lot of new features!</h2>
				</li>
			</ul>
		</div>
		<div id="releaseNotesHeader" style="display: none;" class="settingsHeader">
			Update - Release Notes
		</div>
		<div id="releaseNotesBody" style="display: none;" class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Changelog For X.X update</h2>
				</li>
				<li>
					X.X
					<ul>
						<li>
							...
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="settingsHeader">
			Changelog
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Changelog</h2>
				</li>
				<li>
					2.0
					<ul>
						<li>
							Changed directory structure
						</li>
						<li>
							Added settings page
						</li>
						<li>
							Added upgrade page
						</li>
					</ul>
				</li>
				<li>
					1.3
					<ul>
						<li>
							Added Un-pause on focus
						</li>
						<li>
							Dynamic title of page (reflects status of paused and refreshing)
						</li>
					</ul>
				</li>
				<li>
					1.2
					<ul>
						<li>
							Added Refresh button
						</li>
					</ul>
				</li>
				<li>
					1.1
					<ul>
						<li>
							Added Pause / Play button
						</li>
					</ul>
				</li>
				<li>
					1.0
					<ul>
						<li>
							Initial Forked version from craig-russell
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</body>
<script src="../core/js/settings.js"></script>
<script type="text/javascript">
function checkForUpdates()
{

}
</script>
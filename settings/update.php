<?php
require_once('../core/php/commonFunctions.php');
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');

$daysSince = calcuateDaysSince($configStatic['lastCheck']);
?>
<!doctype html>
<head>
	<title>Settings | Update</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
	<script src="../core/js/update.js?v=<?php echo $cssVersion; ?>"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	
	<div id="main">
		<div class="settingsHeader">
			Update
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<h2>Current Version of Log-Hog: <?php echo $configStatic['version'];?></h2>
				</li>	
				<li>
					<h2>You last checked for updates
						<span id="spanNumOfDaysUpdateSince" >
							<u onclick="checkForUpdates();" style="cursor: pointer;" > <?php echo $daysSince;?> Day<?php if($daysSince != 1){ echo "s";} ?></u>
						</span>
						 Ago
					</h2>
				</li>
				<li>
					<form id="settingsCheckForUpdate" style="float: left; padding: 10px;">
					<a class="link" onclick="checkForUpdates();">Check for updates</a>
					</form>
					<form id="settingsInstallUpdate" action="../update/updater.php" method="post" style="padding: 10px;">
					<?php
					if($levelOfUpdate != 0){echo '<a class="link" onclick="installUpdates();">Install '.$configStatic["newestVersion"].' Update</a>';}
					?>
					</form>
				</li>
				<li id="noUpdate" <?php if($levelOfUpdate != 0){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo generateImage(
							$arrayOfImages["greenCheck"],
							$imageConfig = array(
								"id"			=>	"statusImage1",
								"height"		=>	"15px",
								"srcModifier"	=> "../"
							)
						);
						?>
						&nbsp; No new updates - You are on the current version!
					</h2>
				</li>
				<li id="minorUpdate" <?php if($levelOfUpdate != 1){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo generateImage(
							$arrayOfImages["yellowWarning"],
							$imageConfig = array(
								"id"			=>	"statusImage2",
								"height"		=>	"15px",
								"srcModifier"	=> "../"
							)
						);
						?>
						&nbsp; Minor Updates -
						<span id="minorUpdatesVersionNumber">
							<?php echo " ".$configStatic['newestVersion']." ";?>
						</span>
						- bug fixes 
					</h2>
				</li>
				<li id="majorUpdate" <?php if($levelOfUpdate != 2){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo generateImage(
							$arrayOfImages["redWarning"],
							$imageConfig = array(
								"id"			=>	"statusImage3",
								"height"		=>	"15px",
								"srcModifier"	=> "../"
							)
						);
						?>
						&nbsp; Major Updates -
						<span id="majorUpdatesVersionNumber">
							<?php echo " ".$configStatic['newestVersion']." ";?>
						</span>
						- new features!</h2>
				</li>
				<li id="NewXReleaseUpdate" <?php if($levelOfUpdate != 3){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo generateImage(
							$arrayOfImages["redWarning"],
							$imageConfig = array(
								"id"			=>	"statusImage3",
								"height"		=>	"30px",
								"srcModifier"	=> "../"
							)
						);
						?>
						&nbsp; Very Major Updates -
						<span id="veryMajorUpdatesVersionNumber">
							<?php echo " ".$configStatic['newestVersion']." ";?>
						</span>
						- a lot of new features!
					</h2>
				</li>
			</ul>
		</div>
		<div id="releaseNotesHeader" <?php if($levelOfUpdate == 0){echo "style='display: none;'";} ?> class="settingsHeader">
			Release Notes
		</div>
		<div id="releaseNotesBody" <?php if($levelOfUpdate == 0){echo "style='display: none;'";} ?> class="settingsDiv" >
			<ul id="settingsUl">
			<?php
			if(array_key_exists('versionList', $configStatic))
			{
				foreach ($configStatic['versionList'] as $key => $value)
				{
					$version = explode('.', $configStatic['version']);
					$newestVersion = explode('.', $key);
					$levelOfUpdate = findUpdateValue(count($newestVersion), count($version), $newestVersion, $version);
					if($levelOfUpdate != 0)
					{
						echo "<li><h2>Changelog For ".$key." update</h2></li>";
						echo $value['releaseNotes'];
					}
				}
			}
			?>
			</ul>
		</div>
	</div>
</body>
<script type="text/javascript">
	var timeoutVar;
	var dataFromJSON;
	var currentVersion = "<?php echo $configStatic['version']?>";
	var updateFromID = "settingsInstallUpdate";
</script>
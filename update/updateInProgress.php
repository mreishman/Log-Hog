<?php
require_once("../core/php/commonFunctions.php");
require_once("../core/php/class/core.php");
$core = new core();
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/updateProgressFile.php');
require_once('../core/php/settingsInstallUpdate.php');
$cssVersion = date("YmdHis");
?>
<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<?php echo $core->loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<?php getScript(array(
		"filePath"		=> "../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>


<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<h1 id="titleForUpdater" >An Update is in progress</h1>
		<div id="menu" style="margin-right: auto; margin-left: auto; position: relative; display: none;">
			<a onclick="window.location.href = '../settings/update.php'">Back to Log-Hog</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<progress id="progressBar" value="<?php echo $updateProgress['percent'];?>" max="100" style="width: 95%; margin-top: 10px; margin-bottom: 10px; margin-left: 2.5%;" ></progress>
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 300px; overflow: auto; max-height: 300px; padding: 5px;">
				<br>
				<p>
					An update is currently in progress... please wait for it to finish or try one of the following options:
				</p>
				<h2>
					Option 1:
				</h2>
				<p>
					If there is no progress in around <b><span id="counterDisplay">2 minutes</span></b>, this page will auto redirect to the updater page.
				</p>
				<h2>
					Option 2:
				</h2>
				<p>
					Click here to manually go to updater page:
					<a class="link" onclick="window.location.href = '../update/updater.php'"  >
						Retry Update
					</a>
				</p>
				<h2>
					Option 3:
				</h2>
				<p>
					Click here to retry an update if previous update failed or was inturrepted:
					<a class="link" onclick="window.location.href = '../staticUpdate.php'"  >
						Retry Update
					</a>
				</p>
				<h2>
					Option 4:
				</h2>
				<p>
					Click here to revert back to a previous version
					<a class="link" onclick="window.location=href = '../restore/restore.php'" >
						Revert to a previous version
					</a>
				</p>
			</div>
			<p style="border-bottom: 1px solid white;"></p>
			<div class="settingsHeader">
			Log Info
			</div>
			<div id="innerSettingsText" class="settingsDiv" style="height: 75px; overflow-y: scroll;" ></div>
		</div>
	</div>
</div>
<?php getScripts(
	array(
		array(
			"filePath"		=> "../core/js/settings.js",
			"baseFilePath"	=> "core/js/settings.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "../core/js/updateInProgress.js",
			"baseFilePath"	=> "core/js/updateInProgress.js",
			"default"		=> $configStatic["version"]
		)
	)
); ?>
<script type="text/javascript">
<?php echo "var currentPercent = parseInt(".$updateProgress['percent'].");";?>
</script>
</body>
</html>
<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("../", "", 17);
}
$currentSelectedTheme = $core->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$baseUrlImages = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('setupProcessFile.php');
require_once('../core/php/configStatic.php');
if($setupProcess != "step5")
{
	$partOfUrl = $core->clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/director.php";
	header('Location: ' . $url, true, 302);
	exit();
}
$counterSteps = 1;
while(file_exists('step'.$counterSteps.'.php'))
{
	$counterSteps++;
}
$counterSteps--;
require_once('../core/php/loadVars.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<?php $core->getScripts(
		array(
			array(
				"filePath"		=> "../core/js/jquery.js",
				"baseFilePath"	=> "core/js/jquery.js",
				"default"		=> $configStatic["version"]
			),
			array(
				"filePath"		=> "../core/js/jscolor.js",
				"baseFilePath"	=> "core/js/jscolor.js",
				"default"		=> $configStatic["version"]
			)
		)
	); ?>
	<?php require_once("../core/php/template/popup.php");
	echo $core->loadCSS("../",$baseUrl, $cssVersion);
	echo $core->loadSentryData($sendCrashInfoJS, $branchSelected, $configStatic);
	require_once("../core/php/customCSS.php");?>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="settingsHeader">
		<h1>Step 5 of <?php echo $counterSteps; ?></h1>
	</div>
	<p style="padding: 10px;">Would you like to install a plugin?:</p>
		<?php require_once("../core/php/template/innerAddon.php"); ?>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr><th style="text-align: right;" >
		<?php if($counterSteps == 5): ?>
			<a onclick="updateStatus('finished');" class="link">Finish</a>
		<?php else: ?>
			<a onclick="updateStatus('step6');" class="link">Continue</a>
		<?php endif; ?>
	</th></tr></table>
	<br>
	<br>
</div>
</body>
<script type="text/javascript">
	var urlForAddonSend = "../core/php/template/innerAddon.php";
	var urlForSendMain = "../core/php/performSettingsInstallUpdateAction.php?format=json";
	var baseUrl = "<?php echo $baseUrlImages;?>";

	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		//change setupProcess to page1
		location.reload();
	}

	var titleOfPage = "Welcome";

	var saveVerifyImage = <?php echo json_encode($core->generateImage(
			$arrayOfImages["greenCheck"],
			array(
				"height"		=>	"50px",
				"srcModifier"	=>	"../"
			)
		)); ?>
</script>
<?php $core->getScripts(
	array(
		array(
			"filePath"		=> "../core/js/settings.js",
			"baseFilePath"	=> "core/js/settings.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "../core/js/addons.js",
			"baseFilePath"	=> "core/js/addons.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "stepsJavascript.js",
			"baseFilePath"	=> "setup/stepsJavascript.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "../core/js/loghogDownloadJS.js",
			"baseFilePath"	=> "core/js/loghogDownloadJS.js",
			"default"		=> $configStatic["version"]
		)
	)
); ?>
<script type="text/javascript">
$(document).ready(function()
{
	loadImgFromData("mainMenuImage");
});

</script>
</html>
<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("../", "", 17);
}
require_once("../core/php/class/errorCheck.php");
$errorCheck = new errorCheck();
require_once('../core/php/configStatic.php');
$currentPage = "welcome.php";
$errorCheck->checkIfFilesExist(
	array("local/layout.php","setup/setupProcessFile.php","error.php","setup/step1.php","core/template/theme.css","core/js/jquery.js","core/php/template/popup.php","core/php/settingsSaveAjax.php","core/conf/config.php","setup/stepsJavascript.js"),
	 "../",
	 $currentPage);
$errorCheck->checkIfFilesAreReadable(
	array("local/layout.php","setup/setupProcessFile.php","error.php","setup/step1.php","core/template/theme.css","core/js/jquery.js","core/php/template/popup.php","core/php/settingsSaveAjax.php","core/conf/config.php","setup/stepsJavascript.js"),
	 "../",
	 $currentPage);


$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";

$errorCheck->checkIfFilesAreWritable(
	array("core/php/settingsSaveAjax.php","local/".$currentSelectedTheme, "setup/setupProcessFile.php"),
	 "../",
	 $currentPage);

require_once('setupProcessFile.php');
if(file_exists($baseUrl.'conf/config.php'))
{
	if($setupProcess != "preStart")
	{
		$partOfUrl = $core->clean_url($_SERVER['REQUEST_URI']);
		$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
		$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/director.php";
		header('Location: ' . $url, true, 302);
		exit();
	}
}

$cssVersion = date("YmdHis");

$core->setCookieRedirect();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="../core/template/theme.css">
	<link rel="stylesheet" type="text/css" href="../core/template/base.css">
	<?php $core->getScript(array(
		"filePath"		=> "../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
	<?php require_once("../core/php/template/popup.php"); ?>
	<script type="text/javascript">
	<?php echo $session->outputFormKey(); ?>
	</script>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px;" >
	<div class="settingsHeader">
		<h1>Thank you for downloading Log-Hog.</h1>
	</div>
	<div class="settingsDiv" >
	<p style="min-height: 200px; padding: 10px;">Please follow these steps to complete the setup process or click default to accept default setting</p>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" >
		<tr>
			<th style="text-align: left;">
				<a onclick="updateStatus('finished');" class="link">Accept Default Settings</a>
			</th>
			<th style="text-align: right;" >
				<a onclick="updateStatus('step1');" class="link">Customize Settings (advised)</a>
			</th>
		</tr>
	</table>
	<br>
	<br>
	</div>
</div>
</body>
<form id="welcomeForm"></form>
<script type="text/javascript">
	var themeChangeLogicDirModifier = "../core/php/";
	var themeErrorLogicDirModifier = "../";
	function defaultSettings()
	{
		//change setupProcess to finished
		saveAndVerifyMain("welcomeForm");
	}

	function customSettings()
	{
		//change setupProcess to page1
		saveAndVerifyMain("welcomeForm");
	}

	var saveVerifyImage = "<img src=\"../core/img/greenCheck.png\" height=\"50px;\" >";

	function redirectToLocationFromUpgradeTheme()
	{
		window.location.href = "./director.php";
	}
</script>
<?php $core->getScripts(
	array(
		array(
			"filePath"		=> "../core/js/settings.js",
			"baseFilePath"	=> "core/js/settings.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "../core/js/upgradeTheme.js",
			"baseFilePath"	=> "core/js/upgradeTheme.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "stepsJavascript.js",
			"baseFilePath"	=> "setup/stepsJavascript.js",
			"default"		=> $configStatic["version"]
		)
	)
); ?>
</html>
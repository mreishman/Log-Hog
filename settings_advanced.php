<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("../", "", 17);
}
if(!isset($settings))
{
	require_once($core->baseURL()."core/php/class/settings.php");
	$settings = new settings();
}
$currentSelectedTheme = $core->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
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
?>
<!doctype html>
<head>
	<title>Settings | Advanced</title>
	<?php echo $core->loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<?php $core->getScripts(
		array(
			array(
				"filePath"		=> "../core/js/jquery.js",
				"baseFilePath"	=> "core/js/jquery.js",
				"default"		=> $configStatic["version"]
			),
			array(
				"filePath"		=> "../core/js/advanced.js",
				"baseFilePath"	=> "core/js/advanced.js",
				"default"		=> $configStatic["version"]
			),
			array(
				"filePath"		=> "../core/js/advancedExt.js",
				"baseFilePath"	=> "core/js/advancedExt.js",
				"default"		=> $configStatic["version"]
			),
			array(
				"filePath"		=> "../core/js/resetSettingsJs.js",
				"baseFilePath"	=> "core/js/resetSettingsJs.js",
				"default"		=> $configStatic["version"]
			)
		)
	); ?>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
	<?php
	$currentSection = "config";
	include('../core/php/template/varTemplate.php');
	$currentSection = "modules";
	include('../core/php/template/varTemplate.php');
	$currentSection = "loggingVars";
	include('../core/php/template/varTemplate.php');
	$currentSection = "fileLocations";
	include('../core/php/template/varTemplate.php');
	$settingsUrlModifier = "../";
	$otherSettingsUrlModifier = "";
	include('../core/php/template/advancedActions.php');
	?>
	</div>
</body>
<script type="text/javascript">
	var saveButtonAlwaysVisible = "<?php echo $saveButtonAlwaysVisible; ?>";
</script>
<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("../", "", 17);
}
require_once("../core/php/class/settings.php");
$settings = new settings();
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/conf/globalConfig.php');
require_once('../local/conf/globalConfig.php');
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
$settingsUrlModifier = "../";
?>
<!doctype html>
<head>
	<title>Settings | Dev</title>
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
				"filePath"		=> "../core/js/devTools.js",
				"baseFilePath"	=> "core/js/devTools.js",
				"default"		=> $configStatic["version"]
			),
			array(
				"filePath"		=> "../core/js/devToolsExt.js",
				"baseFilePath"	=> "core/js/devToolsExt.js",
				"default"		=> $configStatic["version"]
			)
		)
	); ?>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
		<?php
			require_once("../core/php/template/devConfigSettings.php");
			$currentSection = "globalConfig";
			include('../core/php/template/varTemplate.php');
		?>
	</div>
	<script type="text/javascript">
		var saveButtonAlwaysVisible = "<?php echo $saveButtonAlwaysVisible; ?>";
		var dirForAjaxSend = "../";
	</script>
</body>
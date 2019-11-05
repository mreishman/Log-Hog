<?php
$cssVersion = date("YmdHis");
require_once("core/php/class/core.php");
$core = new core();
require_once("core/php/class/update.php");
$update = new update();
require_once("core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("", "", 17);
}
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl = "local/".$currentSelectedTheme."/";

require_once($baseUrl.'conf/config.php');
require_once('core/conf/config.php');
require_once('local/conf/globalConfig.php');
require_once('core/conf/globalConfig.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
$defaultSettingsDir = 'core/Themes/'.$currentTheme."/defaultSetting.php";
if(is_dir('local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	$defaultSettingsDir = 'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php";
}
require_once($defaultSettingsDir);
require_once('core/php/configStatic.php');
$daysSince = $update->calcuateDaysSince($configStatic['lastCheck']);
require_once('core/php/updateCheck.php');
require_once('core/php/loadVars.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Static Update Page</title>
	<?php echo $core->loadCSS("",$baseUrl, $cssVersion);?>
	<?php $core->getScript(array(
		"filePath"		=> "core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
</head>
<body>
	<div id="main">
		<?php require_once('core/php/template/update.php'); ?>
	</div>
	<?php require_once('core/php/template/popup.php'); ?>
</body>
</html>
<?php $core->getScripts(
	array(
		array(
			"filePath"		=> "core/js/update.js",
			"baseFilePath"	=> "core/js/update.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "core/js/settingsExt.js",
			"baseFilePath"	=> "core/js/settingsExt.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "core/js/lazyLoadImg.js",
			"baseFilePath"	=> "core/js/lazyLoadImg.js",
			"default"		=> $configStatic["version"]
		)
	)
); ?>
<script type="text/javascript">

$(document).ready(function()
{
	loadImgFromData("updateImg");
});
var currentVersion = "<?php echo $configStatic['version'];?>";
var baseUrl = "<?php echo $baseUrl;?>";
var saveVerifyImage = <?php echo json_encode($core->generateImage(
	$arrayOfImages["greenCheck"],
	array(
		"height"		=>	"50px"
	)
)); ?>
</script>
<form id="settingsInstallUpdate" action="update/updater.php" method="post" style="display: none"></form>
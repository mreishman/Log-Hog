<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("../", "", 17);
}
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
$config = settingsData::read($baseUrl.'conf/config.json', 'config');
$defaultConfig = settingsData::defaults('config');
require_once('../core/php/configStatic.php');
$defaultGlobalConfig = settingsData::defaults('globalConfig');
$globalConfig = settingsData::read('../local/conf/globalConfig.json', 'globalConfig');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/Themes/'.$currentTheme))
{
	$themeDefaultSettings = settingsData::read('../local/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
}
else
{
	$themeDefaultSettings = settingsData::read('../core/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
}
require_once('../core/php/loadVars.php');
?>
<!doctype html>
<head>
	<title>Settings | About</title>
	<?php echo $core->loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="stylesheet" type="text/css" href="../core/template/lightbox.css?v=<?php echo $core->getFileTime("core/template/lightbox.css",$configStatic["version"]);?>">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<?php $core->getScript(array(
		"filePath"		=> "../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>
	<?php require_once('header2.php'); ?>
	<div id="main">
		<?php
		$otherPageImageModifier = "../";
		require_once('../core/php/template/about.php');
		require_once("../core/php/template/changelog.php");
		?>
	</div>
</body>
<?php $core->getScript(array(
	"filePath"		=> "../core/js/lazyLoadImg.js",
	"baseFilePath"	=> "core/js/lazyLoadImg.js",
	"default"		=> $configStatic["version"]
)); ?>
<script type="text/javascript">

$(document).ready(function()
{
	loadImgFromData("mainMenuImage");
	showAboutTab("<?php echo $_GET['pageType'] ?? "about"; ?>");
});

</script>
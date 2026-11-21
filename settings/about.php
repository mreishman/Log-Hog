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
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
include('../core/conf/globalConfig.php');
include('../local/conf/globalConfig.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/Themes/'.$currentTheme))
{
	require_once('../local/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../core/Themes/'.$currentTheme."/defaultSetting.php");
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
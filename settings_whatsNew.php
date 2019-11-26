<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("../", "", 17);
}
$core->setCookieRedirect();
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/conf/globalConfig.php');
require_once('../local/conf/globalConfig.php');
require_once('../core/php/configStatic.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/Themes/'.$currentTheme))
{
	require_once('../local/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../core/php/updateCheck.php');
require_once('../core/php/loadVars.php');
?>
<!doctype html>
<head>
	<title>Settings | What's New</title>
	<?php echo $core->loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<?php $core->getScript(array(
		"filePath"		=> "../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>

<?php require_once('header2.php');?>

	<div id="main" >
		<h1 style="width: 100%; text-align: center;  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black; " >You are on version <?php echo $configStatic['version'];?>!</h1>
		<?php
		$otherPageImageModifier = "../";
		require_once('../core/php/template/whatsNew.php');
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
	loadImgFromData("whatsNewImage");
});

</script>
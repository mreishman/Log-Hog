<?php
require_once('../core/php/commonFunctions.php');
require_once("../core/php/class/core.php");
$core = new core();
setCookieRedirect();
$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
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
	<title>Settings | Main</title>
	<?php echo $core->loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<?php getScript(array(
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
<?php getScript(array(
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
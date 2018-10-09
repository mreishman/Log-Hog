<?php
require_once('../core/php/commonFunctions.php');
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
	<?php echo loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script type="text/javascript" src="../core/js/jquery.js"></script>
</head>
<body>

<?php require_once('header2.php');?>	

	<div id="main" > 
		<h1 style="width: 100%; text-align: center;  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black; " >You are on version <?php echo $configStatic['version'];?>!</h1>
		<?php
		$imageDirModifierAbout = "../";
		require_once('../core/php/template/whatsNew.php');
		?>
	</div>
</body>
<script src="../core/js/lazyLoadImg.js?v=<?php echo $jsVersion?>"></script>
<script type="text/javascript">
	
$(document).ready(function()
{
	loadImgFromData("whatsNewImage");
});

</script>
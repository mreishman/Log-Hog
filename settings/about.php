<?php
require_once('../core/php/commonFunctions.php');
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
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');
?>
<!doctype html>
<head>
	<title>Settings | About</title>
	<?php echo loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header2.php'); ?>
	<div id="main">
		<?php
		$aboutImage = generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"class"		=>	"mainMenuImage",
				"style"		=>	"margin-bottom: -40px;",
				"data-src"	=>	"../core/img/LogHog.png",
				"width"		=>	"100px"
			)
		);
		require_once('../core/php/template/about.php');
		?>
	</div>
</body>
<script src="../core/js/lazyLoadImg.js?v=<?php echo $cssVersion?>"></script>
<script type="text/javascript">
	
$(document).ready(function()
{
	loadImgFromData("mainMenuImage");
});

</script>
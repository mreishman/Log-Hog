<?php
$cssVersion = rand(0 , 9000000);
require_once('core/php/commonFunctions.php');

$currentSelectedTheme = returnCurrentSelectedTheme();
$baseUrl = "local/".$currentSelectedTheme."/";

require_once($baseUrl.'conf/config.php');
require_once('core/conf/config.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
$defaultSettingsDir = 'core/Themes/'.$currentTheme."/defaultSetting.php";
if(is_dir('local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	$defaultSettingsDir = 'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php";
}
require_once($defaultSettingsDir);
require_once('core/php/configStatic.php');
$daysSince = calcuateDaysSince($configStatic['lastCheck']);
require_once('core/php/updateCheck.php');
require_once('core/php/loadVars.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Static Update Page</title>
	<?php echo loadCSS("",$baseUrl, $cssVersion);?>
	<script src="core/js/jquery.js"></script>
</head>
<body>
	<div id="main">
		<?php require_once('core/php/template/update.php'); ?>
	</div>
</body>
</html>
<script src="core/js/update.js?v=<?php echo $cssVersion?>"></script>
<script src="core/js/settingsExt.js?v=<?php echo $cssVersion?>"></script>
<script src="core/js/lazyLoadImg.js?v=<?php echo $cssVersion?>"></script>
<script type="text/javascript">
	
$(document).ready(function()
{
	loadImgFromData("updateImg");
});
var currentVersion = "<?php echo $configStatic['version'];?>";
var baseUrl = "<?php echo $baseUrl;?>";
var saveVerifyImage = <?php echo json_encode(generateImage(
	$arrayOfImages["greenCheck"],
	array(
		"height"		=>	"50px"
	)
)); ?>
</script>
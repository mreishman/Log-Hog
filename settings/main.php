<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/settings.php");
$settings = new settings();
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
require_once('../core/php/updateCheck.php');
require_once('../core/php/loadVars.php');

?>
<!doctype html>
<head>
	<title>Settings | Main</title>
	<?php echo $core->loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<?php $core->getScript(array(
		"filePath"		=> "../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>

<?php require_once('header.php');?>

	<div id="main">
		<?php
		$currentSection = "logVars";
		include('../core/php/template/varTemplate.php');
		if($advancedLogFormatEnabled === "true")
		{
			$currentSection = "logFormatVars";
			include('../core/php/template/varTemplate.php');
		}
		$currentSection = "pollVars";
		include('../core/php/template/varTemplate.php');
		$currentSection = "filterVars";
		include('../core/php/template/varTemplate.php');
		$currentSection = "archive";
		include('../core/php/template/varTemplate.php');
		$currentSection = "notificationVars";
		include('../core/php/template/varTemplate.php');
		$currentSection = "menuVars";
		include('../core/php/template/varTemplate.php');
		$currentSection = "watchlistVars";
		include('../core/php/template/varTemplate.php');
		if($oneLogEnable === "true")
		{
			$currentSection = "oneLogVars";
			include('../core/php/template/varTemplate.php');
		}
		if($enableMultiLog === "true")
		{
			$currentSection = "multiLogVars";
			include('../core/php/template/varTemplate.php');
			require_once('../core/php/template/logLayout.php');
		}
		$currentSection = "otherVars";
		include('../core/php/template/varTemplate.php');
		?>
	</div>
</body>
<script type="text/javascript">
var logTrimType = "<?php echo $logTrimType; ?>";
var saveButtonAlwaysVisible = "<?php echo $saveButtonAlwaysVisible; ?>";
</script>
<?php $core->getScript(array(
	"filePath"		=> "../core/js/settingsMain.js",
	"baseFilePath"	=> "core/js/settingsMain.js",
	"default"		=> $configStatic["version"]
)); ?>
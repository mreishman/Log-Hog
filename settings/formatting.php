<?php
require_once("../core/php/class/core.php");
$core = new core();
$core->setCookieRedirect();
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
if(is_dir('../local/Themes/'.$currentTheme))
{
	require_once('../local/Themes/'.$currentTheme."/defaultSetting.php");
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
	<title>Settings | Formatting</title>
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
		require_once('../core/php/template/folderGroupColor.php');
		$currentSection = "generalThemeOptions";
		include('../core/php/template/varTemplate.php');
		if($advancedLogFormatEnabled === "true")
		{
			$currentSection = "logFormatVars";
			include('../core/php/template/varTemplate.php');
		}
		?>
	</div>
</body>
<script type="text/javascript">
var logTrimType = "<?php echo $logTrimType; ?>";
var saveButtonAlwaysVisible = "<?php echo $saveButtonAlwaysVisible; ?>";
</script>
<?php $core->getScripts(array(
	array(
		"filePath"		=> "../core/js/settingsMain.js",
		"baseFilePath"	=> "core/js/settingsMain.js",
		"default"		=> $configStatic["version"]
	),
	array(
		"filePath"		=> "../core/js/settingsFormattingExt.js",
		"baseFilePath"	=> "core/js/settingsMainExt.js",
		"default"		=> $configStatic["version"]
	),
	array(
		"filePath"		=> "../core/js/colorScheme.js",
		"baseFilePath"	=> "core/js/colorScheme.js",
		"default"		=> $configStatic["version"]
	)
)); ?>
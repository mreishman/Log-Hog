<?php
require_once("core/php/class/core.php");
$core = new core();
$core->setCookieRedirect();
require_once("core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("", "", 17);
}
require_once("core/php/class/settings.php");
$settings = new settings();
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl = "local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
$config = settingsData::read($baseUrl.'conf/config.json', 'config');
$defaultConfig = settingsData::defaults('config');
$defaultGlobalConfig = settingsData::defaults('globalConfig');
$globalConfig = settingsData::read('local/conf/globalConfig.json', 'globalConfig');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('local/Themes/'.$currentTheme))
{
	$themeDefaultSettings = settingsData::read('local/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
}
else
{
	$themeDefaultSettings = settingsData::read('core/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
}
require_once('core/php/configStatic.php');
require_once('core/php/loadVars.php');

?>
<!doctype html>
<head>
	<title>Log-Hog | Settings</title>
	<?php echo $core->loadCSS("",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
	<?php $core->getScript(array(
		"filePath"		=> "core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>
<?php require_once('core/php/template/settingsHeader.php');?>
	<div id="main">
		<?php //auto generated settings tabs ?>
		<?php foreach ($defaultConfigMoreData as $currentSection => $configRowData): ?>
			<div id="<?php echo $configRowData["menu"]["id"]; ?>" class="fullScreenMenuSettingsFormDiv" style="display: none;" >
				<?php include('core/php/template/varTemplate.php');	?>
			</div>
		<?php endforeach; ?>
		<?php //custom settings tabs ?>
		<div id="fullScreenMenuColorScheme" class="fullScreenMenuSettingsFormDiv" style="display: none;">
			<?php require_once('core/php/template/folderGroupColor.php'); ?>
		</div>
		<div id="settingsMainLogLayout" class="fullScreenMenuSettingsFormDiv" style="display: none;" >
			<?php
			require_once('core/php/template/logLayout.php');
			?>
		</div>
	</div>
</body>
<script type="text/javascript">
var logTrimType = "<?php echo $logTrimType; ?>";
var saveButtonAlwaysVisible = "<?php echo $saveButtonAlwaysVisible; ?>";
var openTabClass = "<?php echo $_GET["tab"] ?? "main"; ?>";
var openTabId = "<?php echo $_GET["id"] ?? ""; ?>";
</script>
<?php $core->getScripts(array(
	array(
		"filePath"		=> "core/js/settingsMain.js",
		"baseFilePath"	=> "core/js/settingsMain.js",
		"default"		=> $configStatic["version"]
	),
	array(
		"filePath"		=> "core/js/settingsMainExt.js",
		"baseFilePath"	=> "core/js/settingsMainExt.js",
		"default"		=> $configStatic["version"]
	),
	array(
		"filePath"		=> "core/js/advanced.js",
		"baseFilePath"	=> "core/js/advanced.js",
		"default"		=> $configStatic["version"]
	),
	array(
		"filePath"		=> "core/js/resetSettingsJs.js",
		"baseFilePath"	=> "core/js/resetSettingsJs.js",
		"default"		=> $configStatic["version"]
	),
	array(
		"filePath"		=> "core/js/globalConfig.js",
		"baseFilePath"	=> "core/js/globalConfig.js",
		"default"		=> $configStatic["version"]
	),
	array(
		"filePath"		=> "core/js/colorScheme.js",
		"baseFilePath"	=> "core/js/colorScheme.js",
		"default"		=> $configStatic["version"]
	),
	array(
		"filePath"		=> "Modules/AdvancedLogFormatOptions/js/format.js",
		"baseFilePath"	=> "Modules/AdvancedLogFormatOptions/js/format.js",
		"default"		=> $configStatic["version"]
	),
	array(
		"filePath"		=> "Modules/AdvancedLogFormatOptions/js/formatSettings.js",
		"baseFilePath"	=> "Modules/AdvancedLogFormatOptions/js/formatSettings.js",
		"default"		=> $configStatic["version"]
	)
)); ?>
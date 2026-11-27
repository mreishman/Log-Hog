<?php
require_once("../../../core/php/class/core.php");
$core = new core();
require_once("../../../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
if(!$session->validate())
{
	echo json_encode(array("error" => 18));
	exit();
}
require_once("../../../core/php/class/settings.php");
$settings = new settings();
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = "../../../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
$config = settingsData::read($baseUrl.'conf/config.json', 'config');
$defaultConfig = settingsData::defaults('config');
$globalConfig = settingsData::read('../../../local/conf/globalConfig.json', 'globalConfig');
$defaultGlobalConfig = settingsData::defaults('globalConfig');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../../../local/Themes/'.$currentTheme))
{
	$themeDefaultSettings = settingsData::read('../../../local/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
}
else
{
	$themeDefaultSettings = settingsData::read('../../../core/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
}
require_once('../../../core/php/configStatic.php');
require_once('../../../core/php/loadVars.php');
require_once('../../../core/php/loadVarsToJs.php');
?>
<script type="text/javascript">
	var defaultdefaultNewAddAlertEnabled 	= "<?php echo $defaultNewAddAlertEnabled; ?>";
	var defaultNewAddAutoDeleteFiles 		= "<?php echo $defaultNewAddAutoDeleteFiles; ?>";
	var defaultNewAddExcludeTrim 			= "<?php echo $defaultNewAddExcludeTrim; ?>";
	var defaultNewAddPattern 				= "<?php echo $defaultNewAddPattern;?>";
	var defaultNewAddRecursive 				= "<?php echo $defaultNewAddRecursive;?>";
	var defaultNewPathFile 					= "<?php echo $defaultNewPathFile; ?>";
	var defaultNewPathFolder				= "<?php echo $defaultNewPathFolder;?>";
	var defaultNewPathOther 				= "<?php echo $defaultNewPathOther;?>";
	var sortTypeFileFolderPopup				= "<?php echo $sortTypeFileFolderPopup; ?>";
</script>
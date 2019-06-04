<?php
require_once("../../core/php/class/core.php");
$core = new core();
require_once("../../core/php/class/settings.php");
$settings = new settings();
$currentSelectedTheme = $core->returnCurrentSelectedTheme();
$baseUrl = "../../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../../core/php/configStatic.php');
require_once('../../core/php/updateCheck.php');
require_once('../../core/php/loadVars.php');
require_once('../../core/php/loadVarsToJs.php');
echo $core->loadSentryData($sendCrashInfoJS, $branchSelected, $configStatic);
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
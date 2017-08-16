<?php
  
$arrayOfFiles = array("core_conf_config.php", "core_html_popup.html","core_html_restoreVersionOptions.html","core_js_loghogDownloadJS.js","core_js_main.js","core_js_rightClickJS.js","core_js_settings.js","core_js_settingsMain.js","core_js_top.js","core_php_configStaticCheck.php","core_php_getPercentUpdate.php","core_php_loadVars.php","core_php_performSettingsInstallUpdateAction.php","core_php_poll.php","core_php_pollCheck.php","core_php_resetUpdateFilesToDefault.php","core_php_saveCheck.php","core_php_settingsCheckForUpdate.php","core_php_settingsCheckForUpdateAjax.php","core_php_settingsInstallUpdate.php","core_php_settingsSave.php","core_php_settingsSaveAjax.php","core_php_settingsSaveConfigStatic.php","core_php_template_mainVars.php","core_php_template_settingsMainWatch.php","core_php_template_settingsMenuVars.php","core_php_updateProgressLogHead.php","core_php_verifyWriteStatus.php","core_template_theme.css","error.php","index.php","local_default_template_theme.css","restore_php_performSettingsInstallUpdateAction.php","restore_php_settingsInstallUpdate.php","settings_advanced.php","settings_changelog.html","settings_devTools.php","settings_experimentalfeatures.php","settings_header.php","settings_index.php","settings_main.php","settings_monitorDownload.php","settings_monitorRemove.php","settings_update.php","setup_stepsJavascript.js","setup_updateSetupStatus.php","update_index.php","update_updateInProgress.php","not_a_real_file.php");

require_once("innerUpgradeStatus.php");

$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."index.php"))
{
  $varToIndexDir .= "../";        
}

if($innerUpdateProgress['currentFile'] < sizeOf($arrayOfFiles))
{
 
sleep(2); 
$currentFile = $arrayOfFiles[$innerUpdateProgress['currentFile']]; 
$indexToExtracted = "update/downloads/updateFiles/extracted/";  

	if($currentFile == "not_a_real_file.php")
	{
		//redirect to external upgrade thing	
		header("Location: ".$varToIndexDir."update/updater-tmp.php"); 
		exit();
	}
	
//update innerUpgradeStatus file
$newCount = $innerUpdateProgress['currentFile'] + 1;

$currentFileArray = explode("_", $currentFile );  
$sizeOfCurrentFileArray = sizeOf($currentFileArray);

$nameOfFile = $currentFileArray[$sizeOfCurrentFileArray - 1];

$directoryPath = "";
  
for($i = 0; $i < $sizeOfCurrentFileArray - 1; $i++)
{
  $directoryPath .= $currentFileArray[$i]."/"; 
}
 
$newFile = $directoryPath.$nameOfFile;
$fileTransfer = file_get_contents($varToIndexDir.$indexToExtracted.$currentFile);
file_put_contents($varToIndexDir.$newFile,$fileTransfer);  
  
$string = "Updating file ".$newCount." of ".sizeOf($arrayOfFiles). " - Updating this file -  ".$varToIndexDir.$newFile." - with this file - ".$varToIndexDir.$indexToExtracted.$currentFile; 
  
//update message for update  
  
updateProgressFile($string, "", "updateProgressFileNext.php", "");
updateProgressFile($string, "", "updateProgressFile.php", "");   
  
$mainFileContents = file_get_contents("updateProgressLog.php");
$mainFileContents = $string.$mainFileContents;	
file_put_contents("updateProgressLog.php", $mainFileContents);	
	
  
//update innerUpgradeStatus.php
  
$writtenTextTofile = "<?php
	$"."innerUpdateProgress = array(
  	'currentFile'   => '".$newCount."'
	);
	?>
";



file_put_contents($varToIndexDir.$indexToExtracted."innerUpgradeStatus.php", $writtenTextTofile);  

 
sleep(2);  
}
else
{
  
updateProgressFile("Finished Running Update Script", "", "updateProgressFileNext.php", "");
updateProgressFile("Finished Running Update Script", "", "updateProgressFile.php", "");  
   header( 'Location: ' .$varToIndexDir."update/redirectToWaitUntillUpdate.php");
  exit; 
}



  
?>

<?php
  
$arrayOfFiles = array("core_conf_config.php","core_php_loadVars.php","core_php_performSettingsInstallUpdateAction.php","core_php_resetUpdateFilesToDefault.php","core_php_settingsInstallUpdate.php","update_redirectToWaitUntillUpdate.php","update_updateActionCheck.php","core_php_settingsSave.php","core_php_settingsSaveAjax.php","core_php_settingsTop.php","core_php_settingsTopMain.php","core_php_template_mainVars.php","core_php_template_settingsMainWatch.php","core_php_template_settingsMenuVars.php","core_template_theme.css","index.php","local_default_template_theme.css","settings_advanced.php","settings_changelog.html","settings_devTools.php","settings_experimentalfeatures.php","settings_header.php","settings_main.php","update_updater.php","settings_settingsTop.php","settings_update.php","setup_step1.php","setup_step2.php","setup_step3.php","setup_step4.php","setup_step5.php","setup_stepsJavascript.js","setup_updateSetupCheck.php","setup_updateSetupStatus.php","setup_welcome.php","top_functions_dfAL.php","top_functions_free.php","top_functions_getRUsage.php","top_functions_ioStatDx.php","top_functions_killProcess.php","top_functions_procNetDev.php","top_functions_procStat.php","top_functions_psAux.php","top_header.php","top_index.php");

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
  
if($currentFile == "core_conf_config.php")
{
   if (!file_exists($varToIndexDir.'top/functions/')) 
   {
   	mkdir($varToIndexDir.'top/functions/', 0777, true);
   }
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

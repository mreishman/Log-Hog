<?php
  
$arrayOfFiles = array("core_conf_config.php", "core_html_restoreVersionOptions.html","core_js_loghogDownloadJS.js","core_js_settings.js","core_php_performSettingsInstallUpdateAction.php","core_php_pollCheck.php","core_php_settingsSaveConfigStatic.php","core_php_template_settingsMenuVars.php","core_template_theme.css","index.php","local_default_template_theme.css","restore_php_performSettingsInstallUpdateAction.php","restore_php_settingsInstallUpdate.php","restore_restore.php","settings_advanced.php","settings_changelog.html","settings_devTools.php","settings_header.php","settings_monitorDownload.php","settings_monitorRemove.php","setup_step4.php");

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
   if (!file_exists($varToIndexDir.'restore/')) 
   {
   	mkdir($varToIndexDir.'restore/', 0777, true);
   }
	
	if (!file_exists($varToIndexDir.'restore/php/')) 
   {
   	mkdir($varToIndexDir.'restore/php/', 0777, true);
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

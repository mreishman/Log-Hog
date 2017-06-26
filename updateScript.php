<?php
  
$arrayOfFiles = array("core_conf_config.php","core_html_popup.html","core_js_main.js","core_js_rightClickJS.js","core_js_settingsMain.js","core_js_top.js","core_php_deleteLog.php","core_php_dfAL.php","core_php_free.php","core_php_getRUsage.php","core_php_ioStatDx.php","core_php_killProcess.php","core_php_loadVars.php","core_php_procNetDev.php","core_php_procStat.php","core_php_psAux.php","core_php_settingsCheckForUpdateAjax.php","core_php_settingsSave.php","core_php_settingsSaveAjax.php","core_php_top.php","core_php_topAlt.php","core_php_updateCheck.php","core_template_theme.css","index.php","local_default_template_theme.css","settings_about.php","settings_advanced.php","settings_changelog.html","settings_devTools.php","settings_experimentalfeatures.php","settings_header.php","settings_main.php","settings_settingsTop.php","settings_update.php","top_header.php","top_overview.php");

require_once("innerUpgradeStatus.php");

if($innerUpdateProgress['currentFile'] < sizeOf($arrayOfFiles))
{
 
$currentFile = $arrayOfFiles[$innerUpdateProgress['currentFile']]; 
$indexToExtracted = "update/downloads/updateFiles/extracted/";  
$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."index.php"))
{
  $varToIndexDir .= "../";        
}
  
if($currentFile == "core_js_main.js")
{
   mkdir($varToIndexDir."/top/", 0777);
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

  
}
else
{
  
updateProgressFile("Finished Running Update Script", "", "updateProgressFileNext.php", "");
updateProgressFile("Finished Running Update Script", "", "updateProgressFile.php", "");  
  
}



  
?>

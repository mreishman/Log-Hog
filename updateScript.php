<?php
  
$arrayOfFiles = array("core_js_main.js", "core_php_settingsCheckForUpdate.php","settings_main.php","settings_update.php");

require_once("innerUpgradeStatus.php");

if($innerUpdateProgress['currentFile'] < sizeOf($arrayOfFiles))
{
 
$currentFile = $arrayOfFiles[$innerUpdateProgress['currentFile']]; 
  
if($currentFile == "core_js_main.js")
{
   rename("/core_js_main.php", "/core_js_main.js");
}
  
//update innerUpgradeStatus file
$newCount = $innerUpdateProgress['currentFile'] + 1;

$currentFileArray = explode("_", $currentFile );  
$sizeOfCurrentFileArray = sizeOf($currentFileArray);

$nameOfFile = $currentFileArray[$sizeOfCurrentFileArray - 1];

$directoryPath = "../../";
  
for($i = 0; $i < $sizeOfCurrentFileArray - 1; $i++)
{
  $directoryPath .= $currentFileArray[$i]."/"; 
}

$currentFileTransfer = '"'.$currentFile.'"';  
$newFile = $directoryPath.$nameOfFile;
$fileTransfer = file_get_contents($currentFileTransfer);
file_put_contents($newFile,$fileTransfer);  
  
$string = "Updating file ".$newCount." of ".sizeOf($arrayOfFiles). " - Updating this file -  ".$newFile." - with this file - ".$currentFile; 
  
//update message for update  
  
updateProgressFile($string, "", "updateProgressFileNext.php", "");
updateProgressFile($string, "", "updateProgressFile.php", "");   
  
  
}
else
{
  
updateProgressFile("Finished Running Update Script", "", "updateProgressFileNext.php", "");
updateProgressFile("Finished Running Update Script", "", "updateProgressFile.php", "");  
  
}



  
?>

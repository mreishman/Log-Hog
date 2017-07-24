<?php
  
$arrayOfFiles = array("core_conf_config.php", "core_conf_configTop.php","core_js_main.js","core_js_top.js","core_php_loadVars.php","core_php_loadVarsTop.php","core_php_poll.php","core_php_pollCheck.php","core_php_settingsSave.php","core_php_settingsSaveAjax.php","core_php_settingsSaveTop.php","core_php_template_mainVars.php","core_php_template_settingsMainWatch.php","core_php_template_settingsMenuVars.php","core_php_versionCheck.php","index.php","local_default_conf_topConfig.php","settings_changelog.html","settings_main.php","settings_settingsTop.php","settings_update.php","setup_director.php","setup_setupProcessFile.php","setup_step1.php","setup_step2.php","setup_step3.php","setup_updateSetupStatus.php","setup_welcome.php","top_header.php","top_index.php","top_statusTest.php");

require_once("innerUpgradeStatus.php");

if($innerUpdateProgress['currentFile'] < sizeOf($arrayOfFiles))
{
sleep(2);  
$currentFile = $arrayOfFiles[$innerUpdateProgress['currentFile']]; 
$indexToExtracted = "update/downloads/updateFiles/extracted/";  
$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."index.php"))
{
  $varToIndexDir .= "../";        
}
  
if($currentFile == "core_conf_config.php")
{
   if (!file_exists($varToIndexDir.'setup/')) 
   {
   	mkdir($varToIndexDir.'setup/', 0777, true);
   }
	if (!file_exists($varToIndexDir.'core/php/template')) 
   	{
    		mkdir($varToIndexDir.'core/php/template', 0777, true);
	}
	if(file_exists($varToIndexDir.'top/overview.php')
	{
		unlink($varToIndexDir.'top/overview.php');
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
  
}



  
?>

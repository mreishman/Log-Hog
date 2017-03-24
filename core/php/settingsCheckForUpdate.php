<?php

//check for previous update, if failed

$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
  $baseUrl = "../../local/";
  //there is custom information, use this
  require_once('../../local/layout.php');
  $baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('../conf/config.php');

require_once('verifyWriteStatus.php');
checkForUpdate($_SERVER['REQUEST_URI']);

if(file_exists("../../update/downloads/versionCheck/extracted/"))
{
  //dir exists
  if(file_exists("../../update/downloads/versionCheck/extracted/versionsCheckFile.php"))
  {
    //last version check here
    $files = glob("../../update/downloads/versionCheck/extracted/*"); // get all file names
    foreach($files as $file)
    { // iterate files
        if(is_file($file))
          unlink($file); // delete file
    }
    rmdir("../../update/downloads/versionCheck/extracted/");
  }

}

if(array_key_exists('enableDevBranchDownload', $config))
{
  $enableDevBranchDownload = $config['enableDevBranchDownload'];
}
else
{
  $enableDevBranchDownload = $defaultConfig['enableDevBranchDownload'];
}

if($enableDevBranchDownload == "true")
{
  file_put_contents("../../update/downloads/versionCheck/versionCheck.zip", 
  file_get_contents("https://github.com/mreishman/Log-Hog/archive/versionCheckDev.zip")
  );
}
else
{
  file_put_contents("../../update/downloads/versionCheck/versionCheck.zip", 
  file_get_contents("https://github.com/mreishman/Log-Hog/archive/versionCheck.zip")
  );
}




mkdir("../../update/downloads/versionCheck/extracted/");
$zip = new ZipArchive;
$path = "../../update/downloads/versionCheck/versionCheck.zip";
$res = $zip->open($path);
if ($res === TRUE) {
  for($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);
        $fileinfo = pathinfo($filename);
        if (strpos($fileinfo['basename'], '.php') !== false) 
        {
          copy("zip://".$path."#".$filename, "../../update/downloads/versionCheck/extracted/".$fileinfo['basename']);
        }
    }                   
    $zip->close();  
}

unlink("../../update/downloads/versionCheck/versionCheck.zip");

require_once('../../update/downloads/versionCheck/extracted/versionsCheckFile.php');
require_once('configStatic.php');

$arrayForVersionList = "";
$countOfArray = count($versionCheckArray['versionList']);
$i = 0;
foreach ($versionCheckArray['versionList'] as $key => $value) {
  $i++;
  $arrayForVersionList .= "'".$key."' => array(";
  $countOfArraySub = count($value);
  $j = 0;
  foreach ($value as $keySub => $valueSub) 
  {
    $j++;
    $arrayForVersionList .= "'".$keySub."' => '".$valueSub."'";
    if($j != $countOfArraySub)
    {
      $arrayForVersionList .= ",";
    }
  }
  $arrayForVersionList .= ")";
  if($i != $countOfArray)
  {
    $arrayForVersionList .= ",";
  }
}

$newInfoForConfig = "
<?php

$"."configStatic = array(
  'version'   => '".$configStatic['version']."',
  'lastCheck'   => '".date('m-d-Y')."',
  'newestVersion' => '".$versionCheckArray['version']."',
  'versionList' => array(
  ".$arrayForVersionList."
  )
);
";


//write new info to version file in core/php/configStatic.php

$files = glob("../../update/downloads/versionCheck/extracted/*"); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

file_put_contents("configStatic.php", $newInfoForConfig);

rmdir("../../update/downloads/versionCheck/extracted/");

if(array_key_exists('HTTP_REFERER', $_SERVER))
{
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
exit();
?>
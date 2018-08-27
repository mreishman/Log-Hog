<?php
$data = array();
$data['version'] = -1;
$data['error'] = "";
require_once('commonFunctions.php');
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

if(file_exists("../../update/downloads/versionCheck/extracted/"))
{
  //dir exists
  if(file_exists("../../update/downloads/versionCheck/extracted/versionsCheckFile.php"))
  {
    //last version check here
    $files = glob("../../update/downloads/versionCheck/extracted/*"); // get all file names
    foreach($files as $file)
    {
      if(is_file($file))
      {
        unlink($file);
      }
    }
    rmdir("../../update/downloads/versionCheck/extracted/");
  }

}

if(array_key_exists('branchSelected', $config))
{
  $branchSelected = $config['branchSelected'];
}
else
{
  $branchSelected = $defaultConfig['branchSelected'];
}
if(array_key_exists('baseUrlUpdate', $config))
{
  $baseUrlUpdate = $config['baseUrlUpdate'];
}
else
{
  $baseUrlUpdate = $defaultConfig['baseUrlUpdate'];
}

$fileNameForDownload = "versionCheck";

if($branchSelected === "dev")
{
  $fileNameForDownload = "versionCheckDev";
}
elseif($branchSelected == "beta")
{
  $fileNameForDownload = "versionCheckBeta";
}
if(file_exists("../../update/downloads/versionCheck/versionCheck.zip"))
{
  unlink("../../update/downloads/versionCheck/versionCheck.zip");
}
file_put_contents("../../update/downloads/versionCheck/versionCheck.zip",
  file_get_contents($baseUrlUpdate .$fileNameForDownload.".zip")
  );

if(!is_dir("../../update/downloads/versionCheck/extracted/"))
{
  $dirMade = @mkdir("../../update/downloads/versionCheck/extracted/");
  if($dirMade !== true)
  {
    //throw custom error
    echo json_encode(array("version" => -1, "error" => "could not create folder for tmp versionCheck data"));
    exit();
  }
}
$zip = new ZipArchive;
$path = "../../update/downloads/versionCheck/versionCheck.zip";
$res = $zip->open($path);
if ($res === true)
{
  for($i = 0; $i < $zip->numFiles; $i++)
  {
    $filename = $zip->getNameIndex($i);
    $fileinfo = pathinfo($filename);
    if (strpos($fileinfo['basename'], '.php') !== false)
    {
      copy("zip://".$path."#".$filename, "../../update/downloads/versionCheck/extracted/".$fileinfo['basename']);
    }
  }
  $zip->close();
}
else
{
  echo json_encode(array("version" => -1, "error" => "error opening zip"));
  exit();
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

$newInfoForConfig = "<?php

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

$files = glob("../../update/downloads/versionCheck/extracted/*");
foreach($files as $file)
{
  if(is_file($file))
  {
    unlink($file);
  }
}

if(!is_writable("configStatic.php"))
{
  echo json_encode(array("version" => -1, "error" => "configStatic is not writeable"));
  exit();
}
if(file_exists("configStatic.php"))
{
  unlink("configStatic.php");
}
file_put_contents("configStatic.php", $newInfoForConfig);

rmdir("../../update/downloads/versionCheck/extracted/");

$version = $configStatic['version'];
$newestVersion = $versionCheckArray['version'];

$version = explode('.', $configStatic['version'] );
$newestVersion =  explode('.', $versionCheckArray['version']);

$newestVersionCount = count($newestVersion);
$versionCount = count($version);
$levelOfUpdate = $levelOfUpdate = findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version);

$data['version'] = $levelOfUpdate;
$data['versionNumber'] = $versionCheckArray['version'];

$Changelog = "";

if($levelOfUpdate != 0)
{
  $Changelog .= "<ul class='settingsUl'>";
}
$version = explode('.', $configStatic['version'] );
$versionCount = count($version);

foreach ($versionCheckArray['versionList'] as $key => $value)
{
  $newestVersion = explode('.', $key);
  $newestVersionCount = count($newestVersion);
  $levelOfUpdate = $levelOfUpdate = findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version);

  if($levelOfUpdate != 0)
  {
    $Changelog .= "<li><h2>Changelog For ".$key." update</h2></li>";
    $Changelog .= $value['releaseNotes'];
  }
}

if($levelOfUpdate != 0)
{
  $Changelog .= "</ul>";
}

$data['changeLog'] = $Changelog;

echo json_encode($data);
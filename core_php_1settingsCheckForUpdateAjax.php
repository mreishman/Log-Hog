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

if($branchSelected === "dev")
{
  file_put_contents("../../update/downloads/versionCheck/versionCheck.zip", 
  file_get_contents($baseUrlUpdate ."versionCheckDev.zip")
  );
}
elseif($branchSelected == "beta")
{
  file_put_contents("../../update/downloads/versionCheck/versionCheck.zip", 
  file_get_contents($baseUrlUpdate ."versionCheckBeta.zip")
  );
}
else
{
  file_put_contents("../../update/downloads/versionCheck/versionCheck.zip", 
  file_get_contents($baseUrlUpdate ."versionCheck.zip")
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

$files = glob("../../update/downloads/versionCheck/extracted/*"); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

file_put_contents("configStatic.php", $newInfoForConfig);

rmdir("../../update/downloads/versionCheck/extracted/");


$version = $configStatic['version'];
$newestVersion = $versionCheckArray['version'];

$version = explode('.', $configStatic['version'] ); 
$newestVersion =  explode('.', $versionCheckArray['version']);

$newestVersionCount = count($newestVersion);
$versionCount = count($version);
$levelOfUpdate = 0;
for($i = 0; $i < $newestVersionCount; $i++)
{
  if($i < $versionCount)
  {
    if($i == 0)
    {
      if($newestVersion[$i] > $version[$i])
      {
        $levelOfUpdate = 3;
        break;
      }
      elseif($newestVersion[$i] < $version[$i])
      {
        break;
      }
    }
    elseif($i == 1)
    {
      if($newestVersion[$i] > $version[$i])
      {
        $levelOfUpdate = 2;
        break;
      }
      elseif($newestVersion[$i] < $version[$i])
      {
        break;
      }
    }
    else
    {
      if(isset($newestVersion[$i]))
      {
        if($newestVersion[$i] > $version[$i])
        {
          $levelOfUpdate = 1;
          break;
        }
        elseif($newestVersion[$i] < $version[$i])
        {
          break;
        }
      }
      else
      {
        break;
      }
    }
  }
  else
  {
    $levelOfUpdate = 1;
    break;
  }
}


$data['version'] = $levelOfUpdate;
$data['versionNumber'] = $versionCheckArray['version'];



$Changelog = "<ul id='settingsUl'>";
$version = explode('.', $configStatic['version'] ); 
$versionCount = count($version);

foreach ($versionCheckArray['versionList'] as $key => $value) 
{
 
  $newestVersion = explode('.', $key);
  $newestVersionCount = count($newestVersion);
  $levelOfUpdate = 0;
  for($i = 0; $i < $newestVersionCount; $i++)
  {
    if($i < $versionCount)
    {
      if($i == 0)
      {
        if($newestVersion[$i] > $version[$i])
        {
          $levelOfUpdate = 3;
          break;
        }
        elseif($newestVersion[$i] < $version[$i])
        {
          break;
        }
      }
      elseif($i == 1)
      {
        if($newestVersion[$i] > $version[$i])
        {
          $levelOfUpdate = 2;
          break;
        }
        elseif($newestVersion[$i] < $version[$i])
        {
          break;
        }
      }
      else
      {
        if($newestVersion[$i] > $version[$i])
        {
          $levelOfUpdate = 1;
          break;
        }
        elseif($newestVersion[$i] < $version[$i])
        {
          break;
        }
      }
    }
    else
    {
      $levelOfUpdate = 1;
      break;
    }
  }

  if($levelOfUpdate != 0)
  {
    $Changelog .= "<li><h2>Changelog For ".$key." update</h2></li>";
    $Changelog .= $value['releaseNotes'];
  }
}

$Changelog .= "</ul>";


$data['changeLog'] = $Changelog;

echo json_encode($data); 

?>
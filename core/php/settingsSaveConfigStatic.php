<?php
require_once("class/core.php");
$session = new core();
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
  echo json_encode(array("error" => 14));
  exit();
}
$fileName = 'configStatic.php';
require_once($fileName);

$version = $configStatic['version'];
if(isset($_POST['version']))
{
	$version = $_POST['version'];
}

$lastCheck = $configStatic['lastCheck'];
if(isset($_POST['lastCheck']))
{
	$lastCheck = $_POST['lastCheck'];
}

$newestVersion = $configStatic['newestVersion'];
if(isset($_POST['newestVersion']))
{
	$newestVersion = $_POST['newestVersion'];
}

$arrayForVersionList = "";
$countOfArray = count($configStatic['versionList']);
$i = 0;
foreach ($configStatic['versionList'] as $key => $value) {
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
  'version'   => '".$version."',
  'lastCheck'   => '".$lastCheck."',
  'newestVersion' => '".$newestVersion."',
  'versionList' => array(
  ".$arrayForVersionList."
  )
);
";

if(file_exists($fileName))
{
  unlink($fileName);
}
file_put_contents($fileName, $newInfoForConfig);
echo json_encode(true);
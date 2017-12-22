<?php


require_once('configStatic.php');

	$fileName = 'configStatic.php';

	//Don't forget to update Ajax version

if(isset($_POST['version']))
{
	$version = $_POST['version'];
}
else
{
	$version = $configStatic['version'];
}

if(isset($_POST['lastCheck']))
{
	$lastCheck = $_POST['lastCheck'];
}
else
{
	$lastCheck = $configStatic['lastCheck'];
}

if(isset($_POST['newestVersion']))
{
	$newestVersion = $_POST['newestVersion'];
}
else
{
	$newestVersion = $configStatic['newestVersion'];
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

	//Don't forget to update Ajax version

	file_put_contents($fileName, $newInfoForConfig);

	echo json_encode(true);
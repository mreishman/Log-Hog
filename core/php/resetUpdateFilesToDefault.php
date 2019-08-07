<?php
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
if(!$session->validate())
{
	echo json_encode(array("error" => 18));
	exit();
}
$fileName = "updateProgressFileNext.php";
$newInfoForConfig = "<?php
	$"."updateProgress = array(
  	'currentStep'   => 'Finished Updating to ',
  	'action' => 'finishedUpdate',
  	'percent'	=> 0
	);
	?>";
if(file_exists($fileName))
{
	unlink($fileName);
}
file_put_contents($fileName, $newInfoForConfig);

$fileName = "updateProgressFile.php";
$newInfoForConfig = "<?php
	$"."updateProgress = array(
  	'currentStep'   => 'Finished Updating to ',
  	'action' => 'finishedUpdate',
  	'percent'	=> 0
	);
	?>";
if(file_exists($fileName))
{
	unlink($fileName);
}
file_put_contents($fileName, $newInfoForConfig);

echo json_encode(true);
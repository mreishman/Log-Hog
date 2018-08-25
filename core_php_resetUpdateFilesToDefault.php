<?php

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

$fileName = "updateProgressLog.php";
$newInfoForConfig = "<p> Loading update file list. </p>";
if(file_exists($fileName))
{
	unlink($fileName);
}
file_put_contents($fileName, $newInfoForConfig);

$fileName = "updateProgressLogHead.php";
$newInfoForConfig = "<p id='headerForUpdate'><?php echo $"."updateProgress['currentStep']; echo ' '; echo $"."versionToUpdate; ?>.</p>";
if(file_exists($fileName))
{
	unlink($fileName);
}
file_put_contents($fileName, $newInfoForConfig);

echo json_encode(true);
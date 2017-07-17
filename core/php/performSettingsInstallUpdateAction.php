<?php
require_once('settingsInstallUpdate.php');
$action = $_POST['action'];
$response = $action;
if($action == 'downloadFile')
{
	downloadFile($_POST['file'],false,$_POST['downloadFrom'],$_POST['downloadTo']);
	$response = true; 
}
elseif($action == 'unzipFile')
{
	unzipFile($_POST['locationExtractTo'], $_POST['locationExtractFrom']);
	$response = true; 
}
elseif($action == 'removeZipFile')
{
	removeZipFile($_POST['fileToUnlink']);
	$response = true; 
}
elseif($action == 'removeUnZippedFiles')
{
	$removeDir = true;
	if(isset($_POST['removeDir']))
	{
		$removeDir = $_POST['removeDir'];
	}
	removeUnZippedFiles($_POST['locationOfFilesThatNeedToBeRemovedRecursivally'],$removeDir);
	$response = true; 
}
elseif($action == 'verifyFileIsThere')
{
	$response = verifyFileIsThere($_POST['fileLocation']);
}
elseif($action == 'verifyDirIsThere')
{
	$response = verifyFileIsThere($_POST['dirLocation']);
}
elseif($action == 'checkIfDirIsEmpty')
{
	if (verifyDirIsEmpty($_POST['dir'])) 
	{
  		$response = true; 
	}
	else
	{
  		$response = false;
	}
}
echo json_encode($response);
?>
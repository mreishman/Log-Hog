<?php
require_once('settingsInstallUpdate.php');
$action = $_POST['action'];
if($action == 'downloadFile')
{
	downloadFile($_POST['file'],false,$_POST['downloadFrom'],$_POST['downloadTo']);
	return true;
}
elseif($action == 'unzipFile')
{
	unzipFile($_POST['locationExtractTo'], $_POST['locationExtractFrom']);
	return true;
}
elseif($action == 'removeZipFile')
{
	removeZipFile($_POST['fileToUnlink']);
	return true;
}
elseif($action == 'removeUnZippedFiles')
{
	$removeDir = true;
	if(isset($_POST['removeDir']))
	{
		$removeDir = $_POST['removeDir']
	}
	removeUnZippedFiles($_POST['locationOfFilesThatNeedToBeRemovedRecursivally'],$removeDir);
	return true;
}
elseif($action == 'verifyFileIsThere')
{
	return verifyFileIsThere($_POST['fileLocation']);
}
elseif($action == 'verifyDirIsThere')
{
	return verifyFileIsThere($_POST['dirLocation']);
}
elseif($action == 'checkIfDirIsEmpty')
{
	if (is_dir_empty($_POST['dir'])) 
	{
  		echo true; 
	}
	else
	{
  		echo false;
	}
}
?>
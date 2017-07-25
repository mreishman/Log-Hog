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
	unzipFileAndSub($_POST['locationExtractFrom'],"",$_POST['locationExtractTo'],"../../");
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
	$response = verifyFileIsThere($_POST['fileLocation'], $_POST['isThere']);
}
elseif($action == 'verifyDirIsThere')
{
	$response = verifyDirIsThere($_POST['dirLocation']);
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
elseif($action == 'cleanUpMonitor')
{
	if(is_dir('../../top'))
	{
		rmdir('../../top');
	}

	rename('../../monitor-master', '../../top');

	return true;
}
elseif($action == 'changeMonSettings')
{
	$string = "<?php
		$"."monitorStatus = array(
	'withLogHog'	=> 'true'
	);
	?>";

	file_put_contents("../../top/statusTest.php", $string);

	return true;
}
elseif($action == 'removeUnneededFoldersMonitor')
{
	$removeDir = true;
	rrmdir('../../top/core/',$removeDir);
	rrmdir('../../top/local/',$removeDir);
	rrmdir('../../top/settings/',$removeDir);
	rrmdir('../../top/setup/',$removeDir);
	rrmdir('../../top/update/',$removeDir);
	removeZipFile('../../top/.gitattributes');
	removeZipFile('../../top/.gitignore');
	removeZipFile('../../top/README.md');
	removeZipFile('../../top/error.php');

	return true;
}
echo json_encode($response);
?>
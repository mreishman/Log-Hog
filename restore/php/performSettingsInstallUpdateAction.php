<?php
require_once("class/core.php");
$core = new core();
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
require_once('class/settingsInstallUpdate.php');
$settingsInstallUpdate = new settingsInstallUpdate();
$action = $_POST['action'];
$response = "ACTION";
if($action === 'downloadFile')
{
	$boolUp = false;
	if(isset($_POST['update']))
	{
		if($_POST['update'] == true)
		{
			$boolUp = true;
		}
	}
	$settingsInstallUpdate->downloadFile($_POST['file'],$boolUp,$_POST['downloadFrom'],$_POST['downloadTo']);
	$response = true;
}
elseif($action === 'unzipFile')
{
	$settingsInstallUpdate->unzipFileAndSub($_POST['locationExtractFrom'],"",$_POST['locationExtractTo'],"../../");
	$response = true;
}
elseif($action === 'unzipUpdateAndReturnArray')
{
	$response = $settingsInstallUpdate->unzipFile();
}
elseif($action === 'removeZipFile')
{
	$settingsInstallUpdate->removeZipFile($_POST['fileToUnlink']);
	$response = true;
}
elseif($action === 'removeUnZippedFiles')
{
	$removeDir = true;
	if(isset($_POST['removeDir']))
	{
		$removeDir = $_POST['removeDir'];
	}
	$settingsInstallUpdate->rrmdir($_POST['locationOfFilesThatNeedToBeRemovedRecursivally']);
	$response = true;
}
elseif($action === 'removeDirUpdate')
{
	$settingsInstallUpdate->removeUnZippedFiles();
	$response = true;
}
elseif($action === 'verifyFileIsThere')
{
	$response = $settingsInstallUpdate->verifyFileIsThere($_POST['fileLocation'], $_POST['isThere']);
}
elseif($action === 'verifyFileHasStuff')
{
	$response = $settingsInstallUpdate->verifyFileHasStuff($_POST['fileLocation']);
}
elseif($action === 'verifyDirIsThere')
{
	$response = $settingsInstallUpdate->verifyDirIsThere($_POST['dirLocation']);
}
elseif($action === "verifyFileOrDirIsThere")
{
	$response = $settingsInstallUpdate->verifyDirOrFile($_POST['locationOfDirOrFile']);
}
elseif($action === 'checkIfDirIsEmpty')
{
	if ($settingsInstallUpdate->verifyDirIsEmpty($_POST['dir']))
	{
  		$response = true;
	}
	else
	{
  		$response = false;
	}
}
elseif($action === 'removeAllFilesFromLogHogExceptRestore')
{
	$files = scandir('../../');
	foreach ($files as $thing => $file)
	{
		if($file != "." && $file != ".." && $file != "restore")
		{
			$fileDir = '../../'.$file;
			if(is_dir($fileDir))
			{
				$settingsInstallUpdate->rrmdir($fileDir);
			}
			else
			{
				$settingsInstallUpdate->removeZipFile($fileDir);
			}
		}
	}
	$response = true;
}
elseif($action === "changeDirUnzipped")
{
	$files = scandir('../../restore/extracted/');
	foreach ($files as $thing => $file)
	{
		$fileDirNew = '../../'.$file;
		$fileDirOld = '../../restore/extracted/'.$file;
		rename($fileDirOld, $fileDirNew);
	}
	$response = true;
}
elseif($action === 'moveDirUnzipped')
{
	rename("../../Log-Hog-".$_POST['version'], "../../restore/extracted");
	$response = true;
}
elseif($action === 'updateProgressFile')
{
	$percent = 0;
	if(isset($_POST['percent']))
	{
		$percent = $_POST['percent'];
	}
	$settingsInstallUpdate->updateProgressFile($_POST['status'], $_POST['pathToFile'], $_POST['typeOfProgress'], $_POST['actionSave'], $percent);

	$response = true;
}
elseif($action === 'copyFileToFile')
{
	$indexToExtracted = "update/downloads/updateFiles/extracted/";
	if(isset($_POST['fileCopyTo']))
	{
		$indexToExtracted = $_POST['fileCopyTo'];
	}
	$response = $settingsInstallUpdate->copyFileToFile($_POST['fileCopyFrom'], $indexToExtracted);
}
elseif($action === 'updateConfigStatic')
{
	$settingsInstallUpdate->updateConfigStatic($_POST['versionToUpdate']);
	$response = true;
}
elseif($action === 'createFolder')
{
	$newDir = $_POST["newDir"];
	if(!file_exists($newDir))
	{
		mkdir($newDir);
	}
	$response = true;
}
echo json_encode($response);
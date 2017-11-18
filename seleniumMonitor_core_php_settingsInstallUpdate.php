<?php


function updateMainProgressLogFile($dotsTime)
{

	require_once('configStatic.php');
	require_once('updateProgressFileNext.php');

	$dots = "";
	while($dotsTime > 0.1)
	{
		$dots .= " .";
		$dotsTime -= 0.1;
	}
	$versionToUpdate = "";

	//find next version to update to
	if(!empty($configStatic))
	{
		$keys = array_keys($configStatic['versionList']);
		foreach ($keys as $key)
		{
			$version = explode('.', $configStatic['version']);
			$newestVersion = explode('.', $key);

			$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update

			$newestVersionCount = count($newestVersion);
			$versionCount = count($version);

			for($i = 0; $i < $newestVersionCount; $i++)
			{
				if($i < $versionCount)
				{
					if($i === 0)
					{
						if($newestVersion[$i] > $version[$i])
						{
							$levelOfUpdate = 3;
							$versionToUpdate = $key;
							break;
						}
						elseif($newestVersion[$i] < $version[$i])
						{
							break;
						}
					}
					elseif($i === 1)
					{
						if($newestVersion[$i] > $version[$i])
						{
							$levelOfUpdate = 2;
							$versionToUpdate = $key;
							break;
						}
						elseif($newestVersion[$i] < $version[$i])
						{
							break;
						}
					}
					elseif($i > 1)
					{
						if($newestVersion[$i] > $version[$i])
						{
							$levelOfUpdate = 1;
							$versionToUpdate = $key;
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
					$versionToUpdate = $key;
					break;
				}
			}

			if($levelOfUpdate != 0)
			{
				break;
			}

		}
	}

	if(!empty($configStatic))
	{
		$varForHeaderTwo = '"'.$versionToUpdate.'"';
		$stringToFindHeadTwo = "$"."versionToUpdate";
	}
	else
	{
		$varForHeaderTwo = '"New Version"';
		$stringToFindHeadTwo = "$"."versionToUpdate";
	}
	$dots .= "</p>";
	$varForHeader = '"'.$updateProgress['currentStep'].'"';

	$stringToFindHead = "$"."updateProgress['currentStep']";

	$headerFileContents = file_get_contents("updateProgressLogHead.php");
	$headerFileContents = str_replace('id="headerForUpdate"', "", $headerFileContents);
	$headerFileContents = str_replace($stringToFindHead, $varForHeader , $headerFileContents);
	$headerFileContents = str_replace($stringToFindHeadTwo, $varForHeaderTwo , $headerFileContents);
	$headerFileContents = str_replace('.</p>', $dots, $headerFileContents);
	$mainFileContents = file_get_contents("updateProgressLog.php");
	$mainFileContents = $headerFileContents.$mainFileContents;
	file_put_contents("updateProgressLog.php", $mainFileContents);
}

function updateProgressFile($status, $pathToFile, $typeOfProgress, $action, $percent = 0)
{
	$writtenTextTofile = "<?php
$"."updateProgress = array(
'currentStep'   => '".$status."',
'action' => '".$action."',
'percent' => ".$percent."
);
?>";

	$fileToPutContent = $pathToFile.$typeOfProgress;

	file_put_contents($fileToPutContent, $writtenTextTofile);
}

function downloadFile($file = null, $update = true, $downloadFrom = 'SeleniumMonitor/archive/', $downloadTo = '../../update/downloads/updateFiles/updateFiles.zip')
{

	if($update == true)
	{
		require_once('configStatic.php');
		$file = $configStatic['versionList'][$file]['branchName'];
	}

	file_put_contents($downloadTo,
	file_get_contents("https://github.com/mreishman/".$downloadFrom.$file.".zip")
	);
}

function rrmdir($dir)
{
	if (is_dir($dir))
	{
		actuallyRemoveDir($dir);
	}
}

function actuallyRemoveDir($dir)
{
	$objects = scandir($dir);
	foreach ($objects as $object)
	{
		if ($object != "." && $object != "..")
		{
			if (filetype($dir."/".$object) == "dir")
			{
				rrmdir($dir."/".$object);
			}
			else
			{
				unlink($dir."/".$object);
			}
		}
	}
	reset($objects);
	rmdir($dir);
}

function unzipFile($locationExtractTo = '../../update/downloads/updateFiles/extracted/', $locationExtractFrom = '../../update/downloads/updateFiles/updateFiles.zip')
{
	if($locationExtractTo == "")
	{
		$locationExtractTo = '../../update/downloads/updateFiles/extracted/';
	}

	if(!file_exists($locationExtractTo))
	{
		mkdir($locationExtractTo);
	}
	$zip = new ZipArchive;
	$path = $locationExtractFrom;
	$res = $zip->open($path);
	$arrayOfExtensions = array('.php','.js','.css','.html','.png','.jpg','.jpeg','.gif');
	$arrayOfFiles = array();
	if ($res === true) {
	  for($i = 0; $i < $zip->numFiles; $i++) {
	        $filename = $zip->getNameIndex($i);
	        $fileinfo = pathinfo($filename);
	        if (strposa($fileinfo["basename"], $arrayOfExtensions, 1))
	        {
	          copy("zip://".$path."#".$filename, $locationExtractTo.$fileinfo['basename']);
	          array_push($arrayOfFiles, $fileinfo['basename']);
	        }
	    }
	    $zip->close();
	}
	if(empty($arrayOfFiles))
	{
		return false;
	}
	else
	{
		return $arrayOfFiles;
	}
}

function unzipFileAndSub($zipfile, $subpath, $destination, $temp_cache, $traverseFirstSubdir=true){
	$zip = new ZipArchive;
	if(substr($temp_cache, -1) !== DIRECTORY_SEPARATOR)
	{
		$temp_cache .= DIRECTORY_SEPARATOR;
	}
	$res = $zip->open($zipfile);
	if ($res === true)
	{
	    if ($traverseFirstSubdir === true)
	    {
	        $zip_dir = $temp_cache . $zip->getNameIndex(0);
	    }
	    else
	    {
	    	$temp_cache = $temp_cache . basename($zipfile, ".zip");
	    	$zip_dir = $temp_cache;
	    }

	    $zip->extractTo($temp_cache);
	    $zip->close();

	    if($zip_dir !== $destination)
	    {
		    rename($zip_dir . DIRECTORY_SEPARATOR . $subpath, $destination);

		    rrmdir($zip_dir);
		}
	    return true;
	}
	else
	{
	    return false;
	}
}

function strposa($haystack, $needle, $offset=0)
{
	if(!is_array($needle))
	{
		$needle = array($needle);
	}
	foreach($needle as $query)
	{
		if(strpos($haystack, $query, $offset) !== false)
		{
			return true; // stop on first true result
		}
	}
	return false;
}

function removeZipFile($fileToUnlink = "../../update/downloads/updateFiles/updateFiles.zip")
{
	if($fileToUnlink == "")
	{
		$fileToUnlink = "../../update/downloads/updateFiles/updateFiles.zip";
	}
	if(is_file($fileToUnlink))
	{
		unlink($fileToUnlink);
	}
}


function removeUnZippedFiles($recRemovedFileLoc = '../../update/downloads/updateFiles/extracted', $removeDirectory = true)
{
	if($recRemovedFileLoc == "")
	{
		$recRemovedFileLoc = '../../update/downloads/updateFiles/extracted';
	}
	$files = glob($recRemovedFileLoc."/*"); // get all file names
	foreach($files as $file){ // iterate files
	  if(is_file($file))
	    unlink($file); // delete file
	}
	if($removeDirectory)
	{
		removeDirectory();
	}
}

function removeDirectory($directory = "../../update/downloads/updateFiles/extracted/")
{
	if(is_dir($directory))
	{
		rmdir($directory);
	}
}

function verifyFileIsThere($file, $notInvert = true)
{
	if(is_file($file))
	{
		if($notInvert == false || $notInvert == "false")
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	else
	{
		if($notInvert == false || $notInvert == "false")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}

function verifyDirIsThere($file)
{
	if(is_dir($file))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function verifyDirOrFile($file)
{
	if(is_file($file) || is_dir($file))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function verifyDirIsEmpty($dir)
{
	if (!is_readable($dir))
	{
		return null;
	}
	return (count(scandir($dir)) == 2);
}

function handOffToUpdate()
{
	require_once('../../update/downloads/updateFiles/extracted/updateScript.php');
}

function copyFileToFile($currentFile, $indexToExtracted = "update/downloads/updateFiles/extracted/")
{
	$varToIndexDir = "../../";

	$currentFileArray = explode("_", $currentFile );
	$sizeCurrentFileArray = sizeOf($currentFileArray);
	$nameOfFile = $currentFileArray[$sizeCurrentFileArray - 1];
	$directoryPath = "";
	  
	for($i = 0; $i < $sizeCurrentFileArray - 1; $i++)
	{
	  $directoryPath .= $currentFileArray[$i]."/";
	}
	 
	$newFile = $directoryPath.$nameOfFile;
	$fileTransfer = file_get_contents($varToIndexDir.$indexToExtracted.$currentFile);
	$newFileWithIndexVar = $varToIndexDir.$newFile;
	file_put_contents($newFileWithIndexVar,$fileTransfer);
	return ($newFileWithIndexVar);
}

function updateConfigStatic($versionToUpdate)
{
	require_once('configStatic.php');

	$arrayForVersionList = "";
	$countOfArray = count($configStatic['versionList']);
	$count = 0;
	foreach ($configStatic['versionList'] as $key => $value) {
	  $count++;
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
	  if($count != $countOfArray)
	  {
	    $arrayForVersionList .= ",";
	  }
	}

	$newInfoForConfig = "<?php

$"."configStatic = array(
	'version'   => '".$versionToUpdate."',
	'lastCheck'   => '".date('m-d-Y')."',
	'newestVersion' => '".$configStatic['newestVersion']."',
	'versionList' => array(
		".$arrayForVersionList."
	)
);";
	file_put_contents("configStatic.php", $newInfoForConfig);
}

function finishedUpdate()
{
	//nothing!
}
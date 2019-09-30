<?php

class settingsInstallUpdate
{
	public function updateProgressFile($status, $pathToFile, $typeOfProgress, $action, $percent = 0)
	{
		$writtenTextTofile = "<?php
	$"."updateProgress = array(
	'currentStep'   => '".$status."',
	'action' => '".$action."',
	'percent' => ".$percent."
	);
	?>";

		$fileToPutContent = $pathToFile.$typeOfProgress;
		if(file_exists($fileToPutContent))
		{
			unlink($fileToPutContent);
		}
		file_put_contents($fileToPutContent, $writtenTextTofile);
	}

	public function downloadFile($file = null, $update = true, $downloadFrom = 'Log-Hog/archive/', $downloadTo = '../../update/downloads/updateFiles/updateFiles.zip')
	{

		if($update == true)
		{
			require_once('configStatic.php');
			$file = $configStatic['versionList'][$file]['branchName'];
		}
		if(file_exists($downloadTo))
		{
			unlink($downloadTo);
		}
		file_put_contents($downloadTo,
		file_get_contents("https://github.com/mreishman/".$downloadFrom.$file.".zip")
		);
	}

	public function rrmdir($dir)
	{
		if (is_dir($dir))
		{
			$this->actuallyRemoveDir($dir);
		}
	}

	private function actuallyRemoveDir($dir)
	{
		$objects = scandir($dir);
		foreach ($objects as $object)
		{
			if ($object != "." && $object != "..")
			{
				if (filetype($dir."/".$object) == "dir")
				{
					$this->rrmdir($dir."/".$object);
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

	public function unzipFile($locationExtractTo = '../../update/downloads/updateFiles/extracted/', $locationExtractFrom = '../../update/downloads/updateFiles/updateFiles.zip')
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
		        if ($this->strposa($fileinfo["basename"], $arrayOfExtensions, 1))
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

	public function unzipFileAndSub($zipfile, $subpath, $destination, $temp_cache, $traverseFirstSubdir=true){
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

			    $this->rrmdir($zip_dir);
			}
		    return true;
		}
		else
		{
		    return false;
		}
	}

	private function strposa($haystack, $needle, $offset=0)
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

	public function removeZipFile($fileToUnlink = "../../update/downloads/updateFiles/updateFiles.zip")
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

	public function removeUnZippedFiles($recRemovedFileLoc = '../../update/downloads/updateFiles/extracted', $removeDirectory = true)
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
			$this->removeDirectory();
		}
	}

	private function removeDirectory($directory = "../../update/downloads/updateFiles/extracted/")
	{
		if(is_dir($directory))
		{
			rmdir($directory);
		}
	}

	public function verifyFileIsThere($file, $notInvert = true)
	{
		if(is_file($file))
		{
			if($notInvert == false || $notInvert == "false")
			{
				return false;
			}
			return true;
		}
		if($notInvert == false || $notInvert == "false")
		{
			return true;
		}
		return false;
	}

	public function verifyFileHasStuff($file)
	{
		if(is_file($file) && filesize($file))
		{
			return true;
		}
		return false;
	}

	public function verifyDirIsThere($file)
	{
		if(is_dir($file))
		{
			return true;
		}
		return false;
	}

	public function verifyDirOrFile($file)
	{
		if(is_file($file) || is_dir($file))
		{
			return true;
		}
		return false;
	}

	public function verifyDirIsEmpty($dir)
	{
		if (!is_readable($dir))
		{
			return null;
		}
		return (count(scandir($dir)) == 2);
	}

	public function copyFileToFile($currentFile, $indexToExtracted = "update/downloads/updateFiles/extracted/")
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
		if(file_exists($newFileWithIndexVar))
		{
			unlink($newFileWithIndexVar);
		}
		file_put_contents($newFileWithIndexVar,$fileTransfer);
		return ($newFileWithIndexVar);
	}

	public function updateConfigStatic($versionToUpdate)
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
	if(file_exists("configStatic.php"))
		{
			unlink("configStatic.php");
		}
		file_put_contents("configStatic.php", $newInfoForConfig);
	}
}
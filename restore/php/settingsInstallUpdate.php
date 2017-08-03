<?php




function downloadFile($file = null, $update = true, $downloadFrom = 'Log-Hog/archive/', $downloadTo = '../../update/downloads/updateFiles/updateFiles.zip')
{
	if($file == null)
	{
		$file = $POST_['file'];
	}
	file_put_contents($downloadTo, 
	file_get_contents("https://github.com/mreishman/".$downloadFrom.$file.".zip")
	);
}

function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
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
	if ($res === TRUE) {
	  for($i = 0; $i < $zip->numFiles; $i++) {
	        $filename = $zip->getNameIndex($i);
	        $fileinfo = pathinfo($filename);
	        if (strposa($fileinfo['basename'], $arrayOfExtensions, 1)) 
	        {
	          copy("zip://".$path."#".$filename, $locationExtractTo.$fileinfo['basename']);
	        }
	    }                   
	    $zip->close();  
	}
}

function unzipFileAndSub($zipfile, $subpath, $destination, $temp_cache, $traverse_first_subdir=true){
	$zip = new ZipArchive;
	if(substr($temp_cache, -1) !== DIRECTORY_SEPARATOR) {
		$temp_cache .= DIRECTORY_SEPARATOR;
	}
	$res = $zip->open($zipfile);
	if ($res === TRUE) {
	    if ($traverse_first_subdir==true){
	        $zip_dir = $temp_cache . $zip->getNameIndex(0);
	    }
	    else {
	    	$temp_cache = $temp_cache . basename($zipfile, ".zip");
	    	$zip_dir = $temp_cache;
	    }

	    $zip->extractTo($temp_cache);
	    $zip->close();

	    //rename($zip_dir . DIRECTORY_SEPARATOR . $subpath, $destination);

	    //rrmdir($zip_dir);
	    return true;
	} else {
	    return false;
	}
}

function strposa($haystack, $needle, $offset=0) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $query) {
        if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
    }
    return false;
}

function removeZipFile($fileToUnlink = "../../update/downloads/updateFiles/updateFiles.zip")
{
	if($fileToUnlink == "")
	{
		$fileToUnlink = "../../update/downloads/updateFiles/updateFiles.zip";
	}
	unlink($fileToUnlink);
}


function removeUnZippedFiles($locationOfFilesThatNeedToBeRemovedRecursivally = '../../update/downloads/updateFiles/extracted', $removeDirectory = true)
{
	if($locationOfFilesThatNeedToBeRemovedRecursivally == "")
	{
		$locationOfFilesThatNeedToBeRemovedRecursivally = '../../update/downloads/updateFiles/extracted';
	}
	$files = glob($locationOfFilesThatNeedToBeRemovedRecursivally."/*"); // get all file names
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

function verifyDirIsEmpty($dir) 
{
  if (!is_readable($dir)) return NULL; 
  return (count(scandir($dir)) == 2);
}
?>
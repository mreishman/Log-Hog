<?php


function updateMainProgressLogFile($dotsTime)
{
	require_once('updateProgressFileNext.php');

	$dots = "";
	while($dotsTime > 0.1)
	{
		$dots .= " .";
		$dotsTime -= 0.1;
	}
	$dots .= "</p>";
	$varForHeader = '"'.$updateProgress['currentStep'].'"';
	$varForHeaderTwo = '"'.$versionToUpdate.'"';
	$stringToFindHead = "$"."updateProgress['currentStep']";
	$stringToFindHeadTwo = "$"."versionToUpdate";
	$headerFileContents = file_get_contents("updateProgressLogHead.php");
	$headerFileContents = str_replace('id="headerForUpdate"', "", $headerFileContents);
	$headerFileContents = str_replace($stringToFindHead, $varForHeader , $headerFileContents);
	$headerFileContents = str_replace($stringToFindHeadTwo, $varForHeaderTwo , $headerFileContents);
	$headerFileContents = str_replace('.</p>', $dots, $headerFileContents);
	$mainFileContents = file_get_contents("updateProgressLog.php");
	$mainFileContents = $headerFileContents.$mainFileContents;
	file_put_contents("updateProgressLog.php", $mainFileContents);
}

function updateHeadProgressLogFile($message)
{

}

function updateProgressFile($status, $pathToFile, $typeOfProgress, $action)
{
	$writtenTextTofile = "<?php
	$"."updateProgress = array(
  	'currentStep'   => '".$status."',
  	'action' => '".$action."'
	);
	?>
	";

	$fileToPutContent = $pathToFile.$typeOfProgress;

	file_put_contents($fileToPutContent, $writtenTextTofile);
}

function downloadFile($file)
{
	require_once('configStatic.php');

	$arrayForFile = $configStatic['versionList'];
	$arrayForFile = $arrayForFile[$file];
	file_put_contents("../../update/downloads/updateFiles/updateFiles.zip", 
	file_get_contents("https://github.com/mreishman/Log-Hog/archive/".$arrayForFile['branchName'].".zip")
	);
}

function unzipFile()
{


	mkdir("../../update/downloads/updateFiles/extracted/");
	$zip = new ZipArchive;
	$path = "../../update/downloads/updateFiles/updateFiles.zip";
	$res = $zip->open($path);
	$arrayOfExtensions = array('.php','.js','.css','.html','.png','.jpg','.jpeg');
	if ($res === TRUE) {
	  for($i = 0; $i < $zip->numFiles; $i++) {
	        $filename = $zip->getNameIndex($i);
	        $fileinfo = pathinfo($filename);
	        if (strposa($fileinfo['basename'], $arrayOfExtensions, 1)) 
	        {
	          copy("zip://".$path."#".$filename, "../../update/downloads/updateFiles/extracted/".$fileinfo['basename']);
	        }
	    }                   
	    $zip->close();  
	}
}

function strposa($haystack, $needle, $offset=0) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $query) {
        if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
    }
    return false;
}

function removeZipFile()
{
	unlink("../../update/downloads/updateFiles/updateFiles.zip");
}


function removeUnZippedFiles()
{
	$files = glob("../../update/downloads/updateFiles/extracted/*"); // get all file names
	foreach($files as $file){ // iterate files
	  if(is_file($file))
	    unlink($file); // delete file
	}

	rmdir("../../update/downloads/updateFiles/extracted/");

}

function handOffToUpdate()
{
	require_once('../../update/downloads/updateFiles/extracted/updateScript.php');
}

function finishedUpdate()
{
	//nothing!
}

?>
<?php

//check for previous update, if failed


if(file_exists("../../update/downloads/versionCheck/extracted/"))
{
  //dir exists
  if(file_exists("../../update/downloads/versionCheck/extracted/versionsCheckFile.php"))
  {
    //last version check here
    $files = glob("../../update/downloads/versionCheck/extracted/*"); // get all file names
    foreach($files as $file)
    { // iterate files
        if(is_file($file))
          unlink($file); // delete file
    }
    rmdir("../../update/downloads/versionCheck/extracted/");
  }

}

file_put_contents("../../update/downloads/versionCheck/versionCheck.zip", 
file_get_contents("https://github.com/mreishman/Log-Hog/archive/versionCheck.zip")
);
mkdir("../../update/downloads/versionCheck/extracted/");
$zip = new ZipArchive;
$path = "../../update/downloads/versionCheck/versionCheck.zip";
$res = $zip->open($path);
if ($res === TRUE) {
  for($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);
        $fileinfo = pathinfo($filename);
        if (strpos($fileinfo['basename'], '.php') !== false) 
        {
          copy("zip://".$path."#".$filename, "../../update/downloads/versionCheck/extracted/".$fileinfo['basename']);
        }
    }                   
    $zip->close();  
}

unlink("../../update/downloads/versionCheck/versionCheck.zip");

require_once('../../update/downloads/versionCheck/extracted/versionsCheckFile.php');

$newInfoForConfig = "
<?php

$"."configStatic = array(
  'version'   => '2.0',
  'lastCheck'   => '03-06-2017',
  'newestVersion' => '".$versionCheckArray['version']."'
);
";


//write new info to version file in core/php/configStatic.php

$files = glob("../../update/downloads/versionCheck/extracted/*"); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

file_put_contents("configStatic.php", $newInfoForConfig);

rmdir("../../update/downloads/versionCheck/extracted/");

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>
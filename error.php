<?php
$baseUrl = "core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = "local/";
	//there is custom information, use this
	require_once('local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('core/conf/config.php');
require_once('core/php/configStatic.php');  
?>

<h1> Error <?php echo $_GET["error"] ?> </h1>
<h1> <?php echo $_GET["page"] ?> </h1>
<img src="core/img/redWarning.png" height="60px">
<?php 

if($_GET["error"] == 550)
{
	echo "<h2>File Permission Error</h2>";
	echo "Make sure the file permissions are set correctly for all of the files within loghog.";
}

?>

<p> More Information: </p>
<p> Current Version of Log-Hog: <?php echo $configStatic['version']; ?> </p>
<p> File Permissions: </p>
<?php

$arrayOfFiles = array("update/updater.php","core/php/configStatic.php","core/php/loadVars.php","core/php/poll.php","core/php/settingsCheckForUpdate.php","core/php/settingsCheckForUpdateAjax.php","core/php/settingsSave.php","core/php/settingsInstallUpdate.php","core/php/updateActionFile.php","core/php/updateProgressFile.php","core/php/updateProgressFileNext.php","core/php/updateProgressLog.php","core/php/updateProgressLogHead.php","core/php/verifyWriteStatus.php");

foreach ($arrayOfFiles as $key) 
{

 $perms  =  fileperms($key); 

switch ($perms & 0xF000) {
    case 0xC000: // socket
        $info = 's';
        break;
    case 0xA000: // symbolic link
        $info = 'l';
        break;
    case 0x8000: // regular
        $info = 'r';
        break;
    case 0x6000: // block special
        $info = 'b';
        break;
    case 0x4000: // directory
        $info = 'd';
        break;
    case 0x2000: // character special
        $info = 'c';
        break;
    case 0x1000: // FIFO pipe
        $info = 'p';
        break;
    default: // unknown
        $info = 'u';
}

// Owner
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));

// Group
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));

// World
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));

echo "<p>";
if((strpos(substr($info, 0, -7), "w")) === false)
{
echo '<img src="core/img/redWarning.png" height="10px">';
}
else
{
echo '<img src="core/img/greenCheck.png" height="10px">';
}
echo "  ";
echo $key;
echo "   -   ";
echo $info;
echo "</p>";
}
?>
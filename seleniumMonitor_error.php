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
require_once('core/php/commonFunctions.php');
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
<p> Current Version of seleniumMonitor: <?php echo $configStatic['version']; ?> </p>
<p> File Permissions: </p>
<?php

$arrayOfFiles = array("update/updater.php","core/php/configStatic.php","core/php/loadVars.php","core/php/poll.php","core/php/settingsCheckForUpdate.php","core/php/settingsCheckForUpdateAjax.php","core/php/settingsSave.php","core/php/settingsInstallUpdate.php","core/php/updateActionFile.php","core/php/updateProgressFile.php","core/php/updateProgressFileNext.php","core/php/updateProgressLog.php","core/php/updateProgressLogHead.php","core/php/verifyWriteStatus.php");

foreach ($arrayOfFiles as $key)
{

    $info = filePermsDisplay($key);

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
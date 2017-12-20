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
require_once('core/php/template/listOfFiles.php');

$error = "";
if(isset($_GET["error"]))
{
    $error = $_GET["error"];
}

$page = "";
if(isset($_GET["page"]))
{
    $page = $_GET["page"];
}

?>

<h1> Error <?php echo $error ?> </h1>
<h1> <?php echo $page ?> </h1>
<img src="core/img/redWarning.png" height="60px">
<?php
if($error == 550)
{
	echo "<h2>File Permission Error</h2>";
	echo "Make sure the file permissions are set correctly for all of the files within loghog.";
}

?>

<p> More Information: </p>
<p> Current Version of Log-Hog: <?php echo $configStatic['version']; ?> </p>
<p> File Permissions: </p>
<?php

foreach ($fileNameArray as $key => $value)
{

    $info = filePermsDisplay($value["path"]);

    echo "<p>";
    echo "  ";
    echo $value["name"];
    echo "   -   ";
    echo $info;
    echo "</p>";
}
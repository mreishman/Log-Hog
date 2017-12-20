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
<div style="text-align: center; background-color: black; color: white; padding: 20px; min-height: 100px;" >
    <h1 style="line-height: 60px;"> <img style="vertical-align: middle;" src="core/img/redWarning.png" height="60px"> Error <?php echo $error ?> <img  style="vertical-align: middle;" src="core/img/redWarning.png" height="60px"> </h1>
    <h1> <?php echo $page ?> </h1>
    
    <?php
    if($error == 550)
    {
    	echo "<h2>File Permission Error</h2>";
    	echo "Make sure the file permissions are set correctly for all of the files within loghog.";
    }
    elseif($error == 1073)
    {
        echo "<h2>File Is Writable Error</h2>";
        echo "This error occured when a file tried to write to it. Please ensure that the file permissions of the file allow it to be written to, and that the file trying to write has permission to do so.";
    }
    elseif($error == 1072)
    {
        echo "<h2>File Is Readable Error</h2>";
        echo "This error occured when a file tried to read another file. Please ensure that the file permissions of the file allow it to be read / read other files.";
    }

    ?>
</div>
<p>Current Version of Log-Hog: <?php echo $configStatic['version']; ?> </p>
<table style="width: 100%;" >
    <tr>
        <td width="33%" style="background-color: lightgrey">
            <h3> File Permissions: </h3>
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
            ?>
        </td>
        <td width="33%" style="background-color: lightgrey" >
        </td>
        <td width="33%" style="background-color: lightgrey">
        </td>
    </tr>
</table>
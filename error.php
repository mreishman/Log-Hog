<?php
//$baseUrl = "core/";
//if(file_exists('local/layout.php'))
//{
//	$baseUrl = "local/";
	//there is custom information, use this
//	require_once('local/layout.php');
//	$baseUrl .= $currentSelectedTheme."/";
//}
//require_once($baseUrl.'conf/config.php');
//require_once('core/conf/config.php');
require_once('core/php/configStatic.php');
require_once('core/php/commonFunctions.php');
require_once('core/php/template/listOfFiles.php');

$error = 0;
if(isset($_GET["error"]))
{
    $error = $_GET["error"];
}

$page = "";
if(isset($_GET["page"]))
{
    $page = $_GET["page"];
}

$errorArray = array(
    0   =>  array(
        "firstMessage"      =>  "General Error",
        "secondMessage"     =>  "A general error occured, or you navigated to this page directly."
    ),
    1   =>  array(
        "firstMessage"      =>  "Watch-List Config Error",
        "secondMessage"     =>  "Please remove all reference of double backslash (\\\\) from the watchList var in config.php (Local/default/conf/config.php)"
    ),
    550   =>  array(
        "firstMessage"      =>  "File Permission Error",
        "secondMessage"     =>  "Make sure the file permissions are set correctly for all of the files within loghog."
    ),
    1072   =>  array(
        "firstMessage"      =>  "File Is Readable Error",
        "secondMessage"     =>  "This error occured when a file tried to read another file. Please ensure that the file permissions of the file allow it to be read / read other files."
    ),
    1073   =>  array(
        "firstMessage"      =>  "File Is Writable Error",
        "secondMessage"     =>  "This error occured when a file tried to write to it. Please ensure that the file permissions of the file allow it to be written to, and that the file trying to write has permission to do so."
    )
);

if(!isset($errorArray[$error]))
{
    $error = 0;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Error Page</title>
    <style type="text/css">
        .link
        {
            text-decoration: none;
            padding: 5px;
            background: white;
            border: 1px solid black;
            cursor: pointer;
            color: black;
        }
        .list
        {
            list-style: none;
        }
        .list li
        {
            padding: 10px;
        }
        .tableRow td
        {
            background-color: lightgrey;
            vertical-align: top;
        }
    </style>
</head>
<body>


<div style="text-align: center; background-color: black; color: white; padding: 20px; min-height: 100px;" >
    <h1 style="line-height: 60px;"> <img style="vertical-align: middle;" src="core/img/redWarning.png" height="60px"> Error <?php echo $error ?> <img  style="vertical-align: middle;" src="core/img/redWarning.png" height="60px"> </h1>
    <h1> <?php echo $page ?> </h1>
</div>
<table style="width: 100%;" >
    <tr class="tableRow">
        <td width="33%">
            <h3> More Info: </h3>
            <h2><?php echo $errorArray[$error]["firstMessage"]; ?></h2>
            <?php echo $errorArray[$error]["secondMessage"]; ?>
            <h2> Version: </h2>
            <?php echo $configStatic['version']; ?>
        </td>
        <td width="33%">
            <h3> Actions: </h3>
            <ul class="list">
                <li>
                    <a href="../setup/step1.php" class="link">Re-do Setup</a>
                </li>
                <li>
                    <a onclick="revertPopup();" class="link">Revert Version</a>
                </li>
                <li>
                    <a class="link" href="editFiles.php" >View Files</a>
                </li>
            </ul>
        </td>
        <td width="33%">
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
    </tr>
</table>
</body>
</html>
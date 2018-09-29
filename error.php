<?php
$version = "Unknown - Could not find core/php/configStatic.php";
$file = 'core/php/configStatic.php';
if(file_exists($file))
{
    if(is_readable($file))
    {
        try
        {
            require_once($file);
            if(isset($configStatic['version']))
            {
                $version = $configStatic['version'];
            }
            else
            {
                $version = "Config Static was loaded, but errored when loading the version number";
            }
        }
        catch (Exception $e)
        {
            $version = "Unknown - Error reading core/php/configStatic.php";
        }
    }
    else
    {
        $version = "Unknown - core/php/configStatic.php is there, but is not readable by this file";
    }
}

$commonFunctionsLoaded = false;
$file = 'core/php/commonFunctions.php';
if(file_exists($file))
{
    try
    {
        require_once($file);
        $commonFunctionsLoaded = true;
    }
    catch (Exception $e)
    {

    }
}

$fileNameArray = array(
    "Error"    =>  array(
        "name"      =>  "Could not load list of files",
        "path"      =>  ""
    )
);
$file = 'core/php/template/listOfFiles.php';
if(file_exists($file))
{
    if(is_readable($file))
    {
        try
        {
            require_once($file);
        }
        catch (Exception $e)
        {
            $fileNameArray = array(
                "Error"    =>  array(
                    "name"      =>  "List of files exists, but cant be loaded",
                    "path"      =>  ""
                )
            );
        }
    }
    else
    {
        $fileNameArray = array(
            "Error"    =>  array(
                "name"      =>  "List of files exists, but is not readable",
                "path"      =>  ""
            )
        );
    }
}

$error = 42;
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
        "firstMessage"      =>  "",
        "secondMessage"     =>  ""
    ),
    1   =>  array(
        "firstMessage"      =>  "Watch-List Config Error",
        "secondMessage"     =>  "Please remove all reference of double backslash (\\\\) from the watchList var in config.php (Local/default/conf/config.php)"
    ),
    2   =>  array(
        "firstMessage"      =>  "Setup Error",
        "secondMessage"     =>  "An error occured when trying to complete the setup process. Please check that the save file has correct access to write to and create a local config file.  If that doesn't work: Copy core/conf/config.php to local/default/conf/config.php and change defaultConfig to config."
    ),
    3   =>  array(
        "firstMessage"      =>  "Config Folder Save Error",
        "secondMessage"     =>  "An error occured when SettingsSaveAjax tried to save the config file. This file does not have write access to the specific folder (Local/default/conf) to save the updated config file. Please give the correct write access to settingsSaveAjax to save and update the config with the new values."
    ),
    4   =>  array(
        "firstMessage"      =>  "Config File Save Error",
        "secondMessage"     =>  "An error occured when SettingsSaveAjax tried to save the config file. This file does not have write access to the specific file (Local/default/conf/config.php) to save the updated config file. Please give the correct write access to settingsSaveAjax to save and update the config with the new values."
    ),
    5   =>  array(
        "firstMessage"      =>  "Config Save Error",
        "secondMessage"     =>  "An unknown error occured when SettingsSaveAjax tried to save the config file. This file  (Local/default/conf/config.php) could not be updated with the new values."
    ),
    6   =>  array(
        "firstMessage"      =>  "Config Backup Error",
        "secondMessage"     =>  "An unknown error occured when SettingsSaveAjax tried to save a backup of the config file."
    ),
    7   =>  array(
        "firstMessage"      =>  "Local Layout File Error",
        "secondMessage"     =>  "An error occured when trying to locate the local layout file. Please make sure the file is readable and in the correct folder (local/layout.php)"
    ),
    8   =>  array(
        "firstMessage"      =>  "Core Config File Error",
        "secondMessage"     =>  "An error occured when trying to locate the core config file. Please make sure the file is readable and in the correct folder (core/conf/config.php)"
    ),
    9   =>  array(
        "firstMessage"      =>  "Local Layout File Error",
        "secondMessage"     =>  "An error occured when loading the layout file. The file loaded does not contain the expected variable. Please check that the local layout file contains the currentSelectedTheme variable, and is defined (probably default) (local/layout.php)"
    ),
    10   =>  array(
        "firstMessage"      =>  "Core Config File Error",
        "secondMessage"     =>  "An error occured when loading the core config file. The file loaded does not contain the expected variable. Please check that the local layout file contains the defaultConfig variable, and is defined. If it is empty, re copy it from the repo (core/conf/config.php)"
    ),
    11   =>  array(
        "firstMessage"      =>  "Zip Archive is not installed",
        "secondMessage"     =>  "When trying to check for an update, php downloads a Zip file from github. This requires the php module Zip Archive to work. Please install Zip archive to use the update function in log-hog. An example command would be: sudo apt-get install php7.0-zip. If you are unable to install Zip Archive, you can disable automatic update checks under settings. <br><br> <form id=\"formUpdateSave\" ><span class=\"settingsBuffer\" > Auto Check Update: </span><select id=\"settingsSelect\" name=\"autoCheckUpdate\"><option selected value=\"true\">True</option><option value=\"false\">False</option></select><br><br></form><button onclick=\"saveAndVerifyMain('formUpdateSave');\" >Save</button><br><br>This could take up to 60 seconds to refresh the config file"
    ),
    12   =>  array(
        "firstMessage"      =>  "Update check failed because of incorrect write permissions",
        "secondMessage"     =>  "The file configStatic.php could not be written to by settingsCheckForUpdateAjax.php because of incorrect file write permissions. Please update the settingsCheckForUpdateAjax file with correct file permissions to write to configStatic.php (under core/php). If this is not possible, change the auto check for update settings to false to prevent this message."
    ),
    13   =>  array(
        "firstMessage"      =>  "Update check failed because a temporary directory failed to create",
        "secondMessage"     =>  "When checking for updates, a tmp directory is created under update/downloads/versionCheck/extracted/ to hold the zip file and list of versions.  This process errored out when trying to check for updates, throwing this error. Please check if settingsCheckForUpdateAjax.php has correct write permissions to create a folder, and that the target directory has enough free space."
    ),
    14   =>  array(
        "firstMessage"      =>  "Update check failed because it could not open the downloaded zip file",
        "secondMessage"     =>  "When checking for updates, a zip file is download that contains the new version list. An error occured when trying to open the zip file. This could either be due to a permission error or not enough space in the target directory."
    ),
    42   =>  array(
        "firstMessage"      =>  "General Error",
        "secondMessage"     =>  "A general error occured, or you navigated to this page directly."
    ),
    43   =>  array(
        "firstMessage"      =>  "General Update Error",
        "secondMessage"     =>  "A general error occured when trying to check for an update."
    ),
    550   =>  array(
        "firstMessage"      =>  "File Permission Error",
        "secondMessage"     =>  "Make sure the file permissions are set correctly for all of the files within loghog."
    ),
    1072   =>  array(
        "firstMessage"      =>  "File Is Readable Error",
        "secondMessage"     =>  "This error occured when a file tried to read another file. Please ensure that the file permissions of the file allow it to be read / read other files. (is_readable check) "
    ),
    1073   =>  array(
        "firstMessage"      =>  "File Is Writable Error",
        "secondMessage"     =>  "This error occured when a file tried to write to it. Please ensure that the file permissions of the file allow it to be written to, and that the file trying to write has permission to do so. (is_writable check) "
    ),
    1074   =>  array(
        "firstMessage"      =>  "File Is Accessable Error",
        "secondMessage"     =>  "This error occured when a file is trying to be accessed, but cant be found. (file_exists check) "
    ),
);

if(!isset($errorArray[$error]))
{
    $error = 42;
}

$jsForResetToDefaultLoaded = false;
$file = 'core/js/resetSettingsJs.js';
if(file_exists($file))
{
    if(is_readable($file))
    {
        $jsForResetToDefaultLoaded = true;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Error Page</title>
    <script src="core/js/jquery.js"></script>
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
    <script type="text/javascript">
        function showPopup()
        {
            document.getElementById('popup').style.display = "block";
            document.getElementById('popupContentInnerHTMLDiv').innerHTML = "";
        }
        function hidePopup()
        {
            document.getElementById('popup').style.display = "none";
            document.getElementById('popupContentInnerHTMLDiv').innerHTML = "";
        }
        function toggleReset()
        {
            if(document.getElementById('popup').style.display === "none")
            {
                resetSettingsPopup();
            }
            else
            {
                hidePopup();
            }
        }
    </script>
    <?php if($jsForResetToDefaultLoaded): ?>
        <script type="text/javascript" src="core/js/resetSettingsJs.js" ></script>
    <?php endif;?>
</head>
<body>

<?php if($error != 0): ?>
    <div style="text-align: center; background-color: black; color: white; padding: 20px; min-height: 100px;" >
        <h1 style="line-height: 60px;"> <img style="vertical-align: middle;" src="core/img/redWarning.png" height="60px"> Error <?php echo $error ?> <img  style="vertical-align: middle;" src="core/img/redWarning.png" height="60px"> </h1>
        <h1> <?php echo $page ?> </h1>
    </div> 
<?php endif; ?>
<table style="width: 100%;" >
    <tr class="tableRow">
        <td width="33%">
            <h3> More Info: </h3>
            <h2><?php echo $errorArray[$error]["firstMessage"]; ?></h2>
            <?php echo $errorArray[$error]["secondMessage"]; ?>
            <h2> Version: </h2>
            <?php echo $version; ?>
        </td>
        <td width="33%">
            <h3> Actions: </h3>
            <ul class="list">
                <?php
                if(file_exists("setup/step1.php")): ?>
                    <li>
                        <a href="setup/step1.php" class="link">Re-do Setup</a>
                    </li>
                <?php
                endif;
                if(file_exists("restore/restore.php")): ?>
                    <li>
                        <a href="restore/restore.php" class="link">Revert Version</a>
                    </li>
                <?php
                endif;
                if(file_exists("settings/editFiles.php")): ?>
                    <li>
                        <a class="link" href="settings/editFiles.php" >View Files</a>
                    </li>
                <?php
                endif;
                if(file_exists("core/php/loadVars.php") && file_exists("core/conf/config.php") && $jsForResetToDefaultLoaded):
                ?>
                    <li>
                        <a onclick="toggleReset();" class="link">Reset Settings back to Default</a>
                    </li>
                <?php
                endif;
                if(file_exists("core/php/resetUpdateFilesToDefault.php")):
                ?>
                <li>
                    <a onclick="resetUpdateSettings();" class="link"> Reset Update Progress back to default </a>
                </li>
                <?php
                endif;
                ?>
                <li>
                    <div id="popup" style="background-color: #444444; border: 1px solid black; display: none; color: white;">
                        <div id="popupContentInnerHTMLDiv">
                        </div>
                    </div>
                </li>
            </ul>
        </td>
        <td width="33%">
            <h3> File Permissions: </h3>
            <?php
            foreach ($fileNameArray as $key => $value)
            {
                $info = "";
                if($commonFunctionsLoaded)
                {
                    $info = filePermsDisplay($value["path"]);
                }
                echo "<p>  ".$value["name"]."   -   ".$info."</p>";
            }
            ?>
        </td>
    </tr>
</table>
</body>
<script type="text/javascript">
    var verifyCountSuccess = 0;
    var installUpdatePoll = null;
    var totalCounterInstall = 0;
    function saveAndVerifyMain(idForForm)
    {
        idForm = "#"+idForForm;
        data = $(idForm).serializeArray();
        $.ajax({
            type: "post",
            url: "core/php/settingsSaveAjax.php",
            data,
            success(data)
            {
                if(data !== "true")
                {
                    window.location.href = "../error.php?error="+data+"&page=core/php/settingsSaveAjax.php";
                }
            }
        });
    }

    function resetUpdateSettings()
    {
        document.getElementById("popup").style.display = "block";
        document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Resetting...</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'> Resetting Update Settings... Please wait... </div>";
        var urlForSend = "core/php/resetUpdateFilesToDefault.php?format=json";
        var data = {status: "" };
        $.ajax(
        {
            url: urlForSend,
            dataType: "json",
            data,
            type: "POST",
            complete(data)
            {
                verifyCountSuccess = 0;
                installUpdatePoll = setInterval(function(){verifyChange();},3000);
            }
        });
    }

    function verifyChange()
    {
        var urlForSend = "update/updateActionCheck.php?format=json";
        var data = {status: "" };
        $.ajax(
        {
            url: urlForSend,
            dataType: "json",
            data,
            type: "POST",
            success(data)
            {
                if(data == "finishedUpdate")
                {
                    verifyCountSuccess++;
                    if(verifyCountSuccess >= 4)
                    {
                        verifyCountSuccess = 0;
                        clearInterval(installUpdatePoll);
                        //success popup
                        document.getElementById("popup").style.display = "block";
                        document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Success</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'> Update settings successfully reset! </div>";
                    }
                }
                else
                {
                    verifyCountSuccess = 0;
                }
            },
            failure(data)
            {
                if(totalCounterInstall > 30)
                {
                    //error message
                    clearInterval(installUpdatePoll);
                    document.getElementById("popup").style.display = "block";
                    document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An Error occured when trying to reset update progress</div>";
                }
            },
            complete(data)
            {
                totalCounterInstall++;
            }
        });
    }
</script>
</html>
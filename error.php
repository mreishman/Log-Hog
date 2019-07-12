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

$coreLoaded = false;
$file = "core/php/class/core.php";
if(file_exists($file))
{
    try {
        require_once($file);
        $coreLoaded = true;
    } catch (Exception $e) {

    }
    if($coreLoaded)
    {
        $core = new core();
    }
}

$fileNameArray = array(
    "Error"    =>  array(
        "name"      =>  "Could not load list of files",
        "path"      =>  ""
    )
);
$file = 'core/json/listOfFiles.json';
if(file_exists($file))
{
    if(is_readable($file))
    {
        try
        {
            $jsonFiles = file_get_contents("core/json/listOfFiles.json");
            $fileNameArray = json_decode($jsonFiles, true);
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
    15   =>  array(
        "firstMessage"      =>  "Could not load JS file when trying to initialize Log-Hog",
        "secondMessage"     =>  "Please make sure your are connected to the server, and the javascript file is present"
    ),
    16   =>  array(
        "firstMessage"      =>  "Update check failed because the downloaded zip file was empty, or the file(s) could not be copied over",
        "secondMessage"     =>  "When checking for updates, a zip file is download that contains the new version list. An error occured when trying to copy files from the zip file. This could either be due to a permission error or not enough space in the target directory."
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
    <script src="core/js/jquery.js?v=<?php echo rand(5, 15); ?>"></script>
    <link rel="stylesheet" type="text/css" href="core/template/error.css?v=<?php echo rand(5, 15); ?>">
    <script type="text/javascript" src="core/js/error.js?v=<?php echo rand(5, 15); ?>" ></script>
    <?php if($jsForResetToDefaultLoaded): ?>
        <script type="text/javascript" src="core/js/resetSettingsJs.js?v=<?php echo rand(5, 15); ?>" ></script>
    <?php endif;?>
</head>
<body>

<?php if($error != 0): ?>
    <div class="errorMessage" >
        <table>
            <tr>
                <td rowspan="2"><img class="warningImage" src="core/img/redWarning.png" height="120px"></td>
                <td><h1>Error <?php echo $error ?></h1></td>
                <td rowspan="2"><img class="warningImage" src="core/img/redWarning.png" height="120px"></td>
            </tr>
            <tr>
                <td><h3><?php echo $page ?></h3></td>
            </tr>
        </table>
    </div>
<?php endif; ?>
<table>
    <tr class="tableRow">
        <td width="33%">
            <h3> More Info: </h3>
            <h2><?php echo $errorArray[$error]["firstMessage"]; ?></h2>
            <?php echo $errorArray[$error]["secondMessage"]; ?>
            <h2> Version: </h2>
            <?php echo $version; ?>
            <h2> PHP Version: </h2>
            <?php echo phpversion(); ?>
            <br>
            <br>
            <?php
                try
                {
                    $currentSelectedTheme = "default";
                    if(is_file("local/layout.php"))
                    {
                        @include("local/layout.php");
                    }
                    $config = array();
                    if(is_file("local/".$currentSelectedTheme."/conf/config.php"))
                    {
                        @include("local/".$currentSelectedTheme."/conf/config.php");
                    }
                    $arrayOfModules = array(
                        0                                   =>  array(
                            "key"                               =>  "developmentTabEnabled",
                            "name"                              =>  "Development Tools",
                        ),
                        1                                   =>  array(
                            "key"                               =>  "themesEnabled",
                            "name"                              =>  "Themes",
                        ),
                        2                                   =>  array(
                            "key"                               =>  "enableMultiLog",
                            "name"                              =>  "Multi-Log",
                        ),
                        3                                   =>  array(
                            "key"                               =>  "enableHistory",
                            "name"                              =>  "History",
                        ),
                        4                                   =>  array(
                            "key"                               =>  "oneLogEnable",
                            "name"                              =>  "One Log",
                        ),
                        5                                   =>  array(
                            "key"                               =>  "filterEnabled",
                            "name"                              =>  "Filters",
                        ),
                        6                                   =>  array(
                            "key"                               =>  "rightClickMenuEnable",
                            "name"                              =>  "Right Click Menu",
                        ),
                        7                                   =>  array(
                            "key"                               =>  "advancedLogFormatEnabled",
                            "name"                              =>  "Advanced Log Format Options",
                        ),
                        8                                   =>  array(
                            "key"                               =>  "backupNumConfigEnabled",
                            "name"                              =>  "Config Backup",
                        )
                    );
                    echo "<h3>Modules:</h3><table>";
                    foreach ($arrayOfModules as $value)
                    {
                        $enabled = "Enabled?";
                        if(!empty($config))
                        {
                            $enabled = "Enabled";
                            if(isset($config[$value["key"]]) && $config[$value["key"]] !== "true")
                            {
                                $enabled = "Disabled";
                            }
                        }
                        echo "<tr><td> ".$value["name"]." </td><td> ".$enabled."</td>";
                    }
                    echo "</table>";
                }
                catch (Exception $e)
                {
                    echo "Could not load module status";
                }
            ?>
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
                    <div id="popup">
                        <div id="popupContentInnerHTMLDiv">
                        </div>
                    </div>
                </li>
            </ul>
        </td>
        <td width="33%">
            <h3> File Permissions: </h3>
            <table>
            <?php
            foreach ($fileNameArray as $key => $value)
            {
                $info = "";
                if($coreLoaded)
                {
                    $info = $core->filePermsDisplay($value["path"]);
                }
                echo "<tr><td>".$value["name"]."</td><td>".$info."</td></tr><tr><td colspan=\"2\">".$value["path"]."</td></tr>";
            }
            ?>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
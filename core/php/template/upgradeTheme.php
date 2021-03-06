<!doctype html>
<?php
require_once("../../../core/php/class/core.php");
$core = new core();
require_once("../../../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("", "", 14);
}
$baseUrl = "../../../local/";
$currentSelectedTheme = $session->returnCurrentSelectedTheme();
$baseUrl .= $currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../../core/conf/config.php');
require_once('../../../local/conf/globalConfig.php');
require_once('../../../core/conf/globalConfig.php');
require_once('../../../core/php/configStatic.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../../../local/Themes/'.$currentTheme))
{
	require_once('../../../local/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../../../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../../../core/php/loadVars.php');
$baseFileVersion = $defaultConfig["themeVersion"];
$oldFileVersion = $config["themeVersion"];
$forceThemeUpdate = false;
if(isset($_GET["forceThemeUpdate"]))
{
	$forceThemeUpdate = true;
}
if((strval($baseFileVersion) === strval($oldFileVersion)) && (file_exists("../../../local/".$currentSelectedTheme."/img/info.png")) && !$forceThemeUpdate)
{
	header("Location: "."../../../settings/whatsNew.php", true, 302); /* Redirect browser */
	exit();
}
?>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="../../../core/template/base.css">
	<link rel="stylesheet" type="text/css" href="../../../core/template/theme.css">
	<link rel="stylesheet" type="text/css" href="../../../core/template/upgrade.css">
	<?php require_once("../../../core/php/customCSS.php"); ?>
	<link rel="icon" type="image/png" href="../../../core/img/favicon.png" />
	<?php $core->getScript(array(
		"filePath"		=> "../../../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>
	<div id="upgradeStatusPopup">
		<div class="settingsHeader" style="text-align: center;" >
			<span id="titleHeader" >
				<h1>Copying over Theme files to local/<?php echo $currentSelectedTheme; ?>/theme...</h1>
			</span>
		</div>
		<div class="settingsDiv" >
			<div class="updatingDiv">
				<div id="innerDisplayUpdate">
					<table style="padding: 10px; height: 100%;">
						<tr>
							<td style="height: 50px;">
								<?php echo $core->generateImage(
									$arrayOfImages["loading"],
									array(
										"height"		=>	"30px",
										"srcModifier"	=>	"../../../",
										"id"			=>	"runLoad"
									)
								); ?>
								<?php echo $core->generateImage(
									$arrayOfImages["greenCheck"],
									array(
										"height"		=>	"30px",
										"srcModifier"	=>	"../../../",
										"id"			=>	"runCheck",
										"style"			=>	"display: none;"
									)
								); ?>
							</td>
							<td style="width: 20px;">
							</td>
							<td>
								Copying Images / CSS
							</td>
						</tr>
						<tr>
							<td style="height: 50px;">
								<?php echo $core->generateImage(
									$arrayOfImages["loading"],
									array(
										"height"		=>	"30px",
										"srcModifier"	=>	"../../../",
										"id"			=>	"verifyLoad",
										"style"			=>	"display: none;"
									)
								); ?>
								<?php echo $core->generateImage(
									$arrayOfImages["greenCheck"],
									array(
										"height"		=>	"30px",
										"srcModifier"	=>	"../../../",
										"id"			=>	"verifyCheck",
										"style"			=>	"display: none;"
									)
								); ?>
							</td>
							<td style="width: 20px;">
							</td>
							<td>
								Verifying Copied files
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
<?php $core->getScripts(array(
		array(
			"filePath"		=> "../../../core/js/settings.js",
			"baseFilePath"	=> "core/js/settings.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "../../../core/js/upgradeTheme.js",
			"baseFilePath"	=> "core/js/upgradeTheme.js",
			"default"		=> $configStatic["version"]
		)
	)
); ?>
<script type="text/javascript">
	var themeChangeLogicDirModifier = "../";
	var themeErrorLogicDirModifier = "../../";
	$( document ).ready(function()
	{
		$("body").height(""+window.innerHeight+"px");
		copyFilesThemeChange();
	});
	$( window ).resize(function() {
		$("body").height(""+window.innerHeight+"px");
	});

	function redirectToLocationFromUpgradeTheme()
	{
		window.location.href = "<?php echo $core->getCookieRedirect(); ?>";
	}
</script>
</html>

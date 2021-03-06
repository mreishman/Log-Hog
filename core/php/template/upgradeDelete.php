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
require_once($baseUrl."conf/config.php");
require_once("../../../core/conf/config.php");
require_once('../../../local/conf/globalConfig.php');
require_once('../../../core/conf/globalConfig.php');
require_once("../../../core/php/configStatic.php");
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir("../../../local/Themes/".$currentTheme))
{
	require_once("../../../local/Themes/".$currentTheme."/defaultSetting.php");
}
else
{
	require_once("../../../core/Themes/".$currentTheme."/defaultSetting.php");
}
require_once("../../../core/php/loadVars.php");
$jsonFiles = file_get_contents("../../../core/json/staticDeletedFiles.json");
$arrayOfFilesDeleted = json_decode($jsonFiles, true);
$arrayOfFilesToDelete = array();
foreach ($arrayOfFilesDeleted as $value)
{
	if(is_file("../../../".$value["fullPath"]))
	{
		array_push($arrayOfFilesToDelete, $value);
	}
}
$totalCountOfFilesToDelete = count($arrayOfFilesToDelete);
if($totalCountOfFilesToDelete < 1)
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
			<h1>Removing old Log-Hog files...</h1>
			<p>This may take a few min</p>
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
							Removing File <span id="runCount">1</span> of <?php echo $totalCountOfFilesToDelete;?>
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
							Verifying <span id="verifyCount">1</span> of <?php echo $totalCountOfFilesToDelete;?>
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
			"filePath"		=> "../../../core/js/upgradeDelete.js",
			"baseFilePath"	=> "core/js/upgradeDelete.js",
			"default"		=> $configStatic["version"]
		)
	)
); ?>
<script type="text/javascript">
	var arrayOfFilesToDelete = <?php echo json_encode($arrayOfFilesToDelete); ?>;
	var totalCountOfFilesToDelete = <?php echo $totalCountOfFilesToDelete; ?>;
	$( document ).ready(function()
	{
		$("body").height(""+window.innerHeight+"px");
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

<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="../../../core/template/theme.css">
	<link rel="icon" type="image/png" href="../../../core/img/favicon.png" />
	<script src="../../../core/js/jquery.js"></script>
</head>
<body>
<?php
$baseUrl = "../../../core/";
if(file_exists('../../../local/layout.php'))
{
	$baseUrl = "../../../local/";
	//there is custom information, use this
	require_once('../../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('../../../core/php/commonFunctions.php');
require_once('../../../core/conf/config.php');
require_once('../../../core/php/configStatic.php');
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme", "jsVersion");
if(is_dir('../../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../../../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../../../core/php/loadVars.php');
require_once('../../../core/php/staticDeletedFiles.php');
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
	//header("Location: "."../../../settings/whatsNew.php", true, 302); /* Redirect browser */
	//exit();
}
?>

<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<span id="titleHeader" >
			<h1>Removing old Log-Hog files...</h1>
			<p>This may take a few min</p>
		</span>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 350px; overflow: auto; max-height: 300px;">
				<table style="padding: 10px;">
					<tr>
						<td style="height: 50px;">
							<?php echo generateImage(
								$arrayOfImages["loading"],
								array(
									"height"		=>	"30px",
									"srcModifier"	=>	"../../../",
									"id"			=>	"runLoad"
								)
							); ?>
							<?php echo generateImage(
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
							<?php echo generateImage(
								$arrayOfImages["loading"],
								array(
									"height"		=>	"30px",
									"srcModifier"	=>	"../../../",
									"id"			=>	"verifyLoad",
									"style"			=>	"display: none;"
								)
							); ?>
							<?php echo generateImage(
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
			<p style="border-bottom: 1px solid white;"></p>
		</div>
	</div>
</div>
</body>

<script src="../../../core/js/settings.js?v=<?php echo $jsVersion?>"></script>
<script src="../../../core/js/upgradeDelete.js?v=<?php echo $jsVersion?>"></script>
<script type="text/javascript">
	var themeChangeLogicDirModifier = "../";
	var arrayOfFilesToDelete = <?php echo json_encode($arrayOfFilesToDelete); ?>;
	$( document ).ready(function()
	{
		//copyFilesThemeChange();
	});

	function redirectToLocationFromUpgradeTheme()
	{
		window.location.href = "<?php echo getCookieRedirect(); ?>";
	}
</script>
</html>

<?php
require_once('../core/php/commonFunctions.php');
require_once("../core/php/class/core.php");
$core = new core();
$currentSelectedTheme = $core->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/updateProgressFile.php');
require_once('../core/php/settingsInstallUpdate.php');
$redirectUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($redirectUrl, "updater.php") > -1)
{
	$redirectUrl = str_replace("updater.php", "whatsNew.php", $redirectUrl);
}
if(strpos($redirectUrl, "update") > -1)
{
	$redirectUrl = str_replace("update", "settings", $redirectUrl);
}
$core->setCookieRedirect($redirectUrl);
$noUpdateNeeded = true;
$versionToUpdate = "";

$versionToUpdateFirst = "";
$levelToUpdateFirst = 0;
$arrayOfVersions = array();

//find next version to update to
if($configStatic['newestVersion'] != $configStatic['version'])
{
	$noUpdateNeeded = false;
	foreach ($configStatic['versionList'] as $key => $value)
	{
		$version = explode('.', $configStatic['version']);
		$newestVersion = explode('.', $key);

		$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update

		$newestVersionCount = count($newestVersion);
		$versionCount = count($version);

		for($i = 0; $i < $newestVersionCount; $i++)
		{
			if($i < $versionCount)
			{
				$compareTo = intval($newestVersion[$i]);
				$compareFrom = intval($version[$i]);
				if($i == 0)
				{
					if($compareTo > $compareFrom)
					{
						$levelOfUpdate = 3;
						$versionToUpdate = $key;
						break;
					}
					elseif($compareTo < $compareFrom)
					{
						break;
					}
				}
				elseif($i == 1)
				{
					if($compareTo > $compareFrom)
					{
						$levelOfUpdate = 2;
						$versionToUpdate = $key;
						break;
					}
					elseif($compareTo < $compareFrom)
					{
						break;
					}
				}
				else
				{
					if($compareTo > $compareFrom)
					{
						$levelOfUpdate = 1;
						$versionToUpdate = $key;
						break;
					}
					elseif($compareTo < $compareFrom)
					{
						break;
					}
				}
			}
			else
			{
				$levelOfUpdate = 1;
				$versionToUpdate = $key;
				break;
			}
		}

		if($levelOfUpdate != 0)
		{
			if(empty($arrayOfVersions))
			{
				$versionToUpdateFirst = $versionToUpdate;
				$levelToUpdateFirst = $levelOfUpdate;
			}
			array_push($arrayOfVersions, $versionToUpdate);
		}

	}
}

$versionToUpdate = $versionToUpdateFirst;
$levelOfUpdate = $levelToUpdateFirst;

if($levelOfUpdate == 0)
{
	$noUpdateNeeded = true;
}

$updateStatus = $updateProgress['currentStep'];

if($updateProgress['currentStep'] == "Finished Updating to ")
{
	//just starting update, switch to download
	$updateStatus = "Downloading Zip Files For ";
	$updateAction = "downloadFile";
}

require_once('../core/php/updateProgressFileNext.php');
$newestVersionCheck = '"'.$configStatic['newestVersion'].'"';
$versionCheck = '"'.$configStatic['version'].'"';
$cssVersion = date("YmdHis");
$update = true;
if(count($arrayOfVersions) === 0)
{
	$update = false;
}
?>

<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<?php echo $core->loadCSS("../",$baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<?php getScript(array(
		"filePath"		=> "../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
</head>
<body>
	<div id="main">
		<div class="settingsHeader" style="text-align: center; padding: 5px 1px 1px 1px;" >
			<span id="titleHeader" >
			<?php if($update):?>
				<?php if ($configStatic['newestVersion'] == $versionToUpdate): ?>
					<h1>Updating to version <?php echo $versionToUpdate ; ?></h1>
				<?php else: ?>
					<h1>Installing Update <span id="countOfVersions" >1</span> of <?php echo count($arrayOfVersions); ?> ... Updating to version <span id="currentUpdatTo" ><?php echo $versionToUpdate ?></span>/<?php echo $configStatic['newestVersion'];?></h1>
				<?php endif; ?>
			<?php else: ?>
				<h1>There are no updates</h1>
				<script type="text/javascript">
					setTimeout(function(){ window.location.href = "../settings/whatsNew.php"; }, 3000);
				</script>
			<?php endif; ?>
			</span>
			<div id="menu" style="margin-right: auto; margin-left: auto; position: relative; display: none;">
				<h2 style="color: white;">If this page doesn't redirect within 10 seconds... click here:</h2>
				<br>
				<a onclick="window.location.href = '../index.php'">Back to Log-Hog</a>
			</div>
		</div>
		<div class="settingsDiv" style="border: 1px solid transparent; margin-bottom: 0;" >
			<div class="updatingDiv">
				<progress id="progressBar" value="0" max="100" style="width: 95%; margin-top: 10px; margin-bottom: 10px; margin-left: 2.5%; -webkit-appearance: none; appearance: none;" ></progress>
				<p style="border-bottom: 1px dashed #777;"></p>
				<table style="width: 100%;">
					<tr>
						<td>
							<div id="innerDisplayUpdate" style="height: 300px; overflow: auto; max-height: 300px;"></div>
						</td>
						<td width="310px;">
							<div id="innerDisplayPicture" style="height: 300px; width: 300px; max-height: 300px; max-width: 300px; overflow: hidden;" ></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="settingsHeader" style="margin-top: 0;">Log Info</div>
		<div id="innerSettingsText" class="settingsDiv" style="height: 75px; overflow-y: scroll;" ></div>
	</div>
</body>
<?php getScripts(
	array(
		array(
			"filePath"		=> "../core/js/settings.js",
			"baseFilePath"	=> "core/js/settings.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "../core/js/settingsExt.js",
			"baseFilePath"	=> "core/js/settingsExt.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "updater.js",
			"baseFilePath"	=> "update/updater.js",
			"default"		=> $configStatic["version"]
		)
	)
); ?>
<script type="text/javascript">
	var updateStatus = '<?php echo $updateStatus; ?>'
	var versionToUpdateTo = "<?php echo $versionToUpdate; ?>";
	var settingsForBranchStuff = JSON.parse('<?php echo json_encode($configStatic);?>');
	var arrayOfVersions = JSON.parse('<?php echo json_encode($arrayOfVersions);?>');
	<?php echo "var arrayOfVersionsCount = ".count($arrayOfVersions).";";?>
	var update = "<?php echo $update;?>";

	$( document ).ready(function()
	{
		total = 100*arrayOfVersionsCount;
		if(update === "1")
		{
			downloadBranch();
		}
		else
		{
			updateText("No update is currently available for Log-Hog.");
			document.getElementById('menu').style.display = "block";
		}
	});
</script>

</html>
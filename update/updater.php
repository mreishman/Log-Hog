<?php
require_once("../core/php/class/core.php");
$core = new core();
require_once("../core/php/class/session.php");
$session = new session();
if(!$session->startSession())
{
	$core->echoErrorJavaScript("../", "", 17);
}
$currentSelectedTheme = $core->returnCurrentSelectedTheme();
$baseUrl = "../local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/updateProgressFile.php');
require_once('../core/php/class/settingsInstallUpdate.php');
$settingsInstallUpdate = new settingsInstallUpdate();
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
	<?php $core->getScript(array(
		"filePath"		=> "../core/js/jquery.js",
		"baseFilePath"	=> "core/js/jquery.js",
		"default"		=> $configStatic["version"]
	)); ?>
	<style type="text/css">
		#menu {
			padding: 0;
		}
	</style>
</head>
<body>
	<div id="main">
		<div class="settingsHeader" style="padding: 5px 1px 1px 1px;" >
			<table width="100%">
				<tr>
					<td>
						<img width="100%" src="../core/img/favicon.png">
					</td>
					<td style="padding-left: 20px;">
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
						<progress id="progressBar" value="0" max="100" style="width: 95%; margin-top: 10px; margin-bottom: 10px; -webkit-appearance: none; appearance: none;" ></progress>
						<div id="menu" style="margin-right: auto; margin-left: auto; position: relative; display: none;">
							<h2 style="color: white; display: inline-block;">If this page doesn't redirect within 10 seconds... click here:</h2>
							<a onclick="window.location.href = '../index.php'">Back to Log-Hog</a>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="settingsHeader" style="margin-top: 0;">Change Log</div>
		<div class="settingsDiv" style="margin-bottom: 0;" >
			<div class="updatingDiv">
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
		<div class="settingsHeader" style="margin-top: 0;">Update Log</div>
		<div id="innerSettingsText" class="settingsDiv" style="height: 100px; overflow-y: scroll;" ></div>
	</div>
</body>
<?php $core->getScripts(
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
	<?php echo "var formKey = \"".$session->outputKey()."\";"; ?>
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
			pickNextAction();
		}
		else
		{
			updateText("No update is currently available for Log-Hog.");
			document.getElementById('menu').style.display = "block";
		}
	});
</script>

</html>
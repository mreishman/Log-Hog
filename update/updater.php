<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/updateProgressFile.php');
require_once('../core/php/settingsInstallUpdate.php'); 

$noUpdateNeeded = true;
$versionToUpdate = "";

//find next version to update to
if($configStatic['newestVersion'] != $configStatic['version'])
{
	$noUpdateNeeded = false;
	foreach ($configStatic['versionList'] as $key => $value) {
		

		$version = explode('.', $configStatic['version']);
		$newestVersion = explode('.', $key);

		$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update

		$newestVersionCount = count($newestVersion);
		$versionCount = count($version);

		for($i = 0; $i < $newestVersionCount; $i++)
		{
			if($i < $versionCount)
			{
				if($i == 0)
				{
					if($newestVersion[$i] > $version[$i])
					{
						$levelOfUpdate = 3;
						$versionToUpdate = $key;
						break;
					}
					elseif($newestVersion[$i] < $version[$i])
					{
						break;
					}
				}
				elseif($i == 1)
				{
					if($newestVersion[$i] > $version[$i])
					{
						$levelOfUpdate = 2;
						$versionToUpdate = $key;
						break;
					}
					elseif($newestVersion[$i] < $version[$i])
					{
						break;
					}
				}
				else
				{
					if($newestVersion[$i] > $version[$i])
					{
						$levelOfUpdate = 1;
						$versionToUpdate = $key;
						break;
					}
					elseif($newestVersion[$i] < $version[$i])
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
			break;
		}

	}
}


?>



<?php if(!$noUpdateNeeded)
{

	$updateStatus = "";
	$updateAction = "";
	$requiredVars = "";

	//determin what step you're on
	if($updateProgress['currentStep'] == "Finished Updating to ")
	{
		//just starting update, switch to download
		$updateStatus = "Downloading Zip Files For ";
		$updateAction = "downloadFile";
		$requiredVars = $versionToUpdate;
	}
	elseif($updateProgress['currentStep'] == "Downloading Zip Files For ")
	{
		//just downloaded update, switch to unzipping
		$updateStatus = "Extracting Zip Files For ";
		$updateAction = "unzipFile";
	}
	elseif($updateProgress['currentStep'] == "Extracting Zip Files For ")
	{
		//just finished extracting, switch to removing zip file
		$updateStatus = "";
		$updateAction = "";
	}
	else
	{
		//other?
	}


	updateProgressFile($updateStatus, "../core/php/", "updateProgressFileNext.php", $updateAction);
	updateProgressFile($updateStatus, "../core/php/", "updateProgressFile.php", $updateAction);
}
require_once('../core/php/updateProgressFileNext.php');
?>




<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
</body>

<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
	<?php if($noUpdateNeeded): ?>
		<h1>Finished Updating!</h1>
	<?php else: ?>
		<h1>Updating to version <?php echo $configStatic['newestVersion'] ; ?></h1>
	<?php endif; ?>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<?php require_once('../core/php/updateProgressLogHead.php'); ?>
			<p style="border-bottom: 1px solid white;"></p>
			<?php require_once('../core/php/updateProgressLog.php'); ?>
		</div>
	</div>
</div>
<form id="formForAction" method="post" action="../core/php/updateActionFile.php" style="display: none;">
	<input type="text" name="actionVar" value="<?php echo $updateAction ;?>">
	<input type="text" name="requiredVars" value="<?php echo $requiredVars ;?>">
</form>
<script src="../core/js/settings.js"></script>
<?php if(!$noUpdateNeeded): ?>
	<script type="text/javascript"> 
		var headerForUpdate = document.getElementById('headerForUpdate');
		setInterval(function() {headerForUpdate.innerHTML = headerForUpdate.innerHTML + ' .';}, '100');
		document.getElementById("formForAction").submit();
	</script> 
<?php endif; ?>


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

if($levelOfUpdate == 0)
{
	$noUpdateNeeded = true;
}

if(!$noUpdateNeeded)
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
		$updateStatus = "Running Update Script For ";
		$updateAction = "handOffToUpdate";
	}
	elseif($updateProgress['currentStep'] == "Finished Running Update Script")
	{
		//just finished runing update script, remove files 
		$updateStatus = "Removing Extracted Files";
		$updateAction = "removeUnZippedFiles";
	}
	elseif($updateProgress['currentStep'] == "Removing Extracted Files")
	{
		//just finished runing update script, remove files 
		$updateStatus = "Removing Zip File";
		$updateAction = "removeZipFile";
	}
	elseif($updateProgress['currentStep'] == "Removing Zip File")
	{
		//just finished runing update script, remove files 
		$updateStatus = "Finished Updating to ";
		$updateAction = "finishedUpdate";
		//change version in configStatic to updated version number

		$arrayForVersionList = "";
		$countOfArray = count($configStatic['versionList']);
		$i = 0;
		foreach ($configStatic['versionList'] as $key => $value) {
		  $i++;
		  $arrayForVersionList .= "'".$key."' => array(";
		  $countOfArraySub = count($value);
		  $j = 0;
		  foreach ($value as $keySub => $valueSub) 
		  {
		    $j++;
		    $arrayForVersionList .= "'".$keySub."' => '".$valueSub."'";
		    if($j != $countOfArraySub)
		    {
		      $arrayForVersionList .= ",";
		    }
		  }
		  $arrayForVersionList .= ")";
		  if($i != $countOfArray)
		  {
		    $arrayForVersionList .= ",";
		  }
		}

		$newInfoForConfig = "
		<?php

		$"."configStatic = array(
		  'version'   => '".$versionToUpdate."',
		  'lastCheck'   => '".date('m-d-Y')."',
		  'newestVersion' => '".$configStatic['newestVersion']."',
		  'versionList' => array(
		  ".$arrayForVersionList."
		  )
		);
		";

		file_put_contents("../core/php/configStatic.php", $newInfoForConfig);

	}
	else
	{
		//anything else will be passed to update script 
		$updateStatus = "Running Update Script For ";
		$updateAction = "handOffToUpdate";
	}
}
require_once('../core/php/updateProgressFileNext.php');
$newestVersionCheck = '"'.$configStatic['newestVersion'].'"';
$versionCheck = '"'.$configStatic['version'].'"';
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
		<h1>Updating to version <?php echo $configStatic['newestVersion'] ; ?></h1>
		<div id="menu" style="margin-right: auto; margin-left: auto; position: relative; display: none;">
			<a onclick="window.location.href = '../settings/update.php'">Back to Log-Hog</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<progress value="0" max="100" style="width: 95%; margin-top: 10px; margin-bottom: 10px; margin-left: 2.5%;" ></progress>
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 300px;">

			</div>
			<p style="border-bottom: 1px solid white;"></p>
			<div class="settingsHeader">
			Log Info
			</div>
			<div id="innerSettingsText" class="settingsDiv" style="height: 75px; overflow-y: scroll;" >
				<?php require_once('../core/php/updateProgressLog.php'); ?>
			</div>
		</div>
	</div>
</div>

<script src="../core/js/settings.js"></script>
<script type="text/javascript"> 
	var updateStatus = '<?php echo $updateStatus; ?>'
	var headerForUpdate = document.getElementById('headerForUpdate');
	var urlForSendMain = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var retryCount = 0;
	var verifyFileTimer;
	var versionToUpdateTo = "<?php echo $versionToUpdate; ?>";


	function updateText(text)
	{
		document.getElementById('innerSettingsText').innerHTML = "<p>"+text+"</p>"+document.getElementById('innerSettingsText').innerHTML;
	}

	function pickNextAction()
	{
		if(updateStatus == "Downloading Zip Files For ")
		{
			downloadBranch();
		}
		else if(updateStatus == "Extracting Zip Files For ")
		{
			//already downloaded, verify download then extract
		}
		else if(updateStatus == "Removing Extracted Files")
		{
			//remove extracted files
		}
		else if(updateStatus == "Removing Zip File")
		{
			//remove zip
		}
	}

	//timer = setInterval(function(){ajaxCheck();},3000);

	function updateStatus()
	{
		//updateProgressFile($updateStatus, "../core/php/", "updateProgressFileNext.php", $updateAction);
		//updateProgressFile($updateStatus, "../core/php/", "updateProgressFile.php", $updateAction);
	}

	function ajaxCheck()
	{
		var urlForSend = './updateCheck.php?format=json'
		var data = {status: updateStatus };
		$.ajax(
		{
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			success: function(data)
			{
				if(data == updateStatus)
				{
					clearInterval(timer);
					//saved, move on to next action
				}
		  	},
		});
	}

	function downloadBranch()
	{
		if(retryCount == 0)
		{
			updateText("Downloading Update");
		}
		else
		{
			updateText("Attempt "+(retryCount+1)+" of 3 for downloading Update");
		}
		var urlForSend = urlForSendMain;
		var data = {action: 'downloadFile', file: versionToUpdateTo,downloadFrom: 'Log-Hog/archive/', downloadTo: '../../update/downloads/updateFiles/updateFiles.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				updateText("Verifying Download");
				verifyFile('downloadMonitor', '../../updateFiles.zip');
			}
		});	

	}

	function unzipBranch()
	{
		//this builds array of file to copy (check if top is insalled for files copy)
	}

	function verifyFile(action, fileLocation,isThere = true)
	{
		verifyCount = 0;
		updateText('Verifying '+action+' with'+fileLocation);
		verifyFileTimer = setInterval(function(){verifyFilePoll(action,fileLocation,isThere);},6000);
	}

	function verifyFilePoll(action, fileLocation,isThere)
	{
		if(lock == false)
		{
			lock = true;
			updateText('verifying '+(verifyCount+1)+' of 10');
			var urlForSend = urlForSendMain;
			var data = {action: 'verifyFileIsThere', fileLocation: fileLocation, isThere: isThere , lastAction: action};
			(function(_data){
				$.ajax({
					url: urlForSend,
					dataType: 'json',
					data: data,
					type: 'POST',
					success: function(data)
					{
						verifyPostEnd(data, _data);
					},
					failure: function(data)
					{
						verifyPostEnd(data, _data);
					},
					complete: function()
					{
						lock = false;
					}
				});	
			}(data));
		}
	}

	function verifyPostEnd(verified, data)
	{
		if(verified == true)
		{
			clearInterval(verifyFileTimer);
			verifySucceded(data['lastAction']);
		}
		else
		{
			verifyCount++;
			if(verifyCount > 9)
			{
				clearInterval(verifyFileTimer);
				verifyFail(data['lastAction']);
			}
		}
	}

	function updateError()
	{
		clearInterval(dotsTimer);
		document.getElementById('innerSettingsText').innerHTML = "<p>An error occured while trying to download Monitor. </p>";
	}

	function preScripRun()
	{

	}

	function copyFileFromArray()
	{

	}

	function postScriptRun()
	{

	}

	function removeExtractedDir()
	{

	}

	function removeDownloadedZip()
	{

	}
	
</script> 

<?php 
if($newestVersionCheck == $versionCheck)
{
	file_put_contents("../core/php/updateProgressLog.php", "<p> Loading update file list. </p>");
}
?>


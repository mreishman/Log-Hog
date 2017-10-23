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
require_once('../core/php/commonFunctions.php');

$noUpdateNeeded = true;
$versionToUpdate = "";

$versionToUpdateFirst = "";
$levelToUpdateFirst = 0;
$arrayOfVersions = array();

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
$cssVersion = rand(1, 999999);
$update = true;
if(count($arrayOfVersions) === 0)
{
	$update = false;
}
?>

<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>


<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<span id="titleHeader" >
		<?php if($update):?>
			<?php if ($configStatic['newestVersion'] == $versionToUpdate): ?>
				<h1>Updating to version <?php echo $versionToUpdate ; ?></h1>
			<?php else: ?>
				<h1>Installing Update <span id="countOfVersions" >1</span> of <?php echo count($arrayOfVersions); ?> ... Updating to version <span id="currentUpdatTo" ><?php echo $versionToUpdate ?></span>/<?php echo $configStatic['newestVersion'];?></h1>
			<?php endif; ?>
		<?php else: ?>
			<h1>There are no updates</h1>
		<?php endif; ?>
		</span>
		<div id="menu" style="margin-right: auto; margin-left: auto; position: relative; display: none;">
			<h2 style="color: white;">If this page doesn't redirect within 10 seconds... click here:</h2>
			<br>
			<a onclick="window.location.href = '../settings/update.php'">Back to Log-Hog</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<progress id="progressBar" value="0" max="100" style="width: 95%; margin-top: 10px; margin-bottom: 10px; margin-left: 2.5%; -webkit-appearance: none; appearance: none;" ></progress>
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 300px; overflow: auto; max-height: 300px;">

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
</body>

<script src="../core/js/settings.js?v=<?php echo $cssVersion?>"></script>
<script type="text/javascript"> 
	var updateStatus = '<?php echo $updateStatus; ?>'
	var headerForUpdate = document.getElementById('headerForUpdate');
	var urlForSendMain = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var retryCount = 0;
	var verifyFileTimer;
	var versionToUpdateTo = "<?php echo $versionToUpdate; ?>";
	var percent = 0;
	var arrayOfFilesExtracted;
	var lock = false;
	var settingsForBranchStuff = JSON.parse('<?php echo json_encode($configStatic);?>');
	var filteredArray = new Array();
	var preScriptCount = 1;
	var postScriptCount = 1;
	var fileCopyCount = 0;
	var arrayOfVersions = JSON.parse('<?php echo json_encode($arrayOfVersions);?>');
	<?php echo "var arrayOfVersionsCount = ".count($arrayOfVersions).";";?>
	var total = 100*arrayOfVersionsCount;
	var versionCountCurrent = 1;
	var lastFileCheck = "";
	var update = "<?php echo $update;?>";

	$( document ).ready(function()
	{
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

	function updateProgressBar(additonalPercent)
	{
		percent = percent + additonalPercent;
		document.getElementById('progressBar').value = percent/total*100;
		if(percent/total*100 > 100)
		{
			document.getElementById('progressBar').value = ((percent/total*100)-100);
		}
	}


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
			document.getElementById('innerDisplayUpdate').innerHTML = settingsForBranchStuff['versionList'][versionToUpdateTo]['releaseNotes'];
			updateProgressBar(10);
			unzipBranch();
		}
		else if(updateStatus == 'preUpgrade Scripts')
		{
			document.getElementById('innerDisplayUpdate').innerHTML = settingsForBranchStuff['versionList'][versionToUpdateTo]['releaseNotes'];
			updateProgressBar(20);
			preScriptRun();
		}
		else if(updateStatus == 'Copying Files')
		{
			downloadBranch();
		}
		else if(updateStatus == 'postUpgrade Scripts')
		{
			document.getElementById('innerDisplayUpdate').innerHTML = settingsForBranchStuff['versionList'][versionToUpdateTo]['releaseNotes'];
			updateProgressBar(75);
			postScriptRun();
		}
		else if(updateStatus == "Removing Extracted Files")
		{
			//remove extracted files
			document.getElementById('innerDisplayUpdate').innerHTML = settingsForBranchStuff['versionList'][versionToUpdateTo]['releaseNotes'];
			updateProgressBar(80);
			removeExtractedDir();
		}
		else if(updateStatus == "Removing Zip File")
		{
			updateProgressBar(90);
			document.getElementById('innerDisplayUpdate').innerHTML = settingsForBranchStuff['versionList'][versionToUpdateTo]['releaseNotes'];
			//remove zip
			removeDownloadedZip();
		}
		else if(updateStatus == "finishedUpdate")
		{
			updateProgressBar(99);
			document.getElementById('innerDisplayUpdate').innerHTML = settingsForBranchStuff['versionList'][versionToUpdateTo]['releaseNotes'];
			finishedUpdate();
		}

	}

	function updateStatusFunc(updateStatusInner, actionLocal, percentToSave = (document.getElementById('progressBar').value))
	{
		var urlForSend = urlForSendMain;
		var data = {action: 'updateProgressFile', status: updateStatusInner, typeOfProgress: "updateProgressFileNext.php", actionSave: actionLocal, percent: percentToSave, pathToFile: ''};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				
			}
		});	

		var data = {action: 'updateProgressFile', status: updateStatusInner, typeOfProgress: "updateProgressFile.php", actionSave: actionLocal, percent: percentToSave, pathToFile: ''};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				
			}
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
		document.getElementById('innerDisplayUpdate').innerHTML = settingsForBranchStuff['versionList'][versionToUpdateTo]['releaseNotes'];
		var data = {action: 'downloadFile', file: settingsForBranchStuff['versionList'][versionToUpdateTo]['branchName'],downloadFrom: 'Log-Hog/archive/', downloadTo: '../../update/downloads/updateFiles/updateFiles.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				updateText("Verifying Download");
				verifyFile('downloadLogHog', '../../update/downloads/updateFiles/updateFiles.zip');
			}
		});	

	}

	function unzipBranch()
	{
		//this builds array of file to copy (check if top is insalled for files copy)

		if(retryCount == 0)
		{
			updateText("Unzipping Files");
		}
		else
		{
			updateText("Attempt "+(retryCount+1)+" of 3 for Unzipping Files");
		}
		var urlForSend = urlForSendMain;
		var dataSend = {action: 'unzipUpdateAndReturnArray'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: dataSend,
			type: 'POST',
			success: function(arrayOfFiles)
			{
				//verify if downloaded
				arrayOfFilesExtracted = arrayOfFiles;
				updateText("Verifying Unzipping");
				verifyFile('unzipUpdateAndReturnArray', '../../update/downloads/updateFiles/extracted/'+arrayOfFiles[0]);
			},
			failure: function(data)
			{
				retryCount++;
				unzipBranch();
			}
		});
	}

	function verifyFile(action, fileLocation,isThere = true)
	{
		verifyCount = 0;
		updateText('Verifying '+action+' with '+fileLocation);
		verifyFileTimer = setInterval(function(){verifyFilePoll(action,fileLocation,isThere);},2000);
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
		document.getElementById('innerSettingsText').innerHTML = "<p>An error occured while trying to update Log-Hog. </p>";
	}

	function verifyFail(action)
	{
		//failed? try again?
		retryCount++;
		if(retryCount >= 3)
		{
			//stop trying, give up :c
			updateError();
		}
		else
		{
			updateText("Could not verify action was executed");
			if(action == 'downloadLogHog')
			{
				downloadBranch();
			}
			else if(action == 'unzipUpdateAndReturnArray')
			{
				unzipUpdateAndReturnArray();
			}
			else if(action == 'removeDirUpdate')
			{
				removeExtractedDir();
			}
			else if(action == "removeZipFile")
			{
				removeDownloadedZip();
			}
			else if(action == "copyFilesFromArray")
			{
				fileCopyCount = 0;
				copyFilesFromArray();
			}
		}
	}

	function verifySucceded(action)
	{
		//downloaded, extract
		retryCount = 0;
		updateText("Verified Action");
		if(action == 'downloadLogHog')
		{
			updateProgressBar(10);
			updateStatusFunc("Extracting Zip Files For ", "");
			unzipBranch();
		}
		else if(action == 'unzipUpdateAndReturnArray')
		{
			updateProgressBar(9);
			updateStatusFunc("Copying Files", "");
			filterFilesFromArray();
		}
		else if(action == 'removeDirUpdate')
		{
			updateProgressBar(10);
			updateStatusFunc("Removing Extracted Files", "");
			removeDownloadedZip();
		}
		else if(action == 'removeZipFile')
		{
			updateProgressBar(9);
			updateStatusFunc("Removing Zip File", "");
			finishedUpdate();
		}
		else if(action == 'copyFilesFromArray')
		{
			postScriptRun();
			updateStatusFunc("postUpgrade Scripts", "");
		}
	}

	function verifyFileOrDir(action, fileLocation)
	{
		verifyCount = 0;
		updateText('Verifying '+action+' with '+fileLocation);
		verifyFileTimer = setInterval(function(){verifyFileOrDirPoll(action,fileLocation);},2000);
	}

	function verifyFileOrDirPoll(action, fileLocation,isThere)
	{
		if(lock == false)
		{
			lock = true;
			updateText('verifying '+(verifyCount+1)+' of 10');
			var urlForSend = urlForSendMain;
			var data = {action: 'verifyFileOrDirIsThere', locationOfDirOrFile: fileLocation, lastAction: action};
			(function(_data){
				$.ajax({
					url: urlForSend,
					dataType: 'json',
					data: data,
					type: 'POST',
					success: function(data)
					{
						verifyPostEndTwo(data, _data);
					},
					failure: function(data)
					{
						verifyPostEndTwo(data, _data);
					},
					complete: function()
					{
						lock = false;
					}
				});	
			}(data));
		}
	}

	function verifyPostEndTwo(verified, data)
	{
		if(verified == true)
		{
			clearInterval(verifyFileTimer);
			verifySuccededTwo(data['lastAction']);
		}
		else
		{
			verifyCount++;
			if(verifyCount > 9)
			{
				clearInterval(verifyFileTimer);
				verifyFailTwo(data['lastAction']);
			}
		}
	}

	function verifySuccededTwo(action)
	{
		retryCount = 0;
		updateText("Verified Action");
		if(action === "preScriptRun")
		{
			preScriptRun();
		}
		else
		{
			postScriptRun();
		}
	}

	function verifyFailTwo(action)
	{
		//failed? try again?
		retryCount++;
		if(retryCount >= 3)
		{
			//stop trying, give up :c
			updateError();
		}
		else
		{
			if(action === "preScriptRun")
			{
				preScriptCount--;
				preScriptRun();
			}
			else
			{
				postScriptCount--;
				postScriptRun();
			}
		}
	}

	function preScriptRun()
	{
		updateText("Checking for pre upgrade scripts");
		if(preScriptCount != 1)
		{
			var totalCount = 1;
			var fileName = "pre-script-"+totalCount+".php";
			var loop = ($.inArray(fileName,arrayOfFilesExtracted)!== -1);
			while(loop)
			{
				totalCount++;
				fileName = "pre-script-"+totalCount+".php";
				loop = ($.inArray(fileName,arrayOfFilesExtracted)!== -1);
			}
			updateProgressBar(((1/totalCount)*5));
		}
		var fileName = "pre-script-"+preScriptCount+".php";
		if($.inArray(fileName,arrayOfFilesExtracted) != "-1")
		{
			updateText("Running pre upgrade script "+preScriptCount);
			ajaxForPreScriptRun(fileName);
			preScriptCount++;
		}
		else
		{
			if(preScriptCount == 1)
			{
				updateText("No Pre Upgrade scripts.");
				updateProgressBar(5);
			}
			else
			{
				updateText("Finished running pre upgrade scripts");
			}
			preScriptCount = 1;
			//finished with pre scripts
			fileCopyCount = 0;
			copyFilesFromArray();
		}
	}

	function ajaxForPreScriptRun(urlForSendMain)
	{
		var urlForSend = "../update/downloads/updateFiles/extracted/"+urlForSendMain;
		var data = "";
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			success: function(data)
			{
				if(data !== true)
				{
					//verify data
					verifyFileOrDir("preScriptRun",data)
				}
				else
				{
					//no verify needed
					preScriptRun();
				}
			}
		});	
	}

	function filterFilesFromArray()
	{
		filteredArray = new Array();
		for (var i = arrayOfFilesExtracted.length - 1; i >= 0; i--) 
		{
			var file = arrayOfFilesExtracted[i];
			var copyFile = true;
			f(file.startsWith("pre-script-") || file.startsWith("post-script-") || file.startsWith("post-redirect-") || file.startsWith("exclude-this-file-from-copy-"))
			{
				copyFile = false;
			}

			if(copyFile)
			{
				filteredArray.push(file);
			}
		}
		updateProgressBar(1);
		preScriptRun();
	}

	function copyFilesFromArray()
	{
		if(fileCopyCount > 0)
		{
			updateProgressBar(((1/filteredArray.length)*50));
		}
		for (var i = filteredArray.length - 1; i >= 0; i--) 
		{
			if(i == fileCopyCount)
			{
				updateText("Copying File "+(i+1)+" of "+filteredArray.length);
				fileCopyCount++;
				copyFileFromArrayAjax(filteredArray[i]);
				break;
			}
		}
		if(fileCopyCount == filteredArray.length)
		{
			updateText("Finished copying files.");
			fileCopyCount++;
			verifyFile('copyFilesFromArray', lastFileCheck);
		}
	}

	function copyFileFromArrayAjax(file)
	{
		updateText("File: "+file);
		
		var urlForSend = urlForSendMain;
		var dataSend = {action: "copyFileToFile", fileCopyFrom: file};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: dataSend,
			type: 'POST',
			success(fileCopied)
			{
				lastFileCheck = fileCopied;
			},
			complete: function(data)
			{
				copyFilesFromArray();
			}
		});
	}

	function postScriptRun()
	{
		updateText("Checking for post upgrade scripts");
		if(postScriptCount != 1)
		{
			var totalCount = 1;
			var fileName = "post-script-"+totalCount+".php";
			var loop = ($.inArray(fileName,arrayOfFilesExtracted)!== -1);
			while(loop)
			{
				totalCount++;
				fileName = "post-script-"+totalCount+".php";
				loop = ($.inArray(fileName,arrayOfFilesExtracted)!== -1);
			}
			updateProgressBar(((1/totalCount)*5));
		}

		var fileName = "post-script-"+postScriptCount+".php";
		if($.inArray(fileName,arrayOfFilesExtracted) != "-1")
		{
			updateText("Running post upgrade script "+postScriptCount);
			postScriptCount++;
			ajaxForPostScriptRun(fileName);

		}
		else
		{
			if(postScriptCount == 1)
			{
				updateText("No post Upgrade scripts.");
				updateProgressBar(5);
			}
			else
			{
				updateText("Finished running post upgrade scripts");
			}
			postScriptCount = 1;
			//finished with post scripts
			postScriptRedirect();
		}
	}

	function ajaxForPostScriptRun(urlForSendMain)
	{
		var urlForSend = "../update/downloads/updateFiles/extracted/"+urlForSendMain;
		var data = "";
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			success: function(data)
			{
				if(data !== true)
				{
					//verify data
					verifyFileOrDir("postScriptRun",data)
				}
				else
				{
					//no verify needed
					postScriptRun();
				}
			}
		});	
	}

	function postScriptRedirect()
	{
		//check for file called post-redirect
		var fileName = "post-redirect-1.php";
		if($.inArray(fileName,arrayOfFilesExtracted) != "-1")
		{
			updateText("Redirecting to external upgrade script");
			ajaxForRedirectScript(fileName);
		}
		else
		{
			removeExtractedDir();
		}
	}

	function ajaxForRedirectScript(urlForSendMain)
	{
		var urlForSend = "../update/downloads/updateFiles/extracted/"+urlForSendMain;
		var data = {};
		(function(_data){
			$.ajax({
				url: urlForSend,
				dataType: 'json',
				data: data,
				type: 'POST',
				success: function(data)
				{
					window.location.href = data;
				},
				failure: function(data)
				{
					ajaxForRedirectScript();
				}
			});	
		}(data));
	}

	function removeExtractedDir()
	{
		if(retryCount == 0)
		{
			updateText("Removing Extracted TMP Files");
		}
		else
		{
			updateText("Attempt "+(retryCount+1)+" of 3 for Removing Extracted TMP Files");
		}
		var urlForSend = urlForSendMain;
		var dataSend = {action: 'removeDirUpdate'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: dataSend,
			type: 'POST',
			success: function(data)
			{
				//verify if downloaded
				updateText("Verifying that TMP files were removed");
				verifyFile('removeDirUpdate', '../../update/downloads/updateFiles/extracted/', false);
			},
			failure: function(data)
			{
				retryCount++;
				removeExtractedDir();
			}
		});
	}

	function removeDownloadedZip()
	{
		if(retryCount == 0)
		{
			updateText("Removing Zip TMP File");
		}
		else
		{
			updateText("Attempt "+(retryCount+1)+" of 3 for Removing Zip TMP File");
		}
		var urlForSend = urlForSendMain;
		var dataSend = {action: 'removeZipFile', fileToUnlink: "../../update/downloads/updateFiles/updateFiles.zip"};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: dataSend,
			type: 'POST',
			success: function(data)
			{
				//verify if downloaded
				updateText("Verifying that TMP files were removed");
				verifyFile('removeZipFile', '../../update/downloads/updateFiles/updateFiles.zip', false);
			},
			failure: function(data)
			{
				retryCount++;
				removeDownloadedZip();
			}
		});
	}

	function finishedUpdate()
	{
		//updateConfigStatic
		var urlForSend = urlForSendMain;
		var dataSend = {action: 'updateConfigStatic', versionToUpdate: arrayOfVersions[(versionCountCurrent-1)]};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: dataSend,
			type: 'POST',
			complete: function(data)
			{
				retryCount = 0;
				verifyFileTimer = setInterval(function(){finishUpdatePollCheck();},2000);
				
			}
		});
		

	}

	function finishUpdatePollCheck()
	{
		if(retryCount == 0)
		{
			updateText("Verifying Version Change");
		}
		else
		{
			updateText("Attempt "+(retryCount+1)+" of 3 for Verifying Version Change");
		}
		if(retryCount > 3)
		{
			clearInterval(verifyFileTimer);
			updateError();
		}
		var urlForSend = "../core/php/versionCheck.php";
		var dataSend = {};
		$.ajax({
			url: urlForSend,
			dataType: "json",
			data: dataSend,
			type: "POST",
			success: function(data)
			{
				if(data === arrayOfVersions[(versionCountCurrent-1)])
				{
					retryCount = 0;
					clearInterval(verifyFileTimer);
					finishedUpdateAfterAjax();
				}
			},
			failure: function(data)
			{
				retryCount++;
			}
		});
	}

	function finishedUpdateAfterAjax()
	{
		//check if another version to update to next
		versionCountCurrent++;
		if(versionCountCurrent > arrayOfVersionsCount)
		{
			//finished update
			document.getElementById('menu').style.display = "block";
			document.getElementById('titleHeader').innerHTML = "<h1>Finished Update</h1>";
			document.getElementById('progressBar').value = 100;
			updateStatusFunc("Finished Updating to ","finishedUpdate",100);
			window.location.href = "../settings/whatsNew.php";
		}
		else
		{
			//update num to match
			document.getElementById('countOfVersions').innerHTML = versionCountCurrent;
			document.getElementById('currentUpdatTo').innerHTML = (arrayOfVersions[(versionCountCurrent-1)]);
			//update version to update to
			versionToUpdateTo = arrayOfVersions[(versionCountCurrent-1)];
			//start new download
			updateStatusFunc("Downloading Zip Files For ","downloadFile");
			downloadBranch();
		}
	}
	
</script> 

<?php
if($newestVersionCheck == $versionCheck)
{
	file_put_contents("../core/php/updateProgressLog.php", "<p> Loading update file list. </p>");
}
?>
</html>

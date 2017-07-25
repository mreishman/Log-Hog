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
require_once('setupProcessFile.php');

function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
}


if($setupProcess != "step4")
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/director.php";
	header('Location: ' . $url, true, 302);
	exit();
}
$counterSteps = 1;
while(file_exists('step'.$counterSteps.'.php'))
{
	$counterSteps++;
}
$counterSteps--;
require_once('../core/php/loadVars.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<script src="../core/js/jquery.js"></script>
	<?php readfile('../core/html/popup.html') ?>	
	<style type="text/css">
		#settingsMainVars .settingsHeader{
			display: none;
		}
		li .settingsHeader{
			display: block !important;
		}
		#widthForWatchListSection{
			width: 100% !important;
		}
		#menu a, .link, .linkSmall, .context-menu
		{
			background-color: <?php echo $currentSelectedThemeColorValues[0]?>;
		}
	</style>
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px; max-height: 500px;" >
	<div class="settingsHeader">
		<h1>Step 4 of <?php echo $counterSteps; ?></h1>
	</div>
	<div style="word-break: break-all; margin-left: auto; margin-right: auto; max-width: 800px; overflow: auto; max-height: 500px;" id="innerSettingsText">
	<p style="padding: 10px;">Would you also like to install Monitor?</p>
	<p style="padding: 10px;">Monitor is a htop like program that allows you to monitor system resources from the web.</p>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr>
	<th style="text-align: left;">
		<?php if($counterSteps < 6): ?>
			<a onclick="updateStatus('finished');" class="link">No Thanks, Continue to Log-Hog</a>
		<?php else: ?>
			<a onclick="updateStatus('step6');" class="link">No Thanks, Continue Setup</a>
		<?php endif; ?>
	</th>
	<th style="text-align: right;" >
		<?php if($counterSteps == 4): ?>
			<a onclick="updateStatus('step5');" class="link">Yes, Download!</a>
		<?php else: ?>
			<a onclick="updateStatus('step5');" class="link">Yes, Download!</a>
		<?php endif; ?>
	</th></tr></table>
	</div>
	<br>
	<br>
</div>
</body>
<form id="defaultVarsForm" action="../core/php/settingsSave.php" method="post"></form>
<script type="text/javascript">

var retryCount = 0;
var verifyCount = 0;
var lock = false;
var directory = "../../top/";
var urlForSendMain = '../core/php/performSettingsInstallUpdateAction.php?format=json';
var verifyFileTimer = null;
var dotsTimer = null;

	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		if(statusExt == 'step6')
		{
			location.reload();
		}
		else
		{
			hidePopup();
			//download Monitor from github
			document.getElementById('innerSettingsText').innerHTML = "";
			dotsTimer = setInterval(function() {document.getElementById('innerSettingsText').innerHTML = ' .'+document.getElementById('innerSettingsText').innerHTML;}, '120');
			checkIfTopDirIsEmpty();
		}
	}

	function updateText(text)
	{
		document.getElementById('innerSettingsText').innerHTML = "<p>"+text+"</p>"+document.getElementById('innerSettingsText').innerHTML;
	}

	function checkIfTopDirIsEmpty()
	{
		updateText("Verifying that Directory is empty");
		var urlForSend = urlForSendMain;
		var data = {action: 'checkIfDirIsEmpty', dir: '../../top/'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			success: function(data)
			{
				if(data == true)
				{
					downloadFile();
				}
				else if(data == false)
				{
					removeFilesFromToppFolder();
				}
			}
		});	
	}

	function removeFilesFromToppFolder()
	{
		updateText("Directory has files in it, removing files");
		var urlForSend = urlForSendMain;
		var data = {action: 'removeUnZippedFiles', locationOfFilesThatNeedToBeRemovedRecursivally: '../../top/',removeDir: false};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				updateText("Download Files");
				downloadFile();
			}
		});	
	}

	function downloadFile()
	{
		if(retryCount == 0)
		{
			updateText("Downloading Monitor");
		}
		else
		{
			updateText("Attempt "+(retryCount+1)+" of 3 for downloading Monitor");
		}
		var urlForSend = urlForSendMain;
		var data = {action: 'downloadFile', file: 'master',downloadFrom: 'monitor/archive/', downloadTo: '../../top.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				updateText("Verifying Download");
				verifyFile('downloadMonitor', '../../top.zip');
			}
		});	
	}

	function unzipFile()
	{
		var urlForSend = urlForSendMain;
		var data = {action: 'unzipFile', locationExtractTo: '../../monitor-master/', locationExtractFrom: '../../top.zip', tmpCache: '../../'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('unzipFile', '../../monitor-master/index.php');
			}
		});	
	}

	function removeZipFile()
	{
		updateText("Removing Downloaded File");
		var urlForSend = urlForSendMain;
		var data = {action: 'removeZipFile', fileToUnlink: '../../top.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('removeZipFile', '../../top.zip',false);
			}
		});
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
			if(action == 'downloadMonitor')
			{
				updateText("File Could NOT be found");
				downloadFile();
			}
			else if(action == 'unzipFile')
			{
				unzipFile();
			}
			else if(action == 'removeZipFile')
			{
				removeZipFile();
			}
			else if(action == 'cleanUp')
			{
				cleanUp();
			}
			else if(action == 'changeMonSettings')
			{
				changeMonSettings();
			}
			else if(action == 'removeUnneededFoldersMonitor')
			{
				removeUnneededFoldersMonitor();
			}
			//run previous ajax
		}
	}

	function verifySucceded(action)
	{
		//downloaded, extract
		retryCount = 0;
		if(action == 'downloadMonitor')
		{
			updateText("File Download Verified");
			updateText("Unzipping Downloaded File");
			unzipFile();
		}
		else if(action == 'unzipFile')
		{
			removeZipFile();
		}
		else if(action == 'removeZipFile')
		{
			cleanUp();
		}
		else if(action == 'cleanUp')
		{
			changeMonSettings();
		}
		else if(action == 'changeMonSettings')
		{
			removeUnneededFoldersMonitor();
		}
		else if(action == 'removeUnneededFoldersMonitor')
		{
			clearInterval(dotsTimer);
			location.reload();
		}
	}

	function changeMonSettings()
	{
		updateText("Changing Monitor Settings");
		var urlForSend = urlForSendMain;
		var data = {action: 'changeMonSettings'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('changeMonSettings', '../../top/statusTest.php');
			}
		});
	}

	function removeUnneededFoldersMonitor()
	{
		updateText("Removing unneeded folders from top");
		var urlForSend = urlForSendMain;
		var data = {action: 'removeUnneededFoldersMonitor', dir: '../../top'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('removeUnneededFoldersMonitor', '../../top/core/conf/config.php',false);
			}
		});
	}

	function cleanUp()
	{
		//remove old dir, rename new dir to old dir
		updateText("Cleaning Up");
		var urlForSend = urlForSendMain;
		var data = {action: 'cleanUpMonitor', fileToUnlink: '../../monitor.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('cleanUp', '../../top/index.php');
			}
		});
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
</script>
<script src="stepsJavascript.js"></script>
<script src="../core/js/settingsMain.js"></script>
</html>
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
	<div style="word-break: break-all; margin-left: auto; margin-right: auto; max-width: 800px;" id="innerSettingsText">
	<p style="padding: 10px;">Would you also like to install Monitor?</p>
	<p style="padding: 10px;">Monitor is a htop like program that allows you to monitor system resources from the web.</p>
	<table style="width: 100%; padding-left: 20px; padding-right: 20px;" ><tr>
	<th style="text-align: left;"><a onclick="updateStatus('finished');" class="link">No Thanks, Continue to Log-Hog</a></th>
	<th style="text-align: right;" >
		<?php if($counterSteps == 4): ?>
			<a onclick="updateStatus('step4');" class="link">Yes, Download!</a>
		<?php else: ?>
			<a onclick="updateStatus('step4');" class="link">Yes, Download!</a>
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

	function defaultSettings()
	{
		//change setupProcess to finished
		location.reload();
	}

	function customSettings()
	{
		//download Monitor from github
		document.getElementById('innerSettingsText').innerHTML = "";
		setInterval(function() {document.getElementById('innerSettingsText').innerHTML += ' .';}, '100');
		checkIfTopDirIsEmpty();
		
		
	}

	function updateText(text)
	{
		document.getElementById('innerSettingsText').innerHTML += "<p>"+text+"</p>";
	}

	function updateStatus(status)
	{
		var urlForSend = './updateSetupStatus.php?format=json'
		var data = {status: status };
		$.ajax({
				  url: urlForSend,
				  dataType: 'json',
				  data: data,
				  type: 'POST',
		success: function(data)
		{
			if(status == "finished")
			{
				defaultSettings();
			}
			else
			{
				customSettings();
			}
	  	},
			});
		return false;
	}

	function checkIfTopDirIsEmpty()
	{
		updateText("Verifying that Directory is empty");
		var urlForSend = urlForSendMain;
		var data = {action: 'checkIfDirIsEmpty', dir: '../../../top/'};
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
		var data = {action: 'removeUnZippedFiles', locationOfFilesThatNeedToBeRemovedRecursivally: '../../monitor',removeDir: false};
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
		var data = {action: 'downloadFile', file: 'master',downloadFrom: 'monitor/archive/', downloadTo: '../../monitor.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				updateText("Verifying Download");
				verifyFile('downloadMonitor', '../../monitor.zip');
			}
		});	
	}

	function unzipFile()
	{
		var urlForSend = urlForSendMain;
		var data = {action: 'unzipFile', locationExtractTo: '../../monitor.zip', locationExtractFrom: '../../top/'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('unzipFile', '../../top/index.php');
			}
		});	
	}

	function removeZipFile()
	{
		var urlForSend = urlForSendMain;
		var data = {action: 'removeZipFile', fileToUnlink: '../../monitor.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('removeZipFile', '../../monitor.zip',false);
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
			//run previous ajax
		}
	}

	function verifySucceded(action)
	{
		updateText('Verified');
		console.log(action);
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

		}
	}

	function verifyFile(action, fileLocation,isThere = true)
	{
		verifyCount = 0;
		updateText('Verifying '+action+' with'+fileLocation);
		verifyFileTimer = setInterval(verifyFilePoll(action,fileLocation,isThere),6000);
	}

	function verifyFilePoll(action, fileLocation,isThere)
	{
		if(lock == false)
		{
			lock = true;
			updateText('verifying '+verifyCount+' of 10');
			var urlForSend = urlForSendMain;
			var data = {action: 'verifyFileIsThere', fileLocation: fileLocation, lastAction: action};
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
			console.log("Int Clear");
			clearInterval(verifyFileTimer);
			verifySucceded(data['lastAction']);
		}
		else
		{
			verifyCount++;
			if(verifyCount > 10)
			{
				clearInterval(verifyFileTimer);
				verifyFail(data['lastAction']);
			}
		}
	}

	function updateError()
	{
		document.getElementById('innerSettingsText').innerHTML = "<p>An error occured while trying to download Monitor. </p>";
	}

	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	var fileArray = JSON.parse('<?php echo json_encode($config['watchList']) ?>');
	var countOfWatchList = <?php echo $i; ?>;
	var countOfAddedFiles = 0;
	var countOfClicks = 0;
	var locationInsert = "newRowLocationForWatchList";
	var logTrimType = "<?php echo $logTrimType; ?>";


</script>
<script src="../core/js/settingsMain.js"></script>
<?php readfile('../core/html/popup.html') ?>
</html>
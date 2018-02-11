<?php
$baseUrl = "../core/";

$versionToRestoreTo = 0;
if(isset($_POST['versionRevertTo']))
{
	$versionToRestoreTo = $_POST['versionRevertTo'];
}
require_once('../core/php/loadVars.php');
require_once('../core/php/commonFunctions.php');
require_once('../core/php/configStatic.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="../core/template/theme.css">
	<link rel="stylesheet" type="text/css" href="../core/template/base.css">
	<script src="../core/js/jquery.js"></script>	
</head>
<body>
<div style="width: 90%; margin: auto; margin-right: auto; margin-left: auto; display: block; height: auto; margin-top: 15px; max-height: 500px;" >
	<div class="settingsHeader">
	<?php if($versionToRestoreTo != 0): ?>
		<h1>Restoring to version <?php echo $versionToRestoreTo; ?></h1>
	<?php else: ?>
		<h1>Select a version to restore to: <?php echo generateRestoreList($configStatic);?> <button class="link" onclick="document.getElementById('revertForm').submit();"  >Restore</button></h1>
	<?php endif;?>
	</div>
	<div style="word-break: break-all; margin-left: auto; margin-right: auto; max-width: 800px; overflow: auto; max-height: 500px;" id="innerSettingsText">
	<?php if($versionToRestoreTo != 0): ?>
		<img src='../core/img/loading.gif' height='50' width='50'> 
	<?php endif; ?>
	</div>
	<br>
	<br>
</div>
</body>
<script type="text/javascript">

var retryCount = 0;
var verifyCount = 0;
var lock = false;
var directory = "../../top/";
var urlForSendMain = './php/performSettingsInstallUpdateAction.php?format=json';
var verifyFileTimer = null;
var dotsTimer = null;
var fileVersionDownload = null;
<?php if($versionToRestoreTo != 0): ?>
fileVersionDownload = '<?php echo $versionToRestoreTo; ?>';
<?php endif ;?>

$( document ).ready(function() 
{
	if(fileVersionDownload)
	{
		startLogic();
	}
});

function startLogic()
{
		dotsTimer = setInterval(function() {document.getElementById('innerSettingsText').innerHTML = ' .'+document.getElementById('innerSettingsText').innerHTML;}, '120');
	document.getElementById('innerSettingsText').innerHTML = "";
	downloadRestoreVersion();
}

function finishedDownload()
	{
		clearInterval(dotsTimer);
		document.getElementById('innerSettingsText').innerHTML = "<br> <h1>Finished Restoring Log-Hog<h1><br> <br> <a class='link' onclick='goBack();' >< Back to Settings</a>";
	}

	function goBack()
	{
		window.history.back();
	}

	function updateText(text)
	{
		document.getElementById('innerSettingsText').innerHTML = "<p>"+text+"</p>"+document.getElementById('innerSettingsText').innerHTML;
	}

	function downloadRestoreVersion()
	{
		if(retryCount == 0)
		{
			updateText("Downloading Log-Hog");
		}
		else
		{
			updateText("Attempt "+(retryCount+1)+" of 3 for downloading Log-Hog");
		}
		var urlForSend = urlForSendMain;
		var data = {action: 'downloadFile', file: fileVersionDownload,downloadFrom: 'Log-Hog/archive/', downloadTo: '../../restore/restore.zip'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				updateText("Verifying Download");
				verifyFile('downloadRestoreVersion', '../../restore/restore.zip');
			}
		});	
	}

	function unzip()
	{
		var urlForSend = urlForSendMain;
		var data = {action: 'unzipFile', locationExtractTo: '../../restore/extracted/', locationExtractFrom: '../../restore/restore.zip', tmpCache: '../../'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('unzip', '../../Log-Hog-'+fileVersionDownload+'/index.php');
			}
		});	
	}

	function moveDirUnzipped()
	{
		var urlForSend = urlForSendMain;
		var data = {action: 'moveDirUnzipped', version: fileVersionDownload};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('moveDirUnzipped', '../../restore/extracted/index.php');
			}
		});	
	}

	function changeDirUnzipped()
	{
		var urlForSend = urlForSendMain;
		var data = {action: 'changeDirUnzipped'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				verifyFile('changeDirUnzipped', '../../index.php');
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
			if(action == 'downloadRestoreVersion')
			{
				updateText("File Could NOT be found");
				downloadRestoreVersion();
			}
			else if(action == 'cleanDirectory')
			{
				updateText("Could not verify that directory is empty");
				cleanDirectory();
			}
			else if(action == 'unzip')
			{
				updateText("Could not verify that zip file was extracted");
				unzip();
			}
			else if(action == 'moveDirUnzipped')
			{
				moveDirUnzipped();
			}
			else if(action == 'changeDirUnzipped')
			{
				changeDirUnzipped();
			}
			
			//run previous ajax
		}
	}

	function verifySucceded(action)
	{
		//downloaded, extract
		retryCount = 0;
		if(action == 'downloadRestoreVersion')
		{
			updateText("File Download Verified");
			cleanDirectory();
		}
		else if(action == 'cleanDirectory')
		{
			//unzip folder
			unzip();
		}
		else if(action == 'unzip')
		{
			moveDirUnzipped();
		}
		else if(action == 'moveDirUnzipped')
		{
			//move from unzipped to actual locations
			changeDirUnzipped();
		}
		else if(action == 'changeDirUnzipped')
		{
			finishedDownload();
		}
		
	}

	function cleanDirectory()
	{
		//
		if(retryCount == 0)
		{
			updateText("Cleaning Directory");
		}
		else
		{
			updateText("Attempt "+(retryCount+1)+" of 3 for cleaning directory");
		}
		var urlForSend = urlForSendMain;
		var data = {action: 'removeAllFilesFromLogHogExceptRestore'};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			complete: function()
			{
				//verify if downloaded
				updateText("Verifying that the directory is empty");
				verifyFile('cleanDirectory', '../index.php', false);
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
		document.getElementById('innerSettingsText').innerHTML = "<p>An error occured while trying to restore Log-Hog. </p>";
	}
	
</script>
</html>
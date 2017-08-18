<!doctype html>
<head>
	<title>Log Hog | Updater</title>
	<link rel="stylesheet" type="text/css" href="../core/template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>

<div id="main">
	<div class="settingsHeader" style="text-align: center;" >
		<span id="titleHeader" >
			<h1>Updating Updater...</h1>
		</span>
	</div>
	<div class="settingsDiv" >
		<div class="updatingDiv">
			<p style="border-bottom: 1px solid white;"></p>
			<div id="innerDisplayUpdate" style="height: 300px; overflow: auto; max-height: 300px;">
			<table style="padding: 10px;">
				<tr>
					<td style="height: 50px;">
						<img id="loadingCopyOld" src="../core/img/loading.gif" height="30px;">
						<img id="greenCheckOld" style="display: none;" src="../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Removing Old Updater.
					</td>
				</tr>
				<tr>
					<td style="height: 50px;">
						<img id="loadingVerifiedRemove" style="display: none;" src="../core/img/loading.gif" height="30px;">
						<img id="greenCheckVerifiedRemove" style="display: none;" src="../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Verifying old Updater was removed.
					</td>
				</tr>
				<tr>
					<td style="height: 50px;">
						<img id="loadingCopyNew" style="display: none;" src="../core/img/loading.gif" height="30px;">
						<img id="greenCheckCopyNew" style="display: none;" src="../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Copying new updater.
					</td>
				</tr>
				<tr>
					<td style="height: 50px;">
						<img id="loadingCopyNewVerify" style="display: none;" src="../core/img/loading.gif" height="30px;">
						<img id="greenCheckCopyNewVerify" style="display: none;" src="../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Verifying new updater was copied.
					</td>
				</tr>
				<tr>
					<td style="height: 50px;">
						<img id="loadingUpdateConf" style="display: none;" src="../core/img/loading.gif" height="30px;">
						<img id="greenCheckUpdateConf" style="display: none;" src="../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Updating config file. 
					</td>
				</tr>
				<tr>
					<td style="height: 50px;">
						<img id="loadingUpdateConfVerify" style="display: none;" src="../core/img/loading.gif" height="30px;">
						<img id="greenCheckUpdateConfVerify" style="display: none;" src="../core/img/greenCheck.png" height="30px;">
					</td>
					<td style="width: 20px;">
					</td>
					<td>
						Verifying config file was updated. 
					</td>
				</tr>
			</table>
			</div>
			<p style="border-bottom: 1px solid white;"></p>
		</div>
	</div>
</div>
</body>

<script src="../core/js/settings.js"></script>
<script type="text/javascript"> 
	var lock = false;
	var urlForSendMain = '../../../../core/php/performSettingsInstallUpdateAction.php?format=json';

	$( document ).ready(function()
	{
		removeUpdateOld();
	});

	function removeUpdateOld()
	{
		var urlForSend = urlForSendMain;
		var dataSend = {action: 'removeZipFile', fileToUnlink: "../../update/updater.php"};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: dataSend,
			type: 'POST',
			success: function(data)
			{
				document.getElementById('loadingCopyOld').style.display = "none";
				document.getElementById('greenCheckOld').style.display = "block";
				document.getElementById('loadingVerifiedRemove').style.display = "block";
				verifyFile("remove","../../update/updater.php", false);
			},
			failure: function(data)
			{
				removeUpdateOld();
			}
		});
	}

	function copyFileFromArrayAjax()
	{
		
		var urlForSend = urlForSendMain;
		var dataSend = {action: "copyFileToFile", fileCopyFrom: "update_updater.php"};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: dataSend,
			type: 'POST',
			success(fileCopied)
			{
				document.getElementById('loadingCopyNew').style.display = "none";
				document.getElementById('greenCheckCopyNew').style.display = "block";
				document.getElementById('loadingCopyNewVerify').style.display = "block";
				verifyFile("added","../../update/updater.php");
			}
		});
	}


	function verifyFile(action, fileLocation,isThere = true)
	{
		verifyCount = 0;
		verifyFileTimer = setInterval(function(){verifyFilePoll(action,fileLocation,isThere);},2000);
	}

	function verifyFilePoll(action, fileLocation,isThere)
	{
		if(lock == false)
		{
			lock = true;
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
		document.getElementById('innerSettingsText').innerHTML = "<p>An error occured while trying to download Monitor. </p>";
	}

	function verifyFail(action)
	{
		updateError();
	}

	function verifySucceded(action)
	{
		//downloaded, extract
		retryCount = 0;
		if(action == 'remove')
		{
			document.getElementById('loadingVerifiedRemove').style.display = "none";
			document.getElementById('greenCheckVerifiedRemove').style.display = "block";
			document.getElementById('loadingCopyNew').style.display = "block";
			copyFileFromArrayAjax();

		}
		else if(action == 'added')
		{
			document.getElementById('loadingCopyNewVerify').style.display = "none";
			document.getElementById('greenCheckCopyNewVerify').style.display = "block";
			document.getElementById('loadingUpdateConf').style.display = "block";
			updateStatusFunc();
		}
	}

	function updateStatusFunc(updateStatusInner = 'postUpgrade Scripts', actionLocal = 'postUpgrade Scripts', percentToSave = 75)
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
				document.getElementById('loadingUpdateConf').style.display = "none";
				document.getElementById('greenCheckUpdateConf').style.display = "block";
				document.getElementById('loadingUpdateConfVerify').style.display = "block";
				verifyFileTimer = setInterval(function(){verifyConfFileChanged();},2000);
			}
		});	
	}

	function verifyConfFileChanged()
	{
		var urlForSend =  '../../../../core/php/getPercentUpdate?format=json';;
		var data = {};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			success: function(data)
			{
				if(data == "75")
				{
					clearInterval(verifyFileTimer);
					document.getElementById('loadingUpdateConfVerify').style.display = "none";
					document.getElementById('greenCheckUpdateConfVerify').style.display = "block";
					setTimeout(function()
					{ 
						finishedTmpUpdate();
					}, 1000);  
				}
			}
		});	
	}


	function finishedTmpUpdate()
	{
		window.location.href = "./updater.php";
	}

</script> 
</html>

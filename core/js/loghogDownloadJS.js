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
			finishedDownload();
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
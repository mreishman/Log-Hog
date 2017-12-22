var lock = false;

function updateText(text)
{
	document.getElementById("innerSettingsText").innerHTML = "<p>"+text+"</p>"+document.getElementById("innerSettingsText").innerHTML;
}

function checkIfTopDirIsEmpty()
{
	updateText("Verifying that Directory is empty");
	var urlForSend = urlForSendMain;
	var data = {action: "checkIfDirIsEmpty", dir: "../../"+localFolderLocation+"/"};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			if(data === true)
			{
				downloadFile();
			}
			else if(data === false)
			{
				removeFilesFromToppFolder();
			}
		}
	});	
}

function removeFilesFromToppFolder(skip = false)
{
	updateText("Directory has files in it, removing files");
	var urlForSend = urlForSendMain;
	var data = {action: "removeUnZippedFiles", locationOfFilesThatNeedToBeRemovedRecursivally: "../../"+localFolderLocation+"/",removeDir: true};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		complete()
		{
			//verify if downloaded
			updateText("Download Files");
			if(!skip)
			{
				downloadFile();
			}
			else
			{
				//re-add folder / one file

				verifyFile("removeFilesFromToppFolderSkip", "../../"+localFolderLocation+"/",false);
			}
		}
	});	
}

function downloadFile()
{
	if(retryCount === 0)
	{
		updateText("Downloading Monitor");
	}
	else
	{
		updateText("Attempt "+(retryCount+1)+" of 3 for downloading Monitor");
	}
	var urlForSend = urlForSendMain;
	var data = {action: "downloadFile", file: "master",downloadFrom: repoName+"/archive/", downloadTo: "../../tmp.zip"};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data: data,
		type: "POST",
		complete()
		{
			//verify if downloaded
			updateText("Verifying Download");
			verifyFile("downloadMonitor", "../../tmp.zip");
		}
	});	
}

function unzipFile()
{
	var urlForSend = urlForSendMain;
	var data = {action: "unzipFile", locationExtractTo: "../../"+localFolderLocation+"/", locationExtractFrom: "../../tmp.zip", tmpCache: "../../"};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data: data,
		type: "POST",
		complete()
		{
			//verify if downloaded
			verifyFile("unzipFile", "../../"+localFolderLocation+"/index.php");
		}
	});	
}

function removeZipFile()
{
	updateText("Removing Downloaded File");
	var urlForSend = urlForSendMain;
	var data = {action: "removeZipFile", fileToUnlink: "../../tmp.zip"};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data: data,
		type: "POST",
		complete: function()
		{
			//verify if downloaded
			verifyFile("removeZipFile", "../../tmp.zip",false);
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
		verifyFailAction(action);
	}
}

function verifyFailAction(action)
{
	if(action === "downloadMonitor")
	{
		updateText("File Could NOT be found");
		downloadFile();
	}
	else if(action === "unzipFile")
	{
		unzipFile();
	}
	else if(action === "removeZipFile")
	{
		removeZipFile();
	}
	else if(action === "removeFilesFromToppFolderSkip")
	{
		removeFilesFromToppFolder(true);
	}
}

function verifySucceded(action)
{
	//downloaded, extract
	retryCount = 0;
	if(action === "downloadMonitor")
	{
		updateText("File Download Verified");
		updateText("Unzipping Downloaded File");
		unzipFile();
	}
	else if(action === "unzipFile")
	{
		removeZipFile();
	}
	else if(action === "removeZipFile")
	{
		finishedDownload();
	}
	else if(action === "removeFilesFromToppFolderSkip")
	{
		finishedDownload();
	}
}

function verifyFile(action, fileLocation,isThere = true)
{
	verifyCount = 0;
	updateText("Verifying "+action+" with"+fileLocation);
	verifyFileTimer = setInterval(function(){verifyFilePoll(action,fileLocation,isThere);},6000);
}

function verifyFilePoll(action, fileLocation,isThere)
{
	if(lock === false)
	{
		lock = true;
		updateText("verifying "+(verifyCount+1)+" of 10");
		var urlForSend = urlForSendMain;
		var data = {action: "verifyFileIsThere", fileLocation, isThere , lastAction: action};
		(function(_data){
			$.ajax({
				url: urlForSend,
				dataType: "json",
				data: data,
				type: "POST",
				success(data)
				{
					verifyPostEnd(data, _data);
				},
				failure(data)
				{
					verifyPostEnd(data, _data);
				},
				complete()
				{
					lock = false;
				}
			});	
		}(data));
	}
}

function verifyPostEnd(verified, data)
{
	if(verified === true)
	{
		clearInterval(verifyFileTimer);
		verifySucceded(data["lastAction"]);
	}
	else
	{
		verifyCount++;
		if(verifyCount > 9)
		{
			clearInterval(verifyFileTimer);
			verifyFail(data["lastAction"]);
		}
	}
}

function updateError()
{
	clearInterval(dotsTimer);
	document.getElementById("innerSettingsText").innerHTML = "<p>An error occured while trying to download "+repoName+". </p>";
}
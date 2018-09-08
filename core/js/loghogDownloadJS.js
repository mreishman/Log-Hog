var lock = false;
var verifyCountSuccess = 0;

function updateText(newValue)
{
	document.getElementById(idToSubmitStatic+"ProgressBar").value = newValue;
}

function checkIfTopDirIsEmpty()
{
	updateText(10);
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
	updateText(20);
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
		updateText(40);
	}
	var urlForSend = urlForSendMain;
	var data = {action: "downloadFile", file: "master",downloadFrom: repoName+"/archive/", downloadTo: "../../tmp.zip"};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		complete()
		{
			//verify if downloaded
			updateText(60);
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
		data,
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
	updateText(70);
	var urlForSend = urlForSendMain;
	var data = {action: "removeZipFile", fileToUnlink: "../../tmp.zip"};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		complete()
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
	verifyCountSuccess = 0;
	verifyFileTimer = setInterval(function(){verifyFilePoll(action,fileLocation,isThere);},6000);
}

function verifyFilePoll(action, fileLocation,isThere)
{
	if(lock === false)
	{
		lock = true;
		updateText(90);
		var urlForSend = urlForSendMain;
		var data = {action: "verifyFileIsThere", fileLocation, isThere , lastAction: action};
		(function(_data){
			$.ajax({
				url: urlForSend,
				dataType: "json",
				data,
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
		verifyCountSuccess++;
		if(verifyCountSuccess >= successVerifyNum)
		{
			clearInterval(verifyFileTimer);
			verifyCountSuccess = 0;
			verifySucceded(data["lastAction"]);
		}
	}
	else
	{
		verifyCountSuccess = 0;
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
	//error popup
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML += "<div class='settingsHeader' id='popupHeaderText' ><span id='popupHeaderText' >Error</span></div><br><br><div style='width:100%;text-align:center;'> Error when trying to modify addon <a class=\"link\" onclick=\"hidePopup();\" >Close</a> </div>";
}
var currentFile = 1;
var lock = false;
var urlForSendMain = '../../../core/php/performSettingsInstallUpdateAction.php?format=json';

$( document ).ready(function()
{
	remove();
});

function remove()
{
	if(arrayOfFilesToDelete[currentFile-1]["type"] === "file")
	{
		removeFile();
	}
	else
	{
		removeFolder();
	}
}

function removeFile()
{
	document.getElementById("runCount").innerHTML = currentFile;
	document.getElementById("verifyCount").innerHTML = currentFile;
	document.getElementById("runLoad").style.display = "block";
	document.getElementById("verifyLoad").style.display = "none";
	var urlForSend = urlForSendMain;
	var dataSend = {action: "removeZipFile",fileToUnlink: "../../"+arrayOfFilesToDelete[currentFile-1]["fullPath"]};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data: dataSend,
		type: "POST",
		success(data)
		{
			verifyRemoveFile(data);
		}
	});
}

function removeFolder()
{
	document.getElementById("runCount").innerHTML = currentFile;
	document.getElementById("verifyCount").innerHTML = currentFile;
	document.getElementById("runLoad").style.display = "block";
	document.getElementById("verifyLoad").style.display = "none";
	var urlForSend = urlForSendMain;
	var dataSend = {action: "removeUnZippedFiles",locationOfFilesThatNeedToBeRemovedRecursivally: "../../"+arrayOfFilesToDelete[currentFile-1]["fullPath"]};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data: dataSend,
		type: "POST",
		success(data)
		{
			verifyRemoveFile(data);
		}
	});
}

function verifyRemoveFile()
{
	document.getElementById("runCheck").style.display = "block";
	document.getElementById("runLoad").style.display = "none";
	document.getElementById("verifyLoad").style.display = "block";
	verifyCount = 0;
	verifyCountSuccess = 0;
	verifyFileTimer = setInterval(function(){verifyFilePoll(arrayOfFilesToDelete[currentFile-1]["fullPath"]);},2000);
}

function verifyFilePoll(file)
{
	if(lock === false)
	{
		lock = true;
		var urlForSend = urlForSendMain;
		var data = {action: "verifyFileIsThere",fileLocation: file, "isThere" : false};
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
	if(verified == true)
	{
		verifyCountSuccess++;
		if(verifyCountSuccess >= successVerifyNum)
		{
			verifyCountSuccess = 0;
			clearInterval(verifyFileTimer);
			verifySucceded();
		}
	}
	else
	{
		verifyCountSuccess = 0;
		verifyCount++;
		if(verifyCount > 29)
		{
			clearInterval(verifyFileTimer);
			verifyFail();
		}
	}
}

function updateError()
{
	document.getElementById("innerDisplayUpdate").innerHTML = "<h1>An error occured while trying to upgrade file. </h1>";
}

function verifyFail()
{
	updateError();
}

function verifySucceded()
{
	retryCount = 0;
	currentFile++;
	if(currentFile <= totalCountOfFilesToDelete)
	{
		remove();
	}
	else
	{
		finishedTmpUpdate();
	}
}

function finishedTmpUpdate()
{
	document.getElementById('verifyCheck').style.display = "block";
	document.getElementById('verifyLoad').style.display = "none";
	redirectToLocationFromUpgradeTheme();
}
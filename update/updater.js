var headerForUpdate = document.getElementById('headerForUpdate');
var urlForSendMain = '../core/php/performSettingsInstallUpdateAction.php?format=json';
var retryCount = 0;
var verifyFileTimer;
var percent = 0;
var arrayOfFilesExtracted;
var lock = false;
var filteredArray = new Array();
var preScriptCount = 1;
var postScriptCount = 1;
var fileCopyCount = 0;
var total = 100*arrayOfVersionsCount;
var versionCountCurrent = 1;
var lastFileCheck = "";
var verifyCountSuccess = 0;
var successVerifyNum = 4;

function updateProgressBar(additonalPercent)
{
	percent = percent + additonalPercent;
	if(percent > total)
	{
		percent = percent - total;
	}
	document.getElementById('progressBar').value = percent/total*100;
}

function updateText(text)
{
	document.getElementById('innerSettingsText').innerHTML = "<p>"+text+"</p>"+document.getElementById('innerSettingsText').innerHTML;
}

function updateStatusFunc(updateStatusInner, actionLocal, percentToSave = (document.getElementById('progressBar').value))
{
	var data = {action: 'updateProgressFile', status: updateStatusInner, typeOfProgress: "updateProgressFile.php", actionSave: actionLocal, percent: percentToSave, pathToFile: ''};
	$.ajax({
		url: urlForSendMain,
		dataType: 'json',
		data,
		type: 'POST',
		complete()
		{

		}
	});	

	data = {action: 'updateProgressFile', status: updateStatusInner, typeOfProgress: "updateProgressFileNext.php", actionSave: actionLocal, percent: percentToSave, pathToFile: ''};
	$.ajax({
		url: urlForSendMain,
		dataType: 'json',
		data,
		type: 'POST',
		complete()
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
	document.getElementById('innerDisplayUpdate').innerHTML = settingsForBranchStuff['versionList'][versionToUpdateTo]['releaseNotes'];
	var data = {action: 'downloadFile', file: settingsForBranchStuff['versionList'][versionToUpdateTo]['branchName'],downloadFrom: 'Log-Hog/archive/', downloadTo: '../../update/downloads/updateFiles/updateFiles.zip'};
	$.ajax({
		url: urlForSendMain,
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
	$.ajax({
		url: urlForSendMain,
		dataType: 'json',
		data: {action: 'unzipUpdateAndReturnArray'},
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
	verifyCountSuccess = 0;
	updateText('Verifying '+action+' with '+fileLocation);
	verifyFileTimer = setInterval(function(){verifyFilePoll(action,fileLocation,isThere);},2000);
}

function verifyFilePoll(action, fileLocation,isThere)
{
	if(lock == false)
	{
		lock = true;
		updateText('verifying '+(verifyCount+1)+' of 10');
		var data = {action: 'verifyFileIsThere', fileLocation: fileLocation, isThere: isThere , lastAction: action};
		(function(_data){
			$.ajax({
				url: urlForSendMain,
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
		verifyCountSuccess++;
		if(verifyCountSuccess >= successVerifyNum)
		{
			verifyCountSuccess = 0;
			clearInterval(verifyFileTimer);
			verifySucceded(data['lastAction']);
		}
	}
	else
	{
		verifyCountSuccess = 0;
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
	document.getElementById('innerSettingsText').innerHTML += "<h2>An error occured while trying to update Log-Hog. </h2>";
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
			unzipBranch();
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
	verifyCountSuccess = 0;
	updateText('Verifying '+action+' with '+fileLocation);
	verifyFileTimer = setInterval(function(){verifyFileOrDirPoll(action,fileLocation);},2000);
}

function verifyFileOrDirPoll(action, fileLocation,isThere)
{
	if(lock == false)
	{
		lock = true;
		updateText('verifying '+(verifyCount+1)+' of 10');
		var data = {action: 'verifyFileOrDirIsThere', locationOfDirOrFile: fileLocation, lastAction: action};
		(function(_data){
			$.ajax({
				url: urlForSendMain,
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
		verifyCountSuccess++;
		if(verifyCountSuccess >= successVerifyNum)
		{
			verifyCountSuccess = 0;
			clearInterval(verifyFileTimer);
			verifySuccededTwo(data['lastAction']);
		}
	}
	else
	{
		verifyCountSuccess = 0;
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

function ajaxForPreScriptRun(urlForSendAjaxScrip)
{
	var data = "";
	$.ajax({
		url: "../update/downloads/updateFiles/extracted/"+urlForSendAjaxScrip,
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
		if(file.startsWith("pre-script-") || file.startsWith("post-script-") || file.startsWith("post-redirect-") || file.startsWith("exclude-this-file-from-copy-"))
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
	$.ajax({
		url: urlForSendMain,
		dataType: 'json',
		data: {action: "copyFileToFile", fileCopyFrom: file},
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

function ajaxForPostScriptRun(urlForSendAjaxScript)
{
	var data = "";
	$.ajax({
		url: "../update/downloads/updateFiles/extracted/"+urlForSendAjaxScript,
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

function ajaxForRedirectScript(urlForSendMainRedAjax)
{
	var data = {};
	(function(_data){
		$.ajax({
			url: "../update/downloads/updateFiles/extracted/"+urlForSendMainRedAjax,
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
	$.ajax({
		url: urlForSendMain,
		dataType: 'json',
		data: {action: 'removeDirUpdate'},
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
	$.ajax({
		url: urlForSendMain,
		dataType: 'json',
		data: {action: 'removeZipFile', fileToUnlink: "../../update/downloads/updateFiles/updateFiles.zip"},
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
	$.ajax({
		url: urlForSendMain,
		dataType: 'json',
		data: {action: 'updateConfigStatic', versionToUpdate: arrayOfVersions[(versionCountCurrent-1)]},
		type: 'POST',
		complete: function(data)
		{
			retryCount = 0;
			verifyCountSuccess = 0;
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
	$.ajax({
		url: "../core/php/versionCheck.php",
		dataType: "json",
		data: {},
		type: "POST",
		success: function(data)
		{
			if(data === arrayOfVersions[(versionCountCurrent-1)])
			{
				verifyCountSuccess++;
				if(verifyCountSuccess >= successVerifyNum)
				{
					verifyCountSuccess = 0;
					retryCount = 0;
					clearInterval(verifyFileTimer);
					finishedUpdateAfterAjaxSetToOneHundred();
				}
			}
			else
			{
				verifyCountSuccess = 0;
			}
		},
		failure: function(data)
		{
			retryCount++;
		}
	});
}

function finishedUpdateAfterAjaxSetToOneHundred()
{
	updateProgressBar(0.5);
	updateStatusFunc("Finished Updating to ","finishedUpdate",100);
	retryCount = 0;
	verifyCountSuccess = 0;
	verifyFileTimer = setInterval(function(){finishUpdateOneHundredCheck();},2000);
}

function finishUpdateOneHundredCheck()
{
	if(retryCount == 0)
	{
		updateText("Verifying Update Complete");
	}
	else
	{
		updateText("Attempt "+(retryCount+1)+" of 3 for Verifying Update Complete");
	}
	if(retryCount > 3)
	{
		clearInterval(verifyFileTimer);
		updateError();
	}
	$.ajax({
		url: "../core/php/verifyVersionInstallComplete.php",
		dataType: "json",
		data: {},
		type: "POST",
		success: function(data)
		{
			if(data === true)
			{
				verifyCountSuccess++;
				if(verifyCountSuccess >= successVerifyNum)
				{
					verifyCountSuccess = 0;
					retryCount = 0;
					clearInterval(verifyFileTimer);
					finishedUpdateAfterAjax();
				}
			}
			else
			{
				verifyCountSuccess = 0;
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
		setTimeout(function(){ window.location.href = "../settings/whatsNew.php"; }, 3000);
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
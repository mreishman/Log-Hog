function checkForUpdates()
{
	displayLoadingPopup();
	$.getJSON('../core/php/settingsCheckForUpdateAjax.php', {}, function(data) 
	{
		if(data.version == "1" || data.version == "2" | data.version == "3")
		{
			dataFromJSON = data;
			timeoutVar = setInterval(function(){checkForUpdateTimer();},3000);
		}
		else if (data.version == "0")
		{
			document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >No Update Needed</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>You are on the most current version</div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:25px;'>Okay!</div></div>";
		}
		else
		{
			document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Error</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An error occured while trying to check for updates. Make sure you are connected to the internet and settingsCheckForUpdate.php has sufficient rights to write / create files. </div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
		}
		
	});
}

function checkForUpdateTimer()
{
	$.getJSON('../core/php/configStaticCheck.php', {}, function(data) 
	{
		if(currentVersion != data)
		{
			clearInterval(timeoutVar);
			showPopupForUpdate();
		}
	});
}

function showPopupForUpdate()
{
	document.getElementById('noUpdate').style.display = "none";
	document.getElementById('minorUpdate').style.display = "none";
	document.getElementById('majorUpdate').style.display = "none";
	document.getElementById('NewXReleaseUpdate').style.display = "none";

	if(dataFromJSON.version == "1")
	{
		document.getElementById('minorUpdate').style.display = "block";
		document.getElementById('minorUpdatesVersionNumber').innerHTML = dataFromJSON.versionNumber;
	}
	else if (dataFromJSON.version == "2")
	{
		document.getElementById('majorUpdate').style.display = "block";
		document.getElementById('majorUpdatesVersionNumber').innerHTML = dataFromJSON.versionNumber;
	}
	else
	{
		document.getElementById('NewXReleaseUpdate').style.display = "block";
		document.getElementById('veryMajorUpdatesVersionNumber').innerHTML = dataFromJSON.versionNumber;
	}


	document.getElementById('releaseNotesHeader').style.display = "block";
	document.getElementById('releaseNotesBody').style.display = "block";
	document.getElementById('releaseNotesBody').innerHTML = dataFromJSON.changeLog;
	document.getElementById('settingsInstallUpdate').innerHTML = '<a class="link" onclick="installUpdates();">Install '+dataFromJSON.versionNumber+' Update</a>';


	//Update needed
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >New Version Available!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Version "+dataFromJSON.versionNumber+" is now available!</div><div class='link' onclick='installUpdates();' style='margin-left:74px; margin-right:50px;margin-top:25px;'>Update Now</div><div onclick='hidePopup();' class='link'>Maybe Later</div></div>";
}

function closePopupNoUpdate()
{
	document.getElementById("spanNumOfDaysUpdateSince").innerHTML = "0 Days";
	hidePopup();
}

function installUpdates()
{
	displayLoadingPopup();
	//reset vars in post request
	var urlForSend = '../core/php/resetUpdateFilesToDefault.php?format=json'
	var data = {status: "" };
	$.ajax(
	{
		url: urlForSend,
		dataType: 'json',
		data: data,
		type: 'POST',
		complete: function(data)
		{
			//set thing to check for updated files. 	
			timeoutVar = setInterval(function(){verifyChange();},3000);
	  	}
	});
}

function verifyChange()
{
	var urlForSend = '../update/updateActionCheck.php?format=json'
	var data = {status: "" };
	$.ajax(
	{
		url: urlForSend,
		dataType: 'json',
		data: data,
		type: 'POST',
		success: function(data)
		{
			if(data == 'finishedUpdate')
			{
				clearInterval(timeoutVar);
				actuallyInstallUpdates();
			}
	  	}
	});
}

function actuallyInstallUpdates()
{
	$("#settingsInstallUpdate").submit();
}
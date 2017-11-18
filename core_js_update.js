var urlSend = "";
var whatAmIUpdating = "";
var updateFormID = "settingsInstallUpdate";
var showPopupForUpdateBool = true;
var dontNotifyVersionNotSet = "";
var dataFromJSON = "";

function checkForUpdates(urlSend = "../", whatAmIUpdating = "Log-Hog", currentNewVersion = currentVersion, updateFormIDLocal = "settingsInstallUpdate", showPopupForUpdateInner = true, dontNotifyVersionInner = "")
{
	versionUpdate = currentNewVersion;
	urlSend = urlSend;
	whatAmIUpdating = whatAmIUpdating;
	updateFormID = updateFormIDLocal;
	showPopupForUpdateBool = showPopupForUpdateInner;
	dontNotifyVersionNotSet = dontNotifyVersionInner;
	if(showPopupForUpdateBool)
	{
		displayLoadingPopup();
	}
	$.getJSON(urlSend + "core/php/settingsCheckForUpdateAjax.php", {}, function(data) 
	{
		if(data.version == "1" || data.version == "2" | data.version == "3")
		{
			if(dontNotifyVersionNotSet === "" || dontNotifyVersionNotSet != data.versionNumber)
			{
				dataFromJSON = data;
				timeoutVar = setInterval(function(){checkForUpdateTimer(urlSend, whatAmIUpdating);},3000);
			}
		}
		else if (data.version == "0")
		{
			if(showPopupForUpdateBool)
			{
				document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >No Update For "+whatAmIUpdating+" </div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>You are on the most current version</div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:25px;'>Okay!</div></div>";
			}
		}
		else
		{
			if(showPopupForUpdateBool)
			{
				document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An error occured while trying to check for updates for "+whatAmIUpdating+". Make sure you are connected to the internet and settingsCheckForUpdate.php has sufficient rights to write / create files. </div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
			}
		}
		
	});
}

function checkForUpdateTimer(urlSend, whatAmIUpdating)
{
	whatAmIUpdating = whatAmIUpdating;
	$.getJSON(urlSend+"core/php/configStaticCheck.php", {}, function(data) 
	{
		if(versionUpdate != data)
		{
			clearInterval(timeoutVar);
			showPopupForUpdate(urlSend,whatAmIUpdating);
		}
	});
}

function showPopupForUpdate(urlSend,whatAmIUpdating)
{
	if(document.getElementById("noUpdate"))
	{
		document.getElementById("noUpdate").style.display = "none";
		document.getElementById("minorUpdate").style.display = "none";
		document.getElementById("majorUpdate").style.display = "none";
		document.getElementById("NewXReleaseUpdate").style.display = "none";

		if(dataFromJSON.version == "1")
		{
			document.getElementById("minorUpdate").style.display = "block";
			document.getElementById("minorUpdatesVersionNumber").innerHTML = dataFromJSON.versionNumber;
		}
		else if (dataFromJSON.version == "2")
		{
			document.getElementById("majorUpdate").style.display = "block";
			document.getElementById("majorUpdatesVersionNumber").innerHTML = dataFromJSON.versionNumber;
		}
		else
		{
			document.getElementById("NewXReleaseUpdate").style.display = "block";
			document.getElementById("veryMajorUpdatesVersionNumber").innerHTML = dataFromJSON.versionNumber;
		}
	

		document.getElementById("releaseNotesHeader").style.display = "block";
		document.getElementById("releaseNotesBody").style.display = "block";
		document.getElementById("releaseNotesBody").innerHTML = dataFromJSON.changeLog;
		document.getElementById("settingsInstallUpdate").innerHTML = '<a class="link" onclick="installUpdates();">Install '+dataFromJSON.versionNumber+' Update</a>';
	}

	//Update needed
	showPopup();
	var innerHtmlPopup = "<div class='settingsHeader' >New Version of "+whatAmIUpdating+" Available!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Version "+dataFromJSON.versionNumber+" is now available!</div><div class='link' onclick='installUpdates(\""+urlSend+"\");' style='margin-left:74px; margin-right:50px;margin-top:25px;'>Update Now</div>";
	if(dontNotifyVersionNotSet !== "")
	{
		innerHtmlPopup += "type='checkbox'>Don't notify me about this update again</div><input id='dontShowPopuForThisUpdateAgain'";
		if(dontNotifyVersion == dataFromJSON.versionNumber)
		{
			innerHtmlPopup += " checked ";
		}
		dontNotifyVersion = dataFromJSON.versionNumber;
		innerHtmlPopup += "type='checkbox'>Don't notify me about this update again</div>";
	}
	else
	{
		innerHtmlPopup += "<div onclick='saveSettingFromPopupNoCheckMaybe();' class='link'>Maybe Later</div>";
	}
	innerHtmlPopup += "</div>";
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = innerHtmlPopup;
}

function saveSettingFromPopupNoCheckMaybe()
{
	try
	{
		if(document.getElementById("dontShowPopuForThisUpdateAgain").checked)
		{
			var urlForSend = urlSend+"core/php/settingsSaveAjax.php?format=json";
			var data = {dontNotifyVersion};
			$.ajax({
				url: urlForSend,
				dataType: "json",
				data,
				type: "POST",
			complete(data){
				closePopupNoUpdate();
				},
			});
		}
		else
		{
			closePopupNoUpdate();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function closePopupNoUpdate()
{
	if(document.getElementById("spanNumOfDaysUpdateSince"))
	{
		document.getElementById("spanNumOfDaysUpdateSince").innerHTML = "0 Days";
	}
	hidePopup();
}

function installUpdates(urlSend = "../", updateFormIDLocal = "settingsInstallUpdate")
{
	if(updateFromID !== "settingsInstallUpdate")
	{
		updateFormIDLocal = updateFormID;
	}
	urlSend = urlSend;
	updateFormID = updateFormIDLocal;
	displayLoadingPopup();
	//reset vars in post request
	var urlForSend = urlSend + "core/php/resetUpdateFilesToDefault.php?format=json";
	var data = {status: "" };
	$.ajax(
	{
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		complete(data)
		{
			//set thing to check for updated files. 	
			timeoutVar = setInterval(function(){verifyChange(urlSend);},3000);
		}
	});
}

function verifyChange(urlSend)
{
	var urlForSend = urlSend + "update/updateActionCheck.php?format=json";
	var data = {status: "" };
	$.ajax(
	{
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			if(data == "finishedUpdate")
			{
				clearInterval(timeoutVar);
				actuallyInstallUpdates();
			}
		}
	});
}

function actuallyInstallUpdates()
{
	document.getElementById(updateFormID).submit();
}
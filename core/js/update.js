var urlSend = "";
var whatAmIUpdating = "";
var updateFormID = "settingsInstallUpdate";
var showPopupForUpdateBool = true;
var dontNotifyVersionNotSet = "";
var dataFromJSON = "";
var verifyCountSuccess = 0;
var verifyCheckCount = 0;
var totalCounter = 1;
var updateCheckFinished = false;

function checkForUpdates(urlSend = "../", whatAmIUpdating = "Log-Hog", currentNewVersion = currentVersion, updateFormIDLocal = "settingsInstallUpdate", showPopupForUpdateInner = true, dontNotifyVersionInner = "")
{
	try
	{
		versionUpdate = currentNewVersion;
		urlSend = urlSend;
		whatAmIUpdating = whatAmIUpdating;
		updateFormID = updateFormIDLocal;
		showPopupForUpdateBool = showPopupForUpdateInner;
		dontNotifyVersionNotSet = dontNotifyVersionInner;
		if(showPopupForUpdateBool)
		{
			if(whatAmIUpdating === "Log-Hog")
			{
				document.getElementById("checkForUpdateButton").style.display = "none";
				document.getElementById("progressBarUpdateCheck").style.display = "inline-block";
				document.getElementById("progressBarText").innerHTML = "Downloading version list file for "+whatAmIUpdating;
				document.getElementById("progressBarUpdateCheckActualBar").value = 50;
			}
			else
			{
				displayLoadingPopup();
			}
		}
		$.ajax({
			url: urlSend + "core/php/settingsCheckForUpdateAjax.php",
			dataType: "json",
			data: {},
			type: "POST",
			success(data)
			{
				updateCheckFinished = true;
				if(data.version == "-1")
				{
					//error occured, show that
					if(whatAmIUpdating === "Log-Hog")
					{
						document.getElementById("progressBarUpdateCheck").style.display = "none";
					}
					if(showPopupForUpdateBool)
					{
						if(data.error === "configStatic is not writeable")
						{
							window.location.href = "./error.php?error=12&page=File Permission Error";
						}
						else if(data.error === "could not create folder for tmp versionCheck data")
						{
							window.location.href = "./error.php?error=13&page=Folder Create Error";
						}
						else if(data.error === "error opening zip")
						{
							window.location.href = "./error.php?error=14&page=Error Opening Zip";
						}
						else
						{
							window.location.href = "./error.php?error=43&page=Update Error";
						}
					}
				}
				if(data.version == "1" || data.version == "2" | data.version == "3")
				{
					if(dontNotifyVersionNotSet === "" || dontNotifyVersionNotSet != data.versionNumber)
					{
						dataFromJSON = data;
						document.getElementById("progressBarText").innerHTML = "Verifying version list file for "+whatAmIUpdating+" "+totalCounter+"/"+verifyCheckCount+"/"+(successVerifyNum+1);
						timeoutVar = setInterval(function(){checkForUpdateTimer(urlSend, whatAmIUpdating);},3000);
					}
				}
				else if (data.version == "0")
				{
					if(showPopupForUpdateBool)
					{
						if(whatAmIUpdating === "Log-Hog")
						{
							document.getElementById("checkForUpdateButton").style.display = "inline-block";
							document.getElementById("progressBarUpdateCheck").style.display = "none";
							document.getElementById("progressBarText").innerHTML = "No Update For "+whatAmIUpdating;
						}
						else
						{
							document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >No Update For "+whatAmIUpdating+" </div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>You are on the most current version</div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:25px;'>Okay!</div></div>";
						}
					}
				}
				else
				{
					if(showPopupForUpdateBool)
					{
						if(whatAmIUpdating === "Log-Hog")
						{
							document.getElementById("checkForUpdateButton").style.display = "inline-block";
							document.getElementById("progressBarUpdateCheck").style.display = "none";
							document.getElementById("progressBarText").innerHTML = "An error occured while trying to check for updates for "+whatAmIUpdating+". Make sure you are connected to the internet and settingsCheckForUpdate.php has sufficient rights to write / create files.";
						}
						else
						{
							document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An error occured while trying to check for updates for "+whatAmIUpdating+". Make sure you are connected to the internet and settingsCheckForUpdate.php has sufficient rights to write / create files. </div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
						}
					}
				}
			},
			failure(data)
			{
				updateCheckFinished = true;
				window.location.href = "./error.php?error=43&page="+data;
			},
			complete(data)
			{
				if(whatAmIUpdating === "Log-Hog")
				{
					document.getElementById("progressBarUpdateCheck").style.display = "none";
				}
				if(updateCheckFinished !== true)
				{
					window.location.href = "./error.php?error=43&page=An Unknown Error Occured: Check ajax request response";
				}
				updateCheckFinished = false;
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkForUpdateTimer(urlSend, whatAmIUpdating)
{
	whatAmIUpdating = whatAmIUpdating;
	$.getJSON(urlSend+"core/php/configStaticCheck.php", {}, function(data) 
	{
		totalCounter++;
		if(showPopupForUpdateBool && whatAmIUpdating === "Log-Hog")
		{
			document.getElementById("progressBarText").innerHTML = "Verifying version list file for "+whatAmIUpdating+" "+totalCounter+"/"+verifyCheckCount+"/"+(successVerifyNum+1);
		}
		if(versionUpdate != data)
		{
			verifyCheckCount++;
			if(showPopupForUpdateBool && whatAmIUpdating === "Log-Hog")
			{
				document.getElementById("progressBarText").innerHTML = "Verifying version list file for "+whatAmIUpdating+" "+totalCounter+"/"+verifyCheckCount+"/"+(successVerifyNum+1);
				document.getElementById("progressBarUpdateCheckActualBar").value = 50+(50*(verifyCheckCount/(successVerifyNum+2)));
			}
			if(verifyCheckCount > successVerifyNum)
			{
				clearInterval(timeoutVar);
				showPopupForUpdate(urlSend,whatAmIUpdating);
			}
		}
		else
		{
			verifyCheckCount = 0;
			if(showPopupForUpdateBool && whatAmIUpdating === "Log-Hog")
			{
				document.getElementById("progressBarText").innerHTML = "Verifying version list file for "+whatAmIUpdating+" "+totalCounter+"/"+verifyCheckCount+"/"+(successVerifyNum+1);
			}
		}
	});
}

function showPopupForUpdate(urlSend,whatAmIUpdating)
{
	try
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
			document.getElementById("settingsInstallUpdate").innerHTML = "<a class=\"link\" onclick=\"installUpdates(\""+urlSend+"\");\">Install "+dataFromJSON.versionNumber+" Update</a>";
		}
		if(document.getElementById("checkForUpdateButton"))
		{
			document.getElementById("checkForUpdateButton").style.display = "inline-block";
			document.getElementById("progressBarUpdateCheck").style.display = "none";
			document.getElementById("progressBarText").innerHTML = "";
		}

		//Update needed
		if(document.getElementById("fullScreenMenu").style.display === "none")
		{
			showPopup();
			var innerHtmlPopup = "<div class='settingsHeader' >New Version of "+whatAmIUpdating+" Available!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Version "+dataFromJSON.versionNumber+" is now available!<br><br><div class='link' onclick='installUpdates(\""+urlSend+"\");'>Update Now</div>";
			if(dontNotifyVersionNotSet !== "")
			{
				innerHtmlPopup += "</div><br><input id='dontShowPopuForThisUpdateAgain'";
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
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = innerHtmlPopup;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function saveSettingFromPopupNoCheckMaybe()
{
	try
	{
		if(document.getElementById("dontShowPopuForThisUpdateAgain") && document.getElementById("dontShowPopuForThisUpdateAgain").checked)
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

function installUpdates(urlSend = "../", updateFormIDLocal = "settingsInstallUpdate", imgLocatin = "../")
{
	try
	{
		if(typeof pollTimer !== "undefined")
		{
			clearInterval(pollTimer);
		}
		if(typeof updateFromID !== "undefined" &&  updateFromID !== "settingsInstallUpdate")
		{
			updateFormIDLocal = updateFormID;
		}
		urlSend = urlSend;
		updateFormID = updateFormIDLocal;
		displayLoadingPopup(imgLocatin);
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
				verifyCountSuccess = 0;
				timeoutVar = setInterval(function(){verifyChange(urlSend);},3000);
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function verifyChange(urlSend)
{
	try
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
					verifyCountSuccess++;
					if(verifyCountSuccess >= successVerifyNum)
					{
						verifyCountSuccess = 0;
						clearInterval(timeoutVar);
						actuallyInstallUpdates();
					}
				}
				else
				{
					verifyCountSuccess = 0;
				}
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function actuallyInstallUpdates()
{
	try
	{
		document.getElementById(updateFormID).submit();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}
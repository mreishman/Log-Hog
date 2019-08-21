var urlSend = "";
var whatAmIUpdating = "";
var updateFormID = "settingsInstallUpdate";
var showPopupForUpdateBool = true;
var dontNotifyVersionNotSet = "";
var dataFromJSON = "";
var verifyCountSuccess = 0;
var verifyCheckCount = 0;
var totalCounter = 1;
var totalCounterInstall = 1;
var updateCheckFinished = true;
var checkForUpdatePoll = null;
var installUpdatePoll = null;

function updateInProgressPopup()
{
	//show popup for update check already in progress
	showPopup();
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Update Check in Progress</div><div style='width:100%;text-align:center;padding:10px;'> Log-Hog is already checking for an update. Please wait untill it is finished before trying to check for another udpate. </div><div class='link' onclick='hidePopup();' style='margin-left:165px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
}

function checkForUpdates(urlSend = "../", whatAmIUpdating = "Log-Hog", currentNewVersion = currentVersion, updateFormIDLocal = "settingsInstallUpdate", showPopupForUpdateInner = true, dontNotifyVersionInner = "")
{
	try
	{
		if(updateCheckFinished)
		{
			updateCheckFinished = false;
		}
		else
		{
			updateInProgressPopup();
			return;
		}
		versionUpdate = currentNewVersion;
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
				displayLoadingPopup(urlSend, "Checking For Update");
			}
		}
		$.ajax({
			url: urlSend + "core/php/settingsCheckForUpdateAjax.php",
			dataType: "json",
			data: {formKey},
			type: "POST",
			success(data)
			{
				if(typeof data === "object"  && "error" in data)
	            {
	                window.location.href = urlSend + "error.php?error="+data["error"]+"&page=settingsCheckForUpdateAjax.php";
	            }
	            else if(typeof data === "string" && data.indexOf("error:") > -1)
	            {
	            	data = JSON.parse(data);
	            	window.location.href = urlSend + "error.php?error="+data["error"]+"&page=settingsCheckForUpdateAjax.php";
	            }
				else if(checkForUpdatePoll !== null)
				{
					updateInProgressPopup();
				}
				else
				{
					if(data.version == "-1")
					{
						updateCheckFinished = true;
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
								window.location.href = "./error.php?error=17&page=Error Opening Zip";
							}
							else if(data.error === "empty zip")
							{
								window.location.href = "./error.php?error=16&page=Error Copying Files From Zip";
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
							if(document.getElementById("progressBarText"))
							{
								document.getElementById("progressBarText").innerHTML = "Verifying version list file for "+whatAmIUpdating+" "+totalCounter+"/"+verifyCheckCount+"/"+(successVerifyNum);
							}
							totalCounter = 1;
							checkForUpdatePoll = setInterval(function(){checkForUpdateTimer(urlSend, whatAmIUpdating);},3000);
						}
					}
					else if (data.version == "0")
					{
						updateCheckFinished = true;
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
						updateCheckFinished = true;
						if(showPopupForUpdateBool)
						{
							if(whatAmIUpdating === "Log-Hog")
							{
								document.getElementById("checkForUpdateButton").style.display = "inline-block";
								document.getElementById("progressBarUpdateCheck").style.display = "none";
								document.getElementById("progressBarText").innerHTML = "An error occured while trying to check for updates for "+whatAmIUpdating+". Make sure you are connected to the internet and settingsCheckForUpdateAjax.php has sufficient rights to write / create files.";
							}
							else
							{
								document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An error occured while trying to check for updates for "+whatAmIUpdating+". Make sure you are connected to the internet and settingsCheckForUpdateAjax.php has sufficient rights to write / create files. </div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
							}
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
					if(dataFromJSON === "")
					{
						document.getElementById("progressBarUpdateCheck").style.display = "none";
						document.getElementById("checkForUpdateButton").style.display = "inline-block";
					}
				}
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
	if(showPopupForUpdateBool && whatAmIUpdating === "Log-Hog")
	{
		if(document.getElementById("progressBarUpdateCheck").style.display === "none")
		{
			document.getElementById("progressBarUpdateCheck").style.display = "block";
		}
	}
	$.getJSON(urlSend+"core/php/configStaticCheck.php", {}, function(data)
	{
		if(typeof data === "object"  && "error" in data)
		{
			window.location.href = urlSend + "error.php?error="+data["error"]+"&page=configStaticCheck.php";
			return;
		}
		else if(typeof data === "string" && data.indexOf("error:") > -1)
        {
        	data = JSON.parse(data);
        	window.location.href = urlSend + "error.php?error="+data["error"]+"&page=configStaticCheck.php";
        	return;
        }
		totalCounter++;
		if(showPopupForUpdateBool && whatAmIUpdating === "Log-Hog")
		{
			document.getElementById("progressBarText").innerHTML = "Verifying version list file for "+whatAmIUpdating+" "+totalCounter+"/"+verifyCheckCount+"/"+(successVerifyNum);
		}
		if(versionUpdate != data)
		{
			verifyCheckCount++;
			if(showPopupForUpdateBool && whatAmIUpdating === "Log-Hog")
			{
				document.getElementById("progressBarText").innerHTML = "Verifying version list file for "+whatAmIUpdating+" "+totalCounter+"/"+verifyCheckCount+"/"+(successVerifyNum);
				document.getElementById("progressBarUpdateCheckActualBar").value = 50+(50*(verifyCheckCount/(successVerifyNum+1)));
			}
			if(verifyCheckCount >= successVerifyNum)
			{
				updateCheckFinished = true;
				clearIntervalUpdate();
				if(whatAmIUpdating === "Log-Hog")
				{
					showPopupForUpdate(urlSend,whatAmIUpdating);
				}
				else
				{
					//inner addon update
					hidePopup();
					$.get( "core/php/template/innerAddon.php", function( data ) {
						$("#innerAddonSpanReplace").html(data);
					});
				}
			}
		}
		else
		{
			verifyCheckCount = 0;
			if(showPopupForUpdateBool && whatAmIUpdating === "Log-Hog")
			{
				document.getElementById("progressBarText").innerHTML = "Verifying version list file for "+whatAmIUpdating+" "+totalCounter+"/"+verifyCheckCount+"/"+(successVerifyNum);
			}
		}

		if(totalCounter > 30)
		{
			updateCheckFinished = true;
			clearIntervalUpdate();
		}
	});
}

function clearIntervalUpdate()
{
	clearInterval(checkForUpdatePoll);
	checkForUpdatePoll = null;
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

			document.getElementById("installDataDownloadSize").innerHTML = dataFromJSON.downloadTotal;
			document.getElementById("installDataCurrentFree").innerHTML = dataFromJSON.currentAmmtFree;
			document.getElementById("installDataTotalChange").innerHTML = dataFromJSON.totalSizeChange;
			document.getElementById("installData").style.display = "block";
		}
		if(document.getElementById("checkForUpdateButton"))
		{
			document.getElementById("checkForUpdateButton").style.display = "inline-block";
			if(document.getElementById("progressBarText"))
			{
				document.getElementById("progressBarUpdateCheck").style.display = "none";
				document.getElementById("progressBarText").innerHTML = "";
			}
		}
		if(document.getElementById("update"))
		{
			var newSrc = updateIconRedSrc;
			if(dataFromJSON.version == "1")
			{
				newSrc = updateIconYellowSrc;
			}
			if(document.getElementById("update").src !== newSrc)
			{
				document.getElementById("update").src = newSrc;
			}
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
			var data = {dontNotifyVersion, formKey};
			$.ajax({
				url: urlForSend,
				dataType: "json",
				data,
				type: "POST",
				success(data){
					if(typeof data === "object"  && "error" in data)
		            {
		                window.location.href = urlSend + "error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
		            }
		            else if(typeof data === "string" && data.indexOf("error:") > -1)
		            {
		            	data = JSON.parse(data);
		            	window.location.href = urlSend + "error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
		            }
				},
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
		totalCounterInstall = 1;
		urlSend = urlSend;
		updateFormID = updateFormIDLocal;
		displayLoadingPopup(imgLocatin);
		//reset vars in post request
		var urlForSend = urlSend + "core/php/resetUpdateFilesToDefault.php?format=json";
		var data = {status: "" , formKey};
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				if(typeof data === "object"  && "error" in data)
	            {
	                window.location.href = urlSend + "error.php?error="+data["error"]+"&page=resetUpdateFilesToDefault.php";
	            }
	            else if(typeof data === "string" && data.indexOf("error:") > -1)
	            {
	            	data = JSON.parse(data);
	            	window.location.href = urlSend + "error.php?error="+data["error"]+"&page=resetUpdateFilesToDefault.php";
	            }
			},
			complete(data)
			{
				verifyCountSuccess = 0;
				installUpdatePoll = setInterval(function(){verifyChange(urlSend);},3000);
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
		var data = {status: "" , formKey};
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				if(typeof data === "object"  && "error" in data)
	            {
	                window.location.href = urlSend + "error.php?error="+data["error"]+"&page=updateActionCheck.php";
	            }
	            else if(typeof data === "string" && data.indexOf("error:") > -1)
	            {
	            	data = JSON.parse(data);
	            	window.location.href = urlSend + "error.php?error="+data["error"]+"&page=updateActionCheck.php";
	            }
				else if(data == "finishedUpdate")
				{
					verifyCountSuccess++;
					if(verifyCountSuccess > successVerifyNum)
					{
						verifyCountSuccess = 0;
						clearInterval(installUpdatePoll);
						actuallyInstallUpdates();
					}
				}
				else
				{
					verifyCountSuccess = 0;
				}
			},
			failure(data)
			{
				if(totalCounterInstall > 30)
				{
					//error message
					clearInterval(installUpdatePoll);
					showPopup();
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An error occured while trying to check for updates for "+whatAmIUpdating+". Make sure you are connected to the internet and settingsCheckForUpdate.php has sufficient rights to write / create files. </div><div class='link' onclick='closePopupNoUpdate();' style='margin-left:165px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
				}
			},
			complete(data)
			{
				totalCounterInstall++;
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
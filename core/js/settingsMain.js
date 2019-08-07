function changeDescriptionLineSize()
{
	try
	{
		var valueForDesc = document.getElementById("logTrimTypeToggle").value;

		if (valueForDesc === "lines")
		{
			document.getElementById("logTrimTypeText").innerHTML = "Lines";
		}
		else if (valueForDesc === "size")
		{
			document.getElementById("logTrimTypeText").innerHTML = document.getElementById("TrimSize").value;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function updateJsonForPopupTheme()
{
	setTimeout(function() {
			updateJsonForPopupThemeInner();
		}, 2);
}

function updateJsonForPopupThemeInner()
{
	var saveSettingsVar = document.getElementById("popupsaveSettings").value;
	var blankFolderVar = document.getElementById("popupblankFolder").value;
	var deleteLogVar = document.getElementById("popupdeleteLog").value;
	var removeFolderVar = document.getElementById("popupremoveFolder").value;
	var versionCheckVar = document.getElementById("popupversionCheck").value;
	var popupSelectValue = document.getElementById("popupSelect").value;
	var toSet = "true";
	if(popupSelectValue === "none")
	{
		toSet = "false";
	}
	if(popupSelectValue === "all" || popupSelectValue === "none")
	{
		saveSettingsVar = toSet;
		blankFolderVar = toSet;
		deleteLogVar = toSet;
		removeFolderVar = toSet;
		versionCheckVar = toSet;
	}

	var objectToSave = {
		saveSettings :saveSettingsVar,
		blankFolder:blankFolderVar,
		deleteLog:deleteLogVar,
		removeFolder:removeFolderVar,
		versionCheck:versionCheckVar
	};
	document.getElementById("popupSettingsArray").value = JSON.stringify(objectToSave);
}

function updateJsonForCustomDateFormat()
{
	setTimeout(function() {
			updateJsonForCustomDateFormatInner();
		}, 2);
}

function updateJsonForCustomDateFormatInner()
{
	var objectToSave = "";
	var counterForJsonObjectDate = 0;
	while(document.getElementById("DateFormat-"+counterForJsonObjectDate+"-M"))
	{
		var del1 = document.getElementById("DateFormat-"+counterForJsonObjectDate+"-D1").value;
		if(del1 === "space")
		{
			del1 = " ";
		}
		else if(del1 === "none")
		{
			del1 = "";
		}
		var del2 = document.getElementById("DateFormat-"+counterForJsonObjectDate+"-D2").value;
		if(del2 === "space")
		{
			del2 = " ";
		}
		else if(del2 === "none")
		{
			del2 = "";
		}
		var mainFormatVal = document.getElementById("DateFormat-"+counterForJsonObjectDate+"-M").value;
		if(mainFormatVal === "none")
		{
			mainFormatVal = "";
		}
		objectToSave += "" + del1 + "" + mainFormatVal + "" + del2 + "";
		if(document.getElementById("DateFormat-"+(counterForJsonObjectDate + 1)+"-M"))
		{
			objectToSave += "|";
		}
		counterForJsonObjectDate++;
	}

	document.getElementById("dateTextFormatCustom").value = objectToSave;
}

function selectLogPopup(locationForNewLogText)
{
	var selctor = locationForNewLogText.split("-");
	var currentWindow = 0;
	var arrayOfAlreadySelectedLogs = [];
	while(typeof document.getElementsByName(selctor[0]+"-"+currentWindow+"-"+selctor[2])[0] !== "undefined")
	{
		arrayOfAlreadySelectedLogs.push(document.getElementsByName(selctor[0]+"-"+currentWindow+"-"+selctor[2])[0].value);
		currentWindow++;
	}
	displayLoadingPopup(urlModifierForAjax , "Generating List");
	var urlForSend = urlModifierForAjax + "core/php/pollCheck.php?format=json";
	var data = {formKey};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data && data["error"] === 18)
			{
				window.location.href =urlModifierForAjax + "error.php?error=18&page=pollCheck.php";
				return;
			}
			else if(typeof data === "object"  && "error" in data && data["error"] === 14)
			{
				window.location.href =urlModifierForAjax + "error.php?error=14&page=pollCheck.php";
				return;
			}
			data["oneLog"] = {};
			var popupFileList = Object.keys(data);
			var popupFileListLength = popupFileList.length;
			var htmlForPopup = "";
			var counter = 0;
			htmlForPopup += "<div class=\"selectDiv\"><select id=\"newLogSelectionFromPopup\" ><option value=\"\" >None</option>";
			for(var i = 0; i < popupFileListLength; i++)
			{
				if(arrayOfAlreadySelectedLogs.indexOf(popupFileList[i]) === -1)
				{
					htmlForPopup += "<option value=\""+popupFileList[i]+"\">"+popupFileList[i]+"</option>";
					counter++;
				}
			}
			htmlForPopup += "</select></div>";
			htmlForPopup = "<div class='settingsHeader' >Select Log:</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+htmlForPopup+"</div><div class='link' onclick='selectLog(\""+locationForNewLogText+"\")' style='margin-left:100px; margin-right:50px;margin-top:25px;'>Select</div><div onclick='hidePopup();' class='link'>Close</div></div>";
			if(counter === 0)
			{
				htmlForPopup = "<div class='settingsHeader' >No Logs:</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>There are not logs to select</div><div onclick='hidePopup();' class='link'>Close</div></div>";
			}
			document.getElementById('popupContentInnerHTMLDiv').innerHTML = htmlForPopup;
		}
	});
}

function selectLog(locationForNewLogText)
{
	if(document.getElementById("newLogSelectionFromPopup").value === "")
	{
		document.getElementById(locationForNewLogText).innerHTML = "No Log Selected";
	}
	else
	{
		document.getElementById(locationForNewLogText).innerHTML = document.getElementById("newLogSelectionFromPopup").value;
	}
	document.getElementsByName(locationForNewLogText)[0].value = document.getElementById("newLogSelectionFromPopup").value;
	if(document.getElementById("unselectLogButton"+locationForNewLogText))
	{
		document.getElementById("unselectLogButton"+locationForNewLogText).style.display = "inline-block";
	}

	hidePopup();
}

function unselectLog(locationForNewLogText)
{
	document.getElementById(locationForNewLogText).innerHTML = "No Log Selected";
	document.getElementsByName(locationForNewLogText)[0].value = "";
	if(document.getElementById("unselectLogButton"+locationForNewLogText))
	{
		document.getElementById("unselectLogButton"+locationForNewLogText).style.display = "none";
	}
}

function toggleUpdateDisplayCheck()
{
	updateJsonForPopupTheme();
	showOrHidePopupSubWindow();
}

function toggleUpdateLogFormat()
{
	//add json update here
	updateJsonForCustomDateFormat();
	showOrHideLogFormat();
}

function showLayoutOptions(classAdd)
{
	$(".logLayoutShowAll"+classAdd).hide();
	$(".logLayoutHideAll").show();
	$(".innerWindowDisplayLoadLayout"+classAdd).show();
	$(".innerWindowDisplayLoadLayoutHidden"+classAdd).hide();
}

function hideLayoutOptionsAll()
{
	$(".logLayoutShowAll").show();
	$(".logLayoutHideAll").hide();
	$(".innerWindowDisplayLoadLayout").hide();
	$(".innerWindowDisplayLoadLayoutHidden").show();
}
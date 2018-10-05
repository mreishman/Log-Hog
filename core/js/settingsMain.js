var titleOfPage = "Main";

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

function showOrHideSubWindow(valueForPopupInner, valueForVarsInner, valueToCompare)
{
	try
	{
		if(valueForPopupInner.value === valueToCompare)
		{
			valueForVarsInner.style.display = "block";
		}
		else
		{
			valueForVarsInner.style.display = "none";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


function checkIfChanges()
{
	var arrayToCheck = new Array();
	if(document.getElementById("settingsMenuVars"))
	{
		arrayToCheck.push("settingsMenuVars");
	}
	if(document.getElementById("settingsMainVars"))
	{
		arrayToCheck.push("settingsMainVars");
	}
	if(document.getElementById("settingsLogVars"))
	{
		arrayToCheck.push("settingsLogVars");
	}
	if(document.getElementById("settingsPollVars"))
	{
		arrayToCheck.push("settingsPollVars");
	}
	if(document.getElementById("settingsFilterVars"))
	{
		arrayToCheck.push("settingsFilterVars");
	}
	if(document.getElementById("archiveConfig"))
	{
		arrayToCheck.push("archiveConfig");
	}
	if(document.getElementById("settingsUpdateVars"))
	{
		arrayToCheck.push("settingsUpdateVars");
	}
	if(document.getElementById("settingsWatchlistVars"))
	{
		arrayToCheck.push("settingsWatchlistVars");
	}
	if(document.getElementById("settingsMultiLogVars"))
	{
		arrayToCheck.push("settingsMultiLogVars");
	}
	if(document.getElementById("settingsInitialLoadLayoutVars"))
	{
		arrayToCheck.push("settingsInitialLoadLayoutVars");
	}
	if(	checkForChangesArray(arrayToCheck))
	{
		return true;
	}
	return false;
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

function selectLogPopup(locationForNewLogText)
{
	displayLoadingPopup();
	var urlForSend = "../core/php/pollCheck.php?format=json";
	var data = {};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			var popupFileList = Object.keys(data);
			var popupFileListLength = popupFileList.length;
			var htmlForPopup = "";
			htmlForPopup += "<div class=\"selectDiv\"><select id=\"newLogSelectionFromPopup\" ><option value=\"\" >None</option>";
			for(var i = 0; i < popupFileListLength; i++)
			{
				var fileName = popupFileList[i];
				htmlForPopup += "<option value=\""+popupFileList[i]+"\">"+popupFileList[i]+"</option>";
			}
			htmlForPopup += "</select></div>";
			document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Select Log:</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+htmlForPopup+"</div><div class='link' onclick='selectLog(\""+locationForNewLogText+"\")' style='margin-left:100px; margin-right:50px;margin-top:25px;'>Select</div><div onclick='hidePopup();' class='link'>Close</div></div>";
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

$( document ).ready(function()
{
	var arrayToRefresh = new Array();
	if(document.getElementById("settingsLogVars"))
	{
		arrayToRefresh.push("settingsLogVars");
	}
	if(document.getElementById("settingsPollVars"))
	{
		arrayToRefresh.push("settingsPollVars");
	}
	if(document.getElementById("settingsFilterVars"))
	{
		arrayToRefresh.push("settingsFilterVars");
	}
	if(document.getElementById("archiveConfig"))
	{
		arrayToRefresh.push("archiveConfig");
	}
	if(document.getElementById("settingsUpdateVars"))
	{
		arrayToRefresh.push("settingsUpdateVars");
	}
	if(document.getElementById("settingsMenuVars"))
	{
		arrayToRefresh.push("settingsMenuVars");
	}
	if(document.getElementById("settingsWatchlistVars"))
	{
		arrayToRefresh.push("settingsWatchlistVars");
	}
	if(document.getElementById("settingsMainVars"))
	{
		arrayToRefresh.push("settingsMainVars");
	}
	if(document.getElementById("settingsMultiLogVars"))
	{
		arrayToRefresh.push("settingsMultiLogVars");
	}
	if(document.getElementById("settingsInitialLoadLayoutVars"))
	{
		arrayToRefresh.push("settingsInitialLoadLayoutVars");
	}
	refreshArrayObjectOfArrays(arrayToRefresh);

	document.addEventListener(
		"scroll",
		function (event)
		{
			onScrollShowFixedMiniBar(arrayToRefresh);
		},
		true
	);

	setInterval(poll, 100);
});
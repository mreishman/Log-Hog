var titleOfPage = "Main";

function showOrHideLogTrimSubWindow()
{
	try
	{
		var valueForPopup = document.getElementById("logTrimOn");
		var valueForVars = document.getElementById("settingsLogTrimVars");
		showOrHideSubWindow(valueForPopup, valueForVars);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHideSideBarSettings()
{
	try
	{
		var valueForPopup = document.getElementById("bottomBarIndexShow");
		var valueForVars = document.getElementById("sidebarContentSettings");
		showOrHideSubWindow(valueForPopup, valueForVars);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


function changeDescriptionLineSize()
{
	try
	{
		var valueForDesc = document.getElementById("logTrimTypeToggle").value;

		if (valueForDesc === "lines")
		{
			document.getElementById("logTrimTypeText").innerHTML = "Lines";
			document.getElementById("LiForlogTrimSize").style.display = "none";
		}
		else if (valueForDesc === "size")
		{
			document.getElementById("logTrimTypeText").innerHTML = document.getElementById("TrimSize").value;
			document.getElementById("LiForlogTrimSize").style.display = "block";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHidePopupSubWindow()
{
	try
	{
		showOrHideSubWindow(document.getElementById("popupSelect"), document.getElementById("settingsPopupVars"));
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHideUpdateSubWindow()
{
	try
	{
		showOrHideSubWindow(document.getElementById("settingsSelect"), document.getElementById("settingsAutoCheckVars"));
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHideFilterContentSettings()
{
	try
	{
		showOrHideSubWindow(document.getElementById("filterContentLimit"), document.getElementById("filterContentSettings"));
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHideFilterHighlightSettings()
{
	try
	{
		showOrHideSubWindow(document.getElementById("filterContentHighlight"), document.getElementById("highlightContentSettings"));
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHideScrollLogSettings()
{
	try
	{
		showOrHideSubWindow(document.getElementById("scrollOnUpdate"), document.getElementById("scrollLogOnUpdateSettings"));
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHideHighlightNewLinesSettings()
{
	try
	{
		showOrHideSubWindow(document.getElementById("highlightNew"), document.getElementById("highlightNewSettings"));
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


function showOrHideSubWindow(valueForPopupInner, valueForVarsInner)
{
	try
	{
		if((valueForPopupInner.value === "true") || (valueForPopupInner.value === "custom"))
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
	if(document.getElementById("settingsUpdateVars"))
	{
		arrayToCheck.push("settingsUpdateVars");
	}
	if(document.getElementById("settingsFilterVars"))
	{
		arrayToCheck.push("settingsFilterVars");
	}
	if(document.getElementById("settingsWatchlistVars"))
	{
		arrayToCheck.push("settingsWatchlistVars");
	}
	if(document.getElementById("settingsMultiLogVars"))
	{
		arrayToCheck.push("settingsMultiLogVars");
	}

	if(	checkForChangesArray(arrayToCheck))
	{
		return true;
	}
	return false;
}

function updateJsonForPopupTheme()
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
	hidePopup();
}

$( document ).ready(function()
{
	if(document.getElementById("popupSelect"))
	{
		$("#popupSelect").on("keydown change", function(){
			var box = $(this);
			setTimeout(function() {
				updateJsonForPopupTheme();
			}, 2);
			showOrHidePopupSubWindow();
		});
	}
	if(document.getElementById("settingsSelect"))
	{
		document.getElementById("settingsSelect").addEventListener("change", showOrHideUpdateSubWindow, false);
	}
	if(document.getElementById("logTrimTypeToggle"))
	{
		document.getElementById("logTrimTypeToggle").addEventListener("change", changeDescriptionLineSize, false);
	}
	if(document.getElementById("logTrimOn"))
	{
		document.getElementById("logTrimOn").addEventListener("change", showOrHideLogTrimSubWindow, false);
	}
	if(document.getElementById("filterContentHighlight"))
	{
		document.getElementById("filterContentHighlight").addEventListener("change", showOrHideFilterHighlightSettings, false);
	}

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
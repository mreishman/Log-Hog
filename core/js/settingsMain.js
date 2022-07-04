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
		console.log(e);
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
	setTimeout(function() {
		generateTimestampExample();
	}, 2);
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
	var urlForSend = urlModifierForAjax + "core/php/post/pollCheck.php?format=json";
	var data = {formKey};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			if (handleError(urlModifierForAjax, data, "pollCheck.php"))
			{
				return;
			}
			data["oneLog"] = {};
			var popupFileList = Object.keys(data);
			var popupFileListLength = popupFileList.length;
			var htmlForPopup = "";
			var counter = 0;
			htmlForPopup += "<div class=\"selectDiv\"><select autocomplete=\"off\" id=\"newLogSelectionFromPopup\" ><option value=\"\" >None</option>";
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
	let selectLogText = "No Log Selected";
	if(document.getElementById("newLogSelectionFromPopup").value !== "")
	{
		selectLogText = document.getElementById("newLogSelectionFromPopup").value;
	}
	document.getElementById(locationForNewLogText).innerHTML = selectLogText;

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

function addNewFilePathAlternativeRow(newRowPos, originalValue, newValue)
{
	let groupId = 'filePathAlternativeSettings';
	let tableId = 'addNewRowToThisForFilePathAlternatives';
	let inputId = 'filePathAlternatives';
	addNewFilePathAlternativeRowBase(newRowPos, originalValue, newValue, groupId, tableId, inputId);
}

function addNewFilePathViewAlternativeRow(newRowPos, originalValue, newValue)
{
	let groupId = 'filePathViewAlternativeSettings';
	let tableId = 'addNewRowToThisForFilePathViewAlternatives';
	let inputId = 'filePathViewAlternatives';
	addNewFilePathAlternativeRowBase(newRowPos, originalValue, newValue, groupId, tableId, inputId);
}

function addNewFilePathAlternativeRowBase(newRowPos, originalValue, newValue, groupId, tableId, inputId)
{
	let newRow = "<tr class=\"generatedRow\" >"+$("#"+groupId+" .settingsTemplateHolder tr").html()+"</tr>";
	if(newRowPos === -1)
	{
		newRowPos = $('#'+tableId+' tr').length;
	}
	newRow = newRow.replace(/{{i}}/g, newRowPos);
	newRow = newRow.replace(/{{original_value}}/g, originalValue);
	newRow = newRow.replace(/{{new_value}}/g, newValue);
	$('#'+tableId+' tr:last').after(newRow);
	updateJsonStringOfFilePathAlternativesMain(inputId, tableId);
}

function removeFilePathAlternativeRow(rowNumber)
{
	let groupId = 'filePathAlternativeSettings';
	let tableId = 'addNewRowToThisForFilePathAlternatives';
	let inputId = 'filePathAlternatives';
	removeFilePathAlternativeRowBase(rowNumber, groupId, tableId, inputId);
}

function removeFilePathViewAlternativeRow(rowNumber)
{
	let groupId = 'filePathViewAlternativeSettings';
	let tableId = 'addNewRowToThisForFilePathViewAlternatives';
	let inputId = 'filePathViewAlternatives';
	removeFilePathAlternativeRowBase(rowNumber, groupId, tableId, inputId);
}

function removeFilePathAlternativeRowBase(rowNumber, groupId, tableId, inputId)
{
	//remove from table
	$("#"+tableId+" .generatedRow").remove();
	//remove from json (generate new json array)
	let values = JSON.parse($("#"+inputId).val());
	let newValues = [];
	let valuesLength = values.length;
	let minusOne = false;
	for(i = 0; i < valuesLength; i++)
	{
		let locVal = values[i];
		let rowICheck = Math.ceil((i+1)/2);
		let oCheck = "path["+rowNumber+"][original]";
		let nCheck = "path["+rowNumber+"][new]";
		if(locVal["name"] === oCheck || locVal["name"] === nCheck)
		{
			minusOne = true;
			continue;
		}
		if(minusOne)
		{
			//reduce number by 1
			locVal["name"] = locVal["name"].replace("["+rowICheck+"]", "["+(rowICheck - 1)+"]");
		}
		newValues.push(locVal)
	}

	let newValuesLength = newValues.length;
	if(newValuesLength > 0)
	{
		//rebuild display table
		for(i = 0; i < newValuesLength; i = i + 2)
		{
			let rowICheck = Math.ceil((i+1)/2);
			addNewFilePathAlternativeRowBase(rowICheck, newValues[i]["value"], newValues[(i+1)]["value"], groupId, tableId, inputId)
		}
		updateJsonStringOfFilePathAlternativesMain(inputId, tableId);
	}
	else
	{
		$("#"+inputId).val("");
	}
}

function updateJsonStringOfFilePathAlternatives()
{
	updateJsonStringOfFilePathAlternativesMain('filePathAlternatives', 'addNewRowToThisForFilePathAlternatives');
}

function updateJsonStringOfFilePathViewAlternatives()
{
	updateJsonStringOfFilePathAlternativesMain('filePathViewAlternatives', 'addNewRowToThisForFilePathViewAlternatives');
}

function updateJsonStringOfFilePathAlternativesMain(inputId, tableId)
{
	$("#"+inputId).val(JSON.stringify($("#"+tableId+" input").serializeArray()));
}
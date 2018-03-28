var titleOfPage = "Watchlist";

function generateRow(data)
{
	var fileTypeIsFolder = false;
	if(data["fileType"] === "folder")
	{
		fileTypeIsFolder = true;
	}
	var fileTypeIsFile = false;
	if(data["fileType"] === "file")
	{
		fileTypeIsFile = true;
	}
	var item = $("#storage .saveBlock").html();
	item = item.replace(/{{rowNumber}}/g, data["rowNumber"]);
	item = item.replace(/{{fileNumber}}/g, data["fileNumber"]);
	item = item.replace(/{{filePermsDisplay}}/g, data["filePermsDisplay"]);
	item = item.replace(/{{fileImage}}/g, data["fileImage"]);
	item = item.replace(/{{location}}/g, data["location"]);
	item = item.replace(/{{pattern}}/g, data["pattern"]);
	item = item.replace(/{{key}}/g, data["key"]);
	item = item.replace(/{{recursiveOptions}}/g, generateTrueFalseSelect(data["recursive"]));
	item = item.replace(/{{excludeTrimOptions}}/g, generateTrueFalseSelect(data["excludeTrim"]));
	item = item.replace(/{{typefile}}/g, displayNoneIfTrue(fileTypeIsFile));
	item = item.replace(/{{typefolder}}/g, displayNoneIfTrue(fileTypeIsFolder));
	item = item.replace(/{{FileTypeOptions}}/g, generateFileTypeSelect(data["fileType"]));
	item = item.replace(/{{filesInFolder}}/g, data["filesInFolder"]);
	item = item.replace(/{{AutoDeleteFiles}}/g, data["AutoDeleteFiles"]);
	item = item.replace(/{{FileInformation}}/g, data["FileInformation"]);
	item = item.replace('FileInformation" value="', 'FileInformation" value=\'');
	item = item.replace('"></ul></div>', '\'></ul></div>');	
	item = item.replace(/{{Group}}/g, data["Group"]);
	item = item.replace(/{{Name}}/g, data["Name"]);
	item = item.replace(/{{AlertEnabled}}/g, generateTrueFalseSelect(data["AlertEnabled"]));
	return item;
}

function displayNoneIfTrue(selectValue)
{
	if(selectValue)
	{
		return "style=\"display: none;\"";
	}
	return "";
}

function generateFileTypeSelect(selectValue)
{
	var selectHtml = "";
	selectHtml += "<option value=\"file\" ";
	if(selectValue === "file")
	{
		selectHtml += " selected ";
	}
	selectHtml += " >File</option>";
	selectHtml += "<option value=\"folder\" ";
	if(selectValue === "folder")
	{
		selectHtml += " selected ";
	}
	selectHtml += " >Folder</option>";
	selectHtml += "<option value=\"other\" ";
	if(selectValue !== "file" && selectValue !== "folder")
	{
		selectHtml += " selected ";
	}
	selectHtml += " >Other</option>";
	return selectHtml;
}

function generateTrueFalseSelect(selectValue)
{
	var selectHtml = "";
	selectHtml += "<option value=\"true\" ";
	if(selectValue === "true")
	{
		selectHtml += " selected ";
	}
	selectHtml += " >True</option>";
	selectHtml += "<option value=\"false\" ";
	if(selectValue !== "true")
	{
		selectHtml += " selected ";
	}
	selectHtml += " >False</option>";
	return selectHtml;
}

function addFile()
{
	addRowFunction(
		{
			fileType: "file"
		}
	);
} 

function addFolder()
{
	addRowFunction(
		{
			fileType: "folder"
		}
	);
}

function addOther()
{
	addRowFunction(
		{
			fileType: "other"
		}
	);
}

function addRowFunction(data)
{
	try
	{
		var countOfWatchList = parseInt(document.getElementById("numberOfRows").value);
		countOfWatchList++;

		var fileName = ""+countOfWatchList;
		if(countOfWatchList < 10)
		{
			fileName = "0"+fileName;
		}
		var fileTypeFromData = "other";
		if("fileType" in data)
		{
			fileTypeFromData = data["fileType"];
		}
		var filesInFolderFromData = "<li>Unknown files in folder</li>";
		if("filesInFolder" in data)
		{
			filesInFolderFromData = data["filesInFolder"];
		}
		var locationFromData = "";
		if("location" in data)
		{
			locationFromData = data["location"];
		}

		var patternFromData = defaultNewAddPattern;
		if("pattern" in data)
		{
			patternFromData = data["pattern"];
		}

		var item = generateRow(
			{
				rowNumber: countOfWatchList,
				fileNumber: fileName,
				filePermsDisplay: "----------",
				fileImage: "",
				location: locationFromData,
				pattern: patternFromData,
				key: "Log "+countOfWatchList,
				recursive: defaultNewAddRecursive,
				excludeTrim: defaultNewAddExcludeTrim,
				fileType: fileTypeFromData,
				filesInFolder: filesInFolderFromData,
				AutoDeleteFiles: defaultNewAddAutoDeleteFiles,
				FileInformation: "{}",
				Group: "",
				Name: "",
				AlertEnabled: defaultdefaultNewAddAlertEnabled
			}
		);
		$(".uniqueClassForAppendSettingsMainWatchNew").append(item);
		document.getElementById("numberOfRows").value = countOfWatchList;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function splitFilesPopup(currentRow, keyName = "")
{
	try
	{
		if("removeFolder" in popupSettingsArray && popupSettingsArray.removeFolder === "true")
		{
			showPopup();
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Are you sure you want to split the files into new watch blocks?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+keyName+"</div><div><div class='link' onclick='splitFiles("+currentRow+");hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
		}
		else
		{
			splitFiles(currentRow);
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function splitFiles(currentRow)
{
	//do for loop with current list of files
	var listOfFiles = document.getElementsByName("watchListKey"+currentRow+"FileInFolder");
	if(listOfFiles)
	{
		for (var i = 0; i < listOfFiles.length; i++)
		{
		  var fileLocation = listOfFiles[i].value;
		  addRowFunction(
		  	{
		  		fileType: "file",
		  		location: fileLocation
		  	});
		}

		deleteRowFunction(currentRow);
	}
}

function updateFileInfo(currentRow)
{
	var stringToUpdateTo = "{";
	var listOfFiles = document.getElementsByName("watchListKey"+currentRow+"FileInFolder");
	var listOfFilesInclude = document.getElementsByName("watchListKey"+currentRow+"FileInFolderInclude");
	var listOfFilesTrim = document.getElementsByName("watchListKey"+currentRow+"FileInFolderTrim");
	var listOfFilesDelete = document.getElementsByName("watchListKey"+currentRow+"ExcludeDelete");
	var listOfFilesName = document.getElementsByName("watchListKey"+currentRow+"FileInFolderName");
	var listOfFilesAlert = document.getElementsByName("watchListKey"+currentRow+"FileInFolderAlert");
	
	if(listOfFiles)
	{
		listOfFilesLength = listOfFiles.length;
		for (var i = 0; i < listOfFilesLength; i++)
		{
			stringToUpdateTo += "\""+listOfFiles[i].value+"\" : {";
			stringToUpdateTo += " \"Include\": \""+listOfFilesInclude[i].value + "\" , ";
			stringToUpdateTo += " \"Trim\":  \""+listOfFilesTrim[i].value + "\" , ";
			stringToUpdateTo += " \"Delete\":  \""+listOfFilesDelete[i].value + "\", ";
			stringToUpdateTo += " \"Name\":  \""+listOfFilesName[i].value + "\", ";
			stringToUpdateTo += " \"Alert\":  \""+listOfFilesAlert[i].value + "\"  ";
			stringToUpdateTo += "}";
			if(i !== (listOfFilesLength - 1))
			{
				stringToUpdateTo += ","
			}
		}
	}
	stringToUpdateTo += "}";
	document.getElementsByName("watchListKey"+currentRow+"FileInformation")[0].value = stringToUpdateTo;
}

function toggleTypeFolderFile(currentRow)
{
	if(document.getElementsByName("watchListKey"+currentRow+"FileType")[0].value === "file")
	{
		$("#rowNumber"+currentRow+" .typeFile").hide();
		$("#rowNumber"+currentRow+" .typeFolder").show();
	}
	else
	{
		$("#rowNumber"+currentRow+" .typeFile").show();
		$("#rowNumber"+currentRow+" .typeFolder").hide();
	}
	
}

function deleteRowFunctionPopup(currentRow, keyName = "")
{
	try
	{
		if("removeFolder" in popupSettingsArray && popupSettingsArray.removeFolder === "true")
		{
			showPopup();
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Are you sure you want to remove this file/folder?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+keyName+"</div><div><div class='link' onclick='deleteRowFunction("+currentRow+");hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
		}
		else
		{
			deleteRowFunction(currentRow);
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}	
}

function deleteRowFunction(currentRow)
{
	try
	{
		var elementToFind = "rowNumber" + currentRow;
		document.getElementById(elementToFind).outerHTML = "";
		var newValue = parseInt(document.getElementById("numberOfRows").value);
		if(currentRow < newValue)
		{
			//this wasn't the last folder deleted, update others
			for(var i = currentRow + 1; i <= newValue; i++)
			{
				var updateItoIMinusOne = i - 1;
				var fileName = "";
				if(updateItoIMinusOne < 10)
				{
					fileName += "0";
				}
				fileName += updateItoIMinusOne;

				var item = generateRow(
					{
						rowNumber: updateItoIMinusOne,
						fileNumber: fileName,
						filePermsDisplay: $("#infoFile"+i).html(),
						fileImage: $("#imageFile"+i).html(),
						location: document.getElementsByName("watchListKey"+i+"Location")[0].value,
						pattern: document.getElementsByName("watchListKey"+i+"Pattern")[0].value,
						key: document.getElementsByName("watchListKey"+i)[0].value,
						recursive: document.getElementsByName("watchListKey"+i+"Recursive")[0].value,
						excludeTrim: document.getElementsByName("watchListKey"+i+"ExcludeTrim")[0].value,
						fileType: document.getElementsByName("watchListKey"+i+"FileType")[0].value,
						filesInFolder: document.getElementById("watchListKey"+i+"FilesInFolder").innerHTML,
						AutoDeleteFiles: document.getElementsByName("watchListKey"+i+"AutoDeleteFiles")[0].value,
						FileInformation: document.getElementsByName("watchListKey"+i+"FileInformation")[0].value,
						Group: document.getElementsByName("watchListKey"+i+"Group")[0].value,
						Name: document.getElementsByName("watchListKey"+i+"Name")[0].value,
						AlertEnabled: document.getElementsByName("watchListKey"+i+"AlertEnabled")[0].value
					}
				);
				//add new one
				$(".uniqueClassForAppendSettingsMainWatchNew").append(item);
				//remove old one
				$("#rowNumber"+i).remove();
			}
		}
		newValue--;
		document.getElementById("numberOfRows").value = newValue;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkWatchList()
{
	try
	{
		var countOfWatchList = parseInt(document.getElementById("numberOfRows").value);
		var blankValue = false;
		for (var i = 1; i <= countOfWatchList; i++) 
		{
			if(document.getElementsByName("watchListKey"+i+"Location")[0].value === "")
			{
				blankValue = true;
				break;
			}
		}
		if(blankValue && "blankFolder" in popupSettingsArray && popupSettingsArray.blankFolder === "true")
		{
			showNoEmptyFolderPopup();
			event.preventDefault();
			event.returnValue = false;
			return false;
		}
		else
		{
			displayLoadingPopup();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}
function showNoEmptyFolderPopup()
{
	try
	{
		showPopup();
		document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Warning!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Please make sure there are no empty folders when saving the Watch List.</div><div><div class='link' onclick='hidePopup();' style='margin-left:175px; margin-top:25px;'>Okay</div></div>";
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkIfChanges()
{
	if(	checkForChangesArray(["settingsMainWatch"]))
	{
		return true;
	}
	return false;
}

function resetWatchListVars()
{
	try
	{
		resetArrayObject("settingsMainWatch");
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsWatchList()
{
	try
	{
		refreshArrayObject("settingsMainWatch");
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

$( document ).ready(function() 
{
	refreshSettingsWatchList();
	setInterval(poll, 100);
});


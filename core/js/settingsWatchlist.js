var titleOfPage = "Watchlist";
var selectOptions =
{
	0:{
		value: ".log$",
		name: ".log"
	},
	1:{
		value: ".txt$",
		name: ".txt"
	},
	2:{
		value: ".out$",
		name: ".out"
	},
	3:{
		value: "$",
		name: "Any File"
	}
};
var staticFileData;
var staticRowNumber = 1;

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
	var filesInFolder = data["filesInFolder"];
	if(data["prevRowNum"] !== -1)
	{
		filesInFolder = filesInFolder.split("watchListKey"+data["prevRowNum"]).join("watchListKey"+data["rowNumber"]);
		filesInFolder = filesInFolder.split("updateFileInfo("+data["prevRowNum"]).join("updateFileInfo("+data["rowNumber"]);
	}
	var hideSplit = false;
	if("hideSplit" in data)
	{
		hideSplit = data["hideSplit"];
	}

	var hidePattern = false;
	var optionList = Object.keys(selectOptions);
	var optionListCount = optionList.length;
	for(var i = 0; i < optionListCount; i++)
	{
		if(String(data["pattern"]) === String(selectOptions[optionList[i]]["value"]))
		{
			hidePattern = true;
			break;
		}
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
	item = item.replace(/{{filesInFolder}}/g, filesInFolder);
	item = item.replace(/{{AutoDeleteFiles}}/g, data["AutoDeleteFiles"]);
	item = item.replace(/{{FileInformation}}/g, data["FileInformation"]);
	item = item.replace('FileInformation" value="', 'FileInformation" value=\'');
	item = item.replace('"></ul></div>', '\'></ul></div>');	
	item = item.replace(/{{Group}}/g, data["Group"]);
	item = item.replace(/{{Name}}/g, data["Name"]);
	item = item.replace(/{{AlertEnabled}}/g, generateTrueFalseSelect(data["AlertEnabled"]));
	item = item.replace(/{{hidesplitbutton}}/g, displayNoneIfTrue(hideSplit));
	item = item.replace(/{{patternSelect}}/g, generatePatternSelect(data["pattern"]));
	item = item.replace(/{{hidepatterninput}}/g, displayNoneIfTrue(hidePattern));
	if(!data["down"])
	{
		item = item.replace(/{{movedown}}/g, "style=\"display: none;\"");
	}
	if(!data["up"])
	{
		item = item.replace(/{{moveup}}/g, "style=\"display: none;\"");
	}
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

function generatePatternSelect(selectValue)
{
	return generateSelect(
		selectOptions,
		{
			value: "other",
			name: "Other"
		},
		selectValue
	);
}

function generateFileTypeSelect(selectValue)
{
	return generateSelect(
		{
			0:{
				value: "file",
				name: "File"
			},
			1:{
				value: "folder",
				name: "Folder"
			}
		},
		{
			value: "other",
			name: "Other"
		},
		selectValue
	);
}

function generateTrueFalseSelect(selectValue)
{
	return generateSelect(
		{
			0:{
				value: "true",
				name: "True"
			}
		},
		{
			value: "false",
			name: "False"
		},
		selectValue
	);
}

function generateSelect(data, defaultData, selectValue)
{
	var optionList = Object.keys(data);
	var optionListCount = optionList.length;
	var selectHtml = "";
	var selected = false;
	for(var i = 0; i < optionListCount; i++)
	{
		selectHtml += "<option value=\""+data[optionList[i]]["value"]+"\" ";
		if(selectValue === data[optionList[i]]["value"] && selected !== true)
		{
			selectHtml += " selected ";
			selected = true;
		}
		selectHtml += " >"+data[optionList[i]]["name"]+"</option>";
	}
	selectHtml += "<option value=\""+defaultData["value"]+"\" ";
	if(selected !== true)
	{
		selectHtml += " selected ";
	}
	selectHtml += " >"+defaultData["name"]+"</option>";
	return selectHtml;
}

function togglePatternSelect(rowNumber)
{
	var newPatternvalue = document.getElementById("watchListKey"+rowNumber+"PatternSelect").value;
	if(newPatternvalue === "other")
	{
		document.getElementsByName("watchListKey"+rowNumber+"Pattern")[0].value = "";
		document.getElementsByName("watchListKey"+rowNumber+"Pattern")[0].style.display = "inline-block";
	}
	else
	{
		document.getElementsByName("watchListKey"+rowNumber+"Pattern")[0].value = newPatternvalue;
		document.getElementsByName("watchListKey"+rowNumber+"Pattern")[0].style.display = "none";
	}
	setTimeout(function(){ updateSubFiles(rowNumber);  }, 50);
}

function addFile()
{
	showPopup();
	var htmlForPopoup = "<div class='settingsHeader' id='popupHeaderText' ><span id='popupHeaderText' >Add File</span></div>";
	htmlForPopoup += "<br><div style='width:100%;text-align:center;'> <input onkeyup=\"getCurrentFileFolderInfoKeyPress(false);\" value=\""+defaultNewPathFile+"\" id=\"inputFieldForFileOrFolder\" type=\"text\" style=\"width: 90%;\" > </div>";
	htmlForPopoup += "<br><div style='width:100%;height:30px;padding-left:20px;' id=\"folderNavUpHolder\"> </div><div id=\"folderFileInfoHolder\" style='margin-right:10px; margin-left: 10px;height:200px;border: 1px solid white;overflow: auto;'> --- </div>";
	htmlForPopoup += "<div class='link' onclick='addFileFolderAjax(\"file\", document.getElementById(\"inputFieldForFileOrFolder\").value);' style='margin-left:125px; margin-right:50px;margin-top:25px;'>Add</div><div onclick='hidePopup();' class='link'>Cancel</div";
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = htmlForPopoup;
	document.getElementById('popupContent').style.height = "400px";
	document.getElementById('popupContent').style.marginTop = "-200px";
	updateFileFolderGui(false);
} 

function addFolder()
{
	showPopup();
	var htmlForPopoup = "<div class='settingsHeader' id='popupHeaderText' ><span id='popupHeaderText' >Add Folder</span></div>";
	htmlForPopoup += "<br><div style='width:100%;text-align:center;'> <input onkeyup=\"getCurrentFileFolderInfoKeyPress(true);\" value=\""+defaultNewPathFolder+"\" id=\"inputFieldForFileOrFolder\" type=\"text\" style=\"width: 90%;\" > </div>";
	htmlForPopoup += "<br><div style='width:100%;height:30px;padding-left:20px;' id=\"folderNavUpHolder\"> </div><div id=\"folderFileInfoHolder\" style='margin-right:20px; margin-left: 20px;height:200px;border: 1px solid white;overflow: auto;'> --- </div>";
	htmlForPopoup += "<div class='link' onclick='addFileFolderAjax(\"folder\", document.getElementById(\"inputFieldForFileOrFolder\").value);' style='margin-left:110px; margin-right:50px;margin-top:25px;'>Add</div><div onclick='hidePopup();' class='link'>Cancel</div";
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = htmlForPopoup;
	document.getElementById('popupContent').style.height = "400px";
	document.getElementById('popupContent').style.marginTop = "-200px";
	updateFileFolderGui(true);
}

function addFileFolderAjax(fileType, sentLocation)
{
	hidePopup();
	displayLoadingPopup("../");
	var urlForSend = "../core/php/getFileFolderData.php?format=json";
	var data = {currentFolder: sentLocation, filter: defaultNewAddPattern};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			var countOfWatchList = parseInt(document.getElementById("numberOfRows").value);
			var fileListData = generateSubFiles({fileArray: data["data"], currentNum: (countOfWatchList+1), mainFolder: sentLocation});
			hidePopup();
			addRowFunction(
			{
				fileType: fileType,
				fileImage: icons[data["img"]],
				location: sentLocation,
				filePermsDisplay: data["fileInfo"],
				filesInFolder: fileListData["html"],
				hideSplit: fileListData["filesFound"]
			}
			);
		}
	});	
}

function updateSubFiles(id)
{
	document.getElementById("watchListKey"+id+"LoadingSubFilesIcon").style.display = "inline-block";
	document.getElementById("watchListKey"+id+"FilesInFolder").style.display = "none";
	var urlForSend = "../core/php/getFileFolderData.php?format=json";
	var data = {currentFolder: document.getElementsByName("watchListKey"+id+"Location")[0].value, recursive: document.getElementsByName("watchListKey"+id+"Recursive")[0].value, filter:  document.getElementsByName("watchListKey"+id+"Pattern")[0].value};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			document.getElementById("infoFile"+id).innerHTML = data["fileInfo"];
			document.getElementById("imageFile"+id).innerHTML = icons[data["img"]];
			setTimeout(function(){ document.getElementById("watchListKey"+id+"LoadingSubFilesIcon").style.display = "none"; document.getElementById("watchListKey"+id+"FilesInFolder").style.display = "inline-block"; }, 1000);
			var prevFolderData = JSON.parse(document.getElementsByName("watchListKey"+id+"FileInformation")[0].value);
			var htmlReturn = generateSubFiles({fileArray: data["data"], currentNum: id, mainFolder: data["orgPath"], fileData: prevFolderData});
			$("#watchListKey"+id+"FilesInFolder").html(htmlReturn["html"]);
			if(htmlReturn["hideSplit"])
			{
				if(document.getElementById("watchListKey"+id+"SplitFilesLink").style.display !== "none")
				{
					document.getElementById("watchListKey"+id+"SplitFilesLink").style.display = "none";
				}
			}
			else
			{
				if(document.getElementById("watchListKey"+id+"SplitFilesLink").style.display !== "inline-block")
				{
					document.getElementById("watchListKey"+id+"SplitFilesLink").style.display = "inline-block";
				}
			}
		}
	});	
}

function generateSubFiles(data)
{
	var fileArray = data["fileArray"];
	var currentNum = data["currentNum"];
	var mainFolder = data["mainFolder"];
	var fileData = {};
	if("fileData" in data)
	{
		fileData = data["fileData"];
	}
	var returnHtml = "";
	var fileArrayList = Object.keys(fileArray);
	var fileArrayListCount = fileArrayList.length;
	var hideSplit = false;
	for(var i = 0; i < fileArrayListCount; i++)
	{
		var keyTwo = fileArrayList[i];
		if(fileArray[keyTwo]["type"] !== "folder")
		{
			var includeBool = "true";
			var excludeTrim = defaultNewAddExcludeTrim;
			var excludeDelete = "false";
			var alertOnUpdate = defaultdefaultNewAddAlertEnabled;
			var name = "";
			
			if(keyTwo in fileData)
			{
				if("Name" in fileData[keyTwo])
				{
					name = fileData[keyTwo]["Name"];
				}
				if("Alert" in fileData[keyTwo])
				{
					alertOnUpdate = fileData[keyTwo]["Alert"];
				}
				if("Delete" in fileData[keyTwo])
				{
					excludeDelete = fileData[keyTwo]["Delete"];
				}
				if("Trim" in fileData[keyTwo])
				{
					excludeTrim = fileData[keyTwo]["Trim"];
				}
				if("Include" in fileData[keyTwo])
				{
					includeBool = fileData[keyTwo]["Include"];
				}
			}
			returnHtml += "<li>"+icons[fileArray[keyTwo]["image"]];
			returnHtml += "<span style=\"width: 300px; overflow: auto; display: inline-block;\" >"+keyTwo.replace(mainFolder,"")+"</span><input name=\"watchListKey"+currentNum+"FileInFolder\"  type=\"hidden\" value=\""+keyTwo+"\" >";
			returnHtml += "<span class=\"settingsBuffer\" >Include: <select onchange=\"updateFileInfo("+currentNum+");\" name=\"watchListKey"+currentNum+"FileInFolderInclude\" > "+generateTrueFalseSelect(includeBool)+" </select></span>";
			returnHtml += "<span class=\"settingsBuffer\" >Exclude Trim: <select onchange=\"updateFileInfo("+currentNum+");\" name=\"watchListKey"+currentNum+"FileInFolderTrim\"> "+generateTrueFalseSelect(excludeTrim)+" </select></span>";
			returnHtml += "<span class=\"settingsBuffer\" >Exclude Delete: <select onchange=\"updateFileInfo("+currentNum+");\" name=\"watchListKey"+currentNum+"ExcludeDelete\"> "+generateTrueFalseSelect(excludeDelete)+" </select></span>";
			returnHtml += "<span class=\"settingsBuffer\" >Alert on Update: <select onchange=\"updateFileInfo("+currentNum+");\" name=\"watchListKey"+currentNum+"FileInFolderAlert\"> "+generateTrueFalseSelect(alertOnUpdate)+" </select></span>";
			returnHtml += "<span class=\"settingsBuffer\" >Name: <input onchange=\"updateFileInfo("+currentNum+");\"  type=\"text\" name=\"watchListKey"+currentNum+"FileInFolderName\" value=\""+name+"\" > </span>";
			returnHtml += "</li>";
		}
	}
	if(returnHtml === "")
	{
		returnHtml = "<li>No Files Found In Folder</li>";
		hideSplit = true;
	}
	return {html: returnHtml, hideSplit};
}

function updateFileFolderGui(hideFiles)
{
	getFileFolderData(document.getElementById("inputFieldForFileOrFolder").value, hideFiles,document.getElementById("inputFieldForFileOrFolder").value);
}

function addOther()
{
	addRowFunction(
		{
			fileType: "other",
			location: defaultNewPathOther
		}
	);
}

function setNewFileFolderValue(newValue,hideFiles)
{
	document.getElementById("inputFieldForFileOrFolder").value = newValue;
	getCurrentFileFolderInfoKeyPress(hideFiles);
}

function expandFileFolderView(newValue, hideFiles)
{
	document.getElementById("inputFieldForFileOrFolder").value = newValue;
	getFileFolderData(newValue, hideFiles,newValue)
}

function getCurrentFileFolderMainPage(currentRow)
{
	var currentDir = document.getElementsByName("watchListKey"+currentRow+"Location")[0].value;
	var hideFiles = false;
	if(document.getElementsByName("watchListKey"+currentRow+"FileType")[0].value === "folder")
	{
		hideFiles = true;
	}
	var joinChar = getJoinCharMain(currentRow);
	var newDir = getCurrentDir(currentDir, joinChar);
	getFileFolderDataMain(newDir, hideFiles, currentDir, currentRow);
}

function getCurrentFileFolderInfoKeyPress(hideFiles)
{
	var currentDir = document.getElementById("inputFieldForFileOrFolder").value;
	var joinChar = getJoinChar();
	var newDir = getCurrentDir(currentDir, joinChar);
	getFileFolderData(newDir, hideFiles,currentDir);
}

function getCurrentDir(currentDir, joinChar)
{
	var currentDirArray = currentDir.split(joinChar);
	var lengthOfArr = currentDirArray.length;
	if(currentDirArray[lengthOfArr-1] !== "")
	{
		currentDirArray.pop();
	}
	var newDir = currentDirArray.join(joinChar);
	if(newDir === "")
	{
		newDir = joinChar;
	}
	return newDir;
}

function getFileFolderData(currentFolder, hideFiles, orgPath)
{
	//make ajax to get file / folder data, return array
	var urlForSend = "../core/php/getFileFolderData.php?format=json";
	var data = {currentFolder, filter: defaultNewAddPattern};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			staticFileData = data;
			if(document.getElementById("inputFieldForFileOrFolder").value == orgPath)
			{
				var joinChar = getJoinChar();
				getFileFolderSubFunction(data, orgPath, hideFiles, joinChar, false);
			}
		}
	});	
}

function getFileFolderDataMain(currentFolder, hideFiles, orgPath, currentRow)
{
	//make ajax to get file / folder data, return array
	var urlForSend = "../core/php/getFileFolderData.php?format=json";
	var data = {currentFolder, filter: document.getElementsByName("watchListKey"+currentRow+"Pattern")[0].value};
	$.ajax({
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
			staticFileData = data;
			if(document.getElementsByName("watchListKey"+currentRow+"Location")[0].value == orgPath)
			{
				var joinChar = getJoinCharMain(currentRow);
				getFileFolderSubFunction(data, orgPath, hideFiles, joinChar, true);
			}
		}
	});	
}

function getFileFolderSubFunction(data, orgPath, hideFiles, joinChar, dropdown)
{
	
	var htmlSet = "";
	var currentFile = "";
	if(orgPath !== joinChar && orgPath !== "")
	{
		if(!dropdown)
		{
			document.getElementById("folderNavUpHolder").innerHTML = "<a class=\"linkSmall\" onclick=\"navUpDir("+hideFiles+")\" >Navigate Up One Folder</a>";
		}
		var currentDirArray = orgPath.split(joinChar);
		var lengthOfArr = currentDirArray.length;
		var checkHighlight = currentDirArray[lengthOfArr-1];
		if(checkHighlight !== "")
		{
			currentFile = checkHighlight;
		}
	}
	else
	{
		document.getElementById("folderNavUpHolder").innerHTML = "";
	}
	var listOfFileOrFolders = Object.keys(data["data"]);
	var listOfFileOrFoldersCount = listOfFileOrFolders.length;
	var fileFolderList = {
		selected: "",
		startsWith: "",
		contains: "",
		other: ""
	};
	for(var i = 0; i < listOfFileOrFoldersCount; i++)
	{
		var subData = data["data"][listOfFileOrFolders[i]];
		var selectButton = "<a class=\"linkSmall\"  onclick=\"setNewFileFolderValue('"+listOfFileOrFolders[i]+"',"+hideFiles+")\" >select</a>";
		var name = "<span style=\"max-width: 200px; word-break: break-all; display: inline-block; \" >"+subData["filename"]+"</span>"
		var highlightClass = "";
		var listKey = "other";
		if(subData["filename"].indexOf(currentFile) === 0 && currentFile !== "")
		{
			highlightClass = "class=\"selected\"";
			if(sortTypeFileFolderPopup === "startsWithAndcontains" || sortTypeFileFolderPopup === "startsWith")
			{
				listKey = "startsWith";
			}
			if(subData["filename"] === currentFile)
			{
				selectButton = "<a class=\"linkSmallHover\"> Selected </a>";
				if(sortTypeFileFolderPopup === "startsWithAndcontains" || sortTypeFileFolderPopup === "startsWith")
				{
					listKey = "selected";
				}
			}
		}
		else if(subData["filename"].indexOf(currentFile) > 0 && currentFile !== "" && sortTypeFileFolderPopup === "startsWithAndcontains")
		{
			listKey = "contains";
		}
		if(dropdown)
		{
			selectButton = "";
		}
		if(subData["type"] === "folder")
		{
			var folderHtml = "";
			var expandButton =  "<a class=\"linkSmall\"  onclick=\"expandFileFolderView('"+listOfFileOrFolders[i]+"',"+hideFiles+")\" >expand</a>";
			if(dropdown)
			{
				expandButton = "";
			}
			folderHtml += "<div "+highlightClass+" style=\"padding: 5px;min-height:30px;\" >"+name+" <span style=\"float:right;\" > ";
			if(hideFiles)
			{
				folderHtml += selectButton+" ";
			}
			if(subData["dirEmpty"] !== true)
			{
				folderHtml += " "+expandButton+" ";
			}
			folderHtml += "</span> </div>";
			fileFolderList[listKey] += folderHtml;
		}
		else if(data["data"][listOfFileOrFolders[i]]["type"] === "file")
		{
			if(!hideFiles)
			{
				var fileHtml = "<div "+highlightClass+" style=\"padding: 5px;min-height:30px;\" >"+name+" <span style=\"float:right;\" > "+selectButton+" </span> </div>";
				fileFolderList[listKey] += fileHtml;
			}
		}
	}
	htmlSet += fileFolderList["selected"];
	htmlSet += fileFolderList["startsWith"];
	htmlSet += fileFolderList["contains"];
	htmlSet += fileFolderList["other"];
	document.getElementById("folderFileInfoHolder").innerHTML = htmlSet;
}

function showTypeDropdown(rowNumber)
{
	document.getElementById("fileFolderDropdown").style.display = "block";
	staticRowNumber = rowNumber;
	moveFileFolderDropdown();

	var htmlForPopoup = "<div id=\"folderNavUpHolder\"> </div><div id=\"folderFileInfoHolder\" style='margin-right:20px; margin-left: 20px;height:200px;border: 1px solid white;overflow: auto;'> --- </div>";
	document.getElementById("fileFolderDropdown").innerHTML = htmlForPopoup;
	getCurrentFileFolderMainPage(rowNumber);
}

function hideTypeDropdown(rowNumber)
{
	document.getElementById("fileFolderDropdown").style.display = "none";
	document.getElementById("fileFolderDropdown").innerHTML = "";
	updateSubFiles(rowNumber);
}

function navUpDir(hideFiles)
{
	var lastDir = getLastDir();
	document.getElementById("inputFieldForFileOrFolder").value = lastDir;
	getFileFolderData(lastDir, hideFiles,lastDir)
}

function getLastDir()
{
	var currentDir = document.getElementById("inputFieldForFileOrFolder").value;
	var joinChar = getJoinChar();
	var currentDirArray = currentDir.split(joinChar);
	var lengthOfArr = currentDirArray.length;
	if(currentDirArray[lengthOfArr-1] === "")
	{
		currentDirArray.pop();
		currentDirArray.pop();
	}
	else
	{
		currentDirArray.pop();
	}
	var newDir = currentDirArray.join(joinChar);
	if(newDir === "")
	{
		newDir = joinChar;
	}
	return newDir;
}

function getJoinChar()
{
	if(document.getElementById("inputFieldForFileOrFolder").value.indexOf("/") === -1)
	{
		return "\\";
	}
	return "/";
}

function getJoinCharMain(rowNumber)
{
	if(document.getElementsByName("watchListKey"+rowNumber+"Location")[0].value.indexOf("/") === -1)
	{
		return "\\";
	}
	return "/";
}

function addRowFunction(data)
{
	try
	{
		var countOfWatchList = parseInt(document.getElementById("numberOfRows").value);
		document.getElementById("moveDown"+countOfWatchList).style.display = "inline-block";
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

		var fileImg = "";
		if("fileImage" in data)
		{
			fileImg = data["fileImage"];
		}

		var filePermsDisplay = "";
		if("filePermsDisplay" in data)
		{
			filePermsDisplay = data["filePermsDisplay"];
		}

		var hideSplit = false;
		if("hideSplit" in data)
		{
			hideSplit = data["hideSplit"];
		}

		var item = generateRow(
			{
				rowNumber: countOfWatchList,
				prevRowNum: -1,
				fileNumber: fileName,
				filePermsDisplay,
				fileImage: fileImg,
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
				AlertEnabled: defaultdefaultNewAddAlertEnabled,
				up: true,
				down: false,
				hideSplit
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
	setTimeout(function(){ updateSubFiles(currentRow);  }, 50);
}

function deleteRowFunctionPopup(currentRow, keyName = "")
{
	try
	{
		if("removeFolder" in popupSettingsArray && popupSettingsArray.removeFolder === "true")
		{
			showPopup();
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Are you sure you want to remove this entry from your watchlist?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+keyName+"</div><div><div class='link' onclick='deleteRowFunction("+currentRow+");hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
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
				moveRow(i, updateItoIMinusOne);
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

function moveRow(currentRow, newRow)
{
	var fileName = "";
	if(newRow < 10)
	{
		fileName += "0";
	}
	var upBool = true;
	var downBool = true;
	if(newRow === 1)
	{
		upBool = false;
	}
	else if(newRow === parseInt(document.getElementById("numberOfRows").value))
	{
		downBool = false;
	}
	fileName += newRow;
	var item = generateRow(
		{
			rowNumber: newRow,
			prevRowNum: currentRow,
			fileNumber: fileName,
			filePermsDisplay: $("#infoFile"+currentRow).html(),
			fileImage: $("#imageFile"+currentRow).html(),
			location: document.getElementsByName("watchListKey"+currentRow+"Location")[0].value,
			pattern: document.getElementsByName("watchListKey"+currentRow+"Pattern")[0].value,
			key: document.getElementsByName("watchListKey"+currentRow)[0].value,
			recursive: document.getElementsByName("watchListKey"+currentRow+"Recursive")[0].value,
			excludeTrim: document.getElementsByName("watchListKey"+currentRow+"ExcludeTrim")[0].value,
			fileType: document.getElementsByName("watchListKey"+currentRow+"FileType")[0].value,
			filesInFolder: document.getElementById("watchListKey"+currentRow+"FilesInFolder").innerHTML,
			AutoDeleteFiles: document.getElementsByName("watchListKey"+currentRow+"AutoDeleteFiles")[0].value,
			FileInformation: document.getElementsByName("watchListKey"+currentRow+"FileInformation")[0].value,
			Group: document.getElementsByName("watchListKey"+currentRow+"Group")[0].value,
			Name: document.getElementsByName("watchListKey"+currentRow+"Name")[0].value,
			AlertEnabled: document.getElementsByName("watchListKey"+currentRow+"AlertEnabled")[0].value,
			up: upBool,
			down: downBool,
			hideSplit: (document.getElementById("watchListKey"+currentRow+"SplitFilesLink").style.display === "none")
		}
	);
	//add new one
	$(".uniqueClassForAppendSettingsMainWatchNew").append(item);
	//remove old one
	$("#rowNumber"+currentRow).remove();
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

function moveDown(rowNumber)
{
	//rown number is current row
	var countOfWatchList = parseInt(document.getElementById("numberOfRows").value);
	var counter = 0;
	for(var i = rowNumber; i <= countOfWatchList; i++)
	{
		counter++;
		moveRow(i, (countOfWatchList+counter));
	}

	moveRow((countOfWatchList+2),rowNumber);
	rowNumber++;
	moveRow((countOfWatchList+1),rowNumber);
	rowNumber++;
	if(rowNumber !== countOfWatchList + 1)
	{
		var counter = 2;
		for(var i = rowNumber; i <= countOfWatchList; i++)
		{
			counter++;
			moveRow((countOfWatchList+counter), i);
		}
	}
}

function moveUp(rowNumber)
{
	rowNumber--;
	moveDown(rowNumber);
}

function moveFileFolderDropdown()
{
	if(document.getElementById("fileFolderDropdown").style.display !== "none")
	{
		document.getElementById("fileFolderDropdown").style.top = document.getElementsByName("watchListKey"+staticRowNumber+"Location")[0].getBoundingClientRect().bottom;
		document.getElementById("fileFolderDropdown").style.left = document.getElementsByName("watchListKey"+staticRowNumber+"Location")[0].getBoundingClientRect().left;
	}
}

$( document ).ready(function() 
{
	refreshSettingsWatchList();

	document.addEventListener(
		'scroll',
		function (event)
		{
			onScrollShowFixedMiniBar(["settingsMainWatch"]);
			moveFileFolderDropdown();
		},
		true
	);

	setInterval(poll, 100);
});
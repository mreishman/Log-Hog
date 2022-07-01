function formatFileLine(text, extraData) //used to check if file loaded
{
	if(checkIfTextIsError(text) === -1)
	{
		if(dateTextFormatColumn === "auto" && window.innerWidth > breakPointTwo)
		{
			if("lineDisplay" in extraData && extraData["lineDisplay"] === "true")
			{
				return "<td style=\"white-space:nowrap;width: 1%;\">" + extraData["lineCount"] + "</td><td style=\"white-space: pre-wrap;\">" + text + "</td>";
			}
			return "<td style=\"white-space:nowrap;width: 1%;\"></td><td style=\"white-space: pre-wrap;\">" + text + "</td>";
		}
		else if("lineDisplay" in extraData && extraData["lineDisplay"] === "true")
		{
			return "<td style=\"white-space:nowrap;width: 1%;\">" + extraData["lineCount"] + "</td><td style=\"white-space: pre-wrap;\">" + text + "</td>";
		}

	}
	return "<td style=\"white-space: pre-wrap;\">" + text + "</td>";
}

function formatMessageFileData(message, extraData)
{
	let customClass = "";
	if("customClassAdd" in extraData && extraData["customClassAdd"])
	{
		customClass = extraData["customClass"];
	}

	let fileTable = "";

	let files = extraData["fileData"];
	let filesLength = files.length;
	for(let i = 0; i < filesLength; i++)
	{
		let file = extraData["fileData"][i];
		var lineStart = 0;
		var pregMatchData = file["pregMatchData"];
		var numForBaseLineStart = parseInt(pregMatchData[(pregMatchData.length - 1)]);
		if(numForBaseLineStart > 0)
		{
			lineStart = numForBaseLineStart - logFormatFileLinePadding;
		}
		
		let filePermissions = "";
		if(file["permissions"] !== "")
		{
			
			filePermissions = " [File Permissions: "+file["permissions"]+"]";
			if(logFormatFileTitleSeperateLine === "true")
			{
				filePermissions = "<span style=\"float: right;\" >" + filePermissions + "</span>";
			}
			
		}

		let id = 0;
		if("id" in extraData)
		{
			id = extraData["id"];
		}

		let fileName = "";
		if(logFormatFileTitleSeperateLine === "true")
		{
			fileName = file["fileName"];
			fileTable += "<tr style=\"background-color: white;\"><td style=\"color: black; padding: 5px;\">" + fileName + filePermissions + "</td></tr>";
		}
		else
		{
			message = message.replace(file["fileName"], " " + filePermissions + " " + file["fileName"]);
		}
		fileTable += "<tr "+customClass+"><td style=\"padding: 0;\" ><table class=\"logCode\" style=\"width: 100%;\">"+makePrettyWithText(escapeHTML(file["fileData"]), 0, {lineDisplay: logFormatFileLineCount, lineModifier: lineStart, type: "file", id: id})+"</table></td></tr>";

	}
	let tdStyle = "";
	if(logFormatFileTitleSeperateLine === "true")
	{
		tdStyle = "style=\"padding-bottom: 5px;\"";
	}
	return "<table style=\"width: 100%; border-spacing: 0;\"><tr "+customClass+"><td "+tdStyle+" >"+message + "</td></tr>" + fileTable + "</table>";
}

function updateFileDataArrayInner(newDataArr)
{
	var newDataArrKeys = Object.keys(newDataArr);
	var newDataArrKeysLength=  newDataArrKeys.length;
	for(var NDACount = 0; NDACount < newDataArrKeysLength; NDACount++)
	{
		var fileDataArr = newDataArr[newDataArrKeys[NDACount]]["fileData"];
		var fileDataArrKeys = Object.keys(fileDataArr);
		var fileDataArrKeysLength = fileDataArrKeys.length;
		if(fileDataArrKeysLength > 0)
		{
			for(var FDACount = 0; FDACount < fileDataArrKeysLength; FDACount++)
			{
				arrayOfFileData[fileDataArrKeys[FDACount]] = fileDataArr[fileDataArrKeys[FDACount]];
			}
		}
	}
}


function checkIfLineContainsAFile(localMessage)
{
	let fileMatch = false;
	let fileData = [];
	var arrayOfFileDataKeys = Object.keys(arrayOfFileData);
	var arrayOfFileDataKeysLength = arrayOfFileDataKeys.length;
	for(var AOFDCount = 0; AOFDCount < arrayOfFileDataKeysLength; AOFDCount++)
	{
		let dataKeyData = arrayOfFileDataKeys[AOFDCount];
		let localMessageIndex = localMessage.indexOf(dataKeyData);
		if(localMessageIndex > -1)
		{
			if (checkIfTextIsError(arrayOfFileData[dataKeyData]["fileData"]) === -1)
			{
				fileData.push(arrayOfFileData[dataKeyData]);
				fileMatch = true;
			}
			else if (
				(checkIfTextIsError(arrayOfFileData[dataKeyData]["fileData"]) === 1 && logFormatFileHideError !== "true") ||
				(checkIfTextIsError(arrayOfFileData[dataKeyData]["fileData"]) === 0 && logFormatFileHideReadError !== "true")
				)
			{
				fileData.push(arrayOfFileData[dataKeyData]);
				fileMatch = true;
			}
		}
	}
	return {
		match: fileMatch,
		files: fileData
	};
}

function checkIfTextIsError(textToCheck)
{
	if(textToCheck === "Error - File Not Found")
	{
		return 0;
	}
	if(textToCheck === "Error - File Changed, line no longer in file")
	{
		return 1;
	}
	return -1;
}
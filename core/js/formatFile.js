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
	var lineStart = 0;
	var pregMatchData = extraData["fileData"]["pregMatchData"];
	var numForBaseLineStart = parseInt(pregMatchData[(pregMatchData.length - 1)]);
	if(numForBaseLineStart > 0)
	{
		lineStart = numForBaseLineStart - logFormatFileLinePadding;
	}
	let customClass = "";
	if("customClassAdd" in extraData && extraData["customClassAdd"])
	{
		customClass = extraData["customClass"];
	}
	let filePermissions = "";
	if(extraData["fileData"]["permissions"] !== "")
	{
		
		filePermissions = " [File Permissions: "+extraData["fileData"]["permissions"]+"]";
		if(true)
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
	let tdStyle = "";
	let messageFilePermission = filePermissions;
	if(true)
	{
		fileName = extraData["fileData"]["fileName"];
		fileName = "<tr style=\"background-color: white;\"><td style=\"color: black; padding: 5px;\">" + fileName + filePermissions + "</td></tr>";
		tdStyle = "style=\"padding-bottom: 5px;\"";
		messageFilePermission = "";
	}
	return "<table style=\"width: 100%; border-spacing: 0;\"><tr "+customClass+"><td "+tdStyle+" >"+message+messageFilePermission+"</td></tr>"+fileName+"<tr "+customClass+"><td style=\"padding: 0;\" ><table class=\"logCode\" style=\"width: 100%;\">"+makePrettyWithText(escapeHTML(extraData["fileData"]["fileData"]), 0, {lineDisplay: logFormatFileLineCount, lineModifier: lineStart, type: "file", id: id})+"</table></td></tr></table>";
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
	let stringLengthMatch = -1;
	let fileData = "";
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
				let stringLength = dataKeyData.length;
				if(stringLength > stringLengthMatch)
				{
					fileData = arrayOfFileData[dataKeyData];
					stringLengthMatch = stringLength;
				}
			}
			else if (
				(checkIfTextIsError(arrayOfFileData[dataKeyData]["fileData"]) === 1 && logFormatFileHideError !== "true") ||
				(checkIfTextIsError(arrayOfFileData[dataKeyData]["fileData"]) === 0 && logFormatFileHideReadError !== "true")
				)
			{
				fileData = arrayOfFileData[dataKeyData];
				stringLengthMatch = 1;
			}
		}
	}
	return {
		match: stringLengthMatch,
		file: fileData
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
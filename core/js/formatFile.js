function formatFileLine(text, extraData) //used to check if file loaded
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
	}
	let id = 0;
	if("id" in extraData)
	{
		id = extraData["id"];
	}
	return "<table style=\"width: 100%;\"><tr "+customClass+"><td>"+message+filePermissions+"</td></tr><tr "+customClass+"><td><table class=\"logCode\" style=\"width: 100%;\">"+makePrettyWithText(escapeHTML(extraData["fileData"]["fileData"]), 0, {lineDisplay: logFormatFileLineCount, lineModifier: lineStart, type: "file", id: id})+"</table></td></tr></table>";
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
		let localMessageIndex = localMessage.indexOf(arrayOfFileDataKeys[AOFDCount]);
		if(localMessageIndex > -1 && arrayOfFileData[arrayOfFileDataKeys[AOFDCount]]["fileData"] !== "Error - File Not Found")
		{
			let stringLength = arrayOfFileDataKeys[AOFDCount].length;
			if(stringLength > stringLengthMatch)
			{
				fileData = arrayOfFileData[arrayOfFileDataKeys[AOFDCount]];
				stringLengthMatch = stringLength;
			}
		}
	}
	return {
		match: stringLengthMatch,
		file: fileData
	};
}
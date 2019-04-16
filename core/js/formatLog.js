function makePretty(id)
{
	try
	{
		var text = logs[id];
		var count = document.getElementById(id+"CountHidden").innerHTML;
		if(count !== "")
		{
			count = parseInt(count);
		}
		else
		{
			count = 0;
		}
		var returnText = makePrettyWithText(text, count, {id: id});
		if(returnText !== "")
		{
			return "<table width=\"100%\" style=\"border-spacing: 0;\">" + returnText + "</table>";
		}
		return "";
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function getPositionsOf(stringCheck, find, startBlock, endBlock)
{
	let posArr = {};
	let counter = 0;
	let base = 0;
	let findLength = find.length;
	while(stringCheck.indexOf(find) > -1)
	{
		posArr[counter] = {
			type: true,
			startBlock,
			endBlock,
			position: base + stringCheck.indexOf(find)
		};
		counter++;
		posArr[counter] = {
			type: false,
			startBlock,
			endBlock,
			position: base + stringCheck.indexOf(find) + findLength
		};
		counter++;
		base += stringCheck.indexOf(find) + findLength;
		stringCheck = stringCheck.substring(stringCheck.indexOf(find) + findLength);
	}
	return posArr;
}

function updatePositionOfArray(posArrArr, minOuter, minInner, lineToAdd)
{
	let posArrArrKeys = Object.keys(posArrArr);
	let posArrArrKeysLength = posArrArrKeys.length;
	for(let PAAKCount = 0; PAAKCount < posArrArrKeysLength; PAAKCount++)
	{
		if(PAAKCount < minOuter)
		{
			continue;
		}
		let innerArray = posArrArr[posArrArrKeys[PAAKCount]];
		let innerKeyCount = Object.keys(innerArray);
		let innerKeyCountLength = innerKeyCount.length;
		for(let IKCLCount = 0; IKCLCount < innerKeyCountLength; IKCLCount++)
		{
			if(innerArray[innerKeyCount[IKCLCount]]["position"] > minInner)
			{
				posArrArr[posArrArrKeys[PAAKCount]][innerKeyCount[IKCLCount]]["position"] += lineToAdd;
			}
		}
	}
	return posArrArr;
}

function makePrettyWithText(text, count, extraData = {})
{
	try
	{
		if(text === "")
		{
			return "";
		}
		var type = "log";
		if("type" in extraData && extraData["type"] !== "")
		{
			type = extraData["type"];
		}
		let localText = text.split("\n");
		if(localText.length < 2)
		{
			localText = localText[0].split("\\n");
		}
		var returnText = "";
		var lengthOfLocalTextArray = localText.length;
		var addLineCount = "false";
		var selectListForFilter = document.getElementsByName("searchType")[0];
		var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
		let filterTextFieldLocal = "";
		if(filterEnabled === "true")
		{
			let currentLogId = getLogIdFromText(text);
			if("id" in extraData)
			{
				currentLogId = extraData["id"];
			}
			filterTextFieldLocal = getFilterTextField(getPositionOfLogInLogDisplay(currentLogId));
		}
		if("lineDisplay" in extraData && extraData["lineDisplay"] === "true")
		{
			addLineCount = "true";
		}
		let formattedLogArr = formatTextIntoArray(text, count, extraData);
		let formattedLogArrKeys = Object.keys(formattedLogArr);
		let formattedLogArrKeysLength = formattedLogArrKeys.length;
		for(let FLAKCount = 0; FLAKCount < formattedLogArrKeysLength; FLAKCount++)
		{
			var lineCount = FLAKCount;
			if("lineModifier" in extraData)
			{
				lineCount += extraData["lineModifier"];
			}
			var lineText = formattedLogArr[formattedLogArrKeys[FLAKCount]];
			var customClass = " class = '";
			var customClassAdd = true;
			if(highlightNew === "true" && ((FLAKCount + count + 1) > formattedLogArrKeysLength))
			{
				customClass += " newLine ";
			}
			let filterHighlight = false;
			if(filterEnabled === "true" && selectedListFilterType === "content" && filterContentHighlight === "true" && filterTextFieldLocal !== "")
			{
				//check if match, and if supposed to highlight
				if(filterContentCheck(lineText, filterTextFieldLocal))
				{
					filterHighlight = true;
					if(filterContentHighlightLine === "true")
					{
						customClass += " highlight ";
					}
				}
			}
			if("id" in extraData)
			{
				let currentWindowId = 0;
				let logDisplayArrayKeys = Object.keys(logDisplayArray);
				let logDisplayArrayKeysCount = logDisplayArrayKeys.length;
				for(let i = 0; i < logDisplayArrayKeysCount; i++)
				{
					if(logDisplayArray[logDisplayArrayKeys[i]]["id"] === extraData["id"])
					{
						currentWindowId = i;
						break;
					}
				}
				customClass += " logLineHide logLineHide"+currentWindowId+" ";
			}
			customClass += " '";
			returnText += "<tr valign=\"top\"";
			if(customClassAdd)
			{
				returnText += " "+customClass+" ";
			}
			returnText += ">";
			let posArrArr = {};
			if(filterContentHighlightLine !== "true" && filterHighlight === true)
			{
				posArrArr[0] = getPositionsOf(lineText, filterTextFieldLocal, "<div class=\"highlightDiv\" >", "</div>");
			}
			let posArrArrKeys = Object.keys(posArrArr);
			let posArrArrKeysLength = posArrArrKeys.length;
			if(posArrArrKeysLength > 0)
			{
				for(let PAAKCount = 0; PAAKCount < posArrArrKeysLength; PAAKCount++)
				{
					let innerArray = posArrArr[posArrArrKeys[PAAKCount]];
					let innerKeyCount = Object.keys(innerArray);
					let innerKeyCountLength = innerKeyCount.length;
					for(let IKCLCount = 0; IKCLCount < innerKeyCountLength; IKCLCount++)
					{
						let newLine = "";
						if(filterInvert === "true")
						{
							newLine += currentAdd["startBlock"];
						}
						//update array values, length wont change though
						posArrArrKeys = Object.keys(posArrArr);
						innerArray = posArrArr[posArrArrKeys[PAAKCount]];
						innerKeyCount = Object.keys(innerArray);
						//add text to line
						let currentKey = innerKeyCount[IKCLCount];
						let currentAdd = innerArray[currentKey];
						let currentLinePosition = currentAdd["position"];
						newLine += lineText.slice(0, currentLinePosition);
						let currentType = currentAdd["type"];
						if(filterInvert === "true")
						{
							currentType = !currentType;
						}
						let addLine = 0;
						let lineType = "endBlock";
						if(currentType)
						{
							lineType = "startBlock";
						}
						newLine += currentAdd[lineType];
						addLine = currentAdd[lineType].length;
						newLine += lineText.slice(currentLinePosition);
						if(filterInvert === "true")
						{
							newLine += currentAdd["endBlock"];
						}
						lineText = newLine;
						//update other values in array
						posArrArr = updatePositionOfArray(posArrArr, PAAKCount, currentLinePosition, addLine);
					}
				}
			}
			let lineToReturn = "<td style=\"white-space: pre-wrap;\">"+lineText+"</td>";
			let colspan = 2;
			let addRowPadding = true;
			if(type === "log" && advancedLogFormatEnabled === "true")
			{
				let lastLine = "";
				let nextLine = "";
				if(formattedLogArrKeys[(FLAKCount-1)] in formattedLogArr)
				{
					lastLine = formattedLogArr[formattedLogArrKeys[FLAKCount-1]];
				}
				if(formattedLogArrKeys[(FLAKCount+1)] in formattedLogArr)
				{
					nextLine = formattedLogArr[formattedLogArrKeys[FLAKCount+1]];
				}
				//file formatting specific to logs
				lineToReturn = formatLine(lineText, {
					customClass,
					customClassAdd,
					lineDisplay : addLineCount,
					lineCount,
					lastLine,
					nextLine
				});
				if(dateTextFormatColumn === "true" || (dateTextFormatColumn === "auto" && window.innerWidth > breakPointTwo))
				{
					colspan = 3;
				}
			}
			else if (type === "file")
			{
				//formatting specific to files here
				lineToReturn = formatFileLine(lineText, {
					customClass,
					customClassAdd,
					lineDisplay : addLineCount,
					lineCount
				});
			}
			returnText += "<td style=\"width: 31px; padding: 0;\"></td>"+lineToReturn+"</tr>";
			if(addRowPadding)
			{
				returnText += "<tr class=\"logLinePaddingHeight\"><td class=\"logLineBorder\" colspan=\""+colspan+"\"></td></tr>";
			}
		}
		if(returnText === "")
		{
			return "";
		}
		return returnText;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function formatTextIntoArray(text, count, extraData = {})
{
	var newLogObject = {};
	var newLogCounter = 0;
	if(text === "")
	{
		return {};
	}
	text = text.split("\n");
	if(text.length < 2)
	{
		text = text[0].split("\\n");
	}
	var returnText = "";
	var lengthOfTextArray = text.length;
	var selectListForFilter = document.getElementsByName("searchType")[0];
	var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
	filterContentLinePadding = parseInt(filterContentLinePadding);
	var bottomPadding = filterContentLinePadding;
	var topPadding = filterContentLinePadding;
	var foundOne = false;
	var addLine = false;
	let filterTextFieldLocal = "";
	if(filterEnabled === "true")
	{
		let currentLogId = getLogIdFromText(text);
		if("id" in extraData)
		{
			currentLogId = extraData["id"];
		}
		filterTextFieldLocal = getFilterTextField(currentLogId);
	}
	for (var i = 0; i < lengthOfTextArray; i++)
	{
		addLine = true;
		if(filterEnabled === "true" && selectedListFilterType === "content" && filterContentLimit === "true" && filterTextFieldLocal !== "")
		{
			addLine = false;
			//check for content on current line
			if(filterContentCheck(text[i], filterTextFieldLocal))
			{
				//current line is thing, reset counter.
				bottomPadding = filterContentLinePadding;
				topPadding = filterContentLinePadding;
				addLine = true;
				foundOne = true;
			}
			else
			{
				//check for line in next few lines
				for (var j = 0; j <= bottomPadding; j++)
				{
					if(lengthOfTextArray > i+j)
					{
						if(filterContentCheck(text[i+j], filterTextFieldLocal))
						{
							addLine = true;
							bottomPadding--;
							break;
						}
					}
				}
				if(!addLine)
				{
					if(topPadding > 0 && foundOne)
					{
						addLine = true;
						topPadding--;
					}
					else
					{
						foundOne = false;
					}
				}
			}
		}
		if(addLine)
		{
			var lineText = text[i].split("\\n");
			var lengthOflineTextArray = lineText.length;
			for (var j = 0; j < lengthOflineTextArray; j++)
			{
				newLogObject[newLogCounter] = lineText[j];
				newLogCounter++;
			}
		}
	}
	return newLogObject;
}
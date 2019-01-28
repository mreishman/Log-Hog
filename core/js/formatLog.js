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
		var returnText = makePrettyWithText(text, count);
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
		var filterTextField = "";
		if(filterEnabled === "true")
		{
			filterTextField = getFilterTextField();
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
			var customClassAdd = false;
			if(highlightNew === "true" && ((FLAKCount + count + 1) > formattedLogArrKeysLength))
			{
				customClass += " newLine ";
				customClassAdd = true;
			}

			if(filterEnabled === "true" && selectedListFilterType === "content" && filterContentHighlight === "true" && filterTextField !== "")
			{
				//check if match, and if supposed to highlight
				if(filterContentCheck(lineText))
				{
					customClass += " highlight ";
					customClassAdd = true;
				}
			}

			customClass += " '";
			returnText += "<tr valign=\"top\"";
			if(customClassAdd)
			{
				returnText += " "+customClass+" ";
			}
			returnText += ">";
			var lineToReturn = "<td style=\"white-space: pre-wrap;\">"+lineText+"</td>";
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
			returnText += "<td style=\"width: 31px; padding: 0;\"></td>"+lineToReturn+"</tr><tr height=\""+logLinePadding+"px\"><td colspan=\"2\"></td></tr>";
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
	var filterTextField = "";
	if(filterEnabled === "true")
	{
		filterTextField = getFilterTextField();
	}
	for (var i = 0; i < lengthOfTextArray; i++)
	{
		addLine = true;
		if(filterEnabled === "true" && selectedListFilterType === "content" && filterContentLimit === "true" && filterTextField !== "")
		{
			addLine = false;
			//check for content on current line
			if(filterContentCheck(text[i]))
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
						if(filterContentCheck(text[i+j]))
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
			var filterTextField = "";
			if(filterEnabled === "true")
			{
				filterTextField = getFilterTextField();
			}
			for (var j = 0; j < lengthOflineTextArray; j++)
			{
				newLogObject[newLogCounter] = lineText[j];
				newLogCounter++;
			}
		}
	}
	return newLogObject;
}
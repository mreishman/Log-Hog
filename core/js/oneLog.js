var oneLogLogData = {
	id: "oneLog",
	logs: [{logName: "No Logs Updated", logData: "No logs have been updated", logId: "noLogUpdate"}]
};

function addOneLogTab() //check for file load
{
	var menu = $("#menu");
	var blank = $("#storage .menuItem").html();
	var nameForLog = "oneLog";
	classInsert = "";
	var item = blank;
	item = item.replace(/{{title}}/g, nameForLog);
	item = item.replace(/{{id}}/g, "oneLog");
	if(groupByColorEnabled === "true")
	{
		classInsert += " buttonColor1 ";
	}
	classInsert += " IgnoreAllGroupLogicGroup ";
	classInsert += " allGroup ";
	item = item.replace(/{{class}}/g, classInsert);
	var itemAdded = false;
	if(!itemAdded)
	{
		menu.append(item);
	}
}

function addOneLogData()
{
	oneLogLogData = {
		id: "oneLog",
		logs: [{logName: "No Logs Updated", logData: "No logs have been updated", logId: "noLogUpdate"}]
	};
	arrayOfDataMain["oneLog"] = {data: "", lineCount: "---", log: oneLogLogData, oneLog: true};
	logs["oneLog"] = oneLogLogData;
	titles["oneLog"] = "oneLog";
}

function toggleVisibleOneLog()
{
	if(document.getElementById("oneLogVisible").value === "false")
	{
		document.getElementById("oneLog").style.display = "none";
	}
	else
	{
		if(logMenuLocation === "left" || logMenuLocation === "right")
		{
			document.getElementById("oneLog").style.display = "block";
		}
		else
		{
			document.getElementById("oneLog").style.display = "inline-block";
		}
	}
}

function makeOneLogPretty()
{
	var htmlToReturn = "";
	var lengthOfArray = oneLogLogData["logs"].length;
	if(logDirectionInvert === "false")
	{
		for(var i = 0; i < lengthOfArray; i++)
		{
			htmlToReturn += makeOneLogPrettyLine(i);
		}
	}
	else
	{
		for(var i = lengthOfArray - 1; i >= 0; i--)
		{
			htmlToReturn += makeOneLogPrettyLine(i);
		}
	}
	logs["oneLog"] = oneLogLogData;
	return htmlToReturn;
}

function makeOneLogPrettyLine(i)
{
	var currentLogHtml = "";
	var currentLog = oneLogLogData["logs"][i];
	var currentHtmlForLog = makePrettyWithText(currentLog["logData"], 0);
	if(currentHtmlForLog === "")
	{
		return "";
	}
	currentHtmlForLog = "<table class=\"oneLogTable\" width=\"100%\" style=\"border-spacing: 0;\" >" + currentHtmlForLog + "</table>";
	currentLogHtml += "<div ";
	if(currentLog["logId"] !== "noLogUpdate")
	{
		currentLogHtml += "onclick=\"openLogInFull('"+currentLog["logId"]+"')\" ";
	}
	currentLogHtml += " class=\"settingsHeader ";
	if(currentLog["new"] === true)
	{
		if(highlightNew === "true" && (oneLogHighlight === "titleBar" || oneLogHighlight === "all"))
		{
			currentLogHtml += " newLine ";
		}
	}
	currentLogHtml += " \" style=\"padding-left: 40px; ";
	if(currentLog["logId"] !== "noLogUpdate")
	{
		currentLogHtml += " cursor: pointer; ";
	}
	currentLogHtml += " \" >"+currentLog["logName"]+"</div>";
	currentLogHtml += "<div class=\"settingsDiv ";
	if(currentLog["new"] === true)
	{
		oneLogLogData["logs"][i]["new"] = false;
		if(highlightNew === "true" && (oneLogHighlight === "body" || oneLogHighlight === "all"))
		{
			currentLogHtml += " newLine ";
		}
	}
	currentLogHtml += " \" style=\"max-height: "+oneLogLogMaxHeight+"px; overflow: auto;\" >"+currentHtmlForLog+"</div>";
	return currentLogHtml;
}

function oneLogInitialLoadCheck()
{
	if(oneLogLogData["logs"][0]["logId"] === "noLogUpdate")
	{
		oneLogLogData["logs"] = new Array();
	}
}

function isOneLogVisible()
{
	var logDisplayArrayKey = Object.keys(logDisplayArray);
	var logDisplayArrayKeyLength = logDisplayArrayKey.length;
	for(var logVisInLogDisCount = 0; logVisInLogDisCount < logDisplayArrayKeyLength; logVisInLogDisCount++)
	{
		if(logDisplayArray[logDisplayArrayKey[logVisInLogDisCount]]["id"] === "oneLog")
		{
			return logVisInLogDisCount;
		}
	}
	return false;
}

function closeToOneLogInFull(currentLogNum, currentOneLogPosition)
{
	document.getElementById("windowConfig").value = "1x1";
	generateWindowDisplayInner();
	changeCurrentSelectWindow(0);
	if(currentOneLogPosition === 0)
	{
		document.getElementById("oneLog").click();
	}
}

function switchBackToOnelog(currentLogNum)
{
	var initialPos = currentSelectWindow;
	if(initialPos !== currentLogNum)
	{
		changeCurrentSelectWindow(currentLogNum);
		document.getElementById("oneLog").click();
	}
	if(initialPos !== currentLogNum)
	{
		changeCurrentSelectWindow(initialPos);
	}
}

function scrollOneLogIfVisible(currentPosOfOneLog)
{
	$("#log"+currentPosOfOneLog).html(makeOneLogPretty());
	if(logDirectionInvert === "false")
	{
		scrollToBottom(currentPosOfOneLog);
	}
	else
	{
		scrollToTop(currentPosOfOneLog);
	}
}

function updateOneLogData(id, newDiff, newDiffText)
{
	if(newDiffText !== "")
	{
		//check if initial load
		oneLogInitialLoadCheck();
		var currentLengthOfOneLogLogs = oneLogLogData["logs"].length - 1;
		if(currentLengthOfOneLogLogs >= oneLogMaxLength)
		{
			oneLogLogData["logs"].shift();
			currentLengthOfOneLogLogs--;
		}
		if(oneLogMergeLast === "true" && currentLengthOfOneLogLogs >= 0 && oneLogLogData["logs"][currentLengthOfOneLogLogs]["logId"] === id)
		{
			//add to this one
			oneLogLogData["logs"][currentLengthOfOneLogLogs]["logData"] += "\n"+newDiffText;
			oneLogLogData["logs"][currentLengthOfOneLogLogs]["new"] = true;
		}
		else
		{
			var oneLogTitle = filterTitle(titles[id]) + newDiff;
			//create new entry below
			oneLogLogData["logs"].push({
				logName: oneLogTitle,
				logData: newDiffText,
				logId: id,
				new: true
			});
		}
		logs["oneLog"] = oneLogLogData;
	}
}

function openLogInFull(logId)
{
	var currentOneLogPosition = isOneLogVisible();
	if(oneLogNewBlockClick === "true")
	{
		var firstPosition = 0;
		var secondPosition = 1;
		var logDisplayArrayKey = Object.keys(logDisplayArray);
		var logDisplayArrayKeyLength = logDisplayArrayKey.length;
		var boolForGen = (logDisplayArrayKey === 1);
		if(boolForGen)
		{
			idOfOneLogOpen = logId;
			//generate window from 1 to 2
			document.getElementById("windowConfig").value = "1x2";
			if(oneLogNewBlockLocation === "bottom" || (window.innerWidth < breakPointTwo && oneLogNewBlockLocation === "auto"))
			{
				document.getElementById("windowConfig").value = "2x1";
			}
			generateWindowDisplayInner();
		}
		else
		{
			//already greater than 2, pick either one or two
			//check if already open
			for(var LDACount = 0; LDACount < logDisplayArrayKeyLength; LDACount++)
			{
				if(logId === logDisplayArray[logDisplayArrayKey[LDACount]]["id"])
				{
					//already visible
					$("#log"+LDACount+"Td tr").addClass("highlight");
					setTimeout(function()
					{
						$("#log"+LDACount+"Td tr").removeClass("highlight");
					}, 250, LDACount);
					return;
				}
			}
			if(currentOneLogPosition !== 0)
			{
				firstPosition = 1;
				secondPosition = 0;
			}
		}
		changeCurrentSelectWindow(secondPosition);
		document.getElementById(logId).click();
		changeCurrentSelectWindow(firstPosition);
		if(boolForGen)
		{
			document.getElementById("oneLog").click();
		}
	}
	else
	{
		idOfOneLogOpen = logId;
		changeCurrentSelectWindow(currentOneLogPosition);
		document.getElementById(logId).click();
	}
}

function possiblyUpdateOneLogVisibleData()
{
	var oneLogPos = isOneLogVisible();
	if(oneLogPos !== false)
	{
		if(!checkIfCurrentLogIsPaused(oneLogPos))
		{
			$("#log"+oneLogPos).html(makeOneLogPretty());
		}
	}
}

function resetOneLogData()
{
	addOneLogData();
	possiblyUpdateOneLogVisibleData();
}
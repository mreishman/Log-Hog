var oneLogLogData = {
	id: "oneLog",
	logs: [{logName: "No Logs Updated", logData: "No logs have been updated", logId: "noLogUpdate"}]
};

function addOneLogTab()
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
	var lengthOfArray = logs["oneLog"]["logs"].length;
	for(var i = 0; i < lengthOfArray; i++)
	{
		var currentLog = logs["oneLog"]["logs"][i];
		htmlToReturn += "<div ";
		if(currentLog["logId"] !== "noLogUpdate")
		{
			htmlToReturn += "onclick=\"openLogInFull('"+currentLog["logId"]+"')\" ";
		}
		htmlToReturn += " class=\"settingsHeader ";
		if(currentLog["new"] === true)
		{
			if(highlightNew === "true" && (oneLogHighlight === "titleBar" || oneLogHighlight === "all"))
			{
				htmlToReturn += " highlight "
			}
		}
		htmlToReturn += " \" style=\"padding-left: 40px; ";
		if(currentLog["logId"] !== "noLogUpdate")
		{
			htmlToReturn += " cursor: pointer; "
		}
		htmlToReturn += " \" >"+currentLog["logName"]+"</div>";
		htmlToReturn += "<div class=\"settingsDiv ";
		if(logs["oneLog"]["logs"]["new"] === true)
		{
			currentLog["new"] = false;
			if(highlightNew === "true" && (oneLogHighlight === "body" || oneLogHighlight === "all"))
			{
				htmlToReturn += " highlight "
			}
		}
		htmlToReturn += " \" style=\"max-height: "+oneLogLogMaxHeight+"px; overflow: auto;\" >"+makePrettyWithText(currentLog["logData"], 0)+"</div>";
	}
	return htmlToReturn;
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

function scrollOneLogIfVisible(currentPosOfOneLog)
{
	$("#log"+currentPosOfOneLog).html(makeOneLogPretty());
	scrollToBottom(currentPosOfOneLog);
}

function updateOneLogData(id, newDiff, newDiffText)
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
		oneLogLogData["logs"][currentLengthOfOneLogLogs]["logData"] += newDiffText;
		oneLogLogData["logs"][currentLengthOfOneLogLogs]["new"] = true;
	}
	else
	{
		var oneLogTitle = filterTitle(titles[id]);
		oneLogTitle += "("+newDiff+")";
		//create new entry below
		oneLogLogData["logs"].push({
			logName: oneLogTitle,
			logData: newDiffText,
			logId: id,
			new: true
		});
	}
}

function openLogInFull(logId)
{
	var currentOneLogPosition = isOneLogVisible();
	if(oneLogNewBlockClick === "true")
	{
		var firstPosition = 0;
		var secondPosition = 1;
		if(Object.keys(logDisplayArray).length === 1)
		{
			//generate window from 1 to 2
			document.getElementById("windowConfig").value = "1x2";
			generateWindowDisplayInner();
		}
		else
		{
			//already greater than 2, pick either one or two
			if(currentOneLogPosition !== 0)
			{
				firstPosition = 1;
				secondPosition = 0;
			}
		}
		changeCurrentSelectWindow(secondPosition);
		document.getElementById(logId).click();
		changeCurrentSelectWindow(firstPosition);
		document.getElementById("oneLog").click();
	}
	else
	{
		changeCurrentSelectWindow(currentOneLogPosition);
		document.getElementById(logId).click();
	}
}
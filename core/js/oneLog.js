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

function makeOneLogPretty(arrayOfLogs)
{
	var htmlToReturn = "";
	var lengthOfArray = arrayOfLogs.length;
	for(var i = 0; i < lengthOfArray; i++)
	{
		var currentLog = arrayOfLogs[i];
		htmlToReturn += "<div class=\"settingsHeader\" style=\"padding-left: 40px;\" >"+currentLog["logName"]+"</div>";
		htmlToReturn += "<div class=\"settingsDiv\" style=\"max-height: 200px; overflow: auto;\" >"+makePrettyWithText(currentLog["logData"], 0)+"</div>";
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

function scrollOneLogIfVisible()
{
	var currentPosOfOneLog = isOneLogVisible();
	if(currentPosOfOneLog !== false)
	{
		$("#log"+currentPosOfOneLog).html(makeOneLogPretty(logs["oneLog"]["logs"]));
		scrollToBottom(currentPosOfOneLog);
	}
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
	if(currentLengthOfOneLogLogs >= 0 && oneLogLogData["logs"][currentLengthOfOneLogLogs]["logId"] === id)
	{
		//add to this one
		oneLogLogData["logs"][currentLengthOfOneLogLogs]["logId"] += newDiffText
	}
	else
	{
		var oneLogTitle = titles[id];
		if(titles[id].indexOf("|") > -1)
		{
			oneLogTitle = titles[id].split("|")[0];
		}
		oneLogTitle += "("+newDiff+")";
		//create new entry below
		oneLogLogData["logs"].push({
			logName: oneLogTitle,
			logData: newDiffText,
			logId: id
		});
	}
}
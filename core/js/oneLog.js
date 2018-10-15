function addOneLogTab()
{
	var menu = $("#menu");
	var blank = $("#storage .menuItem").html();
	var nameForLog = "New";
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
	var logData = {
		id: "oneLog",
		logs: [{logName: "No Logs Updated", logData: "No logs have been updated", logId: "noLogUpdate"}]
	};
	arrayOfDataMain["oneLog"] = {data: "", lineCount: "---", log: logData, oneLog: true};
	logs["oneLog"] = logData;
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
		document.getElementById("oneLog").style.display = "inline-block";
	}
}


function makeOneLogPretty(arrayOfLogs)
{
	var htmlToReturn = "";
	var lengthOfArray = arrayOfLogs.length;
	for(var i = 0; i < lengthOfArray; i++)
	{
		var currentLog = arrayOfLogs[i];
		htmlToReturn += "<div class=\"settingsHeader\">"+currentLog["logName"]+"</div>";
		htmlToReturn += "<div class=\"settingsDiv\">"+makePrettyWithText(currentLog["logData"], 0)+"</div>";
	}
	return htmlToReturn;
}
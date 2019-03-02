function archiveAction(title)
{
	if(saveTmpLogOnClear === "true" && enableHistory === "true")
	{
		var dataToSend = {subFolder: "tmp/loghogBackupHistoryLogs/", key: title, log: arrayOfDataMain[title]["log"]};
		$.ajax({
				url: "core/php/saveTmpVersionOfLog.php?format=json",
				dataType: "json",
				data: dataToSend,
				type: "POST",
		success(data){},
		});
	}
}

function archiveLogPopupToggle()
{
	//get list of logs in tmpbackup
	if(document.getElementById("fullScreenMenu").style.display !== "none")
	{
		toggleFullScreenMenu();
	}
	if(document.getElementById("historyDropdown").style.display === "inline-block")
	{
		document.getElementById("historyDropdown").style.display = "none";
	}
	else
	{
		getListOfArchiveLogs();
		document.getElementById("historyDropdown").style.display = "inline-block";
		document.getElementById("historyDropdown").style.left = (document.getElementById("historyImage").getBoundingClientRect().left-21) + "px";
		document.getElementById("historyDropdown").style.top = (document.getElementById("historyImage").getBoundingClientRect().top+25) + "px";
	}
}

function getListOfArchiveLogs()
{
	$.ajax({
			url: "core/php/getListOfTmpLogs.php?format=json",
			dataType: "json",
			data: {},
			type: "POST",
	success(data){
		showHistory(data);
	}});
}

function showHistory(data)
{
	$("#historyHolder").html('');
	var htmlForHistory = "No Log History To Display";
	if(data)
	{
		htmlForHistory = "<table style=\"width: 100%;\" ><tr><td width=\"55%\" ></td><td  width=\"45%\" ></td></tr>";
		var historyKeys = Object.keys(data);
		var historyKeysLength = historyKeys.length;
		if(historyKeysLength === 0)
		{
			htmlForHistory += "<tr><td colspan=\"2\" >No Log Backups To Display</td></tr>"
		}
		else
		{
			for(var historyKey = 0; historyKey < historyKeysLength; historyKey++)
			{
				var historyName = data[historyKeys[historyKey]].replace(/_DIR_/g, "/").replace("Backup/", "");
				htmlForHistory += "<tr><td style=\"word-break:break-all\" >"+historyName+"</td><td>";
				if("LogHog/"+data[historyKeys[historyKey]].replace(/_DIR_/g, "/") in arrayOfDataMain)
				{
					htmlForHistory += "<a class=\"linkSmall\" onclick=\"hideArchiveLog('"+data[historyKeys[historyKey]]+"')\" >Hide</a> ";
				}
				else
				{
					htmlForHistory += "<a class=\"linkSmall\" onclick=\"viewArchiveLog('"+data[historyKeys[historyKey]]+"')\" >View</a> ";
				}
				htmlForHistory += " <a onclick=\"deleteArchiveLog('"+data[historyKeys[historyKey]]+"')\" class=\"linkSmall\" >Delete</a></td></tr>";
			}
		}
		htmlForHistory += "</table>";
	}
	$("#historyHolder").html(htmlForHistory);
	$("#historyHolder").append($("#storage .historyButtons").html());
}

function hideArchiveLog(title)
{
	var newTitle = "LogHog/"+title.replace(/_DIR_/g, "/");
	archiveLogPopupToggle();
	removeNotificationByLog(newTitle.replace(/[^a-z0-9]/g, ""));
	delete arrayOfDataMain[newTitle];
	$("#"+newTitle.replace(/[^a-z0-9]/g, "")).remove();
	var logDisplayArrayLength = Object.keys(logDisplayArray).length;
	for(logDisplayArrayCount = 0; logDisplayArrayCount < logDisplayArrayLength; logDisplayArrayCount++)
	{
		if(logDisplayArray[logDisplayArrayCount]["id"] === newTitle.replace(/[^a-z0-9]/g, ""))
		{
			logDisplayArray[logDisplayArrayCount] = {id: null, scroll: true, pin: false};
			selectTabsInOrder(logDisplayArrayLength);
			break;
		}
	}
	resize();
}

function viewArchiveLog(title)
{
	loadImgFromData("archiveLogImages");
	archiveLogPopupToggle();
	var dataToSend = {file: title};
	$.ajax({
			url: "core/php/getTmpVersionOfLog.php?format=json",
			dataType: "json",
			data: dataToSend,
			type: "POST",
	success(data){
		arrayOfDataMain["LogHog/"+title.replace(/_DIR_/g, "/")] = {log: data, data: "", lineCount: "---"};
		generalUpdate();
	}});
}

function deleteArchiveLog(title)
{
	archiveLogPopupToggle();
	var dataToSend = {file: title};
	$.ajax({
			url: "core/php/deleteArchiveLog.php?format=json",
			dataType: "json",
			data: dataToSend,
			type: "POST",
	success(data){
		delete arrayOfDataMain["LogHog/"+title.replace(/_DIR_/g, "/")];
		generalUpdate();
	}});
}

function clearAllArchiveLogs()
{
	archiveLogPopupToggle();
	$.ajax({
			url: "core/php/deleteAllArchiveLogs.php?format=json",
			dataType: "json",
			data: dataToSend,
			type: "POST",
	success(data){
		var arrayOfDataMainKeys = Object.keys(arrayOfDataMain);
		var arrayOfDataMainKeysLength = arrayOfDataMainKeys.length;
		for(var aodkcount = 0; aodkcount < arrayOfDataMainKeysLength; aodkcount++)
		{
			if(arrayOfDataMainKeys[aodkcount].indexOf("LogHog/Backup") === 0)
			{
				delete arrayOfDataMain[arrayOfDataMainKeys[aodkcount]];
			}
		}
		generalUpdate();
	}});
}

function removeArchiveLogFromDisplay(currentLogNum)
{
	var archiveLogId = logDisplayArray[currentLogNum]["id"];
	$("#"+archiveLogId).remove();
	removeNotificationByLog(archiveLogId);
	var aodmKeys = Object.keys(arrayOfDataMain);
	var aodmKeysLength = aodmKeys.length;
	for(var archiveRemoveCount = 0; archiveRemoveCount < aodmKeysLength; archiveRemoveCount++)
	{
		if(aodmKeys[archiveRemoveCount].indexOf("LogHog/Backup") > -1)
		{
			if(aodmKeys[archiveRemoveCount].replace(/[^a-z0-9]/g, "") === archiveLogId)
			{
				delete arrayOfDataMain[aodmKeys[archiveRemoveCount]];
				break;
			}
		}
	}
	logDisplayArray[currentLogNum] = {id: null, scroll: true, pin: false};
	selectTabsInOrder(Object.keys(logDisplayArray).length);
	resize();
}
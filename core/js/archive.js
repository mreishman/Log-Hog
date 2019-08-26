function archiveAction(title, type) //used to check if file is loaded
{
	if(saveTmpLogOnClear === "true" && enableHistory === "true")
	{
		let folder = "loghogBackupArchiveLogs";
		if(type !== "archive")
		{
			folder = "loghogBackupHistoryLogs";
		}
		var dataToSend = {subFolder: "tmp/"+folder+"/", key: title, log: arrayOfDataMain[title]["log"], formKey};
		$.ajax({
				url: "core/php/saveTmpVersionOfLog.php?format=json",
				dataType: "json",
				data: dataToSend,
				type: "POST",
		success(data){
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = "error.php?error="+data["error"]+"&page=saveTmpVersionOfLog.php";
            }
			else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = "error.php?error="+data["error"]+"&page=saveTmpVersionOfLog.php";
            }
			else if(document.getElementById("popup").style.display !== "none")
			{
				saveSuccess();
				fadeOutPopup();
			}
		},
		});
	}
}

function getListOfTmpHistoryLogs()
{
	$.ajax({
			url: "core/php/getListOfTmpLogs.php?format=json",
			dataType: "json",
			data: {
				type: "temp",
				formKey
			},
			type: "POST",
	success(data){
		if(typeof data === "object"  && "error" in data)
        {
            window.location.href = "error.php?error="+data["error"]+"&page=getListOfTmpLogs.php";
        }
		else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
        {
        	data = JSON.parse(data);
        	window.location.href = "error.php?error="+data["error"]+"&page=getListOfTmpLogs.php";
        }
		else
		{
			showHistory(data);
		}
	}});
}

function showHistory(data)
{
	$("#historyHolder").html('');
	let htmlForHistory = "<table width=\"100%\" ><tr><td></td><td></td></tr>";
	htmlForHistory += "<tr><td style=\"text-align: center;\" colspan=\"2\" ><h2>No Log Backups To Display</h2></td></tr>";
	if(data)
	{
		htmlForHistory = archiveListActions(data, htmlForHistory, "tmp");
	}
	htmlForHistory += "</table>";
	$("#historyHolder").html(htmlForHistory);
	$("#historyHolder").append($("#storage .historyButtons").html());
}

function getListOfArchiveLogs()
{
	$.ajax({
			url: "core/php/getListOfTmpLogs.php?format=json",
			dataType: "json",
			data: {
				type: "archive",
				formKey
			},
			type: "POST",
	success(data){
		if(typeof data === "object"  && "error" in data)
        {
            window.location.href = "error.php?error="+data["error"]+"&page=getListOfTmpLogs.php";
        }
		else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
        {
        	data = JSON.parse(data);
        	window.location.href = "error.php?error="+data["error"]+"&page=getListOfTmpLogs.php";
        }
		else
		{
			showArchive(data);
		}
	}});
}

function showArchive(data)
{
	$("#archiveHolder").html('');
	let htmlForHistory = "<table width=\"100%\" ><tr><td></td><td></td></tr><tr><td style=\"text-align: center;\" colspan=\"2\" ><h2>No Log Backups To Display</h2></td></tr></table>"
	if(data)
	{
		htmlForHistory = archiveListActions(data, htmlForHistory, "archive");
	}
	$("#archiveHolder").html(htmlForHistory);
	$("#archiveHolder").append($("#storage .archiveButtons").html());
}

function archiveListActions(data, defaultText = "", type)
{
	htmlForActionList = defaultText;
	let historyKeys = Object.keys(data);
	let historyKeysLength = historyKeys.length;
	if(historyKeysLength !== 0)
	{
		htmlForActionList = "<table><tr><td></td><td></td></tr>";
		for(let historyKey = 0; historyKey < historyKeysLength; historyKey++)
		{
			let historyName = data[historyKeys[historyKey]].replace(/_DIR_/g, "/").replace("Backup/", "");
			htmlForActionList += "<tr><td style=\"word-break:break-all\" >"+historyName+"</td><td>";
			if("LogHog/"+data[historyKeys[historyKey]].replace(/_DIR_/g, "/") in arrayOfDataMain)
			{
				htmlForActionList += "<a class=\"linkSmall\" onclick=\"hideArchiveLog('"+escapeTheEscapes(data[historyKeys[historyKey]])+"')\" >Hide</a> ";
			}
			else
			{
				htmlForActionList += "<a class=\"linkSmall\" onclick=\"viewArchiveLog('"+escapeTheEscapes(data[historyKeys[historyKey]])+"', '"+type+"')\" >View</a> ";
			}
			htmlForActionList += " <a onclick=\"deleteArchiveLog('"+data[historyKeys[historyKey]]+"','archive')\" class=\"linkSmall\" >Delete</a></td></tr>";
		}
	}
	htmlForActionList += "</table>";
	return htmlForActionList;
}

function hideArchiveLog(title)
{
	var newTitle = "LogHog/"+title.replace(/_DIR_/g, "/");
	toggleFullScreenMenu();
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

function viewArchiveLog(title, type)
{
	loadImgFromData("archiveLogImages");
	if(document.getElementById("fullScreenMenu").style.display !== "none")
	{
		toggleFullScreenMenu();
	}
	if(document.getElementById("popupContent").style.display !== "none")
	{
		fadeOutPopup();
	}
	var dataToSend = {file: title, type, formKey};
	$.ajax({
			url: "core/php/getTmpVersionOfLog.php?format=json",
			dataType: "json",
			data: dataToSend,
			type: "POST",
	success(data){
		if(typeof data === "object"  && "error" in data)
        {
            window.location.href = "error.php?error="+data["data"]+"&page=getTmpVersionOfLog.php";
        }
		else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
        {
        	data = JSON.parse(data);
        	window.location.href = "error.php?error="+data["error"]+"&page=getTmpVersionOfLog.php";
        }
		else
		{
			arrayOfDataMain["LogHog/"+title.replace(/_DIR_/g, "/")] = {log: data, data: "", lineCount: "---"};
			generalUpdate();
		}
	}});
}

function deleteArchiveLog(title, type)
{
	var dataToSend = {file: title, type, formKey};
	$.ajax({
			url: "core/php/deleteArchiveLog.php?format=json",
			dataType: "json",
			data: dataToSend,
			type: "POST",
	success(data){
		if(typeof data === "object"  && "error" in data)
        {
            window.location.href = "error.php?error="+data["error"]+"&page=deleteArchiveLog.php";
        }
		else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
        {
        	data = JSON.parse(data);
        	window.location.href = "error.php?error="+data["error"]+"&page=deleteArchiveLog.php";
        }
		delete arrayOfDataMain["LogHog/"+title.replace(/_DIR_/g, "/")];
		generalUpdate();
		if(type !== "archive")
		{
			getListOfTmpHistoryLogs();
		}
		else
		{
			getListOfArchiveLogs();
		}
	}});
}

function clearAllArchiveLogs(type)
{
	$.ajax({
			url: "core/php/deleteAllArchiveLogs.php?format=json",
			dataType: "json",
			data: {type, formKey},
			type: "POST",
	success(data){
		if(typeof data === "object"  && "error" in data)
        {
            window.location.href = "error.php?error="+data["error"]+"&page=deleteAllArchiveLogs.php";
        }
		else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
        {
        	data = JSON.parse(data);
        	window.location.href = "error.php?error="+data["error"]+"&page=deleteAllArchiveLogs.php";
        }
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
		if(type !== "archive")
		{
			getListOfTmpHistoryLogs();
		}
		else
		{
			getListOfArchiveLogs();
		}
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

function viewBackupFromCurrentLog(currentLogNum)
{
	displayLoadingPopup('','Generating List');
	var logId = logDisplayArray[currentLogNum]["id"];
	$.ajax({
			url: "core/php/getListOfTmpLogs.php?format=json",
			dataType: "json",
			data: {
				type: "archive",
				formKey
			},
			type: "POST",
	success(data){
		if(typeof data === "object"  && "error" in data)
        {
            window.location.href = "error.php?error="+data["error"]+"&page=getListOfTmpLogs.php";
        }
		else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
        {
        	data = JSON.parse(data);
        	window.location.href = "error.php?error="+data["error"]+"&page=getListOfTmpLogs.php";
        }
		//show popup of no backupg, show list of backup logs found if found
		var archiveList = filterArrForPopup(data, logId);
			$.ajax({
				url: "core/php/getListOfTmpLogs.php?format=json",
				dataType: "json",
				data: {
					type: "tmp",
					formKey
				},
				type: "POST",
		success(data){
			if(typeof data === "object"  && "error" in data)
	        {
	            window.location.href = "error.php?error="+data["error"]+"&page=getListOfTmpLogs.php";
	        }
			else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
	        {
	        	data = JSON.parse(data);
	        	window.location.href = "error.php?error="+data["error"]+"&page=getListOfTmpLogs.php";
	        }
			//show popup of no backupg, show list of backup logs found if found
			var archiveList2 = filterArrForPopup(data, logId);
			if(archiveList.length !== 0 || archiveList2.length !== 0)
			{
				let popupHtml = "";
				if(archiveList2.length !== 0)
				{
					//history
					popupHtml += "<div class='settingsHeader' >History</div><br>";
					popupHtml += htmlForHistory = archiveListActions(archiveList2, "", "tmp");
				}
				if(archiveList.length !== 0)
				{
					//archive
					popupHtml += "<div class='settingsHeader' >Archive</div><br>";
					popupHtml += htmlForHistory = archiveListActions(archiveList, "", "archive");
				}
				popupHtml += "<div class='link' onclick='hidePopup();' style='margin-left:163px; margin-top:25px;'>Close</div>";
				document.getElementById("popupContentInnerHTMLDiv").innerHTML = popupHtml;
				document.getElementById("popupContent").style.overflow = "auto";
				document.getElementById("popupContent").style.height = "300px";
				document.getElementById("popupContent").style.marginTop = "-150px";
			}
			else
			{
				//show popup for no files
				document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >History</div><br><br><div style='width:100%;text-align:center;'> No Archived Files</div><div class='link' onclick='hidePopup();' style='margin-left:163px; margin-top:25px;'>Close</div>";
			}
		}});
	}});
}

function filterArrForPopup(data, logId)
{
	let found = []
	if(data)
	{
		let historyKeys = Object.keys(data);
		let historyKeysLength = historyKeys.length;
		if(historyKeysLength !== 0)
		{
			for(let historyKey = 0; historyKey < historyKeysLength; historyKey++)
			{
				//check if this file matches current data
				let testName = filterIdText(data[historyKeys[historyKey]].split("_DIR_").join(""));
				if(testName.indexOf(logId) > -1)
				{
					found.push(data[historyKeys[historyKey]]);
				}
			}
		}
	}
	return found;
}

function saveArchivePopup(currentLogNum)
{
	let title = document.getElementById("title"+currentLogNum).textContent;
	title = filterTitle(title);
	displayLoadingPopup('','Saving...');
	archiveAction(title, 'archive');
}
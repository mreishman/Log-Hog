var alertEnabledArray = {};
var allLogOneLog = {};
var arrayToUpdate = {};
var arrayOfData1 = null;
var arrayOfData2 = null;
var arrayOfDataMain = null;
var arrayOfDataSettings = [];
var arrayOfFileData = [];
var arrayOfScrollHeaderUpdate = ["aboutSpanAbout","aboutSpanInfo","aboutSpanGithub"];
var borderPadding = 0;
var breakPointOne = 1400;
var breakPointTwo = 1000;
var clearingNotifications = false;
var counterForPoll = 0;
var counterForPollForceRefreshAll = 0;
var counterForPollForceRefreshErr = 0;
var currentPage;
var currentSelectWindow = 0;
var dataFromUpdateCheck = null;
var fileData;
var filesNew;
var firstLoad = true;
var flasher;
var folderColorGroupNames = ["Main","Highlight","Active","ActiveHighlight"];
var fullScreenMenuClickCount = 0;
var globalForcePageNavigate = false;
var hiddenLogUpdatePollBottom = null;
var hiddenLogUpdatePollTop = null;
var inlineNotificationPoll = null;
var inlineNotificationPollArray = [];
var lastContentSearch = "";
var lastLogs = {};
var logDisplayArray = {};
var logDisplayArrayOld = {};
var logLines = {};
var logs = {};
var logsToHide = new Array();
var notifications = new Array();
var pausePollCurrentSession = false;
var percent = 0;
var polling = false;
var pollingRateBackup = 0;
var pollRefreshAllBoolStatic = pollRefreshAllBool;
var pollSkipCounter = 0;
var pollTimer = null;
var progressBar;
var refreshing = false;
var refreshPauseActionVar;
var sideBarVisible = true;
var startedPauseOnNonFocus = false;
var startOfPollLogicRan = false;
var t0 = performance.now();
var t1 = performance.now();
var t2 = performance.now();
var t3 = performance.now();
var timeoutVar = null;
var timer;
var timerForSettings;
var timerForWatchlist;
var titles = {};
var urlForAddonSend = "core/php/template/innerAddon.php";
var urlForSendMain = "core/php/performSettingsInstallUpdateAction.php?format=json";
var updateFromID = "settingsInstallUpdate";
var updating = false;
var userPaused = false;
var title = $("title").text();
var verifyChangeCounter = 0;


function popupSettingsArrayCheck()
{
	if (typeof popupSettingsArray === "string")
	{
		popupSettingsArray = JSON.parse(popupSettingsArray);
	}
}


function escapeHTML(unsafeStr)
{
	try
	{
		return unsafeStr.toString()
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/\"/g, "&quot;")
		.replace(/\'/g, "&#39;")
		.replace(/\//g, "&#x2F;");
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function unescapeHTML(unsafeStr)
{
	try
	{
		return unsafeStr.toString()
		.replace(/&amp;/g, "&")
		.replace(/&lt;/g, "<")
		.replace(/&gt;/g, ">")
		.replace(/&quot;/g, "\"")
		.replace(/&#39;/g, "\'")
		.replace(/&#x2F;/g, "\/");
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function formatBytes(bytes,decimals)
{
	if(parseInt(bytes) === 0)
	{
		return "0 Bytes";
	}
	var k = 1024;
	var dm = decimals || 2;
	var sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
	var i = Math.floor(Math.log(bytes) / Math.log(k));
	return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + " " + sizes[i];
}

function updateSkipCounterLog(num)
{
	try
	{
		if(enablePollTimeLogging !== "false")
		{
			document.getElementById("loggSkipCount").innerHTML = escapeHTML(num);
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function updateAllRefreshCounter(num)
{
	try
	{
		if(enablePollTimeLogging !== "false")
		{
			document.getElementById("loggAllCount").innerHTML = escapeHTML(num);
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function updateLogTitle(id)
{
	var tmpText = "";
	var buttonReference = document.getElementById("menu").getElementsByClassName(id+"Button")[0];
	if(logTitle === "lastLine")
	{
		tmpText = logs[id].split("\n");
		var tmpTextLength = tmpText.length;
		tmpText = unescapeHTML(tmpText[tmpTextLength-1]);
	}
	else if(logTitle === "filePath")
	{
		tmpText = titles[id];
	}
	if(buttonReference.title !== tmpText)
	{
		buttonReference.title = tmpText;
	}
}

function updateDocumentTitle(updateText)
{
	try
	{
		if(document.title !== "Log Hog | "+updateText)
		{
			document.title = "Log Hog | "+updateText;
			title = updateText;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function poll()
{
	try
	{
		checkForUpdateMaybe();
		if(notificationInlineShow === "true")
		{
			tryToStartNotificationInlinePoll();
		}
		if(refreshing)
		{
			updateDocumentTitle("Refreshing");
		}
		else
		{
			updateDocumentTitle("Index");
		}
		counterForPoll++;
		if(!polling && !clearingNotifications)
		{
			pollSkipCounter = 0;
			updateSkipCounterLog(pollSkipCounter);
			polling = true;
			t0 = performance.now();
			pollTwo();
		}
		else
		{
			if(pollForceTrueBool === "true" && firstLoad !== true && !clearingNotifications)
			{
				pollSkipCounter++;
				updateSkipCounterLog(pollSkipCounter);
				if(pollSkipCounter > pollForceTrue)
				{
					pollSkipCounter = 0;
					polling = false;
					updateSkipCounterLog(pollSkipCounter);
				}
			}
			else
			{
				updateSkipCounterLog("-");
			}
			counterForPollForceRefreshErr++;
			if(counterForPollForceRefreshErr > (2 * pollForceTrue))
			{
				showNoticeBarIfNotThere();
				if(counterForPollForceRefreshErr > (4 * pollForceTrue))
				{
					//show Warning message for no connect in x times
					if(document.getElementById("connectionWarning").style.display === "none")
					{
						document.getElementById("connectionWarning").style.display = "block";
					}
					if(document.getElementById("connectionNotice").style.display !== "none")
					{
						document.getElementById("connectionNotice").style.display = "none";
					}
				}
				else if(counterForPollForceRefreshErr > (2 * pollForceTrue))
				{
					//show notice message of no connect in x times 
					if(document.getElementById("connectionNotice").style.display === "none")
					{
						document.getElementById("connectionNotice").style.display = "block";
					}
					if(document.getElementById("connectionWarning").style.display !== "none")
					{
						document.getElementById("connectionWarning").style.display = "none";
					}
				}
				resize();
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function pollTwo()
{
	try
	{
		var urlForSend = "core/php/pollCheck.php?format=json";
		var data = {currentVersion, fileData};
		$.ajax({
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				hideNoticeBarIfThere();
				if(document.getElementById("noLogToDisplay").style.display !== "none" && (!(data === [] || $.isEmptyObject(data))))
				{
					document.getElementById("noLogToDisplay").style.display = "none";
				}

				if(data === "error in file permissions")
				{
					clearPollTimer();
					window.location.href = "error.php?error=550&page=pollCheck.php";
				}
				else if(data === "update in progress")
				{
					clearPollTimer();
					window.location.href = "update/updateInProgress.php";
				}
				else if(data === false)
				{
					clearPollTimer();
					showPopup();
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Log-Hog has been updated. Please Refresh</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Log-Hog has been updated, and is now on a new version. Please refresh the page.</div><div><div class='link' onclick='location.reload();' style='margin-left:165px; margin-right:50px;margin-top:35px;'>Reload</div></div>";
				}
				else if(data === [] || $.isEmptyObject(data))
				{
					if(document.getElementById("noLogToDisplay").style.display !== "block")
					{
						document.getElementById("noLogToDisplay").style.display = "block";
					}
					if(firstLoad)
					{
						firstLoadEndAction();
					}
				}
				else
				{
					fileData = data;
					if(!firstLoad)
					{
						updateGroupsOnTabs(data, getArrayOfGroups(data));
						removeOldGroups(data, getArrayOfGroups(data));
					}
					pollTwoPartTwo(data);
					if(lineCountFromJS === "false")
					{
						updatePollLineDiff(data);
					}
				}
			},
			failure(data)
			{
				polling = false;
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function hideNoticeBarIfThere()
{
	counterForPollForceRefreshErr = 0;
	if(document.getElementById("noticeBar").style.display !== "none")
	{
		document.getElementById("noticeBar").style.display = "none";
		resizeNotificationCounter();
	}
}

function showNoticeBarIfNotThere()
{
	if(document.getElementById("noticeBar").style.display === "none")
	{
		document.getElementById("noticeBar").style.display = "block";
		resizeNotificationCounter();
	}
}

function updatePollLineDiff(data)
{
	newLineCount = Object.keys(data);
	countLength = newLineCount.length;
	for(var i = 0; i < countLength; i++)
	{
		var currentLog = newLineCount[i];
		if(currentLog in fileData)
		{
			logLines[currentLog] = 0;
			if(data[currentLog]["lineCount"] > fileData[currentLog]["lineCount"])
			{
				logLines[currentLog] = data[currentLog]["lineCount"] - fileData[currentLog]["lineCount"];
			}
		}
		else
		{
			logLines[currentLog] = data[currentLog]["lineCount"];
		}
	}
}

function pollTwoPartTwo(data)
{
	try
	{
		if(firstLoad)
		{
			updateProgressBar(10, "Generating File Object");
		}
		t2 = performance.now();
		filesNew = Object.keys(data);
		var backupArrayOfDataMain = arrayOfDataMain;
		if(arrayOfDataMain !== null)
		{
			var arrayOfDataMainKeys = Object.keys(arrayOfDataMain);
			for (var i = arrayOfDataMainKeys.length - 1; i >= 0; i--) 
			{
				if(arrayOfDataMainKeys[i] in data || arrayOfDataMainKeys[i].indexOf("LogHog/Backup") > -1 || arrayOfDataMainKeys[i].indexOf("oneLog") > -1 )
				{
					continue;
				}
				delete arrayOfDataMain[arrayOfDataMainKeys[i]];
			}
		}

		//check for all update force
		var boolForAllUpdateForce = false;
		if(pollRefreshAllBool === "true")
		{
			updateAllRefreshCounter(counterForPollForceRefreshAll);
			counterForPollForceRefreshAll++;
			if(counterForPollForceRefreshAll > pollRefreshAll)
			{
				counterForPollForceRefreshAll = 0;
				boolForAllUpdateForce = true;
				updateAllRefreshCounter(counterForPollForceRefreshAll);
			}
		}
		else
		{
			updateAllRefreshCounter("-");
		}

		arrayToUpdate = {};

		if(arrayOfData1 === null || boolForAllUpdateForce)
		{
			arrayOfData1 = data;
			for (var updateCount = filesNew.length - 1; updateCount >= 0; updateCount--)
			{
				if($.inArray(filesNew[updateCount].replace(/[^a-z0-9]/g, ""), logsToHide) !== -1)
				{
					continue;
				}
				arrayToUpdate[filesNew[updateCount]] = data[filesNew[updateCount]];
				addToGroupTab(data[filesNew[updateCount]]["Group"]);
			}
		}
		else
		{
			var arrayOfData2 = data;
			var filesOld = Object.keys(arrayOfData1);
			for (var updateOldCount = filesNew.length - 1; updateOldCount >= 0; updateOldCount--)
			{
				if($.inArray(filesNew[updateOldCount].replace(/[^a-z0-9]/g, ""), logsToHide) !== -1)
				{
					continue;
				}
				if(filesOld.indexOf(filesNew[updateOldCount]) > -1)
				{
					//file exists
					if(JSON.stringify(arrayOfData2[filesNew[updateOldCount]]) !== JSON.stringify(arrayOfData1[filesNew[updateOldCount]]))
					{
						arrayToUpdate[filesNew[updateOldCount]] = data[filesNew[updateOldCount]];
					}
				}
				else
				{
					//file is new, add to array
					arrayToUpdate[filesNew[updateOldCount]] = data[filesNew[updateOldCount]];
				}
				addToGroupTab(data[filesNew[updateOldCount]]["Group"]);
			}

			for (var oldSwapCount = filesOld.length - 1; oldSwapCount >= 0; oldSwapCount--)
			{
				if(!(filesNew.indexOf(filesOld[oldSwapCount]) > -1))
				{
					//files old file isn't there in new file
					arrayToUpdate[filesOld[oldSwapCount]] = arrayOfData1[filesOld[oldSwapCount]];
				}
			}
			arrayOfData1 = data;
		}
		pollThree(arrayToUpdate);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function pollThree(arrayToUpdate)
{
	try
	{
		var arrayUpdateKeys = Object.keys(arrayToUpdate);
		t3 = performance.now();
		if (typeof arrayToUpdate !== "undefined" && arrayUpdateKeys.length > 0) 
		{
			if(firstLoad)
			{
				var currentFileSize = fileData[arrayUpdateKeys[0]]["size"];
				if(currentFileSize !== "" && currentFileSize >= 0)
				{
					currentFileSize = formatBytes(currentFileSize);
				}
				else
				{
					currentFileSize = "Unknown File Size";
				}
				updateProgressBar(10,arrayUpdateKeys[0],  "Loading file 1 of "+arrayUpdateKeys.length+" <br>  "+currentFileSize);
				getFileSingle(arrayUpdateKeys.length-1, arrayUpdateKeys.length-1);
			}
			else
			{
				var urlForSend = "core/php/poll.php?format=json";
				var data = {arrayToUpdate};
				$.ajax({
					url: urlForSend,
					dataType: "json",
					data,
					type: "POST",
					success(data)
					{
						arrayOfDataMainDataFilter(data);
						updateFileDataArray(data);
						update(data);
					},
					complete()
					{
						afterPollFunctionComplete();
					}
				});	
			}
		}
		else
		{
			afterPollFunctionComplete();
		}	
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function updateFileDataArray(newDataArr)
{
	if(expFormatEnabled === "true")
	{
		updateFileDataArrayInner(newDataArr);
	}
}

function getFileSingle(current)
{
	try
	{
		var arrayUpdateKeys = Object.keys(arrayToUpdate);
		var arraySend = {};
		var keyForThis = arrayUpdateKeys[current];
		arraySend[keyForThis] = arrayToUpdate[keyForThis];
		var data = {arrayToUpdate: arraySend};
		$.ajax({
			url: "core/php/poll.php?format=json",
			dataType: "json",
			currentFile: current,
			data,
			type: "POST",
			success(data)
			{
				updateFileDataArray(data);
				arrayOfDataMainDataFilter(data);
				generalUpdate();
			},
			complete()
			{
				var arrayUpdateKeys = Object.keys(arrayToUpdate);
				var currentNew = this.currentFile;
				var updateBy = (1/arrayUpdateKeys.length)*60;
				if(currentNew > 0)
				{
					updateProgressBar(updateBy, arrayUpdateKeys[currentNew-1], "Loading file "+(arrayUpdateKeys.length+1-currentNew)+" of "+arrayUpdateKeys.length+" <br>  "+formatBytes(fileData[arrayUpdateKeys[currentNew-1]]["size"]));
					currentNew--;
					setTimeout(function(){ getFileSingle(currentNew); }, 100);
				}
				else
				{
					updateProgressBar(updateBy, "", "Finishing loading....");
					generalUpdate();
					afterPollFunctionComplete();
				}
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function arrayOfDataMainDataFilter(data)
{
	try
	{
		var filesInner = Object.keys(data);
		if(arrayOfDataMain === null)
		{
			arrayOfDataMain = data;
		}
		else
		{
			for (var dataSwapCount = filesInner.length - 1; dataSwapCount >= 0; dataSwapCount--)
			{
				arrayOfDataMain[filesInner[dataSwapCount]] = data[filesInner[dataSwapCount]];
			}
		}

		for (var lineCountUpdateCount = filesInner.length - 1; lineCountUpdateCount >= 0; lineCountUpdateCount--)
		{
			if(data[filesInner[lineCountUpdateCount]]["lineCount"] !== "---")
			{
				fileData[filesInner[lineCountUpdateCount]]["lineCount"] = data[filesInner[lineCountUpdateCount]]["lineCount"];
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function firstLoadEndAction()
{
	firstLoad = false;
	if(oneLogEnable === "true")
	{
		addOneLogData();
	}
	if(allLogsVisible === "true")
	{
		document.getElementById("menu").style.display = "block";
	}
	document.getElementById("firstLoad").style.display = "none";
	document.getElementById("searchType").disabled = false;
	document.getElementById("searchFieldInput").disabled = false;
	document.getElementById("log").style.display = "table";
	var targetLength = Object.keys(logDisplayArray).length;
	if($("#menu .active").length < targetLength)
	{
		selectTabsInOrder(targetLength);
		toggleDisplayOfNoLogs();
	}
	var windows = Object.keys(logDisplayArray);
	var lengthOfWindows = windows.length;
	for(var i = 0; i < lengthOfWindows; i++)
	{
		if(logDisplayArray[i]["id"] !== null)
		{
			var logsCheck = Object.keys(logs);
			var lengthOfLogsCheck = logsCheck.length;
			for(var j = 0; j < lengthOfLogsCheck; j++)
			{
				if(logDisplayArray[i]["id"] === logsCheck[j])
				{
					document.getElementById("log"+i+"Td").scrollTop = $("#log"+i).outerHeight();
				}
			}
		}
	}
}

function pollTimeLogEndAction()
{
	pollRateCalc = pollingRate;
	if(pollingRateType === "Seconds")
	{
		pollRateCalc *= 1000;
	}
	t1 = performance.now();
	document.getElementById("loggingTimerPollRate").innerText = "Ajax refresh took    "+addPaddingToNumber(Math.round(t2 - t0))+":"+addPaddingToNumber(Math.round(t3 - t2),2)+":"+addPaddingToNumber(Math.round(t1 - t3))+"    " + addPaddingToNumber(Math.round(t1 - t0)) + "/" + addPaddingToNumber(pollRateCalc) +"("+addPaddingToNumber(parseInt(pollRateCalc)*counterForPoll)+") milliseconds.";
	document.getElementById("loggingTimerPollRate").style.color = "";
	counterForPoll = 0;
	var time = Math.round(t1-t0);
	var rate = parseInt(pollRateCalc);
	if(time > rate)
	{
		if(time > (2*rate))
		{
			document.getElementById("loggingTimerPollRate").style.color = "#ff0000";
		}
		else
		{
			document.getElementById("loggingTimerPollRate").style.color = "#ffff00";
		}
	}
	else
	{
		document.getElementById("loggingTimerPollRate").style.color = "#00ff00";
	}
}

function afterPollFunctionComplete()
{
	try
	{
		if(firstLoad)
		{
			firstLoadEndAction();
		}
		if(refreshing)
		{
			endRefreshAction();
		}
		polling = false;
		if(enablePollTimeLogging !== "false")
		{
			pollTimeLogEndAction();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function addPaddingToNumber(number, padding = 4)
{
	try
	{
		number = number.toString();
		while(number.length < padding)
		{
			number = "0"+number;
		}
		return number;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showFileFromPinnedWindow(id)
{
	//look for pinned window
	var windowKeys = Object.keys(logDisplayArray);
	var lengthOfWindows = windowKeys.length;
	for(var j = 0; j < lengthOfWindows; j++)
	{
		if(logDisplayArray[windowKeys[j]]["id"] === id)
		{
			if(logDisplayArray[windowKeys[j]]["pin"] === true)
			{
				return true;
			}
			return false;
		}
	}
	return false;
}

function update(data)
{
	try
	{
		var menu = $("#menu");
		var blank = $("#storage .menuItem").html();
		var id, shortName, item, style, folderName, classInsert;
		var files = Object.keys(data);
		var stop = files.length;
		var updated = false;
		var initialized = $("#menu a").length !== 0;
		var folderNamePrev = "?-1";
		var folderNameCount = -1;
		var atLeastOneLogUpdate = false;
		if(oneLogEnable === "true")
		{
			folderNameCount++;
		}
		for(var i = 0; i !== stop; i++)
		{
			var name = files[i];

			if((!(name in data)) || typeof(data[name]) === "undefined" || data[name] === null || name === "oneLog")
			{
				hideLogByName(name);
				continue;
			}
			var logData = data[name]["log"];
			var showFile = false;
			shortName = files[i].replace(/.*\//g, "");
			id = name.replace(/[^a-z0-9]/g, "");

			if(showFileFromFilter(id, name, shortName, logData) && (showFileFromGroup(id) || $("#"+id).hasClass("active")))
			{
				showFile = true;
			}
			if(!showFile)
			{
				if(showFileFromPinnedWindow(id))
				{
					showFile = true;
				}
			}
			if(showFile)
			{
				if(!firstLoad &&  document.getElementById("selectForGroup").value === "all")
				{
					showLogByName(name);
				}
				if(logData === "This file is empty. This should not be displayed." && hideEmptyLog === "true" || logData === "Error - File does not exist")
				{
					hideLogByName(name);
					logs[id] ="<div class='errorMessageLog errorMessageGreenBG' > This file is empty. </div>";
				}
				else
				{
					if(logData !== null)
					{
						folderName = name.substr(0, name.lastIndexOf("/"));
						if(folderName !== folderNamePrev || i === 0 || groupByType === "file")
						{
							folderNameCount++;
							folderNamePrev = folderName;
							if(folderNameCount >= colorArrayLength)
							{
								folderNameCount = 0;
							}
						}
						var standardMessage = false;
						if(logData === "")
						{
							logData = "<div class='errorMessageLog errorMessageRedBG' >Error - Unknown error? Check file permissions or clear log to fix?</div>";
							standardMessage = true;
						}
						else if(logData === "This file is empty. This should not be displayed.")
						{
							logData = "<div class='errorMessageLog errorMessageGreenBG' > This file is empty. </div>";
							standardMessage = true;
						}
						else if((logData === "Error - File is not Readable") || (logData === "Error - Maybe insufficient access to read file?"))
						{
							var mainMessage = "Error - Maybe insufficient access to read file?";
							if(logData === "Error - File is not Readable")
							{
								mainMessage = "Error - File is not Readable";
							}
							logData = "<div class='errorMessageLog errorMessageRedBG' > "+mainMessage+" <br> <span style='font-size:75%;'> Try entering: <br> chown -R www-data:www-data "+name+" <br> or <br> chmod 664 "+name+" </span> </div>";
							standardMessage = true;
						}

						logs[id] = logData;
						titles[id] = name;
						if(files[i] in fileData)
						{
							if(enableLogging !== "false")
							{
								titles[id] = name + " | " + data[name]["data"] + " | Size: " + formatBytes(fileData[files[i]]["size"]);
							}
							else
							{
								titles[id] = name + " | Size: " + formatBytes(fileData[files[i]]["size"]);
							}
						}
						if(enableLogging !== "false")
						{
							if(id === currentPage)
							{
								$("#title"+currentSelectWindow).html(titles[id]);
							}
						}

						var lastLogLine = logs[id].count - 1;
						var fullPathSearch = filterTitle(titles[id]).trim();

						var nameForLog = shortName;
						if(fullPathSearch in fileData && "Name" in fileData[fullPathSearch] && fileData[fullPathSearch]["Name"] !== "" && fileData[fullPathSearch]["Name"] !== null)
						{
							nameForLog = fileData[fullPathSearch]["Name"];
						}
						else
						{
							if(logNameFormat !== "default")
							{
								//check for other options in displaying name
								if(logNameFormat === "firstFolder" || logNameFormat === "lastFolder")
								{
									var locationOfLast = 1;
									var newName = "";
									var splitType = "/";
									if(fullPathSearch.indexOf("/") > -1)
									{
										newName = fullPathSearch.split("/");
									}
									else if(fullPathSearch.indexOf("\\") > -1)
									{
										newName = fullPathSearch.split("\\");
										splitType = "\\";
									}
									if(logNameFormat === "lastFolder")
									{
										locationOfLast = newName.length-2;
									}
									if(newName !== "")
									{
										nameForLog = newName[locationOfLast]+splitType+shortName;
									}
								}
								else if(logNameFormat === "fullPath")
								{
									nameForLog = fullPathSearch;
								}
							}

							if(logNameExtension === "false")
							{
								if(shortName.indexOf(".") > -1)
								{
									var secondNewName = nameForLog.split(".");
									secondNewName.splice(-1,1);
									nameForLog = secondNewName.join();
								}
							}
						}
						if(logNameGroup === "true")
						{
							if(files[i] in fileData && fileData[files[i]]["Group"] !== "")
							{
								var newNameGroup = fileData[files[i]]["Group"].split(" ")[0];
								nameForLog = "<span id='"+id+"GroupInName' >"+newNameGroup+":</span>"+nameForLog;
							}
							else if(files[i].indexOf("LogHog/Backup/") === 0)
							{
								nameForLog = "Backup:"+nameForLog;
							}
						}
						if($("#menu ." + id + "Button").length === 0) 
						{
							classInsert = "";
							item = blank;
							item = item.replace(/{{title}}/g, nameForLog);
							item = item.replace(/{{id}}/g, id);
							if(groupByColorEnabled === "true")
							{
								classInsert += " buttonColor"+(folderNameCount+1)+" ";
							}
							if(fullPathSearch in fileData && fileData[fullPathSearch]["Group"] !== "")
							{
								var classNameGroup = fileData[files[i]]["Group"].split(" ");
								var classNameGroupLength = classNameGroup.length;
								for(var NCGcount = 0; NCGcount < classNameGroupLength; NCGcount++)
								{
									classInsert += " "+classNameGroup[NCGcount]+"Group ";
								}
							}
							else if(files[i].indexOf("LogHog/Backup/") !== 0)
							{
								classInsert += " BackupGroup ";
							}
							classInsert += " allGroup ";
							item = item.replace(/{{class}}/g, classInsert);

							var itemAdded = false;

							if(!firstLoad)
							{
								var moveToFrontOnUpdate = false;
								var innerCount = i;
								if(filesNew.length > 0)
								{
									for (var innerCountFind = filesNew.length - 1; innerCountFind >= 0; innerCountFind--)
									{
										if(filesNew[innerCountFind] === files[i])
										{
											innerCount = innerCountFind;
											break;
										}
									}
								}
								var innerCountStatic = innerCount;
								if(typeof files[i] !== "undefined")
								{
									var idCheck = files[i].replace(/[^a-z0-9]/g, "");
									if(innerCountStatic === 0)
									{
										itemAdded = tryToInsertBeforeLog(innerCountStatic, stop, idCheck, item);
										if(!itemAdded)
										{
											itemAdded = tryToInsertAfterLog(innerCountStatic, stop, idCheck, item);
										}
									}
									else
									{
										itemAdded = tryToInsertAfterLog(innerCountStatic, stop, idCheck, item);
										if(!itemAdded)
										{
											itemAdded = tryToInsertBeforeLog(innerCountStatic, stop, idCheck, item);
										}
									}
								}
							}
							if(!itemAdded)
							{
								menu.append(item);
							}

							if(!firstLoad)
							{
								if(notificationNewLog === "true" && !$("#menu a." + id + "Button").hasClass("updated") && ( (!(fullPathSearch in fileData)) || fileData[fullPathSearch]["AlertEnabled"] === "true" ) && (!(id in alertEnabledArray) || (id in alertEnabledArray && alertEnabledArray[id] === "enabled")))
								{
									if(notificationNewLogHighlight === "true")
									{
										$("#menu a." + id + "Button").addClass("updated");
									}
									if(notificationNewLogBadge === "true" || notificationNewLogDropdown === "true")
									{
										addLogNotification({
											log: id,
											name: "New Log "+nameForLog,
											action: "$('#"+id+"').click();  closeNotificationsAndMainMenu();",
											showNotification: notificationNewLineBadge,
											showDropdown: notificationNewLineDropdown
										});
									}
								}
							}
							var rightClickObjectNew = new Array();
							if(files[i].indexOf("LogHog/Backup/") !== 0)
							{
								rightClickObjectNew.push({action: "tmpHideLog(\""+id+"\");", name: "Tmp Hide Log"});
								rightClickObjectNew.push({action: "clearLogInner(titles[\""+id+"\"]);", name: "Clear Log"});
								rightClickObjectNew.push({action: "deleteLogPopupInner(titles[\""+id+"\"]);", name: "Delete Log"});
								var alertToggle = {action: "tmpToggleAlerts(\""+id+"\");" ,name: "Enable Alerts"};
								if( (!(fullPathSearch in fileData)) || fileData[fullPathSearch]["AlertEnabled"] === "true")
								{
									alertToggle = {action: "tmpToggleAlerts(\""+id+"\");" ,name: "Disable Alerts"};
								}
								rightClickObjectNew.push(alertToggle);
							}
							rightClickObjectNew.push({action: "copyToClipBoard(\""+shortName+"\");", name: "Copy File Name"});
							rightClickObjectNew.push({action: "copyToClipBoard(titles[\""+id+"\"]);", name: "Copy Filepath"});
							//add rightclick menu
							if(rightClickMenuEnable === "true")
							{
								var listOfRightClickTargets =["","CurrentWindow","GroupInName","Count"];
								var listOfRightClickTargetsLength = listOfRightClickTargets.length;
								for(var rct = 0; rct < listOfRightClickTargetsLength; rct++)
								{
									var innerId = id+listOfRightClickTargets[rct];
									menuObjectRightClick[innerId] = rightClickObjectNew;
									Rightclick_ID_list.push(innerId);
								}
							}
						}

						updated = false;
						if(fullPathSearch in fileData && fileData[fullPathSearch]["AlertEnabled"] === "true" && (!(id in alertEnabledArray) || (id in alertEnabledArray && alertEnabledArray[id] === "enabled")))
						{
							if(!(logs[id] === lastLogs[id]))
							{
								updated = true;
							}
							else
							{
								var selectListForFilter = document.getElementsByName("searchType")[0];
								var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
								if(selectedListFilterType === "content" && filterContentHighlight === "true")
								{
									if(lastContentSearch !== getFilterTextField())
									{
										updated = checkIfDisplay(id)["display"];
									}
								}
							}
						}
						else
						{
							//check if displayed
							updated = checkIfDisplay(id)["display"];
						}

						if(updated)
						{
							//determine if id is one of the values in the array of open files (use instead of currentPage)
							var currentIdPos = checkIfDisplay(id)["location"];

							var newDiff = getDiffLogAndLastLog(id);
							var newDiffText = getDifferentText(id, newDiff);
							var diff = newDiff;
							var diffMod = "";
							if(diff !== "")
							{
								if(document.getElementById(id+"Count").innerHTML !== "" )
								{
									var count = document.getElementById(id+"CountHidden").innerHTML;
									diff = parseInt(count) + diff;
									if(diff > sliceSize)
									{
										diff = sliceSize;
										diffMod = "+";
									}
								}
							}
							var diffNew = diff;
							if(diff !== "")
							{
								diffNew = "("+diff+diffMod+")";
							}
							if(document.getElementById(id+"CountHidden").innerHTML !== diff)
							{
								//this has updated, update stuff for counter
								document.getElementById(id+"CountHidden").innerHTML = diff;
								if(notificationCountVisible === "true" && diff !== 0)
								{
									document.getElementById(id+"Count").innerHTML = diffNew;
								}
							}

							var updateHtml = true;
							if(currentIdPos === -1)
							{
								updateHtml = false;
							}
							else if(scrollOnUpdate === "true" && scrollEvenIfScrolled === "false")
							{
								updateHtml = scrollPauseLogic(currentIdPos);
								logDisplayArray[currentIdPos]["scroll"] = updateHtml;
							}


							if(updateHtml)
							{
								var logFormatted = "";
								if(standardMessage)
								{
									logFormatted = logData;
								}
								else
								{
									logFormatted = makePretty(id);
								}
								if(logFormatted !== $("#log"+currentIdPos).html())
								{
									$("#log"+currentIdPos).html(logFormatted);
									fadeHighlight(currentIdPos);
								}
								if(document.getElementById(id+"Count").innerHTML !== "")
								{
									document.getElementById(id+"Count").innerHTML = "";
									document.getElementById(id+"CountHidden").innerHTML = "";
								}
							}
							else
							{
								if(!firstLoad && notificationNewLine === "true" && (oneLogEnable === "false" || isOneLogVisible() === "false" || oneLogVisibleDisableUpdate === "false"))
								{
									if(autoMoveUpdateLog === "true")
									{
										//'click' on log to switch to log
										$("#menu a." + id + "Button").click();
									}
									else
									{
										if(notificationNewLineHighlight === "true")
										{
											if(!$("#menu a." + id + "Button").hasClass("updated"))
											{
												$("#menu a." + id + "Button").addClass("updated");
											}
										}
										if(notificationNewLineBadge === "true" || notificationNewLineDropdown === "true")
										{
											var numForNot = "";
											if (diffNew !== "(0)")
											{
												numForNot = diffNew;
											}
											addLogNotification({
												log: id,
												name: nameForLog+" Update "+numForNot,
												action: "$('#"+id+"').click();  closeNotificationsAndMainMenu();",
												newText: newDiffText,
												showNotification: notificationNewLogBadge,
												showDropdown: notificationNewLogDropdown
											});
										}
									}
								}
							}

							//update one log if needed
							if(oneLogEnable === "true" && !firstLoad)
							{
								if(fullPathSearch in fileData && fileData[fullPathSearch]["AlertEnabled"] === "true" && (!(id in alertEnabledArray) || (id in alertEnabledArray && alertEnabledArray[id] === "enabled")))
								{
									if(!firstLoad && diffNew !== "(0)")
									{
										updateOneLogData(id, newDiff, newDiffText);
										atLeastOneLogUpdate = true;
									}
								}
							}
						}
						if(initialized && updated && $(window).filter(":focus").length === 0)
						{
							if(flashTitleUpdateLog === "true")
							{
								flashTitle();
							}
						}
						updateLogTitle(id);
					}
					else
					{
						removeLogByName(name);
					}
				}
			}
			else
			{
				hideLogByName(name);
				//remove this log from array of window keys if there
				var windowKeys = Object.keys(logDisplayArray);
				var lengthOfWindows = windowKeys.length;
				for(var j = 0; j < lengthOfWindows; j++)
				{
					if(logDisplayArray[windowKeys[j]]["id"] === id)
					{
						logDisplayArray[windowKeys[j]]["id"] = null;
						logDisplayArray[windowKeys[j]]["pin"] = false;
						logDisplayArray[windowKeys[j]]["scroll"] = true;
						break;
					}
				}
			}
		}

		if(atLeastOneLogUpdate === true)
		{
			var oneLogPos = isOneLogVisible();
			if(oneLogPos !== false)
			{
				scrollOneLogIfVisible(oneLogPos);
				fadeHighlight(oneLogPos);
			}
		}

		//Check if a tab is active, if none... click on first in array that's visible
		var targetLength = Object.keys(logDisplayArray).length;
		var tmpCurrentSelectWindow = currentSelectWindow;
		if($("#menu .active").length < targetLength && !firstLoad)
		{
			selectTabsInOrder(targetLength);
			toggleDisplayOfNoLogs();
		}
		else if($("#menu .active").length > targetLength)
		{
			removeTabsInOrder(targetLength);
		}
		//below changes the current select window back to what was selected by user (could change by function above)
		changeCurrentSelectWindow(tmpCurrentSelectWindow);

		toggleNotificationClearButton();
		updateScrollOnLogs();
		refreshLastLogsArray();
		checkForUpdateLogsOffScreen();
		resize();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkIfDisplay(id)
{
	var windows = Object.keys(logDisplayArray);
	var lengthOfWindows = windows.length;
	for(var j = 0; j < lengthOfWindows; j++)
	{
		if(logDisplayArray[j]["id"] === id)
		{
			return {display: true, location: j};
		}
	}
	return {display: false, location: -1};
}

function unselectAllLogs()
{
	unselectLogsInner(true);
}

function unselectLogsThatAreInNewLayout()
{
	unselectLogsInner(false);
}

function unselectLogsInner(boolForType)
{
	try
	{
		var triggerUpdate = false;
		var arrayOfLogsLength = Object.keys(logDisplayArray).length;
		for(var h = arrayOfLogsLength - 1; h >= 0; h--)
		{
			if(boolForType || logDisplayArray[h]["id"] !== null)
			{
				var currentLayout = getCurrentWindowLayout();
				var layoutVersionIndex = document.getElementById("layoutVersionIndex").value;
				if
				(
					boolForType || logLoadLayout.length === 0 ||
					(
						logLoadLayout[currentLayout][h][layoutVersionIndex] !== "" &&
						logLoadLayout[currentLayout][h][layoutVersionIndex] in fileData
					)
				)
				{
					if(logDisplayArray[h]["pin"] === false)
					{
						$("#log"+h).html("");
						$("#"+logDisplayArray[h]["id"]).removeClass("active");
						$("#"+logDisplayArray[h]["id"]+"CurrentWindow").html("");
						logDisplayArray[h] = {id: null, scroll: true, pin: false};
						triggerUpdate = true;
					}
				}
			}
		}
		if(triggerUpdate)
		{
			generalUpdate();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function removeTabsInOrder(targetLength)
{
	try
	{
		var arrayOfLogsLength = Object.keys(logDisplayArrayOld).length;
		//this is where on first load, tabs are selected to be visible (see here for issue 312)
		for(var h = arrayOfLogsLength - 1; h >= targetLength; h--)
		{
			$("#"+logDisplayArrayOld[h]["id"]+"CurrentWindow").html("");
			$("#"+logDisplayArrayOld[h]["id"]).removeClass("active");
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkIfLogIsVisible(logToCheck)
{
	var arrayOfLogs = $("#menu a");
	var arrayOfLogsLength = arrayOfLogs.length;
	for (var lo = 0; lo < arrayOfLogsLength; lo++)
	{
		if(checkNameCont(logToCheck.replace(/[^a-z0-9]/g, ""), arrayOfLogs[lo]))
		{
			if(arrayOfLogs[lo].style.display !== "none")
			{
				return true;
			}
		}
	}
	return false;
}

function selectTabsInOrder(targetLength)
{
	try
	{
		var arrayOfLogs = $("#menu a");
		var arrayOfLogsLength = arrayOfLogs.length;
		//this is where on first load, tabs are selected to be visible (see here for issue 312)
		for(var h = 0; h < targetLength; h++)
		{
			if(logDisplayArray[h]["id"] === null)
			{
				//show first available log
				for (var i = 0; i < arrayOfLogsLength; i++)
				{
					var isVis = false;
					var currentLayout = getCurrentWindowLayout();
					var layoutVersionIndex = document.getElementById("layoutVersionIndex").value;
					if(enableMultiLog === "true" && logLoadLayout.length !== 0 && logLoadLayout[currentLayout][h][layoutVersionIndex] !== "" && logLoadLayout[currentLayout][h][layoutVersionIndex] in fileData )
					{
						var currentLogCheck = logLoadLayout[currentLayout][h][layoutVersionIndex];
						if(checkNameCont(currentLogCheck.replace(/[^a-z0-9]/g, ""), arrayOfLogs[i]))
						{
							if(arrayOfLogs[i].style.display === "none")
							{
								continue;
							}
						}
						else
						{
							isVis = checkIfLogIsVisible(currentLogCheck);
							if(isVis)
							{
								continue;
							}
						}
					}
					else if(h === 0 && logSelectedFirstLoad !== "" && logSelectedFirstLoad in fileData)
					{
						if(checkNameCont(logSelectedFirstLoad.replace(/[^a-z0-9]/g, ""), arrayOfLogs[i]))
						{
							if(arrayOfLogs[i].style.display === "none")
							{
								continue;
							}
						}
						else
						{
							isVis = checkIfLogIsVisible(logSelectedFirstLoad);
							if(isVis)
							{
								continue;
							}
						}
					}

					var logIsAlreadyShown = false;
					for(var j = 0; j < targetLength; j++)
					{
						if(logDisplayArray[j]["id"] === arrayOfLogs[i].id)
						{
							logIsAlreadyShown = true;
							break;
						}
					}
					if(arrayOfLogs[i].style.display !== "none" && !logIsAlreadyShown)
					{
						changeCurrentSelectWindow(h);
						arrayOfLogs[i].onclick.apply(arrayOfLogs[i]);
						break;
					}
				}
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkNameCont(checkName, currentCheck)
{
	if(!($("#"+checkName).hasClass("active")))
	{
		if(currentCheck.id === checkName)
		{
			return true;
		}
	}
	return false;
}

function toggleDisplayOfNoLogs()
{
	try
	{
		if($("#menu .active").length === 0)
		{
			//if still none active, none to display - add popup here
			if(document.getElementById("noLogToDisplay").style.display !== "block")
			{
				document.getElementById("noLogToDisplay").style.display = "block";
				document.getElementById("log").style.display = "none";
			}
		}
		else
		{
			//we do not need this, hide popup
			if(document.getElementById("noLogToDisplay").style.display !== "none")
			{
				document.getElementById("noLogToDisplay").style.display = "none";
				document.getElementById("log").style.display = "block";
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function updateScrollOnLogs()
{
	try
	{
		var windows = Object.keys(logDisplayArray);
		var lengthOfWindows = windows.length;
		for(var i = 0; i < lengthOfWindows; i++)
		{
			if(logDisplayArray[i]["id"] !== null)
			{
				var logsCheck = Object.keys(logs);
				var lengthOfLogsCheck = logsCheck.length;
				for(var j = 0; j < lengthOfLogsCheck; j++)
				{
					if(logDisplayArray[i]["id"] === logsCheck[j])
					{
						var currentPageId = logsCheck[j];
						if(logs[currentPageId] !== lastLogs[currentPageId])
						{
							lastLogs[currentPageId] = logs[currentPageId];
							if(scrollOnUpdate === "true" && logDisplayArray[i]["scroll"])
							{
								document.getElementById("log"+i+"Td").scrollTop = $("#log"+i).outerHeight();
							}
						}
						break;
					}
				}
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function scrollPauseLogic(id)
{
	try
	{
		var logTdCalc = document.getElementById("log"+id+"Td").getBoundingClientRect();  //const
		var logCalc = document.getElementById("log"+id).getBoundingClientRect(); //changes
		//do calc to see if scrolled, if scrolled don't scroll to bottom 
		if(logCalc.bottom > logTdCalc.bottom)
		{
			return false;
		}
		return true;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function tmpHideLog(name)
{
	try
	{
		hideLogByName(name);
		logsToHide.push(name);
		generalUpdate();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function copyToClipBoard(whatToCopy)
{
	try
	{
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val(filterTitle(whatToCopy)).select();
		document.execCommand("copy");
		$temp.remove();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function tryToInsertBeforeLog(innerCount, stop, idCheck, item)
{
	try
	{
		var itemToBefore = null;
		while(itemToBefore === null && innerCount < stop)
		{
			var itemCheck = $("#menu ." + idCheck + "Button");
			if(itemCheck.length !== 0) 
			{
				itemToBefore = itemCheck;
			}
			innerCount++;
		}
		if(itemToBefore !== null)
		{
			itemToBefore.before(item);
		}

		return (itemToBefore !== null);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function tryToInsertAfterLog(innerCount, stop, idCheck, item)
{
	try
	{
		var itemToBefore = null;
		while(itemToBefore === null && innerCount > 0)
		{
			var itemCheck = $("#menu ." + idCheck + "Button");
			if(itemCheck.length !== 0) 
			{
				itemToBefore = itemCheck;
			}
			innerCount--;
		}
		if(itemToBefore !== null)
		{
			itemToBefore.after(item);
		}

		return (itemToBefore !== null);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshLastLogsArray()
{
	try
	{
		var ids = Object.keys(logs);
		var stop = ids.length;
		for(var i = 0; i !== stop; ++i)
		{
			id = ids[i];
			lastLogs[id] = logs[id];
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function removeFromMultiLog(idOfName)
{
	var lengthOfLogDisplayArray = Object.keys(logDisplayArray).length;
	var windowNum = -1;
	for(var i = 0; i < lengthOfLogDisplayArray; i++)
	{
		if(logDisplayArray[i]["id"] === idOfName)
		{
			logDisplayArray[i]["id"] = null;
			windowNum = i;
			break;
		}
	}
	if(windowNum > -1)
	{
		$("#log"+windowNum).html("");
		$("#menu ." + idOfName + "Button currentWindowNum").html("");
	}
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

function hideLogByLogDisplayArray(currentLogNum)
{
	hideLogByName(logDisplayArray[currentLogNum]["id"]);
}

function hideLogByName(name)
{
	try
	{
		var idOfName = name.replace(/[^a-z0-9]/g, "");
		if($("#menu ." + idOfName + "Button").length !== 0)
		{
			if($("#menu ." + idOfName + "Button").hasClass("active"))
			{
				$("#menu ." + idOfName + "Button").removeClass("active");
			}
			$("#menu ." + idOfName + "Button").hide();
		}
		removeNotificationByLog(idOfName);
		removeFromMultiLog(idOfName);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showLogByName(name)
{
	try
	{
		var idOfName = name.replace(/[^a-z0-9]/g, "");
		if($("#menu ." + idOfName + "Button").length !== 0)
		{
			$("#menu ." + idOfName + "Button").show();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function removeLogByName(name)
{
	try
	{
		var idOfName = name.replace(/[^a-z0-9]/g, "");
		if($("#menu ." + idOfName + "Button").length !== 0)
		{
			$("#menu ." + idOfName + "Button").remove();
		}
		removeFromMultiLog(idOfName);
		resize();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function fadeHighlight(id)
{
	try
	{
		setTimeout(function(){ removeNewHighlights("#log"+id); }, parseInt(timeoutHighlight));
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function show(e, id)
{
	try
	{
		var internalID = id;
		var currentCurrentSelectWindow = currentSelectWindow;
		$("#log"+currentCurrentSelectWindow).hide();
		$("#log"+currentCurrentSelectWindow+"load").show();
		resize();
		$(e).siblings().removeClass("active");
		var windowNumInTitle = $("#"+internalID+"CurrentWindow").html();
		if(windowNumInTitle !== "")
		{
			windowNumInTitle = windowNumInTitle + "0";
			var windowNumAsNum = parseInt(windowNumInTitle);
			$("#log"+(windowNumAsNum-1)).html("");
		}
		//window number clear
		$(".currentWindowNum").each(function(i, obj)
		{
			if(obj.innerHTML ==  ""+(currentCurrentSelectWindow+1)+". ")
			{
				obj.innerHTML = "";
			}
		});
		//window number add
		$("#"+internalID+"CurrentWindow").html(""+(currentCurrentSelectWindow+1)+". ");
		currentPage = internalID;
		logDisplayArray[currentCurrentSelectWindow]["id"] = internalID;
		var windows = Object.keys(logDisplayArray);
		var lengthOfWindows = windows.length;
		var logsCheck = Object.keys(logs);
		var lengthOfLogsCheck = logsCheck.length;
		for(var i = 0; i < lengthOfWindows; i++)
		{
			if(logDisplayArray[i]["id"] !== null)
			{
				for(var j = 0; j < lengthOfLogsCheck; j++)
				{
					if(logDisplayArray[i]["id"] === logsCheck[j])
					{
						$("."+logsCheck[j]+"Button").addClass("active").removeClass("updated");
					}
				}
			}
		}
		$("#title"+currentCurrentSelectWindow).html(titles[internalID]);
		setTimeout(function() {
			showPartTwo(e, internalID, currentCurrentSelectWindow);
		}, 2);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showPartTwo(e, internalID, currentCurrentSelectWindow)
{
	try
	{
		var formattedHtml = "";
		if(typeof logs[internalID] === "object" && "id" in logs[internalID] && logs[internalID]["id"] === "oneLog")
		{
			formattedHtml = makeOneLogPretty();
		}
		else if(logs[internalID].indexOf("errorMessageLog errorMessageRedBG") > -1 || logs[internalID].indexOf("errorMessageLog errorMessageGreenBG") > -1)
		{
			formattedHtml = logs[internalID];
		}
		else
		{
			formattedHtml = makePretty(internalID);
		}
		$("#log"+currentCurrentSelectWindow).html(formattedHtml);
		fadeHighlight(currentCurrentSelectWindow);
		setTimeout(function() {
			showPartThree(e, internalID, currentCurrentSelectWindow);
		}, 2);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function toggleSideBarElements(internalID, currentCurrentSelectWindow)
{
	var visibleStatusOfClearLogSideBar = "block";
	var visibleStatusOfDeleteLogSideBar = "block";
	var visibleStatusOfCloseLogSideBar = "none";
	if(internalID.indexOf("ogogackup") === 0)
	{
		visibleStatusOfClearLogSideBar  = "none";
		visibleStatusOfDeleteLogSideBar = "none";
		visibleStatusOfCloseLogSideBar  = "block";
	}
	else if(internalID === "oneLog")
	{
		visibleStatusOfDeleteLogSideBar= "none";
	}
	if(document.getElementById("clearLogSideBar"+currentCurrentSelectWindow).style.display !== visibleStatusOfClearLogSideBar)
	{
		document.getElementById("clearLogSideBar"+currentCurrentSelectWindow).style.display = visibleStatusOfClearLogSideBar;
	}
	if(document.getElementById("deleteLogSideBar"+currentCurrentSelectWindow).style.display !== visibleStatusOfDeleteLogSideBar)
	{
		document.getElementById("deleteLogSideBar"+currentCurrentSelectWindow).style.display = visibleStatusOfDeleteLogSideBar;
	}
	if(document.getElementById("closeLogSideBar"+currentCurrentSelectWindow).style.display !== visibleStatusOfCloseLogSideBar)
	{
		document.getElementById("closeLogSideBar"+currentCurrentSelectWindow).style.display = visibleStatusOfCloseLogSideBar;
	}
}

function showPartThree(e, internalID, currentCurrentSelectWindow)
{
	try
	{
		toggleSideBarElements(internalID, currentCurrentSelectWindow);
		$("#log"+currentCurrentSelectWindow+"load").hide();
		$("#log"+currentCurrentSelectWindow).show();
		if(document.getElementById("noLogToDisplay").style.display !== "none")
		{
			document.getElementById("noLogToDisplay").style.display = "none";
			document.getElementById("log").style.display = "block";
		}
		scrollToBottom(currentCurrentSelectWindow);
		toggleNotificationClearButton();
		removeNotificationByLog(internalID);
		//below function does resize
		toggleGroupedGroups();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function removeNewHighlights(area)
{
	$(area + " div").removeClass("newLine");
	$(area + " tr").removeClass("newLine");
}

function getDifferentText(id, diffCount)
{
	var tmpTextLog = logs[id].split("\n");
	var lengthOfArray = tmpTextLog.length;
	var returnArray = new Array();
	for (var i = lengthOfArray - 1; i >= (lengthOfArray - diffCount); i--)
	{
		returnArray.push(tmpTextLog[i]);
	}
	returnArray = returnArray.reverse();
	return returnArray.join("\n");
}

function getDiffLogAndLastLog(id)
{
	try
	{
		if(lineCountFromJS === "false")
		{
			if(id in logLines)
			{
				return logLines[id];
			}
		}
		if(logs[id] === lastLogs[id])
		{
			return 0;
		}
		var tmpTextLog = logs[id].split("\n");
		var tmpTextLast;
		if(id in lastLogs)
		{
			tmpTextLast = lastLogs[id].split("\n");
		}
		else
		{
			return 0;
		}
		var lengthOfLastArray = tmpTextLast.length;
		var lengthOfArray = tmpTextLog.length;
		if(lengthOfLastArray === 0)
		{
			return lengthOfArray;
		}
		else if(lengthOfLastArray > lengthOfArray)
		{
			return 0;
		}
		else if(sliceSize < lengthOfArray)
		{
			return lengthOfArray - sliceSize;
		}

		var lastLine = tmpTextLast[lengthOfLastArray-1];
		var counter = 0;
		for (var i = lengthOfArray - 1; i >= 0; i--)
		{
			if(tmpTextLog[i].trim() === lastLine.trim())
			{
				//confirm the next two also
				var returnNewNum = true;
				var j = i;
				var lastStart = lengthOfLastArray-1;
				while(j >= 0 && returnNewNum)
				{
					if(!(j in tmpTextLog))
					{
						returnNewNum = false;
					}
					else if(lastStart in tmpTextLast && tmpTextLog[j].trim() !== tmpTextLast[lastStart].trim())
					{
						returnNewNum = false;
					}
					else
					{
						j--;
						lastStart--;
					}
				}
				if(returnNewNum)
				{
					return (lengthOfArray - 1 - i);
				}
			}
		}
		return 0;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

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
			return "<table width=\"100%\" style=\"border-spacing: 0;\" >" + returnText + "</table>";
		}
		return "";
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function makePrettyWithText(text, count)
{
	try
	{
		if(text === "")
		{
			return "";
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
		var filterTextField = getFilterTextField();
		for (var i = 0; i < lengthOfTextArray; i++)
		{
			addLine = false;
			if(selectedListFilterType === "content" && filterContentLimit === "true" && filterTextField !== "")
			{
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
			else
			{
				addLine = true;
			}
			if(addLine)
			{
				var lineText = text[i].split("\\n");
				var lengthOflineTextArray = lineText.length;
				for (var j = 0; j < lengthOflineTextArray; j++)
				{
					var customClass = " class = '";
					var customClassAdd = false;
					if(highlightNew === "true" && ((i + count + 1) > lengthOfTextArray))
					{
						customClass += " newLine ";
						customClassAdd = true;
					}

					if(selectedListFilterType === "content" && filterContentHighlight === "true" && getFilterTextField() !== "")
					{
						//check if match, and if supposed to highlight
						if(filterContentCheck(lineText[j]))
						{
							customClass += " highlight ";
							customClassAdd = true;
						}
					}

					customClass += " '";
					returnText += "<tr valign=\"top\" ";
					if(customClassAdd)
					{
						returnText += " "+customClass+" ";
					}
					returnText += " >";
					var lineToReturn = "<td style=\"white-space: pre-wrap;\" >"+lineText[j]+"</td>";
					if(expFormatEnabled === "true")
					{
						lineToReturn = formatLine(lineText[j], {
							customClass,
							customClassAdd
						});
					}
					returnText += "<td style=\"width: 31px; padding: 0;\" ></td>"+lineToReturn+"</tr><tr height=\""+logLinePadding+"px\" ><td colspan=\"2\"></td></tr>";
				}
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

function resize()
{
	try
	{
		var targetHeight = window.innerHeight - $("#header").outerHeight();
		var menuHeight = document.getElementById("menu").getBoundingClientRect().height;
		if(logMenuLocation === "top" || logMenuLocation === "bottom")
		{
			targetHeight = targetHeight - menuHeight;
		}
		var targetWidth = window.innerWidth;
		if(enablePollTimeLogging !== "false")
		{
			targetHeight -= 25;
		}
		if(document.getElementById("noticeBar").style.display !== "none")
		{
			targetHeight = targetHeight - $("#noticeBar").outerHeight();
		}
		if($("#main").outerHeight() !== targetHeight)
		{
			$("#main").outerHeight(targetHeight);
		}
		if($("#settingsSideBar").outerHeight() !== targetHeight)
		{
			$("#settingsSideBar").outerHeight(targetHeight);
		}
		if(logMenuLocation === "bottom")
		{
			if(document.getElementById("main").style.bottom !== menuHeight)
			{
				document.getElementById("main").style.bottom = menuHeight+"px";
			}
		}
		else if((logMenuLocation === "left" || logMenuLocation === "right") && allLogsVisible === "true")
		{
			if(menuHeight !== targetHeight)
			{
				$("#menu").outerHeight(targetHeight);
			}
		}
		var tdElementWidth = (targetWidth/windowDisplayConfigColCount).toFixed(4);
		var trElementHeight = ((targetHeight-borderPadding)/windowDisplayConfigRowCount).toFixed(4);
		if(($(".logTrHeight").outerHeight() !== trElementHeight)|| ($(".logTdWidth").outerWidth() !== tdElementWidth) || ($(".backgroundForSideBarMenu").outerHeight() !== trElementHeight))
		{
			if($(".logTrHeight").outerHeight() !== trElementHeight)
			{
				$(".logTrHeight").outerHeight(trElementHeight);
			}
			if($(".logTdWidth").outerWidth() !== tdElementWidth)
			{
				$(".logTdWidth").outerWidth(tdElementWidth);
			}
				if($(".backgroundForSideBarMenu").outerHeight() >= $(".logTrHeight").outerHeight())
				{
					$(".backgroundForSideBarMenu").outerHeight(trElementHeight);
				}
				else
				{
					if($(".backgroundForSideBarMenu").css("height") !== "auto")
					{
						$(".backgroundForSideBarMenu").css("height","auto");
					}
					if(bottomBarIndexType === "center")
					{
						if($(".backgroundForSideBarMenu").css("top") !== trElementHeight+"px")
						{
							$(".backgroundForSideBarMenu").css("top",((trElementHeight / 2) - ($(".backgroundForSideBarMenu").outerHeight() / 2))+"px")
						}
					}
				}
		}

		resizeFullScreenMenu();

		updateNotificationCount();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function startPollTimer()
{
	/* Dont try catch visibility  */
	pollRateCalc = pollingRate;
	if(pollingRateType === "Seconds")
	{
		pollRateCalc *= 1000;
	}
	if(pauseOnNotFocus === "true")
	{
		pollTimer = setInterval(poll, pollRateCalc);
	}
	else
	{
		var bgPollRateCalc = backgroundPollingRate;
		if(backgroundPollingRateType === "Seconds")
		{
			bgPollRateCalc *= 1000;
		}
		pollTimer = Visibility.every(pollRateCalc, bgPollRateCalc, function () { poll(); });
	}
}

function clearPollTimer()
{
	/* Dont try catch visibility  */

	if(pauseOnNotFocus === "true")
	{
		clearInterval(pollTimer);
	}
	else
	{
		Visibility.stop(pollTimer);
	}
	pollTimer = null;
}

function togglePollSpeedDown(currentClick)
{
	if(userPaused || pausePollCurrentSession)
	{
		return;
	}
	if(currentClick !== fullScreenMenuClickCount)
	{
		return;
	}
	clearPollTimer();
	if(fullScreenMenuPollSwitchType === "BGrate")
	{
		pollingRateBackup = pollingRate;
		pollingRate = backgroundPollingRate;
		startPollTimer();
	}
}

function togglePollSpeedUp()
{
	if(userPaused || pausePollCurrentSession)
	{
		return;
	}
	clearPollTimer();
	if(pollingRateBackup !== 0)
	{
		pollingRate = pollingRateBackup;
	}
	pollingRateBackup = 0;
	startPollTimer();
}

function switchPollType()
{
	pollRateCalc = pollingRate;
	if(pollingRateType === "Seconds")
	{
		pollRateCalc *= 1000;
	}
	if(pauseOnNotFocus === "true")
	{
		clearInterval(pollTimer);
		pauseOnNotFocus = "false";
		var bgPollRateCalc = backgroundPollingRate;
		if(backgroundPollingRateType === "Seconds")
		{
			bgPollRateCalc *= 1000;
		}
		pollTimer = Visibility.every(pollRateCalc, bgPollRateCalc, function () { poll(); });
		showPopup();
		document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >Toggled off!</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">Toggled off auto pause in background</div></div>";
	}
	else
	{
		Visibility.stop(pollTimer);
		pauseOnNotFocus = "true";
		pollTimer = setInterval(poll, pollRateCalc);
		showPopup();
		document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >Toggled on!</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">Toggled on auto pause in background</div></div>";
	}
	setTimeout(function(){ hidePopup(); }, 500);
}

function startPauseOnNotFocus()
{
	/* Dont try catch visibility  */

	startedPauseOnNonFocus = true;
	Visibility.every(100, 1000, function () { checkIfPageHidden(); });
}

function checkIfPageHidden()
{
	try
	{
		if(isPageHidden() && pauseOnNotFocus === "true")
		{
			//hidden
			if(!pausePollCurrentSession)
			{
				pausePollFunction();
			}
			return;
		}

		//not hidden
		if(!userPaused && pausePollCurrentSession)
		{
			pausePollCurrentSession = false;
			showPauseButton();
			if(flashTitleUpdateLog === "true")
			{
				stopFlashTitle();
			}
			if(pollTimer === null)
			{
				poll();
				startPollTimer();
			}
			return;
		}

		if(userPaused)
		{
			updateDocumentTitle("Paused");
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function pausePollFunction()
{
	try
	{
		pausePollCurrentSession = true;
		showPlayButton();
		updateDocumentTitle("Paused");
		if(pollTimer !== null)
		{
			clearPollTimer();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function isPageHidden()
{
	return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
}

function scrollToBottom(idNum)
{
	document.getElementById("log"+idNum+"Td").scrollTop = $("#log"+idNum).outerHeight();
}

function clearLogInner(title)
{
	if(title.indexOf(" | ") > -1)
	{
		title = title.split(" | ")[0];
	}
	title = title.trim();
	archiveAction(title);
	title = filterTitle(title);
	var data = {file: title};
	$.ajax({
			url: "core/php/clearLog.php?format=json",
			dataType: "json",
			data,
			type: "POST",
	success(data)
	{
		if(data["fileFound"] === "false")
		{
			showPopup();
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >An Error Occured when clearing this log</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">The log could not be found.</div><div><div style=\"margin-left: 160px; margin-top: 20px;\" onclick=\"hidePopup();\" class=\"link\">Close</div></div>";
		}
		else if(data["success"] === "false")
		{
			showPopup();
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >An Error Occured when clearing this log</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">An unknown error occured when trying to clear this log.</div><div><div style=\"margin-left: 160px; margin-top: 20px;\" onclick=\"hidePopup();\" class=\"link\">Close</div></div>";
		}
		else
		{
			refreshLastLogsArray();
		}
	},
	});
}

function clearLog(idNum)
{
	try
	{
		if(document.getElementById("title"+idNum).textContent !== "")
		{
			if(document.getElementById("title"+idNum).textContent === "oneLog")
			{
				resetOneLogData();
			}
			else
			{
				clearLogInner(document.getElementById("title"+idNum).textContent);
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function deleteAction()
{
	try
	{
		popupSettingsArrayCheck();
		if("deleteLog" in popupSettingsArray && popupSettingsArray.deleteLog == "true")
		{
			showPopup();
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >Are you sure you want to clear all logs?</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\"></div><div><div class=\"link\" onclick=\"deleteActionAfter();hidePopup();\" style=\"margin-left:125px; margin-right:50px;margin-top:35px;\">Yes</div><div onclick=\"hidePopup();\" class=\"link\">No</div></div>";
		}
		else
		{
			deleteActionAfter();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


function deleteActionAfter()
{
	try
	{
		//save tmp versions first
		if(saveTmpLogOnClear === "true" && enableHistory === "true")
		{
			var logSaveTmpKeys = Object.keys(arrayOfDataMain);
			var logSaveTmpKeysLength = logSaveTmpKeys.length;
			for(var tmpClearAllCountSaveTmp = 0; tmpClearAllCountSaveTmp < logSaveTmpKeysLength; tmpClearAllCountSaveTmp++)
			{
				var currentTitle = logSaveTmpKeys[tmpClearAllCountSaveTmp];
				if(
					arrayOfDataMain[currentTitle]["log"] === "This file is empty. This should not be displayed." ||
					arrayOfDataMain[currentTitle]["log"] === "Error - File does not exist" ||
					arrayOfDataMain[currentTitle]["log"] === "Error - File is not Readable" ||
					arrayOfDataMain[currentTitle]["log"] === "Error - Maybe insufficient access to read file?"
				)
				{
					continue;
				}
				var dataToSend = {subFolder: "tmp/loghogBackupHistoryLogs/", key: currentTitle, log: arrayOfDataMain[currentTitle]["log"]};
				$.ajax({
						url: "core/php/saveTmpVersionOfLog.php?format=json",
						dataType: "json",
						data: dataToSend,
						type: "POST",
				success(data){},
				});
			}
		}
		if(oneLogEnable === "true" && oneLogAllLogClear === "true")
		{
			resetOneLogData();
		}
		//Clear All Log Function (not delete actual file, just contents)
		var urlForSend = "core/php/clearAllLogs.php?format=json";
		var data = "";
		$.ajax({
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{

			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function deleteLogPopup(idNum)
{
	try
	{
		deleteLogPopupInner(document.getElementById("title"+idNum).textContent);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function deleteLogPopupInner(title)
{
	title = filterTitle(title);
	if(title !== "")
	{
		popupSettingsArrayCheck();
		if("deleteLog" in popupSettingsArray && popupSettingsArray.deleteLog == "true")
		{
			showPopup();
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >Are you sure you want to delete this log?</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">"+title+"</div><div><div class=\"link\" onclick=\"deleteLog('"+title+"');hidePopup();\" style=\"margin-left:125px; margin-right:50px;margin-top:35px;\">Yes</div><div onclick=\"hidePopup();\" class=\"link\">No</div></div>";
		}
		else
		{
			deleteLog(title);
		}
	}
}

function deleteLog(title)
{
	try
	{
		if(title.indexOf(" | ") > -1)
		{
			title = title.split(" | ")[0];
		}
		title = title.trim();
		archiveAction(title);
		var urlForSend = "core/php/deleteLog.php?format=json";
		title = title.replace(/\s/g, "");
		var data = {file: title};
		name = title;
		$.ajax({
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				if(data["fileFound"] === "false")
				{
					showPopup();
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >An Error Occured when deleting this log</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">The log could not be found.</div><div><div style=\"margin-left: 160px; margin-top: 20px;\" onclick=\"hidePopup();\" class=\"link\">Close</div></div>";
				}
				else if(data["success"] === "false")
				{
					showPopup();
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >An Error Occured when deleting this log</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">An unknown error occured when trying to delete this log.</div><div><div style=\"margin-left: 160px; margin-top: 20px;\" onclick=\"hidePopup();\" class=\"link\">Close</div></div>";
				}
				else
				{
					removeLogByName(data["file"]);
				}
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function filterTitle(title)
{
	try
	{
		if(title.substring(0, title.indexOf("|")) !== null && title.substring(0, title.indexOf("|")) !== "")
		{
			title = title.substring(0, title.indexOf("|"));
		}
		return title;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkForUpdateMaybe()
{
	try
	{
		if (autoCheckUpdate === "true")
		{
			if(daysSinceLastCheck > (autoCheckDaysUpdate - 1))
			{
				daysSinceLastCheck = -1;
				checkForUpdates("","Log-Hog", currentVersion, "settingsInstallUpdate", false, dontNotifyVersion);
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function updateProgressBar(additonalPercent, text, topText = "Loading...")
{
	try
	{
		if(firstLoad)
		{
			percent = percent + additonalPercent;
			progressBar.set(percent);
			$("#progressBarSubInfo").empty();
			$("#progressBarSubInfo").append(text);
			$("#progressBarMainInfo").empty();
			$("#progressBarMainInfo").append(topText);
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function changeCurrentSelectWindow(newSelectWindow)
{
	newSelectWindow = parseInt(newSelectWindow);
	if(currentSelectWindow === newSelectWindow)
	{
		return;
	}
	$(".currentWindowNumSelected").removeClass("currentWindowNumSelected").addClass("sidebarCurrentWindowNum");
	currentSelectWindow = newSelectWindow;
	$("#numSelectIndecatorForWindow"+newSelectWindow).removeClass("sidebarCurrentWindowNum").addClass("currentWindowNumSelected");
	if(windowDisplayConfigColCount > 1 || windowDisplayConfigRowCount > 1)
	{
		$(".currentWindowNumSelected").show();
	}
}

function showInfo(idNum)
{
	if(document.getElementById("title"+idNum).textContent !== "")
	{
		if(document.getElementById("title"+idNum).style.display === "none")
		{
			var posOfInfo = document.getElementById("showInfoLink"+idNum).getBoundingClientRect();
			var infoPopup = document.getElementById("title"+idNum);
			infoPopup.style.display = "block";
			infoPopup.style.left = (posOfInfo.x + 32 )+ "px";
			infoPopup.style.top = (posOfInfo.y - 16) + "px";
			infoPopup.style.maxWidth = document.getElementById("log"+idNum).getBoundingClientRect().width + "px";
		}
		else
		{
			document.getElementById("title"+idNum).style.display = "none";
		}
	}
}

function formatAMPM(date)
{
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}

function hideEmptyLogs()
{
	if(hideEmptyLog === "true")
	{
		hideEmptyLogsInner();
	}
}

function pinWindow(windowNum)
{
	if(logDisplayArray[windowNum]["pin"] === true)
	{
		logDisplayArray[windowNum]["pin"] = false;
		$("#pinWindow"+windowNum+" .pinWindow").show();
		$("#pinWindow"+windowNum+" .unPinWindow").hide();
	}
	else
	{
		logDisplayArray[windowNum]["pin"] = true;
		$("#pinWindow"+windowNum+" .pinWindow").hide();
		$("#pinWindow"+windowNum+" .unPinWindow").show();
	}
}

function generateWindowDisplay()
{
	var localData = generateWindowDisplayInner();
	var arrayOfPrevLogs = localData["arrayOfPrevLogs"];
	if(startOfPollLogicRan === false)
	{
		startOfPollLogic();
	}
	else
	{
		if(logSwitchKeepCurrent === "true")
		{
			if(arrayOfPrevLogs !== {})
			{
				setTimeout(function() {
					loadPrevLogContent(arrayOfPrevLogs);
				}, 1);
			}
		}
		else if(logSwitchKeepCurrent === "onlyIfPresetDefined")
		{
			//Check for preset before unselect
			if(logSwitchABCClearAll === "true")
			{
				unselectAllLogs();
			}
			else
			{
				if(arrayOfPrevLogs !== {})
				{
					setTimeout(function() {
						loadPrevLogContent(arrayOfPrevLogs);
					}, 1);
				}
			}
		}
		else
		{
			//unselect all logs
			unselectAllLogs();
		}
		setTimeout(function() {
			generalUpdate();
		}, 2);
	}
}

function generateWindowDisplayInner()
{
	var windowDisplayConfig = getCurrentWindowLayout();
	var windowDisplayConfigArray = windowDisplayConfig.split("x");
	windowDisplayConfigRowCount = windowDisplayConfigArray[0];
	windowDisplayConfigColCount = windowDisplayConfigArray[1];
	var logDisplayHtml = "";
	var newBorderPadding = 0;
	var newLogDisplayArray = {};
	var arrayOfPrevLogs = {};
	for(var i = 0; i < windowDisplayConfigRowCount; i++)
	{
		logDisplayHtml += "<tr>";
		for(var j = 0; j < windowDisplayConfigColCount; j++)
		{
			newBorderPadding += 2;
			var newBlock = $("#storage .logTdHolder").html();
			var counterInternal = j+(i*windowDisplayConfigColCount);
			newBlock = newBlock.replace(/{{counter}}/g, counterInternal);
			newBlock = newBlock.replace(/{{counterPlusOne}}/g, (1+counterInternal));
			if(counterInternal === 0)
			{
				newBlock = newBlock.replace(/{{windowSelect}}/g, "currentWindowNumSelected");
			}
			else
			{
				newBlock = newBlock.replace(/{{windowSelect}}/g, "sidebarCurrentWindowNum");
			}
			if(document.getElementById("log"+counterInternal))
			{
				arrayOfPrevLogs[counterInternal] = $("#log"+counterInternal).html();
				newBlock = newBlock.replace(/{{loadingStyle}}/g, "");
			}
			else
			{
				newBlock = newBlock.replace(/{{loadingStyle}}/g, "style=\"display: none\"");
			}
			logDisplayHtml += newBlock;
			var newPopupHolder = $("#storage .popuopInfoHolder").html();
			newPopupHolder = newPopupHolder.replace(/{{counter}}/g, counterInternal);
			$("body").append(newPopupHolder);
			if(counterInternal in logDisplayArray)
			{
				newLogDisplayArray[counterInternal] = logDisplayArray[counterInternal];
			}
			else
			{
				newLogDisplayArray[counterInternal] = {id: null, scroll: true, pin: false};
			}
		}
		logDisplayHtml += "</tr>";
	}
	borderPadding = newBorderPadding;
	logDisplayArrayOld = logDisplayArray;
	logDisplayArray = newLogDisplayArray;
	document.getElementById("log").innerHTML = ""+logDisplayHtml+"";
	//show or hide numbers for windows if needed
	if(windowDisplayConfigColCount > 1 || windowDisplayConfigRowCount > 1)
	{
		$(".pinWindowContainer, .currentWindowNumSelected, .currentWindowNum").show();
		loadImgFromData("multiLogGreaterThanOne");
	}
	else
	{
		$(".pinWindowContainer, .currentWindowNumSelected, .currentWindowNum").hide();
	}
	//change select if needed
	if(Object.keys(logDisplayArray).length < (currentSelectWindow + 1))
	{
		currentSelectWindow = (Object.keys(logDisplayArray).length -1);
	}
	resize();
	return{
		"arrayOfPrevLogs" : arrayOfPrevLogs
	}
}

function loadPrevLogContent(arrayOfPrevLogs)
{
	var arrayOfPrevLogsKeys = Object.keys(arrayOfPrevLogs);
	var totalarrayOfPrevLogs = arrayOfPrevLogsKeys.length;
	for(var countAPLK = 0; countAPLK < totalarrayOfPrevLogs; countAPLK++)
	{
		$("#log"+arrayOfPrevLogsKeys[countAPLK]).html(arrayOfPrevLogs[arrayOfPrevLogsKeys[countAPLK]]);
		$("#log"+arrayOfPrevLogsKeys[countAPLK]+"load").hide();
		scrollToBottom(arrayOfPrevLogsKeys[countAPLK]);
		toggleSideBarElements(logDisplayArrayOld[arrayOfPrevLogsKeys[countAPLK]]["id"],arrayOfPrevLogsKeys[countAPLK]);
	}
}

function startOfPollLogic()
{
	startOfPollLogicRan = true;
	refreshAction();

	if(pausePoll === "true")
	{
		pausePollCurrentSession = true;
	}
	else
	{
		startPollTimer();
		if(pauseOnNotFocus === "true")
		{
			startPauseOnNotFocus();
		}
	}
}

function generalUpdate()
{
	update(arrayOfDataMain);
}

function checkForUpdateLogsOffScreen()
{
	if(offscreenLogNotify !== "false")
	{
		checkForUpdateLogsOffScreenInner();
	}
}

function getCurrentWindowLayout()
{
	return document.getElementById("windowConfig").value;
}

function toggleVisibleAllLogs()
{
	if(document.getElementById("allLogsVisible").value === "false")
	{
		document.getElementById("menu").style.display = "none";
		if(logMenuLocation === "left")
		{
			$("#main").css("padding-left","0px");
		}
		else if(logMenuLocation === "right")
		{
			$("#main").css("padding-right","0px");
		}
		allLogsVisible = "false";
	}
	else
	{
		document.getElementById("menu").style.display = "block";
		if(logMenuLocation === "left")
		{
			$("#main").css("padding-left","200px");
		}
		else if(logMenuLocation === "right")
		{
			$("#main").css("padding-right","200px");
		}
		allLogsVisible = "true";
	}
	resize();
}

function mainReady()
{
	if(oneLogEnable === "true")
	{
		addOneLogTab();
		toggleVisibleOneLog();
	}
	dirForAjaxSend = "";
	progressBar = new ldBar("#progressBar");
	resize();
	updateProgressBar(10, "Generating File List");
	window.addEventListener("resize", resize);
	window.addEventListener("focus", focus);

	checkForUpdateMaybe();
	generateWindowDisplay();

	$("#searchFieldInput").on("input", function()
	{
		possiblyUpdateFromFilter();
	});

	if(document.getElementById("searchType"))
	{
		document.getElementById("searchType").addEventListener("change", changeSearchplaceholder, false);
	}

	if (typeof addUpdateNotification == 'function')
	{
		addUpdateNotification();
	}
	updateNotificationCount();

	$("#selectForGroup").on("keydown change", function(){
		setTimeout(function() {
			toggleGroupedGroups();
		}, 2);
	});

	$("#windowConfig").on("keydown change", function(){
		setTimeout(function() {
			generateWindowDisplay();
		}, 2);
	});

	document.addEventListener(
		'scroll',
		function (event)
		{
			onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
		},
		true
	);

	document.getElementById("menu").addEventListener(
		'scroll',
		function (event)
		{
			checkForUpdateLogsOffScreen();
		},
		true
	);

	refreshArrayObject("generalThemeOptions");
	refreshArrayObject("settingsColorFolderGroupVars");
}
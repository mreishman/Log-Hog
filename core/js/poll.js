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
					toggleDisplayOfNoLogs(true);
					if(firstLoad)
					{
						afterPollFunctionComplete();
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

function pollTwoPartTwo(data)
{
	try
	{
		if(firstLoad)
		{
			updateProgressBar(10, "Generating File Object","Generating File Object");
		}
		t2 = performance.now();
		filesNew = Object.keys(data);
		var backupArrayOfDataMain = arrayOfDataMain;

		var arrayOfDataMainKeys = Object.keys(arrayOfDataMain);
		var arrayOfDataMainKeysLength = arrayOfDataMainKeys.length;
		if(arrayOfDataMainKeysLength > 0)
		{
			for (var i = arrayOfDataMainKeysLength - 1; i >= 0; i--)
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
				if($.inArray(filterIdText(filesNew[updateCount]), logsToHide) !== -1)
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
				if($.inArray(filterIdText(filesNew[updateOldCount]), logsToHide) !== -1)
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
				updateProgressBar(10,arrayUpdateKeys[0] + "(" + currentFileSize + ")",  "Log: 1 of "+arrayUpdateKeys.length);
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
				var updateBy = (1/arrayUpdateKeys.length)*70;
				if(currentNew > 0)
				{
					updateProgressBar(updateBy, arrayUpdateKeys[currentNew-1] + "(" + formatBytes(fileData[arrayUpdateKeys[currentNew-1]]["size"]) + ")", "Log: "+(arrayUpdateKeys.length+1-currentNew)+" of "+arrayUpdateKeys.length);
					currentNew--;
					setTimeout(function(){ getFileSingle(currentNew); }, 100);
				}
				else
				{
					updateProgressBar(updateBy, "Finishing loading....", "Finishing loading");
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
		var filesInnerLength = filesInner.length;
		for (var dataSwapCount = filesInnerLength - 1; dataSwapCount >= 0; dataSwapCount--)
		{
			arrayOfDataMain[filesInner[dataSwapCount]] = data[filesInner[dataSwapCount]];
		}

		for (var lineCountUpdateCount = filesInnerLength - 1; lineCountUpdateCount >= 0; lineCountUpdateCount--)
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
		if(Object.keys(arrayOfDataMain).length < 1)
		{
			addOneLogData();
			document.getElementById("oneLog").style.display = "none";
		}
		else
		{
			addOneLogData();
		}
	}
	if(allLogsVisible === "true")
	{
		document.getElementById("menu").style.display = "block";
	}
	document.getElementById("menuButtons").style.display = "block";

	document.getElementById("firstLoad").style.display = "none";
	$('#initialLoadContent').addClass("hidden");
	setTimeout(function()
	{
		if($("#initialLoadContent").hasClass("hidden"))
		{
			document.getElementById('initialLoadContent').style.display = "none";
		}
	}, 1000);

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
	resize();
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

function logCheckForStandardMessage(logData)
{
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
	return {standardMessage, logData};
}

function getNameForLog(shortName, fullPathSearch, localFile, id)
{
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
		if(localFile in fileData && fileData[localFile]["Group"] !== "")
		{
			var newNameGroup = fileData[localFile]["Group"].split(" ")[0];
			nameForLog = "<span class='GroupInName' id='"+id+"GroupInName' >"+newNameGroup+":</span>"+nameForLog;
		}
		else if(localFile.indexOf("LogHog/Backup/") === 0)
		{
			nameForLog = "Backup:"+nameForLog;
		}
	}
	return nameForLog;
}

function getLineDiffCount(id)
{
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
	if(diff !== 0)
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
	return {
		diff: diff,
		newDiff: diffNew,
		newDiffText: newDiffText
	};
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
			id = filterIdText(name);

			if(( filterEnabled === "false" || showFileFromFilter(id, name, shortName, logData)) && (showFileFromGroup(id) || $("#"+id).hasClass("active")))
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
				if((logData === "This file is empty. This should not be displayed." && hideEmptyLog === "true") || logData === "Error - File does not exist")
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
						var logStandardCheckData = logCheckForStandardMessage(logData);
						var standardMessage = logStandardCheckData["standardMessage"];
						logData = logStandardCheckData["logData"];

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
						var fullPathSearch = name.trim();

						var nameForLog = getNameForLog(shortName, fullPathSearch, files[i], id);
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
								var filesNewLength = filesNew.length;
								var innerCount = i;
								if(filesNewLength > 0)
								{
									for (var innerCountFind = filesNewLength - 1; innerCountFind >= 0; innerCountFind--)
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
									var idCheck = filterIdText(files[i]);
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
							if(rightClickMenuEnable === "true")
							{
								addLogToRightClickMenu(files[i], id, fullPathSearch, shortName);
							}
						}

						var displayLocation = checkIfDisplay(id);
						updated = displayLocation["display"];
						if(fullPathSearch in fileData && fileData[fullPathSearch]["AlertEnabled"] === "true" && (!(id in alertEnabledArray) || (id in alertEnabledArray && alertEnabledArray[id] === "enabled")))
						{
							if(!(logs[id] === lastLogs[id]))
							{
								updated = true;
							}
						}
						if(updated)
						{
							//determine if id is one of the values in the array of open files (use instead of currentPage)
							var currentIdPos = displayLocation["location"];

							var diffData = getLineDiffCount(id);

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
								//check if equal
								if(!(logs[id] === lastLogs[id]))
								{
									$("#log"+currentIdPos).html(logFormatted);
									fadeHighlight(currentIdPos);
									unhideHidden(currentIdPos);
									if(logLoadType === "Visible - Poll")
									{
										startLoadPollTimerDelay();
									}
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
											if (diffData["diff"] !== 0)
											{
												numForNot = diffData["newDiff"];
											}
											addLogNotification({
												log: id,
												name: nameForLog+" Update "+numForNot,
												action: "$('#"+id+"').click();  closeNotificationsAndMainMenu();",
												newText: diffData["newDiffText"],
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
									if(!firstLoad && diffData["diff"] !== 0)
									{
										updateOneLogData(id, diffData["newDiff"], diffData["newDiffText"]);
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
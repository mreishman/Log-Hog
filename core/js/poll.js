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
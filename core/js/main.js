var arrayToUpdate = [];
var arrayOfData1 = null;
var arrayOfData2 = null;
var arrayOfDataMain = null;
var clearingNotifications = false;
var counterForPoll = 0;
var counterForPollForceRefreshAll = 0;
var counterForPollForceRefreshErr = 0;
var currentPage;
var currentSelectWindow = 0;
var dataFromUpdateCheck = null;
var fileSizes;
var filesNew;
var firstLoad = true;
var flasher;
var lastContentSearch = "";
var lastLogs = {};
var logs = {};
var logsToHide = new Array();
var pausePoll = false;
var percent = 0;
var polling = false;
var pollRefreshAllBoolStatic = pollRefreshAllBool;
var pollSkipCounter = 0;
var pollTimer = null;
var progressBar;
var refreshing = false;
var refreshPauseActionVar;
var startedPauseOnNonFocus = false;
var t0 = performance.now();
var t1 = performance.now();
var t2 = performance.now();
var t3 = performance.now();
var timeoutVar = null;
var timer;
var titles = {};
var updating = false;
var userPaused = false;
var title = $("title").text();

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
	if(bytes == 0)
	{
		return '0 Bytes';
	}
	var k = 1024;
	var dm = decimals || 2;
	var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
	var i = Math.floor(Math.log(bytes) / Math.log(k));
	return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
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
				if(document.getElementById("noticeBar").style.display === "none")
				{
					document.getElementById("noticeBar").style.display = "block";
				}
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
		var data = {currentVersion};
		$.ajax({
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				counterForPollForceRefreshErr = 0;
				if(document.getElementById("noticeBar").style.display !== "none")
				{
					document.getElementById("noticeBar").style.display = "none";
				}
				if(data === false)
				{
					showPopup();
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Log-Hog has been updated. Please Refresh</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Log-Hog has been updated, and is now on a new version. Please refresh the page.</div><div><div class='link' onclick='location.reload();' style='margin-left:165px; margin-right:50px;margin-top:35px;'>Reload</div></div>";
					clearPollTimer()
				}
				else if(data === "update in progress")
				{
					clearPollTimer()
					window.location.href = "update/updateInProgress.php";
				}
				else
				{
					fileSizes = data;
					pollTwoPartTwo(data);
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

		filesNew = Object.keys(data);
		arrayToUpdate = [];

		if(arrayOfData1 === null || boolForAllUpdateForce)
		{
			arrayOfData1 = data;
			for (var i = filesNew.length - 1; i >= 0; i--)
			{
				arrayToUpdate.push(filesNew[i]);
			}
		}
		else
		{
			var arrayOfData2 = data; 
			var filesOld = Object.keys(arrayOfData1);
			for (var i = filesNew.length - 1; i >= 0; i--)
			{
				if(filesOld.indexOf(filesNew[i]) > -1)
				{
					//file exists
					if(arrayOfData2[filesNew[i]] !== arrayOfData1[filesNew[i]])
					{
						arrayToUpdate.push(filesNew[i]);
					}
				}
				else
				{
					//file is new, add to array
					arrayToUpdate.push(filesNew[i]);
				}
			}
			
			for (var i = filesOld.length - 1; i >= 0; i--)
			{
				if(!(filesNew.indexOf(filesOld[i]) > -1))
				{
					//files old file isn't there in new file
					arrayToUpdate.push(filesOld[i]);
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
		if(arrayOfDataMain !== null)
		{
			for (var i = arrayToUpdate.length - 1; i >= 0; i--) 
			{
				if(arrayOfDataMain[arrayToUpdate[i]] === null)
				{
					delete arrayOfDataMain[arrayToUpdate[i]];
				}
				else
				{
					arrayOfDataMain[arrayToUpdate[i]] = null;
				}
			}
		}
		t3 = performance.now();
		if (typeof arrayToUpdate !== "undefined" && arrayToUpdate.length > 0) 
		{
			if(firstLoad)
			{
				updateProgressBar(10,arrayToUpdate[0],  "Loading file 1 of "+arrayToUpdate.length+" <br>  "+formatBytes(fileSizes[arrayToUpdate[0]]));
				getFileSingle(arrayToUpdate.length-1, arrayToUpdate.length-1);
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
						update(arrayOfDataMain);
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

function getFileSingle(current)
{
	try
	{
		var data = {arrayToUpdate: [arrayToUpdate[current]]};
		$.ajax({
			url: "core/php/poll.php?format=json",
			dataType: "json",
			currentFile: current,
			data,
			type: "POST",
			success(data)
			{
				arrayOfDataMainDataFilter(data);
				update(arrayOfDataMain);
			},
			complete()
			{
				var currentNew = this.currentFile;
				var updateBy = (1/arrayToUpdate.length)*60;
				updateProgressBar(updateBy, arrayToUpdate[currentNew-1], "Loading file "+(arrayToUpdate.length+1-currentNew)+" of "+arrayToUpdate.length+" <br>  "+formatBytes(fileSizes[arrayToUpdate[currentNew-1]]));
				if(currentNew > 0)
				{
					currentNew--;
					setTimeout(function(){ getFileSingle(currentNew); }, 100);
					
				}
				else
				{
					update(arrayOfDataMain);
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
			for (var i = filesInner.length - 1; i >= 0; i--) 
			{
				arrayOfDataMain[filesInner[i]] = data[filesInner[i]];
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
	document.getElementById("firstLoad").style.display = "none";
	document.getElementById("searchType").disabled = false;
	document.getElementById("searchFieldInput").disabled = false;
	document.getElementById("log").style.display = "table";
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
	t1 = performance.now();
	document.getElementById("loggingTimerPollRate").innerText = "Ajax refresh took    "+addPaddingToNumber(Math.round(t2 - t0))+":"+addPaddingToNumber(Math.round(t3 - t2),2)+":"+addPaddingToNumber(Math.round(t1 - t3))+"    " + addPaddingToNumber(Math.round(t1 - t0)) + "/" + addPaddingToNumber(pollingRate) +"("+addPaddingToNumber(parseInt(pollingRate)*counterForPoll)+") milliseconds.";
	document.getElementById("loggingTimerPollRate").style.color = "";
	counterForPoll = 0;
	var time = Math.round(t1-t0);
	var rate = parseInt(pollingRate);
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

function pausePollAction()
{
	try
	{
		if(pausePoll)
		{
			userPaused = false;
			pausePoll = false;
			showPauseButton();
			if(pollTimer === null)
			{
				poll();
				startPollTimer();
			}

		}
		else
		{
			userPaused = true;
			pausePollFunction();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshAction()
{
	try
	{
		if(pollRefreshAllBoolStatic === "false")
		{
			pollRefreshAllBool = "true";
		}
		counterForPollForceRefreshAll = 1+pollRefreshAll;
		showRefreshingButton();
		refreshing = true;
		poll();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function endRefreshAction()
{
	try
	{
		if(pollRefreshAllBoolStatic === "false")
		{
			pollRefreshAllBool = "false";
		}
		showRefreshButton(); 
		refreshing = false;
		if(pausePoll)
		{
			updateDocumentTitle("Paused");
		}
		else
		{
			updateDocumentTitle("Index");
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
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

		for(var i = 0; i !== stop; i++)
		{
			if(files[i].indexOf("dataForLoggingLogHog051620170928") === -1)
			{
				var dataForCheck = data[files[i]];
				var name = files[i];
				var selectListForFilter = document.getElementsByName("searchType")[0];
				var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
				var filterTextField = getFilterTextField();
				var showFile = false;
				shortName = files[i].replace(/.*\//g, "");
				id = name.replace(/[^a-z0-9]/g, "");
				

				var filterOffOf = "";
				if(selectedListFilterType === "title")
				{
					if(filterTitleIncludePath === "true")
					{
						filterOffOf = name;
					}
					else
					{
						filterOffOf = shortName;
					}
				}
				else if(selectedListFilterType === "content")
				{
					filterOffOf = dataForCheck;
				}

				if(caseInsensitiveSearch === "true")
				{
					filterOffOf = filterOffOf.toLowerCase();
				}

				if(logsToHide instanceof Array && (logsToHide.length === 0 || $.inArray(name, logsToHide) === -1 ))
				{
					if(filterOffOf !== "")
					{
						if(filterTextField === "" || filterOffOf.indexOf(filterTextField) !== -1)
						{
							showFile = true;
						}
					}
					else
					{
						showFile = true;
					}
				}
				if(showFile)
				{
					showLogByName(name);
					if(dataForCheck === "This file is empty. This should not be displayed." && hideEmptyLog === "true")
					{
						hideLogByName(name);
					}
					else
					{
						if(data[name] !== null)
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
							if(data[name] === "")
							{
								data[name] = "<div class='errorMessageLog errorMessageRedBG' >Error - Unknown error? Check file permissions or clear log to fix?</div>";
							}
							else if(data[name] === "This file is empty. This should not be displayed.")
							{
								data[name] = "<div class='errorMessageLog errorMessageGreenBG' > This file is empty. </div>";
							}
							else if((data[name] === "Error - File is not Readable") || (data[name] === "Error - Maybe insufficient access to read file?"))
							{
								var mainMessage = "Error - Maybe insufficient access to read file?";
								if(data[name] === "Error - File is not Readable")
								{
									mainMessage = "Error - File is not Readable";
								}
								data[name] = "<div class='errorMessageLog errorMessageRedBG' > "+mainMessage+" <br> <span style='font-size:75%;'> Try entering: <br> chown -R www-data:www-data "+name+" <br> or <br> chmod 664 "+name+" </span> </div>";
							}
							logs[id] = data[name];
							if(enableLogging !== "false")
							{
								titles[id] = name + " | " + data[name+"dataForLoggingLogHog051620170928"] + " | Size: " + formatBytes(fileSizes[files[i]]);
							}
							else
							{
								titles[id] = name + " | Size: " + formatBytes(fileSizes[files[i]]);
							}
							
							if(enableLogging !== "false")
							{
								if(id === currentPage)
								{
									$("#title"+currentSelectWindow).html(titles[id]);
								}
							}

							var lastLogLine = logs[id].count - 1;

							if($("#menu ." + id + "Button").length === 0) 
							{
								classInsert = "";
								item = blank;
								item = item.replace(/{{title}}/g, shortName);
								item = item.replace(/{{id}}/g, id);
								if(groupByColorEnabled === true)
								{
									classInsert += " buttonColor"+(folderNameCount+1)+" ";
								}
								item = item.replace(/{{class}}/g, classInsert);

								var itemAdded = false;

								if(!firstLoad)
								{
									var moveToFrontOnUpdate = false;
									var innerCount = i;
									for (var i = filesNew.length - 1; i >= 0; i--)
									{
										if(filesNew[i] === files[i])
										{
											innerCount = i;
											break;
										}
									}
									var innerCountStatic = innerCount;
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

								if(!itemAdded)
								{
									menu.append(item);
								}

								if(!firstLoad)
								{
									if(!$("#menu a." + id + "Button").hasClass("updated"))
									{
										$("#menu a." + id + "Button").addClass("updated");
									}
								}

								var hideLogAction = {action: "tmpHideLog(\""+name+"\");", name: "Tmp Hide Log"};
								var clearLogAction = {action: "clearLogInner(titles[\""+id+"\"]);", name: "Clear Log"};
								var deleteLogAction = {action: "deleteLogPopupInner(titles[\""+id+"\"]);", name: "Delete Log"};
								var copyNameAction = {action: "copyToClipBoard(\""+shortName+"\");", name: "Copy Name"};
								var copyFullPathAction = {action: "copyToClipBoard(titles[\""+id+"\"]);", name: "Copy Filepath"};
								//add rightclick menu
								menuObjectRightClick[id] = [hideLogAction, clearLogAction,deleteLogAction,copyNameAction,copyFullPathAction];
								Rightclick_ID_list.push(id);
							}

							updated = false;

							if(!(logs[id] === lastLogs[id]))
							{
								updated = true;
							}
							else
							{
								if(selectedListFilterType === "content" && filterContentHighlight === "true")
								{
									if(lastContentSearch !== getFilterTextField())
									{
										if(id === currentPage)
										{
											updated = true;
										}
									}
								}
							}

							if(updated)
							{
								//determine if id is one of the values in the array of open files (use instead of currentPage)
								var windows = Object.keys(logDisplayArray);
								var lengthOfWindows = windows.length;
								var currentIdPos = -1;
								for(var j = 0; j < lengthOfWindows; j++)
								{
									if(id === logDisplayArray[j]["id"])
									{
										currentIdPos = j;
										break;
									}
								}

								var diff = getDiffLogAndLastLog(id);
								if(diff !== "")
								{
									if(document.getElementById(id+"Count").innerHTML !== "" )
									{
										var count = document.getElementById(id+"CountHidden").innerHTML;
										diff = parseInt(count) + diff;
										if(diff > sliceSize)
										{
											diff = sliceSize;
										}
									}
								}
								var diffNew = diff;
								if(diff !== "")
								{
									diffNew = "("+diff+")";
								}
								if(document.getElementById(id+"CountHidden").innerHTML !== diff)
								{
									document.getElementById(id+"CountHidden").innerHTML = diff;
									if(notificationCountVisible === "true" && diff !== 0)
									{
										document.getElementById(id+"Count").innerHTML = diffNew;
									}
								}

								var updateHtml = true;
								if(currentIdPos === -1)
								{
									updateHtml = false
								}
								else if(scrollOnUpdate === "true" && scrollEvenIfScrolled === "false")
								{
									updateHtml = scrollPauseLogic(currentIdPos);
									logDisplayArray[currentIdPos]["scroll"] = updateHtml;
								}


								if(updateHtml)
								{
									$("#log"+currentIdPos).html(makePretty(id));
									fadeHighlight(currentIdPos);
									if(document.getElementById(id+"Count").innerHTML !== "")
									{
										document.getElementById(id+"Count").innerHTML = "";
										document.getElementById(id+"CountHidden").innerHTML = "";
									}
								}
								else
								{
									if(!firstLoad)
									{
										if(autoMoveUpdateLog === "true")
										{
											//'click' on log to switch to log
											$("#menu a." + id + "Button").click();
										}
										else
										{
											if(!$("#menu a." + id + "Button").hasClass("updated"))
											{
												$("#menu a." + id + "Button").addClass("updated");
											}
										}
									}
								}
							}
							
							
							if(initialized && updated && $(window).filter(":focus").length === 0) 
							{
								if(flashTitleUpdateLog)
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
				}
			}
		}
		resize();
		
		//Check if a tab is active, if none... click on first in array that's visible
		var targetLength = Object.keys(logDisplayArray).length;
		if($("#menu .active").length < targetLength)
		{
			var arrayOfLogs = $("#menu a");
			currentSelectWindow = 0;
			for (var i = 0; i < arrayOfLogs.length; i++)
			{
				if(arrayOfLogs[i].style.display !== "none")
				{
					arrayOfLogs[i].onclick.apply(arrayOfLogs[i]);
				}
				currentSelectWindow++;
				if(currentSelectWindow >= targetLength)
				{
					break;
				}
			}
			if(!firstLoad)
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
					if(document.getElementById("noLogToDisplay").style.display !== "none")
					{
						document.getElementById("noLogToDisplay").style.display = "none";
						document.getElementById("log").style.display = "block";
					}
				}
			}
		}

		toggleNotificationClearButton();
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
		
		lastContentSearch = getFilterTextField();

		refreshLastLogsArray();

		resize();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function scrollPauseLogic(id)
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

function tmpHideLog(name)
{
	hideLogByName(name);
	logsToHide.push(name);
	update(arrayOfDataMain);
}

function copyToClipBoard(whatToCopy)
{
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val(filterTitle(whatToCopy)).select();
	document.execCommand("copy");
	$temp.remove();
}

function tryToInsertBeforeLog(innerCount, stop, idCheck, item)
{
	var itemToBefore = null;
	while(itemToBefore === null && innerCount < stop)
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
		itemToBefore.before(item);
	}

	return (itemToBefore !== null);
}

function tryToInsertAfterLog(innerCount, stop, idCheck, item)
{
	var itemToBefore = null;
	while(itemToBefore === null && innerCount > 0)
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
		itemToBefore.after(item);
	}

	return (itemToBefore !== null);
}

function toggleNotificationClearButton()
{
	try
	{
		if($("#menu .updated").length !== 0)
		{
			//there is at least one updated thing, show button for clear all notifications
			if(document.getElementById("clearNotificationsImage").style.display !== "inline-block")
			{
				document.getElementById("clearNotificationsImage").style.display = "inline-block";
			}
		}
		else
		{
			if(document.getElementById("clearNotificationsImage").style.display !== "none")
			{
				document.getElementById("clearNotificationsImage").style.display = "none";
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function clearNotifications()
{
	clearingNotifications = true;
	try
	{
		if($("#menu .updated").length !== 0)
		{
			var arrayOfLogs = $("#menu a");
			for (var clearNotifCountOne = 0; clearNotifCountOne < arrayOfLogs.length; clearNotifCountOne++)
			{
				arrayOfLogs[clearNotifCountOne].classList.remove("updated");
			}
			var arrayOfCounts = $("#menu a .menuCounter");
			for (var clearNotifCountTwo = 0; clearNotifCountTwo < arrayOfCounts.length; clearNotifCountTwo++)
			{
				arrayOfCounts[clearNotifCountTwo].innerHTML = "";
			}
			var arrayOfCounts = $("#menu a .menuCounterHidden");
			for (var clearNotifCountTwo = 0; clearNotifCountTwo < arrayOfCounts.length; clearNotifCountTwo++)
			{
				arrayOfCounts[clearNotifCountTwo].innerHTML = "";
			}
		}
		refreshLastLogsArray();
		document.getElementById("clearNotificationsImage").style.display = "none";
	}
	catch(e)
	{
		eventThrowException(e);
	}
	clearingNotifications = false;
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
	}
	catch(e)
	{
		eventThrowException(e);
	}
	
}

function fadeHighlight(id)
{
	setTimeout(function(){ removeNewHighlights("#log"+id); }, 30);
}

function show(e, id) 
{
	try
	{
		$("#log"+currentSelectWindow).hide();
		$("#log"+currentSelectWindow+"load").show();
		resize();

		$(e).siblings().removeClass("active");
		var windowNumInTitle = $("#"+id+"CurrentWindow").html();
		if(windowNumInTitle !== "")
		{
			windowNumInTitle = windowNumInTitle + "0";
			var windowNumAsNum = parseInt(windowNumInTitle);
			$("#log"+(windowNumAsNum-1)).html("");
		}
		$("#log"+currentSelectWindow).html(makePretty(id));
		fadeHighlight(currentSelectWindow);
		//window number clear
		$('.currentWindowNum').each(function(i, obj)
		{
		    if(obj.innerHTML ==  ""+(currentSelectWindow+1)+". ")
		    {
		    	obj.innerHTML = "";
		    }
		});
		//window number add
		$("#"+id+"CurrentWindow").html(""+(currentSelectWindow+1)+". ");
		currentPage = id;
		logDisplayArray[currentSelectWindow]["id"] = id;
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
						$("."+logsCheck[j]+"Button").addClass("active").removeClass("updated");
					}
				}
			}
		}
		$("#title"+currentSelectWindow).html(titles[id]);

		$("#log"+currentSelectWindow+"load").hide();
		$("#log"+currentSelectWindow).show();

		resize();

		document.getElementById("log"+currentSelectWindow+"Td").scrollTop = $("#log"+currentSelectWindow).outerHeight();
		toggleNotificationClearButton();
		document.getElementById(id+"Count").innerHTML = "";
		document.getElementById(id+"CountHidden").innerHTML = "";

		
		resize();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function removeNewHighlights(area)
{
	$(area + " div").removeClass("newLine");
}

function getDiffLogAndLastLog(id)
{
	try
	{
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
					if(tmpTextLog[j].trim() !== tmpTextLast[lastStart].trim())
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
		return lengthOfArray;
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
		text = text.split("\n");
		var returnText = "";
		var lengthOfTextArray = text.length;
		var selectListForFilter = document.getElementsByName("searchType")[0];
		var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
		var bottomPadding = filterContentLinePadding;
		var topPadding = filterContentLinePadding;
		var foundOne = false;
		var addLine = false;
		for (var i = 0; i < lengthOfTextArray; i++)
		{
			addLine = false;
			if(selectedListFilterType === "content" && filterContentLimit === "true" && getFilterTextField() !== "")
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
					if(filterContentCheck(text[i]))
					{
						customClass += " highlight ";
						customClassAdd = true;
					}
				}

				customClass += " '";
				returnText += "<div ";
				if(customClassAdd)
				{
					returnText += " "+customClass+" ";
				}
				returnText += " >"+text[i]+"</div>";
			}
		}
		
		return returnText;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function filterContentCheck(textToMatch)
{
	var filterTextField = getFilterTextField();
	if(caseInsensitiveSearch === "true")
	{
		textToMatch = textToMatch.toLowerCase();
	}
	return (textToMatch.indexOf(filterTextField) !== -1);
}

function getFilterTextField()
{
	var filterTextField = document.getElementsByName("search")[0].value;
	if(caseInsensitiveSearch === "true")
	{
		filterTextField = filterTextField.toLowerCase();
	}
	return filterTextField;
}

function getScrollbarWidth()
{
    var outer = document.createElement("div");
    outer.style.visibility = "hidden";
    outer.style.width = "100px";
    outer.style.msOverflowStyle = "scrollbar"; // needed for WinJS apps

    document.body.appendChild(outer);

    var widthNoScroll = outer.offsetWidth;
    // force scrollbars
    outer.style.overflow = "scroll";

    // add innerdiv
    var inner = document.createElement("div");
    inner.style.width = "100%";
    outer.appendChild(inner);        

    var widthWithScroll = inner.offsetWidth;

    // remove divs
    outer.parentNode.removeChild(outer);

    return widthNoScroll - widthWithScroll;
}

function resize() 
{
	try
	{
		var targetHeight = window.innerHeight - $("#header").outerHeight();
		if(logMenuLocation === "top" || logMenuLocation === "bottom")
		{
			targetHeight = targetHeight - $("#menu").outerHeight();
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
		if(logMenuLocation === "bottom")
		{
			if(document.getElementById("main").style.bottom !== $("#menu").outerHeight())
			{
				document.getElementById("main").style.bottom = $("#menu").outerHeight()+"px";
			}
		}
		else if(logMenuLocation === "left" || logMenuLocation === "right")
		{
			if($("#menu").outerHeight() !== targetHeight)
			{
				$("#menu").outerHeight(targetHeight);
			}
		}
		var tdElementWidth = (targetWidth/windowDisplayConfigColCount).toFixed(4);
		var trElementHeight = ((targetHeight-borderPadding)/windowDisplayConfigRowCount).toFixed(4);
		if(($(".logTrHeight").outerHeight() !== trElementHeight)|| ($(".logTdWidth").outerWidth() !== tdElementWidth) || ($(".backgroundForSideBarMenu").outerHeight() !== trElementHeight))
		{
			$(".logTrHeight").outerHeight(trElementHeight);
			
			$(".logTdWidth").outerWidth(tdElementWidth);
			$(".backgroundForSideBarMenu").outerHeight(trElementHeight);
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function flashTitle() 
{
	try
	{
		stopFlashTitle();
		$("title").text("");
		flasher = setInterval(function() {
			$("title").text($("title").text() === "" ? title : "");
		}, 1000);
	}
	catch(e)
	{
		eventThrowException(e);
	}
	
}

function stopFlashTitle() 
{
	try
	{
		clearInterval(flasher);
		$("title").text(title);
	}
	catch(e)
	{
		eventThrowException(e);
	}
	
}

function focus() 
{
	stopFlashTitle();
}

function startPollTimer()
{
	/* Dont try catch visibility  */

	if(pausePollOnNotFocus === true || pausePollOnNotFocus === "true")
	{
		pollTimer = setInterval(poll, pollingRate);
	}
	else
	{
		pollTimer = Visibility.every(pollingRate, backgroundPollingRate, function () { poll(); });
	}
}

function clearPollTimer()
{
	/* Dont try catch visibility  */
	
	if(pausePollOnNotFocus === true || pausePollOnNotFocus === "true")
	{
		clearInterval(pollTimer);
	}
	else
	{
		Visibility.stop(pollTimer);
	}
	pollTimer = null;
}

function switchPollType()
{
	if(pausePollOnNotFocus === true || pausePollOnNotFocus === "true")
	{
		clearInterval(pollTimer);
		pausePollOnNotFocus = false;
		pollTimer = Visibility.every(pollingRate, backgroundPollingRate, function () { poll(); });
		showPopup();
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Toggled off!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Toggled off auto pause in background</div></div>";
	}
	else
	{
		Visibility.stop(pollTimer);
		pausePollOnNotFocus = true;
		pollTimer = setInterval(poll, pollingRate);
		showPopup();
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Toggled on!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Toggled on auto pause in background</div></div>";
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
		if(isPageHidden() && pausePollOnNotFocus)
		{
			//hidden
			if(!pausePoll)
			{
				pausePollFunction();
			}
			return;
		}

		//not hidden
		if(!userPaused && pausePoll)
		{
			pausePoll = false;
			showPauseButton();
			stopFlashTitle();
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
		pausePoll = true;
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
	try
	{
		return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
    }
	catch(e)
	{
		eventThrowException(e);
	}
}

function scrollToBottom(idNum)
{
	document.getElementById("log"+idNum+"Td").scrollTop = $("#log"+idNum).outerHeight();
}

function clearLogInner(title)
{
	var urlForSend = "core/php/clearLog.php?format=json";
	title = filterTitle(title);
	var data = {file: title};
	$.ajax({
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
	success(data)
	{
		refreshLastLogsArray();
	},
	});
}

function clearLog(idNum)
{
	try
	{
		if(document.getElementById("title"+idNum).textContent !== "")
		{
			var title = document.getElementById("title"+idNum).textContent;
			clearLogInner(title);
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
		if(popupSettingsArray.deleteLog == "true")
		{
			showPopup();
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >Are you sure you want to clear all logs?</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\"></div><div><div class=\"link\" onclick=\"deleteActionAfter();hidePopup();\" style=\"margin-left:125px; margin-right:50px;margin-top:35px;\">Yes</div><div onclick=\"hidePopup();\" class=\"link\">No</div></div>";
		}
		else
		{
			deleteLog(title);
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
		var title = document.getElementById("title"+idNum).textContent;
		deleteLogPopupInner(title);
		
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
		if(popupSettingsArray.deleteLog == "true")
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
				removeLogByName(data);
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

function installUpdates()
{
	try
	{
		displayLoadingPopup();
		//reset vars in post request
		var urlForSend = "core/php/resetUpdateFilesToDefault.php?format=json";
		var data = {status: "" };
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			complete(data)
			{
				//set thing to check for updated files. 	
				timeoutVar = setInterval(function(){verifyChange();},3000);
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function verifyChange()
{
	try
	{
		var urlForSend = "update/updateActionCheck.php?format=json";
		var data = {status: "" };
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				if(data == "finishedUpdate")
				{
					clearInterval(timeoutVar);
					actuallyInstallUpdates();
				}
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function actuallyInstallUpdates()
{
	try
	{
		$("#settingsInstallUpdate").submit();
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
		if (autoCheckUpdate == true)
		{
			if(daysSinceLastCheck > (daysSetToUpdate - 1))
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

function showPauseButton()
{
	try
	{
		document.getElementById("pauseImage").style.display = "inline-block";
		document.getElementById("playImage").style.display = "none";
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showPlayButton()
{
	try
	{
		document.getElementById("pauseImage").style.display = "none";
		document.getElementById("playImage").style.display = "inline-block";
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showRefreshButton()
{
	try
	{
		document.getElementById("refreshImage").style.display = "inline-block";
		document.getElementById("refreshingImage").style.display = "none";
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showRefreshingButton()
{
	try
	{
		document.getElementById("refreshImage").style.display = "none";
		document.getElementById("refreshingImage").style.display = "inline-block";
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

function changeSearchplaceholder()
{
	var selectListForFilter = document.getElementsByName("searchType")[0];
	var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
	document.getElementById("searchFieldInput").placeholder = "Filter "+selectedListFilterType;
	update(arrayOfDataMain);
}

function changeCurrentSelectWindow(newSelectWindow)
{
	$("#numSelectIndecatorForWindow"+currentSelectWindow).removeClass("currentWindowNumSelected").addClass("sidebarCurrentWindowNum");
	currentSelectWindow = newSelectWindow;
	$("#numSelectIndecatorForWindow"+newSelectWindow).removeClass("sidebarCurrentWindowNum").addClass("currentWindowNumSelected");
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

function toggleFilterSettingsPopup()
{
	showPopup();
	var innerHtmlForSettings = "<div class='settingsHeader' id='popupHeaderText' ><span id='popupHeaderText' >Local Filter Content Settings</span><a style=\"float: right; margin-top: -3px;\" onclick=\"hidePopup();\" class=\"linkSmall\" >Close</a></div><div style='width:100%;'>";
	innerHtmlForSettings += "<ul id=\"settingsUl\" ><li><span class=\"settingsBuffer\" > Case Insensitive Search: </span> <div class=\"selectDiv\">";
	innerHtmlForSettings += "<select onchange=\"changeFilterCase();\" id=\"caseInsensitiveSearch\">";
	innerHtmlForSettings += "<option";
	if(caseInsensitiveSearch === 'true')
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"true\">True</option>";
	innerHtmlForSettings += "<option";
	if(caseInsensitiveSearch === 'false')
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"false\">False</option>";
	innerHtmlForSettings += " </select></div></li>";
	innerHtmlForSettings += "<li><span class=\"settingsBuffer\" > Filter Title Includes Path: </span>";
	innerHtmlForSettings += " <div class=\"selectDiv\"><select onchange=\"changeFilterTitleIncludePath();\" id=\"filterTitleIncludePath\">";
	innerHtmlForSettings += "<option ";
	if(filterTitleIncludePath === 'true')
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"true\">True</option>";
	innerHtmlForSettings += "<option ";
	if(filterTitleIncludePath === 'false')
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"false\">False</option>";
	innerHtmlForSettings += " </select></div></li>";
	innerHtmlForSettings += "<li><span class=\"settingsBuffer\" > Highlight Content match: </span>";
	innerHtmlForSettings += " <div class=\"selectDiv\"><select onchange=\"changeHighlightContentMatch();\" id=\"filterContentHighlight\">";
	innerHtmlForSettings += "<option";
	if(filterContentHighlight === 'true')
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"true\">True</option>";
	innerHtmlForSettings += "<option";
	if(filterContentHighlight === 'false')
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"false\">False</option>";
	innerHtmlForSettings += " </select></div></li>";
	innerHtmlForSettings += " <li><span class=\"settingsBuffer\" > Filter Content match: </span>";
	innerHtmlForSettings += " <div class=\"selectDiv\"><select onchange=\"changeFilterContentMatch();\" id=\"filterContentLimit\">";
	innerHtmlForSettings += "<option";
	if(filterContentLimit === 'true')
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"true\">True</option>";
	innerHtmlForSettings += "<option";
	if(filterContentLimit === 'false')
	{
		innerHtmlForSettings += " selected ";
	} 
	innerHtmlForSettings += " value=\"false\">False</option>";
	innerHtmlForSettings += "</select></div></li>";
	innerHtmlForSettings += "<li><span class=\"settingsBuffer\" > Line Padding: </span>";
	innerHtmlForSettings += " <div class=\"selectDiv\">	<select onchange=\"changeFilterContentLinePadding();\" id=\"filterContentLinePadding\">";
	for (var i=0; i < 10; i++)
	{
		innerHtmlForSettings += "<option ";
		if(parseInt(filterContentLinePadding) === i)
		{
			innerHtmlForSettings += " selected ";
		}
		innerHtmlForSettings += " value="+i+">"+i+"</option>";
	}
	innerHtmlForSettings += "</select></div></li>";
	innerHtmlForSettings += "</ul></div>";
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = innerHtmlForSettings;
	document.getElementById("popupContent").style.height = "273px";
	document.getElementById("popupContent").style.marginTop = "-136px";
}

function changeFilterCase()
{
	caseInsensitiveSearch = document.getElementById("caseInsensitiveSearch").value;
	possiblyUpdateFromFilter();
}

function changeHighlightContentMatch()
{
	filterContentHighlight = document.getElementById("filterContentHighlight").value;
	possiblyUpdateFromFilter();
}

function changeFilterContentMatch()
{
	filterContentLimit = document.getElementById("filterContentLimit").value;
	possiblyUpdateFromFilter();
}

function changeFilterContentLinePadding()
{
	filterContentLinePadding = parseInt(document.getElementById("filterContentLinePadding").value);
	possiblyUpdateFromFilter();
}

function changeFilterTitleIncludePath()
{
	filterTitleIncludePath = document.getElementById("filterTitleIncludePath").value;
	possiblyUpdateFromFilter();
}

function possiblyUpdateFromFilter()
{
	if(document.getElementById("searchFieldInput").value !== "")
	{
		lastContentSearch = "";
		update(arrayOfDataMain);
	}
}

$(document).ready(function()
{
	progressBar = new ldBar("#progressBar");
	resize();
	updateProgressBar(10, "Generating File List");
	window.addEventListener("resize", resize);
	window.addEventListener("focus", focus);

	refreshAction();

	if(pausePollFromFile)
	{
		pausePoll = true;

	}
	else
	{
		startPollTimer();
	}

	if(pausePollOnNotFocus)
	{
		startPauseOnNotFocus();
	}

	checkForUpdateMaybe();


	$("#searchFieldInput").on("input", function()
	{
		update(arrayOfDataMain);
	});

	if(document.getElementById("searchType"))
	{
		document.getElementById("searchType").addEventListener("change", changeSearchplaceholder, false);
	}
});
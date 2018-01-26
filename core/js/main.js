var arrayToUpdate = [];
var arrayOfData1 = null;
var arrayOfData2 = null;
var arrayOfDataMain = null;
var clearingNotifications = false;
var counterForPoll = 0;
var counterForPollForceRefreshAll = 0;
var currentPage;
var currentSelectWindow = 0;
var dataFromUpdateCheck = null;
var fileSizes;
var filesNew;
var firstLoad = true;
var flasher;
var fresh = true;
var lastContentSearch = "";
var lastLogs = {};
var logs = {};
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
				if(data === false)
				{
					showPopup();
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Log-Hog has been updated. Please Refresh</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Log-Hog has been updated, and is now on a new version. Please refresh the page.</div><div><div class='link' onclick='location.reload();' style='margin-left:165px; margin-right:50px;margin-top:35px;'>Reload</div></div>";
				}
				else if(data === "update in progress")
				{
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
			arrayToUpdate = [];
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
						fresh = false;
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
					fresh = false;
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

function afterPollFunctionComplete()
{
	try
	{
		if(firstLoad)
		{
			firstLoad = false;
			document.getElementById("firstLoad").style.display = "none";
			document.getElementById("searchType").disabled = false;
			document.getElementById("searchFieldInput").disabled = false;
			document.getElementById("log").style.display = "table";
		}
		if(refreshing)
		{
			endRefreshAction();
		}
		polling = false;
		if(enablePollTimeLogging !== "false")
		{
			t1 = performance.now();
			document.getElementById("loggingTimerPollRate").innerText = "Ajax refresh took    "+addPaddingToNumber(Math.round(t2 - t0))+":"+addPaddingToNumber(Math.round(t3 - t2),2)+":"+addPaddingToNumber(Math.round(t1 - t3))+"    " + addPaddingToNumber(Math.round(t1 - t0)) + "/" + addPaddingToNumber(pollingRate) +"("+addPaddingToNumber(parseInt(pollingRate)*counterForPoll)+") milliseconds.";
			document.getElementById("loggingTimerPollRate").style.color = "";
			counterForPoll = 0;
			if(Math.round(t1-t0) > parseInt(pollingRate))
			{
				if(Math.round(t1-t0) > (2*parseInt(pollingRate)))
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

function update(data) {
	try
	{
		var menu = $("#menu");
		var blank = $("#storage .menuItem").html();
		var id, shortName, item, style, folderName;
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

				

				var filterOffOf = "";
				if(selectedListFilterType === "title")
				{
					filterOffOf = name;
				}
				else if(selectedListFilterType === "content")
				{
					filterOffOf = dataForCheck;
				}

				if(caseInsensitiveSearch === "true")
				{
					filterOffOf = filterOffOf.toLowerCase();
				}

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
							id = name.replace(/[^a-z0-9]/g, "");
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
								titles[id] = name + " | " + data[name+"dataForLoggingLogHog051620170928"];
							}
							else
							{
								titles[id] = name;
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
								shortName = files[i].replace(/.*\//g, "");
								classInsert = "buttonColor"+(folderNameCount+1);
								item = blank;
								item = item.replace(/{{title}}/g, shortName);
								item = item.replace(/{{id}}/g, id);
								if(groupByColorEnabled === true)
								{
									item = item.replace(/{{class}}/g, classInsert);
								}

								var itemAdded = false;

								if(!fresh)
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

								if(!fresh)
								{
									if(!$("#menu a." + id + "Button").hasClass("updated"))
									{
										$("#menu a." + id + "Button").addClass("updated");
									}
								}
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
									if(id === logDisplayArray[j])
									{
										currentIdPos = j;
										break;
									}
								}
								if(currentIdPos !== -1)
								{
									$("#log"+currentIdPos).html(makePretty(logs[id]));
									if(document.getElementById(id+"Count").innerHTML !== "")
									{
										document.getElementById(id+"Count").innerHTML = "";
										document.getElementById(id+"CountHidden").innerHTML = "";
									}
								}
								else
								{
									if(!fresh)
									{
										if(!$("#menu a." + id + "Button").hasClass("updated"))
										{
											$("#menu a." + id + "Button").addClass("updated");
										}

										if(notificationCountVisible === "true")
										{
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
											if(document.getElementById(id+"Count").innerHTML !== diffNew)
											{
												document.getElementById(id+"CountHidden").innerHTML = diff;
												document.getElementById(id+"Count").innerHTML = diffNew;
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
		if($("#menu .active").length === 0)
		{
			var arrayOfLogs = $("#menu a");
			for (var i = 0; i < arrayOfLogs.length; i++)
			{
				if(arrayOfLogs[i].style.display !== "none")
				{
					arrayOfLogs[i].onclick.apply(arrayOfLogs[i]);
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
			if(logDisplayArray[i] !== null)
			{
				var logsCheck = Object.keys(logs);
				var lengthOfLogsCheck = logsCheck.length;
				for(var j = 0; j < lengthOfLogsCheck; j++)
				{
					if(logDisplayArray[i] === logsCheck[j])
					{
						var currentPageId = logsCheck[j];
						if(logs[currentPageId] !== lastLogs[currentPageId])
						{
							lastLogs[currentPageId] = logs[currentPageId];
							if(scrollOnUpdate === "true")
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

function show(e, id) 
{
	try
	{
		$(e).siblings().removeClass("active");
		$("#log"+currentSelectWindow).html(makePretty(logs[id]));
		
		$('.currentWindowNum').each(function(i, obj) {
		    if(obj.innerHTML ==  ""+(currentSelectWindow+1)+". ")
		    {
		    	obj.innerHTML = "";
		    }
		});
		
		$("#"+id+"CurrentWindow").html(""+(currentSelectWindow+1)+". ");
		currentPage = id;
		logDisplayArray[currentSelectWindow] = id;
		var windows = Object.keys(logDisplayArray);
		var lengthOfWindows = windows.length;
		for(var i = 0; i < lengthOfWindows; i++)
		{
			if(logDisplayArray[i] !== null)
			{
				var logsCheck = Object.keys(logs);
				var lengthOfLogsCheck = logsCheck.length;
				for(var j = 0; j < lengthOfLogsCheck; j++)
				{
					if(logDisplayArray[i] === logsCheck[j])
					{
						$("."+logsCheck[j]+"Button").addClass("active").removeClass("updated");
					}
				}
			}
		}
		$("#title"+currentSelectWindow).html(titles[id]);
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

function makePretty(text) 
{
	try
	{
		text = text.split("\n");
		var returnText = "";
		var lengthOfTextArray = text.length;
		var selectListForFilter = document.getElementsByName("searchType")[0];
		var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
		var bottomPadding = filterContentLinePadding;
		var topPadding = filterContentLinePadding;
		var foundOne = false;
		var addLine = false;
		var customStyle = "";
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
				customStyle = "";
				if(selectedListFilterType === "content" && filterContentHighlight === "true" && getFilterTextField() !== "")
				{
					//check if match, and if supposed to highlight
					if(filterContentCheck(text[i]))
					{
						customStyle += "class = 'highlight' ";
					}
				}
				returnText += "<div "+customStyle+" >"+text[i]+"</div>";
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
		var targetHeight = window.innerHeight - $("#menu").outerHeight();
		var targetWidth = window.innerWidth;
		if(enablePollTimeLogging !== "false")
		{
			targetHeight -= 25;
		}
		if($("#main").outerHeight() !== targetHeight)
		{
			$("#main").outerHeight(targetHeight);
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
		if(isPageHidden())
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

function clearLog(idNum)
{
	try
	{
		if(document.getElementById("title"+idNum).textContent !== "")
		{
			var urlForSend = "core/php/clearLog.php?format=json";
			var title = filterTitle(document.getElementById("title"+idNum).textContent);
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
		var title = filterTitle(document.getElementById("title"+idNum).textContent);
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
	catch(e)
	{
		eventThrowException(e);
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
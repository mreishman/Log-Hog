var alertEnabledArray = {};
var arrayToUpdate = {};
var arrayOfData1 = null;
var arrayOfData2 = null;
var arrayOfDataMain = null;
var arrayOfDataSettings = [];
var arrayOfScrollHeaderUpdate = ["aboutSpanAbout","aboutSpanInfo","aboutSpanGithub"];
var borderPadding = 0;
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
var pollRefreshAllBoolStatic = pollRefreshAllBool;
var pollSkipCounter = 0;
var pollTimer = null;
var progressBar;
var refreshing = false;
var refreshPauseActionVar;
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
				if(!($("#selectForGroup option[value='"+data[filesNew[updateCount]]["Group"]+"']").length > 0) && data[filesNew[updateCount]]["Group"] !== "")
				{
					$("#selectForGroup").append("<option value='"+data[filesNew[updateCount]]["Group"]+"'>"+data[filesNew[updateCount]]["Group"]+"</option>");
					if(document.getElementById("selectForGroupDiv").style.display === "none")
					{
						document.getElementById("selectForGroupDiv").style.display = "inline-block";
					}
				}
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
				if(!($("#selectForGroup option[value='"+data[filesNew[updateOldCount]]["Group"]+"']").length > 0) && data[filesNew[updateOldCount]]["Group"] !== "")
				{
					$("#selectForGroup").append("<option value='"+data[filesNew[updateOldCount]]["Group"]+"'>"+data[filesNew[updateOldCount]]["Group"]+"</option>");
					if(document.getElementById("selectForGroupDiv").style.display === "none")
					{
						document.getElementById("selectForGroupDiv").style.display = "inline-block";
					}
				}
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

function getArrayOfGroups(data)
{
	var fileDataKeys = Object.keys(data);
	var fileDataKeysLength = fileDataKeys.length;
	var arrayOfGroups = new Array();
	for(var OGRcount = 0; OGRcount < fileDataKeysLength; OGRcount++)
	{
		var group = data[fileDataKeys[OGRcount]]["Group"];
		if($.inArray(group, arrayOfGroups) === -1 && $.inArray(fileDataKeys[OGRcount].replace(/[^a-z0-9]/g, ""), logsToHide) === -1)
		{
			arrayOfGroups.push(group);
		}
	}
	return arrayOfGroups;
}

function updateGroupsOnTabs(data, arrayOfGroupsModded)
{
	var arrayOfGroupsLength = arrayOfGroupsModded.length;
	var fileDataKeysTwo = Object.keys(data);
	var fileDataKeysLengthTwo = fileDataKeysTwo.length;
	var idForTab = "";
	for(var EGRcount = 0; EGRcount < arrayOfGroupsLength; EGRcount++)
	{
		arrayOfGroupsModded[EGRcount] = arrayOfGroupsModded[EGRcount] + "Group";
	}
	for(var UGRcount = 0; UGRcount < fileDataKeysLengthTwo; UGRcount++)
	{
		idForTab = fileDataKeysTwo[UGRcount].replace(/[^a-z0-9]/g, "");
		if(document.getElementById(idForTab))
		{
			var classList = document.getElementById(idForTab).className.split(' ');
			var classListLength = classList.length;
			for(var classCount = 0; classCount < classListLength; classCount++)
			{
				if(classList[classCount].indexOf("Group") > -1 && classList[classCount] !== "allGroup")
				{
					if($.inArray(classList[classCount], arrayOfGroupsModded) === -1)
					{
						//class is not in group, remove it from tab
						$("#"+idForTab).removeClass(classList[classCount]);
						if($("#"+idForTab+"GroupInName"))
						{
							//group name shows, update if there is one
							var possibleNewGroup = data[fileDataKeysTwo[UGRcount]]["Group"];
							$("#"+idForTab+"GroupInName").html("");
							if(possibleNewGroup !== "")
							{
								$("#"+idForTab+"GroupInName").html(possibleNewGroup+":");
							}
						}
					}
				}
			}
		}
	}

	for(var AGRcount = 0; AGRcount < fileDataKeysLengthTwo; AGRcount++)
	{
		idForTab = fileDataKeysTwo[AGRcount].replace(/[^a-z0-9]/g, "");
		if(document.getElementById(idForTab))
		{
			var groupSearch = data[fileDataKeysTwo[AGRcount]]["Group"];
			if(!$("#"+idForTab).hasClass(groupSearch+"Group"))
			{
				$("#"+idForTab).addClass(groupSearch+"Group");
			}
		}
	}
}

function removeOldGroups(data, arrayOfGroups)
{
	var modCOScount = 0;
	var currentOptionsSelect = document.getElementById('selectForGroup').options;
	var currentOptionsSelectLength = currentOptionsSelect.length;
	for(var COScount = 0; COScount < currentOptionsSelectLength; COScount++)
	{
		if(currentOptionsSelect[modCOScount].value !== "all" && $.inArray(currentOptionsSelect[modCOScount].value, arrayOfGroups) === -1)
		{
			//remove because not in new array
			var selectGroupSelector = document.getElementById('selectForGroup');
			$('#selectForGroup option[value="'+currentOptionsSelect[modCOScount].value+'"]').remove();
			modCOScount--;
		}
		modCOScount++;
	}
}

function pollThree(arrayToUpdate)
{
	try
	{
		var arrayUpdateKeys = Object.keys(arrayToUpdate);
		if(arrayOfDataMain !== null)
		{
			for (var i = arrayUpdateKeys.length - 1; i >= 0; i--) 
			{
				if(arrayOfDataMain[arrayUpdateKeys[i]] === null)
				{
					delete arrayOfDataMain[arrayUpdateKeys[i]];
				}
				else
				{
					arrayOfDataMain[arrayUpdateKeys[i]] = null;
				}
			}
		}
		t3 = performance.now();
		if (typeof arrayToUpdate !== "undefined" && arrayUpdateKeys.length > 0) 
		{
			if(firstLoad)
			{
				updateProgressBar(10,arrayUpdateKeys[0],  "Loading file 1 of "+arrayUpdateKeys.length+" <br>  "+formatBytes(fileData[arrayUpdateKeys[0]]["size"]));
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
						generalUpdate();
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

function pausePollAction()
{
	try
	{
		if(pausePollCurrentSession)
		{
			userPaused = false;
			pausePollCurrentSession = false;
			showPauseButton();
			if(pollTimer === null)
			{
				poll();
				startPollTimer();
			}
			if(!startedPauseOnNonFocus && pauseOnNotFocus === "true")
			{
				startPauseOnNotFocus();
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
		if(pausePollCurrentSession)
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

function getFilterData(name, shortName, logData)
{
	var selectListForFilter = document.getElementsByName("searchType")[0];
	var selectedListFilterType = selectListForFilter.options[selectListForFilter.selectedIndex].value;
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
		filterOffOf = logData;
	}

	if(caseInsensitiveSearch === "true")
	{
		if(filterOffOf !== "")
		{
			filterOffOf = filterOffOf.toLowerCase();
		}
	}
	return filterOffOf;
}

function showFileFromFilter(id, name, shortName, logData)
{
	var filterOffOf = getFilterData(name, shortName, logData);
	if(logsToHide instanceof Array && (logsToHide.length === 0 || $.inArray(id, logsToHide) === -1 ))
	{
		if(filterOffOf !== "")
		{
			var filterTextField = getFilterTextField();
			if(filterTextField === "" || filterOffOf.indexOf(filterTextField) !== -1)
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	return false;
}

function showFileFromGroup(id)
{
	var groupSelect = document.getElementById("selectForGroup").value;
	if(groupSelect === "all")
	{
		return true;
	}
	if($("#"+id).hasClass(groupSelect+"Group"))
	{
		return true;
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
		for(var i = 0; i !== stop; i++)
		{
			var name = files[i];

			if((!(name in data)) || typeof(data[name]) === "undefined" || data[name] === null)
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
						if(enableLogging !== "false")
						{
							titles[id] = name + " | " + data[name]["data"] + " | Size: " + formatBytes(fileData[files[i]]["size"]);
						}
						else
						{
							titles[id] = name + " | Size: " + formatBytes(fileData[files[i]]["size"]);
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

						if($("#menu ." + id + "Button").length === 0) 
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
							if(logNameGroup === "true" && fileData[files[i]]["Group"] !== "")
							{
								nameForLog = "<span id='"+id+"GroupInName' >"+fileData[files[i]]["Group"]+":</span>"+nameForLog;
							}
							classInsert = "";
							item = blank;
							item = item.replace(/{{title}}/g, nameForLog);
							item = item.replace(/{{id}}/g, id);
							if(groupByColorEnabled === "true")
							{
								classInsert += " buttonColor"+(folderNameCount+1)+" ";
							}
							if(fileData[fullPathSearch]["Group"] !== "")
							{
								classInsert += " "+fileData[files[i]]["Group"]+"Group ";
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
								if(!$("#menu a." + id + "Button").hasClass("updated") && fileData[fullPathSearch]["AlertEnabled"] === "true" && (!(id in alertEnabledArray) || (id in alertEnabledArray && alertEnabledArray[id] === "enabled")))
								{
									$("#menu a." + id + "Button").addClass("updated");

									addLogNotification({
										log: id,
										name: "New Log "+nameForLog,
										action: "$('#"+id+"').click();  toggleNotifications();"
									});
								}
							}

							var hideLogAction = {action: "tmpHideLog(\""+id+"\");", name: "Tmp Hide Log"};
							var clearLogAction = {action: "clearLogInner(titles[\""+id+"\"]);", name: "Clear Log"};
							var deleteLogAction = {action: "deleteLogPopupInner(titles[\""+id+"\"]);", name: "Delete Log"};
							var copyNameAction = {action: "copyToClipBoard(\""+shortName+"\");", name: "Copy File Name"};
							var copyFullPathAction = {action: "copyToClipBoard(titles[\""+id+"\"]);", name: "Copy Filepath"};
							var alertToggle = {action: "tmpToggleAlerts(\""+id+"\");" ,name: "Enable Alerts"};
							if(fileData[fullPathSearch]["AlertEnabled"] === "true")
							{
								alertToggle = {action: "tmpToggleAlerts(\""+id+"\");" ,name: "Disable Alerts"};
							}
							//add rightclick menu
							if(rightClickMenuEnable === "true")
							{
								menuObjectRightClick[id] = [hideLogAction, clearLogAction,deleteLogAction,copyNameAction,copyFullPathAction,alertToggle];
								Rightclick_ID_list.push(id);
							}
						}

						updated = false;
						if(fileData[fullPathSearch]["AlertEnabled"] === "true" && (!(id in alertEnabledArray) || (id in alertEnabledArray && alertEnabledArray[id] === "enabled")))
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
								$("#log"+currentIdPos).html(logFormatted);
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
										var numForNot = "";
										if (diffNew !== "(0)")
										{
											numForNot = diffNew;
										}
										addLogNotification({
											log: id,
											name: shortName+" Update "+numForNot,
											action: "$('#"+id+"').click();  toggleNotifications();"
										});
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
		resize();
		//Check if a tab is active, if none... click on first in array that's visible
		var targetLength = Object.keys(logDisplayArray).length;
		var tmpCurrentSelectWindow = currentSelectWindow;
		if($("#menu .active").length < targetLength)
		{
			selectTabsInOrder(targetLength);

			if(!firstLoad)
			{
				toggleDisplayOfNoLogs();
			}
		}
		else if($("#menu .active").length > targetLength)
		{
			removeTabsInOrder(targetLength);
		}
		//below changes the current select window back to what was selected by user (could change by function above)
		changeCurrentSelectWindow(tmpCurrentSelectWindow);

		toggleNotificationClearButton();
		updateScrollOnLogs();
		lastContentSearch = getFilterTextField();
		refreshLastLogsArray();

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
				var currentLayout = document.getElementById("windowConfig").value;
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
					var currentLayout = document.getElementById("windowConfig").value;
					var layoutVersionIndex = document.getElementById("layoutVersionIndex").value;
					if(logLoadLayout.length !== 0 && logLoadLayout[currentLayout][h][layoutVersionIndex] !== "" && logLoadLayout[currentLayout][h][layoutVersionIndex] in fileData )
					{
						if(checkNameCont(logLoadLayout[currentLayout][h][layoutVersionIndex].replace(/[^a-z0-9]/g, ""), arrayOfLogs[i]))
						{
							continue;
						}
					}
					if(h === 0 && logSelectedFirstLoad !== "" && logSelectedFirstLoad in fileData)
					{
						if(checkNameCont(logSelectedFirstLoad.replace(/[^a-z0-9]/g, ""), arrayOfLogs[i]))
						{
							continue;
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
		if(currentCheck.id !== checkName)
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

function tmpToggleAlerts(id)
{
	try
	{
		var menuObjectLocal = menuObjectRightClick[id];
		var options = Object.keys(menuObjectLocal);
		var lengthOfOptions = options.length;
		for(var i = 0; i < lengthOfOptions; i++)
		{
			var currentOption = menuObjectLocal[options[i]];
			if(currentOption["name"] === "Enable Alerts" || currentOption["name"] === "Disable Alerts")
			{
				menuObjectRightClick[id][options[i]]["name"] = "Disable Alerts";
				if(currentOption["name"] === "Disable Alerts")
				{
					menuObjectRightClick[id][options[i]]["name"] = "Enable Alerts";
				}
				break;
			}
		}
		alertEnabledArray[id] = "enabled";
		if(currentOption["name"] === "Disable Alerts")
		{
			alertEnabledArray[id] = "disabled";
			removeNotificationByLog(id);
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
		$("#log"+i).html("");
		$("#menu ." + idOfName + "Button currentWindowNum").html("");
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
		if(logs[internalID].indexOf("errorMessageLog errorMessageRedBG") > -1 || logs[id].indexOf("errorMessageLog errorMessageGreenBG") > -1)
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

function showPartThree(e, internalID, currentCurrentSelectWindow)
{
	try
	{
		$("#log"+currentCurrentSelectWindow+"load").hide();
		$("#log"+currentCurrentSelectWindow).show();
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
					else if(tmpTextLog[j].trim() !== tmpTextLast[lastStart].trim())
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
		text = text.split("\n");
		if(text.length < 2)
		{
			text = text[0].split("\\n");
		}
		var returnText = "<table width=\"100%\" style=\"border-spacing: 2px 0;\" >";
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
					returnText += " >"+formatLine(lineText[j])+"</tr>";
					returnText += "<tr height=\""+logLinePadding+"px\" ><td colspan=\"2\"></td></tr>";
				}
			}
		}
		returnText += "</table>";
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
		updateNotificationCount();
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
		popupSettingsArrayCheck();
		if("deleteLog" in popupSettingsArray && popupSettingsArray.deleteLog == "true")
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
	generalUpdate();
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

function toggleFilterSettingsPopup()
{
	showPopup();
	var innerHtmlForSettings = "<div class='settingsHeader' id='popupHeaderText' ><span id='popupHeaderText' >Local Filter Content Settings</span><a style=\"float: right; margin-top: -3px;\" onclick=\"hidePopup();\" class=\"linkSmall\" >Close</a></div><div style='width:100%;'>";
	innerHtmlForSettings += "<ul class=\"settingsUl\" ><li><span class=\"settingsBuffer\" > Case Insensitive Search: </span> <div class=\"selectDiv\">";
	innerHtmlForSettings += "<select onchange=\"changeFilterCase();\" id=\"caseInsensitiveSearch\">";
	innerHtmlForSettings += "<option";
	if(caseInsensitiveSearch === "true")
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"true\">True</option>";
	innerHtmlForSettings += "<option";
	if(caseInsensitiveSearch === "false")
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"false\">False</option>";
	innerHtmlForSettings += " </select></div></li>";
	innerHtmlForSettings += "<li><span class=\"settingsBuffer\" > Filter Title Includes Path: </span>";
	innerHtmlForSettings += " <div class=\"selectDiv\"><select onchange=\"changeFilterTitleIncludePath();\" id=\"filterTitleIncludePath\">";
	innerHtmlForSettings += "<option ";
	if(filterTitleIncludePath === "true")
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"true\">True</option>";
	innerHtmlForSettings += "<option ";
	if(filterTitleIncludePath === "false")
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"false\">False</option>";
	innerHtmlForSettings += " </select></div></li>";
	innerHtmlForSettings += "<li><span class=\"settingsBuffer\" > Highlight Content match: </span>";
	innerHtmlForSettings += " <div class=\"selectDiv\"><select onchange=\"changeHighlightContentMatch();\" id=\"filterContentHighlight\">";
	innerHtmlForSettings += "<option";
	if(filterContentHighlight === "true")
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"true\">True</option>";
	innerHtmlForSettings += "<option";
	if(filterContentHighlight === "false")
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"false\">False</option>";
	innerHtmlForSettings += " </select></div></li>";
	innerHtmlForSettings += " <li><span class=\"settingsBuffer\" > Filter Content match: </span>";
	innerHtmlForSettings += " <div class=\"selectDiv\"><select onchange=\"changeFilterContentMatch();\" id=\"filterContentLimit\">";
	innerHtmlForSettings += "<option";
	if(filterContentLimit === "true")
	{
		innerHtmlForSettings += " selected ";
	}
	innerHtmlForSettings += " value=\"true\">True</option>";
	innerHtmlForSettings += "<option";
	if(filterContentLimit === "false")
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
		generalUpdate();
	}
}

function toggleNotifications()
{
	if(document.getElementById("fullScreenMenu").style.display !== "none")
	{
		toggleFullScreenMenu();
	}
	if(document.getElementById("notifications").style.display === "inline-block")
	{
		document.getElementById("notifications").style.display = "none";
		document.getElementById("notificationNotClicked").style.display = "inline-block";
		document.getElementById("notificationClicked").style.display = "none";
		document.getElementById("notificationCount").style.color = "white";
	}
	else
	{
		showNotifications();
		document.getElementById("notificationNotClicked").style.display = "none";
		document.getElementById("notificationClicked").style.display = "inline-block";
		document.getElementById("notifications").style.display = "inline-block";
		document.getElementById("notifications").style.left = (document.getElementById("notificationDiv").getBoundingClientRect().left-27) + "px";
		document.getElementById("notifications").style.top = (document.getElementById("notificationDiv").getBoundingClientRect().top+25) + "px";
		document.getElementById("notificationCount").style.color = "black";
	}
}

function showNotifications()
{
	var arrayInternalNotifications = new Array();
	if(notifications.length < 1)
	{
		//no notifications to show
		arrayInternalNotifications[0] = new Array();
		arrayInternalNotifications[0]["id"] = 0;
		arrayInternalNotifications[0]["name"] = "No Notifications";
		arrayInternalNotifications[0]["time"] = formatAMPM(new Date());
		arrayInternalNotifications[0]["action"] = "";
	}
	else
	{
		arrayInternalNotifications = notifications;
	}
	displayNotifications(arrayInternalNotifications);

}

function clearAllNotifications()
{
	$("#notificationHolder").empty();
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

function displayNotifications(notificationsArray)
{
	clearAllNotifications();
	var htmlForNotifications = "<span style=\"overflow: auto; max-height: 300px; display: block;\" >";
	for (var i = notificationsArray.length - 1; i >= 0; i--)
	{
		var blank;
		if("image" in notificationsArray[i])
		{
			blank = $("#storage .notificationContainerWithImage").html();
		}
		else if(notificationsArray[i]["name"] === "No Notifications")
		{
			blank = $("#storage .notificationContainerEmpty").html();
		}
		else
		{
			blank = $("#storage .notificationContainer").html();
		}
		var item = blank;
		item = item.replace(/{{id}}/g, "notification"+notificationsArray[i]['id']);
		item = item.replace(/{{idNum}}/g, i);
		item = item.replace(/{{name}}/g, notificationsArray[i]['name']);
		item = item.replace(/{{time}}/g, notificationsArray[i]['time']);
		item = item.replace(/{{action}}/g, notificationsArray[i]['action']);
		if("image" in notificationsArray[i])
		{
			item = item.replace(/{{image}}/g, notificationsArray[i]['image']);
		}
		htmlForNotifications += item;
	}
	htmlForNotifications += "</span>";
	$("#notificationHolder").append(htmlForNotifications);
	$("#notificationHolder").append($("#storage .notificationButtons").html());
}

function removeAllNotifications()
{
	clearNotifications();
	notifications = new Array();
	updateNotificationStuff();
}

function removeNotificationByLog(logId)
{
	for (var i = notifications.length - 1; i >= 0; i--)
	{
		if("log" in notifications[i])
		{
			if(notifications[i]["log"] === logId)
			{
				removeNotification(i);
				break;
			}
		}
	}
}

function removeNotification(idToRemove)
{
	if(idToRemove in notifications)
	{
		//remove from array
		if("log" in notifications[idToRemove])
		{
			var logId = notifications[idToRemove]["log"];
			document.getElementById(logId).classList.remove("updated");
			document.getElementById(logId+"Count").innerHTML = "";
			document.getElementById(logId+"CountHidden").innerHTML = "";
		}
		notifications.splice(idToRemove, 1);
	}
	updateNotificationStuff();
}

function updateNotificationCount()
{
	var currentCount = notifications.length;
	if(currentCount > 0)
	{
		if(currentCount < 10)
		{
			currentCount = "0" + currentCount;
		}
		if(document.getElementById("notificationCount").innerHTML == currentCount)
		{
			return;
		}
		$("#notificationCount").empty();
		document.getElementById("notificationIcon").style.display = "block";
		$("#notificationCount").append(currentCount);
		document.getElementById("notificationCount").style.left = (document.getElementById("notificationDiv").getBoundingClientRect().left+5) + "px";
		document.getElementById("notificationBadge").style.left = (document.getElementById("notificationDiv").getBoundingClientRect().left-5) + "px";
		document.getElementById("notificationCount").style.top = (document.getElementById("notificationDiv").getBoundingClientRect().top+11) + "px";
		document.getElementById("notificationBadge").style.top = (document.getElementById("notificationDiv").getBoundingClientRect().top+19) + "px";
	}
	else
	{
		$("#notificationCount").empty();
		document.getElementById("notificationIcon").style.display = "none";
	}
}

function addLogNotification(notificationArray)
{
	//check if log notification is already displayed. If so, get ID of that for current ID
	for (var i = notifications.length - 1; i >= 0; i--)
	{
		if("log" in notifications[i])
		{
			if(notifications[i]["log"] === notificationArray["log"])
			{
				notificationArray["currentId"] = i;
				break;
			}
		}
	}
	addNotification(notificationArray);
}

function addNotification(notificationArray)
{

	var currentId = notifications.length;
	if("currentId" in notificationArray)
	{
		currentId = notificationArray["currentId"];
	}
	notifications[currentId] = new Array();
	notifications[currentId]["id"] = currentId;
	notifications[currentId]["name"] = notificationArray["name"];
	notifications[currentId]["time"] = formatAMPM(new Date());
	notifications[currentId]["action"] = notificationArray["action"];
	if("log" in notificationArray)
	{
		notifications[currentId]["log"] = notificationArray["log"];
	}

	updateNotificationStuff();
}

function updateNotificationStuff()
{
	updateNotificationCount();
	showNotifications();
}

function toggleFullScreenMenu()
{
	dirForAjaxSend = "";
	if(document.getElementById("notifications").style.display === "inline-block")
	{
		toggleNotifications();
	}
	if(document.getElementById("fullScreenMenu").style.display === "none")
	{
		loadImgFromData("mainMenuImage");
		document.getElementById("fullScreenMenu").style.display = "block";
		onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
		if($("#menuStatusAddon").hasClass("selected"))
		{
			$("#menuStatusAddon").click();
		}
		else if($("#menuMonitorAddon").hasClass("selected"))
		{
			$("#menuMonitorAddon").click();
		}
		else if ($("#menuSearchAddon").hasClass("selected"))
		{
			$("#menuSearchAddon").click();
		}
		else if ($("#menuSeleniumMonitorAddon").hasClass("selected"))
		{
			$("#menuSeleniumMonitorAddon").click();
		}
	}
	else
	{
		hideIframeStuff();
		document.getElementById("fullScreenMenu").style.display = "none";
	}
}

function toggleUpdateMenu(force = false)
{
	if(!force)
	{
		if(!(goToPageCheck("toggleUpdateMenu(true)")))
		{
			return false;
		}
	}
	loadImgFromData("updateImg");
	hideMainStuff();
	hideSidebar();
	document.getElementById("fullScreenMenuUpdate").style.display = "block";
	$("#mainMenuUpdate").addClass("selected");
	arrayOfScrollHeaderUpdate = ["updateUpdate","updateReleaseNotes"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
}

function toggleAbout(force = false)
{
	if(!force)
	{
		if(!(goToPageCheck("toggleAbout(true)")))
		{
			return false;
		}
	}
	hideMainStuff();
	document.getElementById("mainContentFullScreenMenu").style.left = ""+402+"px";
	document.getElementById("aboutSubMenu").style.display = "block";
	$("#mainMenuAbout").addClass("selected");
	toggleAboutLogHog();
}

function toggleAboutLogHog()
{
	hideAboutStuff();
	document.getElementById("fullScreenMenuAbout").style.display = "block";
	$("#aboutSubMenuAbout").addClass("selected");
	arrayOfScrollHeaderUpdate = ["aboutSpanAbout","aboutSpanInfo","aboutSpanGithub"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
}

function toggleWhatsNew()
{
	loadImgFromData("whatsNewImage");
	hideAboutStuff();
	document.getElementById("fullScreenMenuWhatsNew").style.display = "block";
	$("#aboutSubMenuWhatsNew").addClass("selected");
	arrayOfScrollHeaderUpdate = ["fullScreenMenuWhatsNew"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
}

function toggleChangeLog()
{
	hideAboutStuff();
	document.getElementById("fullScreenMenuChangeLog").style.display = "block";
	$("#aboutSubMenuChangelog").addClass("selected");
	arrayOfScrollHeaderUpdate = ["fullScreenMenuChangeLog"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
}

function toggleWatchListMenu(force = false)
{
	if(!force)
	{
		if(!(goToPageCheck("toggleWatchListMenu(true)")))
		{
			return false;
		}
	}
	if(typeof loadWatchList !== "function")
	{
		script("core/js/settingsWatchlist.js?v="+cssVersion);
	}
	else
	{
		resetProgressBarWatchList();
	}
	$(".uniqueClassForAppendSettingsMainWatchNew").html("");
	$("#loadingSpan").show();
	document.getElementById("mainContentFullScreenMenu").style.left = ""+402+"px";
	loadImgFromData("watchlistImg");
	hideMainStuff();
	arrayOfDataSettings = ["settingsMainWatch"];
	document.getElementById("fullScreenMenuWatchList").style.display = "block";
	document.getElementById("watchListSubMenu").style.display = "block";
	$("#watchListMenu").addClass("selected");
	arrayOfScrollHeaderUpdate = ["settingsMainWatch"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	if(typeof loadWatchList !== "function")
	{
		setTimeout(function() {
			timerForWatchlist = setInterval(tryLoadWatch, 100);
		}, 250);
	}
	else
	{
		setTimeout(function() {
			timerForWatchlist = setInterval(tryLoadWatch, 100);
		}, 25);
	}
}

function tryLoadWatch()
{
	if(typeof loadWatchList === "function")
	{
		clearInterval(timerForWatchlist);
		startSettingsPollTimer();
		loadWatchList();
	}
}

function startSettingsPollTimer()
{
	timerForSettings = setInterval(checkIfChanges, 100);
}

function checkIfChanges()
{
	if(checkForChangesArray(arrayOfDataSettings))
	{
		return true;
	}
	return false;
}

function goToPageCheck(functionName)
{
	try
	{
		var goToPage = !checkIfChanges();
		popupSettingsArrayCheck();
		if(!(goToPage || ("saveSettings" in popupSettingsArray  && popupSettingsArray.saveSettings == "false")))
		{
			displaySavePromptPopupIndex(functionName);
			return false;
		}
		return true;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function endSettingsPollTimer()
{
	arrayOfDataSettings = [];
	clearInterval(timerForSettings);
}

function hideSidebar()
{
	document.getElementById("mainContentFullScreenMenu").style.left = ""+201+"px";
}

function hideWatchListStuff()
{
	document.getElementById("fullScreenMenuWatchList").style.display = "none";
	document.getElementById("watchListSubMenu").style.display = "none";
}

function hideUpdateStuff()
{
	document.getElementById("fullScreenMenuUpdate").style.display = "none";
}

function hideAboutStuff()
{
	document.getElementById("fullScreenMenuAbout").style.display = "none";
	$("#aboutSubMenuAbout").removeClass("selected");
	document.getElementById("fullScreenMenuChangeLog").style.display = "none";
	$("#aboutSubMenuChangelog").removeClass("selected");
	document.getElementById("fullScreenMenuWhatsNew").style.display = "none";
	$("#aboutSubMenuWhatsNew").removeClass("selected");
}

function hideIframeStuff()
{
	document.getElementById("fullScreenMenuIFrame").style.display = "none";
	$('#iframeFullScreen').prop('src', "");
}

function toggleIframe(locHref, idOfAddon, force = false)
{
	if(!force)
	{
		if(!(goToPageCheck("toggleIframe(\""+locHref+"\",\""+idOfAddon+"\",true)")))
		{
			return false;
		}
	}
	hideMainStuff();
	$("#"+idOfAddon).addClass("selected");
	document.getElementById("fullScreenMenuIFrame").style.display = "block";
	document.getElementById("mainContentFullScreenMenu").style.left = ""+201+"px";
	$('#iframeFullScreen').prop('src', locHref);
	var mainContentRect = document.getElementById("mainContentFullScreenMenu").getBoundingClientRect();
	document.getElementById("iframeFullScreen").style.width = ""+mainContentRect.width+"px";
	document.getElementById("iframeFullScreen").style.height = ""+mainContentRect.height+"px";
	arrayOfScrollHeaderUpdate = [];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	return false;
}

function hideMainStuff()
{
	endSettingsPollTimer();

	if($("#mainMenuAbout").hasClass("selected"))
	{
		document.getElementById("aboutSubMenu").style.display = "none";
		hideAboutStuff();
	}

	$("#mainMenuAbout").removeClass("selected");

	if($("#mainMenuUpdate").hasClass("selected"))
	{
		hideUpdateStuff();
	}

	$("#mainMenuUpdate").removeClass("selected");


	if($("#menuStatusAddon").hasClass("selected") || $("#menuMonitorAddon").hasClass("selected") || $("#menuSearchAddon").hasClass("selected") || $("#menuSeleniumMonitorAddon").hasClass("selected"))
	{
		hideIframeStuff();
	}

	if($("#watchListMenu").hasClass("selected"))
	{
		hideWatchListStuff();
	}

	$("#watchListMenu").removeClass("selected");

	$("#menuStatusAddon").removeClass("selected");
	$("#menuMonitorAddon").removeClass("selected");
	$("#menuSearchAddon").removeClass("selected");
	$("#menuSeleniumMonitorAddon").removeClass("selected");
}

function toggleGroupedGroups()
{
	var groupSelect = document.getElementById("selectForGroup").value;
	var listOfTabs = $("#menu a");
	var listOfTabsKeys = Object.keys(listOfTabs);
	var listOfTabsKeysLength = listOfTabsKeys.length;
	for(var groupCount = 0; groupCount < listOfTabsKeysLength; groupCount++)
	{
		var objectTab = listOfTabs[listOfTabsKeys[groupCount]];
		if(!objectTab)
		{
			continue;
		}
		var idOfObject = objectTab.id;
		if($("#"+idOfObject).hasClass("active"))
		{
			//show tab if hidden
			$("#"+idOfObject).show();
		}
		else if($.inArray(idOfObject, logsToHide) > -1)
		{
			//hide tab if not valid
			$("#"+idOfObject).hide();
		}
		else if(document.getElementById("searchFieldInput").value === "")
		{
			if($("#"+idOfObject).hasClass(groupSelect+"Group") || groupSelect === "all")
			{
				//show tab if valid
				$("#"+idOfObject).show();
			}
			else
			{
				//hide tab if not valid
				$("#"+idOfObject).hide();
			}
		}
	}
	//hide empty files if needed
	if(hideEmptyLog === "true")
	{
		hideEmptyLogs();
	}
	resize();
}

function hideEmptyLogs()
{
	var logKeys = Object.keys(logs);
	var logKeysLength = logKeys.length;
	for(var logHideCheck = 0; logHideCheck < logKeysLength; logHideCheck++)
	{
		if(logs[logKeys[logHideCheck]] === "<div class='errorMessageLog errorMessageGreenBG' > This file is empty. </div>")
		{
			hideLogByName(logKeys[logHideCheck]);
		}
	}
}

function onScrollShowFixedMiniBar(idsOfForms)
{
	if(!document.getElementById("fixedPositionMiniMenu"))
	{
		return;
	}
	if(idsOfForms.length < 1)
	{
		$("#fixedPositionMiniMenu").html("");
		if(document.getElementById("fixedPositionMiniMenu").style.display !== "none")
		{
			document.getElementById("fixedPositionMiniMenu").style.display = "none";
		}
		return;
	}
	var widthOfMainMenu = document.getElementById("mainContentFullScreenMenu").getBoundingClientRect().width;
	if (document.getElementById("fixedPositionMiniMenu").style.width !==  widthOfMainMenu)
	{
		document.getElementById("fixedPositionMiniMenu").style.width = widthOfMainMenu;
	}
	var dis = false;
	for (var i = idsOfForms.length - 1; i >= 0; i--)
	{
		var currentPos = document.getElementById(idsOfForms[i]).getBoundingClientRect().top;
		if(currentPos < 46)
		{
			$("#fixedPositionMiniMenu").html($("#"+idsOfForms[i]+" .settingsHeader").html());
			if(document.getElementById("fixedPositionMiniMenu").style.display === "none")
			{
				document.getElementById("fixedPositionMiniMenu").style.display = "block";
			}
			dis = true;
			break;
		}
	}
	if(!dis)
	{
		$("#fixedPositionMiniMenu").html("");
		if(document.getElementById("fixedPositionMiniMenu").style.display !== "none")
		{
			document.getElementById("fixedPositionMiniMenu").style.display = "none";
		}
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

function multiLogPopup()
{
	if(document.getElementById("subMenuForGroup").style.display === "none")
	{
		//show menu
		document.getElementById("menu2").style.display = "block";
		document.getElementById("subMenuForGroup").style.display = "block";
	}
	else
	{
		//hide menu
		document.getElementById("menu2").style.display = "none";
		document.getElementById("subMenuForGroup").style.display = "none";
	}
	resize();
}

function generateWindowDisplay()
{
	var windowDisplayConfig = document.getElementById("windowConfig").value;
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

function loadPrevLogContent(arrayOfPrevLogs)
{
	var arrayOfPrevLogsKeys = Object.keys(arrayOfPrevLogs);
	var totalarrayOfPrevLogs = arrayOfPrevLogsKeys.length;
	for(var countAPLK = 0; countAPLK < totalarrayOfPrevLogs; countAPLK++)
	{
		$("#log"+arrayOfPrevLogsKeys[countAPLK]).html(arrayOfPrevLogs[arrayOfPrevLogsKeys[countAPLK]]);
		$("#log"+arrayOfPrevLogsKeys[countAPLK]+"load").hide();
		scrollToBottom(arrayOfPrevLogsKeys[countAPLK]);
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

function swapLayoutLetters(letter)
{
	document.getElementById("layoutVersionIndex").value = letter;
	if(logSwitchABCClearAll === "true")
	{
		unselectAllLogs();
	}
	else
	{
		unselectLogsThatAreInNewLayout();
	}
	generalUpdate();
}

function resetSelection()
{
	var currentLayout = document.getElementById("layoutVersionIndex").value;
	swapLayoutLetters(currentLayout);
}

function generalUpdate()
{
	update(arrayOfDataMain);
}

$(document).ready(function()
{
	progressBar = new ldBar("#progressBar");
	resize();
	updateProgressBar(10, "Generating File List");
	window.addEventListener("resize", resize);
	window.addEventListener("focus", focus);

	checkForUpdateMaybe();
	generateWindowDisplay();

	$("#searchFieldInput").on("input", function()
	{
		generalUpdate();
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
});

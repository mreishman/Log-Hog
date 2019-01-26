var alertEnabledArray = {};
var allLogOneLog = {};
var arrayToUpdate = {};
var arrayOfData1 = null;
var arrayOfData2 = null;
var arrayOfDataMain = {};
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
var idOfOneLogOpen = "";
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

function getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min) ) + min;
}


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
		.replace(/\\/g, "&#x5c;")
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
		.replace(/&#x5c;/g, "\\")
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

function updateFileDataArray(newDataArr)
{
	if(expFormatEnabled === "true" && logFormatFileEnable === "true")
	{
		updateFileDataArrayInner(newDataArr);
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
				
			}
			if(document.getElementById("log").style.display !== "none")
			{
				document.getElementById("log").style.display = "none";
			}
		}
		else
		{
			//we do not need this, hide popup
			if(document.getElementById("noLogToDisplay").style.display !== "none")
			{
				document.getElementById("noLogToDisplay").style.display = "none";
				
			}
			if(document.getElementById("log").style.display !== "block")
			{
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

function removeLogFromDisplay(currentLogNum)
{
	var internalID = logDisplayArray[currentLogNum]["id"];
	if(internalID.indexOf("ogogackup") === 0)
	{
		removeArchiveLogFromDisplay(currentLogNum);
		return;
	}
	//check if oneLog is enabled
	if(oneLogEnable === "true")
	{
		//check if oneLog is open in another block
		//if not in another block, switch this block to oneLog
		var currentOneLogPosition = isOneLogVisible();
		if(currentOneLogPosition === false)
		{
			//switch back to onelog
			switchBackToOnelog(currentLogNum);
			return;
		}
		//else close, and go back to 1x1 window with onelog open
		if(oneLogEnable === "true")
		{
			closeToOneLogInFull(currentLogNum, currentOneLogPosition);
			return;
		}
	}
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

function toggleLogPopup(event, currentCurrentSelectWindow)
{
	if(isLogPopupOpen())
	{
		closeLogPopup();
	}
	else
	{
		openLogPopup(event,currentCurrentSelectWindow);
	}
}

function openLogPopup(event,currentCurrentSelectWindow)
{
	closeLogPopup();
	var height = $("#log"+currentCurrentSelectWindow+"Td").outerHeight()/2;
	var eventData = $(event);
	var popupHtml = $("#storage .logListPopup").html();
	var newWindowHtml = $("#menu").html();
	newWindowHtml = newWindowHtml.replace(/id="/g, "id=\"popup");
	newWindowHtml = newWindowHtml.replace(/show\(this,/g, "clickLog(");
	popupHtml = popupHtml.replace(/{{content}}/g, newWindowHtml);
	popupHtml = popupHtml.replace(/{{maxHeight}}/g, height+"px");
	$("#popupSelectContainer").html(popupHtml);
	$("#popupSelectContainer").css("top",((eventData.offset().top-height-20)+"px"));
	$("#popupSelectContainer").css("left",((eventData.offset().left+40)+"px"));
	document.getElementById("popupSelectContainer").style.display = "block";
}

function clickLog(logId)
{
	$("#"+logId).click();
}

function closeLogPopup()
{
	if(isLogPopupOpen())
	{
		document.getElementById("popupSelectContainer").style.display = "none";
		$("#popupSelectContainer").html("");
	}
}

function isLogPopupOpen()
{
	if(document.getElementById("popupSelectContainer").style.display === "block")
	{
		return true;
	}
	return false;
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
	else if(internalID === idOfOneLogOpen)
	{
		visibleStatusOfCloseLogSideBar  = "block";
		idOfOneLogOpen = "";
	}
	if(visibleStatusOfCloseLogSideBar === "block")
	{
		loadImgFromData("closeImageForLoad");
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
		var tdElementWidth = (targetWidth/windowDisplayConfigColCount).toFixed(0);
		var trElementHeight = ((targetHeight-borderPadding)/windowDisplayConfigRowCount).toFixed(0);
		if(($(".logTrHeight").outerHeight().toFixed(0) !== trElementHeight)|| ($(".logTdWidth").outerWidth().toFixed(0) !== tdElementWidth))
		{
			closeLogPopup();
			if($(".logTrHeight").outerHeight() !== trElementHeight)
			{
				$(".logTrHeight").outerHeight(trElementHeight);
			}
			if($(".logTdWidth").outerWidth() !== tdElementWidth)
			{
				$(".logTdWidth").outerWidth(tdElementWidth);
			}
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
  var ampm = hours >= 12 ? "pm" : "am";
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? "0"+minutes : minutes;
  var strTime = hours + ":" + minutes + " " + ampm;
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
		arrayOfPrevLogs
	};
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
	if(filterEnabled === "true")
	{
		$("#searchFieldInput").on("input", function()
		{
			possiblyUpdateFromFilter(false);
		});

		if(document.getElementById("searchType"))
		{
			document.getElementById("searchType").addEventListener("change", changeSearchplaceholder, false);
		}
	}

	if (typeof addUpdateNotification == "function")
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
		"scroll",
		function (event)
		{
			onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
		},
		true
	);

	document.getElementById("menu").addEventListener(
		"scroll",
		function (event)
		{
			checkForUpdateLogsOffScreen();
		},
		true
	);

	refreshArrayObject("generalThemeOptions");
	refreshArrayObject("settingsColorFolderGroupVars");
}
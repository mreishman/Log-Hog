var title = $("title").text();
var currentPage;
var logs = {};
var titles = {};
var lastLogs = {};
var fresh = true;
var flasher;
var updating = false;
var startedPauseOnNonFocus = false;
var polling = false;
var t0 = performance.now();
var t1 = performance.now();
var t2 = performance.now();
var t3 = performance.now();
var counterForPoll = 0;
var arrayOfData1 = null;
var arrayOfData2 = null;
var arrayToUpdate = [];
var arrayOfDataMain = null;
var pollTimer = null;
var dataFromUpdateCheck = null;
var timeoutVar = null;
var pollSkipCounter = 0;
var counterForPollForceRefreshAll = 0;
var filesNew;
var pausePoll = false;
var refreshPauseActionVar;
var userPaused = false;
var refreshing = false;
var percent = 0;
var pollRefreshAllBoolStatic = pollRefreshAllBool;

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

function poll()
{
	try
	{
    	checkForUpdateMaybe();
		if(refreshing)
		{
			document.title = "Log Hog | Refreshing";
		}
		else
		{
			document.title = "Log Hog | Index";
		}
		counterForPoll++;
		if(!polling)
		{
			pollSkipCounter = 0;
			updateSkipCounterLog(pollSkipCounter);
			polling = true;
			t0 = performance.now();
			pollTwo();
		}
		else
		{
			if(pollForceTrueBool === "true")
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
		var data = {currentVersion: currentVersion};
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

		if(arrayOfData1 == null || boolForAllUpdateForce)
		{
			arrayOfData1 = data;
			filesNew = Object.keys(arrayOfData1);
			for (i = filesNew.length - 1; i >= 0; i--)
			{
				arrayToUpdate.push(filesNew[i]);
			}
		}
		else
		{
			var arrayOfData2 = data; 
			filesNew = Object.keys(arrayOfData2);
			var filesOld = Object.keys(arrayOfData1);

			arrayToUpdate = [];

			for (i = filesNew.length - 1; i >= 0; i--)
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

			for (i = filesOld.length - 1; i >= 0; i--)
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
		if(arrayOfDataMain != null)
		{
			for (var i = arrayToUpdate.length - 1; i >= 0; i--) 
			{
				if(arrayOfDataMain[arrayToUpdate[i]] == null)
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
			var urlForSend = "core/php/poll.php?format=json";
			var data = {arrayToUpdate: arrayToUpdate};
			$.ajax({
				url: urlForSend,
				dataType: "json",
				data: data,
				type: "POST",
				success(data)
				{
					var filesInner = Object.keys(data);
					if(arrayOfDataMain == null)
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
					update(arrayOfDataMain);
					fresh = false;
				},
				complete()
				{
					afterPollFunctionComplete();
				}
			});	
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

function afterPollFunctionComplete()
{
	try
	{
    	document.getElementById('firstLoad').style.display = 'none';
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
			document.getElementById("pauseImage").src="core/img/Pause.png";
			if(pollTimer == null)
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
    	if(pollRefreshAllBoolStatic == "false")
		{
    		pollRefreshAllBool = "true";
		}
    	counterForPollForceRefreshAll = 1+pollRefreshAll;
		document.getElementById("refreshImage").src="core/img/loading.gif";
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
		if(pollRefreshAllBoolStatic == "false")
    	{
    		pollRefreshAllBool = "false";
    	}
	    document.getElementById("refreshImage").src="core/img/Refresh.png"; 
		refreshing = false;
		if(pausePoll)
		{
			document.title = "Log Hog | Paused";
		}
		else
		{
			document.title = "Log Hog | Index";
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
	    //console.log(data);
		var menu = $("#menu");
		var blank = $("#storage .menuItem").html();
		var i, id, name, shortName, item, style, folderName;
		var files = Object.keys(data);
		var stop = files.length;
		var updated = false;
		var initialized = $("#menu a").length !== 0;
		var colorArray = currentFolderColorThemeArrayOfColors;
		var colorArrayLength = colorArray.length;
		var folderNamePrev = "?-1";
		var folderNameCount = -1;
		for(i = 0; i !== stop; ++i) {
			if(files[i].indexOf("dataForLoggingLogHog051620170928") === -1)
			{
				var dataForCheck = data[files[i]];
				name = files[i];
				if(dataForCheck === "This file is empty. This should not be displayed." && hideEmptyLog === "true")
				{
					removeLogByName(name);
				}
				else
				{
					if(data[name] != null)
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
								$("#title").html(titles[id]);
							}
						}

						if($("#menu ." + id + "Button").length === 0) 
						{
							shortName = files[i].replace(/.*\//g, "");
							style = "background-color: "+colorArray[folderNameCount];
							item = blank;
							item = item.replace(/{{title}}/g, shortName);
							item = item.replace(/{{id}}/g, id);
							if(groupByColorEnabled === true)
							{
								item = item.replace(/{{style}}/g, style);
							}
							menu.append(item);
						}
						
						if(logs[id] !== lastLogs[id]) 
						{
							updated = true;
							if(id === currentPage)
							{
								$("#log").html(makePretty(logs[id]));
							}
							else if(!fresh && !$("#menu a." + id + "Button").hasClass("updated"))
							{
								$("#menu a." + id + "Button").addClass("updated");
							}
						}
						
						if(initialized && updated && $(window).filter(":focus").length === 0) 
						{
							if(flashTitleUpdateLog)
							{
								flashTitle();
							}
						}
					}
					else
					{
						removeLogByName(name);
					}
				}
			}
		}
		resize();
		
		if($("#menu .active").length === 0)
		{
			$("#menu a:eq(0)").click();
		}
		
		if(logs[currentPage] !== lastLogs[currentPage]) {
			lastLogs[currentPage] = logs[currentPage];
			document.getElementById("main").scrollTop = $("#log").outerHeight();
		}
		
		var ids = Object.keys(logs);
		for(i = 0; i !== stop; ++i) {
			id = ids[i];
			lastLogs[id] = logs[id];
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
		$(e).addClass("active").removeClass("updated");
		$("#log").html(makePretty(logs[id]));
		currentPage = id;
		$("#title").html(titles[id]);
		document.getElementById("main").scrollTop = $("#log").outerHeight();
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
		text = text.join("</div><div>");
		
		return "<div>" + text + "</div>";
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
	    var targetHeight = window.innerHeight - $("#menu").outerHeight() - $("#title").outerHeight();
		if(enablePollTimeLogging !== "false")
		{
			targetHeight -= 25;
		}
		if($("#main").outerHeight() !== targetHeight)
		{
			$("#main").outerHeight(targetHeight);
		}
		if($("#main").css("bottom") !== $("#title").outerHeight() + "px")
		{
			$("#main").css("bottom", $("#title").outerHeight() + "px");
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
	pollTimer = setInterval(poll, pollingRate);
}

function clearPollTimer()
{
	clearInterval(pollTimer);
	pollTimer = null;
}

function startPauseOnNotFocus()
{
	startedPauseOnNonFocus = true;
	Visibility.every(100, 1000, function () { checkIfPageHidden(); });
}

function checkIfPageHidden()
{
	if(isPageHidden())
	{
		//hidden
		if(!pausePoll)
		{
			pausePollFunction();
		}
	}
	else
	{
		//not hidden
		if(!userPaused && pausePoll)
		{
			pausePoll = false;
			document.getElementById("pauseImage").src="core/img/Pause.png";
			stopFlashTitle();
			if(pollTimer == null)
			{
				poll();
				startPollTimer();
			}
		}
		if(userPaused)
		{
			document.title = "Log Hog | Paused";
		}
	}
}

function pausePollFunction()
{
	pausePoll = true;
	document.getElementById("pauseImage").src="core/img/Play.png";
	document.title = "Log Hog | Paused";
	if(pollTimer != null)
	{
		clearPollTimer();
	}
}

function isPageHidden(){
     return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
}

function clearLog()
{
	try
	{
	    var urlForSend = "core/php/clearLog.php?format=json";
		var title = filterTitle(document.getElementById("title").innerHTML);
		var data = {file: title};
		$.ajax({
				url: urlForSend,
				dataType: "json",
				data: data,
				type: "POST",
		success: function(data){
		  },
		});
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
    	var urlForSend = "core/php/clearAllLogs.php?format=json";
	var data = "";
	$.ajax({
			  url: urlForSend,
			  dataType: "json",
			  data: data,
			  type: "POST",
	success: function(data){
	  },
	});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function deleteLogPopup()
{
	try
	{
    	if(popupSettingsArray.deleteLog == "true")
		{
			showPopup();
			var title = filterTitle(document.getElementById("title").innerHTML);
			document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Are you sure you want to delete this log?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+title+"</div><div><div class='link' onclick='deleteLog();hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
		}
		else
		{
			deleteLog();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function deleteLog()
{
	try
	{
    	var urlForSend = 'core/php/deleteLog.php?format=json';
		var title = filterTitle(document.getElementById("title").innerHTML);
		title = title.replace(/\s/g, '');
		var data = {file: title};
		name = title;
		$.ajax({
				  url: urlForSend,
				  dataType: "json",
				  data: data,
				  type: "POST",
		success(data)
		{
		    var idOfDeletedLog = data.replace(/[^a-z0-9]/g, "");
			if($("#menu ." + idOfDeletedLog + "Button").length !== 0)
			{
				$("#menu ." + idOfDeletedLog + "Button").remove();
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
    	if(title.substring(0, title.indexOf("|")) != null && title.substring(0, title.indexOf("|")) != "")
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
		var urlForSend = '../core/php/resetUpdateFilesToDefault.php?format=json'
		var data = {status: "" };
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data: data,
			type: "POST",
			complete: function(data)
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
	    var urlForSend = '../update/updateActionCheck.php?format=json'
		var data = {status: "" };
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data: data,
			type: "POST",
			success(data)
			{
				if(data == 'finishedUpdate')
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
				checkForUpdateDefinitely();
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkForUpdateDefinitely(showPopupForNoUpdate = false)
{
	try
	{
    	if(!updating)
		{
			updating = true;
			if(showPopupForNoUpdate)
			{
				displayLoadingPopup("./core/img/");
			}
			$.getJSON('core/php/settingsCheckForUpdateAjax.php', {}, function(data) 
			{
				if((data.version == "1" && updateNoticeMeter == "every")|| data.version == "2" | data.version == "3")
				{
					//Update needed
					if(dontNotifyVersion != data.versionNumber)
					{

						if(popupSettingsArray.versionCheck != "false")
						{
							dataFromUpdateCheck = data;
							timeoutVar = setInterval(function(){updateUpdateCheckWaitTimer();},3000);
						}
						else
						{
							location.reload();
						}
					}
				}
				else if (data.version == "0")
				{
					if(showPopupForNoUpdate)
					{
						showPopup();
						document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >No Update Needed</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>You are on the most current version</div><div class='link' onclick='hidePopup();' style='margin-left:165px; margin-right:50px;margin-top:25px;'>Okay!</div></div>";
					}
				}
				else
				{
					//error?
					showPopup();
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error when checking for update</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An error occured while trying to check for updates. Make sure you are connected to the internet and settingsCheckForUpdate.php has sufficient rights to write / create files. </div><div class='link' onclick='hidePopup();' style='margin-left:165px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
				}
				
			});
			updating = false;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function updateUpdateCheckWaitTimer()
{
	try
	{
		$.getJSON("core/php/configStaticCheck.php", {}, function(data) 
		{
			if(currentVersion != data)
			{
				clearInterval(timeoutVar);
				showPopupForUpdate(dataFromUpdateCheck);
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showUpdateCheckPopup(data)
{
	try
	{
		showPopup();
		var textForInnerHTML = "<div class='settingsHeader' >New Version Available!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Version "+escapeHTML(data.versionNumber)+" is now available!</div><div class='link' onclick='installUpdates();' style='margin-left:74px; margin-right:50px;margin-top:25px;'>Update Now</div><div onclick='saveSettingFromPopupNoCheckMaybe();' class='link'>Maybe Later</div><br><div style='width:100%; padding-left:45px; padding-top:5px;'><input id='dontShowPopuForThisUpdateAgain'";
		if(dontNotifyVersion == data.versionNumber)
		{
			textForInnerHTML += " checked "
		}
		dontNotifyVersion = data.versionNumber;
		textForInnerHTML += "type='checkbox'>Don't notify me about this update again</div></div>";
		document.getElementById("popupContentInnerHTMLDiv").innerHTML = textForInnerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function saveSettingFromPopupNoCheckMaybe()
{
	try
	{
    	if(document.getElementById("dontShowPopuForThisUpdateAgain").checked)
		{
			var urlForSend = "core/php/settingsSaveAjax.php?format=json";
			var data = {dontNotifyVersion: dontNotifyVersion };
			$.ajax({
					  url: urlForSend,
					  dataType: "json",
					  data: data,
					  type: "POST",
			complete: function(data){
				hidePopup();
	  	},
			});
		}
		else
		{
		hidePopup();
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function updateProgressBar(additonalPercent, text)
{
	try
	{
		percent = percent + additonalPercent;
		document.getElementById('progressBar').value = percent;
		$('#progressBarSubInfo').empty();
		$('#progressBarSubInfo').append(text);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

$(document).ready(function()
{
	resize();
	updateProgressBar(10, "Generating Filelist Object");
	window.onresize = resize;
	window.onfocus = focus;

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

});
var title = $('title').text();
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
var counterForPoll = 0;
var arrayOfData1 = null;
var arrayOfData2 = null;
var arrayToUpdate = [];
var arrayOfDataMain = null;

function poll() {

	if(!startedPauseOnNonFocus)
	{
		startPauseOnNotFocus();
	}

	checkForUpdateMaybe();
	pollTwo();
	
}

function pollTwo()
{
	if(!pausePoll)
	{
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
			polling = true;
			t0 = performance.now();
			$.getJSON('core/php/pollCheck.php', {}, function(data) {
				pollTwoPartTwo(data);
			});
		}
	}
}

function pollTwoPartTwo(data)
{
	t2 = performance.now();
	if(arrayOfData1 == null)
	{
		arrayOfData1 = data;
		var filesNew = Object.keys(arrayOfData1);
		for (var i = filesNew.length - 1; i >= 0; i--)
		{
			arrayToUpdate.push(filesNew[i]);
		}
	}
	else
	{
		var arrayOfData2 = data; 
		var filesNew = Object.keys(arrayOfData2);
		var filesOld = Object.keys(arrayOfData1);

		arrayToUpdate = [];

		for (var i = filesNew.length - 1; i >= 0; i--)
		{
			if(filesOld.indexOf(filesNew[i]) > -1)
			{
				//file exists
				if(arrayOfData2[filesNew[i]] != arrayOfData1[filesNew[i]])
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

function pollThree(arrayToUpdate)
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
	if (typeof arrayToUpdate !== 'undefined' && arrayToUpdate.length > 0) 
	{
		var urlForSend = 'core/php/poll.php?format=json'
		var data = {arrayToUpdate: arrayToUpdate};
		$.ajax({
			url: urlForSend,
			dataType: 'json',
			data: data,
			type: 'POST',
			success: function(data)
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
			complete: function()
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

function afterPollFunctionComplete()
{
	polling = false;
	if(enablePollTimeLogging != "false")
	{
		t1 = performance.now();
		document.getElementById("loggingTimerPollRate").innerText = "Ajax refresh took    "+(Math.round(t2 - t0))+":"+(Math.round(t1 - t2))+"     " + (Math.round(t1 - t0)) + "/" + pollingRate +"("+(parseInt(pollingRate)*counterForPoll)+")"+" milliseconds.";
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

function pausePollAction()
{
	if(pausePoll)
	{
		userPaused = false;
		pausePoll = false;
		document.getElementById('pauseImage').src="core/img/Pause.png";
	}
	else
	{
		userPaused = true;
		pausePollFunction();
	}
}

function refreshAction()
{
	clearTimeout(refreshActionVar);
	document.getElementById('refreshImage').src="core/img/refresh-animated.gif";
	refreshing = true;
	if(pausePoll)
	{
		clearTimeout(refreshPauseActionVar);
		pausePoll = false;
		poll();
		refreshPauseActionVar = setTimeout(function(){pausePoll = true;}, 1000);
	}
	else
	{
		poll();
	}
	refreshActionVar = setTimeout(function(){endRefreshAction()}, 1500);
}

function endRefreshAction()
{
	document.getElementById('refreshImage').src="core/img/Refresh.png"; 
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

function update(data) {
	//console.log(data);
	var menu = $('#menu');
	var blank = $('#storage .menuItem').html();
	var i, id, name, shortName, item, style, folderName;
	var files = Object.keys(data);
	var stop = files.length;
	var updated = false;
	var initialized = $('#menu a').length != 0;
	var colorArray = currentFolderColorThemeArrayOfColors;
	var colorArrayLength = colorArray.length;
	var folderNamePrev = "?-1";
	var folderNameCount = -1;
	for(i = 0; i != stop; ++i) {
		if(files[i].indexOf("dataForLoggingLogHog051620170928") == -1)
		{
			var dataForCheck = data[files[i]];
			if(dataForCheck == "This file is empty. This should not be displayed." && hideEmptyLog == "true")
			{
				name = files[i];
				id = name.replace(/[^a-z0-9]/g, '');
				if($('#menu .' + id + 'Button').length != 0)
				{
					$('#menu .' + id + 'Button').remove();
				} 
			}
			else
			{
				name = files[i];
				if(data[name] != null)
				{
					folderName = name.substr(0, name.lastIndexOf("/"));
					if(folderName !== folderNamePrev || i == 0 || groupByType == 'file')
					{
						folderNameCount++;
						folderNamePrev = folderName;
						if(folderNameCount >= colorArrayLength)
						{
							folderNameCount = 0;
						}
					}
					id = name.replace(/[^a-z0-9]/g, '');
					if(data[name] == "")
					{
						data[name] = "<div class='errorMessageLog errorMessageRedBG' >Error - Unknown error? Check file permissions or clear log to fix?</div>";
					}
					else if(data[name] == "This file is empty. This should not be displayed.")
					{
						data[name] = "<div class='errorMessageLog errorMessageGreenBG' > This file is empty. </div>";
					}
					else if(data[name] == "Error - Maybe insufficient access to read file?")
					{
						data[name] = "<div class='errorMessageLog errorMessageRedBG' > Error - Maybe insufficient access to read file? <br> <span style='font-size:75%;'> Try entering: <br> chown -R www-data:www-data "+name+" <br> or <br> chmod 664 "+name+" </span> </div>";
					}
					logs[id] = data[name];
					if(enableLogging != "false")
					{
						titles[id] = name + " | " + data[name+"dataForLoggingLogHog051620170928"];
					}
					else
					{
						titles[id] = name;
					}
					
					if(enableLogging != "false")
					{
						if(id == currentPage)
						{
							$('#title').html(titles[id]);
						}
					}

					if($('#menu .' + id + 'Button').length == 0) 
					{
						shortName = files[i].replace(/.*\//g, '');
						style = "background-color: "+colorArray[folderNameCount];
						item = blank;
						item = item.replace(/{{title}}/g, shortName);
						item = item.replace(/{{id}}/g, id);
						if(groupByColorEnabled == true)
						{
							item = item.replace(/{{style}}/g, style);
						}
						menu.append(item);
					}
					
					if(logs[id] != lastLogs[id]) 
					{
						updated = true;
						if(id == currentPage)
							$('#log').html(makePretty(logs[id]));
						else if(!fresh && !$('#menu a.' + id + 'Button').hasClass('updated'))
							$('#menu a.' + id + 'Button').addClass('updated');
					}
					
					if(initialized && updated && $(window).filter(':focus').length == 0) 
					{
						if(flashTitleUpdateLog)
						{
							flashTitle();
						}
					}
				}
				else
				{
					id = name.replace(/[^a-z0-9]/g, '');
					if($('#menu .' + id + 'Button').length != 0)
					{
						$('#menu .' + id + 'Button').remove();
					}
				}
			}
		}
	}
	resize();
	
	if($('#menu .active').length == 0)
		$('#menu a:eq(0)').click();
	
	if(logs[currentPage] != lastLogs[currentPage]) {
		lastLogs[currentPage] = logs[currentPage];
		document.getElementById('main').scrollTop = $('#log').outerHeight();
	}
	
	var ids = Object.keys(logs);
	for(i = 0; i != stop; ++i) {
		id = ids[i];
		lastLogs[id] = logs[id];
	}
}

function show(e, id) {
	$(e).siblings().removeClass('active');
	$(e).addClass('active').removeClass('updated');
	$('#log').html(makePretty(logs[id]));
	currentPage = id;
	$('#title').html(titles[id]);
	document.getElementById('main').scrollTop = $('#log').outerHeight();
}

function makePretty(text) {
	text = text.split("\n");
	text = text.join('</div><div>');
	
	return '<div>' + text + '</div>';
}

function resize() {
	var targetHeight = window.innerHeight - $('#menu').outerHeight() - $('#title').outerHeight();
	if(enablePollTimeLogging != "false")
	{
		targetHeight -= 25;
	}
	if($('#main').outerHeight() != targetHeight)
		$('#main').outerHeight(targetHeight);
	if($('#main').css('bottom') != $('#title').outerHeight() + 'px')
		$('#main').css('bottom', $('#title').outerHeight() + 'px');
}

function flashTitle() {
	stopFlashTitle();
	$('title').text('');
	flasher = setInterval(function() {
		$('title').text($('title').text() == '' ? title : '');
	}, 1000);
}

function stopFlashTitle() {
	clearInterval(flasher);
	$('title').text(title);
}

function focus() {
	stopFlashTitle();
}



poll();
setInterval(poll, pollingRate);
resize();

window.onresize = resize;
window.onfocus = focus;

if(pausePollFromFile)
{
	pausePoll = true;
	document.getElementById('pauseImage').src="core/img/Play.png";
}

if(pausePollOnNotFocus && !pausePollFromFile)
{
	startPauseOnNotFocus();
}

function startPauseOnNotFocus()
{
	startedPauseOnNonFocus = true;
	Visibility.every(250, 1000, function () { checkIfPageHidden(); });
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
			document.getElementById('pauseImage').src="core/img/Pause.png";
			stopFlashTitle();
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
	document.getElementById('pauseImage').src="core/img/Play.png";
	document.title = "Log Hog | Paused";
}

function isPageHidden(){
     return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
}

function clearLog()
{
	var urlForSend = 'core/php/clearLog.php?format=json';
	var title = document.getElementById("title").innerHTML;
	if(title.substring(0, title.indexOf("|")) != null && title.substring(0, title.indexOf("|")) != "")
	{
		title = title.substring(0, title.indexOf("|"));
	}
	var data = {file: title};
	$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
	success: function(data){
    // we make a successful JSONP call!
  },
});
}


function deleteAction()
{
	var urlForSend = 'core/php/clearAllLogs.php?format=json'
	var data = "";
	$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
	success: function(data){
    // we make a successful JSONP call!
  },
});
}

function deleteLogPopup()
{
	if(popupSettingsArray.deleteLog == "true")
	{
		showPopup();
		var title = document.getElementById("title").innerHTML;
		if(title.substring(0, title.indexOf("|")) != null && title.substring(0, title.indexOf("|")) != "")
		{
			title = title.substring(0, title.indexOf("|"));
		}
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Are you sure you want to delete this log?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+title+"</div><div><div class='link' onclick='deleteLog();hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
	}
	else
	{
		deleteLog();
	}
}

function deleteLog()
{
	var urlForSend = 'core/php/deleteLog.php?format=json';
	var title = document.getElementById("title").innerHTML;
	if(title.substring(0, title.indexOf("|")) != null && title.substring(0, title.indexOf("|")) != "")
	{
		title = title.substring(0, title.indexOf("|"));
	}
	title = title.replace(/\s/g, '');
	var data = {file: title};
	name = title;
	$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
	success: function(data){
    // we make a successful JSONP call!
    id = data.replace(/[^a-z0-9]/g, '');
	if($('#menu .' + id + 'Button').length != 0)
	{
		$('#menu .' + id + 'Button').remove();
	}
  },
  	complete: function(data){
  	},
});
}

function installUpdates()
{
	$("#settingsInstallUpdate").submit();
}

$(document).ready(function()
{
	checkForUpdateMaybe();
});

function checkForUpdateMaybe()
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

function checkForUpdateDefinitely(showPopupForNoUpdate = false)
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
						showPopup();
						var textForInnerHTML = "<div class='settingsHeader' >New Version Available!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Version "+data.versionNumber+" is now available!</div><div class='link' onclick='installUpdates();' style='margin-left:74px; margin-right:50px;margin-top:25px;'>Update Now</div><div onclick='saveSettingFromPopupNoCheckMaybe();' class='link'>Maybe Later</div><br><div style='width:100%; padding-left:45px; padding-top:5px;'><input id='dontShowPopuForThisUpdateAgain'";
						if(dontNotifyVersion == data.versionNumber)
						{
							textForInnerHTML += " checked "
						}
						dontNotifyVersion = data.versionNumber;
						textForInnerHTML += "type='checkbox'>Don't notify me about this update again</div></div>";
						document.getElementById('popupContentInnerHTMLDiv').innerHTML = textForInnerHTML;
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
					hidePopup();
					showPopup();
					document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >No Update Needed</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>You are on the most current version</div><div class='link' onclick='hidePopup();' style='margin-left:165px; margin-right:50px;margin-top:25px;'>Okay!</div></div>";
				}
			}
			else
			{
				//error?
				showPopup();
				document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Error when checking for update</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>An error occured while trying to check for updates. Make sure you are connected to the internet and settingsCheckForUpdate.php has sufficient rights to write / create files. </div><div class='link' onclick='hidePopup();' style='margin-left:165px; margin-right:50px;margin-top:5px;'>Okay!</div></div>";
			}
			
		});
		updating = false;
	}
}

function saveSettingFromPopupNoCheckMaybe()
{
	if(document.getElementById('dontShowPopuForThisUpdateAgain').checked)
	{
		var urlForSend = 'core/php/settingsSaveAjax.php?format=json'
		var data = {dontNotifyVersion: dontNotifyVersion };
		$.ajax({
				  url: urlForSend,
				  dataType: 'json',
				  data: data,
				  type: 'POST',
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
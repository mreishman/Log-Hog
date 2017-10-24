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
var firstLoad = true;
var timer;

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

function resize() 
{
	try
	{
	    var targetHeight = window.innerHeight - $("#menu").outerHeight();
		if($("#main").outerHeight() !== targetHeight)
		{
			$("#main").outerHeight(targetHeight);
		}
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
				displayLoadingPopup(baseUrl+"img/");
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

function scanDir(arrayOfFolders, idOfScan, scanFor, arrayOfFiles = [], total = 1, count = 0)
{
	if(arrayOfFolders.constructor !== Array)
	{
		document.getElementById("newSearch").style.display = "none";
		var item = $("#storage .container").html();
		item = item.replace(/{{id}}/g, idOfScan);
		item = item.replace(/{{folder}}/g, arrayOfFolders);
		item = item.replace(/{{search}}/g, scanFor);
		$("#main").append(item);
		arrayOfFolders = [arrayOfFolders];
	}
	try
	{
		//send number of folders, max 3;
		var lengthOfFolders = arrayOfFolders.length;
		if(lengthOfFolders > 5)
		{
			lengthOfFolders = 5;
		}
		var arrayToSend = new Array();
		for (var i = 0; i < lengthOfFolders; i++)
		{
			arrayToSend.push(arrayOfFolders[i]); 
		}
		var urlForSend = "core/php/getDirInfo.php?format=json";
		var data = {arrayOfFolders, idOfScan, scanFor, arrayOfFiles, total, count,lengthOfFolders};
		(function(_data){
			$.ajax({
				url: urlForSend,
				dataType: "json",
				data: {dir: arrayToSend},
				type: "POST",
				success(data)
				{
					parseDirectoryData(_data, data);
				}
			});	
		}(data));
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function parseDirectoryData(_data, data)
{
	if(document.getElementById(_data['idOfScan']+'Progress'))
	{
		for (var i = _data['lengthOfFolders']; i > 0; i--)
		{
			_data['count']++;
		}
		_data['total'] += data['folders'].length;
		var currentPercent = ((100*(_data['count']/_data['total']))/2).toFixed(2);
		document.getElementById(_data['idOfScan']+'Progress').value = currentPercent/100;
		document.getElementById(_data['idOfScan']+'ProgressTxt').innerHTML = currentPercent;
		_data['arrayOfFolders'] = _data['arrayOfFolders'].concat(data['folders']);
		_data['arrayOfFiles'] = _data['arrayOfFiles'].concat(data['files']);
		for (var i = _data['lengthOfFolders']; i > 0; i--)
		{
			_data['arrayOfFolders'].shift();
		}
		if(_data['arrayOfFolders'].length > 0)
		{
			scanDir(_data['arrayOfFolders'], _data['idOfScan'], _data['scanFor'], _data['arrayOfFiles'], _data['total'], _data['count']);
		}
		else
		{
			_data['arrayOfFiles'].sort();
			loopThroughFiles(_data['scanFor'], "" ,_data['idOfScan'], -1, _data['arrayOfFiles']);
		}
	}
}

function loopThroughFiles(pattern, file, id, count = -1, arrayOfFiles)
{
	if(document.getElementById(id+'Progress'))
	{
		var total = arrayOfFiles.length;
		count++;
		var currentPercent = (((100*(count/total))/2)+50).toFixed(2);
		if(currentPercent === 100 && (((100*(count/total))/2)+50) !== 100)
		{
			currentPercent = 99.99;
		}
		document.getElementById(id+'Progress').value = currentPercent/100;
		document.getElementById(id+'ProgressTxt').innerHTML = currentPercent;
		if(count < arrayOfFiles.length)
		{
			phpGrep(pattern,arrayOfFiles[count],id, count, arrayOfFiles);
		}
		else
		{
			//finished

			//notification data
			var newNotification = new Array();
			newNotification["name"] = "Finished Scanning " + document.getElementById(id+"Folder").innerHTML;
			newNotification["action"] = "window.location.hash = '#"+id+"'";

			//send notification
			addNotification(newNotification);

			if(document.getElementById(id+"FoundThings").style.display === "none")
			{
				//nothing found in thing, display that fact
				var tableOutput = "<table style='width: 100%;'><tr><th><h1>No Results Found</h1></th></tr></table>";
				$("#"+id+"FoundThings").append(tableOutput);
				toggleMainExpand(id);
			}
			else
			{
				//un comment when save works
				//document.getElementById(id+"SaveSearch").style.display = "inline-block";
			}
		}
	}
}

function phpGrep(pattern, file, id, count, files)
{
	try
	{
		var urlForSend = "core/php/phpGrep.php?format=json";
		var objectSent = new Array();
		var data = {file, pattern, id, count, files};
		(function(_data){
			$.ajax({
				url: urlForSend,
				dataType: "json",
				data: {file, pattern, id, count},
				type: "POST",
				success(data)
				{
					styleReturnedData(data, _data);
					loopThroughFiles(_data['pattern'], _data['file'], _data['id'], _data['count'],  _data['files']);
				}
			});	
		}(data));
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function styleReturnedData(data, otherData)
{
	if(data.length !== 0)
	{
		var idToAttach = otherData['id']+"FoundThings";
		if(document.getElementById(idToAttach).style.display === "none")
		{
			toggleMainExpand(otherData['id']);
		}
		var dataKeys = Object.keys(data);
		for (var i = dataKeys.length - 1; i >= 0; i--) 
		{
			var tableOutput = "<table style='width: 100%; border-spacing: 0; border: 1px solid white;' ><tr><th colspan=\"2\" style='background-color: #333; line-height: 250%;'>"+dataKeys[i]+"("+data[dataKeys[i]]["data"].length+")</th></tr>";
			for (var j = 0; j < data[dataKeys[i]]["data"].length; j++)
			{

				for (var k = 0; k < data[dataKeys[i]]["data"][j].length; k++)
				{
					if( (data[dataKeys[i]]["positionArray"][j][0]+k) === (data[dataKeys[i]]["positionArray"][j][1]))
					{
						tableOutput += "<tr style='background-color: #7c7;'>";
					}
					else
					{
						tableOutput += "<tr>";
					}
					tableOutput += "<td style='text-align: right; background-color: #555; width: 100px; min-width: 100px;' >" + ((data[dataKeys[i]]["positionArray"][j][0])+k+1) + "</td><td style='white-space: pre-wrap;'>" + escapeHTML(data[dataKeys[i]]["data"][j][k]) + "</td></tr>";
				}
				if(j != (data[dataKeys[i]]["data"].length-1) && ((data[dataKeys[i]]["positionArray"][j][0]) + 1 + data[dataKeys[i]]["data"][j].length - 1) !== (data[dataKeys[i]]["positionArray"][j+1][0]))
				{
					tableOutput += "<td style='text-align: right; background-color: #555;' >...</td><td></td>";
				}
				
			}
			tableOutput += "</table>";
			$("#"+idToAttach).append(tableOutput);
		}
	}
}

function showGrepPopup()
{
	document.getElementById('newGrep').style.display = "block";
}

function hideNewGrep()
{
	document.getElementById('newGrep').style.display = "none";
}

function toggleMainExpand(idOfResults)
{
	if(document.getElementById(idOfResults+"FoundThings").style.display === "none")
	{
		document.getElementById(idOfResults+"Expand").style.display = "none";
		document.getElementById(idOfResults+"Loading").style.display = "inline-block";

		document.getElementById(idOfResults+"FoundThings").style.display = "block";

		document.getElementById(idOfResults+"Loading").style.display = "none";
		document.getElementById(idOfResults+"Contract").style.display = "inline-block";
	}
	else
	{
		document.getElementById(idOfResults+"Contract").style.display = "none";
		document.getElementById(idOfResults+"Loading").style.display = "inline-block";

		document.getElementById(idOfResults+"FoundThings").style.display = "none";

		document.getElementById(idOfResults+"Loading").style.display = "none";
		document.getElementById(idOfResults+"Expand").style.display = "inline-block";
	}
}

function scanDirCreate()
{
	hideNewGrep();
	var directoryInput = document.getElementById('directoryInput').value;
	var idForSearch = 'Search'+counter;
	var searchInput = document.getElementById('searchInput').value;
	scanDir(directoryInput, idForSearch, searchInput);
	counter++;
}

function deleteSearch(searchToRemove)
{
	$("#"+searchToRemove).remove();

	//check if no more searches, add back buttons
	if($(".containerMain").length === 2)
	{
		document.getElementById("newSearch").style.display = "block";
	}
}

function toggleNotifications()
{
	if(document.getElementById("notifications").style.display === "block")
	{
		document.getElementById("notifications").style.display = "none";
		document.getElementById("notificationNotClicked").style.display = "block";
		document.getElementById("notificationClicked").style.display = "none";
	}
	else
	{
		showNotifications();
		document.getElementById("notificationNotClicked").style.display = "none";
		document.getElementById("notificationClicked").style.display = "block";
		document.getElementById("notifications").style.display = "block";
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
		arrayInternalNotifications[0]["name"] = "No Notifications to Display";
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
	for (var i = notificationsArray.length - 1; i >= 0; i--)
	{
		var blank = $("#storage .notificationContainer").html();
		var item = blank;
		item = item.replace(/{{id}}/g, "notification"+notificationsArray[i]['id']);
		item = item.replace(/{{idNum}}/g, notificationsArray[i]['id']);
		item = item.replace(/{{name}}/g, notificationsArray[i]['name']);
		item = item.replace(/{{time}}/g, notificationsArray[i]['time']);
		item = item.replace(/{{action}}/g, notificationsArray[i]['action']);
		$("#notificationHolder").append(item);
	}
	$("#notificationHolder").append($("#storage .notificationButtons").html());
}

function removeAllNotifications()
{
	notifications = new Array();
	updateNotificationStuff();
}

function removeNotification(idToRemove)
{
	//remove from array
	var position = notifications.indexOf(idToRemove);
	notifications.splice(position, 1);
	updateNotificationStuff();
}

function updateNotificationCount()
{
	var currentCount = notifications.length;
	$("#notificationCount").empty();
	if(currentCount > 0)
	{
		if(currentCount < 10)
		{
			currentCount = "0" + currentCount;
		}
		document.getElementById("notificationIcon").style.display = "block";
		$("#notificationCount").append(currentCount);
	}
	else
	{
		document.getElementById("notificationIcon").style.display = "none";
	}
}

function addNotification(notificationArray)
{

	var currentId = notifications.length;

	notifications[currentId] = new Array();
	notifications[currentId]["id"] = currentId;
	notifications[currentId]["name"] = notificationArray["name"];
	notifications[currentId]["time"] = formatAMPM(new Date());
	notifications[currentId]["action"] = notificationArray["action"];

	updateNotificationStuff();
}

function updateNotificationStuff()
{
	updateNotificationCount();
	showNotifications();
}

$(document).ready(function()
{
	resize();
	window.onresize = resize;
	window.onfocus = focus;
	if (typeof addUpdateNotification == 'function')
	{
		addUpdateNotification();
	}
	updateNotificationCount();
	//checkForUpdateMaybe();
});
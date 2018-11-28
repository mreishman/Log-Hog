function toggleNotifications(force = false)
{
	if(document.getElementById("fullScreenMenu").style.display === "none")
	{
		toggleFullScreenMenu();
	}
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleFullScreenMenu(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideMainStuff();
	hideSidebar();
	if(notifications.length < 1)
	{
		document.getElementById("notificationsEmpty").style.display = "block";
		document.getElementById("notifications").style.display = "none";
	}
	else
	{
		showNotifications();
		document.getElementById("notifications").style.display = "block";
		document.getElementById("notificationsEmpty").style.display = "none";
		changeNotificationsToViewed();
		regroupNotifications();
	}
	$("#mainMenuNotifications").addClass("selected");
	arrayOfScrollHeaderUpdate = [];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resize();
}

function showNotifications()
{
	//code here later if needed
	displayNotifications();
}

function clearAllNotifications()
{
	$("#notificationHolder").empty();
}

function displayNotifications()
{
	clearAllNotifications();
	var htmlForNotifications = "<span style=\"display: block;\" >";
	var unreadNotifications = "";
	var readNotifications = "";
	for (var i = notifications.length - 1; i >= 0; i--)
	{
		var blank;
		var blankMod = "";
		if(window.innerWidth < breakPointTwo)
		{
			blankMod += "Small";
		}
		if("image" in notifications[i])
		{
			blankMod += "WithImage";
		}
		blank = $("#storage .notificationContainer"+blankMod).html();
		var item = blank;
		var viewIndicatorHtml = "<span class=\"led-green\" ></span>";
		if(notifications[i]["viewed"] === false)
		{
			viewIndicatorHtml = "<span class=\"led-yellow\" ></span>";
		}
		item = item.replace(/{{id}}/g, "notification"+notifications[i]['id']);
		item = item.replace(/{{idNum}}/g, i);
		item = item.replace(/{{viewIndicator}}/g, viewIndicatorHtml);
		item = item.replace(/{{name}}/g, notifications[i]['name']);
		item = item.replace(/{{time}}/g, notifications[i]['time']);
		item = item.replace(/{{action}}/g, notifications[i]['action']);
		if(notifications[i]["newText"] !== "" && notificationPreviewShow === "true")
		{
			var logTextToShow = "";
			var tmpLogText = notifications[i]['newText'].split("\n");
			var tmpLogTextLength = tmpLogText.length;
			var max = notificationPreviewLineCount;
			if(max > tmpLogTextLength)
			{
				max = tmpLogTextLength;
			}
			for(var tltc = 0; tltc < max; tltc++)
			{
				logTextToShow += "\n"+tmpLogText[tltc];
			}
			item = item.replace(/{{previewText}}/g, "<div style=\"max-height: "+notificationPreviewHeight+"px;\" class=\"notificationPreviewLog\" ><table width=\"100%\" style=\"border-spacing: 0;\" >" + makePrettyWithText(logTextToShow, 0) + "</table></div>");
		}
		else
		{
			item = item.replace(/{{previewText}}/g, "");
		}
		if("image" in notifications[i])
		{
			item = item.replace(/{{image}}/g, notifications[i]['image']);
		}
		if(notifications[i]["viewed"] === false)
		{
			unreadNotifications += item;
		}
		else
		{
			readNotifications += item;
		}
	}
	if(unreadNotifications !== "")
	{
		htmlForNotifications += "<div style=\"filter: invert(100%);\" class=\"menuTitle fullScreenNotificationTitle\" >Unread</div>" + unreadNotifications;
	}
	if(readNotifications !== "")
	{
		htmlForNotifications += "<div style=\"filter: invert(100%);\" class=\"menuTitle fullScreenNotificationTitle\" >Read</div>" + readNotifications;
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

function changeNotificationsToViewed()
{
	for (var i = notifications.length - 1; i >= 0; i--)
	{
		if(notifications[i]["viewed"] !== true)
		{
			notifications[i]["viewed"] = true;
		}
	}
}

function regroupNotifications()
{
	for (var i = notifications.length - 1; i >= 0; i--)
	{
		if(notifications[i] !== null && "log" in notifications[i])
		{
			for (var j = i - 1; j >= 0; j--)
			{
				if(notifications[j] !== null && "log" in notifications[j])
				{
					if(notifications[i]["log"] === notifications[j]["log"] )
					{
						if(notifications[j]["viewed"] === true && notifications[i]["viewed"] === true && notificationGroupType === "OnlyRead")
						{
							//merge j into i
							notifications[i]["newText"] += "\n"+notifications[j]["newText"];
							notifications[j] = null;
							break;
						}
					}
				}
			}
		}
	}
	notifications = notifications.filter(function(e){return e});
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
	var currentCount = getNotificationCount();
	if(currentCount > 0)
	{
		if(currentCount < 10)
		{
			currentCount = "0" + currentCount;
		}
		if(document.getElementById("notificationBadge").innerHTML == currentCount)
		{
			return;
		}
		$("#notificationBadge").empty();
		document.getElementById("notificationIcon").style.display = "block";
		$("#notificationBadge").append(currentCount);
		$("#mainMenuNotificationsText").html("Notifications ("+currentCount+")");
		resizeNotificationCounter();
	}
	else
	{
		if($("#notificationBadge").html() !== "")
		{
			$("#notificationBadge").empty();
			$("#mainMenuNotificationsText").html("Notifications");
			document.getElementById("notificationIcon").style.display = "none";
		}
	}
}

function getNotificationCount()
{
	if(notificationCountViewedOnly === "false")
	{
		return notifications.length;
	}
	newCount = 0;
	for (var i = notifications.length - 1; i >= 0; i--)
	{
		if(notifications[i]["viewed"] !== true)
		{
			newCount++;
		}
	}
	return newCount;
}

function resizeNotificationCounter()
{
	var boundingRectForNotificationDiv = document.getElementById("mainMenuDiv").getBoundingClientRect();
	if(document.getElementById("notificationBadge").style.left !== (boundingRectForNotificationDiv.left+11) + "px")
	{
		document.getElementById("notificationBadge").style.left = (boundingRectForNotificationDiv.left+11) + "px";
	}
	if(document.getElementById("notificationBadge").style.top !== (boundingRectForNotificationDiv.top+17) + "px")
	{
		document.getElementById("notificationBadge").style.top = (boundingRectForNotificationDiv.top+17) + "px";
	}
}
//added to view notificatin action
function closeNotificationsAndMainMenu()
{
	toggleNotifications();
	toggleFullScreenMenu();
}

function addLogNotification(notificationArray)
{
	if(notificationGroupType !== "Never")
	{
		//check if log notification is already displayed. If so, get ID of that for current ID
		for (var i = notifications.length - 1; i >= 0; i--)
		{
			if("log" in notifications[i])
			{
				if(notifications[i]["log"] === notificationArray["log"])
				{
					if((notifications[i]["viewed"] === false && notificationGroupType === "OnlyRead") ||  notificationGroupType === "Always")
					{
						notificationArray["currentId"] = i;
						if(notificationPreviewOnlyNew === "false")
						{
							notificationArray["newText"] += notifications[i]["newText"]+"\n"+notificationArray["newText"];
						}
						break;
					}
				}
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
	notifications[currentId]["viewed"] = false;
	notifications[currentId]["newText"] = "";
	if("newText" in notificationArray)
	{
		notifications[currentId]["newText"] = notificationArray["newText"];
	}
	if("log" in notificationArray)
	{
		notifications[currentId]["log"] = notificationArray["log"];
	}
	if(notificationInlineShow === "true")
	{
		inlineNotificationAdd(notifications[currentId]);
	}

	updateNotificationStuff();
}

function inlineNotificationAdd(notificationArray)
{
	inlineNotificationPollArray.push(notificationArray);
}

function tryToStartNotificationInlinePoll()
{
	if(
		inlineNotificationPoll === null &&
		document.getElementById("fullScreenMenu").style.display === "none" &&
		inlineNotificationPollArray.length > 0)
	{
		//start poll
		inlineNotificationPollLogic();
		inlineNotificationPoll = setInterval(inlineNotificationPollLogic, (notificationInlineDisplayTime * 1000));
	}
}

function inlineNotificationPollLogic(force = false)
{
	if($("#inlineNotifications:hover").length != 0 && !force)
	{
	    return;
	}
	var currentLength = inlineNotificationPollArray.length;
	if(currentLength > 0)
	{
		var currentThing = inlineNotificationPollArray[0];
		inlineNotificationPollArray.shift();
		//show notification
		var blank;
		if("image" in currentThing)
		{
			blank = $("#storage .notificationContainerInlineWithImage").html();
		}
		else
		{
			blank = $("#storage .notificationContainerInline").html();
		}
		var item = blank;
		item = item.replace(/{{name}}/g, currentThing['name']);
		item = item.replace(/{{time}}/g, currentThing['time']);
		item = item.replace(/{{action}}/g, currentThing['action']);
		if("image" in currentThing)
		{
			item = item.replace(/{{image}}/g, currentThing['image']);
		}
		$("#inlineNotifications").html(item);
		document.getElementById("inlineNotifications").style.display = "block";
		if(notificationInlineButtonHover === "true")
		{
			$( "#inlineNotifications" ).hover(
			  function() {
			    $( ".notificationContainerInlineButtons" ).css( "display" , "block" );
			  }, function() {
			    $( ".notificationContainerInlineButtons" ).css( "display" , "none" );
			  }
			);
		}
		else
		{
			$( ".notificationContainerInlineButtons" ).css( "display" , "block" );
		}
	}
	else
	{
		document.getElementById("inlineNotifications").style.display = "none";
		//stop poll
		clearInterval(inlineNotificationPoll);
		inlineNotificationPoll = null;
	}
}

function updateNotificationStuff()
{
	updateNotificationCount();
	if(document.getElementById("fullScreenMenu").style.display !== "none" && ($("#mainMenuNotifications") && $("#mainMenuNotifications").hasClass("selected")))
	{
		if(notifications.length < 1)
		{
			document.getElementById("notificationsEmpty").style.display = "block";
			document.getElementById("notifications").style.display = "none";
		}
		else
		{
			showNotifications();
			document.getElementById("notifications").style.display = "block";
			document.getElementById("notificationsEmpty").style.display = "none";
		}
	}
	checkForUpdateLogsOffScreen();
}
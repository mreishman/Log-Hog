function show(e, id)
{
	try
	{
		var formattedHtml = "";
		var internalID = id;
		var currentCurrentSelectWindow = currentSelectWindow;
		closeLogPopup();
		if(logDisplayArray[currentSelectWindow]["id"] === id)
		{
			var localCheckHtml = $("#log"+currentSelectWindow).html();
			localCheckHtml = localCheckHtml.replace(/<tbody>/g,"");
			localCheckHtml = localCheckHtml.replace(/<\/tbody>/g,"");
			formattedHtml = showPartGetFormattedHtml(internalID);
			if(unescapeHTML(localCheckHtml) === unescapeHTML(formattedHtml))
			{
				return;
			}
		}
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
			showPartTwo(e, internalID, currentCurrentSelectWindow, formattedHtml);
		}, 2);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showPartGetFormattedHtml(internalID)
{
	if(typeof logs[internalID] === "object" && "id" in logs[internalID] && logs[internalID]["id"] === "oneLog")
	{
		return makeOneLogPretty();
	}

	if(logs[internalID].indexOf("errorMessageLog errorMessageRedBG") > -1 || logs[internalID].indexOf("errorMessageLog errorMessageGreenBG") > -1)
	{
		return logs[internalID];
	}

	return makePretty(internalID);
}

function showPartTwo(e, internalID, currentCurrentSelectWindow, formattedHtml)
{
	try
	{
		if(formattedHtml === "")
		{
			formattedHtml = showPartGetFormattedHtml(internalID);
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
		toggleSideBarElements(internalID, currentCurrentSelectWindow);
		$("#log"+currentCurrentSelectWindow+"load").hide();
		$("#log"+currentCurrentSelectWindow).show();
		if(document.getElementById("noLogToDisplay").style.display !== "none")
		{
			document.getElementById("noLogToDisplay").style.display = "none";
			document.getElementById("log").style.display = "block";
		}
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
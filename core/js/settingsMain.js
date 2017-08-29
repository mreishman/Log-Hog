function showOrHideLogTrimSubWindow()
{
	try
	{
		var valueToSeeIfShowOrHideSubWindowLogTrim = document.getElementById("logTrimOn").value;

		if(valueToSeeIfShowOrHideSubWindowLogTrim === "true")
		{
			document.getElementById("settingsLogTrimVars").style.display = "block";
		}
		else
		{
			document.getElementById("settingsLogTrimVars").style.display = "none";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


function changeDescriptionLineSize()
{
	try
	{
		var valueForDesc = document.getElementById("logTrimTypeToggle").value;

		if (valueForDesc === "lines")
		{
			document.getElementById("logTrimTypeText").innerHTML = "Lines";
			document.getElementById("LiForlogTrimSize").style.display = "none";
		}
		else if (valueForDesc === "size")
		{
			document.getElementById("logTrimTypeText").innerHTML = "Size";
			document.getElementById("LiForlogTrimSize").style.display = "block";
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function addRowFunction()
{
	try
	{
		countOfWatchList++;
		countOfClicks++;
		if(countOfWatchList < 10)
		{
			document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #0" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link'  onclick='deleteRowFunctionPopup("+ countOfWatchList +", true, \"File #0" + countOfWatchList+"\")'>Remove</a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
		}
		else
		{
			document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link' onclick='deleteRowFunctionPopup("+ countOfWatchList +", true, \"File #" + countOfWatchList+"\")'>Remove</a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
		}
		locationInsert = "newRowLocationForWatchList"+countOfClicks;
		document.getElementById("numberOfRows").value = countOfWatchList;
		countOfAddedFiles++;
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function deleteRowFunctionPopup(currentRow, decreaseCountWatchListNum, keyName = "")
{
	try
	{
		if(popupSettingsArray.removeFolder === "true")
		{
			showPopup();
			document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Are you sure you want to remove this file/folder?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+keyName+"</div><div><div class='link' onclick='deleteRowFunction("+currentRow+","+ decreaseCountWatchListNum+");hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
		}
		else
		{
			deleteRowFunction(currentRow, decreaseCountWatchListNum);
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}	
}

function deleteRowFunction(currentRow, decreaseCountWatchListNum)
{
	try
	{
		var elementToFind = "rowNumber" + currentRow;
		document.getElementById(elementToFind).outerHTML = "";
		if(decreaseCountWatchListNum)
		{
			var newValue = document.getElementById("numberOfRows").value;
			if(currentRow < newValue)
			{
				//this wasn't the last folder deleted, update others
				for(var i = currentRow + 1; i <= newValue; i++)
				{
					var updateItoIMinusOne = i - 1;
					var elementToUpdate = "rowNumber" + i;
					var documentUpdateText = "<li id='rowNumber"+updateItoIMinusOne+"' >File #";
					var watchListKeyIdFind = "watchListKey"+i;
					var watchListItemIdFind = "watchListItem"+i;
					var previousElementNumIdentifierForKey  = document.getElementsByName(watchListKeyIdFind);
					var previousElementNumIdentifierForItem  = document.getElementsByName(watchListItemIdFind);
					if(updateItoIMinusOne < 10)
					{
						documentUpdateText += "0";
					}
					documentUpdateText += updateItoIMinusOne+": ";
					var nameForId = "fileNotFoundImage" + i;
					var elementByIdPreCheck = document.getElementById(nameForId);
					if(elementByIdPreCheck !== null)
					{
						documentUpdateText += "<img id='fileNotFoundImage"+updateItoIMinusOne+"' src='../core/img/redWarning.png' height='10px'>";
					}
					documentUpdateText += "<input style='width: ";
					if(elementByIdPreCheck !== null)
					{
						documentUpdateText += "480";
					}
					else
					{
						documentUpdateText += "500";
					}
					documentUpdateText += "px' type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
					documentUpdateText += "<input type='text' name='watchListItem"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
					documentUpdateText += " <a class='link' onclick='deleteRowFunctionPopup("+updateItoIMinusOne+", true,\""+previousElementNumIdentifierForKey[0].value+"\")'>Remove</a>";
					documentUpdateText += "</li>";
					document.getElementById(elementToUpdate).outerHTML = documentUpdateText;
				}
			}
			newValue--;
			if(countOfAddedFiles > 0)
			{
				countOfAddedFiles--;
				countOfWatchList--;
			}
			else
			{
				countOfWatchList--;
			}
			document.getElementById("numberOfRows").value = newValue;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}	
function showOrHidePopupSubWindow()
{
	try
	{
		var valueForPopup = document.getElementById("popupSelect");
		var valueForVars = document.getElementById("settingsPopupVars");
		showOrHideSubWindow(valueForPopup, valueForVars);
	}
	catch(e)
	{
		eventThrowException(e)
	}
}
function showOrHideUpdateSubWindow()
{
	try
	{
		var valueForPopup = document.getElementById("settingsSelect");
		var valueForVars = document.getElementById("settingsAutoCheckVars");
		showOrHideSubWindow(valueForPopup, valueForVars);
	}
	catch(e)
	{
		eventThrowException(e)
	}
}
function showOrHideSubWindow(valueForPopupInner, valueForVarsInner)
{
	try
	{
		if(valueForPopupInner.value === "true")
		{
			valueForVarsInner.style.display = "block";
		}
		else
		{
			valueForVarsInner.style.display = "none";
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}
function checkWatchList()
{
	try
	{
		var blankValue = false;
		for (var i = 1; i <= countOfWatchList; i++) 
		{
			if(document.getElementsByName("watchListKey"+i)[0].value === "")
			{
				blankValue = true;
			}
		}
		if(blankValue && popupSettingsArray.blankFolder == "true")
		{
			showNoEmptyFolderPopup();
			event.preventDefault();
			event.returnValue = false;
			return false;
		}
		else
		{
			displayLoadingPopup();
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}
function showNoEmptyFolderPopup()
{
	try
	{
		showPopup();
		document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Warning!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Please make sure there are no empty folders when saving the Watch List.</div><div><div class='link' onclick='hidePopup();' style='margin-left:175px; margin-top:25px;'>Okay</div></div>";
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function eventThrowException(e)
{
	if((typeof(sendCrashInfoJS) !== 'undefined') && (sendCrashInfoJS === "true"))
	{
		Raven.captureException(e);
	}
}
/global sendCrashInfoJS Raven displayLoadingPopup countOfAddedFiles countOfWatchList popupSettingsArray /;
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
		eventThrowException(e);
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
			document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #0" + countOfWatchList+ ": <div style=\"width: 130px; display: inline-block; text-align: center;\">----------</div><input type='text' style='width: 480px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link'  onclick='deleteRowFunctionPopup("+ countOfWatchList +", true, \"File #0" + countOfWatchList+"\")'><img src=\"../core/img/trashCan.png\" height=\"15px;\" ></a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
		}
		else
		{
			document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #" + countOfWatchList+ ": <div style=\"width: 130px; display: inline-block; text-align: center;\">----------</div><input type='text' style='width: 480px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link' onclick='deleteRowFunctionPopup("+ countOfWatchList +", true, \"File #" + countOfWatchList+"\")'><img src=\"../core/img/trashCan.png\" height=\"15px;\" ></a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
		}
		locationInsert = "newRowLocationForWatchList"+countOfClicks;
		document.getElementById("numberOfRows").value = countOfWatchList;
		countOfAddedFiles++;
	}
	catch(e)
	{
		eventThrowException(e);
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
		eventThrowException(e);
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
					var nameForId = "fileNotFoundImage" + i;
					var elementByIdPreCheck = document.getElementById(nameForId);
					if(elementByIdPreCheck !== null)
					{
						documentUpdateText += updateItoIMinusOne+": <div style=\"width: 100px; display: inline-block; text-align: center;\">----------</div>";
						var elementPreCheckSrc = elementByIdPreCheck.src;
						if(elementPreCheckSrc.indexOf("folderIcon") !== -1)
						{
							documentUpdateText += "<img id='fileNotFoundImage"+updateItoIMinusOne+"' src='../core/img/folderIcon.png' width='15px'>  ";
						}
						else if(elementPreCheckSrc.indexOf("fileIcon") !== -1)
						{
							documentUpdateText += "<img id='fileNotFoundImage"+updateItoIMinusOne+"' src='../core/img/fileIcon.png' width='15px'>  ";
						}
						else
						{
							documentUpdateText += "<img id='fileNotFoundImage"+updateItoIMinusOne+"' src='../core/img/redWarning.png' width='15px'>  ";
						}
					}
					else
					{
						documentUpdateText += updateItoIMinusOne+": <div style=\"width: 130px; display: inline-block; text-align: center;\">----------</div>";
					}
					documentUpdateText += "<input style='width: 480px' type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
					documentUpdateText += "<input type='text' name='watchListItem"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
					documentUpdateText += " <a class='link' onclick='deleteRowFunctionPopup("+updateItoIMinusOne+", true,\""+previousElementNumIdentifierForKey[0].value+"\")'><img src=\"../core/img/trashCan.png\" height=\"15px;\" ></a>";
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
		if(blankValue && popupSettingsArray.blankFolder === "true")
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

function checkForChangesWatchListPoll()
{
	try
	{
		if(!objectsAreSame($("#settingsMainWatch").serializeArray(),watchlistData))
		{
			document.getElementById("resetChangesSettingsHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesSettingsHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function checkForChangesMainSettings()
{
	try
	{
		if(!objectsAreSame($("#settingsMainVars").serializeArray(),mainData))
		{
			document.getElementById("resetChangesMainSettingsHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesMainSettingsHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function checkForChangesMenuSettings()
{
	try
	{
		if(!objectsAreSame($("#settingsMenuVars").serializeArray(), menuData))
		{
			document.getElementById("resetChangesMenuSettingsHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesMenuSettingsHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function poll()
{
	try
	{
		var change = checkForChangesWatchListPoll();
		var change2 = checkForChangesMainSettings();
		var change3 = checkForChangesMenuSettings();
		if(change || change2 || change3)
		{
			document.getElementById("mainLink").innerHTML = "Main*";
		}
		else
		{
			document.getElementById("mainLink").innerHTML = "Main";
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function resetWatchListVars()
{
	try
	{
		document.getElementById("settingsMainWatch").innerHTML = savedInnerHtmlWatchList;
		watchlistData = $("#settingsMainWatch").serializeArray();
		countOfWatchList = countOfWatchListStatic;
		countOfAddedFiles =  countOfAddedFilesStatic;
		countOfClicks = countOfClicksStatic;
		locationInsert = locationInsertStatic;
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function resetSettingsMainVar()
{
	try
	{
		document.getElementById("settingsMainVars").innerHTML = savedInnerHtmlMainVars;
		mainData = $("#settingsMainVars").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function resetSettingsMenuVar()
{
	try
	{
		document.getElementById("settingsMenuVars").innerHTML = savedInnerHtmlMenu;
		menuData = $("#settingsMenuVars").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function refreshSettingsMainVar()
{
	try
	{
		mainData = $("#settingsMainVars").serializeArray();
		savedInnerHtmlWatchList = document.getElementById("settingsMainWatch").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function refreshSettingsMenuVar()
{
	try
	{
		menuData = $("#settingsMenuVars").serializeArray();
		savedInnerHtmlMenu = document.getElementById("settingsMenuVars").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function refreshSettingsWatchList()
{
	try
	{
		watchlistData = $("#settingsMainWatch").serializeArray();
		savedInnerHtmlMainVars = document.getElementById("settingsMainVars").innerHTML;
		countOfWatchListStatic = countOfWatchList;
		countOfAddedFilesStatic = countOfAddedFiles;
		countOfClicksStatic = countOfClicks;
		locationInsertStatic = locationInsert;
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function highlightTopNavDepends()
{
	try
	{
		var offsetHeight = 0;
		if(document.getElementById("menu"))
		{
			offsetHeight += document.getElementById("menu").offsetHeight;
		}
		if(document.getElementById("menu2"))
		{
			offsetHeight += document.getElementById("menu2").offsetHeight;
		}
		outerHeightMain = $("#settingsMainVars").outerHeight();
		positionMain = $("#settingsMainVars").position();
		if((outerHeightMain+positionMain.top-offsetHeight) < 0)
		{
			positionMain = $("#settingsMainWatch").position();
			if((outerHeightMain+positionMain.top-offsetHeight) < 0)
			{
				highlightSettingsMenu2Option("menuSettingsMenu2");
			}
			else
			{
				highlightSettingsMenu2Option("watchListSettingsMenu2");
			}
		}
		else
		{
			//check if class is already there before adding
			highlightSettingsMenu2Option("mainSettingsMenu2");
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function highlightSettingsMenu2Option(option)
{
	try
	{
		var titles = ["mainSettingsMenu2", "watchListSettingsMenu2", "menuSettingsMenu2"];
		for (var i = titles.length - 1; i >= 0; i--)
		{
			
			if(option != titles[i])
			{
				removeActiveClass(titles[i]);
			}
			else
			{
				addActiveClass(titles[i]);
			}
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function addActiveClass(idToAdd)
{
	try
	{
		if(!$("#"+idToAdd).hasClass('active'))
		{
			$("#"+idToAdd).addClass('active');
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function removeActiveClass(idToAdd)
{
	try
	{
		if($("#"+idToAdd).hasClass('active'))
		{
			$("#"+idToAdd).removeClass('active');
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}
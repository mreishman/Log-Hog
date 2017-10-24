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
							documentUpdateText += "<img id='fileNotFoundImage"+updateItoIMinusOne+"' src='"+baseUrl+"img/folderIcon.png' width='15px'>  ";
						}
						else if(elementPreCheckSrc.indexOf("fileIcon") !== -1)
						{
							documentUpdateText += "<img id='fileNotFoundImage"+updateItoIMinusOne+"' src='"+baseUrl+"img/fileIcon.png' width='15px'>  ";
						}
						else
						{
							documentUpdateText += "<img id='fileNotFoundImage"+updateItoIMinusOne+"' src='"+baseUrl+"img/redWarning.png' width='15px'>  ";
						}
					}
					else
					{
						documentUpdateText += updateItoIMinusOne+": <div style=\"width: 130px; display: inline-block; text-align: center;\">----------</div>";
					}
					documentUpdateText += "<input style='width: 480px' type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
					documentUpdateText += "<input type='text' name='watchListItem"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
					documentUpdateText += " <a class='deleteIconPosition' onclick='deleteRowFunctionPopup("+updateItoIMinusOne+", true,\""+previousElementNumIdentifierForKey[0].value+"\")'><img src=\""+baseUrl+"img/trashCan.png\" height=\"15px;\" ></a>";
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
		if((valueForPopupInner.value === "true") || (valueForPopupInner.value === "custom"))
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

function poll()
{
	try
	{
		var change2 = checkForChangesMainSettings();
		if(change2)
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
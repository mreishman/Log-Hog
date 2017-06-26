function showOrHideLogTrimSubWindow()
{
	var valueToSeeIfShowOrHideSubWindowLogTrim = document.getElementById("logTrimOn").value;

	if(valueToSeeIfShowOrHideSubWindowLogTrim == "true")
	{
		document.getElementById("settingsLogTrimVars").style.display = "block";
	}
	else
	{
		document.getElementById("settingsLogTrimVars").style.display = "none";
	}
}


function changeDescriptionLineSize()
{

	var valueForDesc = document.getElementById("logTrimTypeToggle").value;

	if (valueForDesc == "lines")
	{
		document.getElementById('logTrimTypeText').innerHTML = "Lines";
		document.getElementById('LiForlogTrimSize').style.display = "none"
	}
	else if (valueForDesc == 'size')
	{
		document.getElementById('logTrimTypeText').innerHTML = "Size";
		document.getElementById('LiForlogTrimSize').style.display = "block"
	}

}

function addRowFunction()
{

	countOfWatchList++;
	countOfClicks++;
	if(countOfWatchList < 10)
	{
		document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #0" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link'  onclick='deleteRowFunctionPopup("+ countOfWatchList +", true,"+'"'+"File #0" + countOfWatchList+'"'+")'>Remove File / Folder</a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
	}
	else
	{
		document.getElementById(locationInsert).outerHTML += "<li id='rowNumber"+countOfWatchList+"'>File #" + countOfWatchList+ ": <input type='text' style='width: 500px;' name='watchListKey" + countOfWatchList + "' > <input type='text' name='watchListItem" + countOfWatchList + "' > <a class='link' onclick='deleteRowFunctionPopup("+ countOfWatchList +", true,"+'"'+"File #" + countOfWatchList+'"'+")'>Remove File / Folder</a></li><div id='newRowLocationForWatchList"+countOfClicks+"'></div>";
	}
	locationInsert = "newRowLocationForWatchList"+countOfClicks;
	document.getElementById('numberOfRows').value = countOfWatchList;
	countOfAddedFiles++;
}

function deleteRowFunctionPopup(currentRow, decreaseCountWatchListNum, keyName = "")
{
	if(popupSettingsArray.removeFolder == "true")
	{
		showPopup();
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Are you sure you want to remove this file/folder?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+keyName+"</div><div><div class='link' onclick='deleteRowFunction("+currentRow+","+ decreaseCountWatchListNum+");hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
	}
	else
	{
		deleteRowFunction(currentRow, decreaseCountWatchListNum);
	}
	
}

function deleteRowFunction(currentRow, decreaseCountWatchListNum)
{
	var elementToFind = "rowNumber" + currentRow;
	document.getElementById(elementToFind).outerHTML = "";
	if(decreaseCountWatchListNum)
	{
		newValue = document.getElementById('numberOfRows').value;
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
					documentUpdateText += '<img id="fileNotFoundImage'+updateItoIMinusOne+'" src="../core/img/redWarning.png" height="10px">';
				}
				documentUpdateText += "<input style='width: ";
				if(elementByIdPreCheck !== null)
				{
					documentUpdateText += '480';
				}
				else
				{
					documentUpdateText += '500';
				}
				documentUpdateText += "px' type='text' name='watchListKey"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForKey[0].value+"'> ";
				documentUpdateText += "<input type='text' name='watchListItem"+updateItoIMinusOne+"' value='"+previousElementNumIdentifierForItem[0].value+"'>";
				documentUpdateText += ' <a class="link" onclick="deleteRowFunctionPopup('+updateItoIMinusOne+', true,'+"'"+previousElementNumIdentifierForKey[0].value+"'"+')">Remove File / Folder</a>';
				documentUpdateText += '</li>';
				document.getElementById(elementToUpdate).outerHTML = documentUpdateText;
			}
		}
		newValue--;
		if(countOfAddedFiles > 0)
		{
			countOfAddedFiles--;
			countOfWatchList--;
		}
		document.getElementById('numberOfRows').value = newValue;
	}

}	
function showOrHidePopupSubWindow()
{
	var valueForPopup = document.getElementById('popupSelect').value;
	if(valueForPopup == 'custom')
	{
		document.getElementById('settingsPopupVars').style.display = 'block';
	}
	else
	{
		document.getElementById('settingsPopupVars').style.display = 'none';
	}
}
function showOrHideUpdateSubWindow()
{
	var valueForPopup = document.getElementById('settingsSelect').value;
	if(valueForPopup == 'true')
	{
		document.getElementById('settingsAutoCheckVars').style.display = 'block';
	}
	else
	{
		document.getElementById('settingsAutoCheckVars').style.display = 'none';
	}
}
function checkWatchList()
{
	var blankValue = false;
	for (var i = 1; i <= countOfWatchList; i++) 
	{
		if(document.getElementsByName("watchListKey"+i)[0].value == "")
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
function showNoEmptyFolderPopup()
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Warning!</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Please make sure there are no empty folders when saving the Watch List.</div><div><div class='link' onclick='hidePopup();' style='margin-left:175px; margin-top:25px;'>Okay</div></div>";
}

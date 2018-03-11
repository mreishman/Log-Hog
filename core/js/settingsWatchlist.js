var fileArrayKeys = Object.keys(fileArray);
var titleOfPage = "Watchlist";

function generateRow(data)
{
	var item = $("#storage .saveBlock").html();
	item = item.replace(/{{rowNumber}}/g, data["rowNumber"]);
	item = item.replace(/{{fileNumber}}/g, data["fileName"]);
	item = item.replace(/{{filePermsDisplay}}/g, data["filePermsDisplay"]);
	item = item.replace(/{{fileImage}}/g, data["fileImage"]);
	item = item.replace(/{{location}}/g, data["location"]);
	item = item.replace(/{{pattern}}/g, data["pattern"]);
	item = item.replace(/{{key}}/g, data["key"]);
	return item;
} 


function addRowFunction()
{
	try
	{
		var countOfWatchList = document.getElementById("numberOfRows").value;
		countOfWatchList++;

		var fileName = ""+countOfWatchList;
		if(countOfWatchList < 10)
		{
			fileName = "0"+fileName;
		}
		var item = generateRow(
			{
				rowNumber: countOfWatchList,
				fileNumber: fileName,
				filePermsDisplay: "----------",
				fileImage: "",
				location: "",
				pattern: "",
				key: "Log "+countOfWatchList
			}
		);
		$(".uniqueClassForAppendSettingsMainWatchNew").append(item);
		document.getElementById("numberOfRows").value = countOfWatchList;
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
		if("removeFolder" in popupSettingsArray && popupSettingsArray.removeFolder === "true")
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
					var fileName = "";
					if(updateItoIMinusOne < 10)
					{
						fileName += "0";
					}
					fileName += updateItoIMinusOne;
					var nameForId = "fileNotFoundImage" + i;
					var elementByIdPreCheck = document.getElementById(nameForId);
					var elementByIdAlsoPreCheck = document.getElementById("infoFile"+i);
					if(elementByIdPreCheck !== null && elementByIdAlsoPreCheck !== null)
					{
						documentUpdateText += updateItoIMinusOne+": ";
						elementByIdAlsoPreCheck.id = "infoFile"+updateItoIMinusOne;
						documentUpdateText += elementByIdAlsoPreCheck.html();
						elementByIdPreCheck.id = "fileNotFoundImage"+updateItoIMinusOne;
						documentUpdateText += elementByIdPreCheck.html();
					}
					else
					{
						documentUpdateText += updateItoIMinusOne+": <div style=\"width: 130px; display: inline-block; text-align: center;\">----------</div>";
					}
					documentUpdateText += "<input style='width: 480px' type='text' name='watchListKey"+updateItoIMinusOne+"' value=''> ";
					documentUpdateText += "<input type='text' name='watchListItem"+updateItoIMinusOne+"' value=''>";
					documentUpdateText += " <a class='deleteIconPosition' onclick='deleteRowFunctionPopup("+updateItoIMinusOne+", true,\"\")'>"+defaultTrashCanIcon+"</a>";

					var item = generateRow(
						{
							rowNumber: updateItoIMinusOne,
							fileNumber: fileName,
							filePermsDisplay: "----------",
							fileImage: "",
							location: document.getElementsByName("watchListKey"+1+"Location")[0].value,
							pattern: document.getElementsByName("watchListKey"+1+"Pattern")[0].value,
							key: document.getElementsByName("watchListKey"+1)[0].value,
						}
					);
					$(".uniqueClassForAppendSettingsMainWatchNew").append(item);
				}
			}
			newValue--;
			document.getElementById("numberOfRows").value = newValue;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkWatchList()
{
	try
	{
		var countOfWatchList = document.getElementById("numberOfRows").value;
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
		eventThrowException(e);
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
		eventThrowException(e);
	}
}

function checkIfChanges()
{
	if(	checkForChangesArray(["settingsMainWatch"]))
	{
		return true;
	}
	return false;
}

function resetWatchListVars()
{
	try
	{
		resetArrayObject("settingsMainWatch");
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsWatchList()
{
	try
	{
		refreshArrayObject("settingsMainWatch");
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

$( document ).ready(function() 
{
	refreshSettingsWatchList();
	setInterval(poll, 100);
});


function addRowForFolderColorOptions()
{
	var currentMaxRow = parseInt($("#settingsColorFolderGroupVars [name=\"folderThemeCount\"] ")[0].value);
	var counterForDefaults = 1;
	while($("#settingsColorFolderGroupVars [name=\"folderColorThemeNameForPost"+counterForDefaults+"\"] ")[0] && $("#settingsColorFolderGroupVars [name=\"folderColorThemeNameForPost"+counterForDefaults+"\"] ")[0].value.indexOf("theme-default") > -1)
	{
		counterForDefaults++;
	}
	counterForDefaults--;
	currentMaxRow++;
	var table = document.getElementById("addNewRowToThisForThemes");
	var row 	= table.insertRow(currentMaxRow);
	var cell1 	= row.insertCell(0);
	var cell1p5 = row.insertCell(1);
	var cell2 	= row.insertCell(2);
	var cell3 	= row.insertCell(3);
	var cell4 	= row.insertCell(4);
	var cell5 	= row.insertCell(5);
	var cellItem = $("#holderForFolderColors .emptyRow1").html();
	cell1.innerHTML = replaceStuff(cellItem, currentMaxRow, (currentMaxRow-counterForDefaults), "na", "na");
	cellItem = $("#holderForFolderColors .emptyRow1p5").html();
	cell1p5.innerHTML = replaceStuff(cellItem, currentMaxRow, (currentMaxRow-counterForDefaults), "na", "na");
	cellItem = $("#holderForFolderColors .emptyRow2").html();
	cell2.innerHTML = replaceStuff(cellItem, currentMaxRow, (currentMaxRow-counterForDefaults), "#000000", "#FFFFFF");
	cellItem = $("#holderForFolderColors .emptyRow3").html();
	cell3.innerHTML = replaceStuff(cellItem, currentMaxRow, (currentMaxRow-counterForDefaults), "#000000", "#FFFFFF");
	cellItem = $("#holderForFolderColors .emptyRow4").html();
	cell4.innerHTML = replaceStuff(cellItem, currentMaxRow, (currentMaxRow-counterForDefaults), "#000000", "#FFFFFF");
	cellItem = $("#holderForFolderColors .emptyRow5").html();
	cell5.innerHTML = replaceStuff(cellItem, currentMaxRow, (currentMaxRow-counterForDefaults), "#000000", "#FFFFFF");
	$("#settingsColorFolderGroupVars [name=\"folderThemeCount\"] ")[0].value = currentMaxRow;
	var lengthOfNames = folderColorGroupNames.length;
	for(var nameCount = 0; nameCount < lengthOfNames; nameCount++)
	{
		addNewFolderColorButtonForThing(folderColorGroupNames[nameCount], currentMaxRow, 1);
	}
}

function moveRowForFolderColorOptions(newRowLocation)
{
	var counterForDefaults = 1;
	while($("#settingsColorFolderGroupVars [name=\"folderColorThemeNameForPost"+counterForDefaults+"\"] ")[0] && $("#settingsColorFolderGroupVars [name=\"folderColorThemeNameForPost"+counterForDefaults+"\"] ")[0].value.indexOf("theme-default") > -1)
	{
		counterForDefaults++;
	}
	counterForDefaults--;
	var table 	= document.getElementById("addNewRowToThisForThemes");
	var row 	= table.insertRow(newRowLocation);
	var cell1 	= row.insertCell(0);
	var cell1p5 = row.insertCell(1);
	var cell2 	= row.insertCell(2);
	var cell3 	= row.insertCell(3);
	var cell4 	= row.insertCell(4);
	var cell5 	= row.insertCell(5);
	var cellItem = $("#holderForFolderColors .emptyRow1").html();
	cell1.innerHTML = replaceStuff(cellItem, newRowLocation, (newRowLocation-counterForDefaults), "na", "na");
	cellItem = $("#holderForFolderColors .emptyRow1p5").html();
	cell1p5.innerHTML = replaceStuff(cellItem, newRowLocation, (newRowLocation-counterForDefaults), "na", "na");
	cellItem = $("#holderForFolderColors .emptyRow2").html();
	cell2.innerHTML = replaceStuff(cellItem, newRowLocation, (newRowLocation-counterForDefaults), document.getElementById("folderColorValueMainBackground"+(newRowLocation+1)+"-1").value, document.getElementById("folderColorValueMainFont"+(newRowLocation+1)+"-1").value);
	cellItem = $("#holderForFolderColors .emptyRow3").html();
	cell3.innerHTML = replaceStuff(cellItem, newRowLocation, (newRowLocation-counterForDefaults), document.getElementById("folderColorValueHighlightBackground"+(newRowLocation+1)+"-1").value, document.getElementById("folderColorValueHighlightFont"+(newRowLocation+1)+"-1").value);
	cellItem = $("#holderForFolderColors .emptyRow4").html();
	cell4.innerHTML = replaceStuff(cellItem, newRowLocation, (newRowLocation-counterForDefaults), document.getElementById("folderColorValueActiveBackground"+(newRowLocation+1)+"-1").value, document.getElementById("folderColorValueActiveFont"+(newRowLocation+1)+"-1").value);
	cellItem = $("#holderForFolderColors .emptyRow5").html();
	cell5.innerHTML = replaceStuff(cellItem, newRowLocation, (newRowLocation-counterForDefaults), document.getElementById("folderColorValueActiveHighlightBackground"+(newRowLocation+1)+"-1").value, document.getElementById("folderColorValueActiveHighlightFont"+(newRowLocation+1)+"-1").value);
	var extraColors = 2;
	if((document.getElementById("folderColorValueMainBackground"+(newRowLocation+1)+"-"+(extraColors))))
	{
		while(document.getElementById("folderColorValueMainBackground"+(newRowLocation+1)+"-"+(extraColors)))
		{
			addColorBlock(newRowLocation, document.getElementById("folderColorValueMainBackground"+(newRowLocation+1)+"-"+(extraColors)).value, document.getElementById("folderColorValueMainFont"+(newRowLocation+1)+"-"+(extraColors)).value);
			extraColors++;
		}
	}
	var lengthOfNames = folderColorGroupNames.length;
	for(var nameCount = 0; nameCount < lengthOfNames; nameCount++)
	{
		addNewFolderColorButtonForThing(folderColorGroupNames[nameCount], newRowLocation, 1);
	}
	table.deleteRow(newRowLocation + 1);
}

function replaceStuff(item, currentMax, newTheme, bgColor, fColor)
{
	item = item.replace(/{{themeName}}/g, "noTheme");
	item = item.replace(/{{j}}/g, "1");
	item = item.replace(/{{i}}/g, currentMax);
	item = item.replace(/{{key}}/g, "theme-user-"+newTheme);
	item = item.replace(/{{backgroundColor}}/g, bgColor);
	item = item.replace(/{{fontColor}}/g, fColor);
	return item;
}

function addColorBlock(currentRow, bgColor = "#000000", fColor = "#FFFFFF")
{
	var item = $("#holderForFolderColors .emptyColorBlock").html();
	var newRow = getLastRowForMainColors(currentRow);
	item = item.replace(/{{backgroundColor}}/g, bgColor);
	item = item.replace(/{{fontColor}}/g, fColor);
	item = item.replace(/{{name}}/g, "Main");
	item = item.replace(/{{i}}/g, currentRow);
	item = item.replace(/{{j}}/g, newRow);
	$("#folderColorThemeNameForPost"+currentRow+"Main").append(item);
	addNewFolderColorButtonForThing("Main", currentRow, newRow);
}

function removeColorBlock(currentRow)
{
	var newRow = getLastRowForMainColors(currentRow) -  1;
	$("#folderColorButtonMainBackground"+currentRow+"-"+newRow).parent().parent().remove();
}

function removeRow(currentRow)
{
	var currentMaxRow = parseInt($("#settingsColorFolderGroupVars [name=\"folderThemeCount\"] ")[0].value);
	var table = document.getElementById("addNewRowToThisForThemes");
	table.deleteRow(currentRow);
	if(currentRow < currentMaxRow)
	{
		//loop to update other rows by -1 to row
		for(var moveRowCount = currentRow; moveRowCount < currentMaxRow; moveRowCount++)
		{
			moveRowForFolderColorOptions(moveRowCount);
		}
	}
	currentMaxRow--;
	$("#settingsColorFolderGroupVars [name=\"folderThemeCount\"] ")[0].value = currentMaxRow;
}

function getLastRowForMainColors(currentRow)
{
	var newRow = 1;
	while(document.getElementById("folderColorButtonMainBackground"+currentRow+"-"+newRow))
	{
		newRow++;
	}
	return newRow;
}

function addNewFolderColorButtonForThing(name, currentRow, currentColumn)
{
	new jscolor(document.getElementById("folderColorButton"+name+"Background"+currentRow+"-"+currentColumn), {valueElement: "folderColorValue"+name+"Background"+currentRow+"-"+currentColumn, hash:true});
	new jscolor(document.getElementById("folderColorButton"+name+"Font"+currentRow+"-"+currentColumn), {valueElement: "folderColorValue"+name+"Font"+currentRow+"-"+currentColumn, hash:true});
}

function reAddJsColorPopupForCustomThemes()
{
	var lengthOfNames = folderColorGroupNames.length;
	var startOfuser = 1;
	var allFolderCount = 1;
	while($("#settingsColorFolderGroupVars [name=\"folderColorThemeNameForPost"+allFolderCount+"\"] ")[0])
	{
		if($("#settingsColorFolderGroupVars [name=\"folderColorThemeNameForPost"+allFolderCount+"\"] ")[0].value.indexOf("theme-user") > -1)
		{
			//this one is custom
			for(var nameCount = 0; nameCount < lengthOfNames; nameCount++)
			{
				var internalCountFolder = 1;
				while(document.getElementById("folderColorButton"+folderColorGroupNames[nameCount]+"Background"+allFolderCount+"-"+internalCountFolder))
				{
					addNewFolderColorButtonForThing(folderColorGroupNames[nameCount], allFolderCount, internalCountFolder);
					internalCountFolder++;
				}
			}
			startOfuser++;
		}
		allFolderCount++;
	}
}
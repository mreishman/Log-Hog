var titleOfPage = "Themes";

function checkIfChanges()
{
	if(	checkForChangesArray(["settingsColorFolderVars","settingsColorFolderGroupVars"]))
	{
		return true;
	}
	return false;
}

function deleteTheme(themeName)
{
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'removeUnZippedFiles', removeDir: true, locationOfFilesThatNeedToBeRemovedRecursivally: themeName};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		complete()
		{
			
		}
	});
}

function newThemePopup(themeNum)
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Save custom theme ("+themeNum+")</div><br><div style='width:100%;text-align:center;'> Insert name for new custom theme: <br> <input id=\"newCustomThemeName\" type=\"text\" value=\"Custom-Theme-"+themeNum+"\"> <br> <div class='link' onclick='saveCustomTheme("+themeNum+")' style='margin-right:50px;margin-top:25px;'>Save</div><div onclick='hidePopup();' class='link'>Cancel</div> </div>";
}

function saveCustomTheme(themeNum)
{
	var themeName = document.getElementById("newCustomThemeName").value;
}

$( document ).ready(function() 
{
	refreshArrayObjectOfArrays(["settingsColorFolderVars","settingsColorFolderGroupVars"]);
	setInterval(poll, 100);
});
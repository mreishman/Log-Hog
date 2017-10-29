var titleOfPage = "Themes";

function checkIfChanges()
{
	if(	checkForChanges("settingsColorFolderVars") || checkForChanges("settingsColorFolderGroupVars"))
	{
		return true;
	}
	return false;
}

function goToUrl(url)
{
	goToPage = !checkIfChanges();
	if(goToPage || popupSettingsArray.saveSettings == "false")
	{
		window.location.href = url;
	}
	else
	{
		displaySavePromptPopup(url);
	}
}

$( document ).ready(function() 
{
	refreshArrayObject("settingsColorFolderVars");
	refreshArrayObject("settingsColorFolderGroupVars");
	setInterval(poll, 100);
});
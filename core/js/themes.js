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

$( document ).ready(function() 
{
	refreshArrayObjectOfArrays(["settingsColorFolderVars","settingsColorFolderGroupVars"]);
	setInterval(poll, 100);
});
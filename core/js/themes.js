var titleOfPage = "Themes";

function checkIfChanges()
{
	if(	checkForChanges("settingsColorFolderVars") || checkForChanges("settingsColorFolderGroupVars"))
	{
		return true;
	}
	return false;
}

$( document ).ready(function() 
{
	refreshArrayObject("settingsColorFolderVars");
	refreshArrayObject("settingsColorFolderGroupVars");
	setInterval(poll, 100);
});
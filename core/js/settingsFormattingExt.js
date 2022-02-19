var titleOfPage = "Main";
var urlModifierForAjax = "../";

function checkIfChanges()
{
	let arrayToCheck = [];
	let arrOfPossibleGroups = [
		"settingsColorFolderGroupVars",
		"generalThemeOptions",
		"settingsLogFormatVars"
		
	];
	let arrOfPossibleGroupsKeys = Object.keys(arrOfPossibleGroups);
	let arrOfPossibleGroupsKeysLength = arrOfPossibleGroupsKeys.length;
	for(let i = 0; i < arrOfPossibleGroupsKeysLength; i++)
	{
		if(document.getElementById(arrOfPossibleGroups[arrOfPossibleGroupsKeys[i]]))
		{
			arrayToCheck.push(arrOfPossibleGroups[arrOfPossibleGroupsKeys[i]]);
		}
	}
	if(	checkForChangesArray(arrayToCheck))
	{
		return true;
	}
	return false;
}

$( document ).ready(function()
{
	let arrayToRefresh = [];
	let arrOfPossibleGroups = [
		"settingsColorFolderGroupVars",
		"generalThemeOptions",
		"settingsLogFormatVars"

	];
	let arrOfPossibleGroupsKeys = Object.keys(arrOfPossibleGroups);
	let arrOfPossibleGroupsKeysLength = arrOfPossibleGroupsKeys.length;
	for(let i = 0; i < arrOfPossibleGroupsKeysLength; i++)
	{
		if(document.getElementById(arrOfPossibleGroups[arrOfPossibleGroupsKeys[i]]))
		{
			arrayToRefresh.push(arrOfPossibleGroups[arrOfPossibleGroupsKeys[i]]);
		}
	}
	refreshArrayObjectOfArrays(arrayToRefresh);

	document.addEventListener("resize", function() {onScrollShowFixedMiniBar(arrayToRefresh);});
	$( window ).resize(function() { onScrollShowFixedMiniBar(arrayToRefresh); });

	if (typeof poll !== "undefined")
	{
		setInterval(poll, 100);
	}
});
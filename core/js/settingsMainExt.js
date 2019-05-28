var titleOfPage = "Main";
var urlModifierForAjax = "../";

function checkIfChanges()
{
	let arrayToCheck = [];
	let arrOfPossibleGroups = [
		"settingsLogVars",
		"settingsLogFormatVars",
		"settingsPollVars",
		"settingsFilterVars",
		"archiveConfig",
		"settingsNotificationVars",
		"settingsMenuVars",
		"settingsWatchlistVars",
		"settingsOneLogVars",
		"settingsMultiLogVars",
		"settingsInitialLoadLayoutVars",
		"settingsMainVars"
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
		"settingsLogVars",
		"settingsLogFormatVars",
		"settingsPollVars",
		"settingsFilterVars",
		"archiveConfig",
		"settingsNotificationVars",
		"settingsMenuVars",
		"settingsWatchlistVars",
		"settingsOneLogVars",
		"settingsMultiLogVars",
		"settingsInitialLoadLayoutVars",
		"settingsMainVars"
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

	document.addEventListener(
		"scroll",
		function (event)
		{
			onScrollShowFixedMiniBar(arrayToRefresh);
		},
		true
	);

	setInterval(poll, 100);
});
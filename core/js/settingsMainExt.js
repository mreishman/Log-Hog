var titleOfPage = "Main";
var urlModifierForAjax = "../";

function checkIfChanges()
{
	var arrayToCheck = new Array();
	if(document.getElementById("settingsMenuVars"))
	{
		arrayToCheck.push("settingsMenuVars");
	}
	if(document.getElementById("settingsMainVars"))
	{
		arrayToCheck.push("settingsMainVars");
	}
	if(document.getElementById("settingsLogVars"))
	{
		arrayToCheck.push("settingsLogVars");
	}
	if(document.getElementById("settingsLogFormatVars"))
	{
		arrayToCheck.push("settingsLogFormatVars");
	}
	if(document.getElementById("settingsPollVars"))
	{
		arrayToCheck.push("settingsPollVars");
	}
	if(document.getElementById("settingsFilterVars"))
	{
		arrayToCheck.push("settingsFilterVars");
	}
	if(document.getElementById("archiveConfig"))
	{
		arrayToCheck.push("archiveConfig");
	}
	if(document.getElementById("settingsNotificationVars"))
	{
		arrayToCheck.push("settingsNotificationVars");
	}
	if(document.getElementById("settingsWatchlistVars"))
	{
		arrayToCheck.push("settingsWatchlistVars");
	}
	if(document.getElementById("settingsOneLogVars"))
	{
		arrayToCheck.push("settingsOneLogVars");
	}
	if(document.getElementById("settingsMultiLogVars"))
	{
		arrayToCheck.push("settingsMultiLogVars");
	}
	if(document.getElementById("settingsInitialLoadLayoutVars"))
	{
		arrayToCheck.push("settingsInitialLoadLayoutVars");
	}
	if(	checkForChangesArray(arrayToCheck))
	{
		return true;
	}
	return false;
}

$( document ).ready(function()
{
	var arrayToRefresh = new Array();
	if(document.getElementById("settingsLogVars"))
	{
		arrayToRefresh.push("settingsLogVars");
	}
	if(document.getElementById("settingsLogFormatVars"))
	{
		arrayToRefresh.push("settingsLogFormatVars");
	}
	if(document.getElementById("settingsPollVars"))
	{
		arrayToRefresh.push("settingsPollVars");
	}
	if(document.getElementById("settingsFilterVars"))
	{
		arrayToRefresh.push("settingsFilterVars");
	}
	if(document.getElementById("archiveConfig"))
	{
		arrayToRefresh.push("archiveConfig");
	}
	if(document.getElementById("settingsNotificationVars"))
	{
		arrayToRefresh.push("settingsNotificationVars");
	}
	if(document.getElementById("settingsMenuVars"))
	{
		arrayToRefresh.push("settingsMenuVars");
	}
	if(document.getElementById("settingsWatchlistVars"))
	{
		arrayToRefresh.push("settingsWatchlistVars");
	}
	if(document.getElementById("settingsOneLogVars"))
	{
		arrayToRefresh.push("settingsOneLogVars");
	}
	if(document.getElementById("settingsMainVars"))
	{
		arrayToRefresh.push("settingsMainVars");
	}
	if(document.getElementById("settingsMultiLogVars"))
	{
		arrayToRefresh.push("settingsMultiLogVars");
	}
	if(document.getElementById("settingsInitialLoadLayoutVars"))
	{
		arrayToRefresh.push("settingsInitialLoadLayoutVars");
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
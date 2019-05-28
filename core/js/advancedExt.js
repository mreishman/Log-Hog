var titleOfPage = "Advanced";
var popupHtml = "";

function checkIfChanges()
{
	if(checkForChangesArray(["loggingDisplay","modules","locationOtherApps","advancedConfig","expFeatures"]))
	{
		return true;
	}
	return false;
}

$( document ).ready(function()
{
	refreshArrayObjectOfArrays(["loggingDisplay","modules","locationOtherApps","advancedConfig","expFeatures"]);

	document.addEventListener(
		"scroll",
		function (event)
		{
			onScrollShowFixedMiniBar(["advancedConfig","modules","loggingDisplay","locationOtherApps","moreAdvancedSpan","expFeatures"]);
		},
		true
	);

	setInterval(poll, 100);
});
var titleOfPage = "Advanced";
var popupHtml = "";

function checkIfChanges()
{
	if(checkForChangesArray(["modules","locationOtherApps","advancedConfig"]))
	{
		return true;
	}
	return false;
}

$( document ).ready(function()
{
	refreshArrayObjectOfArrays(["modules","locationOtherApps","advancedConfig"]);

	document.addEventListener(
		"scroll",
		function (event)
		{
			onScrollShowFixedMiniBar(["advancedConfig","modules","locationOtherApps","moreAdvancedSpan"]);
		},
		true
	);

	setInterval(poll, 100);
});
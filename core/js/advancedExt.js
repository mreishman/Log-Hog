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

	document.addEventListener("resize", function() {onScrollShowFixedMiniBar(["advancedConfig","modules","locationOtherApps","settingsAdvancedAdvanced"]);});
	$( window ).resize(function() { onScrollShowFixedMiniBar(["advancedConfig","modules","locationOtherApps","settingsAdvancedAdvanced"]); });

	setInterval(poll, 100);
});
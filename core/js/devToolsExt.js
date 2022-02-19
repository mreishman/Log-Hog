var devBranchData;
var savedInnerHtmlDevBranch;
var savedInnerHtmldevConfig;
var devConfigData;
var titleOfPage = "Dev";

function checkIfChanges()
{
	if(	checkForChangesArray(["devConfig","globalAdvanced"]))
	{
		return true;
	}
	return false;
}

$( document ).ready(function()
{
	refreshArrayObjectOfArrays(["devConfig","globalAdvanced"]);

	document.addEventListener("resize", function() {onScrollShowFixedMiniBar(["devConfig","globalAdvanced"]);});
	$( window ).resize(function() { onScrollShowFixedMiniBar(["devConfig","globalAdvanced"]); });

	setInterval(poll, 100);
});
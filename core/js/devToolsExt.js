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

	ddocument.addEventListener(
		"scroll",
		function (event)
		{
			onScrollShowFixedMiniBar(["devConfig","globalAdvanced"]);
		},
		true
	);
	$( window ).resize(function() { onScrollShowFixedMiniBar(["devConfig","globalAdvanced"]); });

	setInterval(poll, 100);
});
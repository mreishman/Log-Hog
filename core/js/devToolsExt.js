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

	document.addEventListener(
		'scroll',
		function (event)
		{
			onScrollShowFixedMiniBar(["devConfig","globalAdvanced"]);
		},
		true
	);

	setInterval(poll, 100);
});
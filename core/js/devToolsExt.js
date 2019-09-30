var devBranchData;
var savedInnerHtmlDevBranch;
var savedInnerHtmldevConfig;
var devConfigData;
var titleOfPage = "Dev";

function checkIfChanges()
{
	if(	checkForChangesArray(["devBranch","devConfig"]))
	{
		return true;
	}
	return false;
}

$( document ).ready(function()
{
	refreshArrayObjectOfArrays(["devBranch","devConfig"]);

	document.addEventListener(
		'scroll',
		function (event)
		{
			onScrollShowFixedMiniBar(["devBranch","devConfig"]);
		},
		true
	);

	setInterval(poll, 100);
});
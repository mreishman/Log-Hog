var devBranchData;
var savedInnerHtmlDevBranch;
var savedInnerHtmldevConfig;
var devConfigData;
var titleOfPage = "Dev";

function checkIfChanges()
{
	if(	checkForChangesArray(["devConfig"]))
	{
		return true;
	}
	return false;
}

$( document ).ready(function()
{
	refreshArrayObjectOfArrays(["devConfig"]);

	document.addEventListener(
		'scroll',
		function (event)
		{
			onScrollShowFixedMiniBar(["devConfig"]);
		},
		true
	);

	setInterval(poll, 100);
});
var devBranchData;
var savedInnerHtmlDevBranch;
var savedInnerHtmlDevAdvanced2;
var devAdvanced2Data;
var savedInnerHtmlDevAdvanced3;
var devAdvanced3Data;
var titleOfPage = "Dev";

function checkForChange()
{
	if(	checkForChangesArray(["devBranch","devAdvanced2","devAdvanced3"]))
	{
		return true;
	}
	return false;
}

$( document ).ready(function() 
{
	refreshArrayObjectOfArrays(["devBranch","devAdvanced2","devAdvanced3"]);
	setInterval(poll, 100);
});
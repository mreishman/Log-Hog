var devBranchData;
var savedInnerHtmlDevBranch;
var savedInnerHtmlDevAdvanced2;
var devAdvanced2Data;
var savedInnerHtmlDevAdvanced3;
var devAdvanced3Data;
var titleOfPage = "Dev";

function checkForChange()
{
	if(	checkForChanges("devBranch") || checkForChanges("devAdvanced2") || checkForChanges("devAdvanced3"))
	{
		return true;
	}
	return false;
}

$( document ).ready(function() 
{
	refreshArrayObject("devBranch");
	refreshArrayObject("devAdvanced2");
	refreshArrayObject("devAdvanced3");
	setInterval(poll, 100);
});
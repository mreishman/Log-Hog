var devBranchData;
var savedInnerHtmlDevBranch;
var savedInnerHtmlDevAdvanced2;
var devAdvanced2Data;
var savedInnerHtmlDevAdvanced3;
var devAdvanced3Data;

function poll()
{
	try
	{
		if(checkForChange())
		{
			document.getElementById("devToolsLink").innerHTML = "Dev Tools*";
		}
		else
		{
			document.getElementById("devToolsLink").innerHTML = "Dev Tools";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkForChange()
{
	if(	checkForChanges("devBranch", devBranchData, "resetChangesDevBranchHeaderButton") ||
		checkForChanges("devAdvanced2", devAdvanced2Data, "resetChangesDevAdvanced2HeaderButton") ||
		checkForChanges("devAdvanced3", devAdvanced3Data, "resetChangesDevAdvanced3HeaderButton"))
	{
		return true;
	}
	return false;
}

//DEV Branch

function resetSettingsDevBranch()
{
	try
	{
		document.getElementById("devBranch").innerHTML = savedInnerHtmlDevBranch;
		devBranchData = $("#devBranch").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsDevBranch()
{
	try
	{
		devBranchData = $("#devBranch").serializeArray();
		savedInnerHtmlDevBranch = document.getElementById("devBranch").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


//Config Static

function resetSettingsDevAdvanced2()
{
	try
	{
		document.getElementById("devAdvanced2").innerHTML = savedInnerHtmlDevAdvanced2;
		devAdvanced2Data = $("#devAdvanced2").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsDevAdvanced2()
{
	try
	{
		devAdvanced2Data = $("#devAdvanced2").serializeArray();
		savedInnerHtmlDevAdvanced2 = document.getElementById("devAdvanced2").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

//Progress File

function resetSettingsDevAdvanced3()
{
	try
	{
		document.getElementById("devAdvanced3").innerHTML = savedInnerHtmlDevAdvanced3;
		devAdvanced3Data = $("#devAdvanced3").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsDevAdvanced3()
{
	try
	{
		devAdvanced3Data = $("#devAdvanced3").serializeArray();
		savedInnerHtmlDevAdvanced3 = document.getElementById("devAdvanced3").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}
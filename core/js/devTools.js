/global eventThrowException /

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
	var change = checkForChangesDevBranch();
	var change2 = checkForChangesDevAdvanced2();
	var change3 = checkForChangesDevAdvanced3();
	if(change || change2 || change3)
	{
		return true;
	}
	return false;
}

//DEV Branch

function checkForChangesDevBranch()
{
	try
	{
		if(!objectsAreSame($("#devBranch").serializeArray(), devBranchData))
		{
			document.getElementById("resetChangesDevBranchHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesDevBranchHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

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

function checkForChangesDevAdvanced2()
{
	try
	{
		if(!objectsAreSame($("#devAdvanced2").serializeArray(), devAdvanced2Data))
		{
			document.getElementById("resetChangesDevAdvanced2HeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesDevAdvanced2HeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

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

function checkForChangesDevAdvanced3()
{
	try
	{
		if(!objectsAreSame($("#devAdvanced3").serializeArray(), devAdvanced3Data))
		{
			document.getElementById("resetChangesDevAdvanced3HeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesDevAdvanced3HeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

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
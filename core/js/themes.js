function poll()
{
	try
	{
		var change = checkForChangesGeneralThemeOptions();
		var change2 = checkForFolderGroupColor();
		if(change || change2)
		{
			document.getElementById("themesLink").innerHTML = "Themes*";
		}
		else
		{
			document.getElementById("themesLink").innerHTML = "Themes";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkForChangesGeneralThemeOptions()
{
	try
	{
		if(!objectsAreSame($("#settingsColorFolderVars").serializeArray(), generalThemeOptions))
		{
			document.getElementById("resetGeneralThemeOptionsHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetGeneralThemeOptionsHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkForFolderGroupColor()
{
	try
	{
		if(!objectsAreSame($("#settingsColorFolderGroupVars").serializeArray(), folderGroupColor))
		{
			document.getElementById("resetFolderGroupColorHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetFolderGroupColorHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshGeneralThemeOptions()
{
	try
	{
		generalThemeOptions = $("#settingsColorFolderVars").serializeArray();
		savedInnerHTMLgeneralThemeOptions = document.getElementById("settingsColorFolderVars").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshFolderGroupColor()
{
	try
	{
		folderGroupColor = $("#settingsColorFolderGroupVars").serializeArray();
		savedInnerHTMLfolderGroupColor = document.getElementById("settingsColorFolderGroupVars").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function resetGeneralThemeOptions()
{
	try
	{
		document.getElementById("settingsColorFolderVars").innerHTML = savedInnerHTMLgeneralThemeOptions;
		generalThemeOptions = $("#settingsColorFolderVars").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function resetFolderGroupColor()
{
	try
	{
		document.getElementById("settingsColorFolderGroupVars").innerHTML = savedInnerHTMLfolderGroupColor;
		folderGroupColor = $("#settingsColorFolderGroupVars").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}
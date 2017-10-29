function poll()
{
	try
	{
		if(checkIfChanges())
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

function checkIfChanges()
{
	if(	checkForChanges("settingsColorFolderVars", generalThemeOptions, "resetGeneralThemeOptionsHeaderButton") ||
		 	checkForChanges("settingsColorFolderGroupVars", folderGroupColor, "resetFolderGroupColorHeaderButton"))
	{
		return true;
	}
	return false;
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
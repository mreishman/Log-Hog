var titleOfPage = "Main";


function showOrHideLogTrimSubWindow()
{
	try
	{
		var valueToSeeIfShowOrHideSubWindowLogTrim = document.getElementById("logTrimOn").value;

		if(valueToSeeIfShowOrHideSubWindowLogTrim === "true")
		{
			document.getElementById("settingsLogTrimVars").style.display = "block";
		}
		else
		{
			document.getElementById("settingsLogTrimVars").style.display = "none";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


function changeDescriptionLineSize()
{
	try
	{
		var valueForDesc = document.getElementById("logTrimTypeToggle").value;

		if (valueForDesc === "lines")
		{
			document.getElementById("logTrimTypeText").innerHTML = "Lines";
			document.getElementById("LiForlogTrimSize").style.display = "none";
		}
		else if (valueForDesc === "size")
		{
			document.getElementById("logTrimTypeText").innerHTML = "Size";
			document.getElementById("LiForlogTrimSize").style.display = "block";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}
	
function showOrHidePopupSubWindow()
{
	try
	{
		var valueForPopup = document.getElementById("popupSelect");
		var valueForVars = document.getElementById("settingsPopupVars");
		showOrHideSubWindow(valueForPopup, valueForVars);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHideUpdateSubWindow()
{
	try
	{
		var valueForPopup = document.getElementById("settingsSelect");
		var valueForVars = document.getElementById("settingsAutoCheckVars");
		showOrHideSubWindow(valueForPopup, valueForVars);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHideFilterContentSettings()
{
	try
	{
		var valueForPopup = document.getElementById("filterContentLimit");
		var valueForVars = document.getElementById("filterContentSettings");
		showOrHideSubWindow(valueForPopup, valueForVars);
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function showOrHideSubWindow(valueForPopupInner, valueForVarsInner)
{
	try
	{
		if((valueForPopupInner.value === "true") || (valueForPopupInner.value === "custom"))
		{
			valueForVarsInner.style.display = "block";
		}
		else
		{
			valueForVarsInner.style.display = "none";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


function checkIfChanges()
{
	var arrayToCheck = new Array();
	if(document.getElementById("settingsMenuVars"))
	{
		arrayToCheck.push("settingsMenuVars");
	}
	if(document.getElementById("settingsMainVars"))
	{
		arrayToCheck.push("settingsMainVars");
	}
	if(document.getElementById("settingsLogVars"))
	{
		arrayToCheck.push("settingsLogVars");
	}
	if(document.getElementById("settingsPollVars"))
	{
		arrayToCheck.push("settingsPollVars");
	}
	if(document.getElementById("settingsUpdateVars"))
	{
		arrayToCheck.push("settingsUpdateVars");
	}

	if(	checkForChangesArray(arrayToCheck))
	{
		return true;
	}
	return false;
}

$( document ).ready(function() 
{
	if(document.getElementById('logTrimTypeText'))
	{
		if(logTrimType == 'lines')
		{
			document.getElementById('logTrimTypeText').innerHTML = "Lines";
		}
		else if (logTrimType == 'size')
		{
			document.getElementById('logTrimTypeText').innerHTML = "Size";
		}
	}
	if(document.getElementById("popupSelect"))
	{
		document.getElementById("popupSelect").addEventListener("change", showOrHidePopupSubWindow, false);
	}
	if(document.getElementById("settingsSelect"))
	{
		document.getElementById("settingsSelect").addEventListener("change", showOrHideUpdateSubWindow, false);
	}
	if(document.getElementById("logTrimTypeToggle"))
	{
		document.getElementById("logTrimTypeToggle").addEventListener("change", changeDescriptionLineSize, false);
	}
	if(document.getElementById("logTrimOn"))
	{
		document.getElementById("logTrimOn").addEventListener("change", showOrHideLogTrimSubWindow, false);
	}
	if(document.getElementById("filterContentSettings"))
	{
		document.getElementById("filterContentSettings").addEventListener("change", showOrHideFilterContentSettings, false);
	}

	var arrayToRefresh = new Array();
	if(document.getElementById("settingsMainVars"))
	{
		arrayToRefresh.push("settingsMainVars");
	}
	if(document.getElementById("settingsMenuVars"))
	{
		arrayToRefresh.push("settingsMenuVars");
	}
	if(document.getElementById("settingsLogVars"))
	{
		arrayToRefresh.push("settingsLogVars");
	}
	if(document.getElementById("settingsPollVars"))
	{
		arrayToRefresh.push("settingsPollVars");
	}
	if(document.getElementById("settingsUpdateVars"))
	{
		arrayToRefresh.push("settingsUpdateVars");
	}
	refreshArrayObjectOfArrays(arrayToRefresh);
	setInterval(poll, 100);
});
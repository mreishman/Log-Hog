var savedInnerHtmlAdvancedConfig;
var advancedConfig;
var savedInnerHtmlDevAdvanced;
var devAdvancedData;
var savedInnerHtmlPollAdvanced;
var pollAdvancedData;
var savedInnerHtmlLoggingDisplay;
var loggingDisplayData;
var savedInnerHtmlJsPhpSend;
var jsPhpSendData;
var savedInnerHtmlLocationOtherApps;
var locationOtherAppsData;
var timeoutVar;

function resetSettingsPopup()
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Reset Settings?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Are you sure you want to reset all settings back to defaults?</div><div class='link' onclick='submitResetSettings();' style='margin-left:125px; margin-right:50px;margin-top:25px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
}

function revertPopup()
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Go back to previous version?</div><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>Are you sure you want to revert back to a previous version? Version: "+htmlRestoreOptions+" </div><div class='link' onclick='submitRevert();' style='margin-left:125px; margin-right:50px;margin-top:25px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
}

function submitRevert()
{
	document.getElementById("revertForm").submit();
}

function submitResetSettings()
{
	document.getElementById("resetSettings").submit();
}

function resetUpdateNotification()
{
	document.getElementById("devAdvanced2").submit();
}

//timeoutVar = setInterval(function(){updateNoNewVersionCheck();},3000);

function updateNoNewVersionCheck()
{
	try
	{
		$.getJSON("core/php/configStaticCheck.php", {}, function(data) 
		{
			if(currentVersion === data)
			{
				clearInterval(timeoutVar);
				//show saved popup
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function poll()
{
	try
	{
		if(checkIfChanges())
		{
			document.getElementById("advancedLink").innerHTML = "Advanced*";
		}
		else
		{
			document.getElementById("advancedLink").innerHTML = "Advanced";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkIfChanges()
{
	var change = checkForChangesDevAdvanced();
	var change2 = checkForChangesPollAdvanced();
	var change3 = checkForChangesLoggingDisplay();
	var change4 = checkForChangesJsPhpSend();
	var change5 = checkForChangesLocationOtherApps();
	if(change || change2 || change3 || change4 || change5)
	{
		return true;
	}
	return false;
}

//DEV ADVANCED

function checkForChangesDevAdvanced()
{
	try
	{
		if(!objectsAreSame($("#devAdvanced").serializeArray(), devAdvancedData))
		{
			document.getElementById("resetChangesDevAdvancedHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesDevAdvancedHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function resetSettingsDevAdvanced()
{
	try
	{
		document.getElementById("devAdvanced").innerHTML = savedInnerHtmlDevAdvanced;
		devAdvancedData = $("#devAdvanced").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsDevAdvanced()
{
	try
	{
		devAdvancedData = $("#devAdvanced").serializeArray();
		savedInnerHtmlDevAdvanced = document.getElementById("devAdvanced").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

//POLL ADVANCED

function checkForChangesPollAdvanced()
{
	try
	{
		if(!objectsAreSame($("#pollAdvanced").serializeArray(), pollAdvancedData))
		{
			document.getElementById("resetChangesPollAdvancedHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesPollAdvancedHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function resetSettingsPollAdvanced()
{
	try
	{
		document.getElementById("pollAdvanced").innerHTML = savedInnerHtmlPollAdvanced;
		pollAdvancedData = $("#pollAdvanced").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsPollAdvanced()
{
	try
	{
		pollAdvancedData = $("#pollAdvanced").serializeArray();
		savedInnerHtmlPollAdvanced = document.getElementById("pollAdvanced").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

//Logging Display

function checkForChangesLoggingDisplay()
{
	try
	{
		if(!objectsAreSame($("#loggingDisplay").serializeArray(), loggingDisplayData))
		{
			document.getElementById("resetChangesLoggingDisplayHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesLoggingDisplayHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function resetSettingsLoggingDisplay()
{
	try
	{
		document.getElementById("loggingDisplay").innerHTML = savedInnerHtmlLoggingDisplay;
		loggingDisplayData = $("#loggingDisplay").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsLoggingDisplay()
{
	try
	{
		loggingDisplayData = $("#loggingDisplay").serializeArray();
		savedInnerHtmlLoggingDisplay = document.getElementById("loggingDisplay").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


//JS-PHP Send

function checkForChangesJsPhpSend()
{
	try
	{
		if(!objectsAreSame($("#jsPhpSend").serializeArray(), jsPhpSendData))
		{
			document.getElementById("resetChangesJsPhpSendHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesJsPhpSendHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function resetSettingsJsPhpSend()
{
	try
	{
		document.getElementById("jsPhpSend").innerHTML = savedInnerHtmlJsPhpSend;
		jsPhpSendData = $("#jsPhpSend").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsJsPhpSend()
{
	try
	{
		jsPhpSendData = $("#jsPhpSend").serializeArray();
		savedInnerHtmlJsPhpSend = document.getElementById("jsPhpSend").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


//File Locations

function checkForChangesLocationOtherApps()
{
	try
	{
		if(!objectsAreSame($("#locationOtherApps").serializeArray(), locationOtherAppsData))
		{
			document.getElementById("resetChangesLocationOtherAppsHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesLocationOtherAppsHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function resetSettingsLocationOtherApps()
{
	try
	{
		document.getElementById("locationOtherApps").innerHTML = savedInnerHtmlLocationOtherApps;
		locationOtherAppsData = $("#locationOtherApps").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsLocationOtherApps()
{
	try
	{
		locationOtherAppsData = $("#locationOtherApps").serializeArray();
		savedInnerHtmlLocationOtherApps = document.getElementById("locationOtherApps").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


// CONFIG

function checkForChangesAdvancedConfig()
{
	try
	{
		if(!objectsAreSame($("#advancedConfig").serializeArray(), advancedConfig))
		{
			document.getElementById("resetChangesAdvancedConfigHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesAdvancedConfigHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
	}
}

function resetSettingsAdvancedConfig()
{
	try
	{
		document.getElementById("advancedConfig").innerHTML = savedInnerHtmlAdvancedConfig;
		advancedConfig = $("#advancedConfig").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsAdvancedConfig()
{
	try
	{
		advancedConfig = $("#advancedConfig").serializeArray();
		savedInnerHtmlAdvancedConfig = document.getElementById("advancedConfig").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}


// Other stuffs

function showConfigPopup()
{
	try
	{
		displayLoadingPopup();
		$.getJSON("core/php/configVersionsPopup.php", {}, function(data) 
		{
			if(data['backupCopiesPresent'])
			{
				//adjust size of popup
			}
			else
			{
				//no backups there to show, current size is file
				document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >No Backups</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>There are currently no other versions of config to restore to</div></div>";
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}
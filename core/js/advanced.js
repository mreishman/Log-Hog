var timeoutVar;
var titleOfPage = "Advanced";

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
	displayLoadingPopup();
	var data = $("#devAdvanced2").serializeArray();
	$.ajax({
        type: "post",
        url: "../core/php/settingsSaveConfigStatic.php",
        data,
        complete()
        {
          //verify saved
          timeoutVar = setInterval(function(){updateNoNewVersionCheck();},3000);
        }
      });
}

function updateNoNewVersionCheck()
{
	try
	{
		$.getJSON("../core/php/configStaticCheck.php", {}, function(data) 
		{
			if(data['version'] === data['newestVersion'])
			{
				clearInterval(timeoutVar);
				saveSuccess();
				fadeOutPopup();
				if(document.getElementById("updateNoticeImage"))
				{
					document.getElementById("updateNoticeImage").style.display = "none";
				}
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkIfChanges()
{
	if(checkForChangesArray(["devAdvanced","pollAdvanced","loggingDisplay","jsPhpSend","locationOtherApps","advancedConfig"]))
	{
		return true;
	}
	return false;
}

function showConfigPopup()
{
	try
	{
		displayLoadingPopup();
		$.getJSON("../core/php/configVersionsPopup.php", {}, function(data) 
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

function clearBackupFiles()
{
	try
	{
		displayLoadingPopup();
		$.getJSON("../core/php/clearConfigBackups.php", {}, function(data) 
		{
			if(data)
			{
				//verify that it was removed
				timeoutVar = setInterval(function(){verifyNoConfigBackups();},3000);
			}
			else
			{
				document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Error</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>There was an error deleting backups. Please ensure that the php folder has correct permissions to remove files</div></div>";
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function verifyNoConfigBackups()
{
	try
	{
		displayLoadingPopup();
		$.getJSON("../core/php/configVersionsPopup.php", {}, function(data) 
		{
			if(!data['backupCopiesPresent'])
			{
				//no backups there to show, current size is file
				clearInterval(timeoutVar);
				saveSuccess();
				fadeOutPopup();
				document.getElementById("showConfigClearButton").style.display = "none";
			}
		});
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

$( document ).ready(function() 
{
	refreshArrayObjectOfArrays(["devAdvanced","pollAdvanced","loggingDisplay","jsPhpSend","locationOtherApps","advancedConfig"]);
	setInterval(poll, 100);
});
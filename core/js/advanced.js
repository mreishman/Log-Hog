var advancedSettingsTimeoutVar;
var dirForAjaxSend = "../";

function showConfigPopup()
{
	try
	{
		displayLoadingPopup(dirForAjaxSend, "Loading Config Versions");
		$.getJSON(dirForAjaxSend + "core/php/post/configVersionsPopup.php", {}, function(data)
		{
			if(data["backupCopiesPresent"])
			{
				var heightOffset = document.getElementById("menu").offsetHeight;

				var popupHtml = "<div class='settingsHeader' >Backup List <span><a onclick=\"hidePopup();\" class=\"link\">Close</a></span></div><br><div style='width:100%; height: "+((((window.innerHeight * 0.9)-heightOffset).toFixed(2))-70)+"px; overflow-y: scroll; padding-left:10px;padding-right:10px;'><table style=\"width: 100%;\">";
				for (var i = 1; i <= data["arrayOfFiles"].length; i++)
				{
					popupHtml += "<tr><td class=\"addBorderBottom\" width=\"25%\"><div>Config"+i+"</div>";
					popupHtml += "<br><a onclick=\"restoreToVersion("+i+")\" class=\"link\"> Restore to this version</a>";
					popupHtml += "</td><td class=\"addBorderBottom\" width=\"75%\" ";
					popupHtml += "<div>"+data["arrayOfDiffs"][i-1]+"</div></tr>";
				}
				popupHtml += "</td></tr></table></div>";

				document.getElementById("popupContent").style.width = ""+((window.innerWidth * 0.9).toFixed(2))+"px";
				document.getElementById("popupContent").style.height = ""+(((window.innerHeight * 0.9)-heightOffset).toFixed(2))+"px";
				document.getElementById("popupContent").style.left = ""+((window.innerWidth * 0.05).toFixed(2))+"px";
				document.getElementById("popupContent").style.top = ""+(((window.innerHeight * 0.05)+heightOffset).toFixed(2))+"px";
				document.getElementById("popupContent").style.zIndex = 120;
				document.getElementById("popupContent").style.marginTop = 0;
				document.getElementById("popupContent").style.marginLeft = 0;

				document.getElementById("popupContentInnerHTMLDiv").innerHTML = popupHtml;
			}
			else
			{
				//no backups there to show, current size is file
				document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >No Backups</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">There are currently no other versions of config to restore to</div><div class=\"link\" onclick=\"hidePopup();\" style=\"margin-left:165px; margin-right:50px;margin-top:25px;\">Okay!</div></div>";
			}
		});
	}
	catch(e)
	{
		console.log(e);
	}
}

function restoreToVersion(restoreTo)
{
	displayLoadingPopup(dirForAjaxSend, "Loading Restore Versions");
	var urlForSend = dirForAjaxSend + "core/php/post/restoreConfig.php?format=json";
	var data = {restoreTo, formKey};
	$.ajax(
	{
		url: urlForSend,
		dataType: "json",
		data,
		type: "POST",
		success(data)
		{
            if(!handleError(dirForAjaxSend, data, "restoreConfig.php"))
            {
				saveSuccess();
				fadeOutPopup();
			}
		}
	});
}

function clearBackupFiles()
{
	try
	{
		displayLoadingPopup(dirForAjaxSend, "Clearing Files");
		$.getJSON(dirForAjaxSend + "core/php/post/clearConfigBackups.php", {}, function(data)
		{
            if(!handleError(dirForAjaxSend, data, "clearConfigBackups.php"))
            {
				if(data)
				{
					//verify that it was removed
					advancedSettingsTimeoutVar = setInterval(function(){verifyNoConfigBackups();},3000);
				}
				else
				{
					document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >Error</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">There was an error deleting backups. Please ensure that the php folder has correct permissions to remove files</div></div>";
				}
			}
		});
	}
	catch(e)
	{
		console.log(e);
	}
}

function verifyNoConfigBackups()
{
	try
	{
		displayLoadingPopup(dirForAjaxSend, "Verifying...");
		$.getJSON(dirForAjaxSend + "core/php/post/configVersionsPopup.php", {}, function(data)
		{
			if(!data["backupCopiesPresent"])
			{
				//no backups there to show, current size is file
				clearInterval(advancedSettingsTimeoutVar);
				saveSuccess();
				fadeOutPopup();
			}
		});
	}
	catch(e)
	{
		console.log(e);
	}
}

function updateListOfDisabledModules()
{
	let arrayOfModules = $("#modules select").serializeArray();
	let arrayOfModulesLength = arrayOfModules.length;
	let disabledArray = [];
	for(let i = 0; i < arrayOfModulesLength; i++)
	{
		let module = arrayOfModules[i];
		if(module.value === 'false')
		{
			disabledArray.push(module.name);
		}
	}
	$("#moduleDisabledList").val(JSON.stringify(disabledArray));
}

function selectDisabledModules()
{
	let arrayOfModules = $("#modules select").serializeArray();
	let arrayOfModulesLength = arrayOfModules.length;
	let savedArray = JSON.parse($("#moduleDisabledList").val());

	for(let i = 0; i < arrayOfModulesLength; i++)
	{
		let module = arrayOfModules[i];
		if($.inArray( module.name, savedArray ) > -1)
		{
			$("#modules [name='" + module.name + "']").val('false');
		}
		else
		{
			$("#modules [name='" + module.name + "']").val('true');
		}
	}
}


$( document ).ready(function() {
    selectDisabledModules();
});
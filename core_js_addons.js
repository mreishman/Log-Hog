var retryCount = 0;
var verifyCount = 0;
var lock = false;
var directory = "../../top/";
var action = "";
var localFolderLocation = "";
var repoName = "";
var idToSubmitStatic = "";

function updateOtherApps()
{
	if(typeof listOfAddons === "object")
	{
		var listOfAddonsKeys = Object.keys(listOfAddons);
		var lengthOfAddonKeys = listOfAddonsKeys.length;
		for(var addonCount = 0; addonCount < lengthOfAddonKeys; addonCount++)
		{
			var idForAddon = listOfAddons[listOfAddonsKeys[addonCount]]["id"];
			if($("#"+idForAddon))
			{
				$("#"+idForAddon).removeAttr('onclick');
				var installLocation = listOfAddons[listOfAddonsKeys[addonCount]]["Installed"];
				if(installLocation !== false)
				{
					if(installLocation.indexOf("../../") > -1)
					{
						installLocation = installLocation.replace("../../","./");
					}
					//it's installed, update icon
					if(addonsAsIframe)
					{
						$("#"+idForAddon).attr("onClick", "toggleIframe('"+installLocation+"','menuStatusAddon');");
					}
					else
					{
						$("#"+idForAddon).attr("onClick", "window.location.href='"+installLocation+"'");
					}
					document.getElementById(idForAddon).style.display = "block";
				}
				else
				{
					//not installed, hide icon
					document.getElementById(idForAddon).style.display = "none";
				}
			}
			resize();
		}
	}
}

function addonMonitorAction(idToSubmit)
{
	idToSubmitStatic = idToSubmit;
	var formData = $("#"+idToSubmit).serializeArray();
	var newObject = {};
	var keysInfo = Object.keys(formData);
	var keysInfoLength = keysInfo.length;
	for(var i = 0; i < keysInfoLength; i++)
	{
		newObject[formData[i]["name"]] = formData[i]["value"];
	}
	action = newObject["action"];
	localFolderLocation = newObject["localFolderLocation"];
	repoName = newObject["repoName"];
	if(action === "Downloading")
	{
		checkIfTopDirIsEmpty();
	}
	else
	{
		if($("."+idToSubmit+"RemoveHideThis"))
		{
			$("."+idToSubmit+"RemoveHideThis").hide();
		}
		if($("."+idToSubmit+"RemoveShowThis"))
		{
			$("."+idToSubmit+"RemoveShowThis").show();
		}
		removeFilesFromToppFolder(true);
	}
}

function finishedDownload()
{
	//reload page on finish?
	updateText(100);
	$.get( urlForAddonSend, function( data ) {
		$("#innerAddonSpanReplace").html(data);
		updateOtherApps();
	});
}
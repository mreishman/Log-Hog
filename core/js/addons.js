function updateOtherApps()
{
	if(typeof listOfAddons === "object")
	{
		var listOfAddonsKeys = Object.keys(listOfAddons);
		var lengthOfAddonKeys = listOfAddonsKeys.length;
		for(var addonCount = 0; addonCount < lengthOfAddonKeys; addonCount++)
		{
			var idForAddon = listOfAddons[listOfAddonsKeys[addonCount]]["id"];
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
	}
}
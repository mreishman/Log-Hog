function toggleSettingsSidebar()
{
	if(document.getElementById("settingsSideBar").style.display === "none")
	{
		let newWidth = window.innerWidth - 200;
		newWidth = adjustLogForMenuLocation(newWidth);
		if(typeof adjustLogForInfoSideBar !== "undefined")
		{
			newWidth = adjustLogForInfoSideBar(newWidth);
		}
		document.getElementById("log").style.width = newWidth+"px";
		document.getElementById("log").style.marginLeft = "200px";
		document.getElementById("settingsSideBar").style.display = "inline-block";
	}
	else
	{
		let newWidth = "100%";
		let newWidthTest = window.innerWidth;
		if(typeof adjustLogForInfoSideBar !== "undefined")
		{
			newWidthTest = adjustLogForInfoSideBar(newWidthTest);
		}
		if(newWidthTest !== window.innerWidth)
		{
			newWidthTest = adjustLogForMenuLocation(newWidthTest);
			newWidth = newWidthTest;
		}
		document.getElementById("log").style.width = newWidth;
		document.getElementById("log").style.marginLeft = "0px";
		document.getElementById("settingsSideBar").style.display = "none";
	}
	resize();
}

function adjustLogForSettingsSideBar(mainWidth)
{
	if(document.getElementById("settingsSideBar").style.display !== "none")
	{
		mainWidth -= 200;
	}
	return mainWidth;
}

function swapLayoutLetters(letter)
{
	document.getElementById("layoutVersionIndex").value = letter;
	if(logSwitchABCClearAll === "true")
	{
		unselectAllLogs();
	}
	else
	{
		unselectLogsThatAreInNewLayout();
	}
	generalUpdate();
}

function resetSelection()
{
	var currentLayout = document.getElementById("layoutVersionIndex").value;
	swapLayoutLetters(currentLayout);
}
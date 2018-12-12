function toggleSettingsSidebar()
{
	if(document.getElementById("settingsSideBar").style.display === "none")
	{
		var newWidth = window.innerWidth - 200;
		if((logMenuLocation === "left" || logMenuLocation === "right") && allLogsVisible === "true")
		{
			newWidth -= document.getElementById("menu").getBoundingClientRect().width;
		}
		document.getElementById("log").style.width = newWidth+"px";
		document.getElementById("log").style.marginLeft = "200px";
		document.getElementById("settingsSideBar").style.display = "inline-block";
	}
	else
	{
		document.getElementById("log").style.width = "100%";
		document.getElementById("log").style.marginLeft = "0px";
		document.getElementById("settingsSideBar").style.display = "none";
	}
	resize();
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
function resize()
{
	if(document.getElementById("main"))
	{
		var offsetHeight = 0;
		if(document.getElementById("menu"))
		{
			offsetHeight += document.getElementById("menu").offsetHeight;
		}
		if(document.getElementById("menu2"))
		{
			offsetHeight += document.getElementById("menu2").offsetHeight;
		}
		var heightOfMain = window.innerHeight - offsetHeight;
		var heightOfMainStyle = "height:";
		heightOfMainStyle += heightOfMain;
		heightOfMainStyle += "px";
		document.getElementById("main").setAttribute("style",heightOfMainStyle);
	}
}

function poll()
{
	try
	{
		if(checkIfChanges())
		{
			if(document.getElementById(titleOfPage+"Link"))
			{
				if(document.getElementById(titleOfPage+"Link").innerHTML !== titleOfPage+"*")
				{
					document.getElementById(titleOfPage+"Link").innerHTML = titleOfPage+"*";
				}
			}
		}
		else
		{
			if(document.getElementById(titleOfPage+"Link"))
			{
				if(document.getElementById(titleOfPage+"Link").innerHTML !== titleOfPage)
				{
					document.getElementById(titleOfPage+"Link").innerHTML = titleOfPage;
				}
			}
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function goToUrl(url)
{
	try
	{
		var goToPage = true;
		if(typeof checkIfChanges == "function")
		{
			goToPage = !checkIfChanges();
		}
		if(goToPage || popupSettingsArray.saveSettings == "false")
		{
			window.location.href = url;
		}
		else
		{
			displaySavePromptPopup(url);
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function onScrollShowFixedMiniBar(idsOfForms)
{
	if(!document.getElementById("fixedPositionMiniMenu"))
	{
		return;
	}
	var heightOne = 55;
	if(document.getElementById("menu2") !== null)
	{
		heightOne = 104;
	}
	if(document.getElementById("fixedPositionMiniMenu").style.top !== ""+heightOne+"px")
	{
		document.getElementById("fixedPositionMiniMenu").style.top = ""+heightOne+"px";
	}
	var dis = false;
	for (var i = idsOfForms.length - 1; i >= 0; i--)
	{
		var currentPos = document.getElementById(idsOfForms[i]).getBoundingClientRect().top;
		if(currentPos < (heightOne+10))
		{
			$("#fixedPositionMiniMenu").html($("#"+idsOfForms[i]+" .settingsHeader").html());
			if(document.getElementById("fixedPositionMiniMenu").style.display === "none")
			{
				document.getElementById("fixedPositionMiniMenu").style.display = "block";
			}
			dis = true;
			break;
		}
	}
	if(!dis)
	{
		$("#fixedPositionMiniMenu").html("");
		if(document.getElementById("fixedPositionMiniMenu").style.display !== "none")
		{
			document.getElementById("fixedPositionMiniMenu").style.display = "none";
		}
	}
}

$(document).ready(function()
{
	resize();
	window.onresize = resize;

});
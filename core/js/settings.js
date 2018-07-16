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

var idForm = "";
var countForVerifySave = 0;
var pollCheckForUpdate;
var data;
var idForFormMain;
var arrayObject = {};
var innerHtmlObject = {};
var countForVerifySaveSuccess = 0;

function saveAndVerifyMain(idForForm)
{
	idForFormMain = idForForm;
	idForm = "#"+idForForm;
	displayLoadingPopup(baseUrl); //displayLoadingPopup is defined in popup.php
	data = $(idForm).serializeArray();
	$.ajax({
        type: "post",
        url: "../core/php/settingsSaveAjax.php",
        data,
        success(data)
        {
			if(data !== "true")
			{
				window.location.href = "../error.php?error="+data+"&page=core/php/settingsSaveAjax.php";
			}
		},
        complete()
        {
          //verify saved
          verifySaveTimer();
        }
      });

}

function verifySaveTimer()
{
	countForVerifySave = 0;
	pollCheckForUpdate = setInterval(timerVerifySave,3000);
}

function timerVerifySave()
{
	countForVerifySave++;
	if(countForVerifySave < 20)
	{
		var urlForSend = "../core/php/saveCheck.php?format=json";
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				if(data === true)
				{
					countForVerifySaveSuccess++;
					if(countForVerifySaveSuccess >= successVerifyNum)
					{
						clearInterval(pollCheckForUpdate);
						countForVerifySaveSuccess = 0;
						saveVerified();
					}
				}
				else
				{
					countForVerifySaveSuccess = 0;
				}
			},
		});
	}
	else
	{
		clearInterval(pollCheckForUpdate);
		saveError();
	}
}

function saveVerified()
{
	if(idForFormMain === "welcomeForm")
	{
		//do nothing
	}
	else if(idForFormMain === "settingsMainWatch")
	{
		refreshSettingsWatchList();
	}
	else
	{
		refreshArrayObject(idForFormMain);
	}

	if(idForFormMain === "settingsMainVars")
	{
		if(document.getElementsByName("themesEnabled")[0].value === "true")
		{
			document.getElementById("ThemesLink").style.display = "inline-block";
		}
		else
		{
			document.getElementById("ThemesLink").style.display = "none";
		}
	}
	else if(idForFormMain === "devAdvanced")
	{
		if(document.getElementsByName("developmentTabEnabled")[0].value === "true")
		{
			document.getElementById("DevLink").style.display = "inline-block";
		}
		else
		{
			document.getElementById("DevLink").style.display = "none";
		}
	}

	saveSuccess();
	
	if(idForFormMain.includes("themeMainSelection"))
	{
		
		window.location.href = "../core/php/template/upgradeTheme.php";
	}
	else if(idForFormMain === "settingsColorFolderGroupVars" || idForFormMain === "settingsColorFolderVars" || idForFormMain === "welcomeForm")
	{
		location.reload();
	}
	else
	{
		fadeOutPopup();
	}
}

function saveSuccess()
{
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Saved Changes!</div><br><br><div style='width:100%;text-align:center;'> "+saveVerifyImage+" </div>";
}

function saveError()
{
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error</div><br><br><div style='width:100%;text-align:center;'> An Error Occured While Saving... </div>";
	fadeOutPopup();
}

function fadeOutPopup()
{
	setTimeout(hidePopup, 1000);
}

function objectsAreSameInner(x, y) 
{
	try
	{
		for(var propertyName in x) 
		{
			if( (typeof(x) === "undefined") || (typeof(y) === "undefined") || x[propertyName] !== y[propertyName])
			{
				return false;
			}
		}
		return true;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function objectsAreSame(x, y) 
{
	try
	{
		var returnValue = true;
		for (var i = x.length - 1; i >= 0; i--) 
		{
			if(!objectsAreSameInner(x[i],y[i]))
			{
				returnValue = false;
				break;
			}
		}
		return returnValue;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkForChangesArray(idsOfObjects)
{
	var returnValue = false;
	for (var i = idsOfObjects.length - 1; i >= 0; i--)
	{
		var newValue = checkForChanges(idsOfObjects[i]);
		if(!returnValue)
		{
			returnValue = newValue;
		}
	}
	return returnValue;
}

function checkForChanges(idOfObject)
{
	try
	{
		if(!objectsAreSame($("#"+idOfObject).serializeArray(), arrayObject[idOfObject]))
		{
			document.getElementById(idOfObject+"ResetButton").style.display = "inline-block";
			if(document.getElementById("setupButtonContinue"))
			{
				document.getElementById("setupButtonContinue").style.display = "none";
				document.getElementById("setupButtonDisabled").style.display = "inline-block";

			}
			return true;
		}
		else
		{
			if(document.getElementById(idOfObject+"ResetButton"))
			{
				document.getElementById(idOfObject+"ResetButton").style.display = "none";
			}
			if(document.getElementById("setupButtonContinue"))
			{
				document.getElementById("setupButtonContinue").style.display = "inline-block";
				document.getElementById("setupButtonDisabled").style.display = "none";
			}
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshArrayObjectOfArrays(idsOfForms)
{
	for (var i = idsOfForms.length - 1; i >= 0; i--)
	{
		refreshArrayObject(idsOfForms[i]);
	}
}

function refreshArrayObject(idOfForm)
{
	try
	{
		arrayObject[idOfForm] = $("#"+idOfForm).serializeArray();
		innerHtmlObject[idOfForm] = document.getElementById(idOfForm).innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function resetArrayObject(idOfForm)
{
	try
	{
		document.getElementById(idOfForm).innerHTML = innerHtmlObject[idOfForm];
		arrayObject[idOfForm] = $("#"+idOfForm).serializeArray();
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
		document.getElementById("fixedPositionMiniMenu").style.top = ""+heightOne+"px"
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
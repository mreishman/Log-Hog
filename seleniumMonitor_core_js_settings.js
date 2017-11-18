function resize()
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

var idForm = "";
var countForVerifySave = 0;
var pollCheckForUpdate;
var data;
var idForFormMain;
var arrayObject = {};
var innerHtmlObject = {};

function saveAndVerifyMain(idForForm)
{
	idForFormMain = idForForm;
	idForm = "#"+idForForm;
	displayLoadingPopup(baseUrl+"img/"); //displayLoadingPopup is defined in popup.html
	data = $(idForm).serializeArray();
	$.ajax({
        type: "post",
        url: "../core/php/settingsSaveAjax.php",
        data,
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
			data: data,
			type: "POST",
			success(data)
			{
				if(data === true)
				{
					clearInterval(pollCheckForUpdate);
					saveVerified();
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
	if(idForFormMain === "settingsMainWatch")
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
			document.getElementById("themesLink").style.display = "inline-block";
		}
		else
		{
			document.getElementById("themesLink").style.display = "none";
		}
	}
	else if(idForFormMain === "devAdvanced")
	{
		if(document.getElementsByName("developmentTabEnabled")[0].value === "true")
		{
			document.getElementById("devToolsLink").style.display = "inline-block";
		}
		else
		{
			document.getElementById("devToolsLink").style.display = "none";
		}
	}

	saveSuccess();
	
	if(idForFormMain.includes("themeMainSelection"))
	{
		
		window.location.href = "../core/php/template/upgradeTheme.php";
	}
	else if(idForFormMain === "settingsColorFolderGroupVars" || idForFormMain === "settingsColorFolderVars")
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
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Saved Changes!</div><br><br><div style='width:100%;text-align:center;'> <img src='"+baseUrl+"img/greenCheck.png' height='50' width='50'> </div>";
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
			return true;
		}
		else
		{
			document.getElementById(idOfObject+"ResetButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e)
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
			document.getElementById(titleOfPage+"Link").innerHTML = titleOfPage+"*";
		}
		else
		{
			document.getElementById(titleOfPage+"Link").innerHTML = titleOfPage;
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

$(document).ready(function()
{
	resize();
	window.onresize = resize;

});
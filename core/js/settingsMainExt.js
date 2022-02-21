var titleOfPage = "Log-Hog | Settings";
var urlModifierForAjax = "";
var arrayOfDataSettings = [];

function checkIfChanges()
{
	if(	checkForChangesArray(arrayOfDataSettings))
	{
		return true;
	}
	return false;
}

function openTab(className)
{
	var goToPage = true;
	if(typeof checkIfChanges == "function")
	{
		goToPage = !checkIfChanges();
	}
	if(goToPage || popupSettingsArray.saveSettings == "false")
	{
		actuallyOpenTab(className);
	}
	else
	{
		displaySavePromptPopup(url);
	}
}

function actuallyOpenTab(className)
{
	$(".mainMenuHeader").removeClass("active");
	$(".mainMenuHeader." + className).addClass("active");
	$(".settingsSecondaryHeaders").hide();

	$(".settingsSecondaryHeaders." + className).show();
	$(".settingsSecondaryHeaders." + className+":first").click();
}

function toggleSettingSection(data)
{
	$(".settingsSecondaryHeaders").removeClass("active");
	$("#" + data.id + "Menu").addClass("active");
	$(".fullScreenMenuSettingsFormDiv").hide();
	document.getElementById(data.id).style.display = "block";
	if(data.formId != "false")
	{
		arrayOfDataSettings = [data.formId];
		idArrayForHeader = [data.formId];
	}
}

function openSettingsSectionFromLink(id, className)
{
	$(".mainMenuHeader").removeClass("active");
	$(".mainMenuHeader." + className).addClass("active");
	$(".settingsSecondaryHeaders").hide();

	$(".settingsSecondaryHeaders." + className).show();
	if (id !== "")
	{
		$("#" + id + "Menu").click();
	}
	else
	{
		$(".settingsSecondaryHeaders." + className+":first").click();
	}
}

function headerScrollLocal()
{
	onScrollShowFixedMiniBar(idArrayForHeader);
}

$( document ).ready(function()
{
	settingsArrayRefresh();

	document.addEventListener(
		"scroll",
		function (event)
		{
			headerScrollLocal();
		},
		true
	);
	$( window ).resize(function() { headerScrollLocal(); });

	if (typeof poll !== "undefined")
	{
		setInterval(poll, 100);
	}

	openSettingsSectionFromLink(openTabId, openTabClass)
	resize();
});
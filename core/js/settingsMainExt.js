var titleOfPage = "Log-Hog | Settings";
var urlModifierForAjax = "";
var arrayOfDataSettings = [];
var globalForcePageNavigate = false;

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
		displaySavePromptPopupIndex("actuallyOpenTab(\""+className+"\");");
	}
}

function actuallyOpenTab(className)
{
	globalForcePageNavigate = true;
	$(".mainMenuHeader").removeClass("active");
	$(".mainMenuHeader." + className).addClass("active");
	$(".settingsSecondaryHeaders").hide();

	$(".settingsSecondaryHeaders." + className).not(".hiddenMenu").show();
	$(".settingsSecondaryHeaders." + className+":first").click();
}

function toggleSettingSection(data)
{
	var goToPage = true;
	if(typeof checkIfChanges == "function")
	{
		goToPage = !checkIfChanges();
	}
	if(globalForcePageNavigate || goToPage || popupSettingsArray.saveSettings == "false")
	{
		actuallyToggleSettingsSection(data);
	}
	else
	{
		displaySavePromptPopupIndex("actuallyToggleSettingsSection("+JSON.stringify(data)+");");
	}
}

function actuallyToggleSettingsSection(data)
{
	globalForcePageNavigate = false;
	$(".settingsSecondaryHeaders").removeClass("active");
	$("#" + data.id + "Menu").addClass("active");
	$(".fullScreenMenuSettingsFormDiv").hide();
	document.getElementById(data.id).style.display = "block";
	if(data.formId != "false")
	{
		arrayOfDataSettings = [data.formId];
		idArrayForHeader = [data.formId];
	}
	else
	{
		arrayOfDataSettings = [];
		idArrayForHeader = [];
	}
	headerScrollLocal();
	resize();
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
var expFeaturesData;
var savedInnerHtmlExpFeatures;
var titleOfPage = "Experimental-Features";

function checkForChange()
{
	if(checkForChanges("expFeatures"))
	{
		return true;
	}
	return false;
}

function goToUrl(url)
{
	if(!checkForChange() || popupSettingsArray.saveSettings == "false")
	{
		window.location.href = url;
	}
	else
	{
		displaySavePromptPopup(url);
	}
}

$( document ).ready(function() 
{
	refreshArrayObject("expFeatures");
	setInterval(poll, 100);
});
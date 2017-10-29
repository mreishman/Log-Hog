var expFeaturesData;
var savedInnerHtmlExpFeatures;


function poll()
{
	try
	{
		if(checkForChange())
		{
			document.getElementById("experimentalfeaturesLink").innerHTML = "Experimental Features*";
		}
		else
		{
			document.getElementById("experimentalfeaturesLink").innerHTML = "Experimental Features";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function checkForChange()
{
	if(checkForChanges("expFeatures", expFeaturesData, "resetChangesExpFeaturesHeaderButton"))
	{
		return true;
	}
	return false;
}

//expFeatures

function resetSettingsExpFeatures()
{
	try
	{
		document.getElementById("expFeatures").innerHTML = savedInnerHtmlExpFeatures;
		expFeaturesData = $("#expFeatures").serializeArray();
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function refreshSettingsExpFeatures()
{
	try
	{
		expFeaturesData = $("#expFeatures").serializeArray();
		savedInnerHtmlExpFeatures = document.getElementById("expFeatures").innerHTML;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}
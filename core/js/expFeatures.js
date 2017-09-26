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
	var change = checkForChangesExpFeatures();
	if(change)
	{
		return true;
	}
	return false;
}

//expFeatures

function checkForChangesExpFeatures()
{
	try
	{
		if(!objectsAreSame($("#expFeatures").serializeArray(), expFeaturesData))
		{
			document.getElementById("resetChangesExpFeaturesHeaderButton").style.display = "inline-block";
			return true;
		}
		else
		{
			document.getElementById("resetChangesExpFeaturesHeaderButton").style.display = "none";
			return false;
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

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
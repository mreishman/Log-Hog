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

$( document ).ready(function() 
{
	refreshArrayObject("expFeatures");
	setInterval(poll, 100);
});
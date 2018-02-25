function resetSettingsPopup()
{
	showPopup();
	var popupString = "<div class='settingsHeader' >Reset Settings?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>";
	popupString += "<form id=\"resetSettings\">";
	popupString +=  "Option to reset: ";
	popupString += "<select name=\"resetConfigValuesBackToDefault\">";
	popupString +=  "<option selected value=\"all\">All</option>";
	popupString +=  "<option value=\"justWatch\">Just Watchlist</option>";
	popupString +=  "<option value=\"allButWatch\">All But Watchlist</option>";
	popupString +=  "</select></form>";
	popupString +=  "</div><div class='link' onclick='resetSettingsConfirmPopup();' style='margin-left:125px; margin-right:50px;margin-top:25px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = popupString;
}

function submitResetSettings()
{
	document.getElementById("resetSettings").submit();
}
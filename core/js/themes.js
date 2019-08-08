var titleOfPage = "Themes";
var externalThemeNumber = 1;
var themeName = "";
var timeoutVar = null;
var numberOfStepsForThemeCreate = 12;
var urlForSendUpdateAction = themeDirMod+"core/php/performSettingsInstallUpdateAction.php?format=json";

function deleteTheme(themeName)
{
	displayLoadingPopup("../","Removing Theme");
	themeName = themeName;
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "removeUnZippedFiles", removeDir: true, locationOfFilesThatNeedToBeRemovedRecursivally: themeName, formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			//verify folder is removed
			timeoutVar = setInterval(function(){verifyThemeRemoved();},3000);
		}
	});
}

function verifyThemeRemoved()
{
	displayLoadingPopup("../","verifying Removal");
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "verifyFileIsThere", fileLocation: themeName, isThere: false, formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			else if(data === true)
			{
				clearInterval(timeoutVar);
				location.reload();
			}
		}
	});
}

function newThemePopup(themeNum)
{
	externalThemeNumber = themeNum;
	showPopup();
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >Save custom theme ("+themeNum+")</div><br><div style=\"width:100%;text-align:center;\"> Insert name for new custom theme: <br> <input id=\"newCustomThemeName\" type=\"text\" value=\"Custom-Theme-"+themeNum+"\"> <br> <div class=\"link\" onclick=\"saveCustomTheme();\" style=\"margin-right:50px;margin-top:25px;\">Save</div><div onclick=\"hidePopup();\" class=\"link\">Cancel</div> </div>";
}

function saveCustomTheme()
{
	themeName = document.getElementById("newCustomThemeName").value;
	displayLoadingPopup();
	document.getElementById("popupHeaderText").innerHTML = "creating /Theme/ folder (step 1 of "+numberOfStepsForThemeCreate+")";
	//create folder
	var data = {action: "createFolder", newDir: "../../local/"+currentTheme+"/Themes/", formKey};
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data,
		type: "POST",
		success()
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			timeoutVar = setInterval(function(){verifyFolder();},3000);
		}
	});
}

function verifyFolder()
{
	//verify folder
	document.getElementById("popupHeaderText").innerHTML = "verifying /Theme/ folder (step 2 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "verifyDirIsThere", dirLocation: "../../local/"+currentTheme+"/Themes/", formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			else if(data === true)
			{
				clearInterval(timeoutVar);
				saveCustomThemeCustomFolder();
			}
		}
	});
}

function saveCustomThemeCustomFolder()
{
	displayLoadingPopup();
	//create folder
	document.getElementById("popupHeaderText").innerHTML = "creating new folder (step 3 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "createFolder", newDir: "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber, formKey},
		type: "POST",
		success()
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			timeoutVar = setInterval(function(){verifyFolderInFolder();},3000);
		}
	});
}


function verifyFolderInFolder()
{
	//verify folder
	document.getElementById("popupHeaderText").innerHTML = "verifying new folder (step 4 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "verifyDirIsThere", dirLocation: "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber, formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			else if(data === true)
			{
				clearInterval(timeoutVar);
				createNewFiles();
			}
		}
	});
}

function createNewFiles()
{
	//default settings file
	document.getElementById("popupHeaderText").innerHTML = "Creating config file (step 5 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: themeDirMod+"core/php/saveCustomThemeDefaults.php?format=json",
		dataType: "json",
		data: {themeNumber: externalThemeNumber, displayName: themeName, formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"]+"&page=saveCustomThemeDefaults.php";
            }
			else if(data === true)
			{
				timeoutVar = setInterval(function(){verifyNewFiles();},3000);
			}
		}
	});
}

function verifyNewFiles()
{
	document.getElementById("popupHeaderText").innerHTML = "verifying config file (step 6 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "verifyFileIsThere", fileLocation: "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/defaultSetting.php", isThere: true, formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			else if(data === true)
			{
				clearInterval(timeoutVar);
				createImageFolder();
			}
		}
	});
}

function createImageFolder()
{
	document.getElementById("popupHeaderText").innerHTML = "creating new image folder (step 7 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "createFolder", newDir: "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/img", formKey},
		type: "POST",
		success()
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			timeoutVar = setInterval(function(){verifyImageFolder();},3000);
		}
	});
}

function verifyImageFolder()
{
	document.getElementById("popupHeaderText").innerHTML = "verifying /img/ folder (step 8 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "verifyDirIsThere", dirLocation: "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/img", formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			else if(data === true)
			{
				clearInterval(timeoutVar);
				createTemplateFolder();
			}
		}
	});
}

function createTemplateFolder()
{
	document.getElementById("popupHeaderText").innerHTML = "creating new template folder (step 9 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "createFolder", newDir: "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/template", formKey},
		type: "POST",
		success()
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			timeoutVar = setInterval(function(){verifyTemplateFolder();},3000);
		}
	});
}

function verifyTemplateFolder()
{
	document.getElementById("popupHeaderText").innerHTML = "verifying /template/ folder (step 10 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "verifyDirIsThere", dirLocation: "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/template", formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			else if(data === true)
			{
				clearInterval(timeoutVar);
				copyFiles();
			}
		}
	});
}

function copyFiles()
{
	//copy images to new folder, as well as template css to new folder
	document.getElementById("popupHeaderText").innerHTML = "Copying base images to theme folder (step 11 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: themeDirMod+"core/php/copyImagesToNewTheme.php?format=json",
		dataType: "json",
		data: {themeNumber: externalThemeNumber, formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
			{
				window.location.href = themeDirMod + "error.php?error="+data["error"]+"&page=copyImagesToNewTheme.php";
			}
			else if(data === true)
			{
				timeoutVar = setInterval(function(){verifyCopiedFiles();},3000);
			}
		}
	});
}

function verifyCopiedFiles()
{
	document.getElementById("popupHeaderText").innerHTML = "verifying config file (step 12 of "+numberOfStepsForThemeCreate+")";
	$.ajax({
		url: urlForSendUpdateAction,
		dataType: "json",
		data: {action: "verifyFileIsThere", fileLocation: "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/img/Gear.png", isThere: true, formKey},
		type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = themeDirMod + "error.php?error="+data["error"];
            }
			else if(data === true)
			{
				clearInterval(timeoutVar);
				saveAndVerifyMain("themeMainSelectionCustomNew");
			}
		}
	});
}
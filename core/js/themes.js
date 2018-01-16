var titleOfPage = "Themes";
var externalThemeNumber = 1;
var themeName = "";
var timeoutVar = null;
var numberOfStepsForThemeCreate = 6;

function checkIfChanges()
{
	if(	checkForChangesArray(["settingsColorFolderVars","settingsColorFolderGroupVars"]))
	{
		return true;
	}
	return false;
}

function deleteTheme(themeName)
{
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'removeUnZippedFiles', removeDir: true, locationOfFilesThatNeedToBeRemovedRecursivally: themeName};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		complete()
		{
			//verify folder is removed
		}
	});
}

function newThemePopup(themeNum)
{
	externalThemeNumber = themeNum;
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Save custom theme ("+themeNum+")</div><br><div style='width:100%;text-align:center;'> Insert name for new custom theme: <br> <input id=\"newCustomThemeName\" type=\"text\" value=\"Custom-Theme-"+themeNum+"\"> <br> <div class='link' onclick='saveCustomTheme();' style='margin-right:50px;margin-top:25px;'>Save</div><div onclick='hidePopup();' class='link'>Cancel</div> </div>";
}

function saveCustomTheme()
{
	themeName = document.getElementById("newCustomThemeName").value;
	displayLoadingPopup();
	document.getElementById("popupHeaderText").innerHTML = "creating /Theme/ folder (step 1 of "+numberOfStepsForThemeCreate+")";
	//create folder
	var folderPath = "../../local/"+currentTheme+"/Themes/";
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'createFolder', newDir: folderPath};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		success()
		{
			timeoutVar = setInterval(function(){verifyFolder();},3000);
		}
	});
}

function verifyFolder()
{
	//verify folder
	document.getElementById("popupHeaderText").innerHTML = "verifying /Theme/ folder (step 2 of "+numberOfStepsForThemeCreate+")";
	var folderPath = "../../local/"+currentTheme+"/Themes/";
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'verifyDirIsThere', dirLocation: folderPath};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		success(data)
		{
			if(data === true)
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
	var folderPath = "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber;
	document.getElementById("popupHeaderText").innerHTML = "creating new folder (step 3 of "+numberOfStepsForThemeCreate+")";
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'createFolder', newDir: folderPath};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		success()
		{
			verifyFolderInFolder();
		}
	});
}


function verifyFolderInFolder()
{
	//verify folder
	document.getElementById("popupHeaderText").innerHTML = "verifying new folder (step 4 of "+numberOfStepsForThemeCreate+")";
	var folderPath = "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber;
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'verifyDirIsThere', dirLocation: folderPath};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		success(data)
		{
			if(data === true)
			{
				clearInterval(timeoutVar);
				createNewFiles();
			}
		}
	});
}

function createNewFiles()
{

}

function verifyNewFiles()
{

}

$( document ).ready(function() 
{
	refreshArrayObjectOfArrays(["settingsColorFolderVars","settingsColorFolderGroupVars"]);
	setInterval(poll, 100);
});
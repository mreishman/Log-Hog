var titleOfPage = "Themes";
var externalThemeNumber = 1;
var themeName = "";
var timeoutVar = null;
var numberOfStepsForThemeCreate = 12;

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
	displayLoadingPopup();
	themeName = themeName;
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'removeUnZippedFiles', removeDir: true, locationOfFilesThatNeedToBeRemovedRecursivally: themeName};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		success(data)
		{
			//verify folder is removed
			timeoutVar = setInterval(function(){verifyThemeRemoved();},3000);
		}
	});
}

function verifyThemeRemoved()
{
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'verifyFileIsThere', fileLocation: themeName, isThere: false};
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
				location.reload();
			}
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
			timeoutVar = setInterval(function(){verifyFolderInFolder();},3000);
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
	//default settings file
	document.getElementById("popupHeaderText").innerHTML = "Creating config file (step 5 of "+numberOfStepsForThemeCreate+")";
	var themeNumber = externalThemeNumber;
	var displayName = themeName;
	var urlForSend = '../core/php/saveCustomThemeDefaults.php?format=json';
	var data = {themeNumber, displayName};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		success(data)
		{
			if(data === true)
			{
				timeoutVar = setInterval(function(){verifyNewFiles();},3000);
			}
		}
	});
}

function verifyNewFiles()
{
	document.getElementById("popupHeaderText").innerHTML = "verifying config file (step 6 of "+numberOfStepsForThemeCreate+")";
	var filePath = "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/defaultSetting.php";
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'verifyFileIsThere', fileLocation: filePath, isThere: true};
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
				createImageFolder();
			}
		}
	});
}

function createImageFolder()
{
	var folderPath = "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/img";
	document.getElementById("popupHeaderText").innerHTML = "creating new image folder (step 7 of "+numberOfStepsForThemeCreate+")";
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'createFolder', newDir: folderPath};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		success()
		{
			timeoutVar = setInterval(function(){verifyImageFolder();},3000);
		}
	});
}

function verifyImageFolder()
{
	document.getElementById("popupHeaderText").innerHTML = "verifying /img/ folder (step 8 of "+numberOfStepsForThemeCreate+")";
	var folderPath = "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/img";
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
				createTemplateFolder();
			}
		}
	});
}

function createTemplateFolder()
{
	var folderPath = "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/template";
	document.getElementById("popupHeaderText").innerHTML = "creating new template folder (step 9 of "+numberOfStepsForThemeCreate+")";
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'createFolder', newDir: folderPath};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		success()
		{
			timeoutVar = setInterval(function(){verifyTemplateFolder();},3000);
		}
	});
}

function verifyTemplateFolder()
{
	document.getElementById("popupHeaderText").innerHTML = "verifying /template/ folder (step 10 of "+numberOfStepsForThemeCreate+")";
	var folderPath = "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/template";
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
				copyFiles();
			}
		}
	});
}

function copyFiles()
{
	//copy images to new folder, as well as template css to new folder
	document.getElementById("popupHeaderText").innerHTML = "Copying base images to theme folder (step 11 of "+numberOfStepsForThemeCreate+")";
	var themeNumber = externalThemeNumber;
	var urlForSend = '../core/php/copyImagesToNewTheme.php?format=json';
	var data = {themeNumber};
	$.ajax({
		url: urlForSend,
		dataType: 'json',
		data,
		type: 'POST',
		success(data)
		{
			if(data === true)
			{
				timeoutVar = setInterval(function(){verifyCopiedFiles();},3000);
			}
		}
	});
}

function verifyCopiedFiles()
{
	document.getElementById("popupHeaderText").innerHTML = "verifying config file (step 12 of "+numberOfStepsForThemeCreate+")";
	var filePath = "../../local/"+currentTheme+"/Themes/Custom-Theme-"+externalThemeNumber+"/img/Gear.png";
	var urlForSend = '../core/php/performSettingsInstallUpdateAction.php?format=json';
	var data = {action: 'verifyFileIsThere', fileLocation: filePath, isThere: true};
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
				saveAndVerifyMain('themeMainSelectionCustomNew');
			}
		}
	});
}



$( document ).ready(function() 
{
	refreshArrayObjectOfArrays(["settingsColorFolderVars","settingsColorFolderGroupVars"]);
	setInterval(poll, 100);
});
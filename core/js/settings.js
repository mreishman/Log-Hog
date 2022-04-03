var arrayObject = {};
var countForVerifySave = 0;
var countForVerifySaveSuccess = 0;
var data;
var dirForAjaxSend = "../";
var idForFormMain;
var idForm = "";
var innerHtmlObject = {};
var pollCheckForUpdate;

function showOrHideSubWindow(valueForPopupInner, valueForVarsInner, valueToCompare)
{
	try
	{
		let display = "none";
		if(valueForPopupInner.value === valueToCompare)
		{
			display = "block";
		}
		valueForVarsInner.style.display = display;
	}
	catch(e)
	{
		console.log(e);
	}
}


function saveAndVerifyMain(idForForm)
{
	idForFormMain = idForForm;
	idForm = "#"+idForForm;
	displayLoadingPopup(dirForAjaxSend, "Saving...");
	data = $(idForm).serializeArray();
	data.push({name: "formKey", value: formKey});
	$.ajax({
				type: "post",
				url: dirForAjaxSend+"core/php/post/settingsSaveAjax.php",
				data,
				success(data)
				{
					handleErrorWithTruthCheck(dirForAjaxSend, data, "settingsSaveAjax.php");
		},
				complete()
				{
					//verify saved
					verifySaveTimer();
				}
			});
}

function verifySaveTimer()
{
	countForVerifySave = 0;
	pollCheckForUpdate = setInterval(timerVerifySave,3000);
}

function timerVerifySave()
{
	displayLoadingPopup(dirForAjaxSend, "Verifying Save...");
	countForVerifySave++;
	if(countForVerifySave < 20)
	{
		var urlForSend = dirForAjaxSend+"core/php/post/saveCheck.php?format=json";
		data["formKey"] = formKey;
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
							if(!handleError(dirForAjaxSend, data, "saveCheck.php"))
							{
					if(data === true)
					{
						countForVerifySaveSuccess++;
						if(countForVerifySaveSuccess >= successVerifyNum)
						{
							clearInterval(pollCheckForUpdate);
							countForVerifySaveSuccess = 0;
							saveVerified();
						}
					}
					else
					{
						countForVerifySaveSuccess = 0;
					}
				}
			},
		});
	}
	else
	{
		clearInterval(pollCheckForUpdate);
		saveError();
	}
}

function saveVerified()
{
	if(idForFormMain === "welcomeForm")
	{
		//do nothing
	}
	else if(idForFormMain === "settingsMainWatch")
	{
		refreshSettingsWatchList();
	}
	else
	{
		refreshArrayObject(idForFormMain);
	}

	if(idForFormMain === "settingsMainVars" && document.getElementsByName("themesEnabled")[0])
	{
		if(document.getElementsByName("themesEnabled")[0].value === "true")
		{
			if(document.getElementById("ThemesLink"))
			{
				document.getElementById("ThemesLink").style.display = "block";
			}
		}
		else
		{
			if(document.getElementById("ThemesLink"))
			{
				document.getElementById("ThemesLink").style.display = "none";
			}
		}
	}
	else if(idForFormMain === "devBranch")
	{
		if($("[name='branchSelected']"))
		{
			if($("[name='enableDevBranchDownload']")[0].value === "true")
			{
				if($("[name='branchSelected']")[0].options.length === 2)
				{
					//append
					$("[name='branchSelected']").append("<option value='dev'>Dev</option>")
				}
			}
			else
			{
				if($("[name='branchSelected']")[0].options.length === 3)
				{
					//remove
					$("[name='branchSelected'] option[value='dev']").remove();
				}
			}
		}
	}
	else if(idForFormMain === "advancedConfig")
	{
		if($("[name='enablePollTimeLogging']"))
		{
			if($("[name='enablePollTimeLogging']")[0].value === "false")
			{
				$("#loggTimerPollStyle").hide();
			}
			else
			{
				$("#loggTimerPollStyle").show();
			}
		}
	}
	else if(idForFormMain === "settingsWatchlistVars")
	{
		if($("[name='logShowMoreOptions']"))
		{
			if($("[name='logShowMoreOptions']")[0].value === "false")
			{
				$(".condensed").hide();
				document.getElementById("condensedLink").innerHTML = "Show More Options";
			}
			else
			{
				$(".condensed").show();
				document.getElementById("condensedLink").innerHTML = "Show Condensed Options";
			}
		}
	}
	else if(idForFormMain === "settingsMultiLogVars")
	{
		if($("#windowConfig"))
		{
			if($("[name='windowConfig']")[0].value !== $("#windowConfig")[0].value)
			{
				$("#windowConfig")[0].value = $("[name='windowConfig']")[0].value;
				setTimeout(function() {
					generateWindowDisplay();
				}, 2);
			}
		}
	}
	else if(idForFormMain === "settingsOneLogVars")
	{
		if($("#oneLogVisible"))
		{
			if($("[name='oneLogVisible']")[0].value !== $("#oneLogVisible")[0].value)
			{
				$("#oneLogVisible")[0].value = $("[name='oneLogVisible']")[0].value;
				setTimeout(function() {
					toggleVisibleOneLog();
				}, 2);
			}
		}
	}
	else if(idForFormMain === "settingsLogFormatVars")
	{
		if($("#logFormatFileEnable") && $("#logFormatFileEnable")[0].value === "true")
		{
			if(typeof formatFileLine !== "function" && typeof script === "function")
			{
				script("core/js/formatFile.js");
			}
		}
		if($("#logFormatPhpEnable") && $("#logFormatPhpEnable")[0].value === "true")
		{
			if(typeof formatPhpMessage !== "function" && typeof script === "function")
			{
				script("core/js/formatPhp.js");
			}
		}
		if($("#logFormatReportEnable") && $("#logFormatReportEnable")[0].value === "true")
		{
			if(typeof formatReportMessage !== "function" && typeof script === "function")
			{
				script("core/js/formatReport.js");
			}
		}
		if($("#logFormatJsObjectEnable") && $("#logFormatJsObjectEnable")[0].value === "true")
		{
			if(typeof formatJsonMessage !== "function" && typeof script === "function")
			{
				script("core/js/formatJsObject.js");
			}
		}
	}
	else if(idForFormMain === "settingsLogVars")
	{
		if(typeof flashTitle !== "function"	&& typeof script === "function" && $("[name='flashTitleUpdateLog']")[0].value === "true")
		{
			script("core/js/titleFlash.js");
		}
	}
	else if(idForFormMain === "settingsMenuVars")
	{
		if($("#clearNotificationsImageHolder"))
		{
			if($("[name='hideClearAllNotifications']")[0].value === "false")
			{
				$("#clearNotificationsImageHolder").show();
			}
			else
			{
				$("#clearNotificationsImageHolder").hide()
			}
		}
		if($("#groupsInHeader"))
		{
			if($("[name='groupDropdownInHeader']")[0].value === "true")
			{
				$("#groupsInHeader").show();
			}
			else
			{
				$("#groupsInHeader").hide()
			}
		}
		if($("#deleteImage"))
		{
			if($("[name='truncateLog']")[0].value === "hide")
			{
				$("#deleteImage").show();
			}
			else if($("[name='truncateLog']")[0].value === "true")
			{
				$("#deleteImage").attr("src", arrayOfImages["eraserMulti"]["src"]);
				$("#deleteImage").attr("alt", arrayOfImages["eraserMulti"]["alt"]);
				$("#deleteImage").attr("title", arrayOfImages["eraserMulti"]["title"]);
			}
			else if($("[name='truncateLog']")[0].value === "false")
			{
				$("#deleteImage").attr("src", arrayOfImages["eraser"]["src"]);
				$("#deleteImage").attr("alt", arrayOfImages["eraser"]["alt"]);
				$("#deleteImage").attr("title", arrayOfImages["eraser"]["title"]);
			}
		}
		if($(".indexHeaderFilterGroup"))
		{
			if($("[name='filterSearchInHeader']")[0].value === "true")
			{
				$(".indexHeaderFilterGroup").show();
				$("#filterSettingsSideBar").hide();
			}
			else
			{
				$(".indexHeaderFilterGroup").hide();
				$("#filterSettingsSideBar").show();
			}
		}
	}
	else if(idForFormMain === "modules")
	{
		if($("[name='enableHistory']")[0].value === "true")
		{
			if(typeof archiveAction !== "function" && typeof script === "function")
			{
				script("core/js/archive.js");
			}
			$("#mainMenuHistory").show();
			$("#settingsMainArchiveMenu").show().removeClass("hiddenMenu");;
		}
		else
		{
			$("#mainMenuHistory").hide();
			$("#settingsMainArchiveMenu").hide().addClass("hiddenMenu");;
		}
		if($("[name='filterEnabled']")[0].value === "true")
		{
			if(typeof getFilterData !== "function" && typeof script === "function")
			{
				script("core/js/filter.js");
			}
			$("#settingsMainFilterMenu").show().removeClass("hiddenMenu");;
			$(".searchSideBarImageForLoad").show();
			if($("[name='filterSearchInHeader']")[0].value === "true")
			{
				$(".indexHeaderFilterGroup").show();
				$("#filterSettingsSideBar").hide();
			}
			else
			{
				$(".indexHeaderFilterGroup").hide();
				$("#filterSettingsSideBar").show();
			}
		}
		else
		{
			$("#settingsMainFilterMenu").hide().addClass("hiddenMenu");;
			$(".indexHeaderFilterGroup").hide();
			$("#filterSettingsSideBar").hide();
			$(".searchSideBarImageForLoad").hide();
		}
		if($("[name='oneLogEnable']")[0].value === "true")
		{
			if(typeof addOneLogTab !== "function" && typeof script === "function")
			{
				script("core/js/oneLog.js");
			}
			$("#settingsMainOneLogMenu").show().removeClass("hiddenMenu");;
			if($("#oneLog"))
			{
				$("#oneLog").show();
			}
			$("oneLogSettingsSideBar").show();
		}
		else
		{
			$("#settingsMainOneLogMenu").hide().addClass("hiddenMenu");;
			if($("#oneLog"))
			{
				$("#oneLog").hide();
			}
			$("#oneLogSettingsSideBar").hide();
		}
		if($("[name='themesEnabled']")[0].value === "true")
		{
			if(typeof addOneLogTab !== "function" && typeof script === "function")
			{
				script("core/js/themes.js");
				script("core/js/upgradeTheme.js");
			}
			$("#ThemesLink").show();
		}
		else
		{
			$("#ThemesLink").hide();
		}
		if($("[name='updaterEnabled']")[0].value === "true")
		{
			if(typeof checkForUpdates !== "function" && typeof script === "function")
			{
				script("core/js/update.js");
			}
			$("#mainMenuUpdate, #settingsMainOtherMenu").show().removeClass("hiddenMenu");
		}
		else
		{
			$("#mainMenuUpdate, #settingsMainOtherMenu").hide().addClass("hiddenMenu");
		}
		if($("[name='enableMultiLog']")[0].value === "true")
		{
			if(typeof getMultiLogWindowConfig !== "function" && typeof script === "function")
			{
				script("core/js/multilog.js");
			}
			$("#subMenuTitle-multilog, #settingsMainLogLayoutMenu, #settingsMainMultiLogMenu, .mainMenuHeader.multilog").show().removeClass("hiddenMenu");
		}
		else
		{
			$("#subMenuTitle-multilog, #settingsMainLogLayoutMenu, #settingsMainMultiLogMenu, .mainMenuHeader.multilog").hide().addClass("hiddenMenu");
		}
	}

	saveSuccess();

	if(idForFormMain === "locationOtherApps" || idForFormMain === "settingsFullScreenMenuVars")
	{
		refreshAddonLinks();
		refreshJsVars();
	}
	else if(
		idForFormMain === "settingsColorFolderGroupVars" ||
		idForFormMain === "generalThemeOptions" ||
		idForFormMain === "settingsFilterVars" ||
		idForFormMain === "settingsNotificationVars"
	) {
		refreshCustomCss();
	}
	else if(
		idForFormMain === "advancedConfig" ||
		idForFormMain === "settingsWatchlistVars" ||
		idForFormMain === "settingsMultiLogVars" ||
		idForFormMain === "settingsInitialLoadLayoutVars" ||
		idForFormMain === "settingsMainVars" ||
		idForFormMain === "archiveConfig" ||
		idForFormMain === "settingsPollVars" ||
		idForFormMain === "settingsMenuLogVars" ||
		idForFormMain === "settingsMenuVars" ||
		idForFormMain === "groupLayoutPresetForm"
	) {
		refreshJsVars();
	}
	else if(
		idForFormMain === "settingsOneLogVars" ||
		idForFormMain === "settingsLogFormatVars" ||
		idForFormMain === "settingsLogVars" ||
		idForFormMain === "modules"
	) {
		refreshCustomCss();
		refreshJsVars();
	}

	if(idForFormMain.includes("themeMainSelection"))
	{
		if (typeof themeChangeLogicDirModifier !== "undefined" && themeChangeLogicDirModifier === "../core/php/post/")
		{
			copyThemeStuffPopup();
		}
		else
		{
			copyThemeStuffPopup("");
		}
	}
	else if(idForFormMain === "welcomeForm")
	{
		if(document.getElementById("innerDisplayUpdate"))
		{
			copyThemeStuffPopup();
		}
		else
		{
			location.reload();
		}
	}
	else
	{
		fadeOutPopup();
		resize();
	}
}

function forceLogMenuRefresh()
{
	clearPollTimer();
	$("#menu a").not("#oneLog").remove()
	forceIgnoreNotifications = true;
	generalUpdate();
	firstLoadEndAction();
	startPollTimer();
	resetSelection();
}

function refreshCustomCss()
{
	if($("#initialLoadContent"))
	{
		$.ajax({
			url: "core/php/customIndexCSS.php?format=json",
			data: {formKey},
			type: "POST",
		success(data)
		{		
			//add css to bottom of index page
			$("#initialLoadContent").append(data);
			
		},
		});

		$.ajax({
			url: "core/php/customCSS.php?format=json",
			data: {formKey},
			type: "POST",
		success(data)
		{	
			//add css to bottom of index page
			$("#initialLoadContent").append(data);
		},
		});
	}
}

function refreshJsVars()
{
	if($("#initialLoadContent"))
	{
		$.ajax({
			url: "core/php/post/reloadJsVars.php?format=json",
			data: {formKey},
			type: "POST",
		success(data)
		{
			//add css to bottom of index page
			$("#initialLoadContent").append(data);
			if(idForFormMain === "settingsPollVars")
			{
				clearPollTimer();
				startPollTimer();
			}
			else if(idForFormMain === "settingsLogVars")
			{
				clearLoadPollTimer();
				startLoadPollTimerDelay();
				if(logDirectionInvert !== document.getElementById("logDirectionInvert").value)
				{
					document.getElementById("logDirectionInvert").value = logDirectionInvert;
					toggleLogDirectionInvert();
				}
			}
			else if(idForFormMain === "settingsMenuLogVars")
			{
				forceLogMenuRefresh();
			}
			else if(idForFormMain === "settingsMenuVars")
			{
				generateWindowDisplay();
			}
		},
		});
	}
}

function refreshAddonLinks()
{
	if($("#menuAddonLinks"))
	{
		$.ajax({
			url: "core/php/post/reloadAddonLinks.php?format=json",
			data: {formKey},
			type: "POST",
		success(data)
		{
			if(!handleError(dirForAjaxSend, data, "reloadAddonLinks.php"))
			{
				//add css to bottom of index page
				$("#menuAddonLinks").html(data);
			}
		},
		});
	}
}

function copyThemeStuffPopup(fileLoc = "../")
{
	//update theme, copying images over
	showPopup();
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<span id=\"innerDisplayUpdate\"><table style=\"padding: 10px;\"><tr><td style=\"height: 50px;\"><img src=\""+fileLoc+"core/img/loading.gif\" id=\"runLoad\" height=\"30px\"><img src=\""+fileLoc+"core/img/greenCheck.png\" id=\"runCheck\" style=\"display: none;\" height=\"30px\"></td><td style=\"width: 20px;\"></td><td>Copying Images / CSS</td></tr><tr><td style=\"height: 50px;\"><img src=\""+fileLoc+"core/img/loading.gif\" id=\"verifyLoad\" style=\"display: none;\" height=\"30px\"><img src=\""+fileLoc+"core/img/greenCheck.png\" id=\"verifyCheck\" style=\"display: none;\" height=\"30px\"></td><td style=\"width: 20px;\"></td><td>Verifying Copied files</td></tr></table></span>";
	copyFilesThemeChange();
}

function saveSuccess()
{
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Saved Changes!</div><br><br><div style='width:100%;text-align:center;'> "+saveVerifyImage+" </div>";
}

function saveError()
{
	document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class='settingsHeader' >Error</div><br><br><div style='width:100%;text-align:center;'> An Error Occured While Saving... </div>";
	fadeOutPopup();
}

function fadeOutPopup()
{
	setTimeout(hidePopup, 1000);
}

function objectsAreSameInner(x, y)
{
	try
	{
		for(var propertyName in x)
		{
			if( (typeof(x) === "undefined") || (typeof(y) === "undefined") || x[propertyName] !== y[propertyName])
			{
				return false;
			}
		}
		return true;
	}
	catch(e)
	{
		console.log(e);
	}
}

function objectsAreSame(x, y)
{
	try
	{
		var returnValue = true;
		for (var i = x.length - 1; i >= 0; i--)
		{
			if(!objectsAreSameInner(x[i],y[i]))
			{
				returnValue = false;
				break;
			}
		}
		return returnValue;
	}
	catch(e)
	{
		console.log(e);
	}
}

function checkForChangesArray(idsOfObjects)
{
	var returnValue = false;
	if (idsOfObjects.length > 0)
	{
		for (var i = idsOfObjects.length - 1; i >= 0; i--)
		{
			var newValue = checkForChanges(idsOfObjects[i]);
			if(!returnValue)
			{
				returnValue = newValue;
			}
		}
	}
	return returnValue;
}

function checkForChanges(idOfObject)
{
	try
	{
		if(!objectsAreSame($("#"+idOfObject).serializeArray(), arrayObject[idOfObject]))
		{
			if($("."+idOfObject+"ResetButton"))
			{
				$("."+idOfObject+"ResetButton").css("display","inline-block");
				$("."+idOfObject+"NoChangesDetected").css("display","none");
				if(saveButtonAlwaysVisible !== "true")
				{
					$("."+idOfObject+"SaveButton").css("display","inline-block");
				}
			}
			if(document.getElementById("setupButtonContinue"))
			{
				document.getElementById("setupButtonContinue").style.display = "none";
				document.getElementById("setupButtonDisabled").style.display = "inline-block";

			}
			return true;
		}

		if($("."+idOfObject+"ResetButton"))
		{
			$("."+idOfObject+"NoChangesDetected").css("display","inline-block");
			$("."+idOfObject+"ResetButton").css("display","none");
			if(saveButtonAlwaysVisible !== "true")
			{
				$("."+idOfObject+"SaveButton").css("display","none");
			}
		}
		if(document.getElementById("setupButtonContinue"))
		{
			document.getElementById("setupButtonContinue").style.display = "inline-block";
			document.getElementById("setupButtonDisabled").style.display = "none";
		}
		return false;
	}
	catch(e)
	{
		console.log(e);
	}
}

function settingsArrayRefresh()
{
	let arrOfVarGroups = [];
	let arrOfPossibleGroupsKeys = Object.keys(arrOfPossibleGroups);
	let arrOfPossibleGroupsKeysLength = arrOfPossibleGroupsKeys.length;
	for(let i = 0; i < arrOfPossibleGroupsKeysLength; i++)
	{
		if(document.getElementById(arrOfPossibleGroups[arrOfPossibleGroupsKeys[i]]))
		{
			arrOfVarGroups.push(arrOfPossibleGroups[arrOfPossibleGroupsKeys[i]]);
		}
	}
	refreshArrayObjectOfArrays(arrOfVarGroups);
}

function refreshArrayObjectOfArrays(idsOfForms)
{
	let idsOfFormsKeys = Object.keys(idsOfForms);
	let idsOfFormsKeysLength = idsOfFormsKeys.length;
	for(let i = 0; i < idsOfFormsKeysLength; i++)
	{
		refreshArrayObject(idsOfForms[idsOfFormsKeys[i]]);
	}
}

function refreshArrayObject(idOfForm)
{
	try
	{
		arrayObject[idOfForm] = $("#"+idOfForm).serializeArray();
		innerHtmlObject[idOfForm] = document.getElementById(idOfForm).innerHTML;
	}
	catch(e)
	{
		console.log(e);
	}
}

function resetArrayObject(idOfForm)
{
	try
	{
		document.getElementById(idOfForm).innerHTML = innerHtmlObject[idOfForm];
		arrayObject[idOfForm] = $("#"+idOfForm).serializeArray();

		if(idOfForm === "settingsColorFolderGroupVars")
		{
			reAddJsColorPopupForCustomThemes();
		}
		else if(idOfForm === "generalThemeOptions")
		{
			logStyleListeners();
		}

		if(innerHtmlObject[idOfForm].indexOf("colorSelectorDiv") > -1)
		{
			//reset color popups
			let colorPickerDataKeys = Object.keys(colorPickerData);
			let colorPickerDataKeysLength = colorPickerDataKeys.length;
			for(let i = 0; i < colorPickerDataKeysLength; i++)
			{
				if(innerHtmlObject[idOfForm].indexOf(colorPickerDataKeys[i]) > -1)
				{
					colorPickerData[colorPickerDataKeys[i]]["function"](
						colorPickerData[colorPickerDataKeys[i]]["arg1"],
						colorPickerData[colorPickerDataKeys[i]]["arg2"]
					);
				}
			}
		}
	}
	catch(e)
	{
		console.log(e);
	}
}

function generateExampleLogForStyle()
{
	let html = "<table style=\" background: " + $("#generalThemeOptions input[name=backgroundColor]").val() + "; \" >";
	let length = exampleLogForCustomStyle.length;
	for(let i = 0; i < length; i++)
	{
		html += "<tr style=\"border-spacing: 0; \"><td style=\"padding: 0; font-family: " +
		$("#generalThemeOptions select[name=fontFamily]").val() + 
		"; color: "+
		$("#generalThemeOptions input[name=logFontColor]").val() +
		"; font-size: " +
		$("#generalThemeOptions select[name=logFontSize]").val() +
		"%; \" >" + exampleLogForCustomStyle[i] + "</td></tr>";
		if (i !== (length - 1))
		{
			let lineBorder = "";
			if ($("#generalThemeOptions select[name=logLineBorder]").val() === 'true')
			{
				lineBorder = "border-top: " + 
				$("#generalThemeOptions select[name=logLineBorderHeight]").val() + 
				"px solid " +
				$("#generalThemeOptions input[name=logLineBorderColor]").val() + 
				";";
			}
			html += "<tr style=\"border-spacing: 0; height: " +
			$("#generalThemeOptions select[name=logLinePadding]").val() +
			"px;\" ><td style=\"padding: 0; "+lineBorder+" \"></td></tr>";
		}
	}
	html += "</table>";
	$("#exampleStyleLogSpan").html(html);
}

function logStyleListeners()
{
	generateExampleLogForStyle();
	$("#generalThemeOptions input, #generalThemeOptions select").on("change", function() {
		generateExampleLogForStyle();
	})
}

logStyleListeners();
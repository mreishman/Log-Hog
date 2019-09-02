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
		if(valueForPopupInner.value === valueToCompare)
		{
			valueForVarsInner.style.display = "block";
		}
		else
		{
			valueForVarsInner.style.display = "none";
		}
	}
	catch(e)
	{
		eventThrowException(e);
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
        url: dirForAjaxSend+"core/php/settingsSaveAjax.php",
        data,
        success(data)
        {
        	if(typeof data === "object"  && "error" in data)
            {
                window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
			else if(data !== "true")
			{
				window.location.href = dirForAjaxSend+"error.php?error="+data+"&page=core/php/settingsSaveAjax.php";
			}
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
		var urlForSend = dirForAjaxSend+"core/php/saveCheck.php?format=json";
		data["formKey"] = formKey;
		$.ajax(
		{
			url: urlForSend,
			dataType: "json",
			data,
			type: "POST",
			success(data)
			{
				if(typeof data === "object"  && "error" in data)
				{
					window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=saveCheck.php";
				}
				else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
	            {
	            	data = JSON.parse(data);
	            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=saveCheck.php";
	            }
				else if(data === true)
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
				document.getElementById("ThemesLink").style.display = "inline-block";
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
	else if(idForFormMain === "loggingDisplay")
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
			if(typeof formatFileLine !== "function")
			{
				script("core/js/formatFile.js");
			}
		}
		if($("#logFormatPhpEnable") && $("#logFormatPhpEnable")[0].value === "true")
		{
			if(typeof formatPhpMessage !== "function")
			{
				script("core/js/formatPhp.js");
			}
		}
		if($("#logFormatReportEnable") && $("#logFormatReportEnable")[0].value === "true")
		{
			if(typeof formatReportMessage !== "function")
			{
				script("core/js/formatReport.js");
			}
		}
		if($("#logFormatJsObjectEnable") && $("#logFormatJsObjectEnable")[0].value === "true")
		{
			if(typeof formatJsonMessage !== "function")
			{
				script("core/js/formatJsObject.js");
			}
		}
	}
	else if(idForFormMain === "settingsLogVars")
	{
		if(typeof flashTitle !== "function" && $("[name='flashTitleUpdateLog']")[0].value === "true")
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
		if($("#menuButtonRight"))
		{
			if($("[name='filterSearchInHeader']")[0].value === "true")
			{
				$("#menuButtonRight").show();
			}
			else
			{
				$("#menuButtonRight").hide()
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
		if($("#menuButtonRight"))
		{
			if($("[name='filterSearchInHeader']")[0].value === "true")
			{
				$("#menuButtonRight").show();
				$("#filterSettingsSideBar").hide();
			}
			else
			{
				$("#menuButtonRight").hide();
				$("#filterSettingsSideBar").show();
			}
		}
	}
	else if(idForFormMain ===  "modules")
	{
		if($("[name='developmentTabEnabled']")[0].value === "true")
		{
			$(".DevLink").show();
		}
		else
		{
			$(".DevLink").hide()
		}
		if($("[name='enableHistory']")[0].value === "true")
		{
			if(typeof archiveAction !== "function")
			{
				script("core/js/archive.js");
			}
			$("#mainMenuHistory").show();
			$("#settingsMainArchiveMenu").show();
		}
		else
		{
			$("#mainMenuHistory").hide();
			$("#settingsMainArchiveMenu").hide();
		}
		if($("[name='filterEnabled']")[0].value === "true")
		{
			if(typeof getFilterData !== "function")
			{
				script("core/js/filter.js");
			}
			$("#settingsMainFilterMenu").show();
			$(".searchSideBarImageForLoad").show();
			if($("[name='filterSearchInHeader']")[0].value === "true")
			{
				$("#menuButtonRight").show();
				$("#filterSettingsSideBar").hide();
			}
			else
			{
				$("#menuButtonRight").hide();
				$("#filterSettingsSideBar").show();
			}
		}
		else
		{
			$("#settingsMainFilterMenu").hide();
			$("#menuButtonRight").hide();
			$("#filterSettingsSideBar").hide();
			$(".searchSideBarImageForLoad").hide();
		}
		if($("[name='oneLogEnable']")[0].value === "true")
		{
			if(typeof addOneLogTab !== "function")
			{
				script("core/js/oneLog.js");
			}
			$("#settingsMainOneLogMenu").show();
			if($("#oneLog"))
			{
				$("#oneLog").show();
			}
			$("oneLogSettingsSideBar").show();
		}
		else
		{
			$("#settingsMainOneLogMenu").hide();
			if($("#oneLog"))
			{
				$("#oneLog").hide();
			}
			$("#oneLogSettingsSideBar").hide();
		}
		if($("[name='themesEnabled']")[0].value === "true")
		{
			if(typeof addOneLogTab !== "function")
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
		idForFormMain === "loggingDisplay" ||
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
		copyThemeStuffPopup("");
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
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else
            {
				//add css to bottom of index page
				$("#initialLoadContent").append(data);
			}
		},
		});

		$.ajax({
			url: "core/php/customCSS.php?format=json",
			data: {formKey},
			type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
            {
                window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=settingsSaveAjax.php";
            }
            else
            {
				//add css to bottom of index page
				$("#initialLoadContent").append(data);
			}
		},
		});
	}
}

function refreshJsVars()
{
	if($("#initialLoadContent"))
	{
		$.ajax({
			url: "core/php/reloadJsVars.php?format=json",
			data: {formKey},
			type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
			{
				window.location.href = "error.php?error="+data["error"]+"&page=reloadJsVars.php";
				return;
			}
			else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=reloadJsVars.php";
            }
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
			url: "core/php/reloadAddonLinks.php?format=json",
			data: {formKey},
			type: "POST",
		success(data)
		{
			if(typeof data === "object"  && "error" in data)
			{
				window.location.href = "error.php?error="+data["error"]+"&page=reloadAddonLinks.php";
			}
			else if(typeof data === "string" && data.indexOf("error") > -1 && data.indexOf("{") > -1 && data.indexOf("}") > -1)
            {
            	data = JSON.parse(data);
            	window.location.href = dirForAjaxSend + "error.php?error="+data["error"]+"&page=reloadAddonLinks.php";
            }
			else
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
		eventThrowException(e);
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
		eventThrowException(e);
	}
}

function checkForChangesArray(idsOfObjects)
{
	var returnValue = false;
	for (var i = idsOfObjects.length - 1; i >= 0; i--)
	{
		var newValue = checkForChanges(idsOfObjects[i]);
		if(!returnValue)
		{
			returnValue = newValue;
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
		eventThrowException(e);
	}
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
		eventThrowException(e);
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
		eventThrowException(e);
	}
}
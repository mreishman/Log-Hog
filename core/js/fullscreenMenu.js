function toggleFullScreenMenu(force = false)
{
	fullScreenMenuClickCount++;
	dirForAjaxSend = "";
	closeLogPopup();
	if(document.getElementById("fullScreenMenu").style.display === "none")
	{
		document.getElementById("menu").style.zIndex = "4";
		loadImgFromData("mainMenuImage");
		document.getElementById("fullScreenMenu").style.display = "block";
		onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
		if($("#menuStatusAddon").hasClass("selected"))
		{
			$("#menuStatusAddon").click();
		}
		else if($("#menuMonitorAddon").hasClass("selected"))
		{
			$("#menuMonitorAddon").click();
		}
		else if ($("#menuSearchAddon").hasClass("selected"))
		{
			$("#menuSearchAddon").click();
		}
		else if ($("#menuSeleniumMonitorAddon").hasClass("selected"))
		{
			$("#menuSeleniumMonitorAddon").click();
		}
		else if($("#ThemesLink") && $("#ThemesLink").hasClass("selected"))
		{
			toggleThemesIframeSource(true);
		}
		else if($("#mainMenuNotifications") && $("#mainMenuNotifications").hasClass("selected"))
		{
			updateNotificationStuff();
		}
		else if($("#mainFullScreenMenu li.selected").length === 0)
		{
			//first load of full screen menu, switch to defined initial page
			if(fullScreenMenuDefaultPage !== "none")
			{
				if(fullScreenMenuDefaultPage === "about")
				{
					toggleAbout();
				}
				else if(fullScreenMenuDefaultPage === "addons")
				{
					toggleAddons();
				}
				else if(fullScreenMenuDefaultPage === "history")
				{
					toggleHistory();
				}
				else if(fullScreenMenuDefaultPage === "notifications")
				{
					toggleNotifications();
				}
				else if(fullScreenMenuDefaultPage === "settings")
				{
					toggleSettings();
				}
				else if(fullScreenMenuDefaultPage === "themes")
				{
					toggleThemes();
				}
				else if(fullScreenMenuDefaultPage === "update")
				{
					toggleUpdateMenu();
				}
				else if(fullScreenMenuDefaultPage === "watchlist")
				{
					toggleWatchListMenu();
				}
			}
		}
		resizeFullScreenMenu();
		var fullScreenMenuClickCountCurrent = fullScreenMenuClickCount;
		setTimeout(function() {
			togglePollSpeedDown(fullScreenMenuClickCountCurrent);
		}, 1000 * fullScreenMenuPollSwitchDelay);

	}
	else
	{
		if(!force && !globalForcePageNavigate)
		{
			if(!(goToPageCheck("toggleFullScreenMenu(true)")))
			{
				return false;
			}
		}
		toggleThemesIframeSource(false);
		$( "#fullScreenMenuWatchList" ).off( "mousemove" );
		globalForcePageNavigate = false;
		document.getElementById("menu").style.zIndex = "20";
		hideIframeStuff();
		document.getElementById("fullScreenMenu").style.display = "none";
		togglePollSpeedUp();
	}
}

function toggleSettingsMainLogs(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleSettingsMainLogs(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideSettingsStuff();
	endSettingsPollTimer();
	document.getElementById("settingsMainLogs").style.display = "block";
	$("#settingsMainLogsMenu").addClass("selected");
	arrayOfScrollHeaderUpdate = ['settingsLogVars'];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
	startSettingsPollTimer();
}

function toggleSettingsMainLogFormat(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleSettingsMainLogFormat(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideSettingsStuff();
	endSettingsPollTimer();
	document.getElementById("settingsMainLogFormat").style.display = "block";
	$("#settingsMainLogFormatMenu").addClass("selected");
	arrayOfScrollHeaderUpdate = ['settingsLogFormatVars'];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
	startSettingsPollTimer();
}

function togleSettingsMainFilter(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("togleSettingsMainFilter(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideSettingsStuff();
	endSettingsPollTimer();
	document.getElementById("settingsMainFilter").style.display = "block";
	$("#settingsMainFilterMenu").addClass("selected");
	arrayOfScrollHeaderUpdate = ['settingsFilterVars'];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
	startSettingsPollTimer();
}

function toggleSettingsMainArchive(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("togleSettingsMainArchive(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideSettingsStuff();
	endSettingsPollTimer();
	document.getElementById("settingsMainArchive").style.display = "block";
	$("#settingsMainArchiveMenu").addClass("selected");
	arrayOfScrollHeaderUpdate = ['archiveConfig'];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
	startSettingsPollTimer();
}

function toggleSettingsMainNotifications(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleSettingsMainNotifications(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideSettingsStuff();
	endSettingsPollTimer();
	document.getElementById("settingsMainNotifications").style.display = "block";
	$("#settingsMainNotificationsMenu").addClass("selected");
	arrayOfScrollHeaderUpdate = ['settingsNotificationVars'];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
	startSettingsPollTimer();
}

function toggleSettingsMainPoll(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleSettingsMainPoll(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideSettingsStuff();
	endSettingsPollTimer();
	document.getElementById("settingsMainPoll").style.display = "block";
	$("#settingsMainPollMenu").addClass("selected");
	arrayOfScrollHeaderUpdate = ['settingsPollVars'];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
	startSettingsPollTimer();
}

function toggleUpdateMenu(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleUpdateMenu(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	loadImgFromData("updateImg");
	hideMainStuff();
	hideSidebar();
	document.getElementById("fullScreenMenuUpdate").style.display = "block";
	$("#mainMenuUpdate").addClass("selected");
	arrayOfScrollHeaderUpdate = [];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
}

function toggleAddons(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleAddons(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideMainStuff();
	hideSidebar();
	document.getElementById("fullScreenMenuAddons").style.display = "block";
	$("#mainMenuAddons").addClass("selected");
	arrayOfScrollHeaderUpdate = [];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
}

function toggleHistory(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleHistory(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideMainStuff();
	toggleFullScreenMenuMainContent();
	document.getElementById("historySubMenu").style.display = "block";
	$("#mainMenuHistory").addClass("selected");
	arrayOfScrollHeaderUpdate = [];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	toggleTmpSaveHistory();
}

function toggleTmpSaveHistory()
{
	hideHistoryStuff();
	document.getElementById("fullScreenMenuHistory").style.display = "block";
	$("#tempSaveHistory").addClass("selected");
	getListOfTmpHistoryLogs();
	resizeFullScreenMenu();
}

function toggleArchiveHistory()
{
	hideHistoryStuff();
	document.getElementById("fullScreenMenuArchive").style.display = "block";
	$("#archiveHistory").addClass("selected");
	getListOfArchiveLogs();
	resizeFullScreenMenu();
}

function toggleSettings(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleSettings(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideMainStuff();
	toggleFullScreenMenuMainContent();
	document.getElementById("settingsSubMenu").style.display = "block";
	$("#mainMenuSettings").addClass("selected");
	arrayOfScrollHeaderUpdate = [];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
}

function toggleAbout(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleAbout(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideMainStuff();
	toggleFullScreenMenuMainContent();
	document.getElementById("aboutSubMenu").style.display = "block";
	$("#mainMenuAbout").addClass("selected");
	toggleAboutLogHog();
}

function toggleThemes(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleThemes(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideMainStuff();
	toggleFullScreenMenuMainContent();
	document.getElementById("themeSubMenu").style.display = "block";
	$("#ThemesLink").addClass("selected");
	toggleMainThemes();
	$(".subMenuActionsColorScheme").hide();
}

function toggleMainThemes(force = false)
{
	if(!force)
	{
		if(!(goToPageCheck("toggleMainThemes(true)")))
		{
			return false;
		}
	}
	hideThemeStuff();
	endSettingsPollTimer();
	toggleThemesIframeSource(true);
	$("#themeSubMenuMainThemes").addClass("selected");
	document.getElementById("fullScreenMenuTheme").style.display = "block";
	arrayOfScrollHeaderUpdate = ["themeSpan"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
}

function toggleGeneralThemeStyle(force = false)
{
	if(!force)
	{
		if(!(goToPageCheck("toggleGeneralThemeStyle(true)")))
		{
			return false;
		}
	}
	hideThemeStuff();
	endSettingsPollTimer();
	$("#themeSubMenuGeneralStyle").addClass("selected");
	document.getElementById("fullScreenMenuThemeGeneralStyle").style.display = "block";
	arrayOfScrollHeaderUpdate = ["generalThemeOptions"];
	arrayOfDataSettings = ["generalThemeOptions"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	startSettingsPollTimer();
	resizeFullScreenMenu();
}

function toggleThemesIframeSource(showOrHide)
{
	var arrayOfIframesForThemes = document.getElementsByClassName("iframeThemes");
	var lengthOfIframeThemes = arrayOfIframesForThemes.length;
	for(var counterOfIframeThemes = 0; counterOfIframeThemes < lengthOfIframeThemes; counterOfIframeThemes++)
	{
		if(showOrHide)
		{
			arrayOfIframesForThemes[counterOfIframeThemes].setAttribute("src",arrayOfIframesForThemes[counterOfIframeThemes].getAttribute("data-src"));
		}
		else
		{
			arrayOfIframesForThemes[counterOfIframeThemes].setAttribute("src","core/html/iframe.html");
		}
	}
}

function toggleThemeColorScheme(force = false)
{
	if(!force && !(goToPageCheck("toggleThemeColorScheme(true)")))
	{
		return false;
	}
	hideThemeStuff();
	endSettingsPollTimer();
	$("#themeSubMenuColorScheme").addClass("selected");
	document.getElementById("fullScreenMenuColorScheme").style.display = "block";
	let subMenuActionDisplay = "block";
	if(window.innerWidth < breakPointTwo || sideBarOnlyIcons === "breakpointtwo")
	{
		subMenuActionDisplay = "inline-block";
	}
	$(".subMenuActionsColorScheme").css("display",subMenuActionDisplay);
	arrayOfScrollHeaderUpdate = ["settingsColorFolderGroupVars"];
	arrayOfDataSettings = ["settingsColorFolderGroupVars"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	startSettingsPollTimer();
	reAddJsColorPopupForCustomThemes();
	resizeFullScreenMenu();
}

function toggleFullScreenMenuMainContent()
{
	var mainContentFullScreenMenuLeft = "402px";
	var mainContentFullScreenMenuTop = "46px";
	if( window.innerWidth < breakPointTwo || sideBarOnlyIcons === "breakpointtwo")
	{
		mainContentFullScreenMenuLeft = "52px";
		mainContentFullScreenMenuTop = "82px";
	}
	else if(sideBarOnlyIcons === "breakpointone" || window.innerWidth < breakPointOne)
	{
		mainContentFullScreenMenuLeft = "252px";
	}

	if(document.getElementById("mainContentFullScreenMenu").style.left !== mainContentFullScreenMenuLeft)
	{
		document.getElementById("mainContentFullScreenMenu").style.left = mainContentFullScreenMenuLeft;
	}

	if(document.getElementById("mainContentFullScreenMenu").style.top !== mainContentFullScreenMenuTop)
	{
		document.getElementById("mainContentFullScreenMenu").style.top = mainContentFullScreenMenuTop;
	}
}

function toggleAboutLogHog()
{
	hideAboutStuff();
	document.getElementById("fullScreenMenuAbout").style.display = "block";
	$("#aboutSubMenuAbout").addClass("selected");
	arrayOfScrollHeaderUpdate = ["aboutSpanAbout","aboutSpanInfo","aboutSpanGithub"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
}

function toggleWhatsNew()
{
	loadImgFromData("whatsNewImage");
	hideAboutStuff();
	document.getElementById("fullScreenMenuWhatsNew").style.display = "block";
	$("#aboutSubMenuWhatsNew").addClass("selected");
	arrayOfScrollHeaderUpdate = ["fullScreenMenuWhatsNew"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
}

function toggleChangeLog()
{
	hideAboutStuff();
	document.getElementById("fullScreenMenuChangeLog").style.display = "block";
	$("#aboutSubMenuChangelog").addClass("selected");
	arrayOfScrollHeaderUpdate = ["fullScreenMenuChangeLog"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	resizeFullScreenMenu();
}

function toggleWatchListMenu(force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleWatchListMenu(true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = true;
	if(typeof loadWatchList !== "function")
	{
		let scriptToLoad = onLoadJsFiles["watchlist"];
		script(scriptToLoad["name"] + "?v=" + scriptToLoad["ver"]);
	}
	else
	{
		resetProgressBarWatchList();
	}
	$(".uniqueClassForAppendSettingsMainWatchNew").html("");
	$("#loadingSpan").show();
	toggleFullScreenMenuMainContent();
	loadImgFromData("watchlistImg");
	hideMainStuff();
	arrayOfDataSettings = ["settingsMainWatch"];
	document.getElementById("fullScreenMenuWatchList").style.display = "block";
	document.getElementById("watchListSubMenu").style.display = "block";
	$("#watchListMenu").addClass("selected");
	arrayOfScrollHeaderUpdate = ["settingsMainWatch"];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	$(".settingsMainWatchSaveChangesButton").css("display","none");
	document.getElementById("watchListSubMenu").style.display = "none";
	if(typeof loadWatchList !== "function")
	{
		setTimeout(function() {
			timerForWatchlist = setInterval(tryLoadWatch, 100);
		}, 250);
	}
	else
	{
		setTimeout(function() {
			timerForWatchlist = setInterval(tryLoadWatch, 100);
		}, 25);
	}
	resizeFullScreenMenu();
}

function tryLoadWatch()
{
	if(typeof loadWatchList === "function")
	{
		clearInterval(timerForWatchlist);
		loadWatchList();
	}
}

function startSettingsPollTimer()
{
	timerForSettings = setInterval(checkIfChanges, 100);
}

function checkIfChanges()
{
	if(checkForChangesArray(arrayOfDataSettings))
	{
		return true;
	}
	return false;
}

function goToPageCheck(functionName)
{
	try
	{
		var goToPage = !checkIfChanges();
		popupSettingsArrayCheck();
		if(!(goToPage || ("saveSettings" in popupSettingsArray  && popupSettingsArray.saveSettings == "false")))
		{
			displaySavePromptPopupIndex(functionName);
			return false;
		}
		return true;
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function endSettingsPollTimer()
{
	arrayOfDataSettings = [];
	clearInterval(timerForSettings);
}

function hideSidebar()
{
	sideBarVisible = false;
	var mainContentFullScreenMenuLeft = "201px";
	if(sideBarOnlyIcons === "breakpointone" || window.innerWidth < breakPointOne || sideBarOnlyIcons === "breakpointtwo")
	{
		mainContentFullScreenMenuLeft = "52px";
	}

	if(document.getElementById("mainContentFullScreenMenu").style.left !== mainContentFullScreenMenuLeft)
	{
		document.getElementById("mainContentFullScreenMenu").style.left = mainContentFullScreenMenuLeft;
	}
	if(document.getElementById("mainContentFullScreenMenu").style.top !== "46px")
	{
		document.getElementById("mainContentFullScreenMenu").style.top = "46px";
	}

}

function hideWatchListStuff()
{
	document.getElementById("fullScreenMenuWatchList").style.display = "none";
	document.getElementById("watchListSubMenu").style.display = "none";
}

function hideUpdateStuff()
{
	document.getElementById("fullScreenMenuUpdate").style.display = "none";
}

function hideSettingsStuff()
{
	document.getElementById("settingsMainLogs").style.display = "none";
	$("#settingsMainLogsMenu").removeClass("selected");
	document.getElementById("settingsMainLogFormat").style.display = "none";
	$("#settingsMainLogFormatMenu").removeClass("selected");
	document.getElementById("settingsMainPoll").style.display = "none";
	$("#settingsMainPollMenu").removeClass("selected");
	document.getElementById("settingsMainFilter").style.display = "none";
	$("#settingsMainFilterMenu").removeClass("selected");
	document.getElementById("settingsMainArchive").style.display = "none";
	$("#settingsMainArchiveMenu").removeClass("selected");
	document.getElementById("settingsMainNotifications").style.display = "none";
	$("#settingsMainNotificationsMenu").removeClass("selected");
}

function hideAboutStuff()
{
	document.getElementById("fullScreenMenuAbout").style.display = "none";
	$("#aboutSubMenuAbout").removeClass("selected");
	document.getElementById("fullScreenMenuChangeLog").style.display = "none";
	$("#aboutSubMenuChangelog").removeClass("selected");
	document.getElementById("fullScreenMenuWhatsNew").style.display = "none";
	$("#aboutSubMenuWhatsNew").removeClass("selected");
}

function hideHistoryStuff()
{
	document.getElementById("fullScreenMenuHistory").style.display = "none";
	$("#tempSaveHistory").removeClass("selected");
	document.getElementById("fullScreenMenuArchive").style.display = "none";
	$("#archiveHistory").removeClass("selected");
}

function hideNotificationStuff()
{
	document.getElementById("notifications").style.display = "none";
	document.getElementById("notificationsEmpty").style.display = "none";
}

function hideAddonStuff()
{
	document.getElementById("fullScreenMenuAddons").style.display = "none";
	$("#mainMenuAddons").removeClass("selected");
}

function hideThemeStuff()
{
	toggleThemesIframeSource(false);
	document.getElementById("fullScreenMenuTheme").style.display = "none";
	$("#themeSubMenuMainThemes").removeClass("selected");
	document.getElementById("fullScreenMenuColorScheme").style.display = "none";
	$(".subMenuActionsColorScheme").hide();
	$("#themeSubMenuGeneralStyle").removeClass("selected");
	document.getElementById("fullScreenMenuThemeGeneralStyle").style.display = "none";
	$("#themeSubMenuColorScheme").removeClass("selected");
}

function hideIframeStuff()
{
	document.getElementById("fullScreenMenuIFrame").style.display = "none";
	$("#iframeFullScreen").prop("src", "core/html/iframe.html");
}

function toggleIframe(locHref, idOfAddon, force = false)
{
	if(!force && !globalForcePageNavigate)
	{
		if(!(goToPageCheck("toggleIframe(\""+locHref+"\",\""+idOfAddon+"\",true)")))
		{
			return false;
		}
	}
	globalForcePageNavigate = false;
	hideMainStuff();
	$("#"+idOfAddon).addClass("selected");
	document.getElementById("fullScreenMenuIFrame").style.display = "block";
	hideSidebar();
	$("#iframeFullScreen").prop("src", locHref);
	var mainContentRect = document.getElementById("mainContentFullScreenMenu").getBoundingClientRect();
	document.getElementById("iframeFullScreen").style.width = ""+mainContentRect.width+"px";
	document.getElementById("iframeFullScreen").style.height = ""+mainContentRect.height+"px";
	arrayOfScrollHeaderUpdate = [];
	onScrollShowFixedMiniBar(arrayOfScrollHeaderUpdate);
	return false;
}

function hideMainStuff()
{
	endSettingsPollTimer();

	if($("#mainMenuSettings").hasClass("selected"))
	{
		hideSettingsStuff();
		document.getElementById("settingsSubMenu").style.display = "none";
		$("#mainMenuSettings").removeClass("selected");
	}

	if($("#mainMenuNotifications").hasClass("selected"))
	{
		hideNotificationStuff();
		$("#mainMenuNotifications").removeClass("selected");
		sideBarVisible = true;
	}

	if($("#mainMenuAbout").hasClass("selected"))
	{
		document.getElementById("aboutSubMenu").style.display = "none";
		hideAboutStuff();
		$("#mainMenuAbout").removeClass("selected");
	}

	if($("#mainMenuHistory").hasClass("selected"))
	{
		document.getElementById("historySubMenu").style.display = "none";
		hideHistoryStuff();
		$("#mainMenuHistory").removeClass("selected");
	}

	if($("#mainMenuUpdate").hasClass("selected"))
	{
		hideUpdateStuff();
		$("#mainMenuUpdate").removeClass("selected");
		sideBarVisible = true;
	}


	if($("#menuStatusAddon").hasClass("selected") || $("#menuMonitorAddon").hasClass("selected") || $("#menuSearchAddon").hasClass("selected") || $("#menuSeleniumMonitorAddon").hasClass("selected"))
	{
		hideIframeStuff();
		sideBarVisible = true;
	}

	if($("#watchListMenu").hasClass("selected"))
	{
		hideWatchListStuff();
		$("#watchListMenu").removeClass("selected");
	}

	if($("#mainMenuAddons").hasClass("selected"))
	{
		hideAddonStuff();
		sideBarVisible = true;
	}

	if($("#ThemesLink") && $("#ThemesLink").hasClass("selected"))
	{
		document.getElementById("themeSubMenu").style.display = "none";
		hideThemeStuff();
		$("#ThemesLink").removeClass("selected");
	}

	$("#menuStatusAddon").removeClass("selected");
	$("#menuMonitorAddon").removeClass("selected");
	$("#menuSearchAddon").removeClass("selected");
	$("#menuSeleniumMonitorAddon").removeClass("selected");
}

function onScrollShowFixedMiniBar(idsOfForms)
{
	if(!document.getElementById("fixedPositionMiniMenu"))
	{
		return;
	}
	if(idsOfForms.length < 1)
	{
		$("#fixedPositionMiniMenu").html("");
		if(document.getElementById("fixedPositionMiniMenu").style.display !== "none")
		{
			document.getElementById("fixedPositionMiniMenu").style.display = "none";
		}
		return;
	}
	var widthOfMainMenu = document.getElementById("mainContentFullScreenMenu").getBoundingClientRect().width;
	if (document.getElementById("fixedPositionMiniMenu").style.width !==  widthOfMainMenu)
	{
		document.getElementById("fixedPositionMiniMenu").style.width = widthOfMainMenu;
	}
	var dis = false;
	for (var i = idsOfForms.length - 1; i >= 0; i--)
	{
		var currentPos = document.getElementById(idsOfForms[i]).getBoundingClientRect().top;
		var topCheck = 52;
		if(window.innerWidth < breakPointTwo || sideBarOnlyIcons === "breakpointtwo")
		{
			topCheck = 88;
		}
		if(currentPos < topCheck)
		{
			$("#fixedPositionMiniMenu").html($("#"+idsOfForms[i]+" .settingsHeader").html());
			if(document.getElementById("fixedPositionMiniMenu").style.display === "none")
			{
				document.getElementById("fixedPositionMiniMenu").style.display = "block";
			}
			var fixedPositionMiniMenuTop = "52px";
			if(window.innerWidth < breakPointTwo || sideBarOnlyIcons === "breakpointtwo")
			{
				fixedPositionMiniMenuTop = "88px";
			}
			if(document.getElementById("fixedPositionMiniMenu").style.top !== fixedPositionMiniMenuTop)
			{
				document.getElementById("fixedPositionMiniMenu").style.top = fixedPositionMiniMenuTop;
			}
			dis = true;
			break;
		}
	}
	if(!dis)
	{
		$("#fixedPositionMiniMenu").html("");
		if(document.getElementById("fixedPositionMiniMenu").style.display !== "none")
		{
			document.getElementById("fixedPositionMiniMenu").style.display = "none";
		}
	}
}

function resizeFullScreenMenu()
{
	try
	{
		var targetWidth = window.innerWidth;
		var mainContentFullScreenMenuLeft = "402";
		if(!sideBarVisible)
		{
			mainContentFullScreenMenuLeft = "201";
		}
		var mainContentFullScreenMenuTop = "52px";
		if(sideBarOnlyIcons === "breakpointone" || targetWidth < breakPointOne || sideBarOnlyIcons === "breakpointtwo")
		{
			$(".fullScreenMenuText").hide();
			if(document.getElementById("mainFullScreenMenu").getBoundingClientRect().width !== 52) //1px border included here
			{
				document.getElementById("mainFullScreenMenu").style.width = "51px";
				$(".settingsUlSub").css("left", "52px");
			}
			mainContentFullScreenMenuLeft = "252";
			if(!sideBarVisible)
			{
				mainContentFullScreenMenuLeft = "52";
			}
		}
		else
		{
			$(".fullScreenMenuText").show();
			if(document.getElementById("mainFullScreenMenu").getBoundingClientRect().width !== 201) //1px border included here
			{
				document.getElementById("mainFullScreenMenu").style.width = "200px";
				$(".settingsUlSub").css("left", "201px");
			}
		}

		if(targetWidth < breakPointTwo || sideBarOnlyIcons === "breakpointtwo")
		{
			mainContentFullScreenMenuLeft = "52";
			if(sideBarVisible)
			{
				mainContentFullScreenMenuTop = "88px";
			}
			$(".settingsUlSub").css("width","auto").css("bottom","auto").css("right","0").addClass("addBorderBottom").removeClass("addBorderRight").css("height","35px");
			$(".settingsUlSub li").not(".subMenuToggle").css("display","inline-block");
			$(".menuTitle").not(".menuBreak , .fullScreenNotificationTitle").hide();
		}
		else
		{
			$(".settingsUlSub").css("width","200px").css("bottom","0").css("right","auto").removeClass("addBorderBottom").addClass("addBorderRight").css("height","auto");
			$(".settingsUlSub li").not(".subMenuToggle").css("display","block");
			$(".menuTitle").not(".fullScreenMenuText").show();
			toggleAddonAppsMenuText();
		}

		if(document.getElementById("mainContentFullScreenMenu").style.left !== mainContentFullScreenMenuLeft+"px")
		{
			document.getElementById("mainContentFullScreenMenu").style.left = mainContentFullScreenMenuLeft+"px";
		}
		if(document.getElementById("mainContentFullScreenMenu").style.top !== mainContentFullScreenMenuTop)
		{
			document.getElementById("mainContentFullScreenMenu").style.top = mainContentFullScreenMenuTop;
		}
		if(document.getElementById("notificationHolder").style.width !== (window.innerWidth - mainContentFullScreenMenuLeft)+"px")
		{
			document.getElementById("notificationHolder").style.width = (window.innerWidth - mainContentFullScreenMenuLeft)+"px";
		}
	}
	catch(e)
	{
		eventThrowException(e);
	}
}

function toggleAddonAppsMenuText()
{
	if(!checkIfAddonsAreInstalled())
	{
		document.getElementById("menuOtherApps").style.display = "none";
	}
	else
	{
		document.getElementById("menuOtherApps").style.display = "list-item";
	}
}
function checkIfAddonsAreInstalled()
{
	if(typeof listOfAddons === "object")
	{
		let listOfAddonKeys = Object.keys(listOfAddons);
		let listOfAddonKeysLength = listOfAddonKeys.length;
		for(let addCount = 0; addCount < listOfAddonKeysLength; addCount++)
		{
			if(listOfAddons[listOfAddonKeys[addCount]]["Installed"] !== false && listOfAddons[listOfAddonKeys[addCount]]["Installed"] !== "false")
			{
				return true;
			}
		}
	}
	return false;
}

function togglePollSpeedDown(currentClick)
{
	if(userPaused || pausePollCurrentSession || currentClick !== fullScreenMenuClickCount)
	{
		return;
	}
	clearPollTimer();
	if(fullScreenMenuPollSwitchType === "BGrate")
	{
		pollingRateBackup = pollingRate;
		pollingRate = backgroundPollingRate;
		startPollTimer();
	}
}

function togglePollSpeedUp()
{
	if(userPaused || pausePollCurrentSession)
	{
		return;
	}
	clearPollTimer();
	if(pollingRateBackup !== 0)
	{
		pollingRate = pollingRateBackup;
	}
	pollingRateBackup = 0;
	startPollTimer();
}
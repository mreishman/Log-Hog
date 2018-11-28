var timerForLoadJS = null;
var counterForJSLoad = 0;
var loadedFile = false;
var arrayOfJsFiles = {
	0:  {name: "core/template/base.css", type: "css"},
	1:  {name: "core/template/loading-bar.css", type: "css"},
	2:  {name: baseUrl + "template/theme.css", type: "css"},
	3:  {name: "jquery.js", type: "js"},
	4:  {name: "visibility.core.js", type: "js"},
	5:  {name: "visibility.fallback.js", type: "js"},
	6:  {name: "visibility.timers.js", type: "js"},
	7:  {name: "loading-bar.min.js", type: "js"},
	8:  {name: "main.js", type: "js"},
	9:  {name: "rightClickJS.js", type: "js"},
	10: {name: "update.js", type: "js"},
	11: {name: "settings.js", type: "js"},
	12: {name: "loghogDownloadJS.js", type: "js"},
	13: {name: "jscolor.js", type: "js"},
	14: {name: "colorScheme.js", type: "js"},
	15: {name: "addons.js", type: "js"},
	16: {name: "menu.js", type: "js"},
	17: {name: "notifications.js", type: "js"},
	18: {name: "fullscreenMenu.js", type: "js"},
	19: {name: baseUrl + "img/menu.png", type: "img", class:"menuImageForLoad"},
	20: {name: baseUrl + "img/play.png", type: "img", class:"playImageForLoad"},
	21: {name: baseUrl + "img/pause.png", type: "img", class:"pauseImageForLoad"},
	22: {name: baseUrl + "img/refresh.png", type: "img", class:"refreshImageForLoad"},
	23: {name: baseUrl + "img/infoSideBar.png", type: "img", class:"infoSideBarImageForLoad"},
	24: {name: baseUrl + "img/eraserSideBar.png", type: "img", class:"eraserSideBarImageForLoad"},
	25: {name: baseUrl + "img/trashCanSideBar.png", type: "img", class:"trashCanSideBarImageForLoad"},
	26: {name: baseUrl + "img/downArrowSideBar.png", type: "img", class:"downArrowSideBarImageForLoad"},
	27: {name: baseUrl + "img/gear.png", type: "img", class:"gearImageForLoad"}
};
var countForCheck = 1;
var arrayOfJsFilesKeys = Object.keys(arrayOfJsFiles);
var lengthOfArrayOfJsFiles = arrayOfJsFilesKeys.length;

function updateCustomLoadImages()
{
	if(sendCrashInfoJS === "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: "Raven.js", type: "js"};
	}
	if(expFormatEnabled === "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: "format.js", type: "js"};
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: "dateFormat.min.js", type: "js"};
	}
	if(themesEnabled === "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: "themes.js", type: "js"};
	}
	if(oneLogEnable === "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: "oneLog.js", type: "js"};
	}
	if(enableHistory === "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: "archive.js", type: "js"};
	}
	if(enableMultiLog === "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: "multilog.js", type: "js"};
	}
	if(truncateLog === "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: baseUrl + "img/eraserMulti.png", type: "img", class:"eraserMultiImageForLoad"};
	}
	if(truncateLog === "false")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: baseUrl + "img/eraser.png", type: "img", class:"eraserForLoad"};
	}
	if(enableMultiLog === "true" && multiLogOnIndex === "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: baseUrl + "img/multiLog.png", type: "img", class:"multiLogImageForLoad"};
	}
	if(hideClearAllNotifications !== "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: baseUrl + "img/notificationClear.png", type: "img", class:"notificationClearImageForLoad"};
	}
	if(hideNotificationIcon !== "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: "local/default/img/notification.png", type: "img", class:"notificationImageForLoad"};
	}
	if(windowConfig !== "1x1")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: baseUrl + "img/pin.png", type: "img", class:"pinImageForLoad"};
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: baseUrl + "img/pinPinned.png", type: "img", class:"pinPinnedImageForLoad"};
	}
	if(enableHistory === "true")
	{
		arrayOfJsFiles[Object.keys(arrayOfJsFiles).length] = {name: baseUrl + "img/history.png", type: "img", class:"historyImageForLoad"};
	}
}

function tryLoadJSStuff()
{
	var currentFileType = arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["type"];
	if(currentFileType === "js")
	{
		if(document.getElementById("initialLoadContentInfo").innerHTML !== "Loading Javascript Files")
		{
			document.getElementById("initialLoadContentInfo").innerHTML = "Loading Javascript Files";
		}
	}
	else if(currentFileType === "css")
	{
		if(document.getElementById("initialLoadContentInfo").innerHTML !== "Loading CSS Files")
		{
			document.getElementById("initialLoadContentInfo").innerHTML = "Loading CSS Files";
		}
	}
	else if(currentFileType === "img")
	{
		if(document.getElementById("initialLoadContentInfo").innerHTML !== "Loading Images")
		{
			document.getElementById("initialLoadContentInfo").innerHTML = "Loading Images";
		}
	}
	if(typeof script === "function")
	{
		clearInterval(timerForLoadJS);
		loadedFile = false;
		var nameOfCurrentFile = arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["name"];
		document.getElementById("initialLoadContentMoreInfo").innerHTML = nameOfCurrentFile;
		var versionToAdd = cssVersion;
		if(currentFileType === "js")
		{
			versionToAdd = jsVersion;
		}
		var nameOfFile = nameOfCurrentFile+"?v="+versionToAdd;
		if(currentFileType === "js")
		{
			nameOfFile = "core/js/"+nameOfFile;
			script(nameOfFile);
			document.getElementById(nameOfFile.replace(/[^a-z0-9]/g, "")).addEventListener('load', function() {
				loadedFile = true;
			}, false);
		}
		else if(currentFileType === "css")
		{
			css(nameOfFile)
			document.getElementById(nameOfFile.replace(/[^a-z0-9]/g, "")).addEventListener('load', function() {
				loadedFile = true;
			}, false);
		}
		else if(currentFileType === "img")
		{
			loadImgFromData(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["class"]);
			document.getElementsByClassName(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["class"])[0].addEventListener('load', function() {
				loadedFile = true;
			}, false);
		}
		timerForLoadJS = setInterval(checkIfJSLoaded, 25);
	}
}
function checkIfJSLoaded()
{
	if(loadedFile === true)
	{
		if(document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display !== "none")
		{
			document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display = "none";
		}
		countForCheck = 1;
		clearInterval(timerForLoadJS);
		counterForJSLoad++;
		document.getElementById("initialLoadProgress").value = ((counterForJSLoad/lengthOfArrayOfJsFiles) * 100);
		if(counterForJSLoad >= lengthOfArrayOfJsFiles)
		{
			document.getElementById("mainContent").style.display = "block";
			if(sendCrashInfoJS === "true")
			{
				startSentryStuff();
			}
			mainReady();
			$('#initialLoadContent').addClass("hidden");
			setTimeout(function()
			{
				if($("#initialLoadContent").hasClass("hidden"))
				{
					document.getElementById('initialLoadContent').style.display = "none";
				}
			}, 1000);
		}
		else
		{
			setTimeout(function() {
				timerForLoadJS = setInterval(tryLoadJSStuff, 25);
			}, 25);
		}
	}
	else
	{
		countForCheck++;
		document.getElementById("initialLoadCountCheck").innerHTML = countForCheck;
		if(countForCheck > 100)
		{
			if(document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display === "none")
			{
				document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display = "block";
			}
		}
		if(countForCheck > 1000)
		{
			//error
			clearInterval(timerForLoadJS);
			window.location.href = "error.php?error=15&page="+arrayOfJsFiles[counterForJSLoad];
		}
	}
}
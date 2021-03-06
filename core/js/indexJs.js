var timerForLoadJS = null;
var counterForJSLoad = 0;
var loadedFile = false;
var msDelay = 20;
var countForCheck = 1;

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
		let nameOfCurrentFile = arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["name"];
		let versionOfCurrentFile = arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["ver"];
		updatePopupLog(nameOfCurrentFile);
		var nameOfFile = nameOfCurrentFile+"?v="+versionOfCurrentFile;
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
			css(nameOfFile);
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
		timerForLoadJS = setInterval(checkIfJSLoaded, msDelay);
	}
}

function updatePopupLog(newLineText)
{
	document.getElementById("initialLoadContentMoreInfo").innerHTML = newLineText + "<br>" + document.getElementById("initialLoadContentMoreInfo").innerHTML;
}

function checkIfJSLoaded()
{
	if(loadedFile === true)
	{
		if(document.getElementById("initialLoadContentEvenMoreInfo").style.display !== "none")
		{
			document.getElementById("initialLoadContentEvenMoreInfo").style.display = "none";
		}
		if(document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display !== "none")
		{
			document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display = "none";
		}
		countForCheck = 1;
		clearInterval(timerForLoadJS);
		counterForJSLoad++;
		document.getElementById("initialLoadProgress").value = ((counterForJSLoad/lengthOfArrayOfJsFiles) * 100) / 2;
		if(counterForJSLoad >= lengthOfArrayOfJsFiles)
		{
			document.getElementById("mainContent").style.display = "block";
			if(sendCrashInfoJS === "true")
			{
				startSentryStuff();
			}
			mainReady();
		}
		else
		{
			document.getElementById("initialLoadContentCountInfo").innerHTML = "File: "+(counterForJSLoad+1)+"/"+lengthOfArrayOfJsFiles;
			setTimeout(function() {
				timerForLoadJS = setInterval(tryLoadJSStuff, msDelay);
			}, msDelay);
		}
	}
	else
	{
		countForCheck++;
		document.getElementById("initialLoadCountCheck").innerHTML = countForCheck;
		if(countForCheck > 100)
		{
			if(document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display !== "block")
			{
				document.getElementById("initialLoadContentEvenEvenMoreInfo").style.display = "block";
			}
			if(document.getElementById("initialLoadContentEvenMoreInfo").style.display !== "block")
			{
				document.getElementById("initialLoadContentEvenMoreInfo").style.display = "block";
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
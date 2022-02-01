var timerForLoadJS = null;
var counterForJSLoad = 0;
var loadedFile = false;
var msDelay = 20;
var countForCheck = 1;

var loadTimeStart = 0;
var loadTimeEnd = 0;

var loadTimesForFiles = [];

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
		updatePopupLog(nameOfCurrentFile + "(" + formatLoadFileSize(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["size"]) + ")");
		var nameOfFile = nameOfCurrentFile+"?v="+versionOfCurrentFile;
		loadTimeStart = performance.now();
		if(currentFileType === "js")
		{
			nameOfFile = "core/js/"+nameOfFile;
			script(nameOfFile);
			document.getElementById(nameOfFile.replace(/[^a-z0-9]/g, "")).addEventListener('load', function() {
				loadTimeEnd = performance.now();
				loadedFile = true;
			}, false);
		}
		else if(currentFileType === "css")
		{
			css(nameOfFile);
			document.getElementById(nameOfFile.replace(/[^a-z0-9]/g, "")).addEventListener('load', function() {
				loadTimeEnd = performance.now();
				loadedFile = true;
			}, false);
		}
		else if(currentFileType === "img")
		{
			loadImgFromData(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["class"]);
			document.getElementsByClassName(arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["class"])[0].addEventListener('load', function() {
				loadTimeEnd = performance.now();
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
		let timeTaken = loadTimeEnd - loadTimeStart;
		if (timeTaken < 1) {
			timeTaken = 1;
		}
		
		let bytesPerSecond = arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["size"] / timeTaken;
		if (loadTimesForFiles.length > 10) {
			loadTimesForFiles.shift();
		}
		loadTimesForFiles.push(bytesPerSecond);
		let loadTimeFilesArrLength = loadTimesForFiles.length;
		let totalTimes = 0;
		for (let i = 0; i < loadTimeFilesArrLength; i++) {
		    totalTimes += loadTimesForFiles[i] << 0;
		}
		let avgBytesPerSecond = totalTimes / (loadTimeFilesArrLength);

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
			//done loading files, start with logs
			document.getElementById("mainContent").style.display = "block";
			mainReady();
		}
		else
		{
			//more files needed
			let newFileSize = arrayOfJsFiles[arrayOfJsFilesKeys[counterForJSLoad]]["size"];
			let estTimeToDownload = Math.ceil(newFileSize/avgBytesPerSecond);
			msDelay = Math.ceil(estTimeToDownload/2);

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

function formatLoadFileSize(bytes)
{
	if(parseInt(bytes) === 0)
	{
		return "0 Bytes";
	}
	var k = 1024;
	var sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
	var i = Math.floor(Math.log(bytes) / Math.log(k));
	return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
}
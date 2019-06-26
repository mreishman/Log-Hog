var reportRedWarningArr = {
	0:"FATAL",
	1:"ERROR",
	2:"CRITICAL"
};

var reportYellowWarningArr = {
	0:"WARNING"
};

function getTypeOfReportSev(message)
{
	//check for info stuff
	let arrOfArrs = {
		0: reportRedWarningArr,
		1: reportYellowWarningArr,
		2: {
			0: "INFO"
		}
	}
	let arrOfArrsKeys = Object.keys(arrOfArrs);
	let arrOfArrsKeysLength = arrOfArrsKeys.length;
	for(let AOAKLCount = 0; AOAKLCount < arrOfArrsKeysLength; AOAKLCount++)
	{
		let innerArr = arrOfArrs[arrOfArrsKeys[AOAKLCount]];
		let innerArrKeys = Object.keys(innerArr);
		let innerArrKeysLength = innerArrKeys.length;
		for(let IAKCount = 0; IAKCount < innerArrKeysLength; IAKCount++)
		{
			if(message.indexOf("report."+innerArr[innerArrKeys[IAKCount]]) > -1)
			{
				return innerArr[innerArrKeys[IAKCount]];
			}
		}
	}
	return false;
}

function formatReportMessage(message, extraData) //used for file check
{
	message = message.split(":");
	let firstPart = message[0];
	message.shift();
	if(message.length > 1)
	{
		message = message.join(":");
	}
	//get severity level
	let severity = "";
	//check for same type last line
	var arrayOfTextLastLine = {
		0: "",
		1: "",
		2: "",
		timeFound: false
	};
	if("lastLine" in extraData && extraData["lastLine"] !== "")
	{
		arrayOfTextLastLine = dateTimeSplit(extraData["lastLine"]);
	}
	let lastLineFormatError = getTypeOfReportSev(arrayOfTextLastLine[1]);
	let thisLineFormatError = getTypeOfReportSev(firstPart);
	let lastErrorSame = false;
	if(lastLineFormatError === thisLineFormatError)
	{
		//check if time is same as well
		if(extraData["lastLineSame"])
		{
			lastErrorSame = true;
		}
	}
	//check for same type next line
	var arrayOfTextNextLine = {
		0: "",
		1: "",
		2: "",
		timeFound: false
	};
	if("nextLine" in extraData && extraData["nextLine"] !== "")
	{
		arrayOfTextNextLine = dateTimeSplit(extraData["nextLine"]);
	}
	let nextLineFormatError = getTypeOfReportSev(arrayOfTextNextLine[1]);
	let nextErrorSame = false;
	if(nextLineFormatError === thisLineFormatError)
	{
		//check if time is same as well
		if(extraData["nextLineSame"])
		{
			nextErrorSame = true;
		}
	}
	//other stuff
	if(logFormatReportShowImg === "true")
	{
		let firstPartArr = firstPart.split(".");
		severity = "<img src=\""+getReportSeverifyLevel(firstPartArr[1])+"\" height=\"15px\">";
	}
	let lineToReturn = "";
	if(!lastErrorSame)
	{
		lineToReturn += "<div>"+severity+firstPart+"</div>";
	}
	let classToAdd = " settingsDiv ";
	if(lastErrorSame)
	{
		classToAdd += " settingsDivRemoveTop ";
	}
	if(nextErrorSame)
	{
		classToAdd += " settingsDivRemoveBottom ";
	}
	lineToReturn += "<div class=\""+classToAdd+"\">"+formatMainMessage(message, extraData)+"</div>";
	return lineToReturn;
}

function getReportSeverifyLevel(snippit)
{
	return getSeverifyLevel(snippit, reportRedWarningArr, reportYellowWarningArr);
}
/* Date Time Arrays */

var arrOfDaysSmall = {
	1: "Mon",
	2: "Tue",
	3: "Wed",
	4: "Thu",
	5: "Fri",
	6: "Sat",
	7: "Sun"
};
var arrOfDaysLarge = {
	1: "Monday",
	2: "Tuesday",
	3: "Wednesday",
	4: "Thursday",
	5: "Friday",
	6: "Saturday",
	7: "Sunday"
};
var arrOfMonthsSmall = {
	1:  "Jan",
	2:  "Feb",
	3:  "Mar",
	4:  "Apr",
	5:  "May",
	6:  "Jun",
	7:  "Jul",
	8:  "Aug",
	9:  "Sep",
	10: "Oct",
	11: "Nov",
	12: "Dec"
};
var arrOfMonthsLarge = {
	1:  "January",
	2:  "February",
	3:  "March",
	4:  "April",
	5:  "May",
	6:  "June",
	7:  "July",
	8:  "August",
	9:  "September",
	10: "October",
	11: "November",
	12: "December"
};

/* Report arrs */

var reportRedWarningArr = {
	0:"FATAL",
	1:"ERROR",
	2:"CRITICAL"
};

var reportYellowWarningArr = {
	0:"WARNING"
};

/* Start of functions for formatting*/

function formatLine(text, extraData)
{
	extraData["lastLineSame"] = false;
	var arrayOfText = dateTimeSplit(text);
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
	let timeFormat = dateTimeFormat(arrayOfText);
	extraData["lastLineSame"] = (arrayOfText[0] === arrayOfTextLastLine[0]);
	if(dateTextGroup === "true" && extraData["lastLineSame"])
	{
		timeFormat = "";
	}
	if(dateTextFormatColumn === "true" || (dateTextFormatColumn === "auto" && window.innerWidth > breakPointTwo))
	{
		if("lineDisplay" in extraData && extraData["lineDisplay"] === "true")
		{
			return "<td style=\"white-space:nowrap;width: 1%;\">" + timeFormat + extraData["lineCount"] + "</td><td style=\"white-space: pre-wrap;\">" + formatMainMessage(arrayOfText[1], extraData) + "</td>";
		}
		return "<td style=\"white-space:nowrap;width: 1%;\">" + timeFormat + "</td><td style=\"white-space: pre-wrap;\">" + formatMainMessage(arrayOfText[1], extraData) + "</td>";
	}
	else if("lineDisplay" in extraData && extraData["lineDisplay"] === "true")
	{
		return "<td style=\"white-space:nowrap;width: 1%;\">" + extraData["lineCount"] + "</td><td style=\"white-space: pre-wrap;\">" + timeFormat + formatMainMessage(arrayOfText[1], extraData) + "</td>";
	}
	return "<td style=\"white-space: pre-wrap;\">" + timeFormat + formatMainMessage(arrayOfText[1], extraData) + "</td>";
}


function dateTimeSplit(text)
{
	var returnObject = {
		0: "",
		1: text,
		2: "",
		timeFound: false
	};
	text = text.trim(); //remove extra spaces
	//check for start of time stamp. Could be: ( [ or just a number
	var regExLoop = {
		0: {
			regex: /[0-9]{1,4}(\D[0-9]{1,2}){5}(\D?AM|\D?PM)?(\D[0-9]{1,2}){0,2}/i
		},
		1: {
			regex: /(\w{3} ){2}[0-9]{1,2}(.[0-9]{2}){3}(.[0-9]{6})?.[0-9]{4}/i
		}
	};
	var keysOfRegExLoop = Object.keys(regExLoop);
	var regExLoopCount = keysOfRegExLoop.length;
	for(var regExLoopCounter = 0; regExLoopCounter < regExLoopCount; regExLoopCounter++)
	{
		var textInfo = regExLoop[keysOfRegExLoop[regExLoopCounter]]["regex"].exec(text);
		if(textInfo !== null)
		{
			var positionOfExpression = textInfo.index;
			if(positionOfExpression < 5)
			{
				var lengthOfExpression = textInfo[0].length;
				var endPosition = (positionOfExpression * 2) + lengthOfExpression;
				returnObject[0] = text.substring(0,endPosition).trim(); //date
				returnObject[2] = text.substring(positionOfExpression,lengthOfExpression+1).trim(); //date no extras
				returnObject[1] = text.substring(endPosition).trim(); //rest of text
				returnObject["timeFound"] = regExLoopCounter;
			}
			break;
		}
	}

	return returnObject;
}

function formatMainMessage(message, extraData)
{
	if(message.indexOf("{") > -1 && message.lastIndexOf("}") > message.indexOf("{"))
	{
		let messageData = formatJsonMessage(message, extraData);
		if(messageData["success"] === true)
		{
			return messageData["text"];
		}
	}
	if(logFormatPhpEnable === "true")
	{
		if(message.indexOf("PHP message:") > -1)
		{
			return formatPhpMessage(message, extraData);
		}
	}
	if(logFormatReportEnable === "true")
	{
		if(message.indexOf("report.") > -1)
		{
			found = getTypeOfReportSev(message);
			if(found !== false)
			{
				return formatReportMessage(message, extraData);
			}
		}
	}
	//check if message is in arrayOfFileData
	if(logFormatFileEnable === "true")
	{
		let localMessage = unescapeHTML(message);
		if(/(in|at) (.?)([\/]+)([^&\r\n\t]*)(on line|\D:\d)(.?)(\d{1,10})/.test(localMessage))
		{
			let stringLengthMatch = -1;
			let fileData = "";
			var arrayOfFileDataKeys = Object.keys(arrayOfFileData);
			var arrayOfFileDataKeysLength = arrayOfFileDataKeys.length;
			for(var AOFDCount = 0; AOFDCount < arrayOfFileDataKeysLength; AOFDCount++)
			{
				let localMessageIndex = localMessage.indexOf(arrayOfFileDataKeys[AOFDCount]);
				if(localMessageIndex > -1 && arrayOfFileData[arrayOfFileDataKeys[AOFDCount]]["fileData"] !== "Error - File Not Found")
				{
					let stringLength = arrayOfFileDataKeys[AOFDCount].length;
					if(stringLength > stringLengthMatch)
					{
						fileData = arrayOfFileData[arrayOfFileDataKeys[AOFDCount]];
						stringLengthMatch = stringLength;
					}
				}
			}
			if(stringLengthMatch > -1)
			{
				//this message matches file data, add this below
				extraData["fileData"] = fileData;
				return formatMessageFileData(localMessage, extraData);
			}
		}
	}
	return message;
}

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

function formatReportMessage(message, extraData)
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
	lineToReturn += "<div class=\"settingsDiv\">"+formatMainMessage(message, extraData)+"</div>";
	return lineToReturn;
}

function getReportSeverifyLevel(snippit)
{
	return getSeverifyLevel(snippit, reportRedWarningArr, reportYellowWarningArr);
}

function getSeverifyLevel(snippit, redWarningArr, yellowWarningArr)
{
	var redWarningArrKeys = Object.keys(redWarningArr);
	var redWarningArrLength = redWarningArrKeys.length;
	for (var rwaCount = 0; rwaCount < redWarningArrLength; rwaCount++)
	{
		if(snippit.indexOf(redWarningArr[redWarningArrKeys[rwaCount]]) > -1)
		{
			return arrayOfImages["redWarning"]["src"];
		}
	}
	var yellowWarningArrKeys = Object.keys(yellowWarningArr);
	var yellowWarningArrLength = yellowWarningArrKeys.length;
	for (var rwaCount = 0; rwaCount < yellowWarningArrLength; rwaCount++)
	{
		if(snippit.indexOf(yellowWarningArr[yellowWarningArrKeys[rwaCount]]) > -1)
		{
			return arrayOfImages["yellowWarning"]["src"];
		}
	}

	return arrayOfImages["info"]["src"];
}

function formatMoreInfo(objOfInfo)
{
	returnHtml = "<table>";
	returnHtml += "<tr><th>More Info: <span onclick=\"toggleInfoSidebar();\" class=\"linkSmall\" >Close</span></th></tr>"
	let objOfInfoKeys = Object.keys(objOfInfo);
	let objOfInfoKeysLength = objOfInfoKeys.length;
	let borderBottomClass = " class=\"addBorderBottom\" style=\"padding-bottom: 3px;\" ";
	for(let OOIKCount = 0; OOIKCount < objOfInfoKeysLength; OOIKCount++)
	{
		returnHtml += "<tr><td style=\"margin-top: 5px;\" "+borderBottomClass+" ><b>"+objOfInfo[objOfInfoKeys[OOIKCount]]["hit"]+"</b></td></tr>";
		if("" !== objOfInfo[objOfInfoKeys[OOIKCount]]["syntax"])
		{
			returnHtml += "<tr><td "+borderBottomClass+" ><b>Syntax: </b></td></tr>";
			returnHtml += "<tr><td>"+objOfInfo[objOfInfoKeys[OOIKCount]]["syntax"]+"</td></tr>";
		}
		returnHtml += "<tr><td "+borderBottomClass+" ><b>Definition: </b></td></tr>";
		returnHtml += "<tr><td>"+objOfInfo[objOfInfoKeys[OOIKCount]]["info"]+"</td></tr>";
		if(objOfInfo[objOfInfoKeys[OOIKCount]]["moreinfo"] !== "")
		{
			//add show more button with more info
			if(logFormatShowMoreExtraInfo === "false")
			{
				returnHtml += "<tr><td style=\"padding-bottom: 5px;\"> <span class=\"linkSmall showMoreEvenMore"+OOIKCount+"\" onclick=\"showEvenMoreInfo("+OOIKCount+");\" >Show More</span></td></tr>";
			}
			let styleForMoreMoreInfo = "none";
			if(logFormatShowMoreExtraInfo === "false")
			{
				styleForMoreMoreInfo = "block";
			}
			returnHtml += "<tr><td><span style=\"display: "+styleForMoreMoreInfo+";\" class=\"evenMoreInfo"+OOIKCount+"\" >"+objOfInfo[objOfInfoKeys[OOIKCount]]["moreinfo"]+"</span></td></tr>";
			if(logFormatShowMoreExtraInfo === "false")
			{
				returnHtml += "<tr><td><span style=\"display: none;\" class=\"linkSmall hideMoreEvenMore"+OOIKCount+"\" onclick=\"hideEvenMoreInfo("+OOIKCount+");\" >Show Less</span></td></tr>";
			}
		}
		if("" !== objOfInfo[objOfInfoKeys[OOIKCount]]["link"])
		{
			returnHtml += "<tr><td "+borderBottomClass+" ><b>Link:</b></td></tr>";
			returnHtml += "<tr><td><a href=\""+objOfInfo[objOfInfoKeys[OOIKCount]]["link"]+"\" target=\"_blank\">"+objOfInfo[objOfInfoKeys[OOIKCount]]["link"]+"</a></td></tr>";
		}
		if("" !== objOfInfo[objOfInfoKeys[OOIKCount]]["link2"])
		{
			returnHtml += "<tr><td><a href=\""+objOfInfo[objOfInfoKeys[OOIKCount]]["link2"]+"\" target=\"_blank\">"+objOfInfo[objOfInfoKeys[OOIKCount]]["link2"]+"</a></td></tr>";
		}
	}
	returnHtml += "</table>";
	return returnHtml;
}

function showMoreInfo(e)
{
	showInfoSidebar();
	let htmlForSidebar = $(e).siblings('div').html();
	$("#moreInfoSideBar").html(htmlForSidebar);
}

function showEvenMoreInfo(id)
{
	$("#moreInfoSideBar .evenMoreInfo"+id).show();
	$("#moreInfoSideBar .showMoreEvenMore"+id).hide();
	$("#moreInfoSideBar .hideMoreEvenMore"+id).show();
}

function hideEvenMoreInfo(id)
{
	$("#moreInfoSideBar .evenMoreInfo"+id).hide();
	$("#moreInfoSideBar .showMoreEvenMore"+id).show();
	$("#moreInfoSideBar .hideMoreEvenMore"+id).hide();
}

function formatJsonMessage(message, extraData)
{
	let defaultMessage = {
		text: message,
		success: false
	};
	//try to json decode
	var jsonMessage = message.substring(message.indexOf("{"),message.lastIndexOf("}") + 1);
	if(jsonMessage !== "")
	{
		var newMessage = jsonDecodeTry(jsonMessage);
		var excapeHTML = false;
		if(typeof newMessage !== "object")
		{
			var newerMessage = unescapeHTML(jsonMessage);
			if(newerMessage !== "")
			{
				newMessage = jsonDecodeTry("" + newerMessage);
				excapeHTML = true;
				if(typeof newMessage !== "object")
				{
					newerMessage = unescapeHTML(jsonMessage).replace(/\\/g,"\\\\");
					if(newerMessage !== "")
					{
						newMessage = jsonDecodeTry("" + newerMessage);
						excapeHTML = true;
						if(typeof newMessage !== "object")
						{
							//console.log(unescapeHTML(jsonMessage));
							return defaultMessage;
						}
					}
					else
					{
						return defaultMessage;
					}
				}
			}
			else
			{
				return defaultMessage;
			}
		}
		var testReturn = "<table>";
		var extraTrClass = "";
		if("customClassAdd" in extraData && extraData["customClassAdd"])
		{
			extraTrClass = extraData["customClass"];
		}
		let initialMessageText = message.substr(0, message.indexOf('{'));
		testReturn += "<tr "+extraTrClass+"><td colspan=\"2\">"+formatMainMessage(initialMessageText,extraData)+"</td></tr>";
		var messageKeys = Object.keys(newMessage);
		var messageKeysLength = messageKeys.length;
		for (var messageCount = 0; messageCount < messageKeysLength; messageCount++)
		{
			var messageOne = messageKeys[messageCount];
			var messageTwo = newMessage[messageKeys[messageCount]];
			var messageTwoIsObject = false;
			if(typeof messageTwo === "object")
			{
				messageTwo = formatMainMessage(JSON.stringify(messageTwo), extraData);
				messageTwoIsObject = true;
			}
			if(excapeHTML)
			{
				messageOne = escapeHTML(messageOne);
				if(!messageTwoIsObject)
				{
					messageTwo = escapeHTML(messageTwo);
				}
			}
			testReturn += "<tr "+extraTrClass+"><td style=\"word-break: normal;\">"+formatMainMessage(messageOne,extraData)+"</td><td>"+formatMainMessage(messageTwo,extraData)+"</td></tr>";
		}
		let lastMessageText = message.substr(message.lastIndexOf('}') + 1);
		testReturn += "<tr "+extraTrClass+"><td colspan=\"2\">"+formatMainMessage(lastMessageText,extraData)+"</td></tr>";
		testReturn += "</table>";
		return {
			text: testReturn,
			success: true
		};
	}
	return defaultMessage;
}

function jsonDecodeTry(jsonTry)
{
	try
	{
		var possibleJson = JSON.parse(jsonTry);
		return possibleJson;
	}
	catch(e)
	{
		//console.log(e);
	}
	return false;
}

function dateTimeFormat(dateTextArray)
{
	if(dateTextFormat === "hidden")
	{
		return "";
	}
	var dateText = dateTextArray[0];
	var timeFormat = dateTextArray["timeFound"];
	var justDateText = dateTextArray[2];
	if(dateText === "" || dateTextFormat === "default")
	{
		return dateText;
	}

	var newConfDate = "Invalid Date";
	if(timeFormat === 0 || timeFormat === 1)
	{
		newConfDate = new Date(justDateText);
		if(String(newConfDate) === "Invalid Date" || String(newConfDate) === "NaN")
		{
			var justDateTextTmp = justDateText.replace(/[A-Z]/," ");
			newConfDate = new Date(justDateTextTmp);
		}
	}
	if(String(newConfDate) === "Invalid Date" || String(newConfDate) === "NaN")
	{
		newConfDate = DateFormat.format(justDateText);
	}
	if(String(newConfDate) !== "Invalid Date" && String(newConfDate) !== "NaN")
	{
		var hours = newConfDate.getHours();
		var hours12 = hours;
		var ampm = "AM";
		if(hours < 10)
		{
			hours = "0"+hours;
			hours12 = hours;
		}
		else if(hours > 12)
		{
			ampm = "PM";
			hours12 = hours - 12;
			if(hours12 < 10)
			{
				hours12 = hours;
			}
		}
		var min = newConfDate.getMinutes();
		if(min < 10)
		{
			min = "0"+min;
		}
		var sec = newConfDate.getSeconds();
		if(sec < 10)
		{
			sec = "0"+sec;
		}
		var day = newConfDate.getDate();
		if(day < 10)
		{
			day = "0"+day;
		}
		var month = newConfDate.getMonth()+1; //January is 0!
		if(month < 10)
		{
			month = "0"+month;
		}
		var mili = newConfDate.getMilliseconds();
		var yearFull = newConfDate.getFullYear();
		var dayName = newConfDate.getDay(); //1 is monday, 2 tuesday, etc
		var localDateTextFormat = dateTextFormat;
		if(dateTextFormat === "custom")
		{
			localDateTextFormat = dateTextFormatCustom;
		}
		var dateTextFormatArray = localDateTextFormat.split("|");
		var dateTextFormatArrayLength = dateTextFormatArray.length;
		var stringForNewTime = "";
		var arrOfOptions = {
			0: {
				"search" : "hh",
				"replace": hours
			},
			1: {
				"search" : "mm",
				"replace": min
			},
			2: {
				"search" : "ss",
				"replace": sec
			},
			3: {
				"search" : "DD",
				"replace": day
			},
			4: {
				"search" : "MM",
				"replace": month
			},
			5: {
				"search" : "YYYY",
				"replace": yearFull
			},
			6: {
				"search" : "PartDay",
				"replace": arrOfDaysSmall[parseInt(dayName)]
			},
			7: {
				"search" : "FullDay",
				"replace": arrOfDaysLarge[parseInt(dayName)]
			},
			8: {
				"search" : "PartMonth",
				"replace": arrOfMonthsSmall[parseInt(month)]
			},
			9: {
				"search" : "FullMonth",
				"replace": arrOfMonthsLarge[parseInt(month)]
			},
			10: {
				"search" : "mili",
				"replace": mili
			},
			11: {
				"search" : "hh12",
				"replace": hours12
			},
			12: {
				"search" : "AMPM",
				"replace": ampm
			}
		};
		var arrOfOptionsKeys = Object.keys(arrOfOptions);
		var lengthOfOptionKeys = arrOfOptionsKeys.length;
		for(var dtfCount = 0; dtfCount < dateTextFormatArrayLength; dtfCount++)
		{
			var currentSection = dateTextFormatArray[dtfCount];
			if(currentSection === "" || currentSection.indexOf("none") > -1)
			{
				continue;
			}
			var added = false;
			for(var optionCount = 0; optionCount < lengthOfOptionKeys; optionCount++)
			{
				var currentSearch = arrOfOptions[arrOfOptionsKeys[optionCount]]["search"];
				var currentReplace = arrOfOptions[arrOfOptionsKeys[optionCount]]["replace"];
				if(currentSection.indexOf(currentSearch) > -1)
				{
					stringForNewTime += currentSection.replace(currentSearch, currentReplace);
					added = true;
					break;
				}
			}
			if(!added)
			{
				stringForNewTime += currentSection;
			}
		}
		if(stringForNewTime !== "" && stringForNewTime.indexOf("NaN") === -1)
		{
			return stringForNewTime;
		}
	}


	return dateText;
}

function toggleInfoSidebar()
{
	if(document.getElementById("moreInfoSideBar").style.display === "none")
	{
		let newWidth = window.innerWidth - 200;
		newWidth = adjustLogForMenuLocation(newWidth);
		if(typeof adjustLogForSettingsSideBar !== "undefined")
		{
			newWidth = adjustLogForSettingsSideBar(newWidth);
		}
		document.getElementById("log").style.width = newWidth+"px";
		document.getElementById("log").style.marginRight = "200px";
		document.getElementById("moreInfoSideBar").style.display = "inline-block";
	}
	else
	{
		let newWidth = "100%";
		let newWidthTest = window.innerWidth;
		if(typeof adjustLogForSettingsSideBar !== "undefined")
		{
			newWidthTest = adjustLogForSettingsSideBar(newWidthTest);
		}
		if(newWidthTest !== window.innerWidth)
		{
			newWidthTest = adjustLogForMenuLocation(newWidthTest);
			newWidth = newWidthTest;
		}
		document.getElementById("log").style.width = newWidth;
		document.getElementById("log").style.marginRight = "0px";
		document.getElementById("moreInfoSideBar").style.display = "none";
	}
	resize();
}

function showInfoSidebar()
{
	if(document.getElementById("moreInfoSideBar").style.display === "none")
	{
		toggleInfoSidebar();
	}
}

function hideInfoSidebar()
{
	if(document.getElementById("moreInfoSideBar").style.display !== "none")
	{
		toggleInfoSidebar();
	}
}

function adjustLogForInfoSideBar(mainWidth)
{
	if(document.getElementById("moreInfoSideBar").style.display !== "none")
	{
		mainWidth -= 200;
	}
	return mainWidth;
}
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

/* PHP arrays */

var phpRedWarningArr = {
	0:"PHP Fatal",
	1:"PHP Parse error",
	2:"PHP Syntax error"
};

var phpYellowWarningArr = {
	0:"PHP Warning"
};

/* Start of functions for formatting*/

function formatLine(text, extraData)
{
	var arrayOfText = dateTimeSplit(text);
	return "<td style=\"white-space:nowrap;width: 1%;\" >" + dateTimeFormat(arrayOfText) + "</td><td style=\"white-space: pre-wrap;\" >" + formatMainMessage(arrayOfText[1], extraData) + "</td>";
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
		return formatJsonMessage(message, extraData);
	}
	else if(message.indexOf("PHP message:") > -1)
	{
		return formatPhpMessage(message, extraData);
	}
	return message;
}

function formatPhpMessage(message, extraData)
{
	var message = message.split("PHP message:");
	var firstPartOfMessage = message[0];
	message.shift();
	if(typeof message !== "string")
	{
		message = message.join("PHP message:");
	}
	var restOfMessage = message.split(":");
	var messageWarning = restOfMessage[0];
	var severity = getPhpSeverifyLevel(messageWarning);
	restOfMessage.shift();
	restOfMessage = restOfMessage.join(":");
	restOfMessage = parseErrorMessage(restOfMessage, extraData);
	if(firstPartOfMessage !== "")
	{
		firstPartOfMessage = formatMainMessage(firstPartOfMessage, extraData);
	}
	return firstPartOfMessage+"<div><img src=\""+severity+"\" height=\"15px\" >"+messageWarning+"</div><div class=\"settingsDiv\" >"+restOfMessage+"</div>";
}

function parseErrorMessage(restOfMessage, extraData)
{
	//check for client and extra data after that
	//0: main data, 1: client, 2: server, 3: request, 4: upstream, 5: host, 6: referrer
	var arrayOfData = {
		0: {
			"string"	: restOfMessage,
			"key"		: "",
			"position"	: -1
		},
		1: {
			"string"	: "",
			"key"		: "Client:",
			"position"	: restOfMessage.indexOf(", client:")
		},
		2: {
			"string"	: "",
			"key"		: "Server:",
			"position"	: restOfMessage.indexOf(", server:")
		},
		3: {
			"string"	: "",
			"key"		: "Request:",
			"position"	: restOfMessage.indexOf(", request:")
		},
		4: {
			"string"	: "",
			"key"		: "Upstream:",
			"position"	: restOfMessage.indexOf(", upstream:")
		},
		5: {
			"string"	: "",
			"key"		: "Host:",
			"position"	: restOfMessage.indexOf(", host:")
		},
		6: {
			"string"	: "",
			"key"		: "Referrer:",
			"position"	: restOfMessage.indexOf(", referrer:")
		},
	};
	var arrayOfDataKeys = Object.keys(arrayOfData);
	var trimmedMainData = false;
	var atLeastOnePresent = false;
	var skipLogic = false;
	for(var aodc = 1; aodc < 7; aodc++)
	{
		if(!skipLogic)
		{
			//start filter, get lowest position (ext -1) then trim that out (first lowest to second lowest)
			var lowest = -1;
			var lowestPos = 0;
			for(var aodc2 = 1; aodc2 < 7; aodc2++)
			{
				if(arrayOfData[arrayOfDataKeys[aodc2]]["position"] < lowest || lowest === -1)
				{
					atLeastOnePresent = true;
					lowest = arrayOfData[arrayOfDataKeys[aodc2]]["position"];
					lowestPos = aodc2;
				}
			}
			if(lowest !== -1)
			{
				//find second lowest, cut out that part anad add to array of data
				arrayOfData[arrayOfDataKeys[lowestPos]]["position"] = -1;
				var secondLowest = restOfMessage.length;
				for(var aodc3 = 1; aodc3 < 7; aodc3++)
				{
					if(arrayOfData[arrayOfDataKeys[aodc3]]["position"] < secondLowest && arrayOfData[arrayOfDataKeys[aodc3]]["position"] !== -1)
					{
						secondLowest = arrayOfData[arrayOfDataKeys[aodc3]]["position"];
					}
				}
				arrayOfData[arrayOfDataKeys[lowestPos]]["string"] = restOfMessage.substring(lowest + 1, secondLowest);
				if(!trimmedMainData)
				{
					arrayOfData[arrayOfDataKeys[0]]["string"] = restOfMessage.substring(0, lowest);
					trimmedMainData = true;
				}
			}
			else
			{
				skipLogic = true;
			}
		}
	}
	var newHtmlToSend = "";
	for(var aodc4 = 0; aodc4 < 7; aodc4++)
	{
		if(arrayOfData[arrayOfDataKeys[aodc4]]["string"] !== "")
		{
			newHtmlToSend += "<div>"+formatMainMessage(arrayOfData[arrayOfDataKeys[aodc4]]["string"].trim(), extraData)+"</div>";
		}
	}
	return newHtmlToSend;
}

function getPhpSeverifyLevel(snippit)
{
	var phpRedWarningArrKeys = Object.keys(phpRedWarningArr);
	var phpRedWarningArrLength = phpRedWarningArrKeys.length;
	for (var rwaCount = 0; rwaCount < phpRedWarningArrLength; rwaCount++)
	{
		if(snippit.indexOf(phpRedWarningArr[phpRedWarningArrKeys[rwaCount]]) > -1)
		{
			return arrayOfImages["redWarning"]["src"];
		}
	}
	var phpYellowWarningArrKeys = Object.keys(phpYellowWarningArr);
	var phpYellowWarningArrLength = phpYellowWarningArrKeys.length;
	for (var rwaCount = 0; rwaCount < phpYellowWarningArrLength; rwaCount++)
	{
		if(snippit.indexOf(phpYellowWarningArr[phpYellowWarningArrKeys[rwaCount]]) > -1)
		{
			return arrayOfImages["yellowWarning"]["src"];
		}
	}

	return arrayOfImages["info"]["src"];
}

function formatJsonMessage(message, extraData)
{
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
							return message;
						}
					}
					else
					{
						return message;
					}
				}
			}
			else
			{
				return message;
			}
		}
		var testReturn = "<table>";
		var extraTrClass = "";
		if(extraData["customClassAdd"])
		{
			extraTrClass = extraData["customClass"];
		}
		testReturn += "<tr "+extraTrClass+" ><td colspan=\"2\" >"+message.substr(0, message.indexOf('{'))+"</td></tr>";
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
			testReturn += "<tr "+extraTrClass+" ><td style=\"word-break: normal;\" >"+messageOne+"</td><td>"+messageTwo+"</td></tr>";
		}
		testReturn += "<tr "+extraTrClass+" ><td colspan=\"2\" >"+message.substr(message.lastIndexOf('}') + 1)+"</td></tr>";
		testReturn += "</table>";
		return testReturn;
	}
	return message;
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
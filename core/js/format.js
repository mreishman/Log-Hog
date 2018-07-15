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
	1: "Jan",
	2: "Feb",
	3: "Mar",
	4: "Apr",
	5: "May",
	6: "June",
	7: "July",
	8: "Aug",
	9: "Sept",
	10: "Oct",
	11: "Nov",
	12: "Dec"
};
var arrOfMonthsLarge = {
	1: "January",
	2: "February",
	3: "March",
	4: "April",
	5: "May",
	6: "June",
	7: "July",
	8: "August",
	9: "September",
	10: "October",
	11: "November",
	12: "December"
};


function formatLine(text)
{
	if(expFormatEnabled !== "true")
	{
		return "<td>"+text+"<td>";
	}
	var arrayOfText = dateTimeSplit(text);
	return "<td style=\"white-space:nowrap;width: 1%;\" >" + dateTimeFormat(arrayOfText) + "</td><td >" + arrayOfText[1] + "</td>";
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
	var regExpForTimeStampV1 = /[0-9]{1,4}(\D[0-9]{1,2}){5}(\D?AM|\D?PM)?(\D[0-9]{1,2}){0,2}/i;
	var regExpForTimeStampV2 = /(\w{3} ){2}[0-9]{1,2}(.[0-9]{2}){3}(.[0-9]{6})?.[0-9]{4}/i;
	var textInfoV1 = regExpForTimeStampV1.exec(text);
	var textInfoV2 = regExpForTimeStampV2.exec(text);
	//returns null if not found, data if found
	if(textInfoV1 !== null)
	{
		var positionOfExpression = textInfoV1.index;
		if(positionOfExpression < 5)
		{
			var lengthOfExpression = textInfoV1[0].length;
			var endPosition = (positionOfExpression * 2) + lengthOfExpression;
			returnObject[0] = text.substring(0,endPosition).trim(); //date
			returnObject[2] = text.substring(positionOfExpression,lengthOfExpression+1).trim(); //date no extras
			returnObject[1] = text.substring(endPosition).trim(); //rest of text
			returnObject["timeFound"] = 1;
		}
	}
	else if(textInfoV2 !== null)
	{
		var positionOfExpression = textInfoV2.index;
		if(positionOfExpression < 5)
		{
			var lengthOfExpression = textInfoV2[0].length;
			var endPosition = (positionOfExpression * 2) + lengthOfExpression;
			returnObject[0] = text.substring(0,endPosition).trim(); //date
			returnObject[2] = text.substring(positionOfExpression,lengthOfExpression+1).trim(); //date no extras
			returnObject[1] = text.substring(endPosition).trim(); //rest of text
			returnObject["timeFound"] = 2;
		}
	}

	return returnObject;
}

function dateTimeFormat(dateTextArray)
{
	var dateText = dateTextArray[0];
	var timeFormat = dateTextArray["timeFound"];
	var justDateText = dateTextArray[2];
	if(dateText === "" || dateTextFormat === "default")
	{
		return dateText;
	}
	else if(dateTextFormat === "hidden")
	{
		return "";
	}

	var newConfDate = "Invalid Date";
	if(timeFormat === 1 || timeFormat === 2)
	{
		newConfDate = new Date(justDateText);
	}

	if(newConfDate !== "Invalid Date")
	{
		var hours = newConfDate.getHours();
		if(hours < 10)
		{
			hours = "0"+hours;
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
		var dateTextFormatArray = dateTextFormat.split("|");
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
				"replace": arrOfDaysSmall[parseInt(day)]
			},
			7: {
				"search" : "FullDay",
				"replace": arrOfDaysLarge[parseInt(day)]
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
			}
		};
		var arrOfOptionsKeys = Object.keys(arrOfOptions);
		var lengthOfOptionKeys = arrOfOptionsKeys.length;
		for(var dtfCount = 0; dtfCount < dateTextFormatArrayLength; dtfCount++)
		{
			var currentSection = dateTextFormatArray[dtfCount];
			if(currentSection === "" || currentSection.indexOf("none") > -1)
			{
				break;
			}
			for(var optionCount = 0; optionCount < lengthOfOptionKeys; optionCount++)
			{
				var currentSearch = arrOfOptions[arrOfOptionsKeys[optionCount]]["search"];
				var currentReplace = arrOfOptions[arrOfOptionsKeys[optionCount]]["replace"];
				if(currentSection.indexOf(currentSearch) > -1)
				{
					stringForNewTime += currentSection.replace(currentSearch, currentReplace);
					break;
				}
			}
		}
		if(stringForNewTime !== "")
		{
			return stringForNewTime;
		}
	}


	return dateText;
}
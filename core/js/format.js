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
	var regExpForTimeStamp = /[0-9]{1,4}(\D[0-9]{1,2}){5}(\D?AM|\D?PM)?(\D[0-9]{1,2}){0,2}/i;
	// /[0-9]{1,4}\W[0-9]{1,2}\W[0-9]{1,2}\W[0-9]{1,2}\W[0-9]{1,2}\W[0-9]{1,2}((\WAM|AM)|(\WPM|PM))?/i;
	// WILL NOT WORK IF DATE IS FORMATTED LIKE: Mon Sep 4 16:05:04 2017
	var textInfo = regExpForTimeStamp.exec(text);
	//returns null if not found, data if found
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
			returnObject["timeFound"] = 1;
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

	var newConfDate = null;
	if(timeFormat === 1)
	{
		newConfDate = new Date(justDateText);
	}

	if(newConfDate !== null && newConfDate !== "Invalid Date")
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
		if(dateTextFormat === "hhmmss")
		{
			return ""+hours+":"+min+":"+sec;
		}
	}


	return dateText;
}
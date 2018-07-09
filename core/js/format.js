function formatLine(text)
{
	if(expFormatEnabled !== "true")
	{
		return "<td>"+text+"<td>";
	}
	var arrayOfText = dateTimeSplit(text);
	return "<td style=\"white-space:nowrap;width: 1%;\" >" + dateTimeFormat(arrayOfText[0]) + "</td><td >" + arrayOfText[1] + "</td>";
}

function dateTimeSplit(text)
{
	var returnObject = {
		0: "",
		1: text,
		timeFound: false
	};
	text = text.trim(); //remove extra spaces
	//check for start of time stamp. Could be: ( [ or just a number
	var regExpForTimeStamp = /[0-9]{1,4}(.[0-9]{1,2}){5}((.AM|AM)|(.PM|PM))?(.[0-9]{1,2}){0,2}/i;
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
			returnObject[1] = text.substring(endPosition).trim(); //rest of text
			returnObject["timeFound"] = true;
		}
	}
	return returnObject;
}

function dateTimeFormat(dateText)
{
	if(dateText === "" || dateTextFormat === "default")
	{
		return dateText;
	}
	else if(dateTextFormat === "hidden")
	{
		return "";
	}
	return dateText;
}
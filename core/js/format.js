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
		var yearFull = newConfDate.getFullYear();
		var dayName = newConfDate.getDay(); //1 is monday, 2 tuesday, etc

		if(dateTextFormat === "hhmmss")
		{
			return ""+hours+":"+min+":"+sec;
		}
	}


	return dateText;
}
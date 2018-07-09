function formatLine(text)
{
	var arrayOfText = dateTimeFormat(text);
	return "<td style=\"white-space:nowrap;width: 1%;\" >" + arrayOfText[0].replace(/ /g,"_") + "</td><td >" + arrayOfText[1] + "</td>";
}

function dateTimeFormat(text)
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
	var textInfo = regExpForTimeStamp.exec(text);
	//returns null if not found, data if found
	if(textInfo !== null)
	{
		var positionOfExpression = textInfo.index;
		var lengthOfExpression = textInfo[0].length;
		var endPosition = (positionOfExpression * 2) + lengthOfExpression;
		returnObject[0] = text.substring(0,endPosition); //date
		returnObject[1] = text.substring(endPosition).trim(); //rest of text
		returnObject["timeFound"] = true;
	}
	return returnObject;
}
function formatJsonMessage(message, extraData) //used for file check
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
			if(newerMessage === "")
			{
				return defaultMessage;
			}
			newMessage = jsonDecodeTry("" + newerMessage);
			excapeHTML = true;
			if(typeof newMessage !== "object")
			{
				newerMessage = unescapeHTML(jsonMessage).replace(/\\/g,"\\\\");
				if(newerMessage === "")
				{
					return defaultMessage;
				}
				newMessage = jsonDecodeTry("" + newerMessage);
				excapeHTML = true;
				if(typeof newMessage !== "object")
				{
					if(logFormatJsObjectArrEnable !== "true")
					{
						return defaultMessage;
					}
					//check if in array
					jsonMessage = message.substring(message.indexOf("["),message.lastIndexOf("]") + 1);
					newMessage = jsonDecodeTry(jsonMessage);
					excapeHTML = false;
					if(typeof newMessage !== "object")
					{
						newerMessage = unescapeHTML(jsonMessage);
						if(newerMessage === "")
						{
							return defaultMessage;
						}
						newMessage = jsonDecodeTry("" + newerMessage);
						excapeHTML = true;
						if(typeof newMessage !== "object")
						{
							newerMessage = unescapeHTML(jsonMessage).replace(/\\/g,"\\\\");
							if(newerMessage === "")
							{
								return defaultMessage;
							}
							newMessage = jsonDecodeTry("" + newerMessage);
							excapeHTML = true;
							if(typeof newMessage !== "object")
							{
								//console.log(unescapeHTML(jsonMessage));
								return defaultMessage;
							}
						}
					}

				}
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
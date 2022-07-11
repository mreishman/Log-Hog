function formatJsonMessage(message, extraData) //used for file check
{
	let defaultMessage = {
		text: message,
		success: false
	};
	//try to json decode
	let jsonMessage = message.substring(message.indexOf("{"),message.lastIndexOf("}") + 1);
	let originalJsonMessage = jsonMessage;
	if(jsonMessage !== "")
	{
		let newMessage = jsonDecodeTry(jsonMessage);
		let excapeHTML = false;
		if(typeof newMessage !== "object")
		{
			let newerMessage = unescapeHTML(jsonMessage);
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
		let testReturn = "<table>";
		let extraTrClass = "";
		if("customClassAdd" in extraData && extraData["customClassAdd"])
		{
			extraTrClass = extraData["customClass"];
		}
		let initialMessageText = message.substr(0, message.indexOf('{'));
		testReturn += "<tr "+extraTrClass+"><td colspan=\"2\">"+formatMainMessage(initialMessageText,extraData)+"</td></tr>";
		testReturn += "<tr><td colspan=\"2\"><table class=\"formattedJson jsonTableData\" >";
			testReturn += "<tr><td><span class=\"linkSmall\" onclick=\"toggleUnformattedJson(event);\" >View Unformatted</span> JSON Formatted:</td></tr>";
			let messageKeys = Object.keys(newMessage);
			let messageKeysLength = messageKeys.length;
			for (let messageCount = 0; messageCount < messageKeysLength; messageCount++)
			{
				let messageOne = messageKeys[messageCount];
				let messageTwo = newMessage[messageKeys[messageCount]];
				let messageTwoIsObject = false;
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
		testReturn += "</table></td></tr>";
		testReturn += "<tr><td colspan=\"2\"><table style=\"display: none;\" class=\"unformattedJson jsonTableData\" >";
			testReturn += "<tr><td><span class=\"linkSmall\" onclick=\"toggleFormattedJson(event);\" >View Formatted</span> JSON Unformatted:</td></tr>";
			testReturn += "<tr><td>"+originalJsonMessage+"</td></tr>";
		testReturn += "</table></td></tr>";

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
		let possibleJson = JSON.parse(jsonTry);
		return possibleJson;
	}
	catch(e)
	{
		//console.log(e);
	}
	return false;
}

function toggleUnformattedJson(event)
{
	$(event.target).closest("table:not('.jsonTableData')").find(".formattedJson").hide();
	$(event.target).closest("table:not('.jsonTableData')").find(".unformattedJson").show();
}

function toggleFormattedJson(event)
{
	$(event.target).closest("table:not('.jsonTableData')").find(".formattedJson").show();
	$(event.target).closest("table:not('.jsonTableData')").find(".unformattedJson").hide();
}
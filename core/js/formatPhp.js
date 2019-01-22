/* PHP arrays */

var phpRedWarningArr = {
	0:"PHP Fatal",
	1:"PHP Parse error",
	2:"PHP Syntax error"
};

var phpYellowWarningArr = {
	0:"PHP Warning"
};

var parseTokenWeight = 10;

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
	var severity = "";
	if(logFormatPhpShowImg === "true")
	{
		severity = "<img src=\""+getPhpSeverifyLevel(messageWarning)+"\" height=\"15px\">";
	}
	restOfMessage.shift();
	restOfMessage = restOfMessage.join(":");
	restOfMessage = parseErrorMessage(restOfMessage, extraData);
	if(firstPartOfMessage !== "")
	{
		firstPartOfMessage = formatMainMessage(firstPartOfMessage, extraData);
	}
	let buttonOfInfo = "";
	if(logFormatShowMoreButton === "true")
	{
		let morePhpInfo = getMoreInfo(restOfMessage, "php", 0);
		if(!morePhpInfo["empty"])
		{
			buttonOfInfo = "<span><span style=\"float:right; margin-top: -3px;\" class=\"linkSmall\" onclick=\"showMoreInfo(this)\" >More Info</span><div style=\"display: none;\" >"+formatMoreInfo(morePhpInfo["data"])+"</div></span>"
		}
	}
	return firstPartOfMessage+"<div>"+severity+messageWarning+buttonOfInfo+"</div><div class=\"settingsDiv\">"+restOfMessage+"</div>";
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
				if((arrayOfData[arrayOfDataKeys[aodc2]]["position"] < lowest || lowest === -1 ) && arrayOfData[arrayOfDataKeys[aodc2]]["position"] > -1)
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
	if(logFormatPhpHideExtra !== "false")
	{
		return "<div>"+formatMainMessage(arrayOfData[arrayOfDataKeys[0]]["string"].trim(), extraData)+"</div>";
	}
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
	return getSeverifyLevel(snippit, phpRedWarningArr, phpYellowWarningArr);
}
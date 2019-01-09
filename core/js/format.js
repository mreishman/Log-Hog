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

var parseTokenWeight = 1;

var phpInfoArr = {
	0: {
		syntax: "abstract",
		target: "T_ABSTRACT",
		weight: parseTokenWeight
	},
	1: {
		syntax: "&=",
		target: "T_AND_EQUAL",
		weight: parseTokenWeight
	},
	2: {
		syntax: "array()",
		target: "T_ARRAY",
		weight: parseTokenWeight
	},
	3: {
		syntax: "(array)",
		target: "T_ARRAY_CAST",
		weight: parseTokenWeight
	},
	4: {
		syntax: "as",
		target: "T_AS",
		weight: parseTokenWeight
	},
	5: {
		syntax: "",
		target: "T_BAD_CHARACTER",
		weight: parseTokenWeight
	},
	6: {
		syntax: "&&",
		target: "T_BOOLEAN_AND",
		weight: parseTokenWeight
	},
	7: {
		syntax: "||",
		target: "T_BOOLEAN_OR",
		weight: parseTokenWeight
	},
	8: {
		syntax: "(bool) or (boolean)",
		target: "T_BOOL_CAST",
		weight: parseTokenWeight
	},
	9: {
		syntax: "break",
		target: "T_BREAK",
		weight: parseTokenWeight
	},
	10: {
		syntax: "callable",
		target: "T_CALLABLE",
		weight: parseTokenWeight
	},
	11: {
		syntax: "case",
		target: "T_CASE",
		weight: parseTokenWeight
	},
	12: {
		syntax: "catch",
		target: "T_CATCH",
		weight: parseTokenWeight
	},
	13: {
		syntax: "",
		target: "T_CHARACTER",
		weight: parseTokenWeight
	},
	14: {
		syntax: "class",
		target: "T_CLASS",
		weight: parseTokenWeight
	},
	15: {
		syntax: "__CLASS__",
		target: "T_CLASS_C",
		weight: parseTokenWeight
	},
	16: {
		syntax: "clone",
		target: "T_CLONE",
		weight: parseTokenWeight
	},
	17: {
		syntax: "?> or %>",
		target: "T_CLOSE_TAG",
		weight: parseTokenWeight
	},
	18: {
		syntax: "??",
		target: "T_COALESCE",
		weight: parseTokenWeight
	},
	19: {
		syntax: "// or #, and /* */",
		target: "T_COMMENT",
		weight: parseTokenWeight
	},
	20: {
		syntax: ".=",
		target: "T_CONCAT_EQUAL",
		weight: parseTokenWeight
	},
	21: {
		syntax: "const",
		target: "T_CONST",
		weight: parseTokenWeight
	},
	22: {
		syntax: "\"foo\" or \'bar\'	",
		target: "T_CONSTANT_ENCAPSED_STRING",
		weight: parseTokenWeight
	},
	23: {
		syntax: "continue",
		target: "T_CONTINUE",
		weight: parseTokenWeight
	},
	24: {
		syntax: "{$",
		target: "T_CURLY_OPEN",
		weight: parseTokenWeight
	},
	25: {
		syntax: "--",
		target: "T_DEC",
		weight: parseTokenWeight
	},
	26: {
		syntax: "declare",
		target: "T_DECLARE",
		weight: parseTokenWeight
	},
	27: {
		syntax: "default",
		target: "T_DEFAULT",
		weight: parseTokenWeight
	},
	28: {
		syntax: "__DIR__",
		target: "T_DIR",
		weight: parseTokenWeight
	},
	29: {
		syntax: "/=",
		target: "T_DIV_EQUAL",
		weight: parseTokenWeight
	},
	30: {
		syntax: "0.12, etc.",
		target: "T_DNUMBER",
		weight: parseTokenWeight
	},
	31: {
		syntax: "/** */",
		target: "T_DOC_COMMENT",
		weight: parseTokenWeight
	},
	32: {
		syntax: "do",
		target: "T_DO",
		weight: parseTokenWeight
	},
	33: {
		syntax: "${",
		target: "T_DOLLAR_OPEN_CURLY_BRACES",
		weight: parseTokenWeight
	},
	34: {
		syntax: "=>",
		target: "T_DOUBLE_ARROW",
		weight: parseTokenWeight
	},
	35: {
		syntax: "(real),(double) or (float)",
		target: "T_DOUBLE_CAST",
		weight: parseTokenWeight
	},
	36: {
		syntax: "::",
		target: "T_DOUBLE_COLON",
		weight: parseTokenWeight
	},
	37: {
		syntax: "echo",
		target: "T_ECHO",
		weight: parseTokenWeight
	},
	38: {
		syntax: "...",
		target: "T_ELLIPSIS",
		weight: parseTokenWeight
	},
	39: {
		syntax: "else",
		target: "T_ELSE",
		weight: parseTokenWeight
	},
	40: {
		syntax: "elseif",
		target: "T_ELSEIF",
		weight: parseTokenWeight
	},
	41: {
		syntax: "empty",
		target: "T_EMPTY",
		weight: parseTokenWeight
	},
	42: {
		syntax: "\" $a\"",
		target: "T_ENCAPSED_AND_WHITESPACE",
		weight: parseTokenWeight
	},
	43: {
		syntax: "enddeclare",
		target: "T_ENDDECLARE",
		weight: parseTokenWeight
	},
	44: {
		syntax: "endfor",
		target: "T_ENDFOR",
		weight: parseTokenWeight
	},
	45: {
		syntax: "endforeach",
		target: "T_ENDFOREACH",
		weight: parseTokenWeight
	},
	46: {
		syntax: "endif",
		target: "T_ENDIF",
		weight: parseTokenWeight
	},
	47: {
		syntax: "endswitch",
		target: "T_ENDSWITCH",
		weight: parseTokenWeight
	},
	48: {
		syntax: "endwhile",
		target: "T_ENDWHILE",
		weight: parseTokenWeight
	},
	49: {
		syntax: "",
		target: "T_END_HEREDOC",
		weight: parseTokenWeight
	},
	50: {
		syntax: "eval()",
		target: "T_EVAL",
		weight: parseTokenWeight
	},
	51: {
		syntax: "exit or die",
		target: "T_EXIT",
		weight: parseTokenWeight
	},
	52: {
		syntax: "extends",
		target: "T_EXTENDS",
		weight: parseTokenWeight
	},
	53: {
		syntax: "__FILE__",
		target: "T_FILE",
		weight: parseTokenWeight
	},
	54: {
		syntax: "final",
		target: "T_FINAL",
		weight: parseTokenWeight
	},
	55: {
		syntax: "finally",
		target: "T_FINALLY",
		weight: parseTokenWeight
	},
	56: {
		syntax: "for",
		target: "T_FOR",
		weight: parseTokenWeight
	},
	57: {
		syntax: "foreach",
		target: "T_FOREACH",
		weight: parseTokenWeight
	},
	58: {
		syntax: "function or cfunction",
		target: "T_FUNCTION",
		weight: parseTokenWeight
	},
	59: {
		syntax: "__FUNCTION__",
		target: "T_FUNC_C",
		weight: parseTokenWeight
	},
	60: {
		syntax: "global",
		target: "T_GLOBAL",
		weight: parseTokenWeight
	},
	61: {
		syntax: "goto",
		target: "T_GOTO",
		weight: parseTokenWeight
	},
	62: {
		syntax: "__halt_compiler()",
		target: "T_HALT_COMPILER",
		weight: parseTokenWeight
	},
	63: {
		syntax: "if",
		target: "T_IF",
		weight: parseTokenWeight
	},
	64: {
		syntax: "implements",
		target: "T_IMPLEMENTS",
		weight: parseTokenWeight
	},
	65: {
		syntax: "++",
		target: "T_INC",
		weight: parseTokenWeight
	},
	66: {
		syntax: "include()",
		target: "T_INCLUDE",
		weight: parseTokenWeight
	},
	67: {
		syntax: "include_once()",
		target: "T_INCLUDE_ONCE",
		weight: parseTokenWeight
	},
	68: {
		syntax: "",
		target: "T_INLINE_HTML",
		weight: parseTokenWeight
	},
	69: {
		syntax: "instanceof",
		target: "T_INSTANCEOF",
		weight: parseTokenWeight
	},
	70: {
		syntax: "insteadof",
		target: "T_INSTEADOF",
		weight: parseTokenWeight
	},
	71: {
		syntax: "(int) or (integer)",
		target: "T_INT_CAST",
		weight: parseTokenWeight
	},
	72: {
		syntax: "interface",
		target: "T_INTERFACE",
		weight: parseTokenWeight
	},
	73: {
		syntax: "isset()",
		target: "T_ISSET",
		weight: parseTokenWeight
	},
	74: {
		syntax: "==",
		target: "T_IS_EQUAL",
		weight: parseTokenWeight
	},
	75: {
		syntax: ">=",
		target: "T_IS_GREATER_OR_EQUAL",
		weight: parseTokenWeight
	},
	76: {
		syntax: "===",
		target: "T_IS_IDENTICAL",
		weight: parseTokenWeight
	},
	77: {
		syntax: "!= ir <>",
		target: "T_IS_NOT_EQUAL",
		weight: parseTokenWeight
	},
	78: {
		syntax: "!==",
		target: "T_IS_NOT_IDENTICAL",
		weight: parseTokenWeight
	},
	79: {
		syntax: "<=",
		target: "T_IS_SMALLER_OR_EQUAL",
		weight: parseTokenWeight
	},
	80: {
		syntax: "<=>",
		target: "T_SPACESHIP",
		weight: parseTokenWeight
	},
	81: {
		syntax: "__LINE__",
		target: "T_LINE",
		weight: parseTokenWeight
	},
	82: {
		syntax: "list()",
		target: "T_LIST",
		weight: parseTokenWeight
	},
	83: {
		syntax: "123, 012, 0x1ac, etc",
		target: "T_LNUMBER",
		weight: parseTokenWeight
	},
	84: {
		syntax: "and",
		target: "T_LOGICAL_AND",
		weight: parseTokenWeight
	},
	85: {
		syntax: "or",
		target: "T_LOGICAL_OR",
		weight: parseTokenWeight
	},
	86: {
		syntax: "xor",
		target: "T_LOGICAL_XOR",
		weight: parseTokenWeight
	},
	87: {
		syntax: "__METHOD__",
		target: "T_METHOD_C",
		weight: parseTokenWeight
	},
	88: {
		syntax: "-=",
		target: "T_MINUS_EQUAL",
		weight: parseTokenWeight
	},
	89: {
		syntax: "%=",
		target: "T_MOD_EQUAL",
		weight: parseTokenWeight
	},
	90: {
		syntax: "*=",
		target: "T_MUL_EQUAL",
		weight: parseTokenWeight
	},
	91: {
		syntax: "namespace",
		target: "T_NAMESPACE",
		weight: parseTokenWeight
	},
	92: {
		syntax: "__NAMESPACE__",
		target: "T_NS_C",
		weight: parseTokenWeight
	},
	93: {
		syntax: "\\",
		target: "T_NS_SEPARATOR",
		weight: parseTokenWeight
	},
	94: {
		syntax: "new",
		target: "T_NEW",
		weight: parseTokenWeight
	},
	95: {
		syntax: "$a[0]",
		target: "T_NUM_STRING",
		weight: parseTokenWeight
	},
	96: {
		syntax: "(object)",
		target: "T_OBJECT_CAST",
		weight: parseTokenWeight
	},
	97: {
		syntax: "->",
		target: "T_OBJECT_OPERATOR",
		weight: parseTokenWeight
	},
	98: {
		syntax: "<?php, <? or <%",
		target: "T_OPEN_TAG",
		weight: parseTokenWeight
	},
	99: {
		syntax: "<?= or <%=",
		target: "T_OPEN_TAG_WITH_ECHO",
		weight: parseTokenWeight
	},
	100: {
		syntax: "|=",
		target: "T_OR_EQUAL	",
		weight: parseTokenWeight
	},
	101: {
		syntax: "::",
		target: "T_PAAMAYIM_NEKUDOTAYIM",
		weight: parseTokenWeight
	},
	102: {
		syntax: "+=",
		target: "T_PLUS_EQUAL",
		weight: parseTokenWeight
	},
	103: {
		syntax: "**",
		target: "T_POW",
		weight: parseTokenWeight
	},
	104: {
		syntax: "**=",
		target: "T_POW_EQUAL",
		weight: parseTokenWeight
	},
	105: {
		syntax: "print()",
		target: "T_PRINT",
		weight: parseTokenWeight
	},
	106: {
		syntax: "private",
		target: "T_PRIVATE",
		weight: parseTokenWeight
	},
	107: {
		syntax: "public",
		target: "T_PUBLIC",
		weight: parseTokenWeight
	},
	108: {
		syntax: "protected",
		target: "T_PROTECTED",
		weight: parseTokenWeight
	},
	109: {
		syntax: "require()",
		target: "T_REQUIRE",
		weight: parseTokenWeight
	},
	110: {
		syntax: "require_once()",
		target: "T_REQUIRE_ONCE",
		weight: parseTokenWeight
	},
	111: {
		syntax: "return",
		target: "T_RETURN",
		weight: parseTokenWeight
	},
	112: {
		syntax: "<<",
		target: "T_SL",
		weight: parseTokenWeight
	},
	113: {
		syntax: "<<=",
		target: "T_SL_EQUAL",
		weight: parseTokenWeight
	},
	114: {
		syntax: ">>",
		target: "T_SR",
		weight: parseTokenWeight
	},
	115: {
		syntax: ">>=",
		target: "T_SR_EQUAL",
		weight: parseTokenWeight
	},
	116: {
		syntax: "<<<",
		target: "T_START_HEREDOC",
		weight: parseTokenWeight
	},
	117: {
		syntax: "static",
		target: "T_STATIC",
		weight: parseTokenWeight
	},
	118: {
		syntax: "parent, self, etc",
		target: "T_STRING",
		weight: parseTokenWeight
	},
	119: {
		syntax: "(string)",
		target: "T_STRING_CAST",
		weight: parseTokenWeight
	},
	120: {
		syntax: "\"${a",
		target: "T_STRING_VARNAME",
		weight: parseTokenWeight
	},
	121: {
		syntax: "switch",
		target: "T_SWITCH",
		weight: parseTokenWeight
	},
	122: {
		syntax: "throw",
		target: "T_THROW",
		weight: parseTokenWeight
	},
	123: {
		syntax: "trait",
		target: "T_TRAIT",
		weight: parseTokenWeight
	},
	124: {
		syntax: "__TRAIT__",
		target: "T_TRAIT_C",
		weight: parseTokenWeight
	},
	125: {
		syntax: "try",
		target: "T_TRY",
		weight: parseTokenWeight
	},
	126: {
		syntax: "unset()",
		target: "T_UNSET",
		weight: parseTokenWeight
	},
	127: {
		syntax: "(unset)",
		target: "T_UNSET_CAST",
		weight: parseTokenWeight
	},
	128: {
		syntax: "use",
		target: "T_USE",
		weight: parseTokenWeight
	},
	129: {
		syntax: "var",
		target: "T_VAR",
		weight: parseTokenWeight
	},
	130: {
		syntax: "$foo",
		target: "T_VARIABLE",
		weight: parseTokenWeight
	},
	131: {
		syntax: "while",
		target: "T_WHILE",
		weight: parseTokenWeight
	},
	132: {
		syntax: "\\t \\r\\n",
		target: "T_WHITESPACE",
		weight: parseTokenWeight
	},
	133: {
		syntax: "^=",
		target: "T_XOR_EQUAL",
		weight: parseTokenWeight
	},
	134: {
		syntax: "yield",
		target: "T_YIELD",
		weight: parseTokenWeight
	},
	135: {
		syntax: "yield from",
		target: "T_YIELD_FROM",
		weight: parseTokenWeight
	}
}

/* Start of functions for formatting*/

function formatLine(text, extraData)
{
	var arrayOfText = dateTimeSplit(text);
	if(dateTextFormatColumn === "true" || (dateTextFormatColumn === "auto" && window.innerWidth > breakPointTwo))
	{
		if("lineDisplay" in extraData && extraData["lineDisplay"] === "true")
		{
			return "<td style=\"white-space:nowrap;width: 1%;\">" + dateTimeFormat(arrayOfText) + extraData["lineCount"] + "</td><td style=\"white-space: pre-wrap;\">" + formatMainMessage(arrayOfText[1], extraData) + "</td>";
		}
		return "<td style=\"white-space:nowrap;width: 1%;\">" + dateTimeFormat(arrayOfText) + "</td><td style=\"white-space: pre-wrap;\">" + formatMainMessage(arrayOfText[1], extraData) + "</td>";
	}
	else if("lineDisplay" in extraData && extraData["lineDisplay"] === "true")
	{
		return "<td style=\"white-space:nowrap;width: 1%;\">" + extraData["lineCount"] + "</td><td style=\"white-space: pre-wrap;\">" + dateTimeFormat(arrayOfText) + formatMainMessage(arrayOfText[1], extraData) + "</td>";
	}
	return "<td style=\"white-space: pre-wrap;\">" + dateTimeFormat(arrayOfText) + formatMainMessage(arrayOfText[1], extraData) + "</td>";
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
	//check if message is in arrayOfFileData
	if(logFormatFileEnable === "true")
	{
		let localMessage = unescapeHTML(message);
		if(/(in|at) (.?)([\/]+)([^&\r\n\t]*)(on line|\D:\d)(.?)(\d{1,10})/.test(localMessage))
		{
			var arrayOfFileDataKeys = Object.keys(arrayOfFileData);
			var arrayOfFileDataKeysLength = arrayOfFileDataKeys.length;
			for(var AOFDCount = 0; AOFDCount < arrayOfFileDataKeysLength; AOFDCount++)
			{
				if(localMessage.indexOf(arrayOfFileDataKeys[AOFDCount]) > -1 && arrayOfFileData[arrayOfFileDataKeys[AOFDCount]]["fileData"] !== "Error - File Not Found")
				{
					//this message matches file data, add this below
					extraData["fileData"] = arrayOfFileData[arrayOfFileDataKeys[AOFDCount]];
					return formatMessageFileData(localMessage, extraData);
				}
			}
		}
	}
	return message;
}

function formatMessageFileData(message, extraData)
{
	var lineStart = 0;
	var pregMatchData = extraData["fileData"]["pregMatchData"];
	var numForBaseLineStart = parseInt(pregMatchData[(pregMatchData.length - 1)]);
	if(numForBaseLineStart > 0)
	{
		lineStart = numForBaseLineStart - logFormatFileLinePadding;
	}
	let customClass = "";
	if("customClassAdd" in extraData && extraData["customClassAdd"])
	{
		customClass = extraData["customClass"];
	}
	let filePermissions = "";
	if(extraData["fileData"]["permissions"] !== "")
	{
		filePermissions = " [File Permissions: "+extraData["fileData"]["permissions"]+"]";
	}
	return "<table style=\"width: 100%;\"><tr "+customClass+"><td>"+message+filePermissions+"</td></tr><tr "+customClass+"><td><table class=\"logCode\" style=\"width: 100%;\">"+makePrettyWithText(escapeHTML(extraData["fileData"]["fileData"]), 0, {lineDisplay: logFormatFileLineCount, lineModifier: lineStart})+"</table></td></tr></table>";
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
	let morePhpInfo = getMorePhpInfo(restOfMessage);
	let buttonOfInfo = "";
	if(Object.keys(morePhpInfo).length > 0)
	{
		buttonOfInfo = "<span><span style=\"float:right; margin-top: -3px;\" class=\"linkSmall\" onclick=\"showMoreInfo(this)\" >More Info</span><div style=\"display: none;\" >"+formatMoreInfo(morePhpInfo)+"</div></span>"
	}
	return firstPartOfMessage+"<div>"+severity+messageWarning+buttonOfInfo+"</div><div class=\"settingsDiv\">"+restOfMessage+"</div>";
}

function getMorePhpInfo(message)
{
	let counterOfHits = 0;
	let returnInfoObj = {};
	let phpInfoArrKeys = Object.keys(phpInfoArr);
	let phpInfoArrKeysLength = phpInfoArrKeys.length;
	for(let PIAKCount = 0; PIAKCount < phpInfoArrKeysLength; PIAKCount++)
	{
		let search = "("+phpInfoArr[phpInfoArrKeys[PIAKCount]]["target"]+")";
		if(message.indexOf(search) > -1)
		{
			returnInfoObj[parseFloat(phpInfoArr[phpInfoArrKeys[PIAKCount]]["target"]+"."+counterOfHits)] = {
				"hit" : phpInfoArr[phpInfoArrKeys[PIAKCount]]["target"],
				"info": "Info Goes Here"
			}
		}
	}
	return returnInfoObj;
}

function formatMoreInfo(objOfInfo)
{
	returnHtml = "<table>";
	let objOfInfoKeys = Object.keys(objOfInfo);
	let objOfInfoKeysLength = objOfInfoKeys.length;
	for(let OOIKCount = 0; OOIKCount < objOfInfoKeysLength; OOIKCount++)
	{
		returnHtml += "<tr><td>"+objOfInfo[objOfInfoKeys[OOIKCount]]["hit"]+"</td></tr>";
		returnHtml += "<tr><td>"+objOfInfo[objOfInfoKeys[OOIKCount]]["info"]+"</td></tr>";
	}
	returnHtml += "</table>";
	return returnHtml;
}

function showMoreInfo(e)
{
	console.log($(e).siblings('div').html());
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

function updateFileDataArrayInner(newDataArr)
{
	var newDataArrKeys = Object.keys(newDataArr);
	var newDataArrKeysLength=  newDataArrKeys.length;
	for(var NDACount = 0; NDACount < newDataArrKeysLength; NDACount++)
	{
		var fileDataArr = newDataArr[newDataArrKeys[NDACount]]["fileData"];
		var fileDataArrKeys = Object.keys(fileDataArr);
		var fileDataArrKeysLength = fileDataArrKeys.length;
		if(fileDataArrKeysLength > 0)
		{
			for(var FDACount = 0; FDACount < fileDataArrKeysLength; FDACount++)
			{
				arrayOfFileData[fileDataArrKeys[FDACount]] = fileDataArr[fileDataArrKeys[FDACount]];
			}
		}
	}
}
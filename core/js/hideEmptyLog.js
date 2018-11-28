function hideEmptyLogsInner()
{
	var logKeys = Object.keys(logs);
	var logKeysLength = logKeys.length;
	for(var logHideCheck = 0; logHideCheck < logKeysLength; logHideCheck++)
	{
		if(logs[logKeys[logHideCheck]] === "<div class='errorMessageLog errorMessageGreenBG' > This file is empty. </div>")
		{
			hideLogByName(logKeys[logHideCheck]);
		}
	}
}
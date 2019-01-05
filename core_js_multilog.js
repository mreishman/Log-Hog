function saveLayoutTo(letter)
{
	if(logLoadLayout.length === 0)
	{
		for(var iCount = 1; iCount <= 3; iCount++)
		{
			for(var jCount = 1; jCount <= 3; jCount++)
			{
				logLoadLayout[""+iCount+"x"+jCount] = [];
				for(var kCount = 0; kCount < (iCount * jCount); kCount++)
				{
					logLoadLayout[""+iCount+"x"+jCount][kCount] = {A: "", B: "", C: ""};
				}
			}
		}
	}
	var currentConfig = getCurrentWindowLayout();
	var currentConfigArray = currentConfig.split("x");
	var outerLoop = parseInt(currentConfigArray[0]);
	var innerLoop = parseInt(currentConfigArray[1]);
	var currentConterLoopExt = 0;
	for(var outerLoopCount = 0; outerLoopCount < outerLoop; outerLoopCount++)
	{
		for(var innerLoopCount = 0; innerLoopCount < innerLoop; innerLoopCount++)
		{
			var localValue = filterTitle(titles[logDisplayArray[currentConterLoopExt]["id"]]).trim();
			$("#localLayout [name=\"logLoad"+currentConfig+"-"+currentConterLoopExt+"-"+letter+"\"]")[0].value = localValue;
			logLoadLayout[currentConfig][currentConterLoopExt][letter] = localValue;
			currentConterLoopExt++;
		}
	}
	saveAndVerifyMain('localLayout');
}
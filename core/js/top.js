var dropdownMenuVisible = false;

function killProcess(processNumber)
{
	var urlForSend = '../core/php/killProcess.php?format=json';
	var data = {processNumber: processNumber};
	$.ajax({
	  url: urlForSend,
	  dataType: 'json',
	  data: data,
	  type: 'POST',
	  success: function(data){
	  	console.log(data);
	  	procStatFunc();
	  },
	});
}

function dropdownShow(nameOfElem) {
    if(document.getElementById("dropdown-"+nameOfElem).style.display == 'block')
    {
    	$('.dropdown-content').hide();
    	dropdownMenuVisible = false;
    }
    else
    {
    	$('.dropdown-content').hide();
    	document.getElementById("dropdown-"+nameOfElem).style.display = 'block';
    	document.getElementById("dropdown-"+nameOfElem).style.left = event.clientX+"px";
    	document.getElementById("dropdown-"+nameOfElem).style.top = event.clientY+"px";
    	dropdownMenuVisible = true;
    }
}

window.onclick = function(event) {
	if (!event.target.matches('.expandMenu')) {
		$('.dropdown-content').hide();
		dropdownMenuVisible = false;
	}
}

function showGraphPopup(graph, name,type)
{
	showPopup();
	var w = window.innerWidth;
	var h = window.innerHeight;
	var height = (h*0.95);
	var width = (w*0.95);
	heightForPopup = ((height*0.95)-125);
	widthForPopup = (width*0.95);
	var innerHTMLforPopup = "";
	innerHTMLforPopup =  "<div class='settingsHeader' ><table style='width:100%; color:black;'><tr><th style='text-align:left;' >"+name+"</th><th style='text-align:right;'><a class='link' onclick='hidePopup();'>Close</a></th></tr></table></div><br><br><div style='width:100%;text-align:center;'>";
	if(type == "onePage")
	{
		innerHTMLforPopup += showOnePagePopup(graph,name,heightForPopup,widthForPopup);
	}
	else if(type == "twoColumnLeftOneGraphRightOneGraphOneDescription")
	{
		innerHTMLforPopup += showTwoColumnLeftOneGraphRightOneGraphOneDescriptionPopup(graph,name,heightForPopup,widthForPopup);
	}
	innerHTMLforPopup += "<br><br><div class='settingsHeader' ><table style='width:100%; color:black;'><tr id='popupGraphLowerTr' ><th></th></tr></table></div>  </div>";
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = innerHTMLforPopup;
	document.getElementById('popupContent').style.width = width+"px";
	document.getElementById('popupContent').style.height = height+"px";
	document.getElementById('popupContent').style.marginTop = "-"+(height/2)+"px";
	document.getElementById('popupContent').style.marginLeft = "-"+(width/2)+"px";
	document.getElementById('popupContent').style.backgroundColor = "rgba(68, 68, 68, 0.7)";
}

function showTwoColumnLeftOneGraphRightOneGraphOneDescriptionPopup(graph,name,heightForPopup,widthForPopup)
{
	var squarePopupWidth = widthForPopup/2;
	if(squarePopupWidth > heightForPopup)
	{
		squarePopupWidth = heightForPopup;
	}
	return "<table style='width: "+widthForPopup+"px; height: "+heightForPopup+"px;' ><tr><td rowspan='2' style='width:"+(widthForPopup/2)+"px;' ><img id='popupGraphLoadingSpinner' src='../core/img/loading.gif' height='50' width='50' style='margin-left:"+(widthForPopup/4)+"px;' ><canvas style='display:none;'  id='graph[0]' width='"+squarePopupWidth+"' height='"+squarePopupWidth+"' ></canvas> </td><td style='width:"+(widthForPopup/2)+"px;' ><img id='popupGraphLoadingSpinner2' src='../core/img/loading.gif' height='50' width='50' style='margin-left:"+(widthForPopup/4)+"px;' ><canvas style='display:none;'  id='graph[0]' width='"+(widthForPopup/2)+"' height='"+(heightForPopup/2)+"' ></canvas>  </td></tr><tr><td><img id='popupGraphLoadingSpinner3' src='../core/img/loading.gif' height='50' width='50' style='margin-left:"+(widthForPopup/4)+"px;' > </td></tr></table>";
}

function showOnePagePopup(graph,name,heightForPopup,widthForPopup)
{
	return "<img id='popupGraphLoadingSpinner' style='padding-top: "+((heightForPopup/2)-25)+"px; padding-bottom: "+((heightForPopup/2)-25)+"px;' src='../core/img/loading.gif' height='50' width='50'><canvas style='display:none;' class='canvasMonitor' id='"+graph+"' width='"+widthForPopup+"' height='"+heightForPopup+"' ></canvas>";
}

function fillAreaInChart(arrayForFill, bottomArray, color, context, height, width, type)
{
	if(type == 1)
	{
		fillAreaInChartVersionOne(arrayForFill, bottomArray, color, context, height, width);
	}
	else
	{
		//type == 2
		fillAreaInChartVersionTwo(arrayForFill, bottomArray, color, context, height, width);
	}
}

function fillAreaInChartVersionOne(arrayForFill, bottomArray, color, context, height, width)
{
	context.fillStyle = color;
	var totalWidthOfEachElement = width/bottomArray.length;
	for (var i = bottomArray.length - 1; i >= 0; i--) 
	{
		var heightOfElement = height*(arrayForFill[i]/100);
		context.fillRect((totalWidthOfEachElement*(i)),(height-heightOfElement-bottomArray[i]),totalWidthOfEachElement,heightOfElement);
		bottomArray[i] = bottomArray[i]+heightOfElement;
	}
}

function fillAreaInChartVersionTwo(arrayForFill, bottomArray, color, context, height, width)
{
	context.fillStyle = color;
	var totalWidthOfEachElement = width/(bottomArray.length-1);
	var bottomArrayTmp = bottomArray;
	for (var i = bottomArray.length - 1; i >= 0; i--) 
	{
		var heightOfElement = (height*(arrayForFill[i]/100));
		context.beginPath();
		context.moveTo((totalWidthOfEachElement*(i-1)),(height-(height*(arrayForFill[i-1]/100))-bottomArrayTmp[i-1]));
		context.lineTo((totalWidthOfEachElement*(i-1)),(height-bottomArrayTmp[i-1]));
		context.lineTo((totalWidthOfEachElement*(i)),(height-bottomArrayTmp[i]));
		context.lineTo((totalWidthOfEachElement*(i)),(height-heightOfElement-bottomArrayTmp[i]));
		context.closePath();
		context.fill();
		bottomArray[i] = bottomArray[i]+heightOfElement;
	}
}

function sortArray(array, column)
{
	array.sort(function(a,b)
		{
			var filterA = a[column];
			var filterB = b[column];

			if((a[column]).indexOf("%") == (a[column].length-1))
			{
				//% logic
				filterA = a[column].slice(0,-1);
				filterB = b[column].slice(0,-1);
			}
			if(((isFloat(parseFloat(filterA))) || (isInt(parseFloat(filterA)))) && ((isFloat(parseFloat(filterB))) || (isInt(parseFloat(filterB)))))
			{
				return parseFloat(filterA) == parseFloat(filterB) ? 0 : (parseFloat(filterA) > parseFloat(filterB) ? 1 : -1);
			}
			else
			{
				return filterA == filterB ? 0 : (filterA > filterB ? 1 : -1);
			}
		});
}

function isFloat(n)
{
	return Number(n) === n && n % 1 !== 0;
}

function isInt(n)
{
	return Number(n) === n && n % 1 === 0;
}

function filterData(dataInner, maxRowNum)
{
	dataInnerNewArrayOfArrays = [];
	dataInner = dataInner.split(" ");
	dataInnerNew = [];
	dataInnerLength = dataInner.length;
	var counterForRow = 0;
	var endingText = "";
	for (var i = 0; i < dataInnerLength; i++) 
	{
		var addToNewArray = true;
		if(dataInner[i] == " " || dataInner[i] == "")
		{
			addToNewArray = false;
		}
		if(addToNewArray)
		{
			if(counterForRow < (maxRowNum))
			{
				counterForRow++;
				dataInnerNew.push(dataInner[i]);
			}
			else
			{
				var filterData = dataInner[i].replace(/(\r\n|\n|\r)/gm, ",");
				if(filterData.indexOf(',') > -1)
				{
					dataInnerNewRow = filterData.split(",");
					counterForRow = 0;
					endingText += dataInnerNewRow[0];
					dataInnerNew.push(endingText);
					dataInnerNewArrayOfArrays.push(dataInnerNew);
					dataInnerNew = [];
					if(dataInnerNewRow[1] != " " && dataInnerNewRow[1] != "")
					{
						dataInnerNew.push(dataInnerNewRow[1]);
						counterForRow++;
					}
					endingText = "";
				}
				else
				{
					endingText += dataInner[i];
				}
				
			}
			
		}
	}
	if(dataInnerNew.length > 0)
	{
		dataInnerNewArrayOfArrays.push(dataInnerNew);
	}
	return dataInnerNewArrayOfArrays;

}

function filterDataFromRUsage(dataInner)
{
	phpUserTimeDiff.push((parseFloat(dataInner['ru_utime.tv_usec'])) + (1000000*dataInner["ru_utime.tv_sec"]));
	if(phpUserTimeDiff.length > 1)
	{
		var phpUserTimeDiffForHistory = phpUserTimeDiff[1] - phpUserTimeDiff[0];
		filterDataFromRUsageUser(phpUserTimeDiffForHistory);
		phpUserTimeDiff.shift();
	}
	phpSystemTimeDiff.push(parseFloat(dataInner['ru_stime.tv_usec']));
	if(phpSystemTimeDiff.length > 1)
	{
		phpSystemTimeDiffForHistory = phpSystemTimeDiff[1] - phpSystemTimeDiff[0]
		if(phpSystemTimeDiff[1] < phpSystemTimeDiff[0])
		{
			phpSystemTimeDiffForHistory = phpSystemTimeDiff[1] - (phpSystemTimeDiff[0]+1000000);
		}
		if(phpSystemTimeDiffForHistory > 0)
		{
			filterDataFromRUsageSystem(phpSystemTimeDiffForHistory);
			
		}
		phpSystemTimeDiff.shift();
	}
}

function filterDataFromRUsageUser(phpUserTimeDiffForHistory)
{
	phpUserTimeHistory.push(phpUserTimeDiffForHistory);
	phpUserTimeHistory.shift();

	document.getElementById('canvasMonitorLoading_PHP_UTU').style.display = "none";
	document.getElementById('PHPUTUCanvas').style.display = "block";

	var arrayToShowInConsole = new Array();
	var baseArray = new Array();
	phpUserTimeHistoryLength = phpUserTimeHistory.length;
	for (var j = 0; j < (phpUserTimeHistoryLength); j++) 
	{
		arrayToShowInConsole.push(phpUserTimeHistory[j]);
		baseArray.push(0);
	}
	var maxOfArray = Math.max.apply(Math, arrayToShowInConsole);
	var arrayToShowInConsoleLength = arrayToShowInConsole.length;
	document.getElementById('canvasMonitorPHPUTUText').innerHTML = arrayToShowInConsole[arrayToShowInConsoleLength-1] + "/" + maxOfArray;
	for(var j = 0; j < arrayToShowInConsoleLength; j++)
	{
		arrayToShowInConsole[j] = ((arrayToShowInConsole[j]/maxOfArray)*100).toFixed(1);
	}
	phpUserTimeAreaContext.clearRect(0, 0, phpUserTimeArea.height, phpUserTimeArea.width);
	fillAreaInChart(arrayToShowInConsole, baseArray, "blue",phpUserTimeAreaContext, phpUserTimeArea.height, phpUserTimeArea.width,1);
	var phpUTUPopupArea = document.getElementById('phpUTUPopupCanvas');
	if(phpUTUPopupArea)
	{
		var arrayOfArraysToFillWith = [arrayToShowInConsole];
		popupFillInChart(phpUTUPopupArea, baseArray, arrayOfArraysToFillWith);
		document.getElementById('popupGraphLowerTr').innerHTML = "<th style='background-color:blue; width:25px;'><th  style='text-align:left;'>Current: "+arrayToShowInConsole[arrayToShowInConsoleLength-1]+"% of "+maxOfArray+"</th></th>";
	}

}

function filterDataFromRUsageSystem(phpSystemTimeDiffForHistory)
{
	phpSystemTimeHistory.push(phpSystemTimeDiffForHistory);
	phpSystemTimeHistory.shift();

	document.getElementById('canvasMonitorLoading_PHP_STU').style.display = "none";
	document.getElementById('PHPSTUCanvas').style.display = "block";

	var arrayToShowInConsole = new Array();
	var baseArray = new Array();
	phpSystemTimeHistoryLength = phpSystemTimeHistory.length;
	for (var j = 0; j < (phpSystemTimeHistoryLength); j++) 
	{
		arrayToShowInConsole.push(phpSystemTimeHistory[j]);
		baseArray.push(0);
	}
	var maxOfArray = Math.max.apply(Math, arrayToShowInConsole);
	var arrayToShowInConsoleLength = arrayToShowInConsole.length;
	document.getElementById('canvasMonitorPHPSTUText').innerHTML = arrayToShowInConsole[arrayToShowInConsoleLength-1] + "/" + maxOfArray;
	for(var j = 0; j < arrayToShowInConsoleLength; j++)
	{
		arrayToShowInConsole[j] = ((arrayToShowInConsole[j]/maxOfArray)*100).toFixed(1);
	}
	var fillThis = document.getElementById("PHPSTUCanvas");
	var fillThisContext= fillThis.getContext("2d");
	fillThisContext.clearRect(0, 0, fillThis.height, fillThis.width);
	fillAreaInChart(arrayToShowInConsole, baseArray, "blue",fillThisContext, fillThis.height, fillThis.width,1);
	var phpSTUPopupArea = document.getElementById('phpSTUPopupCanvas');
	if(phpSTUPopupArea)
	{
		var arrayOfArraysToFillWith = [arrayToShowInConsole];
		popupFillInChart(phpSTUPopupArea, baseArray, arrayOfArraysToFillWith);
		document.getElementById('popupGraphLowerTr').innerHTML = "<th style='background-color:blue; width:25px;'><th  style='text-align:left;'>Current: "+arrayToShowInConsole[arrayToShowInConsoleLength-1]+"% of "+maxOfArray+"</th></th>";
	}
}
//check if used + free = total, if not add buffer/cache
function filterDataForFreeRam(dataInner)
{
	dataInner = "Memory " + dataInner;
	dataInner = filterData(dataInner, 6);
	var rowForMem = 1;
	for (var i = dataInner.length - 1; i >= 0; i--) {
		if(dataInner[i][0].indexOf("Mem:") !== -1)
		{
			rowForMem = i;
			break;
		}
	}
	var totalRam = dataInner[rowForMem][1];
	var usedRam = dataInner[rowForMem][2];
	var freeRam = dataInner[rowForMem][3];
	var cacheRam = dataInner[rowForMem][5];
	if(parseInt(totalRam) == (parseInt(freeRam)+parseInt(usedRam)))
	{
		filterDataForRamSubFunction(usedRam, cacheRam, totalRam,true);
	}
	else
	{
		filterDataForRamSubFunction(usedRam, cacheRam, totalRam,false);
	}
}

function filterDataForFreeSwap(dataInner)
{
	dataInner = dataInner.substring(dataInner.indexOf("Swap:"));
	dataInner = filterData(dataInner, 4);
	var totalSwap = dataInner[0][1];
	var usedSwap = dataInner[0][2];	
	filterDataForCacheSubFunction(totalSwap, usedSwap)
}

function filterDataForioStatDx(dataInner)
{
	
	dataInner = dataInner.substring(dataInner.indexOf("kB_wrtn")+8);
	dataInner = dataInner.substring(dataInner.indexOf("kB_wrtn")+8);
	dataInner = filterData(dataInner, 5);
	var dataInnerLength = dataInner.length;
	var htmlForDiskIO = "<table style='width: 100%;'>";
	htmlForDiskIO += "<tr><th>Disk</th><th>Read</th><th>Write</th></tr>"
	var height = 38;
	if(dataInnerLength > 3)
	{
		height = 24;
	}	
	while(dataInnerLength > 6)
	{
		dataInner.pop();
		dataInnerLength = dataInner.length;
	}
	ioDiff.push(dataInner);
	var ioDiffLength = ioDiff.length;
	if(ioDiffLength > 1)
	{
		var outerArrayToPush = [];
		for(var i = 0; i < dataInnerLength; i++)
		{
			var arrayToPush = [];
			htmlForDiskIO += "<tr><td>"+dataInner[i][0]+"</td>";	
			htmlForDiskIO += "<td onclick='showGraphPopup("+'"'+"diskIO"+i+"readPopupCanvas"+'"'+","+'"'+dataInner[i][0]+" Read"+'"'+","+'"'+"onePage"+'"'+")' style='cursor: pointer;'  ><canvas id='diskIO"+i+"-read' style='background-color: #333; border: 1px solid white;' width='65px' height='"+height+"px'></canvas></td>";
			htmlForDiskIO += "<td onclick='showGraphPopup("+'"'+"diskIO"+i+"writePopupCanvas"+'"'+","+'"'+dataInner[i][0]+" Write"+'"'+","+'"'+"onePage"+'"'+")' style='cursor: pointer;'  ><canvas id='diskIO"+i+"-write' style='background-color: #333; border: 1px solid white;' width='65px' height='"+height+"'></canvas></td>";
			htmlForDiskIO += "</tr>";	
			if(ioDiffLength > 1)
			{
				var read = parseInt(ioDiff[1][i][4]) - parseInt(ioDiff[0][i][4]) //read
				var written = parseInt(ioDiff[1][i][5]) - parseInt(ioDiff[0][i][5]) //written
				arrayToPush = [read,written];
			}
			outerArrayToPush.push(arrayToPush);
		}
		ioDiffHistory.push(outerArrayToPush);
		if(ioDiffHistory.length > 20)
		{
			ioDiffHistory.shift();
		}
		htmlForDiskIO += "</table>";
		document.getElementById('DIOCanvas').innerHTML = htmlForDiskIO;
		document.getElementById('canvasMonitorLoading_DIO').style.display = "none";
		document.getElementById('DIOCanvas').style.display = "block";
		for(var i = 0; i < dataInnerLength; i++)
		{
			//create array from column in array of arrays 
			var arrayToShowInConsole = new Array();
			var baseArray = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
			ioDiffLength = ioDiffHistory.length-1;
			for (var j = 0; j < (20 - ioDiffLength); j++) 
			{
				arrayToShowInConsole.push(0);
			}
			for (var j = 0; j < (ioDiffLength); j++) 
			{
				arrayToShowInConsole.push(ioDiffHistory[j][i][0]);
			}
			var maxOfArray = Math.max.apply(Math, arrayToShowInConsole);
			var arrayToShowInConsoleLength = arrayToShowInConsole.length;
			for(var j = 0; j < arrayToShowInConsoleLength; j++)
			{
				arrayToShowInConsole[j] = ((arrayToShowInConsole[j]/maxOfArray)*100).toFixed(1);
			}
			var fillThis = document.getElementById("diskIO"+i+"-read").getContext("2d");
			fillAreaInChart(arrayToShowInConsole, baseArray, "blue",fillThis, height, 65,1);

			var popupFillArea = document.getElementById("diskIO"+i+"readPopupCanvas");
			if(popupFillArea)
			{
				var arrayOfArraysToFillWith = [arrayToShowInConsole];
				popupFillInChart(popupFillArea, baseArray, arrayOfArraysToFillWith);
				document.getElementById('popupGraphLowerTr').innerHTML = "<th style='background-color:blue; width:25px;'><th  style='text-align:left;'>Current: "+arrayToShowInConsole[arrayToShowInConsoleLength-1]+"% of "+maxOfArray+" kB</th></th>";
			}

			arrayToShowInConsole = new Array();
			for (var j = baseArray.length - 1; j >= 0; j--) 
			{
				baseArray[j] = 0;
			}
			for (var j = 0; j < (20 - ioDiffLength); j++) 
			{
				arrayToShowInConsole.push(0);
			}
			for (var j = 0; j < (ioDiffLength); j++) 
			{
				arrayToShowInConsole.push(ioDiffHistory[j][i][1]);
			}
			maxOfArray = Math.max.apply(Math, arrayToShowInConsole);
			arrayToShowInConsoleLength = arrayToShowInConsole.length;
			for(var j = 0; j < arrayToShowInConsoleLength; j++)
			{
				arrayToShowInConsole[j] = ((arrayToShowInConsole[j]/maxOfArray)*100).toFixed(1);
			}
			fillThis = document.getElementById("diskIO"+i+"-write").getContext("2d");
			fillAreaInChart(arrayToShowInConsole, baseArray, "blue",fillThis, height, 65,1);

			var popupFillArea = document.getElementById("diskIO"+i+"writePopupCanvas");
			if(popupFillArea)
			{
				var arrayOfArraysToFillWith = [arrayToShowInConsole];
				popupFillInChart(popupFillArea, baseArray, arrayOfArraysToFillWith);
				document.getElementById('popupGraphLowerTr').innerHTML = "<th style='background-color:blue; width:25px;'><th  style='text-align:left;'>Current: "+arrayToShowInConsole[arrayToShowInConsoleLength-1]+"% of "+maxOfArray+" kB</th></th>";
			}
		}
		ioDiff.shift();
	}
}

function filterDataForNetworkDev(dataInner)
{
	dataInner = dataInner.substring(dataInner.indexOf("carrier compressed")+19);
	dataInner = filterData(dataInner, 16);
	networkArrayOfArrays.push(dataInner);
	if(networkArrayOfArrays.length > 21)
	{
		networkArrayOfArrays.shift();
	}
	if(networkArrayOfArrays.length > 1)
	{
		var netLength = networkArrayOfArrays.length;
		var netNetLength = networkArrayOfArrays[netLength-1].length; 
		var arrayNewDiff = [];
		for (var i = 0; i < netNetLength; i++)
		{
			var bytesRecieved = parseInt(networkArrayOfArrays[netLength-1][i][1])-parseInt(networkArrayOfArrays[netLength-2][i][1]);
			var packetsRecieved = parseInt(networkArrayOfArrays[netLength-1][i][2])-parseInt(networkArrayOfArrays[netLength-2][i][2]);
			var bytesSent = parseInt(networkArrayOfArrays[netLength-1][i][9])-parseInt(networkArrayOfArrays[netLength-2][i][9]);
			var packetsSent = parseInt(networkArrayOfArrays[netLength-1][i][10])-parseInt(networkArrayOfArrays[netLength-2][i][10]);
			arrayNewDiff.push([bytesRecieved, packetsRecieved,bytesSent,packetsSent]);
		}
		networkArrayOfArraysDifference.push(arrayNewDiff);
		if(networkArrayOfArraysDifference.length > 20)
		{
			networkArrayOfArraysDifference.shift();
		}
	}
	var htmlForNetwork = "<table style='width: 100%;'>";
	htmlForNetwork += "<tr><th style='width:50px;'>Interface</th><th>Receive</th><th>Transmit</th></tr>";
	var networkArrayOfArraysLength = networkArrayOfArrays[0].length;
	var count = networkArrayOfArrays.length -1;
	for (var i = 0; i < networkArrayOfArraysLength; i++)
	{
		htmlForNetwork += "<tr><td>"+networkArrayOfArrays[count][i][0]+"</td>"
		htmlForNetwork += "<td>";
		if(!(networkArrayOfArrays.length > 1))
		{
			htmlForNetwork += "<img style='margin-top: 25px; margin-left: 75px; position: absolute;' src='../core/img/loading.gif' height='50' width='50'>";
		}
		else
		{
			htmlForNetwork += "<div class='TableInfoForNet'>Current: "+networkArrayOfArraysDifference[count-1][i][0]+"</div>"
		}
		htmlForNetwork += "<canvas onclick='showGraphPopup("+'"'+"networkGraphPopup"+networkArrayOfArrays[count][i][0]+"receive"+'"'+","+'"'+networkArrayOfArrays[count][i][0]+" Receive"+'"'+","+'"'+"onePage"+'"'+")' id='"+networkArrayOfArrays[count][i][0]+"-downloadCanvas' style='background-color:#333; border: 1px solid white; cursor: pointer;' width='200' height='100' ></canvas><div class='TableInfoForNet'>Bytes: "+networkArrayOfArrays[count][i][1]+"</div></td>"
		htmlForNetwork += "<td>";
		if(!(networkArrayOfArrays.length > 1))
		{
			htmlForNetwork += "<img style='margin-top: 25px; margin-left: 75px; position: absolute;' src='../core/img/loading.gif' height='50' width='50'>";
		}
		else
		{
			htmlForNetwork += "<div class='TableInfoForNet'>Current: "+networkArrayOfArraysDifference[count-1][i][2]+"</div>"
		}
		htmlForNetwork += "<canvas onclick='showGraphPopup("+'"'+"networkGraphPopup"+networkArrayOfArrays[count][i][0]+"transmit"+'"'+","+'"'+networkArrayOfArrays[count][i][0]+" Transmit"+'"'+","+'"'+"onePage"+'"'+")' id='"+networkArrayOfArrays[count][i][0]+"-uploadCanvas' style='background-color:#333; border: 1px solid white; cursor: pointer;' width='200' height='100' ></canvas><div class='TableInfoForNet'>Bytes: "+networkArrayOfArrays[count][i][9]+"</div></td></tr>"
	}
	htmlForNetwork += "</table>";
	document.getElementById('networkArea').innerHTML = htmlForNetwork;
	if(networkArrayOfArrays.length > 1)
	{
		for (var i = 0; i < networkArrayOfArraysLength; i++)
		{
			//create array from column in array of arrays 
			var arrayToShowInConsole = new Array();
			var baseArray = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
			var netDiffLength = networkArrayOfArraysDifference.length;
			for (var j = 0; j < (20 - netDiffLength); j++) 
			{
				arrayToShowInConsole.push(0);
			}
			for (var j = 0; j < (netDiffLength); j++) 
			{
				arrayToShowInConsole.push(networkArrayOfArraysDifference[j][i][0]);
			}
			var maxOfArray = Math.max.apply(Math, arrayToShowInConsole);
			var arrayToShowInConsoleLength = arrayToShowInConsole.length;
			for(var j = 0; j < arrayToShowInConsoleLength; j++)
			{
				arrayToShowInConsole[j] = ((arrayToShowInConsole[j]/maxOfArray)*100).toFixed(1);
			}
			var fillThis = document.getElementById(networkArrayOfArrays[count][i][0]+"-downloadCanvas").getContext("2d");
			fillAreaInChart(arrayToShowInConsole, baseArray, "blue",fillThis, 100, 200,1);

			var fillPopoupArea = document.getElementById("networkGraphPopup"+networkArrayOfArrays[count][i][0]+"receive");
			if(fillPopoupArea)
			{
				var arrayOfArraysToFillWith = [arrayToShowInConsole];
				popupFillInChart(fillPopoupArea, baseArray, arrayOfArraysToFillWith);
				document.getElementById('popupGraphLowerTr').innerHTML = "<th style='background-color:blue; width:25px;'><th  style='text-align:left;'>Current: "+arrayToShowInConsole[arrayToShowInConsoleLength-1]+"% of "+maxOfArray+"</th></th>";
			}


			arrayToShowInConsole = new Array();
			baseArray = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
			netDiffLength = networkArrayOfArraysDifference.length;
			for (var j = 0; j < (20 - netDiffLength); j++) 
			{
				arrayToShowInConsole.push(0);
			}
			for (var j = 0; j < (netDiffLength); j++) 
			{
				arrayToShowInConsole.push(networkArrayOfArraysDifference[j][i][2]);
			}
			maxOfArray = Math.max.apply(Math, arrayToShowInConsole);
			arrayToShowInConsoleLength = arrayToShowInConsole.length;
			for(var j = 0; j < arrayToShowInConsoleLength; j++)
			{
				arrayToShowInConsole[j] = ((arrayToShowInConsole[j]/maxOfArray)*100).toFixed(1);
			}
			fillThis = document.getElementById(networkArrayOfArrays[count][i][0]+"-uploadCanvas").getContext("2d");
			fillAreaInChart(arrayToShowInConsole, baseArray, "blue",fillThis, 100, 200,1);

			var fillPopoupArea = document.getElementById("networkGraphPopup"+networkArrayOfArrays[count][i][0]+"transmit");
			if(fillPopoupArea)
			{
				var arrayOfArraysToFillWith = [arrayToShowInConsole];
				popupFillInChart(fillPopoupArea, baseArray, arrayOfArraysToFillWith);
				document.getElementById('popupGraphLowerTr').innerHTML = "<th style='background-color:blue; width:25px;'><th  style='text-align:left;'>Current: "+arrayToShowInConsole[arrayToShowInConsoleLength-1]+"% of "+maxOfArray+"</th></th>";
			}
		}
	}
}

function filterProcessByUser()
{
	selectedUser = document.getElementById('processUserSelect').value;
	psAuxFunction();
}

function filterDataForProcessesPreSort(dataInner)
{
	dataInnerNewArrayOfArrays = filterData(dataInner, 10);
	dataInnerNewArrayOfArrays.shift();
	filterDataForProcesses(dataInnerNewArrayOfArrays);
	
}

function filterDataFromProcStat(dataInner)
{
	dataInner = filterData(dataInner, 10);
	processInfoArray.push([dataInner[0][1],dataInner[0][3],dataInner[0][4],dataInner[0][5]]);
	if(processInfoArray.length > 1)
	{
		var processOneDiff = [processInfoArray[1][0]]-processInfoArray[0][0];
		var processTwoDiff = [processInfoArray[1][1]]-processInfoArray[0][1];
		var processThreeDiff = [processInfoArray[1][2]]-processInfoArray[0][2];
		var processFourDiff = [processInfoArray[1][3]]-processInfoArray[0][3];
		processInfoArrayDiff.push([processOneDiff, processTwoDiff, processThreeDiff, processFourDiff]);
		if(processInfoArrayDiff.length > 20)
		{
			processInfoArrayDiff.shift();
		}
		processInfoArray.shift();
		var currentLengthOfArray = processInfoArrayDiff.length;
		var user = processInfoArrayDiff[currentLengthOfArray-1][0];
		var sys = processInfoArrayDiff[currentLengthOfArray-1][1];
		var idle = processInfoArrayDiff[currentLengthOfArray-1][2]; 
		var iow = processInfoArrayDiff[currentLengthOfArray-1][3];
		var active = user+sys+iow;
		var total = active+idle;
		var ptc = (active*100)/total;
		var userInfo = ((user*100)/total).toFixed(1);
		var systemInfo = ((sys*100)/total).toFixed(1);
		var otherInfo = ((iow*100)/total).toFixed(1);
		filterDataForCPUSubFunction(userInfo, systemInfo, otherInfo);
	}
}

function filterDataForProcesses(dataInnerNewArrayOfArrays)
{
	var sortColumnNumber = Math.abs(processFilterByRow) - 1;
	sortArray(dataInnerNewArrayOfArrays, sortColumnNumber);
	if(!(processFilterByRow > 0))
	{
		dataInnerNewArrayOfArrays.reverse();
	}
	var dataInnerNewArrayOfArraysLength = dataInnerNewArrayOfArrays.length;
	//create array of 'users'
	var arrayOfUserProcesses = [];
	arrayOfUserProcesses.push('USER');
	for (var i = 0; i < dataInnerNewArrayOfArraysLength; i++) 
	{
		if(arrayOfUserProcesses.indexOf(dataInnerNewArrayOfArrays[i][0]) == -1)
		{
			arrayOfUserProcesses.push(dataInnerNewArrayOfArrays[i][0]);
		}
	}
	var htmlForProcesses = "<table style='width: 100%;'>";
	//0-11 is a row
	htmlForProcesses += "<tr class'headerProcess'>";
		//USER
		htmlForProcesses += "<th><select id='processUserSelect' onchange='filterProcessByUser();' >";
			var arrayOfUserProcessesLength = arrayOfUserProcesses.length;
			for (var i = 0; i < arrayOfUserProcessesLength; i++)
			{
				htmlForProcesses += "<option ";
				if(selectedUser == arrayOfUserProcesses[i])
				{
					htmlForProcesses += " selected ";
				}
				htmlForProcesses += " value='"+arrayOfUserProcesses[i]+"'> "+arrayOfUserProcesses[i]+" </option>";
			} 
		htmlForProcesses += "</th></select>";
		//PID 
		if(processFilterByRow == 2)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(2,-1)'>PID &uarr;";
		}
		else 
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(2,1)'>PID";
			if(processFilterByRow == -2)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";
		//CPU
		if(processFilterByRow == 3)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(3,-1)'>%CPU &uarr;";
		}
		else
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(3,1)'>%CPU";
			if(processFilterByRow == -3)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";
		//Mem
		if(processFilterByRow == 4)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(4,-1)'>%MEM &uarr;";
		}
		else 
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(4,1)'>%MEM";
			if(processFilterByRow == -4)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";
		//VSZ
		if(processFilterByRow == 5)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(5,-1)'>VSZ &uarr;";
		}
		else 
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(5,1)'>VSZ ";
			if(processFilterByRow == -5)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";
		//RSS
		if(processFilterByRow == 6)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(6,-1)'>RSS &uarr;";
		}
		else
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(6,1)'>RSS";
			if(processFilterByRow == -6)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";
		//TTY
		if(processFilterByRow == 7)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(7,-1)'>TTY &uarr;";
		}
		else
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(7,1)'>TTY ";
			if(processFilterByRow == -7)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";
		//Stat
		if(processFilterByRow == 8)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(8,-1)'>STAT &uarr;";
		}
		else
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(8,1)'>STAT";
			if(processFilterByRow == -8)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";
		//Start
		if(processFilterByRow == 9)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(9,-1)'>START &uarr;";
		}
		else
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(9,1)'>START ";
			if(processFilterByRow == -9)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";
		//Time
		if(processFilterByRow == 10)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(10,-1)'>TIME &uarr;";
		}
		else
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(10,1)'>TIME";
			if(processFilterByRow == -10)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";
		//Command
		htmlForProcesses += "";
		if(processFilterByRow == 11)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(11,-1)'>COMMAND &uarr;";
		}
		else
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(11,1)'>COMMAND";
			if(processFilterByRow == -11)
			{
				htmlForProcesses += " &darr;";
			}
		}
		htmlForProcesses += "</th>";	
		htmlForProcesses += "<th style='cursor:default;' ></th>";
	htmlForProcesses += "</tr>";
	for (var i = 0; i < dataInnerNewArrayOfArraysLength; i++) 
	{
		if(selectedUser == "USER" || dataInnerNewArrayOfArrays[i][0] == selectedUser)
		{
			htmlForProcesses += "<tr>";
			var dataInnerNewArrayOfArraysILength = dataInnerNewArrayOfArrays[i].length;
			for (var j =  0; j < dataInnerNewArrayOfArraysILength; j++) 
			{
				htmlForProcesses += "<td>" + dataInnerNewArrayOfArrays[i][j]+"</td>";
			}
			htmlForProcesses += "<td>";
			if((dataInnerNewArrayOfArrays[i][0] != "root") || (dataInnerNewArrayOfArrays[i][10].length > 8))
			{
				htmlForProcesses += "<div class='expandMenu' onclick='dropdownShow("+'"'+'PID'+dataInnerNewArrayOfArrays[i][1]+'"'+")' ></div>";
				htmlForProcesses += "<div id='dropdown-PID"+dataInnerNewArrayOfArrays[i][1]+"' class='dropdown-content'>";
				htmlForProcesses += "<ul class='dropdown-content__items'>";
				if(dataInnerNewArrayOfArrays[i][0] == "www-data")
				{
					htmlForProcesses += "<li class='dropdown-content__item'><a onclick='killProcess("+dataInnerNewArrayOfArrays[i][1]+")' >Kill Process</a></li>"
				}
				if(dataInnerNewArrayOfArrays[i][10].length > 8)
				{
					htmlForProcesses += "<li class='dropdown-content__item'><a onclick='showFullCommand("+'"'+dataInnerNewArrayOfArrays[i][10]+'"'+")' >Full Command</a></li>"
				}
				htmlForProcesses += "</ul></div>";
			}
			else
			{
				htmlForProcesses += "<div class='expandMenu' style='color: rgba(0,0,0,0) !important; cursor: default;' ></div>";
				
			}
			htmlForProcesses += "</td></tr>";
		}
	}
	htmlForProcesses += "</table>";
	document.getElementById('processIds').innerHTML = htmlForProcesses;
}

function showFullCommand(command)
{
	showPopup();
	document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Full Command:</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+command+"</div><div><div class='link' onclick='hidePopup();' style='margin-left:175px; margin-top:25px;'>Okay</div></div>";
}

function filterProcessDataBy(column, reverse)
{	
	processFilterByRow = column*reverse;
	psAuxFunction();
}

function filterAndSort(preSortArray, limit, reverse)
{
	sortArray(preSortArray, 4);
	if(reverse)
	{
		preSortArray.reverse();
	}
	while(preSortArray.length > limit)
	{
		preSortArray.shift();
	}
	return preSortArray;
}

function filterDataForDiskSpace(dataInner)
{
	dataInnerNewArrayOfArraysHDD = filterData(dataInner, 5);
	filteredHDDArray = [];
	for (var i = dataInnerNewArrayOfArraysHDD.length - 1; i >= 0; i--) 
	{
		if(dataInnerNewArrayOfArraysHDD[i][4] != "-" && dataInnerNewArrayOfArraysHDD[i][4] != "0%" && dataInnerNewArrayOfArraysHDD[i][4] != "Use%")
		{
			filteredHDDArray.push(dataInnerNewArrayOfArraysHDD[i]);
		}
	}
	filteredHDDArray = filterAndSort(filteredHDDArray, 7, true);
	if(filteredHDDArray.length < 7)
	{
		for (var i = dataInnerNewArrayOfArraysHDD.length - 1; i >= 0; i--) 
		{
			if(dataInnerNewArrayOfArraysHDD[i][4] == "0%")
			{
				filteredHDDArray.push(dataInnerNewArrayOfArraysHDD[i]);
			}
		}
		filteredHDDArray = filterAndSort(filteredHDDArray, 7, false);
		filteredHDDArray.reverse();
	}
	var htmlForProcesses = "<table style='width: 100%;'>";
	var dataInnerNewArrayOfArraysHDDLength = filteredHDDArray.length;
	for (var i = 0; i < dataInnerNewArrayOfArraysHDDLength; i++) 
	{
		//htmlForProcesses += "<tr onclick='showGraphPopup("+'"graph"'+", "+'"'+filteredHDDArray[i][0]+"("+filteredHDDArray[i][5]+")"+'"'+","+'"twoColumnLeftOneGraphRightOneGraphOneDescription"'+")' style='font-size: 75%; cursor: pointer;'>";
		htmlForProcesses += "<tr style='font-size: 75%;' >";
		var percent = filteredHDDArray[i][4].slice(0,-1);
		percent = parseInt(percent);
		htmlForProcesses += "<td style='max-width: 20px; overflow: hidden;'><div class='led-";
		if(percent > 90)
		{
			htmlForProcesses +=  "red";
		}
		else if(percent > 70)
		{
			htmlForProcesses += "yellow";
		}
		else if(percent > 0)
		{
			htmlForProcesses += "green";
		}
		else
		{
			htmlForProcesses += "blue";
		}
		htmlForProcesses += "'></td>";
		if(dataSwap)
		{
			htmlForProcesses += "<td style='max-width: 100px; overflow: hidden;'>" + filteredHDDArray[i][5]+"</td>";
		}
		else
		{
			htmlForProcesses += "<td style='max-width: 100px; overflow: hidden;'>" + filteredHDDArray[i][0]+"</td>";
		}
		htmlForProcesses += "<td style='max-width: 30px; overflow: hidden;'>" + filteredHDDArray[i][4]+"</td>";
		htmlForProcesses += "</tr>";
	}
	if(dataSwap)
	{
		dataSwap = false;
	}
	else
	{
		dataSwap = true;
	}
	htmlForProcesses += "</table>";
	document.getElementById('canvasMonitorLoading_HDD').style.display = "none";
	document.getElementById('HDDCanvas').style.display = "block";
	document.getElementById('HDDCanvas').innerHTML = htmlForProcesses;
}

function filterDataForCache(dataInner)
{
	dataInner = dataInner.substring(dataInner.indexOf("KiB Swap:")+9);
	dataInner = dataInner.replace(/\s/g, '');
	dataInner = dataInner.split(",");
	//0 = total, 1 = free, 2 = used
	var totalSwap = dataInner[0].substring(0, dataInner[0].length - 5);
	var freeSwap = dataInner[1].substring(0, dataInner[1].length - 4);
	var usedSwap = dataInner[2].substring(0, dataInner[2].length - 4);
	filterDataForCacheSubFunction(totalSwap, usedSwap);
}

function filterDataForCacheSubFunction(totalSwap, usedSwap)
{
	usedSwap = parseFloat(usedSwap)/parseInt(totalSwap);
	usedSwap = (usedSwap*100).toFixed(1);
	swapInfoArray_Used.push(usedSwap);
	document.getElementById('canvasMonitorSwap').innerHTML = usedSwap;
	document.getElementById('canvasMonitorLoading_Swap').style.display = "none";
	document.getElementById('swapCanvas').style.display = "block";
	swapInfoArray_Used.shift();
	swapAreaContext.clearRect(0, 0, swapArea.width, swapArea.height);
	swapInfoArray_heightVar = clearBaseArray(swapInfoArray_heightVar);
	fillAreaInChart(swapInfoArray_Used, swapInfoArray_heightVar, "blue",swapAreaContext, swapArea.height, swapArea.width,1);
	var swapPopupArea = document.getElementById('swapPopupCanvas');
	if(swapPopupArea)
	{
		var arrayOfArraysToFillWith = [swapInfoArray_Used];
		popupFillInChart(swapPopupArea, swapInfoArray_heightVar, arrayOfArraysToFillWith);
		document.getElementById('popupGraphLowerTr').innerHTML = "<th style='background-color:blue; width:25px;'><th  style='text-align:left;'>Used: "+usedSwap+"%</th></th>";
	}
}

function filterDataForRAM(dataInner)
{
	dataInner = dataInner.substring(dataInner.indexOf("KiB Mem :")+9);
	dataInner = dataInner.replace(/\s/g, '');
	dataInner = dataInner.split(",");
	//0 = total, 1 = free, 2 = used, 3 = cache
	var totalRam = dataInner[0].substring(0, dataInner[0].length - 5);
	var freeRam = dataInner[1].substring(0, dataInner[1].length - 4);
	var usedRam = dataInner[2].substring(0, dataInner[2].length - 4);
	var cacheRam = dataInner[3].substring(0, dataInner[3].length - 10);
	filterDataForRamSubFunction(usedRam, cacheRam, totalRam,false);
}

function filterDataForRamSubFunction(usedRam, cacheRam, totalRam,skipCache)
{
	usedRam = parseFloat(usedRam)/parseInt(totalRam);
	usedRam = (usedRam*100).toFixed(1);
	ramInfoArray_Used.push(usedRam);
	document.getElementById('canvasMonitorRAM_Used').innerHTML = usedRam;
	if(!skipCache)
	{
		cacheRam = parseFloat(cacheRam)/parseInt(totalRam);
		cacheRam = (cacheRam*100).toFixed(1);
		ramInfoArray_Cache.push(cacheRam);
		document.getElementById('canvasMonitorRAM_Cache').innerHTML = cacheRam;
	}
	else
	{
		document.getElementById('canvasMonitorRAM_Cache').innerHTML = "?";
	}
	document.getElementById('canvasMonitorLoading_RAM').style.display = "none";
	document.getElementById('ramCanvas').style.display = "block";
	ramInfoArray_Cache.shift();
	ramInfoArray_Used.shift();
	ramAreaContext.clearRect(0, 0, ramArea.width, ramArea.height);
	ramInfoArray_heightVar = clearBaseArray(ramInfoArray_heightVar);
	fillAreaInChart(ramInfoArray_Used, ramInfoArray_heightVar, "blue",ramAreaContext, ramArea.height, ramArea.width,1);
	if(!skipCache)
	{
		fillAreaInChart(ramInfoArray_Cache, ramInfoArray_heightVar, "red",ramAreaContext, ramArea.height, ramArea.width,1);
	}
	var ramPopupArea = document.getElementById('ramPopupCanvas');
	if(ramPopupArea)
	{
		var arrayOfArraysToFillWith = [ramInfoArray_Used];
		if(!skipCache)
		{
			arrayOfArraysToFillWith = [ramInfoArray_Used,ramInfoArray_Cache];
		}
		popupFillInChart(ramPopupArea, ramInfoArray_heightVar, arrayOfArraysToFillWith);
		if(!skipCache)
		{
			document.getElementById('popupGraphLowerTr').innerHTML = "<th>All: "+((parseFloat(usedRam)+parseFloat(cacheRam)).toFixed(1))+"%</th><th style='background-color:blue; width:25px;'><th  style='text-align:left;'>Used: "+usedRam+"%</th><th style='background-color:red; width:25px;'><th  style='text-align:left;'>Cache: "+cacheRam+"%</th>";
		}
		else
		{
			document.getElementById('popupGraphLowerTr').innerHTML = "<th style='background-color:blue; width:25px;'><th  style='text-align:left;'>Used: "+usedRam+"%</th>";
		}
	}
}

function filterDataForCPU(dataInner)
{
	dataInner = dataInner.substring(dataInner.indexOf("%Cpu(s):")+8);
	dataInner = dataInner.replace(/\s/g, '');
	dataInner = dataInner.split(",");
	//0 = user, 1 = system, 2 = other;
	var userInfo = dataInner[0].substring(0, dataInner[0].length - 2);
	var systemInfo = dataInner[1].substring(0, dataInner[1].length - 2);
	var otherInfo = dataInner[2].substring(0, dataInner[2].length - 2);
	filterDataForCPUSubFunction(userInfo, systemInfo, otherInfo);
}

function filterDataForCPUSubFunction(userInfo, systemInfo, otherInfo)
{
	document.getElementById('canvasMonitorCPU_User').innerHTML = userInfo;
	cpuInfoArray_User.push(parseFloat(userInfo));
	document.getElementById('canvasMonitorCPU_System').innerHTML = systemInfo;
	cpuInfoArray_System.push(parseFloat(systemInfo));
	document.getElementById('canvasMonitorCPU_Other').innerHTML = otherInfo;
	cpuInfoArray_other.push(parseFloat(otherInfo));
	document.getElementById('canvasMonitorLoading_CPU').style.display = "none";
	document.getElementById('cpuCanvas').style.display = "block";
	cpuInfoArray_User.shift();
	cpuInfoArray_System.shift();
	cpuInfoArray_other.shift();
	cpuInfoArray_heightVar = clearBaseArray(cpuInfoArray_heightVar)
	cpuAreaContext.clearRect(0, 0, cpuArea.width, cpuArea.height);
	fillAreaInChart(cpuInfoArray_User, cpuInfoArray_heightVar, "blue",cpuAreaContext, cpuArea.height, cpuArea.width,1);
	fillAreaInChart(cpuInfoArray_System, cpuInfoArray_heightVar, "red",cpuAreaContext, cpuArea.height, cpuArea.width,1);
	fillAreaInChart(cpuInfoArray_other, cpuInfoArray_heightVar, "yellow",cpuAreaContext, cpuArea.height, cpuArea.width,1);
	var cpuAreaPopup = document.getElementById('cpuPopupCanvas');
	if(cpuAreaPopup)
	{
		var arrayOfArraysToFillWith = [cpuInfoArray_User,cpuInfoArray_System,cpuInfoArray_other];
		popupFillInChart(cpuAreaPopup, cpuInfoArray_heightVar, arrayOfArraysToFillWith);
		document.getElementById('popupGraphLowerTr').innerHTML = "<th>All: "+((parseFloat(userInfo)+parseFloat(systemInfo)+parseFloat(otherInfo)).toFixed(1))+"%</th><th style='background-color:blue; width:25px;'></th><th style='text-align:left;'>User: "+userInfo+"%</th><th style='background-color:red; width:25px;'></th><th style='text-align:left;'>System: "+systemInfo+"%</th><th style='background-color:yellow; width:25px;'></th><th style='text-align:left;'>Other: "+otherInfo+"%</th>";
	}
}

function popupFillInChart(canvas, baseArray, arrayOfArraysToFillWith)
{
	document.getElementById('popupGraphLoadingSpinner').style.display = "none";
	canvas.style.display = "inline-block";
	var canvasPopupContext = canvas.getContext("2d");
	canvasPopupContext.clearRect(0, 0, canvas.width, canvas.height);
	baseArray = clearBaseArray(baseArray);
	var arrayOfArraysToFillWithLength = arrayOfArraysToFillWith.length;
	var arrayOfColors = ["blue","red",'yellow'];
	for (var i = 0; i < arrayOfArraysToFillWithLength; i++) 
	{
		fillAreaInChart(arrayOfArraysToFillWith[i], baseArray, arrayOfColors[i],canvasPopupContext, canvas.height, canvas.width,2);
		
	}
}

function clearBaseArray(baseArray)
{
	for (var i = baseArray.length - 1; i >= 0; i--) {
	baseArray[i] = 0;
	}
	return baseArray;
}
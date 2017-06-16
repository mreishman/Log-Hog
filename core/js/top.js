var dropdownMenuVisible = false;

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

function fillAreaInChart(arrayForFill, bottomArray, color, context, height, width)
{
	context.fillStyle = color;
	var totalWidthOfEachElement = width/bottomArray.length;
	for (var i = arrayForFill.length - 1; i >= 0; i--) 
	{
		var heightOfElement = height*(arrayForFill[i]/100);
		context.fillRect((totalWidthOfEachElement*(i)),(height-heightOfElement-bottomArray[i]),totalWidthOfEachElement,heightOfElement);
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
	return dataInnerNewArrayOfArrays;

}

function filterDataForioStatDx(dataInner)
{
	//console.log(dataInner);
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
		htmlForNetwork += "<canvas id='"+networkArrayOfArrays[count][i][0]+"-downloadCanvas' style='background-color:#333; border: 1px solid white;' width='200' height='100' ></canvas><div class='TableInfoForNet'>Bytes: "+networkArrayOfArrays[count][i][1]+"</div></td>"
		htmlForNetwork += "<td>";
		if(!(networkArrayOfArrays.length > 1))
		{
			htmlForNetwork += "<img style='margin-top: 25px; margin-left: 75px; position: absolute;' src='../core/img/loading.gif' height='50' width='50'>";
		}
		htmlForNetwork += "<canvas id='"+networkArrayOfArrays[count][i][0]+"-uploadCanvas' style='background-color:#333; border: 1px solid white;' width='200' height='100' ></canvas><div class='TableInfoForNet'>Bytes: "+networkArrayOfArrays[count][i][9]+"</div></td></tr>"
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
				arrayToShowInConsole[j] = (arrayToShowInConsole[j]/maxOfArray)*100;
			}
			var fillThis = document.getElementById(networkArrayOfArrays[count][i][0]+"-downloadCanvas").getContext("2d");
			fillAreaInChart(arrayToShowInConsole, baseArray, "blue",fillThis, 100, 200);

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
				arrayToShowInConsole[j] = (arrayToShowInConsole[j]/maxOfArray)*100;
			}
			var fillThis = document.getElementById(networkArrayOfArrays[count][i][0]+"-uploadCanvas").getContext("2d");
			fillAreaInChart(arrayToShowInConsole, baseArray, "blue",fillThis, 100, 200);
		}
	}
}

function filterProcessByUser()
{
	selectedUser = document.getElementById('processUserSelect').value;
	psAuxFunction();
}

function filterDataForProcesses(dataInner)
{
	dataInnerNewArrayOfArrays = filterData(dataInner, 10);
	dataInnerNewArrayOfArrays.shift();
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
				if(dataInnerNewArrayOfArrays[i][0] != "root")
				{
					htmlForProcesses += "<li class='dropdown-content__item'><a>Kill Process</a></li>"
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
	sortArray(filteredHDDArray, 4)
	filteredHDDArray.reverse();
	while(filteredHDDArray.length > 6)
	{
		filteredHDDArray.shift();
	}
	var htmlForProcesses = "<table style='width: 100%;'>";
	var dataInnerNewArrayOfArraysHDDLength = filteredHDDArray.length;
	for (var i = 0; i < dataInnerNewArrayOfArraysHDDLength; i++) 
	{
		htmlForProcesses += "<tr style='font-size: 75%;'>";
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
		else
		{
			htmlForProcesses += "green";
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
		htmlForProcesses += "<td style='max-width: 30px;'><div class='expandMenu'></div></td>";
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
	usedSwap = parseFloat(usedSwap)/parseInt(totalSwap);
	usedSwap = (usedSwap*100).toFixed(1);
	swapInfoArray_Used.push(usedSwap);
	document.getElementById('canvasMonitorSwap').innerHTML = usedSwap;
	document.getElementById('canvasMonitorLoading_Swap').style.display = "none";
	swapInfoArray_Used.shift();
	swapAreaContext.clearRect(0, 0, swapArea.width, swapArea.height);
	for (var i = swapInfoArray_heightVar.length - 1; i >= 0; i--) {
		swapInfoArray_heightVar[i] = 0;
	}
	fillAreaInChart(swapInfoArray_Used, swapInfoArray_heightVar, "blue",swapAreaContext, 200, 200);
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
	usedRam = parseFloat(usedRam)/parseInt(totalRam);
	usedRam = (usedRam*100).toFixed(1);
	ramInfoArray_Used.push(usedRam);
	document.getElementById('canvasMonitorRAM_Used').innerHTML = usedRam;
	cacheRam = parseFloat(cacheRam)/parseInt(totalRam);
	cacheRam = (cacheRam*100).toFixed(1);
	ramInfoArray_Cache.push(cacheRam);
	document.getElementById('canvasMonitorRAM_Cache').innerHTML = cacheRam;
	document.getElementById('canvasMonitorLoading_RAM').style.display = "none";
	ramInfoArray_Cache.shift();
	ramInfoArray_Used.shift();
	ramAreaContext.clearRect(0, 0, ramArea.width, ramArea.height);
	for (var i = ramInfoArray_heightVar.length - 1; i >= 0; i--) {
		ramInfoArray_heightVar[i] = 0;
	}
	fillAreaInChart(ramInfoArray_Used, ramInfoArray_heightVar, "blue",ramAreaContext, 200, 200);
	fillAreaInChart(ramInfoArray_Cache, ramInfoArray_heightVar, "red",ramAreaContext, 200, 200);
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
	document.getElementById('canvasMonitorCPU_User').innerHTML = userInfo;
	cpuInfoArray_User.push(parseFloat(userInfo));
	document.getElementById('canvasMonitorCPU_System').innerHTML = systemInfo;
	cpuInfoArray_System.push(parseFloat(systemInfo));
	document.getElementById('canvasMonitorCPU_Other').innerHTML = otherInfo;
	cpuInfoArray_other.push(parseFloat(otherInfo));
	document.getElementById('canvasMonitorLoading_CPU').style.display = "none";
	cpuInfoArray_User.shift();
	cpuInfoArray_System.shift();
	cpuInfoArray_other.shift();
	cpuAreaContext.clearRect(0, 0, cpuArea.width, cpuArea.height);
	for (var i = cpuInfoArray_heightVar.length - 1; i >= 0; i--) {
		cpuInfoArray_heightVar[i] = 0;
	}
	fillAreaInChart(cpuInfoArray_User, cpuInfoArray_heightVar, "blue",cpuAreaContext, 200, 200);
	fillAreaInChart(cpuInfoArray_System, cpuInfoArray_heightVar, "red",cpuAreaContext, 200, 200);
	fillAreaInChart(cpuInfoArray_other, cpuInfoArray_heightVar, "yellow",cpuAreaContext, 200, 200);
}
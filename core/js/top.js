function fillAreaInChart(arrayForFill, bottomArray, color, context)
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
			if((a[column].slice(0,-1)).indexOf("%") !== -1)
			{
				//% logic
				a[column] = a[column].slice(0,-1);
				b[column] = b[column].slice(0,-1);
			}
			if((isFloat(parseFloat(a[column]))) || (isInt(parseFloat(a[column]))))
			{
				return parseFloat(a[column]) == parseFloat(b[column]) ? 0 : (parseFloat(a[column]) > parseFloat(b[column]) ? 1 : -1);
			}
			else
			{
				return a[column] == b[column] ? 0 : (a[column] > b[column] ? 1 : -1);
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
					dataInnerNew.push(dataInnerNewRow[1]);
					counterForRow++;
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

	var htmlForProcesses = "<table style='width: 100%;'>";
	//0-11 is a row
	var dataInnerNewArrayOfArraysLength = dataInnerNewArrayOfArrays.length;
	htmlForProcesses += "<tr class'headerProcess'>";
		//USER
		if(processFilterByRow == 1)
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(1,-1)'>USER &uarr;";
		}
		else
		{
			htmlForProcesses += "<th onclick='filterProcessDataBy(1,1)'>USER";
			if(processFilterByRow == -1)
			{
				htmlForProcesses += " &darr;";
			}
			
		}
		htmlForProcesses += "</th>";
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
		htmlForProcesses += "<th>TTY";
		if(processFilterByRow == 7)
		{
			htmlForProcesses += "<span> &uarr;</span>";
		}
		else if(processFilterByRow == -7)
		{
			htmlForProcesses += "<span> &darr;</span>";
		}
		htmlForProcesses += "</th>";
		//Stat
		htmlForProcesses += "<th>STAT";
		if(processFilterByRow == 8)
		{
			htmlForProcesses += "<span> &uarr;</span>";
		}
		else if(processFilterByRow == -8)
		{
			htmlForProcesses += "<span> &darr;</span>";
		}
		htmlForProcesses += "</th>";
		//Start
		htmlForProcesses += "<th>START";
		if(processFilterByRow == 9)
		{
			htmlForProcesses += "<span> &uarr;</span>";
		}
		else if(processFilterByRow == -9)
		{
			htmlForProcesses += "<span> &darr;</span>";
		}
		htmlForProcesses += "</th>";
		//Time
		htmlForProcesses += "<th>TIME";
		if(processFilterByRow == 10)
		{
			htmlForProcesses += "<span> &uarr;</span>";
		}
		else if(processFilterByRow == -10)
		{
			htmlForProcesses += "<span> &darr;</span>";
		}
		htmlForProcesses += "</th>";
		//Command
		htmlForProcesses += "<th>COMMAND";
		if(processFilterByRow == 11)
		{
			htmlForProcesses += "<span> &uarr;</span>";
		}
		else if(processFilterByRow == -11)
		{
			htmlForProcesses += "<span> &darr;</span>";
		}
		htmlForProcesses += "</th>";	
		htmlForProcesses += "<th style='cursor:default;' ></th>";
	htmlForProcesses += "</tr>";
	for (var i = 0; i < dataInnerNewArrayOfArraysLength; i++) 
	{
		htmlForProcesses += "<tr>";
		var dataInnerNewArrayOfArraysILength = dataInnerNewArrayOfArrays[i].length;
		for (var j =  0; j < dataInnerNewArrayOfArraysILength; j++) 
		{
			htmlForProcesses += "<td>" + dataInnerNewArrayOfArrays[i][j]+"</td>";
		}
		htmlForProcesses += "<td><div class='expandMenu'></div></td>";
		htmlForProcesses += "</tr>";
	}
	htmlForProcesses += "</table>";
	document.getElementById('processIds').innerHTML = htmlForProcesses;
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
	fillAreaInChart(swapInfoArray_Used, swapInfoArray_heightVar, "blue",swapAreaContext);
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
	fillAreaInChart(ramInfoArray_Used, ramInfoArray_heightVar, "blue",ramAreaContext);
	fillAreaInChart(ramInfoArray_Cache, ramInfoArray_heightVar, "red",ramAreaContext);
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
	fillAreaInChart(cpuInfoArray_User, cpuInfoArray_heightVar, "blue",cpuAreaContext);
	fillAreaInChart(cpuInfoArray_System, cpuInfoArray_heightVar, "red",cpuAreaContext);
	fillAreaInChart(cpuInfoArray_other, cpuInfoArray_heightVar, "yellow",cpuAreaContext);
}

<meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0">
<meta http-equiv="expires" content="Sat, 31 Oct 2014 00:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">

<?php
$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');

$version = explode('.', $configStatic['version']);
$newestVersion = explode('.', $configStatic['newestVersion']);

$levelOfUpdate = 0; // 0 is no updated, 1 is minor update and 2 is major update

$newestVersionCount = count($newestVersion);
$versionCount = count($version);

for($i = 0; $i < $newestVersionCount; $i++)
{
	if($i < $versionCount)
	{
		if($i == 0)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 3;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		elseif($i == 1)
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 2;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
		else
		{
			if($newestVersion[$i] > $version[$i])
			{
				$levelOfUpdate = 1;
				break;
			}
			elseif($newestVersion[$i] < $version[$i])
			{
				break;
			}
		}
	}
	else
	{
		$levelOfUpdate = 1;
		break;
	}
}
require_once('../core/php/loadVars.php');
?>
<!doctype html>
<head>
	<title>Top | Overview</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>

<?php require_once('header.php');?>	

	<div id="main">
		<div id="topBarOverview">
			<div class="canvasMonitorDiv" >	
				<div class="canvasMonitorText">CPU</div>
				<img id="canvasMonitorLoading_CPU" style="margin-top: 75px; margin-left: 75px; position: absolute;" src='../core/img/loading.gif' height='50' width='50'> 
				<canvas class="canvasMonitor" id="cpuCanvas" width="200" height="200"></canvas>
				<div class="canvasMonitorText">U <span id="canvasMonitorCPU_User">-</span>% | S <span id="canvasMonitorCPU_System">-</span>% | N <span id="canvasMonitorCPU_Other">-</span>%</div>
			</div>
			<div class="canvasMonitorDiv" >	
				<div class="canvasMonitorText">RAM</div>
				<img id="canvasMonitorLoading_RAM" style="margin-top: 75px; margin-left: 75px; position: absolute;" src='../core/img/loading.gif' height='50' width='50'> 
				<canvas class="canvasMonitor" id="ramCanvas" width="200" height="200"></canvas>
				<div class="canvasMonitorText">Used <span id="canvasMonitorRAM_Used">-</span>% | Cache <span id="canvasMonitorRAM_Cache">-</span>%</div>
			</div>
			<div class="canvasMonitorDiv" >	
				<div class="canvasMonitorText">Swap</div>
				<img id="canvasMonitorLoading_Swap" style="margin-top: 75px; margin-left: 75px; position: absolute;" src='../core/img/loading.gif' height='50' width='50'> 
				<canvas class="canvasMonitor" id="swapCanvas" width="200" height="200"></canvas>
				<div class="canvasMonitorText"><span id="canvasMonitorSwap">-</span>%</div>
			</div>
		</div>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
	<script type="text/javascript">

	var nullReturnForDefaultPoll = false;
	var defaultArray = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
	var cpuInfoArray_User = [];
	var cpuInfoArray_heightVar = [];
	var cpuInfoArray_other = [];
	var cpuInfoArray_System = [];
	var ramInfoArray_Used = [];
	var ramInfoArray_Cache = [];
	var ramInfoArray_heightVar = [];
	var swapInfoArray_Used = [];
	var swapInfoArray_heightVar = [];

	for (var i = defaultArray.length - 1; i >= 0; i--) {
		cpuInfoArray_User.push(defaultArray[i]);
		cpuInfoArray_heightVar.push(defaultArray[i]);
		cpuInfoArray_other.push(defaultArray[i]);
		cpuInfoArray_System.push(defaultArray[i]);
		ramInfoArray_Used.push(defaultArray[i]);
		ramInfoArray_Cache.push(defaultArray[i]);
		ramInfoArray_heightVar.push(defaultArray[i]);
		swapInfoArray_Used.push(defaultArray[i]);
		swapInfoArray_heightVar.push(defaultArray[i]);
	}

	


	var width = 200;
	var height = 200;

	var cpuArea = document.getElementById('cpuCanvas');
	var cpuAreaContext = cpuArea.getContext("2d");

	var ramArea = document.getElementById('ramCanvas');
	var ramAreaContext = ramArea.getContext("2d");

	var swapArea = document.getElementById('swapCanvas');
	var swapAreaContext = swapArea.getContext("2d");

	function topFunction()
	{
		if(nullReturnForDefaultPoll)
		{
			$.getJSON('../core/php/topAlt.php', {}, function(data) {
				processDataFromTOP(data);
			})
		}
		else
		{
			$.getJSON('../core/php/top.php', {}, function(data) {
				if(data == null)
				{
					nullReturnForDefaultPoll = true;
					topFunction();
				}
				else
				{
					processDataFromTOP(data);
				}
			})
		}
	}

	function processDataFromTOP(data)
	{
		//console.log(data);
		filterDataForCPU(data);
		filterDataForRAM(data);
		fillDataForCache(data);
	}

	function fillDataForCache(dataInner)
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

	function poll()
	{
		topFunction();
	}


	poll();
	setInterval(poll, 2500);
	
	</script>
	<script src="../core/js/settings.js"></script>
</body>
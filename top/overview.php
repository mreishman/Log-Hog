
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
	<style type="text/css">
	#menu a, .link, .linkSmall, .context-menu, .dropdown-content{
		background-color: <?php echo $currentSelectedThemeColorValues[0]?>;
	}
</style>
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
			<div class="canvasMonitorDiv" >	
				<div class="canvasMonitorText">Disk Usage</div>
				<img id="canvasMonitorLoading_HDD" style="margin-top: 75px; margin-left: 75px; position: absolute;" src='../core/img/loading.gif' height='50' width='50'> 
				<div id="HDDCanvas" style="height: 200px; width: 200px;" class="canvasMonitor" ></div>
				<div class="canvasMonitorText"><span style="color: white;">n/a</span></div>
			</div>

		</div>
		<div id="bottomBarOverview">
			<div class="bottomBarOverviewHalf bottomBarOverviewLeft" id="processIds">

			</div>
			<div class="bottomBarOverviewHalf bottomBarOverviewRight" id="networkArea">

			</div>
		</div>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
	<script src="../core/js/top.js"></script>
	<script type="text/javascript">

	var dataSwap = false;

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
	var networkArrayOfArrays = [];
	var networkArrayOfArraysDifference = [];

	var processFilterByRow = 2;
	var selectedUser = "USER";

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

	function psAuxFunction()
	{
		if(!dropdownMenuVisible)
		{
		$.getJSON('../core/php/psAux.php', {}, function(data) {
				processDataFrompsAux(data);
			})
		}
	}

	function procNetDev()
	{
		$.getJSON('../core/php/procNetDev.php', {}, function(data) {
				processDataFromprocNetDev(data);
			})
	}

	function dfALFunction()
	{
		$.getJSON('../core/php/dfAL.php', {}, function(data) {
				processDataFrompsdfAL(data);
			})
	}

	function processDataFromprocNetDev(data)
	{
		filterDataForNetworkDev(data);
	}

	function processDataFrompsAux(data)
	{
		filterDataForProcesses(data);
	}

	function processDataFrompsdfAL(data)
	{
		filterDataForDiskSpace(data);
	}

	function processDataFromTOP(data)
	{
		filterDataForCPU(data);
		filterDataForRAM(data);
		filterDataForCache(data);
	}

	function poll()
	{
		topFunction();
		psAuxFunction();
		dfALFunction();
		procNetDev();
	}


	poll();
	setInterval(poll, 5000);
	
	var offsetHeight = 0;
	var offsetHeight2 = 0;
	if(document.getElementById('menu'))
	{
		offsetHeight = document.getElementById('menu').offsetHeight;
	}
	if(document.getElementById('topBarOverview'))
	{
		offsetHeight2 = document.getElementById('topBarOverview').offsetHeight;
		offsetHeight2 = offsetHeight2;
	}
	var heightOfMain = window.innerHeight - offsetHeight;
	var heightOfMainStyle = 'height:';
	heightOfMainStyle += heightOfMain;
	heightOfMainStyle += 'px';
	document.getElementById("main").setAttribute("style",heightOfMainStyle);
	heightOfMain = window.innerHeight - offsetHeight - offsetHeight2;
	heightOfMainStyle = 'height:';
	heightOfMainStyle += heightOfMain;
	heightOfMainStyle += 'px';
	document.getElementById("processIds").setAttribute("style",heightOfMainStyle);

	</script>
</body>
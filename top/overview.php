
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
		<div class="canvasMonitorDiv" >	
			<div class="canvasMonitorText">CPU</div>
			<img id="canvasMonitorLoading_CPU" style="margin-top: 75px; margin-left: 75px; position: absolute;" src='../core/img/loading.gif' height='50' width='50'> 
			<canvas class="canvasMonitor" id="cpuCanvas" width="200" height="200"></canvas>
			<div class="canvasMonitorText">U <span id="canvasMonitorCPU_User">-</span>% | S <span id="canvasMonitorCPU_System">-</span>% | N <span id="canvasMonitorCPU_Other">-</span>%</div>
		</div>
	</div>
	<?php readfile('../core/html/popup.html') ?>	
	<script type="text/javascript">

	var nullReturnForDefaultPoll = false;
	var cpuInfoArray_Default = [0,0,0,0,0,0,0,0,0,0];
	var cpuInfoArray_User = [0,0,0,0,0,0,0,0,0,0];
	var cpuInfoArray_System = [0,0,0,0,0,0,0,0,0,0];
	var cpuInfoArray_other = [0,0,0,0,0,0,0,0,0,0];
	var cpuInfoArray_heightVar = [0,0,0,0,0,0,0,0,0,0];

	var width = 200;
	var height = 200;

	var cpuArea = document.getElementById('cpuCanvas');
	var cpuAreaContext = cpuArea.getContext("2d");


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
		filterDataForCPU(data)
	}

	function filterDataForCPU(dataInner)
	{
		console.log(dataInner);
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
		if(cpuInfoArray_User.length > 10)
		{
			cpuInfoArray_User.shift();
			cpuInfoArray_System.shift();
			cpuInfoArray_other.shift();
		}

		cpuAreaContext.clearRect(0, 0, cpuArea.width, cpuArea.height);
		cpuInfoArray_heightVar = [0,0,0,0,0,0,0,0,0,0];
		fillAreaInChart(cpuInfoArray_User, cpuInfoArray_heightVar, "blue");
		fillAreaInChart(cpuInfoArray_System, cpuInfoArray_heightVar, "red");
		fillAreaInChart(cpuInfoArray_other, cpuInfoArray_heightVar, "yellow");
	}

	function fillAreaInChart(arrayForFill, bottomArray, color)
	{
		cpuAreaContext.fillStyle = color;
		var totalWidthOfEachElement = width/bottomArray.length;
		for (var i = arrayForFill.length - 1; i >= 0; i--) 
		{
			var heightOfElement = height*(arrayForFill[i]/100);
			cpuAreaContext.fillRect((totalWidthOfEachElement*(i)),(height-heightOfElement-bottomArray[i]),totalWidthOfEachElement,heightOfElement);
			cpuInfoArray_heightVar[i] = heightOfElement;
		}
	}

	topFunction();
	setInterval(topFunction, 10000);
	
	</script>
	<script src="../core/js/settings.js"></script>
</body>
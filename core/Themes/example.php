<?php
	$theme = $_GET["type"];
	$cssVersion = rand(0 , 9000000);
?>
<!DOCTYPE html>
<html>
<head> 
	<link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/template/theme.css?v=<?php echo $cssVersion;?>">
	<link rel="stylesheet" type="text/css" href="../template/base.css?v=<?php echo $cssVersion;?>">
</head>
<body>
	<div id="menu" style="position: relative; ">
		<div id="menuButtons">
			<div class="menuImageDiv">
				<img id="pauseImage" class="menuImage" src="<?php echo $theme; ?>/img/Pause.png" height="30px">
			</div>
			<div class="menuImageDiv">
				<img id="refreshImage" class="menuImage" src="<?php echo $theme; ?>/img/Refresh.png" height="30px">
			</div>
			<div class="menuImageDiv">
				<img id="deleteImage" class="menuImage" src="<?php echo $theme; ?>/img/eraserMulti.png" height="30px">
			</div>
			<div class="menuImageDiv">
				<img data-id="1" id="gear" class="menuImage" src="<?php echo $theme; ?>/img/Gear.png" height="30px">
			</div>
			<div class="menuImageDiv">
					<img id="notificationClear" class="menuImage" src="<?php echo $theme; ?>/img/notificationClear.png" height="30px">
			</div>
			<div style="float: right;">
				<input type="search" placeholder="Filter Title" style="height: 30px; width: 200px;">
			</div>
		</div>
		<a class="varwwwhtmlvarlogauthnetcimlogButton active" >server_hhvm.log</a>

		<a class="varwwwhtmlvarlogauthnetcimachlogButton" >server_system.log</a>

		<a class="varlogapache2errorlogButton" >error.log</a>

		<a class="varlogalternativeslogButton updated">alternatives.log</a>
	</div>

		<!-- LOG -->
	<div id="main" style="height: 278px; position: inherit;">
		<table style="margin: 0px;padding: 0px; border-spacing: 0px; width:100%; height: 278px; " >
				<tr>
					<td style="padding: 0; width: 30px;" >
						<div class="backgroundForSideBarMenu" style="width: 30px; float: left; display: inline; padding: 0px; height: 100%;">
							<a style="cursor: pointer;" >
								<img src="<?php echo $theme; ?>/img/infoSideBar.png" style="padding: 5px;" width="20px;">
							</a>
							<a style="cursor: pointer;">
								<img src="<?php echo $theme; ?>/img/eraserSideBar.png" style="padding: 5px;" width="20px;">
							</a>
							<a style="cursor: pointer;">
								<img src="<?php echo $theme; ?>/img/trashCanSideBar.png" style="padding: 5px;" width="20px;">
							</a>
							<a style="cursor: pointer;">
								<img src="<?php echo $theme; ?>/img/downArrowSideBar.png" style="padding: 5px;" width="20px;">
							</a>
						</div>
					</td>
					<td style="padding: 0;" >
						<div id="log" style="height: 278px; overflow: auto;" >
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000028] [] BootStats: servers started done, took 2ms wall, 4ms cpu, 1 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000029] [] all servers started</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000030] [] BootStats: all done, took 188ms wall, 188ms cpu, 137 MB RSS total</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000031] [] BootStats: ExecutionContext = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000032] [] BootStats: ExtensionRegistry::moduleInit = 118ms wall, 120ms cpu, 7 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000033] [] BootStats: PageletServer::Restart = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000034] [] BootStats: Process::InitProcessStatics = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000035] [] BootStats: Stream::RegisterCoreWrappers = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000036] [] BootStats: TOTAL = 188ms wall, 188ms cpu, 137 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000037] [] BootStats: XboxServer::Restart = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000038] [] BootStats: apc_load = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000039] [] BootStats: enable_numa = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000040] [] BootStats: extra_process_init = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000041] [] BootStats: extra_process_init_concurrent_wait = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000042] [] BootStats: g_vmProcessInit = 36ms wall, 36ms cpu, 5 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000043] [] BootStats: loading static content = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000044] [] BootStats: mapping self = 23ms wall, 24ms cpu, 121 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000045] [] BootStats: onig_init = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000046] [] BootStats: pagein_self = 23ms wall, 24ms cpu, 121 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000047] [] BootStats: pcre_reinit = 2ms wall, 4ms cpu, -1 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000048] [] BootStats: pthread_init = 4ms wall, 0ms cpu, 3 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000049] [] BootStats: rds::requestExit = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000050] [] BootStats: servers started = 2ms wall, 4ms cpu, 1 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000051] [] BootStats: timezone_init = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000052] [] BootStats: warmup = 0ms wall, 0ms cpu, 0 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000053] [] BootStats: xenon = 0ms wall, 0ms cpu, 1 MB RSS</div>
							<div>[Mon Sep  4 16:05:04 2017] [hphp] [1035:7f37b432b180:0:000054] [] BootStats: xmlInitParser = 0ms wall, 0ms cpu, 0 MB RSS</div>
						</div>
					</td>
				</tr>
			</table>
	</div>
</body>
</html>
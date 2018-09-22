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
	<div id="menu" style="position: relative; overflow: hidden; ">
		<span id="stars" style="display: block;" ></span>
		<span id="stars2" style="display: block;" ></span>
		<span id="stars3" style="display: block;" ></span>
		<div id="menuButtons">
			<div class="menuImageDiv">
				<img class="menuImage" src="<?php echo $theme; ?>/img/menu.png" height="30px">
			</div>
			<div class="menuImageDiv">
				<img class="menuImage" src="<?php echo $theme; ?>/img/notification.png" height="30px">
			</div>
			<div class="menuImageDiv">
				<img class="menuImage" src="<?php echo $theme; ?>/img/Pause.png" height="30px">
			</div>
			<div class="menuImageDiv">
				<img class="menuImage" src="<?php echo $theme; ?>/img/Refresh.png" height="30px">
			</div>
			<div style="float: right;">
				<input type="search" placeholder="Filter Title" style="height: 30px; width: 200px;">
			</div>
		</div>
		<a class="varwwwhtmlvarlogauthnetcimlogButton active" >server_hhvm.log</a>
		<a class="varlogapache2errorlogButton" >error.log</a>
		<a class="varlogalternativeslogButton updated">alternatives.log</a>
	</div>
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
						<table width="100%" >
							<?php
								$log = file_get_contents("example.html");
								$log = explode("\n", $log);
								foreach ($log as $line)
								{
									echo "<tr valign=\"top\" ><td >".implode("</td><td>", explode("[hphp]", $line))."</td></tr>";
								}
							?>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
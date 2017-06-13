<style type="text/css">
	#menu a, .link, .linkSmall{
		background-color: <?php echo $currentSelectedThemeColorValues[0]?>;
	}
</style>
<?php
$URI = $_SERVER['REQUEST_URI'];
?>
<div id="menu">
	<div onclick="window.location.href = '../index.php';" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
		<img id="pauseImage" class="menuImage" src="../core/img/backArrow.png" height="30px">
	</div>
	<?php if(strpos($URI, 'overview.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Overview</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'overview.php';" >Overview</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'cpu.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >CPU</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'cpu.php';" >CPU</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'ram.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Memory</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'ram.php';" >Memory</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'disk.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Disk</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'disk.php';" >Disk</a>
	<?php endif; ?>
	<a id="settingsLink" onclick="window.location.href = '../settings/main.php';" >Settings</a>
</div>
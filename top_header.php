<?php if($monitorStatus['withLogHog'] == 'true'): ?>
<style type="text/css">
	#menu a, .link, .linkSmall{
		background-color: <?php echo $currentSelectedThemeColorValues[0]?>;
	}
</style>
<?php
endif; 
$URI = $_SERVER['REQUEST_URI'];
?>
<?php if($monitorStatus['withLogHog'] == 'true'): ?>
<div id="menu">
	<div onclick="window.location.href = '../index.php';" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
		<img id="pauseImage" class="menuImage" src="../core/img/backArrow.png" height="30px">
	</div>
	<?php if(strpos($URI, 'overview.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Overview</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'overview.php';" >Overview</a>
	<?php endif; ?>
	<!-- 
	<?php if(strpos($URI, 'cpu.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >CPU</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'cpu.php';" >CPU</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'disk.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Disk</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'disk.php';" >Disk</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'ram.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Memory</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'ram.php';" >Memory</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'network.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Network</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'network.php';" >Network</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'php.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >PHP</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'php.php';" >PHP</a>
	<?php endif; ?>
	<a id="settingsLink" onclick="window.location.href = '../settings/main.php';" >Settings</a>
	-->
</div>
<?php else: ?>
<div id="menu">
	<?php $notThisPage = true; ?>
	<!-- 
	<?php if(strpos($URI, 'cpu.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >CPU</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'cpu.php';" >CPU</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'disk.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Disk</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'disk.php';" >Disk</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'ram.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Memory</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'ram.php';" >Memory</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'network.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Network</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'network.php';" >Network</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'php.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >PHP</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'php.php';" >PHP</a>
	<?php endif; ?>
	-->
	<?php if(strpos($URI, 'settings.php') !== false): $notThisPage = false; ?>
		<a id="settingsLink" class="active" id="mainLink">Settings</a>
	<?php else: ?>
		<a id="settingsLink" onclick="window.location.href = 'settings/settingsTop.php';" >Settings</a>
	<?php endif; ?>
	<?php if($notThisPage): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Overview</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'overview.php';" >Overview</a>
	<?php endif; ?>
	<?php if(file_exists('../status/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../status/';" >gitStatus</a>
	<?php endif;?>
	<?php if(file_exists('../Log-Hog/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../Log-Hog/';" >Log-Hog</a>
	<?php endif;?>
	<?php if(file_exists('../loghog/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../loghog/';" >Loghog</a>
	<?php endif;?>
</div>
<?php endif; ?>
<?php
$URI = $_SERVER['REQUEST_URI'];
?>
<div id="menu">
	<?php $notThisPage = true;
	if((strpos($URI, 'settings.php') !== false) || (strpos($URI, 'php.php') !== false) || (strpos($URI, 'network.php') !== false) || (strpos($URI, 'ram.php') !== false) || (strpos($URI, 'disk.php') !== false) || (strpos($URI, 'cpu.php') !== false))
	{
		$notThisPage = false;
	}
	?>
	<?php if(strpos($URI, 'settings.php') !== false): ?>
		<a id="settingsLink" class="active" id="mainLink">Settings</a>
	<?php else: ?>
		<a id="settingsLink" onclick="window.location.href = 'settings/settingsTop.php';" >Settings</a>
	<?php endif; ?>
	<?php if($notThisPage): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Overview</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'index.php';" >Overview</a>
	<?php endif; ?> 
	<?php if(strpos($URI, 'cpu.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >CPU</a>
	<?php else: ?>
		<a id="mainLink" onclick="window.location.href =  'cpu.php';" >CPU</a>
	<?php endif; ?>
	<!--
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
		<a class="noHover" style="cursor: default;" >|</a>
	<!-- Status -->
	<?php if(file_exists('../status/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../status/';" >gitStatus</a>
	<?php elseif(file_exists('../../status/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../../status/';" >gitStatus</a>
	<?php endif;?>
	<!-- Search -->
	<?php if(file_exists('../search/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../search/';" >Search</a>
	<?php elseif(file_exists('../../search/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../../search/';" >Search</a>
	<?php endif;?>
	<!-- Log-Hog -->
	<?php if(file_exists('../Log-Hog/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../Log-Hog/';" >Log-Hog</a>
	<?php elseif(file_exists('../../Log-Hog/index.php')):?>
		<a id="mainLink"  onclick="window.location.href =  '../../Log-Hog/';" >Log-Hog</a>
	<?php endif;?>
	<?php if(file_exists('../loghog/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../loghog/';" >Loghog</a>
	<?php elseif(file_exists('../../loghog/index.php')): ?>
		<a id="mainLink"  onclick="window.location.href =  '../../loghog/';" >Loghog</a>
	<?php endif;?>
</div>
<style type="text/css">
	#menu a, #menu2 a, .link, .linkSmall, .settingsHeader button{
		background-color: <?php echo $currentSelectedThemeColorValues[0]?>;
	}
</style>
<?php
require_once('../top/statusTest.php');
$withLogHog = $monitorStatus['withLogHog'];
$URI = $_SERVER['REQUEST_URI'];
?>
<div id="menu">
	<div onclick="goToUrl('../index.php');" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
		<img id="pauseImage" class="menuImage" src="../core/img/backArrow.png" height="30px">
	</div>
	<?php if(strpos($URI, 'main.php') !== false): ?>
		<a style="cursor: default;" class="active" id="mainLink" >Main</a>
	<?php else: ?>
		<a id="mainLink" onclick="goToUrl('main.php');" >Main</a>
	<?php endif; ?>
	<?php if ($withLogHog == "true"):?>
		<?php if(strpos($URI, 'settingsTop.php') !== false): ?>
			<a style="cursor: default;" class="active" id="topLink" >Top</a>
		<?php else: ?>
			<a id="topLink" onclick="goToUrl('settingsTop.php');" >Top</a>
		<?php endif; ?>
	<?php endif; ?>
	<?php if(strpos($URI, 'about.php') !== false): ?>
		<a style="cursor: default;" class="active" id="aboutLink" >About</a>
	<?php else: ?>	
		<a id="aboutLink" onclick="goToUrl('about.php');">About</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'update.php') !== false): ?>
		<a style="cursor: default;" class="active" id="updateLink">
	<?php else: ?>
		<a id="updateLink" onclick="goToUrl('update.php');">
	<?php endif; ?>	
			<?php  if($levelOfUpdate == 1){echo '<img src="../core/img/yellowWarning.png" height="10px">';} ?> <?php if($levelOfUpdate == 2){echo '<img src="../core/img/redWarning.png" height="10px">';} ?>Update
		</a>
	<?php if(strpos($URI, 'advanced.php') !== false): ?>
		<a style="cursor: default;" class="active" id="advancedLink">Advanced</a>
	<?php else: ?>	
		<a id="advancedLink" onclick="goToUrl('advanced.php');">Advanced</a>
	<?php endif; ?>
	<?php
	if($developmentTabEnabled == 'true'):?>
		<?php if(strpos($URI, 'devTools.php') !== false): ?>
			<a style="cursor: default;" class="active" id="devToolsLink"> Dev Tools </a>
		<?php else: ?>
			<a id="devToolsLink" onclick="goToUrl('devTools.php');"> Dev Tools </a>
		<?php endif; ?>	
	<?php endif; ?>
	<?php
	if($expSettingsAvail):?>
		<?php if(strpos($URI, 'experimentalfeatures.php') !== false): ?>
			<a style="cursor: default;" class="active" id="experimentalfeaturesLink"> Experimental Features </a>
		<?php else: ?>
			<a id="experimentalfeaturesLink" onclick="goToUrl('experimentalfeatures.php');"> Experimental Features </a>
		<?php endif; ?>	
	<?php endif; ?>
</div>
<?php if(strpos($URI, 'main.php') !== false): ?>
		<div id="menu2">
			<a onclick="goToUrl('#settingsMainVars');" > Main Settings </a>
			<a onclick="goToUrl('#settingsMainWatch');" > WatchList </a>
			<a onclick="goToUrl('#settingsMenuVars');" > Menu Settings </a>
		</div>
	<?php endif; ?>
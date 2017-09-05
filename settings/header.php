<?php
require_once('../top/statusTest.php');
require_once('../setup/setupProcessFile.php');
$withLogHog = $monitorStatus['withLogHog'];
$URI = $_SERVER['REQUEST_URI'];
require_once("../core/php/customCSS.php");
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
	<a id="themesLink" style="
		<?php if($themesEnabled === "false"): ?>
		display: none;
		<?php endif; ?>
		<?php if(strpos($URI, 'themes.php') !== false): ?>
			cursor: default;" class="active" 
		<?php else: ?>
			" onclick="goToUrl('themes.php');" 
		<?php endif; ?>
	>Themes</a>
	<?php if(strpos($URI, 'about.php') !== false): ?>
		<a style="cursor: default;" class="active" id="aboutLink" >About</a>
	<?php else: ?>	
		<a id="aboutLink" onclick="goToUrl('about.php');">About</a>
	<?php endif; ?>
	<?php if((strpos($URI, 'whatsNew.php') !== false) || (strpos($URI, 'update.php') !== false) || (strpos($URI, 'changeLog.php') !== false)): ?>
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
	<a id="devToolsLink"
		<?php if(!(($developmentTabEnabled == 'true') || (strpos($URI, 'devTools.php') !== false))):?>
			style="display: none;
		<?php endif; ?>	
		<?php if(strpos($URI, 'devTools.php') !== false): ?>
			cursor: default;" class="active"
		<?php else: ?>
			" onclick="goToUrl('devTools.php');"
		<?php endif; ?>
	> Dev Tools </a>
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
		<a id="mainSettingsMenu2" onclick="goToUrl('#settingsMainVars');" class="active" > Main Settings </a>
		<a id="watchListSettingsMenu2" onclick="goToUrl('#settingsMainWatch');" > WatchList </a>
		<a id="menuSettingsMenu2" onclick="goToUrl('#settingsMenuVars');" > Menu Settings </a>
	</div>
<?php endif; ?>
<?php if((strpos($URI, 'whatsNew.php') !== false) || (strpos($URI, 'update.php') !== false) || (strpos($URI, 'changeLog.php') !== false)): ?>
	<div id="menu2">
		<a <?php if(strpos($URI, 'update.php') !== false): ?> class='active' <?php else: ?>  onclick="goToUrl('./update.php');"  <?php endif;?> > Update </a>
		<a <?php if(strpos($URI, 'whatsNew.php') !== false): ?> class='active' <?php else: ?>  onclick="goToUrl('./whatsNew.php');"  <?php endif;?> > What's New? </a>
		<a <?php if(strpos($URI, 'changeLog.php') !== false): ?> class='active' <?php else: ?>  onclick="goToUrl('./changeLog.php');"  <?php endif;?> > Changelog </a>
	</div>
<?php endif; ?>
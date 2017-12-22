<?php
require_once('../setup/setupProcessFile.php');
require_once("../core/php/customCSS.php");
echo loadSentryData($sendCrashInfoJS, $branchSelected); ?>
<script src="../core/js/settings.js?v=<?php echo $cssVersion?>"></script>
<div id="menu">
	<div onclick="goToUrl('../index.php');" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
		<img id="pauseImage" class="menuImage" src="<?php echo $localURL;?>img/backArrow.png" height="30px">
	</div>
	<?php if(strpos($URI, 'main.php') !== false): ?>
		<a style="cursor: default;" class="active" id="MainLink" >Main</a>
	<?php else: ?>
		<a id="MainLink" onclick="goToUrl('main.php');" >Main</a>
	<?php endif; ?>
	<a id="ThemesLink" style="
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
			<?php if($updateNotificationEnabled === "true")
			{
				if($levelOfUpdate == 1)
				{
					echo '<img id="updateNoticeImage" src="'.$localURL.'img/yellowWarning.png" height="10px">';
				}
				elseif($levelOfUpdate !== 0)
				{
					echo '<img id="updateNoticeImage" src="'.$localURL.'img/redWarning.png" height="10px">';
				}
			}?>
			Update
		</a>
	<?php if(strpos($URI, 'advanced.php') !== false): ?>
		<a style="cursor: default;" class="active" id="AdvancedLink">Advanced</a>
	<?php else: ?>	
		<a id="AdvancedLink" onclick="goToUrl('advanced.php');">Advanced</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'addons.php') !== false): ?>
		<a style="cursor: default;" class="active" id="addonsLink" >Addons</a>
	<?php else: ?>	
		<a id="addonsLink" onclick="goToUrl('addons.php');">Addons</a>
	<?php endif; ?>
	<a id="DevLink"
		<?php if(!(($developmentTabEnabled == 'true') || (strpos($URI, 'devTools.php') !== false))):?>
			style="display: none;
		<?php endif; ?>	
		<?php if(strpos($URI, 'devTools.php') !== false): ?>
			cursor: default;" class="active"
		<?php else: ?>
			" onclick="goToUrl('devTools.php');"
		<?php endif; ?>
	> Dev</a>
	<?php
	if($expSettingsAvail):?>
		<?php if(strpos($URI, 'experimentalfeatures.php') !== false): ?>
			<a style="cursor: default;" class="active" id="Experimental-FeaturesLink"> Experimental-Features </a>
		<?php else: ?>
			<a id="Experimental-FeaturesLink" onclick="goToUrl('experimentalfeatures.php');"> Experimental-Features </a>
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
<?php endif;
$baseUrlImages = $localURL;
?>
<script type="text/javascript">
	var baseUrl = "<?php echo $baseUrlImages;?>";
	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
	var currentVersion = "<?php echo $configStatic['version']; ?>";
	var newestVersion = "<?php echo $configStatic['newestVersion']; ?>";
</script>
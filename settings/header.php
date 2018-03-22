<?php
setCookieRedirect();
require_once('../setup/setupProcessFile.php');
require_once("../core/php/customCSS.php");
echo loadSentryData($sendCrashInfoJS, $branchSelected); ?>
<script src="../core/js/settings.js?v=<?php echo $cssVersion?>"></script>
<div id="menu">
	<div onclick="goToUrl('../index.php');" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
		<?php echo generateImage(
			$arrayOfImages["backArrow"],
			array(
				"height"		=>	"30px",
				"srcModifier"	=>	"../",
				"class"			=>	"menuImage",
				"id"			=>	"back"
			)
		); ?>
	</div>
	<?php if(strpos($URI, 'main.php') !== false): ?>
		<a style="cursor: default;" class="active" id="MainLink" >Main</a>
	<?php else: ?>
		<a id="MainLink" onclick="goToUrl('main.php');" >Main</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'watchlist.php') !== false): ?>
		<a style="cursor: default;" class="active" id="Watchlist" >Watchlist</a>
	<?php else: ?>
		<a id="Watchlist" onclick="goToUrl('watchlist.php');" >Watchlist</a>
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
	<?php if(strpos($URI, 'update.php') !== false): ?>
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
</div>
<?php if(strpos($URI, 'main.php') !== false): ?>
	<div id="menu2">
		<a href="#settingsLogVars" > Logs </a>
		<a href="#settingsPollVars" > Poll </a>
		<a href="#settingsFilterVars" > Filter </a>
		<a href="#settingsUpdateVars" > Update </a>
		<a href="#settingsMenuVars" > Menu </a>
		<a href="#settingsMainVars" > Other </a>
	</div>
<?php elseif(strpos($URI, 'themes.php') !== false): ?>
	<div id="menu2">
		<a href="#themeMain" > Themes </a>
		<a href="#settingsColorFolderVars" > Theme Options </a>
		<a href="#settingsColorFolderGroupVars" > Tab Style </a>
	</div>
<?php elseif(strpos($URI, 'advanced.php') !== false): ?>
	<div id="menu2">
		<a href="#advancedConfig" > Advanced </a>
		<a href="#devAdvanced" > Dev </a>
		<a href="#pollAdvanced" > Poll</a>
		<a href="#loggingDisplay" > Logs </a>
		<a href="#jsPhpSend" > Reporting </a>
		<a href="#locationOtherApps" > Apps </a>
		<a href="#moreAdvanced" > Actions </a>
		<a href="#expFeatures" > Experimental </a>
	</div>
<?php endif;
$baseUrlImages = $localURL;
?>
<script type="text/javascript">
	var baseUrl = "<?php echo baseURL();?>";
	var popupSettingsArray = <?php echo $popupSettingsArray ?>;
	var currentVersion = "<?php echo $configStatic['version']; ?>";
	var newestVersion = "<?php echo $configStatic['newestVersion']; ?>";
	var saveVerifyImage = <?php echo json_encode(generateImage(
			$arrayOfImages["greenCheck"],
			array(
				"height"		=>	"50px",
				"srcModifier"	=>	"../"
			)
		)); ?>
</script>
<?php require_once("../core/php/template/popup.php");
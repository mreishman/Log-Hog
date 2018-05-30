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
		<span style="color: black;">Settings:</span> 
		<a class="link" href="#settingsLogVars" > Logs </a>
		<a class="link" href="#settingsPollVars" > Poll </a>
		<a class="link" href="#settingsFilterVars" > Filter </a>
		<a class="link" href="#settingsUpdateVars" > Update </a>
		<a class="link" href="#settingsMenuVars" > Menu </a>
		<a class="link" href="#settingsWatchlistVars" > Watchlist </a>
		<a class="link" href="#settingsMainVars" > Other </a>
	</div>
<?php elseif(strpos($URI, 'themes.php') !== false): ?>
	<div id="menu2">
		<a class="link" href="#themeMain" > Themes </a>
		<a class="link" href="#settingsColorFolderVars" > Theme Options </a>
		<a class="link" href="#settingsColorFolderGroupVars" > Tab Style </a>
	</div>
<?php elseif(strpos($URI, 'advanced.php') !== false): ?>
	<div id="menu2">
		<a class="link" href="#advancedConfig" > Advanced </a>
		<a class="link" href="#devAdvanced" > Dev </a>
		<a class="link" href="#pollAdvanced" > Poll</a>
		<a class="link" href="#loggingDisplay" > Logs </a>
		<a class="link" href="#jsPhpSend" > Reporting </a>
		<a class="link" href="#locationOtherApps" > Apps </a>
		<a class="link" href="#moreAdvanced" > Actions </a>
		<a class="link" href="#expFeatures" > Experimental </a>
	</div>
<?php elseif(strpos($URI, 'watchlist.php') !== false): ?>
	<div id="menu2">
		<a class="link" href="#settingsMainWatch" > Watchlist </a>
		<a class="link" href="#archive" > Archive </a>
		<a class="link" href="#watchKey" > Key</a>
		<a class="link" onclick="addFile();">+ Add New File</a>
		<a class="link" onclick="addFolder();">+ Add New Folder</a>
		<a class="link" onclick="addOther();">+ Add Other</a>
	</div>
<?php endif;
$baseUrlImages = $localURL;
?>
<div class="settingsHeader" style="position: absolute;width: 100%;z-index: 10;top: 104px; margin: 0; border-bottom: 1px solid white; display: none;" id="fixedPositionMiniMenu" >
</div>
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
<?php
$core->setCookieRedirect();
require_once('../setup/setupProcessFile.php');
require_once("../core/php/customCSS.php");
require_once("../core/php/defaultConfData.php");
$infoImage = $core->generateImage(
	$arrayOfImages["info"],
	array(
		"style"			=>	"margin-bottom: -4px;",
		"height"		=>	"20px",
		"srcModifier"	=>	"../"
	)
);
echo $core->loadSentryData($sendCrashInfoJS, $branchSelected, $configStatic);
$core->getScripts(
	array(
		array(
			"filePath"		=> "../core/js/jscolor.js",
			"baseFilePath"	=> "core/js/jscolor.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "../core/js/settings.js",
			"baseFilePath"	=> "core/js/settings.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "../core/js/settingsExt.js",
			"baseFilePath"	=> "core/js/settingsExt.js",
			"default"		=> $configStatic["version"]
		)
	)
);
?>
<div id="menu">
	<div onclick="goToUrl('../index.php');" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
		<?php echo $core->generateImage(
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
	<?php if(strpos($URI, 'advanced.php') !== false): ?>
		<a style="cursor: default;" class="active" id="AdvancedLink">Advanced</a>
	<?php else: ?>
		<a id="AdvancedLink" onclick="goToUrl('advanced.php');">Advanced</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'devTools.php') !== false): ?>
		<a style="cursor: default;" class="DevLink active"> Global</a>
	<?php else: ?>
		<a class="DevLink" onclick="goToUrl('devTools.php');"> Global</a>
	<?php endif; ?>
</div>
<?php if(strpos($URI, 'main.php') !== false): ?>
	<div id="menu2">
		<span>Settings:</span>
		<a class="link" href="#settingsLogVars" > Logs </a>
		<?php if($advancedLogFormatEnabled === "true"): ?>
			<a class="link" href="#settingsLogFormatVars" > Log Format </a>
		<?php endif; ?>
		<a class="link" href="#settingsPollVars" > Poll </a>
		<?php if($filterEnabled === "true"): ?>
			<a class="link" href="#settingsFilterVars" > Filter </a>
		<?php endif; ?>
		<a class="link" href="#archiveConfig" > Archive </a>
		<a class="link" href="#settingsNotificationVars" > Notifications </a>
		<a class="link" href="#settingsMenuVars" > Menu Actions </a>
		<a class="link" href="#settingsMenuLogVars" > Menu Logs </a>
		<a class="link" href="#settingsFullScreenMenuVars" > Full Screen Menu </a>
		<a class="link" href="#settingsWatchlistVars" > Watchlist </a>
		<?php if($oneLogEnable === "true"): ?>
			<a class="link" href="#settingsOneLogVars" > OneLog </a>
		<?php endif; ?>
		<?php if($enableMultiLog === "true"): ?>
			<a class="link" href="#settingsMultiLogVars" > Multi-Log </a>
			<a class="link" href="#settingsInitialLoadLayoutVars"> Log Layout</a>
		<?php endif; ?>
		<a class="link" href="#settingsMainVars" > Other </a>
	</div>
<?php elseif(strpos($URI, 'advanced.php') !== false): ?>
	<div id="menu2">
		<a class="link" href="#advancedConfig" > Config </a>
		<a class="link" href="#modules" > Modules </a>
		<a class="link" href="#loggingDisplay" > Logs </a>
		<a class="link" href="#locationOtherApps" > Locations </a>
		<a class="link" href="#moreAdvanced" > Advanced </a>
		<a class="link" href="#expFeatures" > Experimental </a>
	</div>
<?php endif;
$baseUrlImages = $localURL;
?>
<div class="settingsHeader addBorderBottom" style="position: absolute;width: 100%;z-index: 10;top: 104px; margin: 0; display: none;" id="fixedPositionMiniMenu" ></div>
<script type="text/javascript">
	var baseUrl = "<?php echo $core->baseURL();?>";
	var popupSettingsArray = <?php echo $popupSettingsArray ?>;
	var currentVersion = "<?php echo $configStatic['version']; ?>";
	var newestVersion = "<?php echo $configStatic['newestVersion']; ?>";
	var saveVerifyImage = <?php echo json_encode($core->generateImage(
			$arrayOfImages["greenCheck"],
			array(
				"height"		=>	"50px",
				"srcModifier"	=>	"../"
			)
		)); ?>
</script>
<?php require_once("../core/php/template/popup.php");
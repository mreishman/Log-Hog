<?php
setCookieRedirect();
require_once('../setup/setupProcessFile.php');
require_once("../core/php/customCSS.php");
require_once("../core/php/defaultConfData.php");
$infoImage = generateImage(
	$arrayOfImages["info"],
	array(
		"style"			=>	"margin-bottom: -4px;",
		"height"		=>	"20px",
		"srcModifier"	=>	"../"
	)
);
echo loadSentryData($sendCrashInfoJS, $branchSelected); ?>
<script src="../core/js/settings.js?v=<?php echo $cssVersion?>"></script>
<script src="../core/js/settingsExt.js?v=<?php echo $cssVersion?>"></script>
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
	<a class="link" href="#themeMain" > Themes </a>
	<a class="link" href="#settingsColorFolderVars" > Theme Options </a>
	<a class="link" href="#settingsColorFolderGroupVars" > Tab Style </a>
</div>
<?php $baseUrlImages = $localURL; ?>
<div class="settingsHeader" style="position: absolute;width: 100%;z-index: 10;top: 104px; margin: 0; border-bottom: 1px solid white; display: none;" id="fixedPositionMiniMenu" ></div>
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
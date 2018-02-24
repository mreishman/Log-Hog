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
	<?php if(strpos($URI, 'about.php') !== false): ?>
		<a style="cursor: default;" class="active" id="aboutLink" >About</a>
	<?php else: ?>	
		<a id="aboutLink" onclick="goToUrl('about.php');">About</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'whatsNew.php') !== false): ?>
		<a style="cursor: default;" class="active" id="whatsNewLink">What's New</a>
	<?php else: ?>
		<a id="whatsNewLink" onclick="goToUrl('whatsNew.php');">What's New</a>
	<?php endif; ?>
	<?php if(strpos($URI, 'changeLog.php') !== false): ?>
		<a style="cursor: default;" class="active" id="changeLogLink">ChangeLog</a>
	<?php else: ?>
		<a id="changeLogLink" onclick="goToUrl('changeLog.php');">ChangeLog</a>
	<?php endif; ?>
</div>

<?php
$baseUrlImages = $localURL;
?>
<script type="text/javascript">
	var baseUrl = "<?php echo baseURL();?>";
	var popupSettingsArray = JSON.parse('<?php echo json_encode($popupSettingsArray) ?>');
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
<?php require_once("../core/php/template/popup.php"); ?>
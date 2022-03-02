<?php
require_once('../setup/setupProcessFile.php');
require_once("../core/php/customCSS.php");
$core->getScript(array(
	"filePath"		=> "../core/js/settingsExt.js",
	"baseFilePath"	=> "core/js/settingsExt.js",
	"default"		=> $configStatic["version"]
)); ?>
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
		<a id="aboutLink" onclick="showAboutTab('about');">About</a>
		<a id="whatsNewLink" onclick="showAboutTab('whatsNew');">What's New</a>
		<a id="changeLogLink" onclick="showAboutTab('changelog');">ChangeLog</a>
</div>

<?php
$baseUrlImages = $localURL;
?>
<script type="text/javascript">
	var baseUrl = "<?php echo $core->baseURL();?>";
	var popupSettingsArray = {};
	var currentVersion = "<?php echo $configStatic['version']; ?>";
	var newestVersion = "<?php echo $configStatic['newestVersion']; ?>";
	var saveVerifyImage = <?php echo json_encode($core->generateImage(
			$arrayOfImages["greenCheck"],
			array(
				"height"		=>	"50px",
				"srcModifier"	=>	"../"
			)
		)); ?>;
</script>
<?php require_once("../core/php/template/popup.php");
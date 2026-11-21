<?php
$baseDir = $core->baseURL();
require_once($baseDir.'setup/setupProcessFile.php');
require_once($baseDir."core/php/customCSS.php");
$settingsUrlModifier = "";
require_once($baseDir."core/php/defaultConfData.php");
$infoImage = $core->generateImage(
	$arrayOfImages["info"],
	array(
		"style"			=>	"margin-bottom: -4px;",
		"height"		=>	"20px",
		"srcModifier"	=>	""
	)
);
$core->getScripts(
	array(
		array(
			"filePath"		=> "core/js/jscolor.js",
			"baseFilePath"	=> "core/js/jscolor.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "core/js/settings.js",
			"baseFilePath"	=> "core/js/settings.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "core/js/settingsExt.js",
			"baseFilePath"	=> "core/js/settingsExt.js",
			"default"		=> $configStatic["version"]
		),
		array(
			"filePath"		=> "core/js/errorHandle.js",
			"baseFilePath"	=> "core/js/errorHandle.js",
			"default"		=> $configStatic["version"]
		)
	)
);
?>
<div id="menu">
	<div onclick="goToUrl('index.php');" style="display: inline-block; cursor: pointer; height: 30px; width: 30px; ">
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
	<?php
	foreach($fullScreenMenuGroups as $fsmgKey => $fsmgData)
	{
		$extraClass = "";
		$style = "";
		if (!$fsmgData["display"]) {
			$extraClass = "hiddenMenu";
			$style = "style=\"display:none;\"";
		}
		echo "<a class=\"mainMenuHeader ".$extraClass." ".$fsmgKey."\" ".$style." onclick=\"openTab('".$fsmgKey."')\">" . $fsmgData["name"] . "</a>" . PHP_EOL;
	}
	?>
</div>
<div id="menu2">
	<?php
	$idArray = []; 
	foreach($fullScreenMenuGroups as $fsmgKey => $fsmgData)
	{
		foreach($fsmgData["menu_items"] as $defaultConfigMoreDataRowData)
		{

			$style = "";
			$extraClass = "";
			$id = "id=\"". $defaultConfigMoreDataRowData["menu"]["id"]. "Menu\"";

			if(!$defaultConfigMoreDataRowData["menu"]["display"])
			{
				$style = "style=\"display:none;\"";
				$extraClass = "hiddenMenu";
			}

			$idArray[] = $defaultConfigMoreDataRowData["id"];
			$stringToEcho	 = "<a ".$style." ".$id." class=\"link settingsSecondaryHeaders ".$extraClass." ".$fsmgKey."\" ";
			if(!$defaultConfigMoreDataRowData["menu"]["display"])
			{
				$stringToEcho .= "style=\"display: none;\"";
			}
			$stringToEcho .= " onclick=\"toggleSettingSection({id: '".
			$defaultConfigMoreDataRowData["menu"]["id"].
			"',formId: '".
			$defaultConfigMoreDataRowData["id"].
			"',groupId: '".
			$fsmgKey.
			"'});\" >".
			$defaultConfigMoreDataRowData["menu"]["name"].
			"</a>";
			echo $stringToEcho . PHP_EOL;
		}
	}
	$baseUrlImages = $localURL;
	?>
	<script type="text/javascript">
		var arrOfPossibleGroups = [<?php echo '"'.implode('","', $idArray).'"'?>];
	</script>
</div>
<div class="settingsHeader addBorderBottom" style="position: absolute;width: 100%;z-index: 10;top: 104px; margin: 0; display: none;" id="fixedPositionMiniMenu" ></div>
<script type="text/javascript">
	var baseUrl = "<?php echo $core->baseURL();?>";
	var popupSettingsArray = <?php echo $popupSettingsArray ?>;
	var currentVersion = "<?php echo $configStatic['version']; ?>";
	var saveVerifyImage = <?php echo json_encode($core->generateImage(
			$arrayOfImages["greenCheck"],
			array(
				"height"		=>	"50px",
				"srcModifier"	=>	""
			)
		)); ?>
</script>
<?php require_once($baseDir."core/php/template/popup.php");
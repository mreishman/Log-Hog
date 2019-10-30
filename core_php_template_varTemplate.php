<?php
if(!isset($settings))
{
	require_once($core->baseURL()."core/php/class/settings.php");
	$settings = new settings();
}
?>
<form id="<?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>">
<div class="settingsHeader">
<?php echo $defaultConfigMoreData[$currentSection]["name"]; ?>
<div class="settingsHeaderButtons">
	<?php echo $settings->addResetButton($defaultConfigMoreData[$currentSection]["id"]);?>
	<?php if ($currentSection === "globalConfig"):?>
		<a class="linkSmall <?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>SaveButton" onclick="saveAndVerifyGlobalConfigMain('<?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>');" >Save Changes</a>
	<?php else: ?>
		<a class="linkSmall <?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>SaveButton" onclick="saveAndVerifyMain('<?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>');" >Save Changes</a>
	<?php endif; ?>
</div>
</div>
<div class="settingsDiv" >
<ul class="settingsUl">
	<?php
	if(!isset($varTemplateSrcModifier))
	{
		$varTemplateSrcModifier = "../";
	}
	$infoImage = $core->generateImage(
		$arrayOfImages["info"],
		array(
			"style"			=>	"margin-bottom: -4px;",
			"height"		=>	"20px",
			"srcModifier"	=>	$varTemplateSrcModifier
		)
	);
	foreach ($defaultConfigMoreData[$currentSection]["vars"] as $confDataValue)
	{
		$settings->varTemplateLogic($confDataValue, $loadVarsArray, $infoImage);
	}
	?>
</ul>
</div>
</form>
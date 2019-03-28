<form id="<?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>">
<div class="settingsHeader">
<?php echo $defaultConfigMoreData[$currentSection]["name"]; ?>
<div class="settingsHeaderButtons">
	<?php echo addResetButton($defaultConfigMoreData[$currentSection]["id"]);?>
	<a class="linkSmall <?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>SaveButton" onclick="saveAndVerifyMain('<?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul class="settingsUl">
	<?php
	$infoImage = generateImage(
		$arrayOfImages["info"],
		array(
			"style"			=>	"margin-bottom: -4px;",
			"height"		=>	"20px",
			"srcModifier"	=>	"../"
		)
	);
	foreach ($defaultConfigMoreData[$currentSection]["vars"] as $confDataValue)
	{
		varTemplateLogic($confDataValue, $loadVarsArray, $infoImage);
	}
	?>
</ul>
</div>
</form>
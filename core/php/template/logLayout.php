<form id="settingsInitialLoadLayoutVars">
	<div class="settingsHeader">
	Log Layout Settings
		<div class="settingsHeaderButtons">
			<?php echo $settings->addResetButton("settingsInitialLoadLayoutVars"); ?>
			<a class="linkSmall settingsInitialLoadLayoutVarsSaveButton" onclick="saveAndVerifyMain('settingsInitialLoadLayoutVars');" >Save Changes</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<?php include("logLayoutInner.php"); ?>
	</div>
</form>
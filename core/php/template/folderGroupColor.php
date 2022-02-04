<form id="settingsColorFolderGroupVars">
	<div class="settingsHeader">
		Folder Color Options
		<a class="linkSmall" onclick="addRowForFolderColorOptions();" >Add Row</a>
		<div class="settingsHeaderButtons">
			<?php echo $settings->addResetButton("settingsColorFolderGroupVars"); ?>
			<a class="linkSmall" onclick="saveAndVerifyMain('settingsColorFolderGroupVars');" >Save Changes</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<?php
		$themeName = "noTheme";
		include("innerFolderGroupColor.php");
		?>
	</div>
</form>
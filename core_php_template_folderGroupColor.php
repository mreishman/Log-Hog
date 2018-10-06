<form id="settingsColorFolderGroupVars">
	<div class="settingsHeader">
	Folder Color Options [Refresh Required]
	<div class="settingsHeaderButtons">
		<?php echo addResetButton("settingsColorFolderGroupVars"); ?>
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
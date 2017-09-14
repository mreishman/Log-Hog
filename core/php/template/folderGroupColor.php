<form id="settingsColorFolderVars" action="../core/php/settingsSave.php" method="post">
	<div class="settingsHeader">
	Folder Color Options
	<div class="settingsHeaderButtons">
		<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsColorFolderVars');" >Save Changes</a>
		<?php else: ?>
			<button  onclick="displayLoadingPopup();">Save Changes</button>
		<?php endif; ?>
	</div>
	</div>
	<div class="settingsDiv" >
		<?php include("innerFolderGroupColor.php");?>
	</div>
</form>
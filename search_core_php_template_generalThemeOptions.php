<form id="settingsColorFolderVars" action="../core/php/settingsSave.php" method="post">
	<div class="settingsHeader">
	Main Theme Options
	<div class="settingsHeaderButtons">
		<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsColorFolderVars');" >Save Changes</a>
		<?php else: ?>
			<button  onclick="displayLoadingPopup();">Save Changes</button>
		<?php endif; ?>
	</div>
	</div>
	<div class="settingsDiv" >
		<ul id="settingsUl">
			<li>
				<span class="settingsBuffer" > Background: </span>  <input type="text" name="backgroundColor" value="<?php echo $backgroundColor;?>" >
			</li>
			<li>
				<span class="settingsBuffer" > Main Font Color: </span>  <input type="text" name="mainFontColor" value="<?php echo $mainFontColor;?>" >
			</li>
		</ul>
	</div>
</form>
<form id="devBranch">
	<div class="settingsHeader">
		Branch Settings
		<div class="settingsHeaderButtons">
			<?php echo $settings->addResetButton("devBranch"); ?>
			<a class="linkSmall devBranchSaveButton" onclick="saveAndVerifyMain('devBranch');" >Save Changes</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<span class="settingsBuffer" > Config Version: </span> <input type="number" pattern="[0-9]*" class="inputWidth" name="configVersion" value="<?php echo $configVersion;?>" >
			</li>
			<li>
				<span class="settingsBuffer" > Layout Version: </span> <input type="number" pattern="[0-9]*" class="inputWidth"  name="layoutVersion" value="<?php echo $layoutVersion;?>" >
			</li>
			<li>
				<span class="settingsBuffer" > Theme Version: </span> <input type="number" pattern="[0-9]*" class="inputWidth"  name="themeVersion" value="<?php echo $themeVersion;?>" >
			</li>
			<li>
				Refresh to run upgrade scripts
			</li>
		</ul>

	</div>
</form>
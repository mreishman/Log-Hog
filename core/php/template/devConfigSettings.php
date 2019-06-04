<form id="devConfig">
	<div class="settingsHeader">
		Static Config Settings
		<div class="settingsHeaderButtons">
			<?php echo $settings->addResetButton("devConfig");?>
			<a class="linkSmall devConfigSaveButton" onclick="saveConfigStatic();" >Save Changes</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<span class="settingsBuffer" >  Version Number:  </span> <input id="versionNumberConfigStaticInput" type="text" class="inputWidth"  name="version" value="<?php echo $configStatic['version'];?>" >
			</li>
		</ul>
	</div>
</form>
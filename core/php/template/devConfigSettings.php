<form id="devAdvanced2">
	<div class="settingsHeader">
		Static Config Settings
		<div class="settingsHeaderButtons">
			<?php echo $settings->addResetButton("devAdvanced2");?>
			<a class="linkSmall devAdvanced2SaveButton" onclick="saveConfigStatic();" >Save Changes</a>
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
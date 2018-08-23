<form id="settingsMainVars">
<div class="settingsHeader">
Other Settings 
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsMainVars"); ?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainVars');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul class="settingsUl">
	<li>
		<span class="settingsBuffer" > Popup Warnings: </span>
		<div class="selectDiv">
			<select id="popupSelect"  name="popupWarnings">
					<option <?php if($popupWarnings == 'all'){echo "selected";} ?> value="all">All</option>
					<option <?php if($popupWarnings == 'custom'){echo "selected";} ?> value="custom">Custom</option>
					<option <?php if($popupWarnings == 'none'){echo "selected";} ?> value="none">None</option>
			</select>
		</div>
		<div id="settingsPopupVars" <?php if($popupWarnings != 'custom'){echo "style='display: none;'";}?> >

		<div class="settingsHeader">
			Popup Settings
			</div>
			<div class="settingsDiv" >
			<ul class="settingsUl">
			<?php
			$popupSettingsInArray = json_decode($popupSettingsArray);
			foreach ($popupSettingsInArray as $key => $value):?>
				<li>
				<span class="settingsBuffer" > <?php echo $key;?>: </span>
				<div class="selectDiv">
					<select id="popup<?php echo $key;?>">
  						<option <?php if($value == 'true'){echo "selected";} ?> value="true">Yes</option>
  						<option <?php if($value == 'false'){echo "selected";} ?> value="false">No</option>
					</select>
				</div>
				</li>
			<?php endforeach;?>
			</ul>
			</div>
			<input id="popupSettingsArray" type="hidden" name="popupSettingsArray" value='<?php echo $popupSettingsArray; ?>' >
		</div>
	</li>
</ul>
</div>
</form>
<script type="text/javascript">
	
	<?php foreach ($popupSettingsInArray as $key => $value):?>
	$("#popup<?php echo $key; ?>").on("keydown change", function(){
	    var box = $(this);
	    setTimeout(function() {
	        updateJsonForPopupTheme();
	    }, 2);
	});
	<?php endforeach; ?>

</script>
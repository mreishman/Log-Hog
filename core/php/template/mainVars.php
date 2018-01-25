<form id="settingsMainVars">
<div class="settingsHeader">
Other Settings 
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsMainVars"); ?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainVars');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul id="settingsUl">
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
			<ul id="settingsUl">
			<?php foreach ($popupSettingsArray as $key => $value):?>
				<li>
				<span class="settingsBuffer" > <?php echo $key;?>: </span>
				<div class="selectDiv">
					<select name="<?php echo $key;?>">
  						<option <?php if($value == 'true'){echo "selected";} ?> value="true">Yes</option>
  						<option <?php if($value == 'false'){echo "selected";} ?> value="false">No</option>
					</select>
				</div>
				</li>
			<?php endforeach;?>
			</ul>
			</div>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Right Click Menu Enabled: </span>
		<div class="selectDiv">
			<select name="rightClickMenuEnable">
				<option <?php if($rightClickMenuEnable == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($rightClickMenuEnable == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Enable Themes: </span>
		<div class="selectDiv">
			<select name="themesEnabled">
				<option <?php if($themesEnabled == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($themesEnabled == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
</ul>
</div>
</form>
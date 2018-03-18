<form id="settingsUpdateVars">
<div class="settingsHeader">
Update Settings 
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsUpdateVars"); ?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsUpdateVars');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul id="settingsUl">
	<li>
		<span class="settingsBuffer" > Show Update Notification: </span>
		<div class="selectDiv">
			<select name="updateNotificationEnabled">
				<option <?php if($updateNotificationEnabled == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($updateNotificationEnabled == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Auto Check Update: </span>
		<div class="selectDiv">
			<select id="settingsSelect" name="autoCheckUpdate">
				<option <?php if($autoCheckUpdate == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($autoCheckUpdate == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
		<div id="settingsAutoCheckVars" <?php if($autoCheckUpdate == 'false'){echo "style='display: none;'";}?> >

		<div class="settingsHeader">
			Auto Check Update Settings
			</div>
			<div class="settingsDiv" >
			<ul id="settingsUl">
			
				<li>
				<span class="settingsBuffer" > Check for update every: </span> 
					<input type="number" pattern="[0-9]*" name="autoCheckDaysUpdate" value="<?php echo $autoCheckDaysUpdate;?>" >  Day(s)
				</li>
				<li>
				<span class="settingsBuffer" > Notify Updates on: </span>
				<div class="selectDiv">
					<select id="updateNoticeMeter" name="updateNoticeMeter">
  						<option <?php if($updateNoticeMeter == 'every'){echo "selected";} ?> value="every">Every Update</option>
  						<option <?php if($updateNoticeMeter == 'major'){echo "selected";} ?> value="major">Only Major Updates</option>
					</select>
				</div>
				</li>

			</ul>
			</div>
		</div>

	</li>
</ul>
</div>
</form>
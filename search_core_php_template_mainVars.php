<form id="settingsMainVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
Main Settings 
<div class="settingsHeaderButtons">
	<a onclick="resetSettingsMainVar();" id="resetChangesMainSettingsHeaderButton" style="display: none;" class="linkSmall" > Reset Current Changes</a>
	<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsMainVars');" >Save Changes</a>
	<?php else: ?>
		<button  onclick="displayLoadingPopup();">Save Changes</button>
	<?php endif; ?>
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
					<input type="text" name="autoCheckDaysUpdate" value="<?php echo $autoCheckDaysUpdate;?>" >  Day(s)
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
	<li>
		<span class="settingsBuffer" > Popup Warnings: </span>
		<div class="selectDiv">
			<select id="popupSelect"  name="popupWarnings">
					<option <?php if($popupWarnings == 'all'){echo "selected";} ?> value="all">All</option>
					<option <?php if($popupWarnings == 'none'){echo "selected";} ?> value="none">None</option>
			</select>
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
	
</ul>
</div>
</form>
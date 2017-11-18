<form id="settingsViewVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
View Settings 
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsViewVars");
	if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsViewVars');" >Save Changes</a>
	<?php else: ?>
		<button  onclick="displayLoadingPopup();">Save Changes</button>
	<?php endif; ?>
</div>
</div>
<div class="settingsDiv" >
<ul id="settingsUl">
	<li>
		<span class="settingsBuffer" > Polling Rate: </span>  <input type="text" name="pollingRateView" value="<?php echo $pollingRateView;?>" >
		<div class="selectDiv">
			<select name="pollingRateTypeView">
				<option <?php if($pollingRateTypeView == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($pollingRateTypeView == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Polling BG Rate: </span>  <input type="text" name="backgroundPollingRate" value="<?php echo $backgroundPollingRate;?>" >
		<div class="selectDiv">
			<select name="backgroundPollingRateType">
				<option <?php if($backgroundPollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($backgroundPollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
			</select>
		</div>
	</li>
</ul>
</div>
</form>
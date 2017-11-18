<form id="settingsRunVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
Run Settings 
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsRunVars");
	if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsRunVars');" >Save Changes</a>
	<?php else: ?>
		<button  onclick="displayLoadingPopup();">Save Changes</button>
	<?php endif; ?>
</div>
</div>
<div class="settingsDiv" >
<ul id="settingsUl">
	<li>
		<span class="settingsBuffer" > Polling Rate: </span>  <input type="text" name="pollingRate" value="<?php echo $pollingRate;?>" >
		<div class="selectDiv">
			<select name="pollingRateType">
				<option <?php if($pollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($pollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Test Folder: </span>  <input style="width: 600px;" type="text" name="locationOfTests" value="<?php echo $locationOfTests;?>" >
	</li>
	<li>
		<span class="settingsBuffer" > Selenium Folder: </span>  <input style="width: 600px;" type="text" name="locationOfSelenium" value="<?php echo $locationOfSelenium;?>" >
	</li>
</ul>
</div>
</form>
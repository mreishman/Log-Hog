<form id="settingsPollVars">
<div class="settingsHeader">
Poll Settings 
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsPollVars");?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsPollVars');" >Save Changes</a>
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
		<span class="settingsBuffer" > Background Poll Rate: </span>  <input type="text" name="backgroundPollingRate" value="<?php echo $backgroundPollingRate;?>" >
		<div class="selectDiv">
			<select name="backgroundPollingRateType">
				<option <?php if($backgroundPollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($backgroundPollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
			</select>
		</div>	
		<br>
		<i style="font-size: 75%;" >Only if Pause On Not Focus is set to False</i>
	</li>
	<li>
		<span class="settingsBuffer" > Pause Poll By Default:  </span>
		<div class="selectDiv">
			<select name="pausePoll">
				<option <?php if($pausePoll == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($pausePoll == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Pause On Not Focus: </span>
		<div class="selectDiv">
			<select name="pauseOnNotFocus">
				<option <?php if($pauseOnNotFocus == 'true'){echo "selected";} ?> value="true">True</option>
				<option <?php if($pauseOnNotFocus == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
</ul>
</div>
</form>
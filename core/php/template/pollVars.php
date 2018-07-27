<form id="settingsPollVars">
<div class="settingsHeader">
Poll Settings
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsPollVars");?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsPollVars');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul class="settingsUl">
	<li>
		<span class="settingsBuffer" > Polling Rate: </span>  <input type="number" pattern="[0-9]*" name="pollingRate" value="<?php echo $pollingRate;?>" >
		<div class="selectDiv">
			<select name="pollingRateType">
				<option <?php if($pollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($pollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Background Poll Rate: </span>  <input type="number" pattern="[0-9]*" name="backgroundPollingRate" value="<?php echo $backgroundPollingRate;?>" >
		<div class="selectDiv">
			<select name="backgroundPollingRateType">
				<option <?php if($backgroundPollingRateType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
				<option <?php if($backgroundPollingRateType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Pause Poll On Load:  </span>
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
	<li>
		<span class="settingsBuffer" > Full Screen Menu Click: </span>
		<div class="selectDiv">
			<select name="fullScreenMenuPollSwitchType">
				<option <?php if($fullScreenMenuPollSwitchType == 'BGrate'){echo "selected";} ?> value="BGrate">Use Background Rate</option>
				<option <?php if($fullScreenMenuPollSwitchType == 'Pause'){echo "selected";} ?> value="Pause">Pause Poll</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer" > Full Screen Menu delay: </span> <input type="number" pattern="[0-9]*" name="fullScreenMenuPollSwitchDelay" value="<?php echo $fullScreenMenuPollSwitchDelay;?>" > Seconds
	</li>
	<li>
		<span class="settingsBuffer"> Poll refresh all data every </span>
		<input type="number" pattern="[0-9]*" style="width: 100px;"  name="pollRefreshAll" value="<?php echo $pollRefreshAll;?>" >
		poll requests
		<div class="selectDiv">
			<select name="pollRefreshAllBool">
					<option <?php if($pollRefreshAllBool == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($pollRefreshAllBool == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer"> Force poll refresh after </span>
		<input type="number" pattern="[0-9]*" style="width: 100px;"  name="pollForceTrue" value="<?php echo $pollForceTrue;?>" >
		skipped poll requests
		<div class="selectDiv">
			<select name="pollForceTrueBool">
					<option <?php if($pollForceTrueBool == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($pollForceTrueBool == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer"> System preference:</span>
		<div class="selectDiv">
			<select name="shellOrPhp">
					<option <?php if($shellOrPhp == 'shellPreferred'){echo "selected";} ?> value="shellPreferred">Shell Preferred</option>
					<option <?php if($shellOrPhp == 'phpPreferred'){echo "selected";} ?> value="phpPreferred">Php Preferred</option>
					<option <?php if($shellOrPhp == 'shellOnly'){echo "selected";} ?> value="shellOnly">Shell Only</option>
					<option <?php if($shellOrPhp == 'phpOnly'){echo "selected";} ?> value="phpOnly">Php Only</option>
			</select>
		</div>
	</li>
	<li>
		<span class="settingsBuffer"> Line count from:</span>
		<div class="selectDiv">
			<select name="lineCountFromJS">
					<option <?php if($lineCountFromJS == 'true'){echo "selected";} ?> value="true">JS</option>
					<option <?php if($lineCountFromJS == 'false'){echo "selected";} ?> value="false">PHP</option>
			</select>
		</div>
		<br>
		<span style="font-size: 75%;">
			<?php echo generateImage(
				$arrayOfImages["info"],
				array(
					"style"			=>	"margin-bottom: -4px;",
					"height"		=>	"20px",
					"srcModifier"	=>	"../"
				)
			); ?>
			<i>PHP method is more accurate, but will increase poll times</i></span>
	</li>
	<li>
		<span class="settingsBuffer">Show Php errors from file open fails:</span>
		<div class="selectDiv">
			<select name="showErrorPhpFileOpen">
					<option <?php if($showErrorPhpFileOpen == 'true'){echo "selected";} ?> value="true">True</option>
					<option <?php if($showErrorPhpFileOpen == 'false'){echo "selected";} ?> value="false">False</option>
			</select>
		</div>
	</li>
</ul>
</div>
</form>
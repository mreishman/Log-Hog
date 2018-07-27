<?php $infoImage = generateImage(
	$arrayOfImages["info"],
	array(
		"style"			=>	"margin-bottom: -4px;",
		"height"		=>	"20px",
		"srcModifier"	=>	"../"
	)
);
?>
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
	<?php
	foreach ($defaultConfigMoreData["pollVars"] as $confDataKey => $confDataValue)
	{
		if($confDataValue["type"] === "single")
		{
			echo "<li>".generateGenericType($confDataValue["var"], $loadVarsArray[$confDataKey], $confDataKey)."</li>";
			if(isset($confDataValue["var"]["info"]) && $confDataValue["var"]["info"] !== "")
			{
				echo generateInfo($infoImage,$confDataValue["var"]["info"]);
			}
		}
		if(isset($confDataValue["info"]) && $confDataValue["info"] !== "")
		{
			echo generateInfo($infoImage,$confDataValue["info"]);
		}
	}
	?>
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
</ul>
</div>
</form>
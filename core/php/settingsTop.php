<form id="settingsMainVars" action="../core/php/settingsSaveTop.php" method="post">
		<div class="settingsHeader">
			Top Settings <button onclick="displayLoadingPopup();" >Save Changes</button>
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<span class="settingsBuffer" > Poll Rate Main: </span>  <input type="text" name="pollingRateOverviewMain" value="<?php echo $pollingRateOverviewMain;?>" >
					<select name="pollingRateOverviewMainType">
							<option <?php if($pollingRateOverviewMainType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
							<option <?php if($pollingRateOverviewMainType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
					</select>
				</li>
				<li>
					<span class="settingsBuffer" > Poll Rate Slow: </span>  <input type="text" name="pollingRateOverviewSlow" value="<?php echo $pollingRateOverviewSlow;?>" >
					<select name="pollingRateOverviewSlowType">
							<option <?php if($pollingRateOverviewSlowType == 'Milliseconds'){echo "selected";} ?> value="Milliseconds">Milliseconds</option>
							<option <?php if($pollingRateOverviewSlowType == 'Seconds'){echo "selected";} ?> value="Seconds">Seconds</option>
					</select>
				</li>
			</ul>
		</div>
	</form>
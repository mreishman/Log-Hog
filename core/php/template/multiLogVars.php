<form id="settingsMultiLogVars">
	<div class="settingsHeader">
	Multi-Log Settings
		<div class="settingsHeaderButtons">
			<?php echo addResetButton("settingsMultiLogVars"); ?>
			<a class="linkSmall" onclick="saveAndVerifyMain('settingsMultiLogVars');" >Save Changes</a>
		</div>
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<span class="settingsBuffer"> Log Layout</span>
				<?php $arrayOfwindowConfigOptions = array();
				for ($i=0; $i < 3; $i++)
				{
					for ($j=0; $j < 3; $j++)
					{
						array_push($arrayOfwindowConfigOptions, "".($i+1)."x".($j+1));
					}
				}
				?>
				<div class="selectDiv">
					<select name="windowConfig">
						<?php foreach ($arrayOfwindowConfigOptions as $value)
						{
							$stringToEcho = "<option ";
							if($value === $windowConfig)
							{
								$stringToEcho .= " selected ";
							}
							$stringToEcho .= " value=\"".$value."\"> ".$value."</option>";
							echo $stringToEcho;
						}
						?>
					</select>
				</div>
			</li>
			<li>
				<span class="settingsBuffer"> Enable tmp Multilog (button in menu): </span>
				<div class="selectDiv">
					<select name="multiLogOnIndex">
						<option <?php if($multiLogOnIndex === 'true'){echo "selected";} ?> value="true">True</option>
						<option <?php if($multiLogOnIndex === 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</div>
			</li>
			<li>
				<span class="settingsBuffer"> Keep Current on Switch: </span>
				<div class="selectDiv">
					<select name="logSwitchKeepCurrent">
						<option <?php if($logSwitchKeepCurrent === 'true'){echo "selected";} ?> value="true">True</option>
						<option <?php if($logSwitchKeepCurrent === 'onlyIfPresetDefined'){echo "selected";} ?> value="onlyIfPresetDefined" >Only If Preset Is Not Defined</option>
						<option <?php if($logSwitchKeepCurrent === 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</div>
			</li>
			<li>
			<span style="font-size: 75%;">
				<?php echo $infoImage; ?>
				<i>When switching between layouts, keep current selected windows over config</i>
			</span>
			</li>
			<li>
				<span class="settingsBuffer"> Clear windows if not in config: </span>
				<div class="selectDiv">
					<select name="logSwitchABCClearAll">
						<option <?php if($logSwitchABCClearAll === 'true'){echo "selected";} ?> value="true">True</option>
						<option <?php if($logSwitchABCClearAll === 'false'){echo "selected";} ?> value="false" >False</option>
					</select>
				</div>
			</li>
			<li>
			<span style="font-size: 75%;">
				<?php echo $infoImage; ?>
				<i>When switching between A B or C layouts, either clear all windows, OR keep current selected windows IF not defined in config</i>
			</span>
			</li>
		</ul>
	</div>
</form>
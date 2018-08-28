<form id="settingsColorFolderVars">
	<div class="settingsHeader">
	Main Theme Options [Refresh Required]
	<div class="settingsHeaderButtons">
		<?php echo addResetButton("settingsColorFolderVars"); ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsColorFolderVars');" >Save Changes</a>
	</div>
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<span class="settingsBuffer" > Background: </span>
				<input type="text" name="backgroundColor" value="<?php echo $backgroundColor;?>" >
			</li>
			<li>
				<span class="settingsBuffer" > Main Font Color: </span>
				<input type="text" name="mainFontColor" value="<?php echo $mainFontColor;?>" >
			</li>
			<li>
				<span class="settingsBuffer"> Font: </span>
				<div class="selectDiv">
					<select name="fontFamily">
						<?php
						$fonts = array('monospace','sans-serif','Courier','Monaco','Verdana','Geneva','Helvetica','Tahoma','Charcoal','Impact','cursive','Gadget','Arial');
						foreach ($fonts as $value): ?>
							<option <?php if($fontFamily === $value){echo "selected";} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</li>
			<li>
				<span class="settingsBuffer" > Log Font Color: </span>  <input type="text" name="logFontColor" value="<?php echo $logFontColor;?>" >
			</li>
			<li>
				<span class="settingsBuffer" > Header Background: </span>
				<input type="text" name="backgroundHeaderColor" value="<?php echo $backgroundHeaderColor;?>" >
			</li>
			<li>
				<span class="settingsBuffer"> Invert Header Images: </span>
				<div class="selectDiv">
					<select name="invertMenuImages">
						<option <?php if($invertMenuImages === 'true'){echo "selected";} ?> value="true">True</option>
						<option <?php if($invertMenuImages === 'false'){echo "selected";} ?> value="false">False</option>
					</select>
				</div>
			</li>
			<li>
				<span class="settingsBuffer"> Overall Brightness: </span>
				<div class="selectDiv">
					<select name="overallBrightness">
						<?php for ($brightnessPrecent=2; $brightnessPrecent <= 15; $brightnessPrecent++):
							$brightnessPrecentValue = ($brightnessPrecent * 10);
							?>
							<option <?php if($overallBrightness === $brightnessPrecentValue){echo "selected";} ?> value="<?php echo $brightnessPrecentValue; ?>"><?php echo $brightnessPrecentValue; ?>%</option>
						<?php endfor; ?>
					</select>
				</div>
			</li>
			<li>
				<span class="settingsBuffer"> Log Line Padding: </span>
				<div class="selectDiv">
					<select name="logLinePadding">
						<?php for ($logPadCount=0; $logPadCount <= 20; $logPadCount++): ?>
							<option <?php if($logLinePadding === $logPadCount){echo "selected";} ?> value="<?php echo $logPadCount; ?>"><?php echo $logPadCount; ?>px</option>
						<?php endfor; ?>
					</select>
				</div>
			</li>
			<li>
				<span class="settingsBuffer"> Log Font Size: </span>
				<div class="selectDiv">
					<select name="logFontSize">
						<?php for ($fontSizePercent=5; $fontSizePercent <= 20; $fontSizePercent++):
							$fontSizePercentValue = ($fontSizePercent * 10);
							?>
							<option <?php if($logFontSize === $fontSizePercentValue){echo "selected";} ?> value="<?php echo $fontSizePercentValue; ?>"><?php echo $fontSizePercentValue; ?>%</option>
						<?php endfor; ?>
					</select>
				</div>
			</li>
		</ul>
	</div>
</form>
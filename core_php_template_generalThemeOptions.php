<form id="settingsColorFolderVars" action="../core/php/settingsSave.php" method="post">
	<div class="settingsHeader">
	Main Theme Options
	<div class="settingsHeaderButtons">
		<?php echo addResetButton("settingsColorFolderVars");
		if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('settingsColorFolderVars');" >Save Changes</a>
		<?php else: ?>
			<button  onclick="displayLoadingPopup();">Save Changes</button>
		<?php endif; ?>
	</div>
	</div>
	<div class="settingsDiv" >
		<ul id="settingsUl">
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
		</ul>
	</div>
</form>
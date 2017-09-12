<form id="themeMainVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
Theme Selector
</div>
<div class="settingsDiv" >
	<?php
	$directory = '../core/Themes/';
	$scanned_directory = array_diff(scandir($directory), array('..', '.'));
	foreach ($scanned_directory as $key): 
		if($key != ".DS_Store"):
			require_once("../core/Themes/".$key."/defaultSetting.php");?>
			<div style="width: 600px; height: 400px; display: inline-block; background-color: grey; border: 1px solid white; margin: 20px;">
				<div class="settingsHeader" style="margin: 0px;">
					<?php echo $key;?>
					<div class="settingsHeaderButtons">
						<?php if($key !== $currentTheme): ?>
							<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
							<a class="linkSmall" onclick="saveAndVerifyMain('themeMainSelection-<?php echo $key;?>');" >Select</a>
							<?php else: ?>
								<button  onclick="displayLoadingPopup();">Select</button>
							<?php endif; ?>
						<?php else: ?>
							<a class="linkSmallHover"> Selected </a>
						<?php endif;?>
					</div>
					<form id="themeMainSelection-<?php echo $key;?>">
						<input type="hidden" name="currentTheme" value="<?php echo $key?>">
						<input type="hidden" name="backgroundColor" value="<?php echo $backgroundColorDefault;?>" >
						<input type="hidden" name="mainFontColor" value="<?php echo $mainFontColorDefault;?>" >
						<input type="hidden" name="backgroundHeaderColor" value="<?php echo $backgroundHeaderColorDefault;?>" >
					</form>
				</div>
				<?php echo generateExampleIndex($key, $withLogHog);?>
			</div>
		<?php endif; 
	endforeach; ?>
</div>
</form>
<form id="themeMainVars" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
Theme Selector
<div class="settingsHeaderButtons">
	<?php if ($setupProcess == "preStart" || $setupProcess == "finished"): ?>
		<a class="linkSmall" onclick="saveAndVerifyMain('themeMainVars');" >Save Changes</a>
	<?php else: ?>
		<button  onclick="displayLoadingPopup();">Save Changes</button>
	<?php endif; ?>
</div>
</div>
<div class="settingsDiv" >
	<?php
	$directory = '../core/Themes/';
	$scanned_directory = array_diff(scandir($directory), array('..', '.'));
	foreach ($scanned_directory as $key): ?>
		<div style="width: 600px; height: 400px; display: inline-block; background-color: grey; border: 1px solid white; margin: 10px;">
			<div class="settingsHeader" style="margin: 0px;">
			<?php echo $key;?>
			</div>
			<?php echo generateExampleIndex($key, $withLogHog);?>
		</div>
	<?php endforeach; ?>
</div>
</form>
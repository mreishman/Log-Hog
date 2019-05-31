<span id="moreAdvancedSpan">
	<div id="moreAdvanced" class="settingsHeader">
		Advanced
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<a style="text-decoration: none;" href="<?php echo $settingsUrlModifier; ?>setup/step1.php" class="link">Re-do Setup</a>
				<span> | </span>
				<a onclick="revertPopup();" class="link">Revert Version</a>
				<span> | </span>
				<a onclick="resetUpdateNotification();" class="link">Reset Update Notification</a>
				<span> | </span>
				<a class="link" href="<?php echo $otherSettingsUrlModifier; ?>editFiles.php" >View Files</a>
				<span> | </span>
				<?php if($backupNumConfigEnabled == 'true'): ?>
					<a onclick="showConfigPopup();" class="link">View restore options for config</a>
					<span> | </span>
					<?php if($showConfigBackupClear): ?>
						<span id="showConfigClearButton">
							<a onclick="clearBackupFiles();" class="link">Clear (<?php echo $countConfig;?>) Backup Config Files</a>
							<span> | </span>
						</span>
					<?php endif; ?>
				<?php endif; ?>
				<a onclick="resetSettingsPopup();" class="link">Reset Settings back to Default</a>
			</li>
		</ul>
	</div>
</span>
<form id="devAdvanced2" action="../core/php/settingsSaveConfigStatic.php" method="post"> <!-- Reset update notification form -->
	<input type="hidden" name="newestVersion" value="<?php echo $configStatic['version'];?>" >
</form>
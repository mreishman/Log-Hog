<?php require_once(baseUrl().'core/php/themeFunctions.php'); ?>
<div class="settingsHeader">
Theme Selector
</div>
<div class="settingsDiv" >
	<h2>Default</h2>
	<hr>
	<?php
	$customThemeCreateNew = false;
	$directory = '../core/Themes/';
	$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		include("themeSub.php");
	?>
	<br>
	<?php
		$directory = '../local/'.$currentSelectedTheme.'/Themes/';
		$scanned_directory = array();
		$customThemeNum = 1;
		if(is_dir($directory))
		{
			$scanned_directory = array_diff(scandir($directory), array('..', '.'));
			$customThemeNum = count($scanned_directory) + 1;
		}
		if($customThemeCreateNew || $scanned_directory !== array()): ?>
			<h2>Custom</h2>
			<hr>
		<?php
			if($scanned_directory !== array())
			{
				include("themeSub.php");
			}
			if($customThemeCreateNew): ?>
			<div style="width: 600px; height: 400px; display: inline-block; background-color: grey; border: 1px solid white; margin: 20px;">
				<span onclick="newThemePopup(<?php echo $customThemeNum; ?>)" style="cursor: pointer;" >
					<h1 style="text-align: center; font-size: 400%" >+</h1>
					<h1 style="text-align: center;" >Save as New Theme</h1>
				</span>
			</div>
		<?php endif;
		endif; ?>
</div>

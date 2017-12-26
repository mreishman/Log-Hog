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
		$directory = '../local/Themes/';
		$scanned_directory = array();
		if(is_dir($directory))
		{
			$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		}
		if($customThemeCreateNew || $scanned_directory !== array()): ?>
			<h2>Custom</h2>
			<hr>
		<?php
			include("themeSub.php");
		endif;
	?>

	<?php if($customThemeCreateNew): ?>
		<div style="width: 600px; height: 400px; display: inline-block; background-color: grey; border: 1px solid white; margin: 20px;">
	</div>
	<?php endif; ?>
</div>

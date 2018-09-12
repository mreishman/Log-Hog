<ul class="settingsUl">
<?php
$mainFolderColorMax = 0;
$highlightFolderColorMax = 0;
$activeFolderColorMax = 0;
$activeHighlightFolderColorMax = 0;
$i = 0;
foreach ($folderColorArrays as $key => $value):
	$i++ ?>
	<li>
		<?php $newRow = generateFolderColorRow(array(
			"key"							=>	$key,
			"currentFolderColorTheme"		=>	$currentFolderColorTheme,
			"i"								=>	$i,
			"value"							=>	$value
		));
		echo $newRow["html"];
		?>
		<?php
		if($newRow["newMainMax"] > $mainFolderColorMax)
		{
			$mainFolderColorMax = $newRow["newMainMax"];
		}
		if($newRow["newHighlightMax"] > $highlightFolderColorMax)
		{
			$highlightFolderColorMax = $newRow["newHighlightMax"];
		}
		if($newRow["newActiveMax"] > $activeFolderColorMax)
		{
			$activeFolderColorMax = $newRow["newActiveMax"];
		}
		if($newRow["newActiveHighlightMax"] > $activeHighlightFolderColorMax)
		{
			$activeHighlightFolderColorMax = $newRow["newActiveHighlightMax"];
		}
		?>
	</li>
<?php endforeach;
$mainFolderColorMax = 10+($mainFolderColorMax*26);
$highlightFolderColorMax = 10+($highlightFolderColorMax*26);
$activeFolderColorMax = 10+($activeFolderColorMax*26);
$activeHighlightFolderColorMax = 10+($activeHighlightFolderColorMax*26);
?>
<style>
.divAroundColors
{
	display: inline-grid;
}
.colorFolderMainWidth
{
	width: <?php echo $mainFolderColorMax; ?>px;
	display: inline-block;
}
.colorFolderHighlightWidth
{
	width: <?php echo $highlightFolderColorMax; ?>px;
	display: inline-block;
}
.colorFolderActiveWidth
{
	width: <?php echo $activeFolderColorMax; ?>px;
	display: inline-block;
}
.colorFolderActiveHighlightWidth
{
	width: <?php echo $activeHighlightFolderColorMax; ?>px;
	display: inline-block;
}
</style>
<input style="display: none;" type="text" name="folderThemeCount" value="<?php echo $i; ?>">
</ul>
<ul id="settingsUl">
<?php
$mainFolderColorMax = 0;
$highlightFolderColorMax = 0;
$activeFolderColorMax = 0;
$activeHighlightFolderColorMax = 0;
$i = 0;
foreach ($folderColorArrays as $key => $value):
	$i++ ?>
	<li>
		<span class="settingsBuffer" > <input type="radio" name="currentFolderColorTheme" <?php if ($key == $currentFolderColorTheme){echo "checked='checked'";}?> value="<?php echo $key; ?>"> <?php echo $key; ?>: </span>  <input style="display: none;" type="text" name="folderColorThemeNameForPost<?php echo $i;?>" value="<?php echo $key; ?>" >

		Main Colors: 
		<span class="colorFolderMainWidth" >
		<?php $j = 0;
		foreach ($value['main'] as $key2 => $value2):
			$j++;?>
		<div class="divAroundColors">
			<div class="colorSelectorDiv" style="background-color: <?php echo $value2['background']; ?>; border-bottom: 0px;" >
				<!-- <div class="inner-triangle" ></div> -->
			</div>
			<input style="width: 100px; display: none;" type="text" name="folderColorValueMainBackground<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2['background']; ?>" >
			<div class="colorSelectorDiv" style="background-color: <?php echo $value2['fontColor']; ?>; border-top: 0px;" >
				<!-- <div class="inner-triangle" ></div> -->
			</div>
			<input style="width: 100px; display: none;" type="text" name="folderColorValueMainFont<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2['fontColor']; ?>" >
		</div>
		<?php endforeach;
		if($j > $mainFolderColorMax)
		{
			$mainFolderColorMax = $j;
		}
		?>
		</span>
		Highlight:
		<span class="colorFolderHighlightWidth" >
		<?php $j = 0;
		foreach ($value['highlight'] as $key2 => $value2):
			$j++;?>
		<div class="divAroundColors">
			<div class="colorSelectorDiv" style="background-color: <?php echo $value2['background']; ?>; border-bottom: 0px;" >
				<!-- <div class="inner-triangle" ></div> -->
			</div>
			<input style="width: 100px; display: none;" type="text" name="folderColorValueHighlightBackground<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2['background']; ?>" >
			<div class="colorSelectorDiv" style="background-color: <?php echo $value2['fontColor']; ?>; border-top: 0px;" >
				<!-- <div class="inner-triangle" ></div> -->
			</div>
			<input style="width: 100px; display: none;" type="text" name="folderColorValueHighlightFont<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2['fontColor']; ?>" >
		</div>
		<?php endforeach;
		if($j > $highlightFolderColorMax)
		{
			$highlightFolderColorMax = $j;
		}
		?>
		</span>
		Updated:
		<span class="colorFolderActiveWidth" >
		<?php $j = 0;
		foreach ($value['active'] as $key2 => $value2):
			$j++;?>
		<div class="divAroundColors">
			<div class="colorSelectorDiv" style="background-color: <?php echo $value2['background']; ?>; border-bottom: 0px;" >
				<!-- <div class="inner-triangle" ></div> -->
			</div>
			<input style="width: 100px; display: none;" type="text" name="folderColorValueActiveBackground<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2['background']; ?>" >
			<div class="colorSelectorDiv" style="background-color: <?php echo $value2['fontColor']; ?>; border-top: 0px;" >
				<!-- <div class="inner-triangle" ></div> -->
			</div>
			<input style="width: 100px; display: none;" type="text" name="folderColorValueActiveFont<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2['fontColor']; ?>" >
		</div>
		<?php endforeach;
		if($j > $activeFolderColorMax)
		{
			$activeFolderColorMax = $j;
		}
		?>
		</span>
		Updated highlight:
		<span class="colorFolderActiveHighlightWidth" >
		<?php $j = 0;
		foreach ($value['highlightActive'] as $key2 => $value2):
			$j++;?>
		<div class="divAroundColors">
			<div class="colorSelectorDiv" style="background-color: <?php echo $value2['background']; ?>; border-bottom: 0px;" >
				<!-- <div class="inner-triangle" ></div> -->
			</div>
			<input style="width: 100px; display: none;" type="text" name="folderColorValueActiveHighlightBackground<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2['background']; ?>" >
			<div class="colorSelectorDiv" style="background-color: <?php echo $value2['fontColor']; ?>; border-top: 0px;" >
				<!-- <div class="inner-triangle" ></div> -->
			</div>
			<input style="width: 100px; display: none;" type="text" name="folderColorValueActiveHighlightFont<?php echo $i; ?>-<?php echo $j;?>" value="<?php echo $value2['fontColor']; ?>" >
		</div>
		<?php endforeach; 
		if($j > $activeHighlightFolderColorMax)
		{
			$activeHighlightFolderColorMax = $j;
		}
		?>
		</span>
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
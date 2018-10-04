<ul class="settingsUl">
	<li>
		<table id="addNewRowToThisForThemes" >
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php
				$mainFolderColorMax = 0;
				$highlightFolderColorMax = 0;
				$activeFolderColorMax = 0;
				$activeHighlightFolderColorMax = 0;
				$i = 0;
				foreach ($folderColorArrays as $key => $value):
					$i++ ?>
					<tr>
						<?php
						echo generateFolderColorRow(array(
							"key"							=>	$key,
							"currentFolderColorTheme"		=>	$currentFolderColorTheme,
							"i"								=>	$i,
							"value"							=>	$value,
							"themeName"						=>	$themeName
							))["html"];
						?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</li>
<input style="display: none;" type="text" name="folderThemeCount" value="<?php echo $i; ?>">
</ul>
<?php $newBlankRow = generateFolderColorRow(); ?>
<div style="display: none;" id="holderForFolderColors">
	<span class="emptyRow1" >
		<?php echo $newBlankRow["td1"]; ?>
	</span>
	<span class="emptyRow1p5" >
		<?php echo $newBlankRow["td1p5"]; ?>
	</span>
	<span class="emptyRow2" >
		<?php echo $newBlankRow["td2"]; ?>
	</span>
	<span class="emptyRow3" >
		<?php echo $newBlankRow["td3"]; ?>
	</span>
	<span class="emptyRow4" >
		<?php echo $newBlankRow["td4"]; ?>
	</span>
	<span class="emptyRow5" >
		<?php echo $newBlankRow["td5"]; ?>
	</span>
	<span class="emptyColorBlock">
		<?php echo generateColorBlock(); ?>
	</span>
</div>
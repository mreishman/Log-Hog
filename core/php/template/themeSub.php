<?php
foreach ($scanned_directory as $key):
		if($key != ".DS_Store" && is_dir($directory.$key)):
			include($directory.$key."/defaultSetting.php");
			$thisThemeIsSelected = false;
			?>
			<div style="width: 600px; height: 405px; display: inline-block; background-color: grey; border: 1px solid white; margin: 20px;">
				<div class="settingsHeader" style="margin: 0px;">
					<?php echo $themeDefaultSettings['displayName'];?>
					<div class="settingsHeaderButtons">
						<?php if($key !== $currentTheme): ?>
							<?php if(strpos($directory, "local") !== false): ?>
								<a class="linkSmall" onclick="deleteTheme('<?php echo "../../local/".$currentSelectedTheme."/Themes/".$key; ?>')" >Delete</a>
							<?php endif; ?>
							<a class="linkSmall" onclick="saveAndVerifyMain('themeMainSelection-<?php echo $key;?>');" >Select</a>
						<?php else:
							$thisThemeIsSelected = true;
							?>
							<a class="linkSmall" onclick="saveAndVerifyMain('themeMainSelection-<?php echo $key;?>');" >Reset / Update</a>
							<a class="linkSmallHover"> Selected </a>
						<?php endif;?>
					</div>
				</div>
				<span id="htmlContent-<?php echo $key;?>" style="display: block;">
					<iframe class="iframeThemes" data-src="<?php echo $themeDirMod; ?>core/Themes/example.php?type=<?php echo $key;?>" style="width: 598px; border: 0px; height: 378px;" src="">
					</iframe>
				</span>
				<span style="display: none;">
					<form id="themeMainSelection-<?php echo $key;?>">
						<?php
							$arrayOfInputValues = array(
								"loadingBarVersion"			=>	array(
									'value'					=>	$themeDefaultSettings['loadingBarVersion'],
									'default'				=>	$loadingBarVersion
								),
								"currentTheme"				=>	array(
									'value'					=>	$key,
									'default'				=>	$currentTheme
								),
								"backgroundColor"			=>	array(
									'value'					=>	$themeDefaultSettings['backgroundColor'],
									'default'				=>	$backgroundColor
								),
								"mainFontColor"				=>	array(
									'value'					=>	$themeDefaultSettings['mainFontColor'],
									'default'				=>	$mainFontColor
								),
								"backgroundHeaderColor"		=>	array(
									'value'					=>	$themeDefaultSettings['backgroundHeaderColor'],
									'default'				=>	$backgroundHeaderColor
								),
								"logFontColor"				=>	array(
									'value'					=>	$themeDefaultSettings["logFontColor"],
									'default'				=>	$logFontColor
								)
							);

							foreach ($arrayOfInputValues as $inputKey => $inputArrayValue):
								$type = "hidden";
								if(isset($inputArrayValue["type"]))
								{
									$type = $inputArrayValue["type"];
								}

								if($inputArrayValue["value"] !== $inputArrayValue["default"] && $thisThemeIsSelected)
								{
									$customThemeCreateNew = true;
								}

								?>
								<input type="<?php echo $type; ?>" name="<?php echo $inputKey; ?>" value="<?php echo $inputArrayValue['value']; ?>" >
							<?php endforeach;

							$tmpcurrentFolderColorTheme = $currentFolderColorTheme;
							$currentFolderColorTheme = $themeDefaultSettings["currentFolderColorTheme"];
							$tmpfolderColorArrays = $folderColorArrays;
							$folderColorArrays = $themeDefaultSettings["folderColorArrays"];
							if($thisThemeIsSelected && !$customThemeCreateNew)
							{
								if($tmpcurrentFolderColorTheme !== $currentFolderColorTheme || $tmpfolderColorArrays !== $folderColorArrays)
								{
									$customThemeCreateNew = true;
								}
							}
							$themeName = $key;
							$i = 0;
							foreach ($folderColorArrays as $key => $value)
							{
								$i++;
								echo generateFolderColorRow(array(
										"key"							=>	$key,
										"currentFolderColorTheme"		=>	$currentFolderColorTheme,
										"i"								=>	$i,
										"value"							=>	$value,
										"themeName"						=>	$themeName
									))["html"];
							}
							echo "<input style=\"display: none;\" type=\"text\" name=\"folderThemeCount\" value=\"".$i."\">";
							$folderColorArrays = $tmpfolderColorArrays;
							$currentFolderColorTheme = $tmpcurrentFolderColorTheme;
						?>
					</form>
				</span>
			</div>
		<?php endif;
	endforeach;
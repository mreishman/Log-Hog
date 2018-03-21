<?php
foreach ($scanned_directory as $key):
		if($key != ".DS_Store" && is_dir($directory.$key)):
			include($directory.$key."/defaultSetting.php");
			$thisThemeIsSelected = false;
			?>
			<div style="width: 600px; height: 400px; display: inline-block; background-color: grey; border: 1px solid white; margin: 20px;">
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
				<span id="loadingSpinner-<?php echo $key;?>">
					<?php
						echo generateImage(
						$arrayOfImages["loading"],
						$imageConfig = array(
							"height"	=>	"60px",
							"srcModifier"	=>	"../",
							"style"		=>	"position: relative; height: 60px; top: 170px; left: 270px;"
							)
						);
					?>
				</span>
				<span id="htmlContent-<?php echo $key;?>" style="display: none;">
					<iframe style="width: 598px; border: 0px; height: 373px;" src="../core/Themes/example.php?type=../<?php echo $directory.$key;?>">
					</iframe>
				</span>
				<span style="display: none;">
					<script type="text/javascript">
						$( document ).ready(function()
						{
							setTimeout(function(){
								document.getElementById("loadingSpinner-<?php echo $key;?>").style.display = "none";
								document.getElementById("htmlContent-<?php echo $key;?>").style.display = "block";
							}, 2000);
						});
					</script>
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
							include('innerFolderGroupColor.php');
							$folderColorArrays = $tmpfolderColorArrays;
							$currentFolderColorTheme = $tmpcurrentFolderColorTheme;
						?>
					</form>
				</span>
			</div>
		<?php endif;
	endforeach;
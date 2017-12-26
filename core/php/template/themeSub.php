<?php
foreach ($scanned_directory as $key):
		if($key != ".DS_Store"):
			require_once("../core/Themes/".$key."/defaultSetting.php");
			$thisThemeIsSelected = false;
			?>
			<div style="width: 600px; height: 400px; display: inline-block; background-color: grey; border: 1px solid white; margin: 20px;">
				<div class="settingsHeader" style="margin: 0px;">
					<?php echo $key;?>
					<div class="settingsHeaderButtons">
						<?php if($key !== $currentTheme): ?>
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
					<img src="<?php echo $baseUrl;?>/img/loading.gif" style="position: relative; height: 60px; top: 170px; left: 270px;" >
				</span>
				<span id="htmlContent-<?php echo $key;?>" style="display: none;">
					<?php echo generateExampleIndex($key);?>
				</span>
				<span style="display: none;">
					<script type="text/javascript">
						$( document ).ready(function()
						{
						   document.getElementById("loadingSpinner-<?php echo $key;?>").style.display = "none";
						   document.getElementById("htmlContent-<?php echo $key;?>").style.display = "block";
						});
					</script>
					<form action="../core/php/settingsSave.php" method="post" id="themeMainSelection-<?php echo $key;?>">
						<?php
							$arrayOfInputValues = array(
								"loadingBarVersion"			=>	array(
									'value'					=>	$loadingBarVersionDefault,
									'default'				=>	$loadingBarVersion
								),
								"currentTheme"				=>	array(
									'value'					=>	$key,
									'default'				=>	$currentTheme
								),
								"backgroundColor"			=>	array(
									'value'					=>	$backgroundColorDefault,
									'default'				=>	$backgroundColor
								),
								"mainFontColor"				=>	array(
									'value'					=>	$mainFontColorDefault,
									'default'				=>	$mainFontColor
								),
								"backgroundHeaderColor"		=>	array(
									'value'					=>	$backgroundHeaderColorDefault,
									'default'				=>	$backgroundHeaderColor
								),
								"logFontColor"				=>	array(
									'value'					=>	$logFontColorDefault,
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
							$currentFolderColorTheme = $currentFolderColorThemeDefault;
							$tmpfolderColorArrays = $folderColorArrays;
							$folderColorArrays = $folderColorArraysDefault;
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
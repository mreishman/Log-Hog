<ul class="settingsUl">
	<li>
		<span onclick="showLayoutOptions('');" class="linkSmall logLayoutShowAll logLayoutShowAllMain">Show All Options</span>
		<span onclick="hideLayoutOptionsAll();" class="linkSmall logLayoutHideAll logLayoutHideAllMain">Hide All Options</span>
	</li>
</ul>
<?php
$oneLogSelected = false;
$oneLogNotSelected = false;
foreach ($arrayOfwindowConfigOptions as $key => $valueOuter):
	$value = $valueOuter["value"];?>
	<div class="settingsHeader" id="logLayoutInitial<?php echo $key;?>" >
	Initial Load Layout <?php echo $value; ?>
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<?php $innerCount = explode("x", $value);
			$innerWindowDisplayConfigRowCount = $innerCount[0];
			$innerWindowDisplayConfigColCount = $innerCount[1];
			for($i = 0; $i < $innerWindowDisplayConfigRowCount; $i++):
				for($j = 0; $j < $innerWindowDisplayConfigColCount; $j++):
					$counterInternal = $j+($i*$innerWindowDisplayConfigColCount);
					$oneLogInnerSelected = false;
					?>
					<li class="innerWindowDisplayLoadLayout innerWindowDisplayLoadLayout<?php echo $value; ?>">
						<div class="settingsHeader">
							Window <?php echo $counterInternal + 1; ?>
						</div>
						<div class="settingsDiv" >
							<ul class="settingsUl">
								<?php
									$arrayOfLetters = array("A","B","C"); //If you want more, change loadVars.php
									foreach ($arrayOfLetters as $letter):
										$logID = "logLoad".$value."-".$counterInternal."-".$letter;
										?>
										<li>
											Layout <?php echo $letter; ?>:
											<span id="<?php echo $logID; ?>" >
												<?php if (isset($logLoadLayout[$value][$counterInternal][$letter]) && $logLoadLayout[$value][$counterInternal][$letter] !== ""):
													$oneLogSelected = true;
													$oneLogInnerSelected = true;
													echo $logLoadLayout[$value][$counterInternal][$letter]; ?>
												<?php else :
													$oneLogNotSelected = true;
													?>
													No Log Selected
												<?php endif; ?>
											</span>
											<span onclick="selectLogPopup('<?php echo $logID; ?>')" class="linkSmall" >
												Select Log
											</span>
											<?php if (isset($logLoadLayout[$value][$counterInternal][$letter]) && $logLoadLayout[$value][$counterInternal][$letter] !== ""): ?>
												<span id="unselectLogButton<?php echo $logID; ?>" onclick="unselectLog('<?php echo $logID; ?>')" class="linkSmall" >
													Un-Select Log
												</span>
												<input type="hidden" name="<?php echo $logID; ?>" value="<?php echo $logLoadLayout[$value][$counterInternal][$letter]; ?>" >
											<?php else : ?>
												<span id="unselectLogButton<?php echo $logID; ?>" style="display: none;" onclick="unselectLog('<?php echo $logID; ?>')" class="linkSmall" >
													Un-Select Log
												</span>
												<input type="hidden" name="<?php echo $logID; ?>" value="" >
											<?php endif; ?>
										</li>
									<?php
									endforeach;
								?>
							</ul>
						</div>
					</li>
					<?php
				endfor;
			endfor;
			?>
			<li class="innerWindowDisplayLoadLayoutHidden innerWindowDisplayLoadLayoutHidden<?php echo $value; ?>">
				<span onclick="showLayoutOptions('<?php echo $value; ?>');" class="linkSmall logLayoutShowAll logLayoutShowAll<?php echo $value; ?>">Show Options</span>
			</li>
			<?php if ($logLayoutSettingsInfo === "all" || $logLayoutSettingsInfo === "expandWithValues"): ?>
				<?php if ($logLayoutSettingsInfo === "all" || $logLayoutSettingsInfo === "expandWithValues" && $oneLogInnerSelected): ?>
				<style type="text/css">
					.innerWindowDisplayLoadLayoutHidden<?php echo $value; ?> {
						display: none;
					}
				</style>
				<?php else: ?>
				<style type="text/css">
					.innerWindowDisplayLoadLayout<?php echo $value; ?> {
						display: none;
					}
				</style>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
	</div>
<?php
endforeach;

if($logLayoutSettingsInfo === "none" || $logLayoutSettingsInfo === "expandWithValue"):
	if($logLayoutSettingsInfo === "none" || ($logLayoutSettingsInfo === "expandWithValue" && $oneLogInnerSelected === false)) : ?>
		<style type="text/css">
			.innerWindowDisplayLoadLayout {
				display: none;
			}
		</style>
	<?php else: ?>
		<style type="text/css">
			.innerWindowDisplayLoadLayoutHidden {
				display: none;
			}
		</style>
	<?php endif;
endif;
//logic for hiding show all / hide all buttons
$hideShowAll = true;
$hideHideAll = true;
if(
	$logLayoutSettingsInfo === "none" ||
	($logLayoutSettingsInfo === "expandWithValue" && $oneLogSelected !== false) ||
	($logLayoutSettingsInfo === "expandWithValues" && $oneLogSelected !== false)
)
{
	$hideHideAll = false;
}
if(
	$logLayoutSettingsInfo === "all" ||
	($logLayoutSettingsInfo === "expandWithValue" && $oneLogNotSelected !== false) ||
	($logLayoutSettingsInfo === "expandWithValues" && $oneLogNotSelected !== false)
)
{
	$hideShowAll = false;
}
if($hideHideAll): ?>
<style type="text/css">
	.logLayoutHideAllMain {
		display: none;
	}
</style>
<?php endif;
if($hideShowAll): ?>
<style type="text/css">
	.logLayoutShowAllMain {
		display: none;
	}
</style>
<?php endif;
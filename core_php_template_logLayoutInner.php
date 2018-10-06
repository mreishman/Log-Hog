<?php foreach ($arrayOfwindowConfigOptions as $key => $valueOuter):
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
					?>
					<li>
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
												<?php if (isset($logLoadLayout[$value][$counterInternal][$letter]) && $logLoadLayout[$value][$counterInternal][$letter] !== ""): ?>
													<?php echo $logLoadLayout[$value][$counterInternal][$letter]; ?>
												<?php else : ?>
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
		</ul>
	</div>
<?php endforeach; ?>
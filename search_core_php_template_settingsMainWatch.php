<?php

$noSaved = "No Saved Searches";

?>
<form onsubmit="checkWatchList()" id="settingsMainWatch" action="../core/php/settingsSave.php" method="post">
<div class="settingsHeader">
	Saved Searches
</div>
<div class="settingsDiv" >	
	<ul id="settingsUl">
		<?php
		$i = 0;
		if(is_dir("../savedSearches/")):
			$dir = "../savedSearches/";
			$dir = array_diff(scandir($dir), array('..', '.'));
			if(count($dir) > 0):
				foreach($dir as $key): $i++;
				?>
					<li id="rowNumber<?php echo $i; ?>" >
						<a 
							class="deleteIconPosition"
							onclick="deleteRowFunctionPopup(
								<?php echo $i; ?>,
								true,
								'<?php echo $key; ?>')"
						>
							<img src="<?php echo $baseUrlImages;?>img/trashCan.png" height="15px;" >
						</a>
						File #<?php if($i < 10){echo "0";} ?><?php echo $i; ?>: 
						<span> <?php echo $key; ?> </span>
					</li>
				<?php endforeach; 
			else: 
				echo $noSaved;
			endif;
		else: 
			echo $noSaved;
		endif; ?>
	</ul>
</div>
<div id="hidden" style="display: none">
	<input id="numberOfRows" type="text" name="numberOfRows" value="<?php echo $i;?>">
</div>	
</form>
<?php $folderCount = $i; ?>
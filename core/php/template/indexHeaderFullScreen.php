<div class="addBorderBottom" style="padding: 5px 5px 10px 5px;" >
	<div onclick="toggleFullScreenMenu();"  class="menuImageDiv">
		<?php echo generateImage(
			$arrayOfImages["loadingImg"],
			$imageConfig = array(
				"id"		=>	"menuImage",
				"class"		=>	"menuImage menuImageForLoad",
				"height"	=>	"30px",
				"data-src"	=>	$arrayOfImages["menu"]
				)
			);
		?>
	</div>
</div>
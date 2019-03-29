<div class="addBorderBottom padding55105" >
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
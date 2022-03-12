<span onclick="hideFilterTopBar();" style="cursor: pointer;">
	<?php echo $core->generateImage(
		$arrayOfImages["loadingImg"],
		$imageConfig = array(
			"id"		=>	"hideFilterTopBarImage",
			"class"		=>	"menuImage closeImageForLoad",
			"height"	=>	"30px",
			"data-src"	=>	$arrayOfImages["close"]
			)
		);
	?>
</span>
<input autocomplete="off" id="searchFieldInput" type="search" name="search" placeholder="Filter <?php echo $filterDefault; ?>">
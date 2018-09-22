<div style="padding: 5px 5px 10px 5px; border-bottom: 1px solid white;" >
	<div onclick="toggleFullScreenMenu();"  class="menuImageDiv">
		<?php echo generateImage(
			$arrayOfImages["menu"],
			$imageConfig = array(
				"id"		=>	"menuImage",
				"class"		=>	"menuImage",
				"height"	=>	"30px"
				)
			);
		?>
	</div>
	<div onclick="toggleNotifications();"  class="menuImageDiv">
		<?php echo generateImage(
			$arrayOfImages["notification"],
			$imageConfig = array(
				"id"		=>	"notificationNotClicked",
				"class"		=>	"menuImage",
				"height"	=>	"30px"
				)
			);
		?>
	</div>
</div>
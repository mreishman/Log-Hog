<div class="addBorderBottom padding55105 backgroundForSideBarMenu" >
	<table width="100%;">
		<tr>
			<td width="33%">
				<div onclick="toggleFullScreenMenu();"  class="menuImageDiv">
					<?php echo $core->generateImage(
						$arrayOfImages["loadingImg"],
						$imageConfig = array(
							"id"		=>	"menuImage",
							"class"		=>	"menuImage menuImageForLoad altImage",
							"height"	=>	"30px",
							"data-src"	=>	$arrayOfImages["close"]
							)
						);
					?>
				</div>
			</td>
			<td width="33%" style="text-align: center;">
				Log-Hog <?php echo $configStatic['version'];?>
			</td>
			<td width="33%">
			</td>
		</tr>
	</table>
</div>
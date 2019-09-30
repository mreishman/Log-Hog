<div class="settingsHeader">
	Whats New
</div>
<div class="settingsDiv" >
	<table width="100%;">
		<tr>
			<td width="25%" ></td>
			<td width="75%"></td>
		</tr>
		<?php
		$jsonFiles = file_get_contents($core->baseURL()."core/json/whatsNew.json");
		$dataForWhatsNew = json_decode($jsonFiles, true);
		$dataForWhatsNew = array_reverse($dataForWhatsNew);
		$first = true;
		foreach($dataForWhatsNew as $value): ?>
			<tr>
				<?php if($first):
					$first = false; ?>
				<th colspan="2" style="padding: 10px">
				<?php else: ?>
				<th colspan="2" class="addBorderTop" style="padding: 10px">
				<?php endif; ?>
					<h1><?php echo $value["Version"]; ?></h1>
					<h3><?php echo $value["Name"]; ?></h3>
				</th>
			</tr>
			<tr>
				<td style="vertical-align: top;">
					<ul>
						<?php foreach ($value["BP"] as $BPValue): ?>
							<li><?php echo $BPValue; ?></li>
						<?php endforeach; ?>
					</ul>
				</td>
				<td>
					<?php foreach ($value["Images"] as $IMGValue):
						echo "<div style=\"display: inline-block;\" >".$core->generateImage(
							$arrayOfImages["loadingImg"],
							array(
								"class"			=>	"whatsNewImage",
								"style"			=>	"max-width: 500px;",
								"data-src"		=>	array(
									"src"			=> "core/img/".$IMGValue,
									"alt"			=> $value["Version"]. " Image",
									"title"			=> $value["Version"]. " Image"
									),
								"srcModifier"	=>	$otherPageImageModifier
								)
							)."</div>";
					endforeach; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>
<div class="settingsHeader">
	Whats New
</div>
<div class="settingsDiv" >
	<table width="100%;">
		<tr>
			<td width="25%" >
			</td>
			<td width="75%">
			</td>
		</tr>

		<tr>
			<th colspan="2" style="padding: 10px">
				<h1>5.0</h1>
				<h3>Multi-Log</h3>
			</th>
		</tr>


		<tr>
			<td>
				<ul>
					<li>
						View more than one log at a time
					</li>
					<li>
						Save log layout for initial load
					</li>
				</ul>
			</td>
			<td>
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"class"		=>	"whatsNewImage",
						"style"		=>	"width: 45%;",
						"data-src"	=>	$imageDirModifierAbout."core/img/5.0-1.png"
						)
					);
				?>
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"class"		=>	"whatsNewImage",
						"style"		=>	"width: 45%;",
						"data-src"	=>	$imageDirModifierAbout."core/img/5.0-2.png"
						)
					);
				?>
			</td>
		</tr>


		<tr>
			<th colspan="2" style="border-top: 1px solid white; padding: 10px">
				<h1>4.2</h1>
				<h3>Files/Folders [Side B]</h3>
			</th>
		</tr>


		<tr>
			<td>
				<ul>
					<li>
						Added condensed mode for watch list files
					</li>
					<li>
						Added archive button to watchlist
					</li>
				</ul>
			</td>
			<td>
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"class"		=>	"whatsNewImage",
						"style"		=>	"width: 45%;",
						"data-src"	=>	$imageDirModifierAbout."core/img/4.2-1.png"
						)
					);
				?>
			</td>
		</tr>


		<tr>
			<th colspan="2" style="border-top: 1px solid white; padding: 10px">
				<h1>4.1</h1>
				<h3>Files/Folders [Side A]</h3>
			</th>
		</tr>


		<tr>
			<td>
				<ul>
					<li>
						New add file / folder popup
					</li>
					<li>
						See dir while editing previous entries
					</li>
				</ul>
			</td>
			<td>
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"class"		=>	"whatsNewImage",
						"style"		=>	"width: 45%;",
						"data-src"	=>	$imageDirModifierAbout."core/img/4.1-1.png"
						)
					);
				?>
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"class"		=>	"whatsNewImage",
						"style"		=>	"width: 45%;",
						"data-src"	=>	$imageDirModifierAbout."core/img/4.1-2.png"
						)
					);
				?>
			</td>
		</tr>


		<tr>
			<th colspan="2" style="border-top: 1px solid white; padding: 10px">
				<h1>4.0</h1>
				<h3>Back to focus</h3>
			</th>
		</tr>


		<tr>
			<td>
				<ul>
					<li>
						New log format
					</li>
					<li>
						New menu system
					</li>
					<li>
						More log title display options
					</li>
					<li>
						Grouped groups!
					</li>
				</ul>
			</td>
			<td>
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"class"		=>	"whatsNewImage",
						"style"		=>	"width: 45%;",
						"data-src"	=>	$imageDirModifierAbout."core/img/4.0-1.png"
						)
					);
				?>
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"class"		=>	"whatsNewImage",
						"style"		=>	"width: 45%;",
						"data-src"	=>	$imageDirModifierAbout."core/img/4.0-2.png"
						)
					);
				?>
				<br>
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"class"		=>	"whatsNewImage",
						"style"		=>	"width: 45%;",
						"data-src"	=>	$imageDirModifierAbout."core/img/4.0-3.png"
						)
					);
				?>
				<?php echo generateImage(
					$arrayOfImages["loadingImg"],
					$imageConfig = array(
						"class"		=>	"whatsNewImage",
						"style"		=>	"width: 45%;",
						"data-src"	=>	$imageDirModifierAbout."core/img/4.0-4.png"
						)
					);
				?>
			</td>
		</tr>
		<?php
		$dataForWhatsNew = array(
			1	=>	array(
				"Version"		=>	"2.3",
				"Name"			=>	"Processes",
				"BP"			=>	array("CPU usage","Ram / swap usage","Disk usage / IO","PHP User time used / system time used","Network Interface receive / transmit","Shows list of processes"),
				"Images"		=>	array("2.3-1.png","2.3-2.png")
			),
			2	=>	array(
				"Version"		=>	"3.0",
				"Name"			=>	"Stylin'",
				"BP"			=>	array("Change how Log-Hog looks by going to settings, then themes","3 new main themes","New customizability of the current and new themes."),
				"Images"		=>	array("3.0-1.png","3.0-2.png","3.0-3.png","3.0-4.png")
			),
			3	=>	array(
				"Version"		=>	"3.1",
				"Name"			=>	"Couldn't find it",
				"BP"			=>	array("Run visual grep's from the new search addon"),
				"Images"		=>	array("3.1-1.png","3.1-2.png")
			),
			4	=>	array(
				"Version"		=>	"3.2",
				"Name"			=>	"Found it!",
				"BP"			=>	array("Monitor your selenium grid, and run new tests from a web interface","Filter logs by title / path","Restore versions of config."),
				"Images"		=>	array("3.2-1.png","3.2-2.png","3.2-3.png","3.2-4.png")
			),
			5	=>	array(
				"Version"		=>	"3.3",
				"Name"			=>	"I Can Count?",
				"BP"			=>	array("New ocean theme!","Notification count","Clear all notifications button","Last line shown on name hover"),
				"Images"		=>	array("3.3-1.png","3.3-3.png","3.3-4.png")
			),
			6	=>	array(
				"Version"		=>	"3.4",
				"Name"			=>	"Still Searching",
				"BP"			=>	array("Content filter for logs! (search and highlight content of logs)","Save custom themes!"),
				"Images"		=>	array("3.4-1.png","3.4-2.png")
			),
			7	=>	array(
				"Version"		=>	"3.5",
				"Name"			=>	"Settings Update 2",
				"BP"			=>	array("New Theme! (Steampunk)","On hover option to change to full path for log titles","Highlights new lines of logs (for 1 sec) (with options to change color)","Added right click menus for log titles and pause icon"),
				"Images"		=>	array("3.5-1.png","3.5-2.png","3.5-3.png","3.5-4.png")
			),
			8	=>	array(
				"Version"		=>	"3.6",
				"Name"			=>	"Get Notified?",
				"BP"			=>	array("Content filter quick settings","Internal Notifications","New Theme! (Terminal)"),
				"Images"		=>	array("3.6-3.png","3.6-2.png","3.6-1.png","3.6-4.png")
			),
		);
		$dataForWhatsNew = array_reverse($dataForWhatsNew);
		$first = false; //change to true when at top
		foreach($dataForWhatsNew as $value): ?>
			<tr>
				<?php if($first):
					$first = false; ?>
				<th colspan="2" style="padding: 10px">
				<?php else: ?>
				<th colspan="2" style="border-top: 1px solid white; padding: 10px">
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
					<?php foreach ($value["Images"] as $IMGValue): ?>
						<?php echo generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"class"		=>	"whatsNewImage",
								"style"		=>	"width: 100%; max-width: 500px;",
								"data-src"	=>	$imageDirModifierAbout."core/img/".$IMGValue
								)
							);
						?>
					<?php endforeach; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>
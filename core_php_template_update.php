<span id="updateUpdate" >
	<div class="settingsHeader">
		Update
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<h2>Current Version of Log-Hog: <?php echo $configStatic['version'];?></h2>
			</li>
			<?php if(!class_exists('ZipArchive')): ?>
				Error - you must install ZipArchive to download / check for updates.
			<?php else: ?>
				<li>
					<h2>You last checked for updates
						<span id="spanNumOfDaysUpdateSince" >
							<u onclick="checkForUpdates('');" style="cursor: pointer;" > <?php echo $daysSince;?> Day<?php if($daysSince != 1){ echo "s";} ?></u>
						</span>
						 Ago
					</h2>
				</li>
				<li>
					<a id="checkForUpdateButton" class="link" onclick="checkForUpdates('');">Check for updates</a>
				</li>
				<li style="display: none;" id="progressBarUpdateCheck">
					<progress id="progressBarUpdateCheckActualBar" value="50" max="100"></progress>
					<br>
					<p id="progressBarText" ></p>
				</li>
				<li id="noUpdate" <?php if($levelOfUpdate != 0){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo generateImage(
							$arrayOfImages["greenCheck"],
							$imageConfig = array(
								"id"			=>	"statusImage1",
								"height"		=>	"15px",
								"srcModifier"	=> ""
							)
						);
						?>
						&nbsp; No new updates - You are on the current version!
					</h2>
				</li>
				<li id="minorUpdate" <?php if($levelOfUpdate != 1){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo generateImage(
							$arrayOfImages["yellowWarning"],
							$imageConfig = array(
								"id"			=>	"statusImage2",
								"height"		=>	"15px",
								"srcModifier"	=> ""
							)
						);
						?>
						&nbsp; Minor Updates -
						<span id="minorUpdatesVersionNumber">
							<?php echo " ".$configStatic['newestVersion']." ";?>
						</span>
						- bug fixes
					</h2>
					<a class="link" onclick="installUpdates('');">Install Update</a>
				</li>
				<li id="majorUpdate" <?php if($levelOfUpdate != 2){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo generateImage(
							$arrayOfImages["redWarning"],
							$imageConfig = array(
								"id"			=>	"statusImage3",
								"height"		=>	"15px",
								"srcModifier"	=> ""
							)
						);
						?>
						&nbsp; Major Updates -
						<span id="majorUpdatesVersionNumber">
							<?php echo " ".$configStatic['newestVersion']." ";?>
						</span>
						- new features!</h2>
						<a class="link" onclick="installUpdates('');">Install Update</a>
				</li>
				<li id="NewXReleaseUpdate" <?php if($levelOfUpdate != 3){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo generateImage(
							$arrayOfImages["redWarning"],
							$imageConfig = array(
								"id"			=>	"statusImage3",
								"height"		=>	"30px",
								"srcModifier"	=> ""
							)
						);
						?>
						&nbsp; Very Major Updates -
						<span id="veryMajorUpdatesVersionNumber">
							<?php echo " ".$configStatic['newestVersion']." ";?>
						</span>
						- a lot of new features!
					</h2>
					<a class="link" onclick="installUpdates('');">Install Update</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</span>
<span id="updateReleaseNotes" >
	<div id="releaseNotesHeader" <?php if($levelOfUpdate == 0){echo "style='display: none;'";} ?> class="settingsHeader">
		Release Notes
	</div>
	<div id="releaseNotesBody" <?php if($levelOfUpdate == 0){echo "style='display: none;'";} ?> class="settingsDiv" >
		<ul class="settingsUl">
		<?php
		if(array_key_exists('versionList', $configStatic))
		{
			foreach ($configStatic['versionList'] as $key => $value)
			{
				$version = explode('.', $configStatic['version']);
				$newestVersion = explode('.', $key);
				$levelOfUpdate = findUpdateValue(count($newestVersion), count($version), $newestVersion, $version);
				if($levelOfUpdate != 0)
				{
					echo "<li><h2>Changelog For ".$key." update</h2></li>";
					echo $value['releaseNotes'];
				}
			}
		}
		?>
		</ul>
	</div>
</span>

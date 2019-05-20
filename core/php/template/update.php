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
			<?php else:

				$changelogHTML = "";
				$downloadSize = 0;
				$finalInstallSize = 0;
				$currentVersionSize = 0;
				$totalDiff = "";

				if(array_key_exists('versionList', $configStatic))
				{
					foreach ($configStatic['versionList'] as $key => $value)
					{
						if($configStatic['version'] === $key)
						{
							if(isset($value['installSize']))
							{
								$currentVersionSize = (int)$value['installSize'];
							}
						}
						$version = explode('.', $configStatic['version']);
						$newestVersion = explode('.', $key);
						$levelOfUpdate = $update->findUpdateValue(count($newestVersion), count($version), $newestVersion, $version);
						if($levelOfUpdate != 0)
						{
							$changelogHTML .= "<li><h2>Changelog For ".$key." update</h2></li>";
							$changelogHTML .=  $value['releaseNotes'];
							if(isset($value['downloadSize']))
							{
								$downloadSize += (int)$value['downloadSize'];
								$finalInstallSize = (int)$value['installSize'];
							}
						}
					}
					if($finalInstallSize > $currentVersionSize)
					{
					  $totalDiff = "take up an additional ~".$update->formatBytes($finalInstallSize - $currentVersionSize);
					}
					else
					{
					  $totalDiff = "free up ~".$update->formatBytes($currentVersionSize - $finalInstallSize);
					}
				}
				?>
				<li>
					<h2>You last checked for updates
						<span id="spanNumOfDaysUpdateSince" >
							<a onclick="checkForUpdates('');"> <?php echo $daysSince;?> Day<?php if($daysSince != 1){ echo "s";} ?></a>
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
				<li style="display: none;" id="loadingSpinnerForInstallUpdate">
					<?php
						echo $core->generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"id"			=>	"statusImage0",
								"height"		=>	"15px",
								"class"			=>	"updateImg",
								"data-src"		=>	$arrayOfImages["loading"]
							)
						);
						?>
					Loading ...
				</li>
				<li id="noUpdate" <?php if($levelOfUpdate != 0){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo $core->generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"id"			=>	"statusImage1",
								"height"		=>	"15px",
								"class"			=>	"updateImg",
								"data-src"		=>	$arrayOfImages["greenCheck"]
							)
						);
						?>
						&nbsp; No new updates - You are on the current version!
					</h2>
				</li>
				<li id="minorUpdate" <?php if($levelOfUpdate != 1){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo $core->generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"id"			=>	"statusImage2",
								"height"		=>	"15px",
								"class"			=>	"updateImg",
								"data-src"		=>	$arrayOfImages["yellowWarning"]
							)
						);
						?>
						&nbsp; Minor Updates -
						<span id="minorUpdatesVersionNumber">
							<?php echo " ".$configStatic['newestVersion']." ";?>
						</span>
						- bug fixes
					</h2>
					<a class="link" onclick="installUpdates('','settingsInstallUpdate','');">Install Update</a>
				</li>
				<li id="majorUpdate" <?php if($levelOfUpdate != 2){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo $core->generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"id"			=>	"statusImage3",
								"height"		=>	"15px",
								"class"			=>	"updateImg",
								"data-src"		=>	$arrayOfImages["redWarning"]
							)
						);
						?>
						&nbsp; Major Updates -
						<span id="majorUpdatesVersionNumber">
							<?php echo " ".$configStatic['newestVersion']." ";?>
						</span>
						- new features!</h2>
						<a class="link" onclick="installUpdates('','settingsInstallUpdate','');">Install Update</a>
				</li>
				<li id="NewXReleaseUpdate" <?php if($levelOfUpdate != 3){echo "style='display: none;'";} ?> >
					<h2>
						<?php
						echo $core->generateImage(
							$arrayOfImages["loadingImg"],
							$imageConfig = array(
								"id"			=>	"statusImage3",
								"height"		=>	"30px",
								"class"			=>	"updateImg",
								"data-src"		=>	$arrayOfImages["redWarning"]
							)
						);
						?>
						&nbsp; Very Major Updates -
						<span id="veryMajorUpdatesVersionNumber">
							<?php echo " ".$configStatic['newestVersion']." ";?>
						</span>
						- a lot of new features!
					</h2>
					<a class="link" onclick="installUpdates('','settingsInstallUpdate','');">Install Update</a>
				</li>
				<li id="installData" <?php if($levelOfUpdate == 0){echo "style='display: none;'";} ?> >
					This will download ~<b id="installDataDownloadSize" ><?php echo $update->formatBytes($downloadSize);?></b> of data <br>
					The new install will <b id="installDataTotalChange"><?php echo $totalDiff;?></b> of space<br>
					The current drive has <b id="installDataCurrentFree"><?php echo shell_exec("df -h . | tail -1 | awk '{print $4}'"); ?></b> free space
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
		<?php echo $changelogHTML; ?>
		</ul>
	</div>
</span>
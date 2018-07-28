<div class="settingsHeader">
	Changelog
</div>
<div class="settingsDiv" >
	<ul class="settingsUl">
		<li>
			<h2>Changelog</h2>
		</li>
		<?php
		$versionList = array_reverse($configStatic["versionList"]);
		foreach ($versionList as $versionKey => $versionValue): ?>
			<li>
				<?php echo $versionKey;
					if($configStatic["version"] === $versionKey)
					{
						echo " [Current Version]";
					}
				echo $versionValue["releaseNotes"]; ?>
			</li>
		<?php endforeach;?>
		<li>
			2.0:49
			<ul>
				<li>
					Changed directory structure
				</li>
				<li>
					Added settings page
				</li>
				<li>
					Added upgrade page
				</li>
			</ul>
		</li>
		<li>
			1.3:14
			<ul>
				<li>
					Added Un-pause on focus
				</li>
				<li>
					Dynamic title of page (reflects status of paused and refreshing)
				</li>
			</ul>
		</li>
		<li>
			1.2:10
			<ul>
				<li>
					Added Refresh button
				</li>
			</ul>
		</li>
		<li>
			1.1:7
			<ul>
				<li>
					Added Pause / Play button
				</li>
			</ul>
		</li>
		<li>
			1.0:5
			<ul>
				<li>
					Initial Forked version from craig-russell
				</li>
			</ul>
		</li>
	</ul>
</div>
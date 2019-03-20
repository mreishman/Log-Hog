<span id="aboutSpanAbout" >
	<div class="settingsHeader">
		About
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<h2>
					<?php echo generateImage(
						$arrayOfImages["loadingImg"],
						$imageConfig = array(
							"class"			=>	"mainMenuImage",
							"style"			=>	"margin-bottom: -40px;",
							"data-src"		=>	"core/img/LogHog.png",
							"width"			=>	"100px",
							"srcModifier"	=>	$otherPageImageModifier
						)
					); ?>
					Version - <?php echo $configStatic['version'];?>
				</h2>
			</li>
		</ul>
	</div>
</span>
<span id="aboutSpanInfo" >
	<div class="settingsHeader">
		Info
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<h2>Log-Hog</h2>
			</li>
			<li>
				<p>A simple log monitoring tool that is intended for use on dev boxes.</p>

				<p>If you need Log Hog to watch Apache's logs, see this: <a href="https://stackoverflow.com/questions/9568118/apache-access-log-automatically-set-permissions">https://stackoverflow.com/questions/9568118/apache-access-log-automatically-set-permissions</a></p>
			</li>
			<li>
				<p>Includes files from the following project: </p>

				<p> <a href="https://github.com/ai/visibilityjs">https://github.com/ai/visibilityjs </a> </p>

				<p> <a href="https://loading.io/progress/">https://loading.io/progress/</a></p>
			</li>
		</ul>
	</div>
</span>
<span id="aboutSpanGithub" >
	<div class="settingsHeader">
		GitHub
	</div>
	<div class="settingsDiv" >
		<ul class="settingsUl">
			<li>
				<h2>Github</h2>
			</li>
			<li>
				<p>View the project on github: <a href="https://github.com/mreishman/Log-Hog">https://github.com/mreishman/Log-Hog</a> </p>

				<p>Add an issue: <a href="https://github.com/mreishman/Log-Hog/issues">https://github.com/mreishman/Log-Hog/issues</a></p>
			</li>
		</ul>
	</div>
</span>
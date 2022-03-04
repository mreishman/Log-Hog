<?php
$versionFound = isset($configStatic["versionList"][$configStatic["version"]]);

$arrOfMainVersionNumbers = [];
$sortedVersions = [];

$versionList = array_reverse($configStatic["versionList"]);

$found = false;
foreach ($versionList as $versionKey => $versionValue)
{ 
	if(!$found && $configStatic["version"] !== $versionKey && $versionFound)
	{
		continue;
	}
	$found = true;

	$id = explode(".", $versionKey)[0];
	if (!in_array($id, $arrOfMainVersionNumbers))
	{
		$arrOfMainVersionNumbers[] = $id;
		$versionValue["idForHeader"] = "changeLogMainVersionNumber".$id;
	}

	$sortedVersions[$versionKey] = $versionValue;
}

$sortedVersions["2.0"] = array(
	"releaseNotes"	=> "<ul><li>Changed directory structure</li><li>Added settings page</li><li>Added upgrade page</li></ul>",
	"commits"		=> 49,
	"date"			=> "03/10/2017",
	"title"			=> "The Updating Update"
);

$sortedVersions["1.3"] = array(
	"releaseNotes"	=> "<ul><li>Added Un-pause on focus</li><li>Dynamic title of page (reflects status of paused and refreshing)</li></ul>",
	"idForHeader"	=> "changeLogMainVersionNumber1",
	"commits"		=> 14,
	"date"			=> "03/06/2017",
	"title"			=> "Github Release"
);

$sortedVersions["1.2"] = array(
	"releaseNotes"	=> "<ul><li>Added Refresh button</li></ul>",
	"commits"		=> 10
);

$sortedVersions["1.1"] = array(
	"releaseNotes"	=> "<ul><li>Added Pause / Play button</li></ul>",
	"commits"		=> 7
);

$sortedVersions["1.0"] = array(
	"releaseNotes"	=> "<ul><li>Initial Forked version from craig-russell</li></ul>",
	"commits"		=> 5
);

$arrOfMainVersionNumbers[] = 1;

?>
<span id="aboutSpanChangelog">
	<div class="settingsHeader">
		Changelog
		<div class="settingsHeaderButtons">
			<?php foreach($arrOfMainVersionNumbers as $versionId): ?>
				<a class="linkSmall" href="#changeLogMainVersionNumber<?php echo $versionId; ?>"><?php echo $versionId; ?>.X</a>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="settingsDiv" >
		<?php if(!$versionFound):?>
			<li><h2>Notice: Current version of Log-Hog is not in changelog. Showing all versions in changelog</h2></li>
		<?php
		endif;
		foreach ($sortedVersions as $versionKey => $versionValue):
			$id = "";
			if (isset($versionValue["idForHeader"])) {
				$id = "id=\"" . $versionValue["idForHeader"] . "\"";
			}
			?>
			<div <?php echo $id; ?> class="settingsHeader">
				<?php echo $versionKey; ?>
				<?php
					if (isset($versionValue["title"]))
					{
						echo "(" . $versionValue["title"] . ")";
					}
					?>
				<div class="settingsHeaderButtons">
					<?php
					if (isset($versionValue["date"]))
					{
						echo "Release Date: " . $versionValue["date"] . " ";
					}
					if (isset($versionValue["commits"]))
					{
						echo "Commit: " . $versionValue["commits"];
					}
					?>
				</div>
			</div>
			<div class="settingsDiv"><?php echo $versionValue["releaseNotes"]; ?></div>
		<?php endforeach;?>
	</div>
</span>
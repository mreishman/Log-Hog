<?php

if (!isset($gallery))
{
	require_once($core->baseURL()."core/php/gallery.php");
	$gallery = new gallery();
}

$versionFound = isset($configStatic["versionList"][$configStatic["version"]]);

$dataForImages = json_decode(file_get_contents($core->baseURL()."core/json/whatsNew.json"), true);
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

	if (isset($dataForImages[$versionKey]))
	{
		$versionValue["Images"] = $dataForImages[$versionKey]["Images"];
	}

	$sortedVersions[$versionKey] = $versionValue;
}

$oldChangelog = json_decode(file_get_contents($core->baseURL()."core/json/oldChangelog.json"), true);
$sortedVersions = array_merge($sortedVersions, $oldChangelog);
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
					} ?>
				</div>
			</div>
			<div class="settingsDiv">
				<?php echo $versionValue["releaseNotes"]; ?>
				<?php if (isset($versionValue["Images"])): 
					$imageData = [];
					foreach ($versionValue["Images"] as $IMGValue)
					{
						$imageData[] = array(
							"src"	=> $otherPageImageModifier."core/img/".$IMGValue,
							"image" => $core->generateImage(
								$arrayOfImages["loadingImg"],
								array(
									"class"			=>	"whatsNewImage",
									"height"		=>  "157px",
									"data-src"		=>	array(
										"src"			=> "core/img/".$IMGValue,
										"alt"			=> $versionKey. " Image",
										"title"			=> $versionKey. " Image"
										),
									"srcModifier"	=>	$otherPageImageModifier
									)
								)
						);
					}

					?>
					<div style="overflow:auto;">
						<table width="440px"  align="left">
					        <tr>
					        	<?php echo $gallery->generateGallery(
					                $imageData,
					                array(
					                    "imgHeight" =>  "157",
					                    "tag"       =>  "th",
					                    "class" => "whatsNewImage"
					                )
					            ); ?>
					        </tr>
					    </table>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach;?>
	</div>
</span>
<?php 

$id = $sidebarItem["id"] ?? "";
$onClick = $sidebarItem["onClick"] ?? "";
$style = $sidebarItem["style"] ?? "";
$class = $sidebarItem["class"] ?? "";
$visible = $sidebarItem["visible"] ?? "true";

if ($visible !== "true")
{
	$style .=" display: none; ";
}

if ($id !== "")
{
	$id = "id=\"" . $id . "\"";
}
if ($onClick !== "")
{
	$onClick = "onclick=\"" . $onClick . "\"";
}
if ($style !== "")
{
	$style = "style=\"" . $style . "\"";
}
if ($class !== "")
{
	$class = "class=\"" . $class . "\"";
}

if($sidebarItem["type"] === 1): ?>
	<a <?php echo $id . " " . $onClick . " " . $style . " " . $class ?> >
		<?php echo $sidebarItem["content"]; ?>
	</a>
<?php endif; ?>	
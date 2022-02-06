<?php 

$id = $sidebarItem["id"] ?? "";
$onClick = $sidebarItem["onClick"] ?? "";
$style = $sidebarItem["style"] ?? "";
$class = $sidebarItem["class"] ?? "";

if ($sidebarItem["visible"] !== "true")
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

if($sidebarItem["type"] === "image"): ?>
	<a <?php echo $id . " " . $onClick . " " . $style . " " . $class ?> >
		<?php echo $sidebarItem["image"]; ?>
	</a>
<?php endif; ?>	
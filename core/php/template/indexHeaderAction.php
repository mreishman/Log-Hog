<?php
$onClick = $headerItem["onClick"] ?? "";
$class = $headerItem["class"] ?? "";
$id = $headerItem["id"] ?? "";
$style = $headerItem["style"] ?? "";

if ($headerItem["visible"] !== "true")
{
	$style .=" display: none; ";
}

if ($onClick !== "")
{
	$onClick = "onclick=\"" . $onClick . "\"";
}
if ($class !== "")
{
	$class = "class=\"" . $class . "\"";
}
if ($id !== "")
{
	$id = "id=\"" . $id . "\"";
}
if ($style !== "")
{
	$style = "style=\"" . $style . "\"";
}

?>
<div <?php echo $onClick . " " . $class . " " . $id . " " . $style; ?> >
	<?php echo $headerItem["image"];	?>
</div>
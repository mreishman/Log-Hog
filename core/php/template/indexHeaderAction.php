<?php

$onClick = $headerItem["onClick"] ?? "";
$class = $headerItem["class"] ?? "";
$id = $headerItem["id"] ?? "";
$style = $headerItem["style"] ?? "";
$visible = $headerItem["visible"] ?? "true";
$type = $headerItem["type"] ?? 1;

$outerClass = $headerItem["outerClass"] ?? "";
$outerId = $headerItem["outerId"] ?? "";
$outerStyle = $headerItem["style"] ?? "";
$outerVisible = $headerItem["outerVisible"] ?? "true";

if ($visible !== "true")
{
	$style .=" display: none; ";
}
if ($outerVisible !== "true")
{
	$outerStyle .=" display: none; ";
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

if ($outerId !== "")
{
	$outerId = "id=\"" . $outerId . "\"";
}
if ($outerStyle !== "")
{
	$outerStyle = "style=\"" . $outerStyle . "\"";
}

$outerType = "span";
$innerType = "span";
if ($type === 4 || $type === 5)
{
	$outerType = "div";
}
if ($type === 2 || $type === 5)
{
	$innerType = "div";
}

if ($type >= 2 && $type <= 5):
	echo "<" . $outerType . " " . $outerId . " " . $outerStyle. " >";
		echo "<" . $innerType . " " . $onClick . " " . $class . " " . $id . " " . $style . " >";
			echo $headerItem["content"];
		echo "</" . $innerType . ">";
	echo "</" . $outerType . ">";
else: ?>
	<div <?php echo $onClick . " " . $class . " " . $id . " " . $style; ?> >
		<?php echo $headerItem["content"];	?>
	</div>
<?php endif; ?>	
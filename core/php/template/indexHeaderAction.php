<?php

$onClick = $headerItem["onClick"] ?? "";
$class = $headerItem["class"] ?? "";
$id = $headerItem["id"] ?? "";
$style = $headerItem["style"] ?? "";
$visible = $headerItem["visible"] ?? "true";

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

if($headerItem["type"] === 1): ?>
	<div <?php echo $onClick . " " . $class . " " . $id . " " . $style; ?> >
		<?php echo $headerItem["content"];	?>
	</div>
<?php elseif ($headerItem["type"] === 2): ?>
	<span <?php echo $outerId . " " . $outerStyle; ?> >
		<div <?php echo $onClick . " " . $class . " " . $id . " " . $style; ?> >
			<?php echo $headerItem["content"];	?>
		</div>
	</span>
<?php elseif ($headerItem["type"] === 3): ?>
	<span <?php echo $outerClass . " " . $outerStyle; ?> >
		<span <?php echo $onClick . " " . $class . " " . $id . " " . $style; ?> >
			<?php echo $headerItem["content"];	?>
		</span>
	</span> 
<?php endif; ?>	
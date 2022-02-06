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

if($headerItem["type"] === 1): ?>
	<div <?php echo $onClick . " " . $class . " " . $id . " " . $style; ?> >
		<?php echo $headerItem["content"];	?>
	</div>
<?php elseif ($headerItem["type"] === 2): 

	$outerId = $headerItem["outerId"] ?? "";
	$outerStyle = $headerItem["style"] ?? "";
	
	if ($headerItem["outerVisible"] !== "true")
	{
		$outerStyle .=" display: none; ";
	}

	if ($outerId !== "")
	{
		$outerId = "id=\"" . $outerId . "\"";
	}
	if ($outerStyle !== "")
	{
		$outerStyle = "style=\"" . $outerStyle . "\"";
	}

	?>
	<span <?php echo $outerId . " " . $outerStyle; ?> >
		<div <?php echo $onClick . " " . $class . " " . $id . " " . $style; ?> >
			<?php echo $headerItem["content"];	?>
		</div>
	</span>
<?php endif; ?>	
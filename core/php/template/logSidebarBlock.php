<?php 

$style = $sidebarItem['style'] ?? "";
$onClick = $sidebarItem['onClick'] ?? "";

if ($sidebarItem['visible'] !== 'true')
{
	$style .=" display: none; ";
}


if ($style !== "")
{
	$style = "style=\"" . $style . "\"";
}
if ($onClick !== "")
{
	$onClick = "onclick=\"" . $onClick . "\"";
}

if($sidebarItem['type'] === 'image'): ?>
	<a id="<?php echo $sidebarItem['id']; ?>" <?php echo $onClick; ?> <?php echo $style?> >
	<?php echo $sidebarItem['image']; ?>
</a>
<?php endif; ?>	
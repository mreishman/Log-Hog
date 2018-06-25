<!-- Js Vars -->
<script type="text/javascript">
<?php
foreach ($defaultConfig as $key => $value)
{
	if(
		$$key !== $defaultConfig[$key] &&
		(
			!isset($themeDefaultSettings) ||
			isset($themeDefaultSettings) && !array_key_exists($key, $themeDefaultSettings) ||
			isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
		)
		||
		$$key === $defaultConfig[$key] && isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
		||
		isset($arrayOfCustomConfig[$key])
	)
	{
		echo putIntoCorrectJSFormat($key, $$key, $value);
	}
}
?>
</script>
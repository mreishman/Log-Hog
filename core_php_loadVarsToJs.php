<!-- Js Vars -->
<script type="text/javascript">
<?php
foreach ($defaultConfig as $key => $value)
{
	echo $core->putIntoCorrectJSFormat($key, $$key, $value);
}
?>
</script>
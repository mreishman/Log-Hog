<!-- Js Vars -->
<script type="text/javascript">
<?php
foreach ($defaultConfig as $key => $value)
{
	echo putIntoCorrectJSFormat($key, $$key, $value);
}
?>
</script>
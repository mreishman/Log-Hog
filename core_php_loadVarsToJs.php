<!-- Js Vars -->
<script type="text/javascript">
<?php
foreach ($defaultConfig as $key => $value): ?>
	if(typeof(<?php echo $key; ?>) === 'undefined')
	{
		<?php echo $core->putIntoCorrectJSFormat($key, $$key, $value); ?>
	}
	else
	{
		<?php echo $core->putIntoCorrectJSFormat($key, $$key, $value, false); ?>
	}
<?php endforeach;
foreach ($defaultGlobalConfig as $key => $value): ?>
	if(typeof(<?php echo $key; ?>) === 'undefined')
	{
		<?php echo $core->putIntoCorrectJSFormat($key, $$key, $value); ?>
	}
	else
	{
		<?php echo $core->putIntoCorrectJSFormat($key, $$key, $value, false); ?>
	}
<?php endforeach; ?>

</script>
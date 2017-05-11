<?php
`screen  -d -m -S htop_session htop`;
sleep(5);
`screen -p 0 -S htop_session -X hardcopy`;
`screen -p 0 -S htop_session -X quit`;
?>
<pre>
<?php print file_get_contents('hardcopy.0'); ?>
</pre>
<script type="text/javascript">
	location.reload();
</script>
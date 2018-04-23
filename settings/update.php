<?php
header("Location: "."../index.php", true, 302); /* Redirect browser */
exit();
/* NOTES BELOW FOR MOVE, DELETE WHEN WORKS */
?>
<script type="text/javascript">
	var timeoutVar;
	var dataFromJSON;
	var currentVersion = "<?php echo $configStatic['version']?>";
	var updateFromID = "settingsInstallUpdate";
</script>
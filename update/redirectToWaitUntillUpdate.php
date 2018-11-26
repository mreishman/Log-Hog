<?php $cssVersion = date("YmdHis"); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Waiting for update check...</title>
	<link rel="stylesheet" type="text/css" href="../core/template/theme.css">
	<link rel="stylesheet" type="text/css" href="../core/template/base.css">
	<script src="../core/js/jquery.js"></script>
	<script src="../core/js/redirectToWaitUntillUpdate.js?v=<?php echo $cssVersion?>"></script>
</head>
<body>
<?php require_once("../core/php/template/popup.php"); ?>
</body>
</html>
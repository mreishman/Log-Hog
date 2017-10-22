<?php
require_once('../core/php/commonFunctions.php');

$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');
require_once('../core/php/updateCheck.php');
?>
<!doctype html>
<head>
	<title>Settings | Addons</title>
	<?php echo loadCSS($baseUrl, $cssVersion);?>
	<link rel="icon" type="image/png" href="../core/img/favicon.png" />
	<script src="../core/js/jquery.js"></script>
</head>
<body>
	<?php require_once('header.php'); ?>
	<div id="main">
		<div class="settingsHeader">
			Addons
		</div>
		<div class="settingsDiv" >
			<ul id="settingsUl">
				<li>
					<?php if(is_file("../monitor/index.php") === true): ?>
						<script type="text/javascript">
							var monitorRemove = "monitorRemove";
						</script>
						<form id="monitorRemove" action="addonAction.php" method="post">
							<input type="hidden" name="localFolderLocation" value="monitor"> 
							<input type="hidden" name="repoName" value="Monitor">
							<input type="hidden" name="action" value="Removing">
						</form>
						<a onclick="addonMonitorAction(monitorRemove);" class="link">Remove Monitor</a>
					<?php else: ?>
						<script type="text/javascript">
							var monitorDownload = "monitorDownload";
						</script>
						<form id="monitorDownload" action="addonAction.php" method="post">
							<input type="hidden" name="localFolderLocation" value="monitor"> 
							<input type="hidden" name="repoName" value="Monitor">
							<input type="hidden" name="action" value="Downloading">
						</form>
						<a onclick="addonMonitorAction(monitorDownload);" class="link">Download Monitor</a>
					<?php endif; ?>
				</li>
				<li>
					<?php if(is_file("../search/index.php") === true): ?>
						<script type="text/javascript">
							var searchRemove = "searchRemove";
						</script>
						<form id="searchRemove" action="addonAction.php" method="post">
							<input type="hidden" name="localFolderLocation" value="search"> 
							<input type="hidden" name="repoName" value="Search">
							<input type="hidden" name="action" value="Removing">
						</form>
					<a onclick="addonMonitorAction(searchRemove);" class="link">Remove Search</a>
					<?php else: ?>
						<script type="text/javascript">
							var searchDownload = "searchDownload";
						</script>
						<form id="searchDownload" action="addonAction.php" method="post">
							<input type="hidden" name="localFolderLocation" value="search"> 
							<input type="hidden" name="repoName" value="Search">
							<input type="hidden" name="action" value="Downloading">
						</form>
						<a onclick="addonMonitorAction(searchDownload);" class="link">Download Search</a>
					<?php endif; ?>
				</li>
			</ul>
		</div>
	</div>
</body>
<script type="text/javascript">
	function goToUrl(url)
	{
		window.location.href = url;
	}

	function addonMonitorAction(idToSubmit)
{
	document.getElementById(idToSubmit).submit();
}
</script>
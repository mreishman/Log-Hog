<?php

function filePermsDisplay($key)
{
	$info = "u---------";
	if(file_exists($key))
	{
		$perms  =  fileperms($key);

		switch ($perms & 0xF000) {
		    case 0xC000: // socket
		        $info = 's';
		        break;
		    case 0xA000: // symbolic link
		        $info = 'l';
		        break;
		    case 0x8000: // regular
		        $info = 'f';
		        break;
		    case 0x6000: // block special
		        $info = 'b';
		        break;
		    case 0x4000: // directory
		        $info = 'd';
		        break;
		    case 0x2000: // character special
		        $info = 'c';
		        break;
		    case 0x1000: // FIFO pipe
		        $info = 'p';
		        break;
		    default: // unknown
		        $info = 'u';
		}

		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
		            (($perms & 0x0800) ? 's' : 'x' ) :
		            (($perms & 0x0800) ? 'S' : '-'));

		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
		            (($perms & 0x0400) ? 's' : 'x' ) :
		            (($perms & 0x0400) ? 'S' : '-'));

		// World
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
		            (($perms & 0x0200) ? 't' : 'x' ) :
		            (($perms & 0x0200) ? 'T' : '-'));
	}
	return $info;
}

function loadSentryData($sendCrashInfoJS)
{
	$sentryInfo = "";
	if($sendCrashInfoJS === "true")
	{
		$sentryInfo =  "<script src=\"https://cdn.ravenjs.com/3.17.0/raven.min.js\" crossorigin=\"anonymous\"></script>
	<script type=\"text/javascript\">
		Raven.config(\"https://2e455acb0e7a4f8b964b9b65b60743ed@sentry.io/205980\", {
		    release: \"3.0\"
		}).install();
	</script>";
	}
	return $sentryInfo;
}

function customCSS($currentColorValue)
{
	$customCSS = "
	<style type=\"text/css\">
	#menu a, .link, .linkSmall, .context-menu{
		background-color: ".$currentColorValue.";
	}
	</style>";
	return $customCSS;
}

function baseURL()
{
	$baseURL = "";
	$boolBaseURL = file_exists($baseURL."error.php");
	while(!$boolBaseURL)
	{
		$baseURL .= "../";
		$boolBaseURL = file_exists($baseURL."error.php");
	}
	return $baseURL;
}

function clean_url($url)
{
    $parts = parse_url($url);
    return $parts['path'];
}

function loadCSS($baseUrl, $version)
{
	return "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$baseUrl."template/theme.css?v=".$version."\">";
}

function loadVisibilityJS($baseURL)
{
	return "<script src=\"".$baseURL."core/js/visibility.core.js\"></script>
	<script src=\"".$baseURL."core/js/visibility.fallback.js\"></script>
	<script src=\"".$baseURL."core/js/visibility.js\"></script>
	<script src=\"".$baseURL."core/js/visibility.timers.js\"></script>";
}

function calcuateDaysSince($lastCheck)
{
	$today = date('Y-m-d');
	$old_date = $lastCheck;
	$old_date_array = preg_split("/-/", $old_date);
	$old_date = $old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1];

	$datetime1 = date_create($old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1]);
	$datetime2 = date_create($today);
	$interval = date_diff($datetime1, $datetime2);
	return $interval->format('%a');
}

/*

$baseUrl = "../core/";
if(file_exists('../local/layout.php'))
{
	$baseUrl = "../local/";
	//there is custom information, use this
	require_once('../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('../core/conf/config.php');
require_once('../core/php/configStatic.php');
require_once('../core/php/loadVars.php');

*/
?>
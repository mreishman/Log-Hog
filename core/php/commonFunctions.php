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

function loadSentryData($sendCrashInfoJS, $branchSelected)
{
	if($sendCrashInfoJS === "true")
	{
		include(baseURL()."core/php/configStatic.php");
		$versionForSentry = $configStatic["version"];
		$returnString =  "
		<script src=\"https://cdn.ravenjs.com/3.17.0/raven.min.js\" crossorigin=\"anonymous\"></script>
		<script type=\"text/javascript\">
		Raven.config(\"https://2e455acb0e7a4f8b964b9b65b60743ed@sentry.io/205980\", {
		    release: \"".$versionForSentry."\"
		}).install();

		function eventThrowException(e)
		{
			Raven.captureException(e);
			";
			if($branchSelected === 'beta')
			{
				$returnString .= "
					Raven.showReportDialog();
				";
			}

		$returnString .= "}

		</script>";
	}
	return "
	<script>

		function eventThrowException(e)
		{
			//this would send errors, but it is disabled
		}

	</script>";
}

function baseURL()
{
	$tmpFuncBaseURL = "";
	$boolBaseURL = file_exists($tmpFuncBaseURL."error.php");
	while(!$boolBaseURL)
	{
		$tmpFuncBaseURL .= "../";
		$boolBaseURL = file_exists($tmpFuncBaseURL."error.php");
	}
	return $tmpFuncBaseURL;
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

function findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version)
{
	for($i = 0; $i < $newestVersionCount; $i++)
	{
		if($i < $versionCount)
		{
			if($i == 0)
			{
				if($newestVersion[$i] > $version[$i])
				{
					return 3;
				}
				elseif($newestVersion[$i] < $version[$i])
				{
					break;
				}
			}
			elseif($i == 1)
			{
				if($newestVersion[$i] > $version[$i])
				{
					return 2;
				}
				elseif($newestVersion[$i] < $version[$i])
				{
					break;
				}
			}
			else
			{
				if(isset($newestVersion[$i]))
				{
					if($newestVersion[$i] > $version[$i])
					{
						return 1;
					}
					elseif($newestVersion[$i] < $version[$i])
					{
						break;
					}
				}
				else
				{
					break;
				}
			}
		}
		else
		{
			return 1;
		}
	}
	return 0;
}
?>
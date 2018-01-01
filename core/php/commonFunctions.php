<?php

function filePermsDisplay($key)
{
	$info = "u---------";
	if(file_exists($key))
	{
		$info = returnActualFilePerms($key);
	}
	return $info;
}

function returnActualFilePerms($key)
{
	$perms  =  fileperms($key);

	switch ($perms & 0xF000)
	{
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

	$filePermsArray = array(
		"Owner" => array(
			"Read"		=> array(
				"Boolval"	=> ($perms & 0x0100)
			),
			"Write"		=> array(
				"Boolval"	=>	($perms & 0x0080)
			),
			"Execute"	=> array(
				"Boolval"	=>	($perms & 0x0040),
				"Boolval2"	=>	($perms & 0x0800)
			)
		),
		"Group" => array(
			"Read"		=> array(
				"Boolval"	=> ($perms & 0x0020)
			),
			"Write"		=> array(
				"Boolval"	=>	($perms & 0x0010)
			),
			"Execute"	=> array(
				"Boolval"	=>	($perms & 0x0008),
				"Boolval2"	=>	($perms & 0x0400)
			)
		),
		"Owner" => array(
			"Read"		=> array(
				"Boolval"	=> ($perms & 0x0004)
			),
			"Write"		=> array(
				"Boolval"	=>	($perms & 0x0002)
			),
			"Execute"	=> array(
				"Boolval"	=>	($perms & 0x0001),
				"Boolval2"	=>	($perms & 0x0200)
			)
		),
	);

	foreach ($filePermsArray as $key => $value)
	{
		$info .= evaluateBool(
			$value["Read"]["Boolval"],
			"r",
			"-"
		);
		$info .= evaluateBool(
			$value["Write"]["Boolval"],
			"w",
			"-"
		);
		$info .= evaluateBool(
			$value["Execute"]["Boolval"],
			evaluateBool(
				$value["Execute"]["Boolval2"],
				"s",
				"x"
			),
			evaluateBool(
				$value["Execute"]["Boolval2"],
				"S",
				"-"
			)
		);
	}
	return $info;
}

function evaluateBool($boolVal, $trueVal, $falseVal)
{
	if($boolVal)
	{
		return $trueVal;
	}
	return $falseVal;
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
			if($branchSelected === 'dev' || $branchSelected === 'beta')
			{
				$returnString .= "	console.log(e);";
			}

		$returnString .= "}

		</script>";
	}
	return "
	<script>

		function eventThrowException(e)
		{
			//this would send errors, but it is disabled
			console.log(e);
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
			if(isset($newestVersion[$i]) && $newestVersion[$i] !== $version[$i])
			{
				if($newestVersion[$i] > $version[$i])
				{
					$calcuation = 3-$i;
					return max(1, $calcuation);
				}
				break;
			}
			break;
		}
		return 1;
	}
	return 0;
}

function addResetButton($idOfForm)
{
	return "<a onclick=\"resetArrayObject('".$idOfForm."');\" id=\"".$idOfForm."ResetButton\" style=\"display: none;\" class=\"linkSmall\" > Reset Current Changes</a>";
}

function getFileSize($filename)
{
	$filename = preg_replace('/([()"])/S', '$1', $filename);
	return htmlentities(filesize($filename));
}

function trimLogLine($filename, $logSizeLimit,$logTrimMacBSD,$buffer)
{
	$lineCount = shell_exec('wc -l < ' . $filename);
	if($lineCount > ($logSizeLimit+$buffer))
	{
		trimLogInner($logTrimMacBSD,$filename,($lineCount - $logSizeLimit));
	}
}

function trimLogSize($filename, $logSizeLimit,$logTrimMacBSD,$buffer)
{
	$maxForLoop = 0;
	$trimFileBool = true;
	while ($trimFileBool && $maxForLoop < 10)
	{
		$filesizeForFile = shell_exec('wc -c < '.$filename);
		if($filesizeForFile > $logSizeLimit+$buffer)
		{
			$numOfLinesToRemoveTo = 2;
			if($filesizeForFile > (2*$logSizeLimit) && $maxForLoop < 2)
			{
				$lineCountForFile = shell_exec('wc -l < ' . $filename);
				$numOfLinesAllowed = 2*($logSizeLimit/($filesizeForFile/$lineCountForFile));
				$numOfLinesToRemoveTo = round($lineCountForFile - $numOfLinesAllowed);
			}

			trimLogInner($logTrimMacBSD,$filename,$numOfLinesToRemoveTo);
		}
		else
		{
			$trimFileBool = false;
		}
		$maxForLoop++;
	}
}

function trimLogInner($logTrimMacBSD,$filename,$lineEnd)
{
	if($logTrimMacBSD == "true")
	{
		shell_exec('sed -i "'.$filename.'" "1,' . $lineEnd . 'd" ' . $filename);
	}
	else
	{
		shell_exec('sed -i "1,' . $lineEnd . 'd" ' . $filename);
	}
}

function tail($filename, $sliceSize, $shellOrPhp)
{
	if($shellOrPhp == "true")
	{
		$data =  trim(tailCustom($filename, $sliceSize));
	}
	else
	{
		$data = trim(shell_exec('tail -n ' . $sliceSize . ' "' . $filename . '"'));
	}

	if($data === "" || is_null($data))
	{
		if($shellOrPhp == "true")
		{
			$data = trim(shell_exec('tail -n ' . $sliceSize . ' "' . $filename . '"'));
		}
		else
		{
			$data = trim(tailCustom($filename, $sliceSize));
		}

		if($data === "" || is_null($data))
		{
			$data = "Error - Maybe insufficient access to read file?";
		}
	}
	return $data;
}


/**
 * Slightly modified version of http://www.geekality.net/2011/05/28/php-tail-tackling-large-files/
 * @author Torleif Berger, Lorenzo Stanco
 * @link http://stackoverflow.com/a/15025877/995958
 * @license http://creativecommons.org/licenses/by/3.0/
 */
function tailCustom($filepath, $lines = 1, $adaptive = true)
{
	$fileOpened = @fopen($filepath, "rb");
	if($fileOpened === false)
	{
		return false;
	}
	if(!$adaptive)
	{
		$buffer = 4096;
	}
	else
	{
		$buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));
	}
	fseek($fileOpened, -1, SEEK_END);
	if(fread($fileOpened, 1) != "\n")
	{
		$lines -= 1;
	}

	$output = '';
	$chunk = '';
	while (ftell($fileOpened) > 0 && $lines >= 0)
	{
		$seek = min(ftell($fileOpened), $buffer);
		fseek($fileOpened, -$seek, SEEK_CUR);
		$output = ($chunk = fread($fileOpened, $seek)) . $output;
		fseek($fileOpened, -mb_strlen($chunk, '8bit'), SEEK_CUR);
		$lines -= substr_count($chunk, "\n");
	}
	while ($lines++ < 0)
	{
		$output = substr($output, strpos($output, "\n") + 1);
	}
	fclose($fileOpened);
	return trim($output);
}

function convertToSize($TrimSize, $logSizeLimit)
{
	if($TrimSize == "KB")
	{
		return $logSizeLimit * 1024;
	}
	elseif($TrimSize == "M")
	{
		return $logSizeLimit * (1000 * 1000);
	}
	elseif($TrimSize == "MB")
	{
		return $logSizeLimit * (1024 * 1024);
	}
	
	return $logSizeLimit * 1000;
}

function getCookieRedirect()
{
	$urlRedirectValue = "";
	if(isset($_COOKIE["locationRedirectLogHogUpgrade"]) && $_COOKIE["locationRedirectLogHogUpgrade"] !== "")
	{
		$urlRedirectValue =  $_COOKIE["locationRedirectLogHogUpgrade"];
	}
	if($urlRedirectValue !== null && $urlRedirectValue !== "" && strpos($urlRedirectValue, "settingsSaveAjax"))
	{
		return $urlRedirectValue;
	}
	$urlRedirectValue = $_SERVER['HTTP_REFERER'];
	return $urlRedirectValue;
}

function setCookieRedirect()
{
	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	while (isset($_COOKIE["locationRedirectLogHogUpgrade"]))
	{
		unset($_COOKIE["locationRedirectLogHogUpgrade"]);
	}
	setcookie("locationRedirectLogHogUpgrade",$actual_link, time()+3600);
}

function generateRestoreList($configStatic)
{
	$returnHtml = "<form id='revertForm' action='../restore/restore.php'  method='post'  style='display: inline-block;' ><select name='versionRevertTo' >";
	$versionList = $configStatic['versionList'];
	$versionListText = "";
	foreach ($versionList as $key => $value)
	{
		$versionListText = "<option value='".$value['branchName']."' >".$key."</option>".$versionListText;
	}
	$returnHtml .= $versionListText."</select></form>";
	return $returnHtml;
}

function generateImage($imageArray, $customConfig)
{
	$image = "<img ";
	if(isset($customConfig["data-id"]))
	{
		$image .=  " data-id=\"";
		$image .= $customConfig["data-id"];
		$image .= "\" ";
	}
	if(isset($customConfig["id"]))
	{
		$image .=  " id=\"";
		$image .= $customConfig["id"];
		$image .= "\" ";
	}
	if(isset($customConfig["class"]))
	{
		$image .= " class=\"";
		$image .= $customConfig["class"];
		$image .= "\" ";
	}
	$image .= " src=\"";
	if(isset($customConfig["srcModifier"]))
	{
		$image .= $customConfig["srcModifier"];
	}
	$image .= $imageArray["src"];
	$image .= "\" ";
	if(isset($customConfig["alt"]))
	{
		if($customConfig["alt"] !== null)
		{
			$image .= " alt=\"";
			$image .= $customConfig["alt"];
			$image .= "\" ";
		}
	}
	else
	{
		$image .= " alt=\"";
		$image .= $imageArray["alt"];
		$image .= "\" ";
	}
	if(isset($customConfig["title"]))
	{
		if($customConfig["title"] !== null)
		{
			$image .= " title=\"";
			$image .= $customConfig["title"];
			$image .= "\" ";
		}
	}
	else
	{
		$image .= " title=\"";
		$image .= $imageArray["title"];
		$image .= "\" ";
	}
	if(isset($customConfig["style"]))
	{
		$image .= " style=\"";
		$image .= $customConfig["style"];
		$image .= "\" ";
	}
	if(isset($customConfig["height"]))
	{
		$image .= " height=\"";
		$image .= $customConfig["height"];
		$image .= "\" ";
	}
	if(isset($customConfig["width"]))
	{
		$image .= " width=\"";
		$image .= $customConfig["width"];
		$image .= "\" ";
	}
	$image .= " >";
	return $image;
}
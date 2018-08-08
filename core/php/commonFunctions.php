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
	$returnString = "
	<script>

		function eventThrowException(e)
		{
			//this would send errors, but it is disabled
			console.log(e);
		}

	</script>";
	if($sendCrashInfoJS === "true")
	{
		include(baseURL()."core/php/configStatic.php");
		$versionForSentry = $configStatic["version"];
		$returnString =  "
		<script src=\"https://cdn.ravenjs.com/3.26.4/raven.min.js\" crossorigin=\"anonymous\"></script>
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
	return $returnString;
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

function loadCSS($base, $baseUrl, $version)
{
	$stringToReturn = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$baseUrl."template/theme.css?v=".$version."\">";
	$stringToReturn .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$base."core/template/base.css?v=".$version."\">";
	return $stringToReturn;
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
				if(intval($newestVersion[$i]) > intval($version[$i]))
				{
					$calcuation = 3-$i;
					return max(1, $calcuation);
				}
				break;
			}
		}
		else
		{
			return 1;
		}
	}
	return 0;
}

function addResetButton($idOfForm)
{
	return "<a onclick=\"resetArrayObject('".$idOfForm."');\" id=\"".$idOfForm."ResetButton\" style=\"display: none;\" class=\"linkSmall\" > Reset Current Changes</a>";
}

function getFileSize($filename, $shellOrPhp)
{
	$filename = preg_replace('/([()"])/S', '$1', $filename);
	$sof = getFileSizeInner($filename, $shellOrPhp);
	return htmlentities($sof);
}

function getFileSizeInner($fileName, $shellOrPhp)
{
	if($shellOrPhp === "phpPreferred" || $shellOrPhp ===  "phpOnly")
	{
		$fileSize = filesize($fileName);
		if(($fileSize === 0 || $fileSize === null) && $shellOrPhp === "phpPreferred")
		{
			$fileSize = shell_exec('wc -c < ' . $fileName);
		}
		return $fileSize;
	}
	$fileSize = shell_exec('wc -c < ' . $fileName);
	if(($fileSize === 0 || $fileSize === null) && $shellOrPhp === "shellPreferred")
	{
		$fileSize = filesize($fileName);
	}
	return $fileSize;
}

function trimLogLine($filename, $logSizeLimit,$logTrimMacBSD,$buffer, $shellOrPhp, $showErrorPhpFileOpen)
{
	$lineCount = getLineCount($filename, $shellOrPhp);
	if($lineCount > ($logSizeLimit+$buffer))
	{
		trimLogInner($logTrimMacBSD,$filename,($lineCount - $logSizeLimit), $shellOrPhp, $showErrorPhpFileOpen);
	}
}

function trimLogSize($filename, $logSizeLimit,$logTrimMacBSD,$buffer, $shellOrPhp, $showErrorPhpFileOpen)
{
	$maxForLoop = 0;
	$trimFileBool = true;
	while ($trimFileBool && $maxForLoop < 5)
	{
		$filesizeForFile = getFileSizeInner($filename, $shellOrPhp);
		if($filesizeForFile > $logSizeLimit+$buffer)
		{
			$numOfLinesToRemoveTo = 2;
			if($filesizeForFile > (2*$logSizeLimit) && $maxForLoop < 2)
			{
				$lineCountForFile = getLineCount($filename, $shellOrPhp);
				$numOfLinesAllowed = 2*($logSizeLimit/($filesizeForFile/$lineCountForFile));
				$numOfLinesToRemoveTo = round($lineCountForFile - $numOfLinesAllowed);
			}

			trimLogInner($logTrimMacBSD,$filename,$numOfLinesToRemoveTo, $shellOrPhp, $showErrorPhpFileOpen);
		}
		else
		{
			$trimFileBool = false;
		}
		$maxForLoop++;
	}
}

function trimLogInner($logTrimMacBSD,$filename,$lineEnd, $shellOrPhp, $showErrorPhpFileOpen)
{
	if($shellOrPhp === "phpPreferred" || $shellOrPhp ===  "phpOnly")
	{
		try
		{
			trimLogPhp($filename,$lineEnd, $showErrorPhpFileOpen);
			return;
		}
		catch (Exception $e)
		{
			if($shellOrPhp === "phpPreferred")
			{
				try
				{
					trimLogShell($logTrimMacBSD,$filename,$lineEnd);
				}
				catch (Exception $e){}
				return;
			}
		}
	}
	try
	{
		trimLogShell($logTrimMacBSD,$filename,$lineEnd);
		return;
	}
	catch (Exception $e)
	{
		try
		{
			trimLogPhp($filename,$lineEnd, $showErrorPhpFileOpen);
		}
		catch (Exception $e){}
		return;
	}
}

function trimLogPhp($filename,$lineEnd,$showErrorPhpFileOpen)
{
	if($showErrorPhpFileOpen === "false")
	{
		$lines = @file($filename);
	}
	else
	{
		$lines = file($filename);
	}
	$first_line = $lines[0];
	$lines = array_slice($lines, $lineEnd + 2);
	$lines = array_merge(array($first_line, "\n"), $lines);
	$file = false;
	if($showErrorPhpFileOpen === "false")
	{
		$file = @fopen($filename, "w");
	}
	else
	{
		$file = fopen($filename, "w");
	}
	if(gettype($file) !== "boolean")
	{
		fwrite($file, implode("", $lines));
		fclose($file);
	}
}

function trimLogShell($logTrimMacBSD,$filename,$lineEnd)
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

function tailWithGrep($filename, $sliceSize, $shellOrPhp, $whatGrepFor)
{
	$start = 0;
	$total = getLineCount($filename, $shellOrPhp);
	$inLoop = true;
	$data = array();
	while ($inLoop)
	{
		$innerSlice = $sliceSize;
		if($start + $sliceSize > $total)
		{
			//last chance?
			$innerSlice = $total - $start;
		}

		if($shellOrPhp === "phpPreferred" || $shellOrPhp ===  "phpOnly")
		{
			$return = trim(tailCustom($filename, $innerSlice, true, $start));
		}
		else
		{
			$return = trim(shell_exec('tail -n +' . (($total - $start) - $innerSlice) . ' "' . $filename . '" || head -n ' . $innerSlice . ' "' . $filename . '"'));
		}

		if(($return === "" || is_null($return)) && ($shellOrPhp === "shellPreferred" || $shellOrPhp === "phpPreferred"))
		{
			if($shellOrPhp === "phpPreferred")
			{
				$return = trim(shell_exec('tail -n +' . (($total - $start) - $innerSlice) . ' "' . $filename . '" || head -n ' . $innerSlice . ' "' . $filename . '"'));
			}
			else
			{
				$return = trim(tailCustom($filename, $innerSlice, true, $start));
			}
		}

		if($return === "" || is_null($return))
		{
			return "Error - Maybe insufficient access to read file?";
		}
		$lines = explode("\n", $return);
		foreach ($lines as $line)
		{
			if(strpos($line, $whatGrepFor) > -1)
			{
				array_push($data, $line);
			}
		}
		if(count(explode("\n", $data)) >= $sliceSize)
		{
			$inLoop = false;
		}
		$start += $sliceSize;
	}
	//possibly need to remove last \n from string?
	return implode("\n", $data);
}

function tail($filename, $sliceSize, $shellOrPhp)
{
	if($shellOrPhp === "phpPreferred" || $shellOrPhp ===  "phpOnly")
	{
		$data =  trim(tailCustom($filename, $sliceSize));
	}
	else
	{
		$data = trim(shell_exec('tail -n ' . $sliceSize . ' "' . $filename . '"'));
	}

	if(($data === "" || is_null($data)) && ($shellOrPhp === "shellPreferred" || $shellOrPhp === "phpPreferred"))
	{
		if($shellOrPhp === "phpPreferred")
		{
			$data = trim(shell_exec('tail -n ' . $sliceSize . ' "' . $filename . '"'));
		}
		else
		{
			$data = trim(tailCustom($filename, $sliceSize));
		}
	}

	if($data === "" || is_null($data))
	{
		$data = "Error - Maybe insufficient access to read file?";
	}
	return $data;
}


/**
 * Even more slightly modified, added start line for logic
 * Slightly modified version of http://www.geekality.net/2011/05/28/php-tail-tackling-large-files/
 * @author Torleif Berger, Lorenzo Stanco
 * @link http://stackoverflow.com/a/15025877/995958
 * @license http://creativecommons.org/licenses/by/3.0/
 */
function tailCustom($filepath, $lines = 1, $adaptive = true, $startLine = 0)
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
		if($startLine <= 0)
		{
			$output = ($chunk = fread($fileOpened, $seek)) . $output;
			$lines -= substr_count($chunk, "\n");
		}
		else
		{
			$startLine--;
		}
		fseek($fileOpened, -mb_strlen($chunk, '8bit'), SEEK_CUR);
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
	if(isset($_SERVER['HTTP_REFERER']))
	{
		return $_SERVER['HTTP_REFERER'];
	}

	$baseUrl = "";
	$count = 0;
	while ($count < 20)
	{
		$baseUrl .= "../";
		$count++;
		if(is_dir($baseUrl."Log-Hog") || is_dir($baseUrl."loghog"))
		{
			break;
		}
	}
	$baseRedirect = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
	if($count < 20)
	{
		return $baseRedirect . (is_dir($baseUrl."Log-Hog/") ? "Log-Hog/" : "loghog/");
	}
	return $baseRedirect . "Log-Hog/";

}

function setCookieRedirect($customUrl = null)
{
	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	if($customUrl !== null)
	{
		$actual_link = $customUrl;
	}
	if(isset($_COOKIE["locationRedirectLogHogUpgrade"]))
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
	if(isset($customConfig["data-src"]))
	{
		if(is_array($customConfig["data-src"]))
		{
			$image .=  " data-src=\"";
			$image .= $customConfig["data-src"]["src"];
			$image .= "\" ";
			if(!isset($customConfig["title"]))
			{
				$image .=  " data-title=\"";
				$image .= $customConfig["data-src"]["title"];
				$image .= "\" ";
			}
			if(!isset($customConfig["alt"]))
			{
				$image .=  " data-alt=\"";
				$image .= $customConfig["data-src"]["alt"];
				$image .= "\" ";
			}
		}
		else
		{
			$image .=  " data-src=\"";
			$image .= $customConfig["data-src"];
			$image .= "\" ";
		}
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

function upgradeConfig($newSaveStuff = array())
{
	if(!is_array($newSaveStuff))
	{
		$newSaveStuff = array(
			"configVersion" => (Int)$newSaveStuff
		);
	}
	$baseBaseUrl = baseURL();
	$baseUrl = $baseBaseUrl."local/";
	include($baseUrl.'layout.php');
	$baseUrl .= $currentSelectedTheme."/";
	include($baseUrl.'conf/config.php');
	include($baseBaseUrl.'core/conf/config.php');
	$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
	if(is_dir($baseBaseUrl.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
	{
		include($baseBaseUrl.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
	}
	else
	{
		include($baseBaseUrl.'core/Themes/'.$currentTheme."/defaultSetting.php");
	}
	include($baseBaseUrl.'core/php/loadVars.php');

	$fileName = ''.$baseUrl.'conf/config.php';
	$newInfoForConfig = "<?php
		$"."config = array(
		";
	foreach ($defaultConfig as $key => $value)
	{
		if(isset($newSaveStuff[$key]))
		{
			$newInfoForConfig .= putIntoCorrectFormat($key, $newSaveStuff[$key], $value);
		}
		elseif(
			$$key !== $defaultConfig[$key] &&
			(
				!isset($themeDefaultSettings) ||
				isset($themeDefaultSettings) && !array_key_exists($key, $themeDefaultSettings) ||
				isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
			)
			||
			$$key === $defaultConfig[$key] && isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
			||
			isset($arrayOfCustomConfig[$key])
		)
		{
			$newInfoForConfig .= putIntoCorrectFormat($key, $$key, $value);
		}
	}
	$newInfoForConfig .= "
		);
	?>";
	file_put_contents($fileName, $newInfoForConfig);
}

function loadSpecificVar($default, $custom, $configLookFor)
{
	$currentTheme = $default[$configLookFor];
	if(isset($custom[$configLookFor]))
	{
		$currentTheme = $custom[$configLookFor];
	}
	return $currentTheme;
}

function putIntoCorrectFormat($keyKey, $keyValue, $value)
{
	if(is_string($value))
	{
		return "
		'".$keyKey."' => '".$keyValue."',
	";
	}

	if(is_array($value))
	{
		return "
		'".$keyKey."' => array(".$keyValue."),
	";
	}

	return "
		'".$keyKey."' => ".$keyValue.",
	";
}

function putIntoCorrectJSFormat($keyKey, $keyValue, $value)
{
	if(is_string($value))
	{
		return " var ".$keyKey." = '".trim(preg_replace('/\s\s+/', ' ', $keyValue))."';";
	}

	if(is_array($value))
	{
		return " var ".$keyKey." = ".json_encode($keyValue).";";
	}

	return " var ".$keyKey." = ".trim(preg_replace('/\s\s+/', ' ', $keyValue)).";";
}

function returnCurrentSelectedTheme()
{
	$baseBaseUrl = baseURL();
	if(file_exists($baseBaseUrl.'local/layout.php') && is_readable($baseBaseUrl.'local/layout.php'))
	{
		require_once($baseBaseUrl.'local/layout.php');
		if(isset($currentSelectedTheme))
		{
			return $currentSelectedTheme;
		}
		else
		{
			echoErrorJavaScript("", "Error when getting current selected theme.", 9);
		}
	}
	else
	{
		echoErrorJavaScript("", "Could not find local layout file. Please make sure that local/layout.php is setup correctly.", 7);
	}
}

function getLineCount($fileName, $shellOrPhp)
{
	$linesBase = 0;
	if($shellOrPhp === "phpPreferred" || $shellOrPhp ===  "phpOnly")
	{
		$linesBase = getLineCountPhp($fileName);
	    if($linesBase === 0 || $linesBase === null)
	    {
	    	if($shellOrPhp === "phpPreferred")
	    	{
	    		$linesBase = shell_exec("wc -l \"".$fileName."\"");
	    	}
	    }
	    if($linesBase !== 0 || $linesBase !== null)
	    {
	    	return $linesBase;
	    }
	    return 0;
	}
	$linesBase = shell_exec("wc -l \"".$fileName."\"");
	if($linesBase === 0 || $linesBase === null)
	{
		if($shellOrPhp === "shellPreferred")
    	{
    		$linesBase = shell_exec("wc -l \"".$fileName."\"");
    	}
	}
	if($linesBase !== 0 || $linesBase !== null)
    {
    	return $linesBase;
    }
	return 0;
}

function getLineCountPhp($fileName)
{
	$linecount = 0;
	if(!file_exists($fileName))
	{
		return 0;
	}
	if(!is_readable($fileName))
	{
		return 0;
	}
	$handle = fopen($fileName, "r");
	while(!feof($handle))
	{
		$linecount += substr_count(fread($handle, 8192), "\n");
	}
	fclose($handle);
	return $linecount;
}

/* functions to check if X is installed, returns array of bool: local or not AND location: file location */
function checkForStatusInstall($manualReturn, $relBase)
{
	$baseBaseUrl = baseURL();
	if($manualReturn != "")
	{
		return array(
			'local'	=> false,
			'loc'	=> $manualReturn
		);
	}
	elseif (is_dir($baseBaseUrl."../status"))
	{
		return array(
			'local'	=> false,
			'loc'	=> $relBase."../status/"
		);
	}
	elseif (is_dir($baseBaseUrl."../Status"))
	{
		return array(
			'local'	=> false,
			'loc'	=> $relBase."../Status/"
		);
	}
	return array(
		'local'	=> false,
		'loc'	=> false
	);
}

function checkForMonitorInstall($manualReturn, $relBase)
{
	$baseBaseUrl = baseURL();
	if($manualReturn != "")
	{
		return array(
			'local'	=> false,
			'loc'	=> $manualReturn
		);
	}
	elseif(is_file($baseBaseUrl."monitor/index.php"))
	{
		return array(
			'local'	=> true,
			'loc'	=> $relBase."monitor"
		);
	}
	elseif (is_dir($baseBaseUrl."../monitor"))
	{
		return array(
			'local'	=> false,
			'loc'	=> $relBase."../monitor/"
		);
	}
	elseif (is_dir($baseBaseUrl."../Monitor"))
	{
		return array(
			'local'	=> false,
			'loc'	=> $relBase."../Monitor/"
		);
	}
	return array(
		'local'	=> false,
		'loc'	=> false
	);
}

function checkForSearchInstall($manualReturn, $relBase)
{
	$baseBaseUrl = baseURL();
	if($manualReturn != "")
	{
		return array(
			'local'	=> false,
			'loc'	=> $manualReturn
		);
	}
	elseif(is_file($baseBaseUrl."search/index.php"))
	{
		return array(
			'local'	=> true,
			'loc'	=> $relBase."search/"
		);
	}
	elseif (is_dir($baseBaseUrl."../search"))
	{
		return array(
			'local'	=> false,
			'loc'	=> $relBase."../search/"
		);
	}
	elseif (is_dir($baseBaseUrl."../Search"))
	{
		return array(
			'local'	=> false,
			'loc'	=> $relBase."../Search/"
		);
	}
	return array(
		'local'	=> false,
		'loc'	=> false
	);
}

function checkForSeleniumMonitorInstall($manualReturn, $relBase)
{
	$baseBaseUrl = baseURL();
	if($manualReturn != "")
	{
		return array(
			'local'	=> false,
			'loc'	=> $manualReturn
		);
	}
	elseif(is_file($baseBaseUrl."seleniumMonitor/index.php"))
	{
		return array(
			'local'	=> true,
			'loc'	=> $relBase."seleniumMonitor/"
		);
	}
	elseif (is_dir($baseBaseUrl."../seleniumMonitor"))
	{
		return array(
			'local'	=> false,
			'loc'	=> $relBase."../seleniumMonitor/"
		);
	}
	elseif (is_dir($baseBaseUrl."../SeleniumMonitor"))
	{
		return array(
			'local'	=> false,
			'loc'	=> $relBase."../SeleniumMonitor/"
		);
	}
	return array(
		'local'	=> false,
		'loc'	=> false
	);
}

function getListOfFiles($data)
{
	$path = $data["path"];
	$filter = $data["filter"];
	$response = $data["response"];
	$recursive = $data["recursive"];
	$shellOrPhp = $data["shellOrPhp"];
	$fileData = array();
	if(isset($data["data"]))
	{
		$fileData = $data["data"];
	}

	$path = preg_replace('/\/$/', '', $path);
	if(file_exists($path))
	{
		$scannedDir = scandir($path);
		if(!is_array($scannedDir))
		{
			$scannedDir = array($scannedDir);
		}
		$files = array_diff($scannedDir, array('..', '.'));
		if($files)
		{
			foreach($files as $k => $filename)
			{
				$fullPath = $path . DIRECTORY_SEPARATOR . $filename;
				if($recursive === "true" && is_dir($fullPath))
				{
					$response = sizeFilesInDir(array(
						"path" 			=> $fullPath,
						"filter"		=> $filter,
						"response"		=> $response,
						"recursive"		=> "true",
						"shellOrPhp"	=> $shellOrPhp,
						"data"			=> $fileData

					));
				}
				elseif(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath))
				{
					$boolCheck = true;
					if(isset($fileData[$fullPath]))
					{
						if($fileData[$fullPath]["Include"] === "false")
						{
							$boolCheck = false;
						}
					}
					if($boolCheck)
					{
						array_push($response, $fullPath);
					}
				}
			}
		}
	}
	return $response;
}

function sizeFilesInDir($data)
{
	$path = $data["path"];
	$filter = $data["filter"];
	$response = $data["response"];
	$shellOrPhp = $data["shellOrPhp"];
	$recursive = $data["recursive"];

	$path = preg_replace('/\/$/', '', $path);
	if(file_exists($path))
	{
		$scannedDir = scandir($path);
		if(!is_array($scannedDir))
		{
			$scannedDir = array($scannedDir);
		}
		$files = array_diff($scannedDir, array('..', '.'));
		if($files)
		{
			foreach($files as $k => $filename)
			{
				$fullPath = $path . DIRECTORY_SEPARATOR . $filename;
				if(is_dir($fullPath) && $recursive === "true")
				{
					$response = sizeFilesInDir(array(
						"path" 			=> $fullPath,
						"filter"		=> $filter,
						"response"		=> $response,
						"shellOrPhp"	=> $shellOrPhp,
						"recursive"		=> "true"

					));
				}
				elseif(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath))
				{
					$response[$fullPath] = getFileSize($fullPath, $shellOrPhp);
				}
			}
		}
	}
	return $response;
}

function createSelect($options, $selectValue, $defaultOption = false)
{
	$selectHtml = "";
	$selected = false;
	foreach ($options as $key => $value)
	{
		$selectHtml .= "<option value=\"".$value["value"]."\" ";
		if($selectValue === $value["value"] && $selected !== true)
		{
			$selectHtml .= " selected ";
			$selected = true;
		}
		$selectHtml .= " >".$value["name"]."</option>";
	}
	if($defaultOption)
	{
		$selectHtml .= "<option value=\"".$defaultOption["value"]."\" ";
		if($selected !== true)
		{
			$selectHtml .= " selected ";
		}
		$selectHtml .= " >".$defaultOption["name"]."</option>";
	}
	return $selectHtml;
}

function generateFullSelect($confDataValue, $selectValue, $varName)
{
	$returnHtml = "";
	$selectId = "";
	if(isset($confDataValue["id"]))
	{
		$selectId = " id=\"".$confDataValue["id"]."\" ";
	}
	if(isset($confDataValue["name"]) && $confDataValue["name"] !== "")
	{
		$returnHtml .= "<span class=\"settingsBuffer\" > ".$confDataValue["name"].": </span>";
	}
	$returnHtml .= " <div class=\"selectDiv\"><select ".$selectId." name=\"".$varName."\">";
	$returnHtml .= createSelect($confDataValue["options"], $selectValue);
	$returnHtml .= "</select></div>";
	if(isset($confDataValue["function"]) && $confDataValue["function"] !== "")
	{
		$returnHtml .= "<script>$( document ).ready(function(){document.getElementById(\"".$confDataValue["id"]."\").addEventListener(\"change\", ".$confDataValue["function"].", false);});</script>";
	}
	return $returnHtml;
}

function generateNumber($confDataValue,$numberValue,$varName)
{
	$returnHtml = "<span class=\"settingsBuffer\" > ".$confDataValue["name"].": </span>";
	$returnHtml .= " <input type=\"number\" pattern=\"[0-9]*\" name=\"".$varName."\" value=\"".$numberValue."\" >";
	return $returnHtml;
}

function generateHidden($confDataValue,$numberValue,$varName)
{
	$returnHtml = " <input id=\"".$confDataValue["id"]."\" type=\"hidden\" name=\"".$varName."\" value='".$numberValue."' >";
	return $returnHtml;
}

function generateText($confDataValue,$numberValue,$varName)
{
	$returnHtml = "<span class=\"settingsBuffer\" > ".$confDataValue["name"].": </span>";
	$returnHtml .= " <input type=\"text\" name=\"".$varName."\" value=\"".$numberValue."\" >";
	return $returnHtml;
}

function generateGenericType($confDataValue, $confDataKeyValue, $confDataKey)
{
	$returnHtml = "";
	if($confDataValue["type"] === "number")
	{
		$returnHtml .= generateNumber($confDataValue,$confDataKeyValue,$confDataKey);
	}
	else if($confDataValue["type"] === "text")
	{
		$returnHtml .= generateText($confDataValue,$confDataKeyValue,$confDataKey);
	}
	elseif($confDataValue["type"] === "dropdown")
	{
		$returnHtml .= generateFullSelect($confDataValue,$confDataKeyValue,$confDataKey);
	}
	elseif($confDataValue["type"] === "hidden")
	{
		$returnHtml .= generateHidden($confDataValue,$confDataKeyValue,$confDataKey);
	}
	if(isset($confDataValue["postText"]) && $confDataValue["postText"] !== "")
	{
		$returnHtml .= " ".$confDataValue["postText"];
	}
	return $returnHtml;
}

function generateInfo($image, $info)
{
	$returnHtml = "<li><span style=\"font-size: 75%;\">";
	$returnHtml .= $image;
	$returnHtml .= "  <i>".$info."</i></span></li>";
	return $returnHtml;
}

function getData($loadVarsArray, $confDataValue)
{
	$keyVar = "";
	if(isset($confDataValue["var"]) && isset($confDataValue["var"]["key"]))
	{
		$keyVar = $confDataValue["var"]["key"];
	}
	elseif(isset($confDataValue["key"]))
	{
		$keyVar = $confDataValue["key"];
	}
	if(isset($loadVarsArray[$keyVar]))
	{
		return $loadVarsArray[$keyVar];
	}
	if(isset($confDataValue["value"]))
	{
		return $confDataValue["value"];
	}
	return "";
}
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

function isDirRmpty($dir)
{
	if(!is_readable($dir))
	{
		return NULL;
	}
  	return (count(scandir($dir)) == 2);
}

function filterFunctionName($line)
{
	$line = str_replace("public function", "", $line);
	$line = str_replace("\r\n", "", $line);
	$line = str_replace(" ", "", $line);
	$line = str_replace("()", "", $line);
	$line = str_replace("{", "", $line);
	$line =  trim(preg_replace('/\t+/', "", $line));
	return $line;
}

function filterGroupname($line)
{
	$line = str_replace("@group", "", $line);
	$line = str_replace("\r\n", "", $line);
	$line = str_replace(" ", "", $line);
	$line = str_replace("*", "", $line);
	$line =  trim(preg_replace('/\t+/', "", $line));
	return $line;
}

function getAllTestsFromGroup($file, $groupNameArray)
{
	$file = file($file);
	$arrayOfTests = array();
	foreach ($groupNameArray as $groupName)
	{
		for ($i=0; $i < count($file); $i++)
		{ 
			if(strpos($file[$i], "@group") !== false)
			{
				if(strpos($file[$i], "//") === false)
				{
					if(strpos($file[$i], $groupName) !== false)
					{
						//find next public function
						$j = 1;
						$stayInLoop = true;
						while ($stayInLoop)
						{
							if(isset($file[$i+$j]))
							{
								$lineCheckForFunction = $file[$i+$j];
								if(strpos($lineCheckForFunction, "public function") !== false)
								{
									if(strpos($lineCheckForFunction, "test") !== false)
									{
										if(strpos($lineCheckForFunction, "//") === false)
										{
											$line = filterFunctionName($lineCheckForFunction);
											if(!in_array($line, $arrayOfTests))
											{
												array_push($arrayOfTests, $line);
											}
										}
									}
									$stayInLoop = false;
								}
								$j++;
							}
							else
							{
								$stayInLoop = false;
							}
						}
					}
				}
			}
		}
	}
	return $arrayOfTests;
}

function checkPhpUnit()
{
	$commandResult = shell_exec("phpunit --version");
	if(strpos($commandResult, "command not found") === false)
	{
		return true;
	}
	return false;
}
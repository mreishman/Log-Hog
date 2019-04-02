<?php
class core
{
	public function addResetButton($idOfForm)
	{
		return "<a onclick=\"resetArrayObject('".$idOfForm."');\" style=\"display: none;\" class=\"linkSmall ".$idOfForm."ResetButton\" > Reset Current Changes</a><span class=\"".$idOfForm."NoChangesDetected\" >No Changes Detected</span>";
	}

	public function findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version)
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

	public function calcuateDaysSince($lastCheck)
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

	public function loadCSS($base, $baseUrl, $version)
	{
		$stringToReturn = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$baseUrl."template/theme.css?v=".$version."\">";
		$stringToReturn .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$base."core/template/base.css?v=".$version."\">";
		return $stringToReturn;
	}

	function loadSentryData($sendCrashInfoJS, $branchSelected, $configStatic)
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
			$versionForSentry = $configStatic["version"];
			$returnString =  "
			<script type=\"text/javascript\">
			function startSentryStuff(){
			Raven.config(\"https://2e455acb0e7a4f8b964b9b65b60743ed@sentry.io/205980\", {
			    release: \"".$versionForSentry."\"
			}).install();
			}
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

	public function getCookieRedirect()
	{
		$urlRedirectValue = "";
		if(isset($_COOKIE["locationRedirectLogHogUpgrade"]) && $_COOKIE["locationRedirectLogHogUpgrade"] !== "")
		{
			$urlRedirectValue =  $_COOKIE["locationRedirectLogHogUpgrade"];
		}
		if($urlRedirectValue !== null && $urlRedirectValue !== "" && strpos($urlRedirectValue, "settingsSaveAjax") === false)
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

	public function setCookieRedirect($customUrl = null)
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

	public function baseURL()
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

	public function returnCurrentSelectedTheme()
	{
		$baseBaseUrl = $this->baseURL();
		if(file_exists($baseBaseUrl.'local/layout.php') && is_readable($baseBaseUrl.'local/layout.php'))
		{
			include($baseBaseUrl.'local/layout.php');
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

	public function filePermsDisplay($key)
	{
		$info = "u---------";
		if(file_exists($key))
		{
			$info = $this->returnActualFilePerms($key);
		}
		return $info;
	}

	private function returnActualFilePerms($key)
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
			$info .= $this->evaluateBool(
				$value["Read"]["Boolval"],
				"r",
				"-"
			);
			$info .= $this->evaluateBool(
				$value["Write"]["Boolval"],
				"w",
				"-"
			);
			$info .= $this->evaluateBool(
				$value["Execute"]["Boolval"],
				$this->evaluateBool(
					$value["Execute"]["Boolval2"],
					"s",
					"x"
				),
				$this->evaluateBool(
					$value["Execute"]["Boolval2"],
					"S",
					"-"
				)
			);
		}
		return $info;
	}

	private function evaluateBool($boolVal, $trueVal, $falseVal)
	{
		if($boolVal)
		{
			return $trueVal;
		}
		return $falseVal;
	}
}
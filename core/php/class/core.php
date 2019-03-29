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
}
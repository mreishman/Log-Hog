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

	public function convertToSize($TrimSize, $logSizeLimit)
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
}
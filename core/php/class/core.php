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
}
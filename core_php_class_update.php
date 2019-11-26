<?php

class update
{
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

	public function formatBytes($bytes,$decimals = 2)
	{
		$bytes = (int)$bytes;
		if($bytes === 0)
		{
			return "0 Bytes";
		}
		$sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
		$i = floor(log($bytes) / log(1024));
		return number_format(($bytes / pow(1024, $i)), $decimals) . " " . $sizes[$i];
	}
}
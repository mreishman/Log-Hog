<?php
class pollFunctions
{
	public function getListOfFiles($data)
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
			if($scannedDir)
			{
				unset($scannedDir[0], $scannedDir[1]);
				foreach($scannedDir as $filename)
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
}
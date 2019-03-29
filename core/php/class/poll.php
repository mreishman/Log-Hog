<?php
class poll
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
						$response = $this->sizeFilesInDir(array(
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

	private function sizeFilesInDir($data)
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
				foreach($files as $filename)
				{
					$fullPath = $path . DIRECTORY_SEPARATOR . $filename;
					if(is_dir($fullPath) && $recursive === "true")
					{
						$response = $this->sizeFilesInDir(array(
							"path" 			=> $fullPath,
							"filter"		=> $filter,
							"response"		=> $response,
							"shellOrPhp"	=> $shellOrPhp,
							"recursive"		=> "true"

						));
					}
					elseif(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath))
					{
						$response[$fullPath] = $this->getFileSize($fullPath, $shellOrPhp);
					}
				}
			}
		}
		return $response;
	}

	public function getFileSize($filename, $shellOrPhp)
	{
		$filename = preg_replace('/([()"])/S', '$1', $filename);
		$sof = $this->getFileSizeInner($filename, $shellOrPhp);
		return htmlentities($sof);
	}

	private function getFileSizeInner($fileName, $shellOrPhp)
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
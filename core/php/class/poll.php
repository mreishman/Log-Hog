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

	public function trimLogLine($filename, $logSizeLimit, $logTrimMacBSD, $buffer, $shellOrPhp, $showErrorPhpFileOpen)
	{
		$lineCount = $this->getLineCount($filename, $shellOrPhp);
		if($lineCount > ($logSizeLimit+$buffer))
		{
			$this->trimLogInner($logTrimMacBSD,$filename,($lineCount - $logSizeLimit), $shellOrPhp, $showErrorPhpFileOpen);
		}
	}

	public function trimLogSize($filename, $logSizeLimit,$logTrimMacBSD,$buffer, $shellOrPhp, $showErrorPhpFileOpen)
	{
		$maxForLoop = 0;
		$trimFileBool = true;
		while ($trimFileBool && $maxForLoop < 5)
		{
			$filesizeForFile = $this->getFileSizeInner($filename, $shellOrPhp);
			if($filesizeForFile > $logSizeLimit+$buffer)
			{
				$numOfLinesToRemoveTo = 2;
				if($filesizeForFile > (2*$logSizeLimit) && $maxForLoop < 2)
				{
					$lineCountForFile = $this->getLineCount($filename, $shellOrPhp);
					$numOfLinesAllowed = 2*($logSizeLimit/($filesizeForFile/$lineCountForFile));
					$numOfLinesToRemoveTo = round($lineCountForFile - $numOfLinesAllowed);
				}

				$this->trimLogInner($logTrimMacBSD,$filename,$numOfLinesToRemoveTo, $shellOrPhp, $showErrorPhpFileOpen);
			}
			else
			{
				$trimFileBool = false;
			}
			$maxForLoop++;
		}
	}

	private function trimLogInner($logTrimMacBSD, $filename, $lineEnd, $shellOrPhp, $showErrorPhpFileOpen)
	{
		if($shellOrPhp === "phpPreferred" || $shellOrPhp ===  "phpOnly")
		{
			try
			{
				$this->trimLogPhp($filename,$lineEnd, $showErrorPhpFileOpen);
				return;
			}
			catch (Exception $e)
			{
				if($shellOrPhp === "phpPreferred")
				{
					try
					{
						$this->trimLogShell($logTrimMacBSD,$filename,$lineEnd);
					}
					catch (Exception $e){}
					return;
				}
			}
		}
		try
		{
			$this->trimLogShell($logTrimMacBSD,$filename,$lineEnd);
			return;
		}
		catch (Exception $e)
		{
			try
			{
				$this->trimLogPhp($filename,$lineEnd, $showErrorPhpFileOpen);
			}
			catch (Exception $e){}
			return;
		}
	}

	private function trimLogPhp($filename, $lineEnd, $showErrorPhpFileOpen)
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

	private function trimLogShell($logTrimMacBSD, $filename, $lineEnd)
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

	public function tailWithGrep($filename, $sliceSize, $shellOrPhp, $whatGrepFor)
	{
		$start = 0;
		$total = $this->getLineCount($filename, $shellOrPhp);
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
				$return = trim($this->tailCustom($filename, $innerSlice, true, $start));
			}
			else
			{
				$return = trim(shell_exec('sed -n "'.$start.','.($start+$innerSlice).'p" "' . $filename . '"'));
			}

			if(($return === "" || is_null($return)) && ($shellOrPhp === "shellPreferred" || $shellOrPhp === "phpPreferred"))
			{
				if($shellOrPhp === "phpPreferred")
				{
					$return = trim(shell_exec('sed -n "'.$start.','.($start+$innerSlice).'p" "' . $filename . '"'));
				}
				else
				{
					$return = trim($this->tailCustom($filename, $innerSlice, true, $start));
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

	public function tail($filename, $sliceSize, $shellOrPhp, $start = 0)
	{
		if($shellOrPhp === "phpPreferred" || $shellOrPhp ===  "phpOnly")
		{
			$data =  trim($this->tailCustom($filename, $sliceSize, true, $start));
		}
		else
		{
			$data = trim(shell_exec('sed -n "'.$start.','.($start+$sliceSize).'p" "' . $filename . '"'));
		}

		if(($data === "" || is_null($data)))
		{
			if($shellOrPhp === "phpPreferred")
			{
				$data = trim(shell_exec('sed -n "'.$start.','.($start+$sliceSize).'p" "' . $filename . '"'));
			}
			elseif($shellOrPhp === "shellPreferred")
			{
				$data = trim($this->tailCustom($filename, $sliceSize, true, $start));
			}

			if($data === "" || is_null($data))
			{
				$data = "Error - Maybe insufficient access to read file?";
			}
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
	private function tailCustom($filepath, $lines = 1, $adaptive = true, $startLine = 0)
	{
		$fileOpened = @fopen($filepath, "rb");
		if($fileOpened === false)
		{
			return false;
		}
		$buffer = 4096;
		if($adaptive)
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

	public function getLineCount($fileName, $shellOrPhp)
	{
		$linesBase = 0;
		if($shellOrPhp === "phpPreferred" || $shellOrPhp ===  "phpOnly")
		{
			$linesBase = $this->getLineCountPhp($fileName);
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
	    		$linesBase = $this->getLineCountPhp($fileName);
	    	}
		}
		if($linesBase !== 0 || $linesBase !== null)
	    {
	    	return $linesBase;
	    }
		return 0;
	}

	private function getLineCountPhp($fileName)
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
}
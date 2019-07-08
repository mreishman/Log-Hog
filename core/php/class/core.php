<?php
class core
{
	public function clean_url($url)
	{
	    $parts = parse_url($url);
	    return $parts['path'];
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

	public function loadSpecificVar($default, $custom, $configLookFor)
	{
		$currentTheme = $default[$configLookFor];
		if(isset($custom[$configLookFor]))
		{
			$currentTheme = $custom[$configLookFor];
		}
		return $currentTheme;
	}

	public function putIntoCorrectFormat($keyKey, $keyValue, $value)
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

	public function echoErrorJavaScript($urlPath, $mainMessage, $errorNumber)
	{
		$urlPath = $urlPath."error.php?error=".$errorNumber."&page=".$mainMessage;
		echo "<script type=\"text/javascript\"> window.location.href = '".$urlPath."'; </script>";
		exit();
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
				Sentry.init({ dsn: 'https://2e455acb0e7a4f8b964b9b65b60743ed@sentry.io/205980' });
			}
			function eventThrowException(e)
			{
				Sentry.captureException(new Error(e);
				";
				if($branchSelected === 'beta')
				{
					$returnString .= "
						Sentry.showReportDialog();
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
				$this->echoErrorJavaScript("", "Error when getting current selected theme.", 9);
			}
		}
		else
		{
			$this->echoErrorJavaScript("", "Could not find local layout file. Please make sure that local/layout.php is setup correctly.", 7);
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

	public function getFileTime($filePath, $default)
	{
		$basePath = $this->baseURL();
		if(file_exists($basePath . $filePath))
		{
			$returnValue = filemtime($basePath . $filePath);
			if($returnValue) //can be false
			{
				return $returnValue;
			}
		}
		return $default;
	}

	public function getScript($filePath)
	{
		echo "<script src=\"" . $filePath['filePath'] . "?v=" . $this->getFileTime($filePath['baseFilePath'], $filePath['default']) . "\"></script>";
	}

	public function getScripts($filePathArr)
	{
		foreach ($filePathArr as $filePath)
		{
			$this->getScript($filePath);
		}
	}

	public function putIntoCorrectJSFormat($keyKey, $keyValue, $value, $defineVar = true)
	{
		$stringToReturn = "";
		if($defineVar)
		{
			$stringToReturn .= " var ";
		}
		if(is_string($value))
		{
			return $stringToReturn .$keyKey." = '".trim(preg_replace('/\s\s+/', ' ', $keyValue))."';";
		}

		if(is_array($value))
		{
			return $stringToReturn .$keyKey." = ".json_encode($keyValue).";";
		}

		return $stringToReturn .$keyKey." = ".trim(preg_replace('/\s\s+/', ' ', $keyValue)).";";
	}

	public function generateImage($imageArray, $customConfig)
	{
		$currentImgVersion = strtotime("now");
		if(isset($imageArray["version"]))
		{
			$currentImgVersion = $imageArray["version"];
		}
		$image = "<img ";
		if(isset($customConfig["data-id"]))
		{
			$image .=  " data-id=\"".$customConfig["data-id"]."\" ";
		}
		if(isset($customConfig["data-src"]))
		{
			if(is_array($customConfig["data-src"]))
			{
				$image .=  " data-src=\"";
				if(isset($customConfig["srcModifier"]))
				{
					$image .= $customConfig["srcModifier"];
				}
				$image .= $customConfig["data-src"]["src"] . "?v=" . $currentImgVersion."\" ";
				if(!isset($customConfig["title"]) && isset($customConfig["data-src"]["title"]))
				{
					$image .=  " data-title=\"".$customConfig["data-src"]["title"]."\" ";
				}
				if(!isset($customConfig["alt"]) && isset($customConfig["data-src"]["alt"]))
				{
					$image .=  " data-alt=\"".$customConfig["data-src"]["alt"]."\" ";
				}
			}
			else
			{
				$image .=  " data-src=\"";
				if(isset($customConfig["srcModifier"]))
				{
					$image .= $customConfig["srcModifier"];
				}
				$image .= $customConfig["data-src"]."\" ";
			}
		}
		if(isset($customConfig["id"]))
		{
			$image .=  " id=\"".$customConfig["id"]."\" ";
		}
		if(isset($customConfig["class"]))
		{
			$image .= " class=\"".$customConfig["class"]."\" ";
		}
		$image .= " src=\"";
		if(isset($customConfig["srcModifier"]))
		{
			$image .= $customConfig["srcModifier"];
		}
		$image .= $imageArray["src"] . "?v=" . $currentImgVersion . "\" ";
		if(isset($customConfig["alt"]))
		{
			if($customConfig["alt"] !== null)
			{
				$image .= " alt=\"".$customConfig["alt"]."\" ";
			}
		}
		else
		{
			$image .= " alt=\"".$imageArray["alt"]."\" ";
		}
		if(isset($customConfig["title"]))
		{
			if($customConfig["title"] !== null)
			{
				$image .= " title=\"".$customConfig["title"]."\" ";
			}
		}
		else
		{
			$image .= " title=\"".$imageArray["title"]."\" ";
		}
		if(isset($customConfig["style"]))
		{
			$image .= " style=\"".$customConfig["style"]."\" ";
		}
		if(isset($customConfig["height"]))
		{
			$image .= " height=\"".$customConfig["height"]."\" ";
		}
		if(isset($customConfig["width"]))
		{
			$image .= " width=\"".$customConfig["width"]."\" ";
		}
		$image .= " >";
		return $image;
	}

	public function getFileInfoFromDir($data, $response)
	{
		$path = $data["path"];
		$recursive = $data["recursive"];
		$filter = $data["filter"];
		if(!is_readable($path))
		{
			return $response;
		}
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
				$fullPath = $path;
				if($path != "/")
				{
					$fullPath .= DIRECTORY_SEPARATOR;
				}
				$fullPath .= $filename;
				if(is_dir($fullPath))
				{
					$subImg = "defaultFolderIcon";
					if(!is_readable($fullPath))
					{
						$subImg = "defaultFolderNRIcon";
					}
					elseif(!is_writeable($fullPath))
					{
						$subImg = "defaultFolderNWIcon";
					}
					$response[$fullPath] = array(
						"type"		=>	"folder",
						"filename"	=>	$filename,
						"image"		=>	$subImg,
						"fullpath"	=>	$fullPath
					);
					if($recursive === "true")
					{
						$response = $this->getFileInfoFromDir(
							array(
								"path"		=>	$fullPath,
								"recursive"	=>	$recursive,
								"filter"	=>	$filter
							),
							$response
						);
					}
				}
				elseif(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath))
				{
					$subImg = "defaultFileIcon";
					if(!is_readable($fullPath))
					{
						$subImg = "defaultFileNRIcon";
					}
					elseif(!is_writeable($fullPath))
					{
						$subImg = "defaultFileNWIcon";
					}
					$response[$fullPath] = array(
						"type"		=>	"file",
						"filename"	=>	$filename,
						"image"		=>	$subImg,
						"fullpath"	=>	$fullPath
					);
				}
			}
		}
		return $response;
	}
}
<?php

class gallery 
{
	private function getDefaultId($data)
	{
		if(isset($data["id"]))
		{
			return $data["id"];
		}
		return preg_replace('/[^a-z0-9]+/', '_', strtolower($data["src"]));
	}

	public function generateGallery($arrayOfImages, $config = array())
	{
		$htmlToReturn = "";
		//Defaults
		$tag = "div";
		$imgWidth = "auto";
		$imgHeight = "auto";
		$arrows = true;
		$galleryThumbWidth = "50";
		$galleryThumbHeight = "auto";
		$galleryThumbs = true;
		$imageClass = "";
		//Check for custom settings
		if(isset($config["tag"]))
		{
			$tag = $config["tag"];
		}
		if(isset($config["imgWidth"]))
		{
			$imgWidth = $config["imgWidth"];
		}
		if(isset($config["imgHeight"]))
		{
			$imgHeight = $config["imgHeight"];
		}
		if(isset($config["arrows"]))
		{
			$arrows = $config["arrows"];
		}
		if(isset($config["galleryThumbWidth"]))
		{
			$galleryThumbWidth = $config["galleryThumbWidth"];
		}
		if(isset($config["galleryThumbHeight"]))
		{
			$galleryThumbHeight = $config["galleryThumbHeight"];
		}
		if(isset($config["galleryThumbs"]))
		{
			$galleryThumbs = $config["galleryThumbs"];
		}
		if(isset($config["class"]))
		{
			$imageClass = $config["class"];
		}
		$arrayOfImagesCount = count($arrayOfImages);
		$arrayOfImagesCounter = 0;
		if($arrayOfImagesCount === 1)
		{
			$arrows = false;
		}
		else
		{
			//build array
			$arrayOfImagesGen = array();
			foreach ($arrayOfImages as $value)
			{
				//easier to use number for key incase not used in main img
				$arrayOfImagesGen[$arrayOfImagesCounter] = $value;
				$arrayOfImagesCounter++;
			}

		}
		$arrayOfImagesCounter = 0;
		foreach ($arrayOfImages as $value)
		{
			if($arrayOfImagesCounter !== 0)
			{
				$htmlToReturn .= "
			";
			}
			$id = $this->getDefaultId($value);
			$htmlToReturn .= "<".$tag.">";
			$link = "#".$id;
			$image = $value["src"];
			$thumb = $value["src"];
			if(isset($value["link"]))
			{
				$link = $value["link"];
			}
			if(isset($value["thumb"]))
			{
				$thumb = $value["thumb"];
			}
			$target = "";
			if(isset($value["target"]))
			{
				$target = " target=\"".$value["target"]."\"";
			}
			$htmlToReturn .= 	"
				<a href=\"".$link."\"".$target.">
					".$value["image"]."
				</a>";
			if($link === "#".$id)
			{
				$htmlToReturn .= "
				<span class=\"lightbox\"  id=\"".$id."\">
					<span class=\"lightboxForeground\">
						<a href=\"#_\" class=\"lightboxClose	\" >
							<span class=\"lightbox-icon-bar-top\"></span>
							<span class=\"lightbox-icon-bar-bot\"></span>
						</a>";
				if($arrows && $arrayOfImagesCounter !== 0)
				{
					$htmlToReturn .= "
						<a href=\"#".$this->getDefaultId($arrayOfImagesGen[$arrayOfImagesCounter-1])."\" class=\"arrow left lightboxLeft\" ></a>";
				}
				$htmlToReturn .= "
						<img class=\"".$imageClass."\" data-src=\"".$image."\">";
				if($arrows && ($arrayOfImagesCounter + 1) < $arrayOfImagesCount)
				{
					$htmlToReturn .= "
						<a href=\"#".$this->getDefaultId($arrayOfImagesGen[$arrayOfImagesCounter+1])."\" class=\"arrow right lightboxRight\" ></a>";
				}
				if($galleryThumbs)
				{
					if($arrayOfImagesCounter !== 0)
					{
						$leftThumbHtml = "";
						$newCounter = 0;
						foreach ($arrayOfImages as $value2)
						{
							if($newCounter >= $arrayOfImagesCounter)
							{
								break;
							}
							$id = $this->getDefaultId($value2);
							if(isset($value2["id"]))
							{
								$id = $value2["id"];
							}
							$thumb2 = $value2["src"];
							$link2 = "#".$id;
							if(isset($value2["thumb"]))
							{
								$thumb2 = $value2["thumb"];
							}
							$leftThumbHtml .= "
							<a href=\"".$link2 ."\" >
								<img class=\"galleryFSThumb ".$imageClass."\" width=\"".$galleryThumbWidth."px\" height=\"".$galleryThumbHeight."\" style=\"max-height: ".($galleryThumbWidth*2)."px\" data-src=\"".$thumb2."\">
							</a>
							";
							$newCounter++;

						}
						$htmlToReturn .= "<div style=\"margin-right: ".($galleryThumbWidth/2)."px; width:".(($galleryThumbWidth+20)*($newCounter))."px;\" class=\"galleryThumbsLeft\">";
						$htmlToReturn .= $leftThumbHtml;
						$htmlToReturn .= "</div>";
					}
					$htmlToReturn .= "
						<img style=\"margin-left:-".($galleryThumbWidth/2)."px\" class=\"galleryFullScreenThumbCenter galleryFSThumb currentThumb ".$imageClass."\" width=\"".$galleryThumbWidth."px\" height=\"".$galleryThumbHeight."\" data-src=\"".$thumb."\">";
					if(($arrayOfImagesCounter + 1) < $arrayOfImagesCount)
					{
						$leftThumbHtml = "";
						$newCounter = 0;
						$imageCounter = 0;
						foreach ($arrayOfImages as $value2)
						{
							$newCounter++;
							if(($newCounter - 1) <= $arrayOfImagesCounter)
							{
								continue;
							}
							$id = $this->getDefaultId($value2);
							$thumb2 = $value2["src"];
							$link2 = "#".$id;
							if(isset($value2["thumb"]))
							{
								$thumb2 = $value2["thumb"];
							}
							$leftThumbHtml .= "
							<a href=\"".$link2 ."\" >
								<img class=\"galleryFSThumb ".$imageClass."\" width=\"".$galleryThumbWidth."px\" height=\"".$galleryThumbHeight."\" data-src=\"".$thumb2."\">
							</a>
							";
							$imageCounter++;

						}
						$htmlToReturn .= "<div style=\"margin-left: ".(($galleryThumbWidth/1.5))."px; width:".(($galleryThumbWidth+20)*($imageCounter))."px;\" class=\"galleryThumbsRight\">";
						$htmlToReturn .= $leftThumbHtml;
						$htmlToReturn .= "</div>";
					}
				}
				$htmlToReturn .= "
					</span>";
				$htmlToReturn .= "
					<a class=\"lightboxBackground\" href=\"#_\" ></a>";
				$htmlToReturn .= "
				</span>";
			}
			$htmlToReturn .= "
			</".$tag.">";
			$arrayOfImagesCounter++;
		}
		$htmlToReturn .= "
";
		return $htmlToReturn;
	}
}
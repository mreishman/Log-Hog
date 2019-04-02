<?php

function baseURL()
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

function clean_url($url)
{
    $parts = parse_url($url);
    return $parts['path'];
}

function generateImage($imageArray, $customConfig)
{
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
			$image .= $customConfig["data-src"]["src"]."\" ";
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
	$image .= $imageArray["src"]."\" ";
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

function upgradeConfig($newSaveStuff = array())
{
	if(!is_array($newSaveStuff))
	{
		$newSaveStuff = array(
			"configVersion" => (Int)$newSaveStuff
		);
	}
	$baseBaseUrl = baseURL();
	$baseUrl = $baseBaseUrl."local/";
	include($baseUrl.'layout.php');
	$baseUrl .= $currentSelectedTheme."/";
	include($baseUrl.'conf/config.php');
	include($baseBaseUrl.'core/conf/config.php');
	$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
	if(is_dir($baseBaseUrl.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
	{
		include($baseBaseUrl.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
	}
	else
	{
		include($baseBaseUrl.'core/Themes/'.$currentTheme."/defaultSetting.php");
	}
	include($baseBaseUrl.'core/php/loadVars.php');

	$fileName = ''.$baseUrl.'conf/config.php';
	$newInfoForConfig = "<?php
		$"."config = array(
		";
	foreach ($defaultConfig as $key => $value)
	{
		if(isset($newSaveStuff[$key]))
		{
			$newInfoForConfig .= putIntoCorrectFormat($key, $newSaveStuff[$key], $value);
		}
		elseif(
			$$key !== $defaultConfig[$key] &&
			(
				!isset($themeDefaultSettings) ||
				isset($themeDefaultSettings) && !array_key_exists($key, $themeDefaultSettings) ||
				isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
			)
			||
			$$key === $defaultConfig[$key] && isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
			||
			isset($arrayOfCustomConfig[$key])
		)
		{
			$newInfoForConfig .= putIntoCorrectFormat($key, $$key, $value);
		}
	}
	$newInfoForConfig .= "
		);
	?>";
	if(file_exists($fileName))
	{
		unlink($fileName);
	}
	file_put_contents($fileName, $newInfoForConfig);
}

function loadSpecificVar($default, $custom, $configLookFor)
{
	$currentTheme = $default[$configLookFor];
	if(isset($custom[$configLookFor]))
	{
		$currentTheme = $custom[$configLookFor];
	}
	return $currentTheme;
}

function putIntoCorrectFormat($keyKey, $keyValue, $value)
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

function putIntoCorrectJSFormat($keyKey, $keyValue, $value)
{
	if(is_string($value))
	{
		return " var ".$keyKey." = '".trim(preg_replace('/\s\s+/', ' ', $keyValue))."';";
	}

	if(is_array($value))
	{
		return " var ".$keyKey." = ".json_encode($keyValue).";";
	}

	return " var ".$keyKey." = ".trim(preg_replace('/\s\s+/', ' ', $keyValue)).";";
}

function generateFolderColorRow($arrFCOdata = array())
{
	$edit = true;
	$key = "{{key}}";
	$currentFolderColorTheme = "{{currentFolderColorTheme}}";
	$i = "{{i}}";
	$value = 				array(
		"main"					=>	array(
			0						=>	array(
				"background"			=>	"#000",
				"fontColor"				=>	"#fff"
			)
		),
		"highlight"				=>	array(
			0						=>	array(
				"background"			=>	"#000",
				"fontColor"				=>	"#fff"
			)
		),
		"active"				=>	array(
			0						=>	array(
				"background"			=>	"#000",
				"fontColor"				=>	"#fff"
			)
		),
		"highlightActive"		=>	array(
			0						=>	array(
				"background"			=>	"#000",
				"fontColor"				=>	"#fff"
			)
		),
	);
	$themeName = "{{themeName}}";

	if(isset($arrFCOdata["key"]))
	{
		$key = $arrFCOdata["key"];
	}
	if(isset($arrFCOdata["currentFolderColorTheme"]))
	{
		$currentFolderColorTheme = $arrFCOdata["currentFolderColorTheme"];
	}
	if(isset($arrFCOdata["i"]))
	{
		$i = $arrFCOdata["i"];
	}
	if(isset($arrFCOdata["value"]))
	{
		$value = $arrFCOdata["value"];
	}
	if(isset($arrFCOdata["themeName"]))
	{
		$themeName = $arrFCOdata["themeName"];
	}
	if((strpos($key, "default") > -1))
	{
		$edit = false;
	}

	$td1 = "<input type=\"radio\" name=\"currentFolderColorTheme\" ";
	if ($key == $currentFolderColorTheme)
	{
		$td1 .= "checked='checked'";
	}
	$td1 .= " value=\"".$key."\"> ".$key.": ";
	$htmlToReturn = "<td>".$td1."</td>";
	$td1p5 = "<td>";
	if($edit)
	{
		$td1p5 .= "<div class=\"linkSmall\" onclick=\"removeRow(".$i.")\" >Remove</div>";
	}
	$td1p5 .= "</td>";
	$htmlToReturn .= $td1p5;
	$td2 = "<input style=\"display: none;\" type=\"text\" name=\"folderColorThemeNameForPost".$i."\" value=\"".$key."\" > Main Colors: <span id=\"folderColorThemeNameForPost".$i."Main\">";
	if($i !== "{{i}}")
	{
		$j = 0;
		foreach ($value['main'] as $value2)
		{
			$j++;
			$td2 .= generateColorBlock(array(
				"backgroundColor"			=>	$value2['background'],
				"fontColor"					=>	$value2['fontColor'],
				"i"							=>	$i,
				"j"							=>	$j,
				"name"						=>	"Main",
				"edit"						=>	$edit
			));
		}
	}
	else
	{
		$td2 .= generateColorBlock(array(
			"i"							=>	$i,
			"j"							=>	"{{j}}",
			"name"						=>	"Main",
			"edit"						=>	true
		));
	}
	$td2B = "<div style=\"display: inline-block; width: 20px;\"  ></div>";
	if($edit || $i === "{{i}}")
	{
		$td2B = "<div class=\"colorSelectorDiv addBorder\" id=\"folderColorThemeNameForPost".$i."Add\" onclick=\"addColorBlock(".$i.")\" style=\"display: inline-block; text-align: center; line-height: 18px; cursor: pointer; \"  >+</div>";
		$td2B .= "<div class=\"colorSelectorDiv addBorder\" id=\"folderColorThemeNameForPost".$i."Remove\" onclick=\"removeColorBlock(".$i.")\" style=\"display: inline-block; text-align: center; line-height: 18px; cursor: pointer; \"  >-</div>";
	}
	$td2 .= "</span>".$td2B;
	$htmlToReturn .= "<td>".$td2."</td>";
	$td3 = "Highlight: <span>";
	if($i !== "{{i}}")
	{
		$j = 0;
		foreach ($value['highlight'] as $value2)
		{
			$j++;
			$td3 .= generateColorBlock(array(
				"backgroundColor"			=>	$value2['background'],
				"fontColor"					=>	$value2['fontColor'],
				"i"							=>	$i,
				"j"							=>	$j,
				"name"						=>	"Highlight",
				"edit"						=>	$edit
			));
		}
	}
	else
	{
		$td3 .= generateColorBlock(array(
			"i"							=>	$i,
			"j"							=>	"{{j}}",
			"name"						=>	"Highlight",
			"edit"						=>	true
		));
	}
	$td3 .= "</span>";
	$htmlToReturn .= "<td>".$td3."</td>";
	$td4 = " Updated: <span >";
	if($i !== "{{i}}")
	{
		$j = 0;
		foreach ($value['active'] as $value2)
		{
			$j++;
			$td4 .= generateColorBlock(array(
				"backgroundColor"			=>	$value2['background'],
				"fontColor"					=>	$value2['fontColor'],
				"i"							=>	$i,
				"j"							=>	$j,
				"name"						=>	"Active",
				"edit"						=>	$edit
			));
		}
	}
	else
	{
		$td4 .= generateColorBlock(array(
			"i"							=>	$i,
			"j"							=>	"{{j}}",
			"name"						=>	"Active",
			"edit"						=>	true
		));
	}
	$td4 .="</span>";
	$htmlToReturn .= "<td>".$td4." </td>";
	$td5 = " Updated highlight:	<span >";
	if($i !== "{{i}}")
	{
		$j = 0;
		foreach ($value['highlightActive'] as $value2)
		{
			$j++;
			$td5 .= generateColorBlock(array(
				"backgroundColor"			=>	$value2['background'],
				"fontColor"					=>	$value2['fontColor'],
				"i"							=>	$i,
				"j"							=>	$j,
				"name"						=>	"ActiveHighlight",
				"edit"						=>	$edit
			));
		}
	}
	else
	{
		$td5 .= generateColorBlock(array(
			"i"							=>	$i,
			"j"							=>	"{{j}}",
			"name"						=>	"ActiveHighlight",
			"edit"						=>	true
		));
	}
	$td5 .= "</span>";
	$htmlToReturn .= "<td>".$td5."</td>";
	return array(
		"html"					=>	$htmlToReturn,
		"td1"					=>	$td1,
		"td1p5"					=>	$td1p5,
		"td2"					=>	$td2,
		"td3"					=>	$td3,
		"td4"					=>	$td4,
		"td5"					=>	$td5
	);
}

function generateColorBlock($arrCBdata = array())
{
	$backgroundColor = "{{backgroundColor}}";
	$fontColor = "{{fontColor}}";
	$i = "{{i}}";
	$j = "{{j}}";
	$name = "{{name}}";
	$edit = true;

	if(isset($arrCBdata["backgroundColor"]))
	{
		$backgroundColor = $arrCBdata["backgroundColor"];
	}
	if(isset($arrCBdata["fontColor"]))
	{
		$fontColor = $arrCBdata["fontColor"];
	}
	if(isset($arrCBdata["i"]))
	{
		$i = $arrCBdata["i"];
	}
	if(isset($arrCBdata["j"]))
	{
		$j = $arrCBdata["j"];
	}
	if(isset($arrCBdata["name"]))
	{
		$name = $arrCBdata["name"];
	}
	if(isset($arrCBdata["edit"]))
	{
		$edit = $arrCBdata["edit"];
	}

	$htmlToReturn = "";
	$htmlToReturn .= "<div class=\"divAroundColors\">";
	$htmlToReturn .= generateColorBlockInner($name."Background".$i."-".$j, $backgroundColor, array("edit" => $edit, "style" => "border-bottom: 0px;"));
	$htmlToReturn .= generateColorBlockInner($name."Font".$i."-".$j, $fontColor, array("edit" => $edit, "style" => "border-top: 0px;"));
	$htmlToReturn .= "</div>";
	return $htmlToReturn;
}

function generateColorBlockInner($buttonID, $color, $data = array())
{
	$edit = true;
	$style = "";
	$name = "folderColorValue".$buttonID;
	$inputDisplay = "none";
	if(isset($data["edit"]))
	{
		$edit = $data["edit"];
	}
	if(isset($data["style"]))
	{
		$style = $data["style"];
	}
	if(isset($data["name"]))
	{
		$name = $data["name"];
	}
	if(isset($data["inputDisplay"]))
	{
		$inputDisplay = $data["inputDisplay"];
	}
	$htmlToReturn = "";
	if($edit)
	{
		$htmlToReturn .= "<div class=\"colorSelectorDiv\" style=\"".$style."\" >";
		$htmlToReturn .= "<div class=\"inner-triangle-2\" ></div>";
		$htmlToReturn .= "<div class=\"inner-triangle\" ></div>";
		$htmlToReturn .= "<button id=\"folderColorButton".$buttonID."\" class=\"backgroundButtonForColor\"></button>";
	}
	else
	{
		$htmlToReturn .=	"<div class=\"colorSelectorDiv addBorder\" style=\"background-color: ".$color."; ".$style."\" >";
	}
	$htmlToReturn .=	"</div>";
	$htmlToReturn .=	"<input style=\"width: 100px; display: ".$inputDisplay.";\" type=\"text\" id=\"folderColorValue".$buttonID."\" name=\"".$name."\" value=\"".$color."\" >";
	return $htmlToReturn;
}
<?php
class settings
{

	private function getData($loadVarsArray, $confDataValue)
	{
		if(isset($confDataValue["var"]["value"]))
		{
			return $confDataValue["var"]["value"];
		}
		$keyVar = "";
		if(isset($confDataValue["var"]) && isset($confDataValue["var"]["key"]))
		{
			$keyVar = $confDataValue["var"]["key"];
		}
		elseif(isset($confDataValue["key"]))
		{
			$keyVar = $confDataValue["key"];
		}
		if(isset($loadVarsArray[$keyVar]))
		{
			return $loadVarsArray[$keyVar];
		}
		if(isset($confDataValue["value"]))
		{
			return $confDataValue["value"];
		}
		return "";
	}

	public function addResetButton($idOfForm)
	{
		return "<a onclick=\"resetArrayObject('".$idOfForm."');\" style=\"display: none;\" class=\"linkSmall ".$idOfForm."ResetButton\" > Reset Current Changes</a><span class=\"".$idOfForm."NoChangesDetected\" >No Changes Detected</span>";
	}

	public function createSelect($options, $selectValue, $defaultOption = false)
	{
		$selectHtml = "";
		$selected = false;
		foreach ($options as $value)
		{
			$selectHtml .= "<option value=\"".$value["value"]."\" ";
			if($selectValue === $value["value"] && $selected !== true)
			{
				$selectHtml .= " selected ";
				$selected = true;
			}
			$selectHtml .= " >".$value["name"]."</option>";
		}
		if($defaultOption)
		{
			$selectHtml .= "<option value=\"".$defaultOption["value"]."\" ";
			if($selected !== true)
			{
				$selectHtml .= " selected ";
			}
			$selectHtml .= " >".$defaultOption["name"]."</option>";
		}
		return $selectHtml;
	}

	private function generateFullSelect($confDataValue, $selectValue, $varName)
	{
		$returnHtml = "";
		$selectId = "";
		if(isset($confDataValue["id"]))
		{
			$selectId = " id=\"".$confDataValue["id"]."\" ";
		}
		if(isset($confDataValue["name"]) && $confDataValue["name"] !== "")
		{
			$returnHtml .= "<span class=\"settingsBuffer\" > ".$confDataValue["name"].": </span>";
		}
		$onChangeFunction = "";
		if(isset($confDataValue["function"]) && $confDataValue["function"] !== "")
		{
			$onChangeFunction = "onchange=\"".$confDataValue["function"]."();\"";
		}
		$returnHtml .= " <div class=\"selectDiv\"><select ".$selectId." ".$onChangeFunction." name=\"".$varName."\">";
		$returnHtml .= $this->createSelect($confDataValue["options"], $selectValue);
		$returnHtml .= "</select></div>";
		return $returnHtml;
	}

	private function generateNumber($confDataValue, $numberValue, $varName)
	{
		$returnHtml = "<span class=\"settingsBuffer\" > ".$confDataValue["name"].": </span>";
		$returnHtml .= " <input type=\"number\" pattern=\"[0-9]*\" name=\"".$varName."\" value=\"".$numberValue."\" >";
		return $returnHtml;
	}

	private function generateHidden($confDataValue, $numberValue, $varName)
	{
		$returnHtml = " <input id=\"".$confDataValue["id"]."\" type=\"hidden\" name=\"".$varName."\" value='".$numberValue."' >";
		return $returnHtml;
	}

	private function generateText($confDataValue, $numberValue, $varName)
	{
		$returnHtml = "<span class=\"settingsBuffer\" > ".$confDataValue["name"].": </span>";
		$returnHtml .= " <input type=\"text\" name=\"".$varName."\" value=\"".$numberValue."\" >";
		return $returnHtml;
	}

	private function generateColor($confDataValue, $numberValue, $varName)
	{
		$returnHtml = "<span class=\"settingsBuffer\" > ".$confDataValue["name"].": </span>";
		if(strpos($numberValue, "#") === 0 && (strlen($numberValue) === 4 || strlen($numberValue) === 7 ))
		{
			$returnHtml .= $this->generateSettingsColorBlockInner("colorBlock".$varName, $numberValue, array("name" => $varName, "inputDisplay" => "inline-block"));
			$returnHtml .= "
			<script type=\"text/javascript\">
			if(typeof colorPickerData !== \"object\")
			{
				var colorPickerData = {};
			}
			var timerFor".$varName." = null;
			$( document ).ready(function() {
				colorPickerData[\"timerFor".$varName."\"][\"arg1\"] = \"folderColorButtoncolorBlock".$varName."\";
				colorPickerData[\"timerFor".$varName."\"][\"arg2\"] = \"folderColorValuecolorBlock".$varName."\";
				if(typeof jscolor === \"function\")
				{
					colorPickerData[\"timerFor".$varName."\"][\"function\"](\"folderColorButtoncolorBlock".$varName."\",\"folderColorValuecolorBlock".$varName."\");
				}
				else
				{
					setTimeout(function() {
						timerFor".$varName." = setInterval(function () {
							colorPickerData[\"timerFor".$varName."\"][\"function\"](\"folderColorButtoncolorBlock".$varName."\",\"folderColorValuecolorBlock".$varName."\")}, 1000);
					}, 250);
				}
			});
			colorPickerData[\"timerFor".$varName."\"] = {};
			colorPickerData[\"timerFor".$varName."\"][\"function\"] = function (buttonId, valueId)
			{
				if(typeof jscolor === \"function\")
				{
					new jscolor(
						document.getElementById(buttonId), {
							valueElement: valueId,
							hash:true
						}
					);
					if(timerFor".$varName." !== null)
					{
						clearInterval(timerFor".$varName.");
					}
					timerFor".$varName." = null;
				}
			}
			</script>
			";
		}
		else
		{
			$returnHtml .= $this->generateSettingsColorBlockInner("colorBlock".$varName, $numberValue, array("edit" => false));
		}
		return $returnHtml;
	}

	private function generateGenericType($confDataValue, $confDataKeyValue, $confDataKey)
	{
		$returnHtml = "";
		if($confDataValue["type"] === "number")
		{
			$returnHtml .= $this->generateNumber($confDataValue,$confDataKeyValue,$confDataKey);
		}
		if($confDataValue["type"] === "color")
		{
			$returnHtml .= $this->generateColor($confDataValue,$confDataKeyValue,$confDataKey);
		}
		else if($confDataValue["type"] === "text")
		{
			$returnHtml .= $this->generateText($confDataValue,$confDataKeyValue,$confDataKey);
		}
		elseif($confDataValue["type"] === "dropdown")
		{
			$returnHtml .= $this->generateFullSelect($confDataValue,$confDataKeyValue,$confDataKey);
		}
		elseif($confDataValue["type"] === "hidden")
		{
			$returnHtml .= $this->generateHidden($confDataValue,$confDataKeyValue,$confDataKey);
		}
		if(isset($confDataValue["postText"]) && $confDataValue["postText"] !== "")
		{
			$returnHtml .= " ".$confDataValue["postText"];
		}
		return $returnHtml;
	}

	public function varTemplateLogic($confDataValue, $loadVarsArray, $infoImage)
	{
		if($confDataValue["type"] === "single")
		{
			echo "<li";
			if($confDataValue["var"]["type"] === "hidden")
			{
				echo " style=\"display: none;\"  ";
			}
			echo ">".$this->generateGenericType($confDataValue["var"], $this->getData($loadVarsArray, $confDataValue), $confDataValue["var"]["key"])."</li>";
		}
		elseif($confDataValue["type"] === "linked")
		{
			echo "<li>";
			foreach ($confDataValue["vars"] as $confDataInnerValue)
			{
				echo $this->generateGenericType($confDataInnerValue, $this->getData($loadVarsArray, $confDataInnerValue), $confDataInnerValue["key"])." ";
			}
			echo "</li>";
		}
		elseif($confDataValue["type"] === "grouped")
		{
			echo "<li>".$this->generateGenericType($confDataValue["var"], $this->getData($loadVarsArray, $confDataValue), $confDataValue["var"]["key"])."</li>";
			echo "<li><div id=\"".$confDataValue["id"]."\" style=\" ";
			if($confDataValue["bool"])
			{
				echo 'display: none;';
			}
			echo " \" ><div class=\"settingsHeader\">".$confDataValue["name"]."</div><div class=\"settingsDiv\" ><ul class=\"settingsUl\">";
			foreach ($confDataValue["vars"] as $confDataInnerValue)
			{
				$this->varTemplateLogic($confDataInnerValue, $loadVarsArray, $infoImage);
			}
			echo "</ul></div></div></li>";
			$functionName = $confDataValue["var"]["function"];
			if(isset($confDataValue["var"]["functionForToggle"]))
			{
				$functionName = $confDataValue["var"]["functionForToggle"];
			}
			$boolForFunction = "true";
			if(isset($confDataValue["bool2"]))
			{
				$boolForFunction = $confDataValue["bool2"];
			}
			echo "<script type=\"text/javascript\">
				function ".$functionName."()
				{
					try
					{
						showOrHideSubWindow( document.getElementById(\"".$confDataValue["var"]["id"]."\") , document.getElementById(\"".$confDataValue["id"]."\") , \"".$boolForFunction."\" );
					}
					catch(e)
					{
						eventThrowException(e);
					}
				}
			</script>";
		}
		elseif($confDataValue["type"] === "custom")
		{
			echo "<li>".$confDataValue["custom"]."</li>";
		}

		if(isset($confDataValue["info"]) && $confDataValue["info"] !== "")
		{
			echo $this->generateInfo($infoImage,$confDataValue["info"]);
		}
	}

	private function generateInfo($image, $info)
	{
		$returnHtml = "<li><span style=\"font-size: 75%;\">";
		$returnHtml .= $image;
		$returnHtml .= "  <i>".$info."</i></span></li>";
		return $returnHtml;
	}

	private function generateSettingsColorBlockInner($buttonID, $color, $data = array())
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

	public function generateRestoreList($configStatic)
	{
		$returnHtml = "<form id='revertForm' action='../restore/restore.php'  method='post'  style='display: inline-block;' ><select name='versionRevertTo' >";
		$versionList = $configStatic['versionList'];
		$versionListText = "";
		foreach ($versionList as $key => $value)
		{
			$versionListText = "<option value='".str_replace("Update", "", $value['branchName'])."' >".$key."</option>".$versionListText;
		}
		$returnHtml .= $versionListText."</select></form>";
		return $returnHtml;
	}

	public function generateFolderColorRow($arrFCOdata = array())
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
				$td2 .= $this->generateColorBlock(array(
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
			$td2 .= $this->generateColorBlock(array(
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
				$td3 .= $this->generateColorBlock(array(
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
			$td3 .= $this->generateColorBlock(array(
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
				$td4 .= $this->generateColorBlock(array(
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
			$td4 .= $this->generateColorBlock(array(
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
				$td5 .= $this->generateColorBlock(array(
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
			$td5 .= $this->generateColorBlock(array(
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

	public function generateColorBlock($arrCBdata = array())
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
		$htmlToReturn .= $this->generateColorBlockInner($name."Background".$i."-".$j, $backgroundColor, array("edit" => $edit, "style" => "border-bottom: 0px;"));
		$htmlToReturn .= $this->generateColorBlockInner($name."Font".$i."-".$j, $fontColor, array("edit" => $edit, "style" => "border-top: 0px;"));
		$htmlToReturn .= "</div>";
		return $htmlToReturn;
	}

	private function generateColorBlockInner($buttonID, $color, $data = array())
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

}
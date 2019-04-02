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

}
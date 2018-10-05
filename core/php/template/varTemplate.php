<form id="<?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>">
<div class="settingsHeader">
<?php echo $defaultConfigMoreData[$currentSection]["name"]; ?>
<div class="settingsHeaderButtons">
	<?php echo addResetButton($defaultConfigMoreData[$currentSection]["id"]);?>
	<a class="linkSmall" onclick="saveAndVerifyMain('<?php echo $defaultConfigMoreData[$currentSection]["id"]; ?>');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul class="settingsUl">
	<?php
	foreach ($defaultConfigMoreData[$currentSection]["vars"] as $confDataValue)
	{
		if($confDataValue["type"] === "single")
		{
			echo "<li>".generateGenericType($confDataValue["var"], getData($loadVarsArray, $confDataValue), $confDataValue["var"]["key"])."</li>";
		}
		elseif($confDataValue["type"] === "linked")
		{
			echo "<li>";
			foreach ($confDataValue["vars"] as $confDataInnerValue)
			{
				echo generateGenericType($confDataInnerValue, getData($loadVarsArray, $confDataInnerValue), $confDataInnerValue["key"])." ";
			}
			echo "</li>";
		}
		elseif($confDataValue["type"] === "grouped")
		{
			echo "<li>".generateGenericType($confDataValue["var"], getData($loadVarsArray, $confDataValue), $confDataValue["var"]["key"])."</li>";
			echo "<li><div id=\"".$confDataValue["id"]."\" style=\" ";
			if($confDataValue["bool"])
			{
				echo 'display: none;';
			}
			echo " \" ><div class=\"settingsHeader\">".$confDataValue["name"]."</div><div class=\"settingsDiv\" ><ul class=\"settingsUl\">";
			foreach ($confDataValue["vars"] as $confDataInnerValue)
			{
				if($confDataInnerValue["type"] === "single")
				{
					echo "<li>".generateGenericType($confDataInnerValue["var"],getData($loadVarsArray, $confDataInnerValue),$confDataInnerValue["var"]["key"])."</li>";
					if(isset($confDataInnerValue["info"]) && $confDataInnerValue["info"] !== "")
					{
						echo generateInfo($infoImage,$confDataInnerValue["info"]);
					}
				}
				elseif($confDataValue["type"] === "linked")
				{
					echo "<li>";
					foreach ($confDataInnerValue["vars"] as $confDataInnerValueTwo)
					{
						echo generateGenericType($confDataInnerValueTwo, getData($loadVarsArray, $confDataInnerValueTwo), $confDataInnerValueTwo["key"])." ";
					}
					echo "</li>";
				}
				elseif($confDataInnerValue["type"] === "custom")
				{
					echo "<li>".$confDataInnerValue["custom"]."</li>";
				}
			}
			echo "</ul></div></div></li>";
			$functionName = $confDataValue["var"]["function"];
			if(isset($confDataValue["var"]["functionForToggle"]))
			{
				$functionName = $confDataValue["var"]["functionForToggle"];
			}
			$boolForFunction = "false";
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
			echo generateInfo($infoImage,$confDataValue["info"]);
		}
	}
	?>
</ul>
</div>
</form>
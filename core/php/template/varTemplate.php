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
			echo "<li>".generateGenericType($confDataValue["var"], $loadVarsArray[$confDataValue["var"]["key"]], $confDataValue["var"]["key"])."</li>";
		}
		elseif($confDataValue["type"] === "linked")
		{
			echo "<li>";
			foreach ($confDataValue["vars"] as $confDataInnerValue)
			{
				echo generateGenericType($confDataInnerValue, $loadVarsArray[$confDataInnerValue["key"]], $confDataInnerValue["key"])." ";
			}
			echo "</li>";
		}
		elseif($confDataValue["type"] === "grouped")
		{
			echo "<li>".generateGenericType($confDataValue["var"], $loadVarsArray[$confDataValue["var"]["key"]], $confDataValue["var"]["key"])."</li>";
			echo "<li><div id=\"".$confDataValue["id"]."\" style=\" ";
			if($confDataValue["bool"])
			{
				echo 'display: none;';
			}
			echo " \" ><div class=\"settingsHeader\">".$confDataValue["name"]."</div><div class=\"settingsDiv\" ><ul class=\"settingsUl\">";
			foreach ($confDataValue["vars"] as $confDataInnerValue)
			{
				echo "<li>".generateGenericType($confDataInnerValue["var"],$loadVarsArray[$confDataInnerValue["var"]["key"]],$confDataInnerValue["var"]["key"])."</li>";
			}
			echo "</ul></div></div></li><script>$( document ).ready(function(){document.getElementById(\"".$confDataValue["var"]["id"]."\").addEventListener(\"change\", ".$confDataValue["function"].", false);});</script>";
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
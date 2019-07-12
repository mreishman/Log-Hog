<span id="groupsSpanSideBar" style="display: none; width: 100%;">
	<h3 class="addBorderBottom">Groups</h3>
	Groups:
	<span class="selectDiv">
		<select multiple="true" id="selectForGroup" >
			<option selected="true" value="all" >All</option>
		</select>
	</span>
	<br>
	<br>
	Layout Version
	<br>
	<span onclick="swapGroupLayoutLetters('A');" class="linkSmall" >A</span>
	<span onclick="swapGroupLayoutLetters('B');" class="linkSmall" >B</span>
	<span onclick="swapGroupLayoutLetters('C');" class="linkSmall" >C</span>
	<input type="hidden" id="layoutGroupVersionIndex" value="A" >
	<br>
	<br>
	Save Current Layout To
	<br>
	<span onclick="saveGroupLayoutTo('A');" class="linkSmall" >A</span>
	<span onclick="saveGroupLayoutTo('B');" class="linkSmall" >B</span>
	<span onclick="saveGroupLayoutTo('C');" class="linkSmall" >C</span>
	<br>
	<br>
	<form id="groupLayoutPresetForm">
		<input type="hidden" name="groupPresetA" id="groupPresetA" value="<?php echo $groupPresetA; ?>" >
		<input type="hidden" name="groupPresetB" id="groupPresetB" value="<?php echo $groupPresetB; ?>" >
		<input type="hidden" name="groupPresetC" id="groupPresetC" value="<?php echo $groupPresetC; ?>" >
	</form>
</span>
<h3 class="addBorderBottom">Filters</h3>
<input <?php if (!($filterSearchInHeader !== "true" && $filterEnabled === "true")){ echo "style='display: none;'";} ?> id="searchFieldInputSideBar" type="search" name="search" placeholder="Filter <?php echo $filterDefault; ?>">
<span id="filterSettingsSideBar" <?php if ($filterEnabled !== "true"){ echo "style='display: none;'"; } ?> >
	Search:
	<span class="selectDiv" >
		<select id="searchType" name="searchType">
			<option <?php if ($filterDefault === "title"){echo "selected"; }?> value="title">Title</option>
			<option <?php if ($filterDefault === "content"){echo "selected"; }?> value="content">Content</option>
		</select>
	</span>
	<br>
	<ul>
	<?php
	$arrOfVars = array(
		array(
			"type"								=>	"single",
			"var"								=>	array(
				"function"							=>	"changeFilterCase",
				"hideKeyName"						=>	true,
				"id"								=>	"caseInsensitiveSearch",
				"key"								=>	"caseInsensitiveSearch",
				"name"								=>	"Case Insensitive Search",
				"options"							=>	$trueFalsVars,
				"type"								=>	"dropdown"
			)
		),
		array(
			"type"								=>	"single",
			"var"								=>	array(
				"function"							=>	"changeFilterInvert",
				"hideKeyName"						=>	true,
				"id"								=>	"filterInvert",
				"key"								=>	"filterInvert",
				"name"								=>	"Invert Search",
				"options"							=>	$trueFalsVars,
				"type"								=>	"dropdown"
			)
		),
		array(
			"type"								=>	"single",
			"var"								=>	array(
				"function"							=>	"changeFilterTitleIncludePath",
				"hideKeyName"						=>	true,
				"id"								=>	"filterTitleIncludePath",
				"key"								=>	"filterTitleIncludePath",
				"name"								=>	"Filter Title Includes Path",
				"options"							=>	$trueFalsVars,
				"type"								=>	"dropdown"
			)
		),
		array(
			"type"								=>	"single",
			"var"								=>	array(
				"function"							=>	"changeHighlightContentMatch",
				"hideKeyName"						=>	true,
				"id"								=>	"filterContentHighlightSideBar",
				"key"								=>	"filterContentHighlight",
				"name"								=>	"Highlight Content match",
				"options"							=>	$trueFalsVars,
				"type"								=>	"dropdown"
			)
		),
		array(
			"type"								=>	"single",
			"var"								=>	array(
				"function"							=>	"changeHighlightContentMatchLine",
				"hideKeyName"						=>	true,
				"id"								=>	"filterContentHighlightLine",
				"key"								=>	"filterContentHighlightLine",
				"name"								=>	"Hilight Entire Line",
				"options"							=>	$trueFalsVars,
				"type"								=>	"dropdown"
			)
		),
		array(
			"type"								=>	"single",
			"var"								=>	array(
				"function"							=>	"changeFilterContentMatch",
				"hideKeyName"						=>	true,
				"id"								=>	"filterContentLimitSideBar",
				"key"								=>	"filterContentLimit",
				"name"								=>	"Filter Content match",
				"options"							=>	$trueFalsVars,
				"type"								=>	"dropdown"
			),
		),
		array(
			"type"								=>	"single",
			"var"								=>	array(
				"function"							=>	"changeFilterContentLinePadding",
				"hideKeyName"						=>	true,
				"id"								=>	"filterContentLinePadding",
				"key"								=>	"filterContentLinePadding",
				"name"								=>	"Line Padding",
				"options"							=>	$oneToTenArr,
				"type"								=>	"dropdown"
			)
		)
	);
	foreach ($arrOfVars as $arrVar)
	{
	 	$settings->varTemplateLogic($arrVar, $loadVarsArray);
	} ?>
	</ul>
</span>
<?php if($enableMultiLog === "true"): ?>
	<h3 class="addBorderBottom" >Multi-Log</h3>
	Log Layout
	<?php $arrayOfwindowConfigOptionsLocal = array();
	for ($i=0; $i < 3; $i++)
	{
		for ($j=0; $j < 3; $j++)
		{
			array_push($arrayOfwindowConfigOptionsLocal, "".($i+1)."x".($j+1));
		}
	}
	?>
	<span class="selectDiv">
		<select id="windowConfig">
			<?php
			$currentSessionValue = $windowConfig;
			if(isset($_COOKIE["windowConfig"]) && $logLoadPrevious === "true")
			{
				$cookieData = json_decode($_COOKIE["windowConfig"]);
				$currentSessionValue = $cookieData;
			}
			foreach ($arrayOfwindowConfigOptionsLocal as $value)
			{
				$stringToEcho = "<option ";
				if($value === $currentSessionValue)
				{
					$stringToEcho .= " selected ";
				}
				$stringToEcho .= " value=\"".$value."\"> ".$value."</option>";
				echo $stringToEcho;
			}
			?>
		</select>
	</span>
	<br>
	<br>
	Layout Version
	<br>
	<span onclick="swapLayoutLetters('A');" class="linkSmall" >A</span>
	<span onclick="swapLayoutLetters('B');" class="linkSmall" >B</span>
	<span onclick="swapLayoutLetters('C');" class="linkSmall" >C</span>
	<input type="hidden" id="layoutVersionIndex" value="A" >
	<br>
	<br>
	<span onclick="resetSelection();" class="linkSmall">Reset Selection</span>
	<br>
	<br>
	Save Current Layout To
	<br>
	<span onclick="saveLayoutTo('A');" class="linkSmall" >A</span>
	<span onclick="saveLayoutTo('B');" class="linkSmall" >B</span>
	<span onclick="saveLayoutTo('C');" class="linkSmall" >C</span>
	<br>
	<br>
<?php endif; ?>
<h3 class="addBorderBottom">Header Bar</h3>
<span id="oneLogSettingsSideBar" <?php if($oneLogEnable !== "true"){ echo "style='display: none;'";} ?>>
	Show One Log
	<span class="selectDiv">
		<select onchange="toggleVisibleOneLog();" id="oneLogVisible">
			<option <?php if($oneLogVisible === "true"){ echo " selected "; }?>  value="true" >True</option>
			<option <?php if($oneLogVisible === "false"){ echo " selected "; }?>  value="false" >False</option>
		</select>
	</span>
	<br>
	<br>
</span>
Hide Log Tabs
<span class="selectDiv">
	<select onchange="toggleVisibleAllLogs();" id="allLogsVisible">
		<option <?php if($allLogsVisible === "false"){ echo " selected "; }?>  value="false" >True</option>
		<option <?php if($allLogsVisible === "true"){ echo " selected "; }?>  value="true" >False</option>
	</select>
</span>
<h3 class="addBorderBottom">Logs</h3>
<ul>
<?php if($advancedLogFormatEnabled === "true")
{
	$settings->varTemplateLogic(
		array(
			"type"								=>	"single",
			"var"								=>	array(
				"function"							=>	"tmpChangeAdvancedLogFormat",
				"hideKeyName"						=>	true,
				"id"								=>	"advancedLogFormatEnabled",
				"key"								=>	"advancedLogFormatEnabled",
				"name"								=>	"Advanced Log Format",
				"options"							=>	$trueFalsVars,
				"type"								=>	"dropdown"
			)
		)
		,
		$loadVarsArray
	);
}
$settings->varTemplateLogic(
		array(
			"type"								=>	"single",
			"var"								=>	array(
				"function"							=>	"toggleLogDirectionInvert",
				"hideKeyName"						=>	true,
				"id"								=>	"logDirectionInvert",
				"key"								=>	"logDirectionInvert",
				"name"								=>	"Reverse log text",
				"options"							=>	$trueFalsVars,
				"type"								=>	"dropdown"
			)
		)
		,
		$loadVarsArray
	);
?>
</ul>
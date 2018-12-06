<h3 class="addBorderBottom">Filters</h3>
<?php if ($filterSearchInHeader !== "true" && $filterEnabled === "true"): ?>
	<input disabled id="searchFieldInput" type="search" name="search" placeholder="Filter <?php echo $filterDefault; ?>" style="height: 30px; width: 180px; margin-right: 10px;">
<?php endif; ?>
<?php if ($groupDropdownInHeader !== "true"): ?>
	Groups:
	<span class="selectDiv">
		<select id="selectForGroup" >
			<option selected="true" value="all" >All</option>
		</select>
	</span>
	<br>
	<br>
<?php endif; ?>
<?php if ($filterEnabled === "true"): ?>
	Search:
	<span class="selectDiv" >
		<select id="searchType" disabled name="searchType">
			<option <?php if ($filterDefault === "title"){echo "selected"; }?> value="title">Title</option>
			<option <?php if ($filterDefault === "content"){echo "selected"; }?> value="content">Content</option>
		</select>
	</span>
	<br>
	<br>
	Case Insensitive:
	<span class="selectDiv" >
		<select onchange="changeFilterCase();" id="caseInsensitiveSearch">
			<option <?php if ($caseInsensitiveSearch === "true"){ echo "selected"; }?> value="true">True</option>
			<option <?php if ($caseInsensitiveSearch === "false"){ echo "selected"; }?> value="false">False</option>
		</select>
	</span>
	<br>
	<br>
	Title Includes Path:
	<span class="selectDiv" >
		<select onchange="changeFilterTitleIncludePath();" id="filterTitleIncludePath">
			<option <?php if ($filterTitleIncludePath === "true"){ echo "selected"; }?> value="true">True</option>
			<option <?php if ($filterTitleIncludePath === "false"){ echo "selected"; }?> value="false">False</option>
		</select>
	</span>
	<br>
	<br>
	Highlight Content Match:
	<span class="selectDiv" >
		<select onchange="changeHighlightContentMatch();" id="filterContentHighlight">
			<option <?php if ($filterContentHighlight === "true"){ echo "selected"; }?> value="true">True</option>
			<option <?php if ($filterContentHighlight === "false"){ echo "selected"; }?> value="false">False</option>
		</select>
	</span>
	<br>
	<br>
	Filter Content Match:
	<span class="selectDiv" >
		<select onchange="changeFilterContentMatch();" id="filterContentLimit">
			<option <?php if ($filterContentLimit === "true"){ echo "selected"; }?> value="true">True</option>
			<option <?php if ($filterContentLimit === "false"){ echo "selected"; }?> value="false">False</option>
		</select>
	</span>
	<br>
	<br>
	Line Padding:
	<span class="selectDiv" >
		<select onchange="changeFilterContentLinePadding();" id="filterContentLinePadding">
			<?php for($CFC = 0; $CFC < 10; $CFC++): ?>
				<option <?php if ($filterContentLinePadding === $CFC){ echo "selected"; }?> value="<?php echo $CFC; ?>"><?php echo $CFC; ?></option>
			<?php endfor; ?>
		</select>
	</span>
	<br>
	<br>
<?php endif; ?>
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
			<?php foreach ($arrayOfwindowConfigOptionsLocal as $value)
			{
				$stringToEcho = "<option ";
				if($value === $windowConfig)
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
Show One Log
<span class="selectDiv">
	<select onchange="toggleVisibleOneLog();" id="oneLogVisible">
		<option <?php if($oneLogVisible === "true"){ echo " selected "; }?>  value="true" >True</option>
		<option <?php if($oneLogVisible === "false"){ echo " selected "; }?>  value="false" >False</option>
	</select>
</span>
<br>
<br>
Hide Log Tabs
<span class="selectDiv">
	<select onchange="toggleVisibleAllLogs();" id="allLogsVisible">
		<option <?php if($allLogsVisible === "false"){ echo " selected "; }?>  value="false" >True</option>
		<option <?php if($allLogsVisible === "true"){ echo " selected "; }?>  value="true" >False</option>
	</select>
</span>
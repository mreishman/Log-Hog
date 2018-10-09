<?php if($enableMultiLog === "true"): ?>
	<h3 style="border-bottom: 1px solid white;">Multi-Log</h3>
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
	<div class="selectDiv">
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
	</div>
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
<h3 style="border-bottom: 1px solid white;">One Log</h3>
Enable One Log
<div class="selectDiv">
	<select id="windowConfig">
		<option value="true" >True</option>
		<option value="false" >False</option>
	</select>
</div>
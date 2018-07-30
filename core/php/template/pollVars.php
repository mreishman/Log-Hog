<?php

$defaultConfigMoreDataPollVars 	= array(
	0									=> array(
		'type'								=>	"linked",
		'vars'								=>	array(
			0									=>	array(
				'key'								=>	"pollingRate",
				'name'								=>	"Polling Rate",
				'type'								=>	"number"
			),
			1								=>	array(
				'key'								=>	"pollingRateType",
				'options'							=>	array(
					0 									=> array(
						"value" 							=> "Milliseconds",
						"name" 								=> "Milliseconds"),
					1 									=> array(
						"value" 							=> "Seconds",
						"name" 								=> "Seconds")
				),
				'type'								=>	"dropdown"
			)
		)
	),
	1									=> array(
		'type'								=>	"linked",
		'vars'								=>	array(
			0									=>	array(
				'key'								=>	"backgroundPollingRate",
				'name'								=>	"Background Poll Rate",
				'type'								=>	"number"
			),
			1								=>	array(
				'key'								=>	"backgroundPollingRateType",
				'options'							=>	array(
					0 									=> array(
						"value" 							=> "Milliseconds",
						"name" 								=> "Milliseconds"),
					1 									=> array(
						"value" 							=> "Seconds",
						"name" 								=> "Seconds")
				),
				'type'								=>	"dropdown"
			)
		)
	),
	2									=> array(
		'type'								=>	"single",
		'var'								=>	array(
			'key'								=>	"fullScreenMenuPollSwitchDelay",
			'name'								=>	"Full Screen Menu delay",
			'postText'							=>	"Seconds",
			'type'								=>	"number"
		)
	),
	3									=> array(
		'type'								=>	"single",
		'var'								=>	array(
			'key'								=>	"fullScreenMenuPollSwitchType",
			'name'								=>	"Full Screen Menu Click",
			'options'							=>	array(
				0 									=> array(
					"value" 							=> "BGrate",
					"name" 								=> "Use Background Rate"),
				1 									=> array(
					"value" 							=> "Pause",
					"name" 							=> "Pause Poll")
			),
			'type'								=>	"dropdown"
		)
	),
	4									=> array(
		'info'								=>	"PHP method is more accurate, but will increase poll times",
		'type'								=>	"single",
		'var'								=>	array(
			'key'								=>	"lineCountFromJS",
			'name'								=>	"Line count from",
			'options'							=>	array(
				0 									=> array(
					"value" 							=> "true",
					"name" 								=> "JS"),
				1 									=> array(
					"value" 							=> "false",
					"name" 								=> "PHP")
			),
			'type'								=>	"dropdown"
		)
	),
	5									=>	array(
		'type'								=>	"single",
		'var'								=>	array(
			'key'								=>	"pauseOnNotFocus",
			'name'								=>	"Pause On Not Focus",
			'options'							=>	$trueFalsVars,
			'type'								=>	"dropdown"
		)
	),
	6									=>	array(
		'type'								=>	"single",
		'var'									=>	array(
			'key'								=>	"pausePoll",
			'name'								=>	"Pause Poll On Load",
			'options'							=>	$trueFalsVars,
			'type'								=>	"dropdown"
		)
	),
	7									=> array(
		'type'								=>	"linked",
		'vars'								=>	array(
			0									=>	array(
				'key'								=>	"pollRefreshAll",
				'name'								=>	"Poll refresh all data every",
				'postText'							=>	"poll requests",
				'type'								=>	"number"
			),
			1								=>	array(
				'key'								=>	"pollRefreshAllBool",
				'options'							=>	$trueFalsVars,
				'type'								=>	"dropdown"
			)
		)
	),
	8									=> array(
		'type'								=>	"linked",
		'vars'								=>	array(
			0									=>	array(
				'key'								=>	"pollForceTrue",
				'name'								=>	"Force poll refresh after",
				'postText'							=>	"skipped poll requests",
				'type'								=>	"number"
			),
			1								=>	array(
				'key'								=>	"pollForceTrueBool",
				'options'							=>	$trueFalsVars,
				'type'								=>	"dropdown"
			)
		)
	),
	9									=> array(
		'type'								=>	"single",
		'var'								=>	array(
			'key'								=>	"shellOrPhp",
			'name'								=>	"Line count from",
			'options'							=>	array(
				0 									=> array(
					"value" 							=> "shellPreferred",
					"name" 								=> "Shell Preferred"),
				1 									=> array(
					"value" 							=> "phpPreferred",
					"name" 								=> "Php Preferred"),
				2 									=> array(
					"value" 							=> "shellOnly",
					"name" 								=> "Shell Only"),
				3 									=> array(
					"value" 							=> "phpOnly",
					"name" 								=> "Php Only"),
			),
			'type'								=>	"dropdown"
		)
	),
	10									=> array(
		'type'								=>	"single",
		'var'								=>	array(
			'key'								=>	"showErrorPhpFileOpen",
			'name'								=>	"Show Php errors from file open fails",
			'options'							=>	$trueFalsVars,
			'type'								=>	"dropdown"
		)
	)
);

$infoImage = generateImage(
	$arrayOfImages["info"],
	array(
		"style"			=>	"margin-bottom: -4px;",
		"height"		=>	"20px",
		"srcModifier"	=>	"../"
	)
);
?>
<form id="settingsPollVars">
<div class="settingsHeader">
Poll Settings
<div class="settingsHeaderButtons">
	<?php echo addResetButton("settingsPollVars");?>
	<a class="linkSmall" onclick="saveAndVerifyMain('settingsPollVars');" >Save Changes</a>
</div>
</div>
<div class="settingsDiv" >
<ul class="settingsUl">
	<?php
	foreach ($defaultConfigMoreDataPollVars as $confDataValue)
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
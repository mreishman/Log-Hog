<?php

function generateExampleIndex($type, $top)
{
	$html = "<div id=\"menu\" style=\"position: relative; \">
		<div class=\"menuImageDiv\">
			<img id=\"pauseImage\" class=\"menuImage\" src=\"../core/Themes/".$type."/img/Pause.png\" height=\"30px\">
		</div>
		<div class=\"menuImageDiv\">
			<img id=\"refreshImage\" class=\"menuImage\" src=\"../core/Themes/".$type."/img/Refresh.png\" height=\"30px\">
		</div>
		<div  class=\"menuImageDiv\">
			<img id=\"deleteImage\" class=\"menuImage\" src=\"../core/Themes/".$type."/img/trashCanMulti.png\" height=\"30px\">
		</div>";
	if($top)
	{
		$html .= "<div class=\"menuImageDiv\">
				<img id=\"taskmanagerImage\" class=\"menuImage\" src=\"../core/Themes/".$type."/img/task-manager.png\" height=\"30px\">
			</div>";
	}
	$html .= "<div class=\"menuImageDiv\">
			<img data-id=\"1\" id=\"gear\" class=\"menuImage\" src=\"../core/Themes/".$type."/img/Gear.png\" height=\"30px\">
			 		</div>
					<div class=\"menuImage\" style=\"display: inline-block; cursor: pointer; \" \">gS</div>
			
			<a style=\"background-color: #2E8B57\" class=\"varwwwhtmlvarlogauthnetcimlogButton active\" >authnetcim.log</a>
		
			<a style=\"background-color: #2E8B57\" class=\"varwwwhtmlvarlogauthnetcimachlogButton\" \">authnetcim_ach.log</a>
		
			<a style=\"background-color: #20B2AA\" class=\"varlogapache2errorlogButton\" \">error.log</a>
		
			<a style=\"background-color: #3CB371\" class=\"varlogalternativeslogButton\"\">alternatives.log</a>
		</div>";

		return $html;
}

?>
<div>
	<table cellspacing="0"  style="margin: 0px;padding: 0px; border-spacing: 0px; width:100%;" >
		<tr class="logTdHolder">
			<!-- style="padding: 0; -->
			<?php
			// if($bottomBarIndexShow == 'false')
			// {
			// 	echo " width: 0; ";
			// }
			// else
			// {
			// 	echo " width: 31px; ";
			// }
			// if($bottomBarIndexType === "top")
			// {
			// 	echo " vertical-align: top; ";
			// }
			// elseif($bottomBarIndexType === "bottom")
			// {
			// 	echo " vertical-align: bottom; ";
			// }
			?>
			<!-- " -->
			<td class="logTdWidth" onclick="changeCurrentSelectWindow('{{counter}}')" style="padding: 0; border: 1px solid white;" >
				<div
				class="backgroundForSideBarMenu"
				style="
					<?php
					if($bottomBarIndexShow == 'false')
					{
						echo " display: none; width: 0; ";
					}
					else
					{
						echo " display: inline; width: 31px; ";
					}
					?>
					padding: 0px; position: absolute; "
				id="titleContainer{{counter}}"
			>
			<!-- currentWindowNumSelected OR sidebarCurrentWindowNum -->
				<p id="numSelectIndecatorForWindow{{counter}}"  class=" {{windowSelect}} " >
					{{counterPlusOne}}
				</p>
				<a id="showInfoLink{{counter}}" onclick="showInfo('{{counter}}');" style="cursor: pointer;" >
					<?php echo generateImage(
						$arrayOfImages["infoSideBar"],
						$imageConfig = array(
							"height"	=>	"20px",
							"style"		=>	"margin: 5px;",
							"title"		=>	"More Info"
							)
						);
					?>
				</a>
				<a id="pinWindow{{counter}}" class="pinWindowContainer"  onclick="pinWindow('{{counter}}');" style="cursor: pointer;" >
					<?php
						echo generateImage(
						$arrayOfImages["pin"],
						$imageConfig = array(
							"height"	=>	"20px",
							"style"		=>	"margin: 5px;",
							"title"		=>	"Pin Window",
							"class"		=>	"pinWindow"
							)
						);
						echo generateImage(
						$arrayOfImages["pinPinned"],
						$imageConfig = array(
							"height"	=>	"20px",
							"style"		=>	"margin: 5px; display: none;",
							"title"		=>	"Un-Pin Window",
							"class"		=>	"unPinWindow",
							)
						);
					?>
				</a>
				<a id="clearLogSideBar{{counter}}"  onclick="clearLog('{{counter}}');" style="cursor: pointer;">
					<?php echo generateImage(
						$arrayOfImages["eraserSideBar"],
						$imageConfig = array(
							"height"	=>	"20px",
							"style"		=>	"margin: 5px;",
							"title"		=>	"Clear Log"
							)
						);
					?>
				</a>
				<a id="deleteLogSideBar{{counter}}"  onclick="deleteLogPopup('{{counter}}');" style="cursor: pointer;">
					<?php echo  generateImage(
						$arrayOfImages["trashCanSideBar"],
						$imageConfig = array(
							"height"	=>	"20px",
							"style"		=>	"margin: 5px;",
							"title"		=>	"Delete Log"
							)
						);
					?>
				</a>
				<!-- <a onclick="viewBackupFromCurrentLog('{{counter}}');" style="cursor: pointer;">
					<?php echo generateImage(
						$arrayOfImages["historySideBar"],
						$imageConfig = array(
							"height"	=>	"20px",
							"style"		=>	"margin: 5px;",
							"title"		=>	"View Backup"
							)
						);
					?>
				</a> -->
				<a onclick="removeArchiveLogFromDisplay('{{counter}}')" id="closeLogSideBar{{counter}}" onclick="#" style="cursor: pointer; display: none;" >
					<?php echo generateImage(
						$arrayOfImages["close"],
						$imageConfig = array(
							"height"	=>	"20px",
							"style"		=>	"margin: 5px;"
							)
						);
					?>
				</a>
				<a onclick="scrollToBottom('{{counter}}');" style="cursor: pointer;" >
					<?php echo generateImage(
						$arrayOfImages["downArrowSideBar"],
						$imageConfig = array(
							"height"	=>	"20px",
							"style"		=>	"margin: 5px;",
							"title"		=>	"Scroll to Bottom"
							)
						);
					?>
				</a>
			</div>
				<span id="log{{counter}}Td"  class="logTrHeight" style="overflow: auto; display: block; word-break: break-all;" >
					<div id="log{{counter}}load" {{loadingStyle}} class="errorMessageLog">
						<?php echo generateImage(
							$arrayOfImages["loading"],
							$imageConfig = array(
								"height"	=>	"75px",
								)
							);
						?>
					</div>
					<div style="padding: 0; white-space: pre-wrap;" id="log{{counter}}" class="log" ></div>
				</span>
			</td>
		</tr>
	</table>
</div>
<div class="popuopInfoHolder" >
	<div style="display: none;" class="popupForInfo" id="title{{counter}}"></div>
</div>
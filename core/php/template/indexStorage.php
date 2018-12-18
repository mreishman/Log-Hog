<div>
	<table cellspacing="0"  style="margin: 0px;padding: 0px; border-spacing: 0px; width:100%;" >
		<tr class="logTdHolder">
			<td class="logTdWidth addBorder" onclick="changeCurrentSelectWindow('{{counter}}')" style="padding: 0;" >
				<div style="display: block; position: relative;height: 0;width: 0;padding: 0;" >
					<div
					class="backgroundForSideBarMenu addBorder"
					style="
						<?php
						if($bottomBarIndexShow == 'false')
						{
							echo " display: none; width: 0; ";
						}
						else
						{
							echo " display: inline-block; width: 31px; ";
						}
						if($bottomBarIndexType === "top")
						{
							echo " top: 0; ";
						}
						elseif($bottomBarIndexType === "bottom")
						{
							echo " bottom: 0; ";
						}
						elseif($bottomBarIndexType === "full")
						{
							echo " bottom: 0; top: 0; ";
						}
						?>
						padding: 0px; position: relative; overflow-x: hidden; "
					id="titleContainer{{counter}}"
					>
						<!-- currentWindowNumSelected OR sidebarCurrentWindowNum -->
						<p id="numSelectIndecatorForWindow{{counter}}"  class=" {{windowSelect}} " >
							{{counterPlusOne}}
						</p>
						<a id="showInfoLink{{counter}}" onclick="showInfo('{{counter}}');" style="cursor: pointer;" >
							<?php echo generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"class"		=>	"infoSideBarImageForLoad",
									"style"		=>	"margin: 5px;",
									"title"		=>	"More Info",
									"data-src"	=>	$arrayOfImages["infoSideBar"]
									)
								);
							?>
						</a>
						<a id="pinWindow{{counter}}" class="pinWindowContainer"  onclick="pinWindow('{{counter}}');" style="cursor: pointer;" >
							<?php
								echo generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Pin Window",
									"class"		=>	"pinWindow pinImageForLoad multiLogGreaterThanOne",
									"data-src"	=>	$arrayOfImages["pin"]
									)
								);
								echo generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px; display: none;",
									"title"		=>	"Un-Pin Window",
									"class"		=>	"unPinWindow pinPinnedImageForLoad multiLogGreaterThanOne",
									"data-src"	=>	$arrayOfImages["pinPinned"]
									)
								);
							?>
						</a>
						<a id="clearLogSideBar{{counter}}"  onclick="clearLog('{{counter}}');" style="cursor: pointer;">
							<?php echo generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Clear Log",
									"class"		=>	"eraserSideBarImageForLoad",
									"data-src"	=>	$arrayOfImages["eraserSideBar"]
									)
								);
							?>
						</a>
						<a id="deleteLogSideBar{{counter}}"  onclick="deleteLogPopup('{{counter}}');" style="cursor: pointer;">
							<?php echo  generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Delete Log",
									"class"		=>	"trashCanSideBarImageForLoad",
									"data-src"	=>	$arrayOfImages["trashCanSideBar"]
									)
								);
							?>
						</a>
						<!-- <a onclick="viewBackupFromCurrentLog('{{counter}}');" style="cursor: pointer;">
							<?php /* echo generateImage(
								$arrayOfImages["historySideBar"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"View Backup"
									)
								);
							*/ ?>
						</a> -->
						<a onclick="openLogPopup(this,'{{counter}}');" style="cursor: pointer;">
							<?php echo generateImage(
								$arrayOfImages["historySideBar"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"View Backup"
									)
								);
							?>
						</a>
						<a onclick="removeLogFromDisplay('{{counter}}')" id="closeLogSideBar{{counter}}" onclick="#" style="cursor: pointer; display: none;" >
							<?php echo generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"class"		=>	"closeImageForLoad archiveLogImages",
									"data-src"	=>	$arrayOfImages["close"]
									)
								);
							?>
						</a>
						<a onclick="scrollToBottom('{{counter}}');" style="cursor: pointer;" >
							<?php echo generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Scroll to Bottom",
									"class"		=>	"downArrowSideBarImageForLoad",
									"data-src"	=>	$arrayOfImages["downArrowSideBar"]
									)
								);
							?>
						</a>
					</div>
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
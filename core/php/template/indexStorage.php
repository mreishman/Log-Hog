<div>
	<table cellspacing="0"  style="margin: 0px;padding: 0px; border-spacing: 0px; width:100%;" >
		<tr class="logTdHolder">
			<td id="logTd{{counter}}Width" class="logTdWidth addBorder" onclick="changeCurrentSelectWindow('{{counter}}')" style="padding: 0;" >
				<div style="display: block; position: relative;height: 0;width: 0;padding: 0;" >
					<div
					class="backgroundForSideBarMenu addBorder" {{customsidebarstyle}} id="titleContainer{{counter}}">
						<!-- currentWindowNumSelected OR sidebarCurrentWindowNum -->
						<p id="numSelectIndecatorForWindow{{counter}}"  class=" {{windowSelect}} " >
							{{counterPlusOne}}
						</p>
						<a id="showInfoLink{{counter}}" onclick="showInfo('{{counter}}');">
							<?php echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"class"		=>	"infoSideBarImageForLoad altImage",
									"style"		=>	"margin: 5px;",
									"title"		=>	"More Info",
									"data-src"	=>	$arrayOfImages["info"]
									)
								);
							?>
						</a>
						<span id="loadLineCountForWindow{{counter}}" class="loadLineCountForWindow" style="font-size: 86%;padding: 0;">
						</span>
						<a id="showLogWindowFilter{{counter}}" onclick="showLogWindowFilter('{{counter}}');" style="{{customfilterstyle}}" >
							<?php echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"class"		=>	"searchSideBarImageForLoad altImage",
									"style"		=>	"margin: 5px;",
									"title"		=>	"More Info",
									"data-src"	=>	$arrayOfImages["search"]
									)
								);
							?>
						</a>
						<a id="pinWindow{{counter}}" class="pinWindowContainer"  onclick="pinWindow('{{counter}}');">
							<?php
								echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Pin Window",
									"class"		=>	"pinWindow pinImageForLoad multiLogGreaterThanOne altImage",
									"data-src"	=>	$arrayOfImages["pin"]
									)
								);
								echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px; display: none;",
									"title"		=>	"Un-Pin Window",
									"class"		=>	"unPinWindow pinPinnedImageForLoad multiLogGreaterThanOne altImage",
									"data-src"	=>	$arrayOfImages["pinPinned"]
									)
								);
							?>
						</a>
						<a id="clearLogSideBar{{counter}}"  onclick="clearLog('{{counter}}');">
							<?php echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Clear Log",
									"class"		=>	"eraserSideBarImageForLoad altImage",
									"data-src"	=>	$arrayOfImages["eraser"]
									)
								);
							?>
						</a>
						<a id="deleteLogSideBar{{counter}}"  onclick="deleteLogPopup('{{counter}}');">
							<?php echo  $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Delete Log",
									"class"		=>	"trashCanSideBarImageForLoad altImage",
									"data-src"	=>	$arrayOfImages["trashCan"]
									)
								);
							?>
						</a>
						<a id="historySideBar{{counter}}" onclick="viewBackupFromCurrentLog('{{counter}}');">
							<?php echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"View Backup",
									"class"		=>	"historySideBarImageForLoad altImage",
									"data-src"	=>	$arrayOfImages["history"]
									)
								);
							?>
						</a>
						<a id="saveArchiveSideBar{{counter}}" onclick="saveArchivePopup('{{counter}}');">
							<?php echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Save Backup",
									"class"		=>	"historyAddSideBarImageForLoad altImage",
									"data-src"	=>	$arrayOfImages["saveSideBar"]
									)
								);
							?>
						</a>
						<a onclick="toggleLogPopup(this,'{{counter}}');">
							<?php echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Select Log",
									"class"		=>	"menuSideBarImageForLoad altImage",
									"data-src"	=>	$arrayOfImages["menu"]
									)
								);
							?>
						</a>
						<a onclick="removeLogFromDisplay('{{counter}}')" id="closeLogSideBar{{counter}}" onclick="#" style="display: none;" >
							<?php echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"class"		=>	"closeImageForLoad archiveLogImages altImage",
									"data-src"	=>	$arrayOfImages["close"]
									)
								);
							?>
						</a>
						<a onclick="scrollToBottom('{{counter}}');">
							<?php echo $core->generateImage(
								$arrayOfImages["loadingImg"],
								$imageConfig = array(
									"height"	=>	"20px",
									"style"		=>	"margin: 5px;",
									"title"		=>	"Scroll to Bottom",
									"class"		=>	"downArrowSideBarImageForLoad altImage",
									"data-src"	=>	$arrayOfImages["downArrowSideBar"]
									)
								);
							?>
						</a>
					</div>
				</div>
				<span id="searchFieldInputOuter-{{counter}}" class="addBorderBottom" style="padding: 10px; display: none; text-align: center;">
					<input id="searchFieldInput-{{counter}}" type="search" placeholder="Filter Log Content" style="height: 30px; width: 200px;">
				</span>
				<span id="log{{counter}}Td"  class="logTrHeight" style="overflow: auto; display: block; word-break: break-all;" >
					<div id="log{{counter}}load" style="{{loading_style}}" class="errorMessageLog">
						<?php echo $core->generateImage(
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
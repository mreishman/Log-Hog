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
						<span id="loadLineCountForWindow{{counter}}" class="loadLineCountForWindow" style="font-size: 86%;padding: 0;">
						</span>
						<?php foreach ($sortedDefaultLogSidebarConfig as $sidebarItem)
						{
							include("core/php/template/logSidebarBlock.php");
						}
						?>
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
					<div id="log{{counter}}TopButtons" style="text-align: center; display: none;">
						<span onclick="singleLogLoadMore('{{counter}}');" class="link">Load More</span>
					</div>
					<div style="padding: 0; white-space: pre-wrap;" id="log{{counter}}" class="log" ></div>
					<div id="log{{counter}}BottomButtons" style="text-align: center; display: none;">
						<span onclick="singleLogLoadMore('{{counter}}');" class="link">Load More</span>
					</div>
				</span>
			</td>
		</tr>
	</table>
</div>
<div class="popuopInfoHolder" >
	<div style="display: none;" class="popupForInfo" id="title{{counter}}"></div>
</div>
var title = $('title').text();
var currentPage;
var logs = {};
var titles = {};
var lastLogs = {};
var fresh = true;
var flasher;
var updating = false;
var startedPauseOnNonFocus = false;

function poll() {

	if(!startedPauseOnNonFocus)
	{
		startPauseOnNotFocus();
	}

	if (autoCheckUpdate == true && !updating)
	{
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
		    dd='0'+dd
		} 

		if(mm<10) {
		    mm='0'+mm
		} 

		today = mm+'-'+dd+'-'+yyyy;
		if(daysSinceLastCheck > (daysSetToUpdate - 1))
		{
			updating = true;
			window.location.href = "core/php/settingsCheckForUpdate.php";
		}
		else
		{
			pollTwo();
		}

	}
	else
	{
		pollTwo();
	}

	
}

function pollTwo()
{
	if(!pausePoll)
	{
		if(refreshing)
		{
			document.title = "Log Hog | Refreshing";
		}
		else
		{
			document.title = "Log Hog | Index";
		}
	$.getJSON('core/php/poll.php', {}, function(data) {
		update(data);
		fresh = false;
	});
	}
}

function pausePollAction()
{
	if(pausePoll)
	{
		userPaused = false;
		pausePoll = false;
		document.getElementById('pauseImage').src="core/img/Pause.png";
	}
	else
	{
		userPaused = true;
		pausePollFunction();
	}
}

function refreshAction()
{
	clearTimeout(refreshActionVar);
	document.getElementById('refreshImage').src="core/img/refresh-animated.gif";
	refreshing = true;
	if(pausePoll)
	{
		clearTimeout(refreshPauseActionVar);
		pausePoll = false;
		poll();
		refreshPauseActionVar = setTimeout(function(){pausePoll = true;}, 1000);
	}
	else
	{
		poll();
	}
	refreshActionVar = setTimeout(function(){endRefreshAction()}, 1500);
}

function endRefreshAction()
{
	document.getElementById('refreshImage').src="core/img/Refresh.png"; 
	refreshing = false;
	if(pausePoll)
	{
		document.title = "Log Hog | Paused";
	}
	else
	{
		document.title = "Log Hog | Index";
	}
}

function update(data) {
	var menu = $('#menu');
	var blank = $('#storage .menuItem').html();
	var i, id, name, shortName, item, style;
	var files = Object.keys(data);
	var stop = files.length;
	var updated = false;
	var initialized = $('#menu a').length != 0;
	var colorArray = ['#2A912A',"#32CD32","#9ACD32","#556B2F","#6B8E23"];
	var colorArrayLength = colorArray.length;
	var folderNamePrev = "?-1";
	var folderNameCount = -1;
	for(i = 0; i != stop; ++i) {
		name = files[i];
		var folderName = name.substr(0, name.lastIndexOf("/"));
		if(folderName !== folderNamePrev || i == 0)
		{
			folderNameCount++;
			folderNamePrev = folderName;
			if(folderNameCount >= colorArrayLength)
			{
				folderNameCount = 0;
			}
		}
		id = name.replace(/[^a-z0-9]/g, '');
		logs[id] = data[name];
		
		if($('#menu .' + id + 'Button').length == 0) {
			titles[id] = name;
			shortName = files[i].replace(/.*\//g, '');
			style = "background-color: "+colorArray[folderNameCount];
			item = blank;
			item = item.replace(/{{title}}/g, shortName);
			item = item.replace(/{{id}}/g, id);
			item = item.replace(/{{style}}/g, style)
			menu.append(item);
		}
		
		if(logs[id] != lastLogs[id]) {
			updated = true;
			if(id == currentPage)
				$('#log').html(makePretty(logs[id]));
			else if(!fresh && !$('#menu a.' + id + 'Button').hasClass('updated'))
				$('#menu a.' + id + 'Button').addClass('updated');
		}
		
		if(initialized && updated && $(window).filter(':focus').length == 0) {
			if(flashTitleUpdateLog)
			{
				flashTitle();
			}
		}
	}
	resize();
	
	if($('#menu .active').length == 0)
		$('#menu a:eq(0)').click();
	
	if(logs[currentPage] != lastLogs[currentPage]) {
		lastLogs[currentPage] = logs[currentPage];
		document.getElementById('main').scrollTop = $('#log').outerHeight();
	}
	
	var ids = Object.keys(logs);
	for(i = 0; i != stop; ++i) {
		id = ids[i];
		lastLogs[id] = logs[id];
	}
}

function show(e, id) {
	$(e).siblings().removeClass('active');
	$(e).addClass('active').removeClass('updated');
	$('#log').html(makePretty(logs[id]));
	currentPage = id;
	$('#title').html(titles[id]);
	document.getElementById('main').scrollTop = $('#log').outerHeight();
}

function makePretty(text) {
	text = text.split("\n");
	text = text.join('</div><div>');
	
	return '<div>' + text + '</div>';
}

function resize() {
	var targetHeight = window.innerHeight - $('#menu').outerHeight() - $('#title').outerHeight();
	if($('#main').outerHeight() != targetHeight)
		$('#main').outerHeight(targetHeight);
	if($('#main').css('bottom') != $('#title').outerHeight() + 'px')
		$('#main').css('bottom', $('#title').outerHeight() + 'px');
}

function flashTitle() {
	stopFlashTitle();
	$('title').text('');
	flasher = setInterval(function() {
		$('title').text($('title').text() == '' ? title : '');
	}, 1000);
}

function stopFlashTitle() {
	clearInterval(flasher);
	$('title').text(title);
}

function focus() {
	stopFlashTitle();
}



poll();
if (autoCheckUpdate == true)
{
	var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
		    dd='0'+dd
		} 

		if(mm<10) {
		    mm='0'+mm
		} 

		today = mm+'-'+dd+'-'+yyyy;
		if(daysSinceLastCheck > (daysSetToUpdate - 1) && !updating)
		{
			updating = true;
			window.location.href = "core/php/settingsCheckForUpdate.php";
		}
		else
		{
			setInterval(poll, pollingRate);
		}
}
else
{
	setInterval(poll, pollingRate);
}
//setInterval(poll, pollingRate);
resize();

window.onresize = resize;
window.onfocus = focus;

if(pausePollFromFile)
{
	pausePoll = true;
	document.getElementById('pauseImage').src="core/img/Play.png";
}

if(pausePollOnNotFocus && !pausePollFromFile)
{
	startPauseOnNotFocus();
}

function startPauseOnNotFocus()
{
	startedPauseOnNonFocus = true;
	Visibility.every(250, 1000, function () { checkIfPageHidden(); });
}

function checkIfPageHidden()
{
	if(isPageHidden())
	{
		//hidden
		if(!pausePoll)
		{
			pausePollFunction();
		}
	}
	else
	{
		//not hidden
		if(!userPaused && pausePoll)
		{
			pausePoll = false;
			document.getElementById('pauseImage').src="core/img/Pause.png";
			stopFlashTitle();
		}
		if(userPaused)
		{
			document.title = "Log Hog | Paused";
		}
	}
}

function pausePollFunction()
{
	pausePoll = true;
	document.getElementById('pauseImage').src="core/img/Play.png";
	document.title = "Log Hog | Paused";
}

function isPageHidden(){
     return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
}

function clearLog()
{
	var urlForSend = 'core/php/clearLog.php?format=json'
	var data = {file: document.getElementById("title").innerHTML};
	$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
	success: function(data){
    // we make a successful JSONP call!
  },
});
}


function deleteAction()
{
	var urlForSend = 'core/php/clearAllLogs.php?format=json'
	var data = "";
	$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
	success: function(data){
    // we make a successful JSONP call!
  },
});
}

function deleteLogPopup()
{
	if(popupSettingsArray.deleteLog == "true")
	{
	showPopup();
		document.getElementById('popupContentInnerHTMLDiv').innerHTML = "<div class='settingsHeader' >Are you sure you want to delete this log?</div><br><div style='width:100%;text-align:center;padding-left:10px;padding-right:10px;'>"+document.getElementById("title").innerHTML+"</div><div><div class='link' onclick='deleteLog();hidePopup();' style='margin-left:125px; margin-right:50px;margin-top:35px;'>Yes</div><div onclick='hidePopup();' class='link'>No</div></div>";
	}
	else
	{
		deleteLog();
	}
}

function deleteLog()
{
	var urlForSend = 'core/php/deleteLog.php?format=json'
	var data = {file: document.getElementById("title").innerHTML};
	$.ajax({
			  url: urlForSend,
			  dataType: 'json',
			  data: data,
			  type: 'POST',
	success: function(data){
    // we make a successful JSONP call!
  },
  	complete: function(data){
  		location.reload();
  	},
});
}
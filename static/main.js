var title = $('title').text();
var currentPage;
var logs = {};
var titles = {};
var lastLogs = {};
var fresh = true;
var flasher;

function poll() {
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
	$.getJSON('poll.php', {}, function(data) {
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
		document.getElementById('pauseImage').src="static/images/Pause.png";
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
	document.getElementById('refreshImage').src="static/images/refresh-animated.gif";
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
	document.getElementById('refreshImage').src="static/images/Refresh.png"; 
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
	var i, id, name, shortName, item;
	var files = Object.keys(data);
	var stop = files.length;
	var updated = false;
	var initialized = $('#menu a').length != 0;
	
	for(i = 0; i != stop; ++i) {
		name = files[i];
		id = name.replace(/[^a-z0-9]/g, '');
		logs[id] = data[name];
		
		if($('#menu .' + id + 'Button').length == 0) {
			titles[id] = name;
			shortName = files[i].replace(/.*\//g, '');
			item = blank;
			item = item.replace(/{{title}}/g, shortName);
			item = item.replace(/{{id}}/g, id);
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
			flashTitle();
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
setInterval(poll, pollingRate);
resize();

window.onresize = resize;
window.onfocus = focus;

if(pausePollFromFile)
{
	pausePoll = true;
	document.getElementById('pauseImage').src="static/images/Play.png";
}

if(pausePollOnNotFocus && !pausePollFromFile)
{
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
			document.getElementById('pauseImage').src="static/images/Pause.png";
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
	document.getElementById('pauseImage').src="static/images/Play.png";
	document.title = "Log Hog | Paused";
}

function isPageHidden(){
     return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
 }
var currentPage;
var logs = {};
var titles = {};
var lastLogs = {};
var fresh = true;

function poll() {
	$.getJSON('poll.php', {}, function(data) {
		update(data);
		fresh = false;
	});
}

function update(data) {
	var menu = $('#menu');
	var blank = $('#storage .menuItem').html();
	var id, name, shortName, item;
	var files = Object.keys(data);
	var stop = files.length;
	
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
			if(id == currentPage)
				$('#log').html(makePretty(logs[id]));
			else if(!fresh && !$('#menu a.' + id + 'Button').hasClass('updated'))
				$('#menu a.' + id + 'Button').addClass('updated');
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



poll();
setInterval(poll, pollingRate);
resize();

window.onresize = resize;
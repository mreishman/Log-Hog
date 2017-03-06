<?php

$config = array(
	'sliceSize'		=> 500,
	'pollingRate'	=> 500,
	'pausePoll'		=> 'false',
	'pauseOnNotFocus' => 'true',
	'autoCheckUpdate' => 'true',
	'watchList'		=> array(
		'/var/www/html/var/log/system.log'	        => '',
		'/var/log/hhvm/error.log'	=> '',
		'/var/log/apache2'			=> '\.log$'
	)
);
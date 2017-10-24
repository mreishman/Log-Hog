<?php

function filePermsDisplay($key)
{
	$info = "u---------";
	if(file_exists($key))
	{
		$perms  =  fileperms($key);

		switch ($perms & 0xF000) {
		    case 0xC000: // socket
		        $info = 's';
		        break;
		    case 0xA000: // symbolic link
		        $info = 'l';
		        break;
		    case 0x8000: // regular
		        $info = 'f';
		        break;
		    case 0x6000: // block special
		        $info = 'b';
		        break;
		    case 0x4000: // directory
		        $info = 'd';
		        break;
		    case 0x2000: // character special
		        $info = 'c';
		        break;
		    case 0x1000: // FIFO pipe
		        $info = 'p';
		        break;
		    default: // unknown
		        $info = 'u';
		}

		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
		            (($perms & 0x0800) ? 's' : 'x' ) :
		            (($perms & 0x0800) ? 'S' : '-'));

		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
		            (($perms & 0x0400) ? 's' : 'x' ) :
		            (($perms & 0x0400) ? 'S' : '-'));

		// World
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
		            (($perms & 0x0200) ? 't' : 'x' ) :
		            (($perms & 0x0200) ? 'T' : '-'));
	}
	return $info;
}

function phpGrep($objectSent)
{
	$returnArray = array();
	$grepResults = shell_exec("grep -nHo ".$objectSent['pattern']." ".$objectSent['file']);
	$defaultPadding = 3; //lines +/- of padding for around found thing.
	if($grepResults)
	{
		$grepResults = explode(PHP_EOL, $grepResults);
		$subArray = array("data" => array(), "positionArray" => array());
		$file =  file($objectSent['file']);
		//filter out same line ones
		$arrayOfLines = array();
		$grepResultsNew = array();
		foreach ($grepResults as $result)
		{
			$positionArray = explode(":", $result);
			if(count($positionArray) === 3)
			{
				if(!in_array($positionArray[1], $arrayOfLines))
				{
					array_push($arrayOfLines, $positionArray[1]);
					array_push($grepResultsNew, $result);
				}
			}
		}
		foreach ($grepResultsNew as $result)
		{
			$positionArray = explode(":", $result);
			if(count($positionArray) === 3)
			{
				//as expected
				$subSubArray = array();
				$setFirstNum = -1;

				$numForAbove = $defaultPadding;
				foreach ($grepResultsNew as $resultFuture)
				{
					$positionArrayFuture = explode(":", $resultFuture);
					if(count($positionArrayFuture) === 3)
					{
						if((((int)($positionArrayFuture[1])-1) < ((int)($positionArray[1])-1)) && (((int)($positionArrayFuture[1])-1) > ((int)($positionArray[1])-1) - 2 - (2*$defaultPadding)))
						{
							$numForAbove = min( (((int)($positionArrayFuture[1])-1) - ((int)($positionArray[1])-1) -1) , $defaultPadding);
							break;
						}

					}
				}

				for ($i = $numForAbove; $i > 0; $i--)
				{
					if($i > $defaultPadding - $numForAbove)
					{
						if(isset($file[((int)($positionArray[1])-1-$i)]))
						{ 
							array_push($subSubArray, $file[((int)($positionArray[1])-1-$i)]);
							if($setFirstNum  === -1)
							{
								$setFirstNum = ((int)($positionArray[1])-1-$i);
							}
						}
					}
				}

				array_push($subSubArray, $file[((int)($positionArray[1])-1)]);
				if($setFirstNum  === -1)
				{
					$setFirstNum = ((int)($positionArray[1])-1);
				}

				//check if one of the next positions is less than currentPos + 2xbuffer + 2 but greater than currentPOS
				$numForBelow = $defaultPadding;
				foreach ($grepResultsNew as $resultFuture)
				{
					$positionArrayFuture = explode(":", $resultFuture);
					if(count($positionArrayFuture) === 3)
					{
						if((((int)($positionArrayFuture[1])-1) > ((int)($positionArray[1])-1)) && (((int)($positionArrayFuture[1])-1) < ((int)($positionArray[1])-1) + 2 + (2*$defaultPadding)))
						{
							$numForBelow = min( (((int)($positionArrayFuture[1])-1) - ((int)($positionArray[1])-1) -1) , $defaultPadding);
							break;
						}

					}
				}
				
				for ($i = $defaultPadding; $i > 0; $i--)
				{
					if($i > $defaultPadding - $numForBelow)
					{ 
						if(isset($file[((int)($positionArray[1])-1+(4-$i))]))
						{
							array_push($subSubArray, $file[((int)($positionArray[1])-1+(4-$i))]);
						}
					}
				}

				array_push($subArray['data'], $subSubArray);
				array_push($subArray['positionArray'], array($setFirstNum, ((int)($positionArray[1])-1)));
			}
			else
			{
				//?????
			}
		}
		//getName
		$name = explode(":", $grepResults[0]);
		$name = $name[0];
		$returnArray[$name] = $subArray;
	}

	return $returnArray;
}

function returnLinesOfFile($position, $padding, $lastLine)
{

}

function getDirContents($dirArr)
{
    
    $results = ['files' => array(), 'folders' => array()];
    $skipFolders = array('.git' => 1);
    $skipFileTypes = array('.png','.jpg','.jpeg');
    $skipFiles = array('placeholder.txt' => 1);
    $skipExactFolderPaths = array("/var/www/html/media" => 1);

    if(!is_array($dirArr))
    {
    	$dirArr = [$dirArr];
    }
    foreach ($dirArr as $dir)
   	{
   		if(is_dir($dir))
   		{
	    	$files = array_diff(scandir($dir), array('..', '.'));
		    if($files)
		    {
			    foreach($files as $key => $value)
			    {
			        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
			        if(!is_dir($path))
			        {
			        	if(!isset($skipFiles[$value]))
			        	{
				        	$skip = false;
				        	foreach ($skipFileTypes as $key2)
				        	{
				        		if(strpos($value, $key2))
				        		{
				        			$skip = true;
				        			break;
				        		}
				        	}
				        	if(!$skip)
				        	{
				            	array_push($results['files'], $path);
				            }
				        }
			        }
			        else
			        {
			        	if(!isset($skipExactFolderPaths[$path]) && !isset($skipFolders[$value]))
			        	{
			        		if(!is_dir_empty($dir))
			        		{
			            		array_push($results['folders'], $path);
			        		}
			        	}
			        }
			    }
			}
		}
	}
    return $results;
}

function is_dir_empty($dir)
{
	if(is_readable($dir))
	{
		return (count(scandir($dir)) == 2);
	}
}

function loadSentryData($sendCrashInfoJS)
{
	if($sendCrashInfoJS === "true")
	{
		return '<script>
var _rollbarConfig = {
    accessToken: "9c8b0116ef5c435f9afa0a6243a1fcd2",
    captureUncaught: true,
    payload: {
        environment: "production"
    }
};
!function(r){function o(n){if(e[n])return e[n].exports;var t=e[n]={exports:{},id:n,loaded:!1};return r[n].call(t.exports,t,t.exports,o),t.loaded=!0,t.exports}var e={};return o.m=r,o.c=e,o.p="",o(0)}([function(r,o,e){"use strict";var n=e(1),t=e(4);_rollbarConfig=_rollbarConfig||{},_rollbarConfig.rollbarJsUrl=_rollbarConfig.rollbarJsUrl||"https://cdnjs.cloudflare.com/ajax/libs/rollbar.js/2.2.7/rollbar.min.js",_rollbarConfig.async=void 0===_rollbarConfig.async||_rollbarConfig.async;var a=n.setupShim(window,_rollbarConfig),l=t(_rollbarConfig);window.rollbar=n.Rollbar,a.loadFull(window,document,!_rollbarConfig.async,_rollbarConfig,l)},function(r,o,e){"use strict";function n(r){return function(){try{return r.apply(this,arguments)}catch(r){try{console.error("[Rollbar]: Internal error",r)}catch(r){}}}}function t(r,o){this.options=r,this._rollbarOldOnError=null;var e=s++;this.shimId=function(){return e},window&&window._rollbarShims&&(window._rollbarShims[e]={handler:o,messages:[]})}function a(r,o){var e=o.globalAlias||"Rollbar";if("object"==typeof r[e])return r[e];r._rollbarShims={},r._rollbarWrappedError=null;var t=new p(o);return n(function(){o.captureUncaught&&(t._rollbarOldOnError=r.onerror,i.captureUncaughtExceptions(r,t,!0),i.wrapGlobals(r,t,!0)),o.captureUnhandledRejections&&i.captureUnhandledRejections(r,t,!0);var n=o.autoInstrument;return(void 0===n||n===!0||"object"==typeof n&&n.network)&&r.addEventListener&&(r.addEventListener("load",t.captureLoad.bind(t)),r.addEventListener("DOMContentLoaded",t.captureDomContentLoaded.bind(t))),r[e]=t,t})()}function l(r){return n(function(){var o=this,e=Array.prototype.slice.call(arguments,0),n={shim:o,method:r,args:e,ts:new Date};window._rollbarShims[this.shimId()].messages.push(n)})}var i=e(2),s=0,d=e(3),c=function(r,o){return new t(r,o)},p=d.bind(null,c);t.prototype.loadFull=function(r,o,e,t,a){var l=function(){var o;if(void 0===r._rollbarDidLoad){o=new Error("rollbar.js did not load");for(var e,n,t,l,i=0;e=r._rollbarShims[i++];)for(e=e.messages||[];n=e.shift();)for(t=n.args||[],i=0;i<t.length;++i)if(l=t[i],"function"==typeof l){l(o);break}}"function"==typeof a&&a(o)},i=!1,s=o.createElement("script"),d=o.getElementsByTagName("script")[0],c=d.parentNode;s.crossOrigin="",s.src=t.rollbarJsUrl,e||(s.async=!0),s.onload=s.onreadystatechange=n(function(){if(!(i||this.readyState&&"loaded"!==this.readyState&&"complete"!==this.readyState)){s.onload=s.onreadystatechange=null;try{c.removeChild(s)}catch(r){}i=!0,l()}}),c.insertBefore(s,d)},t.prototype.wrap=function(r,o,e){try{var n;if(n="function"==typeof o?o:function(){return o||{}},"function"!=typeof r)return r;if(r._isWrap)return r;if(!r._rollbar_wrapped&&(r._rollbar_wrapped=function(){e&&"function"==typeof e&&e.apply(this,arguments);try{return r.apply(this,arguments)}catch(e){var o=e;throw"string"==typeof o&&(o=new String(o)),o._rollbarContext=n()||{},o._rollbarContext._wrappedSource=r.toString(),window._rollbarWrappedError=o,o}},r._rollbar_wrapped._isWrap=!0,r.hasOwnProperty))for(var t in r)r.hasOwnProperty(t)&&(r._rollbar_wrapped[t]=r[t]);return r._rollbar_wrapped}catch(o){return r}};for(var u="log,debug,info,warn,warning,error,critical,global,configure,handleUncaughtException,handleUnhandledRejection,captureDomContentLoaded,captureLoad".split(","),f=0;f<u.length;++f)t.prototype[u[f]]=l(u[f]);r.exports={setupShim:a,Rollbar:p}},function(r,o){"use strict";function e(r,o,e){if(r){var t;"function"==typeof o._rollbarOldOnError?t=o._rollbarOldOnError:r.onerror&&!r.onerror.belongsToShim&&(t=r.onerror,o._rollbarOldOnError=t);var a=function(){var e=Array.prototype.slice.call(arguments,0);n(r,o,t,e)};a.belongsToShim=e,r.onerror=a}}function n(r,o,e,n){r._rollbarWrappedError&&(n[4]||(n[4]=r._rollbarWrappedError),n[5]||(n[5]=r._rollbarWrappedError._rollbarContext),r._rollbarWrappedError=null),o.handleUncaughtException.apply(o,n),e&&e.apply(r,n)}function t(r,o,e){if(r){"function"==typeof r._rollbarURH&&r._rollbarURH.belongsToShim&&r.removeEventListener("unhandledrejection",r._rollbarURH);var n=function(r){var e=r.reason,n=r.promise,t=r.detail;!e&&t&&(e=t.reason,n=t.promise),o&&o.handleUnhandledRejection&&o.handleUnhandledRejection(e,n)};n.belongsToShim=e,r._rollbarURH=n,r.addEventListener("unhandledrejection",n)}}function a(r,o,e){if(r){var n,t,a="EventTarget,Window,Node,ApplicationCache,AudioTrackList,ChannelMergerNode,CryptoOperation,EventSource,FileReader,HTMLUnknownElement,IDBDatabase,IDBRequest,IDBTransaction,KeyOperation,MediaController,MessagePort,ModalWindow,Notification,SVGElementInstance,Screen,TextTrack,TextTrackCue,TextTrackList,WebSocket,WebSocketWorker,Worker,XMLHttpRequest,XMLHttpRequestEventTarget,XMLHttpRequestUpload".split(",");for(n=0;n<a.length;++n)t=a[n],r[t]&&r[t].prototype&&l(o,r[t].prototype,e)}}function l(r,o,e){if(o.hasOwnProperty&&o.hasOwnProperty("addEventListener")){for(var n=o.addEventListener;n._rollbarOldAdd&&n.belongsToShim;)n=n._rollbarOldAdd;var t=function(o,e,t){n.call(this,o,r.wrap(e),t)};t._rollbarOldAdd=n,t.belongsToShim=e,o.addEventListener=t;for(var a=o.removeEventListener;a._rollbarOldRemove&&a.belongsToShim;)a=a._rollbarOldRemove;var l=function(r,o,e){a.call(this,r,o&&o._rollbar_wrapped||o,e)};l._rollbarOldRemove=a,l.belongsToShim=e,o.removeEventListener=l}}r.exports={captureUncaughtExceptions:e,captureUnhandledRejections:t,wrapGlobals:a}},function(r,o){"use strict";function e(r,o){this.impl=r(o,this),this.options=o,n(e.prototype)}function n(r){for(var o=function(r){return function(){var o=Array.prototype.slice.call(arguments,0);if(this.impl[r])return this.impl[r].apply(this.impl,o)}},e="log,debug,info,warn,warning,error,critical,global,configure,handleUncaughtException,handleUnhandledRejection,_createItem,wrap,loadFull,shimId,captureDomContentLoaded,captureLoad".split(","),n=0;n<e.length;n++)r[e[n]]=o(e[n])}e.prototype._swapAndProcessMessages=function(r,o){this.impl=r(this.options);for(var e,n,t;e=o.shift();)n=e.method,t=e.args,this[n]&&"function"==typeof this[n]&&("captureDomContentLoaded"===n||"captureLoad"===n?this[n].apply(this,[t[0],e.ts]):this[n].apply(this,t));return this},r.exports=e},function(r,o){"use strict";r.exports=function(r){return function(o){if(!o&&!window._rollbarInitialized){r=r||{};for(var e,n,t=r.globalAlias||"Rollbar",a=window.rollbar,l=function(r){return new a(r)},i=0;e=window._rollbarShims[i++];)n||(n=e.handler),e.handler._swapAndProcessMessages(l,e.messages);window[t]=n,window._rollbarInitialized=!0}}}}]);

function eventThrowException(e)
		{
			//this would send errors, but it is disabled
		}


</script>';
	}
	return "
	<script>

		function eventThrowException(e)
		{
			//this would send errors, but it is disabled
		}

	</script>";
}

function baseURL()
{
	$baseURL = "";
	$boolBaseURL = file_exists($baseURL."error.php");
	while(!$boolBaseURL)
	{
		$baseURL .= "../";
		$boolBaseURL = file_exists($baseURL."error.php");
	}
	return $baseURL;
}

function clean_url($url)
{
    $parts = parse_url($url);
    return $parts['path'];
}

function loadCSS($baseUrl, $version)
{
	return "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$baseUrl."template/theme.css?v=".$version."\">";
}

function loadVisibilityJS($baseURL)
{
	return "<script src=\"".$baseURL."core/js/visibility.core.js\"></script>
	<script src=\"".$baseURL."core/js/visibility.fallback.js\"></script>
	<script src=\"".$baseURL."core/js/visibility.js\"></script>
	<script src=\"".$baseURL."core/js/visibility.timers.js\"></script>";
}

function calcuateDaysSince($lastCheck)
{
	$today = date('Y-m-d');
	$old_date = $lastCheck;
	$old_date_array = preg_split("/-/", $old_date);
	$old_date = $old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1];

	$datetime1 = date_create($old_date_array[2]."-".$old_date_array[0]."-".$old_date_array[1]);
	$datetime2 = date_create($today);
	$interval = date_diff($datetime1, $datetime2);
	return $interval->format('%a');
}

function findUpdateValue($newestVersionCount, $versionCount, $newestVersion, $version)
{
	for($i = 0; $i < $newestVersionCount; $i++)
	{
		if($i < $versionCount)
		{
			if($i == 0)
			{
				if($newestVersion[$i] > $version[$i])
				{
					return 3;
				}
				elseif($newestVersion[$i] < $version[$i])
				{
					break;
				}
			}
			elseif($i == 1)
			{
				if($newestVersion[$i] > $version[$i])
				{
					return 2;
				}
				elseif($newestVersion[$i] < $version[$i])
				{
					break;
				}
			}
			else
			{
				if(isset($newestVersion[$i]))
				{
					if($newestVersion[$i] > $version[$i])
					{
						return 1;
					}
					elseif($newestVersion[$i] < $version[$i])
					{
						break;
					}
				}
				else
				{
					break;
				}
			}
		}
		else
		{
			return 1;
		}
	}
	return 0;
}
?>
<?php

$newLocationForStatus = "";

//check for Status
if($locationForStatus !== "")
{
	$newLocationForStatus = $locationForStatus;
}
elseif(file_exists('../../status/index.php'))
{
	$newLocationForStatus = '../../status/index.php';
}
elseif(file_exists('../../../status/index.php'))
{
	$newLocationForStatus = '../../../status/index.php';
}

$newLocationForLogHog = "";

//check for log-hog
if($locationForLogHog !== "")
{
	$newLocationForLogHog = $locationForLogHog;
}
elseif(file_exists('../../Log-Hog/index.php'))
{
	$newLocationForLogHog = '../../Log-Hog/index.php';
}
elseif(file_exists('../../../Log-Hog/index.php'))
{
	$newLocationForLogHog = '../../../Log-Hog/index.php';
}
elseif(file_exists('../../loghog/index.php'))
{
	$newLocationForLogHog = '../../loghog/index.php';
}
elseif(file_exists('../../../loghog/index.php'))
{
	$newLocationForLogHog = '../../../loghog/index.php';
}


$newLocationForMonitor = "";


//check for monitor
if($locationForMonitor)
{
	$newLocationForMonitor = $locationForMonitor;
}
elseif(file_exists('../../monitor/index.php'))
{
	$newLocationForMonitor = '../../monitor/index.php';
}
elseif(file_exists('../../../monitor/index.php'))
{
	$newLocationForMonitor = '../../../monitor/index.php';
}
elseif(file_exists('../../Log-Hog/monitor/index.php'))
{
	$newLocationForMonitor = '../../Log-Hog/monitor/index.php';
}
elseif(file_exists('../../../Log-Hog/monitor/index.php'))
{
	$newLocationForMonitor = '../../../Log-Hog/monitor/index.php';
}
elseif(file_exists('../../loghog/monitor/index.php'))
{
	$newLocationForMonitor = '../../loghog/monitor/index.php';
}
elseif(file_exists('../../../loghog/monitor/index.php'))
{
	$newLocationForMonitor = '../../../loghog/monitor/index.php';
}


$newLocationForSearch = "";


//check for search
if($locationForSearch)
{
	$newLocationForSearch = $locationForSearch;
}
elseif(file_exists('../../search/index.php'))
{
	$newLocationForSearch = '../../search/index.php';
}
elseif(file_exists('../../../search/index.php'))
{
	$newLocationForSearch = '../../../search/index.php';
}
elseif(file_exists('../../Log-Hog/search/index.php'))
{
	$newLocationForSearch = '../../Log-Hog/search/index.php';
}
elseif(file_exists('../../../Log-Hog/search/index.php'))
{
	$newLocationForSearch = '../../../Log-Hog/search/index.php';
}
elseif(file_exists('../../loghog/search/index.php'))
{
	$newLocationForSearch = '../../loghog/search/index.php';
}
elseif(file_exists('../../../loghog/search/index.php'))
{
	$newLocationForSearch = '../../../loghog/search/index.php';
}

if($newLocationForSearch !== "" || $newLocationForMonitor !== "" || $newLocationForLogHog !== "" || $locationForStatus !== ""):
?>
	<style type="text/css">
		#otherLinks ul
		{
			list-style: none;
			float: right;
		}
		#otherLinks ul li
		{
			display: inline-block;
		}
	</style>
	<a onclick="toggleOtherLinks();" class="link" style="float: right;"> Other Apps</a>
	<div style="display: none;" id="otherLinks">
		<ul>
			<?php if($newLocationForSearch):?>
				<li>
					<a href="<?php echo $newLocationForSearch; ?>">Search</a>
				</li>
			<?php endif; ?>
			<?php if($newLocationForMonitor):?>
				<li>
					<a href="<?php echo $newLocationForMonitor; ?>">Monitor</a>
				</li>
			<?php endif; ?>
			<?php if($newLocationForLogHog):?>
				<li>
					<a href="<?php echo $newLocationForLogHog; ?>">Log-Hog</a>
				</li>
			<?php endif; ?>
			<?php if($newLocationForStatus):?>
				<li>
					<a href="<?php echo $newLocationForStatus; ?>">Status</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
	<script type="text/javascript">
		function toggleOtherLinks()
		{
			if(document.getElementById("otherLinks").style.display === "none")
			{
				document.getElementById("otherLinks").style.display = "block";
			}
			else
			{
				document.getElementById("otherLinks").style.display = "none";
			}
			resize();
		}
	</script>
<?php
endif; ?>
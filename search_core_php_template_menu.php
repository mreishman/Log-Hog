<?php 

$URI = $_SERVER['REQUEST_URI'];

$menuItems = array();
$count = 0;
$modifier = "./";
$imageModifier = "../";
$boolOnMainPage = false;

if((strpos($URI, 'main.php') !== false) || (strpos($URI, 'advanced.php') !== false) || (strpos($URI, 'devTools.php') !== false) || (strpos($URI, 'about.php') !== false) || ((strpos($URI, 'whatsNew.php') !== false) || (strpos($URI, 'update.php') !== false) || (strpos($URI, 'changeLog.php') !== false)))
{
	$menuItems[$count] = array("title" => "Back" , "action" => "goToUrl('../index.php')", "image" => "core/img/backArrow.png");
}
else
{
	$boolOnMainPage = true;
	$imageModifier = "./";
	$modifier = "./settings/";
	$menuItems[$count] = array("title" => "New Grep" , "action" => "toggleMenu();showGrepPopup();", "image" => "core/img/search.png");
}
$count++;

if(strpos($URI, 'about.php') !== false)
{
	$menuItems[$count] = array("title" => "About" , "action" => "", "image" => "core/img/info.png");
}
else
{
	$menuItems[$count] = array("title" => "About" , "action" => "window.location = '".$modifier."about.php'", "image" => "core/img/info.png");
}
$count++;

if(strpos($URI, 'main.php') !== false)
{
	$menuItems[$count] = array("title" => "Settings" , "action" => "", "image" => "core/img/Gear.png");
}
else
{
	$menuItems[$count] = array("title" => "Settings" , "action" => "window.location = '".$modifier."main.php'", "image" => "core/img/Gear.png");
}
$count++;

if(((strpos($URI, 'whatsNew.php') !== false) || (strpos($URI, 'update.php') !== false) || (strpos($URI, 'changeLog.php') !== false)))
{
	$menuItems[$count] = array("title" => "Update" , "action" => "", "image" => "core/img/Refresh.png");
}
else
{
	$menuItems[$count] = array("title" => "Update" , "action" => "window.location = '".$modifier."update.php'", "image" => "core/img/Refresh.png");
	
}
$count++;

//check for Status
if($locationForStatus !== "")
{
	$menuItems[$count] = array("title" => "gitStatus" , "action" => "window.location.href =  '"+$locationForStatus+"';", "image" => "core/img/gitStatus.png");
	$count++;
}
elseif(file_exists('../status/index.php'))
{
	$menuItems[$count] = array("title" => "gitStatus" , "action" => "window.location.href =  '../status/';", "image" => "core/img/gitStatus.png");
	$count++;
}
elseif(file_exists('../../status/index.php'))
{
	$menuItems[$count] = array("title" => "gitStatus" , "action" => "window.location.href =  '../../status/';", "image" => "core/img/gitStatus.png");
	$count++;
}

//check for log-hog
if($locationForLogHog !== "")
{
	$menuItems[$count] = array("title" => "Log-Hog" , "action" => "window.location.href =  '"+$locationForLogHog+"';", "image" => "core/img/loghog.png");
	$count++;
}
elseif(file_exists('../Log-Hog/index.php'))
{
	$menuItems[$count] = array("title" => "Log-Hog" , "action" => "window.location.href =  '../Log-Hog/';", "image" => "core/img/loghog.png");
	$count++;
}
elseif(file_exists('../../Log-Hog/index.php'))
{
	$menuItems[$count] = array("title" => "Log-Hog" , "action" => "window.location.href =  '../../Log-Hog/';", "image" => "core/img/loghog.png");
	$count++;
}
	
if(file_exists('../loghog/index.php'))
{
	$menuItems[$count] = array("title" => "Loghog" , "action" => "window.location.href =  '../loghog/';", "image" => "core/img/loghog.png");
	$count++;
}
elseif(file_exists('../../loghog/index.php'))
{
	$menuItems[$count] = array("title" => "Loghog" , "action" => "window.location.href =  '../../loghog/';", "image" => "core/img/loghog.png");
	$count++;
}

//check for monitor
if($locationForMonitor)
{
	$menuItems[$count] = array("title" => "monitor" , "action" => "window.location.href =  '"+$locationForMonitor+"';", "image" => "core/img/task-manager.png");
	$count++;
}
elseif(file_exists('../monitor/index.php'))
{
	$menuItems[$count] = array("title" => "monitor" , "action" => "window.location.href =  '../monitor/';", "image" => "core/img/task-manager.png");
	$count++;
}
elseif(file_exists('../../monitor/index.php'))
{
	$menuItems[$count] = array("title" => "monitor" , "action" => "window.location.href =  '../../monitor/';", "image" => "core/img/task-manager.png");
	$count++;
}
elseif(file_exists('../Log-Hog/monitor/index.php'))
{
	$menuItems[$count] = array("title" => "monitor" , "action" => "window.location.href =  '../Log-Hog/monitor/';", "image" => "core/img/task-manager.png");
	$count++;
}
elseif(file_exists('../../Log-Hog/monitor/index.php'))
{
	$menuItems[$count] = array("title" => "monitor" , "action" => "window.location.href =  '../../Log-Hog/monitor/';", "image" => "core/img/task-manager.png");
	$count++;
}
elseif(file_exists('../loghog/monitor/index.php'))
{
	$menuItems[$count] = array("title" => "monitor" , "action" => "window.location.href =  '../loghog/monitor/';", "image" => "core/img/task-manager.png");
	$count++;
}
elseif(file_exists('../../loghog/monitor/index.php'))
{
	$menuItems[$count] = array("title" => "monitor" , "action" => "window.location.href =  '../../loghog/monitor/';", "image" => "core/img/task-manager.png");
	$count++;
}	

?>
<div id="menuMain" style="width: 100%; height: 100%; background-color: rgba(0,0,0,.85); display: none; position: absolute; z-index: 20; -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px); overflow-y: scroll;">
	<div style="border-bottom: 1px dotted grey; height: 64px; z-index: 21; padding: .5em 1em; background-color: black;">
		<div onclick="toggleMenu();" class="nav-toggle pull-right">
			<a class="show-sidebar" id="show">
		    	<span class="icon-bar-top"></span>
		        <span class="icon-bar-mid"></span>
		        <span class="icon-bar-bot"></span>
		    </a>
		</div>
	</div>
	<?php
	foreach ($menuItems as $menuItem => $value): ?>
		<a style="cursor: pointer" onclick="<?php echo $value['action'];?>">
		<div style="display: inline-block; width: 150px; height: 150px; margin: 75px; z-index: 25;">
			<img src="<?php echo $imageModifier.$value['image'];?>" style="width: 120px; height: 120px; margin-left: 15px;" >
			<p style="width: 100%; text-align: center; margin: 0;" ><?php echo $value['title'];?></p>
			<?php if($menuItem === "Update"):?>
				<?php  if($levelOfUpdate == 1){echo '<img src="'.$imageModifier.'core/img/yellowWarning.png" height="10px">';} ?> <?php if($levelOfUpdate == 2){echo '<img src="'.$imageModifier.'core/img/redWarning.png" height="10px">';} ?>
			<?php endif; ?>
		</div>
		</a>
	<?php endforeach; ?>
</div>
<div id="menu" style="z-index: 19;" class="backgroundForMenus" id="menu">
	<div onclick="toggleMenu();" class="nav-toggle pull-right">
		<a class="show-sidebar" id="show">
	    	<span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	    </a>
	</div>
	<?php if($boolOnMainPage): ?>
		<div style="display: inline-block;">
			<img id="notificationNotClicked" onclick="toggleNotifications();" src="core/img/notification.png" style="width: 22px; height: 22px; position: absolute; top: 21px; cursor: pointer;">
			<img id="notificationClicked" onclick="toggleNotifications();" src="core/img/notificationFull.png" style="width: 22px; height: 22px; position: absolute; top: 21px; cursor: pointer; display: none;">
		</div>
		<div>
			<div id="notificationIcon" style="display: none;">
				<span id="notificationCount" style="width: 10px;height: 10px;border-radius: 50%;background-color: red;display: inline-block;margin-left: 5px;position: absolute;top: 21px; left: 51px; font-size: 68%;"></span>
			</div>
		</div>
		<div id="notifications" style="margin-top: 10px; display: none;">
			<div style="width: 0; height: 0; border-left: 12px solid transparent; border-right: 12px solid transparent;  border-bottom: 12px solid white; margin-left: 29px;" ></div>
			<div id="notificationHolder" style="display: block; width: 300px; color: black; background-color: white; border: 1px solid black; border-bottom: 3px solid black; padding: 10px; padding-bottom: 0px;">
		</div>
		</div>
		
	<?php endif; ?>
	<?php if((strpos($URI, 'main.php') !== false) || (strpos($URI, 'advanced.php') !== false) || (strpos($URI, 'devTools.php') !== false)): ?>
		<a <?php if(strpos($URI, 'main.php') !== false): ?> class='active' <?php else: ?>   onclick="goToUrl('./main.php');" <?php endif;?> > Main Settings </a>
		<a <?php if(strpos($URI, 'advanced.php') !== false): ?> class='active' <?php else: ?>   onclick="goToUrl('./advanced.php');" <?php endif;?> > Advanced </a>
		<a <?php if(strpos($URI, 'devTools.php') !== false): ?> class='active' <?php else: ?>   onclick="goToUrl('./devTools.php');" <?php endif;?> > Dev Tools </a>
	<?php endif; ?>
	<?php if((strpos($URI, 'whatsNew.php') !== false) || (strpos($URI, 'update.php') !== false) || (strpos($URI, 'changeLog.php') !== false)): ?>
		<a <?php if(strpos($URI, 'update.php') !== false): ?> class='active' <?php else: ?>  onclick="goToUrl('./update.php');"  <?php endif;?> > Update </a>
		<!-- 
		<a <?php if(strpos($URI, 'whatsNew.php') !== false): ?> class='active' <?php else: ?>  onclick="goToUrl('./whatsNew.php');"  <?php endif;?> > What's New? </a>
		-->
		<a <?php if(strpos($URI, 'changeLog.php') !== false): ?> class='active' <?php else: ?>  onclick="goToUrl('./changeLog.php');"  <?php endif;?> > Changelog </a>
	<?php endif; ?>
</div>
<script type="text/javascript">
	function toggleMenu()
	{
		if(document.getElementById("menuMain").style.display === "block")
		{
			document.getElementById("menuMain").style.display = "none";
		}
		else
		{
			document.getElementById("menuMain").style.display = "block";
		}
	}
</script>
<?php

function checkForUpdate($filePath)
{
	if(file_exists("test"))
	{
		rmdir("test");
	}

	mkdir("test");

	$boolForCheck = file_exists("test");
	if(!$boolForCheck)
	{
		header("Location: "."../../error.php?error=550&page=".$filePath, true, 302); /* Redirect browser */
	}
	elseif($boolForCheck)
	{
		rmdir("test");
	}

}
?>
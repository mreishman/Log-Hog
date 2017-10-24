<?php

function checkForUpdate($filePath)
{
	if(file_exists("test"))
	{
		rmdir("test");
	}

	mkdir("test");

	if(!file_exists("test"))
	{
		header('Location: '."../../error.php?error=550&page=".$filePath, TRUE, 302); /* Redirect browser */
		exit();
	}
	else
	{
		rmdir("test");
	}
	
}
?>
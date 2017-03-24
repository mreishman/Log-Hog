<?php

function checkForUpdate($filePath)
{
	mkdir("test");

	if(!file_exists("test"))
	{
		header('Location: '."../../error.php?error=550&page=".$filePath, TRUE, 302); /* Redirect browser */
		exit();
	}
	
	rmdir("test");
}
?>
<?php

mkdir("test");

if(!file_exists("test"))
{
	header('Location: '."../../error.php?error=550", TRUE, 302); /* Redirect browser */
	exit();
}

?>
<?php

$command = "rm ".$_POST['file'];

shell_exec($command);

?>
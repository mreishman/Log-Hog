<?php
$command = "truncate -s 0 ".$_POST['file'];
shell_exec($command);
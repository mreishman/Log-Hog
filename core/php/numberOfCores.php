<?php

echo json_encode(shell_exec("cat /proc/cpuinfo | grep processor | wc -l"));

?>
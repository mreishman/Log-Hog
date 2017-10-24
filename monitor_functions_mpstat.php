<?php

echo json_encode(shell_exec("mpstat -P ALL 1 1"));

?>
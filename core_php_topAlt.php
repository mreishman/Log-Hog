<?php
`screen  -d -m -S top_session top -d 1`;
sleep(2);
`screen -p 0 -S top_session -X hardcopy`;
`screen -p 0 -S top_session -X quit`;
shell_exec("pkill top");
echo json_encode(file_get_contents('hardcopy.0')); ?>

<?php
`screen  -d -m -S top_session top`;
sleep(1);
`screen -p 0 -S top_session -X hardcopy`;
`screen -p 0 -S top_session -X quit`;

echo json_encode(file_get_contents('hardcopy.0')); ?>

<?php
unlink($_POST['file']);
echo json_encode($_POST['file']);
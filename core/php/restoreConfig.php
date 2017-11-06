<?php
$restoreTo = $_POST["restoreTo"];

// Remove files above current restore to (if any)

//move current restore to to tmp file

//Copy current config to config-1 

//move current tmp file (current restore) to main config

//move files after current restore (if any) back up to below previous restore to 

echo json_encode(true);
<?php
require_once('../../local/layout.php');
$baseUrl = "../../local/".$currentSelectedTheme."/";
return json_encode(is_file(file_exists($baseUrl."conf/config1Diff.php")));
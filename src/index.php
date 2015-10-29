<?php

namespace STM;

use STM\Database\DB;

require_once __DIR__.'/../vendor/autoload.php';

$db = new DB;
$query = $db->query("show tables")->fetch_assoc();
var_dump(array_values($query));

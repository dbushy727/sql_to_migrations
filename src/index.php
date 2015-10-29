<?php

namespace STM;

use STM\Database\DB;

require_once __DIR__.'/../vendor/autoload.php';

$db = new DB;
$query = $db->query("SELECT * FROM tasks");
var_dump($query);

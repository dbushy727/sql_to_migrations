<?php


use STM\Database\DB;
use STM\Database\Table;

require_once __DIR__.'/../vendor/autoload.php';

$db = new DB;
$table = new Table($db, 'tasks');

var_dump($table->columns());

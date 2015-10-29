<?php


use STM\Database\DB;
use STM\Database\Table;
use STM\Migration\Migration;

class MigrationTest extends PHPUnit_Framework_TestCase
{
    protected $db;
    protected $table;
    protected $migration;

    protected function setUp()
    {
        $this->db = new DB;
        $this->table = new Table($this->db, 'tasks');
        $this->migration = new Migration($this->table, 'laravel');
    }
}

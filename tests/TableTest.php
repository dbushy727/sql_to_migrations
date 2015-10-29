<?php

use STM\Database\DB;
use STM\Database\Table;

class TableTest extends PHPUnit_Framework_TestCase
{
    protected $db;
    protected $table;

    protected function setUp()
    {
        $this->db       = new DB;
        $this->table    = new Table($this->db, 'tasks');
    }

    public function testCanGetName()
    {
        $name = $this->table->name();
        $this->assertEquals($name, 'tasks');
    }

    public function testCanGetColumns()
    {
        $first_column = $this->table->columns()[0];
        
        $column_attributes = [
            "name",
            "position",
            "default",
            "nullable",
            "data_type",
            "char_max",
            "numeric_precision",
            "numeric_scale",
            "key",
            "is_unsigned"
        ];

        $this->assertEquals($column_attributes, array_keys($first_column));
    }
}

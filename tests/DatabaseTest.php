<?php

use STM\Database\DB;

class DatabaseTest extends PHPUnit_Framework_TestCase
{
    protected $db;

    protected function setUp()
    {
        $this->db = new DB;
    }

    public function testGetCorrectParamDataTypes()
    {
        $params             = [123, 'ABC', 12.30];
        $param_data_types   = $this->db->paramDataTypes($params);

        $this->assertEquals("isd", $param_data_types);
    }
    
    public function testCanQuery()
    {
        $query = $this->db->query("SELECT * FROM information_schema.SCHEMA_PRIVILEGES LIMIT 1");

        $this->assertInstanceOf('mysqli_result', $query);
    }

    public function testCanGetTables()
    {
        $tables                     = $this->db->query("show tables")->fetch_assoc();
        $first_table_from_method    = $this->db->tables()[0];
        $first_table_from_query     = array_values($tables)[0];

        $this->assertEquals($first_table_from_query, $first_table_from_method);
    }
}

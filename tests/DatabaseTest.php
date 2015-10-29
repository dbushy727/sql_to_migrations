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
        $params = [123, 'ABC', 12.30];
        $param_data_types = $this->db->paramDataTypes($params);
        $this->assertEquals("isd", $param_data_types);
    }
    
    public function testCanQuery()
    {
        $query = $this->db->query("SELECT * FROM information_schema.SCHEMA_PRIVILEGES LIMIT 1");
        $this->assertInstanceOf('mysqli_result', $query);
    }
}

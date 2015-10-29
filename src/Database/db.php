<?php

namespace STM\Database;

class DB
{

    /**
     * Database Connection
     * @var Database Object
     */
    protected $db;

    /**
     * Establish connection once the instance has been created
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Establish connection to database
     *
     * @author Danny Bushkanets     d.bushkanets@gmail.com
     * @return void
     */
    protected function connect()
    {
        $hostname = getenv("MYSQL_HOSTNAME");
        $username = getenv("MYSQL_USERNAME");
        $password = getenv("MYSQL_PASSWORD");
        $db_name  = getenv("MYSQL_DB_NAME");

        $this->db = new \mysqli($hostname, $username, $password, $db_name);
    }

    /**
     * Get datatype symbols for all parameters
     *
     * @author Danny Bushkanets     d.bushkanets@gmail.com
     * @param  Array  $params       parameters that would be used in a query
     * @return string               string of all datatype symbols with no delimiter
     */
    public function paramDataTypes(Array $params)
    {
        // Get first letter of each param's data type
        foreach ($params as $param) {
            $types[] = gettype($param)[0];
        }

        return implode($types);
    }

    /**
     * Run a query against the database
     *
     * @author Danny Bushkanets     d.bushkanets@gmail.com
     * @param  string $query        SQL Statement
     * @param  Array  $params       bindings for the query to make it safer against sql injection
     * @return mysqli_result        mysqli result object containing data about query
     */
    public function query($query, Array $params = [])
    {
        // Only allow strings for query statement
        if (!is_string($query)) {
            throw new InvalidArgumentException('Paramater must be of type String.');
        }

        // Dynamically bind parameters to the query
        if (!empty($params)) {
            $sql    = $this->db->prepare($query);
            $types  = $this->paramDataTypes($params);

            $number_of_params = count($params);

            // Load data types of parameters by reference first
            $bind_params[] = &$types;

            // Load the rest of the parameters in by reference
            for ($i = 0; $i < $number_of_params; $i++) {
                $bind_params[] = &$params[$i];
            }

            // Call bind param function and pass in parameters
            call_user_func_array([$sql, 'bind_param'], $bind_params);

            // Execute query
            $sql->execute();

            return $sql->get_result();
        }

        return $this->db->query($query);
    }
}

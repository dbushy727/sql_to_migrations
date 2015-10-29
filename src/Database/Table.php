<?php

namespace STM\Database;

class Table
{
    /**
     * Name of the table in the database
     *
     * @author  Danny Bushkanets        d.bushkanets@gmail.com
     * @var     String
     */
    protected $name;

    /**
     * Columns of the table
     *
     * @author  Danny Bushkanets        d.bushkanets@gmail.com
     * @var     Array
     */
    protected $columns;

    /**
     * Instance of a table in the database
     *
     * @author  Danny Bushkanets                    d.bushkanets@gmail.com
     * @param   DB                  $db             DB Instance
     * @param   String              $name           Name of the table in the database
     * @return  Void
     */
    public function __construct(DB $db, $name)
    {
        $this->db   = $db;
        $this->name = $name;
    }

    /**
     * Get the name of the table
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @return Void
     */
    public function name()
    {
        return $this->name;
    }
    
    /**
     * Get the columns of this table
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @return Array                    Full description of all the columns of the table
     */
    public function columns()
    {
        // Query information schema to get all columns for a table
        $query = $this->db->query(
            "SELECT 
                * 
            FROM 
                information_schema.columns 
            WHERE 
                table_schema = ? 
            AND 
                table_name = ?
            ORDER BY
                ORDINAL_POSITION ASC",
            [$this->db->name(), $this->name]
        );

        // Format data into more readable format
        while ($column = $query->fetch_assoc()) {
            $formatted_column = [
                "name"              => $column['COLUMN_NAME'],
                "position"          => $column['ORDINAL_POSITION'],
                "default"           => $column['COLUMN_DEFAULT'],
                "nullable"          => $column['IS_NULLABLE'],
                "data_type"         => $column['DATA_TYPE'],
                "char_max"          => $column['CHARACTER_MAXIMUM_LENGTH'],
                "numeric_precision" => $column['NUMERIC_PRECISION'],
                "numeric_scale"     => $column['NUMERIC_SCALE'],
                "key"               => $column['COLUMN_KEY'],
            ];

            $formatted_column['is_unsigned'] = strpos($column['COLUMN_TYPE'], "unsigned") ? true : false;

            $this->columns[] = $formatted_column;
        }

        return $this->columns;
    }
}

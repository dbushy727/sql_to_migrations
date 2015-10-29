<?php

namespace STM\Migration;

class Migration
{
    /**
     * Name of the framework
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @var    String
     */
    protected $framework;

    /**
     * Migration File on the filesystem
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @var    Resource
     */
    protected $migration_file;

    /**
     * Table used for the migration
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @var    Table
     */
    protected $table;

    /**
     * Indicator if file is open or closed
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @var    Boolean
     */
    protected $is_open;

    /**
     * Instance of migration file
     *
     * @author Danny Bushkanets                        d.bushkanets@gmail.com
     * @param  Table               $table              Table from the database
     * @param  String              $framework          Name of the framework
     */
    public function __construct(Table $table, $framework = 'Laravel')
    {
        $this->framework    = strtolower($framework);
        $this->table        = $table;
    }

    /**
     * Get table name
     *
     * @author Danny Bushkanets            d.bushkanets@gmail.com
     * @return String                      Name of the table
     */
    public function table()
    {
        return $this->table;
    }

    /**
     * Open a migration file on the filesystem
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @return Void
     */
    public function open()
    {
        $this->migration_file = fopen("/migrations/{date("Ymdhis")}_{$this->table->name()}", "w");
        $this->is_open = true;
    }

    /**
     * Close a migration file resource
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @return Void
     */
    public function close()
    {
        fclose($this->migration_file);
        $this->is_open = false;
    }

    /**
     * Make sure a migration file is currently open
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @return Boolean|Exception
     */
    public function validateOpen()
    {
        if (!$this->is_open) {
            throw new Exception("Migration File must be opened first.");
        }

        return true;
    }

    /**
     * Write the opening of a function to a file
     *
     * @author Danny Bushkanets                 d.bushkanets@gmail.com
     * @param  String               $name       Name of the function
     * @return Void
     */
    public function openFunction($name)
    {
        $this->validateOpen();
        $function_open = "\tpublic function $name()\n{";

        fwrite($this->migration_file, $function_open);
    }

    /**
     * Write the close of the function to a file
     *
     * @author Danny Bushkanets         d.bushkanets@gmail.com
     * @return Void
     */
    public function closeFunction()
    {
        $this->validateOpen();
        $function_close = "\t}";

        fwrite($this->migration_file, $function_close);
    }
}

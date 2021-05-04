<?php
class fix_20210201120224_initialize
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        /**
         * ----------------------------------------------------
         * INITIALIZE TRUNCATE TABLE
         * ----------------------------------------------------
         */
        $tableList = $this->dbHandle->query(
            "SELECT
                Concat('TRUNCATE TABLE ', TABLE_NAME) as concat_table
            FROM
                INFORMATION_SCHEMA.TABLES
            WHERE
                table_schema = 'afpaconnect';"
        );

        $tableList = $tableList->fetchAll();

        $query = "SET FOREIGN_KEY_CHECKS=0;";

        foreach ($tableList as $table) {
            $query .= $table['concat_table'] .';';
        }

        $query .= "SET FOREIGN_KEY_CHECKS=1;";
        $this->dbHandle->query($query);
    }
    
}

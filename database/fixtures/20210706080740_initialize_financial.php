<?php
class fix_20210706080740_initialize_financial
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
         * Create financials
         */
        $query =   "INSERT INTO `financials` (`id`, `tag`, `name`, `public_name`) VALUES (NULL, '300', 'REMU Région - Rémunération subsidiaire Région', 'Région')";
        $this->dbHandle->query($query);

        $query =   "INSERT INTO `financials` (`id`, `tag`, `name`, `public_name`) VALUES (NULL, '400', 'Armée de l\'air', 'PSMIL Air')";
        $this->dbHandle->query($query);

        $query =   "INSERT INTO `financials` (`id`, `tag`, `name`, `public_name`) VALUES (NULL, '400', 'Armée de terre', 'PSMIL Terre')";
        $this->dbHandle->query($query);
    }
    
}

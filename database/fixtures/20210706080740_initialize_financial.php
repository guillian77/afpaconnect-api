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

        $query =   "INSERT INTO `financials` (`id`, `tag`, `name`, `public_name`) VALUES (NULL, '500', 'REMU Région - Rémunération subsidiaire Région', 'Région');
                    INSERT INTO `financials` (`id`, `tag`, `name`, `public_name`) VALUES (NULL, '900', 'AREF Pole Emploi - Assurance chômage (AFF compris)', 'AREF PE');
                    INSERT INTO `financials` (`id`, `tag`, `name`, `public_name`) VALUES (NULL, '800', 'BENEFICIAIRES SANS REMUNERATION', 'BENEFICIAIRES SANS REMUNERATION');
                    INSERT INTO `financials` (`id`, `tag`, `name`, `public_name`) VALUES (NULL, '503', 'REMUN REGION:HANDICAPES (LOI DU 10/07/1987)', 'REMUN REGION:HANDICAPES');";

        $this->dbHandle->query($query);
    }
    
}

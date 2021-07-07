<?php
class mig_20210705030733_nullable_default_value
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        // ALTER FORMATION TABLE
        $query = "ALTER TABLE `formations` CHANGE `tag` `tag` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;";
        $this->dbHandle->query($query);

        $query = "ALTER TABLE `formations` CHANGE `degree` `degree` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;";
        $this->dbHandle->query($query);

        $query = "ALTER TABLE `formations` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1';";
        $this->dbHandle->query($query);

        // ALTER SESSION TABLE
        $query = "ALTER TABLE `sessions` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1';";
        $this->dbHandle->query($query);

        $query = "ALTER TABLE `sessions` CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;";
        $this->dbHandle->query($query);

        $query = "ALTER TABLE `users` CHANGE `mailPro` `mail1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
        $this->dbHandle->query($query);

        $query = "ALTER TABLE `users` CHANGE `mailPerso` `mail2` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
        $this->dbHandle->query($query);

        $query = "ALTER TABLE `users` ADD `measure` VARCHAR(255) NOT NULL AFTER `gender`, ADD `convention` VARCHAR(255) NOT NULL AFTER `measure`;";
        $this->dbHandle->query($query);

        $query = "ALTER TABLE `sessions` ADD `n_offer` INT(11) NOT NULL AFTER `name`, ADD `label_offer` VARCHAR(255) NOT NULL AFTER `n_offer`;";
        $this->dbHandle->query($query);

        $query = "ALTER TABLE `sessions` DROP `tag`;";
        $this->dbHandle->query($query);
        // Ajouter select formation dans téléversement ou créer si n'existe pas
        // Libelle offre dans session + num offre
    }
    
}

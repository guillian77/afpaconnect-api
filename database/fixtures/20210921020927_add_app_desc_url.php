<?php
class fix_20210921020927_add_app_desc_url
{
    public $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        $apps = $this->dbHandle->query('SELECT * FROM apps');

        foreach ($apps as $app) {
            $appName = "Une jolie description pour " . strtolower($app['name']) . ".";
            $url = "https://" . strtolower($app['name']) . ".fr";

            $stmt = $this->dbHandle->prepare('UPDATE apps SET description = :description, url = :url WHERE id = :id');
            $stmt->bindParam('id', $app['id']);
            $stmt->bindParam('description', $appName);
            $stmt->bindParam('url', $url);

            $stmt->execute();
        }
    }
    
}

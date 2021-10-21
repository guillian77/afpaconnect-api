<?php
class fix_20210824010824_add_apps_tags
{
    public PDO $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        // Get all apps.
        $apps = $this->dbHandle->query('SELECT * FROM apps');

        // Add tags to apps.
        foreach ($apps as $app) {
            $appTag = "APP_" . strtoupper($app['name']);
            $appId = $app['id'];

            $stmt = $this->dbHandle->prepare('UPDATE apps SET tag = :tag WHERE id = :id');
            $stmt->bindParam('tag', $appTag);
            $stmt->bindParam('id', $appId);

            $stmt->execute();
        }
    }
    
}

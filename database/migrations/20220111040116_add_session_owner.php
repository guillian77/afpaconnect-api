<?php
class mig_20220111040116_add_session_owner
{
    public PDO $dbHandle;
    
    public function __construct($dbHandle)
    {
        $this->dbHandle = $dbHandle;
        $this->exec();
    }
    
    public function exec()
    {
        $this->dbHandle->query('alter table sessions add owner int default null null;');
        $this->dbHandle->query('alter table sessions add constraint sessions_users__fk foreign key (owner) references users (`id`);');

        $this->dbHandle->query('alter table users add teacher bool default 0 not null after password_temp;');
            /**
             * alter table sessions
            add owner int default null null;

            alter table sessions
            add constraint sessions_users__fk
            foreign key (owner) references users (`id`);


             */
    }
    
}

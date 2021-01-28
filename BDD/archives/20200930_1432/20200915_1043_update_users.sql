-- Add comments for users
ALTER TABLE `users` CHANGE `active_users` `active_users` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '(0=deleted) - (1=actived) - (2=pending) - (3=banned)';

-- Add rank field to know if user is admin or not
ALTER TABLE `users` ADD `rank_users` BOOLEAN NOT NULL COMMENT 'True: admin, False: user' AFTER `password_users`;

-- Put admin user as admin
UPDATE `users` SET `rank_users` = '1' WHERE `users`.`id_users` = 1;
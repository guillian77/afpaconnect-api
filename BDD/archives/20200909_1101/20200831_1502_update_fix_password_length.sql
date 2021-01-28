-- ------------------------------------
-- Fix: Password breaking after login
-- ------------------------------------

-- UDDATE password_users max length
ALTER TABLE `users` CHANGE `password_users` `password_users` VARCHAR(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

-- UPDATE admin password
UPDATE `users` SET `password_users` = '$argon2i$v=19$m=1024,t=2,p=2$QjBYYXhKUU01VnNtMjZIeA$R2Ej9VDeb263+GCozGIX/jjjkk/L9zMW6Btrba3kGi8' WHERE `users`.`id_users` = 1;
-- UPDATE user password
UPDATE `users` SET `password_users` = '$argon2i$v=19$m=1024,t=2,p=2$WFZDd3I1RkhNam9UR2xWQQ$vxwtJmhuLrE/pdmculP+PXDmgYgPwAe8robynG3qETs' WHERE `users`.`id_users` = 2;
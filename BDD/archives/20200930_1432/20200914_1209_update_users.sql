-- Update key_reset_users length from 10 to 13
ALTER TABLE `users` CHANGE `key_reset_users` `key_reset_users` VARCHAR(13) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

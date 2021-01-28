-- --------------------------
-- PRIORITIES
-- --------------------------
-- Update designation_prioritys length from 7 to 8
ALTER TABLE `prioritys` CHANGE `designation_prioritys` `designation_prioritys` VARCHAR(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
RENAME TABLE `afpaticket`.`prioritys` TO `afpaticket`.`priorities`;

-- --------------------------
-- TICKETS
-- --------------------------
-- Change name of date_tickets to created_at_tickets AND convert tinyint to DATETIME
ALTER TABLE `tickets` CHANGE `date_tickets` `created_at_tickets` DATETIME NOT NULL;

-- ADD new field created_at_tickets
ALTER TABLE `tickets` ADD `updated_at_tickets` DATETIME NULL AFTER `created_at_tickets`;
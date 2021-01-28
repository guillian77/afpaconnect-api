-- Edit resolved_tickets to BOOLEAN AND default FALSE
ALTER TABLE `tickets` CHANGE `resolved_tickets` `resolved_tickets` BOOLEAN NULL DEFAULT FALSE;

-- Edit active_tickets to BOOLEAN AND default TRUE
ALTER TABLE `tickets` CHANGE `active_tickets` `active_tickets` BOOLEAN NOT NULL DEFAULT TRUE;

-- Set default value to current timestamp for created_at_tickets
ALTER TABLE `tickets` CHANGE `created_at_tickets` `created_at_tickets` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- 
ALTER TABLE `tickets` CHANGE `reported_tickets` `reported_tickets` BOOLEAN NOT NULL DEFAULT FALSE;

-- 
ALTER TABLE `tickets` CHANGE `count_report_tickets` `count_report_tickets` TINYINT(4) NOT NULL DEFAULT '0';

-- 
ALTER TABLE `tickets` CHANGE `subject_tickets` `subject_tickets` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
-- --------------------------
-- SCREENS: update
-- --------------------------
-- Change name_screens length from 10 to 40
ALTER TABLE `screens` CHANGE `name_screens` `name_screens` VARCHAR(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

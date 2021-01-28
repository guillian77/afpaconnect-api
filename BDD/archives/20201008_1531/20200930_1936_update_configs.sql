-- --------------------------
-- CONFIGS: update
-- --------------------------

-- Expend screenshot maximum size if not
UPDATE `configs` SET `size_screen_configs` = 4000000 WHERE `size_screen_configs` = 1024;

-- Add comment on "size_screen_configs"
ALTER TABLE `configs` CHANGE `size_screen_configs` `size_screen_configs` INT(11) NOT NULL COMMENT 'Maximum size for one screenshot. Size is in octect. So 4Mo = 4000000 octets for this field.';
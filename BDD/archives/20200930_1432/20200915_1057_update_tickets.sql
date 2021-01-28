ALTER TABLE `tickets` CHANGE `active_tickets` `active_tickets` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '(0=deleted) - (1=actived) - (2=reported)';

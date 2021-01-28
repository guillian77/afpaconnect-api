#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: users
#------------------------------------------------------------

CREATE TABLE users(
        id_users         Int  Auto_increment  NOT NULL ,
        firstname_users  Varchar (50) NOT NULL ,
        lastname_users   Varchar (50) NOT NULL ,
        email_users      Varchar (100) NOT NULL ,
        password_users   Varchar (60) NOT NULL ,
        key_reset_users  Varchar (10) ,
        birthdate_users  Date NOT NULL ,
        discord_id_users Varchar (40) NOT NULL ,
        created_at_users Date NOT NULL ,
        updated_at_users Date ,
        active_users     Bool NOT NULL default 1
	,CONSTRAINT users_PK PRIMARY KEY (id_users)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: formations
#------------------------------------------------------------

CREATE TABLE formations(
        id_formations          Int  Auto_increment  NOT NULL ,
        designation_formations Varchar (50) NOT NULL ,
        active_formations      Bool NOT NULL default 1
	,CONSTRAINT formations_PK PRIMARY KEY (id_formations)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sessions
#------------------------------------------------------------

CREATE TABLE sessions(
        id_sessions     Int  Auto_increment  NOT NULL ,
        date_sessions   Date ,
        active_sessions Bool NOT NULL default 1,
        id_formations   Int NOT NULL
	,CONSTRAINT sessions_PK PRIMARY KEY (id_sessions)

	,CONSTRAINT sessions_formations_FK FOREIGN KEY (id_formations) REFERENCES formations(id_formations)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: topics
#------------------------------------------------------------

CREATE TABLE topics(
        id_topics          Int  Auto_increment  NOT NULL ,
        designation_topics Varchar (30) NOT NULL ,
        active_topics      Bool NOT NULL default 1
	,CONSTRAINT topics_PK PRIMARY KEY (id_topics)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: prioritys
#------------------------------------------------------------

CREATE TABLE prioritys(
        id_prioritys          Int  Auto_increment  NOT NULL ,
        designation_prioritys Varchar (7) NOT NULL ,
        interval_prioritys    Time NOT NULL ,
        active_prioritys      Bool NOT NULL default 1
	,CONSTRAINT prioritys_PK PRIMARY KEY (id_prioritys)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: tickets
#------------------------------------------------------------

CREATE TABLE tickets(
        id_tickets           Int  Auto_increment  NOT NULL ,
        date_tickets         Bool NOT NULL ,
        subject_tickets      Varchar (50) NOT NULL ,
        description_tickets  Varchar (600) NOT NULL ,
        resolved_tickets     Bool NOT NULL ,
        count_report_tickets TinyINT NOT NULL ,
        reported_tickets     Bool NOT NULL ,
        active_tickets       Bool NOT NULL default 1,
        id_topics            Int NOT NULL ,
        id_prioritys         Int NOT NULL
	,CONSTRAINT tickets_PK PRIMARY KEY (id_tickets)

	,CONSTRAINT tickets_topics_FK FOREIGN KEY (id_topics) REFERENCES topics(id_topics)
	,CONSTRAINT tickets_prioritys0_FK FOREIGN KEY (id_prioritys) REFERENCES prioritys(id_prioritys)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: configs
#------------------------------------------------------------

CREATE TABLE configs(
        id_configs                    Int  Auto_increment  NOT NULL ,
        discord_token_configs         Varchar (255) NOT NULL ,
        discord_id_guild_configs      Int NOT NULL ,
        discord_notif_channel_configs Varchar (255) NOT NULL ,
        ticket_limit_configs          Int NOT NULL ,
        img_limit_configs             Int NOT NULL ,
        report_limit_configs          Int NOT NULL ,
        size_screen_configs           Int NOT NULL ,
        active_configs                Bool NOT NULL default 1
	,CONSTRAINT configs_PK PRIMARY KEY (id_configs)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: screens
#------------------------------------------------------------

CREATE TABLE screens(
        id_screens   Int  Auto_increment  NOT NULL ,
        name_screens Varchar (10) NOT NULL ,
        id_tickets   Int NOT NULL
	,CONSTRAINT screens_PK PRIMARY KEY (id_screens)

	,CONSTRAINT screens_tickets_FK FOREIGN KEY (id_tickets) REFERENCES tickets(id_tickets)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users__sessions
#------------------------------------------------------------

CREATE TABLE users__sessions(
        id_sessions Int NOT NULL ,
        id_users    Int NOT NULL
	,CONSTRAINT users__sessions_PK PRIMARY KEY (id_sessions,id_users)

	,CONSTRAINT users__sessions_sessions_FK FOREIGN KEY (id_sessions) REFERENCES sessions(id_sessions)
	,CONSTRAINT users__sessions_users0_FK FOREIGN KEY (id_users) REFERENCES users(id_users)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: users__tickets
#------------------------------------------------------------

CREATE TABLE users__tickets(
        id_tickets            Int NOT NULL ,
        id_users              Int NOT NULL ,
        status_users__tickets Varchar (10) NOT NULL ,
        date_report           Date ,
        reason_report         Varchar (255)
	,CONSTRAINT users__tickets_PK PRIMARY KEY (id_tickets,id_users)

	,CONSTRAINT users__tickets_tickets_FK FOREIGN KEY (id_tickets) REFERENCES tickets(id_tickets)
	,CONSTRAINT users__tickets_users0_FK FOREIGN KEY (id_users) REFERENCES users(id_users)
)ENGINE=InnoDB;

-- --------------------------------------------
-- UPDATES AND SEEDING
-- --------------------------------------------

-- ----------------------
-- USERS: update
-- ----------------------
-- Change password length from 60 to 95 for password hashing. PASSWORD_ARGON2I take 95 characters length.
ALTER TABLE `users` CHANGE `password_users` `password_users` VARCHAR(95) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

-- ----------------------
-- USERS: seed
-- ----------------------
INSERT INTO `users`
    (`id_users`, `firstname_users`, `lastname_users`, `email_users`, `password_users`, `key_reset_users`, `birthdate_users`, `discord_id_users`, `created_at_users`, `updated_at_users`, `active_users`)
    VALUES
    (NULL, 'Jean-Jacques', 'Pagan', 'jean-jacques.pagan@afpa.fr', '$argon2i$v=19$m=1024,t=2,p=2$c0dGTmwuNDYzQkRkclFrZA$BeT6jvtx/ZmXuRm4gas5R6eBKeSVlvrBtt6UzFxAwgk', NULL, '1995-09-01', 'jijou#6855', '2020-08-27', NULL, '1');

INSERT INTO `users`
    (`id_users`, `firstname_users`, `lastname_users`, `email_users`, `password_users`, `key_reset_users`, `birthdate_users`, `discord_id_users`, `created_at_users`, `updated_at_users`, `active_users`)
    VALUES
    (NULL, 'Thomas', 'Gonzalez-vega', 'thomas.gonzalez-vega@afpa.fr', '$argon2i$v=19$m=1024,t=2,p=2$c0dGTmwuNDYzQkRkclFrZA$BeT6jvtx/ZmXuRm4gas5R6eBKeSVlvrBtt6UzFxAwgk', NULL, '1995-09-01', 'Twikey#0035', '2020-08-27', NULL, '1');

-- ----------------------
-- FORMATIONS: seed
-- ----------------------

-- DWWM
INSERT INTO `formations` (`id_formations`, `designation_formations`, `active_formations`) VALUES (NULL, 'Développeur web et web mobile', '1');
INSERT INTO `sessions` (`id_sessions`, `date_sessions`, `active_sessions`, `id_formations`) VALUES (NULL, '2020-04-06', '1', '1');

-- CDA
INSERT INTO `formations` (`id_formations`, `designation_formations`, `active_formations`) VALUES (NULL, "Concepteur développeur d'application", '1');
INSERT INTO `sessions` (`id_sessions`, `date_sessions`, `active_sessions`, `id_formations`) VALUES (NULL, '2020-04-06', '1', '2');

-- --------------------------
-- PRIORITIES: update
-- --------------------------
-- Update designation_prioritys length from 7 to 8
ALTER TABLE `prioritys` CHANGE `designation_prioritys` `designation_prioritys` VARCHAR(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
RENAME TABLE `prioritys` TO `priorities`;

-- --------------------------
-- TICKETS: update
-- --------------------------
-- Change name of date_tickets to created_at_tickets AND convert tinyint to DATETIME
ALTER TABLE `tickets` CHANGE `date_tickets` `created_at_tickets` DATETIME NOT NULL;

-- ADD new field created_at_tickets
ALTER TABLE `tickets` ADD `updated_at_tickets` DATETIME NULL AFTER `created_at_tickets`;

-- --------------------------
-- USERS: update
-- --------------------------

-- Add rank field to know if user is admin or not
ALTER TABLE `users` ADD `rank_users` BOOLEAN NOT NULL COMMENT 'True: admin, False: user' AFTER `password_users`;

-- Put admin user as admin
UPDATE `users` SET `rank_users` = '1' WHERE `users`.`id_users` = 1;

-- --------------------------
-- TICKETS: update
-- --------------------------

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

-- --------------------------
-- PRIORITIES: update
-- --------------------------

-- Change priority to priorities for fields
ALTER TABLE `priorities` CHANGE `id_prioritys` `id_priorities` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `designation_prioritys` `designation_priorities` VARCHAR(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL, CHANGE `interval_prioritys` `interval_priorities` TIME NOT NULL, CHANGE `active_prioritys` `active_priorities` TINYINT(1) NOT NULL DEFAULT '1';

-- --------------------------
-- TOPICS: seed
-- --------------------------

-- Insert topics
INSERT INTO `topics` (`id_topics`, `designation_topics`, `active_topics`) VALUES (NULL, 'PHP', '1'), (NULL, 'Javascript', '1');
INSERT INTO `topics` (`id_topics`, `designation_topics`, `active_topics`) VALUES (NULL, 'HTML', '1'), (NULL, 'CSS', '1');
INSERT INTO `topics` (`id_topics`, `designation_topics`, `active_topics`) VALUES (NULL, 'Bootstrap', '1'), (NULL, 'POO PHP', '1');
INSERT INTO `topics` (`id_topics`, `designation_topics`, `active_topics`) VALUES (NULL, 'Laravel', '1'), (NULL, 'Symphony', '1');
INSERT INTO `topics` (`id_topics`, `designation_topics`, `active_topics`) VALUES (NULL, 'VueJs', '0'), (NULL, 'React', '0');

-- Insert priorities
INSERT INTO `priorities` (`id_priorities`, `designation_priorities`, `interval_priorities`, `active_priorities`) VALUES (NULL, 'mineur', '30', '1'), (NULL, 'majeur', '15', '1'), (NULL, 'bloquant', '10', '1');

-- --------------------------
-- USERS: update
-- --------------------------

-- ------------------------------------
-- Fix: Password breaking after login
-- ------------------------------------

-- UDDATE password_users max length
ALTER TABLE `users` CHANGE `password_users` `password_users` VARCHAR(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

-- UPDATE admin password
UPDATE `users` SET `password_users` = '$argon2i$v=19$m=1024,t=2,p=2$QjBYYXhKUU01VnNtMjZIeA$R2Ej9VDeb263+GCozGIX/jjjkk/L9zMW6Btrba3kGi8' WHERE `users`.`id_users` = 1;
-- UPDATE user password
UPDATE `users` SET `password_users` = '$argon2i$v=19$m=1024,t=2,p=2$WFZDd3I1RkhNam9UR2xWQQ$vxwtJmhuLrE/pdmculP+PXDmgYgPwAe8robynG3qETs' WHERE `users`.`id_users` = 2;

-- --------------------------
-- CONFIGS: update
-- --------------------------

-- Remove useless auto increment ID from configs table.
ALTER TABLE configs DROP COLUMN id_configs;

-- Remove useless auto increment ID from configs table.
ALTER TABLE configs DROP COLUMN active_configs;

-- Edit any fields to unique
ALTER TABLE `configs` ADD UNIQUE(`discord_token_configs`);
ALTER TABLE `configs` ADD UNIQUE(`discord_id_guild_configs`);
ALTER TABLE `configs` ADD UNIQUE(`discord_notif_channel_configs`);
ALTER TABLE `configs` ADD UNIQUE(`ticket_limit_configs`);
ALTER TABLE `configs` ADD UNIQUE(`img_limit_configs`);
ALTER TABLE `configs` ADD UNIQUE(`report_limit_configs`);
ALTER TABLE `configs` ADD UNIQUE(`size_screen_configs`);

-- Move discord_id_guild_configs length from 11 to 18 + BIG INT
ALTER TABLE `configs` CHANGE `discord_id_guild_configs` `discord_id_guild_configs` BIGINT(18) NOT NULL;

-- Move discord_id_guild_configs length from 255 to 18 + BIG INT
ALTER TABLE `configs` CHANGE `discord_notif_channel_configs` `discord_notif_channel_configs` BIGINT(18) NOT NULL;

-- --------------------------
-- CONFIGS: seed
-- --------------------------

INSERT INTO `configs`
    (`discord_token_configs`, `discord_id_guild_configs`, `discord_notif_channel_configs`, `ticket_limit_configs`, `img_limit_configs`, `report_limit_configs`, `size_screen_configs`)
    VALUES ('NzIwNzMzOTQ0NDMzMjEzNDcx.XuMdzw.oGdcO9p9x3C40QlaxIIwmzXF5ZE', '688798708523073623', '688798709181448223', '3', '3', '0', '1024');

-- --------------------------
-- PRIORITIES (FK): update
-- --------------------------

ALTER TABLE `tickets` CHANGE `id_prioritys` `id_priorities` INT(11) NOT NULL;
ALTER TABLE `tickets` DROP INDEX `tickets_prioritys0_FK`, ADD INDEX `tickets_priorities0_FK` (`id_priorities`) USING BTREE;

-- --------------------------
-- SCREENS: update
-- --------------------------
-- Change name_screens length from 10 to 40
ALTER TABLE `screens` CHANGE `name_screens` `name_screens` VARCHAR(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

-- --------------------------
-- SESSIONS: update
-- --------------------------
-- Edit current `date_session` to `start_at_sessions`
-- Add end column for sessions

ALTER TABLE `sessions` CHANGE `date_sessions` `start_at_sessions` DATE NULL DEFAULT NULL;
ALTER TABLE `sessions` ADD `end_at_sessions` DATE NULL AFTER `start_at_sessions`;

-- --------------------------
-- USERS: update
-- --------------------------
-- Update key_reset_users length from 10 to 13
ALTER TABLE `users` CHANGE `key_reset_users` `key_reset_users` VARCHAR(13) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

-- Add comments for users
ALTER TABLE `users` CHANGE `active_users` `active_users` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '(0=deleted) - (1=actived) - (2=pending) - (3=banned)';

-- --------------------------
-- TICKETS: update
-- --------------------------
ALTER TABLE `tickets` CHANGE `active_tickets` `active_tickets` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '(0=deleted) - (1=actived) - (2=reported)';

-- --------------------------
-- USERS: update > TRIGGER
-- --------------------------
DELIMITER |
CREATE TRIGGER `before_update_report_ticket` BEFORE UPDATE ON `tickets`
    FOR EACH ROW BEGIN
    IF (new.count_report_tickets > (SELECT report_limit_configs FROM configs)) THEN 
    SET new.active_tickets = 2;
    END 
    IF;
END |
DELIMITER ;

-- --------------------------
-- USERS: update
-- --------------------------
ALTER TABLE users__sessions ADD UNIQUE (id_users);

-- --------------------------
-- USERS: update > TRIGGER
-- --------------------------
DELIMITER |
    CREATE TRIGGER `before_update_delete_ticket` BEFORE UPDATE ON `tickets`
    FOR EACH ROW BEGIN
        IF ( new.active_tickets = 0 ) THEN 
        DELETE FROM users__tickets WHERE id_tickets = new.id_tickets ;
        END 
        IF;
    END
    |

    CREATE TRIGGER `before_update_users` BEFORE UPDATE ON `users`
    FOR EACH ROW BEGIN
        IF (new.active_users = 0) THEN 
            SET @SELECT_WHERE_id_AND_owner = (SELECT id_tickets FROM users__tickets WHERE id_users = new.id_users    AND status_users__tickets ="owner");
        UPDATE tickets
        set active_tickets = 0
        WHERE id_tickets IN (@SELECT_WHERE_id_AND_owner);

        END IF ;
    END
    |
DELIMITER ;

-- --------------------------
-- CONFIGS: update
-- --------------------------

-- Expend screenshot maximum size if not
UPDATE `configs` SET `size_screen_configs` = 4000000 WHERE `size_screen_configs` = 1024;

-- Add comment on "size_screen_configs"
ALTER TABLE `configs` CHANGE `size_screen_configs` `size_screen_configs` INT(11) NOT NULL COMMENT 'Maximum size for one screenshot. Size is in octect. So 4Mo = 4000000 octets for this field.';
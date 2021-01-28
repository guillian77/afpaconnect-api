-- MySQL dump 10.17  Distrib 10.3.23-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: afpaticket
-- ------------------------------------------------------
-- Server version	10.3.23-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configs` (
  `discord_token_configs` varchar(255) NOT NULL,
  `discord_id_guild_configs` bigint(18) NOT NULL,
  `discord_notif_channel_configs` bigint(18) NOT NULL,
  `ticket_limit_configs` int(11) NOT NULL,
  `img_limit_configs` int(11) NOT NULL,
  `report_limit_configs` int(11) NOT NULL,
  `size_screen_configs` int(11) NOT NULL COMMENT 'Maximum size for one screenshot. Size is in octect. So 4Mo = 4000000 octets for this field.',
  UNIQUE KEY `discord_token_configs` (`discord_token_configs`),
  UNIQUE KEY `discord_id_guild_configs` (`discord_id_guild_configs`),
  UNIQUE KEY `discord_notif_channel_configs` (`discord_notif_channel_configs`),
  UNIQUE KEY `ticket_limit_configs` (`ticket_limit_configs`),
  UNIQUE KEY `img_limit_configs` (`img_limit_configs`),
  UNIQUE KEY `report_limit_configs` (`report_limit_configs`),
  UNIQUE KEY `size_screen_configs` (`size_screen_configs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configs`
--

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
INSERT INTO `configs` VALUES ('NzIwNzMzOTQ0NDMzMjEzNDcx.XuMdzw.oGdcO9p9x3C40QlaxIIwmzXF5ZE',688798708523073623,719833787613315142,3,3,0,4000000);
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formations`
--

DROP TABLE IF EXISTS `formations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formations` (
  `id_formations` int(11) NOT NULL AUTO_INCREMENT,
  `designation_formations` varchar(50) NOT NULL,
  `active_formations` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_formations`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formations`
--

LOCK TABLES `formations` WRITE;
/*!40000 ALTER TABLE `formations` DISABLE KEYS */;
INSERT INTO `formations` VALUES (1,'DWWM - Développeur web et web mobile',1),(2,'CDA - Concepteur développeur d\'application',1),(3,'Java/Python',1);
/*!40000 ALTER TABLE `formations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `priorities`
--

DROP TABLE IF EXISTS `priorities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `priorities` (
  `id_priorities` int(11) NOT NULL AUTO_INCREMENT,
  `designation_priorities` varchar(8) CHARACTER SET latin1 NOT NULL,
  `interval_priorities` time NOT NULL,
  `active_priorities` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_priorities`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `priorities`
--

LOCK TABLES `priorities` WRITE;
/*!40000 ALTER TABLE `priorities` DISABLE KEYS */;
INSERT INTO `priorities` VALUES (1,'mineur','00:45:00',1),(2,'majeur','00:25:00',1),(3,'bloquant','00:15:00',1);
/*!40000 ALTER TABLE `priorities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `screens`
--

DROP TABLE IF EXISTS `screens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `screens` (
  `id_screens` int(11) NOT NULL AUTO_INCREMENT,
  `name_screens` varchar(40) CHARACTER SET latin1 NOT NULL,
  `id_tickets` int(11) NOT NULL,
  PRIMARY KEY (`id_screens`),
  KEY `screens_tickets_FK` (`id_tickets`),
  CONSTRAINT `screens_tickets_FK` FOREIGN KEY (`id_tickets`) REFERENCES `tickets` (`id_tickets`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `screens`
--

LOCK TABLES `screens` WRITE;
/*!40000 ALTER TABLE `screens` DISABLE KEYS */;
INSERT INTO `screens` VALUES (1,'032020100707342116020560626.jpg',6);
/*!40000 ALTER TABLE `screens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id_sessions` int(11) NOT NULL AUTO_INCREMENT,
  `start_at_sessions` date DEFAULT NULL,
  `end_at_sessions` date DEFAULT NULL,
  `active_sessions` tinyint(1) NOT NULL DEFAULT 1,
  `id_formations` int(11) NOT NULL,
  PRIMARY KEY (`id_sessions`),
  KEY `sessions_formations_FK` (`id_formations`),
  CONSTRAINT `sessions_formations_FK` FOREIGN KEY (`id_formations`) REFERENCES `formations` (`id_formations`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (1,'2020-04-06','2021-01-22',1,1),(2,'2020-04-06','2021-02-06',1,2),(3,'2020-01-06','2020-10-16',1,2),(4,'2020-01-06','2020-10-23',1,2),(5,'2020-08-24','2020-12-24',1,3);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id_tickets` int(11) NOT NULL AUTO_INCREMENT,
  `created_at_tickets` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at_tickets` datetime DEFAULT NULL,
  `subject_tickets` varchar(100) CHARACTER SET latin1 NOT NULL,
  `description_tickets` varchar(600) NOT NULL,
  `resolved_tickets` tinyint(1) DEFAULT 0,
  `count_report_tickets` tinyint(4) NOT NULL DEFAULT 0,
  `reported_tickets` tinyint(1) NOT NULL DEFAULT 0,
  `active_tickets` tinyint(1) NOT NULL DEFAULT 1 COMMENT '(0=deleted) - (1=actived) - (2=reported)',
  `id_topics` int(11) NOT NULL,
  `id_priorities` int(11) NOT NULL,
  PRIMARY KEY (`id_tickets`),
  KEY `tickets_topics_FK` (`id_topics`),
  KEY `tickets_priorities0_FK` (`id_priorities`) USING BTREE,
  CONSTRAINT `tickets_prioritys0_FK` FOREIGN KEY (`id_priorities`) REFERENCES `priorities` (`id_priorities`),
  CONSTRAINT `tickets_topics_FK` FOREIGN KEY (`id_topics`) REFERENCES `topics` (`id_topics`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'2020-10-07 07:17:56',NULL,'Guillian','Guillian',0,0,0,0,1,1),(2,'2020-10-07 07:18:47',NULL,'Guillian','Guillian',0,0,0,0,1,1),(3,'2020-10-07 07:20:47',NULL,'Je pète le front pour tester la sécurité','Je pète le front pour tester la sécurité',0,0,0,0,2,3),(4,'2020-10-07 07:24:09',NULL,'Nombre ','Nombre ',0,0,0,0,1,1),(5,'2020-10-07 07:28:38',NULL,'Guillian','Guillian',0,0,0,0,1,1),(6,'2020-10-07 07:34:21',NULL,'Guillian','Guillian',0,0,0,0,1,1);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`afpaticket`@`%`*/ /*!50003 TRIGGER `before_update_report_ticket` BEFORE UPDATE ON `tickets`
    FOR EACH ROW BEGIN
    IF (new.count_report_tickets > (SELECT report_limit_configs FROM configs)) THEN 
    SET new.active_tickets = 2;
    END 
    IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`afpaticket`@`%`*/ /*!50003 TRIGGER `before_update_delete_ticket` BEFORE UPDATE ON `tickets`
    FOR EACH ROW BEGIN
        IF ( new.active_tickets = 0 ) THEN 
        DELETE FROM users__tickets WHERE id_tickets = new.id_tickets ;
        END 
        IF;
    END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `id_topics` int(11) NOT NULL AUTO_INCREMENT,
  `designation_topics` varchar(30) NOT NULL,
  `active_topics` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_topics`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (1,'PHP',1),(2,'Javascript',1),(3,'HTML',1),(4,'CSS',1),(5,'Bootstrap',1),(6,'POO PHP',1),(7,'Laravel',1),(8,'Symphony',1),(9,'VueJs',0),(10,'React',0);
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_users` int(11) NOT NULL AUTO_INCREMENT,
  `firstname_users` varchar(50) NOT NULL,
  `lastname_users` varchar(50) NOT NULL,
  `email_users` varchar(100) NOT NULL,
  `password_users` varchar(128) CHARACTER SET latin1 NOT NULL,
  `rank_users` tinyint(1) NOT NULL COMMENT 'True: admin, False: user',
  `key_reset_users` varchar(13) CHARACTER SET latin1 DEFAULT NULL,
  `birthdate_users` date NOT NULL,
  `discord_id_users` varchar(40) NOT NULL,
  `created_at_users` date NOT NULL,
  `updated_at_users` date DEFAULT NULL,
  `active_users` tinyint(1) NOT NULL DEFAULT 1 COMMENT '(0=deleted) - (1=actived) - (2=pending) - (3=banned)',
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jean Jacques','Pagan','jean-jacques.pagan@afpa.fr','$argon2i$v=19$m=65536,t=4,p=1$OGhqaW5nYUM2RUw3Q2ZBSg$cPdpp31KU163UosvmMaheKMrwFmSjlfwxEHTiMrTrmY',1,'','1995-09-01','jijou#6855','2020-08-27',NULL,1),(3,'Guillian','Aufrère','guillian77270@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$RGZGdGJSaUVQRnQ2MFNYNg$CyTwLs3P9kjozktjP6v+dgK7Z5sq5WVLnfgMg7+xRN8',0,'','1995-09-01','Dekadmin#5545','2020-09-30',NULL,1),(4,'Damien','Grember','dgrember@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$VlBnUzgzYzZ2N3Z3dldFUQ$X/LlUOvfrW8DOEi4DhlPjQQoasxa85exvaY3CNpWcRg',0,'','1989-06-25','damien34#3100','2020-09-30',NULL,1),(5,'Grégory','Soupé','McGregor777@hotmail.fr','$argon2i$v=19$m=65536,t=4,p=1$SzNWWmpuTnlia09WcWszcg$TsbeAYo6R5pAKy2xJzFGgyptSLx0sFZQNlgxkG832r4',0,'','1995-02-28','McGregor777#9498','2020-09-30',NULL,1),(6,'Raphaël','Causse','causse.raphael@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$VTRwLlM4WXY0bHpGekp6YQ$wBjpyU/xIpaay31yTPQZcXtq1IlcVjqlE/zgW7ygNgY',0,'','1987-02-05','Rapha#3962','2020-09-30',NULL,1),(7,'Younes','Melheb','melheb.younes@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$SVJKWTlFSDZZY0NobTFObA$+Ll4RLDyM1i1sV8/3IeeS5gxgtOXEkuNQAsGhgTdF4E',0,'','1992-10-26','Younes#7978','2020-09-30',NULL,1),(8,'Aurelien','Bernal','scriptair01@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$bzZMMlVXSE1zanVyRHlaNQ$Ba5hmjFpDycKruPaljP3vtuISZmCo+dQkkwTqc1SvjA',0,'','1985-10-08','Aurelien#8488','2020-09-30',NULL,1),(9,'Sissi','Linxe','sylvie.linxe@live.fr','$argon2i$v=19$m=65536,t=4,p=1$VlM0eWk2NnRiZ1lRVEpoZw$ACIcTlTcf/P7hyOm8bJ5hxLR1op7j+AK+axonBsiBEA',0,'','1967-10-18','SylvieLinxe#2521','2020-09-30',NULL,1),(10,'Lucas','Campillo','lucas.campillo@hotmail.fr','$argon2i$v=19$m=65536,t=4,p=1$WnovS05nS1hLL2RLTzZCMQ$SDmQik9yFyoTXCB+5kH39Ja0nRvUgHHDSaqVlsT3XhI',0,'','1999-04-11','Lucas Campillo#2935','2020-09-30',NULL,1),(11,'Mélanie','Philippon','contact@pm-c.fr','$argon2i$v=19$m=65536,t=4,p=1$Ri5Pa0drQ2dZNG1YbVBqMw$6BHrC+l2IwHeUigQ8KU8g1dDb1PDizanGPtbiOz6pag',0,'','1986-09-05','Lorinthal#9598','2020-09-30',NULL,1),(12,'Jean-Patrick','Marchandeau','jeanpatrickmarchandeau@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$RGNyN1FRR2xkY2ROQ2poSw$6+LVtLYJPosgKp4hkRezdkUi+e9llQDLjEn84KIEPEE',0,'','1984-10-07','JPM#3315','2020-10-01',NULL,1),(13,'damien','Lhaurado','damienlhaurado@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$eE8wcWVXL0VCRlZXakFpWg$AQpgMC5JlHQiPzMwI+9UATmQ917w2o2+EprYpHX8gBo',0,'','1993-01-01','damien#8004','2020-10-01',NULL,1),(14,'Benjamin','Roma Sacconney','boublou34300@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$eDZ3MGR3T3BLU3VwL3ozOQ$RKr+y/xFpDQerWtg5BuxvG3ZiKbwOqfV8LGc6Yinjww',0,'','1992-05-20','jo0kker#6660','2020-10-01',NULL,1),(15,'damien','lhaurado','damienlhaurado@hotmail.com','$argon2i$v=19$m=65536,t=4,p=1$Vm5DL0k1ODdiSXIzcm40bw$ezQhXbN6vTNIqfH1MFwYDPGwdfYqrRWwwXKIwMK4Oj4',0,'','1993-01-01','damien#8004','2020-10-02',NULL,0),(16,'Ludovic','Mouly','ludom82@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$Mm5GQXB4QUdyTUpSTlVQaQ$EVQIP+lItxlSUxLnF/aSS0lf8Re8AtH91OfnQRFzKRs',0,'','1982-07-09','LudovicMouly#0720','2020-10-06',NULL,1),(17,'Thomas','Gonzalez','tomas.gonzalez.vega@gmail.com','$argon2i$v=19$m=65536,t=4,p=1$UTVpSi5ydGgzdS8zM3FNcQ$HzgVRWda4eSdL1D6oWciYptrywf1JpCC/M35sTToaCY',1,'','1992-06-15','TwiKey#0035','2020-10-07',NULL,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`afpaticket`@`%`*/ /*!50003 TRIGGER `before_update_users` BEFORE UPDATE ON `users`
    FOR EACH ROW BEGIN
        IF (new.active_users = 0) THEN 
            SET @SELECT_WHERE_id_AND_owner = (SELECT id_tickets FROM users__tickets WHERE id_users = new.id_users    AND status_users__tickets ="owner");
        UPDATE tickets
        set active_tickets = 0
        WHERE id_tickets IN (@SELECT_WHERE_id_AND_owner);

        END IF ;
    END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `users__sessions`
--

DROP TABLE IF EXISTS `users__sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users__sessions` (
  `id_sessions` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  PRIMARY KEY (`id_sessions`,`id_users`),
  UNIQUE KEY `id_users` (`id_users`),
  CONSTRAINT `users__sessions_sessions_FK` FOREIGN KEY (`id_sessions`) REFERENCES `sessions` (`id_sessions`),
  CONSTRAINT `users__sessions_users0_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users__sessions`
--

LOCK TABLES `users__sessions` WRITE;
/*!40000 ALTER TABLE `users__sessions` DISABLE KEYS */;
INSERT INTO `users__sessions` VALUES (1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,13),(1,14),(2,12),(5,16);
/*!40000 ALTER TABLE `users__sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users__tickets`
--

DROP TABLE IF EXISTS `users__tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users__tickets` (
  `id_tickets` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `status_users__tickets` varchar(10) NOT NULL,
  `date_report` date DEFAULT NULL,
  `reason_report` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tickets`,`id_users`),
  KEY `users__tickets_users0_FK` (`id_users`),
  CONSTRAINT `users__tickets_tickets_FK` FOREIGN KEY (`id_tickets`) REFERENCES `tickets` (`id_tickets`),
  CONSTRAINT `users__tickets_users0_FK` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users__tickets`
--

LOCK TABLES `users__tickets` WRITE;
/*!40000 ALTER TABLE `users__tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `users__tickets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-07 14:57:11

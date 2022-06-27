-- MariaDB dump 10.19  Distrib 10.4.22-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: bk
-- ------------------------------------------------------
-- Server version	10.4.22-MariaDB

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
-- Table structure for table `account_address`
--

DROP TABLE IF EXISTS `account_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `City_city_id` int(11) DEFAULT NULL,
  `street` varchar(128) DEFAULT NULL,
  `district` varchar(64) DEFAULT NULL,
  `postal_code` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`address_id`),
  KEY `Address_City` (`City_city_id`),
  CONSTRAINT `Address_City` FOREIGN KEY (`City_city_id`) REFERENCES `city` (`city_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_address`
--

LOCK TABLES `account_address` WRITE;
/*!40000 ALTER TABLE `account_address` DISABLE KEYS */;
INSERT INTO `account_address` VALUES (1,1,'Grunwaldzka 15','Pomorze','83-000'),(2,NULL,NULL,NULL,NULL),(3,NULL,NULL,NULL,NULL),(4,NULL,NULL,NULL,NULL),(5,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `account_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_permissions`
--

DROP TABLE IF EXISTS `account_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_permissions` (
  `Permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_panel` tinyint(1) NOT NULL,
  `add_bet` tinyint(1) NOT NULL,
  `add_game` tinyint(1) NOT NULL,
  `add_sport` tinyint(1) NOT NULL,
  `add_team` tinyint(1) NOT NULL,
  `add_money` tinyint(1) NOT NULL,
  `set_winner` tinyint(1) NOT NULL,
  `send_mail` tinyint(1) NOT NULL,
  PRIMARY KEY (`Permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_permissions`
--

LOCK TABLES `account_permissions` WRITE;
/*!40000 ALTER TABLE `account_permissions` DISABLE KEYS */;
INSERT INTO `account_permissions` VALUES (1,1,1,1,1,1,1,1,1),(2,0,0,0,0,0,0,0,0),(3,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `account_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_profile`
--

DROP TABLE IF EXISTS `account_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_profile` (
  `Profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `register_date` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `surname` varchar(64) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `avatar_path` varchar(256) DEFAULT NULL,
  `Address_address_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Profile_id`),
  KEY `Profiles_Address` (`Address_address_id`),
  CONSTRAINT `Profiles_Address` FOREIGN KEY (`Address_address_id`) REFERENCES `account_address` (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_profile`
--

LOCK TABLES `account_profile` WRITE;
/*!40000 ALTER TABLE `account_profile` DISABLE KEYS */;
INSERT INTO `account_profile` VALUES (1,'2022-06-12 19:46:50',NULL,'Jan','Kreft',2305.99,NULL,1),(2,'2022-06-12 20:52:53',NULL,NULL,NULL,100.01,NULL,2),(3,'2022-06-14 10:28:34',NULL,NULL,NULL,60.00,NULL,3),(4,'2022-06-14 10:44:57',NULL,NULL,NULL,28500.00,NULL,4),(5,'2022-06-27 00:26:56',NULL,NULL,NULL,50375.00,NULL,5);
/*!40000 ALTER TABLE `account_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `account_register`
--

DROP TABLE IF EXISTS `account_register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_register` (
  `Register_id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(256) NOT NULL,
  `create_date` datetime NOT NULL,
  `expire_date` datetime NOT NULL,
  PRIMARY KEY (`Register_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_register`
--

LOCK TABLES `account_register` WRITE;
/*!40000 ALTER TABLE `account_register` DISABLE KEYS */;
INSERT INTO `account_register` VALUES (1,'0891a0534e9bf9ff4fdab16549c60b23121d86b7d2b40a72b234e10ca942ec2a','2022-06-12 19:46:48','2022-06-13 01:46:48'),(2,'595f5dd6eec2fac1fbde998fbd21b2accfcca20aef4d28279a9884c850a629b8','2022-06-12 20:52:52','2022-06-13 02:52:52'),(3,'cb05005111ad12e88abb6f76ee25b2694a28e1a8f8d7b558cc78d64bffd66896','2022-06-14 10:28:32','2022-06-14 16:28:32'),(4,'215ccb19d1da60f94116555c37c3e6d72583dedca3e12536b3ca036dccfa4c0b','2022-06-14 10:44:55','2022-06-14 16:44:55'),(5,'d4f7f299-f12e-11ec-9b6c-38f3ab8bfea3','2022-06-21 08:53:15','2022-06-21 14:53:15'),(6,'44e4388f-f12f-11ec-9b6c-38f3ab8bfea3','2022-06-21 08:56:23','2022-06-21 14:56:23'),(7,'9661260e-f140-11ec-9b6c-38f3ab8bfea3','2022-06-21 11:00:21','2022-06-21 17:00:21'),(8,'5674b057a9982f4fba0c6b58bb8146a4f920aaed0d8003401498d09463018109','2022-06-27 00:26:54','2022-06-27 06:26:54'),(9,'8f1dc5b5f6b068bba9b0b9482040068addcb06a41947e21e59c79497b006f825','2022-06-27 10:41:08','2022-06-27 16:41:08');
/*!40000 ALTER TABLE `account_register` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Profiles_Profile_id` int(11) DEFAULT NULL,
  `Register_Register_id` int(11) DEFAULT NULL,
  `Permissions_Permission_id` int(11) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `login` varchar(64) NOT NULL,
  `email` varchar(320) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `Accounts_Permissions` (`Permissions_Permission_id`),
  KEY `Accounts_Profiles` (`Profiles_Profile_id`),
  KEY `Accounts_Register` (`Register_Register_id`),
  CONSTRAINT `Accounts_Permissions` FOREIGN KEY (`Permissions_Permission_id`) REFERENCES `account_permissions` (`Permission_id`),
  CONSTRAINT `Accounts_Profiles` FOREIGN KEY (`Profiles_Profile_id`) REFERENCES `account_profile` (`Profile_id`),
  CONSTRAINT `Accounts_Register` FOREIGN KEY (`Register_Register_id`) REFERENCES `account_register` (`Register_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,1,1,1,'$argon2id$v=19$m=65536,t=4,p=1$WGJMa0M4bHdjbU5RR0FiSg$US9i7MqB9nl+MRlwwQDriuUXJFOUF90cmpGucJhiXfg','jankreft','jankreft10@gmail.com',1),(2,2,2,NULL,'$argon2id$v=19$m=65536,t=4,p=1$OE1LckJRaHVCTGwzTThOUg$50lyDa7EVDFukneaGh1L9rwoThkYRmfR4chRWjyHCYI','adamnowak','adam.nowak@wp.pl',1),(3,3,3,NULL,'$argon2id$v=19$m=65536,t=4,p=1$WEJHc0Y1S2ZaaGVuZk03eg$LQdPOtnR3nlZBdHRFFObZOd8i76jnkMzPUTxL1hiFTU','jankowalski','jankowalski@wp.pl',1),(4,4,4,NULL,'$argon2id$v=19$m=65536,t=4,p=1$U21ENTg0VTl0ZXpsaWRzdg$hBlkI4JLRucb4ofjHJTQxIevkjxXFUxUOeKhEZN6rPc','adamkowalski','adamkowalski@gmail.com',1),(5,2,NULL,NULL,'uutruttrfutru','j','j',0),(6,NULL,NULL,NULL,'es','gdsgds','gfdfd',0),(7,NULL,NULL,NULL,'gdfhdfh','dfhdfhdf','hdfhdfh',0),(8,5,8,NULL,'$argon2id$v=19$m=65536,t=4,p=1$eTVZZGVmM0RuWnd6MUNDRA$Oh8qTwokRV61gE5O6pNqom/7g6oBUC/My0x04WJvpAM','pjatk','pjatk@pjatk.pl',1),(9,NULL,9,NULL,'$argon2id$v=19$m=65536,t=4,p=1$Z0UwanNHUFhlYndrT2VMUA$zYirnFZr7PGyPwQu5/Y951b1oyayVvrTnzwWfJ3UBcE','jankreft10@gmail.com','jankref10@gmail.com',0);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `aktualne_zaklady_pilka_nozna`
--

DROP TABLE IF EXISTS `aktualne_zaklady_pilka_nozna`;
/*!50001 DROP VIEW IF EXISTS `aktualne_zaklady_pilka_nozna`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `aktualne_zaklady_pilka_nozna` (
  `game_id` tinyint NOT NULL,
  `team_name` tinyint NOT NULL,
  `win_odd` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `bets`
--

DROP TABLE IF EXISTS `bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gt_id` int(11) NOT NULL,
  `bet_place_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Bets_gt_teams` (`gt_id`),
  CONSTRAINT `Bets_gt_teams` FOREIGN KEY (`gt_id`) REFERENCES `game_teams` (`Gt_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bets`
--

LOCK TABLES `bets` WRITE;
/*!40000 ALTER TABLE `bets` DISABLE KEYS */;
INSERT INTO `bets` VALUES (1,1,'2022-06-14 10:41:18'),(2,6,'2022-06-14 10:55:56'),(3,5,'2022-06-14 10:55:56'),(4,9,'2022-06-14 10:58:07'),(5,10,'2022-06-14 10:58:07'),(17,1,'2022-06-19 17:26:22'),(18,5,'2022-06-19 18:02:42'),(19,1,'2022-06-19 19:03:00'),(20,3,'2022-06-22 14:40:52'),(21,16,'2022-06-27 00:33:49');
/*!40000 ALTER TABLE `bets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(64) DEFAULT NULL,
  `Country_country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `City_Country` (`Country_country_id`),
  CONSTRAINT `City_Country` FOREIGN KEY (`Country_country_id`) REFERENCES `country` (`country_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` VALUES (1,'Gdańsk',179);
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(60) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'Afghanistan'),(2,'Aland Islands'),(3,'Albania'),(4,'Algeria'),(5,'American Samoa'),(6,'Andorra'),(7,'Angola'),(8,'Anguilla'),(9,'Antarctica'),(10,'Antigua and Barbuda'),(11,'Argentina'),(12,'Armenia'),(13,'Aruba'),(14,'Australia'),(15,'Austria'),(16,'Azerbaijan'),(17,'Bahamas'),(18,'Bahrain'),(19,'Bangladesh'),(20,'Barbados'),(21,'Belarus'),(22,'Belgium'),(23,'Belize'),(24,'Benin'),(25,'Bermuda'),(26,'Bhutan'),(27,'Bolivia'),(28,'Bonaire, Sint Eustatius and Saba'),(29,'Bosnia and Herzegovina'),(30,'Botswana'),(31,'Bouvet Island'),(32,'Brazil'),(33,'British Indian Ocean Territory'),(34,'Brunei Darussalam'),(35,'Bulgaria'),(36,'Burkina Faso'),(37,'Burundi'),(38,'Cambodia'),(39,'Cameroon'),(40,'Canada'),(41,'Cape Verde'),(42,'Cayman Islands'),(43,'Central African Republic'),(44,'Chad'),(45,'Chile'),(46,'China'),(47,'Christmas Island'),(48,'Cocos (Keeling) Islands'),(49,'Colombia'),(50,'Comoros'),(51,'Congo'),(52,'Congo, Democratic Republic of the Congo'),(53,'Cook Islands'),(54,'Costa Rica'),(55,'Cote D\'Ivoire'),(56,'Croatia'),(57,'Cuba'),(58,'Curacao'),(59,'Cyprus'),(60,'Czech Republic'),(61,'Denmark'),(62,'Djibouti'),(63,'Dominica'),(64,'Dominican Republic'),(65,'Ecuador'),(66,'Egypt'),(67,'El Salvador'),(68,'Equatorial Guinea'),(69,'Eritrea'),(70,'Estonia'),(71,'Ethiopia'),(72,'Falkland Islands (Malvinas)'),(73,'Faroe Islands'),(74,'Fiji'),(75,'Finland'),(76,'France'),(77,'French Guiana'),(78,'French Polynesia'),(79,'French Southern Territories'),(80,'Gabon'),(81,'Gambia'),(82,'Georgia'),(83,'Germany'),(84,'Ghana'),(85,'Gibraltar'),(86,'Greece'),(87,'Greenland'),(88,'Grenada'),(89,'Guadeloupe'),(90,'Guam'),(91,'Guatemala'),(92,'Guernsey'),(93,'Guinea'),(94,'Guinea-Bissau'),(95,'Guyana'),(96,'Haiti'),(97,'Heard Island and Mcdonald Islands'),(98,'Holy See (Vatican City State)'),(99,'Honduras'),(100,'Hong Kong'),(101,'Hungary'),(102,'Iceland'),(103,'India'),(104,'Indonesia'),(105,'Iran, Islamic Republic of'),(106,'Iraq'),(107,'Ireland'),(108,'Isle of Man'),(109,'Israel'),(110,'Italy'),(111,'Jamaica'),(112,'Japan'),(113,'Jersey'),(114,'Jordan'),(115,'Kazakhstan'),(116,'Kenya'),(117,'Kiribati'),(118,'Korea, Democratic People\'s Republic of'),(119,'Korea, Republic of'),(120,'Kosovo'),(121,'Kuwait'),(122,'Kyrgyzstan'),(123,'Lao People\'s Democratic Republic'),(124,'Latvia'),(125,'Lebanon'),(126,'Lesotho'),(127,'Liberia'),(128,'Libyan Arab Jamahiriya'),(129,'Liechtenstein'),(130,'Lithuania'),(131,'Luxembourg'),(132,'Macao'),(133,'Macedonia, the Former Yugoslav Republic of'),(134,'Madagascar'),(135,'Malawi'),(136,'Malaysia'),(137,'Maldives'),(138,'Mali'),(139,'Malta'),(140,'Marshall Islands'),(141,'Martinique'),(142,'Mauritania'),(143,'Mauritius'),(144,'Mayotte'),(145,'Mexico'),(146,'Micronesia, Federated States of'),(147,'Moldova, Republic of'),(148,'Monaco'),(149,'Mongolia'),(150,'Montenegro'),(151,'Montserrat'),(152,'Morocco'),(153,'Mozambique'),(154,'Myanmar'),(155,'Namibia'),(156,'Nauru'),(157,'Nepal'),(158,'Netherlands'),(159,'Netherlands Antilles'),(160,'New Caledonia'),(161,'New Zealand'),(162,'Nicaragua'),(163,'Niger'),(164,'Nigeria'),(165,'Niue'),(166,'Norfolk Island'),(167,'Northern Mariana Islands'),(168,'Norway'),(169,'Oman'),(170,'Pakistan'),(171,'Palau'),(172,'Palestinian Territory, Occupied'),(173,'Panama'),(174,'Papua New Guinea'),(175,'Paraguay'),(176,'Peru'),(177,'Philippines'),(178,'Pitcairn'),(179,'Poland'),(180,'Portugal'),(181,'Puerto Rico'),(182,'Qatar'),(183,'Reunion'),(184,'Romania'),(185,'Russian Federation'),(186,'Rwanda'),(187,'Saint Barthelemy'),(188,'Saint Helena'),(189,'Saint Kitts and Nevis'),(190,'Saint Lucia'),(191,'Saint Martin'),(192,'Saint Pierre and Miquelon'),(193,'Saint Vincent and the Grenadines'),(194,'Samoa'),(195,'San Marino'),(196,'Sao Tome and Principe'),(197,'Saudi Arabia'),(198,'Senegal'),(199,'Serbia'),(200,'Serbia and Montenegro'),(201,'Seychelles'),(202,'Sierra Leone'),(203,'Singapore'),(204,'Sint Maarten'),(205,'Slovakia'),(206,'Slovenia'),(207,'Solomon Islands'),(208,'Somalia'),(209,'South Africa'),(210,'South Georgia and the South Sandwich Islands'),(211,'South Sudan'),(212,'Spain'),(213,'Sri Lanka'),(214,'Sudan'),(215,'Suriname'),(216,'Svalbard and Jan Mayen'),(217,'Swaziland'),(218,'Sweden'),(219,'Switzerland'),(220,'Syrian Arab Republic'),(221,'Taiwan, Province of China'),(222,'Tajikistan'),(223,'Tanzania, United Republic of'),(224,'Thailand'),(225,'Timor-Leste'),(226,'Togo'),(227,'Tokelau'),(228,'Tonga'),(229,'Trinidad and Tobago'),(230,'Tunisia'),(231,'Turkey'),(232,'Turkmenistan'),(233,'Turks and Caicos Islands'),(234,'Tuvalu'),(235,'Uganda'),(236,'Ukraine'),(237,'United Arab Emirates'),(238,'United Kingdom'),(239,'United States'),(240,'United States Minor Outlying Islands'),(241,'Uruguay'),(242,'Uzbekistan'),(243,'Vanuatu'),(244,'Venezuela'),(245,'Viet Nam'),(246,'Virgin Islands, British'),(247,'Virgin Islands, U.s.'),(248,'Wallis and Futuna'),(249,'Western Sahara'),(250,'Yemen'),(251,'Zambia'),(252,'Zimbabwe');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_teams`
--

DROP TABLE IF EXISTS `game_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_teams` (
  `Gt_id` int(11) NOT NULL AUTO_INCREMENT,
  `Games_game_id` int(11) NOT NULL,
  `Teams_id` int(11) DEFAULT NULL,
  `odd` decimal(10,2) NOT NULL,
  `game_result` varchar(250) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Gt_id`),
  KEY `game_teams_Games` (`Games_game_id`),
  KEY `game_teams_Teams` (`Teams_id`),
  CONSTRAINT `game_teams_Games` FOREIGN KEY (`Games_game_id`) REFERENCES `games` (`game_id`),
  CONSTRAINT `game_teams_Teams` FOREIGN KEY (`Teams_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_teams`
--

LOCK TABLES `game_teams` WRITE;
/*!40000 ALTER TABLE `game_teams` DISABLE KEYS */;
INSERT INTO `game_teams` VALUES (1,1,7,2.50,'win',0),(2,1,9,1.30,'win',1),(3,1,NULL,1.78,'remis',0),(4,6,18,2.00,'win',1),(5,6,22,1.50,'win',0),(6,6,NULL,1.80,'remis',0),(7,2,60,1.30,'win',0),(8,2,63,2.80,'win',1),(9,7,28,5.00,'win',NULL),(10,7,21,3.10,'win',NULL),(11,7,NULL,1.50,'remis',NULL),(12,8,23,3.50,'win',NULL),(13,8,19,1.80,'win',NULL),(14,9,56,10.00,'win',NULL),(15,9,51,1.26,'win',NULL),(16,11,19,1.75,'win',1),(17,11,24,3.50,'win',NULL),(18,17,50,2.00,'win',NULL),(19,17,55,1.70,'win',NULL),(20,19,35,1.32,'win',NULL),(21,19,37,3.12,'win',NULL);
/*!40000 ALTER TABLE `game_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_datetime` datetime NOT NULL,
  `start_bet` datetime NOT NULL,
  `end_bet` datetime NOT NULL,
  `added_by_account_id` int(11) NOT NULL,
  PRIMARY KEY (`game_id`),
  KEY `Games_Accounts` (`added_by_account_id`),
  CONSTRAINT `Games_Accounts` FOREIGN KEY (`added_by_account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'2022-06-30 10:27:00','2022-06-14 10:26:59','2022-06-26 10:27:00',1),(2,'2022-06-17 10:32:32','2022-06-15 10:32:32','2022-06-16 10:32:32',1),(6,'2022-06-25 10:32:57','2022-06-16 10:32:57','2022-06-23 10:32:57',1),(7,'2022-06-14 10:32:57','2022-06-14 10:32:57','2022-06-14 10:32:57',1),(8,'2022-06-22 18:50:52','2022-06-17 18:50:52','2022-06-20 18:50:52',1),(9,'2022-06-30 19:15:01','2022-06-17 19:15:01','2022-06-30 19:15:01',1),(10,'2022-06-19 23:50:30','2022-06-19 17:50:34','2022-06-19 20:50:35',1),(11,'2022-07-01 10:00:00','2022-06-19 10:00:00','2022-06-30 23:50:50',1),(12,'2022-06-28 00:39:59','2022-06-27 00:40:03','2022-06-27 20:30:00',1),(13,'2022-06-28 00:39:59','2022-06-27 00:40:03','2022-06-27 20:30:00',1),(14,'2022-06-28 00:39:59','2022-06-27 00:40:03','2022-06-27 20:30:00',1),(15,'2022-06-28 00:39:59','2022-06-27 00:40:03','2022-06-27 20:30:00',1),(16,'2022-06-28 00:39:59','2022-06-27 00:40:03','2022-06-27 20:30:00',1),(17,'2022-06-28 00:39:59','2022-06-27 00:40:03','2022-06-27 20:30:00',1),(18,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1),(19,'2022-06-30 12:00:00','2022-06-27 11:59:02','2022-06-30 11:30:00',1);
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sports`
--

DROP TABLE IF EXISTS `sports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `logo_path` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sports`
--

LOCK TABLES `sports` WRITE;
/*!40000 ALTER TABLE `sports` DISABLE KEYS */;
INSERT INTO `sports` VALUES (1,'Football',NULL),(2,'Basketball',NULL),(3,'Hockey',NULL),(4,'Voleyball',NULL),(5,'Tennis',NULL),(6,'Golf',NULL),(7,'Horse racing',NULL),(8,'Swimming',NULL),(9,'Rugby',NULL),(10,'Boxing',NULL),(11,'Dart',NULL);
/*!40000 ALTER TABLE `sports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sports_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `logo_path` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Teams_Sports` (`sports_id`),
  CONSTRAINT `Teams_Sports` FOREIGN KEY (`sports_id`) REFERENCES `sports` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,1,'BRUK-BET TERMALICA NIECIECZA',NULL),(2,1,'CRACOVIA',NULL),(3,1,'GÓRNIK ŁĘCZNA',NULL),(4,1,'GÓRNIK ZABRZE',NULL),(5,1,'JAGIELLONIA BIAŁYSTOK',NULL),(6,1,'KGHM ZAGŁĘBIE LUBIN',NULL),(7,1,'LECH POZNAŃ',NULL),(8,1,'LECHIA GDAŃSK',NULL),(9,1,'LEGIA WARSZAWA',NULL),(10,1,'PGE FKS STAL MIELEC',NULL),(11,1,'RADOMIAK RADOM',NULL),(12,1,'RAKÓW CZĘSTOCHOWA',NULL),(13,1,'ŚLĄSK WROCŁAW',NULL),(14,1,'WARTA POZNAŃ',NULL),(15,1,'WISŁA KRAKÓW',NULL),(16,1,'WISŁA PŁOCK',NULL),(17,2,'ANVIL WŁOCŁAWEK',NULL),(18,2,'ARGED BM STAL OSTRÓW WLKP.',NULL),(19,2,'ASSECO ARKA GDYNIA',NULL),(20,2,'ENEA ZASTAL BC ZIELONA GÓRA',NULL),(21,2,'GRUPA SIERLECCY CZARNI SŁUPSK',NULL),(22,2,'GTK GLIWICE',NULL),(23,2,'HYDROTRUCK RADOM',NULL),(24,2,'KING SZCZECIN',NULL),(25,2,'LEGIA WARSZAWA',NULL),(26,2,'MKS DĄBROWA GÓRNICZA',NULL),(27,2,'PGE SPÓJNIA STARGARD',NULL),(28,2,'POLSKI CUKIER PSZCZÓŁKA START LUBLIN',NULL),(29,2,'TREFL SOPOT',NULL),(30,2,'TWARDE PIERNIKI TORUŃ',NULL),(31,2,'WKS ŚLĄSK WROCŁAW',NULL),(32,3,'PODHALE NOWY TARG',NULL),(33,3,'CRACOVIA',NULL),(34,3,'ZAGŁĘBIE SOSNOWIEC',NULL),(35,3,'STS SANOK',NULL),(36,3,'GKS TYCHY',NULL),(37,3,'STOCZNIOWIEC GDAŃSK',NULL),(38,3,'UNIA OŚWIĘCIM',NULL),(39,3,'GKS KATOWICE',NULL),(40,3,'KS TORUŃ HSA',NULL),(41,3,'GKS JASTRZĘBIE',NULL),(42,3,'POLONIA BYTOM',NULL),(43,3,'ORLIK OPOLE',NULL),(44,4,'AZS AGH KRAKÓW',NULL),(45,4,'BBTS BIELSKO-BIAŁA',NULL),(46,4,'BKS VISŁA BYDGOSZCZ',NULL),(47,4,'EWINNER GWARDIA WROCŁAW',NULL),(48,4,'EXACT SYSTEMS NORWID CZĘSTOCHOWA',NULL),(49,4,'KKS MICKIEWICZ KLUCZBORK',NULL),(50,4,'KPS SIEDLCE',NULL),(51,4,'KRISPOL WRZEŚNIA',NULL),(52,4,'LECHIA TOMASZÓW MAZOWIECKI',NULL),(53,4,'LEGIA WARSZAWA',NULL),(54,4,'MKS BĘDZIN',NULL),(55,4,'OLIMPIA SULĘCIN',NULL),(56,4,'POLSKI CUKIER AVIA ŚWIDNIK',NULL),(57,4,'SMS PZPS SPAŁA',NULL),(58,4,'SPS CHROBRY GŁOGÓW',NULL),(59,4,'ZAKSA STRZELCE OPOLSKIE',NULL),(60,5,'DJOKOVIC NOVAK',NULL),(61,5,'MEDVEDEV DANIIL',NULL),(62,5,'ZVEREV ALEXANDER',NULL),(63,5,'NADAL RAFAEL',NULL),(64,5,'TSITSIPAS STEFANOS',NULL),(65,5,'RUUD CASPER',NULL),(66,5,'ALCARAZ CARLOS',NULL),(67,5,'RUBLEV ANDREY',NULL),(68,5,'AUGER ALIASSIME FELIX',NULL),(69,5,'BERRETTINI MATTEO',NULL),(70,5,'NORRIE CAMERON',NULL),(71,5,'SINNER JANNIK',NULL),(72,5,'HURKACZ HUBERT',NULL),(73,5,'FRITZ TAYLOR HARRY',NULL),(74,5,'SCHWARTZMAN DIEGO',NULL),(75,5,'SHAPOVALOV DENIS',NULL),(76,6,'PHIL MICKELSON',NULL),(77,6,'DUSTIN JOHSON',NULL),(78,6,'SERGIO GARCIA',NULL),(79,6,'LEE WESTWOOD',NULL),(80,6,'JUSTIN THOMAS',NULL),(81,6,'GREG NORMAN',NULL),(82,6,'SCOTTIE SCHEFFLER',NULL),(83,6,'SAM BURNS',NULL),(84,6,'IAN POULTER',NULL),(85,6,'ABRAHAM ANCER',NULL),(86,10,'TYSON FURY',NULL),(87,10,'OLEKSANDR USYK',NULL),(88,10,'ANTHONY JOSHUA',NULL),(89,10,'MARCIN NAJMAN',NULL),(90,10,'DEONTAY WILDER',NULL),(91,10,'JOSEPH PARKER',NULL),(92,10,'ANDY RUIZ',NULL),(93,10,'DERECK CHISORA',NULL),(94,10,'MICHAEL HUNTER',NULL),(95,10,'LUIS ORTIZ',NULL),(96,9,'Sharks',NULL),(97,11,'Jan Kowalski',NULL);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `Accounts_id` int(11) NOT NULL,
  `Bets_id` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `Transactions_Accounts` (`Accounts_id`),
  KEY `Transactions_Bets` (`Bets_id`),
  CONSTRAINT `Transactions_Accounts` FOREIGN KEY (`Accounts_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `Transactions_Bets` FOREIGN KEY (`Bets_id`) REFERENCES `bets` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,2,1,500.00),(2,3,2,200.00),(3,4,3,5000.00),(4,4,5,10.00),(5,1,5,35.67),(6,2,4,89.54),(7,1,17,50.00),(8,1,18,100.00),(9,1,19,0.01),(10,4,20,5.00),(11,8,21,500.00);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `winners`
--

DROP TABLE IF EXISTS `winners`;
/*!50001 DROP VIEW IF EXISTS `winners`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `winners` (
  `gt_id` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `Profiles_Profile_id` tinyint NOT NULL,
  `money` tinyint NOT NULL,
  `odd` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `zaklady_wygrane`
--

DROP TABLE IF EXISTS `zaklady_wygrane`;
/*!50001 DROP VIEW IF EXISTS `zaklady_wygrane`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `zaklady_wygrane` (
  `login` tinyint NOT NULL,
  `money` tinyint NOT NULL,
  `bet_place_date` tinyint NOT NULL,
  `Teams_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `zaklady_wygrane_2`
--

DROP TABLE IF EXISTS `zaklady_wygrane_2`;
/*!50001 DROP VIEW IF EXISTS `zaklady_wygrane_2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `zaklady_wygrane_2` (
  `id` tinyint NOT NULL,
  `login` tinyint NOT NULL,
  `money` tinyint NOT NULL,
  `bet_place_date` tinyint NOT NULL,
  `Teams_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `aktualne_zaklady_pilka_nozna`
--

/*!50001 DROP TABLE IF EXISTS `aktualne_zaklady_pilka_nozna`*/;
/*!50001 DROP VIEW IF EXISTS `aktualne_zaklady_pilka_nozna`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `aktualne_zaklady_pilka_nozna` AS select `games`.`game_id` AS `game_id`,`teams`.`name` AS `team_name`,`game_teams`.`odd` AS `win_odd` from (((`game_teams` join `games` on(`games`.`game_id` = `game_teams`.`Games_game_id`)) join `teams` on(`teams`.`id` = `game_teams`.`Teams_id`)) join `sports` on(`teams`.`sports_id` = `sports`.`id`)) where `sports`.`name` = 'Football' and `games`.`start_bet` < current_timestamp() and `games`.`end_bet` > current_timestamp() */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `winners`
--

/*!50001 DROP TABLE IF EXISTS `winners`*/;
/*!50001 DROP VIEW IF EXISTS `winners`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `winners` AS select `bets`.`gt_id` AS `gt_id`,`accounts`.`email` AS `email`,`accounts`.`Profiles_Profile_id` AS `Profiles_Profile_id`,`transactions`.`money` AS `money`,`game_teams`.`odd` AS `odd` from ((((`transactions` join `bets` on(`bets`.`id` = `transactions`.`Bets_id`)) join `game_teams` on(`bets`.`gt_id` = `game_teams`.`Gt_id`)) join `accounts` on(`accounts`.`id` = `transactions`.`Accounts_id`)) join `account_profile` on(`account_profile`.`Profile_id` = `accounts`.`Profiles_Profile_id`)) where `game_teams`.`status` is not null and `game_teams`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `zaklady_wygrane`
--

/*!50001 DROP TABLE IF EXISTS `zaklady_wygrane`*/;
/*!50001 DROP VIEW IF EXISTS `zaklady_wygrane`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `zaklady_wygrane` AS select `accounts`.`login` AS `login`,`transactions`.`money` AS `money`,`bets`.`bet_place_date` AS `bet_place_date`,`game_teams`.`Teams_id` AS `Teams_id` from (((`accounts` join `transactions` on(`transactions`.`Accounts_id` = `accounts`.`id`)) join `bets` on(`bets`.`id` = `transactions`.`Bets_id`)) join `game_teams` on(`game_teams`.`Gt_id` = `bets`.`gt_id`)) where `game_teams`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `zaklady_wygrane_2`
--

/*!50001 DROP TABLE IF EXISTS `zaklady_wygrane_2`*/;
/*!50001 DROP VIEW IF EXISTS `zaklady_wygrane_2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `zaklady_wygrane_2` AS select `accounts`.`id` AS `id`,`accounts`.`login` AS `login`,`transactions`.`money` AS `money`,`bets`.`bet_place_date` AS `bet_place_date`,`game_teams`.`Teams_id` AS `Teams_id` from (((`accounts` join `transactions` on(`transactions`.`Accounts_id` = `accounts`.`id`)) join `bets` on(`bets`.`id` = `transactions`.`Bets_id`)) join `game_teams` on(`game_teams`.`Gt_id` = `bets`.`gt_id`)) where `game_teams`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-27 12:27:03

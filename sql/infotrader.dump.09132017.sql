-- MySQL dump 10.16  Distrib 10.1.21-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `credits`
--

DROP TABLE IF EXISTS `credits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `credits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_instruction_id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `attention_required` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `credited_amount` decimal(10,5) NOT NULL,
  `crediting_amount` decimal(10,5) NOT NULL,
  `reversing_amount` decimal(10,5) NOT NULL,
  `state` smallint(6) NOT NULL,
  `target_amount` decimal(10,5) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4117D17E8789B572` (`payment_instruction_id`),
  KEY `IDX_4117D17E4C3A3BB` (`payment_id`),
  CONSTRAINT `FK_4117D17E4C3A3BB` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4117D17E8789B572` FOREIGN KEY (`payment_instruction_id`) REFERENCES `payment_instructions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credits`
--

LOCK TABLES `credits` WRITE;
/*!40000 ALTER TABLE `credits` DISABLE KEYS */;
/*!40000 ALTER TABLE `credits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_account`
--

DROP TABLE IF EXISTS `evangeliko_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_create_id` int(11) DEFAULT NULL,
  `first_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `landline_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interests` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `date_create` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A54242D3EEFE5067` (`user_create_id`),
  CONSTRAINT `FK_A54242D3EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_account`
--

LOCK TABLES `evangeliko_account` WRITE;
/*!40000 ALTER TABLE `evangeliko_account` DISABLE KEYS */;
INSERT INTO `evangeliko_account` VALUES (1,1,'Karlo','Laquian','karlo@laquian.com',NULL,NULL,NULL,'[\"Cars\",\"Finance\",\"Lifestyle\",\"Travel and Leisure\"]','2017-07-16 14:23:53',1),(2,1,'Ashley','Co Kehyeng','tim@yap.com',NULL,NULL,NULL,'[\"Lifestyle\",\"Travel and Leisure\",\"Finance\"]','2017-07-16 15:25:20',1),(3,1,'Rommel','Pascual','rommel@pascual.com',NULL,NULL,NULL,'[\"Cars\",\"Finance\",\"Travel and Leisure\"]','2017-07-16 19:29:52',1),(4,1,'Karlo','Laquian','karlo2@laquian.com',NULL,NULL,NULL,'[\"Lifestyle\",\"Finance\"]','2017-08-29 12:14:06',1);
/*!40000 ALTER TABLE `evangeliko_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_account_credit`
--

DROP TABLE IF EXISTS `evangeliko_account_credit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_account_credit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_65CFD9DC9B6B5FBA` (`account_id`),
  KEY `IDX_65CFD9DCEEFE5067` (`user_create_id`),
  CONSTRAINT `FK_65CFD9DC9B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`),
  CONSTRAINT `FK_65CFD9DCEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_account_credit`
--

LOCK TABLES `evangeliko_account_credit` WRITE;
/*!40000 ALTER TABLE `evangeliko_account_credit` DISABLE KEYS */;
INSERT INTO `evangeliko_account_credit` VALUES (1,1,1,1298.00,'2017-07-16 14:23:53'),(2,2,1,900.00,'2017-07-16 15:25:20'),(3,3,1,0.00,'2017-07-16 19:29:52'),(4,4,1,0.00,'2017-08-29 12:14:06');
/*!40000 ALTER TABLE `evangeliko_account_credit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_account_credit_history`
--

DROP TABLE IF EXISTS `evangeliko_account_credit_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_account_credit_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D77E0AFCE062FF9` (`credit_id`),
  KEY `IDX_8D77E0AFEEFE5067` (`user_create_id`),
  CONSTRAINT `FK_8D77E0AFCE062FF9` FOREIGN KEY (`credit_id`) REFERENCES `evangeliko_account_credit` (`id`),
  CONSTRAINT `FK_8D77E0AFEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_account_credit_history`
--

LOCK TABLES `evangeliko_account_credit_history` WRITE;
/*!40000 ALTER TABLE `evangeliko_account_credit_history` DISABLE KEYS */;
INSERT INTO `evangeliko_account_credit_history` VALUES (1,1,2,1000.00,'2017-07-16 14:51:29'),(2,2,3,500.00,'2017-07-16 16:56:22'),(3,2,3,500.00,'2017-07-16 16:59:16'),(4,2,3,1000.00,'2017-07-16 17:22:28'),(5,2,3,1000.00,'2017-07-16 17:26:25'),(6,1,2,1000.00,'2017-07-16 19:05:35'),(7,1,2,500.00,'2017-07-16 19:06:26'),(8,1,2,500.00,'2017-07-16 19:07:29');
/*!40000 ALTER TABLE `evangeliko_account_credit_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_account_interest`
--

DROP TABLE IF EXISTS `evangeliko_account_interest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_account_interest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `interest_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9E8903669B6B5FBA` (`account_id`),
  KEY `IDX_9E8903665A95FF89` (`interest_id`),
  KEY `IDX_9E890366EEFE5067` (`user_create_id`),
  CONSTRAINT `FK_9E8903665A95FF89` FOREIGN KEY (`interest_id`) REFERENCES `evangeliko_interest` (`id`),
  CONSTRAINT `FK_9E8903669B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`),
  CONSTRAINT `FK_9E890366EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_account_interest`
--

LOCK TABLES `evangeliko_account_interest` WRITE;
/*!40000 ALTER TABLE `evangeliko_account_interest` DISABLE KEYS */;
INSERT INTO `evangeliko_account_interest` VALUES (1,1,2,1,'2017-07-16 14:23:53'),(2,1,5,1,'2017-07-16 14:23:53'),(3,2,2,1,'2017-07-16 15:25:20'),(4,2,5,1,'2017-07-16 15:25:20'),(5,3,1,1,'2017-07-16 19:29:52'),(6,3,3,1,'2017-07-16 19:29:52'),(7,3,5,1,'2017-07-16 19:29:52'),(8,4,2,1,'2017-08-29 12:14:06'),(9,4,3,1,'2017-08-29 12:14:06');
/*!40000 ALTER TABLE `evangeliko_account_interest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_community`
--

DROP TABLE IF EXISTS `evangeliko_community`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_create_id` int(11) DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `interests` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `date_create` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_61C4A30BEEFE5067` (`user_create_id`),
  CONSTRAINT `FK_61C4A30BEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_community`
--

LOCK TABLES `evangeliko_community` WRITE;
/*!40000 ALTER TABLE `evangeliko_community` DISABLE KEYS */;
INSERT INTO `evangeliko_community` VALUES (1,2,'mountain-trekking','Public','All about mountain trekking','[\"Lifestyle\",\"Travel and Leisure\"]','2017-07-16 14:56:54',1,'Mountain Trekking'),(2,3,'food-parks','Private','Reviews of Food Parks','[\"Lifestyle\",\"Food\"]','2017-07-16 17:57:36',1,'Food Parks'),(3,3,'mutual-funds','Private','Basics of Mutual Funds','[\"Finance\"]','2017-07-16 19:01:04',1,'Mutual Funds 101'),(4,2,'car-maintenance','Private','Car Maintenance','[\"Cars\",\"Travel and Leisure\"]','2017-07-16 20:08:32',1,'Car Maintenance');
/*!40000 ALTER TABLE `evangeliko_community` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_community_followers`
--

DROP TABLE IF EXISTS `evangeliko_community_followers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_community_followers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_id` int(11) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `status` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3F7017F8FDA7B0BF` (`community_id`),
  KEY `IDX_3F7017F8AC24F853` (`follower_id`),
  KEY `IDX_3F7017F8EEFE5067` (`user_create_id`),
  CONSTRAINT `FK_3F7017F8AC24F853` FOREIGN KEY (`follower_id`) REFERENCES `evangeliko_account` (`id`),
  CONSTRAINT `FK_3F7017F8EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`),
  CONSTRAINT `FK_3F7017F8FDA7B0BF` FOREIGN KEY (`community_id`) REFERENCES `evangeliko_community` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_community_followers`
--

LOCK TABLES `evangeliko_community_followers` WRITE;
/*!40000 ALTER TABLE `evangeliko_community_followers` DISABLE KEYS */;
INSERT INTO `evangeliko_community_followers` VALUES (1,1,1,NULL,'Followed','2017-07-16 14:56:54',1),(2,1,2,NULL,'Followed','2017-07-16 15:26:56',1),(3,2,2,NULL,'Followed','2017-07-16 17:57:36',1),(4,2,1,NULL,'Followed','2017-07-16 18:20:57',1),(5,3,2,NULL,'Followed','2017-07-16 19:01:04',1),(6,3,1,NULL,'Followed','2017-07-16 19:02:26',1),(8,1,3,NULL,'Followed','2017-07-16 19:39:07',1),(9,3,3,NULL,'Followed','2017-07-16 19:56:57',1),(10,4,1,NULL,'Followed','2017-07-16 20:08:32',1),(11,4,3,NULL,'Pending','2017-07-16 20:09:18',1);
/*!40000 ALTER TABLE `evangeliko_community_followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_community_interest`
--

DROP TABLE IF EXISTS `evangeliko_community_interest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_community_interest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_id` int(11) DEFAULT NULL,
  `interest_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F9346D2FDA7B0BF` (`community_id`),
  KEY `IDX_1F9346D25A95FF89` (`interest_id`),
  KEY `IDX_1F9346D2EEFE5067` (`user_create_id`),
  CONSTRAINT `FK_1F9346D25A95FF89` FOREIGN KEY (`interest_id`) REFERENCES `evangeliko_interest` (`id`),
  CONSTRAINT `FK_1F9346D2EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`),
  CONSTRAINT `FK_1F9346D2FDA7B0BF` FOREIGN KEY (`community_id`) REFERENCES `evangeliko_community` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_community_interest`
--

LOCK TABLES `evangeliko_community_interest` WRITE;
/*!40000 ALTER TABLE `evangeliko_community_interest` DISABLE KEYS */;
INSERT INTO `evangeliko_community_interest` VALUES (1,1,2,2,'2017-07-16 14:56:54'),(2,1,5,2,'2017-07-16 14:56:54'),(3,2,2,3,'2017-07-16 17:57:36'),(4,2,4,3,'2017-07-16 17:57:36'),(5,3,3,3,'2017-07-16 19:01:04'),(6,4,1,2,'2017-07-16 20:08:32'),(7,4,5,2,'2017-07-16 20:08:32');
/*!40000 ALTER TABLE `evangeliko_community_interest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_community_type`
--

DROP TABLE IF EXISTS `evangeliko_community_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_community_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_13B5C4B2EEFE5067` (`user_create_id`),
  CONSTRAINT `FK_13B5C4B2EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_community_type`
--

LOCK TABLES `evangeliko_community_type` WRITE;
/*!40000 ALTER TABLE `evangeliko_community_type` DISABLE KEYS */;
INSERT INTO `evangeliko_community_type` VALUES (1,1,'2017-07-16 12:58:54','Public'),(2,1,'2017-07-16 12:58:54','Private');
/*!40000 ALTER TABLE `evangeliko_community_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_credit_amount`
--

DROP TABLE IF EXISTS `evangeliko_credit_amount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_credit_amount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `amt_pay` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5B17CE5BEEFE5067` (`user_create_id`),
  CONSTRAINT `FK_5B17CE5BEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_credit_amount`
--

LOCK TABLES `evangeliko_credit_amount` WRITE;
/*!40000 ALTER TABLE `evangeliko_credit_amount` DISABLE KEYS */;
INSERT INTO `evangeliko_credit_amount` VALUES (1,1,'2017-07-16 12:58:54',100.00,99.00),(2,1,'2017-07-16 12:58:54',500.00,489.00),(3,1,'2017-07-16 12:58:54',1000.00,969.00);
/*!40000 ALTER TABLE `evangeliko_credit_amount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_friendship`
--

DROP TABLE IF EXISTS `evangeliko_friendship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_friendship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `friend_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A4CB8229B6B5FBA` (`account_id`),
  KEY `IDX_5A4CB8226A5458E8` (`friend_id`),
  KEY `IDX_5A4CB822EEFE5067` (`user_create_id`),
  CONSTRAINT `FK_5A4CB8226A5458E8` FOREIGN KEY (`friend_id`) REFERENCES `evangeliko_account` (`id`),
  CONSTRAINT `FK_5A4CB8229B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`),
  CONSTRAINT `FK_5A4CB822EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_friendship`
--

LOCK TABLES `evangeliko_friendship` WRITE;
/*!40000 ALTER TABLE `evangeliko_friendship` DISABLE KEYS */;
/*!40000 ALTER TABLE `evangeliko_friendship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_interest`
--

DROP TABLE IF EXISTS `evangeliko_interest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_interest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A2878AECEEFE5067` (`user_create_id`),
  CONSTRAINT `FK_A2878AECEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_interest`
--

LOCK TABLES `evangeliko_interest` WRITE;
/*!40000 ALTER TABLE `evangeliko_interest` DISABLE KEYS */;
INSERT INTO `evangeliko_interest` VALUES (1,1,'2017-07-16 12:58:54','Cars'),(2,1,'2017-07-16 12:58:54','Lifestyle'),(3,1,'2017-07-16 12:58:54','Finance'),(4,1,'2017-07-16 12:58:54','Food'),(5,1,'2017-07-16 12:58:54','Travel and Leisure');
/*!40000 ALTER TABLE `evangeliko_interest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_notifications`
--

DROP TABLE IF EXISTS `evangeliko_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8480EFABE92F8F78` (`recipient_id`),
  KEY `IDX_8480EFABEEFE5067` (`user_create_id`),
  CONSTRAINT `FK_8480EFABE92F8F78` FOREIGN KEY (`recipient_id`) REFERENCES `evangeliko_account` (`id`),
  CONSTRAINT `FK_8480EFABEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_notifications`
--

LOCK TABLES `evangeliko_notifications` WRITE;
/*!40000 ALTER TABLE `evangeliko_notifications` DISABLE KEYS */;
INSERT INTO `evangeliko_notifications` VALUES (2,1,NULL,'Rommel Pascual followed Mountain Trekking hive','2017-07-16 19:39:07',1),(3,3,NULL,'You followed Mountain Trekking hive','2017-07-16 19:39:07',1),(4,2,NULL,'Rommel Pascual wants to follow Mutual Funds 101 hive','2017-07-16 19:56:57',1),(5,3,NULL,'You are now following Mutual Funds 101 hive.','2017-07-16 20:02:39',1),(6,3,NULL,'Karlo Laquian recommended Car Maintenance hive.','2017-07-16 20:09:18',1);
/*!40000 ALTER TABLE `evangeliko_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_orders`
--

DROP TABLE IF EXISTS `evangeliko_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_instruction_id` int(11) DEFAULT NULL,
  `amount` decimal(10,5) NOT NULL,
  `credit_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9C1050468789B572` (`payment_instruction_id`),
  KEY `IDX_9C105046CE062FF9` (`credit_id`),
  CONSTRAINT `FK_9C1050468789B572` FOREIGN KEY (`payment_instruction_id`) REFERENCES `payment_instructions` (`id`),
  CONSTRAINT `FK_9C105046CE062FF9` FOREIGN KEY (`credit_id`) REFERENCES `evangeliko_account_credit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_orders`
--

LOCK TABLES `evangeliko_orders` WRITE;
/*!40000 ALTER TABLE `evangeliko_orders` DISABLE KEYS */;
INSERT INTO `evangeliko_orders` VALUES (1,25,42.24000,NULL),(2,26,99.00000,1),(3,27,99.00000,1),(4,28,99.00000,1);
/*!40000 ALTER TABLE `evangeliko_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_post_type`
--

DROP TABLE IF EXISTS `evangeliko_post_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_post_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3F2FD31AEEFE5067` (`user_create_id`),
  CONSTRAINT `FK_3F2FD31AEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_post_type`
--

LOCK TABLES `evangeliko_post_type` WRITE;
/*!40000 ALTER TABLE `evangeliko_post_type` DISABLE KEYS */;
INSERT INTO `evangeliko_post_type` VALUES (1,1,'2017-07-16 12:58:54','Free'),(2,1,'2017-07-16 12:58:54','Paid');
/*!40000 ALTER TABLE `evangeliko_post_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evangeliko_posts`
--

DROP TABLE IF EXISTS `evangeliko_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evangeliko_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `community_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `post_message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `order_number` int(11) DEFAULT NULL,
  `post_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `post_title` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6B48B6F3727ACA70` (`parent_id`),
  KEY `IDX_6B48B6F3FDA7B0BF` (`community_id`),
  KEY `IDX_6B48B6F39B6B5FBA` (`account_id`),
  KEY `IDX_6B48B6F3EEFE5067` (`user_create_id`),
  CONSTRAINT `FK_6B48B6F3727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `evangeliko_posts` (`id`),
  CONSTRAINT `FK_6B48B6F39B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`),
  CONSTRAINT `FK_6B48B6F3EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`),
  CONSTRAINT `FK_6B48B6F3FDA7B0BF` FOREIGN KEY (`community_id`) REFERENCES `evangeliko_community` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evangeliko_posts`
--

LOCK TABLES `evangeliko_posts` WRITE;
/*!40000 ALTER TABLE `evangeliko_posts` DISABLE KEYS */;
INSERT INTO `evangeliko_posts` VALUES (1,NULL,1,NULL,2,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eleifend tortor eget neque dictum ornare. Quisque pulvinar vestibulum lorem, at eleifend risus. Donec venenatis ornare sapien nec ullamcorper. Proin urna mi, fringilla nec leo ac, consectetur fringilla lectus. Maecenas ut iaculis erat. Vestibulum lacinia massa eget nisi facilisis, et feugiat odio porttitor. In facilisis risus eget augue accumsan, vitae facilisis nibh consequat. Donec ut augue auctor, ultrices enim aliquet, lacinia magna. Cras turpis turpis, sodales vestibulum magna at, rutrum imperdiet lorem. Donec vehicula nulla ut ex tincidunt mollis. Quisque sed turpis viverra, maximus orci at, sollicitudin sapien. Phasellus et orci ac ex ultricies euismod. Donec ac erat sit amet orci eleifend tristique.',NULL,'Paid',100.00,'2017-07-16 15:09:46','Welcome!'),(2,NULL,1,NULL,2,'This is a sample post',NULL,'Free',0.00,'2017-07-16 16:36:09','Sample Post'),(3,1,NULL,NULL,3,'This is a sample reply',NULL,'free',0.00,'2017-07-16 17:54:27','Welcome!'),(4,NULL,3,NULL,3,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc semper ut justo et malesuada. Praesent commodo purus ac dignissim ornare. Aenean nec libero condimentum, luctus ante a, feugiat erat. Nulla fermentum sagittis lacinia. Suspendisse potenti. Donec ac efficitur felis. In id dignissim ex. Curabitur lacinia neque nec neque tincidunt interdum. Mauris eget felis ex. ',NULL,'Paid',100.00,'2017-07-16 19:05:20','Welcome to Mutual Funds 101'),(5,NULL,3,NULL,3,'This is a sample post',NULL,'Paid',100.00,'2017-07-16 19:09:04','Sample Post');
/*!40000 ALTER TABLE `evangeliko_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financial_transactions`
--

DROP TABLE IF EXISTS `financial_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `extended_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:extended_payment_data)',
  `processed_amount` decimal(10,5) NOT NULL,
  `reason_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `requested_amount` decimal(10,5) NOT NULL,
  `response_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tracking_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_type` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1353F2D9CE062FF9` (`credit_id`),
  KEY `IDX_1353F2D94C3A3BB` (`payment_id`),
  CONSTRAINT `FK_1353F2D94C3A3BB` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_1353F2D9CE062FF9` FOREIGN KEY (`credit_id`) REFERENCES `credits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financial_transactions`
--

LOCK TABLES `financial_transactions` WRITE;
/*!40000 ALTER TABLE `financial_transactions` DISABLE KEYS */;
INSERT INTO `financial_transactions` VALUES (1,NULL,15,NULL,0.00000,'10419',NULL,42.24000,'Failure',2,'2017-09-12 19:51:42','2017-09-12 19:51:59',NULL,2),(2,NULL,16,NULL,0.00000,'action_required',NULL,42.24000,'pending',4,'2017-09-12 19:54:24','2017-09-12 19:54:27',NULL,2),(3,NULL,19,NULL,0.00000,'10419',NULL,42.24000,'Failure',2,'2017-09-12 19:59:27','2017-09-12 20:09:22',NULL,2),(4,NULL,20,NULL,0.00000,'action_required','7AH787498A3653818',42.24000,'pending',4,'2017-09-12 20:22:32','2017-09-12 20:23:46',NULL,2),(5,NULL,21,NULL,42.24000,'none','4EV46063BK0917452',42.24000,'success',5,'2017-09-12 20:24:36','2017-09-12 20:25:10',NULL,2),(6,NULL,22,NULL,42.24000,'none','70A250788J491980P',42.24000,'success',5,'2017-09-12 20:27:22','2017-09-12 20:27:44',NULL,2),(7,NULL,23,NULL,0.00000,'action_required',NULL,0.00000,'pending',4,'2017-09-12 20:28:02','2017-09-12 20:28:03',NULL,2),(8,NULL,24,NULL,42.24000,'none','0EK09150WF396004T',42.24000,'success',5,'2017-09-12 20:28:30','2017-09-12 20:28:47',NULL,2),(9,NULL,25,NULL,0.00000,'action_required',NULL,42.24000,'pending',4,'2017-09-13 04:49:12','2017-09-13 04:49:15',NULL,2),(10,NULL,26,NULL,0.00000,'action_required',NULL,42.24000,'pending',4,'2017-09-13 05:05:24','2017-09-13 05:05:30',NULL,2),(11,NULL,27,NULL,42.24000,'none','66R50721CM412780L',42.24000,'success',5,'2017-09-13 07:30:49','2017-09-13 07:34:11',NULL,2),(12,NULL,28,NULL,99.00000,'none','5YW07879E46311642',99.00000,'success',5,'2017-09-13 08:59:37','2017-09-13 09:06:27',NULL,2),(13,NULL,29,NULL,99.00000,'none','4LC85972JU784640R',99.00000,'success',5,'2017-09-13 09:09:59','2017-09-13 09:10:51',NULL,2),(14,NULL,30,NULL,99.00000,'none','234274736Y204533X',99.00000,'success',5,'2017-09-13 09:12:06','2017-09-13 09:13:02',NULL,2);
/*!40000 ALTER TABLE `financial_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_access_tokens`
--

DROP TABLE IF EXISTS `oauth2_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_access_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D247A21B5F37A13B` (`token`),
  KEY `IDX_D247A21B19EB6921` (`client_id`),
  KEY `IDX_D247A21BA76ED395` (`user_id`),
  CONSTRAINT `FK_D247A21B19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
  CONSTRAINT `FK_D247A21BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_access_tokens`
--

LOCK TABLES `oauth2_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth2_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth2_access_tokens` VALUES (1,2,5,'MTA2OGJiODc2YzBiMTkzNDhkNTE2NWVmZmExNTNlMTFlMzU1Mzk1MGNiOTE0MTlmNmU1Yzk0YThjYzAyNmI4Ng',1502839172,NULL),(2,3,6,'NWE4MzRhMTRiODUyMTY2YmQxMTdmNzM1MTVmN2QwZDRhYWJiNmE1YTEwNjQ3ZGNmZDI2MWI4MjA2NWY3ZDk4Zg',1503519365,NULL);
/*!40000 ALTER TABLE `oauth2_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_auth_codes`
--

DROP TABLE IF EXISTS `oauth2_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_auth_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` longtext COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A018A10D5F37A13B` (`token`),
  KEY `IDX_A018A10D19EB6921` (`client_id`),
  KEY `IDX_A018A10DA76ED395` (`user_id`),
  CONSTRAINT `FK_A018A10D19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
  CONSTRAINT `FK_A018A10DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_auth_codes`
--

LOCK TABLES `oauth2_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth2_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_clients`
--

DROP TABLE IF EXISTS `oauth2_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `random_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uris` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allowed_grant_types` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_clients`
--

LOCK TABLES `oauth2_clients` WRITE;
/*!40000 ALTER TABLE `oauth2_clients` DISABLE KEYS */;
INSERT INTO `oauth2_clients` VALUES (1,'3xaju6lomx44kw4800c8s8w4o0csc88kc8cwgksg8osow04g88','a:0:{}','37duloqa2hmo4ckgcc80co80k8ccccw00goccwos0ws8c08k84','a:1:{i:0;s:8:\"password\";}'),(2,'2op8ymt9nkcg4g8wkccws4g4w4k8g0sg8ss0k4okwgks44s000','a:0:{}','9exzjovqhsg8040ogwgo0ws88os80kwscgs8gw4ooo00cwso0','a:1:{i:0;s:8:\"password\";}'),(3,'nm2sofmb8mosgccs0kwgco0cck0k84c0kw4g8cskok4cwcs8k','a:0:{}','29q0og2wpllw8kgk4occ408sgskkwkkw840gkkksgocw0wwg88','a:1:{i:0;s:8:\"password\";}');
/*!40000 ALTER TABLE `oauth2_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth2_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_refresh_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D394478C5F37A13B` (`token`),
  KEY `IDX_D394478C19EB6921` (`client_id`),
  KEY `IDX_D394478CA76ED395` (`user_id`),
  CONSTRAINT `FK_D394478C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
  CONSTRAINT `FK_D394478CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_refresh_tokens`
--

LOCK TABLES `oauth2_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth2_refresh_tokens` DISABLE KEYS */;
INSERT INTO `oauth2_refresh_tokens` VALUES (1,2,5,'ZTA5ZWI4NjVlNTdiNjgwNDcyYzliNjgyODdmMTM2ZjNhN2JkZDI0ODU1MDkzN2U0NjgyMWE4MTZkZGI0NWNiNw',1504012773,NULL),(2,3,6,'ZTQ0ZTYxNzBjOTYwNmQwOGFlYTFiNzkzOGRhMjBkMzE4MTM2YzcyNzMxYzZjMzYwM2ExMTcyMzRmMWZiODQ1OA',1504692965,NULL);
/*!40000 ALTER TABLE `oauth2_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_instructions`
--

DROP TABLE IF EXISTS `payment_instructions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_instructions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,5) NOT NULL,
  `approved_amount` decimal(10,5) NOT NULL,
  `approving_amount` decimal(10,5) NOT NULL,
  `created_at` datetime NOT NULL,
  `credited_amount` decimal(10,5) NOT NULL,
  `crediting_amount` decimal(10,5) NOT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `deposited_amount` decimal(10,5) NOT NULL,
  `depositing_amount` decimal(10,5) NOT NULL,
  `extended_data` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:extended_payment_data)',
  `payment_system_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reversing_approved_amount` decimal(10,5) NOT NULL,
  `reversing_credited_amount` decimal(10,5) NOT NULL,
  `reversing_deposited_amount` decimal(10,5) NOT NULL,
  `state` smallint(6) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_instructions`
--

LOCK TABLES `payment_instructions` WRITE;
/*!40000 ALTER TABLE `payment_instructions` DISABLE KEYS */;
INSERT INTO `payment_instructions` VALUES (1,42.24000,0.00000,0.00000,'2017-09-12 19:26:40',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:26:41'),(2,42.24000,0.00000,0.00000,'2017-09-12 19:29:51',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:29:51'),(3,42.24000,0.00000,0.00000,'2017-09-12 19:30:23',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:30:23'),(4,42.24000,0.00000,0.00000,'2017-09-12 19:31:09',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:31:09'),(5,42.24000,0.00000,0.00000,'2017-09-12 19:32:01',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:32:01'),(6,42.24000,0.00000,0.00000,'2017-09-12 19:32:24',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:32:24'),(7,42.24000,0.00000,0.00000,'2017-09-12 19:33:16',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:33:16'),(8,42.24000,0.00000,0.00000,'2017-09-12 19:36:28',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:36:28'),(9,42.24000,0.00000,0.00000,'2017-09-12 19:38:10',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:38:11'),(10,42.24000,0.00000,0.00000,'2017-09-12 19:38:43',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:38:43'),(11,42.24000,0.00000,0.00000,'2017-09-12 19:39:11',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:39:11'),(12,42.24000,0.00000,0.00000,'2017-09-12 19:42:55',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:42:55'),(13,42.24000,0.00000,0.00000,'2017-09-12 19:43:28',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:43:28'),(14,42.24000,0.00000,0.00000,'2017-09-12 19:43:47',0.00000,0.00000,'EUR',0.00000,0.00000,'a:0:{}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:43:47'),(15,42.24000,0.00000,0.00000,'2017-09-12 19:51:41',0.00000,0.00000,'EUR',0.00000,0.00000,'a:5:{s:10:\"return_url\";a:3:{i:0;s:220:\"def5020070910b0c65110c21a267a436765200399a0127729b977152aac1dca2e5cf5adcc69e0583e21a265799536e182f44baaac4ed55fb7755c1e3af586a52d3f8cd4a337b2a651e773fab98407377017542b61b34211043dcafbbcd3e92d1621348ff1572979c1068318a35e2\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:220:\"def502004e5f913617734afe396182df6264297a97d6f5d222c0d4ad5ef910b50186d1bd449d4f19ff6c825783080bda83749f3ea0a425712ce8da877c7fe4429f5cbb0ebc81bcc5a019f09e49033338fb7b65300625e152e3830cb54a318871cc383ba55702b1a512dffdb5e93f\";i:1;b:1;i:2;b:1;}s:10:\"useraction\";a:3:{i:0;s:194:\"def5020097551b441b7c8e5ec671e6c2af88198036d2136e8f9b0049c372bf96fe8146fadc4f2c3d2b2c564ff9d1f51ed07e65e8dc4c04e4562e6c4a77de346bc13820672223633a06fabd232494d2e4ab3cafb5c78e7cba84d4bbe5e9bb2ed104\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def50200dcb77c4230d1ec1924572a77b0e516da97eb5d9c04543e4ab87f0417726282bd925daed1565527f8b07a426ae00b34bb61b23a5e28709dc9aa5a5382c65c4e5d4669d71e44325e19c04538f7eb5b371ea9c14f8abb68def6d13679f616d572902cc24933c6b6f71bda13b365\";i:1;b:1;i:2;b:1;}s:15:\"paypal_payer_id\";a:3:{i:0;s:172:\"def502005f72d2dc12e03cbd1f6e81f6acf437a575ee4c47b9e578a729dab79d362216f69a4539c64fd1a796752615deb9e4ebc32541bc2367b666888b20e3d1cb1a73bfefdb1e7dff3abd3827b375eb6a275a8544d1\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:51:59'),(16,42.24000,0.00000,42.24000,'2017-09-12 19:54:23',0.00000,0.00000,'EUR',0.00000,42.24000,'a:4:{s:10:\"return_url\";a:3:{i:0;s:220:\"def502005c334bd33b02b04758901eed2a774aad46087c98a6e661b710d89008d5203dbb1eba95eecc6b905940a699c4a9cb2037e621f1f5540ab629d697dbab8124c7ff15afd359901d13ebe0b88bf5b2db4ccf6db6396a6861bf94fde62850f3643482640675a6e842bc198960\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:220:\"def50200d68b1b3e8d9ec3d9664ab122905b8e049ed88c3e472c9996c51499854c936b88188b226a59c1305b82df44fb1be523e6c4d0da6ef10ba705c1b7b9ca7f37edca5300ce424ea10986fdf240955401f937b75f58ddd673a98f6277f3669467dd3a906c474441920ef60405\";i:1;b:1;i:2;b:1;}s:10:\"useraction\";a:3:{i:0;s:194:\"def5020085bd501694a4a85b0164d9a717c7c8a38ebd4948e06df4144f2cd094f785a512212ae0f6b0543dc62f239b70dc224a64b84dbf45e78cee3b49b2b0e3d762789282f930c184a4faec42441a3bc12aa13cfb69b67b6ef18dcefe87fda696\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def502006acc9d6c000f5398e86adb854be35a4804eab610cf06cbc66c7c564e6d92c5dfb47427d6c57ec9fc8b4db6330aa608673a1ae2dd88ed9d02e26b7fbbd066a89a969782d8de22759034d7fa72d096a844f81ea76df83f90db5c8ab89f6b8f6bb70b4faaee61cf262baa7166df\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:54:28'),(17,42.24000,0.00000,0.00000,'2017-09-12 19:58:45',0.00000,0.00000,'EUR',0.00000,0.00000,'a:1:{s:10:\"return_url\";a:3:{i:0;s:266:\"def50200d03cecac2b6143c34644aba4b85967aadc7aceb796934eeaebb85f55ceb1bb4189f96c3ac4e1b8a5a58a639c3e84e8dfb6bd7bddea892b21e17d612310c53b287aeec516128adb984322cf32bb292472b09734257d8b8c411cb1d217153c0c9b96b8bc6258a84eb7cd4b0e5a14b6f188fdc3508324457c270969be81c2e8acb67c\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 19:58:45'),(18,42.24000,0.00000,0.00000,'2017-09-12 19:59:24',0.00000,0.00000,'EUR',0.00000,0.00000,'a:4:{s:10:\"return_url\";a:3:{i:0;s:266:\"def502009ae040875e28a4b4e4c47736b770d7994b86f0a8a2e79862d1e357f4fedd5d67f458b1ad5c4ddf95aa9df36fa70367eee58a508d3186f3391c666dda4a15eb7dd040421f5e6c6b6e420eecb3502fab8bb438a1ebfec7028bac48e86c3d75d05c0ba80c1ced7cbbee5829984b7d076c1360b30e2ad66730b5b2f7c26a23987eee18\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:220:\"def50200ef91fc30876c9e561e00252b58644cdd340b3a9d8b984193a5a07c0fc00fe19966a77cbc9ba7d15a82b153414d98ee1d3ce612dde395ed988da7cbc51283ff0c95001d8abf33614f35dac75b659c2fc60643f91f7b19619b853038d2d1dd5128afcd03dfef3578d81fa5\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def502000871a7571a14e020e9ac31953edf8b0a8ea808bfdd5b16099b498ced66bf0844b1b47d1402f6faed66cc878280747f6df74923ad97aee899586d57988ef42436c3d6589822ee40b9eddc9892f5401a335c3c7b673e4d42471d2e480aa72924006ab9f821b2d17d539fa09802\";i:1;b:1;i:2;b:1;}s:15:\"paypal_payer_id\";a:3:{i:0;s:172:\"def50200d012016e6fd907d5192603f3e7f43ebe4fe7a60ae54bf10d21429581d0fb6fcbeb1ea62e97ef6dfc6cfeb123e4a08eab15263909aa54f4456e90c57ed30b21bf0708e9652981a7b4c49b30254e893ac65abb\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 20:09:22'),(19,42.24000,0.00000,42.24000,'2017-09-12 20:22:30',0.00000,0.00000,'EUR',0.00000,42.24000,'a:3:{s:10:\"return_url\";a:3:{i:0;s:266:\"def50200e898ce14701e0f99530619cb85db87cd1c5c6bb4bba92d8d76e0aee45800d539c77a98c0358accc0a808f11413fc9991f236d11a917764d44c3eb4d43a1442dcafa1400d3133c4a9fca0bc97383348f44b8f2e2fda5eeb645a88d8b821c7ec034ff7d19346ab869796f8fcd510c7593b90109b02800dd68d3db6a0c17151eaeb2b\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:220:\"def50200a49bd950f0e68dd589269f88f002f3a2b3b0ab66ef1816230370f1fbffd87e9c6cd98071b017462d5320f759e8436de26dffa5f696126ba36b2eb58be039cce282ab0de796289bfbd8c5c17e2c3b37a5110690773a7acf5bc2032517d1670e040de70a4a4425a80743e3\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def5020008e5ccf929bfb2524caed1e41a524978c648c409eb8d2b41b7ea73de2f93b4c41e9f5fad5da9a7a5eefa849697d648d01a0371c884cf6b6a735463355e90f2d32765eabd9f047dde391a434d5fcb050ee83bafdb05e3cf2e10b1d1d0399161ef1e197c0ae3c498e81e3c2b5c\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 20:22:34'),(20,42.24000,42.24000,0.00000,'2017-09-12 20:24:35',0.00000,0.00000,'USD',42.24000,0.00000,'a:4:{s:10:\"return_url\";a:3:{i:0;s:266:\"def50200fe450abfc88b331f500d2dad44e5b12936163e980fa68c40f1b2a4a832d53d65b4313a7ce08b8f459128201a7f289c071bd83c606b234bc1e3ed078f3f0f016fd3fe2311be89b536dadab62edd8e541ebcdb03b7d3a1737c120b7bf3f226a8c5c44875eb56b7e6f9bab7d3ef737036a5971d576b094f436fa0f2fcaee19ec11aaa\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:220:\"def502008f1bd1b1947b7cacd454c604921852ae4d5f9b64112559ebc3880e0a485b3060837187a18348c4fe1306626e6b973f52c3123b5ba1f1dc3f7b6519f6a01f997a1b68d6bafbcee45df6f76b2642d2076af8a91838078cf00a3d053834e76a86e1aebe1beea1c1b5184055\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def5020066df7128c06b50edfdc23bf607e22de408d7e915beb230599f94d05807d2af2222cfe268f2956ab9a24d73e4af72327a905cb683d1cc5fc93ff44dbff390deb60c5f53da59819c99d39309cbf58877c37c8ced6c160bccaa4bd2db679129c800a43aa7244b3e7e0a5eb72aaf\";i:1;b:1;i:2;b:1;}s:15:\"paypal_payer_id\";a:3:{i:0;s:210:\"def502006c508917306e36d07250a42e16a775e5458c6dd8f0ed0667e3dac07afab7cf719af1f056d55d8873bdc3b2494350fe8e042e1ce2590805bd2616a199ae0c443f6f1f8719bcb72bf1f24150e96f18ff91ea2836c86fc73a3243dadbed2708d80774272fbd0f\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 20:25:09'),(21,42.24000,42.24000,0.00000,'2017-09-12 20:27:19',0.00000,0.00000,'USD',42.24000,0.00000,'a:4:{s:10:\"return_url\";a:3:{i:0;s:266:\"def50200bc239bdc653178556547349c92efe3461c760c768cea411c4ab2d5810cd5757045e2ec1069d7a80e36b0aa41dcc324cf0e3431215319d2069b09769b408e3954fe4af62d630a9ee7cbaf539fcbc3a880a8345979ea3adbfdbd9253a031c30c98b888dddc1661a262288b1b29746ee81f31ca7a1264d4d15fb9b3bb11a571be7171\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:220:\"def502005597a5aa15fc90825caf4669124e954b4ed9a5c4af717031cb424a4619910f65ee24c71297f3556d6ee2df9a8fa620db08d921de17117df36b1c4ec169e5fd02cae04ee1a093885583f93d949a4e9cbb8318797a2f2507f8660f686635c99ffed75aff2944429cf85ba7\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def5020077f637535a8b759a8700b8eeaedc1a6f74a8922019958c26eae265316a6aa24b9a9bf0fba459211be26705d5033825f9a157be893863a4e059739b3f25e12513e5936192c22a812b4850f215bdb3f6f9468035b77761c1f749cea1b07a1df2ddbeb0f7411094f24dab5f2020\";i:1;b:1;i:2;b:1;}s:15:\"paypal_payer_id\";a:3:{i:0;s:210:\"def50200a880642a119f3154858a06a018503feeedf9cedaad3c3cba59f2b5f96a864db2baac8a77315b4d03c323180b4bc4834f2a7ee074a6ad311b92bc57cec89fcc3993ffb9c845d85764a02ff3e0fa8dfdcc8f66956e34c414cb01d0efa7eade713a1b5ec8e3d5\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 20:28:03'),(22,42.24000,42.24000,0.00000,'2017-09-12 20:28:29',0.00000,0.00000,'USD',42.24000,0.00000,'a:4:{s:10:\"return_url\";a:3:{i:0;s:266:\"def50200d8256117f1eab945bce95138773fe38f8aa37e226f905126050427130b2d16cd9620c6af2f597ceedf845a2d5fa14cd6dc4a66f4d381d84e81de821fcdeb9f07c23008eeec38938e3286a23fda38970082734fb08d8b4385e01e2bebc4edc603cd253093bfaae6b550bd0a2ce5a5c2165732d001f5c584afe8c26ba237bde807d5\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:220:\"def50200590cedb4a3d18edd81c7a788bc1fb4b33a4a884b1290fccc1da90a4be0053e74993b5401f3d226585a7dcb307a06b9ab3f4d3dcfb425b24c694f6af7abd900474acfd66781452ea8c6451eca32772f14ac67e4c45e119c03690fdb93dbca72a851613d99f79328066965\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def502003891b0b870d7c7a02762bae49f2d732f6623a957478a35d93e3649facd22f281abbaa0877e8bf1ba081686f9006e811fc8ff647409e1191d594d280c90cddd55121665ccb5bf925e3d0d184ff77c74fbabc8cbb777be877bcafce65baef3f4677e44abf7bfb51dcdd0b4d76f\";i:1;b:1;i:2;b:1;}s:15:\"paypal_payer_id\";a:3:{i:0;s:210:\"def50200f9bd6633049fc0e2c6ca674fd5c0b2d03e9ee18a4f8c688de0ef3d7726af03ca2681488ed1e573bed46e164748556965e2b6750a9e0c6f914272b697c0c96221d96dce01cf327b10ce14a2b5d280956cded2898fdf734385d05cf0de113e020be1ae4736ae\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-12 20:28:47'),(23,42.24000,0.00000,42.24000,'2017-09-13 04:49:08',0.00000,0.00000,'USD',0.00000,42.24000,'a:3:{s:10:\"return_url\";a:3:{i:0;s:266:\"def50200e7835cff978de7fafda582cd894fb0cedb9d00ab88a992153fea5de309a8d3f1342eddd44c569122642c3bb1f34f74caa7c75130c097743b2e824f8ef8760cebf8d87498bd35d01c5bd1a19a77618b568d05b690435d470c58d71755d4301076bff44d86c5e252db4e4ee1b79ab3ba28b636c018b499bcb0bd525e82ac223bb4c1\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:220:\"def502006acadbe3e3e83398eb15d09de629d2cc6653a6b5d7868accac977f1a1279231df37850813e6c60d4ed4c2e92d7718b6ac3129ab699af557bafa18b73b55aef96751867174e28eb78c5e7b777f242df04bdef84cbbed7893212b6639b23a58cbb6ee7f514fc0323ea09e5\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def502001fc7b573c1c7bbfc0d9cfe6d596a89b8d5a5b7c8c7f6f585a7787bc380a99d077979d04d405dc900546c1d10e0dd6fdfc253e7683152b3956a32029e74e9d6b1fd06692b93afd8305188d582c846561513969bd3514457361bfe93a2013809d47306dd74cd5081267d73ca48\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-13 04:49:15'),(24,42.24000,0.00000,42.24000,'2017-09-13 05:05:22',0.00000,0.00000,'USD',0.00000,42.24000,'a:3:{s:10:\"return_url\";a:3:{i:0;s:266:\"def5020063305ad44ddc27e1c7510ac865225fbc35b85eeb6392053b442226aae04c4325b3e9950eb3c8df11e6ea68fbac155031c5282de841a535b07bccb6a7ad2ed39dd1dd962380c3eb1051afe01ba2f109ca40a48b8c7d396dddd318072e37d2978a333e49b582eaf32c0a624d9b28b8bf702e32785a21cead0ddcfa4283db000c9e96\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:218:\"def502007db1c30100768922bf21a7eeaec60b90669ee431565a787eeb9780cfd34e9239f40850d59924d0d246a56a76397fd531010293795ba859d96a08d162fa2517fca7c0c00c9b38a9a386b336e80cb66a54ceafbd9f1911483cc79128b729a7d07931965b0f71bab5a43d\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def50200a20d9a4d7040d634e4f02ad1e49701f4ab20ae461ca62a99ba25674d4190cc5f7e46ea7a5192e16d79f8daacb4a912ae38527cdb1ddc456d2909630df34b3fb8eb9b798815c668c6fac1205c46a677bd15125b72afc7854cb344e3f8f337acce0c891d3aa8e8eec99f458c10\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-13 05:05:30'),(25,42.24000,42.24000,0.00000,'2017-09-13 07:30:48',0.00000,0.00000,'USD',42.24000,0.00000,'a:4:{s:10:\"return_url\";a:3:{i:0;s:266:\"def50200ca67cbe8e81b444be37d8880e7cda69b0a49aca8dcd973e152b81d87bce5fcce3d2eb123b38d854d3a2f9efe9a8a5be4ed3845315eb38daee7471aea75a9172d65364c4b9aaa7a5ab7938ad969153e09060c6f2649e63d476325d15958c9069cd61c87e1cb3b6dc6a710c2fe66635d694a928ddc2d0b7083f540d235e0d23ab460\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:232:\"def50200817c8957ac6549dbbf27f68ee716edf34317cf6955f3ae5b24d4e8b2cd5273f958eb400c515ad98e809b074df07caa373d34b8d3eee98ccf92fd7a9c89ade0e587ee4fcd521a9c5cebcb654ed8e40a62b3f0875ee06a4f178ca890efbd61f9828565a1ae6ae238b4e791a1b0af55177a\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def5020058f9fc19f4fb341dd836ce6d4cdbf213f0e74f5d330ebcdb76e8fc6e8c581312d9c01a4860f4ad2f87801095b33e0c9b5cfa691cb3863265951d979834172ccbef5eea32b5c3faadaec378c1251aa37be34276b17056569600dcf31fb253b69af5f9375a1d7ee170926ccc16\";i:1;b:1;i:2;b:1;}s:15:\"paypal_payer_id\";a:3:{i:0;s:210:\"def5020088f109bd1cb2bb7099f80f68ea40ddeb93d579a4f762d25db1a33365f847407da561707704c46f615457abb3095470233911268a1e9119a4c398e383e7ab6b470c44c9a26bce61f6a03617f2dc5c3a83717bbecfb903b77975d3f2fcfad6948ce88575fb74\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-13 07:34:11'),(26,99.00000,99.00000,0.00000,'2017-09-13 08:59:35',0.00000,0.00000,'USD',99.00000,0.00000,'a:4:{s:10:\"return_url\";a:3:{i:0;s:266:\"def5020046c0ca04779bf36ae9630a8c60d3bbf0b7c5ccbe8b20e1cd2545f045a8d5c963e37f7cee30cfc0f5060ab46de3ba8f61637256f20b8f6928e984c5dca4dac38dd1a40eda8a5fdfab5487ea4a56f9c6f258a3585f193ab33eb4049bf6f31f7acc9f525b62c085e7dc550ad47ad367bc304bb2d64f75a31c1223ddb46c058b242cd3\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:232:\"def502002a53dfc7708163baf2806d86ad0b8afa4cd4a278f6f44f26b94a2af70b97384f68d2f10f50abe7d93baedaaef0610795c00b7acbc2daff9e30735e31b0fc8107e2d2b0a2ac8424de6a876a3fd9abc6d36a2ed95fc6c69c3fe0cc6f0d3be00d977560e92b84bf9f2fb2771b6e867ff0f5\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def5020037d38f808fab0ac5a8ef326b6d1f2bfb0916cd7b662676e4d96ccb47fd0dd8bc14afc45622d5a112f25a9db0f0d4ea6b0812055aa0c503b3e53a9b74ec0a48ad3efb384c32b618c8b38c529e98e6c656c49fa028bfed72e30462a0539e6a4514ba7e61e590eb1c766cbfabb7\";i:1;b:1;i:2;b:1;}s:15:\"paypal_payer_id\";a:3:{i:0;s:210:\"def502008567ff9197e0d7d99c0575dcb60d16f2623d19738be59d04c26907d370b353a93796b1ce64d25b997854c52e20f8e6d7ecff1d648c9457da27e2a58762dd8d5ea09b0b3afd79d5e2d896c5454c946eff0252d10af892fb7cbec40779490bdc65b464c5b688\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-13 09:06:27'),(27,99.00000,99.00000,0.00000,'2017-09-13 09:09:58',0.00000,0.00000,'USD',99.00000,0.00000,'a:4:{s:10:\"return_url\";a:3:{i:0;s:266:\"def50200b2045c0465e26fdd99167bdc8513c46bafc7d1f046289218f054eb9ae61cf485bc7321816fb1314701d600bd8c5395ef9fa575fa1498627b72c6e67b6346972bdacd71a2e4afd47e877c44a1f3429223befa29b6bd2e6f53f0ad0d531415d4964daeae7fb5a654adca6c97d673acca8a82bd8450f0a7387afb8873808c66bf4070\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:232:\"def502007596623e6e361390b7c630743975bae119b666d4081f411d91321c5be19b91f5dbc900279fd408322508d5ecd8cfd9f28bee544d83cd007b81cfc90118c371b91407e4757c5b16ae268948d8e31dc8cf8fe9f8aa7addac7697e666e7c665a6e344672fa763f3399a198283af83651084\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def50200c4922c181e90858f9f61d0d1b4022d9e448e2383900cbe64a999a1f46bdc251c676a992d81d527f79921835b642d2eb35446886e834e6b4e1666458056c370666161c7f3234b0a2b0856c8ba040d45b0b18e6a44f197130cdf4e3a68be29f75be8cc23f0946c84762a5a65f9\";i:1;b:1;i:2;b:1;}s:15:\"paypal_payer_id\";a:3:{i:0;s:210:\"def502001c5c3bcfbe0ce0a3aafcfc9d3a2dddb52ee840c2136efefac6ac17010016ba25a59785e671598e5f60097a58e2608e04afec73dc71bed27f95706832ee75cc711f8b03a09fd023ac8ea06ad703cff694dff6659a34066e097cd01e393f7af5e6feef86ddb9\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-13 09:10:51'),(28,99.00000,99.00000,0.00000,'2017-09-13 09:12:03',0.00000,0.00000,'USD',99.00000,0.00000,'a:4:{s:10:\"return_url\";a:3:{i:0;s:266:\"def5020044f70b234b56c8090f456f008fdb3afbf17f3fecc7491fbb0fb2b66e4103655e0079c76056ed88bf2df2b294e1d916cce05be91ecc0f092441c5589b1e88dd9f8ae83e3d8a4a1dab2583b1e3155609fd7d23f6a139c9bad285d98358293d70968d8575b11fb2a7a3a282c86e350736e03a5da17d1c0bc55a795251a8b4403bd309\";i:1;b:1;i:2;b:1;}s:10:\"cancel_url\";a:3:{i:0;s:232:\"def502003f6e5cad640ee7d8215c5ad2b2c6dfbfce8cdcdfcb05c694d67f074d6510da015e8b096e614eb5c0f7d136e0b16c25000f1594f95b4ad33bf17926d5850d47fc4911967e9a707cb8f81464f8404dfc41938ac335c51e4c673fbb2715b3977f2988c665b97367c0e55e0c9d8216bbe6a5\";i:1;b:1;i:2;b:1;}s:22:\"express_checkout_token\";a:3:{i:0;s:224:\"def50200f5ebe66365c021bd3d99b215ceb27c05be028ae8ebd8d41cb1a213698ed1df1c1d2842e344ede18f0889fadb40dddd9f7f5c4108dcae0227ad2dcd697222bfc2ed84b97223b8b1b2f42e1fdd58fa07e90d95c7332408945f4758cbaec42637f28c596900e1931a80e94495b0\";i:1;b:1;i:2;b:1;}s:15:\"paypal_payer_id\";a:3:{i:0;s:210:\"def5020084cf8da017489f2fa5f6fe73c5f35cc2ea4104261cb63b93d05d24b373f4be386c33d7503e927b1d13cd9841536218d2c69eeba64a3692334d54a187837436d7e9d8079e42387c03ea3c558ec6c4d503d5679c68f0b2cc550b10ebd319285c44f57ec8c97b\";i:1;b:1;i:2;b:1;}}','paypal_express_checkout',0.00000,0.00000,0.00000,4,'2017-09-13 09:13:02');
/*!40000 ALTER TABLE `payment_instructions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_instruction_id` int(11) NOT NULL,
  `approved_amount` decimal(10,5) NOT NULL,
  `approving_amount` decimal(10,5) NOT NULL,
  `credited_amount` decimal(10,5) NOT NULL,
  `crediting_amount` decimal(10,5) NOT NULL,
  `deposited_amount` decimal(10,5) NOT NULL,
  `depositing_amount` decimal(10,5) NOT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `reversing_approved_amount` decimal(10,5) NOT NULL,
  `reversing_credited_amount` decimal(10,5) NOT NULL,
  `reversing_deposited_amount` decimal(10,5) NOT NULL,
  `state` smallint(6) NOT NULL,
  `target_amount` decimal(10,5) NOT NULL,
  `attention_required` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_65D29B328789B572` (`payment_instruction_id`),
  CONSTRAINT `FK_65D29B328789B572` FOREIGN KEY (`payment_instruction_id`) REFERENCES `payment_instructions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,6,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:32:25','2017-09-12 19:32:25'),(2,6,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:32:58','2017-09-12 19:32:58'),(3,7,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:33:28','2017-09-12 19:33:28'),(4,7,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:36:21','2017-09-12 19:36:21'),(5,8,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:36:29','2017-09-12 19:36:29'),(6,9,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:38:11','2017-09-12 19:38:11'),(7,10,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:38:44','2017-09-12 19:38:44'),(8,10,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:39:04','2017-09-12 19:39:04'),(9,11,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:39:12','2017-09-12 19:39:12'),(10,11,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:42:24','2017-09-12 19:42:24'),(11,11,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:42:37','2017-09-12 19:42:37'),(12,12,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:42:56','2017-09-12 19:42:56'),(13,14,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:43:48','2017-09-12 19:43:48'),(14,14,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:44:11','2017-09-12 19:44:11'),(15,15,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,5,42.24000,0,0,'2017-09-12 19:51:42','2017-09-12 19:51:59'),(16,16,0.00000,42.24000,0.00000,0.00000,0.00000,42.24000,NULL,0.00000,0.00000,0.00000,2,42.24000,0,0,'2017-09-12 19:54:24','2017-09-12 19:54:28'),(17,17,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:58:46','2017-09-12 19:58:46'),(18,17,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,6,42.24000,0,0,'2017-09-12 19:59:17','2017-09-12 19:59:17'),(19,18,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,5,42.24000,0,0,'2017-09-12 19:59:27','2017-09-12 20:09:22'),(20,19,0.00000,42.24000,0.00000,0.00000,0.00000,42.24000,NULL,0.00000,0.00000,0.00000,2,42.24000,0,0,'2017-09-12 20:22:32','2017-09-12 20:22:34'),(21,20,42.24000,0.00000,0.00000,0.00000,42.24000,0.00000,NULL,0.00000,0.00000,0.00000,8,42.24000,0,0,'2017-09-12 20:24:36','2017-09-12 20:25:10'),(22,21,42.24000,0.00000,0.00000,0.00000,42.24000,0.00000,NULL,0.00000,0.00000,0.00000,8,42.24000,0,0,'2017-09-12 20:27:22','2017-09-12 20:27:44'),(23,21,0.00000,0.00000,0.00000,0.00000,0.00000,0.00000,NULL,0.00000,0.00000,0.00000,2,0.00000,0,0,'2017-09-12 20:28:02','2017-09-12 20:28:03'),(24,22,42.24000,0.00000,0.00000,0.00000,42.24000,0.00000,NULL,0.00000,0.00000,0.00000,8,42.24000,0,0,'2017-09-12 20:28:30','2017-09-12 20:28:47'),(25,23,0.00000,42.24000,0.00000,0.00000,0.00000,42.24000,NULL,0.00000,0.00000,0.00000,2,42.24000,0,0,'2017-09-13 04:49:11','2017-09-13 04:49:15'),(26,24,0.00000,42.24000,0.00000,0.00000,0.00000,42.24000,NULL,0.00000,0.00000,0.00000,2,42.24000,0,0,'2017-09-13 05:05:24','2017-09-13 05:05:30'),(27,25,42.24000,0.00000,0.00000,0.00000,42.24000,0.00000,NULL,0.00000,0.00000,0.00000,8,42.24000,0,0,'2017-09-13 07:30:49','2017-09-13 07:34:11'),(28,26,99.00000,0.00000,0.00000,0.00000,99.00000,0.00000,NULL,0.00000,0.00000,0.00000,8,99.00000,0,0,'2017-09-13 08:59:37','2017-09-13 09:06:27'),(29,27,99.00000,0.00000,0.00000,0.00000,99.00000,0.00000,NULL,0.00000,0.00000,0.00000,8,99.00000,0,0,'2017-09-13 09:09:59','2017-09-13 09:10:51'),(30,28,99.00000,0.00000,0.00000,0.00000,99.00000,0.00000,NULL,0.00000,0.00000,0.00000,8,99.00000,0,0,'2017-09-13 09:12:06','2017-09-13 09:13:02');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_user`
--

DROP TABLE IF EXISTS `user_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F7129A8092FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_F7129A80C05FB297` (`confirmation_token`),
  UNIQUE KEY `UNIQ_F7129A809B6B5FBA` (`account_id`),
  CONSTRAINT `FK_F7129A809B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_user`
--

LOCK TABLES `user_user` WRITE;
/*!40000 ALTER TABLE `user_user` DISABLE KEYS */;
INSERT INTO `user_user` VALUES (1,NULL,'admin','admin',1,'3UVeOVEuMdtjiEwB35cxw0xuLAzEz6G447V5K.bLFxU','gwkhsWAvnjY3ToBCBZGXhQ0ejBjR5Mr3ec66t/76vG993IPwqlFj2MNOWV+FsY8c1cW8F2QBSmoVRcR4iuN20A==',NULL,NULL,NULL,'a:0:{}','Administrator','test@test.com','test@test.com'),(2,1,'karlo@laquian.com','karlo@laquian.com',1,'eRdFRUMHHuJDQtv8j3AMtPY3fT2RnFuESYZbsCktWLg','U+vYV9M84osDBnTGUeSzvmGyaAu9udj7iqMnUkCn+t1bHHFlyQ6SVDl+8OJh6RPw1NN3uP42yy6kZZDP1pdnTg==','2017-09-13 12:09:30',NULL,NULL,'a:0:{}','Karlo Laquian','karlo@laquian.com','karlo@laquian.com'),(3,2,'tim@yap.com','tim@yap.com',1,'6giXDKFca3n5d15Qcb1TDx7.KDdxp60SRNEPtH5ua1w','xUZfKd6+xT4920n394c858DOE7gdWT3tvdIsEKnYtfONvIg89TIgnW6hJhIVsPUygb3l708Pg59tdgfE8sCbhA==','2017-07-16 19:56:43',NULL,NULL,'a:0:{}','Ashley Co Kehyeng','tim@yap.com','tim@yap.com'),(4,3,'rommel@pascual.com','rommel@pascual.com',1,'WPRsVoK3dM9SEGQjekmoVMP77FfNVdh/mFLR2GPZpxQ','kThxJP4FgTimH8D2w0jq5czmd271Ser6DmzyCpT6VbRBezSt9gHwI1yA0c/+4qIGrM22kUyrhol4oJJUOOUGzA==','2017-07-16 19:30:00',NULL,NULL,'a:0:{}','Rommel Pascual','rommel@pascual.com','rommel@pascual.com'),(5,NULL,'karlo','karlo',1,'G30E/n7uegtpp5Y0sXY/Opd0/mWBmnrFjF8Yz/mLDDQ','R2kh5gQdV74Smod3LeihJfdc4cahC9w/ou1vsdzj4vrIaXdczsBGD3CqzT0Xnc/CE7SY2OdH8nawpgyqArCZgw==',NULL,NULL,NULL,'a:0:{}',NULL,'karlo@test.com','karlo@test.com'),(6,NULL,'karlo3','karlo3',1,'AHC7yG9Sdsts2saqFjUVo7JwbV13zTT/bL2oJK1EEOM','zPco+SrL4dQft0z04Z6XNYBZDpA3SoOrCVZPLf1WxvAak6npj7m3KcJP5XeMlKib0RD9UCVYaEOdEWkLiX4nOw==',NULL,NULL,NULL,'a:0:{}',NULL,'karlo3@test.com','karlo3@test.com'),(7,4,'karlo2@laquian.com','karlo2@laquian.com',1,'Le27Yy5vO4KQLgY7AE.mGlI4TXqFJOnXZg.Mjf23al0','qoaN/ZITFWmUOqODyljpBfQHaEv0u34LlW0LQ0S3X3UGpQW/nQGUe9Eg20TK6i+YziVAKwrZIJX8yR4dOCDEKA==','2017-08-29 12:16:31',NULL,NULL,'a:0:{}','Karlo Laquian','karlo2@laquian.com','karlo2@laquian.com');
/*!40000 ALTER TABLE `user_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-13 20:54:40

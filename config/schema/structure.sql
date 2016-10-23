-- MySQL dump 10.13  Distrib 5.6.28, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: bitkiller
-- ------------------------------------------------------
-- Server version	5.6.28-0ubuntu0.15.04.1

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(6) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `extcode` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `elements_count` int(6) DEFAULT NULL,
  `exchanges_uuid` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `exchanges`
--

DROP TABLE IF EXISTS `exchanges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchanges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid_UNIQUE` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `pricetype_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `currency_id` int(6) NOT NULL,
  `product_id` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pricetypes`
--

DROP TABLE IF EXISTS `pricetypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pricetypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `extcode` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `default` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(6) NOT NULL,
  `vendor_id` int(6) DEFAULT NULL,
  `parent_id` int(6) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extcode` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `extecode` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed

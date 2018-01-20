-- MySQL dump 10.13  Distrib 5.7.15, for Linux (i686)
--
-- Host: localhost    Database: newBookShop
-- ------------------------------------------------------
-- Server version	5.7.15-0ubuntu2

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
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_name` varchar(255) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (1,'Gosha'),(3,'Толстой'),(4,'Антонов'),(5,'RRR');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `author_book`
--

DROP TABLE IF EXISTS `author_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author_book` (
  `author_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  KEY `author_id` (`author_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author_book`
--

LOCK TABLES `author_book` WRITE;
/*!40000 ALTER TABLE `author_book` DISABLE KEYS */;
INSERT INTO `author_book` VALUES (4,10),(1,13),(3,13),(3,11),(4,11),(3,0),(5,0),(3,2),(4,2),(3,14),(4,14),(3,15),(4,15),(4,16),(3,17),(4,17),(3,18),(4,18);
/*!40000 ALTER TABLE `author_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_name` varchar(255) NOT NULL,
  `book_description` tinytext,
  `book_price` float(8,2) NOT NULL,
  `book_discount_id` int(11) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (2,'rott','chot in good!',321.00,0),(10,'монстры','2017 год',120.00,0),(11,'wwwddd','qazwsxedc',123.00,8),(13,'ZZZZZ','ssss',123.00,9),(14,'eee','rrrr',123.00,0),(15,'eee','rrrr',123.00,0),(16,'eee','rrrr',123.00,0),(17,'FFF','GGG',123.00,0),(18,'FFF','GGG',123.00,8);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_order`
--

DROP TABLE IF EXISTS `book_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_order` (
  `book_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  KEY `book_id` (`book_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `book_order_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_order`
--

LOCK TABLES `book_order` WRITE;
/*!40000 ALTER TABLE `book_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `book_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `clients_id` int(11) NOT NULL AUTO_INCREMENT,
  `clients_name` varchar(255) NOT NULL,
  `clients_email` varchar(255) NOT NULL,
  `clients_phone` int(11) NOT NULL,
  `clients_discount_id` int(11) NOT NULL,
  PRIMARY KEY (`clients_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount` (
  `discount_id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_name` varchar(255) NOT NULL,
  `discount_tax` int(11) NOT NULL,
  `discount_type` tinyint(4) NOT NULL,
  PRIMARY KEY (`discount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount`
--

LOCK TABLES `discount` WRITE;
/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
INSERT INTO `discount` VALUES (8,'magento1111',12,2),(9,'sale',20,1),(10,'уценка',5,2),(11,'просрочка',20,1),(12,'qqq',10,2);
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_name` varchar(255) NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (16,'комедия'),(18,'фантастика'),(23,'роман');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre_book`
--

DROP TABLE IF EXISTS `genre_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genre_book` (
  `genre_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  KEY `genre_id` (`genre_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre_book`
--

LOCK TABLES `genre_book` WRITE;
/*!40000 ALTER TABLE `genre_book` DISABLE KEYS */;
INSERT INTO `genre_book` VALUES (18,10),(18,11),(16,15),(18,15),(23,16),(18,17);
/*!40000 ALTER TABLE `genre_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `order_data` datetime NOT NULL,
  `order_client_id` int(11) NOT NULL,
  `order_cost` float(8,2) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT '1',
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-11 15:43:37

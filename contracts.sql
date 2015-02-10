-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: contracts
-- ------------------------------------------------------
-- Server version	5.5.41-0+wheezy1

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
-- Table structure for table `currency_list`
--

DROP TABLE IF EXISTS `currency_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `currency` varchar(100) DEFAULT NULL,
  `currency_short` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_list`
--

LOCK TABLES `currency_list` WRITE;
/*!40000 ALTER TABLE `currency_list` DISABLE KEYS */;
INSERT INTO `currency_list` VALUES (1,'RUB','R'),(2,'EUR','E'),(3,'USD','U');
/*!40000 ALTER TABLE `currency_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `department_short` varchar(100) NOT NULL,
  `department_full` varchar(100) NOT NULL,
  `head_of_dpt` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (2,'ОМТС','Отдел материально-технического снабжения','Вакорин И.В.'),(4,'АПК','Аэропортово-производственный комплекс','Плацинская Л.В.'),(5,'АТБ','Авиационная-техническая база','Усачёв В.Л.');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `main`
--

DROP TABLE IF EXISTS `main`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `signed_date` date DEFAULT NULL,
  `company_name` varchar(45) DEFAULT NULL,
  `partner_address` varchar(45) DEFAULT NULL,
  `contract_subject` varchar(45) DEFAULT NULL,
  `contract_cost` varchar(45) DEFAULT NULL,
  `validity` date DEFAULT NULL,
  `cancelation_terms` varchar(45) DEFAULT NULL,
  `moved_to_archive` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main`
--

LOCK TABLES `main` WRITE;
/*!40000 ALTER TABLE `main` DISABLE KEYS */;
/*!40000 ALTER TABLE `main` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `main_journal`
--

DROP TABLE IF EXISTS `main_journal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `main_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `incoming_date` date NOT NULL,
  `contract_ex_number` varchar(45) DEFAULT NULL,
  `contract_int_number` varchar(255) NOT NULL,
  `contract_subject` varchar(255) NOT NULL,
  `contract_cost` decimal(10,2) NOT NULL,
  `contract_date` date NOT NULL,
  `department_short` varchar(45) DEFAULT NULL,
  `send_to_sign` bit(1) DEFAULT NULL,
  `signed` tinyint(1) DEFAULT '0',
  `currency` varchar(100) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `type_of_contract` varchar(100) DEFAULT NULL,
  `validity` varchar(10) DEFAULT NULL,
  `cancelation_term` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_journal`
--

LOCK TABLES `main_journal` WRITE;
/*!40000 ALTER TABLE `main_journal` DISABLE KEYS */;
INSERT INTO `main_journal` VALUES (7,'2015-02-09','1234','123','Поставка АТИ согласно спецификации к договору',99000.00,'2015-01-01','АТБ','\0',0,'RUB','ОАО \"РЗГА 412\"','Расходный','31.12.2015','По соглашению сторон');
/*!40000 ALTER TABLE `main_journal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner_types`
--

DROP TABLE IF EXISTS `partner_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_types` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `type_of_partner` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_types`
--

LOCK TABLES `partner_types` WRITE;
/*!40000 ALTER TABLE `partner_types` DISABLE KEYS */;
INSERT INTO `partner_types` VALUES (1,'Поставщик'),(2,'Заказчик'),(3,'Покупатель');
/*!40000 ALTER TABLE `partner_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `ceo` varchar(45) NOT NULL,
  `building` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `postcode` decimal(65,0) NOT NULL,
  `city` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  `type_of_partner` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (2,'ОАО \"РЗГА 412\"','8(863)255-76-76','Коблин Мухадин Щахимович','282','--',344009,'г. Ростов-на-Дону','пр. Шолохова','Ростовская область','Поставщик'),(5,'ЗАО \"Авиафарм\"','34423423','апапвап','1','',195000,'','',NULL,'Заказчик'),(6,'ЗАО \"Технотрейд\"','8(495)708-48-00','Не указан','70 стр.2 ','Не указан',109052,'Москва','ул. Нижегородская',NULL,'Поставщик');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types_of_contract`
--

DROP TABLE IF EXISTS `types_of_contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types_of_contract` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type_of_contract` varchar(100) DEFAULT NULL,
  `short_type_of_contract` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types_of_contract`
--

LOCK TABLES `types_of_contract` WRITE;
/*!40000 ALTER TABLE `types_of_contract` DISABLE KEYS */;
INSERT INTO `types_of_contract` VALUES (1,'Доходный','Д'),(2,'Расходный','Р'),(3,'Не применимо','Н');
/*!40000 ALTER TABLE `types_of_contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `validity_data`
--

DROP TABLE IF EXISTS `validity_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validity_data` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `validity` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `validity_data`
--

LOCK TABLES `validity_data` WRITE;
/*!40000 ALTER TABLE `validity_data` DISABLE KEYS */;
INSERT INTO `validity_data` VALUES (1,'До исполнения обязательств');
/*!40000 ALTER TABLE `validity_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-02-10 17:22:57

-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dsw2_fakedex
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.7-MariaDB-1:10.6.7+maria~focal

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `creature`
--

DROP TABLE IF EXISTS `creature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `creature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `id_type1` int(11) DEFAULT NULL,
  `id_type2` int(11) DEFAULT NULL,
  `hp` int(11) DEFAULT 0,
  `atk` int(11) DEFAULT 0,
  `def` int(11) DEFAULT 0,
  `sp_atk` int(11) DEFAULT 0,
  `sp_def` int(11) DEFAULT 0,
  `speed` int(11) DEFAULT 0,
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creature_FK` (`id_type1`),
  KEY `creature_FK_1` (`id_type2`),
  CONSTRAINT `creature_FK` FOREIGN KEY (`id_type1`) REFERENCES `type` (`id`),
  CONSTRAINT `creature_FK_1` FOREIGN KEY (`id_type2`) REFERENCES `type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `creature`
--

LOCK TABLES `creature` WRITE;
/*!40000 ALTER TABLE `creature` DISABLE KEYS */;
INSERT INTO `creature` VALUES (1,'Léviathan',4,17,500,240,150,100,100,25,'Monstre mythologique des océans qui a détruit l\'Atlantide selon la légende.'),(5,'Ostreo',10,1,50,24,15,10,10,250,'sdafsdafsdafdsfa.');
/*!40000 ALTER TABLE `creature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_UN` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (18,'Acier'),(1,'Aucun'),(8,'Combat'),(16,'Dragon'),(4,'Eau'),(6,'Électrique'),(19,'Fée'),(3,'Feu'),(7,'Glace'),(13,'Insecte'),(2,'Normal'),(5,'Plante'),(9,'Poison'),(12,'Psy'),(14,'Roche'),(10,'Sol'),(15,'Spectre'),(17,'Ténèbre'),(11,'Vol');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usager`
--

DROP TABLE IF EXISTS `usager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `api_key` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usager_UN` (`username`,`api_key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usager`
--

LOCK TABLES `usager` WRITE;
/*!40000 ALTER TABLE `usager` DISABLE KEYS */;
INSERT INTO `usager` VALUES (1,'admin','$2y$10$PTcjxP47PlQQ9DvAQKMcA.M2dTRCbcbimSsYLMFqE.IFIqsxwDU4C','5a72df75-4651-4baf-b17a-9ee326fd8a11');
/*!40000 ALTER TABLE `usager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'dsw2_fakedex'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-24 12:24:28

-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: 164.132.225.184    Database: outsmart
-- ------------------------------------------------------
-- Server version	5.5.5-10.5.15-MariaDB-0+deb11u1

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
-- Table structure for table `collection`
--

DROP TABLE IF EXISTS `collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collection` (
  `id_utilisateur` int(11) NOT NULL,
  `id_skin` int(11) NOT NULL,
  `actif` int(11) DEFAULT 0,
  PRIMARY KEY (`id_utilisateur`,`id_skin`),
  KEY `id_skin` (`id_skin`),
  CONSTRAINT `collection_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `collection_ibfk_2` FOREIGN KEY (`id_skin`) REFERENCES `skins` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collection`
--

LOCK TABLES `collection` WRITE;
/*!40000 ALTER TABLE `collection` DISABLE KEYS */;
INSERT INTO `collection` VALUES (0,167,1),(0,173,1),(0,187,1),(0,196,1),(1,171,1),(1,176,1),(1,184,0),(1,185,1),(1,186,0),(1,194,1),(1,196,1),(1,202,1),(1,208,1),(1,210,0),(1,211,0),(1,213,0),(1,214,0),(1,217,1),(1,221,0),(1,224,0),(1,232,0),(1,235,0),(1,236,0),(1,237,0),(1,238,0),(1,239,0),(1,240,0),(1,241,0),(1,242,0),(1,243,0),(1,244,0),(1,245,0),(1,246,0),(1,247,0),(1,248,0),(1,249,0),(1,250,0),(3,167,1),(3,173,1),(3,187,1),(3,196,1),(4,170,1),(4,175,1),(4,184,1),(4,187,1),(4,196,1),(4,228,1),(4,249,1),(4,250,0),(7,167,1),(7,173,1),(7,187,1),(7,196,1),(7,214,0),(7,233,0),(7,234,0),(7,238,0),(7,249,1),(7,250,0),(8,168,1),(8,178,1),(8,185,0),(8,187,1),(8,199,1),(8,201,1),(8,211,0),(8,223,1),(8,237,1),(9,171,1),(9,176,1),(9,184,1),(9,194,1),(9,200,1),(9,205,1),(9,208,1),(9,211,0),(9,212,0),(9,223,1),(9,240,0),(9,248,0),(9,249,1),(9,250,0),(12,167,1),(12,176,1),(12,189,1),(12,198,1),(12,208,0),(12,214,1),(12,215,0),(12,234,1),(12,249,0),(12,250,0),(13,169,1),(13,174,1),(13,186,1),(13,188,1),(13,200,1),(13,208,1),(13,227,1),(14,171,1),(14,177,1),(14,184,1),(14,194,1),(14,196,1),(14,203,1),(14,210,1),(14,216,1),(15,167,1),(15,173,1),(15,187,1),(15,196,1),(18,167,1),(18,173,1),(18,187,1),(18,196,1),(19,171,1),(19,181,1),(19,186,1),(19,187,1),(19,199,1),(22,170,1),(22,175,1),(22,184,0),(22,186,1),(22,189,1),(22,199,1),(22,204,1),(22,227,1),(22,235,0),(22,237,1),(23,167,1),(23,173,1),(23,187,1),(23,196,1),(25,167,1),(25,173,1),(25,186,1),(25,187,1),(25,196,1),(25,208,1),(25,216,1);
/*!40000 ALTER TABLE `collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contient_theme`
--

DROP TABLE IF EXISTS `contient_theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contient_theme` (
  `session` int(11) NOT NULL,
  `theme` char(3) NOT NULL,
  PRIMARY KEY (`session`,`theme`),
  KEY `theme` (`theme`),
  CONSTRAINT `contient_theme_ibfk_1` FOREIGN KEY (`session`) REFERENCES `session` (`id`),
  CONSTRAINT `contient_theme_ibfk_2` FOREIGN KEY (`theme`) REFERENCES `theme` (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contient_theme`
--

LOCK TABLES `contient_theme` WRITE;
/*!40000 ALTER TABLE `contient_theme` DISABLE KEYS */;
/*!40000 ALTER TABLE `contient_theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demande_amis`
--

DROP TABLE IF EXISTS `demande_amis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demande_amis` (
  `id_envoie` int(11) NOT NULL,
  `id_recoit` int(11) NOT NULL,
  `accepte` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_envoie`,`id_recoit`),
  KEY `id_recoit` (`id_recoit`),
  CONSTRAINT `demande_amis_ibfk_1` FOREIGN KEY (`id_envoie`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `demande_amis_ibfk_2` FOREIGN KEY (`id_recoit`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demande_amis`
--

LOCK TABLES `demande_amis` WRITE;
/*!40000 ALTER TABLE `demande_amis` DISABLE KEYS */;
INSERT INTO `demande_amis` VALUES (1,12,1),(9,12,1),(13,3,0),(13,4,1),(13,7,0),(13,12,1),(14,4,1),(14,15,1),(15,4,1),(18,14,0),(19,4,0),(22,24,1);
/*!40000 ALTER TABLE `demande_amis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `envoie_message`
--

DROP TABLE IF EXISTS `envoie_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `envoie_message` (
  `id_envoie` int(11) DEFAULT NULL,
  `id_recoit` int(11) DEFAULT NULL,
  `date_envoie` datetime DEFAULT NULL,
  `contenue` text DEFAULT NULL,
  `vue` int(11) DEFAULT 0,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `id_envoie` (`id_envoie`),
  KEY `id_recoit` (`id_recoit`),
  CONSTRAINT `envoie_message_ibfk_1` FOREIGN KEY (`id_envoie`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `envoie_message_ibfk_2` FOREIGN KEY (`id_recoit`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `envoie_message`
--

LOCK TABLES `envoie_message` WRITE;
/*!40000 ALTER TABLE `envoie_message` DISABLE KEYS */;
INSERT INTO `envoie_message` VALUES (13,4,'2022-04-27 08:30:19','kjeql',1,129),(13,4,'2022-04-27 08:30:29','ca va ',1,130),(4,13,'2022-04-27 08:30:37','non',1,131),(13,4,'2022-04-27 09:27:24','JIZQLJK%MDQ',1,132),(4,13,'2022-04-27 14:28:16','T\'as pas encore fini',0,133),(4,14,'2022-04-28 07:58:07','CV\n',1,134),(14,4,'2022-04-28 07:59:41','Je vais très bien merci de m\'avoir contacter\n ',1,135),(4,14,'2022-04-28 07:59:43','Tant mieux alors',1,136),(14,4,'2022-04-28 07:59:51','HAHAHAHAAH',1,137),(14,15,'2022-04-28 09:04:33','Lait noix on laitue\n',1,138),(12,1,'2022-05-05 16:40:00','coucou\n',1,139),(1,12,'2022-05-05 16:45:18','       ‎‎‎⣠⣤⣤⣤⣤⣤⣄⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀\n ⠀⠀⠀⠀⠀⢰⡿⠋⠁⠀⠀⠈⠉⠙⠻⣷⣄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ \n ⠀⠀⠀⠀⢀⣿⠇⠀⢀⣴⣶⡾⠿⠿⠿⢿⣿⣦⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ \n ⠀⠀⣀⣀⣸⡿⠀⠀⢸⣿⣇⠀⠀⠀⠀⠀⠀⠙⣷⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ \n ⠀⣾⡟⠛⣿⡇⠀⠀⢸⣿⣿⣷⣤⣤⣤⣤⣶⣶⣿⠇⠀⠀⠀⠀⠀⠀⠀⣀⠀⠀ \n ⢀⣿⠀⢀⣿⡇⠀⠀⠀⠻⢿⣿⣿⣿⣿⣿⠿⣿⡏⠀⠀⠀⠀⢴⣶⣶⣿⣿⣿⣆ \n ⢸⣿⠀⢸⣿⡇⠀⠀⠀⠀⠀⠈⠉⠁⠀⠀⠀⣿⡇⣀⣠⣴⣾⣮⣝⠿⠿⠿⣻⡟ \n ⢸⣿⠀⠘⣿⡇⠀⠀⠀⠀⠀⠀⠀⣠⣶⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠁⠉⠀ \n ⠸⣿⠀⠀⣿⡇⠀⠀⠀⠀⠀⣠⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠟⠉⠀⠀⠀⠀ ⠀\n  ⠻⣷⣶⣿⣇⠀⠀⠀⢠⣼⣿⣿⣿⣿⣿⣿⣿⣛⣛⣻⠉⠁⠀⠀⠀⠀⠀⠀⠀ ⠀⠀⠀⠀ \n     ⢸⣿⠀⠀⠀⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠀⠀⠀⠀⠀ ⠀⠀ ⠀⠀⠀⠀\n     ⢸⣿⣀⣀⣀⣼⡿⢿⣿⣿⣿⣿⣿⡿⣿⣿⡿⠀',1,140),(24,22,'2022-05-06 08:30:29','Salut mec ',1,141),(24,22,'2022-05-06 08:30:43','Comment on hash un mdp?',1,142),(22,24,'2022-05-06 08:30:46','Yo mek tu fé 1v1 ?',1,143);
/*!40000 ALTER TABLE `envoie_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `est_ami`
--

DROP TABLE IF EXISTS `est_ami`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `est_ami` (
  `ami1` int(11) NOT NULL,
  `ami2` int(11) NOT NULL,
  `date_ajout` datetime DEFAULT NULL,
  `bloque` int(11) DEFAULT 0,
  PRIMARY KEY (`ami1`,`ami2`),
  KEY `ami2` (`ami2`),
  CONSTRAINT `est_ami_ibfk_1` FOREIGN KEY (`ami1`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `est_ami_ibfk_2` FOREIGN KEY (`ami2`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `est_ami`
--

LOCK TABLES `est_ami` WRITE;
/*!40000 ALTER TABLE `est_ami` DISABLE KEYS */;
INSERT INTO `est_ami` VALUES (1,12,'2022-05-05 16:37:50',0),(9,12,'2022-05-06 11:29:31',0),(13,4,'2022-04-27 08:29:56',0),(13,12,'2022-05-05 16:37:51',0),(14,4,'2022-04-28 07:57:53',0),(14,15,'2022-04-28 09:03:59',0),(15,4,'2022-04-28 09:03:08',0),(22,24,'2022-05-06 08:30:16',0);
/*!40000 ALTER TABLE `est_ami` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `joue_partie`
--

DROP TABLE IF EXISTS `joue_partie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `joue_partie` (
  `joueur` int(11) NOT NULL,
  `partie` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `a_gagne` int(11) DEFAULT 0,
  `finis` int(11) DEFAULT 0,
  PRIMARY KEY (`joueur`,`partie`),
  KEY `partie` (`partie`),
  CONSTRAINT `joue_partie_ibfk_1` FOREIGN KEY (`joueur`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `joue_partie_ibfk_2` FOREIGN KEY (`partie`) REFERENCES `partie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joue_partie`
--

LOCK TABLES `joue_partie` WRITE;
/*!40000 ALTER TABLE `joue_partie` DISABLE KEYS */;
INSERT INTO `joue_partie` VALUES (12,437,0,0,1),(12,438,12,1,1),(23,437,8,1,1),(23,438,8,0,1);
/*!40000 ALTER TABLE `joue_partie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_forum`
--

DROP TABLE IF EXISTS `message_forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_forum` (
  `auteur` int(11) DEFAULT NULL,
  `topic` int(11) DEFAULT NULL,
  `date_envoie` datetime DEFAULT NULL,
  `contenue` text DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `auteur` (`auteur`),
  KEY `topic` (`topic`),
  CONSTRAINT `message_forum_ibfk_1` FOREIGN KEY (`auteur`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `message_forum_ibfk_2` FOREIGN KEY (`topic`) REFERENCES `topic` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_forum`
--

LOCK TABLES `message_forum` WRITE;
/*!40000 ALTER TABLE `message_forum` DISABLE KEYS */;
INSERT INTO `message_forum` VALUES (3,4,'2022-04-24 20:54:17','super topic',16),(7,7,'2022-04-26 06:16:45','bien dit ça',20),(8,7,'2022-04-26 13:44:02','c\'est intolérable ',23),(8,7,'2022-04-26 13:44:10','moi je suis pour ',24),(8,4,'2022-04-26 13:55:05','waouw c\'est beau ',25),(8,8,'2022-04-26 13:56:25','je suis entièrement d\'accord',29),(7,8,'2022-04-26 13:58:02','merci faisons avancer les choses !',30),(12,8,'2022-04-26 22:14:21','Faites gaffe à ce que vous dites ',31),(4,7,'2022-05-01 11:00:15','Vous tous bizarre ',39),(12,10,'2022-05-01 11:35:12','????',40),(1,7,'2022-05-05 16:38:48','je suis pour, il faut enlever ces noirs et ces arabes de notre beau pays !!!!',41),(1,8,'2022-05-05 16:39:13','REVOLUTION !!!!!!!!!',42),(1,10,'2022-05-05 16:39:53','Enfin le printemps, nous pouvons profiter de nos beaux arbres avec leurs belles fleurs !!',43),(1,4,'2022-05-05 16:40:01','Mon topic !!',44),(1,7,'2022-05-05 16:41:28','       ‎‎‎⣠⣤⣤⣤⣤⣤⣄⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀\r\n ⠀⠀⠀⠀⠀⢰⡿⠋⠁⠀⠀⠈⠉⠙⠻⣷⣄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ \r\n ⠀⠀⠀⠀⢀⣿⠇⠀⢀⣴⣶⡾⠿⠿⠿⢿⣿⣦⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ \r\n ⠀⠀⣀⣀⣸⡿⠀⠀⢸⣿⣇⠀⠀⠀⠀⠀⠀⠙⣷⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ \r\n ⠀⣾⡟⠛⣿⡇⠀⠀⢸⣿⣿⣷⣤⣤⣤⣤⣶⣶⣿⠇⠀⠀⠀⠀⠀⠀⠀⣀⠀⠀ \r\n ⢀⣿⠀⢀⣿⡇⠀⠀⠀⠻⢿⣿⣿⣿⣿⣿⠿⣿⡏⠀⠀⠀⠀⢴⣶⣶⣿⣿⣿⣆ \r\n ⢸⣿⠀⢸⣿⡇⠀⠀⠀⠀⠀⠈⠉⠁⠀⠀⠀⣿⡇⣀⣠⣴⣾⣮⣝⠿⠿⠿⣻⡟ \r\n ⢸⣿⠀⠘⣿⡇⠀⠀⠀⠀⠀⠀⠀⣠⣶⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠁⠉⠀ \r\n ⠸⣿⠀⠀⣿⡇⠀⠀⠀⠀⠀⣠⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠟⠉⠀⠀⠀⠀ ⠀\r\n  ⠻⣷⣶⣿⣇⠀⠀⠀⢠⣼⣿⣿⣿⣿⣿⣿⣿⣛⣛⣻⠉⠁⠀⠀⠀⠀⠀⠀⠀ ⠀⠀⠀⠀ \r\n     ⢸⣿⠀⠀⠀⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠀⠀⠀⠀⠀ ⠀⠀ ⠀⠀⠀⠀\r\n     ⢸⣿⣀⣀⣀⣼⡿⢿⣿⣿⣿⣿⣿⡿⣿⣿⡿⠀',45),(9,8,'2022-05-06 11:30:24','Je suis pour !!!',46),(22,13,'2022-05-07 17:34:56','bonjour',47),(22,13,'2022-05-07 17:35:05','blabalbalabalabal',48),(24,7,'2022-05-08 13:07:23','Franchement jsuis pour',49);
/*!40000 ALTER TABLE `message_forum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note` (
  `note` int(11) DEFAULT NULL CHECK (`note` between 0 and 5),
  `utilisateur` int(11) DEFAULT NULL,
  `theme` char(3) DEFAULT NULL,
  KEY `utilisateur` (`utilisateur`),
  KEY `theme` (`theme`),
  CONSTRAINT `note_ibfk_1` FOREIGN KEY (`utilisateur`) REFERENCES `utilisateurs` (`id`),
  CONSTRAINT `note_ibfk_2` FOREIGN KEY (`theme`) REFERENCES `theme` (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note`
--

LOCK TABLES `note` WRITE;
/*!40000 ALTER TABLE `note` DISABLE KEYS */;
/*!40000 ALTER TABLE `note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partie`
--

DROP TABLE IF EXISTS `partie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session` int(11) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session` (`session`),
  CONSTRAINT `partie_ibfk_1` FOREIGN KEY (`session`) REFERENCES `session` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=439 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partie`
--

LOCK TABLES `partie` WRITE;
/*!40000 ALTER TABLE `partie` DISABLE KEYS */;
INSERT INTO `partie` VALUES (437,501,1),(438,509,1);
/*!40000 ALTER TABLE `partie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partie_q`
--

DROP TABLE IF EXISTS `partie_q`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partie_q` (
  `partie` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `statut` int(11) DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  `debut` varchar(15) DEFAULT NULL,
  `enclenche` int(11) DEFAULT 0,
  PRIMARY KEY (`partie`,`question`),
  KEY `question` (`question`),
  CONSTRAINT `partie_q_ibfk_1` FOREIGN KEY (`partie`) REFERENCES `partie` (`id`),
  CONSTRAINT `partie_q_ibfk_2` FOREIGN KEY (`question`) REFERENCES `question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partie_q`
--

LOCK TABLES `partie_q` WRITE;
/*!40000 ALTER TABLE `partie_q` DISABLE KEYS */;
/*!40000 ALTER TABLE `partie_q` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(160) DEFAULT NULL,
  `b_rep` varchar(60) DEFAULT NULL,
  `rep2` varchar(60) DEFAULT NULL,
  `rep3` varchar(60) DEFAULT NULL,
  `rep4` varchar(60) DEFAULT NULL,
  `type` char(1) DEFAULT NULL,
  `image` varchar(20) DEFAULT NULL,
  `audio` varchar(20) DEFAULT NULL,
  `theme` char(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `theme` (`theme`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`theme`) REFERENCES `theme` (`numero`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'Dans la série animé les Ratz, qui sont les deux personnages principaux ?','Razmo Et Rapido','Rasmo et Ratido','Razmo et Finito','Rasmo et Parido','c',NULL,NULL,'des'),(2,'Quel est le jour détésté par Garfield ?','Lundi','Vendredi','Dimanche','Jeudi','c',NULL,NULL,'des'),(3,'Comment s\'apelle le camion dans Scooby-Doo ?','Mystery Machine','Ghost Bus','SchoobyBus','Detective Car','c',NULL,NULL,'des'),(4,'A quel dessin animé appartient ce personnage ?','Bob l\'éponge','Ma famille pirate','Les zinzins de l\'espace','Corneille et Bernie','i','img-4',NULL,'des'),(5,'Qui est le plus grand des Daltons ?','Averell','Joe','William','Jack','c',NULL,NULL,'des'),(6,'Qui est ce personnage de tortue ninja ?','Splinter','Shredder','Donatelo','Krang','i','img-6',NULL,'des'),(7,'Dans le déssin animé ma famille pirate, quel est le nom de l\'île sur laquelle vivent la famille ?','L’île de la tortue','L’ile de la piraterie','L’ile de la sirene','L\'île mangalot','c',NULL,NULL,'des'),(8,'Dans Le dessin animé Phinéas et Ferb, que se passe-t\'il quand Penny l\'ornythorinque croise le professeur Doofenshmirtz ?','Il se fait enfermer','Ils se battent','Ils rigolent','Il l\'arrête','i','img-8',NULL,'des'),(9,'Dans la série animé La cour de récrée, pour quel raison est réputé le personnage Randall ?','C\'est un rapporteur','Il n\'arrête pas de pleurer','Il tombe tout le temps','Il n\'arrête pas de se perdre','c',NULL,NULL,'des'),(10,'Dans le dessin animé Titeuf, Quel est le nom de ce personnage ?','François','Thibault','Manu','Hugo','i','img-10',NULL,'des'),(11,'Dans la série \"Les Simpsons\", dans quel endroit travaille Homer ?','Une centrale nucléaire','Un magasin de donut','Un bar','Un parc d\'attraction','c',NULL,NULL,'des'),(12,'De quel dessin animé vient cet extrait de générique ?','Marsupilami','Safari Trip','Famille de la jungle','Les as de la jungle','a',NULL,'a-1','des'),(13,'Quel dessin animé n\'est pas francophone ?','Oui-Oui','Totally Spies','Martin Mystère','Galactic Football','c',NULL,NULL,'des'),(14,'Quel est le dessin animé correspondant à cet conversation ?','Corneil Et Bernie','Phinéas Et Ferb','Tortues ninja','Iron-Man','a',NULL,'a-2','des'),(15,'En quel année est sortie le film d\'animation WALL-E','2008','2010','2013','2015','i','img-11',NULL,'des'),(16,'Compléter cette phrase provenant d\'un générique de dessin animé : Pas de panique à bord ...','Le fun et la vitesse d\'abord','Quand il n\'y en a plus il y en a encore','Creuse et tu trouvera une mine d\'or','Je suis igor le dinosaure','',NULL,NULL,'des'),(17,'Quel film d\'animation a fait le plus de vente dans l\'histoire du box-office ?','Le roi lion','La Reine des neiges','Les indestructibles','Toy Story','c',NULL,NULL,'des'),(18,'Parmis ces films d\'animation, lequel n\'a pas remporté d\'oscars','Moi moche et méchant','Ratatouille','Zootopie','Rebelle','c',NULL,NULL,'des'),(19,'Dans Kung fu panda, quel est le nom de la prise qui permet à Po de gagner face à son dernier advérsaire ?','La prise de doigt Wuxi','La tornade de Konoha','La technique de la Grue','Milles et une souffrances','i','img-12',NULL,'des'),(20,'Quel est le premier film réalisé par Disney ?','Blanche neige','Peter pan','Pinnochio','Alice au pays des merveilles','c',NULL,NULL,'des'),(21,'Quel est le nom de ce personnage provenant de Monstres & Cie','Bouh','Panny','Fanny','gougou','i','img-13',NULL,'des'),(23,'En quelle année est mort François Ferdinand ?','1914','1912','1918','1915','c',NULL,NULL,'cul'),(25,'Parmis ces noms,lequel n\'est pas un dieu nordique ?','Ares','Odin','Loki','Idun','c',NULL,NULL,'cul'),(26,'En quel année l\'homme a-t\'il posé les pieds pour la première fois sur la lune ?','1972','1969','1843','1974','c',NULL,NULL,'cul'),(27,'Socrate était un : ','Philosophe','Anarchiste','Poète','Prêtre','i','img-14',NULL,'cul'),(28,'De quel pays Fidel Castro était il le président ?','Cuba','France','Paraguay','Bolivie','c',NULL,NULL,'cul'),(29,'Quel instrument fait partie de la famille des cuivre ?','Cimbasso','Piano','Orgue','Clarinette','c',NULL,NULL,'cul'),(35,'Quel est cet ingrédient ?','Gingembre','Patate Douce','Galanga','Ecorce de baobab','i','img-16',NULL,'cui'),(37,'Combien de temps prend un oeuf à la coque à cuire ?','3min','1min30','12min','6min','c',NULL,NULL,'cui'),(38,'Quel est la plus longue rivière d\'Europe ?','La Volga','Le Rhin','Le Danube','Le Dniepr','c',NULL,NULL,'geo'),(41,'Ou se situe le temple d\'Hatchepsout ?','En Egypte','En Turquie','En Russie','Au Botswana','c',NULL,NULL,'geo'),(42,'Quel est le plus petit etat d\'Europe ?','Vatican','Andorre','Monaco','Luxembourg','c',NULL,NULL,'geo'),(43,'Dans quel continent se situe l\'Erythrée ?','Afrique','Asie','Amérique du sud','Europe','c',NULL,NULL,'geo'),(45,'Quel est la plus haute montagne du système solaire ?','Olympus Mons','Everest','Boösaule Montes','Mont Huygens','c',NULL,NULL,'geo'),(47,'Quel nom porte la capitale du Togo ?','Lomé','Guérin-Kouka','Amodoukouté','Sodoké','c',NULL,NULL,'geo'),(51,'Quel est la capitale de l\'aviation civile internationale ?','Montréal','Toulouse','Bruxelle','Berlin','i','img-17',NULL,'geo'),(52,'Quel est ce pays ?','Mongolie','Khazakstan','Pakistan','Népal','i','img-18',NULL,'geo'),(53,'Quel livre a été écrit par Sun Tzu ?','L\'art de la guerre','L\'apogée','La montagne de l\'âme','3 oiseaux seuls','c',NULL,NULL,'cul'),(54,'Combien de temps a durée la guerre de Cent Ans ?','116 ans','100 ans','134 ans','97 ans','c',NULL,NULL,'his'),(55,'Qui est le premier empereur romain ?','Auguste','Caligula','Tibère','Néron','c',NULL,NULL,'his'),(56,'A quand remonte l\'éxécution de LOUIS XVI ?','1793','1648','1724','1789','c',NULL,NULL,'his'),(57,'Parmis ces personnes, qui n\'a pas participé à l\'assassinat de Jules César ?','Titius Vestricius Spurinna','Cauis Cassius Longinus','Decimus Junius Brutus Albinus','Marcus Junius Brutus','c',NULL,NULL,'his'),(58,'Quel est ce château français ?','Chenonceau','Versailles','Chambord','Fontainebleau','i','img-19',NULL,'his'),(59,'Quel est le président français précèdant Georges Pompidou ?','Charles de Gaulle','François Mitterand','Valéry Giscard d\'Estaing','Jacques Chirac','c',NULL,NULL,'his'),(60,'Quel civilisation a construite le Machu Picchu ?','Les incas','Les mayas','Les Aztèques','Les olmèques','i','img-20',NULL,'his'),(61,'Parmis ces villes, laquelle ne fût pas grecque ?','Pompéi','Athènes','Alexandrie','Sparte','c',NULL,NULL,'his'),(62,'Quel année marque la fin de l\'antiquité ?','476 après J.C','675 après J.C','-251 avant J.C','0','c',NULL,NULL,'his'),(63,'Ou à eu lieu l\'éxécution de Louis XVI ?','Concorde','République','Bastille','Vendôme','c',NULL,NULL,'his'),(64,'Qui a donné la formule : E = mc^2 ?','Einstein','Tesla','Galilée','Newton','c',NULL,NULL,'sci'),(67,'Quel est la vitesse de la lumière ?','3*10^8 m/s','3+10^8 m/s','3*10*8 m/s','6 km/s','c',NULL,NULL,'sci'),(68,'Quel est la vitesse du son ?','340 m/s','350 m/s','260 m/s','2000 m/s','c',NULL,NULL,'sci'),(69,'Quel est ce matériau ?','Titanium','Adamantium','Metal','Kryptonite','i','img-21',NULL,'sci'),(70,'Quel est la différence entre un fruit et un légume ?','Le fruit vient d\'une fleur','Le fruit vient d\'un arbre','Le légume est salé','Le légume vient de la Terre','c',NULL,NULL,'sci'),(73,'Quel est cet élément du tableau périodique ?','Azote','Nitrate','Aluminium','Nickel','i','img-22',NULL,'sci'),(74,'Combien y a-t-il d\'octet dans un bit ?','8','16','1016','1','c',NULL,NULL,'sci'),(75,'Combien y a-t-il d\'os dans le corps humain ?','206','178','76','243','c',NULL,NULL,'sci'),(76,'Résoudre l\'équation : 2x * 4 = 12','1,5','3','2','Impossible','c',NULL,NULL,'sci'),(77,'Les naans sont cuits dans des','Tandoor','micro-ondes','Poêles','Four dragons','i','img-15',NULL,'cui'),(78,'Le Takati est une préparation :','Japonaise','Coréene','Chinoise','Thaïlandaise','c',NULL,NULL,'cui'),(79,'Quel est le jour le plus long dans une année ?','22 juin','17 mai','13 juillet','2 août','c',NULL,NULL,'cul'),(80,'Quel est le jour le plus long dans une année ?','22 juin','17 mai','13 juillet','2 août','c',NULL,NULL,'cul'),(81,'Quel est le jour le plus long dans une année ?','22 juin','17 mai','13 juillet','2 août','c',NULL,NULL,'cul'),(82,'En quel année est sortie le film Titanic ?','1997','1992','1978','1984','c',NULL,NULL,'cin'),(83,'Qui a remporté le ballon d\'or en 2021 ?','Messi','Modric','Ronaldo','Mbappe','c',NULL,NULL,'spo'),(84,'Quel pays a été le plus médaillé aux JO Beijing 2022','Allemagne','Autriche','France','Canada','c',NULL,NULL,'spo'),(85,'Que produit la photosynthèse ?','O2','H2O','CO2','HO2','i','img-23',NULL,'sci'),(86,'Combien y\'a t\'il de pays dans le monde reconnus par l\'ONU ?','195','203','164','206','c',NULL,NULL,'geo'),(87,'Parmis ces langues, laquelle n\'est pas officiel en Belgique ?','Belge','Français','Allemand','Néerlandais','c',NULL,NULL,'cul'),(88,'Quel est ce pays ?','Belgique','Luxembourg','Autriche','Suisse','i','img-24',NULL,'geo'),(89,'Comment appelle-t-on ce couteau en cuisine ?','Désosseur','Eminceur','Bec d\'oiseau','Couteau d\'office','i','img-25',NULL,'cui'),(90,'Quel est cette recette ?','Houmous','Amlou','Prouchka','Chorba','i','img-26',NULL,'cui'),(91,'Quel est le nom de ce piment','Habanero','Cayenne','Jalapeno','Arbol','i','img-27',NULL,'cui'),(92,'Quel est l\'ingrédient principale du guacamole ?','Avocat','Pois chiche','Lait','Beurre de cacahuète','c',NULL,NULL,'cui'),(93,'Parmis ces plats, lequel n\'est pas Mexicain ?','Tortilla','Tortillas','Tamales','Quesadilla','c',NULL,NULL,'cui'),(94,'Parmi ces légumes, lesquels n\'apparaissent pas dans la salade niçoise ?','Haricot vert','Tomate','Poivron','Oignon rouge','c',NULL,NULL,'cui'),(95,'Parmi ces films, dans lequel n\'a pas joué Morgan Freeman ?','Inglorious Bastards','Oblivion','Seven','Insaisissables','c',NULL,NULL,'cin'),(97,'Combien de films composent la saga Star Wars ?','12','11','9','7','i','img-28',NULL,'cin'),(98,'Quel acteur/actrice ne figure pas dans Once Upon A Time.. in Hollywood ?','George Cloney','Brad Pitt','Leonardo DiCaprio','Margot Robbie','c',NULL,NULL,'cin'),(99,'Parmi ces films, lequel a remporté plus de 10 oscars ?','West Side Story','Les évadés','Amadeus','Harry Potter 1','c',NULL,NULL,'cin'),(100,'Dans Forest Gump, Bubba est un spécialiste des','Crevettes','Voitures','Insectes','Tours de magies','i','img-29',NULL,'cin'),(101,'Dans quel film Edouard Baer fait son célèbre monologue ?','Mission Cléopâtre','Intouchable','3000 lieux sous les mers','Le bon la brute et le truand','c',NULL,NULL,'cin'),(102,'En quelle année est apparu le premier film en couleur ?','1901','1923','1893','1942','c',NULL,NULL,'cin'),(103,'De quel film vient cette image ?','Pulp Fiction','Inglourious Bastards','Reservoir Dogs','Sin City','i','img-30',NULL,'cin'),(104,'De quel film provient cette image ?','Ocean\'s Eleven','Insaisissables','Braquage à main armée','Pour quelques dollars de plus','i','img-31',NULL,'cin'),(107,'Combien de temps a duré le record du monde du 100 m ?','9.58 s','9.53 s','9.68 s','9.63 s','c',NULL,NULL,'spo'),(108,'Qui est l\'actuel champion du monde poid lourd de la WBC','Tyson Fury','Oleksandr Usyk','Floyd Mayweather','Joe Frazier','c',NULL,NULL,'spo'),(109,'Quel est la longueur d\'une piscine olympique ?','25 m','50 m','100 m','75 m','c',NULL,NULL,'spo'),(110,'Combien de coupes du monde ont remporté le brésil ?','5','4','6','7','c',NULL,NULL,'spo'),(111,'Zlatan Ibrahimovic est un joueur de foot :','Suédois','Serbe','Croate','Norvégiens','i','img-32',NULL,'spo'),(112,'Quel adversaire affronte Mohamed Ali le 8 mars 1971 à New York ?','Joe Frazier','Doug Jones','Tyson Fury','Larry Holmes','c',NULL,NULL,'spo'),(113,'Combien de médailles possède Michael Phelps ?','28','23','18','25','i','img-33',NULL,'spo'),(114,'De quel sport vient le terme Kickoff ?','Football Américain','Basketball','MMA','Rugby','c',NULL,NULL,'spo');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rejoin_session`
--

DROP TABLE IF EXISTS `rejoin_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rejoin_session` (
  `session` int(11) NOT NULL,
  `joueur` int(11) NOT NULL,
  PRIMARY KEY (`joueur`,`session`),
  KEY `session` (`session`),
  CONSTRAINT `rejoin_session_ibfk_1` FOREIGN KEY (`session`) REFERENCES `session` (`id`),
  CONSTRAINT `rejoin_session_ibfk_2` FOREIGN KEY (`joueur`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rejoin_session`
--

LOCK TABLES `rejoin_session` WRITE;
/*!40000 ALTER TABLE `rejoin_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `rejoin_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nb_joueurs` int(11) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  `mode` varchar(10) DEFAULT NULL,
  `nb_questions` int(11) DEFAULT NULL,
  `tmp_reponse` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `createur` int(11) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `createur` (`createur`),
  CONSTRAINT `session_ibfk_1` FOREIGN KEY (`createur`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=510 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES (501,2,2,'brawl',10,10,'2022-05-07 18:36:14',12,'0501'),(509,2,2,'brawl',10,10,'2022-05-08 17:28:36',12,'0509');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skins`
--

DROP TABLE IF EXISTS `skins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  `image` varchar(20) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `rarete` char(1) DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skins`
--

LOCK TABLES `skins` WRITE;
/*!40000 ALTER TABLE `skins` DISABLE KEYS */;
INSERT INTO `skins` VALUES (167,NULL,'visage','head_1',NULL,NULL,2),(168,NULL,'visage','head_2',NULL,NULL,2),(169,NULL,'visage','head_3',NULL,NULL,2),(170,NULL,'visage','head_4',NULL,NULL,2),(171,NULL,'visage','head_5',NULL,NULL,2),(172,NULL,'visage','head_6',NULL,NULL,2),(173,NULL,'fond','fond_bleu',NULL,NULL,0),(174,NULL,'fond','fond_bleu_clair',NULL,NULL,0),(175,NULL,'fond','fond_bleu_foncee',NULL,NULL,0),(176,NULL,'fond','fond_gris',NULL,NULL,0),(177,NULL,'fond','fond_jaune',NULL,NULL,0),(178,NULL,'fond','fond_lacree',NULL,NULL,0),(179,NULL,'fond','fond_rose',NULL,NULL,0),(180,NULL,'fond','fond_rouge',NULL,NULL,0),(181,NULL,'fond','fond_vert',NULL,NULL,0),(182,NULL,'fond','fond_violet',NULL,NULL,0),(183,NULL,'fond','fond_orange',NULL,NULL,0),(184,NULL,'barbe','barbe_1',NULL,NULL,6),(185,'barbe viking','barbe','barbe_2',120,'r',6),(186,NULL,'barbe','moustache_1',NULL,NULL,6),(187,NULL,'bouche','bouche_1',NULL,NULL,7),(188,NULL,'bouche','bouche_2',NULL,NULL,7),(189,NULL,'bouche','bouche_3',NULL,NULL,7),(190,NULL,'bouche','bouche_4',NULL,NULL,7),(191,NULL,'bouche','bouche_5',NULL,NULL,7),(192,NULL,'bouche','bouche_6',NULL,NULL,7),(193,NULL,'bouche','bouche_7',NULL,NULL,7),(194,NULL,'bouche','bouche_8',NULL,NULL,7),(195,NULL,'bouche','bouche_9',NULL,NULL,7),(196,NULL,'yeux','yeux_1',NULL,NULL,3),(197,NULL,'yeux','yeux_2',NULL,NULL,3),(198,NULL,'yeux','yeux_3',NULL,NULL,3),(199,NULL,'yeux','yeux_4',NULL,NULL,3),(200,NULL,'yeux','yeux_5',NULL,NULL,3),(201,NULL,'sourcil','sourcil_1',NULL,NULL,3),(202,NULL,'sourcil','sourcil_2',NULL,NULL,3),(203,NULL,'sourcil','sourcil_3',NULL,NULL,3),(204,NULL,'sourcil','sourcil_4',NULL,NULL,3),(205,NULL,'sourcil','sourcil_5',NULL,NULL,3),(206,NULL,'sourcil','sourcil_6',NULL,NULL,3),(207,NULL,'lunette','lunette_1',NULL,NULL,4),(208,NULL,'lunette','lunette_2',NULL,NULL,4),(209,NULL,'lunette','lunette_3',NULL,NULL,4),(210,NULL,'lunette','lunette_4',NULL,NULL,4),(211,'lunette 3D','lunette','lunette_3D',270,'e',4),(212,'lunette swag','lunette','lunette_5',170,'r',4),(213,'lunette disco','lunette','rainbow',270,'e',4),(214,'minecraft','lunette','minecraft',510,'l',4),(215,NULL,'cheveux','cheveux_1',NULL,NULL,5),(216,NULL,'cheveux','cheveux_2',NULL,NULL,5),(217,NULL,'cheveux','cheveux_3',NULL,NULL,5),(218,NULL,'cheveux','cheveux_4',NULL,NULL,5),(219,NULL,'cheveux','cheveux_5',NULL,NULL,5),(220,NULL,'cheveux','cheveux_6',NULL,NULL,5),(221,NULL,'cheveux','cheveux_7',NULL,NULL,5),(222,NULL,'cheveux','cheveux_8',NULL,NULL,5),(223,NULL,'cheveux','cheveux_9',NULL,NULL,5),(224,NULL,'cheveux','cheveux_10',NULL,NULL,5),(225,NULL,'cheveux','cheveux_11',NULL,NULL,5),(226,NULL,'cheveux','cheveux_12',NULL,NULL,5),(227,NULL,'cheveux','cheveux_13',NULL,NULL,1),(228,NULL,'cheveux','cheveux_14',NULL,NULL,5),(229,NULL,'cheveux','cheveux_15',NULL,NULL,5),(230,NULL,'cheveux','cheveux_16',NULL,NULL,5),(231,NULL,'cheveux','cheveux_17',NULL,NULL,5),(232,'waves','cheveux','waves',300,'e',5),(233,'naruto','cheveux','naruto_cheveux',700,'l',5),(234,'la tentation','cheveux','xxxtentacion',470,'e',5),(235,'patty le chat','cosmetique','patty',200,'r',8),(236,'tony tony chopa','cosmetique','chopa',820,'l',8),(237,'couronne','cosmetique','couronne',130,'r',8),(238,'HEHEHE HA','cosmetique','heheha',1000,'l',8),(239,'moussailon','cosmetique','moussailon',350,'e',8),(240,'mugiwara no','cosmetique','mugiwara',1100,'l',8),(241,'ninja','cosmetique','ninja',430,'e',8),(242,'chapeau pirate','cosmetique','pirate',130,'r',8),(243,'robot','cosmetique','robot',200,'r',8),(244,'shrek','cosmetique','shrek',480,'e',8),(245,'harry potta','cosmetique','sorcier',130,'r',8),(246,'mechant robot','cosmetique','terminator',350,'e',8),(247,'ton pere','cosmetique','vador',400,'e',8),(248,'ragnar','cosmetique','viking',130,'r',8),(249,'Supa Sananes','cosmetique','sananes',1350,'l',8),(250,'MC Delon','cosmetique','delon',1351,'l',8);
/*!40000 ALTER TABLE `skins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `theme` (
  `nom` varchar(30) DEFAULT NULL,
  `couleur` char(7) DEFAULT NULL,
  `image` varchar(30) DEFAULT NULL,
  `numero` char(3) NOT NULL,
  PRIMARY KEY (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theme`
--

LOCK TABLES `theme` WRITE;
/*!40000 ALTER TABLE `theme` DISABLE KEYS */;
INSERT INTO `theme` VALUES ('Animaux','#A39090','animal.png','ani'),('Cinema','#8D93CE','movie.png','cin'),('Cuisine','#6A69AD','cook.png','cui'),('Culture generale','#D87D7D','culture.png','cul'),('Dessins animes','#F2D87C','donut.png','des'),('Drapeaux','#FFFFFF','flag.png','dra'),('Geographie','#E98C36','geo.png','geo'),('Histoire','#DC7777','history.png','his'),('Jeux Videos','#C4C4C4','jv.png','jeu'),('Mangas','#FFEAD9','mangas.png','man'),('Musique','#CBF2BD','music.png','mus'),('Qui est-ce ?','#EA4949','pop.png','qui'),('Rap','#ECF7FF','rap.png','rap'),('Science','#4A4A48','science.png','sci'),('Sport','#63C7D4','sport.png','spo');
/*!40000 ALTER TABLE `theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic` (
  `nom` varchar(32) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `nb_message` int(11) DEFAULT NULL,
  `introduction` text DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auteur` (`auteur`),
  CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`auteur`) REFERENCES `utilisateurs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic`
--

LOCK TABLES `topic` WRITE;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` VALUES ('Mon topic','2022-04-24 20:53:34',4,'Bonjour ceci est mon topic',4,3),('Pour ou contre le racisme ?','2022-04-26 06:16:01',7,'Je suis contre mais des fois c\'est limite',7,7),('Virer le fondateur du site','2022-04-26 13:53:56',5,'Oui je souhaite faire virer cette crapule de Samy',8,7),('Les arbres','2022-04-28 08:53:57',2,'Y\'en as qui sont beau et d\'autres non',10,14),('bonjour ','2022-05-07 17:33:47',2,'wooooooooow',13,22);
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `mdp` varchar(128) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `image` varchar(128) DEFAULT 'default.png',
  `quizz_point` int(11) DEFAULT 0,
  `cle` char(13) DEFAULT NULL,
  `avatar_actif` int(11) DEFAULT 0,
  `verifie` int(11) DEFAULT 0,
  `bannis` int(11) DEFAULT 0,
  `droit` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateurs`
--

LOCK TABLES `utilisateurs` WRITE;
/*!40000 ALTER TABLE `utilisateurs` DISABLE KEYS */;
INSERT INTO `utilisateurs` VALUES (0,'robot','je suis le robot du serveur','a65aa3720d5a217084591505130e09546fccb2086ff8bb015128451c90f44598896887d89e6e04a5baf4fe9dac60bc8cd02d75e4910cceb1896c6942b8d54bd4','robot@outsmart.com','image-1651910043.png',0,'6276259b4b0d9',0,1,0,0),(1,'Lulu El Marabou','Fessew !!','5386f49a4a22078cb061276f46c3831bd43dd0196e877a70f856ec6c751599224764d1548b7c783f4489ab21a8f36a50ee2c650c46ee147f83d00180fdcdec89','luka.truffert92@gmail.com','image-1650809887.jpg',488519,'62655560c33ad',0,1,0,0),(3,'loulou XD','c moi loulou ;)','c601ebf99790fb1f16953d41fb642ac4cd4da08e2d57ecf2f4d440d1df510d543584aaf648f64032ae0ce31b16f0769ada499289f0a365ef733735c1119cfe60','loulou@loulou.lou','image-1650816501.jpg',0,'626575f5b87a2',0,1,0,0),(4,'Mamadou','Je  vous passe mon bonjour.','9a58f1dffe0e4356fa1da61ce9b29cf3dbf062af766f2ce47785545cc6d0de44e203acaf4f693080ffc7ea871d7033b35692689a5b4795083810c9ebe2d152d1','mamadou862@gmail.com','image-1651045318.jpg',78785177,'6266a0aac2f85',1,1,0,0),(6,'mihaf.','fhgjk','e5dca186fa0cdaff45f871c9140fa57374f2a2e23e65bd11d672c170a1af9dc124d6b7d007c00f4f6d62b82687ada5623e2936deac5cff0dcffece0851cca802','mihaf.gaming@gmail.com','default.png',0,'626716f61d45b',0,0,0,0),(7,'ouicmoi','samy le nullos','996ffcdfdfcebd5561ed477564b3c097163e3ebed414511185921245bd90054be7807e067034aa4cf8073264cd11087a31d15f7ba84af1f1bbdab9ae87043443','nicolascabrera12@gmail.com','image-1650953836.jpg',0,'62678cb0823f0',0,1,0,0),(8,'lerattt ','____','c5cbe4807cbd3b3fe283c5d29d82e8844d5bef7a2dc9d58e7cedabf67c142c6fcd99685b4cd9590796ceef7c579338efafcb7b81fae6f4addfd6f3932f48eda0','linaaramja@gmail.com','image-1650980683.png',0,'6267f6667dd45',0,1,0,0),(9,'Lucas','.','df17a97c842ee25c99e7e216ffe883dc9ae228b37f84e7be2528d6166daf8363bc1d7db66fee8cf74d5bcd82aef293d3452e460ccea7922eb7e3247911ac83a8','lire.auparavant_0d@icloud.com','image-1651836074.png',0,'6267f967bf576',0,1,0,0),(10,'ecaeacz','caca','b41e7ff128e8040b4c876920dc924296940dd6ef1213326c4f0c4c1470dcd7d9cd5b97910be6f98794c32641b49f93758e3473b6d19074011979367e1ac5e2e6','xebexih739@wowcg.com','default.png',0,'6268685e638d8',0,0,0,0),(12,'salut','WOOOW','c601ebf99790fb1f16953d41fb642ac4cd4da08e2d57ecf2f4d440d1df510d543584aaf648f64032ae0ce31b16f0769ada499289f0a365ef733735c1119cfe60','samyalouadi@gmail.com','image-1651010279.jpg',736838,'62686ae745a06',1,1,0,0),(13,'fahim','sfqdklMLQ','129978d3b017f045a4fe78981c3334c47533ab40eae105315fbebb4736da891195041629ba5b9ca8d98967cd69c386a057e38156a92aec71207d66f1e5391f88','fahim77.ff@gmail.com','default.png',0,'6268fe8df2f2d',0,1,0,0),(14,'Boran','Fume la vie avant qu\'elle te fume','fe41d0a7476ba66700d7487ef00446ad585b6fa1b020108c5d4e8af8d788c831be75d00680519e0ac6043ac1650ff09d1b653ac6d8c7d3f2ea9a8f686d3c02d9','boran.yildiz.pro@gmail.com','image-1651132492.png',0,'626a47bd20346',0,1,0,0),(15,'100Stresssss','Lena Zhies','b31b9003f35910f6c6aff45b6c481756fa46723d5f576551ad309c2b67874dc5fb5a2864a7289b97c12dcfd878e82614a4f341ec7c929044108f90517fda7195','daniel2002soares09@gmail.com','default.png',0,'626a55e70b53e',0,1,0,0),(16,'aaa','AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA','1cb4bf7dd2badba6f824822dbe7d99f1e95ae9e7d4bfc30fabccfe4880085bf1d0e3b9ba8e27b52ae2323c2d2acbc1aa57f27d797096727c97b3adfa93c2b855','a@mail.com','default.png',0,'626a64b5c5b1b',0,0,1,0),(17,'aaaa','vnzangaznbnbzabnbznaknbknzakn','1cb4bf7dd2badba6f824822dbe7d99f1e95ae9e7d4bfc30fabccfe4880085bf1d0e3b9ba8e27b52ae2323c2d2acbc1aa57f27d797096727c97b3adfa93c2b855','aa@mail.com','default.png',0,'626a64d060286',0,0,1,0),(18,'BG_du_94','NULL','fe41d0a7476ba66700d7487ef00446ad585b6fa1b020108c5d4e8af8d788c831be75d00680519e0ac6043ac1650ff09d1b653ac6d8c7d3f2ea9a8f686d3c02d9','yildizboran7@gmail.com','image-1651227845.png',0,'626bbcc5c551f',0,1,0,0),(19,'Azerty','oui','eb3d001c3f1589e3d91a8dc3ac6b559fa28466c5f1eff77e0f32d6e40fc0c59af0722379e2b699a25550aa0064cf08039b352114a8c2ef7cb00d63a4f5c7ff14','romain.nerot@outlook.fr','image-1651238342.png',0,'626be5c65431e',0,1,0,0),(20,'ADMIN-01','ADMIN :(','4eb20290b7e040e3acb24ba91caebb531adecb631427d7aa620fe5fc836edb385ca08fa37c5761dccff76c05bc6f2e45347447fda8dd9b3391c58850aa7928e1','admin-01@outsmart.com','image-1651405168.png',0,'626e7170369a4',0,1,0,1),(21,'danette','Bonjour les amis','d2c0fc08d53936f862ba0112b785eed6553ca88cccd15d64c1bcc5b6dcecf417f67a2570037994217011ed87570bc7bd8445367c92e1c3927222c68898de5e25','dan.sebag1007@gmail.com','default.png',0,'627222ad6c860',0,1,0,0),(22,'nouveaupseudo','VOici ma description','c601ebf99790fb1f16953d41fb642ac4cd4da08e2d57ecf2f4d440d1df510d543584aaf648f64032ae0ce31b16f0769ada499289f0a365ef733735c1119cfe60','samy2@samy.com','image-1651944326.gif',150,'62727d69535db',1,1,0,0),(23,'samy3','samy3','c601ebf99790fb1f16953d41fb642ac4cd4da08e2d57ecf2f4d440d1df510d543584aaf648f64032ae0ce31b16f0769ada499289f0a365ef733735c1119cfe60','samy3@gmail.com','image-1651779550.jpg',150,'627427de58f47',1,1,0,0),(24,'Jayllyz','Oui','da72888dff157fd3848400dec3277f7a62296e103e66acfcfb26d9b1a1fbdaebb8e63af85d1563ad6f900719b3f45b000f98181cdc54af43eefb840661eaa901','antonydavid945@gmail.com','image-1651835102.jpg',0,'6274db10ef58c',0,1,0,0),(25,'San_thiago','Nsb','d461a56d29eda24c10d4ad7f649315ff86ab654145f7a357fbc6ff211c8af1d974f8281a704354740b9aaf492f08544b0e91326c716e597677ae1b1a41e96138','mjc.jeunesse774@gmail.com','default.png',0,'62750107b7277',0,1,0,0),(27,'YONKO','LES 4 YONKOS EN 1','cb55b2d9d0a63aaf2f98c7662c7ea8225131b2180ee03a430e1fad715eead9f91ead857d7138c0ec36e66554cd0df02b411a512589d3fdca0541fa249145aa3b','samy.admin@outsmart.outsmart','default.png',0,'6276d9480f592',0,1,0,3),(28,'samylefifou','Samy est nul à clash royale','837b8c3927aea2dab96a542b04673f34dcf2f48ebc7a09afa5c86dfa82ab8ccebf0dddb5e02461ce2a67bb599ef9e2e54e278142a0a3c858bdc7a9189a36d684','micujeremy02@gmail.com','image-1652018496.jpg',0,'6277cd40cd946',0,0,0,0);
/*!40000 ALTER TABLE `utilisateurs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-08 21:01:28

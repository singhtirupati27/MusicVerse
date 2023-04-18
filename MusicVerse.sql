-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: MusicVerse
-- ------------------------------------------------------
-- Server version	8.0.32-0ubuntu0.22.04.2

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'tirupatisingh1027@gmail.com','Tiru@123'),(2,'tirupati.singh@innoraft.com','Tiru@123'),(3,'diwakarkumarsah77@gmail.com','Diwa1234#'),(4,'bishal.maji@innoraft.com','Bishal.123'),(6,'rohan.singh@innoraft.com','Rohan@123'),(7,'','');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favourites`
--

DROP TABLE IF EXISTS `favourites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favourites` (
  `fav_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `music_id` int NOT NULL,
  PRIMARY KEY (`fav_id`),
  KEY `user_id` (`user_id`),
  KEY `music_id` (`music_id`),
  CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin` (`user_id`),
  CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`music_id`) REFERENCES `music` (`music_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favourites`
--

LOCK TABLES `favourites` WRITE;
/*!40000 ALTER TABLE `favourites` DISABLE KEYS */;
INSERT INTO `favourites` VALUES (2,1,6);
/*!40000 ALTER TABLE `favourites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `music`
--

DROP TABLE IF EXISTS `music`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `music` (
  `music_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `singer` varchar(80) NOT NULL,
  `genre` varchar(80) NOT NULL,
  `link` varchar(100) NOT NULL,
  `cover_img` varchar(100) DEFAULT '/public/music/coverimage/default-cover.jpeg',
  `user_music_id` int DEFAULT NULL,
  PRIMARY KEY (`music_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `music`
--

LOCK TABLES `music` WRITE;
/*!40000 ALTER TABLE `music` DISABLE KEYS */;
INSERT INTO `music` VALUES (1,'Bones','Imagine Dragon','Rock','public/music/Bones.mp3','public/music/coverimage/imagine-dragons-bones.gif',NULL),(2,'Bad Habits','Ed Sheeran','Rock','public/music/Bad-Habits.mp3','public/music/coverimage/bg1.jpg',NULL),(3,'Hey Mama (Feat. Nicki Minaj  Afrojack).mp3','David Guetta Feat. Nicki Minaj & Afrojack','Pop','public/music/Hey-Mama.mp3','public/music/coverimage/default-cover.jpeg',NULL),(4,'Suit','Guru','Classic, Rock, ','public/music/usermusic/Suit-Suit.mp3','public/music/coverimage/suit.jpg',NULL),(5,'Daaru Party','Millind Gaba','Others, Rock, Pop, ','public/music/usermusic/Daaru-Party.mp3','public/music/coverimage/daaru-party.jpeg',NULL),(6,'Tu Aake Dekhle','King','Hip Hop, Rock, Pop, ','public/music/usermusic/Tu-Aake-Dekhle.mp3','public/music/coverimage/tu-aake.jpeg',NULL),(7,'She Dont Know','Millind Gaba','Rock, Pop, ','public/music/usermusic/She-Dont-Know.mp3','public/music/coverimage/she-dont-know.jpeg',NULL),(8,'Boom Diggy Diggy','Jasmin Walia, Jack Knight','Others, Rock, Pop, ','public/music/usermusic/Bom-Diggy-Diggy.mp3','public/music/coverimage/boom-diggy.jpeg',NULL),(9,'5 Seconds of Summer','Calum Hood','Hip Hop, Pop, ','public/music/usermusic/5 Seconds Of Summer - Youngblood - (SongsLover.com).mp3','public/music/coverimage/5 seconds .jpeg',NULL),(10,'Lover','Diljit Dosanjh','Rock, Pop, ','public/music/usermusic/Lover.mp3','public/music/coverimage/lover.jpeg',1);
/*!40000 ALTER TABLE `music` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_info` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_gender` varchar(15) NOT NULL,
  `user_phone` varchar(14) NOT NULL,
  `user_interest` varchar(50) NOT NULL,
  UNIQUE KEY `user_phone` (`user_phone`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (6,'Rohan Singh','Male','+918862802510','Rock, Pop, '),(1,'Tirupati Singh','Male','+918862802548','Pop, Hip Hop, Rock, '),(2,'Tirupati','Male','+918862802549','Others, Rock, Pop, '),(4,'Bishal Maji','Male','+919812647892','Pop, Hip Hop, Rock, '),(3,'Diwakar Sah','Male','+919831819871','Pop, ');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_music`
--

DROP TABLE IF EXISTS `user_music`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_music` (
  `user_music_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `singer` varchar(80) NOT NULL,
  `genre` varchar(80) NOT NULL,
  `link` varchar(100) NOT NULL,
  `cover_img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '/public/music/coverimage/cover.jpeg',
  PRIMARY KEY (`user_music_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_music_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_music`
--

LOCK TABLES `user_music` WRITE;
/*!40000 ALTER TABLE `user_music` DISABLE KEYS */;
INSERT INTO `user_music` VALUES (1,2,'Lover','Diljit Dosanjh','Rock, Pop, ','public/music/usermusic/Lover.mp3','public/music/coverimage/lover.jpeg');
/*!40000 ALTER TABLE `user_music` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-08 17:02:36

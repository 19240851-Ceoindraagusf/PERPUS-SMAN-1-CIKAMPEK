-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: perpus_digital_sman1_cikampek
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `access_logs`
--

DROP TABLE IF EXISTS `access_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `access_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ebook_id` bigint unsigned NOT NULL,
  `accessed_at` timestamp NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `access_logs_ebook_id_foreign` (`ebook_id`),
  KEY `access_logs_accessed_at_index` (`accessed_at`),
  KEY `access_logs_ebook_id_accessed_at_index` (`ebook_id`,`accessed_at`),
  CONSTRAINT `access_logs_ebook_id_foreign` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_logs`
--

LOCK TABLES `access_logs` WRITE;
/*!40000 ALTER TABLE `access_logs` DISABLE KEYS */;
INSERT INTO `access_logs` VALUES (1,2,'2026-09-28 02:49:43','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-28 02:49:43','2026-09-28 02:49:43'),(2,2,'2026-09-29 03:46:54','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 03:46:54','2026-09-29 03:46:54'),(3,2,'2026-09-29 03:47:03','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 03:47:03','2026-09-29 03:47:03'),(4,25,'2026-09-29 03:48:16','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 03:48:16','2026-09-29 03:48:16'),(5,24,'2026-09-29 03:48:26','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 03:48:26','2026-09-29 03:48:26'),(6,3,'2026-09-29 03:48:41','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 03:48:41','2026-09-29 03:48:41'),(7,9,'2026-09-29 03:48:59','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 03:48:59','2026-09-29 03:48:59'),(8,23,'2026-09-29 04:21:30','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 04:21:30','2026-09-29 04:21:30'),(9,18,'2026-09-29 04:24:08','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 04:24:08','2026-09-29 04:24:08'),(10,19,'2026-09-29 04:25:33','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 04:25:33','2026-09-29 04:25:33'),(11,16,'2026-09-29 04:28:05','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 04:28:05','2026-09-29 04:28:05'),(12,26,'2026-09-29 05:14:23','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 05:14:23','2026-09-29 05:14:23'),(13,2,'2026-09-29 07:41:48','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','2026-09-29 07:41:48','2026-09-29 07:41:48'),(14,2,'2026-09-30 00:47:51','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:47:51','2026-09-30 00:47:51'),(15,3,'2026-09-30 00:48:06','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:48:06','2026-09-30 00:48:06'),(16,4,'2026-09-30 00:48:20','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:48:20','2026-09-30 00:48:20'),(17,5,'2026-09-30 00:48:57','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:48:57','2026-09-30 00:48:57'),(18,6,'2026-09-30 00:49:25','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:49:25','2026-09-30 00:49:25'),(19,7,'2026-09-30 00:49:42','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:49:42','2026-09-30 00:49:42'),(20,8,'2026-09-30 00:50:10','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:50:10','2026-09-30 00:50:10'),(21,9,'2026-09-30 00:50:28','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:50:28','2026-09-30 00:50:28'),(22,10,'2026-09-30 00:50:43','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:50:43','2026-09-30 00:50:43'),(23,11,'2026-09-30 00:50:55','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:50:55','2026-09-30 00:50:55'),(24,12,'2026-09-30 00:51:11','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:51:11','2026-09-30 00:51:11'),(25,13,'2026-09-30 00:51:31','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:51:31','2026-09-30 00:51:31'),(26,14,'2026-09-30 00:51:45','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:51:45','2026-09-30 00:51:45'),(27,24,'2026-09-30 00:52:43','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:52:43','2026-09-30 00:52:43'),(28,15,'2026-09-30 00:53:03','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:53:03','2026-09-30 00:53:03'),(29,16,'2026-09-30 00:53:21','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:53:21','2026-09-30 00:53:21'),(30,17,'2026-09-30 00:53:36','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:53:36','2026-09-30 00:53:36'),(31,29,'2026-09-30 00:54:03','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:54:03','2026-09-30 00:54:03'),(32,30,'2026-09-30 00:54:21','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:54:21','2026-09-30 00:54:21'),(33,18,'2026-09-30 00:55:15','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:55:15','2026-09-30 00:55:15'),(34,19,'2026-09-30 00:55:44','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:55:44','2026-09-30 00:55:44'),(35,20,'2026-09-30 00:56:29','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:56:29','2026-09-30 00:56:29'),(36,28,'2026-09-30 00:56:44','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:56:44','2026-09-30 00:56:44'),(37,32,'2026-09-30 00:57:02','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:57:02','2026-09-30 00:57:02'),(38,31,'2026-09-30 00:57:35','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:57:35','2026-09-30 00:57:35'),(39,33,'2026-09-30 00:58:04','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:58:04','2026-09-30 00:58:04'),(40,34,'2026-09-30 00:58:26','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:58:26','2026-09-30 00:58:26'),(41,23,'2026-09-30 00:59:18','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:59:18','2026-09-30 00:59:18'),(42,21,'2026-09-30 00:59:41','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 00:59:41','2026-09-30 00:59:41'),(43,35,'2026-09-30 01:00:45','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 01:00:45','2026-09-30 01:00:45'),(44,36,'2026-09-30 01:00:57','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 01:00:57','2026-09-30 01:00:57'),(45,37,'2026-09-30 01:01:17','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 01:01:17','2026-09-30 01:01:17'),(46,37,'2026-09-30 01:02:01','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 01:02:01','2026-09-30 01:02:01'),(47,22,'2026-09-30 01:02:27','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 01:02:27','2026-09-30 01:02:27'),(48,44,'2026-09-30 02:14:47','127.0.0.0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','2026-09-30 02:14:47','2026-09-30 02:14:47');
/*!40000 ALTER TABLE `access_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'XI IPA','Kelas XI jurusan IPA',1,'2026-09-28 02:07:03','2026-09-28 02:07:03'),(2,'XI IPS','Kelas XI jurusan IPS',1,'2026-09-28 02:07:03','2026-09-28 02:07:03'),(3,'XI Bahasa','Kelas XI jurusan Bahasa',1,'2026-09-28 02:07:03','2026-09-28 02:07:03'),(4,'XII IPA','Kelas XII jurusan IPA',1,'2026-09-28 02:07:03','2026-09-28 02:07:03'),(5,'XII IPS','Kelas XII jurusan IPS',1,'2026-09-28 02:07:03','2026-09-28 02:07:03'),(6,'XII Bahasa','Kelas XII jurusan Bahasa',1,'2026-09-28 02:07:03','2026-09-28 02:07:03'),(11,'X','Kelas X',1,'2026-09-28 02:09:50','2026-09-28 02:09:50'),(12,'XI','Kelas XI',1,'2026-09-28 02:09:50','2026-09-28 02:09:50'),(13,'XII','Kelas XII',1,'2026-09-28 02:09:50','2026-09-28 02:09:50');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ebooks`
--

DROP TABLE IF EXISTS `ebooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ebooks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publisher` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publication_year` year DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ebooks_subject_id_foreign` (`subject_id`),
  CONSTRAINT `ebooks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ebooks`
--

LOCK TABLES `ebooks` WRITE;
/*!40000 ALTER TABLE `ebooks` DISABLE KEYS */;
INSERT INTO `ebooks` VALUES (2,5,'Bahasa Indonesia','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Cerdas Cergas Berbahasa dan','Fadillah Tri Aulia, Sefi Indra Gumilar','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/3wUewJ5HFcioD7mLDFUxg67kIvcyuZL8j9u0OSuY.pdf','covers/EtqbSB5JURac5tb6rmtQMwXd20gD1yxMFu3cei6D.jpg',1,'2026-09-28 02:49:24','2026-09-28 02:49:24'),(3,35,'Bahasa Indonesia Edisi Revisi','REPUBLIK INDONESIA 2023 BAHASA INDONESIA','Fadillah Tri Aulia, Sei Indra Gumilar, Alvian Kurniawan','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh:, Pusat Perbukuan, Kompleks Kemendikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2023,'ebooks/WJPfMrV35jqRusDOR1d5Llk5vOJzvj06fwopSYiL.pdf','covers/Yqddfcrhut4pZqL09eJZSiBd3vlooiwlja3B7qIQ.png',1,'2026-09-28 05:31:26','2026-09-28 05:32:16'),(4,6,'BAHASA INGGRIS','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN BAHASA INGGRIS Work in Progress','Budi Hermawan, Dwi Haryanti, Nining Suryaningsih','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Kompleks Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2022,'ebooks/TL7Qspn64P4sD99p4J1uxI1J2mOoAkFtQMgWI574.pdf','covers/nDx36TKnfJIXhGwiIQSuLv5jEspg5aSSViFgwm5C.jpg',1,'2026-09-28 05:33:28','2026-09-28 05:33:28'),(5,36,'Informatika','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM PERBUKUAN INFORMATIKA Mushthofa, dkk.','Mushthofa, Wahyono, Auzi Asfarian, Dean Apriana Ramadhan, Hanson Prihantoro Putro, Irya Wisnubhadra, Heni Pratiwi, Budiman Saputra','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/iqU1T0PuLU97JaNKnI6bxQthSnDT2Mzj8P6OBut0.pdf','covers/JQDYBMpaBip5iPsQoP1cQOXzlOqNGIYdicttBcco.jpg',1,'2026-09-28 05:34:35','2026-09-30 01:09:30'),(6,10,'IPA','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Ilmu Pengetahuan Alam Ayuk Ratna Puspaningsih','Ayuk Ratna Puspaningsih, Elizabeth Tjahjadarmawan, Niken Resminingpuri Krisdianti','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/7TK3BMgeiuyfnvRD5AFwhr6Ctl1xrhB8Vfcsv76e.pdf','covers/vU9PBVTi04hX0B44fW648WQ5V1f0toNHIiTJsmgt.png',1,'2026-09-28 05:35:56','2026-09-28 05:37:29'),(7,9,'IPA','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Ilmu Pengetahuan Alam Ayuk Ratna Puspaningsih','Ayuk Ratna Puspaningsih, Elizabeth Tjahjadarmawan, Niken Resminingpuri Krisdianti','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/Ze3AbMyEgZhYQWSKuncwJgHYAg1mNyInYgydwAzi.pdf','covers/vU9PBVTi04hX0B44fW648WQ5V1f0toNHIiTJsmgt.png',1,'2026-09-28 05:36:51','2026-09-28 05:37:29'),(8,8,'IPA','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Ilmu Pengetahuan Alam Ayuk Ratna Puspaningsih','Ayuk Ratna Puspaningsih, Elizabeth Tjahjadarmawan, Niken Resminingpuri Krisdianti','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/0xzc60XyopnCRycf8TPUmLcGCa8t3pnO7RNcZfoM.pdf','covers/vU9PBVTi04hX0B44fW648WQ5V1f0toNHIiTJsmgt.png',1,'2026-09-28 05:37:29','2026-09-28 05:37:29'),(9,37,'IPS','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Sari Oktafiana, dkk. SMA KELAS X','Sari Oktafiana, Efvinggo Fasya Jaya, M. Nursa\'ban, Supardi, Mohammad Rizky Satria','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/bNtBbfS5H4i7feIjpR9gsJ22damtciywMMG4yPfG.pdf','covers/e19XRZkcW8sAttrV0wD6E612i4btdvXBfkDvl15A.jpg',1,'2026-09-28 05:38:15','2026-09-28 05:39:36'),(10,38,'IPS','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Sari Oktafiana, dkk. SMA KELAS X','Sari Oktafiana, Efvinggo Fasya Jaya, M. Nursa\'ban, Supardi, Mohammad Rizky Satria','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/Cb01YBVulbDhR2qlItK5VhxmBs5BqzDOGNE7vyK6.pdf','covers/e19XRZkcW8sAttrV0wD6E612i4btdvXBfkDvl15A.jpg',1,'2026-09-28 05:38:57','2026-09-28 05:39:36'),(11,39,'IPS','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Sari Oktafiana, dkk. SMA KELAS X','Sari Oktafiana, Efvinggo Fasya Jaya, M. Nursa\'ban, Supardi, Mohammad Rizky Satria','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/Qq7tyBZBXweHvmT13zwMl9AqpFELL2ErR8Y0yE9G.pdf','covers/e19XRZkcW8sAttrV0wD6E612i4btdvXBfkDvl15A.jpg',1,'2026-09-28 05:39:36','2026-09-28 05:39:36'),(12,7,'Matematika','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Matematika Dicky Susanto, dkk','Dicky Susanto, Theja Kurniawan, Savitri K. Sihombing, Eunice Salim, Marianna Magdalena, Radjawane, Ummy Salmah, Ambarsari Kusuma Wardani','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Kebudayaan, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/hfUxfpNvE6OS67VJP1INmssQwKOiilEOqFNWzwk2.pdf','covers/cAjLsIEBN6sQK6oxP1B5Z96YB8OhnkjliFvtks4O.png',1,'2026-09-28 05:40:39','2026-09-30 01:09:30'),(13,40,'Pendidikan Agama Islam dan Budi Pekerti','BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN REPUBLIK INDONESIA PUSAT KURIKULUM DAN PERBUKUAN 2021 Ahmad Taufik Nurwastuti Setyowati','Ahmad Taufik, Nurwastuti Setyowati','Pusat Kurikulum dan Perbukuan, Badan Penelitian dan Pengembangan dan Perbukuan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Jalan Gunung Sahari Raya No. 4 Jakarta Pusat',2021,'ebooks/V9PbJVZS8SzA4tWwETJGKHrLReHTHHRsMyhxBOct.pdf','covers/Gn9HHYyMMODjAaUL3gM6J5grwXQB4eZUiX6y7JJT.jpg',1,'2026-09-28 05:41:25','2026-09-28 05:41:25'),(14,41,'Pendidikan Pancasila','REPUBLIK INDONESIA 2023 PENDIDIKAN PANCASILA','Rochimudin, Muhamad Hari Purnomo Hadi, Ahmad Asroni','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh, Pusat Perbukuan, Kompleks Kemdikbudristek Jalan RS Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/XFFdZasI2ZmjgzG3aDP3o6SvUzrRFj6LPrv6Yc4Q.pdf','covers/x3AvmEsClezv64MSA1hat5t0WLpmFS4cDgfLcqy6.jpg',1,'2026-09-28 05:42:07','2026-09-28 05:42:07'),(15,23,'Bahasa Indonesia','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Cerdas Cergas Berbahasa dan Bersastra','Heny Marwati, K. Waskitaningtyas','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/DBEp03fml7PBg27VTB7wsesnQCy9o6w7tPpP9TE4.pdf','covers/eT1SJqvWUTupBcyBbcLAuOdkzGEQfoOL3eUGNvSO.jpg',1,'2026-09-28 05:57:07','2026-09-28 05:57:07'),(16,24,'BAHASA INGGRIS','English for Change KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MA KELAS XI','Puji Astuti, Aria Septi Anggaira, Atti Herawati, Yeyet Nurhayati, Dadan, Dayang Suriani','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh:, Pusat Perbukuan, Kompleks Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2022,'ebooks/ohPIgg1gNhMOTHXwaspsFQrHpmOaZ7anUF83yZat.pdf','covers/N2du9QY4gou4GdTEjmOKtuzDTlcct9zmuT5r06Kp.jpg',1,'2026-09-28 05:57:59','2026-09-28 05:57:59'),(17,42,'Bahasa Inggris','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Bahasa Inggris Tingkat Lanjut','Rida Afrilyasanti','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemendikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/ZjApwaHuOyNTpJ7G5EHbipzWD881HvEBEI9DrdNe.pdf','covers/O8zyPZuhIpX5R9MfpE9shHHH5hTuqqAlqlBDwrFy.jpg',1,'2026-09-28 05:58:47','2026-09-28 05:58:47'),(18,19,'Biologi','KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MSAMKPelas XI Hak Cipta pada Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia','Rini Solihat, Eris Rustandi, Wandi Herpiandi, Zamzam Nursani','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh, Pusat Perbukuan, Kompleks Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2022,'ebooks/48BXKp2feoSchwLRApDByO7LbmbPLNwKzGfh47P5.pdf','covers/2L3Z2KGruKrHSjmJHOfT7ifnJ8uDOhIk4oGPzFNx.jpg',1,'2026-09-28 06:00:16','2026-09-30 01:09:30'),(19,18,'Fisika','KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MA KELAS XI Hak Cipta pada Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi','Marianna Magdalena Radjawane, Alvius Tinambunan, Suntar Jono','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh:, Pusat Perbukuan, Kompleks Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2022,'ebooks/jGbRjhVs9bainKGYHRXjOYkxo4m2PCDJvCdBUfVb.pdf','covers/9DoIMQMPbYZNq7RnLoN96Ul9OfGGQ3Wg4r5jNKFU.jpg',1,'2026-09-28 06:01:32','2026-09-30 01:09:30'),(20,17,'Kimia','KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MA KELAS XI Hak Cipta pada Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia','Munasprianto Ramli, Nanda Saridewi, Tiktik Mustika Budhi, Aang Suhendar','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh:, Pusat Perbukuan, Kompleks Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2022,'ebooks/uuC3Um9TmDKvHrElMvNfvd5gfWksV2JE0IvRh1he.pdf','covers/EHmpqvcxnXv8L2ns7QVXoghtIKOsnlD1OLrdmwX8.jpg',1,'2026-09-28 06:02:14','2026-09-30 01:09:30'),(21,21,'Geografi','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Geografi Budi Handoyo','Budi Handoyo','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/pGH5ZX7oR4Kbv0Ad3iFv20LsdZ8lY5vnDklG4k4T.pdf','covers/FtglXXll84jGqOtACUEwaeOWOI3pnogNOgow4YUE.jpg',1,'2026-09-28 06:03:39','2026-09-30 01:09:30'),(22,22,'Sosiologi','RBADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN BPUSAT PERBUKUAN SOSIOLOGI Joan Hesti Gita Purwasih','Joan Hesti Gita Purwasih, Seli Septiana Pratiwi','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/ooB9IWzkcfNqV9y4avxYQIpxrYFe3wcUUGl1vvx8.pdf','covers/W19PDO8cu6ml1K6Up65eSc9sRWIutx5pP83TiEaU.jpg',1,'2026-09-28 06:04:28','2026-09-30 01:09:30'),(23,20,'Ekonomi','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Yeni Fitriani Aisyah Nurjanah','Yeni Fitriani, Aisyah Nurjanah','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2022,'ebooks/cSv6SKxe6uXoYcBPb88ajuSOGBycDEuatLXwezHn.pdf','covers/1p9nVdXuD7Ft6PFcbGzJl8U27LWadm1om5O9gWRg.jpg',1,'2026-09-28 06:06:39','2026-09-30 01:09:30'),(24,11,'Informatika','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Buku Panduan Guru INFORMATIKA','Paulina H. Prima Rosa, Auzi Asfarian, Irya Wisnubhadra, Mushthofa,, Dean Apriana Ramadhan','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/2jo8ObEum9Pw3a10lrHHEABZ5F9rQ6lxrkiyfl1r.pdf','covers/JSnkoy73vexnqmQ5Vv6ruLWWR5AW9kwFi0lz0KLz.jpg',1,'2026-09-28 06:07:48','2026-09-30 01:09:30'),(25,43,'Pendidikan Agama Islam dan Budi Pekerti','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN REPUBLIK INDONESIA PUSAT PERBUKUAN 2021 Pendidikan Agama Islam','Abd. Rahman, Hery Nugroho','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemendikbud Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/byzsXhZckt1zghM0dTarZ6brGsjThMlGbdrutZUI.pdf','covers/EZiOrpC4OCeC8UbBiiieVu5NRt7VkNXpz0umkNhi.jpg',1,'2026-09-28 06:08:45','2026-09-28 06:08:45'),(26,13,'Matematika','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Matematika Dicky Susanto, dkk.','Dicky Susanto, Savitri K. Sihombing, Marianna Magdalena Radjawane, Yulian Candra, Daniel Sinambela','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/Dhtu2hCNXQ8HtqaKWmVNWjmflU9sDvL3rJK2o4Qp.pdf','covers/Qx7TE69NdDoJ0fyQT4eivVxdn5TqI4MNN63XpiAy.jpg',1,'2026-09-28 06:09:26','2026-09-28 06:09:26'),(27,12,'Sejarah','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Sejarah Martina Safitry','Martina Safitry, Indah Wahyu Puji Utami, Zein Ilyas','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/mp77iZqg9srfzDOYdSKMfDHN3eXWvs7fqp769sQ8.pdf','covers/Juf0SVeFNEbFc4IFc2NlDSc8LtDJqQk2OPqG5xru.jpg',1,'2026-09-28 06:10:03','2026-09-28 06:10:03'),(28,47,'Matematika','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Matematika Dicky Susanto, dkk.','Dicky Susanto, Savitri K. Sihombing, Marianna Magdalena Radjawane, Yulian Candra, Daniel Sinambela','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/Dhtu2hCNXQ8HtqaKWmVNWjmflU9sDvL3rJK2o4Qp.pdf','covers/Qx7TE69NdDoJ0fyQT4eivVxdn5TqI4MNN63XpiAy.jpg',1,'2026-09-28 06:09:26','2026-09-28 06:09:26'),(29,45,'Bahasa Indonesia','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Cerdas Cergas Berbahasa dan Bersastra','Heny Marwati, K. Waskitaningtyas','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/DBEp03fml7PBg27VTB7wsesnQCy9o6w7tPpP9TE4.pdf','covers/eT1SJqvWUTupBcyBbcLAuOdkzGEQfoOL3eUGNvSO.jpg',1,'2026-09-28 05:57:07','2026-09-28 05:57:07'),(30,46,'BAHASA INGGRIS','English for Change KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MA KELAS XI','Puji Astuti, Aria Septi Anggaira, Atti Herawati, Yeyet Nurhayati, Dadan, Dayang Suriani','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh:, Pusat Perbukuan, Kompleks Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2022,'ebooks/ohPIgg1gNhMOTHXwaspsFQrHpmOaZ7anUF83yZat.pdf','covers/N2du9QY4gou4GdTEjmOKtuzDTlcct9zmuT5r06Kp.jpg',1,'2026-09-28 05:57:59','2026-09-28 05:57:59'),(31,48,'Sejarah','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Sejarah Martina Safitry','Martina Safitry, Indah Wahyu Puji Utami, Zein Ilyas','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/mp77iZqg9srfzDOYdSKMfDHN3eXWvs7fqp769sQ8.pdf','covers/Juf0SVeFNEbFc4IFc2NlDSc8LtDJqQk2OPqG5xru.jpg',1,'2026-09-28 06:10:03','2026-09-28 06:10:03'),(32,50,'Pendidikan Agama Islam dan Budi Pekerti','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN REPUBLIK INDONESIA PUSAT PERBUKUAN 2021 Pendidikan Agama Islam','Abd. Rahman, Hery Nugroho','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemendikbud Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/byzsXhZckt1zghM0dTarZ6brGsjThMlGbdrutZUI.pdf','covers/EZiOrpC4OCeC8UbBiiieVu5NRt7VkNXpz0umkNhi.jpg',1,'2026-09-28 06:08:45','2026-09-28 06:08:45'),(33,52,'Bahasa Indonesia','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Cerdas Cergas Berbahasa dan Bersastra','Heny Marwati, K. Waskitaningtyas','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/DBEp03fml7PBg27VTB7wsesnQCy9o6w7tPpP9TE4.pdf','covers/eT1SJqvWUTupBcyBbcLAuOdkzGEQfoOL3eUGNvSO.jpg',1,'2026-09-28 05:57:07','2026-09-28 05:57:07'),(34,53,'BAHASA INGGRIS','English for Change KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MA KELAS XI','Puji Astuti, Aria Septi Anggaira, Atti Herawati, Yeyet Nurhayati, Dadan, Dayang Suriani','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh:, Pusat Perbukuan, Kompleks Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2022,'ebooks/ohPIgg1gNhMOTHXwaspsFQrHpmOaZ7anUF83yZat.pdf','covers/N2du9QY4gou4GdTEjmOKtuzDTlcct9zmuT5r06Kp.jpg',1,'2026-09-28 05:57:59','2026-09-28 05:57:59'),(35,54,'Matematika','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Matematika Dicky Susanto, dkk.','Dicky Susanto, Savitri K. Sihombing, Marianna Magdalena Radjawane, Yulian Candra, Daniel Sinambela','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/Dhtu2hCNXQ8HtqaKWmVNWjmflU9sDvL3rJK2o4Qp.pdf','covers/Qx7TE69NdDoJ0fyQT4eivVxdn5TqI4MNN63XpiAy.jpg',1,'2026-09-28 06:09:26','2026-09-28 06:09:26'),(36,55,'Pendidikan Agama Islam dan Budi Pekerti','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN REPUBLIK INDONESIA PUSAT PERBUKUAN 2021 Pendidikan Agama Islam','Abd. Rahman, Hery Nugroho','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemendikbud Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/byzsXhZckt1zghM0dTarZ6brGsjThMlGbdrutZUI.pdf','covers/EZiOrpC4OCeC8UbBiiieVu5NRt7VkNXpz0umkNhi.jpg',1,'2026-09-28 06:08:45','2026-09-28 06:08:45'),(37,56,'Sejarah','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Sejarah Martina Safitry','Martina Safitry, Indah Wahyu Puji Utami, Zein Ilyas','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemdikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/mp77iZqg9srfzDOYdSKMfDHN3eXWvs7fqp769sQ8.pdf','covers/Juf0SVeFNEbFc4IFc2NlDSc8LtDJqQk2OPqG5xru.jpg',1,'2026-09-28 06:10:03','2026-09-28 06:10:03'),(38,51,'Pendidikan Pancasila','REPUBLIK INDONESIA 2023 PENDIDIKAN PANCASILA','Sri Cahyati, Siti Nurjanah, Ali Usman','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh, Pusat Perbukuan, Kompleks Kemdikbudristek Jalan RS Fatmawati, Cipete, Jakarta Selatan',2023,'ebooks/BMEuhOnthDOvMIFEFIcbViePdZQiVaVnurvAmHgI.pdf','covers/VOt6iBiU5Y89dzvJq51Vxpf3YmliOmNixJszCWPa.jpg',1,'2026-09-30 01:55:46','2026-09-30 01:55:46'),(39,72,'Pendidikan Pancasila','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Pendidikan Pancasila dan Kewarganegaraan','Tedi Kholiludin, Ahmad Asroni, Hatim Gazali, Abdul Waidl, Ali Usman','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemendikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/75Olap7RjMUygf2EJTA3pjtcANqIMVpBNDZJLBTX.pdf','covers/VxKha9DNiyoalOXmG1EJkBF8jN7ZpPxbvSC5hYX6.jpg',1,'2026-09-30 02:08:43','2026-09-30 02:08:43'),(40,71,'Bahasa Inggris Lanjutan','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Bahasa Inggris Tingkat Lanjut','Rida Afrilyasanti','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemendikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/TFbANq2QeQS2KnqiVBVHDbV1ZEpxKAvVOmhxY3i3.pdf','covers/8EetnypaSQBDXbZr7pGv6cRlvteRSUaXf7HuueuZ.jpg',1,'2026-09-30 02:09:35','2026-09-30 02:09:35'),(41,73,'Pendidikan Pancasila Revisi','REPUBLIK INDONESIA 2023 PENDIDIKAN PANCASILA','Sri Cahyati, Siti Nurjanah, Ali Usman','Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Dikeluarkan oleh, Pusat Perbukuan, Kompleks Kemdikbudristek Jalan RS Fatmawati, Cipete, Jakarta Selatan',2023,'ebooks/nlVABOOjyyc875vz03vihiK8MrCquKaegBnrDsgF.pdf','covers/VVAr1TfrYwfcv2ZBDgdtxEhxy0kQ8tzJuSbbbv1L.jpg',1,'2026-09-30 02:10:14','2026-09-30 02:10:14'),(42,49,'Pendidikan Pancasila','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Pendidikan Pancasila dan Kewarganegaraan','Tedi Kholiludin, Ahmad Asroni, Hatim Gazali, Abdul Waidl, Ali Usman','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemendikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/krkSkvCmozTKr9CYCqkCiKnpYkYutdAnZjbmy597.pdf','covers/fbJydElWGQGAcWP2GhAfZF2dJy8ZHFek43bRzTU2.jpg',1,'2026-09-30 02:11:14','2026-09-30 02:11:14'),(43,69,'Bahasa Inggris Lanjutan','BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Bahasa Inggris Tingkat Lanjut','Rida Afrilyasanti','Pusat Perbukuan, Badan Standar, Kurikulum, dan Asesmen Pendidikan, Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi, Komplek Kemendikbudristek Jalan RS. Fatmawati, Cipete, Jakarta Selatan',2021,'ebooks/aSIP3VkvmfeeR7FHakIneDqisRDigRZJFDs4eCzY.pdf','covers/KXFurNZ1Za2fqKf9jgj6EGwh1hwYh5rL1iXxxZsz.jpg',1,'2026-09-30 02:11:52','2026-09-30 02:11:52'),(44,74,'Pendidikan Jasmani,Olahraga dan Kesehatan','Dilindungi Undang-Undang Disklaimer: Buku ini merupakan buku siswa yang dipersiapkan Pemerintah dalam rangka implementasi Kurikulum 2013. Buku siswa ini disusun dan ditelaah oleh berbagai pihak di bawah koordinasi Kementerian Pendidikan dan Kebudayaan, dan dipergunakan','Pendidikan Jasmani Olahraga dan Kesehatan iii, DAFTAR ISI, KATA PENGANTAR.............................................................................................iii, DAFTAR ISI..........................................................................','Pusat Kurikulum dan Perbukuan',2017,'ebooks/Yku577nUlqzVwbGvZKpKHGeDdpe8G4OXO8eiJEsc.pdf','covers/Q6XxDn3VJUyGPiZxLdTfOtKUWa3FwOBV1yZW4gkm.jpg',1,'2026-09-30 02:14:39','2026-09-30 02:14:39');
/*!40000 ALTER TABLE `ebooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_09_22_000001_create_classes_table',1),(6,'2026_09_22_000002_create_subjects_table',1),(7,'2026_09_22_000003_create_ebooks_table',1),(8,'2026_09_22_000004_create_access_logs_table',1),(9,'2026_09_23_000001_replace_ipa_subjects_with_science_branches',1),(10,'2026_09_23_000002_share_existing_ipa_science_ebooks',1),(11,'2026_09_23_000003_replace_ips_subjects_with_social_branches',1),(12,'2026_09_24_000001_sync_subject_statuses_from_active_ebooks',1),(13,'2026_09_24_000002_create_upper_grade_major_classes',1),(14,'2026_09_29_000001_rename_geologi_subjects_to_geografi',2),(15,'2026_09_29_000002_add_access_log_retention_indexes',2),(16,'2026_09_29_000003_anonymize_existing_access_log_ip_addresses',2),(17,'2026_09_30_000001_reorganize_upper_grade_major_subjects',2),(18,'2026_09_30_000002_fix_misassigned_ebook_titles_and_covers',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint unsigned NOT NULL,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subjects_class_id_foreign` (`class_id`),
  CONSTRAINT `subjects_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (5,11,'Bahasa Indonesia',NULL,'Bahasa Indonesia: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Cerdas Cergas Berbahasa dan',1,'2026-09-28 02:09:50','2026-09-28 02:49:24'),(6,11,'Bahasa Inggris',NULL,'Bahasa Inggris: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN BAHASA INGGRIS Work in Progress',1,'2026-09-28 02:09:50','2026-09-28 05:33:28'),(7,11,'Matematika',NULL,'Matematika: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Matematika Dicky Susanto, dkk',1,'2026-09-28 02:09:50','2026-09-28 05:40:39'),(8,11,'IPA / Kimia',NULL,'IPA / Kimia: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Ilmu Pengetahuan Alam Ayuk Ratna Puspaningsih',1,'2026-09-28 02:09:50','2026-09-28 05:37:29'),(9,11,'IPA / Fisika',NULL,'IPA / Fisika: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Ilmu Pengetahuan Alam Ayuk Ratna Puspaningsih',1,'2026-09-28 02:09:50','2026-09-28 05:36:51'),(10,11,'IPA / Biologi',NULL,'IPA / Biologi: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Ilmu Pengetahuan Alam Ayuk Ratna Puspaningsih',1,'2026-09-28 02:09:50','2026-09-28 05:35:56'),(11,12,'Informatika',NULL,'Informatika: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Buku Panduan Guru INFORMATIKA',1,'2026-09-28 02:10:43','2026-09-30 00:40:43'),(12,12,'Sejarah',NULL,'Sejarah: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Sejarah Martina Safitry',0,'2026-09-28 02:10:43','2026-09-30 00:40:43'),(13,12,'Matematika',NULL,'Matematika: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Matematika Dicky Susanto, dkk.',0,'2026-09-28 02:10:43','2026-09-30 00:40:43'),(14,13,'Informatika',NULL,'Mata pelajaran dasar untuk XII',1,'2026-09-28 02:10:43','2026-09-30 00:40:43'),(15,13,'Pendidikan Agama Islam dan Budi Pekerti',NULL,'Mata pelajaran dasar untuk XII',0,'2026-09-28 02:10:43','2026-09-30 00:40:43'),(16,13,'Matematika',NULL,'Mata pelajaran dasar untuk XII',0,'2026-09-28 02:10:43','2026-09-30 00:40:43'),(17,1,'Kimia',NULL,'Kimia: KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MA KELAS XI Hak Cipta pada Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(18,1,'Fisika',NULL,'Fisika: KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MA KELAS XI Hak Cipta pada Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(19,1,'Biologi',NULL,'Biologi: KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MSAMKPelas XI Hak Cipta pada Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(20,2,'Ekonomi',NULL,'Ekonomi: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Yeni Fitriani Aisyah Nurjanah',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(21,2,'Geografi',NULL,'Geografi: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Geografi Budi Handoyo',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(22,2,'Sosiologi',NULL,'Sosiologi: RBADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN BPUSAT PERBUKUAN SOSIOLOGI Joan Hesti Gita Purwasih',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(23,3,'Bahasa Indonesia',NULL,'Bahasa Indonesia: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Cerdas Cergas Berbahasa dan Bersastra',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(24,3,'Bahasa Inggris',NULL,'Bahasa Inggris: English for Change KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI 2022 SMA/MA KELAS XI',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(25,3,'Bahasa Sunda',NULL,'Mata pelajaran Bahasa Sunda untuk XI Bahasa',0,'2026-09-28 02:13:29','2026-09-30 01:17:48'),(26,4,'Kimia',NULL,'Mata pelajaran Kimia untuk XII IPA',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(27,4,'Fisika',NULL,'Mata pelajaran Fisika untuk XII IPA',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(28,4,'Biologi',NULL,'Mata pelajaran Biologi untuk XII IPA',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(29,5,'Ekonomi',NULL,'Mata pelajaran Ekonomi untuk XII IPS',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(30,5,'Geografi',NULL,'Mata pelajaran Geografi untuk XII IPS',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(31,5,'Sosiologi',NULL,'Mata pelajaran Sosiologi untuk XII IPS',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(32,6,'Bahasa Indonesia',NULL,'Mata pelajaran Bahasa Indonesia untuk XII Bahasa',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(33,6,'Bahasa Inggris',NULL,'Mata pelajaran Bahasa Inggris untuk XII Bahasa',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(34,6,'Bahasa Sunda',NULL,'Mata pelajaran Bahasa Sunda untuk XII Bahasa',1,'2026-09-28 02:13:29','2026-09-30 00:40:43'),(35,11,'Bahasa Indonesia Edisi Revisi',NULL,'Bahasa Indonesia Edisi Revisi: REPUBLIK INDONESIA 2023 BAHASA INDONESIA',1,'2026-09-28 02:36:48','2026-09-28 05:31:27'),(36,11,'Informatika',NULL,'Informatika: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM PERBUKUAN INFORMATIKA Mushthofa, dkk.',1,'2026-09-28 02:37:30','2026-09-28 05:34:35'),(37,11,'IPS / Ekonomi',NULL,'IPS / Ekonomi: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Sari Oktafiana, dkk. SMA KELAS X',1,'2026-09-28 02:39:14','2026-09-28 05:38:15'),(38,11,'IPS / Geografi',NULL,'IPS / Geografi: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Sari Oktafiana, dkk. SMA KELAS X',1,'2026-09-28 02:39:25','2026-09-28 05:38:57'),(39,11,'IPS / Sosiologi',NULL,'IPS / Sosiologi: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN PUSAT KURIKULUM DAN PERBUKUAN Sari Oktafiana, dkk. SMA KELAS X',1,'2026-09-28 02:39:59','2026-09-28 05:39:36'),(40,11,'Pendidikan Agama Islam dan Budi Pekerti',NULL,'Pendidikan Agama Islam dan Budi Pekerti: BADAN PENELITIAN DAN PENGEMBANGAN DAN PERBUKUAN REPUBLIK INDONESIA PUSAT KURIKULUM DAN PERBUKUAN 2021 Ahmad Taufik Nurwastuti Setyowati',1,'2026-09-28 02:41:52','2026-09-28 05:41:25'),(41,11,'Pendidikan Pancasila',NULL,'Pendidikan Pancasila: REPUBLIK INDONESIA 2023 PENDIDIKAN PANCASILA',1,'2026-09-28 02:42:07','2026-09-28 05:42:07'),(42,3,'Bahasa Inggris Lanjutan',NULL,'Bahasa Inggris Lanjutan: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Bahasa Inggris Tingkat Lanjut',1,'2026-09-28 03:57:09','2026-09-28 05:58:47'),(43,12,'Pendidikan Agama Islam dan Budi Pekerti',NULL,'Pendidikan Agama Islam dan Budi Pekerti: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN REPUBLIK INDONESIA PUSAT PERBUKUAN 2021 Pendidikan Agama Islam',0,'2026-09-28 03:59:46','2026-09-30 00:40:43'),(44,13,'Sejarah',NULL,NULL,0,'2026-09-28 04:03:42','2026-09-30 00:40:43'),(45,1,'Bahasa Indonesia',NULL,NULL,1,'2026-09-30 00:15:48','2026-09-30 00:40:43'),(46,1,'Bahasa Inggris',NULL,NULL,1,'2026-09-30 00:16:14','2026-09-30 00:40:43'),(47,1,'Matematika',NULL,NULL,1,'2026-09-30 00:16:41','2026-09-30 00:40:43'),(48,1,'Sejarah',NULL,NULL,1,'2026-09-30 00:16:58','2026-09-30 00:40:43'),(49,1,'Pendidikan Pancasila',NULL,'Pendidikan Pancasila: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Pendidikan Pancasila dan Kewarganegaraan',1,'2026-09-30 00:17:34','2026-09-30 02:11:14'),(50,1,'Pendidikan Agama Islam dan Budi Pekerti',NULL,NULL,1,'2026-09-30 00:18:21','2026-09-30 00:40:43'),(51,2,'Pendidikan Pancasila Revisi',NULL,'Pendidikan Pancasila: REPUBLIK INDONESIA 2023 PENDIDIKAN PANCASILA',1,'2026-09-30 00:19:00','2026-09-30 02:02:07'),(52,2,'Bahasa Indonesia',NULL,NULL,1,'2026-09-30 00:19:18','2026-09-30 00:40:43'),(53,2,'Bahasa Inggris',NULL,NULL,1,'2026-09-30 00:20:34','2026-09-30 00:40:43'),(54,2,'Matematika',NULL,NULL,1,'2026-09-30 00:20:46','2026-09-30 00:40:43'),(55,2,'Pendidikan Agama Islam dan Budi Pekerti',NULL,NULL,1,'2026-09-30 00:21:00','2026-09-30 00:40:43'),(56,2,'Sejarah',NULL,NULL,1,'2026-09-30 00:21:25','2026-09-30 00:40:43'),(57,4,'Matematika',NULL,'Mata pelajaran Matematika.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(58,4,'Bahasa Indonesia',NULL,'Mata pelajaran Bahasa Indonesia.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(59,4,'Bahasa Inggris',NULL,'Mata pelajaran Bahasa Inggris.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(60,4,'Sejarah',NULL,'Mata pelajaran Sejarah.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(61,4,'Pendidikan Pancasila',NULL,'Mata pelajaran Pendidikan Pancasila.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(62,4,'Pendidikan Agama Islam dan Budi Pekerti',NULL,'Mata pelajaran Pendidikan Agama Islam dan Budi Pekerti.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(63,5,'Pendidikan Pancasila',NULL,'Mata pelajaran Pendidikan Pancasila.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(64,5,'Bahasa Indonesia',NULL,'Mata pelajaran Bahasa Indonesia.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(65,5,'Bahasa Inggris',NULL,'Mata pelajaran Bahasa Inggris.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(66,5,'Matematika',NULL,'Mata pelajaran Matematika.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(67,5,'Pendidikan Agama Islam dan Budi Pekerti',NULL,'Mata pelajaran Pendidikan Agama Islam dan Budi Pekerti.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(68,5,'Sejarah',NULL,'Mata pelajaran Sejarah.',1,'2026-09-30 00:40:43','2026-09-30 00:40:43'),(69,1,'Bahasa Inggris Lanjutan',NULL,'Bahasa Inggris Lanjutan: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Bahasa Inggris Tingkat Lanjut',1,'2026-09-30 02:01:14','2026-09-30 02:11:52'),(71,2,'Bahasa Inggris Lanjutan',NULL,'Bahasa Inggris Lanjutan: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Bahasa Inggris Tingkat Lanjut',1,'2026-09-30 02:05:42','2026-09-30 02:09:35'),(72,2,'Pendidikan Pancasila',NULL,'Pendidikan Pancasila: BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN PUSAT PERBUKUAN Pendidikan Pancasila dan Kewarganegaraan',1,'2026-09-30 02:06:31','2026-09-30 02:08:43'),(73,1,'Pendidikan Pancasila Revisi',NULL,'Pendidikan Pancasila Revisi: REPUBLIK INDONESIA 2023 PENDIDIKAN PANCASILA',1,'2026-09-30 02:07:22','2026-09-30 02:10:14'),(74,12,'Pendidikan Jasmani,Olahraga dan Kesehatan',NULL,'Pendidikan Jasmani,Olahraga dan Kesehatan: Dilindungi Undang-Undang Disklaimer: Buku ini merupakan buku siswa yang dipersiapkan Pemerintah dalam rangka implementasi Kurikulum 2013. Buku siswa ini disusun dan ditelaah oleh berbagai pihak di bawah koordinasi Kementerian Pendidikan...',1,'2026-09-30 02:13:45','2026-09-30 02:14:39'),(75,13,'Pendidikan Jasmani,Olahraga dan Kesehatan',NULL,NULL,0,'2026-09-30 02:13:59','2026-09-30 02:13:59');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'Admin Perpustakaan','admin@perpus.test',NULL,'$2y$12$hs1qgnbIhND2DXWzyumeROIYGHvo6uEzMu3yVllLoYKtvDC2qr5zq','admin',NULL,'2026-09-28 02:09:50','2026-09-28 02:13:29');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-30  9:23:26

/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.14 : Database - craft
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`craft` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `craft`;

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `company` */

insert  into `company`(`id`,`name`) values (1,'Eon Animal Health Products Ltd'),(2,'Eon Agro Industries Ltd'),(3,'Eon Pharmacetucals Ltd'),(4,'Euro Feeds Limited'),(5,'Eon Excel Feeds limited'),(6,'Eon InfoSys Technology'),(7,'Eon Poultry Complex'),(8,'Eon Foods Ltd'),(9,'Eon Bio Science Ltd');

/*Table structure for table `depot` */

DROP TABLE IF EXISTS `depot`;

CREATE TABLE `depot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `depot` */

insert  into `depot`(`id`,`name`) values (1,'Head Office'),(2,'Barisal'),(3,'Bogra'),(4,'Comilla'),(5,'Jessore'),(6,'Khulna'),(7,'Mymensingh'),(8,'Naogaon'),(9,'Natore'),(10,'Rajshahi'),(11,'Rangpur'),(12,'Thakurgaon'),(15,'testa');

/*Table structure for table `issue` */

DROP TABLE IF EXISTS `issue`;

CREATE TABLE `issue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_location` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `finalized_by` int(11) DEFAULT NULL,
  `issue_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `finalized_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_12AD233E18716951` (`from_location`),
  KEY `IDX_12AD233E979B1AD6` (`company_id`),
  KEY `IDX_12AD233E8510D4DE` (`depot_id`),
  KEY `IDX_12AD233EDE12AB56` (`created_by`),
  KEY `IDX_12AD233E16FE72E1` (`updated_by`),
  KEY `IDX_12AD233EDCA2A522` (`finalized_by`),
  CONSTRAINT `FK_12AD233E16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_12AD233E18716951` FOREIGN KEY (`from_location`) REFERENCES `location` (`id`),
  CONSTRAINT `FK_12AD233E8510D4DE` FOREIGN KEY (`depot_id`) REFERENCES `depot` (`id`),
  CONSTRAINT `FK_12AD233E979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_12AD233EDCA2A522` FOREIGN KEY (`finalized_by`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_12AD233EDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `issue` */

insert  into `issue`(`id`,`from_location`,`company_id`,`depot_id`,`created_by`,`updated_by`,`finalized_by`,`issue_date`,`status`,`created_at`,`updated_at`,`finalized_at`) values (1,1,1,1,1,NULL,1,'2014-08-01',1,'2014-09-15 18:19:56',NULL,'2014-10-13 07:16:49'),(2,1,1,1,1,NULL,NULL,'2014-09-15',0,'2014-09-15 18:20:56',NULL,NULL),(3,1,6,1,1,NULL,1,'2014-09-15',1,'2014-09-15 18:21:33',NULL,'2014-10-13 07:15:37'),(4,1,1,1,1,NULL,1,'2014-09-15',1,'2014-09-15 18:22:03',NULL,'2014-10-13 07:15:43'),(5,1,1,1,1,NULL,1,'2014-09-15',1,'2014-09-15 18:22:31',NULL,'2014-10-13 07:15:49'),(6,1,7,9,1,NULL,1,'2014-09-15',1,'2014-09-15 18:23:39',NULL,'2014-10-13 07:15:57'),(7,1,1,1,1,NULL,1,'2014-09-15',1,'2014-09-15 18:24:09',NULL,'2014-10-13 07:16:03'),(8,1,1,1,1,NULL,1,'2014-09-15',1,'2014-09-15 18:24:33',NULL,'2014-10-13 07:16:10'),(9,1,1,1,1,NULL,1,'2014-09-15',1,'2014-09-15 18:24:58',NULL,'2014-10-13 07:16:17'),(10,1,1,1,1,NULL,NULL,'2014-09-15',0,'2014-09-15 18:26:14',NULL,NULL),(11,1,1,1,28,NULL,NULL,'2014-10-11',0,'2014-10-11 12:55:13',NULL,NULL),(12,1,1,1,4,NULL,4,'2014-10-11',1,'2014-10-11 12:58:36',NULL,'2014-10-11 12:58:40'),(13,1,1,1,1,NULL,1,'2014-10-13',1,'2014-10-13 05:27:59',NULL,'2014-10-13 05:28:03'),(14,1,1,1,1,NULL,1,'2014-10-13',1,'2014-10-13 05:28:56',NULL,'2014-10-13 05:29:05'),(15,1,1,1,1,NULL,1,'2014-10-13',1,'2014-10-13 05:32:48',NULL,'2014-10-13 05:32:52'),(16,1,1,1,1,NULL,1,'2014-10-13',1,'2014-10-13 05:36:41',NULL,'2014-10-13 05:36:44'),(17,1,1,1,1,NULL,1,'2014-11-12',1,'2014-11-12 14:55:52',NULL,'2014-11-12 14:55:56'),(18,1,1,1,1,NULL,1,'2014-11-13',1,'2014-11-13 18:09:45',NULL,'2014-11-13 18:09:49'),(19,1,1,1,1,NULL,1,'2014-11-13',1,'2014-11-13 18:16:09',NULL,'2014-11-13 18:16:12'),(20,1,1,1,1,NULL,1,'2014-11-13',1,'2014-11-13 18:16:52',NULL,'2014-11-13 18:16:55');

/*Table structure for table `issue_line` */

DROP TABLE IF EXISTS `issue_line`;

CREATE TABLE `issue_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,0) NOT NULL,
  `issue_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference_number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_89F37C3A5E7AA58C` (`issue_id`),
  KEY `IDX_89F37C3A4584665A` (`product_id`),
  CONSTRAINT `FK_89F37C3A4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_89F37C3A5E7AA58C` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `issue_line` */

insert  into `issue_line`(`id`,`issue_id`,`product_id`,`quantity`,`issue_to`,`reference_number`) values (1,1,6,1,'jony',1),(2,2,6,1,'rony',9),(3,3,8,1,'Almas',2),(4,4,8,1,'Rashed',10),(5,5,2,1,'Alamgir',3),(6,6,2,1,'shahnur',11),(7,7,7,1,'Khan',4),(8,8,1,1,'Fakrul',5),(9,9,5,1,'rehan',6),(10,10,3,1,'Farabi',7),(11,11,5,1,'raja',6),(12,12,1,1,'Mijan',17),(13,13,8,1,'razzak',2),(14,14,2,2,'Md.Bosir',3),(15,15,7,1,'Elias',4),(16,15,1,3,'Rashed',5),(17,15,5,1,'Tito',6),(18,15,3,1,'Rakib',7),(19,15,4,5,'Kamal',8),(20,16,11,1,'Rahat',14),(21,17,8,1,'jony',34),(22,18,2,1,'istiak',34),(23,19,9,2,'test',34),(24,20,9,2,'test',56);

/*Table structure for table `location` */

DROP TABLE IF EXISTS `location`;

CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `location` */

insert  into `location`(`id`,`name`) values (1,'Eon Head Office');

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`image`) values (1,'Mouse','5451d54618818.jpeg'),(2,'Keyboard','5451ae62e8591.png'),(3,'Ups','5451b0b0b3d0b.jpeg'),(4,'Ups Battery','5451b1e9dce19.jpeg'),(5,'Switch','5451badb049a9.jpeg'),(6,'Desktop','5451bb59beba7.jpeg'),(7,'Laptop','5451bbae8f2af.jpeg'),(8,'Hard Disk','5451bc0e37f73.jpeg'),(9,'Monitor','5451bc7b62e74.png'),(10,'Ram','5451bfd424ee7.jpeg'),(11,'Pen drive','5451c0092e141.jpeg'),(13,'te','no_photo.png');

/*Table structure for table `purchase` */

DROP TABLE IF EXISTS `purchase`;

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `finalized_by` int(11) DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `purchase_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `finalized_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6117D13B2ADD6D8C` (`supplier_id`),
  KEY `IDX_6117D13B64D218E` (`location_id`),
  KEY `IDX_6117D13BDE12AB56` (`created_by`),
  KEY `IDX_6117D13B16FE72E1` (`updated_by`),
  KEY `IDX_6117D13BDCA2A522` (`finalized_by`),
  CONSTRAINT `FK_6117D13B16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_6117D13B2ADD6D8C` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`),
  CONSTRAINT `FK_6117D13B64D218E` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  CONSTRAINT `FK_6117D13BDCA2A522` FOREIGN KEY (`finalized_by`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_6117D13BDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `purchase` */

insert  into `purchase`(`id`,`supplier_id`,`location_id`,`created_by`,`updated_by`,`finalized_by`,`status`,`purchase_date`,`created_at`,`updated_at`,`finalized_at`) values (1,1,1,1,NULL,1,1,'2014-08-01','2014-09-15 18:12:49',NULL,'2014-10-01 13:57:04'),(2,1,1,1,NULL,NULL,0,'2014-08-05','2014-09-15 18:13:20',NULL,NULL),(3,1,1,1,NULL,1,1,'2014-08-10','2014-09-15 18:13:47',NULL,'2014-10-01 13:57:51'),(4,1,1,1,NULL,1,1,'2014-08-15','2014-09-15 18:14:09',NULL,'2014-10-01 13:58:01'),(5,1,1,1,NULL,1,1,'2014-08-20','2014-09-15 18:14:35',NULL,'2014-10-01 13:58:08'),(6,1,1,1,NULL,1,1,'2014-08-25','2014-09-15 18:15:05',NULL,'2014-10-13 05:30:45'),(7,1,1,1,NULL,1,1,'2014-08-30','2014-09-15 18:15:29',NULL,'2014-10-13 06:15:20'),(8,1,1,1,NULL,1,1,'2014-09-01','2014-09-15 18:16:02',NULL,'2014-10-13 05:32:10'),(9,1,1,1,NULL,1,1,'2014-09-05','2014-09-15 18:16:23',NULL,'2014-10-13 06:15:27'),(10,1,1,1,NULL,1,1,'2014-09-10','2014-09-15 18:17:23',NULL,'2014-10-13 06:15:33'),(11,1,1,1,NULL,1,1,'2014-09-15','2014-09-15 18:17:47',NULL,'2014-10-13 06:14:57'),(12,1,1,1,NULL,1,1,'2014-09-16','2014-09-16 11:45:29',NULL,'2014-10-13 06:15:04'),(13,1,1,1,1,NULL,0,'2014-10-15','2014-10-11 07:42:53','2014-11-01 13:34:10',NULL),(14,1,1,1,1,1,1,'2014-10-16','2014-10-11 07:45:43','2014-11-01 13:34:53','2014-11-01 13:34:58'),(15,1,1,28,NULL,1,1,'2014-10-11','2014-10-11 12:53:56',NULL,'2014-10-14 10:20:20'),(17,1,1,6,6,6,1,'2014-10-18','2014-10-18 09:42:49','2014-10-18 09:43:06','2014-10-18 09:43:14'),(18,6,1,1,NULL,1,1,'2014-11-11','2014-11-11 09:30:31',NULL,'2014-11-11 09:30:35');

/*Table structure for table `purchase_line` */

DROP TABLE IF EXISTS `purchase_line`;

CREATE TABLE `purchase_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,0) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `manufacturer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A1A77C954584665A` (`product_id`),
  KEY `IDX_A1A77C95558FBEB9` (`purchase_id`),
  CONSTRAINT `FK_A1A77C954584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_A1A77C95558FBEB9` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `purchase_line` */

insert  into `purchase_line`(`id`,`product_id`,`purchase_id`,`quantity`,`price`,`manufacturer`) values (1,6,1,1,35000.00,'Intel'),(2,8,2,1,5000.00,'Samsung'),(3,2,3,2,800.00,'Perfect'),(4,7,4,1,30000.00,'Hp'),(5,1,5,3,1200.00,'Logitech'),(6,5,6,1,3000.00,'Tp-Link'),(7,3,7,1,3000.00,'Prolink'),(8,4,8,5,5000.00,'High-Source'),(9,6,9,1,35000.00,'Dell'),(10,8,10,1,5000.00,'Samsung'),(11,2,11,1,500.00,'Perfect'),(12,6,12,1,35000.00,'Intel'),(13,7,12,1,50000.00,'Hp'),(16,6,15,1,25000.00,'Dell'),(18,1,17,1,500.00,'Logitech'),(19,2,17,1,600.00,'Hp'),(20,2,13,1,100.00,'Perfect'),(21,9,14,23,1234.00,'12'),(22,1,18,1,400.00,'Logitech'),(23,2,18,1,400.00,'Perfect');

/*Table structure for table `search_statistics` */

DROP TABLE IF EXISTS `search_statistics`;

CREATE TABLE `search_statistics` (
  `search_id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword_search` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_search` datetime NOT NULL,
  PRIMARY KEY (`search_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `search_statistics` */

insert  into `search_statistics`(`search_id`,`keyword_search`,`date_search`) values (1,'jony','2014-11-03 18:14:22'),(2,'jony','2014-11-03 18:16:01'),(3,'jony','2014-11-03 18:16:10'),(4,'sumon','2014-11-05 08:46:41'),(5,'juel','2014-11-05 08:46:57'),(6,'mouse','2014-11-05 08:47:10'),(7,'keyboard','2014-11-05 08:47:19'),(8,'jony','2014-11-05 08:47:59'),(9,'jony','2014-11-05 08:49:22'),(10,'jony','2014-11-05 08:49:35'),(11,'jony','2014-11-05 08:49:47'),(12,'jony','2014-11-05 08:51:26'),(13,'jony','2014-11-05 08:51:48'),(14,'jony','2014-11-05 08:52:23'),(15,'jony','2014-11-05 08:54:10'),(16,'jony','2014-11-05 08:54:24'),(17,'jony','2014-11-05 08:56:36'),(18,'jony','2014-11-05 08:56:56'),(19,'jony','2014-11-05 08:57:07'),(20,'jony','2014-11-05 09:00:39'),(21,'jony','2014-11-05 09:01:06'),(22,'jony','2014-11-05 09:02:38'),(23,'jony','2014-11-05 09:02:49'),(24,'jony','2014-11-05 09:03:49'),(25,'jony','2014-11-05 09:05:10'),(26,'jony','2014-11-05 09:05:35'),(27,'jony','2014-11-05 09:05:46'),(28,'jony','2014-11-05 09:06:01'),(29,'jony','2014-11-05 09:06:19'),(30,'jony','2014-11-05 09:06:50'),(31,'jony','2014-11-05 09:07:58'),(32,'jony','2014-11-05 09:08:14'),(33,'jony','2014-11-05 09:10:41'),(34,'jony','2014-11-05 09:11:00'),(35,'jony','2014-11-05 09:13:00'),(36,'sumon','2014-11-05 09:13:41'),(37,'kothasumon','2014-11-05 09:17:30'),(38,'kotha','2014-11-05 09:17:54'),(39,'kotha','2014-11-05 09:18:02'),(40,'jony','2014-11-05 09:51:05'),(41,'jony','2014-11-08 08:58:51'),(42,'jony','2014-11-08 08:59:37'),(43,'jony','2014-11-08 09:00:03'),(44,'Mouse','2014-11-08 09:01:07'),(45,'Mouse','2014-11-08 09:02:11'),(46,'jony','2014-11-08 09:02:47'),(47,'jony','2014-11-08 10:49:29'),(48,'jony','2014-11-08 10:49:39'),(49,'mouse','2014-11-08 10:49:49'),(50,'jony','2014-11-08 10:50:37'),(51,'jony','2014-11-08 10:50:50'),(52,'jony','2014-11-08 10:51:58'),(53,'jony','2014-11-08 10:53:37'),(54,'jony','2014-11-08 10:53:43'),(55,'jony','2014-11-08 10:53:47'),(56,'jony','2014-11-08 10:53:52'),(57,'jony','2014-11-08 10:53:58'),(58,'jony','2014-11-08 10:54:07'),(59,'jony','2014-11-08 10:54:14'),(60,'jony','2014-11-08 10:54:20'),(61,'jony','2014-11-08 11:09:05'),(62,'jony','2014-11-08 11:12:20'),(63,'jony','2014-11-08 17:21:57'),(64,'jony','2014-11-10 16:48:14'),(65,'mouse','2014-11-10 16:48:27'),(66,'mouse','2014-11-10 16:48:34'),(67,'jony','2014-11-12 14:55:23'),(68,'jony','2014-11-12 14:56:02'),(69,'jony','2014-11-12 15:01:14'),(70,'jony','2014-11-12 15:03:19'),(71,'jony','2014-11-12 15:27:00'),(72,'jony','2014-11-12 15:29:24'),(73,'jony','2014-11-13 18:08:39'),(74,'jony','2014-11-13 18:08:58');

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9B2A6C7EDE12AB56` (`created_by`),
  CONSTRAINT `FK_9B2A6C7EDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `supplier` */

insert  into `supplier`(`id`,`created_by`,`name`,`address`,`created_at`) values (1,1,'Computer Source Ltd','House: 11/B, Road: 12 (New) 31 (Old)\r\nDhanmondi R/A, Dhaka-1209\r\n\r\nTel: +880-2-9127592, +880-2-9121484\r\n+880-2-9140152, \r\n+880-2-9145688, +880-2-8120578','2014-08-17 18:07:05'),(6,1,'test','this is a  test','2014-09-08 17:44:54'),(7,1,'testa','sdfsdf','2014-09-08 17:53:08'),(8,1,'test4','sfsdf','2014-09-08 18:00:05'),(9,1,'test2','sdfsdf','2014-09-08 18:00:13');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`username_canonical`,`email`,`email_canonical`,`enabled`,`salt`,`password`,`last_login`,`locked`,`expired`,`expires_at`,`confirmation_token`,`password_requested_at`,`roles`,`credentials_expired`,`credentials_expire_at`) values (1,'jony','jony','jony@localhost.com','jony@localhost.com',1,'je2bkmqe38gk880c4840k8400080soo','5tr2/n3MAFawo7yBLtqOB8s1Iwa4wjpw6hxx/6efYFYEDlkSPfmzCRkNLUNk2wJRPLEtREACdbB8K22fRK9YaA==','2014-11-13 09:04:03',0,0,NULL,NULL,NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL),(3,'sumon','sumon','sumon@localhost.com','sumon@localhost.com',0,'9xqa8jvz3rscwgccccsggocgkos0o8k','KAH4B58l1ogd8FSKneMZcw9t80gGKb2mbsoiDwMv/CVbah1JWMYxJ2slGm8lHR00J9Xqvh3mqPYZ+toEAW8Nrw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(4,'juel','juel','juel@localhost.com','juel@localhost.com',1,'82brj9rqv4sg0wcggkwwwc40wk80s0w','VOVabl+gQfsfZNnImTI2x6GwMFtDWN1/tJecqECbN5PJ26Muw7vd4Eh6GmNN2IMIDt9fKVFnpsKA2U1KyZSIKA==','2014-10-11 12:57:40',0,0,NULL,NULL,NULL,'a:2:{i:0;s:13:\"ROLE_PURCHASE\";i:1;s:10:\"ROLE_ISSUE\";}',0,NULL),(5,'jibon','jibon','jibon@localhost.com','jibon@localhost.com',1,'5nmdje39dpwccwk4040swokwwgkcsw8','7plJn67qHiPkSC9U1v9I51VWaKJck2AN8iKnq2hcOF0kAOMwEVN1h+eUh8Cb9SKrG2MNDa4f/bgPzZGReDmlOg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(6,'kotha','kotha','kotha@localhost.com','kotha@localhost.com',1,'kg57jijqwxcoc08c8kgwosko8s8ss80','GdWI1LhscJznBISl+BU6nNxiTILIDBmxYlIEBhR4uyUJGRK+47z2wJLOSAv8NBJJzdtmir4+j1aSG1QEr3RdrA==','2014-10-18 09:38:08',0,0,NULL,NULL,NULL,'a:2:{i:0;s:13:\"ROLE_PURCHASE\";i:1;s:10:\"ROLE_ISSUE\";}',0,NULL),(7,'raju','raju','raju@localhost.com','raju@localhost.com',1,'nbnreijwbv48wc40o4g0gcg88wgow88','15srOCq0hwAfb8cKvQfcjNw61jFC7o0RhM8nqy03iqVNmZ/ovtilHvlCtokkZK84279GEOSMAHAGPsv8prXF7w==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(8,'rifat','rifat','rifat@localhost.com','rifat@localhost.com',0,'9wb2n24dwiwocgsw804wsgwswk4w40s','kx1RIBRn7Ebwne/GxGYJSqQg1F+s9V0bBVnjgBIkvhTuA3nEql3yASVNhRoFo5Zw47PVKYHefj2fITMelfoMyw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(9,'rokon','rokon','rokon@localhost.com','rokon@localhost.com',1,'am0ear5ozcowg4ogsc8wksgk4w8www8','/cdWoEcmtLLojA6qY52A7mCJNY1SeY/Arx0He1ZeWQKA9mnKiC862IMNAHenSvtts/4n+8rHVmsXeJe6FTSEzA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(12,'samer','samer','samer@localhost.com','samer@localhost.com',1,'ddul6gqdt28kw8044sg48c4cgs44o0o','8rc8k6157CwJ4vV19GLD5Cu/QhkmmRmZwXAlrs9C7M3FKeYSSeKKk01LMxc+10c6+1I2w6/QKp1e7tQIb97wTQ==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(13,'zahed','zahed','zahed@localhost.com','zahed@localhost.com',1,'j48qdkxudxc0scsggscgo0ggc4ckko0','J2rGRpHCv4WRtCPzgxLtuG6PdbpHIABpxcTKQyTz2N3qxXrVfONe/0Y9RvKKDkQEviOXADG9gYiTBV9Qrne45w==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(14,'wahid','wahid','wahid@localhost.com','wahid@localhost.com',1,'i4q861gjjc8okcoc4wckc4kkcwgg0so','c26d0zD1X0Mnm6VCyQvMEZ4q4n1H2QkU9MJQ013fqXE40Klo2ZTqc5YTtCQEhZjeaB1N5oCYvm/z9JwCjPMJzw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(15,'ontu','ontu','ontu@localhost.com','ontu@localhost.com',1,'bmdzg1y0zcowoc44sg8cgkc4g0og48g','xA/nmu39x70rKEYPlEDfHlnP6jT2pySUfM9c2M8GJkNHC6uaNEW+4Rawt0rnpQKqfXblp8KBRC/S3IAd4J51rA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(16,'onu','onu','onu@localhost.com','onu@localhost.com',1,'4qksiq5misu8skc8g8o8oos4ss0s0s0','nalWDvuAMH460B4FfsaHiqbjForhOC2t3B5KfA5VhQwsPOiEOUZtKN7BfkrtSMyYKqT12PnsyiMJE+lDj3uQkA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(17,'rahat','rahat','rahat@localhost.com','rahat@localhost.com',1,'n4je5rfex9wcco8wsg0ccg88ww8s48w','RROjYmE+ijur3pNAIfNou5WOt/Ekk7KMy4XLrze4wFooVZzMxo/PJzl6U9haLgFFzF6dL60MLu6+fCh24akrNw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(18,'shibli','shibli','shibli@localhost.com','shibli@localhost.com',1,'f7jslbf9lqo8gocg4sgg0ck80088wog','WA3rPbB/Yn/2PuwiQz9/N3791ZN5KG/i9zd/v8xFVeXoD55H6TunfiWL7t3zKjCtDa7cZ24IVDrWQ1k6poBvzQ==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(19,'test','test','test@localhost.com','test@localhost.com',1,'96h0s4sz054wc8sco8k88c0ocwwogw8','LQVLdGshCOFcjXGjUaHZ98XnzhYNUnZFzkYPmLLGXXouUjroxHjg/qPIXS6BTZyq9AUUuLTsixviB84WiTn5Xg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(20,'rodh','rodh','rodh@localhost.com','rodh@localhost.com',1,'gj7sbl4kybwo04oosgsc0s84kksk48o','z195JUOhU+Duuj8TBFf4nIqrzkbnqYXeaj1RiYU2J3ws3U1rBah5lF1iaV9JuxifgkmbBTY4zR8PDkoe++uRpg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(22,'habib','habib','habib@localhost.com','habib@localhost.com',1,'gd4c6spd5qo8gskw408c8s0oc0okwgw','/MHsZJnJf2aTZegATCHnBdGe9UVFRXlABtfkJd3+5k2vJiswoJ7MXYAvt/5k45pCRxyLJXFM3n5waimyiZqTBg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(23,'almas','almas','almas@localhost.com','almas@localhost.com',1,'trwdz9yy6xc8kowgsc0s0w4k84koc0g','OeEXTBSfgqz+Fy3Yhp3kivHJh6SzMBQQ+1YBbFpA469+iUzQBSswdH+e3xSgwNjZ3+Ih484qGMgIwUVB6dJ3ug==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(24,'confirm','confirm','confirm@localhost.com','confirm@localhost.com',1,'opfj9hhcz1ck480sc884w8w4ocs4k4o','Qz4NexsVn97F8jEW/IXTgQxpHLD73xP+KlPKNMLVlzEWZj9ZUvI1SHuTjooWLXYSU7zV1LDtWymZTTV/eeV8lw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(25,'rat','rat','rat@localhost.com','rat@localhost.com',1,'kz838z54w1swgg004k4wg00gwoowccg','y2VGo3B5UVNA6PejKndd26Fp4gbT8no0Y3BnOT9/uNGtfDh6q3WTMXwzwqp/dJAdp6MZhCHcmWJaR/vk6w+nWA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(26,'qatar','qatar','qatar@localhost.com','qatar@localhost.com',1,'80mgaa3xrc848w808wkwkc800c8s88c','6RoUDx8cE7Ata4N9+iOgotJA5VL5wjASidLVALEtMvNEWdvflfA1ZP7o6lX9o/3m8UNX4d1GO9lRnf4RAsz89Q==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(28,'rony','rony','rony@localhost.com','rony@localhost.com',1,'1c48jztolccg4wcg40c0gs0s0w8w0oo','mnzKJXZxO+Tu0AzokZo6IQYN2zi6RVHhRFRRcALrZXgL7rNImtsfHaOoNkl/slNuHyT5aAQX/0rtF2SeGgcPSw==','2014-10-11 11:19:29',0,0,NULL,NULL,NULL,'a:2:{i:0;s:13:\"ROLE_PURCHASE\";i:1;s:10:\"ROLE_ISSUE\";}',0,NULL),(29,'habol','habol','habol@localhost.com','habol@localhost.com',1,'rjrxyoslbv4cgcggws8c4gwcko0oww','123456','2014-09-14 15:33:22',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

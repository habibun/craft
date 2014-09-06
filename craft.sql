/*
SQLyog Ultimate v11.11 (32 bit)
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
  `finalize_date` datetime DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `issue` */

insert  into `issue`(`id`,`from_location`,`company_id`,`depot_id`,`created_by`,`updated_by`,`finalized_by`,`issue_date`,`status`,`created_at`,`updated_at`,`finalize_date`) values (1,1,1,1,1,1,NULL,'2014-08-01',0,'2014-08-19 11:56:40','2014-08-19 12:01:07',NULL),(2,1,1,1,1,1,NULL,'2014-08-02',0,'2014-08-19 11:57:13','2014-08-19 12:01:18',NULL),(3,1,1,1,1,NULL,1,'2014-08-19',1,'2014-08-19 11:58:47','2014-08-19 11:58:51','2014-08-19 11:58:51'),(4,1,1,1,1,NULL,NULL,'2014-08-19',0,'2014-08-19 11:59:14',NULL,NULL),(5,1,1,1,1,NULL,1,'2014-08-19',1,'2014-08-19 11:59:35','2014-08-19 11:59:38','2014-08-19 11:59:38'),(6,1,1,1,1,NULL,1,'2014-08-19',1,'2014-08-19 12:00:02','2014-08-19 12:00:08','2014-08-19 12:00:08'),(7,1,1,1,1,NULL,1,'2014-08-19',1,'2014-08-19 12:00:24','2014-08-19 12:00:27','2014-08-19 12:00:27'),(8,1,1,1,1,NULL,1,'2014-08-19',1,'2014-08-19 12:00:50','2014-08-19 12:00:53','2014-08-19 12:00:53'),(9,1,1,1,1,NULL,1,'2014-08-05',1,'2014-08-19 12:01:53','2014-08-19 12:01:56','2014-08-19 12:01:56'),(10,1,1,1,1,NULL,1,'2014-08-30',1,'2014-08-30 10:14:06','2014-08-30 10:14:12','2014-08-30 10:14:12'),(11,1,1,1,1,NULL,NULL,'2014-08-30',0,'2014-08-30 11:27:28',NULL,NULL),(12,1,1,1,1,NULL,NULL,'2014-08-30',0,'2014-08-30 11:30:53',NULL,NULL);

/*Table structure for table `issue_line` */

DROP TABLE IF EXISTS `issue_line`;

CREATE TABLE `issue_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `issueTo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `referenceNumber` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_89F37C3A5E7AA58C` (`issue_id`),
  KEY `IDX_89F37C3A4584665A` (`product_id`),
  CONSTRAINT `FK_89F37C3A4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_89F37C3A5E7AA58C` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `issue_line` */

insert  into `issue_line`(`id`,`issue_id`,`product_id`,`quantity`,`issueTo`,`referenceNumber`) values (1,11,1,1.0000,'jony',4),(2,12,6,2.0000,'rakib',2);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product` */

insert  into `product`(`id`,`name`) values (1,'Mouse'),(2,'Keyboard'),(3,'Ups'),(4,'Ups-Battery'),(5,'Switch'),(6,'Desktop'),(7,'Laptop');

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
  `finalize_date` datetime DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `purchase` */

insert  into `purchase`(`id`,`supplier_id`,`location_id`,`created_by`,`updated_by`,`finalized_by`,`status`,`purchase_date`,`created_at`,`updated_at`,`finalize_date`) values (1,1,1,1,1,NULL,0,'2014-08-01','2014-08-19 11:36:36','2014-08-19 11:36:45',NULL),(2,1,1,1,NULL,NULL,0,'2014-08-02','2014-08-19 11:38:56',NULL,NULL),(3,1,1,1,NULL,NULL,0,'2014-08-03','2014-08-19 11:39:12',NULL,NULL),(4,1,1,1,NULL,1,1,'2014-08-04','2014-08-19 11:39:33','2014-08-19 11:39:37','2014-08-19 11:39:37'),(5,1,1,1,NULL,NULL,0,'2014-08-05','2014-08-19 11:39:52',NULL,NULL),(6,1,1,1,NULL,1,1,'2014-08-06','2014-08-19 11:40:09','2014-08-19 11:40:12','2014-08-19 11:40:12'),(7,1,1,1,NULL,NULL,0,'2014-08-08','2014-08-19 11:40:30',NULL,NULL),(8,1,1,1,NULL,1,1,'2014-08-09','2014-08-19 11:40:47','2014-08-19 11:40:50','2014-08-19 11:40:50'),(9,1,1,1,NULL,1,1,'2014-08-10','2014-08-19 11:41:13','2014-08-19 11:41:16','2014-08-19 11:41:16'),(10,1,1,1,NULL,1,1,'2014-08-12','2014-08-19 11:41:32','2014-08-19 11:41:35','2014-08-19 11:41:35'),(11,1,1,1,NULL,1,1,'2014-08-16','2014-08-19 11:41:48','2014-08-19 11:41:51','2014-08-19 11:41:51'),(12,1,1,1,NULL,1,1,'2014-08-17','2014-08-19 11:42:16','2014-08-19 11:42:19','2014-08-19 11:42:19'),(13,1,1,1,NULL,NULL,0,'2014-08-30','2014-08-30 10:33:15',NULL,NULL);

/*Table structure for table `purchase_line` */

DROP TABLE IF EXISTS `purchase_line`;

CREATE TABLE `purchase_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A1A77C954584665A` (`product_id`),
  KEY `IDX_A1A77C95558FBEB9` (`purchase_id`),
  CONSTRAINT `FK_A1A77C954584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_A1A77C95558FBEB9` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `purchase_line` */

insert  into `purchase_line`(`id`,`product_id`,`purchase_id`,`quantity`,`price`) values (1,6,1,1.00,100.00),(2,6,2,1.00,35000.00),(3,7,3,1.00,35000.00),(4,1,4,2.00,600.00),(5,5,5,2.00,6000.00),(6,3,6,3.00,9000.00),(7,4,7,5.00,5000.00),(8,6,8,2.00,90000.00),(9,2,9,1.00,300.00),(10,1,10,1.00,400.00),(11,1,11,3.00,900.00),(12,1,12,3.00,900.00),(13,2,12,2.00,800.00),(14,6,13,2.00,60000.00);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `supplier` */

insert  into `supplier`(`id`,`created_by`,`name`,`address`,`created_at`) values (1,NULL,'Computer Source Ltd','House: 11/B, Road: 12 (New) 31 (Old)\r\nDhanmondi R/A, Dhaka-1209\r\n\r\nTel: +880-2-9127592, +880-2-9121484\r\n+880-2-9140152, \r\n+880-2-9145688, +880-2-8120578','2014-08-17 18:07:05'),(2,NULL,'testa','sdfsdf','2014-08-17 18:08:09'),(5,NULL,'test3','test3','2014-08-18 16:27:20');

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`username_canonical`,`email`,`email_canonical`,`enabled`,`salt`,`password`,`last_login`,`locked`,`expired`,`expires_at`,`confirmation_token`,`password_requested_at`,`roles`,`credentials_expired`,`credentials_expire_at`) values (1,'jony','jony','jony@localhost.com','jony@localhost.com',1,'je2bkmqe38gk880c4840k8400080soo','5tr2/n3MAFawo7yBLtqOB8s1Iwa4wjpw6hxx/6efYFYEDlkSPfmzCRkNLUNk2wJRPLEtREACdbB8K22fRK9YaA==','2014-08-30 09:00:18',0,0,NULL,NULL,NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL),(2,'rony','rony','rony@localhost.com','rony@localhost.com',1,'jm1mc0h12jkg8g8ogsco84c0c044048','s/3akHqyAuCFe5NYd6TYwgLSel54ZQxriZVEOiF31oDwhuUjrSxgDWrdEmmr9d8DzEGAi53lYK6tXGdv0AUpLw==','2014-08-10 10:46:16',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(3,'sumon','sumon','sumon@localhost.com','sumon@localhost.com',0,'9xqa8jvz3rscwgccccsggocgkos0o8k','KAH4B58l1ogd8FSKneMZcw9t80gGKb2mbsoiDwMv/CVbah1JWMYxJ2slGm8lHR00J9Xqvh3mqPYZ+toEAW8Nrw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(4,'juel','juel','juel@localhost.com','juel@localhost.com',1,'82brj9rqv4sg0wcggkwwwc40wk80s0w','VOVabl+gQfsfZNnImTI2x6GwMFtDWN1/tJecqECbN5PJ26Muw7vd4Eh6GmNN2IMIDt9fKVFnpsKA2U1KyZSIKA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(5,'jibon','jibon','jibon@localhost.com','jibon@localhost.com',1,'5nmdje39dpwccwk4040swokwwgkcsw8','7plJn67qHiPkSC9U1v9I51VWaKJck2AN8iKnq2hcOF0kAOMwEVN1h+eUh8Cb9SKrG2MNDa4f/bgPzZGReDmlOg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(6,'kotha','kotha','kotha@localhost.com','kotha@localhost.com',1,'kg57jijqwxcoc08c8kgwosko8s8ss80','GdWI1LhscJznBISl+BU6nNxiTILIDBmxYlIEBhR4uyUJGRK+47z2wJLOSAv8NBJJzdtmir4+j1aSG1QEr3RdrA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(7,'raju','raju','raju@localhost.com','raju@localhost.com',1,'nbnreijwbv48wc40o4g0gcg88wgow88','15srOCq0hwAfb8cKvQfcjNw61jFC7o0RhM8nqy03iqVNmZ/ovtilHvlCtokkZK84279GEOSMAHAGPsv8prXF7w==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(8,'rifat','rifat','rifat@localhost.com','rifat@localhost.com',0,'9wb2n24dwiwocgsw804wsgwswk4w40s','kx1RIBRn7Ebwne/GxGYJSqQg1F+s9V0bBVnjgBIkvhTuA3nEql3yASVNhRoFo5Zw47PVKYHefj2fITMelfoMyw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(9,'rokon','rokon','rokon@localhost.com','rokon@localhost.com',1,'am0ear5ozcowg4ogsc8wksgk4w8www8','/cdWoEcmtLLojA6qY52A7mCJNY1SeY/Arx0He1ZeWQKA9mnKiC862IMNAHenSvtts/4n+8rHVmsXeJe6FTSEzA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(12,'samer','samer','samer@localhost.com','samer@localhost.com',1,'ddul6gqdt28kw8044sg48c4cgs44o0o','8rc8k6157CwJ4vV19GLD5Cu/QhkmmRmZwXAlrs9C7M3FKeYSSeKKk01LMxc+10c6+1I2w6/QKp1e7tQIb97wTQ==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(13,'zahed','zahed','zahed@localhost.com','zahed@localhost.com',1,'j48qdkxudxc0scsggscgo0ggc4ckko0','J2rGRpHCv4WRtCPzgxLtuG6PdbpHIABpxcTKQyTz2N3qxXrVfONe/0Y9RvKKDkQEviOXADG9gYiTBV9Qrne45w==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(14,'wahid','wahid','wahid@localhost.com','wahid@localhost.com',1,'i4q861gjjc8okcoc4wckc4kkcwgg0so','c26d0zD1X0Mnm6VCyQvMEZ4q4n1H2QkU9MJQ013fqXE40Klo2ZTqc5YTtCQEhZjeaB1N5oCYvm/z9JwCjPMJzw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(15,'ontu','ontu','ontu@localhost.com','ontu@localhost.com',1,'bmdzg1y0zcowoc44sg8cgkc4g0og48g','xA/nmu39x70rKEYPlEDfHlnP6jT2pySUfM9c2M8GJkNHC6uaNEW+4Rawt0rnpQKqfXblp8KBRC/S3IAd4J51rA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(16,'onu','onu','onu@localhost.com','onu@localhost.com',1,'4qksiq5misu8skc8g8o8oos4ss0s0s0','nalWDvuAMH460B4FfsaHiqbjForhOC2t3B5KfA5VhQwsPOiEOUZtKN7BfkrtSMyYKqT12PnsyiMJE+lDj3uQkA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(17,'rahat','rahat','rahat@localhost.com','rahat@localhost.com',1,'n4je5rfex9wcco8wsg0ccg88ww8s48w','RROjYmE+ijur3pNAIfNou5WOt/Ekk7KMy4XLrze4wFooVZzMxo/PJzl6U9haLgFFzF6dL60MLu6+fCh24akrNw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(18,'shibli','shibli','shibli@localhost.com','shibli@localhost.com',1,'f7jslbf9lqo8gocg4sgg0ck80088wog','WA3rPbB/Yn/2PuwiQz9/N3791ZN5KG/i9zd/v8xFVeXoD55H6TunfiWL7t3zKjCtDa7cZ24IVDrWQ1k6poBvzQ==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(19,'test','test','test@localhost.com','test@localhost.com',1,'96h0s4sz054wc8sco8k88c0ocwwogw8','LQVLdGshCOFcjXGjUaHZ98XnzhYNUnZFzkYPmLLGXXouUjroxHjg/qPIXS6BTZyq9AUUuLTsixviB84WiTn5Xg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(20,'rodh','rodh','rodh@localhost.com','rodh@localhost.com',1,'gj7sbl4kybwo04oosgsc0s84kksk48o','z195JUOhU+Duuj8TBFf4nIqrzkbnqYXeaj1RiYU2J3ws3U1rBah5lF1iaV9JuxifgkmbBTY4zR8PDkoe++uRpg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(22,'habib','habib','habib@localhost.com','habib@localhost.com',1,'gd4c6spd5qo8gskw408c8s0oc0okwgw','/MHsZJnJf2aTZegATCHnBdGe9UVFRXlABtfkJd3+5k2vJiswoJ7MXYAvt/5k45pCRxyLJXFM3n5waimyiZqTBg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(23,'almas','almas','almas@localhost.com','almas@localhost.com',1,'trwdz9yy6xc8kowgsc0s0w4k84koc0g','OeEXTBSfgqz+Fy3Yhp3kivHJh6SzMBQQ+1YBbFpA469+iUzQBSswdH+e3xSgwNjZ3+Ih484qGMgIwUVB6dJ3ug==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

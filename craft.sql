/*
SQLyog Ultimate v11.11 (32 bit)
MySQL - 5.6.21 : Database - craft
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

/*Table structure for table `email` */

DROP TABLE IF EXISTS `email`;

CREATE TABLE `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E7927C74DE12AB56` (`created_by`),
  CONSTRAINT `FK_E7927C74DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `fos_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `email` */

insert  into `email`(`id`,`email`,`created_at`,`status`,`created_by`) values (1,'mrinmoy@eongroup.net.bd','2014-12-15 23:16:47',1,1),(2,'roton@eongroup.net.bd','2014-12-15 23:20:19',1,12),(3,'sumon@eongroup.net.bd','2014-12-15 23:29:18',0,3),(4,'rokon@eongroup.net.bd','2014-12-15 23:29:59',1,4),(5,'rasel@eongroup.net.bd','2014-12-15 23:30:27',1,5),(6,'raihan@eongroup.net.bd','2014-12-15 23:35:45',0,6),(7,'jony@eongroup.net.bd','2014-12-15 23:39:25',1,7),(8,'jibon@eongroup.net.bd','2014-12-16 02:39:36',1,8),(9,'juel@eongroup.net.bd','2014-12-16 02:40:23',1,9),(10,'sristy@eongroup.net.bd','2014-12-16 02:40:50',1,12),(11,'rony@eongroup.net.bd','2014-12-16 02:41:20',1,8),(12,'test12@eongroup.net.bd','2015-05-02 09:05:10',1,1),(13,'test13@eongroup.net.bd','2015-05-02 09:05:38',1,1);

/*Table structure for table `fos_group` */

DROP TABLE IF EXISTS `fos_group`;

CREATE TABLE `fos_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4B019DDB5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `fos_group` */

/*Table structure for table `fos_user` */

DROP TABLE IF EXISTS `fos_user`;

CREATE TABLE `fos_user` (
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
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `fos_user` */

insert  into `fos_user`(`id`,`username`,`username_canonical`,`email`,`email_canonical`,`enabled`,`salt`,`password`,`last_login`,`locked`,`expired`,`expires_at`,`confirmation_token`,`password_requested_at`,`roles`,`credentials_expired`,`credentials_expire_at`,`image`,`created_by`,`created_at`) values (1,'jony','jony','jony@localhost.com','jony@localhost.com',1,'je2bkmqe38gk880c4840k8400080soo','5tr2/n3MAFawo7yBLtqOB8s1Iwa4wjpw6hxx/6efYFYEDlkSPfmzCRkNLUNk2wJRPLEtREACdbB8K22fRK9YaA==','2015-05-01 18:57:57',0,0,NULL,NULL,NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL,'546dafba80493.jpeg','admin','2014-08-01 15:10:37'),(3,'sumon','sumon','sumon@localhost.com','sumon@localhost.com',0,'9xqa8jvz3rscwgccccsggocgkos0o8k','KAH4B58l1ogd8FSKneMZcw9t80gGKb2mbsoiDwMv/CVbah1JWMYxJ2slGm8lHR00J9Xqvh3mqPYZ+toEAW8Nrw==',NULL,0,0,NULL,NULL,NULL,'a:4:{i:0;s:13:\"ROLE_PURCHASE\";i:1;s:10:\"ROLE_ISSUE\";i:2;s:10:\"ROLE_SETUP\";i:3;s:11:\"ROLE_REPORT\";}',0,NULL,'userDefaultLogo.png','','2014-09-01 15:10:58'),(4,'juel','juel','juel@localhost.com','juel@localhost.com',1,'82brj9rqv4sg0wcggkwwwc40wk80s0w','VOVabl+gQfsfZNnImTI2x6GwMFtDWN1/tJecqECbN5PJ26Muw7vd4Eh6GmNN2IMIDt9fKVFnpsKA2U1KyZSIKA==','2014-11-27 11:02:34',0,0,NULL,NULL,NULL,'a:2:{i:0;s:13:\"ROLE_PURCHASE\";i:1;s:10:\"ROLE_ISSUE\";}',0,NULL,'userDefaultLogo.png','','2014-11-08 15:11:06'),(5,'jibon','jibon','jibon@localhost.com','jibon@localhost.com',1,'5nmdje39dpwccwk4040swokwwgkcsw8','7plJn67qHiPkSC9U1v9I51VWaKJck2AN8iKnq2hcOF0kAOMwEVN1h+eUh8Cb9SKrG2MNDa4f/bgPzZGReDmlOg==','2014-11-20 16:34:04',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-08-24 15:11:11'),(6,'kotha','kotha','kotha@localhost.com','kotha@localhost.com',1,'kg57jijqwxcoc08c8kgwosko8s8ss80','GdWI1LhscJznBISl+BU6nNxiTILIDBmxYlIEBhR4uyUJGRK+47z2wJLOSAv8NBJJzdtmir4+j1aSG1QEr3RdrA==','2014-11-20 16:34:45',0,0,NULL,NULL,NULL,'a:2:{i:0;s:13:\"ROLE_PURCHASE\";i:1;s:10:\"ROLE_ISSUE\";}',0,NULL,'userDefaultLogo.png','','2014-08-17 15:11:16'),(7,'raju','raju','raju@localhost.com','raju@localhost.com',1,'nbnreijwbv48wc40o4g0gcg88wgow88','15srOCq0hwAfb8cKvQfcjNw61jFC7o0RhM8nqy03iqVNmZ/ovtilHvlCtokkZK84279GEOSMAHAGPsv8prXF7w==','2014-11-20 16:34:59',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-09-08 15:11:34'),(8,'rifat','rifat','rifat@localhost.com','rifat@localhost.com',0,'9wb2n24dwiwocgsw804wsgwswk4w40s','kx1RIBRn7Ebwne/GxGYJSqQg1F+s9V0bBVnjgBIkvhTuA3nEql3yASVNhRoFo5Zw47PVKYHefj2fITMelfoMyw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-09-26 15:11:58'),(9,'rokon','rokon','rokon@localhost.com','rokon@localhost.com',1,'am0ear5ozcowg4ogsc8wksgk4w8www8','/cdWoEcmtLLojA6qY52A7mCJNY1SeY/Arx0He1ZeWQKA9mnKiC862IMNAHenSvtts/4n+8rHVmsXeJe6FTSEzA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-09-22 15:12:04'),(12,'samer','samer','samer@localhost.com','samer@localhost.com',1,'ddul6gqdt28kw8044sg48c4cgs44o0o','8rc8k6157CwJ4vV19GLD5Cu/QhkmmRmZwXAlrs9C7M3FKeYSSeKKk01LMxc+10c6+1I2w6/QKp1e7tQIb97wTQ==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-09-30 15:12:09'),(13,'zahed','zahed','zahed@localhost.com','zahed@localhost.com',1,'j48qdkxudxc0scsggscgo0ggc4ckko0','J2rGRpHCv4WRtCPzgxLtuG6PdbpHIABpxcTKQyTz2N3qxXrVfONe/0Y9RvKKDkQEviOXADG9gYiTBV9Qrne45w==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-08-19 15:12:12'),(14,'wahid','wahid','wahid@localhost.com','wahid@localhost.com',1,'i4q861gjjc8okcoc4wckc4kkcwgg0so','c26d0zD1X0Mnm6VCyQvMEZ4q4n1H2QkU9MJQ013fqXE40Klo2ZTqc5YTtCQEhZjeaB1N5oCYvm/z9JwCjPMJzw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-09-22 15:12:23'),(15,'ontu','ontu','ontu@localhost.com','ontu@localhost.com',1,'bmdzg1y0zcowoc44sg8cgkc4g0og48g','xA/nmu39x70rKEYPlEDfHlnP6jT2pySUfM9c2M8GJkNHC6uaNEW+4Rawt0rnpQKqfXblp8KBRC/S3IAd4J51rA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-09-28 15:12:28'),(16,'onu','onu','onu@localhost.com','onu@localhost.com',1,'4qksiq5misu8skc8g8o8oos4ss0s0s0','nalWDvuAMH460B4FfsaHiqbjForhOC2t3B5KfA5VhQwsPOiEOUZtKN7BfkrtSMyYKqT12PnsyiMJE+lDj3uQkA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-08-17 15:12:31'),(17,'rahat','rahat','rahat@localhost.com','rahat@localhost.com',1,'n4je5rfex9wcco8wsg0ccg88ww8s48w','RROjYmE+ijur3pNAIfNou5WOt/Ekk7KMy4XLrze4wFooVZzMxo/PJzl6U9haLgFFzF6dL60MLu6+fCh24akrNw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-08-25 15:12:35'),(18,'shibli','shibli','shibli@localhost.com','shibli@localhost.com',1,'f7jslbf9lqo8gocg4sgg0ck80088wog','WA3rPbB/Yn/2PuwiQz9/N3791ZN5KG/i9zd/v8xFVeXoD55H6TunfiWL7t3zKjCtDa7cZ24IVDrWQ1k6poBvzQ==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-07-13 15:12:44'),(19,'test','test','test@localhost.com','test@localhost.com',1,'96h0s4sz054wc8sco8k88c0ocwwogw8','LQVLdGshCOFcjXGjUaHZ98XnzhYNUnZFzkYPmLLGXXouUjroxHjg/qPIXS6BTZyq9AUUuLTsixviB84WiTn5Xg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-07-28 15:12:48'),(20,'rodh','rodh','rodh@localhost.com','rodh@localhost.com',1,'gj7sbl4kybwo04oosgsc0s84kksk48o','z195JUOhU+Duuj8TBFf4nIqrzkbnqYXeaj1RiYU2J3ws3U1rBah5lF1iaV9JuxifgkmbBTY4zR8PDkoe++uRpg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-08-11 15:12:51'),(22,'habib','habib','habib@localhost.com','habib@localhost.com',1,'gd4c6spd5qo8gskw408c8s0oc0okwgw','/MHsZJnJf2aTZegATCHnBdGe9UVFRXlABtfkJd3+5k2vJiswoJ7MXYAvt/5k45pCRxyLJXFM3n5waimyiZqTBg==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-11-09 15:12:57'),(23,'almas','almas','almas@localhost.com','almas@localhost.com',1,'trwdz9yy6xc8kowgsc0s0w4k84koc0g','OeEXTBSfgqz+Fy3Yhp3kivHJh6SzMBQQ+1YBbFpA469+iUzQBSswdH+e3xSgwNjZ3+Ih484qGMgIwUVB6dJ3ug==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-06-23 15:12:23'),(24,'confirm','confirm','confirm@localhost.com','confirm@localhost.com',1,'opfj9hhcz1ck480sc884w8w4ocs4k4o','Qz4NexsVn97F8jEW/IXTgQxpHLD73xP+KlPKNMLVlzEWZj9ZUvI1SHuTjooWLXYSU7zV1LDtWymZTTV/eeV8lw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-09-22 15:13:39'),(25,'rat','rat','rat@localhost.com','rat@localhost.com',1,'kz838z54w1swgg004k4wg00gwoowccg','y2VGo3B5UVNA6PejKndd26Fp4gbT8no0Y3BnOT9/uNGtfDh6q3WTMXwzwqp/dJAdp6MZhCHcmWJaR/vk6w+nWA==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-08-17 15:13:48'),(26,'qatar','qatar','qatar@localhost.com','qatar@localhost.com',1,'80mgaa3xrc848w808wkwkc800c8s88c','6RoUDx8cE7Ata4N9+iOgotJA5VL5wjASidLVALEtMvNEWdvflfA1ZP7o6lX9o/3m8UNX4d1GO9lRnf4RAsz89Q==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','','2014-08-25 15:13:52'),(28,'rony','rony','rony@localhost.com','rony@localhost.com',1,'1c48jztolccg4wcg40c0gs0s0w8w0oo','mnzKJXZxO+Tu0AzokZo6IQYN2zi6RVHhRFRRcALrZXgL7rNImtsfHaOoNkl/slNuHyT5aAQX/0rtF2SeGgcPSw==','2014-10-11 11:19:29',0,0,NULL,NULL,NULL,'a:2:{i:0;s:13:\"ROLE_PURCHASE\";i:1;s:10:\"ROLE_ISSUE\";}',0,NULL,'userDefaultLogo.png','','2014-06-23 15:13:56'),(34,'testing21@localhost.com','testing21@localhost.com','testing21@localhost.com','testing21@localhost.com',1,'deegyuuglxk4cgg88wkkcgk0o0ksks8','0TtHPdhb2kS3McOhk0qRBk2nW7vm6FpZp9Tdf2QEvTeB9x7J+Wfw2/wPSh4E8cD28Z5ib8dOWWYSEFffOua/pw==',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','jony','2014-11-20 16:29:11'),(35,'admin','admin','admin@localhost.com','admin@localhost.com',1,'gryqdnot0rccgk0g0wc0k48kcoccg48','h5QAB8phz9t5E73mekichxa52mXZrzr/5Yw6T9IjkM6SqfisDG5xNApuXJcFuQSvvVuArU/ICs97VreMU9+6Ew==','2015-03-27 06:37:44',0,0,NULL,NULL,NULL,'a:7:{i:0;s:13:\"ROLE_PURCHASE\";i:1;s:10:\"ROLE_ISSUE\";i:2;s:12:\"ROLE_HISTORY\";i:3;s:10:\"ROLE_SETUP\";i:4;s:11:\"ROLE_REPORT\";i:5;s:10:\"ROLE_ADMIN\";i:6;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL,'userDefaultLogo.png','jony','2014-11-26 15:43:23'),(36,'testing25','testing25','testing25@localhost.com','testing25@localhost.com',1,'p6e6uiuhuj4ccgg40gkscs4s4gkwkkk','8D/CKxv9CYHo1zjookUPKrCKWzDCBiuMRO+ubsmPhGZx+D5D5aBTYB3p+XLu4pxA3Erms+rIEBo1JJTeq7PUaA==','2014-11-27 10:07:11',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','admin','2014-11-27 10:06:08'),(37,'testing26','testing26','testing26@localhost.com','testing26@localhost.com',1,'2kyxa444n5448o8kgccgooggoc40o80','+v7mkVjMCshesg2TWMWfkOYnE/VWDhXlqS+mQIQoO+E2If76aFcoQnsDvCkTxw8UYwtKTqlYBQ17NexQ7aH1LQ==','2014-11-27 10:17:11',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','admin','2014-11-27 10:11:30'),(38,'testing27','testing27','testing27@localhost.com','testing27@localhost.com',1,'47tjoabbmq80ckcoookw8c0cgk4w8o4','wA4NVvCswufxp5PHVyD0P9wzfZx75va0oEfHIdHQmDuBam5eDyIYb3pgV1mN8johM5pleN3DMWHByi6ZD+Grvw==','2014-11-27 11:19:27',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'userDefaultLogo.png','admin','2014-11-27 10:20:43');

/*Table structure for table `fos_user_group` */

DROP TABLE IF EXISTS `fos_user_group`;

CREATE TABLE `fos_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `IDX_583D1F3EA76ED395` (`user_id`),
  KEY `IDX_583D1F3EFE54D947` (`group_id`),
  CONSTRAINT `FK_583D1F3EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_583D1F3EFE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `fos_user_group` */

/*Table structure for table `invoice` */

DROP TABLE IF EXISTS `invoice`;

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_90651744DE12AB56` (`created_by`),
  CONSTRAINT `FK_90651744DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `fos_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `invoice` */

insert  into `invoice`(`id`,`created_by`,`name`,`address`,`invoice_date`,`invoice_status`,`created_at`) values (1,1,'testing1','testing1','2015-04-14','paid','2015-03-17 18:07:52'),(2,1,'testing2','testing2','2015-02-19','paid','2015-03-17 18:09:47'),(3,7,'testing3','testing3','2015-03-17','pending','2015-03-17 18:14:49'),(4,1,'testing4','testing4','2015-01-15','paid','2015-03-17 18:17:11'),(5,3,'testing5','testing5','2015-01-26','paid','2015-03-17 18:19:20'),(6,4,'testing6','testing6','2015-03-07','pending','2015-03-17 18:20:49'),(7,1,'testing7','testing7','2015-02-01','paid','2015-03-17 18:21:49'),(8,1,'testing8','testing8','2015-03-17','paid','2015-03-17 18:22:57'),(9,6,'testing9','testing9','2015-05-01','pending','2015-03-17 18:24:09'),(10,5,'testing10','testing10','2015-05-21','paid','2015-03-17 18:25:04'),(11,1,'testing10','testing11','2014-08-20','pending','2015-03-17 18:25:57'),(12,1,'testing 12','testing 12','2015-05-01','paid','2015-03-28 05:22:03');

/*Table structure for table `invoice_line` */

DROP TABLE IF EXISTS `invoice_line`;

CREATE TABLE `invoice_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D3D1D6932989F1FD` (`invoice_id`),
  CONSTRAINT `FK_D3D1D6932989F1FD` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `invoice_line` */

insert  into `invoice_line`(`id`,`invoice_id`,`description`,`unit_price`,`quantity`) values (1,1,'test',200.00,2),(2,2,'asdfsdf',300.00,2),(3,2,'asdf',300.00,3),(4,3,'sdfsdf',400.00,3),(5,4,'sadfsdf',666.00,2),(6,5,'sdfsdf',333.00,3),(7,6,'dsff',222.00,2),(8,7,'sdsd',555.00,5),(9,8,'sdfsdf',333.00,3),(10,9,'sdfsdf',444.00,4),(11,10,'sdfsdf',444.00,4),(12,11,'sdfsdf',777.00,7),(13,12,'sdfsdf',200.00,3);

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
  CONSTRAINT `FK_12AD233E16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_12AD233E18716951` FOREIGN KEY (`from_location`) REFERENCES `location` (`id`),
  CONSTRAINT `FK_12AD233E8510D4DE` FOREIGN KEY (`depot_id`) REFERENCES `depot` (`id`),
  CONSTRAINT `FK_12AD233E979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_12AD233EDCA2A522` FOREIGN KEY (`finalized_by`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_12AD233EDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `fos_user` (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`image`) values (1,'Mouse','5451d54618818.jpeg'),(2,'Keyboard','5451ae62e8591.png'),(3,'Ups','5451b0b0b3d0b.jpeg'),(4,'Ups Battery','5451b1e9dce19.jpeg'),(5,'Switch','5451badb049a9.jpeg'),(6,'Desktop','5451bb59beba7.jpeg'),(7,'Laptop','5451bbae8f2af.jpeg'),(8,'Hard Disk','5451bc0e37f73.jpeg'),(9,'Monitor','5451bc7b62e74.png'),(10,'Ram','5451bfd424ee7.jpeg'),(11,'Pen drive','5451c0092e141.jpeg');

/*Table structure for table `purchase` */

DROP TABLE IF EXISTS `purchase`;

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `finalized_by` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
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
  CONSTRAINT `FK_6117D13B16FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_6117D13B2ADD6D8C` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`),
  CONSTRAINT `FK_6117D13B64D218E` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  CONSTRAINT `FK_6117D13BDCA2A522` FOREIGN KEY (`finalized_by`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_6117D13BDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `fos_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `purchase` */

insert  into `purchase`(`id`,`supplier_id`,`location_id`,`created_by`,`updated_by`,`finalized_by`,`status`,`purchase_date`,`created_at`,`updated_at`,`finalized_at`) values (1,1,1,1,NULL,1,1,'2014-08-01','2014-09-15 18:12:49',NULL,'2014-10-01 13:57:04'),(2,1,1,1,NULL,NULL,0,'2014-08-05','2014-09-15 18:13:20',NULL,NULL),(3,1,1,1,NULL,1,1,'2014-08-10','2014-09-15 18:13:47',NULL,'2014-10-01 13:57:51'),(4,1,1,1,NULL,NULL,0,'2014-08-15','2014-09-15 18:14:09',NULL,NULL),(5,1,1,1,NULL,1,1,'2014-08-20','2014-09-15 18:14:35',NULL,'2014-10-01 13:58:08'),(6,1,1,1,NULL,1,1,'2014-08-25','2014-09-15 18:15:05',NULL,'2014-10-13 05:30:45'),(7,1,1,1,NULL,1,1,'2014-08-30','2014-09-15 18:15:29',NULL,'2014-10-13 06:15:20'),(8,1,1,1,NULL,1,1,'2014-09-01','2014-09-15 18:16:02',NULL,'2014-10-13 05:32:10'),(9,1,1,1,NULL,1,1,'2014-09-05','2014-09-15 18:16:23',NULL,'2014-10-13 06:15:27'),(10,1,1,1,NULL,1,1,'2014-09-10','2014-09-15 18:17:23',NULL,'2014-10-13 06:15:33'),(11,1,1,1,NULL,1,1,'2014-09-15','2014-09-15 18:17:47',NULL,'2014-10-13 06:14:57'),(12,1,1,1,NULL,1,1,'2014-09-16','2014-09-16 11:45:29',NULL,'2014-10-13 06:15:04'),(13,1,1,1,1,NULL,0,'2014-10-15','2014-10-11 07:42:53','2014-11-01 13:34:10',NULL),(14,1,1,1,1,1,1,'2014-10-16','2014-10-11 07:45:43','2014-11-01 13:34:53','2014-11-01 13:34:58'),(15,1,1,28,NULL,1,1,'2014-10-11','2014-10-11 12:53:56',NULL,'2014-10-14 10:20:20'),(17,1,1,6,6,6,1,'2014-10-18','2014-10-18 09:42:49','2014-10-18 09:43:06','2014-10-18 09:43:14'),(18,6,1,1,NULL,1,1,'2014-11-11','2014-11-11 09:30:31',NULL,'2014-11-11 09:30:35'),(19,1,1,1,NULL,1,1,'2014-11-16','2014-11-16 09:08:05',NULL,'2014-11-16 09:08:11'),(20,1,1,1,NULL,NULL,0,'2014-11-16','2014-11-16 09:45:03',NULL,NULL),(21,1,1,1,NULL,NULL,0,'2014-11-16','2014-11-16 09:47:25',NULL,NULL),(22,8,1,1,NULL,NULL,0,'2014-11-16','2014-11-16 09:48:34',NULL,NULL),(23,8,1,1,NULL,1,1,'2014-11-16','2014-11-16 09:54:10',NULL,'2014-11-16 09:54:51'),(24,1,1,1,NULL,1,1,'2014-11-16','2014-11-16 10:00:52',NULL,'2014-11-16 10:00:55'),(25,6,1,35,NULL,35,1,'2014-11-04','2014-11-27 09:21:11',NULL,'2014-11-27 09:21:24'),(26,6,1,35,NULL,35,1,'2014-11-13','2014-11-27 09:28:41',NULL,'2014-11-27 09:28:44'),(27,6,1,35,35,NULL,0,'2014-11-27','2014-11-27 09:29:40','2014-11-27 09:31:05',NULL);

/*Table structure for table `purchase_line` */

DROP TABLE IF EXISTS `purchase_line`;

CREATE TABLE `purchase_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `manufacturer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A1A77C954584665A` (`product_id`),
  KEY `IDX_A1A77C95558FBEB9` (`purchase_id`),
  CONSTRAINT `FK_A1A77C954584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_A1A77C95558FBEB9` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `purchase_line` */

insert  into `purchase_line`(`id`,`product_id`,`purchase_id`,`quantity`,`price`,`manufacturer`) values (1,6,1,1,35000.00,'Intel'),(2,8,2,1,5000.00,'Samsung'),(3,2,3,2,800.00,'Perfect'),(4,7,4,1,30000.00,'Hp'),(5,1,5,3,1200.00,'Logitech'),(6,5,6,1,3000.00,'Tp-Link'),(7,3,7,1,3000.00,'Prolink'),(8,4,8,5,5000.00,'High-Source'),(9,6,9,1,35000.00,'Dell'),(10,8,10,1,5000.00,'Samsung'),(11,2,11,1,500.00,'Perfect'),(12,6,12,1,35000.00,'Intel'),(13,7,12,1,50000.00,'Hp'),(16,6,15,1,25000.00,'Dell'),(18,1,17,1,500.00,'Logitech'),(19,2,17,1,600.00,'Hp'),(20,2,13,1,100.00,'Perfect'),(21,9,14,23,1234.00,'12'),(22,1,18,1,400.00,'Logitech'),(23,2,18,1,400.00,'Perfect'),(24,11,19,1,500.00,'Apache'),(25,8,20,1,1567.00,'we'),(26,7,21,1,36000.00,'WD'),(27,5,22,1,3500.00,'Tp'),(28,11,23,1,500.00,'Tw'),(29,8,24,1,124.00,'we'),(30,1,25,1,200.00,'Logitech'),(31,8,26,1,300.00,'Perfect'),(32,11,27,1,500.00,'Wp'),(33,10,27,1,1200.00,'test');

/*Table structure for table `search_statistics` */

DROP TABLE IF EXISTS `search_statistics`;

CREATE TABLE `search_statistics` (
  `search_id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword_search` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_search` datetime NOT NULL,
  PRIMARY KEY (`search_id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `search_statistics` */

insert  into `search_statistics`(`search_id`,`keyword_search`,`date_search`) values (1,'jony','2014-11-03 18:14:22'),(2,'jony','2014-11-03 18:16:01'),(3,'jony','2014-11-03 18:16:10'),(4,'sumon','2014-11-05 08:46:41'),(5,'juel','2014-11-05 08:46:57'),(6,'mouse','2014-11-05 08:47:10'),(7,'keyboard','2014-11-05 08:47:19'),(8,'jony','2014-11-05 08:47:59'),(9,'jony','2014-11-05 08:49:22'),(10,'jony','2014-11-05 08:49:35'),(11,'jony','2014-11-05 08:49:47'),(12,'jony','2014-11-05 08:51:26'),(13,'jony','2014-11-05 08:51:48'),(14,'jony','2014-11-05 08:52:23'),(15,'jony','2014-11-05 08:54:10'),(16,'jony','2014-11-05 08:54:24'),(17,'jony','2014-11-05 08:56:36'),(18,'jony','2014-11-05 08:56:56'),(19,'jony','2014-11-05 08:57:07'),(20,'jony','2014-11-05 09:00:39'),(21,'jony','2014-11-05 09:01:06'),(22,'jony','2014-11-05 09:02:38'),(23,'jony','2014-11-05 09:02:49'),(24,'jony','2014-11-05 09:03:49'),(25,'jony','2014-11-05 09:05:10'),(26,'jony','2014-11-05 09:05:35'),(27,'jony','2014-11-05 09:05:46'),(28,'jony','2014-11-05 09:06:01'),(29,'jony','2014-11-05 09:06:19'),(30,'jony','2014-11-05 09:06:50'),(31,'jony','2014-11-05 09:07:58'),(32,'jony','2014-11-05 09:08:14'),(33,'jony','2014-11-05 09:10:41'),(34,'jony','2014-11-05 09:11:00'),(35,'jony','2014-11-05 09:13:00'),(36,'sumon','2014-11-05 09:13:41'),(37,'kothasumon','2014-11-05 09:17:30'),(38,'kotha','2014-11-05 09:17:54'),(39,'kotha','2014-11-05 09:18:02'),(40,'jony','2014-11-05 09:51:05'),(41,'jony','2014-11-08 08:58:51'),(42,'jony','2014-11-08 08:59:37'),(43,'jony','2014-11-08 09:00:03'),(44,'Mouse','2014-11-08 09:01:07'),(45,'Mouse','2014-11-08 09:02:11'),(46,'jony','2014-11-08 09:02:47'),(47,'jony','2014-11-08 10:49:29'),(48,'jony','2014-11-08 10:49:39'),(49,'mouse','2014-11-08 10:49:49'),(50,'jony','2014-11-08 10:50:37'),(51,'jony','2014-11-08 10:50:50'),(52,'jony','2014-11-08 10:51:58'),(53,'jony','2014-11-08 10:53:37'),(54,'jony','2014-11-08 10:53:43'),(55,'jony','2014-11-08 10:53:47'),(56,'jony','2014-11-08 10:53:52'),(57,'jony','2014-11-08 10:53:58'),(58,'jony','2014-11-08 10:54:07'),(59,'jony','2014-11-08 10:54:14'),(60,'jony','2014-11-08 10:54:20'),(61,'jony','2014-11-08 11:09:05'),(62,'jony','2014-11-08 11:12:20'),(63,'jony','2014-11-08 17:21:57'),(64,'jony','2014-11-10 16:48:14'),(65,'mouse','2014-11-10 16:48:27'),(66,'mouse','2014-11-10 16:48:34'),(67,'jony','2014-11-12 14:55:23'),(68,'jony','2014-11-12 14:56:02'),(69,'jony','2014-11-12 15:01:14'),(70,'jony','2014-11-12 15:03:19'),(71,'jony','2014-11-12 15:27:00'),(72,'jony','2014-11-12 15:29:24'),(73,'jony','2014-11-13 18:08:39'),(74,'jony','2014-11-13 18:08:58'),(75,'mouser','2014-11-20 18:01:45'),(76,'Mouse','2014-11-20 18:01:53'),(77,'autocomplete','2014-11-23 09:51:12'),(78,'autocomplete','2014-11-23 09:51:40'),(79,'autocomplete','2014-11-23 09:51:51'),(80,'autocomplete','2014-11-23 09:53:41'),(81,'autocomplete','2014-11-23 09:53:43'),(82,'autocomplete','2014-11-23 09:53:45'),(83,'autocomplete','2014-11-23 09:53:48'),(84,'autocomplete','2014-11-23 09:53:49'),(85,'auto-complete','2014-11-23 09:56:14'),(86,'jon','2014-11-23 09:58:04'),(87,'jon','2014-11-23 09:58:50'),(88,'username','2014-11-23 14:40:27'),(89,'username','2014-11-23 14:43:25'),(90,'username','2014-11-23 14:47:05'),(91,'username','2014-11-23 14:47:07'),(92,'username','2014-11-23 14:47:10'),(93,'jony','2014-11-23 14:48:57'),(94,'username','2014-11-23 14:50:47'),(95,'username','2014-11-23 15:30:06'),(96,'username','2014-11-23 15:30:47'),(97,'er','2014-11-23 15:32:17'),(98,'qq','2014-11-23 15:32:29'),(99,'jony','2014-11-23 15:41:01'),(100,'username','2014-11-23 15:41:37'),(101,'username','2014-11-23 15:42:37'),(102,'search-username','2014-11-23 15:43:15'),(103,'search-username','2014-11-23 15:43:35'),(104,'user-username','2014-11-23 15:45:19'),(105,'user-username','2014-11-23 15:58:34'),(106,'jony','2014-11-23 18:03:56'),(107,'jon','2014-11-23 18:04:21'),(108,'jony','2014-11-24 09:25:57'),(109,'jony','2014-11-26 18:12:09'),(110,'almas','2014-11-26 18:12:20'),(111,'almas','2014-11-26 18:12:31'),(112,'almas','2014-11-26 18:12:35'),(113,'almas','2014-11-26 18:12:43'),(114,'almas','2014-11-26 18:12:54'),(115,'alams','2014-11-26 18:12:58'),(116,'almas','2014-11-26 18:13:02'),(117,'almas','2014-11-26 18:13:08'),(118,'almas','2014-11-26 18:13:17'),(119,'mouse','2014-11-26 18:13:30'),(120,'mouse','2014-11-26 18:13:36'),(121,'mouse','2014-11-26 18:13:59'),(122,'jony','2014-12-01 17:05:38'),(123,'mouse','2014-12-01 17:06:12'),(124,'mouse','2014-12-01 17:10:03'),(125,'jony','2014-12-01 17:16:43'),(126,'jony','2014-12-10 10:59:10'),(127,'mouse','2014-12-10 11:03:46'),(128,'mouse','2014-12-10 11:05:45'),(129,'jony','2014-12-10 11:05:50'),(130,'jony','2014-12-10 11:06:10'),(131,'jony','2014-12-10 11:06:37'),(132,'mouse','2014-12-10 11:06:40'),(133,'jony','2014-12-10 14:36:19'),(134,'almas','2014-12-11 09:16:18'),(135,'juel','2014-12-11 09:16:25'),(136,'juel','2014-12-11 09:16:35'),(137,'jibon','2014-12-11 09:16:41'),(138,'jibon','2014-12-11 09:16:50'),(139,'sumon','2014-12-11 09:17:06'),(140,'sumon','2014-12-11 09:17:35'),(141,'sumon','2014-12-11 09:17:50'),(142,'sumon','2014-12-11 09:17:56'),(143,'juel','2014-12-11 09:18:06'),(144,'juel','2014-12-11 09:18:11'),(145,'juel','2014-12-11 09:18:20'),(146,'juel','2014-12-11 09:18:29'),(147,'juel','2014-12-11 09:18:33'),(148,'juel','2014-12-11 09:18:37'),(149,'juel','2014-12-11 09:18:40'),(150,'sumon','2014-12-11 09:18:53'),(151,'sumon','2014-12-11 09:18:58'),(152,'sumon','2014-12-11 09:19:08'),(153,'sumon','2014-12-11 09:19:13'),(154,'vinal','2014-12-11 09:19:27'),(155,'vinal','2014-12-11 09:19:32'),(156,'vinal','2014-12-11 09:19:37'),(157,'vinal','2014-12-11 09:19:41'),(158,'vinal','2014-12-11 09:19:46'),(159,'vinal','2014-12-11 09:19:50'),(160,'vinal','2014-12-11 09:19:54'),(161,'vinal','2014-12-11 09:20:04'),(162,'vinal','2014-12-11 09:20:09'),(163,'vinal','2014-12-11 09:20:12'),(164,'vinal','2014-12-11 09:20:14'),(165,'vinal','2014-12-11 09:20:17'),(166,'vinal','2014-12-11 09:20:20'),(167,'vinal','2014-12-11 09:20:23'),(168,'vinal','2014-12-11 09:20:26'),(169,'Keyboard','2014-12-11 09:20:47'),(170,'Keyboard','2014-12-11 09:20:52'),(171,'Keyboard','2014-12-11 09:20:55'),(172,'Keyboard','2014-12-11 09:20:58'),(173,'Keyboard','2014-12-11 09:21:00'),(174,'Keyboard','2014-12-11 09:21:03'),(175,'Keyboard','2014-12-11 09:21:06'),(176,'Keyboard','2014-12-11 09:21:09'),(177,'Keyboard','2014-12-11 09:21:11'),(178,'Keyboard','2014-12-11 09:21:13'),(179,'Keyboard','2014-12-11 09:21:16'),(180,'juel','2014-12-11 09:23:56'),(181,'juel','2014-12-11 09:24:17'),(182,'juel','2014-12-11 09:24:26'),(183,'sumon','2014-12-11 09:24:38'),(184,'jony','2014-12-29 12:17:59'),(185,'jony','2015-03-27 22:12:34'),(186,'Rakib','2015-03-27 22:13:04');

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
  CONSTRAINT `FK_9B2A6C7EDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `fos_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `supplier` */

insert  into `supplier`(`id`,`created_by`,`name`,`address`,`created_at`) values (1,1,'Computer Source Ltd','House: 11/B, Road: 12 (New) 31 (Old)\r\nDhanmondi R/A, Dhaka-1209\r\n\r\nTel: +880-2-9127592, +880-2-9121484\r\n+880-2-9140152, \r\n+880-2-9145688, +880-2-8120578','2014-08-17 18:07:05'),(6,1,'Ryans Computers Ltd','123/5 BCS Computer City\r\nIDB Bhaban, Agargaon, Dhaka - 1207\r\nTelephone : 02-9183228\r\nFax : 8059859','2014-09-08 17:44:54'),(7,35,'Flora Limited','Adamjee Courte Annex-2, \r\n119-120 Motijheel, \r\nMotijheel Road, \r\nDhaka 1000\r\nPhone:02-9551832','2014-09-08 17:53:08'),(8,1,'High Source Electronics','House # 6,Road # 4 ,Block - A, Av - 3\r\nSection - 11, Mirpur, Dhaka - 1216\r\nE-Mail : highsource09@yahoo.com\r\nWebsite : www.highsourcebd.com ','2014-09-08 18:00:05'),(9,35,'Ethics Mercantile Limited','Road No: 04, House No: 303 (3rd Floor)\r\nDOHS, Baridhara, Dhaka-1229,\r\nBangladesh\r\nTelephone No : +880 2 8415837\r\nE-mail : info@ethicsbd.com\r\nquotation@ethicsbd.com\r\nWebsite: www.ethicsbd.com','2014-09-08 18:00:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

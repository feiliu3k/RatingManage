/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.13-MariaDB : Database - rating
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rating` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `rating`;

/*Table structure for table `adplaylists` */

CREATE TABLE `adplaylists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `d_date` datetime NOT NULL,
  `b_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `f_id` int(10) unsigned NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `len` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `belt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ht_len` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `adplaylists_f_id_index` (`f_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `adplaylists` */

/*Table structure for table `fres` */

CREATE TABLE `fres` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dm` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `xs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fres_fre_unique` (`fre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `fres` */

insert  into `fres`(`id`,`fre`,`dm`,`remark`,`xs`) values (1,'汕视一套','','            \r\n        ',''),(2,'汕视二套','','            \r\n        ',''),(3,'汕视三套','','            \r\n        ',''),(4,'翡翠','','            \r\n        ',''),(5,'本港','','            \r\n        ',''),(6,'凤凰','','            \r\n        ','');

/*Table structure for table `migrations` */

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`migration`,`batch`) values ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_08_26_012105_create_ratings_table',2),('2016_08_26_012130_create_rating_types_table',2),('2016_08_26_012946_create_a_d_play_lists_table',2),('2016_08_26_013127_create_stat_lists_table',2),('2016_08_26_084924_create_fres_table',2);

/*Table structure for table `password_resets` */

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `ratings` */

CREATE TABLE `ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_date` datetime NOT NULL,
  `f_id` int(10) unsigned NOT NULL,
  `b_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `e_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rt_id` int(10) unsigned NOT NULL,
  `a_rating` double(8,3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ratings_f_id_index` (`f_id`),
  KEY `ratings_rt_id_index` (`rt_id`),
  CONSTRAINT `fk_fre_rating` FOREIGN KEY (`f_id`) REFERENCES `fres` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ratings` */

/*Table structure for table `ratingtypes` */

CREATE TABLE `ratingtypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rating_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratingtypes_rating_type_unique` (`rating_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ratingtypes` */

insert  into `ratingtypes`(`id`,`rating_type`,`remark`) values (1,'可口可乐','            \r\n        '),(2,'高露洁','            \r\n        '),(3,'宝洁','            \r\n        ');

/*Table structure for table `statlists` */

CREATE TABLE `statlists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `r_id` int(10) unsigned NOT NULL,
  `a_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `statlists_r_id_index` (`r_id`),
  KEY `statlists_a_id_index` (`a_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `statlists` */

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values (1,'admin','admin@rt.cn','$2y$10$bBoadwsPvT5iEIYrEFVUNOIaHaIRRXhonFQZg5ulGde4dV2ie0F5W','6NJwJ4AvQ3krV8T253xDpoagvIDN5ldXOpbZW8lO3oVMV2glUPaqxsqC4c5n','2016-08-29 03:19:31','2016-09-06 15:41:41');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

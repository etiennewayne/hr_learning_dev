/*
SQLyog Ultimate v12.14 (64 bit)
MySQL - 10.4.24-MariaDB : Database - learning_dev
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`learning_dev` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `learning_dev`;

/*Table structure for table `seminar_posts` */

DROP TABLE IF EXISTS `seminar_posts`;

CREATE TABLE `seminar_posts` (
  `seminar_post_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `img_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_posted` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`seminar_post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `seminar_posts` */

insert  into `seminar_posts`(`seminar_post_id`,`img_path`,`description`,`date_posted`,`created_at`,`updated_at`) values 
(3,'tEEY5QclbIRMQDFAOZ4IsPlj00eya0FwMmFHFszv.jpg','asdawdawd','2023-01-04','2023-01-04 18:21:31','2023-01-04 18:21:31'),
(4,'p58bQWEd2xSfMs0fwWmsxUUkdQt6nkMqSUgVA44K.jpg','We are excited to announce that, due to our remarkable growth over the last [enter number] of years, we are expanding! In fact, we are opening a new store in [enter location and specifics]. We invite you to celebrate with us during the big opening day on [enter date].','2023-01-05','2023-01-05 09:25:19','2023-01-05 09:25:19'),
(5,'7CdmmpLqdZVR7dAWblQwSbr3SXcH5VO1BFneBQTj.jpg','sample post, sniper ta mga dude','2023-01-06','2023-01-06 08:24:13','2023-01-06 08:24:13'),
(6,'','asdawd','2023-01-06','2023-01-06 08:24:32','2023-01-06 08:24:32');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

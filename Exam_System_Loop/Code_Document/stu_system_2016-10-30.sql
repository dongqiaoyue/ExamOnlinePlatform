# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: stu_system
# Generation Time: 2016-10-30 11:40:31 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ab
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ab`;

CREATE TABLE `ab` (
  `TeachingClassID` varchar(32) DEFAULT '',
  `StuNumber` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ac
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ac`;

CREATE TABLE `ac` (
  `TeachingClassID` varchar(32) DEFAULT '',
  `StuNumber` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;

INSERT INTO `admin` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'admin','BAscckbHf91npOYsxfv6KCxY-nqIM5M3','$2y$13$7cOXBX41QMUabgvmCXrp4eHvrG07lqQHDjcHEuSekjld6objrl6Yy',NULL,'liu.lipeng@newsnow.com.cn',10,1476709757,1476709757);

/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table admin_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admin_log`;

CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gets` text COLLATE utf8_unicode_ci,
  `posts` text COLLATE utf8_unicode_ci NOT NULL,
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `admin_log` WRITE;
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;

INSERT INTO `admin_log` (`id`, `route`, `url`, `user_agent`, `gets`, `posts`, `admin_id`, `admin_email`, `ip`, `created_at`, `updated_at`)
VALUES
	(1,'admin/permission/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/permission\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709859,1476709859),
	(2,'admin/role/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/role\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709860,1476709860),
	(3,'admin/rule/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/rule\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709862,1476709862),
	(4,'admin/route/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/route\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709864,1476709864),
	(5,'admin/route/assign','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Fassign','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/route\\/assign\"}','{\"action\":\"remove\",\"routes\":[\"\\/admin\\/assignment\\/assign\"]}',1,'liu.lipeng@newsnow.com.cn','::1',1476709872,1476709872),
	(6,'admin/route/assign','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Fassign','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/route\\/assign\"}','{\"action\":\"assign\",\"routes\":[\"\\/admin\\/assignment\\/assign\"]}',1,'liu.lipeng@newsnow.com.cn','::1',1476709875,1476709875),
	(7,'admin/rule/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/rule\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709880,1476709880),
	(8,'admin/menu/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709881,1476709881),
	(9,'admin/menu/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/index\"}','{\"id\":\"0\"}',1,'liu.lipeng@newsnow.com.cn','::1',1476709882,1476709882),
	(10,'admin/assignment/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/assignment\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709884,1476709884),
	(11,'admin/log/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Flog%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/log\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709885,1476709885),
	(12,'admin/permission/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/permission\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709889,1476709889),
	(13,'admin/permission/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/permission\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709895,1476709895),
	(14,'admin/role/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/role\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709896,1476709896),
	(15,'admin/role/create','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Fcreate','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/role\\/create\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709898,1476709898),
	(16,'admin/permission/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/permission\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709946,1476709946),
	(17,'admin/route/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/route\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709947,1476709947),
	(18,'admin/rule/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/rule\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709948,1476709948),
	(19,'admin/assignment/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/assignment\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709949,1476709949),
	(20,'admin/assignment/create','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Fcreate','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/assignment\\/create\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476709950,1476709950),
	(21,'admin/permission/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/permission\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476710169,1476710169),
	(22,'admin/assignment/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/assignment\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476710181,1476710181),
	(23,'admin/menu/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476710182,1476710182),
	(24,'admin/menu/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/index\"}','{\"id\":\"0\"}',1,'liu.lipeng@newsnow.com.cn','::1',1476710183,1476710183),
	(25,'admin/log/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Flog%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/log\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476710184,1476710184),
	(26,'admin/menu/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476710185,1476710185),
	(27,'admin/menu/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/index\"}','{\"id\":\"0\"}',1,'liu.lipeng@newsnow.com.cn','::1',1476710186,1476710186),
	(28,'admin/menu/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/index\"}','{\"id\":\"1\"}',1,'liu.lipeng@newsnow.com.cn','::1',1476710186,1476710186),
	(29,'admin/menu/update','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Fupdate&id=5','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/update\",\"id\":\"5\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476710191,1476710191),
	(30,'admin/permission/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/permission\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476710195,1476710195),
	(31,'admin/role/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/role\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476711804,1476711804),
	(32,'admin/rule/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/rule\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476711806,1476711806),
	(33,'admin/route/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/route\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476711807,1476711807),
	(34,'admin/menu/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476711809,1476711809),
	(35,'admin/menu/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/menu\\/index\"}','{\"id\":\"0\"}',1,'liu.lipeng@newsnow.com.cn','::1',1476711809,1476711809),
	(36,'admin/permission/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/permission\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476711936,1476711936),
	(37,'admin/rule/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/rule\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476711943,1476711943),
	(38,'admin/role/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/role\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476711945,1476711945),
	(39,'admin/role/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/role\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476711973,1476711973),
	(40,'admin/route/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/route\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1476711975,1476711975),
	(41,'admin/permission/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/permission\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1477317583,1477317583),
	(42,'admin/rule/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/rule\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1477317584,1477317584),
	(43,'admin/assignment/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/assignment\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1477317585,1477317585),
	(44,'admin/route/index','http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0','{\"r\":\"admin\\/route\\/index\"}','[]',1,'liu.lipeng@newsnow.com.cn','::1',1477317586,1477317586);

/*!40000 ALTER TABLE `admin_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table apfill
# ------------------------------------------------------------

DROP TABLE IF EXISTS `apfill`;

CREATE TABLE `apfill` (
  `ApfillPosition` varchar(32) NOT NULL DEFAULT '',
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `ReadType` int(11) DEFAULT '0',
  `Answer` varchar(100) NOT NULL DEFAULT '',
  `Proportion` double DEFAULT '0',
  `Memo` varchar(100) DEFAULT '',
  PRIMARY KEY (`ApfillPosition`,`QuestionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table appointment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `appointment`;

CREATE TABLE `appointment` (
  `AppointmentBh` varchar(32) NOT NULL DEFAULT '',
  `beginTime` varchar(50) DEFAULT '',
  `EndTime` varchar(50) DEFAULT '',
  `TestDate` varchar(50) DEFAULT '',
  `SubmitTime` varchar(50) DEFAULT '',
  `CurrentState` varchar(50) DEFAULT '',
  `TestRoomBh` varchar(32) NOT NULL DEFAULT '',
  `StuNumber` varchar(50) DEFAULT '',
  `ExamPlanBh` varchar(32) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `ConfigureBh` varchar(32) DEFAULT '',
  PRIMARY KEY (`AppointmentBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table attendancerecord
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attendancerecord`;

CREATE TABLE `attendancerecord` (
  `AttendaceRecordID` varchar(32) NOT NULL DEFAULT '',
  `StudentName` varchar(20) DEFAULT '',
  `StudentNum` varchar(50) DEFAULT '',
  `AttendanceDate` datetime DEFAULT NULL,
  `Score` int(11) DEFAULT '0',
  `AttendanceState` varchar(20) DEFAULT '',
  `TeachClass` varchar(32) DEFAULT '',
  PRIMARY KEY (`AttendaceRecordID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table auth_assignment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`)
VALUES
	('Admin','1',1457092343);

/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES
	('/admin/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/assignment/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/assignment/assign',2,NULL,NULL,NULL,1476709875,1476709875),
	('/admin/assignment/create',2,NULL,NULL,NULL,1457521995,1457521995),
	('/admin/assignment/delete',2,NULL,NULL,NULL,1458010804,1458010804),
	('/admin/assignment/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/assignment/search',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/assignment/update',2,NULL,NULL,NULL,1458010804,1458010804),
	('/admin/assignment/view',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/default/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/default/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/log/*',2,NULL,NULL,NULL,1468288689,1468288689),
	('/admin/log/index',2,NULL,NULL,NULL,1468288689,1468288689),
	('/admin/log/view',2,NULL,NULL,NULL,1468288689,1468288689),
	('/admin/menu/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/menu/create',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/menu/delete',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/menu/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/menu/update',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/menu/view',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/permission/*',2,NULL,NULL,NULL,1457948575,1457948575),
	('/admin/permission/assign',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/permission/create',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/permission/delete',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/permission/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/permission/search',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/permission/update',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/permission/view',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/role/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/role/assign',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/role/create',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/role/delete',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/role/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/role/search',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/role/update',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/role/view',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/route/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/route/assign',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/route/create',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/route/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/route/refresh',2,NULL,NULL,NULL,1457947924,1457947924),
	('/admin/route/search',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/rule/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/rule/create',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/rule/delete',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/rule/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/rule/update',2,NULL,NULL,NULL,1457330826,1457330826),
	('/admin/rule/view',2,NULL,NULL,NULL,1457330826,1457330826),
	('/debug/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/debug/default/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/debug/default/db-explain',2,NULL,NULL,NULL,1457330826,1457330826),
	('/debug/default/download-mail',2,NULL,NULL,NULL,1457330826,1457330826),
	('/debug/default/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/debug/default/toolbar',2,NULL,NULL,NULL,1457330826,1457330826),
	('/debug/default/view',2,NULL,NULL,NULL,1457330826,1457330826),
	('/gii/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/gii/default/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/gii/default/action',2,NULL,NULL,NULL,1457330826,1457330826),
	('/gii/default/diff',2,NULL,NULL,NULL,1457330826,1457330826),
	('/gii/default/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/gii/default/preview',2,NULL,NULL,NULL,1457330826,1457330826),
	('/gii/default/view',2,NULL,NULL,NULL,1457330826,1457330826),
	('/site/*',2,NULL,NULL,NULL,1457330826,1457330826),
	('/site/error',2,NULL,NULL,NULL,1457330826,1457330826),
	('/site/index',2,NULL,NULL,NULL,1457330826,1457330826),
	('/site/login',2,NULL,NULL,NULL,1457330826,1457330826),
	('/site/logout',2,NULL,NULL,NULL,1457330826,1457330826),
	('Admin',1,'Administrators',NULL,NULL,1457084487,1457947508),
	('修改用户',2,NULL,NULL,NULL,1457522051,1457522051),
	('修改菜单',2,NULL,NULL,NULL,1457330464,1457405433),
	('删除权限',2,NULL,NULL,NULL,1457331320,1457331320),
	('删除菜单',2,NULL,NULL,NULL,1457330485,1457330485),
	('删除规则',2,NULL,NULL,NULL,1457331677,1457331677),
	('删除角色',2,NULL,NULL,NULL,1457331161,1457331161),
	('删除路由',2,NULL,NULL,NULL,1457331499,1457331499),
	('操作日志',2,NULL,NULL,NULL,1468288713,1468288713),
	('新增权限',2,NULL,NULL,NULL,1457331279,1457331279),
	('新增用户',2,NULL,NULL,NULL,1457433802,1457433802),
	('新增菜单',2,NULL,NULL,NULL,1457330445,1457330445),
	('新增规则',2,NULL,NULL,NULL,1457331552,1457331610),
	('新增角色',2,NULL,NULL,NULL,1457331075,1457331075),
	('新增路由',2,NULL,NULL,NULL,1457331386,1457331386),
	('更新权限',2,NULL,NULL,NULL,1457331303,1457331303),
	('更新规则',2,NULL,NULL,NULL,1457331647,1457331647),
	('更新角色',2,NULL,NULL,NULL,1457331126,1457331126),
	('更新路由',2,NULL,NULL,NULL,1457331492,1457331492),
	('权限分配',2,NULL,NULL,NULL,1457418746,1457418746),
	('权限管理',2,NULL,NULL,NULL,1457331258,1457331258),
	('查看操作日志',2,NULL,NULL,NULL,1468294314,1468294314),
	('查看权限',2,NULL,NULL,NULL,1457331342,1457331342),
	('查看用户权限',2,NULL,NULL,NULL,1457331965,1457331965),
	('查看菜单',2,NULL,NULL,NULL,1457330619,1457330619),
	('查看规则',2,NULL,NULL,NULL,1457331692,1457331692),
	('查看角色',2,NULL,NULL,NULL,1457331191,1457331191),
	('用户权限分配',2,NULL,NULL,NULL,1457333258,1457333258),
	('用户管理',2,NULL,NULL,NULL,1457079781,1457331877),
	('菜单管理',2,NULL,NULL,NULL,1457324314,1457324314),
	('规则管理',2,NULL,NULL,NULL,1457331529,1457331529),
	('角色权限分配',2,NULL,NULL,NULL,1457333688,1457333688),
	('角色管理',2,NULL,NULL,NULL,1457330790,1457330790),
	('路由分配',2,NULL,NULL,NULL,1457333742,1457333742),
	('路由管理',2,NULL,NULL,NULL,1457331368,1457331368);

/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_item_child
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES
	('新增用户','/admin/assignment/create'),
	('用户管理','/admin/assignment/index'),
	('查看用户权限','/admin/assignment/search'),
	('修改用户','/admin/assignment/update'),
	('查看用户权限','/admin/assignment/view'),
	('操作日志','/admin/log/index'),
	('查看操作日志','/admin/log/view'),
	('新增菜单','/admin/menu/create'),
	('删除菜单','/admin/menu/delete'),
	('菜单管理','/admin/menu/index'),
	('修改菜单','/admin/menu/update'),
	('查看菜单','/admin/menu/view'),
	('权限分配','/admin/permission/assign'),
	('新增权限','/admin/permission/create'),
	('删除权限','/admin/permission/delete'),
	('权限管理','/admin/permission/index'),
	('查看权限','/admin/permission/search'),
	('更新权限','/admin/permission/update'),
	('查看权限','/admin/permission/view'),
	('角色权限分配','/admin/role/assign'),
	('新增角色','/admin/role/create'),
	('删除角色','/admin/role/delete'),
	('角色管理','/admin/role/index'),
	('查看角色','/admin/role/search'),
	('更新角色','/admin/role/update'),
	('查看角色','/admin/role/view'),
	('路由分配','/admin/route/assign'),
	('新增路由','/admin/route/create'),
	('查看规则','/admin/route/index'),
	('查看规则','/admin/route/search'),
	('新增规则','/admin/rule/create'),
	('删除规则','/admin/rule/delete'),
	('规则管理','/admin/rule/index'),
	('路由管理','/admin/rule/index'),
	('更新规则','/admin/rule/update'),
	('Admin','修改用户'),
	('Admin','修改菜单'),
	('Admin','删除权限'),
	('Admin','删除菜单'),
	('Admin','删除规则'),
	('Admin','删除角色'),
	('Admin','删除路由'),
	('Admin','操作日志'),
	('Admin','新增权限'),
	('Admin','新增用户'),
	('Admin','新增菜单'),
	('Admin','新增规则'),
	('Admin','新增角色'),
	('Admin','新增路由'),
	('Admin','更新权限'),
	('Admin','更新规则'),
	('Admin','更新角色'),
	('Admin','更新路由'),
	('Admin','权限分配'),
	('Admin','权限管理'),
	('Admin','查看操作日志'),
	('Admin','查看权限'),
	('Admin','查看用户权限'),
	('Admin','查看菜单'),
	('Admin','查看规则'),
	('Admin','查看角色'),
	('Admin','用户权限分配'),
	('Admin','用户管理'),
	('Admin','菜单管理'),
	('Admin','规则管理'),
	('Admin','角色权限分配'),
	('Admin','角色管理'),
	('Admin','路由分配'),
	('Admin','路由管理');

/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_rule
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table classroom
# ------------------------------------------------------------

DROP TABLE IF EXISTS `classroom`;

CREATE TABLE `classroom` (
  `ClassRoomID` int(11) NOT NULL DEFAULT '0',
  `IsUsable` varchar(5) NOT NULL DEFAULT '',
  `ClassName` varchar(50) DEFAULT '',
  `StartIp` varchar(50) DEFAULT '',
  `EndIp` varchar(50) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`ClassRoomID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table classroomdetails
# ------------------------------------------------------------

DROP TABLE IF EXISTS `classroomdetails`;

CREATE TABLE `classroomdetails` (
  `ClassRoomDetailsID` varchar(32) NOT NULL DEFAULT '',
  `IPAddress` varchar(20) NOT NULL DEFAULT '',
  `MACAddress` varchar(30) NOT NULL DEFAULT '',
  `ClassRoomID` int(11) DEFAULT '0',
  PRIMARY KEY (`ClassRoomDetailsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table commonhomework
# ------------------------------------------------------------

DROP TABLE IF EXISTS `commonhomework`;

CREATE TABLE `commonhomework` (
  `HomeworkID` varchar(32) NOT NULL DEFAULT '',
  `TeacherName` varchar(20) DEFAULT '',
  `TeachClass` varchar(32) DEFAULT '',
  `HomeworkName` varchar(50) DEFAULT '',
  `WorkDesc` varchar(2000) DEFAULT '',
  `WorkURL` varchar(500) DEFAULT '',
  `WorkScore` int(11) DEFAULT '0',
  `DeadTime` datetime DEFAULT NULL,
  `IsStuSee` varchar(10) DEFAULT '',
  `Memo` varchar(300) DEFAULT '',
  PRIMARY KEY (`HomeworkID`),
  KEY `PK4` (`HomeworkID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table coursemanagement
# ------------------------------------------------------------

DROP TABLE IF EXISTS `coursemanagement`;

CREATE TABLE `coursemanagement` (
  `CourseID` varchar(32) NOT NULL DEFAULT '',
  `CourseName` varchar(50) NOT NULL DEFAULT '',
  `Grade` double NOT NULL DEFAULT '0',
  `ClassTime` varchar(10) NOT NULL DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `PlatformID` varchar(32) DEFAULT '',
  PRIMARY KEY (`CourseID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table createpaper
# ------------------------------------------------------------

DROP TABLE IF EXISTS `createpaper`;

CREATE TABLE `createpaper` (
  `PaperBh` varchar(32) NOT NULL DEFAULT '',
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `TotalScore` varchar(32) DEFAULT '',
  `Memo` text,
  PRIMARY KEY (`PaperBh`,`QuestionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table developerinfo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `developerinfo`;

CREATE TABLE `developerinfo` (
  `DeveloperID` varchar(36) NOT NULL DEFAULT '',
  `DeveloperName` varchar(50) DEFAULT '',
  `DeveloperIcon` varchar(500) DEFAULT '',
  `Sex` varchar(10) DEFAULT '',
  `Grade` int(11) DEFAULT '0',
  `BetterAspect` varchar(1000) DEFAULT '',
  `DoneProject` varchar(2000) DEFAULT '',
  `QQ` varchar(20) DEFAULT '',
  `Motto` varchar(500) DEFAULT '',
  `Memo` varchar(1000) DEFAULT '',
  `BirthDay` datetime DEFAULT NULL,
  `ContactTell` varchar(50) DEFAULT '',
  `Emails` varchar(50) DEFAULT '',
  `ClassName` varchar(100) DEFAULT '',
  `StudyOfWork` varchar(1000) DEFAULT '',
  `TheHonour` varchar(1000) DEFAULT '',
  PRIMARY KEY (`DeveloperID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table devicetokentable
# ------------------------------------------------------------

DROP TABLE IF EXISTS `devicetokentable`;

CREATE TABLE `devicetokentable` (
  `DeviceID` varchar(32) NOT NULL DEFAULT '',
  `DeviceToken` varchar(500) DEFAULT '',
  PRIMARY KEY (`DeviceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table engineeringpractice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `engineeringpractice`;

CREATE TABLE `engineeringpractice` (
  `EngineeringPracticeID` varchar(32) NOT NULL DEFAULT '',
  `Academy` varchar(100) DEFAULT '',
  `Term` varchar(100) DEFAULT '',
  `EngineeringPracticeName` varchar(100) NOT NULL DEFAULT '',
  `StarTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `CourseID` varchar(32) DEFAULT '',
  `ExamTime` varchar(10) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`EngineeringPracticeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table engineeringpracticepaper
# ------------------------------------------------------------

DROP TABLE IF EXISTS `engineeringpracticepaper`;

CREATE TABLE `engineeringpracticepaper` (
  `EngineeringPracticePaperID` varchar(32) NOT NULL DEFAULT '',
  `PaperContent` text,
  `RealAnswer` text,
  `StuAnswer` text,
  `ExamTime` varchar(20) DEFAULT '',
  `ExamStarTime` datetime DEFAULT NULL,
  `ExamEndTime` datetime DEFAULT NULL,
  `PaperStage` varchar(10) DEFAULT '',
  `Score` double DEFAULT '0',
  `Memo` text,
  `StudentWorkID` varchar(32) DEFAULT '',
  `EngineeringPracticeName` varchar(100) DEFAULT '',
  `StuWorkName` varchar(100) DEFAULT '',
  `StuNumber` varchar(50) DEFAULT '',
  `SourceCode` text,
  `EngineeringPracticeID` varchar(32) DEFAULT '',
  `IPAddress` varchar(200) DEFAULT '',
  `IntoExamStarTime` datetime DEFAULT NULL,
  PRIMARY KEY (`EngineeringPracticePaperID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table engineeringpracticestudent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `engineeringpracticestudent`;

CREATE TABLE `engineeringpracticestudent` (
  `StuNumber` varchar(50) NOT NULL DEFAULT '',
  `ICNumber` varchar(18) NOT NULL DEFAULT '',
  `Name` varchar(30) NOT NULL DEFAULT '',
  `Sex` varchar(5) NOT NULL DEFAULT '',
  `Password` varchar(32) NOT NULL DEFAULT '',
  `ClassName` varchar(50) DEFAULT '',
  `DepartmentName` varchar(50) DEFAULT '',
  `MajorName` varchar(50) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `EngineeringPracticeID` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`StuNumber`,`EngineeringPracticeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table examconfigrecord
# ------------------------------------------------------------

DROP TABLE IF EXISTS `examconfigrecord`;

CREATE TABLE `examconfigrecord` (
  `ExamConfigRecordID` varchar(32) NOT NULL DEFAULT '',
  `ExamPaperName` varchar(200) DEFAULT '',
  `ConfigTeacherName` varchar(50) DEFAULT '',
  `ConfigMemo` varchar(200) DEFAULT '',
  `Academy` varchar(200) DEFAULT '',
  `ConfigTime` datetime DEFAULT NULL,
  PRIMARY KEY (`ExamConfigRecordID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table exampaper
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exampaper`;

CREATE TABLE `exampaper` (
  `PaperBh` varchar(32) NOT NULL DEFAULT '',
  `StuName` varchar(100) NOT NULL DEFAULT '',
  `StudentID` varchar(50) DEFAULT '',
  `Score` varchar(10) NOT NULL DEFAULT '',
  `GeneralTime` varchar(100) DEFAULT '',
  `PaperName` varchar(32) NOT NULL DEFAULT '',
  `EXamPaperAddType` varchar(20) DEFAULT '',
  `ExamBeginTime` varchar(100) DEFAULT '',
  `ExamEndTime` varchar(100) DEFAULT '',
  `DealState` varchar(50) NOT NULL DEFAULT '',
  `MachineIP` varchar(50) DEFAULT '',
  `BrowserVision` varchar(100) DEFAULT '',
  `MACAddress` varchar(50) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `ExamPlanBh` varchar(32) DEFAULT '',
  `SetPaperName` varchar(100) NOT NULL DEFAULT '',
  `SubmitStage` varchar(10) DEFAULT '',
  `TeachingClassID` varchar(32) DEFAULT '',
  `ExamException` varchar(50) DEFAULT '',
  PRIMARY KEY (`PaperBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table examplan
# ------------------------------------------------------------

DROP TABLE IF EXISTS `examplan`;

CREATE TABLE `examplan` (
  `ExamPlanBh` varchar(32) NOT NULL DEFAULT '',
  `ExamPlace` varchar(100) DEFAULT '',
  `ExamPlanName` varchar(100) NOT NULL DEFAULT '',
  `ExamTime` varchar(20) DEFAULT '',
  `Weights` varchar(10) NOT NULL DEFAULT '',
  `IsFixedPlace` varchar(10) DEFAULT '',
  `IsProcessExam` varchar(5) NOT NULL DEFAULT '',
  `NumOfExam` int(11) NOT NULL DEFAULT '0',
  `StarTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `CourseID` varchar(32) NOT NULL DEFAULT '',
  `TeachingClassID` varchar(8000) DEFAULT '',
  `AdjustPlacePassword` varchar(50) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `LastPlanBh` varchar(32) DEFAULT '',
  `Term` varchar(20) DEFAULT '',
  `Department` varchar(100) DEFAULT '',
  PRIMARY KEY (`ExamPlanBh`),
  KEY `PK9` (`ExamPlanBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table examprocess
# ------------------------------------------------------------

DROP TABLE IF EXISTS `examprocess`;

CREATE TABLE `examprocess` (
  `PaperBh` varchar(32) NOT NULL DEFAULT '',
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `Answer` text,
  `SubmitTime` datetime DEFAULT NULL,
  `Memo` text,
  PRIMARY KEY (`PaperBh`,`QuestionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table examrecord
# ------------------------------------------------------------

DROP TABLE IF EXISTS `examrecord`;

CREATE TABLE `examrecord` (
  `ExamRecordID` varchar(32) NOT NULL DEFAULT '',
  `StuNumber` varchar(50) DEFAULT '',
  `StuName` varchar(200) DEFAULT '',
  `TeachingClassID` varchar(32) DEFAULT '',
  `InExamTime` varchar(100) DEFAULT '',
  `OutExamTime` varchar(100) DEFAULT '',
  `InExamNum` int(11) DEFAULT '0',
  `PaperName` varchar(100) DEFAULT '',
  `IPAddress` varchar(50) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `ExamPlanBh` varchar(32) DEFAULT '',
  PRIMARY KEY (`ExamRecordID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table exchange
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exchange`;

CREATE TABLE `exchange` (
  `ExchangeBh` varchar(32) NOT NULL DEFAULT '',
  `ExchangeState` int(11) DEFAULT '0',
  `SortKinds` varchar(32) DEFAULT '',
  `Exchangename` varchar(50) DEFAULT '',
  `ExchangePeople` varchar(50) DEFAULT '',
  `ExchangeTime` varchar(32) DEFAULT '',
  `ExchangeCotent` text,
  `MainCode` varchar(32) DEFAULT '',
  `count` int(11) DEFAULT '0',
  `memo` varchar(30) DEFAULT '',
  PRIMARY KEY (`ExchangeBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table exchangereply
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exchangereply`;

CREATE TABLE `exchangereply` (
  `Code` varchar(32) NOT NULL DEFAULT '',
  `ReplayContent` text,
  `ReplayTime` varchar(32) DEFAULT '',
  `ReplayPeople` varchar(50) DEFAULT '',
  `ExchangeBh` varchar(32) DEFAULT '',
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table filecontrolprograme
# ------------------------------------------------------------

DROP TABLE IF EXISTS `filecontrolprograme`;

CREATE TABLE `filecontrolprograme` (
  `FileControlProgrameBh` varchar(32) NOT NULL DEFAULT '',
  `QuestionBh` varchar(32) DEFAULT '',
  `FileName` varchar(100) NOT NULL DEFAULT '',
  `FileControlMode` varchar(20) DEFAULT '',
  `ServerFilePath` varchar(100) NOT NULL DEFAULT '',
  `StuUseFilePath` varchar(100) NOT NULL DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`FileControlProgrameBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table finderror
# ------------------------------------------------------------

DROP TABLE IF EXISTS `finderror`;

CREATE TABLE `finderror` (
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `ErrorCount` int(11) NOT NULL DEFAULT '0',
  `ErrorStartTag` varchar(50) DEFAULT '',
  `ErrorEndTag` varchar(50) DEFAULT '',
  `Content` text,
  `Answer` varchar(8000) DEFAULT '',
  `Proportion` double DEFAULT '0',
  `Memo` varchar(100) DEFAULT '',
  PRIMARY KEY (`QuestionBh`,`ErrorCount`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table gradescoreset
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gradescoreset`;

CREATE TABLE `gradescoreset` (
  `SetID` varchar(32) NOT NULL DEFAULT '',
  `GradeName` varchar(10) DEFAULT '',
  `Score` int(11) DEFAULT '0',
  `TeachingClassID` varchar(32) DEFAULT '',
  PRIMARY KEY (`SetID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table guestbook
# ------------------------------------------------------------

DROP TABLE IF EXISTS `guestbook`;

CREATE TABLE `guestbook` (
  `GuestBh` varchar(32) NOT NULL DEFAULT '',
  `Guesttitle` varchar(32) DEFAULT '',
  `Guestcontent` text,
  `GuestTime` varchar(32) DEFAULT '',
  `GuestUserName` varchar(32) DEFAULT '',
  `GuestUserEmail` varchar(32) DEFAULT '',
  `Memo` text,
  `Gueststate` varchar(10) DEFAULT '',
  PRIMARY KEY (`GuestBh`),
  KEY `PK2` (`GuestBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table guestreply
# ------------------------------------------------------------

DROP TABLE IF EXISTS `guestreply`;

CREATE TABLE `guestreply` (
  `ReplyBh` varchar(32) NOT NULL DEFAULT '',
  `Replycontent` text,
  `ReplyTime` varchar(32) DEFAULT '',
  `ReplyUser` varchar(32) DEFAULT '',
  `GuestBh` varchar(32) DEFAULT '',
  `Memo` text,
  PRIMARY KEY (`ReplyBh`),
  KEY `PK3` (`ReplyBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table knowledgepoint
# ------------------------------------------------------------

DROP TABLE IF EXISTS `knowledgepoint`;

CREATE TABLE `knowledgepoint` (
  `KnowledgeBh` varchar(32) NOT NULL DEFAULT '',
  `Bh` bigint(20) NOT NULL DEFAULT '0',
  `Description` varchar(1000) DEFAULT '',
  `KnowledgeName` varchar(50) DEFAULT '',
  `Chapter` int(11) NOT NULL DEFAULT '0',
  `Stage` int(11) NOT NULL DEFAULT '0',
  `Memo` varchar(500) DEFAULT '',
  PRIMARY KEY (`KnowledgeBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;

INSERT INTO `menu` (`id`, `name`, `parent`, `route`, `order`, `data`)
VALUES
	(1,'系统管理',NULL,NULL,NULL,NULL),
	(2,'用户管理',1,'/admin/assignment/index',0,NULL),
	(3,'菜单管理',1,'/admin/menu/index',1,NULL),
	(4,'权限管理',1,'/admin/permission/index',NULL,NULL),
	(5,'角色管理',1,'/admin/role/index',NULL,NULL),
	(6,'路由管理',1,'/admin/route/index',NULL,NULL),
	(7,'规则管理',1,'/admin/rule/index',NULL,NULL),
	(8,'操作日志',1,'/admin/log/index',100,NULL);

/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;

INSERT INTO `migration` (`version`, `apply_time`)
VALUES
	('m000000_000000_base',1476709729),
	('m140506_102106_rbac_init',1476709735),
	('m160608_050000_create_admin',1476709757),
	('m160712_034501_create_admin_log',1476709757),
	('m160712_111327_create_menu_table',1476709757);

/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `module`;

CREATE TABLE `module` (
  `ModuleID` varchar(32) NOT NULL DEFAULT '',
  `ModuleName` varchar(10) DEFAULT '',
  `ModulePercent` int(11) DEFAULT '0',
  `TeachingClassID` varchar(32) DEFAULT '',
  PRIMARY KEY (`ModuleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table moduleitem
# ------------------------------------------------------------

DROP TABLE IF EXISTS `moduleitem`;

CREATE TABLE `moduleitem` (
  `ModuleItemID` varchar(32) NOT NULL DEFAULT '',
  `ModuleItemName` varchar(200) DEFAULT '',
  `DeadTime` datetime DEFAULT NULL,
  `ModuleID` varchar(32) NOT NULL DEFAULT '',
  `ModuleItemDetails` varchar(1000) DEFAULT '',
  PRIMARY KEY (`ModuleItemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table modulescorerecord
# ------------------------------------------------------------

DROP TABLE IF EXISTS `modulescorerecord`;

CREATE TABLE `modulescorerecord` (
  `ModuleScoreRecordID` varchar(32) NOT NULL DEFAULT '',
  `StudentName` varchar(20) DEFAULT '',
  `StudentNum` varchar(50) DEFAULT '',
  `UploadFileURL` varchar(500) DEFAULT '',
  `UploadTime` datetime DEFAULT NULL,
  `ScoreDate` datetime DEFAULT NULL,
  `ScoreGrade` varchar(5) DEFAULT '',
  `Score` int(11) DEFAULT '0',
  `ScoreDesc` varchar(200) DEFAULT '',
  `TeachClass` varchar(32) DEFAULT '',
  `ModuleItemID` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`ModuleScoreRecordID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table newsinfo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `newsinfo`;

CREATE TABLE `newsinfo` (
  `newsBh` varchar(32) NOT NULL DEFAULT '',
  `newstype` varchar(32) DEFAULT '',
  `newstitle` varchar(50) DEFAULT '',
  `newscontent` text,
  `releaseUser` varchar(32) DEFAULT '',
  `releasetime` varchar(32) DEFAULT '',
  `Memo` text,
  `Childtype` varchar(10) DEFAULT '',
  `ImgUrl` varchar(500) DEFAULT '',
  `ClickCount` int(11) DEFAULT '0',
  PRIMARY KEY (`newsBh`),
  KEY `PK1` (`newsBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table openconfigure
# ------------------------------------------------------------

DROP TABLE IF EXISTS `openconfigure`;

CREATE TABLE `openconfigure` (
  `ConfigureBh` varchar(32) NOT NULL DEFAULT '',
  `TestDate` varchar(50) DEFAULT '',
  `TestCustomBh` varchar(32) DEFAULT '',
  `TestRoomBh` varchar(32) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`ConfigureBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table otherscorerecord
# ------------------------------------------------------------

DROP TABLE IF EXISTS `otherscorerecord`;

CREATE TABLE `otherscorerecord` (
  `OtherScoreRecordID` varchar(32) NOT NULL DEFAULT '',
  `StudentName` varchar(20) DEFAULT '',
  `StudentNum` varchar(50) DEFAULT '',
  `ScoreDate` datetime DEFAULT NULL,
  `ScoreGrade` varchar(5) DEFAULT '',
  `Score` int(11) DEFAULT '0',
  `ScoreDesc` varchar(200) DEFAULT '',
  `TeachClass` varchar(32) DEFAULT '',
  PRIMARY KEY (`OtherScoreRecordID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table paperconfigure
# ------------------------------------------------------------

DROP TABLE IF EXISTS `paperconfigure`;

CREATE TABLE `paperconfigure` (
  `PaperConfigureID` varchar(32) NOT NULL DEFAULT '',
  `QuestionType` varchar(20) NOT NULL DEFAULT '',
  `QuestionTypeNumber` int(11) NOT NULL DEFAULT '0',
  `EveryQuestionSocre` varchar(10) NOT NULL DEFAULT '',
  `difficulty` varchar(10) NOT NULL DEFAULT '',
  `stage` varchar(100) NOT NULL DEFAULT '',
  `Memo` varchar(500) DEFAULT '',
  `ExamPlanBh` varchar(32) DEFAULT '',
  `ExamConfigRecordID` varchar(32) DEFAULT '',
  PRIMARY KEY (`PaperConfigureID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table platformmannage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `platformmannage`;

CREATE TABLE `platformmannage` (
  `PlatformID` varchar(32) NOT NULL DEFAULT '',
  `ServerAddress` varchar(100) NOT NULL DEFAULT '',
  `DBName` varchar(100) DEFAULT '',
  `DBUserName` varchar(100) DEFAULT '',
  `DBPassword` varchar(50) DEFAULT '',
  `DBAddress` varchar(100) DEFAULT '',
  `Memo` varchar(300) DEFAULT '',
  PRIMARY KEY (`PlatformID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table plugins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `plugins`;

CREATE TABLE `plugins` (
  `ID` varchar(32) NOT NULL DEFAULT '',
  `PluginsName` varchar(100) DEFAULT '',
  `Environment` varchar(20) DEFAULT '',
  `Version` varchar(100) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table question
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question`;

CREATE TABLE `question` (
  `QuestionID` varchar(32) NOT NULL DEFAULT '',
  `StudentName` varchar(20) DEFAULT '',
  `StudentNum` varchar(50) DEFAULT '',
  `QuestionDate` datetime DEFAULT NULL,
  `Score` int(11) DEFAULT '0',
  `ScoreGrade` varchar(5) DEFAULT '',
  `QuestionState` varchar(50) DEFAULT '',
  `TeachClass` varchar(32) DEFAULT '',
  PRIMARY KEY (`QuestionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `CustomBh` varchar(50) DEFAULT '',
  `IsProgramming` int(11) NOT NULL DEFAULT '0',
  `Score` double DEFAULT '0',
  `Difficulty` int(11) NOT NULL DEFAULT '0',
  `Chapter` int(11) DEFAULT '0',
  `Stage` int(11) NOT NULL DEFAULT '0',
  `Description` text,
  `QuestionType` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(1000) DEFAULT '',
  `SourceCode` text,
  `StartTag` varchar(50) DEFAULT '',
  `EndTag` varchar(50) DEFAULT '',
  `AnswerDescript` varchar(1000) DEFAULT '',
  `Answer` text,
  `KnowledgeBh` varchar(32) DEFAULT '',
  `Memo` varchar(8000) DEFAULT '',
  `IsProgramBlank` varchar(50) DEFAULT '',
  `Checked` varchar(50) DEFAULT '',
  `AddTime` datetime DEFAULT NULL,
  PRIMARY KEY (`QuestionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table scorepoint
# ------------------------------------------------------------

DROP TABLE IF EXISTS `scorepoint`;

CREATE TABLE `scorepoint` (
  `ScoreID` int(11) NOT NULL DEFAULT '0',
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `ReadType` int(11) DEFAULT '0',
  `Answer` varchar(500) NOT NULL DEFAULT '',
  `Proportion` double DEFAULT '0',
  `Memo` varchar(100) DEFAULT '',
  PRIMARY KEY (`ScoreID`,`QuestionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table seat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `seat`;

CREATE TABLE `seat` (
  `SeatBh` varchar(32) NOT NULL DEFAULT '',
  `SeatIP` varchar(50) DEFAULT '',
  `SeatMAC` varchar(50) DEFAULT '',
  `SeatAlias` varchar(32) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `TestRoomBh` varchar(32) DEFAULT '',
  PRIMARY KEY (`SeatBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table seatarrangement
# ------------------------------------------------------------

DROP TABLE IF EXISTS `seatarrangement`;

CREATE TABLE `seatarrangement` (
  `SeatArrangementID` varchar(15) NOT NULL DEFAULT '',
  `StuNumber` varchar(50) DEFAULT '',
  `SeatNumber` varchar(10) NOT NULL DEFAULT '',
  `IPAddress` varchar(20) DEFAULT '',
  `ICNumber` varchar(18) NOT NULL DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `ClassRoomID` int(11) DEFAULT '0',
  `ExamPlanBh` varchar(32) DEFAULT '',
  PRIMARY KEY (`SeatArrangementID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table seatdistribution
# ------------------------------------------------------------

DROP TABLE IF EXISTS `seatdistribution`;

CREATE TABLE `seatdistribution` (
  `DistributionBh` varchar(32) NOT NULL DEFAULT '',
  `TestRoomName` varchar(50) DEFAULT '',
  `SeatName` varchar(50) DEFAULT '',
  `PersonalPhotos` varchar(200) DEFAULT '',
  `TestTime` varchar(100) DEFAULT '',
  `beginTime` varchar(50) DEFAULT '',
  `EndTime` varchar(50) DEFAULT '',
  `ICNumber` varchar(18) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `SeatBh` varchar(32) DEFAULT '',
  PRIMARY KEY (`DistributionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table signin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `signin`;

CREATE TABLE `signin` (
  `SignInID` varchar(32) NOT NULL DEFAULT '',
  `SignInTime` varchar(100) DEFAULT '',
  `SignOutTime` varchar(100) DEFAULT '',
  `IPAddress` varchar(50) DEFAULT '',
  `MacAddress` varchar(50) DEFAULT '',
  `Memo` varchar(100) DEFAULT '',
  `StuNumber` varchar(50) DEFAULT '',
  `LeaveIP` varchar(50) DEFAULT '',
  `LeaveMac` varchar(50) DEFAULT '',
  PRIMARY KEY (`SignInID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sqlmapfile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sqlmapfile`;

CREATE TABLE `sqlmapfile` (
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sqlmapoutput
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sqlmapoutput`;

CREATE TABLE `sqlmapoutput` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(4000) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table staticmodulepercent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `staticmodulepercent`;

CREATE TABLE `staticmodulepercent` (
  `StaticID` varchar(32) NOT NULL DEFAULT '',
  `AttendancePercent` int(11) DEFAULT '0',
  `HomeworkPercent` int(11) DEFAULT '0',
  `QuestionPercent` int(11) DEFAULT '0',
  `OtherPercent` int(11) DEFAULT '0',
  `TeachingClassID` varchar(32) DEFAULT '',
  PRIMARY KEY (`StaticID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table stuanswer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stuanswer`;

CREATE TABLE `stuanswer` (
  `PaperBh` varchar(32) NOT NULL DEFAULT '',
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `Answer` text,
  `Score` varchar(10) NOT NULL DEFAULT '',
  `SubjectScore` varchar(10) DEFAULT '',
  `TestTime` varchar(50) DEFAULT '',
  `SubmitTime` varchar(50) DEFAULT '',
  `Memo` text,
  `IsSuccess` varchar(50) DEFAULT '',
  PRIMARY KEY (`PaperBh`,`QuestionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table studentinfo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `studentinfo`;

CREATE TABLE `studentinfo` (
  `StuNumber` varchar(50) NOT NULL DEFAULT '',
  `ICNumber` varchar(18) NOT NULL DEFAULT '',
  `Name` varchar(30) NOT NULL DEFAULT '',
  `Sex` varchar(5) NOT NULL DEFAULT '',
  `Password` varchar(32) NOT NULL DEFAULT '',
  `ClassName` varchar(50) DEFAULT '',
  `DepartmentName` varchar(50) DEFAULT '',
  `MajorName` varchar(50) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `StudentPhoto` varchar(500) DEFAULT '',
  PRIMARY KEY (`StuNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table studentswork
# ------------------------------------------------------------

DROP TABLE IF EXISTS `studentswork`;

CREATE TABLE `studentswork` (
  `StudentWorkID` varchar(32) NOT NULL DEFAULT '',
  `HomeworkID` varchar(32) DEFAULT '',
  `StudentName` varchar(20) DEFAULT '',
  `StudentNum` varchar(50) DEFAULT '',
  `TeacherName` varchar(20) DEFAULT '',
  `WorkContent` text,
  `GetScore` int(11) DEFAULT '0',
  `ScoreGrade` varchar(5) DEFAULT '',
  `AnswerURL` varchar(500) DEFAULT '',
  `uploadTime` datetime DEFAULT NULL,
  `MarkDate` datetime DEFAULT NULL,
  `TeachClass` varchar(32) DEFAULT '',
  `Memo` varchar(300) DEFAULT '',
  PRIMARY KEY (`StudentWorkID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table studentwork
# ------------------------------------------------------------

DROP TABLE IF EXISTS `studentwork`;

CREATE TABLE `studentwork` (
  `StudentWorkID` varchar(32) NOT NULL DEFAULT '',
  `StuNumber` varchar(50) DEFAULT '',
  `StuName` varchar(100) DEFAULT '',
  `FileURL` varchar(100) DEFAULT '',
  `FileName` varchar(100) DEFAULT '',
  `UploadTime` datetime DEFAULT NULL,
  `TeachingClassID` varchar(32) DEFAULT '',
  `StudentWorkName` varchar(50) DEFAULT '',
  `Score` double DEFAULT '0',
  `Memo` text,
  `WorkFileID` varchar(32) DEFAULT '',
  `EngineeringPracticeID` varchar(32) DEFAULT '',
  `PracticereReportName` text,
  `ReportFileUrl` varchar(100) DEFAULT '',
  PRIMARY KEY (`StudentWorkID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table stuhelp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stuhelp`;

CREATE TABLE `stuhelp` (
  `StuHelpBh` varchar(32) NOT NULL DEFAULT '',
  `StuHelpName` varchar(32) DEFAULT '',
  `QQ` varchar(20) DEFAULT '',
  `StuHelpClass` varchar(32) DEFAULT '',
  `stuHelpCourse` varchar(32) DEFAULT '',
  `StuHelpPhotos` varchar(100) DEFAULT '',
  `signature` varchar(50) DEFAULT '',
  `Memo` varchar(50) DEFAULT '',
  PRIMARY KEY (`StuHelpBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table stuscore
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stuscore`;

CREATE TABLE `stuscore` (
  `OrderNumber` varchar(32) NOT NULL DEFAULT '',
  `StuNumber` varchar(50) DEFAULT '',
  `CourseID` varchar(32) DEFAULT '',
  `TeachingClassID` varchar(32) DEFAULT '',
  `NumOfModule` varchar(100) DEFAULT '',
  `NumOfExam` varchar(10) NOT NULL DEFAULT '',
  `PlaceOfExam` varchar(200) NOT NULL DEFAULT '',
  `Weights` varchar(10) NOT NULL DEFAULT '',
  `StarTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `ExamScore` varchar(20) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `ExamPlanBh` varchar(32) DEFAULT '',
  PRIMARY KEY (`OrderNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table stutest
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stutest`;

CREATE TABLE `stutest` (
  `StuNumber` varchar(32) NOT NULL DEFAULT '',
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `StuName` varchar(200) DEFAULT '',
  `StuAnswer` varchar(8000) DEFAULT '',
  `SubmitTime` varchar(100) DEFAULT '',
  `Memo` varchar(500) DEFAULT '',
  `Score` varchar(100) DEFAULT '',
  `DetailsID` varchar(32) DEFAULT '',
  PRIMARY KEY (`StuNumber`,`QuestionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table stutestrecord
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stutestrecord`;

CREATE TABLE `stutestrecord` (
  `TestRecordID` varchar(32) NOT NULL DEFAULT '',
  `StuNumber` varchar(32) NOT NULL DEFAULT '',
  `StuName` varchar(200) DEFAULT '',
  `TeachingClassID` varchar(32) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`TestRecordID`,`StuNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table stutestrecorddetails
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stutestrecorddetails`;

CREATE TABLE `stutestrecorddetails` (
  `DetailsID` varchar(32) NOT NULL DEFAULT '',
  `InTestTime` datetime DEFAULT NULL,
  `OutTestTime` datetime DEFAULT NULL,
  `TestTimeSpan` varchar(20) DEFAULT '',
  `Accuracy` varchar(5) DEFAULT '',
  `Memo` varchar(100) DEFAULT '',
  `TestRecordID` varchar(32) DEFAULT '',
  `StuNumber` varchar(32) DEFAULT '',
  `IPAddress` varchar(50) DEFAULT '',
  `MacAddress` varchar(50) DEFAULT '',
  PRIMARY KEY (`DetailsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sysdiagrams
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sysdiagrams`;

CREATE TABLE `sysdiagrams` (
  `name` varchar(128) NOT NULL DEFAULT '',
  `principal_id` int(11) NOT NULL DEFAULT '0',
  `diagram_id` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) DEFAULT '0',
  `definition` text,
  PRIMARY KEY (`diagram_id`),
  KEY `UK_principal_name` (`principal_id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbcuitmoon_dictionary
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbcuitmoon_dictionary`;

CREATE TABLE `tbcuitmoon_dictionary` (
  `CuitMoon_DictionaryID` char(32) NOT NULL,
  `CuitMoon_DictionaryName` varchar(50) NOT NULL,
  `CuitMoon_DictionaryCode` varchar(50) NOT NULL,
  `CuitMoon_ParentDictionaryID` varchar(50) DEFAULT NULL,
  `CuitMoon_DictionaryOrderNum` int(11) DEFAULT NULL,
  `CuitMoon_DictionaryRemarks` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`CuitMoon_DictionaryID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `tbcuitmoon_dictionary` WRITE;
/*!40000 ALTER TABLE `tbcuitmoon_dictionary` DISABLE KEYS */;

INSERT INTO `tbcuitmoon_dictionary` (`CuitMoon_DictionaryID`, `CuitMoon_DictionaryName`, `CuitMoon_DictionaryCode`, `CuitMoon_ParentDictionaryID`, `CuitMoon_DictionaryOrderNum`, `CuitMoon_DictionaryRemarks`)
VALUES
	('0B96F0FD929D71527849612BC7500D0D','是否','isOrNot','0',NULL,NULL),
	('9986820AF537E66546A39D9F7DE3D060','是','1','0B96F0FD929D71527849612BC7500D0D',NULL,NULL);

/*!40000 ALTER TABLE `tbcuitmoon_dictionary` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tbcuitmoon_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbcuitmoon_log`;

CREATE TABLE `tbcuitmoon_log` (
  `CuitMoon_LogID` char(32) NOT NULL,
  `CuitMoon_LogType` varchar(32) DEFAULT NULL,
  `CuitMoon_LogOperationUserName` varchar(20) DEFAULT NULL,
  `CuitMoon_LogOperationIPv4` varchar(50) DEFAULT NULL,
  `CuitMoon_LogOperationIPv6` varchar(50) DEFAULT NULL,
  `CuitMoon_LogOperationTime` datetime DEFAULT NULL,
  `CuitMoon_LogOperationName` varchar(50) DEFAULT NULL,
  `CuitMoon_LogOperationURL` varchar(200) DEFAULT NULL,
  `CuitMoon_LogRemarks` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`CuitMoon_LogID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table tbcuitmoon_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbcuitmoon_module`;

CREATE TABLE `tbcuitmoon_module` (
  `CuitMoon_ModuleID` char(32) NOT NULL,
  `CuitMoon_ModuleName` varchar(20) NOT NULL,
  `CuitMoon_ModuleURL` varchar(200) DEFAULT NULL,
  `CuitMoon_ModuleIcon` varchar(200) DEFAULT NULL,
  `CuitMoon_ParentModuleID` char(32) DEFAULT NULL,
  `CuitMoon_ModuleStatus` varchar(50) DEFAULT NULL,
  `CuitMoon_ModuleOrderNum` int(11) DEFAULT NULL,
  `CuitMoon_ModuleDescription` varchar(200) DEFAULT NULL,
  `CuitMoon_ModuleRemarks` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`CuitMoon_ModuleID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `tbcuitmoon_module` WRITE;
/*!40000 ALTER TABLE `tbcuitmoon_module` DISABLE KEYS */;

INSERT INTO `tbcuitmoon_module` (`CuitMoon_ModuleID`, `CuitMoon_ModuleName`, `CuitMoon_ModuleURL`, `CuitMoon_ModuleIcon`, `CuitMoon_ParentModuleID`, `CuitMoon_ModuleStatus`, `CuitMoon_ModuleOrderNum`, `CuitMoon_ModuleDescription`, `CuitMoon_ModuleRemarks`)
VALUES
	('9ED7D43DA8D69F0F55E403690FAB26E9','系统管理','/system',NULL,'0','1',NULL,'',''),
	('F6CAA398BE8D5478489B3B9F3842E52C','基本信息管理','/baseInfo',NULL,'0','1',NULL,'',''),
	('6ED91FA803239376B7F700E5EA3F936E','模块管理','/system/module/index',NULL,'9ED7D43DA8D69F0F55E403690FAB26E9','1',NULL,'',''),
	('0B21C1FCC771065E143470AB41A524A9','系统数据管理','/systemData',NULL,'0','1',NULL,'',''),
	('ABDC9993A22A74191D2BADD1E1AB247F','教学计划管理','/teachPlay',NULL,'0','1',NULL,'',''),
	('EA50E095143975C3A4C56970C24D2014','考试管理','/exam',NULL,'0','1',NULL,'',''),
	('D9744C471A3EE3C19779E630EA01B1DA','成绩管理','/grage',NULL,'0','1',NULL,'',''),
	('6D1659A3FE96F674173CC7EFBAFEC469','题库管理','/question',NULL,'0','1',NULL,'',''),
	('28AB49FBFA5CEBF44ECCA502BF53D816','预约系统','/reservation',NULL,'0','1',NULL,'',''),
	('7ADDC1D159CAC2ADE768C07214037E61','字典管理','/system/dictionary/index',NULL,'9ED7D43DA8D69F0F55E403690FAB26E9','1',NULL,'','');

/*!40000 ALTER TABLE `tbcuitmoon_module` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tbcuitmoon_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbcuitmoon_user`;

CREATE TABLE `tbcuitmoon_user` (
  `CuitMoon_UserID` char(32) NOT NULL,
  `CuitMoon_UserName` varchar(20) NOT NULL,
  `CuitMoon_UserPassWord` char(100) NOT NULL,
  `CuitMoon_UserRealName` varchar(20) DEFAULT NULL,
  `CuitMoon_UserSex` varchar(50) DEFAULT NULL,
  `CuitMoon_UserBirthday` datetime DEFAULT NULL,
  `CuitMoon_UserCellphone` varchar(15) DEFAULT NULL,
  `CuitMoon_UserAddress` varchar(100) DEFAULT NULL,
  `CuitMoon_UserZipCode` varchar(10) DEFAULT NULL,
  `CuitMoon_UserEmail` varchar(100) DEFAULT NULL,
  `CuitMoon_UserQQ` varchar(12) DEFAULT NULL,
  `CuitMoon_UserMSN` varchar(100) DEFAULT NULL,
  `CuitMoon_UserRegTime` datetime DEFAULT NULL,
  `CuitMoon_UserLoginCount` bigint(20) DEFAULT NULL,
  `CuitMoon_UserStatus` varchar(50) DEFAULT NULL,
  `CuitMoon_AreaCode` varchar(100) DEFAULT NULL,
  `CuitMoon_DepartmentID` char(32) DEFAULT NULL,
  `CuitMoon_UserLoginStatus` varchar(50) DEFAULT NULL,
  `CuitMoon_UserWorkingStatus` varchar(50) DEFAULT NULL,
  `CuitMoon_UserLevel` varchar(50) DEFAULT NULL,
  `CuitMoon_Discount` decimal(10,2) DEFAULT NULL,
  `CuitMoon_UserRemarks` varchar(200) DEFAULT NULL,
  `CuitMoon_UserAuthKey` char(100) DEFAULT NULL,
  PRIMARY KEY (`CuitMoon_UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `tbcuitmoon_user` WRITE;
/*!40000 ALTER TABLE `tbcuitmoon_user` DISABLE KEYS */;

INSERT INTO `tbcuitmoon_user` (`CuitMoon_UserID`, `CuitMoon_UserName`, `CuitMoon_UserPassWord`, `CuitMoon_UserRealName`, `CuitMoon_UserSex`, `CuitMoon_UserBirthday`, `CuitMoon_UserCellphone`, `CuitMoon_UserAddress`, `CuitMoon_UserZipCode`, `CuitMoon_UserEmail`, `CuitMoon_UserQQ`, `CuitMoon_UserMSN`, `CuitMoon_UserRegTime`, `CuitMoon_UserLoginCount`, `CuitMoon_UserStatus`, `CuitMoon_AreaCode`, `CuitMoon_DepartmentID`, `CuitMoon_UserLoginStatus`, `CuitMoon_UserWorkingStatus`, `CuitMoon_UserLevel`, `CuitMoon_Discount`, `CuitMoon_UserRemarks`, `CuitMoon_UserAuthKey`)
VALUES
	('1','admin','$2y$13$9O6bKJieocg//oSax9fZOOuljAKarBXknqD8.RyYg60FfNjS7SoqK',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'10',NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `tbcuitmoon_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table teachingclassdetails
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teachingclassdetails`;

CREATE TABLE `teachingclassdetails` (
  `TeachingClassDetailsID` varchar(32) NOT NULL DEFAULT '',
  `TeachingClassID` varchar(32) DEFAULT '',
  `StuNumber` varchar(50) DEFAULT '',
  PRIMARY KEY (`TeachingClassDetailsID`),
  KEY `PK5` (`TeachingClassDetailsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table teachingclassmannage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teachingclassmannage`;

CREATE TABLE `teachingclassmannage` (
  `TeachingClassID` varchar(32) NOT NULL DEFAULT '',
  `TeacherName` varchar(50) NOT NULL DEFAULT '',
  `TeachingName` varchar(100) NOT NULL DEFAULT '',
  `Term` varchar(20) NOT NULL DEFAULT '',
  `CourseID` varchar(32) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  `Department` varchar(100) DEFAULT '',
  PRIMARY KEY (`TeachingClassID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table temp_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `temp_data`;

CREATE TABLE `temp_data` (
  `output` varchar(1000) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table testapply
# ------------------------------------------------------------

DROP TABLE IF EXISTS `testapply`;

CREATE TABLE `testapply` (
  `ApplyBh` varchar(32) NOT NULL DEFAULT '',
  `EntityName` varchar(50) DEFAULT '',
  `ContactName` varchar(10) DEFAULT '',
  `Phone` varchar(32) DEFAULT '',
  `Email` varchar(32) DEFAULT '',
  `qq` varchar(15) DEFAULT '',
  `Content` text,
  `SubmitTime` varchar(32) DEFAULT '',
  `IP` varchar(32) DEFAULT '',
  `DealState` varchar(10) DEFAULT '',
  `DealName` varchar(10) DEFAULT '',
  `Memo` text,
  PRIMARY KEY (`ApplyBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table testcase
# ------------------------------------------------------------

DROP TABLE IF EXISTS `testcase`;

CREATE TABLE `testcase` (
  `TestCaseBh` varchar(32) NOT NULL DEFAULT '',
  `ScoreWeight` double NOT NULL DEFAULT '0',
  `TestCaseInput` varchar(500) NOT NULL DEFAULT '',
  `TestCaseOutput` varchar(500) NOT NULL DEFAULT '',
  `TestCaseTips` varchar(100) DEFAULT '',
  `QuestionId` varchar(32) DEFAULT '',
  `Memo` varchar(500) DEFAULT '',
  PRIMARY KEY (`TestCaseBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table testcustom
# ------------------------------------------------------------

DROP TABLE IF EXISTS `testcustom`;

CREATE TABLE `testcustom` (
  `TestCustomBh` varchar(32) NOT NULL DEFAULT '',
  `TestCustomName` varchar(50) DEFAULT '',
  `BeginTime` varchar(50) DEFAULT '',
  `EndTime` varchar(50) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`TestCustomBh`),
  KEY `PK6` (`TestCustomBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table testroom
# ------------------------------------------------------------

DROP TABLE IF EXISTS `testroom`;

CREATE TABLE `testroom` (
  `TestRoomBh` varchar(32) NOT NULL DEFAULT '',
  `TestRoomname` varchar(50) DEFAULT '',
  `BeginIP` varchar(50) DEFAULT '',
  `EndIP` varchar(50) DEFAULT '',
  `SeatTotal` varchar(50) DEFAULT '',
  `Memo` varchar(50) DEFAULT '',
  PRIMARY KEY (`TestRoomBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tmpsocre
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tmpsocre`;

CREATE TABLE `tmpsocre` (
  `教学班` varchar(32) DEFAULT '',
  `学号` varchar(50) DEFAULT '',
  `名称` varchar(32) DEFAULT '',
  `性别` varchar(2) DEFAULT '',
  `考勤` varchar(50) DEFAULT '',
  `平时作业` varchar(50) DEFAULT '',
  `提问` varchar(50) DEFAULT '',
  `总分` varchar(10) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

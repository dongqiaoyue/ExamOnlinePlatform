/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : stu_system

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-10-25 21:30:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ab
-- ----------------------------
DROP TABLE IF EXISTS `ab`;
CREATE TABLE `ab` (
  `TeachingClassID` varchar(32) DEFAULT '',
  `StuNumber` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ab
-- ----------------------------

-- ----------------------------
-- Table structure for ac
-- ----------------------------
DROP TABLE IF EXISTS `ac`;
CREATE TABLE `ac` (
  `TeachingClassID` varchar(32) DEFAULT '',
  `StuNumber` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ac
-- ----------------------------

-- ----------------------------
-- Table structure for admin
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', 'BAscckbHf91npOYsxfv6KCxY-nqIM5M3', '$2y$13$7cOXBX41QMUabgvmCXrp4eHvrG07lqQHDjcHEuSekjld6objrl6Yy', null, 'liu.lipeng@newsnow.com.cn', '10', '1476709757', '1476709757');

-- ----------------------------
-- Table structure for admin_log
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_log
-- ----------------------------
INSERT INTO `admin_log` VALUES ('1', 'admin/permission/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/permission\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709859', '1476709859');
INSERT INTO `admin_log` VALUES ('2', 'admin/role/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/role\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709860', '1476709860');
INSERT INTO `admin_log` VALUES ('3', 'admin/rule/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/rule\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709862', '1476709862');
INSERT INTO `admin_log` VALUES ('4', 'admin/route/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/route\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709864', '1476709864');
INSERT INTO `admin_log` VALUES ('5', 'admin/route/assign', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Fassign', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/route\\/assign\"}', '{\"action\":\"remove\",\"routes\":[\"\\/admin\\/assignment\\/assign\"]}', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709872', '1476709872');
INSERT INTO `admin_log` VALUES ('6', 'admin/route/assign', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Fassign', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/route\\/assign\"}', '{\"action\":\"assign\",\"routes\":[\"\\/admin\\/assignment\\/assign\"]}', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709875', '1476709875');
INSERT INTO `admin_log` VALUES ('7', 'admin/rule/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/rule\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709880', '1476709880');
INSERT INTO `admin_log` VALUES ('8', 'admin/menu/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709881', '1476709881');
INSERT INTO `admin_log` VALUES ('9', 'admin/menu/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/index\"}', '{\"id\":\"0\"}', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709882', '1476709882');
INSERT INTO `admin_log` VALUES ('10', 'admin/assignment/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/assignment\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709884', '1476709884');
INSERT INTO `admin_log` VALUES ('11', 'admin/log/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Flog%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/log\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709885', '1476709885');
INSERT INTO `admin_log` VALUES ('12', 'admin/permission/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/permission\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709889', '1476709889');
INSERT INTO `admin_log` VALUES ('13', 'admin/permission/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/permission\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709895', '1476709895');
INSERT INTO `admin_log` VALUES ('14', 'admin/role/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/role\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709896', '1476709896');
INSERT INTO `admin_log` VALUES ('15', 'admin/role/create', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Fcreate', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/role\\/create\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709898', '1476709898');
INSERT INTO `admin_log` VALUES ('16', 'admin/permission/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/permission\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709946', '1476709946');
INSERT INTO `admin_log` VALUES ('17', 'admin/route/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/route\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709947', '1476709947');
INSERT INTO `admin_log` VALUES ('18', 'admin/rule/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/rule\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709948', '1476709948');
INSERT INTO `admin_log` VALUES ('19', 'admin/assignment/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/assignment\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709949', '1476709949');
INSERT INTO `admin_log` VALUES ('20', 'admin/assignment/create', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Fcreate', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/assignment\\/create\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476709950', '1476709950');
INSERT INTO `admin_log` VALUES ('21', 'admin/permission/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/permission\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710169', '1476710169');
INSERT INTO `admin_log` VALUES ('22', 'admin/assignment/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/assignment\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710181', '1476710181');
INSERT INTO `admin_log` VALUES ('23', 'admin/menu/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710182', '1476710182');
INSERT INTO `admin_log` VALUES ('24', 'admin/menu/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/index\"}', '{\"id\":\"0\"}', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710183', '1476710183');
INSERT INTO `admin_log` VALUES ('25', 'admin/log/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Flog%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/log\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710184', '1476710184');
INSERT INTO `admin_log` VALUES ('26', 'admin/menu/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710185', '1476710185');
INSERT INTO `admin_log` VALUES ('27', 'admin/menu/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/index\"}', '{\"id\":\"0\"}', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710186', '1476710186');
INSERT INTO `admin_log` VALUES ('28', 'admin/menu/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/index\"}', '{\"id\":\"1\"}', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710186', '1476710186');
INSERT INTO `admin_log` VALUES ('29', 'admin/menu/update', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Fupdate&id=5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/update\",\"id\":\"5\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710191', '1476710191');
INSERT INTO `admin_log` VALUES ('30', 'admin/permission/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/permission\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476710195', '1476710195');
INSERT INTO `admin_log` VALUES ('31', 'admin/role/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/role\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711804', '1476711804');
INSERT INTO `admin_log` VALUES ('32', 'admin/rule/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/rule\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711806', '1476711806');
INSERT INTO `admin_log` VALUES ('33', 'admin/route/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/route\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711807', '1476711807');
INSERT INTO `admin_log` VALUES ('34', 'admin/menu/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711809', '1476711809');
INSERT INTO `admin_log` VALUES ('35', 'admin/menu/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fmenu%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/menu\\/index\"}', '{\"id\":\"0\"}', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711809', '1476711809');
INSERT INTO `admin_log` VALUES ('36', 'admin/permission/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/permission\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711936', '1476711936');
INSERT INTO `admin_log` VALUES ('37', 'admin/rule/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/rule\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711943', '1476711943');
INSERT INTO `admin_log` VALUES ('38', 'admin/role/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/role\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711945', '1476711945');
INSERT INTO `admin_log` VALUES ('39', 'admin/role/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frole%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/role\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711973', '1476711973');
INSERT INTO `admin_log` VALUES ('40', 'admin/route/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/route\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1476711975', '1476711975');
INSERT INTO `admin_log` VALUES ('41', 'admin/permission/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fpermission%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/permission\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1477317583', '1477317583');
INSERT INTO `admin_log` VALUES ('42', 'admin/rule/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Frule%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/rule\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1477317584', '1477317584');
INSERT INTO `admin_log` VALUES ('43', 'admin/assignment/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Fassignment%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/assignment\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1477317585', '1477317585');
INSERT INTO `admin_log` VALUES ('44', 'admin/route/index', 'http://localhost/yii/advanced/backend/web/index.php?r=admin%2Froute%2Findex', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:49.0) Gecko/20100101 Firefox/49.0', '{\"r\":\"admin\\/route\\/index\"}', '[]', '1', 'liu.lipeng@newsnow.com.cn', '::1', '1477317586', '1477317586');

-- ----------------------------
-- Table structure for apfill
-- ----------------------------
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

-- ----------------------------
-- Records of apfill
-- ----------------------------

-- ----------------------------
-- Table structure for appointment
-- ----------------------------
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

-- ----------------------------
-- Records of appointment
-- ----------------------------

-- ----------------------------
-- Table structure for attendancerecord
-- ----------------------------
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

-- ----------------------------
-- Records of attendancerecord
-- ----------------------------

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('Admin', '1', '1457092343');

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
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

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('/admin/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/assignment/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/assignment/assign', '2', null, null, null, '1476709875', '1476709875');
INSERT INTO `auth_item` VALUES ('/admin/assignment/create', '2', null, null, null, '1457521995', '1457521995');
INSERT INTO `auth_item` VALUES ('/admin/assignment/delete', '2', null, null, null, '1458010804', '1458010804');
INSERT INTO `auth_item` VALUES ('/admin/assignment/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/assignment/search', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/assignment/update', '2', null, null, null, '1458010804', '1458010804');
INSERT INTO `auth_item` VALUES ('/admin/assignment/view', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/default/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/default/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/log/*', '2', null, null, null, '1468288689', '1468288689');
INSERT INTO `auth_item` VALUES ('/admin/log/index', '2', null, null, null, '1468288689', '1468288689');
INSERT INTO `auth_item` VALUES ('/admin/log/view', '2', null, null, null, '1468288689', '1468288689');
INSERT INTO `auth_item` VALUES ('/admin/menu/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/menu/create', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/menu/delete', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/menu/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/menu/update', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/menu/view', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/permission/*', '2', null, null, null, '1457948575', '1457948575');
INSERT INTO `auth_item` VALUES ('/admin/permission/assign', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/permission/create', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/permission/delete', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/permission/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/permission/search', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/permission/update', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/permission/view', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/role/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/role/assign', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/role/create', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/role/delete', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/role/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/role/search', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/role/update', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/role/view', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/route/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/route/assign', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/route/create', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/route/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/route/refresh', '2', null, null, null, '1457947924', '1457947924');
INSERT INTO `auth_item` VALUES ('/admin/route/search', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/rule/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/rule/create', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/rule/delete', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/rule/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/rule/update', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/admin/rule/view', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/debug/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/debug/default/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/debug/default/db-explain', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/debug/default/download-mail', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/debug/default/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/debug/default/toolbar', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/debug/default/view', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/gii/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/gii/default/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/gii/default/action', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/gii/default/diff', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/gii/default/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/gii/default/preview', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/gii/default/view', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/site/*', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/site/error', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/site/index', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/site/login', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('/site/logout', '2', null, null, null, '1457330826', '1457330826');
INSERT INTO `auth_item` VALUES ('Admin', '1', 'Administrators', null, null, '1457084487', '1457947508');
INSERT INTO `auth_item` VALUES ('修改用户', '2', null, null, null, '1457522051', '1457522051');
INSERT INTO `auth_item` VALUES ('修改菜单', '2', null, null, null, '1457330464', '1457405433');
INSERT INTO `auth_item` VALUES ('删除权限', '2', null, null, null, '1457331320', '1457331320');
INSERT INTO `auth_item` VALUES ('删除菜单', '2', null, null, null, '1457330485', '1457330485');
INSERT INTO `auth_item` VALUES ('删除规则', '2', null, null, null, '1457331677', '1457331677');
INSERT INTO `auth_item` VALUES ('删除角色', '2', null, null, null, '1457331161', '1457331161');
INSERT INTO `auth_item` VALUES ('删除路由', '2', null, null, null, '1457331499', '1457331499');
INSERT INTO `auth_item` VALUES ('操作日志', '2', null, null, null, '1468288713', '1468288713');
INSERT INTO `auth_item` VALUES ('新增权限', '2', null, null, null, '1457331279', '1457331279');
INSERT INTO `auth_item` VALUES ('新增用户', '2', null, null, null, '1457433802', '1457433802');
INSERT INTO `auth_item` VALUES ('新增菜单', '2', null, null, null, '1457330445', '1457330445');
INSERT INTO `auth_item` VALUES ('新增规则', '2', null, null, null, '1457331552', '1457331610');
INSERT INTO `auth_item` VALUES ('新增角色', '2', null, null, null, '1457331075', '1457331075');
INSERT INTO `auth_item` VALUES ('新增路由', '2', null, null, null, '1457331386', '1457331386');
INSERT INTO `auth_item` VALUES ('更新权限', '2', null, null, null, '1457331303', '1457331303');
INSERT INTO `auth_item` VALUES ('更新规则', '2', null, null, null, '1457331647', '1457331647');
INSERT INTO `auth_item` VALUES ('更新角色', '2', null, null, null, '1457331126', '1457331126');
INSERT INTO `auth_item` VALUES ('更新路由', '2', null, null, null, '1457331492', '1457331492');
INSERT INTO `auth_item` VALUES ('权限分配', '2', null, null, null, '1457418746', '1457418746');
INSERT INTO `auth_item` VALUES ('权限管理', '2', null, null, null, '1457331258', '1457331258');
INSERT INTO `auth_item` VALUES ('查看操作日志', '2', null, null, null, '1468294314', '1468294314');
INSERT INTO `auth_item` VALUES ('查看权限', '2', null, null, null, '1457331342', '1457331342');
INSERT INTO `auth_item` VALUES ('查看用户权限', '2', null, null, null, '1457331965', '1457331965');
INSERT INTO `auth_item` VALUES ('查看菜单', '2', null, null, null, '1457330619', '1457330619');
INSERT INTO `auth_item` VALUES ('查看规则', '2', null, null, null, '1457331692', '1457331692');
INSERT INTO `auth_item` VALUES ('查看角色', '2', null, null, null, '1457331191', '1457331191');
INSERT INTO `auth_item` VALUES ('用户权限分配', '2', null, null, null, '1457333258', '1457333258');
INSERT INTO `auth_item` VALUES ('用户管理', '2', null, null, null, '1457079781', '1457331877');
INSERT INTO `auth_item` VALUES ('菜单管理', '2', null, null, null, '1457324314', '1457324314');
INSERT INTO `auth_item` VALUES ('规则管理', '2', null, null, null, '1457331529', '1457331529');
INSERT INTO `auth_item` VALUES ('角色权限分配', '2', null, null, null, '1457333688', '1457333688');
INSERT INTO `auth_item` VALUES ('角色管理', '2', null, null, null, '1457330790', '1457330790');
INSERT INTO `auth_item` VALUES ('路由分配', '2', null, null, null, '1457333742', '1457333742');
INSERT INTO `auth_item` VALUES ('路由管理', '2', null, null, null, '1457331368', '1457331368');

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('Admin', '修改用户');
INSERT INTO `auth_item_child` VALUES ('Admin', '修改菜单');
INSERT INTO `auth_item_child` VALUES ('Admin', '删除权限');
INSERT INTO `auth_item_child` VALUES ('Admin', '删除菜单');
INSERT INTO `auth_item_child` VALUES ('Admin', '删除规则');
INSERT INTO `auth_item_child` VALUES ('Admin', '删除角色');
INSERT INTO `auth_item_child` VALUES ('Admin', '删除路由');
INSERT INTO `auth_item_child` VALUES ('Admin', '操作日志');
INSERT INTO `auth_item_child` VALUES ('Admin', '新增权限');
INSERT INTO `auth_item_child` VALUES ('Admin', '新增用户');
INSERT INTO `auth_item_child` VALUES ('Admin', '新增菜单');
INSERT INTO `auth_item_child` VALUES ('Admin', '新增规则');
INSERT INTO `auth_item_child` VALUES ('Admin', '新增角色');
INSERT INTO `auth_item_child` VALUES ('Admin', '新增路由');
INSERT INTO `auth_item_child` VALUES ('Admin', '更新权限');
INSERT INTO `auth_item_child` VALUES ('Admin', '更新规则');
INSERT INTO `auth_item_child` VALUES ('Admin', '更新角色');
INSERT INTO `auth_item_child` VALUES ('Admin', '更新路由');
INSERT INTO `auth_item_child` VALUES ('Admin', '权限分配');
INSERT INTO `auth_item_child` VALUES ('Admin', '权限管理');
INSERT INTO `auth_item_child` VALUES ('Admin', '查看操作日志');
INSERT INTO `auth_item_child` VALUES ('Admin', '查看权限');
INSERT INTO `auth_item_child` VALUES ('Admin', '查看用户权限');
INSERT INTO `auth_item_child` VALUES ('Admin', '查看菜单');
INSERT INTO `auth_item_child` VALUES ('Admin', '查看规则');
INSERT INTO `auth_item_child` VALUES ('Admin', '查看角色');
INSERT INTO `auth_item_child` VALUES ('Admin', '用户权限分配');
INSERT INTO `auth_item_child` VALUES ('Admin', '用户管理');
INSERT INTO `auth_item_child` VALUES ('Admin', '菜单管理');
INSERT INTO `auth_item_child` VALUES ('Admin', '规则管理');
INSERT INTO `auth_item_child` VALUES ('Admin', '角色权限分配');
INSERT INTO `auth_item_child` VALUES ('Admin', '角色管理');
INSERT INTO `auth_item_child` VALUES ('Admin', '路由分配');
INSERT INTO `auth_item_child` VALUES ('Admin', '路由管理');
INSERT INTO `auth_item_child` VALUES ('修改用户', '/admin/assignment/update');
INSERT INTO `auth_item_child` VALUES ('修改菜单', '/admin/menu/update');
INSERT INTO `auth_item_child` VALUES ('删除权限', '/admin/permission/delete');
INSERT INTO `auth_item_child` VALUES ('删除菜单', '/admin/menu/delete');
INSERT INTO `auth_item_child` VALUES ('删除规则', '/admin/rule/delete');
INSERT INTO `auth_item_child` VALUES ('删除角色', '/admin/role/delete');
INSERT INTO `auth_item_child` VALUES ('操作日志', '/admin/log/index');
INSERT INTO `auth_item_child` VALUES ('新增权限', '/admin/permission/create');
INSERT INTO `auth_item_child` VALUES ('新增用户', '/admin/assignment/create');
INSERT INTO `auth_item_child` VALUES ('新增菜单', '/admin/menu/create');
INSERT INTO `auth_item_child` VALUES ('新增规则', '/admin/rule/create');
INSERT INTO `auth_item_child` VALUES ('新增角色', '/admin/role/create');
INSERT INTO `auth_item_child` VALUES ('新增路由', '/admin/route/create');
INSERT INTO `auth_item_child` VALUES ('更新权限', '/admin/permission/update');
INSERT INTO `auth_item_child` VALUES ('更新规则', '/admin/rule/update');
INSERT INTO `auth_item_child` VALUES ('更新角色', '/admin/role/update');
INSERT INTO `auth_item_child` VALUES ('权限分配', '/admin/permission/assign');
INSERT INTO `auth_item_child` VALUES ('权限管理', '/admin/permission/index');
INSERT INTO `auth_item_child` VALUES ('查看操作日志', '/admin/log/view');
INSERT INTO `auth_item_child` VALUES ('查看权限', '/admin/permission/search');
INSERT INTO `auth_item_child` VALUES ('查看权限', '/admin/permission/view');
INSERT INTO `auth_item_child` VALUES ('查看用户权限', '/admin/assignment/search');
INSERT INTO `auth_item_child` VALUES ('查看用户权限', '/admin/assignment/view');
INSERT INTO `auth_item_child` VALUES ('查看菜单', '/admin/menu/view');
INSERT INTO `auth_item_child` VALUES ('查看规则', '/admin/route/index');
INSERT INTO `auth_item_child` VALUES ('查看规则', '/admin/route/search');
INSERT INTO `auth_item_child` VALUES ('查看角色', '/admin/role/search');
INSERT INTO `auth_item_child` VALUES ('查看角色', '/admin/role/view');
INSERT INTO `auth_item_child` VALUES ('用户管理', '/admin/assignment/index');
INSERT INTO `auth_item_child` VALUES ('菜单管理', '/admin/menu/index');
INSERT INTO `auth_item_child` VALUES ('规则管理', '/admin/rule/index');
INSERT INTO `auth_item_child` VALUES ('角色权限分配', '/admin/role/assign');
INSERT INTO `auth_item_child` VALUES ('角色管理', '/admin/role/index');
INSERT INTO `auth_item_child` VALUES ('路由分配', '/admin/route/assign');
INSERT INTO `auth_item_child` VALUES ('路由管理', '/admin/rule/index');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for classroom
-- ----------------------------
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

-- ----------------------------
-- Records of classroom
-- ----------------------------

-- ----------------------------
-- Table structure for classroomdetails
-- ----------------------------
DROP TABLE IF EXISTS `classroomdetails`;
CREATE TABLE `classroomdetails` (
  `ClassRoomDetailsID` varchar(32) NOT NULL DEFAULT '',
  `IPAddress` varchar(20) NOT NULL DEFAULT '',
  `MACAddress` varchar(30) NOT NULL DEFAULT '',
  `ClassRoomID` int(11) DEFAULT '0',
  PRIMARY KEY (`ClassRoomDetailsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of classroomdetails
-- ----------------------------

-- ----------------------------
-- Table structure for commonhomework
-- ----------------------------
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

-- ----------------------------
-- Records of commonhomework
-- ----------------------------

-- ----------------------------
-- Table structure for coursemanagement
-- ----------------------------
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

-- ----------------------------
-- Records of coursemanagement
-- ----------------------------

-- ----------------------------
-- Table structure for createpaper
-- ----------------------------
DROP TABLE IF EXISTS `createpaper`;
CREATE TABLE `createpaper` (
  `PaperBh` varchar(32) NOT NULL DEFAULT '',
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `TotalScore` varchar(32) DEFAULT '',
  `Memo` text,
  PRIMARY KEY (`PaperBh`,`QuestionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of createpaper
-- ----------------------------

-- ----------------------------
-- Table structure for developerinfo
-- ----------------------------
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

-- ----------------------------
-- Records of developerinfo
-- ----------------------------

-- ----------------------------
-- Table structure for devicetokentable
-- ----------------------------
DROP TABLE IF EXISTS `devicetokentable`;
CREATE TABLE `devicetokentable` (
  `DeviceID` varchar(32) NOT NULL DEFAULT '',
  `DeviceToken` varchar(500) DEFAULT '',
  PRIMARY KEY (`DeviceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of devicetokentable
-- ----------------------------

-- ----------------------------
-- Table structure for engineeringpractice
-- ----------------------------
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

-- ----------------------------
-- Records of engineeringpractice
-- ----------------------------

-- ----------------------------
-- Table structure for engineeringpracticepaper
-- ----------------------------
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

-- ----------------------------
-- Records of engineeringpracticepaper
-- ----------------------------

-- ----------------------------
-- Table structure for engineeringpracticestudent
-- ----------------------------
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

-- ----------------------------
-- Records of engineeringpracticestudent
-- ----------------------------

-- ----------------------------
-- Table structure for examconfigrecord
-- ----------------------------
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

-- ----------------------------
-- Records of examconfigrecord
-- ----------------------------

-- ----------------------------
-- Table structure for exampaper
-- ----------------------------
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

-- ----------------------------
-- Records of exampaper
-- ----------------------------

-- ----------------------------
-- Table structure for examplan
-- ----------------------------
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

-- ----------------------------
-- Records of examplan
-- ----------------------------

-- ----------------------------
-- Table structure for examprocess
-- ----------------------------
DROP TABLE IF EXISTS `examprocess`;
CREATE TABLE `examprocess` (
  `PaperBh` varchar(32) NOT NULL DEFAULT '',
  `QuestionBh` varchar(32) NOT NULL DEFAULT '',
  `Answer` text,
  `SubmitTime` datetime DEFAULT NULL,
  `Memo` text,
  PRIMARY KEY (`PaperBh`,`QuestionBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of examprocess
-- ----------------------------

-- ----------------------------
-- Table structure for examrecord
-- ----------------------------
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

-- ----------------------------
-- Records of examrecord
-- ----------------------------

-- ----------------------------
-- Table structure for exchange
-- ----------------------------
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

-- ----------------------------
-- Records of exchange
-- ----------------------------

-- ----------------------------
-- Table structure for exchangereply
-- ----------------------------
DROP TABLE IF EXISTS `exchangereply`;
CREATE TABLE `exchangereply` (
  `Code` varchar(32) NOT NULL DEFAULT '',
  `ReplayContent` text,
  `ReplayTime` varchar(32) DEFAULT '',
  `ReplayPeople` varchar(50) DEFAULT '',
  `ExchangeBh` varchar(32) DEFAULT '',
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exchangereply
-- ----------------------------

-- ----------------------------
-- Table structure for filecontrolprograme
-- ----------------------------
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

-- ----------------------------
-- Records of filecontrolprograme
-- ----------------------------

-- ----------------------------
-- Table structure for finderror
-- ----------------------------
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

-- ----------------------------
-- Records of finderror
-- ----------------------------

-- ----------------------------
-- Table structure for gradescoreset
-- ----------------------------
DROP TABLE IF EXISTS `gradescoreset`;
CREATE TABLE `gradescoreset` (
  `SetID` varchar(32) NOT NULL DEFAULT '',
  `GradeName` varchar(10) DEFAULT '',
  `Score` int(11) DEFAULT '0',
  `TeachingClassID` varchar(32) DEFAULT '',
  PRIMARY KEY (`SetID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gradescoreset
-- ----------------------------

-- ----------------------------
-- Table structure for guestbook
-- ----------------------------
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

-- ----------------------------
-- Records of guestbook
-- ----------------------------

-- ----------------------------
-- Table structure for guestreply
-- ----------------------------
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

-- ----------------------------
-- Records of guestreply
-- ----------------------------

-- ----------------------------
-- Table structure for knowledgepoint
-- ----------------------------
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

-- ----------------------------
-- Records of knowledgepoint
-- ----------------------------

-- ----------------------------
-- Table structure for menu
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '系统管理', null, null, null, null);
INSERT INTO `menu` VALUES ('2', '用户管理', '1', '/admin/assignment/index', '0', null);
INSERT INTO `menu` VALUES ('3', '菜单管理', '1', '/admin/menu/index', '1', null);
INSERT INTO `menu` VALUES ('4', '权限管理', '1', '/admin/permission/index', null, null);
INSERT INTO `menu` VALUES ('5', '角色管理', '1', '/admin/role/index', null, null);
INSERT INTO `menu` VALUES ('6', '路由管理', '1', '/admin/route/index', null, null);
INSERT INTO `menu` VALUES ('7', '规则管理', '1', '/admin/rule/index', null, null);
INSERT INTO `menu` VALUES ('8', '操作日志', '1', '/admin/log/index', '100', null);

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1476709729');
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', '1476709735');
INSERT INTO `migration` VALUES ('m160608_050000_create_admin', '1476709757');
INSERT INTO `migration` VALUES ('m160712_034501_create_admin_log', '1476709757');
INSERT INTO `migration` VALUES ('m160712_111327_create_menu_table', '1476709757');

-- ----------------------------
-- Table structure for module
-- ----------------------------
DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `ModuleID` varchar(32) NOT NULL DEFAULT '',
  `ModuleName` varchar(10) DEFAULT '',
  `ModulePercent` int(11) DEFAULT '0',
  `TeachingClassID` varchar(32) DEFAULT '',
  PRIMARY KEY (`ModuleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of module
-- ----------------------------

-- ----------------------------
-- Table structure for moduleitem
-- ----------------------------
DROP TABLE IF EXISTS `moduleitem`;
CREATE TABLE `moduleitem` (
  `ModuleItemID` varchar(32) NOT NULL DEFAULT '',
  `ModuleItemName` varchar(200) DEFAULT '',
  `DeadTime` datetime DEFAULT NULL,
  `ModuleID` varchar(32) NOT NULL DEFAULT '',
  `ModuleItemDetails` varchar(1000) DEFAULT '',
  PRIMARY KEY (`ModuleItemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of moduleitem
-- ----------------------------

-- ----------------------------
-- Table structure for modulescorerecord
-- ----------------------------
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

-- ----------------------------
-- Records of modulescorerecord
-- ----------------------------

-- ----------------------------
-- Table structure for newsinfo
-- ----------------------------
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

-- ----------------------------
-- Records of newsinfo
-- ----------------------------

-- ----------------------------
-- Table structure for openconfigure
-- ----------------------------
DROP TABLE IF EXISTS `openconfigure`;
CREATE TABLE `openconfigure` (
  `ConfigureBh` varchar(32) NOT NULL DEFAULT '',
  `TestDate` varchar(50) DEFAULT '',
  `TestCustomBh` varchar(32) DEFAULT '',
  `TestRoomBh` varchar(32) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`ConfigureBh`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of openconfigure
-- ----------------------------

-- ----------------------------
-- Table structure for otherscorerecord
-- ----------------------------
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

-- ----------------------------
-- Records of otherscorerecord
-- ----------------------------

-- ----------------------------
-- Table structure for paperconfigure
-- ----------------------------
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

-- ----------------------------
-- Records of paperconfigure
-- ----------------------------

-- ----------------------------
-- Table structure for platformmannage
-- ----------------------------
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

-- ----------------------------
-- Records of platformmannage
-- ----------------------------

-- ----------------------------
-- Table structure for plugins
-- ----------------------------
DROP TABLE IF EXISTS `plugins`;
CREATE TABLE `plugins` (
  `ID` varchar(32) NOT NULL DEFAULT '',
  `PluginsName` varchar(100) DEFAULT '',
  `Environment` varchar(20) DEFAULT '',
  `Version` varchar(100) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plugins
-- ----------------------------

-- ----------------------------
-- Table structure for question
-- ----------------------------
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

-- ----------------------------
-- Records of question
-- ----------------------------

-- ----------------------------
-- Table structure for questions
-- ----------------------------
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

-- ----------------------------
-- Records of questions
-- ----------------------------

-- ----------------------------
-- Table structure for scorepoint
-- ----------------------------
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

-- ----------------------------
-- Records of scorepoint
-- ----------------------------

-- ----------------------------
-- Table structure for seat
-- ----------------------------
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

-- ----------------------------
-- Records of seat
-- ----------------------------

-- ----------------------------
-- Table structure for seatarrangement
-- ----------------------------
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

-- ----------------------------
-- Records of seatarrangement
-- ----------------------------

-- ----------------------------
-- Table structure for seatdistribution
-- ----------------------------
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

-- ----------------------------
-- Records of seatdistribution
-- ----------------------------

-- ----------------------------
-- Table structure for signin
-- ----------------------------
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

-- ----------------------------
-- Records of signin
-- ----------------------------

-- ----------------------------
-- Table structure for sqlmapfile
-- ----------------------------
DROP TABLE IF EXISTS `sqlmapfile`;
CREATE TABLE `sqlmapfile` (
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sqlmapfile
-- ----------------------------

-- ----------------------------
-- Table structure for sqlmapoutput
-- ----------------------------
DROP TABLE IF EXISTS `sqlmapoutput`;
CREATE TABLE `sqlmapoutput` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(4000) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sqlmapoutput
-- ----------------------------

-- ----------------------------
-- Table structure for staticmodulepercent
-- ----------------------------
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

-- ----------------------------
-- Records of staticmodulepercent
-- ----------------------------

-- ----------------------------
-- Table structure for stuanswer
-- ----------------------------
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

-- ----------------------------
-- Records of stuanswer
-- ----------------------------

-- ----------------------------
-- Table structure for studentinfo
-- ----------------------------
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

-- ----------------------------
-- Records of studentinfo
-- ----------------------------

-- ----------------------------
-- Table structure for studentswork
-- ----------------------------
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

-- ----------------------------
-- Records of studentswork
-- ----------------------------

-- ----------------------------
-- Table structure for studentwork
-- ----------------------------
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

-- ----------------------------
-- Records of studentwork
-- ----------------------------

-- ----------------------------
-- Table structure for stuhelp
-- ----------------------------
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

-- ----------------------------
-- Records of stuhelp
-- ----------------------------

-- ----------------------------
-- Table structure for stuscore
-- ----------------------------
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

-- ----------------------------
-- Records of stuscore
-- ----------------------------

-- ----------------------------
-- Table structure for stutest
-- ----------------------------
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

-- ----------------------------
-- Records of stutest
-- ----------------------------

-- ----------------------------
-- Table structure for stutestrecord
-- ----------------------------
DROP TABLE IF EXISTS `stutestrecord`;
CREATE TABLE `stutestrecord` (
  `TestRecordID` varchar(32) NOT NULL DEFAULT '',
  `StuNumber` varchar(32) NOT NULL DEFAULT '',
  `StuName` varchar(200) DEFAULT '',
  `TeachingClassID` varchar(32) DEFAULT '',
  `Memo` varchar(200) DEFAULT '',
  PRIMARY KEY (`TestRecordID`,`StuNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of stutestrecord
-- ----------------------------

-- ----------------------------
-- Table structure for stutestrecorddetails
-- ----------------------------
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

-- ----------------------------
-- Records of stutestrecorddetails
-- ----------------------------

-- ----------------------------
-- Table structure for sysdiagrams
-- ----------------------------
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

-- ----------------------------
-- Records of sysdiagrams
-- ----------------------------

-- ----------------------------
-- Table structure for tbcuitmoon_log
-- ----------------------------
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

-- ----------------------------
-- Records of tbcuitmoon_log
-- ----------------------------

-- ----------------------------
-- Table structure for tbcuitmoon_module
-- ----------------------------
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
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbcuitmoon_module
-- ----------------------------

-- ----------------------------
-- Table structure for tbcuitmoon_user
-- ----------------------------
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

-- ----------------------------
-- Records of tbcuitmoon_user
-- ----------------------------
INSERT INTO `tbcuitmoon_user` VALUES ('1', 'admin', '$2y$13$9O6bKJieocg//oSax9fZOOuljAKarBXknqD8.RyYg60FfNjS7SoqK', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '10', null, null, null, null, null);

-- ----------------------------
-- Table structure for teachingclassdetails
-- ----------------------------
DROP TABLE IF EXISTS `teachingclassdetails`;
CREATE TABLE `teachingclassdetails` (
  `TeachingClassDetailsID` varchar(32) NOT NULL DEFAULT '',
  `TeachingClassID` varchar(32) DEFAULT '',
  `StuNumber` varchar(50) DEFAULT '',
  PRIMARY KEY (`TeachingClassDetailsID`),
  KEY `PK5` (`TeachingClassDetailsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of teachingclassdetails
-- ----------------------------

-- ----------------------------
-- Table structure for teachingclassmannage
-- ----------------------------
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

-- ----------------------------
-- Records of teachingclassmannage
-- ----------------------------

-- ----------------------------
-- Table structure for temp_data
-- ----------------------------
DROP TABLE IF EXISTS `temp_data`;
CREATE TABLE `temp_data` (
  `output` varchar(1000) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of temp_data
-- ----------------------------

-- ----------------------------
-- Table structure for testapply
-- ----------------------------
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

-- ----------------------------
-- Records of testapply
-- ----------------------------

-- ----------------------------
-- Table structure for testcase
-- ----------------------------
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

-- ----------------------------
-- Records of testcase
-- ----------------------------

-- ----------------------------
-- Table structure for testcustom
-- ----------------------------
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

-- ----------------------------
-- Records of testcustom
-- ----------------------------

-- ----------------------------
-- Table structure for testroom
-- ----------------------------
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

-- ----------------------------
-- Records of testroom
-- ----------------------------

-- ----------------------------
-- Table structure for tmpsocre
-- ----------------------------
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

-- ----------------------------
-- Records of tmpsocre
-- ----------------------------

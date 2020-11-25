/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : yii2_admin

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-10-25 19:04:39
*/

SET FOREIGN_KEY_CHECKS=0;

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

/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ds_dance

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-03-05 18:06:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ds_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `ds_auth_assignment`;
CREATE TABLE `ds_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `ds_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `ds_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ds_auth_assignment
-- ----------------------------

-- ----------------------------
-- Table structure for ds_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `ds_auth_item`;
CREATE TABLE `ds_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `ds_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `ds_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ds_auth_item
-- ----------------------------

-- ----------------------------
-- Table structure for ds_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `ds_auth_item_child`;
CREATE TABLE `ds_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `ds_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ds_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ds_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `ds_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ds_auth_item_child
-- ----------------------------

-- ----------------------------
-- Table structure for ds_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `ds_auth_rule`;
CREATE TABLE `ds_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ds_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for ds_be_user
-- ----------------------------
DROP TABLE IF EXISTS `ds_be_user`;
CREATE TABLE `ds_be_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ds_be_user
-- ----------------------------
INSERT INTO `ds_be_user` VALUES ('1', 'admin', 'Y67PdK8ez7tdXdUOhC4Thw1VrdEtsxFR', '$2y$13$CDxVRxLTK1O8YVdswJaYpuYq0gnqsoA0v3T5omRl8KqjklhiGrsmO', null, '1145470390@qq.com', '10', '1551710413', '1551710413');

-- ----------------------------
-- Table structure for ds_card
-- ----------------------------
DROP TABLE IF EXISTS `ds_card`;
CREATE TABLE `ds_card` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ds_card
-- ----------------------------
INSERT INTO `ds_card` VALUES ('1', '月卡10次', '月卡10次', '1', '10', '1', '2019-03-05 09:00:09', '2019-03-05 09:00:09');

-- ----------------------------
-- Table structure for ds_course
-- ----------------------------
DROP TABLE IF EXISTS `ds_course`;
CREATE TABLE `ds_course` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ds_course
-- ----------------------------

-- ----------------------------
-- Table structure for ds_daily_course
-- ----------------------------
DROP TABLE IF EXISTS `ds_daily_course`;
CREATE TABLE `ds_daily_course` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `remain` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`id`),
  KEY `Index_2` (`course_id`),
  KEY `Index_3` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ds_daily_course
-- ----------------------------

-- ----------------------------
-- Table structure for ds_fe_user
-- ----------------------------
DROP TABLE IF EXISTS `ds_fe_user`;
CREATE TABLE `ds_fe_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '0',
  `attributeset_id` bigint(20) DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `blocked_at` datetime DEFAULT NULL,
  `registration_ip` varchar(255) DEFAULT NULL,
  `registration_src_type` tinyint(4) DEFAULT '100',
  `flags` int(11) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `wechat_union_id` char(10) DEFAULT NULL,
  `wechat_open_id` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `sms_receipt` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `province_id` bigint(20) DEFAULT '0',
  `city_id` bigint(20) DEFAULT '0',
  `created_by` bigint(20) DEFAULT '0',
  `updated_by` bigint(20) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`username`),
  KEY `Index_2` (`email`),
  KEY `Index_3` (`type`),
  KEY `Index_4` (`open_id`),
  KEY `Index_5` (`wechat_open_id`),
  KEY `Index_6` (`access_token`,`status`),
  KEY `Index_7` (`mobile_number`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ds_fe_user
-- ----------------------------
INSERT INTO `ds_fe_user` VALUES ('2', '0', '0', 'xun', null, null, null, null, null, null, null, '100', null, null, null, null, '', null, null, '1562296560', null, null, null, '0', '0', '0', '0', '1', '0', '2019-03-05 09:29:09', '2019-03-05 09:29:09');

-- ----------------------------
-- Table structure for ds_menu
-- ----------------------------
DROP TABLE IF EXISTS `ds_menu`;
CREATE TABLE `ds_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `ds_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ds_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ds_menu
-- ----------------------------

-- ----------------------------
-- Table structure for ds_user_business
-- ----------------------------
DROP TABLE IF EXISTS `ds_user_business`;
CREATE TABLE `ds_user_business` (
  `user_id` bigint(20) NOT NULL,
  `remain` bigint(20) DEFAULT NULL,
  `period` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  KEY `Index_1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ds_user_business
-- ----------------------------
INSERT INTO `ds_user_business` VALUES ('2', '0', '2019-03-05 00:00:00', '1', '2019-03-05 09:29:09', '2019-03-05 09:29:09');

-- ----------------------------
-- Table structure for ds_user_card_rs
-- ----------------------------
DROP TABLE IF EXISTS `ds_user_card_rs`;
CREATE TABLE `ds_user_card_rs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `card_id` bigint(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`user_id`),
  KEY `Index_2` (`card_id`),
  KEY `Index_3` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ds_user_card_rs
-- ----------------------------
INSERT INTO `ds_user_card_rs` VALUES ('1', '2', '1', null, '2019-03-05 10:50:19', '2019-03-05 10:50:19');
INSERT INTO `ds_user_card_rs` VALUES ('2', '2', '1', null, '2019-03-05 10:52:55', '2019-03-05 10:52:55');

-- ----------------------------
-- Table structure for ds_user_entrance
-- ----------------------------
DROP TABLE IF EXISTS `ds_user_entrance`;
CREATE TABLE `ds_user_entrance` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `daily_course_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`id`),
  KEY `Index_2` (`daily_course_id`),
  KEY `Index_3` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ds_user_entrance
-- ----------------------------

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
INSERT INTO `migration` VALUES ('m000000_000000_base', '1551709610');
INSERT INTO `migration` VALUES ('m130524_201442_init', '1551709615');
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', '1551710342');
INSERT INTO `migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', '1551710342');
INSERT INTO `migration` VALUES ('m180523_151638_rbac_updates_indexes_without_prefix', '1551710343');

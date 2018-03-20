/*
Navicat MySQL Data Transfer

Source Server         : 192.168.0.195
Source Server Version : 50505
Source Host           : 192.168.0.195:3306
Source Database       : xiaohouzi

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-11-29 09:11:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `signature`
-- ----------------------------
DROP TABLE IF EXISTS `signature`;
CREATE TABLE `signature` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TID',
  `user_tid` int(11) DEFAULT NULL COMMENT '用户TID',
  `effect_time` int(11) DEFAULT NULL COMMENT '该用户的有效时间，如果有user_tid则为必填，且值为一周后的时间',
  `platform` tinyint(5) NOT NULL COMMENT '平台信息，1.web前端 2.web后台 3.小程序客户版 4.小程序商家版 5.安卓客户版 6.安卓商家版 7.苹果客户版 8.苹果商家版',
  `sign_token` varchar(255) NOT NULL COMMENT '用户的Token，这个是唯一的',
  `status` tinyint(1) NOT NULL COMMENT '状态 1.默认有效，0.无效',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `sign_token` (`sign_token`),
  KEY `sign_token_2` (`sign_token`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='这个是签名表';

-- ----------------------------
-- Records of signature
-- ----------------------------
INSERT INTO `signature` VALUES ('1', '1', '1511995707', '1', 'aassssasssddd', '1', '1510905454', '1510905454');
INSERT INTO `signature` VALUES ('4', null, null, '1', 'aassssasssddd2', '1', '1510906337', '1510906337');

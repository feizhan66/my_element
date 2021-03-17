/*
Navicat MySQL Data Transfer

Source Server         : 192.168.0.195
Source Server Version : 50505
Source Host           : 192.168.0.195:3306
Source Database       : think_user

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-12-14 11:00:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `hair_auth_role`
-- ----------------------------
DROP TABLE IF EXISTS `hair_auth_role`;
CREATE TABLE `hair_auth_role` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `title` varchar(255) NOT NULL COMMENT '角色名称',
  `description` text COMMENT '角色描述',
  `sort` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '排序ASC',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `rules` text COMMENT '规则',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `menus` varchar(255) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of hair_auth_role
-- ----------------------------
INSERT INTO `hair_auth_role` VALUES ('1', '超级管理员', '拥有至高无上的权限', '1', '1', '18,17,0,35,34,80,36,37,38,42,55,54,57,116,115,114,120,33,117,31,119,32,118,3,2,4,5,6,96,13,12,14,15,16,19,121,40,122,39,1', '1494408538', '1513150084', '');
INSERT INTO `hair_auth_role` VALUES ('2', '平台管理员', '负责平台日常管理和维护', '2', '1', '18,17,0,35,34,80,36,37,38,42,55,54,57,19,121,40,122,39', '1494408564', '1513150093', '');
INSERT INTO `hair_auth_role` VALUES ('3', '场馆管理员', '场馆数据录入和维护', '3', '1', '18,17,0,121,40,122,39', '1494408660', '1513150101', '');

-- ----------------------------
-- Table structure for `hair_auth_role_access`
-- ----------------------------
DROP TABLE IF EXISTS `hair_auth_role_access`;
CREATE TABLE `hair_auth_role_access` (
  `user_tid` int(10) unsigned NOT NULL,
  `role_tid` int(10) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`user_tid`,`role_tid`) USING BTREE,
  KEY `uid` (`user_tid`) USING BTREE,
  KEY `group_id` (`role_tid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of hair_auth_role_access
-- ----------------------------
INSERT INTO `hair_auth_role_access` VALUES ('1', '1');
INSERT INTO `hair_auth_role_access` VALUES ('1', '3');

-- ----------------------------
-- Table structure for `hair_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `hair_auth_rule`;
CREATE TABLE `hair_auth_rule` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '节点名称',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '节点标题',
  `icon` varchar(50) DEFAULT NULL COMMENT '图标',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态(1、开启，2、关闭)',
  `condition` varchar(255) NOT NULL DEFAULT '' COMMENT '条件',
  `pid` int(10) unsigned NOT NULL COMMENT '父级id',
  `sort` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '排序',
  `menu` tinyint(5) unsigned NOT NULL DEFAULT '0' COMMENT '是否菜单',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of hair_auth_rule
-- ----------------------------
INSERT INTO `hair_auth_rule` VALUES ('1', 'manage/System/index', '系统设置', 'fa fa-gear', '1', '1', '', '0', '21', '1', '1494663028', '1498133548');
INSERT INTO `hair_auth_rule` VALUES ('2', 'manage/UserRole/roleList', '角色列表', 'fa fa-user', '1', '1', '', '114', '4', '1', '1494663129', '1498133839');
INSERT INTO `hair_auth_rule` VALUES ('3', 'manage/UserRole/roleAdd', '添加用户角色', null, '1', '1', '', '2', '1', '0', '1494663175', '1498133938');
INSERT INTO `hair_auth_rule` VALUES ('4', 'Manage/UserRole/roleEdit', '编辑用户角色', null, '1', '1', '', '2', '2', '0', '1494663207', '1494663626');
INSERT INTO `hair_auth_rule` VALUES ('5', 'manage/UserRole/roleTableEdit', '编辑用户角色表格', '', '1', '1', '', '2', '3', '0', '1494663248', '1498133950');
INSERT INTO `hair_auth_rule` VALUES ('6', 'manage/UserRole/roleDeletes', '删除用户角色', '', '1', '1', '', '2', '4', '0', '1494663272', '1498133956');
INSERT INTO `hair_auth_rule` VALUES ('12', 'manage/UserRule/ruleList', '权限列表', '', '1', '1', '', '114', '5', '1', '1494663691', '1498133902');
INSERT INTO `hair_auth_rule` VALUES ('13', 'manage/UserRule/ruleAdd', '添加用户权限', '', '1', '1', '', '12', '1', '0', '1494663741', '1498133908');
INSERT INTO `hair_auth_rule` VALUES ('14', 'Manage/UserRule/ruleJson', '获取用户权限数据', null, '1', '1', '', '12', '2', '0', '1494663775', '1494663786');
INSERT INTO `hair_auth_rule` VALUES ('15', 'manage/UserRule/ruleEdit', '编辑用户权限', '', '1', '1', '', '12', '3', '0', '1494663807', '1498133914');
INSERT INTO `hair_auth_rule` VALUES ('16', 'manage/UserRule/ruleDeletes', '删除用户权限', '', '1', '1', '', '12', '4', '0', '1494663826', '1498133920');
INSERT INTO `hair_auth_rule` VALUES ('17', 'Manage/Index/index', '首页', null, '1', '1', '', '0', '0', '0', '1494664073', '1498101293');
INSERT INTO `hair_auth_rule` VALUES ('18', 'Manage/Index/welcome', '欢迎页', null, '1', '1', '', '17', '1', '0', '1494664115', '1494664115');
INSERT INTO `hair_auth_rule` VALUES ('31', 'manage/Users/userRoles', '用户角色管理', '', '1', '1', '', '115', '5', '0', '1496642053', '1500945750');
INSERT INTO `hair_auth_rule` VALUES ('32', 'manage/Users/levelLog', '用户成长记录', '', '1', '1', '', '115', '7', '0', '1496642071', '1500945766');
INSERT INTO `hair_auth_rule` VALUES ('33', 'manage/Users/checkMobilePhone', '检查手机', '', '1', '1', '', '115', '3', '0', '1496642090', '1498223919');
INSERT INTO `hair_auth_rule` VALUES ('40', 'manage/Common/index', '通用权限', '', '1', '1', '', '0', '100', '0', '1496642276', '1500945666');
INSERT INTO `hair_auth_rule` VALUES ('80', 'manage/Platform/index', '平台管理', 'fa fa-bullhorn', '1', '1', '', '0', '11', '1', '1496645930', '1499050095');
INSERT INTO `hair_auth_rule` VALUES ('96', 'manage/UserRole/roleStatus', '更改用户角色状态', '', '1', '1', '', '2', '5', '0', '1496646584', '1498545995');
INSERT INTO `hair_auth_rule` VALUES ('114', 'manage/Users/index', '用户管理', 'fa fa-user', '1', '1', '', '0', '13', '1', '1496647696', '1498440598');
INSERT INTO `hair_auth_rule` VALUES ('115', 'manage/Users/userList', '用户列表', 'fa fa-user', '1', '1', '', '114', '1', '1', '1496647733', '1498133932');
INSERT INTO `hair_auth_rule` VALUES ('116', 'manage/Users/userAdd', '添加用户', 'fa fa-user', '1', '1', '', '115', '1', '0', '1496647769', '1498182251');
INSERT INTO `hair_auth_rule` VALUES ('117', 'manage/Users/userStatus', '更改用户状态', '', '1', '1', '', '115', '4', '0', '1496647798', '1500945742');
INSERT INTO `hair_auth_rule` VALUES ('118', 'manage/Users/loginLog', '用户登录日志', '', '1', '1', '', '115', '8', '0', '1496647827', '1500945783');
INSERT INTO `hair_auth_rule` VALUES ('119', 'manage/Users/coinLog', '恒币消费明细', '', '1', '1', '', '115', '6', '0', '1496647876', '1500945756');
INSERT INTO `hair_auth_rule` VALUES ('120', 'Manage/Users/checkAccount', '检查账号', '', '1', '1', '', '115', '2', '0', '1496647961', '1498182403');
INSERT INTO `hair_auth_rule` VALUES ('121', 'manage/Users/userInfo', '用户基本信息', '', '1', '1', '', '40', '1', '0', '1496648001', '1500945725');
INSERT INTO `hair_auth_rule` VALUES ('122', 'manage/Users/changePassword', '用户修改密码', '', '1', '1', '', '40', '2', '0', '1496648380', '1500945730');

-- ----------------------------
-- Table structure for `hair_users`
-- ----------------------------
DROP TABLE IF EXISTS `hair_users`;
CREATE TABLE `hair_users` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户索引',
  `account` varchar(50) NOT NULL COMMENT '用户账号',
  `mobile_phone` varchar(20) NOT NULL COMMENT '用户手机',
  `password` varchar(50) NOT NULL COMMENT '用户密码',
  `identity` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1、普通用户 2、管理员',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态',
  `account_lock` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否锁定账号',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `mobile_phone` (`mobile_phone`) USING BTREE,
  UNIQUE KEY `account` (`account`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of hair_users
-- ----------------------------
INSERT INTO `hair_users` VALUES ('1', '18819446148', '18819446148', 'a1bb0b167bfee6d0cc2fe17778c028c7', '2', '1', '0', '1', '1');

-- ----------------------------
-- Table structure for `hair_user_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `hair_user_login_log`;
CREATE TABLE `hair_user_login_log` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `user_tid` int(10) unsigned NOT NULL COMMENT '用户索引',
  `platform_type` tinyint(5) NOT NULL COMMENT '设备类型( 1、WEB前端 2、小程序 3、安卓客户版 4、苹果客户版 5、安卓商家版 6、苹果商家版 7、WEB管理后台)',
  `equipment_sn` varchar(200) DEFAULT NULL COMMENT '设备号，全局唯一',
  `login_way` varchar(20) NOT NULL COMMENT '登录的方法(platform，qq，wechat，weibo)',
  `login_ip` varchar(15) NOT NULL COMMENT 'IP',
  `login_token` varchar(255) DEFAULT NULL COMMENT '用户token',
  `effect_time` int(11) NOT NULL COMMENT 'Token有效时间',
  `is_effect` tinyint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'token是否有效，0无效，1有效',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of hair_user_login_log
-- ----------------------------
INSERT INTO `hair_user_login_log` VALUES ('1', '1', '7', null, 'platform', '0.0.0.0', null, '1513753722', '1', '1513148922', '1513148922');
INSERT INTO `hair_user_login_log` VALUES ('2', '1', '7', null, 'platform', '0.0.0.0', null, '1513753781', '1', '1513148981', '1513148981');
INSERT INTO `hair_user_login_log` VALUES ('3', '1', '7', null, 'platform', '0.0.0.0', null, '1513754848', '1', '1513150048', '1513150048');
INSERT INTO `hair_user_login_log` VALUES ('4', '1', '7', null, 'platform', '0.0.0.0', null, '1513755190', '1', '1513150390', '1513150390');
INSERT INTO `hair_user_login_log` VALUES ('5', '1', '7', null, 'platform', '0.0.0.0', null, '1513755314', '1', '1513150514', '1513150514');
INSERT INTO `hair_user_login_log` VALUES ('6', '1', '7', null, 'platform', '0.0.0.0', null, '1513755334', '1', '1513150534', '1513150534');
INSERT INTO `hair_user_login_log` VALUES ('7', '1', '7', null, 'platform', '0.0.0.0', null, '1513755485', '1', '1513150685', '1513150685');
INSERT INTO `hair_user_login_log` VALUES ('8', '1', '7', null, 'platform', '0.0.0.0', null, '1513755541', '1', '1513150741', '1513150741');
INSERT INTO `hair_user_login_log` VALUES ('9', '1', '7', null, 'platform', '0.0.0.0', null, '1513765587', '1', '1513160787', '1513160787');
INSERT INTO `hair_user_login_log` VALUES ('10', '1', '7', null, 'platform', '0.0.0.0', null, '1513766297', '1', '1513161497', '1513161497');
INSERT INTO `hair_user_login_log` VALUES ('11', '1', '7', null, 'platform', '0.0.0.0', null, '1513819539', '1', '1513214739', '1513214739');
INSERT INTO `hair_user_login_log` VALUES ('12', '1', '7', null, 'platform', '0.0.0.0', null, '1513820372', '1', '1513215572', '1513215572');
INSERT INTO `hair_user_login_log` VALUES ('13', '1', '7', null, 'platform', '0.0.0.0', null, '1513825066', '1', '1513220266', '1513220266');

-- ----------------------------
-- Table structure for `hair_user_profile`
-- ----------------------------
DROP TABLE IF EXISTS `hair_user_profile`;
CREATE TABLE `hair_user_profile` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户索引',
  `user_tid` int(10) unsigned NOT NULL COMMENT '用户索引',
  `name` varchar(20) NOT NULL COMMENT '用户名称',
  `sex` tinyint(5) unsigned NOT NULL COMMENT '用户性别 0未知1.男2.女',
  `birthday` date NOT NULL COMMENT '用户生日',
  `avatar` varchar(100) DEFAULT '' COMMENT '用户头像',
  `cover_image` varchar(100) DEFAULT NULL COMMENT '用户封面图片',
  `signature` varchar(120) NOT NULL DEFAULT '' COMMENT '个性签名',
  `province_tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所在省份',
  `city_tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所在城市',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '用户地址',
  `profession` varchar(20) NOT NULL DEFAULT '' COMMENT '职业',
  `school` varchar(20) NOT NULL DEFAULT '' COMMENT '学校',
  `relationship` tinyint(5) unsigned NOT NULL DEFAULT '0' COMMENT '感情状态（0、保密，1、单身，2、热恋，3、已婚）默认0',
  `stature` float NOT NULL DEFAULT '0' COMMENT '身高',
  `weight` float NOT NULL DEFAULT '0' COMMENT '体重',
  `individual_label` varchar(100) NOT NULL DEFAULT '' COMMENT '个人标签',
  `like_sport` varchar(100) NOT NULL DEFAULT '' COMMENT '喜爱运动',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of hair_user_profile
-- ----------------------------

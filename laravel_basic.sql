/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : laravel_basic

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2019-11-16 13:27:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `name` varchar(32) DEFAULT NULL COMMENT '昵称',
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别:0=未知,1=男,2=女',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态:1=正常,2=禁用',
  `remember_token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='管理员表';

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', '超级管理员', '0', null, '1', '9vGqYQijJN7ljdrHp325T0YTP8FPED910XWqckISLdXJ6oIkhUNZfaJGczME', null, '2019-11-16 13:18:25', null);

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='管理员角色表';

-- ----------------------------
-- Records of admin_roles
-- ----------------------------

-- ----------------------------
-- Table structure for configs
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `variable` varchar(255) NOT NULL COMMENT '变量名',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型:1=单行文本,2=多行文本,3=单选按钮,4=复选框,5=下拉框',
  `item` text COMMENT '可选项',
  `value` text COMMENT '配置值',
  `order` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `variable` (`variable`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='配置表';

-- ----------------------------
-- Records of configs
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `path` varchar(255) DEFAULT NULL COMMENT 'URL',
  `is_menu` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '菜单栏:1=是,2=否',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态:1=正常,2=禁用',
  `order` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `remark` text COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `path` (`path`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='权限表';

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', '0', 'fa-users', '用户管理', null, '1', '1', '100', null, '2019-11-15 17:00:22', '2019-11-15 17:00:22', null);
INSERT INTO `permissions` VALUES ('2', '1', 'fa-caret-right', '权限列表', 'admin/permission/index', '1', '1', '100', null, '2019-11-15 17:00:22', '2019-11-15 17:00:22', null);
INSERT INTO `permissions` VALUES ('3', '2', 'fa-caret-right', '权限添加', 'admin/permission/create', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-15 17:00:22', null);
INSERT INTO `permissions` VALUES ('4', '2', 'fa-caret-right', '权限查看', 'admin/permission/show', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-15 17:00:22', null);
INSERT INTO `permissions` VALUES ('5', '2', 'fa-caret-right', '权限修改', 'admin/permission/update', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-15 17:00:22', null);
INSERT INTO `permissions` VALUES ('6', '2', 'fa-caret-right', '权限删除', 'admin/permission/delete', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-15 17:00:22', null);
INSERT INTO `permissions` VALUES ('7', '2', 'fa-caret-right', '权限排序', 'admin/permission/order', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-15 17:00:22', null);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '名称',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态:1=正常,2=禁用',
  `remark` text COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色表';

-- ----------------------------
-- Records of roles
-- ----------------------------

-- ----------------------------
-- Table structure for role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `permission_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色权限表';

-- ----------------------------
-- Records of role_permissions
-- ----------------------------
SET FOREIGN_KEY_CHECKS=1;

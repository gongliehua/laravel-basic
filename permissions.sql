/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : laravel_basic

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2019-11-16 13:27:48
*/

SET FOREIGN_KEY_CHECKS=0;

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
SET FOREIGN_KEY_CHECKS=1;

/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : laravel_develop

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2019-11-23 18:21:32
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
INSERT INTO `admins` VALUES ('1', 'sysop', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'sysop', '1', null, '1', 'VVVBYHTeVPVSf7eCazli5mHqbuZ4g523uI2VkhzjvsZCA1xtJOteWBbPCtmT', '2019-11-19 17:36:18', '2019-11-19 17:36:21', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='管理员角色表';

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES ('1', '1', '1', '2019-11-19 17:35:40', '2019-11-19 17:35:42');

-- ----------------------------
-- Table structure for articles
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `alias` varchar(32) DEFAULT NULL COMMENT '别名',
  `author` varchar(32) DEFAULT NULL COMMENT '作者',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态:1=显示,2=隐藏',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `title` (`title`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `alias` (`alias`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='文章表';

-- ----------------------------
-- Records of articles
-- ----------------------------
INSERT INTO `articles` VALUES ('1', 'Hello, World!', null, null, null, null, '<p>这是一篇默认文章，仅作为展示，你可以任意编辑它！</p>', '1', '2019-11-21 17:59:49', '2019-11-21 17:59:49', null);

-- ----------------------------
-- Table structure for article_tags
-- ----------------------------
DROP TABLE IF EXISTS `article_tags`;
CREATE TABLE `article_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `tag_id` int(11) NOT NULL COMMENT '标签ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='文章标题表';

-- ----------------------------
-- Records of article_tags
-- ----------------------------

-- ----------------------------
-- Table structure for configs
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='配置表';

-- ----------------------------
-- Records of configs
-- ----------------------------
INSERT INTO `configs` VALUES ('1', '站点名称', 'name', '1', null, 'Strval', '100', '2019-11-22 17:08:09', '2019-11-23 18:20:12', null);
INSERT INTO `configs` VALUES ('2', '站点URL', 'site', '1', null, '/', '100', '2019-11-22 17:08:34', '2019-11-23 18:20:12', null);
INSERT INTO `configs` VALUES ('3', '站点关键词', 'keywords', '1', null, null, '100', '2019-11-22 17:08:51', '2019-11-23 18:20:12', null);
INSERT INTO `configs` VALUES ('4', '站点描述', 'description', '1', null, null, '100', '2019-11-22 17:09:03', '2019-11-23 18:20:12', null);
INSERT INTO `configs` VALUES ('5', '版权信息', 'copyright', '1', null, null, '100', '2019-11-22 17:09:26', '2019-11-23 18:20:12', null);
INSERT INTO `configs` VALUES ('6', '首页每页显示文章条数', 'limitArticle', '5', '5,10,15,20', '15', '100', '2019-11-22 17:17:34', '2019-11-23 18:20:12', null);
INSERT INTO `configs` VALUES ('7', '首页归档显示文章条数', 'limitArchive', '5', '5,10,15,20', '15', '100', '2019-11-22 17:18:21', '2019-11-23 18:20:12', null);
INSERT INTO `configs` VALUES ('8', '前台文章是否使用别名', 'aliasArticle', '5', '是,否', '否', '100', '2019-11-22 17:18:59', '2019-11-23 18:20:12', null);
INSERT INTO `configs` VALUES ('9', '前台页面是否使用别名', 'aliasPage', '5', '是,否', '是', '100', '2019-11-22 17:19:45', '2019-11-23 18:20:12', null);
INSERT INTO `configs` VALUES ('10', '前台归档页标题', 'archives', '1', null, 'Archives', '100', '2019-11-23 18:15:27', '2019-11-23 18:20:12', null);

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `alias` varchar(32) DEFAULT NULL COMMENT '别名',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '内容',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态:1=显示,2=隐藏',
  `order` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `title` (`title`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `alias` (`alias`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='页面表';

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', '关于', null, null, null, '<p>该页面仅作为展示，你可以任意编辑它！</p>', '2', '100', '2019-11-21 17:58:21', '2019-11-23 18:20:50', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='权限表';

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', '0', 'fa-users', '用户管理', null, '1', '1', '100', null, '2019-11-15 17:00:22', '2019-11-18 17:00:48', null);
INSERT INTO `permissions` VALUES ('2', '1', 'fa-caret-right', '权限管理', 'admin/permission/index', '1', '1', '100', null, '2019-11-15 17:00:22', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('3', '2', 'fa-caret-right', '权限添加', 'admin/permission/create', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('4', '2', 'fa-caret-right', '权限查看', 'admin/permission/show', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('5', '2', 'fa-caret-right', '权限修改', 'admin/permission/update', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('6', '2', 'fa-caret-right', '权限删除', 'admin/permission/delete', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-18 16:58:07', null);
INSERT INTO `permissions` VALUES ('7', '2', 'fa-caret-right', '权限排序', 'admin/permission/order', '2', '1', '100', null, '2019-11-15 17:00:22', '2019-11-18 16:58:07', null);
INSERT INTO `permissions` VALUES ('8', '1', 'fa-caret-right', '角色管理', 'admin/role/index', '1', '1', '100', null, '2019-11-18 09:41:32', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('9', '8', 'fa-caret-right', '角色添加', 'admin/role/create', '2', '1', '100', null, '2019-11-18 09:41:59', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('10', '8', 'fa-caret-right', '角色查看', 'admin/role/show', '2', '1', '100', null, '2019-11-18 09:42:14', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('11', '8', 'fa-caret-right', '角色修改', 'admin/role/update', '2', '1', '100', null, '2019-11-18 09:42:35', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('12', '8', 'fa-caret-right', '角色删除', 'admin/role/delete', '2', '1', '100', null, '2019-11-18 09:42:54', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('13', '1', 'fa-caret-right', '管理员管理', 'admin/admin/index', '1', '1', '100', null, '2019-11-18 15:15:47', '2019-11-18 17:00:48', null);
INSERT INTO `permissions` VALUES ('14', '13', 'fa-caret-right', '管理员添加', 'admin/admin/create', '2', '1', '100', null, '2019-11-18 15:16:28', '2019-11-18 17:00:48', null);
INSERT INTO `permissions` VALUES ('15', '13', 'fa-caret-right', '管理员查看', 'admin/admin/show', '2', '1', '100', null, '2019-11-18 15:16:41', '2019-11-18 17:00:49', null);
INSERT INTO `permissions` VALUES ('16', '13', 'fa-caret-right', '管理员修改', 'admin/admin/update', '2', '1', '100', null, '2019-11-18 15:17:01', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('17', '13', 'fa-caret-right', '管理员删除', 'admin/admin/delete', '2', '1', '100', null, '2019-11-18 15:17:20', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('18', '0', 'fa-cogs', '系统管理', null, '1', '1', '100', null, '2019-11-19 09:17:08', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('19', '18', 'fa-caret-right', '配置管理', 'admin/config/index', '1', '1', '100', null, '2019-11-19 09:17:29', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('20', '19', 'fa-caret-right', '配置添加', 'admin/config/create', '2', '1', '100', null, '2019-11-19 09:17:58', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('21', '19', 'fa-caret-right', '配置查看', 'admin/config/show', '2', '1', '100', null, '2019-11-19 09:18:11', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('22', '19', 'fa-caret-right', '配置修改', 'admin/config/update', '2', '1', '100', null, '2019-11-19 09:18:38', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('23', '19', 'fa-caret-right', '配置删除', 'admin/config/delete', '2', '1', '100', null, '2019-11-19 09:18:52', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('24', '19', 'fa-caret-right', '配置排序', 'admin/config/order', '2', '1', '100', null, '2019-11-19 09:19:09', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('25', '18', 'fa-caret-right', '配置设定', 'admin/config/setting', '1', '1', '100', null, '2019-11-19 09:19:32', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('26', '0', 'fa-pencil-square-o', '内容管理', null, '1', '1', '99', null, '2019-11-21 09:29:19', '2019-11-21 09:29:34', null);
INSERT INTO `permissions` VALUES ('27', '26', 'fa-caret-right', '标签管理', 'admin/tag/index', '1', '1', '100', null, '2019-11-21 09:30:10', '2019-11-21 09:30:10', null);
INSERT INTO `permissions` VALUES ('28', '27', 'fa-caret-right', '标签添加', 'admin/tag/create', '2', '1', '100', null, '2019-11-21 09:30:37', '2019-11-21 09:35:15', null);
INSERT INTO `permissions` VALUES ('29', '27', 'fa-caret-right', '标签查看', 'admin/tag/show', '2', '1', '100', null, '2019-11-21 09:30:57', '2019-11-21 09:34:54', null);
INSERT INTO `permissions` VALUES ('30', '27', 'fa-caret-right', '标签修改', 'admin/tag/update', '2', '1', '100', null, '2019-11-21 09:31:46', '2019-11-21 09:35:04', null);
INSERT INTO `permissions` VALUES ('31', '27', 'fa-caret-right', '标签删除', 'admin/tag/delete', '2', '1', '100', null, '2019-11-21 09:32:20', '2019-11-21 09:32:20', null);
INSERT INTO `permissions` VALUES ('32', '26', 'fa-caret-right', '文章管理', 'admin/article/index', '1', '1', '100', null, '2019-11-21 09:33:09', '2019-11-21 17:28:12', null);
INSERT INTO `permissions` VALUES ('33', '32', 'fa-caret-right', '文章添加', 'admin/article/create', '2', '1', '100', null, '2019-11-21 09:33:29', '2019-11-21 09:33:29', null);
INSERT INTO `permissions` VALUES ('34', '32', 'fa-caret-right', '文章查看', 'admin/article/show', '2', '1', '100', null, '2019-11-21 09:33:50', '2019-11-21 09:33:50', null);
INSERT INTO `permissions` VALUES ('35', '32', 'fa-caret-right', '文章修改', 'admin/article/update', '2', '1', '100', null, '2019-11-21 09:34:06', '2019-11-21 09:34:06', null);
INSERT INTO `permissions` VALUES ('36', '32', 'fa-caret-right', '文章删除', 'admin/article/delete', '2', '1', '100', null, '2019-11-21 09:34:31', '2019-11-21 09:34:31', null);
INSERT INTO `permissions` VALUES ('37', '26', 'fa-caret-right', '页面管理', 'admin/page/index', '1', '1', '100', null, '2019-11-21 09:35:42', '2019-11-21 09:35:42', null);
INSERT INTO `permissions` VALUES ('38', '37', 'fa-caret-right', '页面添加', 'admin/page/create', '2', '1', '100', null, '2019-11-21 09:36:00', '2019-11-21 09:36:00', null);
INSERT INTO `permissions` VALUES ('39', '37', 'fa-caret-right', '页面查看', 'admin/page/show', '2', '1', '100', null, '2019-11-21 09:36:16', '2019-11-21 09:36:16', null);
INSERT INTO `permissions` VALUES ('40', '37', 'fa-caret-right', '页面修改', null, '2', '1', '100', null, '2019-11-21 09:36:27', '2019-11-21 09:36:27', null);
INSERT INTO `permissions` VALUES ('41', '37', 'fa-caret-right', '页面删除', 'admin/page/delete', '2', '1', '100', null, '2019-11-21 09:36:44', '2019-11-21 09:36:44', null);
INSERT INTO `permissions` VALUES ('42', '37', 'fa-caret-right', '页面排序', 'admin/page/order', '2', '1', '100', null, '2019-11-21 09:37:19', '2019-11-21 09:37:19', null);
INSERT INTO `permissions` VALUES ('43', '27', 'fa-caret-right', '标签排序', 'admin/tag/order', '2', '1', '100', null, '2019-11-21 09:37:49', '2019-11-21 09:37:49', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色表';

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '默认角色', '1', null, '2019-11-19 17:37:43', '2019-11-19 17:37:46', null);

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

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `order` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='标签表';

-- ----------------------------
-- Records of tags
-- ----------------------------
SET FOREIGN_KEY_CHECKS=1;

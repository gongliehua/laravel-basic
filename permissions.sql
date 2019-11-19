/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : laravel_basic

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 19/11/2019 17:37:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父ID',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '图标',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'URL',
  `is_menu` tinyint(3) UNSIGNED NOT NULL DEFAULT 2 COMMENT '菜单栏:1=是,2=否',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=禁用',
  `order` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '备注',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `path`(`path`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 0, 'fa-users', '用户管理', NULL, 1, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-18 17:00:48', NULL);
INSERT INTO `permissions` VALUES (2, 1, 'fa-caret-right', '权限管理', 'admin/permission/index', 1, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (3, 2, 'fa-caret-right', '权限添加', 'admin/permission/create', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (4, 2, 'fa-caret-right', '权限查看', 'admin/permission/show', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (5, 2, 'fa-caret-right', '权限修改', 'admin/permission/update', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (6, 2, 'fa-caret-right', '权限删除', 'admin/permission/delete', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-18 16:58:07', NULL);
INSERT INTO `permissions` VALUES (7, 2, 'fa-caret-right', '权限排序', 'admin/permission/order', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-18 16:58:07', NULL);
INSERT INTO `permissions` VALUES (8, 1, 'fa-caret-right', '角色管理', 'admin/role/index', 1, 1, 100, NULL, '2019-11-18 09:41:32', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (9, 8, 'fa-caret-right', '角色添加', 'admin/role/create', 2, 1, 100, NULL, '2019-11-18 09:41:59', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (10, 8, 'fa-caret-right', '角色查看', 'admin/role/show', 2, 1, 100, NULL, '2019-11-18 09:42:14', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (11, 8, 'fa-caret-right', '角色修改', 'admin/role/update', 2, 1, 100, NULL, '2019-11-18 09:42:35', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (12, 8, 'fa-caret-right', '角色删除', 'admin/role/delete', 2, 1, 100, NULL, '2019-11-18 09:42:54', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (13, 1, 'fa-caret-right', '管理员管理', 'admin/admin/index', 1, 1, 100, NULL, '2019-11-18 15:15:47', '2019-11-18 17:00:48', NULL);
INSERT INTO `permissions` VALUES (14, 13, 'fa-caret-right', '管理员添加', 'admin/admin/create', 2, 1, 100, NULL, '2019-11-18 15:16:28', '2019-11-18 17:00:48', NULL);
INSERT INTO `permissions` VALUES (15, 13, 'fa-caret-right', '管理员查看', 'admin/admin/show', 2, 1, 100, NULL, '2019-11-18 15:16:41', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (16, 13, 'fa-caret-right', '管理员修改', 'admin/admin/update', 2, 1, 100, NULL, '2019-11-18 15:17:01', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (17, 13, 'fa-caret-right', '管理员删除', 'admin/admin/delete', 2, 1, 100, NULL, '2019-11-18 15:17:20', '2019-11-18 17:00:49', NULL);
INSERT INTO `permissions` VALUES (18, 0, 'fa-cogs', '系统管理', NULL, 1, 1, 100, NULL, '2019-11-19 09:17:08', '2019-11-19 09:17:08', NULL);
INSERT INTO `permissions` VALUES (19, 18, 'fa-caret-right', '配置管理', 'admin/config/index', 1, 1, 100, NULL, '2019-11-19 09:17:29', '2019-11-19 09:17:29', NULL);
INSERT INTO `permissions` VALUES (20, 19, 'fa-caret-right', '配置添加', 'admin/config/create', 2, 1, 100, NULL, '2019-11-19 09:17:58', '2019-11-19 09:17:58', NULL);
INSERT INTO `permissions` VALUES (21, 19, 'fa-caret-right', '配置查看', 'admin/config/show', 2, 1, 100, NULL, '2019-11-19 09:18:11', '2019-11-19 09:18:11', NULL);
INSERT INTO `permissions` VALUES (22, 19, 'fa-caret-right', '配置修改', 'admin/config/update', 2, 1, 100, NULL, '2019-11-19 09:18:38', '2019-11-19 09:18:38', NULL);
INSERT INTO `permissions` VALUES (23, 19, 'fa-caret-right', '配置删除', 'admin/config/delete', 2, 1, 100, NULL, '2019-11-19 09:18:52', '2019-11-19 09:18:52', NULL);
INSERT INTO `permissions` VALUES (24, 19, 'fa-caret-right', '配置排序', 'admin/config/order', 2, 1, 100, NULL, '2019-11-19 09:19:09', '2019-11-19 09:19:09', NULL);
INSERT INTO `permissions` VALUES (25, 18, 'fa-caret-right', '配置设定', 'admin/config/setting', 1, 1, 100, NULL, '2019-11-19 09:19:32', '2019-11-19 09:19:32', NULL);

SET FOREIGN_KEY_CHECKS = 1;

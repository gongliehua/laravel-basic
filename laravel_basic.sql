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

 Date: 18/11/2019 18:17:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '管理员ID',
  `role_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '角色ID',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES (2, 6, 1, '2019-11-18 16:47:50', '2019-11-18 16:47:50');
INSERT INTO `admin_roles` VALUES (6, 1, 4, '2019-11-18 18:13:00', '2019-11-18 18:13:00');

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '昵称',
  `sex` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '性别:0=未知,1=男,2=女',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '头像',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=禁用',
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Token',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin', 1, NULL, 1, '9vGqYQijJN7ljdrHp325T0YTP8FPED910XWqckISLdXJ6oIkhUNZfaJGczME', NULL, '2019-11-18 18:13:00', NULL);
INSERT INTO `admins` VALUES (6, 'dfas', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'dsadfa', 0, NULL, 1, NULL, '2019-11-18 16:47:50', '2019-11-18 16:47:50', NULL);
INSERT INTO `admins` VALUES (7, '111', '7c4a8d09ca3762af61e59520943dc26494f8941b', '111', 0, NULL, 1, NULL, '2019-11-18 16:48:23', '2019-11-18 18:16:12', '2019-11-18 18:16:12');

-- ----------------------------
-- Table structure for configs
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `variable` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '变量名',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '类型:1=单行文本,2=多行文本,3=单选按钮,4=复选框,5=下拉框',
  `item` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '可选项',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '配置值',
  `order` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `variable`(`variable`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '配置表' ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

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

-- ----------------------------
-- Table structure for role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '角色ID',
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '权限ID',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_permissions
-- ----------------------------
INSERT INTO `role_permissions` VALUES (1, 1, 12, NULL, NULL);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=禁用',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '备注',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'aa', 1, NULL, '2019-11-18 13:39:53', '2019-11-18 13:39:56', NULL);
INSERT INTO `roles` VALUES (2, '角色1', 1, NULL, '2019-11-18 14:23:44', '2019-11-18 14:23:44', NULL);
INSERT INTO `roles` VALUES (3, '角色2', 2, '1', '2019-11-18 14:25:30', '2019-11-18 14:25:30', NULL);
INSERT INTO `roles` VALUES (4, '超级管理员', 1, NULL, '2019-11-18 14:25:44', '2019-11-18 15:25:24', NULL);
INSERT INTO `roles` VALUES (5, '角色4', 1, '1', '2019-11-18 14:26:03', '2019-11-18 15:11:53', '2019-11-18 15:11:53');
INSERT INTO `roles` VALUES (6, 'dsa12', 2, '12', '2019-11-18 14:26:51', '2019-11-18 15:11:42', '2019-11-18 15:11:42');

SET FOREIGN_KEY_CHECKS = 1;

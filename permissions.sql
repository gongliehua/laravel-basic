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

 Date: 15/11/2019 17:01:00
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
  `is_menu` tinyint(3) UNSIGNED NOT NULL DEFAULT 2 COMMENT '显示到导航栏:1=是,2=不是',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态:1=正常,2=禁用',
  `order` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '备注',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '添加时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT '修改时间',
  `deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `path`(`path`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 0, 'fa-users', '用户管理', NULL, 1, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-15 17:00:22', NULL);
INSERT INTO `permissions` VALUES (2, 1, 'fa-caret-right', '权限列表', 'admin/permission/index', 1, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-15 17:00:22', NULL);
INSERT INTO `permissions` VALUES (3, 2, 'fa-caret-right', '权限添加', 'admin/permission/create', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-15 17:00:22', NULL);
INSERT INTO `permissions` VALUES (4, 2, 'fa-caret-right', '权限查看', 'admin/permission/show', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-15 17:00:22', NULL);
INSERT INTO `permissions` VALUES (5, 2, 'fa-caret-right', '权限修改', 'admin/permission/update', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-15 17:00:22', NULL);
INSERT INTO `permissions` VALUES (6, 2, 'fa-caret-right', '权限删除', 'admin/permission/delete', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-15 17:00:22', NULL);
INSERT INTO `permissions` VALUES (7, 2, 'fa-caret-right', '权限排序', 'admin/permission/order', 2, 1, 100, NULL, '2019-11-15 17:00:22', '2019-11-15 17:00:22', NULL);

SET FOREIGN_KEY_CHECKS = 1;

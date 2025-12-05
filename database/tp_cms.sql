-- 用户表
DROP TABLE IF EXISTS `user`;
-- 创建
CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` VARCHAR(26) COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `salt` BLOB NOT NULL COMMENT '密码盐',
  `password` BLOB NOT NULL COMMENT '密码',
  `uuid` CHAR(36) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'uuid',
  `phone` VARCHAR(57) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '电话',
  `email` VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `disabled` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '禁用状态',
  `created_by` INT NOT NULL COMMENT '创建人',
  `created_at` DATETIME DEFAULT NULL COMMENT '添加时间',
  `updated_at` DATETIME DEFAULT NULL COMMENT '修改时间',
  `deleted_at` DATETIME DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
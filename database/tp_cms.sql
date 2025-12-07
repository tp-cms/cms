-- 用户表
DROP TABLE IF EXISTS `user`;
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_username` (`username`),
  UNIQUE KEY `idx_user_email` (`email`),
  KEY `idx_user_uuid` (`uuid`),
  KEY `idx_user_phone` (`phone`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 文件分类
DROP TABLE IF EXISTS `file_category`;
CREATE TABLE `file_category` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(26) COLLATE utf8mb4_general_ci NOT NULL COMMENT '分类名',
  `code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT '分类CODE',
  `created_by` int NOT NULL DEFAULT '0' COMMENT '添加人',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_file_category_code` (`code`),
  KEY `idx_file_category_created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文件分类';

-- 文件
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `category_id` int NOT NULL DEFAULT '1' COMMENT '分类',
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `hash_name` varchar(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件哈希',
  `path` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路径',
  `size` int NOT NULL DEFAULT '0' COMMENT '大小',
  `ext` varchar(20) COLLATE utf8mb4_general_ci NOT NULL COMMENT '扩展名',
  `mime` varchar(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件mime',
  `created_by` int NOT NULL DEFAULT '0' COMMENT '上传用户',
  `storage_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '存储类型',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_file_hash_name` (`hash_name`),
  KEY `idx_file_category_id` (`category_id`),
  KEY `idx_file_created_by` (`created_by`),
  KEY `idx_file_storage_type` (`storage_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文件信息表';

-- 产品分类
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(57) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `code` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'CODE',
  `created_by` int NOT NULL COMMENT '添加人',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_product_category_code` (`code`),
  KEY `idx_product_category_created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='产品分类';

-- 产品
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `category_id` int NOT NULL COMMENT '分类',
  `cover` int NOT NULL COMMENT '封面',
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `summary` varchar(200) COLLATE utf8mb4_general_ci NOT NULL COMMENT '描述',
  `parameter` text COLLATE utf8mb4_general_ci COMMENT '参数',
  `content_image` varchar(200) COLLATE utf8mb4_general_ci NOT NULL COMMENT '内容图片',
  `content` text COLLATE utf8mb4_general_ci COMMENT '内容',
  `price` float(12,1) NOT NULL DEFAULT '0.0' COMMENT '价格',
  `b2b_uri` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '百度爱采购url',
  `created_by` int NOT NULL COMMENT '用户id',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `idx_product_category_id` (`category_id`),
  KEY `idx_product_cover` (`cover`),
  KEY `idx_product_price` (`price`),
  KEY `idx_product_created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='产品信息表';

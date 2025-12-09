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

-- 默认文件分类
INSERT INTO `file_category` (`id`, `name`, `code`, `created_by`) VALUES (1, '未分类', 'unassorted ', 1);

-- 文件
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `category_id` int NOT NULL DEFAULT '1' COMMENT '分类',
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `hash_name` varchar(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件哈希',
  `path` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路径',
  `size` int NOT NULL DEFAULT '0' COMMENT '大小',
  `ext` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '扩展名',
  `mime` varchar(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文件mime',
  `created_by` int NOT NULL DEFAULT '0' COMMENT '上传用户',
  `storage_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '存储类型',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_file_hash_user_storage` (`created_by`, `hash_name`, `storage_type`),
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

-- 轮播图
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `category` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分类',
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `summary` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述文本',
  `image` int(11) NOT NULL COMMENT '图片',
  `video` int(10) NOT NULL DEFAULT '0' COMMENT '视频',
  `url` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '跳转链接',
  `sorted` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_by` int NOT NULL COMMENT '用户id',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `idx_category_status_sorted` (`category`, `status`, `sorted`),
  KEY `idx_status` (`status`),
  KEY `idx_category` (`category`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='轮播图';

-- 新闻
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `summary` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `cover_id` int(10) NOT NULL DEFAULT '0' COMMENT '封面',
  `content` text COLLATE utf8mb4_general_ci NOT NULL COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶',
  `created_by` int NOT NULL COMMENT '用户id',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `idx_status_istop_created` (`status`, `is_top`, `created_at`),
  KEY `idx_status` (`status`),
  KEY `idx_title` (`title`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='新闻';

-- 案例
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `summary` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `cover_id` int(10) NOT NULL DEFAULT '0' COMMENT '封面',
  `content` text COLLATE utf8mb4_general_ci NOT NULL COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `is_top` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶',
  `tag` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标签',
  `created_by` int NOT NULL COMMENT '用户id',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `idx_status_istop_created` (`status`, `is_top`, `created_at`),
  KEY `idx_status` (`status`),
  KEY `idx_title` (`title`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='案例';

-- 客户
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `logo` int(10) NOT NULL DEFAULT '0' COMMENT 'logo',
  `url` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '官网链接',
  `created_by` int NOT NULL COMMENT '用户id',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='客户';

-- 单页
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `image` int(11) NOT NULL COMMENT '图片',
  `category` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分类',
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `summary` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COLLATE utf8mb4_general_ci NOT NULL COMMENT '内容',
  `created_by` int NOT NULL DEFAULT '1' COMMENT '用户id',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='单页信息';

INSERT INTO `page` (`image`, `category`, `title`, `created_by`, `content`)
VALUES 
(0,'about_us', '关于我们', 1, ''),
(0,'privacy', '隐私政策', 1, '');

-- 友情链接
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `url` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '友情链接',
  `created_by` int NOT NULL COMMENT '用户id',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='友情链接';

-- 联系消息
DROP TABLE IF EXISTS `contact_message`;
CREATE TABLE `contact_message` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(57) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '电话',
  `content` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '留言内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `ip` varchar(57) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '留言ip',
  `user_agent` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'UserAgent',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_phone` (`phone`),
  KEY `idx_ip` (`ip`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='联系消息';

-- 配置
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cfg_key` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '键',
  `cfg_val` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '值',
  `created_by` int NOT NULL DEFAULT 1 COMMENT '用户id',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_cfg_key` (`cfg_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='配置信息';

-- 这里的cfg_key与app\model\Config统一下
INSERT INTO `config` (`cfg_key`, `cfg_val`, `created_by`)
VALUES
  ('title',       '', 1),
  ('description', '', 1),
  ('keywords',    '', 1),
  ('logo',        '', 1),
  ('phone',       '', 1),
  ('email',       '', 1),
  ('address',     '', 1),
  ('qq',          '', 1),
  ('douyin',      '', 1),
  ('wechat',      '', 1),
  ('company',     '', 1),
  ('icp',         '', 1)
ON DUPLICATE KEY UPDATE
  cfg_val = VALUES(cfg_val),
  updated_at = CURRENT_TIMESTAMP;

-- 操作记录
DROP TABLE IF EXISTS `action_log`;
CREATE TABLE `action_log` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `action` tinyint(3) NOT NULL DEFAULT '0' COMMENT '操作类型：1新增，2修改，3删除，4登录…',
  `module` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '模块，如 news/banner/project',
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作描述，如 更新新闻id=3',
  `ip` varchar(57) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作ip',
  `user_agent` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作设备信息',
  `created_by` int NOT NULL COMMENT '用户id',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_module` (`module`),
  KEY `idx_action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='操作记录';

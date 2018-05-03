-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.5.53 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出  表 lxp.lxp_about 结构
CREATE TABLE IF NOT EXISTS `lxp_about` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `introduce` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '简介',
  `detail` text COLLATE utf8_unicode_ci NOT NULL COMMENT '详情',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标签',
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '图片',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_about 的数据：4 rows
/*!40000 ALTER TABLE `lxp_about` DISABLE KEYS */;
INSERT INTO `lxp_about` (`id`, `name`, `introduce`, `detail`, `label`, `img`, `created_at`, `updated_at`) VALUES
	(1, 'éternel', '一枚90后程序员，PHP开发工程师', '', '四川-成都', '', '2018-05-01 20:59:04', '2018-05-01 20:59:04'),
	(2, '记忆碎片', '一个PHP程序员的个人博客', '', 'http://www.xp.com', '', '2018-05-01 20:59:08', '2018-05-01 20:59:08'),
	(3, '关键字', '', '', '记忆碎片,个人博客,php技术分享,程序员博客', '', '2018-05-01 20:59:09', '2018-05-01 20:59:09'),
	(4, '描述', '', '', '记忆碎片，记录博主学习和成长之路，记录php方面遇到的问题以及解决方法', '', '2018-05-01 20:59:11', '2018-05-01 20:59:11');
/*!40000 ALTER TABLE `lxp_about` ENABLE KEYS */;


-- 导出  表 lxp.lxp_admin 结构
CREATE TABLE IF NOT EXISTS `lxp_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理员登陆账号',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理员姓名',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理员登陆密码',
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sex` enum('男','女') COLLATE utf8_unicode_ci NOT NULL DEFAULT '男' COMMENT '性别',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `role_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_admin 的数据：2 rows
/*!40000 ALTER TABLE `lxp_admin` DISABLE KEYS */;
INSERT INTO `lxp_admin` (`id`, `account`, `name`, `password`, `phone`, `email`, `status`, `sex`, `role_id`, `role_name`, `created_at`, `updated_at`) VALUES
	(1, 'xp248187189', 'éternel', '1453c23ab2ccd5a99672b1fae32dfb78', '15882180558', '248187189@qq.com', 1, '男', 0, '超级管理员', '2018-05-01 21:00:22', '2018-05-01 21:00:22'),
	(2, 'test', '测试账号', 'e10adc3949ba59abbe56e057f20f883e', '12345678901', '123456789@qq.com', 1, '男', 1, '副号', '2018-04-28 22:28:24', '2018-04-28 22:28:24');
/*!40000 ALTER TABLE `lxp_admin` ENABLE KEYS */;


-- 导出  表 lxp.lxp_admin_login 结构
CREATE TABLE IF NOT EXISTS `lxp_admin_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '登录ip',
  `time` int(10) unsigned NOT NULL COMMENT '登录时间',
  `account_id` int(10) unsigned NOT NULL COMMENT '登陆id',
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '登录名',
  `browser` text COLLATE utf8_unicode_ci NOT NULL COMMENT '浏览器信息',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_admin_login 的数据：0 rows
/*!40000 ALTER TABLE `lxp_admin_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `lxp_admin_login` ENABLE KEYS */;


-- 导出  表 lxp.lxp_article 结构
CREATE TABLE IF NOT EXISTS `lxp_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '文章主图',
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '文章标题',
  `outline` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '文章概要',
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL COMMENT '文章内容',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `category_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `isHome` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页',
  `isRecommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '作者',
  `addTime` int(10) unsigned NOT NULL COMMENT '添加时间戳',
  `showNum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_article 的数据：0 rows
/*!40000 ALTER TABLE `lxp_article` DISABLE KEYS */;
/*!40000 ALTER TABLE `lxp_article` ENABLE KEYS */;


-- 导出  表 lxp.lxp_article_comment 结构
CREATE TABLE IF NOT EXISTS `lxp_article_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  `article_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '文章标题',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_account` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `user_head` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户头像',
  `time` int(10) unsigned NOT NULL COMMENT '评论时间',
  `connect` text COLLATE utf8_unicode_ci NOT NULL COMMENT '评论内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_article_comment 的数据：0 rows
/*!40000 ALTER TABLE `lxp_article_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `lxp_article_comment` ENABLE KEYS */;


-- 导出  表 lxp.lxp_auth 结构
CREATE TABLE IF NOT EXISTS `lxp_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `id_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '顶级id至本身id',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '级别',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限名称',
  `controller` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '控制器',
  `action` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '方法',
  `icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '图标',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_auth 的数据：76 rows
/*!40000 ALTER TABLE `lxp_auth` DISABLE KEYS */;
INSERT INTO `lxp_auth` (`id`, `pid`, `id_list`, `level`, `sort`, `name`, `controller`, `action`, `icon`, `created_at`, `updated_at`) VALUES
	(11, 10, '10,11', 1, 1, '权限管理', 'Auth', 'showList', 'fa-cog', NULL, NULL),
	(10, 0, '10', 0, 1, '系统管理', '', '', 'fa-cogs', NULL, NULL),
	(17, 10, '10,17', 1, 2, '后台人员', 'Admin', 'showList', 'fa-street-view', NULL, NULL),
	(18, 10, '10,18', 1, 3, '角色管理', 'Role', 'showList', 'fa-user', NULL, NULL),
	(19, 11, '10,11,19', 2, 1, '添加权限节点(页面)', 'Auth', 'add', '', NULL, NULL),
	(20, 11, '10,11,20', 2, 2, '修改权限节点(页面)', 'Auth', 'edit', '', NULL, NULL),
	(21, 11, '10,11,21', 2, 3, '删除权限节点', 'Auth', 'ajaxDel', '', NULL, NULL),
	(26, 17, '10,17,26', 2, 1, '添加管理员(页面)', 'Admin', 'add', '', NULL, NULL),
	(27, 17, '10,17,27', 2, 1, '添加管理员(操作)', 'Admin', 'ajaxAdd', '', NULL, NULL),
	(28, 17, '10,17,28', 2, 1, '修改管理员(页面)', 'Admin', 'edit', '', NULL, NULL),
	(29, 17, '10,17,29', 2, 1, '修改管理员(操作)', 'Admin', 'ajaxEdit', '', NULL, NULL),
	(30, 17, '10,17,30', 2, 1, '删除管理员', 'Admin', 'ajaxDel', '', NULL, NULL),
	(31, 11, '10,11,31', 2, 1, '添加权限节点(操作)', 'Auth', 'ajaxAdd', '', NULL, NULL),
	(32, 11, '10,11,32', 2, 1, '修改权限节点(操作)', 'Auth', 'ajaxEdit', '', NULL, NULL),
	(33, 18, '10,18,33', 2, 1, '添加角色(页面)', 'Role', 'add', '', NULL, NULL),
	(34, 18, '10,18,34', 2, 1, '添加角色(操作)', 'Role', 'ajaxAdd', '', NULL, NULL),
	(35, 18, '10,18,35', 2, 1, '修改角色(页面)', 'Role', 'edit', '', NULL, NULL),
	(36, 18, '10,18,36', 2, 1, '修改角色(操作)', 'Role', 'ajaxEdit', '', NULL, NULL),
	(37, 18, '10,18,37', 2, 1, '删除角色', 'Role', 'ajaxDel', '', NULL, NULL),
	(38, 0, '38', 0, 2, '内容管理', '', '', 'fa-file-o', NULL, NULL),
	(39, 38, '38,39', 1, 1, '文章管理', 'Article', 'showList', 'fa-newspaper-o', NULL, NULL),
	(40, 38, '38,40', 1, 1, '分类管理', 'Category', 'showList', 'fa-th', NULL, NULL),
	(46, 38, '38,46', 1, 99, '时间轴', 'TimeAxis', 'showList', 'fa-sort-alpha-asc', NULL, NULL),
	(48, 0, '48', 0, 99, '扩展管理', '', '', 'fa-moon-o', NULL, NULL),
	(49, 48, '48,49', 1, 99, '网站推荐', 'Link', 'showList', 'fa-sliders', NULL, NULL),
	(50, 48, '48,50', 1, 99, '博主信息', 'Blogger', 'show', 'fa-male', NULL, NULL),
	(51, 48, '48,51', 1, 99, '网站公告', 'Notice', 'showList', 'fa-volume-up', NULL, NULL),
	(52, 48, '48,52', 1, 99, '关于博客', 'Blog', 'show', 'fa-puzzle-piece', NULL, NULL),
	(53, 0, '53', 0, 99, '登录信息', '', '', 'fa-hand-peace-o', NULL, NULL),
	(54, 53, '53,54', 1, 99, '后台登录', 'AdminLogin', 'showList', 'fa-info-circle', NULL, NULL),
	(55, 53, '53,55', 1, 99, '用户登录', 'UserLogin', 'showList', 'fa-bullhorn', NULL, NULL),
	(56, 0, '56', 0, 99, '用户中心', '', '', 'fa-github-alt', NULL, NULL),
	(57, 56, '56,57', 1, 99, '用户列表', 'User', 'showList', 'fa-tasks', NULL, NULL),
	(58, 38, '38,58', 1, 99, '文章评论', 'ArticleComment', 'showList', 'fa-krw', NULL, NULL),
	(59, 56, '56,59', 1, 99, '用户留言', 'UserComment', 'showList', 'fa-rub', NULL, NULL),
	(60, 48, '48,60', 1, 99, '关键字与描述', 'Seo', 'show', 'fa-paw', NULL, NULL),
	(61, 48, '48,61', 1, 99, '网站记录', 'Note', 'showList', 'fa-retweet', NULL, NULL),
	(62, 54, '53,54,62', 2, 99, '删除后台登录', 'AdminLogin', 'ajaxDel', '', NULL, NULL),
	(63, 55, '53,55,63', 2, 99, '删除用户登录', 'UserLogin', 'ajaxDel', '', NULL, NULL),
	(64, 39, '38,39,64', 2, 99, '添加文章（页面）', 'Article', 'add', '', NULL, NULL),
	(65, 39, '38,39,65', 2, 99, '添加文章（操作）', 'Article', 'ajaxAdd', '', NULL, NULL),
	(66, 39, '38,39,66', 2, 99, '修改文章（页面）', 'Article', 'edit', '', NULL, NULL),
	(67, 39, '38,39,67', 2, 99, '修改文章（操作）', 'Article', 'ajaxEdit', '', NULL, NULL),
	(68, 39, '38,39,68', 2, 99, '删除文章', 'Article', 'ajaxDel', '', NULL, NULL),
	(69, 40, '38,40,69', 2, 99, '添加分类（页面）', 'Category', 'add', '', NULL, NULL),
	(70, 40, '38,40,70', 2, 99, '添加分类（操作）', 'Category', 'ajaxAdd', '', NULL, NULL),
	(71, 40, '38,40,71', 2, 99, '修改分类（页面）', 'Category', 'edit', '', NULL, NULL),
	(72, 40, '38,40,72', 2, 99, '修改分类（操作）', 'Category', 'ajaxEdit', '', NULL, NULL),
	(73, 40, '38,40,73', 2, 99, '删除分类', 'Category', 'ajaxDel', '', NULL, NULL),
	(74, 46, '38,46,74', 2, 99, '添加时间轴（页面）', 'TimeAxis', 'add', '', NULL, NULL),
	(75, 46, '38,46,75', 2, 99, '添加时间轴（操作）', 'TimeAxis', 'ajaxAdd', '', NULL, NULL),
	(76, 46, '38,46,76', 2, 99, '修改时间轴（页面）', 'TimeAxis', 'edit', '', NULL, NULL),
	(77, 46, '38,46,77', 2, 99, '修改时间轴（操作）', 'TimeAxis', 'ajaxEdit', '', NULL, NULL),
	(78, 46, '38,46,78', 2, 99, '删除时间轴', 'TimeAxis', 'ajaxDel', '', NULL, NULL),
	(79, 58, '38,58,79', 2, 99, '删除文章评论', 'ArticleComment', 'ajaxDel', '', NULL, NULL),
	(80, 49, '48,49,80', 2, 99, '添加网站推荐（页面）', 'Link', 'add', '', NULL, NULL),
	(81, 49, '48,49,81', 2, 99, '添加网站推荐（操作）', 'Link', 'ajaxAdd', '', NULL, NULL),
	(82, 49, '48,49,82', 2, 99, '修改网站推荐（页面）', 'Link', 'edit', '', NULL, NULL),
	(83, 49, '48,49,83', 2, 99, '修改网站推荐（操作）', 'Link', 'ajaxEdit', '', NULL, NULL),
	(84, 49, '48,49,84', 2, 99, '删除网站推荐', 'Link', 'ajaxDel', '', NULL, NULL),
	(85, 50, '48,50,85', 2, 99, '修改博主信息', 'Blogger', 'ajaxEdit', '', NULL, NULL),
	(86, 51, '48,51,86', 2, 99, '添加网站公告（页面）', 'Notice', 'add', '', NULL, NULL),
	(87, 51, '48,51,87', 2, 99, '添加网站公告（操作）', 'Notice', 'ajaxAdd', '', NULL, NULL),
	(88, 51, '48,51,88', 2, 99, '修改网站公告（页面）', 'Notice', 'edit', '', NULL, NULL),
	(89, 51, '48,51,89', 2, 99, '修改网站公告（操作）', 'Notice', 'ajaxEdit', '', NULL, NULL),
	(90, 51, '48,51,90', 2, 99, '删除网站公告', 'Notice', 'ajaxDel', '', NULL, NULL),
	(91, 52, '48,52,91', 2, 99, '修改关于博客', 'Blog', 'ajaxEdit', '', NULL, NULL),
	(92, 60, '48,60,92', 2, 99, '修改关键字与描述', 'Seo', 'ajaxEdit', '', NULL, NULL),
	(94, 61, '48,61,94', 2, 99, '添加网站记录（页面）', 'Note', 'add', '', NULL, NULL),
	(95, 61, '48,61,95', 2, 99, '添加网站记录（操作）', 'Note', 'ajaxAdd', '', NULL, NULL),
	(96, 61, '48,61,96', 2, 99, '修改网站记录（页面）', 'Note', 'edit', '', NULL, NULL),
	(97, 61, '48,61,97', 2, 99, '修改网站记录（操作）', 'Note', 'ajaxEdit', '', NULL, NULL),
	(98, 61, '48,61,98', 2, 99, '删除网站记录', 'Note', 'ajaxDel', '', NULL, NULL),
	(103, 59, '56,59,103', 2, 99, '删除用户留言', 'UserComment', 'ajaxDel', '', NULL, NULL),
	(102, 57, '56,57,102', 2, 99, '修改用户', 'User', 'ajaxEdit', '', NULL, NULL),
	(101, 57, '56,57,101', 2, 99, '删除用户', 'User', 'ajaxDel', '', NULL, NULL);
/*!40000 ALTER TABLE `lxp_auth` ENABLE KEYS */;


-- 导出  表 lxp.lxp_category 结构
CREATE TABLE IF NOT EXISTS `lxp_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_category 的数据：5 rows
/*!40000 ALTER TABLE `lxp_category` DISABLE KEYS */;
INSERT INTO `lxp_category` (`id`, `name`, `sort`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'PHP', 99, 1, '2018-05-01 21:03:15', '2018-05-01 21:03:15'),
	(2, 'JavaScript', 99, 1, '2018-05-01 21:03:16', '2018-05-01 21:03:16'),
	(3, 'HTML', 99, 1, '2018-05-01 21:04:33', '2018-05-01 21:04:33'),
	(4, 'Linux', 99, 1, '2018-05-01 21:04:42', '2018-05-01 21:04:42'),
	(5, '杂谈', 99, 1, '2018-05-01 21:04:44', '2018-05-01 21:04:44');
/*!40000 ALTER TABLE `lxp_category` ENABLE KEYS */;


-- 导出  表 lxp.lxp_link 结构
CREATE TABLE IF NOT EXISTS `lxp_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '链接名称',
  `url` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '链接地址',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_link 的数据：0 rows
/*!40000 ALTER TABLE `lxp_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `lxp_link` ENABLE KEYS */;


-- 导出  表 lxp.lxp_migrations 结构
CREATE TABLE IF NOT EXISTS `lxp_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_migrations 的数据：15 rows
/*!40000 ALTER TABLE `lxp_migrations` DISABLE KEYS */;
INSERT INTO `lxp_migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2018_04_22_062252_create_admin_table', 1),
	(2, '2018_04_22_064532_create_about_table', 1),
	(3, '2018_04_22_065054_create_admin_login_table', 1),
	(4, '2018_04_22_070147_create_article_table', 1),
	(5, '2018_04_22_071132_create_article_comment_table', 1),
	(6, '2018_04_22_071921_create_auth_table', 1),
	(7, '2018_04_22_072525_create_category_table', 1),
	(8, '2018_04_22_072905_create_link_table', 1),
	(9, '2018_04_22_073157_create_note_table', 1),
	(10, '2018_04_22_073408_create_notice_table', 1),
	(11, '2018_04_22_073620_create_role_table', 1),
	(12, '2018_04_22_073917_create_time_axis_table', 1),
	(13, '2018_04_22_074456_create_user_table', 1),
	(14, '2018_04_22_074845_create_user_comment_table', 1),
	(15, '2018_04_22_075135_create_user_login_table', 1);
/*!40000 ALTER TABLE `lxp_migrations` ENABLE KEYS */;


-- 导出  表 lxp.lxp_note 结构
CREATE TABLE IF NOT EXISTS `lxp_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'url地址',
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '账号',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_note 的数据：0 rows
/*!40000 ALTER TABLE `lxp_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `lxp_note` ENABLE KEYS */;


-- 导出  表 lxp.lxp_notice 结构
CREATE TABLE IF NOT EXISTS `lxp_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_notice 的数据：0 rows
/*!40000 ALTER TABLE `lxp_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `lxp_notice` ENABLE KEYS */;


-- 导出  表 lxp.lxp_role 结构
CREATE TABLE IF NOT EXISTS `lxp_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色名称',
  `auth_ids` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限ids',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_role 的数据：1 rows
/*!40000 ALTER TABLE `lxp_role` DISABLE KEYS */;
INSERT INTO `lxp_role` (`id`, `name`, `auth_ids`, `sort`, `created_at`, `updated_at`) VALUES
	(1, '副号', '38,39,64,66,40,69,71,46,74,76,58,48,49,80,82,50,51,86,88,52,60,53,54,55,56,57,59', 99, '2018-05-01 21:06:19', '2018-05-01 21:06:19');
/*!40000 ALTER TABLE `lxp_role` ENABLE KEYS */;


-- 导出  表 lxp.lxp_time_axis 结构
CREATE TABLE IF NOT EXISTS `lxp_time_axis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year` smallint(5) unsigned NOT NULL COMMENT '年',
  `month` tinyint(3) unsigned NOT NULL COMMENT '月',
  `day` tinyint(3) unsigned NOT NULL COMMENT '日',
  `hour` tinyint(3) unsigned NOT NULL COMMENT '时',
  `minute` tinyint(3) unsigned NOT NULL COMMENT '分',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `isHome` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '首页显示',
  `time` int(10) unsigned NOT NULL COMMENT '时间戳',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_time_axis 的数据：0 rows
/*!40000 ALTER TABLE `lxp_time_axis` DISABLE KEYS */;
/*!40000 ALTER TABLE `lxp_time_axis` ENABLE KEYS */;


-- 导出  表 lxp.lxp_user 结构
CREATE TABLE IF NOT EXISTS `lxp_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `sex` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT '性别',
  `head` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '头像',
  `connectid` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'qq登录返回的id',
  `addTime` int(10) unsigned NOT NULL COMMENT '加入时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_user 的数据：4 rows
/*!40000 ALTER TABLE `lxp_user` DISABLE KEYS */;
INSERT INTO `lxp_user` (`id`, `account`, `sex`, `head`, `connectid`, `addTime`, `status`, `created_at`, `updated_at`) VALUES
	(1, '废物', '男', 'http://q.qlogo.cn/qqapp/101449564/8608A261A9C9966595E6E277A8B23C5B/100', 8608, 1513234117, 1, '2018-04-29 14:23:09', '2018-04-29 14:23:09'),
	(2, 'éternel', '男', 'http://thirdqq.qlogo.cn/qqapp/101449564/62C78CCDADF3D953C48BB69D367BD721/100', 62, 1513230253, 1, '2018-04-29 14:23:05', '2018-04-29 14:23:05'),
	(3, '.', '男', 'http://q.qlogo.cn/qqapp/101449564/0E7C4E8477AC2BEFB30CBFEFD92A2775/100', 0, 1513234188, 1, '2018-04-29 14:23:05', '2018-04-29 14:23:05'),
	(4, 'eee', '女', 'http://thirdqq.qlogo.cn/qqapp/101449564/9677D42CE9C01B30FA8FCBC544B54005/100', 9677, 1524983947, 1, '2018-04-29 14:23:04', '2018-04-29 14:23:04');
/*!40000 ALTER TABLE `lxp_user` ENABLE KEYS */;


-- 导出  表 lxp.lxp_user_comment 结构
CREATE TABLE IF NOT EXISTS `lxp_user_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_account` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `user_head` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户头像',
  `time` int(10) unsigned NOT NULL COMMENT '留言时间',
  `connect` text COLLATE utf8_unicode_ci NOT NULL COMMENT '留言内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_user_comment 的数据：0 rows
/*!40000 ALTER TABLE `lxp_user_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `lxp_user_comment` ENABLE KEYS */;


-- 导出  表 lxp.lxp_user_login 结构
CREATE TABLE IF NOT EXISTS `lxp_user_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '登录ip',
  `time` int(10) unsigned NOT NULL COMMENT '登录时间',
  `account_id` int(10) unsigned NOT NULL COMMENT '登陆id',
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '登录名',
  `browser` text COLLATE utf8_unicode_ci NOT NULL COMMENT '浏览器信息',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  lxp.lxp_user_login 的数据：0 rows
/*!40000 ALTER TABLE `lxp_user_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `lxp_user_login` ENABLE KEYS */;


-- 导出  触发器 lxp.admin_delete_after 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `admin_delete_after` AFTER DELETE ON `lxp_admin` FOR EACH ROW BEGIN
	#删除admin_login表
	delete from lxp_admin_login where account_id = old.id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.admin_insert 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `admin_insert` BEFORE INSERT ON `lxp_admin` FOR EACH ROW BEGIN
	#根据角色id设置角色名称
	set @sel_role_name='';
	if new.role_id>0 then 
		select name into @sel_role_name from lxp_role where new.role_id=id;
		set new.role_name = @sel_role_name;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.admin_login_insert 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `admin_login_insert` BEFORE INSERT ON `lxp_admin_login` FOR EACH ROW BEGIN
	#根据管理员id设置管理员名称
	set @sel_account_name='';
	if new.account_id>0 then 
		select account into @sel_account_name from lxp_admin where new.account_id=id;
		set new.account = @sel_account_name;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.admin_login_update 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `admin_login_update` BEFORE UPDATE ON `lxp_admin_login` FOR EACH ROW BEGIN
	#根据管理员id设置管理员名称
	set @sel_account_name='';
	if new.account_id>0 then 
		select account into @sel_account_name from lxp_admin where new.account_id=id;
		set new.account = @sel_account_name;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.admin_update 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `admin_update` BEFORE UPDATE ON `lxp_admin` FOR EACH ROW BEGIN
	#根据角色id设置角色名称
	set @sel_role_name='';
	if new.role_id>0 then 
		select name into @sel_role_name from lxp_role where new.role_id=id;
		set new.role_name = @sel_role_name;
	end if;
	#改变admin_login表
	update lxp_admin_login set account = new.account where account_id = new.id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.admin_update_after 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `admin_update_after` AFTER UPDATE ON `lxp_admin` FOR EACH ROW BEGIN
	#改变admin_login表
	update lxp_admin_login set account = new.account where account_id = new.id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.article_comment_insert 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `article_comment_insert` BEFORE INSERT ON `lxp_article_comment` FOR EACH ROW BEGIN
	set @sel_article_name='';
	set @sel_user_account='';
	set @sel_user_head='';
	#根据文章id设置文章名称
	if new.article_id>0 then 
		select title into @sel_article_name from lxp_article where new.article_id=id;
		set new.article_name = @sel_article_name;
	end if;
	#根据用户id设置用户名称
	if new.user_id>0 then 
		select account into @sel_user_account from lxp_user where new.user_id=id;
		set new.user_account = @sel_user_account;
	end if;
	#根据用户id设置用户头像
	if new.user_id>0 then 
		select head into @sel_user_head from lxp_user where new.user_id=id;
		set new.user_head = @sel_user_head;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.article_comment_update 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `article_comment_update` BEFORE UPDATE ON `lxp_article_comment` FOR EACH ROW BEGIN
	set @sel_article_name='';
	set @sel_user_account='';
	set @sel_user_head='';
	#根据文章id设置文章名称
	if new.article_id>0 then 
		select title into @sel_article_name from lxp_article where new.article_id=id;
		set new.article_name = @sel_article_name;
	end if;
	#根据用户id设置用户名称
	if new.user_id>0 then 
		select account into @sel_user_account from lxp_user where new.user_id=id;
		set new.user_account = @sel_user_account;
	end if;
	#根据用户id设置用户头像
	if new.user_id>0 then 
		select head into @sel_user_head from lxp_user where new.user_id=id;
		set new.user_head = @sel_user_head;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.article_delete_after 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `article_delete_after` AFTER DELETE ON `lxp_article` FOR EACH ROW BEGIN
	#删除article_comment
	delete from lxp_article_comment where article_id = old.id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.article_insert 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `article_insert` BEFORE INSERT ON `lxp_article` FOR EACH ROW BEGIN
	set @sel_category_name='';
	#根据分类id设置分类名称
	if new.category_id>0 then 
		select name into @sel_category_name from lxp_category where new.category_id=id;
		set new.category_name = @sel_category_name;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.article_update 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `article_update` BEFORE UPDATE ON `lxp_article` FOR EACH ROW BEGIN
	set @sel_category_name='';
	#根据分类id设置分类名称
	if new.category_id>0 then 
		select name into @sel_category_name from lxp_category where new.category_id=id;
		set new.category_name = @sel_category_name;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.article_update_after 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `article_update_after` AFTER UPDATE ON `lxp_article` FOR EACH ROW BEGIN
	#更改article_comment
	update lxp_article_comment set article_name = new.title where article_id = new.id; 
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.category_update_after 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `category_update_after` AFTER UPDATE ON `lxp_category` FOR EACH ROW BEGIN
	#更改artice
	update lxp_article set category_name = new.name where category_id = new.id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.role_update_after 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `role_update_after` AFTER UPDATE ON `lxp_role` FOR EACH ROW BEGIN
	#更改admin
	update lxp_admin set role_name = new.name where role_id = new.id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.user_comment_insert 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `user_comment_insert` BEFORE INSERT ON `lxp_user_comment` FOR EACH ROW BEGIN
	set @sel_account='';
	set @sel_head='';
	#根据用户id设置用户名称
	if new.user_id>0 then 
		select account into @sel_account from lxp_user where new.user_id=id;
		set new.user_account = @sel_account;
	end if;
	#根据用户id设置用户头像
	if new.user_id>0 then 
		select head into @sel_head from lxp_user where new.user_id=id;
		set new.user_head = @sel_head;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.user_comment_update 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `user_comment_update` BEFORE UPDATE ON `lxp_user_comment` FOR EACH ROW BEGIN
	set @sel_account='';
	set @sel_head='';
	#根据用户id设置用户名称
	if new.user_id>0 then 
		select account into @sel_account from lxp_user where new.user_id=id;
		set new.user_account = @sel_account;
	end if;
	#根据用户id设置用户头像
	if new.user_id>0 then 
		select head into @sel_head from lxp_user where new.user_id=id;
		set new.user_head = @sel_head;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.user_login_insert 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `user_login_insert` BEFORE INSERT ON `lxp_user_login` FOR EACH ROW BEGIN
	set @sel_account='';
	#根据用户id设置用户名称
	if new.account_id>0 then 
		select account into @sel_account from lxp_user where new.account_id=id;
		set new.account = @sel_account;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.user_login_update 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `user_login_update` BEFORE UPDATE ON `lxp_user_login` FOR EACH ROW BEGIN
	set @sel_account='';
	#根据用户id设置用户名称
	if new.account_id>0 then 
		select account into @sel_account from lxp_user where new.account_id=id;
		set new.account = @sel_account;
	end if;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- 导出  触发器 lxp.user_update_after 结构
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `user_update_after` AFTER UPDATE ON `lxp_user` FOR EACH ROW BEGIN
	#更改user_comment
	update lxp_user_comment set user_account = new.account where user_id = new.id;
	#更改user_login
	update lxp_user_login set account = new.account where account_id = new.id;
	#更改article_comment
	update lxp_article_comment set user_account = new.account where user_id = new.id;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

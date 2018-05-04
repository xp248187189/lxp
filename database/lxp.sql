-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.5.53 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出  表 lxp.lxp_about 结构
CREATE TABLE IF NOT EXISTS `lxp_about` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `introduce` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '简介',
  `detail` text COLLATE utf8_unicode_ci COMMENT '详情',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标签',
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_admin 结构
CREATE TABLE IF NOT EXISTS `lxp_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员登陆账号',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员姓名',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员登陆密码',
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sex` enum('男','女') COLLATE utf8_unicode_ci NOT NULL DEFAULT '男' COMMENT '性别',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `role_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_admin_login 结构
CREATE TABLE IF NOT EXISTS `lxp_admin_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登录ip',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `account_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆id',
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登录名',
  `browser` text COLLATE utf8_unicode_ci COMMENT '浏览器信息',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_article 结构
CREATE TABLE IF NOT EXISTS `lxp_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章主图',
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章标题',
  `outline` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章概要',
  `content` mediumtext COLLATE utf8_unicode_ci COMMENT '文章内容',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `category_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `isHome` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页',
  `isRecommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `addTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间戳',
  `showNum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_article_comment 结构
CREATE TABLE IF NOT EXISTS `lxp_article_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  `article_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章标题',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_account` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `user_head` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户头像',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `connect` text COLLATE utf8_unicode_ci COMMENT '评论内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_auth 结构
CREATE TABLE IF NOT EXISTS `lxp_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `id_list` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '顶级id至本身id',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '级别',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '权限名称',
  `controller` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '方法',
  `icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图标',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_category 结构
CREATE TABLE IF NOT EXISTS `lxp_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_link 结构
CREATE TABLE IF NOT EXISTS `lxp_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '链接名称',
  `url` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_note 结构
CREATE TABLE IF NOT EXISTS `lxp_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'url地址',
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_notice 结构
CREATE TABLE IF NOT EXISTS `lxp_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '内容',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_role 结构
CREATE TABLE IF NOT EXISTS `lxp_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `auth_ids` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '权限ids',
  `sort` int(10) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_time_axis 结构
CREATE TABLE IF NOT EXISTS `lxp_time_axis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '年',
  `month` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '月',
  `day` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '日',
  `hour` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '时',
  `minute` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分',
  `content` text COLLATE utf8_unicode_ci COMMENT '内容',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `isHome` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '首页显示',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间戳',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_user 结构
CREATE TABLE IF NOT EXISTS `lxp_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `sex` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '性别',
  `head` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `connectid` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'qq登录返回的id',
  `addTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '加入时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_user_comment 结构
CREATE TABLE IF NOT EXISTS `lxp_user_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_account` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `user_head` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户头像',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '留言时间',
  `connect` text COLLATE utf8_unicode_ci COMMENT '留言内容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


-- 导出  表 lxp.lxp_user_login 结构
CREATE TABLE IF NOT EXISTS `lxp_user_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登录ip',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `account_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆id',
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登录名',
  `browser` text COLLATE utf8_unicode_ci COMMENT '浏览器信息',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。


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

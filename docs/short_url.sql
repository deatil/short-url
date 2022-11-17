DROP TABLE IF EXISTS `sys_app`;
CREATE TABLE `sys_app` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属用户id',
  `app_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_secret` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_content` text COLLATE utf8mb4_unicode_ci COMMENT '申请内容',
  `is_apply` tinyint(1) DEFAULT '1' COMMENT '0-未通过，1-申请中，2-申请通过',
  `action_content` text COLLATE utf8mb4_unicode_ci COMMENT '申请结果内容',
  `action_time` int(10) DEFAULT NULL COMMENT '申请操作时间',
  `last_active` int(10) DEFAULT '0' COMMENT '上次活动时间',
  `last_ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '上次活动IP',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1-开启',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `add_ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `app_id` (`app_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='api 接口申请';

DROP TABLE IF EXISTS `sys_setting`;
CREATE TABLE `sys_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字段',
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '字段值',
  `desc` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '字段说明',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-禁用',
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='设置';

DROP TABLE IF EXISTS `sys_url`;
CREATE TABLE `sys_url` (
  `id` char(36) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT 'uuid',
  `url` text CHARACTER SET utf8mb4 NOT NULL,
  `url_id` varchar(16) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '短链接跳转ID',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属用户id',
  `scheme` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host` text COLLATE utf8mb4_unicode_ci,
  `port` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1-临时链接，2-永久链接',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-禁用',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '添加IP',
  PRIMARY KEY (`id`),
  KEY `url_id` (`url_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '账号，大小写字母数字',
  `password` char(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '电话',
  `avatar` varchar(50) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '头像',
  `login_time` int(10) DEFAULT '0' COMMENT '最后登录时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '1-启用，0-禁用',
  `add_time` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `add_ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '添加IP',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='用户';

INSERT INTO `sys_setting` VALUES (1,'website_name','short-url','网站名称',1),(2,'website_keywords','short-url,webman,url','网站关键字',1),(3,'website_description','短链接服务系统','网站描述',1),(4,'website_copyright','@deatil','网站版权',1),(5,'website_status','1','网站状态',1),(6,'website_beian','ICP备123456号-112','网站备案',1);
INSERT INTO `sys_user` VALUES (1,'admin','$2y$10$SPbF6UU9uwqpID26B15.pON54WrC1TbQHLSQjf1ARubGycofOt4Fy','admin@admin.com','15345678911','avatar/202211/636f16aa5686.jpg',0,1,1667491323,'127.0.0.1'),(2,'shorturl','$2y$10$jLGaSKCxM85s0a3mbl0ZxuojUJT578lU0MD8m6MtxxdBaW/LVEsQu','admin2@qq.com','15345678911','avatar/202211/637504ccd24f.jpg',0,1,1667491323,'127.0.0.1');

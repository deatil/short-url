# short-url 短链接服务系统

lshort-url 是一套基于 webman 框架的通用短链接服务系统


## 项目介绍

*  `lshort-url` 是基于 `webman` 框架的通用短链接服务系统
*  使用 `bootstrap` 前端框架作为用户界面


## 环境要求

 - PHP >= 8.0.2
 - Fileinfo PHP Extension


## 安装步骤

1. 首先 `clone` 系统到本地

```php
https://github.com/deatil/short-url.git
```

2. 导入数据库文件 `/doc/short_url.sql` 到数据库， 并配置数据库连接信息 `/config/database.php`

3. 测试开发

```php
php windows.php
```

4. 登录地址: `http://127.0.0.1:8787/account/login`, 后台登录账号及密码：`admin` / `123456`


## 特别鸣谢

感谢以下的项目,排名不分先后

 - workerman/webman

 - vlucas/phpdotenv

 - illuminate/database
 
 - PclZip


## 开源协议

*  `short-url` 遵循 `Apache2` 开源协议发布，在保留本系统版权的情况下提供个人及商业免费使用。 


## 版权

*  该系统所属版权归 deatil(https://github.com/deatil) 所有。

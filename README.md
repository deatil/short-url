# short-url 短链接服务系统

lshort-url 是一套基于 webman 框架的通用短链接服务系统


## 项目介绍

*  `lshort-url` 是基于 `webman` 框架的通用短链接服务系统
*  使用 `bootstrap` 前端框架搭建的用户界面


## 环境要求

 - PHP >= 8.0.2
 - Fileinfo PHP Extension


## 截图预览

<table>
    <tr>
        <td width="50%">
            <center>
                <img alt="login" src="https://user-images.githubusercontent.com/24578855/202230701-ab003991-ea1a-4018-8258-7f7cd293dab5.png" />
            </center>
        </td>
        <td width="50%">
            <center>
                <img alt="登录" src="https://user-images.githubusercontent.com/24578855/202233111-2f4111b0-def4-4aa0-9f28-e57974c310b7.png" />
            </center>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <center>
                <img alt="添加链接" src="https://user-images.githubusercontent.com/24578855/202233176-7d001891-be0d-4a6b-b80f-d25c0d765ebc.png" />
            </center>
        </td>
        <td width="50%">
            <center>
                <img alt="链接记录" src="https://user-images.githubusercontent.com/24578855/202233399-a5b6c961-f26a-4603-b71c-a634b5588643.png" />
            </center>
        </td>
    </tr>
</table>

更多截图 
[Short-url 后台截图](https://github.com/deatil/short-url/issues/1)


## 安装步骤

1. 首先 `clone` 系统到本地

```git
git clone https://github.com/deatil/short-url.git
```

2. 导入数据库文件 `/doc/short_url.sql` 到数据库， 并配置数据库连接信息 `/config/database.php`

3. 更新依赖

```php
composer update
```

4. 测试开发

```php
php windows.php
```

或者

```php
php start.php
```

5. 登录地址: `http://127.0.0.1:8787/account/login`, 后台登录账号及密码：`admin` / `123456`


## 特别鸣谢

感谢以下的项目,排名不分先后

 - workerman/webman

 - vlucas/phpdotenv

 - illuminate/database


## 开源协议

*  `short-url` 遵循 `Apache2` 开源协议发布，在保留本系统版权的情况下提供个人及商业免费使用。 


## 版权

*  该系统所属版权归 deatil(https://github.com/deatil) 所有。

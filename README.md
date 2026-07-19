# PHP Management System

基于 ThinkPHP 6.1 和 MySQL 的多应用管理系统，包含后台管理端与用户 API。

## 功能

- 后台管理员登录、图片验证码与登录限制
- 管理员、角色和权限管理
- 基于角色的后台菜单与访问控制
- 新闻管理与图片上传
- 用户登录、极验验证码和 Token 鉴权
- 部门、区域和任务管理
- 任务分页及人员、区域关联展示

## 环境要求

- PHP 7.2.5 或更高版本
- MySQL 5.7 或更高版本
- Composer
- PHP 扩展：PDO MySQL、GD、mbstring

## 安装

```bash
composer install
```

复制环境配置：

```bash
copy .env.example .env
```

修改 `.env` 中的数据库连接和极验配置，然后导入数据库：

```bash
mysql -u root -p < db.sql
```

启动开发服务器：

```bash
php think run
```

后台地址：

```text
http://127.0.0.1:8000/admin/login/index
```

演示管理员账号为 `admin`，初始密码为 `123456`。首次成功登录后，系统会将旧 MD5 密码自动升级为 bcrypt 哈希。部署到公开环境前请立即修改演示密码。

## 安全说明

- 不要提交真实 `.env` 文件。
- 极验密钥必须通过环境变量配置。
- 上传文件限制为不超过 5 MB 的常见图片格式。
- 生产环境请关闭 `APP_DEBUG` 并使用 HTTPS。

## Docker 一键启动

确保 Docker Desktop 已启动，然后复制 Docker 环境变量文件：

```powershell
Copy-Item .env.docker.example .env.docker
```

修改 `.env.docker` 中的两个数据库密码，再构建并启动 Nginx、PHP-FPM 和 MySQL：

```powershell
docker compose --env-file .env.docker up -d --build
```

浏览器访问：

```text
http://127.0.0.1:8080/admin/login/index
```

查看容器状态和日志：

```powershell
docker compose --env-file .env.docker ps
docker compose --env-file .env.docker logs -f
```

停止容器：

```powershell
docker compose --env-file .env.docker down
```

MySQL 数据保存在 `mysql_data` 数据卷中，普通的 `down` 不会删除数据。不要随意执行 `down -v`；它会删除数据卷。数据卷用于持久化，但不能代替数据库备份。

## License

[Apache License 2.0](LICENSE.txt)

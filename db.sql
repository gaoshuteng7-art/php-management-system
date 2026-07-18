/*
SQLyog Ultimate v11.27 (32 bit)
MySQL - 5.7.26 : Database - cms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cms` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `cms`;

/*Table structure for table `think_admin` */

DROP TABLE IF EXISTS `think_admin`;

CREATE TABLE `think_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tel` varchar(20) DEFAULT '',
  `email` varchar(30) DEFAULT '',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '1' COMMENT '0停用1启用',
  `login_time` bigint(16) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `login_num` int(11) DEFAULT '0' COMMENT '登陆次数',
  `login_error_num` int(11) DEFAULT '0' COMMENT '登陆失败的次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `think_admin` */

insert  into `think_admin`(`id`,`role_id`,`name`,`username`,`password`,`tel`,`email`,`create_time`,`status`,`login_time`,`login_num`,`login_error_num`) values (1,4,'超级管理员1','admin','e10adc3949ba59abbe56e057f20f883e','13214033467','','2026-01-21 17:54:13',1,1768989253,24,0),(2,5,'张三','zhangsan','202cb962ac59075b964b07152d234b70','18888888888','','2026-01-21 16:58:25',0,1768985869,4,0);

/*Table structure for table `think_area` */

DROP TABLE IF EXISTS `think_area`;

CREATE TABLE `think_area` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `type` enum('point','line') NOT NULL DEFAULT 'point',
  `chang` float(9,1) NOT NULL DEFAULT '0.0',
  `kuan` float(9,1) NOT NULL DEFAULT '0.0',
  `num` tinyint(4) NOT NULL DEFAULT '0',
  `tag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `think_area` */

insert  into `think_area`(`id`,`title`,`area`,`type`,`chang`,`kuan`,`num`,`tag`) values (1,'A1','A','point',0.0,0.0,1,1),(2,'A2','A','line',20.0,1.6,0,0),(3,'B1','B','point',0.0,0.0,0,0),(4,'B2','B','line',10.0,1.0,0,1),(5,'B3','B','point',0.0,0.0,0,0),(6,'B4','B','line',10.0,1.2,0,1);

/*Table structure for table `think_bumen` */

DROP TABLE IF EXISTS `think_bumen`;

CREATE TABLE `think_bumen` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `weigh` int(9) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `think_bumen` */

insert  into `think_bumen`(`id`,`title`,`weigh`) values (1,'技术部',10),(2,'后勤部',10),(3,'财务部',10),(4,'研发部',10);

/*Table structure for table `think_news` */

DROP TABLE IF EXISTS `think_news`;

CREATE TABLE `think_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL COMMENT '标题',
  `description` varchar(500) NOT NULL COMMENT '描述',
  `author` varchar(30) NOT NULL COMMENT '作者',
  `addtime` date DEFAULT NULL COMMENT '发布时间',
  `content` text COMMENT '内容',
  `picurl` varchar(200) NOT NULL DEFAULT '' COMMENT '封面图片',
  `seenum` int(10) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未发布1已发布',
  `create_time` datetime DEFAULT NULL COMMENT '新增时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4;

/*Data for the table `think_news` */

insert  into `think_news`(`id`,`title`,`description`,`author`,`addtime`,`content`,`picurl`,`seenum`,`status`,`create_time`,`update_time`) values (72,'123','123','123','2026-01-21','<p><span style=\"color: rgb(225, 60, 57);\"> 123</span></p><p>123</p>','/storage/topic/20260121\\75ec6dfe210c24e224482be3cdffbdc0.png',0,1,'2026-01-21 18:57:41','2026-01-21 18:57:41'),(71,'1','1','1','2026-01-21','<p>1</p>','/storage/topic/20260121\\f420cb19bfbe814ad12550f2a6dc9782.png',0,1,'2026-01-21 18:47:05','2026-01-21 18:47:05'),(70,'1','1','1','2026-01-21','1','/storage/topic/20260121\\d3db5e2a6c24fecf20ac9d40eff9ed47.png',0,1,'2026-01-21 18:45:38','2026-01-21 18:45:38');

/*Table structure for table `think_power` */

DROP TABLE IF EXISTS `think_power`;

CREATE TABLE `think_power` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `tag` varchar(200) NOT NULL,
  `weigh` int(10) NOT NULL DEFAULT '10',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0隐藏1显示',
  `url` varchar(100) DEFAULT '',
  `icon` varchar(20) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `think_power` */

insert  into `think_power`(`id`,`pid`,`title`,`tag`,`weigh`,`status`,`url`,`icon`) values (2,0,'管理员管理','GuanLiYuanGuanLi',10,1,'','&amp;#xe62d;'),(3,2,'管理员列表','GuanLiYuanLieBiao',10,1,'/admin/admin/index',''),(4,2,'角色管理','JiaoSeGuanLi',10,1,'/admin/role/index',''),(5,2,'权限管理','QuanXianGuanLi',10,1,'/admin/power/index',''),(7,5,'权限修改','QuanXianXiuGai',10,0,'',''),(8,0,'内容管理','NaRongGuanLi',100,1,'','&amp;#xe616;'),(13,8,'内容列表','NaRongLieBiao',10,1,'/admin/news/index',''),(14,0,'学生管理','XueShengGuanLi',10,1,'','');

/*Table structure for table `think_role` */

DROP TABLE IF EXISTS `think_role`;

CREATE TABLE `think_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `power_ids` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `think_role` */

insert  into `think_role`(`id`,`title`,`power_ids`) values (4,'超级管理员','2,3,4,5,7,8,13'),(5,'内容管理员','8');

/*Table structure for table `think_task` */

DROP TABLE IF EXISTS `think_task`;

CREATE TABLE `think_task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `task_date` date NOT NULL,
  `beginTime` time DEFAULT NULL,
  `endTime` time DEFAULT NULL,
  `areaIds` varchar(300) NOT NULL DEFAULT '',
  `bumenId` smallint(6) NOT NULL DEFAULT '0',
  `peopleIds` varchar(300) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

/*Data for the table `think_task` */

insert  into `think_task`(`id`,`title`,`task_date`,`beginTime`,`endTime`,`areaIds`,`bumenId`,`peopleIds`) values (4,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(5,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(6,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(7,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(8,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(9,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(10,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(11,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(12,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(13,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(14,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(15,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(16,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(17,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(18,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(19,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(20,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(21,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(22,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(23,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(24,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(25,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(26,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(27,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(28,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(29,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(30,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(31,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(32,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(33,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2'),(34,'2025年每周调研计划','2025-12-11','10:30:00','18:30:00','1,2,3,4,5,6',1,'1,2'),(35,'2025年每日研计划','2025-12-12','09:30:00','18:30:00','1,2',1,'1,2');

/*Table structure for table `think_token` */

DROP TABLE IF EXISTS `think_token`;

CREATE TABLE `think_token` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(50) NOT NULL,
  `expired_time` int(16) NOT NULL DEFAULT '0',
  `type` enum('user-token','user-refresh-token','admin-token','admin-refresh-token') DEFAULT NULL,
  `uid` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

/*Data for the table `think_token` */

insert  into `think_token`(`id`,`token`,`expired_time`,`type`,`uid`) values (22,'c32b98c91358c522d9fec1b576702fa1',1768474615,'user-token',1);

/*Table structure for table `think_user` */

DROP TABLE IF EXISTS `think_user`;

CREATE TABLE `think_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `tel` varchar(20) NOT NULL DEFAULT '',
  `bumenId` int(11) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `headerimg` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `think_user` */

insert  into `think_user`(`id`,`name`,`tel`,`bumenId`,`password`,`headerimg`) values (1,'张三','13211112222',1,'',''),(2,'李四','18800002222',1,'',''),(3,'王五','18800003333',2,'',''),(4,'赵六','18800004444',3,'','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

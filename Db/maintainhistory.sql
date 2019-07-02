# Host: localhost  (Version: 5.5.53)
# Date: 2019-07-02 20:00:23
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "fun"
#

DROP TABLE IF EXISTS `fun`;
CREATE TABLE `fun` (
  `code` varchar(11) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "fun"
#

INSERT INTO `fun` VALUES ('FID_5d1b077','维护记录创建'),('FID_5d1b079','维护记录更新'),('FID_5d1b07a','维护记录删除'),('FID_5d1b07b','维护记录查询');

#
# Structure for table "rfid"
#

DROP TABLE IF EXISTS `rfid`;
CREATE TABLE `rfid` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` varchar(255) DEFAULT NULL,
  `fid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "rfid"
#

INSERT INTO `rfid` VALUES (1,'RID_5d1b05a615cfd','FID_5d1b077'),(2,'RID_5d1b05a615cfd','FID_5d1b07a'),(3,'RID_5d1b05a615cfd','FID_5d1b079'),(4,'RID_5d1b05a615cfd','FID_5d1b07b'),(5,'RID_5d1b05b5b99ad','FID_5d1b077'),(6,'RID_5d1b05b5b99ad','FID_5d1b079'),(7,'RID_5d1b05b5b99ad','FID_5d1b07b'),(8,'RID_5d1b0603a37fd','FID_5d1b077'),(9,'RID_5d1b0603a37fd','FID_5d1b079'),(10,'RID_5d1b0603a37fd','FID_5d1b07b'),(11,'RID_5d1b06252d50a','FID_5d1b077'),(12,'RID_5d1b06252d50a','FID_5d1b07a'),(13,'RID_5d1b06252d50a','FID_5d1b079'),(14,'RID_5d1b06252d50a','FID_5d1b07b'),(15,'RID_5d1b070a8ffa3','FID_5d1b077'),(16,'RID_5d1b070a8ffa3','FID_5d1b07a'),(17,'RID_5d1b070a8ffa3','FID_5d1b079'),(18,'RID_5d1b070a8ffa3','FID_5d1b07b');

#
# Structure for table "role"
#

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "role"
#

INSERT INTO `role` VALUES ('RID_5d1b05a615cfd','管理员'),('RID_5d1b05b5b99ad','技术员'),('RID_5d1b0603a37fd','组长'),('RID_5d1b06252d50a','课级'),('RID_5d1b070a8ffa3','部级');

#
# Structure for table "urid"
#

DROP TABLE IF EXISTS `urid`;
CREATE TABLE `urid` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) DEFAULT NULL,
  `rid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "urid"
#

INSERT INTO `urid` VALUES (1,'bj','RID_5d1b070a8ffa3'),(2,'jsy','RID_5d1b05b5b99ad'),(3,'kj','RID_5d1b06252d50a'),(4,'zz','RID_5d1b0603a37fd');

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL DEFAULT '',
  `pwd` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `mail` varchar(255) DEFAULT NULL,
  `lastLogin` datetime DEFAULT NULL,
  `loginTimes` int(11) DEFAULT NULL,
  `loginAddr` varchar(1) DEFAULT NULL,
  `enable` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`,`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'admin','$2y$10$y6CBMcSiH7V8gVRzcJuq6e2LcNx/qs1f.E.drFfdPh6KrjRgCGFBK','Administrator','Ping_yi',NULL,NULL,NULL,b'1'),(2,'S09264888','$2y$10$AkPC83zqJplYmTytHe4Y9eTaeLv.3SvfMaK0/sHf2ZG7Bfxs8USLq','易志平','ping_yi@pegatroncorp.com',NULL,NULL,NULL,b'1'),(3,'jsy','$2y$10$RgdWum0G3Y1rAvM8Z86sK.4/l/Dk5OhNMK1nK2VzT4lF6Z3QNIRX.','技术员','',NULL,NULL,NULL,b'1'),(4,'zz','$2y$10$epXtjXHvG8.NLANb9O2CjeLewMKVkP68j1ox0t2fGNYjzJ7Ba1dJm','组长','',NULL,NULL,NULL,b'1'),(5,'kj','$2y$10$lrfhqc2WlMk4vpWHFLzLou2cNWOen2OlIuBPGBZF0Bdg.m1B6BdF6','课级','',NULL,NULL,NULL,b'1'),(6,'bj','$2y$10$Gxd1cX4ho12LMC6Hdt7/Mu7eIQEQntyVSnyYx1mwulye9DQTbdWgq','部级','',NULL,NULL,NULL,b'1');

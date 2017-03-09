-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (armv7l)
--
-- Host: localhost    Database: dofthings
-- ------------------------------------------------------
-- Server version	5.5.53-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `dofthings` /*!40100 DEFAULT CHARACTER SET utf8 */;
use dofthings;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `faid` int(64) NOT NULL,
  `type` varchar(45) NOT NULL,
  `path` varchar(250) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `pass` varchar(45) DEFAULT NULL,
  `executed` tinyint(1) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `answer` text,
  PRIMARY KEY (`id`),
  KEY `fk_actions_1` (`faid`),
  CONSTRAINT `fk_actions_1` FOREIGN KEY (`faid`) REFERENCES `feed_alarms` (`faid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=522 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alarm_action`
--

DROP TABLE IF EXISTS `alarm_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alarm_action` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `faid` int(64) NOT NULL,
  `type` varchar(45) NOT NULL,
  `path` varchar(250) NOT NULL,
  `value` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_alarm_action_1` (`faid`),
  CONSTRAINT `fk_alarm_action_1` FOREIGN KEY (`faid`) REFERENCES `feed_alarms` (`faid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alarm_notif`
--

DROP TABLE IF EXISTS `alarm_notif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alarm_notif` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `faid` int(64) NOT NULL,
  `type` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `last_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_alarm_notif_1` (`faid`),
  CONSTRAINT `fk_alarm_notif_1` FOREIGN KEY (`faid`) REFERENCES `feed_alarms` (`faid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alarm_signs`
--

DROP TABLE IF EXISTS `alarm_signs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alarm_signs` (
  `asid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `sign` varchar(45) NOT NULL,
  PRIMARY KEY (`asid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alarm_signs`
--

LOCK TABLES `alarm_signs` WRITE;
/*!40000 ALTER TABLE `alarm_signs` DISABLE KEYS */;
INSERT INTO `alarm_signs` VALUES (1,'equal','='),(2,'greater','>'),(3,'less','<'),(4,'not equal','!=');
/*!40000 ALTER TABLE `alarm_signs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alarm_types`
--

DROP TABLE IF EXISTS `alarm_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alarm_types` (
  `atid` int(2) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(250) NOT NULL,
  `atypetable` varchar(250) NOT NULL,
  PRIMARY KEY (`atid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alarm_types`
--

LOCK TABLES `alarm_types` WRITE;
/*!40000 ALTER TABLE `alarm_types` DISABLE KEYS */;
INSERT INTO `alarm_types` VALUES (1,'Once','Generate alarm once and wait for value to reset it before generate again. Or Reset explicitly everytime when generate it.','atype1'),(2,'Period','Generate alarm after period of time threshold was violated and wait for reset before generate again. Or Reset explicitly everytime when generate it.','atype2'),(3,'Count','Generate alarm after a count of alarms and wait for reset before generate again. Or Reset explicitly everytime when generate it.','atype3');
/*!40000 ALTER TABLE `alarm_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atype1`
--

DROP TABLE IF EXISTS `atype1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atype1` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `faid` int(64) NOT NULL,
  `count_to_alarm` varchar(45) NOT NULL DEFAULT '1',
  `current_count` varchar(45) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occured` int(64) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_atype1_1` (`faid`),
  CONSTRAINT `fk_atype1_1` FOREIGN KEY (`faid`) REFERENCES `feed_alarms` (`faid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atype1`
--

LOCK TABLES `atype1` WRITE;
/*!40000 ALTER TABLE `atype1` DISABLE KEYS */;
INSERT INTO `atype1` VALUES (16,27,'1','0','2017-02-02 13:22:14',0),(18,30,'1','0','2017-01-28 21:56:28',0),(19,31,'1','0','2017-02-01 05:34:48',0),(20,32,'1','0','2017-02-01 14:14:48',0);
/*!40000 ALTER TABLE `atype1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atype2`
--

DROP TABLE IF EXISTS `atype2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atype2` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `faid` int(64) NOT NULL,
  `time_to_alarm` varchar(45) NOT NULL,
  `start` varchar(45) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occured` int(64) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_atype2_2` (`faid`),
  CONSTRAINT `fk_atype2_2` FOREIGN KEY (`faid`) REFERENCES `feed_alarms` (`faid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atype2`
--

LOCK TABLES `atype2` WRITE;
/*!40000 ALTER TABLE `atype2` DISABLE KEYS */;
/*!40000 ALTER TABLE `atype2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atype3`
--

DROP TABLE IF EXISTS `atype3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atype3` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `faid` int(64) NOT NULL,
  `count_to_alarm` varchar(45) NOT NULL DEFAULT '1',
  `current_count` varchar(45) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `occured` int(64) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_new_table_2` (`faid`),
  KEY `fk_atype3_2` (`faid`),
  CONSTRAINT `fk_atype3_2` FOREIGN KEY (`faid`) REFERENCES `feed_alarms` (`faid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atype3`
--

LOCK TABLES `atype3` WRITE;
/*!40000 ALTER TABLE `atype3` DISABLE KEYS */;
/*!40000 ALTER TABLE `atype3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dashboards`
--

DROP TABLE IF EXISTS `dashboards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dashboards` (
  `dashid` int(32) NOT NULL AUTO_INCREMENT,
  `uid` int(32) NOT NULL,
  `config` longtext NOT NULL,
  `share` tinyint(1) NOT NULL DEFAULT '0',
  `zoom` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `resolution` varchar(45) NOT NULL DEFAULT '1280x1024',
  `background` varchar(300) NOT NULL DEFAULT 'http://',
  `description` varchar(45) NOT NULL DEFAULT 'description',
  `name` varchar(45) NOT NULL DEFAULT 'Name',
  `move` tinyint(4) NOT NULL DEFAULT '0',
  `style` varchar(5000) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`dashid`),
  KEY `uid` (`uid`),
  CONSTRAINT `graphics_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `env_settings`
--

DROP TABLE IF EXISTS `env_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `env_settings` (
  `site_url` varchar(60) DEFAULT NULL,
  `site_vhost` varchar(60) DEFAULT NULL,
  `admin_name` varchar(20) DEFAULT NULL,
  `admin_email` varchar(60) DEFAULT NULL,
  `site_mode` smallint(1) NOT NULL DEFAULT '0',
  `site_name` varchar(50) NOT NULL,
  `description` mediumtext NOT NULL,
  `keywords` longtext NOT NULL,
  `site_lang` char(3) NOT NULL DEFAULT 'en',
  `template` varchar(100) DEFAULT NULL,
  `use_verify_email` smallint(1) NOT NULL DEFAULT '0',
  `visitor_tracking` smallint(1) NOT NULL DEFAULT '0',
  `force_compile_enabled` smallint(1) NOT NULL DEFAULT '0',
  `use_fancy_urls` smallint(1) NOT NULL DEFAULT '0',
  `use_user_approval` smallint(1) NOT NULL DEFAULT '0',
  `users_delete_after_days` smallint(3) NOT NULL DEFAULT '15',
  `email_after_days` smallint(3) NOT NULL DEFAULT '45',
  `google_code` varchar(60) DEFAULT NULL,
  `cron_access_key` varchar(12) DEFAULT NULL,
  `maint_mode` smallint(1) NOT NULL DEFAULT '0',
  `main_image_width` int(3) NOT NULL DEFAULT '350',
  `default_user_level` smallint(1) NOT NULL DEFAULT '11',
  `time_zone` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `id` int(11) NOT NULL,
  `smtpserver` varchar(60) DEFAULT NULL,
  `smtpport` varchar(60) DEFAULT NULL,
  `smtpuser` varchar(60) DEFAULT NULL,
  `smtppass` varchar(60) DEFAULT NULL,
  `xmppserver` varchar(60) DEFAULT NULL,
  `xmppport` varchar(60) DEFAULT NULL,
  `xmppuser` varchar(60) DEFAULT NULL,
  `xmpppass` varchar(60) DEFAULT NULL,
  `xmppdomain` varchar(60) DEFAULT NULL,
  `xmpptext` varchar(60) DEFAULT NULL,
  `other_credentials` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `env_settings`
--

LOCK TABLES `env_settings` WRITE;
/*!40000 ALTER TABLE `env_settings` DISABLE KEYS */;
INSERT INTO `env_settings` VALUES ('http://localhost/','','adminnn','admin@yoursite.com',0,'d-of-Things','d-of-Things - Home Automation Dashboard','IoT, Internet of Things, cloud, public cloud, smart systems, IoTWorks, iobridge, cisco, devices, iOS, Apple, Microsoft, paas, platform as a service, open, arm, mbed, ti, raspberry pi, arduino','en','template_1',0,0,1,1,0,15,45,'','sfpE8pP4y',0,350,11,NULL,0,'smtp.gmail.com','587','someemailaddressfornotifications@gmail.com','password','talkx.l.google.com','5222','someemailaddressfornotifications@gmail.com','password','gmail.com','xmpphp','{\"mqqtServerMiddlerwareSubscribe\":{\"hostname\":\"localhost\",\"port\":1883,\"user\":\"username\",\"pass\":\"password\"},\"mqttServerSendAction\":{\"hostname\":\"localhost\",\"port\":1883,\"user\":\"username\",\"pass\":\"password\"},\"mqttSendHTTP\":{\"hostname\":\"localhost\",\"port\":80,\"user\":\"username\",\"pass\":\"password\"}}');
/*!40000 ALTER TABLE `env_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feed_alarms`
--

DROP TABLE IF EXISTS `feed_alarms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed_alarms` (
  `faid` int(64) NOT NULL AUTO_INCREMENT,
  `atid` int(2) NOT NULL,
  `feedid` int(64) NOT NULL,
  `asid` int(2) NOT NULL DEFAULT '2',
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `metric` varchar(200) NOT NULL,
  `threshold` varchar(200) NOT NULL,
  `numericc` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `logging` tinyint(1) NOT NULL DEFAULT '0',
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reset` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`faid`),
  KEY `fk_feed_alarms_1` (`atid`),
  KEY `fk_feed_alarms_2` (`feedid`),
  CONSTRAINT `fk_feed_alarms_1` FOREIGN KEY (`atid`) REFERENCES `alarm_types` (`atid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_feed_alarms_2` FOREIGN KEY (`feedid`) REFERENCES `feeds` (`feedid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feed_keys`
--

DROP TABLE IF EXISTS `feed_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed_keys` (
  `uid` int(32) NOT NULL,
  `keyid` int(32) NOT NULL AUTO_INCREMENT,
  `feedid` int(32) NOT NULL,
  `label` varchar(120) NOT NULL DEFAULT 'Autogenerated feed key',
  `keyhash` varchar(120) NOT NULL,
  `perms` int(1) NOT NULL DEFAULT '4',
  `secure` int(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `push_source_ip` varchar(200) NOT NULL DEFAULT 'ALL',
  `pull_source_ip` varchar(200) NOT NULL DEFAULT 'ALL',
  `execute_source_ip` varchar(200) NOT NULL DEFAULT 'ALL',
  PRIMARY KEY (`keyid`),
  KEY `uid` (`uid`),
  KEY `feedid` (`feedid`),
  CONSTRAINT `feed_keys_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `feed_keys_ibfk_2` FOREIGN KEY (`feedid`) REFERENCES `feeds` (`feedid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feed_logs`
--

DROP TABLE IF EXISTS `feed_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feed_logs` (
  `logid` int(32) NOT NULL AUTO_INCREMENT,
  `feedid` int(32) NOT NULL,
  `logmsg` longtext NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`logid`),
  KEY `feedid` (`feedid`),
  CONSTRAINT `feed_logs_ibfk_1` FOREIGN KEY (`feedid`) REFERENCES `feeds` (`feedid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12335 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feeds`
--

DROP TABLE IF EXISTS `feeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feeds` (
  `uid` int(32) NOT NULL,
  `feedid` int(64) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `auto` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `url` varchar(120) NOT NULL DEFAULT 'https://',
  `parser_settings` varchar(120) NOT NULL DEFAULT '*',
  `filepath` varchar(120) NOT NULL DEFAULT '/absolute_path',
  `table_name` varchar(120) NOT NULL DEFAULT 'MongoDB_TableName',
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `logging` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`feedid`),
  KEY `uid` (`uid`),
  CONSTRAINT `feeds_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `faid` int(64) NOT NULL,
  `type` varchar(45) NOT NULL,
  `subject` varchar(45) DEFAULT NULL,
  `address` varchar(45) NOT NULL,
  `message` text NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_notifications_1` (`faid`),
  CONSTRAINT `fk_notifications_1` FOREIGN KEY (`faid`) REFERENCES `feed_alarms` (`faid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=646 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `onlineusers`
--

DROP TABLE IF EXISTS `onlineusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `onlineusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(32) NOT NULL,
  `user` varchar(60) NOT NULL,
  `last_active` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ipaddress` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `onlineusers_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_settings` (
  `uid` int(32) NOT NULL,
  `settings` varchar(120) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `uid` (`uid`),
  CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_settings`
--

LOCK TABLES `user_settings` WRITE;
/*!40000 ALTER TABLE `user_settings` DISABLE KEYS */;
INSERT INTO `user_settings` VALUES (1,'var=value1, var2=value2','2013-05-03 23:13:28','2013-06-06 13:10:33');
/*!40000 ALTER TABLE `user_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` int(32) NOT NULL AUTO_INCREMENT,
  `ipaddress` varchar(16) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `email` varchar(60) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `reg_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_active` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` smallint(1) NOT NULL DEFAULT '0',
  `activated` smallint(1) NOT NULL DEFAULT '1',
  `approved` smallint(1) NOT NULL DEFAULT '1',
  `notes` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`user`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'127.0.0.1','admin','eb0e08b3bd3351091697316934808133','admin@yoursite.comm','admin','admin','+01 000-000-0000 x12345','123 Somewhere','Some City','2013-05-03 23:13:28','2017-01-27 10:24:59',99,1,1,'NULL','NULL'),(2,'127.0.0.1','user','eb0e08b3bd3351091697316934808133','admin@yoursite.com','admin','admin','+01 000-000-0000 x12345','123 Somewhere','Some City','2013-05-03 23:13:28','2016-03-07 13:04:23',11,1,1,'NULL','NULL'),(3,'76.126.242.255','user1','ccd4a3a648f9068072deecc8465e4819','user1@user.com',NULL,NULL,NULL,NULL,NULL,'2014-11-01 23:01:57','2016-03-07 13:04:09',11,1,1,NULL,NULL),(4,'127.0.0.1','user6','2a81536d304f5bf0b9f96a926fa447e8','abv@abv.bg',NULL,NULL,NULL,NULL,NULL,'2015-02-04 08:41:03','2016-03-07 13:04:06',11,1,1,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-02 15:35:44

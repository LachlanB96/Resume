CREATE TABLE `virtual` (
  `address` varchar(64) NOT NULL DEFAULT '',
  `goto` mediumtext NOT NULL,
  PRIMARY KEY (`address`),
  UNIQUE KEY `address` (`address`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `users` (
  `userid` varchar(128) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `home` varchar(48) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '8',
  `gid` int(11) NOT NULL DEFAULT '12',
  `active` char(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

CREATE TABLE `domain_user` (
  `ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `USER` varchar(35) CHARACTER SET utf8 NOT NULL,
  `PASS` varchar(30) CHARACTER SET utf8 NOT NULL,
  `TITLE` varchar(50) CHARACTER SET utf8 NOT NULL,
  `IS_ADMIN` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Can create domains and assign supervisors',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `USER` (`USER`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='Domain supervisors';

CREATE TABLE `domain` (
  `ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `DOMAIN` varchar(65) NOT NULL,
  `ADM_USER` tinyint(3) unsigned DEFAULT NULL COMMENT 'Index into DOMAIN_USER',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ime` (`DOMAIN`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Allowed domains for Postfix';

CREATE TABLE `sender_bcc` (
  `sender` varchar(60) NOT NULL,
  `goto` varchar(250) NOT NULL,
  PRIMARY KEY (`sender`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='sender_bcc_map AND recipient_bcc_map';
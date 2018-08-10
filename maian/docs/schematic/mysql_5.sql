# --------------------------------------------------------
# MYSQL DATABASE SCHEMATIC
# Script:   Maian Support
# MySQL:    5.0 or higher
# Charset:  latin1 (adjust if required)
# Engine:   MyISAM
# --------------------------------------------------------

DROP TABLE IF EXISTS `msp_attachments`;
CREATE TABLE IF NOT EXISTS `msp_attachments` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ts` int(30) NOT NULL DEFAULT '0',
  `ticketID` varchar(20) NOT NULL DEFAULT '',
  `replyID` int(11) NOT NULL DEFAULT '0',
  `department` int(5) NOT NULL DEFAULT '0',
  `fileName` varchar(250) NOT NULL DEFAULT '',
  `fileSize` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  INDEX `tickid_index` (`ticketID`),
  INDEX `repid_index` (`replyID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_categories`;
CREATE TABLE IF NOT EXISTS `msp_categories` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `summary` varchar(250) NOT NULL DEFAULT '',
  `enCat` enum('yes','no') NOT NULL DEFAULT 'yes',
  `orderBy` int(5) NOT NULL DEFAULT '0',
  `subcat` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_cusfields`;
CREATE TABLE IF NOT EXISTS `msp_cusfields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fieldInstructions` varchar(250) NOT NULL DEFAULT '',
  `fieldType` enum('textarea','input','select','checkbox') NOT NULL DEFAULT 'input',
  `fieldReq` enum('yes','no') NOT NULL DEFAULT 'no',
  `fieldOptions` text default null,
  `fieldLoc` varchar(25) NOT NULL DEFAULT '',
  `orderBy` int(5) NOT NULL DEFAULT '0',
  `repeatPref` enum('yes','no') NOT NULL DEFAULT 'yes',
  `enField` enum('yes','no') NOT NULL DEFAULT 'yes',
  `departments` text default null,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_departments`;
CREATE TABLE IF NOT EXISTS `msp_departments` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `showDept` enum('yes','no') NOT NULL DEFAULT 'no',
  `dept_subject` text default null,
  `dept_comments` text default null,
  `orderBy` int(5) NOT NULL DEFAULT '0',
  `manual_assign` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `msp_departments` (`id`, `name`, `showDept`, `dept_subject`, `dept_comments`, `orderBy`, `manual_assign`) VALUES (1, 'General Tickets', 'yes','','','1','no');

DROP TABLE IF EXISTS `msp_disputes`;
CREATE TABLE IF NOT EXISTS `msp_disputes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticketID` int(15) NOT NULL DEFAULT '0',
  `userName` varchar(250) NOT NULL DEFAULT '',
  `userEmail` varchar(250) NOT NULL DEFAULT '',
  `postPrivileges` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`),
  INDEX `tickid_index` (`ticketID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_faq`;
CREATE TABLE IF NOT EXISTS `msp_faq` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ts` int(30) NOT NULL DEFAULT '0',
  `question` text default null,
  `answer` text default null,
  `category` int(5) NOT NULL DEFAULT '0',
  `kviews` int(10) NOT NULL DEFAULT '0',
  `kuseful` int(10) NOT NULL DEFAULT '0',
  `knotuseful` int(10) NOT NULL DEFAULT '0',
  `enFaq` enum('yes','no') NOT NULL DEFAULT 'yes',
  `orderBy` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `catid_index` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_faqattach`;
CREATE TABLE IF NOT EXISTS `msp_faqattach` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ts` int(30) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL DEFAULT '',
  `remote` varchar(250) NOT NULL DEFAULT '',
  `path` varchar(250) NOT NULL DEFAULT '',
  `size` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_faqattassign`;
CREATE TABLE IF NOT EXISTS `msp_faqattassign` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `question` int(7) NOT NULL DEFAULT '0',
  `attachment` int(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `que_index` (`question`),
  INDEX `att_index` (`attachment`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_imap`;
CREATE TABLE IF NOT EXISTS `msp_imap` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `im_piping` enum('yes','no') NOT NULL DEFAULT 'no',
  `im_protocol` enum('pop3','imap') NOT NULL DEFAULT 'pop3',
  `im_host` varchar(100) NOT NULL DEFAULT '',
  `im_user` varchar(250) NOT NULL DEFAULT '',
  `im_pass` varchar(100) NOT NULL DEFAULT '',
  `im_port` int(5) NOT NULL DEFAULT '110',
  `im_name` varchar(50) NOT NULL DEFAULT '',
  `im_flags` varchar(250) NOT NULL DEFAULT '',
  `im_attach` enum('yes','no') NOT NULL DEFAULT 'no',
  `im_move` varchar(50) NOT NULL DEFAULT '',
  `im_messages` int(3) NOT NULL DEFAULT '20',
  `im_ssl` enum('yes','no') NOT NULL DEFAULT 'no',
  `im_priority` varchar(250) NOT NULL DEFAULT '',
  `im_dept` int(5) NOT NULL DEFAULT '0',
  `im_email` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_levels`;
CREATE TABLE IF NOT EXISTS `msp_levels` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `display` enum('yes','no') NOT NULL DEFAULT 'no',
  `marker` varchar(100) NOT NULL DEFAULT '',
  `orderBy` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `msp_levels` VALUES (1, 'Low', 'yes', 'low', 1);
INSERT INTO `msp_levels` VALUES (2, 'Medium', 'yes', 'medium', 2);
INSERT INTO `msp_levels` VALUES (3, 'High', 'yes', 'high', 3);

DROP TABLE IF EXISTS `msp_log`;
CREATE TABLE IF NOT EXISTS `msp_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ts` int(30) NOT NULL DEFAULT '0',
  `userID` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_portal`;
CREATE TABLE IF NOT EXISTS `msp_portal` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ts` int(30) NOT NULL DEFAULT '0',
  `email` varchar(250) NOT NULL DEFAULT '',
  `userPass` varchar(40) NOT NULL DEFAULT '',
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes',
  `timezone` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `em_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_replies`;
CREATE TABLE IF NOT EXISTS `msp_replies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ts` int(30) NOT NULL DEFAULT '0',
  `ticketID` int(15) NOT NULL DEFAULT '0',
  `comments` text default null,
  `mailBodyFilter` varchar(30) NOT NULL DEFAULT '',
  `replyType` enum('none','visitor','admin') NOT NULL DEFAULT 'none',
  `replyUser` int(8) NOT NULL DEFAULT '0',
  `isMerged` enum('yes','no') NOT NULL DEFAULT 'no',
  `ipAddresses` varchar(250) NOT NULL DEFAULT '',
  `disputeUser` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `tickid_index` (`ticketID`),
  INDEX `repuse_index` (`replyUser`),
  INDEX `disuse_index` (`disputeUser`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_responses`;
CREATE TABLE IF NOT EXISTS `msp_responses` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ts` int(30) NOT NULL DEFAULT '0',
  `title` text default null,
  `answer` text default null,
  `department` int(5) NOT NULL DEFAULT '0',
  `enResponse` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`),
  INDEX `depid_index` (`department`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_settings`;
CREATE TABLE IF NOT EXISTS `msp_settings` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `website` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `scriptpath` varchar(250) NOT NULL DEFAULT '',
  `attachpath` varchar(250) NOT NULL DEFAULT '',
  `language` varchar(25) NOT NULL DEFAULT 'english.php',
  `dateformat` varchar(20) NOT NULL DEFAULT 'D j M Y, G:ia',
  `timeformat` varchar(15) NOT NULL DEFAULT 'H:iA',
  `timezone` varchar(50) NOT NULL DEFAULT 'Europe/London',
  `weekStart` enum('mon','sun') NOT NULL DEFAULT 'sun',
  `jsDateFormat` varchar(15) NOT NULL DEFAULT 'DD/MM/YYYY',
  `kbase` enum('yes','no') NOT NULL DEFAULT 'yes',
  `enableVotes` enum('yes','no') NOT NULL DEFAULT 'yes',
  `multiplevotes` enum('yes','no') NOT NULL DEFAULT 'no',
  `popquestions` int(5) NOT NULL DEFAULT '0',
  `quePerPage` int(3) NOT NULL DEFAULT '10',
  `cookiedays` int(5) NOT NULL DEFAULT '0',
  `attachment` enum('yes','no') NOT NULL DEFAULT 'no',
  `rename` enum('yes','no') NOT NULL DEFAULT 'no',
  `attachboxes` int(3) NOT NULL DEFAULT '2',
  `filetypes` text default null,
  `maxsize` int(10) NOT NULL DEFAULT '200',
  `enableBBCode` enum('yes','no') NOT NULL DEFAULT 'yes',
  `afolder` varchar(50) NOT NULL DEFAULT '',
  `portalpages` int(5) NOT NULL DEFAULT '0',
  `autoClose` int(5) NOT NULL DEFAULT '0',
  `autoCloseMail` enum('yes','no') NOT NULL DEFAULT 'yes',
  `smtp` enum('yes','no') NOT NULL DEFAULT 'no',
  `smtp_host` varchar(100) NOT NULL DEFAULT 'localhost',
  `smtp_user` varchar(100) NOT NULL DEFAULT '',
  `smtp_pass` varchar(100) NOT NULL DEFAULT '',
  `smtp_port` int(4) NOT NULL DEFAULT '25',
  `prodKey` char(60) NOT NULL DEFAULT '',
  `publicFooter` text default null,
  `adminFooter` text default null,
  `encoderVersion` varchar(5) NOT NULL DEFAULT '',
  `softwareVersion` varchar(10) NOT NULL DEFAULT '',
  `apiKey` varchar(100) NOT NULL DEFAULT '',
  `recaptchaPublicKey` varchar(250) NOT NULL DEFAULT '',
  `recaptchaPrivateKey` varchar(250) NOT NULL DEFAULT '',
  `enCapLogin` enum('yes','no') NOT NULL DEFAULT 'yes',
  `sysstatus` enum('yes','no') NOT NULL DEFAULT 'yes',
  `autoenable` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `msp_settings` VALUES (1, 'Helpdesk', '', '', '', 'english', 'd M Y', 'H:iA', 'Europe/London', 'sun', 'DD/MM/YYYY', 'yes', 
'yes', 'yes', 10, 10, 360, 'yes', 'no', 5, '.jpg|.zip|.gif|.rar|.png|.pdf', 1048576, 'yes', 'admin', 10, 3, 'yes', 'no', '', '', '', 587, 
'', '', '', '', '', '', '', '', 'no', 'yes', '0000-00-00');

DROP TABLE IF EXISTS `msp_ticketfields`;
CREATE TABLE IF NOT EXISTS `msp_ticketfields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticketID` varchar(20) NOT NULL DEFAULT '',
  `fieldID` int(15) NOT NULL DEFAULT '0',
  `replyID` int(15) NOT NULL DEFAULT '0',
  `fieldData` text default null,
  PRIMARY KEY (`id`),
  INDEX `tickid_index` (`ticketID`),
  INDEX `fldid_index` (`fieldID`),
  INDEX `repid_index` (`replyID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_tickets`;
CREATE TABLE IF NOT EXISTS `msp_tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ts` int(30) NOT NULL DEFAULT '0',
  `lastrevision` int(30) NOT NULL DEFAULT '0',
  `department` int(8) NOT NULL DEFAULT '0',
  `assignedto` varchar(200) NOT NULL DEFAULT '',
  `name` varchar(250) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `subject` varchar(250) NOT NULL DEFAULT '',
  `mailBodyFilter` varchar(30) NOT NULL DEFAULT '',
  `comments` text default null,
  `priority` varchar(250) NOT NULL DEFAULT '',
  `replyStatus` enum('start','visitor','admin') NOT NULL DEFAULT 'start',
  `ticketStatus` enum('open','close','closed') NOT NULL DEFAULT 'open',
  `ipAddresses` varchar(250) NOT NULL DEFAULT '',
  `ticketNotes` text default null,
  `isDisputed` enum('yes','no') NOT NULL DEFAULT 'no',
  `tickLang` varchar(100) NOT NULL DEFAULT 'english',
  `disPostPriv` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`),
  INDEX `email_index` (`email`),
  INDEX `depid_index` (`department`),
  INDEX `pry_index` (`priority`),
  INDEX `isdis_index` (`isDisputed`),
  INDEX `ts_index` (`ts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_userdepts`;
CREATE TABLE IF NOT EXISTS `msp_userdepts` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `userID` int(5) NOT NULL DEFAULT '0',
  `deptID` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `userid_index` (`userID`),
  INDEX `depid_index` (`deptID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `msp_users`;
CREATE TABLE IF NOT EXISTS `msp_users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ts` int(30) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(250) NOT NULL DEFAULT '',
  `accpass` varchar(32) NOT NULL DEFAULT '',
  `signature` text default null,
  `notify` enum('yes','no') NOT NULL DEFAULT 'yes',
  `pageAccess` varchar(250) NOT NULL DEFAULT '',
  `emailSigs` enum('yes','no') NOT NULL DEFAULT 'no',
  `notePadEnable` enum('yes','no') NOT NULL DEFAULT 'yes',
  `delPriv` enum('yes','no') NOT NULL DEFAULT 'no',
  `nameFrom` varchar(250) NOT NULL DEFAULT '',
  `emailFrom` varchar(250) NOT NULL DEFAULT '',
  `assigned` enum('yes','no') NOT NULL DEFAULT 'no',
  `timezone` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `email_index` (`email`),
  INDEX `nty_index` (`notify`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `notifications` (  `notifications_id` int(11) NOT NULL AUTO_INCREMENT,  `title` varchar(255) NOT NULL DEFAULT '',  `body` text NOT NULL,  `source` varchar(255) NOT NULL DEFAULT '',  `checksum` varchar(128) NOT NULL,  PRIMARY KEY (`notifications_id`),  UNIQUE KEY `checksum` (`checksum`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `notifications_attribs` (  `attrib_id` int(11) NOT NULL AUTO_INCREMENT,  `notifications_id` int(11) NOT NULL,  `user_id` int(11) NOT NULL,  `key` varchar(255) NOT NULL DEFAULT '',  `value` varchar(255) NOT NULL DEFAULT '',  PRIMARY KEY (`attrib_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

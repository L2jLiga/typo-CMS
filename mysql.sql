DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `author` varchar(32) NOT NULL,
  `mail` varchar(32) NOT NULL,
  `msg` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
	`id` int(5) NOT NULL AUTO_INCREMENT,
	`title` varchar(64) NOT NULL,
	`short_news` text NOT NULL,
	`full_news` text NOT NULL,
	`photo` int(10) NOT NULL,
	`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

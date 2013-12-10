

DROP TABLE IF EXISTS `state`;
CREATE TABLE `state` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `state` varchar(125) NOT NULL DEFAULT '',
  `state_code` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
   `id` int(10) NOT NULL AUTO_INCREMENT,
  `city` varchar(50) NOT NULL,
  `state_code` char(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_state_code` (`state_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `bank_rate`;
CREATE TABLE `bank_rate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `city_id` int(10) NOT NULL DEFAULT '0',
  `rate` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY city_id (`city_id`)
) ENGINE=InnoDB;
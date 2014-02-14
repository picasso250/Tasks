delimiter $$

CREATE TABLE `task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `indent` tinyint(3) unsigned DEFAULT NULL,
  `order_` int(10) unsigned DEFAULT NULL,
  `group` smallint(5) unsigned DEFAULT NULL,
  `done` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8$$


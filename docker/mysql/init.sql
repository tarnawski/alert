DROP TABLE IF EXISTS `event_store`;

CREATE TABLE `event_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aggregate_id` varchar(60) NOT NULL,
  `type` varchar(60) NOT NULL,
  `data` TEXT,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `alert`;

CREATE TABLE `alert` (
  `id` varchar(60) NOT NULL,
  `type` varchar(16) NOT NULL,
  `status` varchar(32) NOT NULL,
  `latitude` varchar(60) NOT NULL,
  `longitude` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
);
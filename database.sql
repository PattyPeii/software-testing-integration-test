-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ACCOUNT`;
CREATE TABLE `ACCOUNT` (
  `no` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `pin` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `balance` int(10) NOT NULL,
  `waterCharge` int(10) NOT NULL,
  `electricCharge` int(10) NOT NULL,
  `phoneCharge` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 2020-11-12 14:40:55
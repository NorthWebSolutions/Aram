-- --------------------------------------------------------
-- Host:                         79.172.241.66
-- Server version:               5.6.22 - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Verzió:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for aramstats
CREATE DATABASE IF NOT EXISTS `aramstats` /*!40100 DEFAULT CHARACTER SET latin2 */;
USE `aramstats`;

-- Dumping structure for tábla aramstats.aram_data_table
DROP TABLE IF EXISTS `aram_data_table`;
CREATE TABLE IF NOT EXISTS `aram_data_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `summonerID` int(30) NOT NULL,
  `summonersTeam` int(5) NOT NULL,
  `gameID` int(30) NOT NULL,
  `gameMode` text NOT NULL,
  `gameIsWin` int(1) NOT NULL,
  `ipEarned` int(5) DEFAULT NULL,
  `totalDamage` int(10) DEFAULT NULL,
  `totalDamageTaken` int(10) DEFAULT NULL,
  `champion` text NOT NULL,
  `championArray` longtext NOT NULL,
  `statsArray` longtext NOT NULL,
  `fellowPlayersArray` longtext NOT NULL,
  `gameDate` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `summonerID` (`summonerID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for tábla aramstats.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `server` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` date DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `activation_code` varchar(500) DEFAULT NULL,
  `forgotten_password_code` varchar(500) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for tábla aramstats.user_settings
DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(10) NOT NULL,
  `server` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

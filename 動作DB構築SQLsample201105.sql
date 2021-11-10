-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- サーバのバージョン: 5.6.23-log
-- PHP のバージョン: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `sample201105`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `fav`
--

CREATE TABLE IF NOT EXISTS `fav` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`,`user_id`),
  UNIQUE KEY `item_id` (`item_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `fav`
--

INSERT INTO `fav` (`item_id`, `user_id`) VALUES
(1002, 123456),
(1003, 123456);

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `filepath` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `filepath`) VALUES
(1001, '腕時計1', 'ふつうの腕時計です', 10000, '1001.jpg'),
(1002, '腕時計2', 'かっこいい腕時計ですよ', 30000, '1002.jpg'),
(1003, '腕時計3', '手ごろな腕時計です', 5000, '1003.jpg'),
(1004, '腕時計4', 'かわいい腕時計です', 10000, '1004.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

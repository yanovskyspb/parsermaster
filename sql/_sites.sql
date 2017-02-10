-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 10 2017 г., 16:27
-- Версия сервера: 5.6.21
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `parser_master`
--

--
-- Дамп данных таблицы `!sites`
--

INSERT INTO `!sites` (`id`, `siteprefix`, `siteurl`, `parser`, `parser_loader`, `proxy`, `status`, `local`, `updated`, `updated2`) VALUES
(1, 'houzz', 'http://www.houzz.com', 'apist', 'apist', 'NO', '0', 'NO', '2015-01-26 22:43:54', '0000-00-00 00:00:00'),
(2, 'Digit', 'http://digit.ru', 'apist', 'apist', 'NO', '0', 'NO', '2014-11-15 17:35:26', '0000-00-00 00:00:00'),
(3, 'allmodern', 'https://www.allmodern.com', 'native', 'apist', 'YES', '1', 'NO', '2017-02-10 17:56:32', '0000-00-00 00:00:00'),
(4, 'onekingslane', 'https://www.onekingslane.com', 'native', 'native', 'NO', '1', 'YES', '2017-02-10 17:54:40', '2017-02-10 17:56:20'),
(5, 'allposters', 'http://www.allposters.com', 'apist', 'apist', 'NO', '0', 'NO', '2014-12-09 11:05:17', '0000-00-00 00:00:00'),
(6, 'fineartamerica', 'http://fineartamerica.com', 'apist', 'apist', 'NO', '0', 'NO', '2014-11-16 23:20:47', '0000-00-00 00:00:00'),
(7, 'jossandmain', 'https://www.jossandmain.com', 'native', 'native', 'NO', '1', 'YES', '2017-02-10 17:56:00', '2017-02-10 17:54:21'),
(8, 'playgoogle', 'https://play.google.com', 'native', 'apist', 'NO', '0', 'NO', '2014-12-09 11:05:39', '0000-00-00 00:00:00'),
(9, 'dayproject', 'http://www.dayproject.ru', 'apist', 'apist', 'NO', '0', 'NO', '2015-04-10 23:25:24', '0000-00-00 00:00:00'),
(10, 'cb2', 'http://www.cb2.com', 'apist', 'apist', 'NO', '1', 'NO', '2017-02-10 17:58:18', '0000-00-00 00:00:00'),
(11, 'crateandbarrel', 'http://www.crateandbarrel.com', 'apist', 'apist', 'NO', '1', 'NO', '2017-02-10 17:58:19', '0000-00-00 00:00:00'),
(12, 'karmaloop', 'http://www.karmaloop.com', 'apist', 'apist', 'NO', '1', 'NO', '2017-02-10 17:58:24', '0000-00-00 00:00:00'),
(13, 'ikea', 'http://www.ikea.com', 'apist', 'apist', 'NO', '0', 'NO', '2016-02-27 19:20:25', '0000-00-00 00:00:00'),
(14, 'shoptop', 'http://www.shoptop.ru', 'apist', 'apist', 'NO', '1', 'NO', '2017-02-10 17:58:26', '0000-00-00 00:00:00'),
(15, 'madein_en', 'http://www.madeindesign.co.uk', 'apist', 'native', 'NO', '1', 'NO', '2017-02-10 17:54:39', '2017-02-06 15:34:55');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

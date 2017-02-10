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

-- --------------------------------------------------------

--
-- Структура таблицы `!sites`
--

CREATE TABLE IF NOT EXISTS `!sites` (
`id` int(11) NOT NULL,
  `siteprefix` varchar(32) NOT NULL,
  `siteurl` varchar(32) NOT NULL,
  `parser` enum('apist','native') NOT NULL DEFAULT 'apist',
  `parser_loader` enum('apist','native') NOT NULL,
  `proxy` enum('NO','YES') NOT NULL DEFAULT 'NO',
  `status` enum('0','1') NOT NULL,
  `local` enum('NO','YES') NOT NULL DEFAULT 'NO',
  `updated` datetime NOT NULL,
  `updated2` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ikea2_items`
--

CREATE TABLE IF NOT EXISTS `ikea2_items` (
`id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `partNumber` varchar(25) NOT NULL,
  `partNumberDt` varchar(25) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `validDesign` varchar(255) NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `familyPrice` decimal(9,2) NOT NULL,
  `link` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `GoodToKnow` text NOT NULL,
  `CustBenefit` text NOT NULL,
  `CustMaterials` text NOT NULL,
  `Metric` text NOT NULL,
  `careInst` text NOT NULL,
  `Designer` varchar(255) NOT NULL,
  `quantity` int(5) NOT NULL,
  `nopackages` int(3) NOT NULL,
  `length` int(6) NOT NULL,
  `width` int(6) NOT NULL,
  `height` int(6) NOT NULL,
  `weight` int(6) NOT NULL,
  `breadCrumb` varchar(255) NOT NULL,
  `packagePopupUrl` varchar(255) NOT NULL,
  `manualsUrl` varchar(255) NOT NULL,
  `assembly_instructionUrl` varchar(255) NOT NULL,
  `json_string` text NOT NULL,
  `reparse` int(1) NOT NULL DEFAULT '0',
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26698 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `items_onekingslane`
--

CREATE TABLE IF NOT EXISTS `items_onekingslane` (
`id` int(11) NOT NULL,
  `site_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `local_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `local_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `description2` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `msrp` decimal(9,2) NOT NULL,
  `main_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `main_image_local` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `images` text COLLATE utf8_unicode_ci NOT NULL,
  `timestring` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=65844 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `links_allmodern`
--

CREATE TABLE IF NOT EXISTS `links_allmodern` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1','5') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=745477 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_allposters`
--

CREATE TABLE IF NOT EXISTS `links_allposters` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12616581 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_cb2`
--

CREATE TABLE IF NOT EXISTS `links_cb2` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1','5') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=845235 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_crateandbarrel`
--

CREATE TABLE IF NOT EXISTS `links_crateandbarrel` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1','5') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10691160 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_dayproject`
--

CREATE TABLE IF NOT EXISTS `links_dayproject` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4389723 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_fineartamerica`
--

CREATE TABLE IF NOT EXISTS `links_fineartamerica` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3190547 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_houzz`
--

CREATE TABLE IF NOT EXISTS `links_houzz` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1432 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_ikea`
--

CREATE TABLE IF NOT EXISTS `links_ikea` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1','5') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9024933 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_jossandmain`
--

CREATE TABLE IF NOT EXISTS `links_jossandmain` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1','5') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5401624 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_karmaloop`
--

CREATE TABLE IF NOT EXISTS `links_karmaloop` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1','5') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9132981 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблицы `links_madein_en`
--

CREATE TABLE IF NOT EXISTS `links_madein_en` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1','5') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=829430 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_onekingslane`
--

CREATE TABLE IF NOT EXISTS `links_onekingslane` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1','5') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17556255 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_playgoogle`
--

CREATE TABLE IF NOT EXISTS `links_playgoogle` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links_shoptop`
--

CREATE TABLE IF NOT EXISTS `links_shoptop` (
`id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `linktype` enum('0','1','2') NOT NULL DEFAULT '0',
  `prior` enum('0','1','5') NOT NULL,
  `parsed` enum('0','1','2') NOT NULL,
  `local_link` varchar(255) NOT NULL,
  `downloaded` enum('0','1') NOT NULL,
  `timestring` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24378 DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `!sites`
--
ALTER TABLE `!sites`
 ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ikea2_items`
--
ALTER TABLE `ikea2_items`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `partNumber` (`partNumber`);

--
-- Индексы таблицы `items_onekingslane`
--
ALTER TABLE `items_onekingslane`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`), ADD UNIQUE KEY `site_id` (`site_id`);

--
-- Индексы таблицы `links_allmodern`
--
ALTER TABLE `links_allmodern`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `link` (`link`);

--
-- Индексы таблицы `links_allposters`
--
ALTER TABLE `links_allposters`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `link` (`link`);

--
-- Индексы таблицы `links_cb2`
--
ALTER TABLE `links_cb2`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `url` (`link`);

--
-- Индексы таблицы `links_crateandbarrel`
--
ALTER TABLE `links_crateandbarrel`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `url` (`link`);

--
-- Индексы таблицы `links_dayproject`
--
ALTER TABLE `links_dayproject`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `link` (`link`);

--
-- Индексы таблицы `links_fineartamerica`
--
ALTER TABLE `links_fineartamerica`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `link` (`link`);

--
-- Индексы таблицы `links_houzz`
--
ALTER TABLE `links_houzz`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `link` (`link`);

--
-- Индексы таблицы `links_ikea`
--
ALTER TABLE `links_ikea`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `link` (`link`);

--
-- Индексы таблицы `links_jossandmain`
--
ALTER TABLE `links_jossandmain`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `url` (`link`);

--
-- Индексы таблицы `links_karmaloop`
--
ALTER TABLE `links_karmaloop`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `url` (`link`);

--
-- Индексы таблицы `links_madein_en`
--
ALTER TABLE `links_madein_en`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `url` (`link`);

--
-- Индексы таблицы `links_onekingslane`
--
ALTER TABLE `links_onekingslane`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `url` (`link`);

--
-- Индексы таблицы `links_playgoogle`
--
ALTER TABLE `links_playgoogle`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `url` (`link`);

--
-- Индексы таблицы `links_shoptop`
--
ALTER TABLE `links_shoptop`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `link` (`link`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `!sites`
--
ALTER TABLE `!sites`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `ikea2_items`
--
ALTER TABLE `ikea2_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26698;
--
-- AUTO_INCREMENT для таблицы `items_onekingslane`
--
ALTER TABLE `items_onekingslane`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65844;
--
-- AUTO_INCREMENT для таблицы `links_allmodern`
--
ALTER TABLE `links_allmodern`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=745477;
--
-- AUTO_INCREMENT для таблицы `links_allposters`
--
ALTER TABLE `links_allposters`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12616581;
--
-- AUTO_INCREMENT для таблицы `links_cb2`
--
ALTER TABLE `links_cb2`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=845235;
--
-- AUTO_INCREMENT для таблицы `links_crateandbarrel`
--
ALTER TABLE `links_crateandbarrel`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10691160;
--
-- AUTO_INCREMENT для таблицы `links_dayproject`
--
ALTER TABLE `links_dayproject`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4389723;
--
-- AUTO_INCREMENT для таблицы `links_fineartamerica`
--
ALTER TABLE `links_fineartamerica`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3190547;
--
-- AUTO_INCREMENT для таблицы `links_houzz`
--
ALTER TABLE `links_houzz`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1432;
--
-- AUTO_INCREMENT для таблицы `links_ikea`
--
ALTER TABLE `links_ikea`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9024933;
--
-- AUTO_INCREMENT для таблицы `links_jossandmain`
--
ALTER TABLE `links_jossandmain`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5401624;
--
-- AUTO_INCREMENT для таблицы `links_karmaloop`
--
ALTER TABLE `links_karmaloop`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9132981;
--
-- AUTO_INCREMENT для таблицы `links_madein_en`
--
ALTER TABLE `links_madein_en`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=829430;
--
-- AUTO_INCREMENT для таблицы `links_onekingslane`
--
ALTER TABLE `links_onekingslane`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17556255;
--
-- AUTO_INCREMENT для таблицы `links_playgoogle`
--
ALTER TABLE `links_playgoogle`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `links_shoptop`
--
ALTER TABLE `links_shoptop`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24378;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

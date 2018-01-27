-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Host: rdbms
-- Erstellungszeit: 20. Jan 2018 um 18:39
-- Server Version: 5.6.37-log
-- PHP-Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `DB3221600`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `creator` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`id`, `title`, `creator`) VALUES
(5, 'Gewürze', 13),
(6, 'Getränke', 12),
(7, 'Kühlwaren', 12);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL,
  `image` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pocketmoney`
--

CREATE TABLE IF NOT EXISTS `pocketmoney` (
`id` int(11) NOT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pocketmoney_month`
--

CREATE TABLE IF NOT EXISTS `pocketmoney_month` (
`id` int(11) NOT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `user` int(11) NOT NULL,
  `month` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE IF NOT EXISTS `products` (
`id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `creator` int(11) NOT NULL,
  `category` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `title`, `creator`, `category`) VALUES
(9, 'Salz', 13, 5),
(11, 'Bier', 12, 6),
(12, 'Eier', 12, 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE IF NOT EXISTS `role` (
`id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `role`
--

INSERT INTO `role` (`id`, `title`) VALUES
(1, 'Admin'),
(2, 'Einkäufer'),
(3, 'Einkaufsliste'),
(4, 'Aufgabenersteller'),
(5, 'Aufgabenerlediger'),
(6, 'Taschengeldempänger'),
(7, 'Taschengeldadministrator');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shoppinglist`
--

CREATE TABLE IF NOT EXISTS `shoppinglist` (
`id` int(11) NOT NULL,
  `purchaser` int(11) DEFAULT NULL,
  `product` int(11) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `shoppingdate` date DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `unit` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `shoppinglist`
--

INSERT INTO `shoppinglist` (`id`, `purchaser`, `product`, `price`, `shoppingdate`, `amount`, `unit`) VALUES
(7, 12, 9, NULL, '2018-01-13', 1, 5),
(10, 12, 12, NULL, '2018-01-13', 1, 7),
(16, NULL, 11, NULL, NULL, 1, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `task`
--

CREATE TABLE IF NOT EXISTS `task` (
`id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` tinytext,
  `creator` int(11) NOT NULL,
  `lastdo` date DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `standard` varchar(1) DEFAULT '1',
  `price` double DEFAULT '0',
  `active` varchar(1) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `task`
--

INSERT INTO `task` (`id`, `title`, `description`, `creator`, `lastdo`, `image`, `standard`, `price`, `active`) VALUES
(20, 'Hausaufgaben', 'Hausaufgaben erledigen am Wochenplan arbeiten', 12, '2018-01-13', NULL, '1', 0, '1'),
(21, 'Staubsaugen', 'Bitte ordentlich machen', 12, '2018-01-13', NULL, '1', 0, '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
`id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `unit`
--

INSERT INTO `unit` (`id`, `title`) VALUES
(5, 'Pck.'),
(6, 'Kasten'),
(7, 'Stück');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `firstname`, `name`, `birthday`, `email`, `password`, `username`) VALUES
(12, 'Mirko', 'Eberlein', '1979-06-01', 'mail@mirko-eberlein.de', '$2y$12$XD/IOyFXkHx8twgRHfeoIeVHu3T.iPvhrmr9sVG1dwCjmcbjnQAcy', 'meberlein'),
(13, 'Janet', 'Eberlein', '1984-02-15', 'mail@janet-eberlein.de', '$2y$12$VXpOaawmaIQglGGEzAjF7uArLLePmVdKLPrJTxCrRIhDEUBVQi396', 'janet'),
(14, 'Ilir', 'Fetai', '1980-01-01', 'ilir@test.ch', '$2y$12$yky/JlPV2DDbak26Q3zR9.uD6vb8zmDcMfDDMfYPdOJpiHUfaYbT2', 'ilir'),
(15, 'Arben', 'Sabani', '1881-10-12', 'arben.sabani@gmail.com', '$2y$12$Eiw2Bp/Fc9TXohxutMJWlO6Z..1mxPaGyKcC5muxlJxG.h9lD06Wi', 'asabani'),
(16, 'Simon', 'Eberlein', '2006-08-08', 'mail@simon-eberlein.com', '$2y$12$AK16UI7/NlFFAk5nh9TLxuzscHzZ.vQxJOy4OgZyFVX6TCdV4ntqC', 'simon'),
(17, 'Jasmin', 'Eberlein', '2004-10-25', 'mail@jasmin-eberlein.com', '$2y$12$SpminVnC5JWHuEMwQsgAYuY8ET6HfA5IcidDU.1wn07Koq8THFLTO', 'jasmin');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_do_task`
--

CREATE TABLE IF NOT EXISTS `user_do_task` (
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user_do_task`
--

INSERT INTO `user_do_task` (`user_id`, `task_id`, `date`) VALUES
(12, 20, '2018-01-13'),
(12, 21, '2018-01-13');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_has_role`
--

CREATE TABLE IF NOT EXISTS `user_has_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user_has_role`
--

INSERT INTO `user_has_role` (`user_id`, `role_id`) VALUES
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(12, 2),
(13, 2),
(14, 2),
(16, 2),
(17, 2),
(12, 3),
(13, 3),
(14, 3),
(16, 3),
(17, 3),
(12, 4),
(13, 4),
(14, 4),
(12, 5),
(13, 5),
(14, 5),
(16, 5),
(17, 5),
(12, 6),
(13, 6),
(14, 6),
(16, 6),
(17, 6),
(12, 7),
(13, 7),
(14, 7);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_category_user1_idx` (`creator`);

--
-- Indizes für die Tabelle `image`
--
ALTER TABLE `image`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pocketmoney`
--
ALTER TABLE `pocketmoney`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_pocketmoney_user1_idx` (`user`);

--
-- Indizes für die Tabelle `pocketmoney_month`
--
ALTER TABLE `pocketmoney_month`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_table1_user1_idx` (`user`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_products_user1_idx` (`creator`), ADD KEY `fk_products_category1_idx` (`category`);

--
-- Indizes für die Tabelle `role`
--
ALTER TABLE `role`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `shoppinglist`
--
ALTER TABLE `shoppinglist`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_shoppinglist_user1_idx` (`purchaser`), ADD KEY `fk_shoppinglist_products1_idx` (`product`), ADD KEY `fk_shoppinglist_unit1_idx` (`unit`);

--
-- Indizes für die Tabelle `task`
--
ALTER TABLE `task`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_issues_user1_idx` (`creator`), ADD KEY `fk_issues_image1_idx` (`image`);

--
-- Indizes für die Tabelle `unit`
--
ALTER TABLE `unit`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user_do_task`
--
ALTER TABLE `user_do_task`
 ADD PRIMARY KEY (`user_id`,`task_id`), ADD KEY `fk_user_has_task_task1_idx` (`task_id`), ADD KEY `fk_user_has_task_user1_idx` (`user_id`);

--
-- Indizes für die Tabelle `user_has_role`
--
ALTER TABLE `user_has_role`
 ADD PRIMARY KEY (`user_id`,`role_id`), ADD KEY `fk_user_has_role_role1_idx` (`role_id`), ADD KEY `fk_user_has_role_user_idx` (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `category`
--
ALTER TABLE `category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `pocketmoney`
--
ALTER TABLE `pocketmoney`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `pocketmoney_month`
--
ALTER TABLE `pocketmoney_month`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT für Tabelle `role`
--
ALTER TABLE `role`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `shoppinglist`
--
ALTER TABLE `shoppinglist`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT für Tabelle `task`
--
ALTER TABLE `task`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT für Tabelle `unit`
--
ALTER TABLE `unit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `category`
--
ALTER TABLE `category`
ADD CONSTRAINT `fk_category_user1` FOREIGN KEY (`creator`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `pocketmoney`
--
ALTER TABLE `pocketmoney`
ADD CONSTRAINT `fk_pocketmoney_user1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `pocketmoney_month`
--
ALTER TABLE `pocketmoney_month`
ADD CONSTRAINT `fk_table1_user1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `products`
--
ALTER TABLE `products`
ADD CONSTRAINT `fk_products_category1` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_products_user1` FOREIGN KEY (`creator`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `shoppinglist`
--
ALTER TABLE `shoppinglist`
ADD CONSTRAINT `fk_shoppinglist_products1` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_shoppinglist_unit1` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_shoppinglist_user1` FOREIGN KEY (`purchaser`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `task`
--
ALTER TABLE `task`
ADD CONSTRAINT `fk_issues_image1` FOREIGN KEY (`image`) REFERENCES `image` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_issues_user1` FOREIGN KEY (`creator`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `user_do_task`
--
ALTER TABLE `user_do_task`
ADD CONSTRAINT `fk_user_has_task_task1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_user_has_task_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `user_has_role`
--
ALTER TABLE `user_has_role`
ADD CONSTRAINT `fk_user_has_role_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_user_has_role_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Sob 21. kvě 2022, 22:24
-- Verze serveru: 10.3.22-MariaDB-log
-- Verze PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `jocv00`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `Flashcard`
--

CREATE TABLE `Flashcard` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `Topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `Note`
--

CREATE TABLE `Note` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `Topic`
--

CREATE TABLE `Topic` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `archived` tinyint(1) NOT NULL,
  `User_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `Topic_Note`
--

CREATE TABLE `Topic_Note` (
  `Topic_id` int(11) NOT NULL,
  `Note_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `User_app`
--

CREATE TABLE `User_app` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `facebook_id` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `Flashcard`
--
ALTER TABLE `Flashcard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Flashcard_Topic` (`Topic_id`);

--
-- Klíče pro tabulku `Note`
--
ALTER TABLE `Note`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `Topic`
--
ALTER TABLE `Topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_2_User` (`User_id`);

--
-- Klíče pro tabulku `Topic_Note`
--
ALTER TABLE `Topic_Note`
  ADD PRIMARY KEY (`Topic_id`,`Note_id`),
  ADD KEY `Topic_Note_Note` (`Note_id`);

--
-- Klíče pro tabulku `User_app`
--
ALTER TABLE `User_app`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facebook_id` (`facebook_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `Flashcard`
--
ALTER TABLE `Flashcard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pro tabulku `Note`
--
ALTER TABLE `Note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pro tabulku `Topic`
--
ALTER TABLE `Topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pro tabulku `User_app`
--
ALTER TABLE `User_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `Flashcard`
--
ALTER TABLE `Flashcard`
  ADD CONSTRAINT `Flashcard_Topic` FOREIGN KEY (`Topic_id`) REFERENCES `Topic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `Topic`
--
ALTER TABLE `Topic`
  ADD CONSTRAINT `entity_2_User` FOREIGN KEY (`User_id`) REFERENCES `User_app` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `Topic_Note`
--
ALTER TABLE `Topic_Note`
  ADD CONSTRAINT `Topic_Note_Note` FOREIGN KEY (`Note_id`) REFERENCES `Note` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Topic_Note_Topic` FOREIGN KEY (`Topic_id`) REFERENCES `Topic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

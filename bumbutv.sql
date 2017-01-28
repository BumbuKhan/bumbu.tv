-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 29 2017 г., 02:15
-- Версия сервера: 5.5.48
-- Версия PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bumbutv`
--

-- --------------------------------------------------------

--
-- Структура таблицы `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) unsigned NOT NULL,
  `type` enum('movie','series','episode','ted','cartoon') NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `poster_small` varchar(40) NOT NULL,
  `poster_big` varchar(40) NOT NULL,
  `duration` int(3) NOT NULL,
  `src` varchar(255) NOT NULL,
  `trailer` varchar(255) NOT NULL,
  `ted_original` varchar(255) NOT NULL,
  `subtitle` varchar(40) NOT NULL,
  `series_episode_shot` varchar(40) NOT NULL,
  `series_poster_left` varchar(40) NOT NULL,
  `series_poster_right` varchar(40) NOT NULL,
  `series_poster_gradient_start` varchar(7) NOT NULL,
  `series_poster_gradient_end` varchar(7) NOT NULL,
  `issue_date` date NOT NULL,
  `add_datetime` datetime NOT NULL,
  `view_amount` int(11) NOT NULL DEFAULT '0',
  `is_blocked` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `series_episode_rel`
--

CREATE TABLE IF NOT EXISTS `series_episode_rel` (
  `id` int(11) unsigned NOT NULL,
  `movie_id` int(11) unsigned NOT NULL COMMENT 'ID of movie that episode belongs to',
  `season` int(2) unsigned NOT NULL COMMENT 'Index number of season',
  `episode` int(2) NOT NULL COMMENT 'Index number of episode',
  `episode_id` int(11) unsigned NOT NULL COMMENT 'ID of movie(episode)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_3` (`id`);

--
-- Индексы таблицы `series_episode_rel`
--
ALTER TABLE `series_episode_rel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `movie_id_3` (`movie_id`,`episode_id`),
  ADD KEY `movie_id` (`movie_id`,`episode_id`),
  ADD KEY `movie_id_2` (`movie_id`),
  ADD KEY `episode_id` (`episode_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `series_episode_rel`
--
ALTER TABLE `series_episode_rel`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

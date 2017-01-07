-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 07 2017 г., 17:22
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
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(3) NOT NULL,
  `title` varchar(60) NOT NULL,
  `add_datetime` datetime NOT NULL,
  `is_blocked` enum('0','1') NOT NULL DEFAULT '0',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `add_datetime` datetime NOT NULL,
  `is_blocked` enum('0','1') NOT NULL DEFAULT '0',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `poster_small` varchar(100) NOT NULL COMMENT 'Main poster for the movie',
  `poster_big` varchar(100) NOT NULL COMMENT 'Background poster with blur effect',
  `episode_shot` varchar(100) NOT NULL COMMENT 'For series only, showing on ''series_view'' page',
  `poster_left` varchar(100) NOT NULL COMMENT 'For series only, showing on main page',
  `poster_middle` varchar(100) NOT NULL COMMENT 'For series only, showing on main page',
  `poster_right` varchar(100) NOT NULL COMMENT 'For series only, showing on main page',
  `gradient_start_color` varchar(7) NOT NULL COMMENT 'For series only, showing on main page',
  `gradient_end_color` varchar(7) NOT NULL COMMENT 'For series only, showing on main page',
  `type` enum('movie','series','cartoon','ted','episode') NOT NULL,
  `level` enum('beginner','elementary','pre-intermediate','intermediate','upper-intermediate','advanced','proficient') NOT NULL,
  `duration` varchar(8) NOT NULL,
  `issue_date` date NOT NULL,
  `src` varchar(255) NOT NULL COMMENT 'Movie itself, video file',
  `trailer_src` varchar(255) NOT NULL COMMENT 'Youtube link to the trailer',
  `ted_original` varchar(255) NOT NULL COMMENT 'Link to the original TED film',
  `subtitle` varchar(255) NOT NULL,
  `add_datetime` datetime NOT NULL,
  `view_amount` int(11) NOT NULL,
  `is_blocked` enum('0','1') NOT NULL DEFAULT '0',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `movie_country_rel`
--

CREATE TABLE IF NOT EXISTS `movie_country_rel` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `movie_genre_rel`
--

CREATE TABLE IF NOT EXISTS `movie_genre_rel` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
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
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `movie_country_rel`
--
ALTER TABLE `movie_country_rel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `movie_id_2` (`movie_id`,`country_id`);

--
-- Индексы таблицы `movie_genre_rel`
--
ALTER TABLE `movie_genre_rel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `genre_id` (`genre_id`);

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
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `movie_country_rel`
--
ALTER TABLE `movie_country_rel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `movie_genre_rel`
--
ALTER TABLE `movie_genre_rel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `movie_country_rel`
--
ALTER TABLE `movie_country_rel`
  ADD CONSTRAINT `movie_country_rel_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `movie_country_rel_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Ограничения внешнего ключа таблицы `movie_genre_rel`
--
ALTER TABLE `movie_genre_rel`
  ADD CONSTRAINT `movie_genre_rel_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`),
  ADD CONSTRAINT `movie_genre_rel_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

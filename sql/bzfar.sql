-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 21 2021 г., 20:32
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bzfar`
--
CREATE DATABASE IF NOT EXISTS `bzfar` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `bzfar`;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) UNSIGNED NOT NULL,
  `topic_id` int(11) UNSIGNED DEFAULT NULL,
  `files` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `moderated` tinyint(1) UNSIGNED DEFAULT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `moderated_by` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `topic_id`, `files`, `date`, `moderated`, `created_by`, `moderated_by`) VALUES
(1, 3, 'uploads/Machine learning.pptx', '2020-10-12 12:28:58', 1, 1, 1),
(2, 4, 'uploads/Television.docx', '2020-10-12 12:36:30', 1, 3, 1),
(3, 1, 'uploads/bzfar.sql', '2020-11-12 10:07:56', 1, 4, 1),
(4, 1, 'uploads/bzfar (3).sql', '2020-11-12 10:13:18', 1, 4, 4),
(5, 1, 'uploads/2-топ.pptx', '2020-11-15 16:33:31', 1, 4, 4),
(6, 1, 'uploads/Fazyl\'s course work (1) (2).docx', '2020-11-15 18:13:27', 0, 4, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

DROP TABLE IF EXISTS `materials`;
CREATE TABLE `materials` (
  `id` int(11) UNSIGNED NOT NULL,
  `topic` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `topic`) VALUES
(1, 'AI'),
(2, 'Deep Learning'),
(3, 'Machine learning'),
(4, 'Television');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `sender_id` int(11) UNSIGNED DEFAULT NULL,
  `receiver_id` int(11) UNSIGNED DEFAULT NULL,
  `message_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dateandtime` datetime DEFAULT NULL,
  `is_readed` tinyint(1) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message_text`, `dateandtime`, `is_readed`) VALUES
(1, 1, 3, 'Привет', '2020-10-12 12:03:39', 1),
(2, 3, 1, 'Привет', '2020-10-12 12:17:37', 1),
(3, 4, 1, 'Привет', '2020-11-12 10:09:50', 1),
(4, 4, 1, 'афывафыва', '2020-11-12 10:11:44', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` int(11) UNSIGNED DEFAULT NULL,
  `moderator` tinyint(1) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `firstname`, `surname`, `password`, `grade`, `moderator`) VALUES
(1, 'fazil.el2003@gmail.com', 'Еламан', 'Фазыл', '$2y$10$.anfkyZmcaY1MXxD.8Ba3eAqTey/U50lqXAfzX4vAx0zSvrUR5Zma', 12, 1),
(2, 'bzfar07@gmail.com', 'Boris', 'Zelenov', '$2y$10$y.8qAl3lMhrG9YGPVB2eEunDdDmVHpTleNpuFcxm9vsQeLeP/8To2', 12, 0),
(3, 'sultanidcze@gmail.com', 'Sultan', 'Ishangaliyev', '$2y$10$ImaWSKHzEDL8rz8GUx2EOOOTNobezfT/dB0.SHHz.k072z4ehCBvy', 12, 0),
(4, 'tbfan07@gmail.com', 'Alikhan', 'Amangali', '$2y$10$aHmuKzDg/AvWrSXGDg1Vm.11t9D4CzRxjqU1brD1KU4S5d7QlNs66', 12, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_files_topic` (`topic_id`),
  ADD KEY `moderated_by` (`moderated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_messages_sender` (`sender_id`),
  ADD KEY `index_foreignkey_messages_receiver` (`receiver_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`moderated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `files_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

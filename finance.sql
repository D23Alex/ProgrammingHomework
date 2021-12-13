-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 13 2021 г., 14:11
-- Версия сервера: 10.4.21-MariaDB
-- Версия PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `finance`
--
CREATE DATABASE IF NOT EXISTS `finance` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `finance`;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `slug` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Разное', 'other'),
(2, 'Еда', 'food'),
(3, 'Развлечения', 'entertainment'),
(4, 'Здоровье', 'health');

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `price` float NOT NULL,
  `title` tinytext NOT NULL,
  `description` text NOT NULL,
  `amount` float DEFAULT NULL,
  `price_per_one` float DEFAULT NULL,
  `measure` varchar(12) NOT NULL,
  `category` int(10) UNSIGNED NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `uploaded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `price`, `title`, `description`, `amount`, `price_per_one`, `measure`, `category`, `user`, `uploaded`) VALUES
(1, 205, 'Поход в кино', 'Кинотеатр в центре', NULL, NULL, '', 3, 3, '2019-08-07 09:38:41'),
(3, 60, 'Яблоки', '', 3, 20, 'шт', 2, 3, '2019-09-09 09:43:51'),
(4, 5000, 'Стоматология', 'Поставил пломбу. Дорого...', NULL, NULL, '', 4, 2, '2019-09-06 09:50:01'),
(5, 100, 'Сникерс', 'супер!', 2, 50, 'ед.', 2, 3, '2019-09-09 09:51:37'),
(6, 300, 'Кое-что', 'не скажу - секрет', NULL, NULL, '', 1, 1, '2019-09-06 09:55:46'),
(7, 220, 'Обед в столовой ИТМО', 'Комплексный обед. Пюре - реальное, котлета - мнимая.', NULL, NULL, '', 2, 2, '2019-10-06 09:58:40'),
(8, 200, 'Горшок для цветов', 'качество 12/10', 0, 0, 'ед.', 1, 3, '2019-07-26 10:00:01'),
(14, 500, 'Розы', '', 5, 100, 'шт', 1, 3, '2019-09-06 10:00:01'),
(24, 900, 'Поход в театр', 'на Петроградке', 0, 0, 'ед.', 3, 3, '2019-08-09 08:43:55'),
(25, 1000, 'Стул', 'Норм вещь', 1, 1000, 'шт.', 1, 3, '2019-06-05 09:43:42');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(127) NOT NULL,
  `name1` varchar(30) NOT NULL,
  `name2` varchar(30) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `emailme` tinyint(1) NOT NULL DEFAULT 1,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `name1`, `name2`, `active`, `emailme`, `admin`) VALUES
(1, 'admin', '$2y$10$o7eldsElXpDT.f44VsjkQOv7K8YGtEbp6e/GEfVFqTpi1v/vOtqkO', '', '', '', 1, 1, 1),
(2, 'basil', '$2y$10$ju5YtuAI0gK83Iq79Vi/vuUq0mgc2lu56vLGnfMEwwiVBUoKa8/DS', '', '', '', 1, 1, 0),
(3, 'jocker', '$2y$10$azYrgZJkKyDIiUSmyomcyuyt9lQxJl..QDFpPUFFSW2QE/YSLjAse', 'throwaway@gmail.com', 'Алексей', 'Дорморезов', 1, 1, 0),
(4, 'tester', '$2y$10$JG1AZyH3tQ0HGQ.MZbqOQO/t2G8WaCDOu37RvuG4TtbYU3edW2gkO', 'throwaway@gmail.com', '', '', 1, 1, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded` (`uploaded`),
  ADD KEY `category` (`category`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

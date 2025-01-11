-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 12 2025 г., 02:49
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Products`
--

CREATE TABLE `Products` (
  `ID` int NOT NULL,
  `PRODUCT_ID` varchar(50) NOT NULL,
  `PRODUCT_NAME` varchar(255) NOT NULL,
  `PRODUCT_PRICE` decimal(10,2) NOT NULL,
  `PRODUCT_ARTICLE` int NOT NULL,
  `PRODUCT_QUANTITY` int NOT NULL,
  `DATE_CREATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `hidden` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Products`
--

INSERT INTO `Products` (`ID`, `PRODUCT_ID`, `PRODUCT_NAME`, `PRODUCT_PRICE`, `PRODUCT_ARTICLE`, `PRODUCT_QUANTITY`, `DATE_CREATE`, `hidden`) VALUES
(1, 'NH1001', 'Sony WH-1000XM5', '349.99', 1001, 5, '2024-01-05 11:30:00', 0),
(2, 'NH1002', 'Bose QuietComfort 45', '329.99', 1002, 16, '2023-12-21 05:10:00', 0),
(3, 'NH1003', 'Apple AirPods Pro 2', '249.99', 1003, 30, '2023-11-15 09:45:00', 0),
(4, 'NH1004', 'Sennheiser Momentum 4', '379.99', 1004, 33, '2023-10-03 13:25:00', 0),
(5, 'NH1005', 'JBL Club One', '299.99', 1005, 30, '2023-09-22 08:15:00', 0),
(6, 'NH1006', 'Audio-Technica ATH-M50x', '169.99', 1006, 16, '2023-08-17 07:00:00', 0),
(7, 'NH1007', 'Beats Studio 3 Wireless', '349.99', 1007, 25, '2023-07-29 15:35:00', 0),
(8, 'NH1008', 'Bang & Olufsen Beoplay H95', '799.99', 1008, 15, '2023-06-13 11:50:00', 0),
(9, 'NH1009', 'Shure AONIC 50', '399.99', 1009, 7, '2023-05-22 06:20:00', 0),
(10, 'NH1010', 'Sony WF-1000XM4', '279.99', 1010, 55, '2023-04-17 14:40:00', 0),
(11, 'NH1011', 'Bose Noise Cancelling Headphones 700', '379.99', 1011, 20, '2023-03-30 09:30:00', 0),
(12, 'NH1012', 'Jabra Elite 85h', '249.99', 1012, 47, '2023-02-10 11:05:00', 0),
(13, 'NH1013', 'Sennheiser PXC 550-II', '299.99', 1013, 30, '2023-01-25 13:20:00', 0),
(14, 'NH1014', 'AKG N700NC M2', '349.99', 1014, 50, '2022-12-05 10:15:00', 0),
(15, 'NH1015', 'Marshall Monitor II ANC', '329.99', 1015, 25, '2022-11-18 08:00:00', 0),
(16, 'NH1016', 'JBL Live 660NC', '199.99', 1016, 54, '2022-10-11 12:00:00', 0),
(17, 'NH1017', 'Sony XB900N', '249.99', 1017, 45, '2022-09-24 07:30:00', 0),
(18, 'NH1018', 'Beats Solo Pro', '299.99', 1018, 50, '2022-08-13 16:00:00', 0),
(19, 'NH1019', 'Bang & Olufsen Beoplay H9 3rd Gen', '499.99', 1019, 30, '2022-07-04 06:45:00', 0),
(20, 'NH1020', 'JBL Quantum One', '229.99', 1020, 48, '2022-06-25 09:15:00', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `PRODUCT_ID` (`PRODUCT_ID`),
  ADD UNIQUE KEY `PRODUCT_ARTICLE` (`PRODUCT_ARTICLE`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Products`
--
ALTER TABLE `Products`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

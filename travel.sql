-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 
-- 伺服器版本： 8.0.17
-- PHP 版本： 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `travel`
--

-- --------------------------------------------------------

--
-- 資料表結構 `account`
--

CREATE TABLE `account` (
  `address` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `account`
--

INSERT INTO `account` (`address`, `username`, `password`, `email`) VALUES
('101', '101', '101', '101@gmail.com'),
('111', '111', '111', '111@gmail.com'),
('123', '123', '123', '123@gmail.com'),
('222', '222', '222', '222@gmail.com'),
('321', '321', '321', '321@gmail.com'),
('555', '555', '555', '555@gmail.com'),
('888', '8887', '888', '888@gmail.com'),
('8887', '8888', '8888', '8888@gmail.com'),
('chiwen', '鄭棨文', 'chiwen', 'chiwen@gmail.com'),
('Group12', 'Group12', 'Group12', 'Group12@gmail.com'),
('SA', 'SA', 'SA', 'SA@gmail.com');

-- --------------------------------------------------------

--
-- 資料表結構 `arrangement`
--

CREATE TABLE `arrangement` (
  `arrange_id` bigint(20) NOT NULL,
  `journey_id` bigint(20) DEFAULT NULL,
  `location_id` bigint(20) DEFAULT NULL,
  `arr_date` date DEFAULT NULL,
  `arr_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `arrangement`
--

INSERT INTO `arrangement` (`arrange_id`, `journey_id`, `location_id`, `arr_date`, `arr_time`) VALUES
(5, 3, 2, '2024-04-25', '02:23:00'),
(8, 4, 2, '2024-04-25', '23:10:00'),
(9, 4, 2, '2024-04-24', '13:07:00'),
(13, 3, 1, '2024-04-24', '01:30:00'),
(14, 6, 4, '2024-04-25', '01:48:00'),
(15, 6, 3, '2024-04-24', '02:48:00'),
(16, 6, 1, '2024-04-26', '01:48:00'),
(17, 3, 1, '2024-04-25', '01:36:00'),
(18, 5, 2, '2024-04-25', '22:07:00'),
(19, 20, 3, '2024-05-10', '12:05:00'),
(20, 20, 2, '2024-05-11', '23:04:00');

-- --------------------------------------------------------

--
-- 資料表結構 `budget`
--

CREATE TABLE `budget` (
  `budget_id` bigint(20) NOT NULL,
  `journey_id` bigint(20) DEFAULT NULL,
  `bud_cate` varchar(100) DEFAULT NULL,
  `bud_amount` decimal(10,2) DEFAULT NULL,
  `bud_note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `budget`
--

INSERT INTO `budget` (`budget_id`, `journey_id`, `bud_cate`, `bud_amount`, `bud_note`) VALUES
(1, 3, '食物', '321.00', '321'),
(2, 3, '食物', '123.00', '123'),
(3, 5, '食物', '100.00', '123'),
(6, 9, '消費', '1000.00', '1000'),
(8, 21, '交通', '1000.00', '高鐵'),
(9, 21, '食物', '10000.00', '米其林'),
(10, 21, '消費', '1000.00', '紀念品'),
(11, 21, '娛樂', '1500.00', '門票');

-- --------------------------------------------------------

--
-- 資料表結構 `cashflow`
--

CREATE TABLE `cashflow` (
  `cashflow_id` bigint(20) NOT NULL,
  `journey_id` bigint(20) DEFAULT NULL,
  `from_address` varchar(100) DEFAULT NULL,
  `to_address` varchar(100) DEFAULT NULL,
  `cashflow_date` date DEFAULT NULL,
  `cashflow_amount` decimal(10,2) DEFAULT NULL,
  `cashflow_note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `cashflow`
--

INSERT INTO `cashflow` (`cashflow_id`, `journey_id`, `from_address`, `to_address`, `cashflow_date`, `cashflow_amount`, `cashflow_note`) VALUES
(1, 3, '123', '321', '2024-05-10', '321.00', NULL),
(2, 3, '123', '321', '2024-05-03', '333.00', NULL),
(3, 3, '123', '123', '2024-05-03', '321.00', '321'),
(5, 5, '101', '鄭棨文', '2024-05-05', '100.00', '100'),
(6, 5, '鄭棨文', '123', '2024-05-05', '321.00', '321'),
(8, 5, 'chiwen', '101', '2024-05-05', '101.00', '100'),
(9, 5, '101', 'chiwen', '2024-05-05', '300.00', '300'),
(10, 9, 'chiwen', '123', '2024-05-07', '100.00', '100'),
(11, 21, '123', 'chiwen', '2024-05-08', '1000.00', '借錢'),
(12, 21, 'chiwen', '123', '2024-05-11', '1000.00', '還錢'),
(13, 21, 'chiwen', '123', '2024-05-08', '3000.00', '借錢'),
(15, 21, 'chiwen', '123', '2024-05-08', '1000.00', '還錢'),
(16, 21, 'chiwen', '321', '2024-05-09', '1000.00', 'borrow');

-- --------------------------------------------------------

--
-- 資料表結構 `cost`
--

CREATE TABLE `cost` (
  `cost_id` bigint(20) NOT NULL,
  `journey_id` bigint(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `cost_cate` varchar(10) DEFAULT NULL,
  `cost_date` date DEFAULT NULL,
  `cost_amount` decimal(10,2) DEFAULT NULL,
  `cost_note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `cost`
--

INSERT INTO `cost` (`cost_id`, `journey_id`, `address`, `cost_cate`, `cost_date`, `cost_amount`, `cost_note`) VALUES
(1, 3, '123', '0', '2024-05-04', '312.00', '123'),
(2, 3, '123', '食物', '2024-05-04', '123.00', '321'),
(3, 3, '123', '食物', '2024-05-10', '321.00', '321'),
(4, 3, '123', '娛樂', '2024-05-16', '123.00', '123'),
(5, 3, '123', '其他', '2024-05-18', '321.00', '333333'),
(6, 3, '123', '食物', '2024-05-03', '321.00', '123'),
(8, 5, '123', '食物', '2024-05-05', '123.00', '123'),
(9, 5, '123', '交通', '2024-05-05', '123.00', '123'),
(10, 5, '123', '住宿', '2024-05-05', '123.00', '123'),
(11, 5, '123', '其他', '2024-05-05', '111.00', '111'),
(13, 5, 'chiwen', '消費', '2024-05-06', '1000.00', '1000'),
(14, 9, '123', '消費', '2024-05-07', '10000.00', 'Gucci'),
(16, 21, '123', '消費', '2024-05-08', '1000.00', '紀念品'),
(17, 21, '123', '娛樂', '2024-05-08', '1500.00', '門票'),
(18, 24, '123', '交通', '2024-05-08', '1000.00', '123'),
(19, 25, '123', '食物', '2024-05-08', '123.00', '123'),
(20, 21, 'chiwen', '消費', '2024-05-08', '1000.00', '紀念品');

-- --------------------------------------------------------

--
-- 資料表結構 `friends`
--

CREATE TABLE `friends` (
  `my_address` varchar(255) NOT NULL,
  `fri_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `friends`
--

INSERT INTO `friends` (`my_address`, `fri_address`) VALUES
('123', '101'),
('123', '321'),
('123', '555'),
('888', '321'),
('chiwen', '123'),
('SA', '123');

-- --------------------------------------------------------

--
-- 資料表結構 `journey`
--

CREATE TABLE `journey` (
  `journey_id` bigint(20) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `journey_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `journey`
--

INSERT INTO `journey` (`journey_id`, `start_date`, `end_date`, `journey_name`) VALUES
(1, '2024-04-04', '2024-04-19', ''),
(2, '2024-04-22', '2024-04-26', ''),
(3, '2024-04-22', '2024-04-30', 'TA'),
(4, '2024-04-24', '2024-04-27', '旅行'),
(21, '2024-05-08', '2024-05-11', 'SA sprint2'),
(25, '2024-05-09', '2024-05-11', '團隊開支only');

-- --------------------------------------------------------

--
-- 資料表結構 `journey_members`
--

CREATE TABLE `journey_members` (
  `journey_id` bigint(20) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `journey_members`
--

INSERT INTO `journey_members` (`journey_id`, `address`) VALUES
(3, '555'),
(4, '321'),
(4, '888'),
(5, '101'),
(5, '123'),
(5, '321'),
(5, 'chiwen'),
(6, '123'),
(6, 'SA'),
(7, '101'),
(7, '123'),
(7, '321'),
(7, '555'),
(8, '101'),
(8, '123'),
(8, '321'),
(8, '555'),
(8, 'chiwen'),
(8, 'SA'),
(9, '123'),
(9, '321'),
(9, '555'),
(9, 'chiwen'),
(10, '123'),
(11, '123'),
(12, '101'),
(12, '123'),
(12, '321'),
(13, '101'),
(13, '123'),
(14, '101'),
(14, '123'),
(15, '123'),
(15, 'chiwen'),
(16, '123'),
(16, 'chiwen'),
(17, '123'),
(17, 'chiwen'),
(18, '123'),
(18, 'chiwen'),
(19, '123'),
(19, 'chiwen'),
(20, '123'),
(20, 'chiwen'),
(21, '123'),
(21, '321'),
(21, 'chiwen'),
(22, '123'),
(22, 'chiwen'),
(23, '123'),
(23, 'chiwen'),
(24, '123'),
(24, 'chiwen'),
(25, '123'),
(25, '321'),
(25, '555'),
(25, 'chiwen');

-- --------------------------------------------------------

--
-- 資料表結構 `location`
--

CREATE TABLE `location` (
  `location_id` bigint(20) NOT NULL,
  `loca_name` varchar(50) DEFAULT NULL,
  `loca_address` varchar(100) DEFAULT NULL,
  `loca_url` text,
  `loca_info` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `location`
--

INSERT INTO `location` (`location_id`, `loca_name`, `loca_address`, `loca_url`, `loca_info`) VALUES
(1, '台北101', '110台灣台北市信義區信義路五段7號', NULL, NULL),
(2, '台北國際會議中心(TICC)', '110台灣台北市信義區信義路五段1號', 'https://www.google.com.tw/maps/place/%E5%8F%B0%E5%8C%97%E5%9C%8B%E9%9A%9B%E6%9C%83%E8%AD%B0%E4%B8%AD%E5%BF%83(TICC)/@25.0339759,121.559668,17z/data=!4m15!1m8!3m7!1s0x3442abb6da9c9e1f:0x1206bcf082fd10a6!2zVGFpcGVpIDEwMSwgTm8uIDfkv6Hnvqnot6_kupTmrrXkv6HnvqnljYDlj7DljJfluIIxMTA!3b1!8m2!3d25.033976!4d121.5645389!16zL20vMDFjeTZ5!3m5!1s0x3442abb61ab3d33f:0xab0d0f7ac395bff4!8m2!3d25.0335122!4d121.5608913!16s%2Fm%2F0x2b64g?entry=ttu', NULL),
(3, '輔仁大學', '242台灣新北市新莊區中正路510號', 'https://www.google.com.tw/maps/place/%E5%A4%A9%E4%B8%BB%E6%95%99%E8%BC%94%E4%BB%81%E5%A4%A7%E5%AD%B8/@25.0363219,121.43008,17z/data=!3m2!4b1!5s0x3442a7e86859e3b7:0x6b49b417d91172ff!4m6!3m5!1s0x3442a7dd8be91eaf:0xe342a67d6574f896!8m2!3d25.0363219!4d121.4326549!16zL20vMDN0ajFj?entry=ttu', NULL),
(4, '中正紀念堂', '100台灣台北市中正區愛國東路110巷24號', 'https://www.google.com.tw/maps/place/%E5%9C%8B%E7%AB%8B%E4%B8%AD%E6%AD%A3%E7%B4%80%E5%BF%B5%E5%A0%82/@25.035502,121.5176083,17z/data=!3m1!4b1!4m6!3m5!1s0x3442a99db9a2a94d:0x43e9034292df69b2!8m2!3d25.035502!4d121.5201832!16zL20vMDJyZ2Nw?hl=zh-TW&entry=ttu', NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `note`
--

CREATE TABLE `note` (
  `note_id` bigint(20) NOT NULL,
  `journey_id` bigint(20) DEFAULT NULL,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `note`
--

INSERT INTO `note` (`note_id`, `journey_id`, `content`) VALUES
(1, NULL, ''),
(2, NULL, ''),
(3, NULL, ''),
(4, NULL, ''),
(5, NULL, ''),
(6, NULL, ''),
(8, 5, '簽證'),
(9, 8, '簽證2'),
(10, 13, 'New Note'),
(11, 21, '早八12'),
(12, 25, 'New Note123');

-- --------------------------------------------------------

--
-- 資料表結構 `split`
--

CREATE TABLE `split` (
  `split_id` bigint(20) NOT NULL,
  `journey_id` bigint(20) DEFAULT NULL,
  `split_cate` varchar(10) DEFAULT NULL,
  `split_date` date DEFAULT NULL,
  `split_payer` varchar(100) DEFAULT NULL,
  `split_note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `split`
--

INSERT INTO `split` (`split_id`, `journey_id`, `split_cate`, `split_date`, `split_payer`, `split_note`) VALUES
(10, 5, '食物', '2024-05-04', '321', '12333'),
(24, 5, '食物', '2024-05-05', '101', '123'),
(26, 5, '交通', '2024-05-05', '123', '3334'),
(28, 5, '食物', '2024-05-06', 'chiwen', 'taxi'),
(29, 5, '交通', '2024-05-06', '123', 'TAXI'),
(30, 9, '交通', '2024-05-07', '123', '餐廳'),
(31, 21, '食物', '2024-05-08', '123', '餐廳'),
(32, 21, '住宿', '2024-05-07', '123', '5/11住宿'),
(33, 21, '食物', '2024-05-09', '123', 'eat'),
(34, 21, '食物', '2024-05-09', '123', 'eat'),
(35, 21, '食物', '2024-05-09', '321', 'eat'),
(36, 25, '食物', '2024-05-09', '123', 'eat'),
(37, 25, '食物', '2024-05-09', '123', 'eat'),
(38, 21, '食物', '2024-05-09', '123', '1'),
(39, 25, '食物', '2024-05-09', '123', '2'),
(40, 25, '食物', '2024-05-09', '123', 'eat'),
(41, 25, '食物', '2024-05-09', '123', '3');

-- --------------------------------------------------------

--
-- 資料表結構 `split_members`
--

CREATE TABLE `split_members` (
  `split_id` bigint(20) NOT NULL,
  `journey_id` bigint(20) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `split_amount` decimal(10,2) DEFAULT NULL,
  `pay_state` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 傾印資料表的資料 `split_members`
--

INSERT INTO `split_members` (`split_id`, `journey_id`, `address`, `split_amount`, `pay_state`) VALUES
(24, 5, '101', '100.00', 0),
(24, 5, '123', '41.00', 1),
(24, 5, '321', '41.00', 0),
(25, 5, '101', '107.00', 0),
(25, 5, '123', '107.00', 0),
(25, 5, '321', '107.00', 0),
(26, 5, '101', '111.00', 0),
(26, 5, '123', '111.00', 0),
(26, 5, '321', '111.00', 0),
(28, 5, '101', '100.00', 0),
(28, 5, '123', '100.00', 0),
(28, 5, '321', '100.00', 0),
(28, 5, 'chiwen', '100.00', 0),
(29, 5, '101', '200.00', 0),
(29, 5, '123', '200.00', 0),
(29, 5, '321', '200.00', 0),
(29, 5, 'chiwen', '200.00', 0),
(30, 9, '123', '250.00', 0),
(30, 9, '321', '250.00', 0),
(30, 9, '555', '250.00', 0),
(30, 9, 'chiwen', '250.00', 0),
(31, 21, '123', '500.00', 0),
(31, 21, 'chiwen', '500.00', 0),
(32, 21, '123', '2500.00', 0),
(32, 21, 'chiwen', '2500.00', 1),
(33, 21, '123', '100.00', 0),
(33, 21, '321', '100.00', 0),
(33, 21, 'chiwen', '100.00', 1),
(34, 21, '123', '100.00', 0),
(34, 21, '321', '200.00', 0),
(34, 21, '鄭棨文', '300.00', 0),
(35, 21, '123', '100.00', 0),
(35, 21, '321', '100.00', 0),
(35, 21, '鄭棨文', '300.00', 0),
(36, 25, '123', '300.00', 0),
(36, 25, '321', '400.00', 0),
(36, 25, '555', '500.00', 0),
(36, 25, '鄭棨文', '600.00', 0),
(37, 25, '', '300.00', 0),
(38, 21, '123', '300.00', 0),
(38, 21, '321', '400.00', 0),
(38, 21, 'chiwen', '500.00', 0),
(39, 25, '123', '100.00', 0),
(39, 25, '321', '100.00', 0),
(39, 25, '555', '100.00', 0),
(39, 25, 'chiwen', '100.00', 0),
(40, 25, '123', '300.00', 0),
(40, 25, '321', '400.00', 0),
(40, 25, '555', '500.00', 0),
(40, 25, 'chiwen', '600.00', 0),
(41, 25, '123', '300.00', 0),
(41, 25, '555', '50.00', 0),
(41, 25, 'chiwen', '50.00', 0);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`address`);

--
-- 資料表索引 `arrangement`
--
ALTER TABLE `arrangement`
  ADD PRIMARY KEY (`arrange_id`);

--
-- 資料表索引 `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`budget_id`);

--
-- 資料表索引 `cashflow`
--
ALTER TABLE `cashflow`
  ADD PRIMARY KEY (`cashflow_id`);

--
-- 資料表索引 `cost`
--
ALTER TABLE `cost`
  ADD PRIMARY KEY (`cost_id`);

--
-- 資料表索引 `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`my_address`,`fri_address`);

--
-- 資料表索引 `journey`
--
ALTER TABLE `journey`
  ADD PRIMARY KEY (`journey_id`);

--
-- 資料表索引 `journey_members`
--
ALTER TABLE `journey_members`
  ADD PRIMARY KEY (`journey_id`,`address`);

--
-- 資料表索引 `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- 資料表索引 `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`note_id`);

--
-- 資料表索引 `split`
--
ALTER TABLE `split`
  ADD PRIMARY KEY (`split_id`);

--
-- 資料表索引 `split_members`
--
ALTER TABLE `split_members`
  ADD PRIMARY KEY (`split_id`,`address`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `arrangement`
--
ALTER TABLE `arrangement`
  MODIFY `arrange_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `budget`
--
ALTER TABLE `budget`
  MODIFY `budget_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `cashflow`
--
ALTER TABLE `cashflow`
  MODIFY `cashflow_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `cost`
--
ALTER TABLE `cost`
  MODIFY `cost_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `journey`
--
ALTER TABLE `journey`
  MODIFY `journey_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `location`
--
ALTER TABLE `location`
  MODIFY `location_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `note`
--
ALTER TABLE `note`
  MODIFY `note_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `split`
--
ALTER TABLE `split`
  MODIFY `split_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `split_members`
--
ALTER TABLE `split_members`
  MODIFY `split_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

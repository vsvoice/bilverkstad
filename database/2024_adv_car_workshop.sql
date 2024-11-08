-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 08 nov 2024 kl 10:21
-- Serverversion: 10.4.32-MariaDB
-- PHP-version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `2024_adv_car_workshop`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `table_cars`
--

CREATE TABLE `table_cars` (
  `car_id` int(11) NOT NULL,
  `car_brand` varchar(255) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `car_license` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumpning av Data i tabell `table_cars`
--

INSERT INTO `table_cars` (`car_id`, `car_brand`, `car_model`, `car_license`) VALUES
(1, 'Toyota', 'Carolla', 'ABC-123'),
(2, 'Honda', 'Civic', 'BCD-234'),
(4, 'Ford', 'Focus', 'DFG-456'),
(5, 'Test', 'Bil', '123-HJK');

-- --------------------------------------------------------

--
-- Tabellstruktur `table_customers`
--

CREATE TABLE `table_customers` (
  `customer_id` int(11) NOT NULL,
  `customer_fname` varchar(255) NOT NULL,
  `customer_lname` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_zip` varchar(255) NOT NULL,
  `customer_area` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumpning av Data i tabell `table_customers`
--

INSERT INTO `table_customers` (`customer_id`, `customer_fname`, `customer_lname`, `customer_phone`, `customer_email`, `customer_address`, `customer_zip`, `customer_area`) VALUES
(1, 'Erik', 'Blomqvist', '1234567890', 'erik.blomqvist@axxell.fi', '', '', ''),
(2, 'Juke', 'Box', '0450987610', 'jukebox@hotmail.com', 'Streetname 5', '', ''),
(3, 'Peter', 'Griffin', '4567890123', 'PeterGriffin@hotmail.com', '', '', ''),
(4, 'Elorik', 'Glamkuist', '1234567890', 'elorik@dum.com', 'Streetname 87', '12345', 'Espoo'),
(5, 'Nygge', 'Kunde', '12345789997', 'nygge.kunde@hotmail.com', 'Gatandärborta 4', '12340', 'Din mamma');

-- --------------------------------------------------------

--
-- Tabellstruktur `table_hours`
--

CREATE TABLE `table_hours` (
  `h_id` int(11) NOT NULL,
  `p_id_fk` int(11) NOT NULL,
  `u_id_fk` int(11) NOT NULL,
  `h_amount` int(11) NOT NULL,
  `h_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumpning av Data i tabell `table_hours`
--

INSERT INTO `table_hours` (`h_id`, `p_id_fk`, `u_id_fk`, `h_amount`, `h_date`) VALUES
(1, 1, 7, 8, '2024-10-22'),
(2, 1, 7, 2, '2024-10-21'),
(3, 2, 8, 3, '2024-10-29'),
(4, 2, 8, 4, '2024-10-28'),
(5, 2, 8, 5, '2024-10-25'),
(6, 2, 10, 7, '2024-10-28'),
(7, 2, 10, 8, '2024-10-29'),
(8, 1, 13, 5, '2024-11-05'),
(9, 5, 12, 1, '2024-11-05'),
(10, 1, 12, 10, '2024-11-05'),
(11, 1, 12, 10, '2024-11-05'),
(12, 1, 13, 2, '2024-11-06');

-- --------------------------------------------------------

--
-- Tabellstruktur `table_products`
--

CREATE TABLE `table_products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `invoice_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumpning av Data i tabell `table_products`
--

INSERT INTO `table_products` (`product_id`, `name`, `price`, `invoice_number`) VALUES
(2, 'Mutter', 2.90, '14256890987654321'),
(4, 'Mutter3', 2.79, '14256890945678908'),
(5, 'Mutter4', 2.89, '1425689098765098'),
(6, 'Mutter', 0.50, '1425689098765098'),
(7, 'Mutter', 0.50, '1425689098765091'),
(8, 'Mutter', 0.50, '14256890987654321'),
(9, 'Mutter', 0.50, '14256890987654321'),
(10, 'Skruv', 1.00, '12356890'),
(11, 'Spik', 5.00, '1425678987643'),
(12, 'Lång spik', 6.00, '167876432'),
(13, 'Kort spik', 7.00, '765413223647'),
(14, 'Mutter', 0.70, '14256890987654321'),
(16, 'test', 0.00, 'e23454'),
(17, 'test', 0.00, 'e23454'),
(19, 'Tester', 2.40, '12345678'),
(20, 'Mutter', 2.00, '123456'),
(21, 'Liten mutter', 1.00, '12345678'),
(22, 'Mutter', 2.00, '123567'),
(23, 'Skruv', 2.00, '134667'),
(24, 'Skruv', 1.00, '1234567');

-- --------------------------------------------------------

--
-- Tabellstruktur `table_projects`
--

CREATE TABLE `table_projects` (
  `project_id` int(11) NOT NULL,
  `customer_id_fk` int(11) NOT NULL,
  `car_id_fk` int(11) NOT NULL,
  `defect_desc` text NOT NULL,
  `work_desc` text NOT NULL,
  `status_id_fk` int(11) NOT NULL,
  `creation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumpning av Data i tabell `table_projects`
--

INSERT INTO `table_projects` (`project_id`, `customer_id_fk`, `car_id_fk`, `defect_desc`, `work_desc`, `status_id_fk`, `creation_date`) VALUES
(1, 3, 1, 'Testing again 2', 'Edit test1 2', 7, '2024-11-05'),
(2, 2, 1, 'test', 'test1', 5, '2024-11-05'),
(3, 2, 1, 'trefsdvf', 'bgbdsd', 4, '2024-11-05'),
(5, 3, 1, 'Testar', 'testar', 2, '2024-10-15'),
(6, 2, 5, 'trefsdvf', 'bgbdsd', 1, '2024-11-05'),
(8, 2, 1, '', '', 1, '2024-11-05'),
(11, 1, 1, 'fwf', 'fy4w', 1, '2024-11-05'),
(12, 2, 1, '', '', 1, '2024-11-05'),
(16, 3, 2, 'sadfghdjhggfqdwe saefhe', '', 1, '2024-11-05'),
(17, 3, 2, 'ty.lg,nbfeW5U7', '', 1, '2024-11-05'),
(18, 2, 1, 'yftuhdbg', 'adwefsgrfad', 1, '2024-11-05'),
(19, 5, 4, 'Hjulet är snett.', 'Drivaxeln ska ersättas.', 1, NULL),
(20, 4, 4, 'Handbromsen fungerar inte.', 'Undersöka vad problemet är.', 1, NULL),
(21, 5, 4, 'Skrotbil', 'Skrotas', 2, NULL),
(22, 3, 2, 'Testar en felbeskrivning! (Vi får se hur det går!)', 'Testar en arbetsbeskrivning! (Vi får se hur det går!)', 1, NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur `table_project_product`
--

CREATE TABLE `table_project_product` (
  `project_id_fk` int(11) NOT NULL,
  `product_id_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumpning av Data i tabell `table_project_product`
--

INSERT INTO `table_project_product` (`project_id_fk`, `product_id_fk`) VALUES
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 16),
(1, 17),
(1, 19),
(5, 22),
(5, 23),
(6, 20),
(6, 21),
(6, 24);

-- --------------------------------------------------------

--
-- Tabellstruktur `table_roles`
--

CREATE TABLE `table_roles` (
  `r_id` int(11) NOT NULL,
  `r_name` varchar(255) NOT NULL,
  `r_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumpning av Data i tabell `table_roles`
--

INSERT INTO `table_roles` (`r_id`, `r_name`, `r_level`) VALUES
(1, 'Mekaniker', 10),
(2, 'Fakturerare', 50),
(3, 'Administratör', 200),
(4, 'Gäst', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `table_statuses`
--

CREATE TABLE `table_statuses` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumpning av Data i tabell `table_statuses`
--

INSERT INTO `table_statuses` (`s_id`, `s_name`) VALUES
(1, 'I kö'),
(2, 'Pågående'),
(3, 'Pausat'),
(4, 'Avbokat'),
(5, 'Klart för fakturering'),
(6, 'Fakturerat'),
(7, 'Betalt');

-- --------------------------------------------------------

--
-- Tabellstruktur `table_users`
--

CREATE TABLE `table_users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_password` varchar(512) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_role_fk` int(11) NOT NULL,
  `u_fname` varchar(255) NOT NULL,
  `u_lname` varchar(255) NOT NULL,
  `u_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumpning av Data i tabell `table_users`
--

INSERT INTO `table_users` (`u_id`, `u_name`, `u_password`, `u_email`, `u_role_fk`, `u_fname`, `u_lname`, `u_status`) VALUES
(7, 'Bossman', '$2y$10$TlJ0XuL.AT2h.aK/KdbS8O6xXowsj5vltQwy.InfdgbYitL5Z9Cu.', 'bossman@gmail.com', 3, 'Bossi', 'Manninen', 1),
(8, 'mechanic1', '$2y$10$AGYChnNscS3zbTacwkGTAewQ5PrbJ9hvMzwAUQwf2Gi7qeUERet9i', 'mechanic1@gmail.com', 1, 'Juissi', 'Mehulainen', 1),
(10, 'mechanic2', '$2y$10$DIBW13D4nkR5HWLlelR.peUGWkXevZtrlQBWb4rT1BqbzLAM98Mk.', 'mechanic2@gmail.com', 1, 'Ärsyttävä', 'Appelsiini', 1),
(11, 'Mechanic3', '$2y$10$t9SZoO7c.7P5x2nghHLvV.A0mj/fIE0LtyhijLyv0NjKK0G/N6xlO', 'mechanic3@gmail.com', 1, 'Byggare', 'Bob', 1),
(12, 'Mechanic4', '$2y$10$c2.xH9/T2vqC/CQzUMXKSuvuH2zrq3GcoCP2x153Ysfx6H.t3xrEO', 'mechanic4@gmail.com', 1, 'Wreck-It', 'Ralph', 0),
(13, 'bossmannen', '$2y$10$GW7byae3DcLkYnwKPbuZVOcvEtVr8osvVAXHtRwKY2XRWTGS4lY/u', 'bossman2@gmail.com', 3, 'Bossi', 'Manninen', 1),
(14, 'accountant2', '$2y$10$tlrp7Q1hFgyjCW42DO85aen.Se/2dlNhSkzRjvBTCEFYlYX9O24LO', 'akku@money.com', 2, 'Akku', 'Kanttu', 1),
(15, 'testuser', '$2y$10$Nb/NjweZmGB6kdg7WFot/.aM/b3CE9rDaiS7GCZZyy0JX8h4RRAYe', 'test2@user.com', 1, 'Testa', 'Mig', 1);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `table_cars`
--
ALTER TABLE `table_cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Index för tabell `table_customers`
--
ALTER TABLE `table_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Index för tabell `table_hours`
--
ALTER TABLE `table_hours`
  ADD PRIMARY KEY (`h_id`),
  ADD KEY `p_id_fk` (`p_id_fk`,`u_id_fk`),
  ADD KEY `u_id_fk` (`u_id_fk`);

--
-- Index för tabell `table_products`
--
ALTER TABLE `table_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Index för tabell `table_projects`
--
ALTER TABLE `table_projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `customer_id_fk` (`customer_id_fk`,`car_id_fk`),
  ADD KEY `status_id_fk` (`status_id_fk`),
  ADD KEY `car_id_fk` (`car_id_fk`);

--
-- Index för tabell `table_project_product`
--
ALTER TABLE `table_project_product`
  ADD KEY `project_id_fk` (`project_id_fk`,`product_id_fk`),
  ADD KEY `product_id_fk` (`product_id_fk`);

--
-- Index för tabell `table_roles`
--
ALTER TABLE `table_roles`
  ADD PRIMARY KEY (`r_id`);

--
-- Index för tabell `table_statuses`
--
ALTER TABLE `table_statuses`
  ADD PRIMARY KEY (`s_id`);

--
-- Index för tabell `table_users`
--
ALTER TABLE `table_users`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `u_role_fk` (`u_role_fk`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `table_cars`
--
ALTER TABLE `table_cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `table_customers`
--
ALTER TABLE `table_customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `table_hours`
--
ALTER TABLE `table_hours`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT för tabell `table_products`
--
ALTER TABLE `table_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT för tabell `table_projects`
--
ALTER TABLE `table_projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT för tabell `table_roles`
--
ALTER TABLE `table_roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `table_statuses`
--
ALTER TABLE `table_statuses`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `table_users`
--
ALTER TABLE `table_users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `table_hours`
--
ALTER TABLE `table_hours`
  ADD CONSTRAINT `table_hours_ibfk_1` FOREIGN KEY (`p_id_fk`) REFERENCES `table_projects` (`project_id`),
  ADD CONSTRAINT `table_hours_ibfk_2` FOREIGN KEY (`u_id_fk`) REFERENCES `table_users` (`u_id`);

--
-- Restriktioner för tabell `table_projects`
--
ALTER TABLE `table_projects`
  ADD CONSTRAINT `table_projects_ibfk_1` FOREIGN KEY (`customer_id_fk`) REFERENCES `table_customers` (`customer_id`),
  ADD CONSTRAINT `table_projects_ibfk_2` FOREIGN KEY (`car_id_fk`) REFERENCES `table_cars` (`car_id`),
  ADD CONSTRAINT `table_projects_ibfk_3` FOREIGN KEY (`status_id_fk`) REFERENCES `table_statuses` (`s_id`);

--
-- Restriktioner för tabell `table_project_product`
--
ALTER TABLE `table_project_product`
  ADD CONSTRAINT `table_project_product_ibfk_1` FOREIGN KEY (`project_id_fk`) REFERENCES `table_projects` (`project_id`),
  ADD CONSTRAINT `table_project_product_ibfk_2` FOREIGN KEY (`product_id_fk`) REFERENCES `table_products` (`product_id`);

--
-- Restriktioner för tabell `table_users`
--
ALTER TABLE `table_users`
  ADD CONSTRAINT `table_users_ibfk_1` FOREIGN KEY (`u_role_fk`) REFERENCES `table_roles` (`r_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

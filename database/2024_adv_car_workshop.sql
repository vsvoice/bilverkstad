-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 31 maj 2024 kl 09:48
-- Serverversion: 10.4.28-MariaDB
-- PHP-version: 8.2.4

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `customer_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `table_products`
--

CREATE TABLE `table_products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `invoice_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `status_id_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `table_project_product`
--

CREATE TABLE `table_project_product` (
  `project_id_fk` int(11) NOT NULL,
  `product_id_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `table_roles`
--

CREATE TABLE `table_roles` (
  `r_id` int(11) NOT NULL,
  `r_name` varchar(255) NOT NULL,
  `r_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `table_roles`
--

INSERT INTO `table_roles` (`r_id`, `r_name`, `r_level`) VALUES
(1, 'User', 10),
(2, 'Moderator', 50),
(3, 'Admin', 200),
(4, 'Guest', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `table_statuses`
--

CREATE TABLE `table_statuses` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `table_users`
--

INSERT INTO `table_users` (`u_id`, `u_name`, `u_password`, `u_email`, `u_role_fk`, `u_fname`, `u_lname`, `u_status`) VALUES
(7, 'Bossman', '$2y$10$PV3JZ0emg9wOCvQCMswpg.6tnyk5VKCwDZKxWQ.MLKlyxZa2lL0TG', 'bossman@gmail.com', 3, '', '', 1),
(8, 'mechanic1', '$2y$10$AGYChnNscS3zbTacwkGTAewQ5PrbJ9hvMzwAUQwf2Gi7qeUERet9i', 'mechanic1@gmail.com', 1, '', '', 1);

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
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `table_customers`
--
ALTER TABLE `table_customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `table_hours`
--
ALTER TABLE `table_hours`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `table_products`
--
ALTER TABLE `table_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `table_projects`
--
ALTER TABLE `table_projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `table_roles`
--
ALTER TABLE `table_roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `table_statuses`
--
ALTER TABLE `table_statuses`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `table_users`
--
ALTER TABLE `table_users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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

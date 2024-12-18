-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2024 at 08:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transport_smartcity`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `IdCity` int NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`IdCity`, `Name`) VALUES
(1, 'Liège'),
(2, 'Mons'),
(3, 'Namur'),
(4, 'Louvière'),
(5, 'Nimy'),
(6, 'Obourg'),
(7, 'Bruxelle'),
(8, 'Bruge');

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE `parking` (
  `IdParking` int NOT NULL,
  `AvailablePlaces` int NOT NULL,
  `TotalPlace` int NOT NULL,
  `StateUp` tinyint(1) NOT NULL,
  `Connectivity` tinyint(1) NOT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`IdParking`, `AvailablePlaces`, `TotalPlace`, `StateUp`, `Connectivity`, `Location`) VALUES
(1, 120, 125, 1, 1, 'Mons Grand Place, Belgique'),
(2, 200, 243, 1, 1, 'Bruxelle Petite Place, Belgique ');

-- --------------------------------------------------------

--
-- Table structure for table `road`
--

CREATE TABLE `road` (
  `IdRoad` int NOT NULL,
  `Affluence` int NOT NULL,
  `StateUp` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sensorparking`
--

CREATE TABLE `sensorparking` (
  `Ipv4` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `StateUp` tinyint(1) NOT NULL,
  `DateAdded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trafficlight`
--

CREATE TABLE `trafficlight` (
  `IdTrafficLight` int NOT NULL,
  `StateUp` tinyint(1) NOT NULL,
  `Affluence` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `LicensePlate` varchar(200) NOT NULL,
  `Owner` varchar(200) NOT NULL,
  `Park` varchar(200) NOT NULL,
  `Location` varchar(200) NOT NULL,
  `Type` tinyint(1) NOT NULL,
  `Priority` tinyint(1) NOT NULL,
  `AvailablePlaces` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`IdCity`);

--
-- Indexes for table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`IdParking`);

--
-- Indexes for table `road`
--
ALTER TABLE `road`
  ADD PRIMARY KEY (`IdRoad`);

--
-- Indexes for table `trafficlight`
--
ALTER TABLE `trafficlight`
  ADD PRIMARY KEY (`IdTrafficLight`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`LicensePlate`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `IdCity` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `parking`
--
ALTER TABLE `parking`
  MODIFY `IdParking` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `road`
--
ALTER TABLE `road`
  MODIFY `IdRoad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trafficlight`
--
ALTER TABLE `trafficlight`
  MODIFY `IdTrafficLight` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

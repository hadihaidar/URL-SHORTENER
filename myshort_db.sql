-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 19, 2019 at 01:59 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myshort_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ipaddress`
--

CREATE TABLE `ipaddress` (
  `id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `short` varchar(5) NOT NULL,
  `browser` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `link`
--

CREATE TABLE `link` (
  `original` varchar(1000) NOT NULL,
  `new` varchar(1000) NOT NULL,
  `email` varchar(500) NOT NULL,
  `apikey` varchar(32) NOT NULL,
  `clicks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `link`
--

INSERT INTO `link` (`original`, `new`, `email`, `apikey`, `clicks`) VALUES
('http://alphakor.com', '5p9b0', 'design@alphakor.com', '5b7385f02b535326463fcc40ac1af78e', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `first` varchar(100) NOT NULL,
  `last` varchar(100) NOT NULL,
  `Email` varchar(500) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `apikey` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`first`, `last`, `Email`, `password`, `apikey`) VALUES
('Sathish', 'Subramanian', 'design@alphakor.com', '2833c2a126329b5558a9797abd8d72d5', '5b7385f02b535326463fcc40ac1af78e'),
('Hadi', 'test', 'hadi@gmail.com', '25f9e794323b453885f5181f1b624d0b', '36e87da838a987e4750c28240223e702'),
('Hadi', 'Haidar', 'hadihaidar.6.hh@gmail.com', '25f9e794323b453885f5181f1b624d0b', '73317caaa0726cc00caf471e83d84421'),
('Mohamad', 'Houdeib ', 'mohamadhoudeib@hotmail.com', 'efaf9c9dd105fc65dd7050792212cd48', '802dff425f69dc3a685ac7467dee43db'),
('Night Club', 'Service', 'nightclubservice@alphakor.com', 'de0446511adcaecc47512be6d0e96c2c', '40d374a4d09194d758926a2a1f563e56'),
('test', 'test', 'test@test.com', '25f9e794323b453885f5181f1b624d0b', '166a463edbd1c5a17d2b97dbc0031d83');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ipaddress`
--
ALTER TABLE `ipaddress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`new`,`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Email`),
  ADD UNIQUE KEY `apikey` (`apikey`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ipaddress`
--
ALTER TABLE `ipaddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

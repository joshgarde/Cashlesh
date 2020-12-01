-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2020 at 05:32 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

CREATE DATABASE IF NOT EXISTS cashless;
USE cashless;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cashless`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `balance` int(11) NOT NULL,
  `interestRate` int(11) DEFAULT NULL,
  `minimumBalance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountID`, `name`, `balance`, `interestRate`, `minimumBalance`) VALUES
(12345, 'Money Laundering Co.', 99099000, 0, NULL),
(77701, 'Quibi Holdings, LLC', 900100, NULL, 100),
(98765, 'SpaceCoin ICO', 21000, NULL, 100);

-- --------------------------------------------------------

--
-- Table structure for table `accountholders`
--

CREATE TABLE `accountholders` (
  `customerID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accountholders`
--

INSERT INTO `accountholders` (`customerID`, `accountID`) VALUES
(1, 12345),
(1, 98765),
(2, 77701),
(2, 12345);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerId` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `email`, `password`) VALUES
(1, 'joshgarde@gmail.com', 'password'),
(2, 'tomdickerson@cashless.io', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transactionID` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  `fromAccountID` int(11) DEFAULT NULL,
  `toAccountID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transactionID`, `amount`, `timestamp`, `type`, `fromAccountID`, `toAccountID`) VALUES
(18, 100000000, '2020-11-02 09:25:30', 'Cash Deposit', NULL, 12345),
(19, 1000000000, '2020-03-04 13:21:18', 'Cash Deposit', NULL, 77701),
(20, 999999900, '2020-10-20 09:22:24', 'Cash Withdrawal', 77701, NULL),
(21, 20000, '2020-07-06 16:40:16', 'Cash Deposit', NULL, 98765),
(24, 1000, '2020-12-01 01:45:37', 'Transfer', 12345, 98765),
(25, 900000, '2020-12-01 01:46:29', 'Transfer', 12345, 77701);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transactionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98767;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

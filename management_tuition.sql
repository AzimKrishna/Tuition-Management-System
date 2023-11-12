-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 03:05 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `management_tuition`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `ubid` int(11) NOT NULL,
  `bid` varchar(10) NOT NULL,
  `pamt` varchar(10) NOT NULL,
  `sid` int(11) NOT NULL,
  `scid` int(50) NOT NULL,
  `due` date NOT NULL,
  `complete` int(11) NOT NULL,
  `note` varchar(100) NOT NULL,
  `ramt` varchar(10) NOT NULL,
  `psrc` varchar(30) NOT NULL,
  `ptxnid` varchar(30) NOT NULL,
  `pdate` date NOT NULL,
  `bsent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `rid` int(11) NOT NULL,
  `scid` int(20) NOT NULL,
  `sid` int(20) NOT NULL,
  `scstatus` varchar(35) NOT NULL,
  `cancby` varchar(10) NOT NULL,
  `cReason` varchar(120) NOT NULL,
  `AcSTime` time NOT NULL,
  `AcFTime` time NOT NULL,
  `LDuration` int(10) NOT NULL,
  `LDurReason` varchar(120) NOT NULL,
  `takenTopic` varchar(50) NOT NULL,
  `nextTopic` varchar(50) NOT NULL,
  `HWork` varchar(20) NOT NULL,
  `hwNote` varchar(50) NOT NULL,
  `schMark` varchar(15) NOT NULL,
  `wbMark` varchar(15) NOT NULL,
  `pvtComment` varchar(120) NOT NULL,
  `parentComm` varchar(120) NOT NULL,
  `pubComment` varchar(120) NOT NULL,
  `scdate` date NOT NULL,
  `billed` tinyint(1) NOT NULL,
  `psent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scid` int(11) NOT NULL,
  `sid` int(50) NOT NULL,
  `scdate` date NOT NULL,
  `sctime` time NOT NULL,
  `scstatus` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `std_info`
--

CREATE TABLE `std_info` (
  `sid` int(11) NOT NULL,
  `sname` text NOT NULL,
  `course` varchar(25) NOT NULL,
  `smail` varchar(40) NOT NULL DEFAULT 'conronald13@gmail.com',
  `spno` varchar(15) NOT NULL,
  `skype` varchar(35) NOT NULL,
  `pname` text NOT NULL,
  `pmail` varchar(40) NOT NULL,
  `ppno` varchar(15) NOT NULL,
  `tzone` varchar(30) NOT NULL,
  `ctry` text NOT NULL,
  `fee` varchar(5) NOT NULL,
  `doj` date NOT NULL,
  `note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `txn`
--

CREATE TABLE `txn` (
  `pid` int(11) NOT NULL,
  `pamt` varchar(10) NOT NULL,
  `psrc` varchar(30) NOT NULL,
  `ptxnid` varchar(30) NOT NULL,
  `pdate` date NOT NULL,
  `sid` int(11) NOT NULL,
  `psent` int(5) NOT NULL DEFAULT 0,
  `scid` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`ubid`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scid`);

--
-- Indexes for table `std_info`
--
ALTER TABLE `std_info`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `txn`
--
ALTER TABLE `txn`
  ADD PRIMARY KEY (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `ubid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `std_info`
--
ALTER TABLE `std_info`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `txn`
--
ALTER TABLE `txn`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

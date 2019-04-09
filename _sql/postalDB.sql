-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 09, 2019 at 05:44 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `postaldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `FName` varchar(20) NOT NULL,
  `MInit` varchar(2) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `Email` varchar(55) NOT NULL,
  `State` varchar(15) NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Street` varchar(35) NOT NULL,
  `ApartmentNo` int(5) DEFAULT NULL,
  PRIMARY KEY (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`FName`, `MInit`, `LName`, `Email`, `State`, `City`, `ZIP`, `Street`, `ApartmentNo`) VALUES
('Cooper', 'M', 'Freman', 'cooper@hotmail.com', 'FL', 'Man', 22011, 'notFree Ln', NULL),
('Cosmo', 'M', 'Aut', 'cosmo@gmail.com', 'WA', 'Katy', 20001, '222 Space Valley', NULL),
('John', 'O', 'Doe', 'john.doe@gmail.com', 'TX', 'Houston', 77023, '1412 Richmond Avenue', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customercredentials`
--

DROP TABLE IF EXISTS `customercredentials`;
CREATE TABLE IF NOT EXISTS `customercredentials` (
  `Email` varchar(55) NOT NULL,
  `Password` varchar(32) DEFAULT NULL,
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customercredentials`
--

INSERT INTO `customercredentials` (`Email`, `Password`) VALUES
('cooper@hotmail.com', 'cd21b93cfd8d6824dc2bce1a19decaf7'),
('cosmo@gmail.com', '32a8bd4d676f4fef0920c7da8db2bad7');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `EmployeeID` int(7) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(20) NOT NULL,
  `MiddleName` varchar(2) DEFAULT NULL,
  `LastName` varchar(20) NOT NULL,
  `EmploymentDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserRole` int(3) DEFAULT NULL,
  `OfficeID` varchar(17) NOT NULL,
  PRIMARY KEY (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=1000003 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmployeeID`, `FirstName`, `MiddleName`, `LastName`, `EmploymentDate`, `UserRole`, `OfficeID`) VALUES
(1000000, 'John', 'M', 'Doe', '2019-04-07 02:18:21', NULL, 'HOU002'),
(1000001, 'Mo', 'M', 'Mo', '2019-04-07 22:57:14', NULL, 'HOU002'),
(1000002, 'Norm', 'M', 'Norm', '2019-04-08 11:43:23', NULL, 'HOU002');

-- --------------------------------------------------------

--
-- Table structure for table `employeecredentials`
--

DROP TABLE IF EXISTS `employeecredentials`;
CREATE TABLE IF NOT EXISTS `employeecredentials` (
  `EmployeeID` int(7) NOT NULL,
  `Password` varchar(32) NOT NULL,
  UNIQUE KEY `EmployeeID` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employeecredentials`
--

INSERT INTO `employeecredentials` (`EmployeeID`, `Password`) VALUES
(1000000, '8d307b07b9b59d479d0db9be3fa1a2b0'),
(1000001, '81dc9bdb52d04dc20036dbd8313ed055'),
(1000002, '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

DROP TABLE IF EXISTS `office`;
CREATE TABLE IF NOT EXISTS `office` (
  `OfficeID` varchar(17) NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Address` varchar(40) NOT NULL,
  PRIMARY KEY (`ZIP`),
  UNIQUE KEY `VehicleID` (`OfficeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

DROP TABLE IF EXISTS `package`;
CREATE TABLE IF NOT EXISTS `package` (
  `PackageID` int(10) NOT NULL AUTO_INCREMENT,
  `RecipientName` varchar(30) NOT NULL,
  `Email` varchar(55) NOT NULL,
  `Weight` decimal(5,2) NOT NULL,
  `Length` decimal(5,2) NOT NULL,
  `Width` decimal(5,2) DEFAULT NULL,
  `Height` decimal(5,2) NOT NULL,
  `State` varchar(15) NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Street` varchar(35) NOT NULL,
  `ApartmentNo` int(5) DEFAULT NULL,
  `isFragile` tinyint(1) NOT NULL,
  `send_date` date NOT NULL,
  `Priority` int(1) NOT NULL,
  `Status` int(1) NOT NULL,
  PRIMARY KEY (`PackageID`),
  KEY `Package_ibfk_1` (`Status`),
  KEY `Package_ibfk_2` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`PackageID`, `RecipientName`, `Email`, `Weight`, `Length`, `Width`, `Height`, `State`, `City`, `ZIP`, `Street`, `ApartmentNo`, `isFragile`, `send_date`, `Priority`, `Status`) VALUES
(1, 'HANNAH MILLS', 'john.doe@gmail.com', '5.00', '5.00', '5.00', '5.00', 'TX', 'Houston', 77057, '7787 Blue St', NULL, 1, '2019-03-05', 1, 6),
(2, 'MIKE FUR', 'john.doe@gmail.com', '5.00', '5.00', '5.00', '5.00', 'TX', 'Houston', 77057, '8882 Green St', NULL, 1, '2019-03-09', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

DROP TABLE IF EXISTS `shift`;
CREATE TABLE IF NOT EXISTS `shift` (
  `EmployeeID` int(7) NOT NULL,
  `Clock_in_Date` date NOT NULL,
  `Clock_in_Time` time(6) NOT NULL,
  `Clock_out_Time` time(6) NOT NULL,
  `Hours_Worked` decimal(4,2) NOT NULL,
  UNIQUE KEY `EmployeeID` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `Code` int(1) NOT NULL AUTO_INCREMENT,
  `Status` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`Code`, `Status`) VALUES
(1, 'Processed'),
(2, 'In Transit'),
(3, 'Pick Up'),
(4, 'Delivered'),
(5, 'Expired'),
(6, 'Alert');

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

DROP TABLE IF EXISTS `tracking`;
CREATE TABLE IF NOT EXISTS `tracking` (
  `Tracking_Index` int(18) NOT NULL AUTO_INCREMENT,
  `Package_ID` int(10) NOT NULL,
  `TrackingNote` varchar(40) NOT NULL,
  `Update_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Tracking_Index`),
  UNIQUE KEY `Tracking_Index` (`Tracking_Index`),
  KEY `Tracking_ibfk_1` (`Package_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracking`
--

INSERT INTO `tracking` (`Tracking_Index`, `Package_ID`, `TrackingNote`, `Update_Date`) VALUES
(1, 2, 'Package accepted at HOUSTON location', '2019-03-06 07:00:00'),
(2, 2, 'Package on the way to LOS ANGELES', '2019-03-07 07:00:00'),
(3, 2, 'Package out for delivery', '2019-03-08 07:00:00'),
(4, 2, 'Package DELIVERED', '2019-03-09 07:00:00'),
(5, 1, 'Package entered into system', '2019-03-28 23:19:37'),
(6, 1, 'On the way..', '2019-03-28 23:28:27'),
(7, 1, 'Package has arrived to MIAMI', '2019-03-28 23:30:16'),
(8, 1, 'Package RETURNED!', '2019-03-28 23:31:32');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `VIN` varchar(17) NOT NULL,
  `DriverID` int(7) NOT NULL,
  `Vehicle_Type` varchar(10) NOT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`VIN`),
  UNIQUE KEY `DriverID` (`DriverID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customercredentials`
--
ALTER TABLE `customercredentials`
  ADD CONSTRAINT `CustomerCredentials_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `customer` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employeecredentials`
--
ALTER TABLE `employeecredentials`
  ADD CONSTRAINT `EmployeeCredentials_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `office`
--
ALTER TABLE `office`
  ADD CONSTRAINT `Office_ibfk_3` FOREIGN KEY (`OfficeID`) REFERENCES `vehicle` (`VIN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `Package_ibfk_1` FOREIGN KEY (`Status`) REFERENCES `status` (`Code`),
  ADD CONSTRAINT `Package_ibfk_2` FOREIGN KEY (`Email`) REFERENCES `customer` (`Email`);

--
-- Constraints for table `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `Shift_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `Tracking_ibfk_1` FOREIGN KEY (`Package_ID`) REFERENCES `package` (`PackageID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `Vehicle_ibfk_1` FOREIGN KEY (`DriverID`) REFERENCES `employee` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

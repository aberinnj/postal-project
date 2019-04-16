-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 15, 2019 at 09:42 PM
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

CREATE DATABASE IF NOT EXISTS postaldb;
use postaldb;
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
  `State` tinyint(4) NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Street` varchar(35) NOT NULL,
  `ApartmentNo` int(5) DEFAULT NULL,
  PRIMARY KEY (`Email`),
  KEY `Customer_ibfk_1` (`State`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`FName`, `MInit`, `LName`, `Email`, `State`, `City`, `ZIP`, `Street`, `ApartmentNo`) VALUES
('Cooper', 'M', 'Freman', 'cooper@hotmail.com', 1, 'Man', 22011, 'notFree Ln', NULL),
('Cosmo', 'M', 'Aut', 'cosmo@gmail.com', 2, 'Katy', 20001, '222 Space Valley', NULL),
('John', 'O', 'Doe', 'john.doe@gmail.com', 43, 'Houston', 77023, '1412 Richmond Avenue', NULL);

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
  `OfficeID` varchar(7) NOT NULL,
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
  `OfficeID` varchar(7) NOT NULL,
  `State` tinyint(4) NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Street` varchar(35) NOT NULL,
  `isRegional` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`OfficeID`),
  UNIQUE KEY `VehicleID` (`OfficeID`),
  KEY `Office_ibfk_1` (`State`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`OfficeID`, `State`, `City`, `ZIP`, `Street`, `isRegional`) VALUES
('AUS001', 43, 'Austin', 78701, '212 East 6th St', 1),
('AUS002', 43, 'Austin', 78704, '3001 South Congress Avenue', 0),
('DFW001', 43, 'Fort Worth', 76131, '5601 Mark IV Parkway', 0),
('DFW002', 43, 'Plano', 75093, '6121 West Park Blvd', 0),
('DFW003', 43, 'Irving', 75038, '5000 Hanson Drive', 0),
('ELP001', 43, 'El Paso', 79901, '114 W Mills Ave', 0),
('HOU001', 43, 'Houston', 77023, '3525 Sage Road', 0),
('HOU002', 43, 'Katy', 77494, '12212 Westheimer Parkway', 0),
('HOU003', 43, 'Baytown', 77015, '13311 East Freeway', 0),
('HOU004', 43, 'Sugar Land', 77479, '2700 Town Center Boulevard North', 0),
('HOU005', 43, 'The Woodlands', 77380, '1201 Lake Woodlands Drive', 0),
('SAN001', 43, 'San Antonio', 78216, '151 Interpark Boulevard', 0);

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
  `dest_State` tinyint(4) NOT NULL,
  `dest_City` varchar(30) NOT NULL,
  `dest_ZIP` int(5) NOT NULL,
  `dest_Street` varchar(35) NOT NULL,
  `dest_ApartmentNo` int(5) DEFAULT NULL,
  `return_State` tinyint(4) NOT NULL,
  `return_City` varchar(30) NOT NULL,
  `return_ZIP` int(5) NOT NULL,
  `return_Street` varchar(35) NOT NULL,
  `return_ApartmentNo` int(5) DEFAULT NULL,
  `isFragile` tinyint(1) NOT NULL,
  `send_date` date NOT NULL,
  `Service` int(1) NOT NULL,
  `Status` int(1) NOT NULL,
  `OfficeID` varchar(7) DEFAULT NULL,
  `VehicleID` varchar(17) DEFAULT NULL,
  PRIMARY KEY (`PackageID`),
  KEY `Package_ibfk_1` (`Status`),
  KEY `Package_ibfk_2` (`dest_State`),
  KEY `Package_ibfk_5` (`OfficeID`),
  KEY `Package_ibfk_3` (`return_State`),
  KEY `Package_ibfk_4` (`Service`),
  KEY `Package_ibfk_6` (`VehicleID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`PackageID`, `RecipientName`, `Email`, `Weight`, `Length`, `Width`, `Height`, `dest_State`, `dest_City`, `dest_ZIP`, `dest_Street`, `dest_ApartmentNo`, `return_State`, `return_City`, `return_ZIP`, `return_Street`, `return_ApartmentNo`, `isFragile`, `send_date`, `Service`, `Status`, `OfficeID`, `VehicleID`) VALUES
(3, 'Homer Man', 'cooper@hotmail.com', '10.00', '5.00', '5.00', '5.00', 43, 'Corpus', 73001, '4490 Home Road', 10, 43, 'Katy', 73001, '888 Heller Road', 202, 1, '2019-04-15', 3, 2, 'HOU001', NULL),
(4, 'House Morgan', 'cooper@hotmail.com', '10.00', '10.00', '5.00', '5.00', 43, 'Katy', 77494, '888 Heller Road', 201, 43, 'Man', 77494, '1012 Homefree Lane', 11, 0, '2019-04-15', 2, 2, 'HOU002', 'AAAAAAA0000000004'),
(5, 'Cosa Mosa', 'cooper@hotmail.com', '40.00', '5.00', '5.00', '5.00', 47, 'District of Columbia', 20001, '720 Hope Lane', NULL, 43, 'Corpus', 20001, '4490 Home Road', NULL, 0, '2019-04-15', 2, 2, 'HOU002', 'AAAAAAA0000000004'),
(6, 'StressFree Inc.', 'cooper@hotmail.com', '8.00', '8.00', '8.00', '8.00', 43, 'Tomball', 77202, '530 Torp Street', NULL, 43, 'Plano', 77202, '555 Magis Corpus Avenue', 520, 0, '2019-04-15', 1, 2, 'HOU002', 'AAAAAAA0000000004');

--
-- Triggers `package`
--
DROP TRIGGER IF EXISTS `create_package_tracking`;
DELIMITER $$
CREATE TRIGGER `create_package_tracking` AFTER INSERT ON `package` FOR EACH ROW BEGIN
INSERT INTO tracking (package_ID, TrackingNote, Update_Date, OfficeID) VALUES(NEW.packageID, 'Package Picked Up.', NOW(), NEW.OfficeID);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `ServiceID` int(1) NOT NULL AUTO_INCREMENT,
  `ServiceName` varchar(32) NOT NULL,
  `BasePrice` decimal(5,2) NOT NULL,
  `WeightLimit` int(3) NOT NULL DEFAULT '0',
  `WeightPriceMultiplier` float(5,2) NOT NULL,
  PRIMARY KEY (`ServiceID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`ServiceID`, `ServiceName`, `BasePrice`, `WeightLimit`, `WeightPriceMultiplier`) VALUES
(1, 'Ground Economy', '7.50', 150, 0.50),
(2, 'Priority Overnight', '11.25', 150, 0.75),
(3, 'Same-Day Delivery', '13.50', 150, 0.95);

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

DROP TABLE IF EXISTS `shift`;
CREATE TABLE IF NOT EXISTS `shift` (
  `ShiftSession` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `EmployeeID` int(7) NOT NULL,
  `Clock_in_dateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Clock_out_dateTime` datetime,
  `Hours_Worked` decimal(4,2) DEFAULT 0,
  `VehicleID` varchar(17) NOT NULL,
  UNIQUE KEY `EmployeeID` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `StateID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `StateAbbreviation` char(2) NOT NULL,
  `StateName` varchar(15) NOT NULL,
  PRIMARY KEY (`StateID`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`StateID`, `StateAbbreviation`, `StateName`) VALUES
(1, 'AL', 'Alabama'),
(2, 'AK', 'Alaska'),
(3, 'AZ', 'Arizona'),
(4, 'AR', 'Arkansas'),
(5, 'CA', 'California'),
(6, 'CO', 'Colorado'),
(7, 'CT', 'Connecticut'),
(8, 'DE', 'Delaware'),
(9, 'FL', 'Florida'),
(10, 'GA', 'Georgia'),
(11, 'HI', 'Hawaii'),
(12, 'ID', 'Idaho'),
(13, 'IL', 'Illinois'),
(14, 'IN', 'Indiana'),
(15, 'IA', 'Iowa'),
(16, 'KS', 'Kansas'),
(17, 'KY', 'Kentucky'),
(18, 'LA', 'Louisiana'),
(19, 'ME', 'Maine'),
(20, 'MD', 'Maryland'),
(21, 'MA', 'Massachusetts'),
(22, 'MI', 'Michigan'),
(23, 'MN', 'Minnesota'),
(24, 'MS', 'Mississippi'),
(25, 'MO', 'Missouri'),
(26, 'MT', 'Montana'),
(27, 'NE', 'Nebraska'),
(28, 'NV', 'Nevada'),
(29, 'NH', 'New Hampshire'),
(30, 'NJ', 'New Jersey'),
(31, 'NM', 'New Mexico'),
(32, 'NY', 'New York'),
(33, 'NC', 'North Carolina'),
(34, 'ND', 'North Dakota'),
(35, 'OH', 'Ohio'),
(36, 'OK', 'Oklahoma'),
(37, 'OR', 'Oregon'),
(38, 'PA', 'Pennsylvania'),
(39, 'RI', 'Rhode Island'),
(40, 'SC', 'South Carolina'),
(41, 'SD', 'South Dakota'),
(42, 'TN', 'Tennessee'),
(43, 'TX', 'Texas'),
(44, 'UT', 'Utah'),
(45, 'VT', 'Vermont'),
(46, 'VA', 'Virginia'),
(47, 'WA', 'Washington'),
(48, 'WV', 'West Virginia'),
(49, 'WI', 'Wisconsin'),
(50, 'WY', 'Wyoming');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `Code` int(1) NOT NULL AUTO_INCREMENT,
  `Status` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`Code`, `Status`) VALUES
(1, 'Drop Off'),
(2, 'Processed'),
(3, 'In Transit'),
(4, 'Pick Up'),
(5, 'Delivered'),
(6, 'Expired'),
(7, 'Alert');

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

DROP TABLE IF EXISTS `tracking`;
CREATE TABLE IF NOT EXISTS `tracking` (
  `Tracking_Index` int(18) NOT NULL AUTO_INCREMENT,
  `Package_ID` int(10) NOT NULL,
  `TrackingNote` varchar(40) DEFAULT NULL,
  `Update_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OfficeID` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`Tracking_Index`),
  UNIQUE KEY `Tracking_Index` (`Tracking_Index`),
  KEY `Tracking_ibfk_1` (`Package_ID`),
  KEY `Tracking_ibfk_2` (`OfficeID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracking`
--

INSERT INTO `tracking` (`Tracking_Index`, `Package_ID`, `TrackingNote`, `Update_Date`, `OfficeID`) VALUES
(9, 3, 'Package Picked Up.', '2019-04-15 17:47:27', 'HOU001'),
(10, 4, 'Package Picked Up.', '2019-04-15 17:48:40', 'HOU002'),
(11, 5, 'Package Picked Up.', '2019-04-15 17:49:53', 'HOU002'),
(12, 6, 'Package Picked Up.', '2019-04-15 17:51:54', 'HOU002');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `TransactionID` int(18) NOT NULL AUTO_INCREMENT,
  `PackageID` int(10) NOT NULL,
  `TransactionTotal` decimal(8,2) NOT NULL,
  `TransactionDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TransactionID`),
  KEY `Transaction_ibfk_2` (`PackageID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TransactionID`, `PackageID`, `TransactionTotal`, `TransactionDate`) VALUES
(9, 3, '13.50', '2019-04-15 12:47:27'),
(10, 4, '11.25', '2019-04-15 12:48:40'),
(11, 5, '11.25', '2019-04-15 12:49:53'),
(12, 6, '7.50', '2019-04-15 12:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `OfficeID` varchar(7) NOT NULL,
  `VIN` varchar(17) NOT NULL,
  `Vehicle_Type` varchar(10) NOT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`VIN`),
  KEY `Vehicle_ibfk_1` (`OfficeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`OfficeID`, `VIN`, `Vehicle_Type`, `Status`) VALUES
('HOU002', 'AAAAAAA0000000000', 'Truck', NULL),
('HOU002', 'AAAAAAA0000000001', 'Van', NULL),
('HOU002', 'AAAAAAA0000000002', 'Van', NULL),
('HOU002', 'AAAAAAA0000000003', 'Van', NULL),
('HOU002', 'AAAAAAA0000000004', 'Truck', NULL),
('HOU002', 'AAAAAAA0000000005', 'Truck', NULL),
('HOU001', 'AAAAAAA0000000006', 'Van', NULL),
('HOU001', 'AAAAAAA0000000007', 'Van', NULL),
('HOU001', 'AAAAAAA0000000008', 'Van', NULL),
('HOU001', 'AAAAAAA0000000009', 'Truck', NULL),
('HOU001', 'AAAAAAA0000000010', 'Truck', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `Customer_ibfk_1` FOREIGN KEY (`State`) REFERENCES `state` (`StateID`);

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
  ADD CONSTRAINT `Office_ibfk_1` FOREIGN KEY (`State`) REFERENCES `state` (`StateID`);

--
-- Constraints for table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `Package_ibfk_1` FOREIGN KEY (`Status`) REFERENCES `status` (`Code`),
  ADD CONSTRAINT `Package_ibfk_2` FOREIGN KEY (`dest_State`) REFERENCES `state` (`StateID`),
  ADD CONSTRAINT `Package_ibfk_3` FOREIGN KEY (`return_State`) REFERENCES `state` (`StateID`),
  ADD CONSTRAINT `Package_ibfk_4` FOREIGN KEY (`Service`) REFERENCES `service` (`ServiceID`),
  ADD CONSTRAINT `Package_ibfk_5` FOREIGN KEY (`OfficeID`) REFERENCES `office` (`OfficeID`),
  ADD CONSTRAINT `Package_ibfk_6` FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VIN`);

--
-- Constraints for table `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `Shift_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Shift_ibfk_2` FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VIN`);
--
-- Constraints for table `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `Tracking_ibfk_1` FOREIGN KEY (`Package_ID`) REFERENCES `package` (`PackageID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Tracking_ibfk_2` FOREIGN KEY (`OfficeID`) REFERENCES `office` (`OfficeID`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `Transaction_ibfk_2` FOREIGN KEY (`PackageID`) REFERENCES `package` (`PackageID`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `Vehicle_ibfk_1` FOREIGN KEY (`OfficeID`) REFERENCES `office` (`OfficeID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

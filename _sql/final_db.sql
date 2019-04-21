-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 21, 2019 at 10:53 PM
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
-- Database: `courierdb_1`
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
  PRIMARY KEY (`EmployeeID`),
  KEY `OfficeID` (`OfficeID`)
) ENGINE=InnoDB AUTO_INCREMENT=1000007 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmployeeID`, `FirstName`, `MiddleName`, `LastName`, `EmploymentDate`, `UserRole`, `OfficeID`) VALUES
(1000000, 'John', 'M', 'Doe', '2019-04-07 02:18:21', NULL, 'HOU002'),
(1000001, 'Mo', 'M', 'Mo', '2019-04-07 22:57:14', NULL, 'HOU002'),
(1000002, 'Norm', 'M', 'Norm', '2019-04-08 11:43:23', NULL, 'HOU002'),
(1000003, 'Shuber', 'M', 'Costa', '2019-04-16 03:56:07', NULL, 'HOU004'),
(1000004, 'Jesse', 'J', 'James', '2019-04-17 14:47:10', NULL, 'MON001'),
(1000005, 'Jess', 'J', 'Melt', '2019-04-17 14:49:06', NULL, 'AUS001'),
(1000006, 'Marcus', 'A', 'Finch', '2019-04-17 15:05:11', NULL, 'HOU003');

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
(1000002, '81dc9bdb52d04dc20036dbd8313ed055'),
(1000003, 'f56c047327d98c9d787b9325926d9860'),
(1000004, '5f4dcc3b5aa765d61d8327deb882cf99'),
(1000005, '1a1dc91c907325c69271ddf0c944bc72'),
(1000006, '1a1dc91c907325c69271ddf0c944bc72');

-- --------------------------------------------------------

--
-- Stand-in structure for view `employee_delivery_report`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `employee_delivery_report`;
CREATE TABLE IF NOT EXISTS `employee_delivery_report` (
`EmployeeID` int(7)
,`FirstName` varchar(20)
,`MiddleName` varchar(2)
,`LastName` varchar(20)
,`VIN` varchar(17)
,`OfficeID` varchar(7)
,`PackageID` int(10)
,`dest_ZIP` int(5)
,`Weight` decimal(5,2)
,`Status` varchar(12)
);

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
('MON001', 1, 'Montgomery', 35004, 'Montgomery Ave.', 1),
('OLY001', 47, 'Olympia', 98501, '414 Jefferson St NE', 1),
('OLY002', 47, 'Olympia', 98599, '2201 Homer St', 0),
('SAN001', 43, 'San Antonio', 78216, '151 Interpark Boulevard', 0),
('SEA001', 47, 'Seattle', 98401, '420 Valid St', 0),
('SEA002', 47, 'Seattle', 98101, '911 Pine St', 0),
('VAN001', 47, 'Vancouver', 98662, '8700 NE Vancouver Mall Dr', 0);

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
  `return_office` varchar(7) DEFAULT NULL,
  `ShiftID` int(10) DEFAULT NULL,
  PRIMARY KEY (`PackageID`),
  KEY `Package_ibfk_1` (`Status`),
  KEY `Package_ibfk_2` (`dest_State`),
  KEY `Package_ibfk_5` (`OfficeID`),
  KEY `Package_ibfk_3` (`return_State`),
  KEY `Package_ibfk_4` (`Service`),
  KEY `Package_ibfk_6` (`VehicleID`),
  KEY `Package_ibfk_7` (`return_office`),
  KEY `ShiftID` (`ShiftID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`PackageID`, `RecipientName`, `Email`, `Weight`, `Length`, `Width`, `Height`, `dest_State`, `dest_City`, `dest_ZIP`, `dest_Street`, `dest_ApartmentNo`, `return_State`, `return_City`, `return_ZIP`, `return_Street`, `return_ApartmentNo`, `isFragile`, `send_date`, `Service`, `Status`, `OfficeID`, `VehicleID`, `return_office`, `ShiftID`) VALUES
(24, 'Marco', 'cooper@hotmail.com', '5.00', '5.00', '5.00', '5.00', 43, 'Austin', 77534, '1111 Street', NULL, 43, 'Man', 77534, 'notFree Ln', NULL, 0, '2019-04-21', 1, 5, NULL, NULL, 'AUS001', 33),
(25, 'James', 'cooper@hotmail.com', '6.00', '5.00', '5.00', '5.00', 43, 'Austin', 77534, '1111 Street', NULL, 43, 'Man', 77534, 'notFree Ln', NULL, 0, '2019-04-21', 1, 5, NULL, NULL, 'HOU002', 33),
(26, 'Marty', 'cooper@hotmail.com', '5.00', '5.00', '5.00', '5.00', 43, 'Ala', 77534, '1111 Street', NULL, 43, 'Man', 77534, 'notFree Ln', NULL, 0, '2019-04-21', 1, 5, NULL, NULL, 'AUS001', 33),
(27, 'Marco', 'cooper@hotmail.com', '5.00', '5.00', '5.00', '5.00', 43, 'Houston', 77777, '1111 Street', NULL, 43, 'Man', 77777, 'notFree Ln', NULL, 0, '2019-04-21', 1, 5, NULL, NULL, 'AUS001', 34);

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
DROP TRIGGER IF EXISTS `package_transferred`;
DELIMITER $$
CREATE TRIGGER `package_transferred` AFTER UPDATE ON `package` FOR EACH ROW BEGIN
INSERT into tracking (Package_ID, TrackingNote, OfficeID, ShiftID)

SELECT NEW.packageID, d.message, NEW.OfficeID, NEW.ShiftID FROM 

(
  (SELECT m.message FROM 
  (SELECT 'Package delivered' as message from package where package.Status = 5 AND package.PackageID = NEW.packageID) as m

  UNION 

  (SELECT m.message FROM 
  (SELECT CONCAT('Package arrived at regional office', NEW.OfficeID) as message from package, office where package.OfficeID = NEW.OfficeID AND office.isRegional = 1 and office.OfficeID = package.OfficeID) as m)

  UNION

   (  (SELECT m.message FROM 
  (SELECT CONCAT('Package transferred to ', NEW.OfficeID) as message from package, office where package.OfficeID = NEW.OfficeID AND office.isRegional != 1 and office.OfficeID = package.OfficeID) as m))

) as d

);
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
  `ShiftSession` int(10) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(7) NOT NULL,
  `Clock_in_dateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Clock_out_dateTime` datetime DEFAULT NULL,
  `Hours_Worked` decimal(4,2) DEFAULT '0.00',
  `VehicleID` varchar(17) NOT NULL,
  PRIMARY KEY (`ShiftSession`),
  KEY `Shift_ibfk_2` (`VehicleID`),
  KEY `EmployeeID` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`ShiftSession`, `EmployeeID`, `Clock_in_dateTime`, `Clock_out_dateTime`, `Hours_Worked`, `VehicleID`) VALUES
(31, 1000005, '2019-04-21 17:11:18', '2019-04-21 17:11:40', '0.00', 'AAAAAAA0000000010'),
(32, 1000000, '2019-04-21 17:14:11', '2019-04-21 17:14:34', '0.00', 'AAAAAAA0000000000'),
(33, 1000005, '2019-04-21 17:15:14', '2019-04-21 17:16:08', '0.00', 'AAAAAAA0000000010'),
(34, 1000000, '2019-04-21 17:16:29', '2019-04-21 17:16:34', '0.00', 'AAAAAAA0000000000');

--
-- Triggers `shift`
--
DROP TRIGGER IF EXISTS `begin_shipping_package`;
DELIMITER $$
CREATE TRIGGER `begin_shipping_package` AFTER INSERT ON `shift` FOR EACH ROW BEGIN
UPDATE vehicle SET vehicle.Status = 1 WHERE NEW.VehicleID = vehicle.VIN;

UPDATE package SET package.OfficeID = NULL, package.Status = 3 WHERE package.VehicleID = NEW.VehicleID;

INSERT INTO tracking (Package_ID, TrackingNote, OfficeID, ShiftID) 
SELECT package.PackageID,'Left Courier.PO facility', NULL, NEW.ShiftSession FROM package WHERE package.VehicleID = NEW.VehicleID;

END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `end_shift`;
DELIMITER $$
CREATE TRIGGER `end_shift` BEFORE UPDATE ON `shift` FOR EACH ROW UPDATE vehicle SET vehicle.Status = 0 WHERE NEW.VehicleID = vehicle.VIN
$$
DELIMITER ;

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
  `ShiftID` int(10) DEFAULT NULL,
  PRIMARY KEY (`Tracking_Index`),
  UNIQUE KEY `Tracking_Index` (`Tracking_Index`),
  KEY `Tracking_ibfk_1` (`Package_ID`),
  KEY `Tracking_ibfk_2` (`OfficeID`),
  KEY `ShiftID` (`ShiftID`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracking`
--

INSERT INTO `tracking` (`Tracking_Index`, `Package_ID`, `TrackingNote`, `Update_Date`, `OfficeID`, `ShiftID`) VALUES
(126, 24, 'Package Picked Up.', '2019-04-21 22:10:32', 'AUS001', NULL),
(127, 24, 'Package arrived at regional officeAUS001', '2019-04-21 22:11:14', 'AUS001', NULL),
(128, 24, 'Left Courier.PO facility', '2019-04-21 22:11:18', NULL, 31),
(129, 24, 'Package transferred to HOU002', '2019-04-21 22:11:37', 'HOU002', 31),
(130, 25, 'Package Picked Up.', '2019-04-21 22:12:28', 'HOU002', NULL),
(131, 26, 'Package Picked Up.', '2019-04-21 22:12:51', 'AUS001', NULL),
(132, 27, 'Package Picked Up.', '2019-04-21 22:13:20', 'AUS001', NULL),
(133, 24, 'Package transferred to HOU002', '2019-04-21 22:14:06', 'HOU002', 31),
(134, 25, 'Package transferred to HOU002', '2019-04-21 22:14:06', 'HOU002', NULL),
(135, 24, 'Left Courier.PO facility', '2019-04-21 22:14:11', NULL, 32),
(136, 25, 'Left Courier.PO facility', '2019-04-21 22:14:11', NULL, 32),
(138, 24, 'Package arrived at regional officeAUS001', '2019-04-21 22:14:28', 'AUS001', 32),
(139, 25, 'Package arrived at regional officeAUS001', '2019-04-21 22:14:30', 'AUS001', 32),
(140, 27, 'Package arrived at regional officeAUS001', '2019-04-21 22:15:05', 'AUS001', NULL),
(141, 24, 'Package arrived at regional officeAUS001', '2019-04-21 22:15:05', 'AUS001', 32),
(142, 26, 'Package arrived at regional officeAUS001', '2019-04-21 22:15:06', 'AUS001', NULL),
(143, 25, 'Package arrived at regional officeAUS001', '2019-04-21 22:15:06', 'AUS001', 32),
(144, 24, 'Left Courier.PO facility', '2019-04-21 22:15:14', NULL, 33),
(145, 25, 'Left Courier.PO facility', '2019-04-21 22:15:14', NULL, 33),
(146, 26, 'Left Courier.PO facility', '2019-04-21 22:15:14', NULL, 33),
(147, 27, 'Left Courier.PO facility', '2019-04-21 22:15:14', NULL, 33),
(151, 27, 'Package transferred to HOU002', '2019-04-21 22:15:19', 'HOU002', 33),
(152, 25, 'Package delivered', '2019-04-21 22:15:33', NULL, 33),
(153, 24, 'Package delivered', '2019-04-21 22:16:03', NULL, 33),
(154, 26, 'Package delivered', '2019-04-21 22:16:07', NULL, 33),
(155, 27, 'Package transferred to HOU002', '2019-04-21 22:16:25', 'HOU002', 33),
(156, 27, 'Left Courier.PO facility', '2019-04-21 22:16:29', NULL, 34),
(157, 27, 'Package delivered', '2019-04-21 22:16:32', NULL, 34);

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`TransactionID`, `PackageID`, `TransactionTotal`, `TransactionDate`) VALUES
(30, 24, '7.50', '2019-04-21 17:10:32'),
(31, 25, '7.50', '2019-04-21 17:12:28'),
(32, 26, '7.50', '2019-04-21 17:12:52'),
(33, 27, '7.50', '2019-04-21 17:13:20');

-- --------------------------------------------------------

--
-- Stand-in structure for view `unique_customers`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `unique_customers`;
CREATE TABLE IF NOT EXISTS `unique_customers` (
`COUNT(DISTINCT Email)` bigint(21)
);

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
('HOU002', 'AAAAAAA0000000000', 'Truck', 0),
('HOU002', 'AAAAAAA0000000001', 'Van', 0),
('HOU002', 'AAAAAAA0000000002', 'Van', NULL),
('HOU002', 'AAAAAAA0000000003', 'Van', NULL),
('HOU002', 'AAAAAAA0000000004', 'Truck', 0),
('HOU002', 'AAAAAAA0000000005', 'Truck', NULL),
('HOU001', 'AAAAAAA0000000006', 'Van', NULL),
('HOU001', 'AAAAAAA0000000007', 'Van', NULL),
('HOU001', 'AAAAAAA0000000008', 'Van', NULL),
('MON001', 'AAAAAAA0000000009', 'Truck', 0),
('AUS001', 'AAAAAAA0000000010', 'Truck', 0),
('HOU004', 'AAAAAAA0000000012', 'Van', 1),
('HOU003', 'AAAAAAA0000000013', 'Van', 0);

-- --------------------------------------------------------

--
-- Structure for view `employee_delivery_report`
--
DROP TABLE IF EXISTS `employee_delivery_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`%` SQL SECURITY DEFINER VIEW `employee_delivery_report`  AS  select `e`.`EmployeeID` AS `EmployeeID`,`e`.`FirstName` AS `FirstName`,`e`.`MiddleName` AS `MiddleName`,`e`.`LastName` AS `LastName`,`v`.`VIN` AS `VIN`,`o`.`OfficeID` AS `OfficeID`,`p`.`PackageID` AS `PackageID`,`p`.`dest_ZIP` AS `dest_ZIP`,`p`.`Weight` AS `Weight`,`t`.`Status` AS `Status` from (((((`employee` `e` join `package` `p`) join `vehicle` `v`) join `office` `o`) join `shift` `s`) join `status` `t`) where ((`e`.`OfficeID` = `o`.`OfficeID`) and (`e`.`EmployeeID` = `s`.`EmployeeID`) and (`s`.`VehicleID` = `v`.`VIN`) and (`p`.`Status` = `t`.`Code`)) order by `e`.`EmployeeID` ;

-- --------------------------------------------------------

--
-- Structure for view `unique_customers`
--
DROP TABLE IF EXISTS `unique_customers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`%` SQL SECURITY DEFINER VIEW `unique_customers`  AS  select count(distinct `package`.`Email`) AS `COUNT(DISTINCT Email)` from `package` ;

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
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`OfficeID`) REFERENCES `office` (`OfficeID`);

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
  ADD CONSTRAINT `Package_ibfk_6` FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VIN`),
  ADD CONSTRAINT `Package_ibfk_7` FOREIGN KEY (`return_office`) REFERENCES `office` (`OfficeID`);

--
-- Constraints for table `shift`
--
ALTER TABLE `shift`
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

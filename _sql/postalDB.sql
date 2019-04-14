-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 09, 2019 at 05:44 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

CREATE DATABASE IF NOT EXISTS postaldb;
USE postaldb;

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

DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `StateID` tinyint NOT NULL AUTO_INCREMENT,
  `StateAbbreviation` char(2) NOT NULL,
  `StateName` varchar(15) NOT NULL,
  PRIMARY KEY (`StateID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT into `state`(`StateAbbreviation`, `StateName`) values 
('AL', 'Alabama'),
('AK', 'Alaska'),
('AZ', 'Arizona'),
('AR', 'Arkansas'),
('CA', 'California'),
('CO', 'Colorado'),
('CT', 'Connecticut'),
('DE', 'Delaware'),
('FL', 'Florida'),
('GA', 'Georgia'),
('HI', 'Hawaii'),
('ID', 'Idaho'),
('IL', 'Illinois'),
('IN', 'Indiana'),
('IA', 'Iowa'),
('KS', 'Kansas'),
('KY', 'Kentucky'),
('LA', 'Louisiana'),
('ME', 'Maine'),
('MD', 'Maryland'),
('MA', 'Massachusetts'),
('MI', 'Michigan'),
('MN', 'Minnesota'),
('MS', 'Mississippi'),
('MO', 'Missouri'),
('MT', 'Montana'),
('NE', 'Nebraska'),
('NV', 'Nevada'),
('NH', 'New Hampshire'),
('NJ', 'New Jersey'),
('NM', 'New Mexico'),
('NY', 'New York'),
('NC', 'North Carolina'),
('ND', 'North Dakota'),
('OH', 'Ohio'),
('OK', 'Oklahoma'),
('OR', 'Oregon'),
('PA', 'Pennsylvania'),
('RI', 'Rhode Island'),
('SC', 'South Carolina'),
('SD', 'South Dakota'),
('TN', 'Tennessee'),
('TX', 'Texas'),
('UT', 'Utah'),
('VT', 'Vermont'),
('VA', 'Virginia'),
('WA', 'Washington'),
('WV', 'West Virginia'),
('WI', 'Wisconsin'),
('WY', 'Wyoming');


DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `FName` varchar(20) NOT NULL,
  `MInit` varchar(2) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `Email` varchar(55) NOT NULL,
  `State` tinyint NOT NULL,
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
) ENGINE=InnoDB CHARSET=latin1;

--
-- Dumping data for table `employeecredentials`
--

INSERT INTO `employeecredentials` (`EmployeeID`, `Password`) VALUES
(1000000, '8d307b07b9b59d479d0db9be3fa1a2b0'),
(1000001, '81dc9bdb52d04dc20036dbd8313ed055'),
(1000002, '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------


DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `ServiceID` int(1) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `ServiceName` varchar(32) NOT NULL,
  `BasePrice` decimal(5,2) NOT NULL,
  `WeightLimit` int(3) NOT NULL DEFAULT 0,
  `WeightPriceMultiplier` FLOAT (5, 2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `service` (`ServiceName`, `BasePrice`, `WeightLimit`, `WeightPriceMultiplier`) VALUES
('Ground Economy', 7.5, 150, .5),
('Priority Overnight', 11.25, 150, .75),
('Same-Day Delivery', 13.5 , 150, .95 );

-- Table structure for table `office`
--

DROP TABLE IF EXISTS `office`;
CREATE TABLE IF NOT EXISTS `office` (
  `OfficeID` varchar(17) NOT NULL,
  `State` tinyint NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Street` varchar(35) NOT NULL,
  PRIMARY KEY (`OfficeID`),
  UNIQUE KEY `VehicleID` (`OfficeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `office` (`OfficeID`, `State`, `City`, `ZIP`, `Street`) VALUES 
('HOU001', '43', 'Houston', '77023', '3525 Sage Road'),
('HOU002', '43', 'Katy', '77494', '12212 Westheimer Parkway'),
('HOU003', '43', 'Baytown', '77015', '13311 East Freeway'),
('HOU004', '43', 'Sugar Land', '77479', '2700 Town Center Boulevard North'),
('HOU005', '43', 'The Woodlands', '77380', '1201 Lake Woodlands Drive'),
('DFW001', '43', 'Fort Worth', '76131', '5601 Mark IV Parkway'),
('DFW002', '43', 'Plano', '75093', '6121 West Park Blvd'),
('DFW003', '43', 'Irving', '75038', '5000 Hanson Drive'),
('AUS001', '43', 'Austin', '78701', '212 East 6th St'),
('AUS002', '43', 'Austin', '78704', '3001 South Congress Avenue'),
('SAN001', '43', 'San Antonio', '78216', '151 Interpark Boulevard'),
('ELP001', '43', 'El Paso', '79901', '114 W Mills Ave');

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
  `dest_State` tinyint NOT NULL,
  `dest_City` varchar(30) NOT NULL,
  `dest_ZIP` int(5) NOT NULL,
  `dest_Street` varchar(35) NOT NULL,
  `dest_ApartmentNo` int(5) DEFAULT NULL,
  `return_State` tinyint NOT NULL,
  `return_City` varchar(30) NOT NULL,
  `return_ZIP` int(5) NOT NULL,
  `return_Street` varchar(35) NOT NULL,
  `return_ApartmentNo` int(5) DEFAULT NULL,
  `isFragile` tinyint(1) NOT NULL,
  `send_date` date NOT NULL,
  `Service` int(1) NOT NULL,
  `Status` int(1) NOT NULL, 
  PRIMARY KEY (`PackageID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


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
  `TrackingNote` varchar(40),
  `Update_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `State` tinyint NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Street` varchar(35) NOT NULL,
  PRIMARY KEY (`Tracking_Index`),
  UNIQUE KEY `Tracking_Index` (`Tracking_Index`),
  KEY `Tracking_ibfk_1` (`Package_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


--
-- Dumping data for table `tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `OfficeID` varchar(17) NOT NULL,
  `VIN` varchar(17) NOT NULL,
  `DriverID` int(7) NOT NULL,
  `Vehicle_Type` varchar(10) NOT NULL,
  `Status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`VIN`),
  UNIQUE KEY `DriverID` (`DriverID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `transaction` (
  `TransactionID` int(18) NOT NULL,
  `PackageID` int(10) NOT NULL,
  `TransactionTotal` DECIMAL (8,2) NOT NULL,
  `TransactionDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TransactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 

--
-- Constraints for table `customercredentials`
--
--
-- Constraint for transaction table - Foreign key for Email
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `Transaction_ibfk_2` FOREIGN KEY (`PackageID`) REFERENCES `package` (`PackageID`);

 
ALTER TABLE `customer`
  ADD CONSTRAINT `Customer_ibfk_1` FOREIGN KEY (`State`) REFERENCES `state` (`StateID`);
 
--
-- Transaction - Auto-Increment
--
ALTER TABLE `transaction`
  MODIFY `TransactionID` INT(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;



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
  ADD CONSTRAINT `Package_ibfk_4` FOREIGN KEY (`Service`) REFERENCES `service` (`ServiceID`);

--
-- Constraints for table `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `Shift_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `Tracking_ibfk_1` FOREIGN KEY (`Package_ID`) REFERENCES `package` (`PackageID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Tracking_ibfk_2` FOREIGN KEY (`State`) REFERENCES `state` (`StateID`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `Vehicle_ibfk_1` FOREIGN KEY (`OfficeID`) REFERENCES `office` (`OfficeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Vehicle_ibfk_2` FOREIGN KEY (`DriverID`) REFERENCES `employee` (`EmployeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
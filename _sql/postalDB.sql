-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 03, 2019 at 10:28 AM
-- Server version: 5.6.39-cll-lve
-- PHP Version: 5.6.30

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
-- Database: `postalDB`
--

-- ---------------------------------------------------------- ---------------------------------------------------------- --------------------------------------------------------

--
-- Table structure for table `Invoice`
--
/*
CREATE TABLE `invoice` (
  `CustomerEmail` varchar(55) NOT NULL, -- get user details for billing, and return address
  `ServiceType` varchar(55) NOT NULL, -- foreign key to look up service, business logic calculates price
  `TransactionID`, int(10) NOT NULL -- primary key, place in packageID, OR replace with PackageID (1 package/transaction)
  `Tender` float(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
*/

-- ---------------------------------------------------------- ---------------------------------------------------------- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `customer` (
  `FName` varchar(20) NOT NULL,
  `MInit` varchar(2) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `Email` varchar(55) NOT NULL,
  `State` varchar(15) NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Street` varchar(35) NOT NULL,
  `ApartmentNo` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `CustomerCredentials`
--

CREATE TABLE `customercredentials` (
  `Email` varchar(55) NOT NULL,
  `Password` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `employee` (
  `EmployeeID` int(7) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `MiddleName` varchar(2) DEFAULT NULL,
  `LastName` varchar(20) NOT NULL,
  `EmploymentDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UserRole` int(3) DEFAULT NULL,
  `OfficeID` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `EmployeeCredentials`
--

CREATE TABLE `employeecredentials` (
  `EmployeeID` int(7) NOT NULL,
  `Password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Office`
--

CREATE TABLE `office` (
  `OfficeID` varchar(17) NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZIP` int(5) NOT NULL,
  `Address` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `Status`
--

CREATE TABLE `status` (
  `Code` int(1) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `Status` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `Package`
--

CREATE TABLE `package` (
  `PackageID` int(10) NOT NULL,
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
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Package`
--

-- --------------------------------------------------------

--
-- Table structure for table `Shift`
--

CREATE TABLE `shift` (
  `EmployeeID` int(7) NOT NULL,
  `Clock_in_Date` date NOT NULL,
  `Clock_in_Time` time(6) NOT NULL,
  `Clock_out_Time` time(6) NOT NULL,
  `Hours_Worked` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Tracking`
--

CREATE TABLE `tracking` (
  `Tracking_Index` int(18) NOT NULL,
  `Package_ID` int(10) NOT NULL,
  `TrackingNote` varchar(40) NOT NULL,
  `Update_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Vehicle`
--

CREATE TABLE `vehicle` (
  `VIN` varchar(17) NOT NULL,
  `DriverID` int(7) NOT NULL,
  `Vehicle_Type` varchar(10) NOT NULL,
  `Status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Email`);

--
-- Indexes for table `CustomerCredentials`
--
ALTER TABLE `customercredentials`
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `Employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `EmployeeCredentials`
--
ALTER TABLE `employeecredentials`
  ADD UNIQUE KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `Office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`ZIP`),
  ADD UNIQUE KEY `VehicleID` (`OfficeID`);

--
-- Indexes for table `Package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`PackageID`);

--
-- Indexes for table `Shift`
--
ALTER TABLE `shift`
  ADD UNIQUE KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `Tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`Tracking_Index`),
  ADD UNIQUE KEY `Tracking_Index` (`Tracking_Index`);

--
-- Indexes for table `Vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`VIN`),
  ADD UNIQUE KEY `DriverID` (`DriverID`);


--
-- AUTO_INCREMENT for table `Tracking`
--
ALTER TABLE `tracking`
  MODIFY `Tracking_Index` int(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `Tracking`
--
ALTER TABLE `status`
  MODIFY `Code` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;


--
-- AUTO_INCREMENT for table `Package`
ALTER TABLE `package`
  MODIFY `PackageID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;


--
-- AUTO_INCREMENT for table `Employee`
-- Like our student id (7 numbers)
ALTER TABLE `employee`
  MODIFY `EmployeeID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000000;



INSERT INTO `customer` (`FName`, `MInit`, `LName`, `Email`, `State`, `City`, `ZIP`, `Street`, `ApartmentNo`) VALUES
('John', 'O', 'Doe', 'john.doe@gmail.com', 'TX', 'Houston', 77023, '1412 Richmond Avenue', NULL);


INSERT INTO `status` (`Status`) VALUES
('Processed'),
('In Transit'),
('Pick Up'),
('Delivered'),
('Expired'),
('Alert');

INSERT INTO `package` (`RecipientName`, `Email`, `Weight`, `Length`, `Width`, `Height`, `State`, `City`, `ZIP`, `Street`, `ApartmentNo`, `isFragile`, `send_date`, `Priority`, `Status`) VALUES
("HANNAH MILLS", 'john.doe@gmail.com', '5.00', '5.00', '5.00', '5.00', 'TX', 'Houston', 77057, '7787 Blue St', NULL, 1, '2019-03-05', 1, 6),
("MIKE FUR", 'john.doe@gmail.com', '5.00', '5.00', '5.00', '5.00', 'TX', 'Houston', 77057, '8882 Green St', NULL, 1, '2019-03-09', 1, 4);


INSERT INTO `tracking` (`Tracking_Index`, `Package_ID`, `TrackingNote`, `Update_Date`) VALUES
(1, 2, 'Package accepted at HOUSTON location', '2019-03-06 07:00:00'),
(2, 2, 'Package on the way to LOS ANGELES', '2019-03-07 07:00:00'),
(3, 2, 'Package out for delivery', '2019-03-08 07:00:00'),
(4, 2, 'Package DELIVERED', '2019-03-09 07:00:00'),
(5, 1, 'Package entered into system', '2019-03-28 23:19:37'),
(6, 1, 'On the way..', '2019-03-28 23:28:27'),
(7, 1, 'Package has arrived to MIAMI', '2019-03-28 23:30:16'),
(8, 1, 'Package RETURNED!', '2019-03-28 23:31:32');



--
-- Constraints for table `Package`
-- You can delete an account, but that cannot delete the package already in-transit/ deleted.
-- How do you relate it to an account then?
ALTER TABLE `package`
  ADD CONSTRAINT `Package_ibfk_1` FOREIGN KEY (`Status`) REFERENCES `status` (`Code`);

ALTER TABLE `package`
  ADD CONSTRAINT `Package_ibfk_2` FOREIGN KEY (`Email`) REFERENCES `customer` (`Email`);

--
-- Constraints for table `CustomerCredentials`
--
ALTER TABLE `customercredentials`
  ADD CONSTRAINT `CustomerCredentials_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `customer` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE;

  --
-- Constraints for table `Tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `Tracking_ibfk_1` FOREIGN KEY (`Package_ID`) REFERENCES `package` (`PackageID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `EmployeeCredentials`
--
ALTER TABLE `employeecredentials`
  ADD CONSTRAINT `EmployeeCredentials_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Office`
--
ALTER TABLE `office`
  ADD CONSTRAINT `Office_ibfk_3` FOREIGN KEY (`OfficeID`) REFERENCES `vehicle` (`VIN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `Shift_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `Vehicle_ibfk_1` FOREIGN KEY (`DriverID`) REFERENCES `employee` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 28, 2019 at 09:28 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.0.33-8+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `distress_endpoint`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alert_messages`
--

CREATE TABLE `tbl_alert_messages` (
  `alert_message_id` int(11) NOT NULL,
  `fk_alert_type_id` int(11) NOT NULL,
  `alert_message` text NOT NULL,
  `response_code` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_alert_messages`
--

INSERT INTO `tbl_alert_messages` (`alert_message_id`, `fk_alert_type_id`, `alert_message`, `response_code`) VALUES
(1, 1, 'Earthquake may hit your location very soon. Evacuate Evacuate!', 50001000),
(2, 2, 'Cyclone will hit in your area. Move to safe place', 50002000),
(3, 3, 'Flash flood is approching your area, evacuate', 50003000),
(4, 4, 'Thunder may fall in your area, dont move in open area!', 50004000),
(5, 5, 'Alert High Tide Back to shore soon.', 50005000),
(6, 6, 'You are approaching international border move out soon .', 50006000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alert_type`
--

CREATE TABLE `tbl_alert_type` (
  `alert_type_id` int(11) NOT NULL,
  `alert_type` varchar(100) NOT NULL,
  `file` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_alert_type`
--

INSERT INTO `tbl_alert_type` (`alert_type_id`, `alert_type`, `file`) VALUES
(1, 'Earthquake/Tsunami', 'earthquake'),
(2, 'Cyclone/Hurricane/Tornado', 'cyclone'),
(3, 'Flood/GLOF/Cloud Burst', 'flood'),
(4, 'Thunder', 'thunder'),
(5, 'High Tide', 'hightide'),
(6, 'Other Alerts', 'border');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_disaster_messages`
--

CREATE TABLE `tbl_disaster_messages` (
  `disaster_message_id` int(11) NOT NULL,
  `fk_disaster_type_id` int(11) NOT NULL,
  `disaster_message` text NOT NULL,
  `response_code` int(8) NOT NULL,
  `type` varchar(20) NOT NULL,
  `labels` text,
  `file` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_disaster_messages`
--

INSERT INTO `tbl_disaster_messages` (`disaster_message_id`, `fk_disaster_type_id`, `disaster_message`, `response_code`, `type`, `labels`, `file`) VALUES
(1, 1, 'Submit damage, death and casualty report', 10003000, 'REQUEST', '', 'common'),
(2, 1, '', 10003001, 'RESPONSE', '[\"How Many People Died\",\"Human casulaities Number\",\"Number of House Damaged\",\"Is Road Blocked\",\"Number of Animal Death\",\"Animal casulaities Number\",\"Number of Electric Pole Destroyed\"]', ''),
(3, 1, 'Submit the expected number relief required', 10004000, 'REQUEST', '', 'relief'),
(4, 1, '', 10004001, 'RESPONSE', '[\"No of Food Packets Required\",\"Number of Drinking water packets\",\"Number of Polythenes\",\"Urgent rescue team required\",\"Number of People need to rescued from location - Need Airlift\",\"Please Send NDRF Personal (Number)\"]', ''),
(5, 2, 'Submit damage, death and casualty report', 20003000, 'REQUEST', '', 'common'),
(6, 2, '', 20003001, 'RESPONSE', '[\"How Many People Died\",\"Human casulaities Number\",\"Number of House Damaged\",\"Is Road Blocked\",\"Number of Animal Death\",\"Animal casulaities Number\",\"Number of Electric Pole Destroyed\"]', ''),
(7, 2, 'Submit the expected number relief required', 20004000, 'REQUEST', '', 'relief'),
(8, 2, '', 20004001, 'RESPONSE', '[\"No of Food Packets Required\",\"Number of Drinking water packets\",\"Number of Polythenes\",\"Urgent rescue team required\",\"Number of People need to rescued from location - Need Airlift\",\"Please Send NDRF Personal (Number)\"]', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_disaster_type`
--

CREATE TABLE `tbl_disaster_type` (
  `disaster_type_id` int(11) NOT NULL,
  `disaster_type` varchar(100) NOT NULL,
  `file` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_disaster_type`
--

INSERT INTO `tbl_disaster_type` (`disaster_type_id`, `disaster_type`, `file`) VALUES
(1, 'Earthquake/Tsunami', 'earthquake'),
(2, 'Cyclone/Hurricane/Tornado', 'cyclone'),
(3, 'Flood/GLOF/Cloud Burst', 'flood'),
(4, 'Thunder', 'thunder'),
(5, 'High Tide', 'hightide');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_alert_messages`
--
ALTER TABLE `tbl_alert_messages`
  ADD PRIMARY KEY (`alert_message_id`),
  ADD UNIQUE KEY `response_code` (`response_code`);

--
-- Indexes for table `tbl_alert_type`
--
ALTER TABLE `tbl_alert_type`
  ADD PRIMARY KEY (`alert_type_id`);

--
-- Indexes for table `tbl_disaster_messages`
--
ALTER TABLE `tbl_disaster_messages`
  ADD PRIMARY KEY (`disaster_message_id`),
  ADD UNIQUE KEY `response_code` (`response_code`);

--
-- Indexes for table `tbl_disaster_type`
--
ALTER TABLE `tbl_disaster_type`
  ADD PRIMARY KEY (`disaster_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_alert_messages`
--
ALTER TABLE `tbl_alert_messages`
  MODIFY `alert_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_alert_type`
--
ALTER TABLE `tbl_alert_type`
  MODIFY `alert_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_disaster_messages`
--
ALTER TABLE `tbl_disaster_messages`
  MODIFY `disaster_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_disaster_type`
--
ALTER TABLE `tbl_disaster_type`
  MODIFY `disaster_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

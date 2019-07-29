-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2019 at 08:27 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.0.33-8+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `distress_connect`
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
-- Table structure for table `tbl_dcu_cdu_association`
--

CREATE TABLE `tbl_dcu_cdu_association` (
  `dcu_id` int(11) NOT NULL,
  `cdcu_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_dcu_cdu_association`
--

INSERT INTO `tbl_dcu_cdu_association` (`dcu_id`, `cdcu_id`, `created_on`) VALUES
(4, 2, '2019-07-23 14:16:03'),
(5, 2, '2019-07-24 14:10:37');

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
(2, 1, '', 10003001, 'RESPONSE', '[\"How Many People Died\",\"Human casualties Number\",\"Number of House Damaged\",\"Is Road Blocked\",\"Number of Animal Death\",\"Animal casulaities Number\",\"Number of Electric Pole Destroyed\"]', ''),
(3, 1, 'Submit the expected number relief required', 10004000, 'REQUEST', '', 'relief'),
(4, 1, '', 10004001, 'RESPONSE', '[\"No of Food Packets Required\",\"Number of Drinking water packets\",\"Number of Polythenes\",\"Urgent rescue team required\",\"Number of People need to rescued from location - Need Airlift\",\"Please Send NDRF Personal (Number)\"]', ''),
(5, 2, 'Submit damage, death and casualty report', 20003000, 'REQUEST', '', 'common'),
(6, 2, '', 20003001, 'RESPONSE', '[\"How Many People Died\",\"Human casualties Number\",\"Number of House Damaged\",\"Is Road Blocked\",\"Number of Animal Death\",\"Animal casulaities Number\",\"Number of Electric Pole Destroyed\"]', ''),
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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_node_alerts`
--

CREATE TABLE `tbl_node_alerts` (
  `alert_id` int(11) NOT NULL,
  `node_key` varchar(20) NOT NULL,
  `alert_msg_code` int(8) NOT NULL,
  `fk_alert_type_id` int(11) NOT NULL,
  `created_date` date DEFAULT NULL,
  `created_datetime` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_node_alerts`
--

INSERT INTO `tbl_node_alerts` (`alert_id`, `node_key`, `alert_msg_code`, `fk_alert_type_id`, `created_date`, `created_datetime`) VALUES
(1, 'NODE-6', 50003000, 3, '2019-07-27', '2019-07-27 21:33:16'),
(2, 'NODE-7', 50003000, 3, '2019-07-27', '2019-07-27 21:33:16'),
(3, 'NODE-6', 50005000, 5, '2019-07-27', '2019-07-27 21:34:32'),
(4, 'NODE-9', 50002000, 2, '2019-07-27', '2019-07-27 21:35:43'),
(5, 'NODE-8', 50006000, 6, '2019-07-27', '2019-07-27 21:36:47'),
(6, 'NODE-7', 50005000, 5, '2019-07-27', '2019-07-27 21:38:18'),
(7, 'NODE-6', 50003000, 3, '2019-07-27', '2019-07-27 21:59:43'),
(8, 'NODE-7', 50003000, 3, '2019-07-27', '2019-07-27 21:59:43'),
(9, 'NODE-6', 50001000, 1, '2019-07-27', '2019-07-27 22:10:19'),
(10, 'NODE-7', 50001000, 1, '2019-07-27', '2019-07-27 22:10:19'),
(11, 'NODE-8', 50004000, 4, '2019-07-29', '2019-07-29 13:07:24'),
(12, 'NODE-9', 50004000, 4, '2019-07-29', '2019-07-29 13:07:24'),
(13, 'NODE-6', 50001000, 1, '2019-07-29', '2019-07-29 13:08:04'),
(14, 'NODE-7', 50001000, 1, '2019-07-29', '2019-07-29 13:08:04'),
(15, 'NODE-6', 50001000, 1, '2019-07-29', '2019-07-29 17:33:17'),
(16, 'NODE-6', 50003000, 3, '2019-07-29', '2019-07-29 17:34:20'),
(17, 'NODE-6', 50001000, 1, '2019-07-29', '2019-07-29 17:36:31'),
(18, 'NODE-6', 50002000, 2, '2019-07-29', '2019-07-29 17:37:38'),
(19, 'NODE-6', 50002000, 2, '2019-07-29', '2019-07-29 18:01:09'),
(20, 'NODE-6', 50002000, 2, '2019-07-29', '2019-07-29 18:05:29'),
(21, 'NODE-6', 50001000, 1, '2019-07-29', '2019-07-29 18:41:01'),
(22, 'NODE-6', 50001000, 1, '2019-07-29', '2019-07-29 19:05:49'),
(23, 'NODE-6', 50001000, 1, '2019-07-29', '2019-07-29 19:06:36'),
(24, 'NODE-6', 50001000, 1, '2019-07-29', '2019-07-29 19:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_node_dcu_cdcu_association`
--

CREATE TABLE `tbl_node_dcu_cdcu_association` (
  `node_id` int(11) NOT NULL,
  `dcu_id` int(11) NOT NULL,
  `cdcu_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_node_dcu_cdcu_association`
--

INSERT INTO `tbl_node_dcu_cdcu_association` (`node_id`, `dcu_id`, `cdcu_id`, `created_on`) VALUES
(6, 4, 2, '2019-07-23 14:24:22'),
(7, 4, 2, '2019-07-23 14:23:55'),
(8, 5, 2, '2019-07-24 14:11:02'),
(9, 5, 2, '2019-07-24 14:11:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_node_requests`
--

CREATE TABLE `tbl_node_requests` (
  `request_id` int(11) NOT NULL,
  `fk_msg_response_code` int(8) NOT NULL,
  `created_date` date DEFAULT NULL,
  `created_datetime` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_node_requests`
--

INSERT INTO `tbl_node_requests` (`request_id`, `fk_msg_response_code`, `created_date`, `created_datetime`) VALUES
(1, 10003000, '2019-07-27', '2019-07-27 12:49:38'),
(2, 20004000, '2019-07-27', '2019-07-27 12:57:45'),
(3, 10003000, '2019-07-27', '2019-07-27 19:47:50'),
(4, 10004000, '2019-07-27', '2019-07-27 19:48:54'),
(5, 10003000, '2019-07-27', '2019-07-27 19:49:41'),
(6, 10003000, '2019-07-27', '2019-07-27 20:01:34'),
(7, 10003000, '2019-07-27', '2019-07-27 20:05:37'),
(8, 10003000, '2019-07-27', '2019-07-27 20:07:06'),
(9, 10003000, '2019-07-27', '2019-07-27 20:08:49'),
(10, 10003000, '2019-07-27', '2019-07-27 20:09:41'),
(11, 20003000, '2019-07-27', '2019-07-27 20:10:55'),
(12, 10003000, '2019-07-27', '2019-07-27 20:11:37'),
(13, 10003000, '2019-07-27', '2019-07-27 20:13:06'),
(14, 10003000, '2019-07-27', '2019-07-27 21:04:06'),
(15, 10003000, '2019-07-27', '2019-07-27 21:05:14'),
(16, 10003000, '2019-07-27', '2019-07-27 21:06:16'),
(17, 10003000, '2019-07-27', '2019-07-27 21:08:06'),
(18, 10003000, '2019-07-27', '2019-07-27 21:11:34'),
(19, 10003000, '2019-07-27', '2019-07-27 21:13:06'),
(20, 10003000, '2019-07-27', '2019-07-27 21:13:48'),
(21, 10003000, '2019-07-27', '2019-07-27 21:15:33'),
(22, 10003000, '2019-07-27', '2019-07-27 21:18:19'),
(23, 10003000, '2019-07-27', '2019-07-27 21:20:45'),
(24, 10003000, '2019-07-27', '2019-07-27 21:23:12'),
(25, 10003000, '2019-07-27', '2019-07-27 21:41:58'),
(26, 10003000, '2019-07-27', '2019-07-27 21:44:27'),
(27, 10003000, '2019-07-27', '2019-07-27 21:45:42'),
(28, 10003000, '2019-07-27', '2019-07-27 21:48:17'),
(29, 10003000, '2019-07-27', '2019-07-27 21:53:41'),
(30, 10003000, '2019-07-27', '2019-07-27 21:56:49'),
(31, 10003000, '2019-07-27', '2019-07-27 21:59:23'),
(32, 10003000, '2019-07-27', '2019-07-27 22:10:58'),
(33, 10003000, '2019-07-27', '2019-07-27 22:13:02'),
(34, 10003000, '2019-07-27', '2019-07-27 22:13:12'),
(35, 10003000, '2019-07-28', '2019-07-28 12:15:02'),
(36, 10003000, '2019-07-28', '2019-07-28 12:16:02'),
(37, 10003000, '2019-07-28', '2019-07-28 19:33:17'),
(38, 20003000, '2019-07-28', '2019-07-28 19:34:38'),
(39, 20003000, '2019-07-28', '2019-07-28 19:35:19'),
(40, 10004000, '2019-07-28', '2019-07-28 21:20:09'),
(41, 20003000, '2019-07-28', '2019-07-28 21:20:59'),
(42, 20003000, '2019-07-29', '2019-07-29 11:56:47'),
(43, 20004000, '2019-07-29', '2019-07-29 15:38:07'),
(44, 10003000, '2019-07-29', '2019-07-29 17:38:02'),
(45, 10003000, '2019-07-29', '2019-07-29 17:39:21'),
(46, 10003000, '2019-07-29', '2019-07-29 17:39:51'),
(47, 20003000, '2019-07-29', '2019-07-29 17:40:25'),
(48, 10003000, '2019-07-29', '2019-07-29 17:42:31'),
(49, 10003000, '2019-07-29', '2019-07-29 17:43:09'),
(50, 10003000, '2019-07-29', '2019-07-29 17:50:11'),
(51, 20003000, '2019-07-29', '2019-07-29 17:51:23'),
(52, 10003000, '2019-07-29', '2019-07-29 17:52:00'),
(53, 20003000, '2019-07-29', '2019-07-29 17:52:41'),
(54, 20004000, '2019-07-29', '2019-07-29 17:53:58'),
(55, 10003000, '2019-07-29', '2019-07-29 17:54:26'),
(56, 10004000, '2019-07-29', '2019-07-29 17:55:06'),
(57, 20003000, '2019-07-29', '2019-07-29 17:57:08'),
(58, 10003000, '2019-07-29', '2019-07-29 17:59:17'),
(59, 10003000, '2019-07-29', '2019-07-29 18:37:18'),
(60, 10003000, '2019-07-29', '2019-07-29 18:40:37'),
(61, 10003000, '2019-07-29', '2019-07-29 18:50:57'),
(62, 20003000, '2019-07-29', '2019-07-29 18:51:21'),
(63, 10003000, '2019-07-29', '2019-07-29 18:51:47'),
(64, 10003000, '2019-07-29', '2019-07-29 18:52:37'),
(65, 10003000, '2019-07-29', '2019-07-29 18:55:53'),
(66, 10003000, '2019-07-29', '2019-07-29 18:56:20'),
(67, 10003000, '2019-07-29', '2019-07-29 18:56:35'),
(68, 10003000, '2019-07-29', '2019-07-29 18:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_node_request_details`
--

CREATE TABLE `tbl_node_request_details` (
  `node_request_id` int(11) NOT NULL,
  `fk_request_id` int(11) NOT NULL,
  `cdcu_key` varchar(30) NOT NULL,
  `dcu_key` varchar(30) NOT NULL,
  `node_key` varchar(100) NOT NULL,
  `fk_dis_type_id` int(11) NOT NULL,
  `msg_sent_req_code` int(8) NOT NULL,
  `msg_retrun_res_code` int(8) DEFAULT NULL,
  `msg_return_value` text,
  `status` varchar(20) NOT NULL,
  `ack_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_node_request_details`
--

INSERT INTO `tbl_node_request_details` (`node_request_id`, `fk_request_id`, `cdcu_key`, `dcu_key`, `node_key`, `fk_dis_type_id`, `msg_sent_req_code`, `msg_retrun_res_code`, `msg_return_value`, `status`, `ack_time`) VALUES
(1, 1, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, 10003001, '{\"How Many People Died\":\"2\",\"Human casualties Number\":\"4\",\"Number of House Damaged\":\"6\",\"Is Road Blocked\":\"NO\",\"Number of Animal Death\":\"10\",\"Animal casulaities Number\":\"12\",\"Number of Electric Pole Destroyed\":\"14\"}', 'SUCCESS', '2019-07-27 15:35:29'),
(2, 1, 'CDCU-2', 'DCU-4', 'NODE-7', 1, 10003000, 10003001, '{\"How Many People Died\":\"2\",\"Human casulaities Number\":\"4\",\"Number of House Damaged\":\"6\",\"Is Road Blocked\":\"NO\",\"Number of Animal Death\":\"10\",\"Animal casualties Number\":\"12\",\"Number of Electric Pole Destroyed\":\"14\"}', 'SUCCESS', '2019-07-27 15:36:34'),
(3, 2, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20003000, 20004001, '{\"No of Food Packets Required\":\"4\",\"Number of Drinking water packets\":\"3\",\"Number of Polythenes\":\"3\",\"Urgent rescue team required\":\"NO\",\"Number of People need to rescued from location - Need Airlift\":\"13\",\"Please Send NDRF Personal (Number)\":\"16\"}', 'SUCCESS', '2019-07-27 15:33:33'),
(4, 3, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(14, 8, 'CDCU-2', 'DCU-5', 'NODE-8', 1, 10003000, 10003001, '{\"How Many People Died\":\"2\",\"Human casualties Number\":\"4\",\"Number of House Damaged\":\"6\",\"Is Road Blocked\":\"NO\",\"Number of Animal Death\":\"10\",\"Animal casulaities Number\":\"12\",\"Number of Electric Pole Destroyed\":\"14\"}', 'SUCCESS', '2019-07-27 15:33:32'),
(15, 8, 'CDCU-2', 'DCU-5', 'NODE-9', 1, 10003000, 10003001, '{\"How Many People Died\":\"3\",\"Human casualties Number\":\"5\",\"Number of House Damaged\":\"7\",\"Is Road Blocked\":\"NO\",\"Number of Animal Death\":\"12\",\"Animal casulaities Number\":\"13\",\"Number of Electric Pole Destroyed\":\"15\"}', 'SUCCESS', '2019-07-27 15:33:34'),
(20, 11, 'CDCU-2', 'DCU-5', 'NODE-8', 2, 20003000, 20004001, '{\"No of Food Packets Required\":\"5\",\"Number of Drinking water packets\":\"2\",\"Number of Polythenes\":\"13\",\"Urgent rescue team required\":\"NO\",\"Number of People need to rescued from location - Need Airlift\":\"14\",\"Please Send NDRF Personal (Number)\":\"20\"}', 'SUCCESS', '2019-07-27 15:33:34'),
(21, 11, 'CDCU-2', 'DCU-5', 'NODE-9', 2, 20003000, 20004001, '{\"No of Food Packets Required\":\"1\",\"Number of Drinking water packets\":\"2\",\"Number of Polythenes\":\"3\",\"Urgent rescue team required\":\"NO\",\"Number of People need to rescued from location - Need Airlift\":\"8\",\"Please Send NDRF Personal (Number)\":\"6\"}', 'SUCCESS', '2019-07-27 15:33:34'),
(68, 37, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(69, 38, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20003000, NULL, NULL, 'INITIATED', NULL),
(70, 39, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20003000, 20003001, '{\"How Many People Died\":\"6\",\"Human casualties Number\":\"14\",\"Number of House Damaged\":\"16\",\"Is Road Blocked\":\"NO\",\"Number of Animal Death\":\"19\",\"Animal casulaities Number\":\"20\",\"Number of Electric Pole Destroyed\":\"17\"}', 'SUCCESS', '2019-07-28 21:17:01'),
(71, 40, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10004000, NULL, NULL, 'INITIATED', NULL),
(72, 41, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20003000, 20003001, '{\"How Many People Died\":\"10\",\"Human casualties Number\":\"2\",\"Number of House Damaged\":\"3\",\"Is Road Blocked\":\"NO\",\"Number of Animal Death\":\"5\",\"Animal casulaities Number\":\"15\",\"Number of Electric Pole Destroyed\":\"20\"}', 'SUCCESS', '2019-07-28 21:21:30'),
(73, 42, 'CDCU-2', 'DCU-5', 'NODE-8', 2, 20003000, NULL, NULL, 'INITIATED', NULL),
(74, 42, 'CDCU-2', 'DCU-5', 'NODE-9', 2, 20003000, NULL, NULL, 'INITIATED', NULL),
(75, 43, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20004000, 20004001, '{\"No of Food Packets Required\":\"3\",\"Number of Drinking water packets\":\"6\",\"Number of Polythenes\":\"8\",\"Urgent rescue team required\":\"NO\",\"Number of People need to rescued from location - Need Airlift\":\"14\",\"Please Send NDRF Personal (Number)\":\"19\"}', 'SUCCESS', '2019-07-29 15:53:37'),
(76, 44, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(77, 45, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(78, 46, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(79, 47, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20003000, NULL, NULL, 'INITIATED', NULL),
(80, 48, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(81, 49, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(82, 50, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(83, 51, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20003000, NULL, NULL, 'INITIATED', NULL),
(84, 52, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(85, 53, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20003000, NULL, NULL, 'INITIATED', NULL),
(86, 54, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20004000, NULL, NULL, 'INITIATED', NULL),
(87, 55, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(88, 56, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10004000, NULL, NULL, 'INITIATED', NULL),
(89, 57, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20003000, NULL, NULL, 'INITIATED', NULL),
(90, 58, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, 10003001, '{\"How Many People Died\":\"2\",\"Human casualties Number\":\"4\",\"Number of House Damaged\":\"7\",\"Is Road Blocked\":\"NO\",\"Number of Animal Death\":\"14\",\"Animal casulaities Number\":\"14\",\"Number of Electric Pole Destroyed\":\"20\"}', 'SUCCESS', '2019-07-29 18:00:43'),
(91, 59, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(92, 60, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(93, 61, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(94, 62, 'CDCU-2', 'DCU-4', 'NODE-6', 2, 20003000, NULL, NULL, 'INITIATED', NULL),
(95, 63, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(96, 64, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(97, 65, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(98, 66, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(99, 67, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, NULL, NULL, 'INITIATED', NULL),
(100, 68, 'CDCU-2', 'DCU-4', 'NODE-6', 1, 10003000, 10003001, '{\"How Many People Died\":\"2\",\"Human casualties Number\":\"4\",\"Number of House Damaged\":\"6\",\"Is Road Blocked\":\"NO\",\"Number of Animal Death\":\"8\",\"Animal casulaities Number\":\"10\",\"Number of Electric Pole Destroyed\":\"12\"}', 'SUCCESS', '2019-07-29 19:00:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_node_speech_message`
--

CREATE TABLE `tbl_node_speech_message` (
  `speech_msg_id` int(11) NOT NULL,
  `speech_message` text NOT NULL,
  `node_key` varchar(20) NOT NULL,
  `created_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_node_speech_message`
--

INSERT INTO `tbl_node_speech_message` (`speech_msg_id`, `speech_message`, `node_key`, `created_datetime`) VALUES
(1, 'Cyclone Will come', 'NODE-7', '2019-07-28 15:16:44'),
(2, 'Earthquake Started', 'NODE-5', '2019-07-28 15:17:16'),
(3, 'Flood will come', 'NODE-6', '2019-07-29 18:03:09'),
(4, 'Huricane alert', 'NODE-6', '2019-07-29 19:13:21'),
(5, 'Huricane alert', 'NODE-6', '2019-07-29 19:13:54'),
(6, 'Huricane alert', 'NODE-6', '2019-07-29 19:15:13'),
(7, 'Huricane alert', 'NODE-6', '2019-07-29 19:15:38'),
(8, 'Huricane alert', 'NODE-6', '2019-07-29 19:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_node_weather_message`
--

CREATE TABLE `tbl_node_weather_message` (
  `wheather_msg_id` int(11) NOT NULL,
  `humidity` varchar(20) NOT NULL,
  `temperature` varchar(20) NOT NULL,
  `node_key` varchar(20) NOT NULL,
  `created_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_node_weather_message`
--

INSERT INTO `tbl_node_weather_message` (`wheather_msg_id`, `humidity`, `temperature`, `node_key`, `created_datetime`) VALUES
(1, '88.20', '29.50', 'NODE-6', '2019-07-29 16:02:47'),
(2, '84.50', '29.70', 'NODE-6', '2019-07-29 18:08:05'),
(3, '85.20', '29.70', 'NODE-6', '2019-07-29 18:08:25'),
(4, '85.10', '29.70', 'NODE-6', '2019-07-29 18:08:34'),
(5, '85.10', '29.70', 'NODE-6', '2019-07-29 18:08:45'),
(6, '85.00', '29.70', 'NODE-6', '2019-07-29 18:08:54'),
(7, '85.00', '29.70', 'NODE-6', '2019-07-29 18:09:04'),
(8, '85.00', '29.70', 'NODE-6', '2019-07-29 18:09:15'),
(9, '85.10', '29.70', 'NODE-6', '2019-07-29 18:09:25'),
(10, '85.10', '29.70', 'NODE-6', '2019-07-29 18:09:35'),
(11, '85.20', '29.70', 'NODE-6', '2019-07-29 18:09:54'),
(12, '85.20', '29.70', 'NODE-6', '2019-07-29 18:10:05'),
(13, '85.20', '29.70', 'NODE-6', '2019-07-29 18:10:14'),
(14, '85.20', '29.70', 'NODE-6', '2019-07-29 18:10:24'),
(15, '85.30', '29.80', 'NODE-7', '2019-07-29 18:11:03'),
(16, '85.30', '29.80', 'NODE-7', '2019-07-29 18:11:14'),
(17, '85.20', '29.80', 'NODE-7', '2019-07-29 18:11:24'),
(18, '85.00', '29.70', 'NODE-7', '2019-07-29 18:11:33'),
(19, '85.00', '29.70', 'NODE-7', '2019-07-29 18:11:44'),
(20, '85.00', '29.70', 'NODE-7', '2019-07-29 18:12:03'),
(21, '85.20', '29.70', 'NODE-7', '2019-07-29 18:13:04'),
(22, '85.20', '29.70', 'NODE-7', '2019-07-29 18:13:34'),
(23, '85.00', '29.70', 'NODE-7', '2019-07-29 18:13:44'),
(24, '85.00', '29.70', 'NODE-7', '2019-07-29 18:14:03'),
(25, '85.00', '29.70', 'NODE-7', '2019-07-29 18:14:14'),
(26, '85.10', '29.70', 'NODE-8', '2019-07-29 18:14:43'),
(27, '85.10', '29.70', 'NODE-8', '2019-07-29 18:14:53'),
(28, '85.20', '29.70', 'NODE-8', '2019-07-29 18:15:34'),
(29, '85.30', '29.70', 'NODE-8', '2019-07-29 18:15:44'),
(30, '84.70', '29.70', 'NODE-6', '2019-07-29 18:16:00'),
(31, '85.30', '29.70', 'NODE-6', '2019-07-29 18:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_operation_track`
--

CREATE TABLE `tbl_operation_track` (
  `track_id` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` bigint(20) NOT NULL,
  `actionable_module` varchar(200) NOT NULL,
  `action_performed` varchar(200) NOT NULL,
  `fk_action_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_operation_track`
--

INSERT INTO `tbl_operation_track` (`track_id`, `updated_by`, `updated_on`, `actionable_module`, `action_performed`, `fk_action_id`) VALUES
(1, 1, 1564394178, 'USER', 'Change Password of admin', 1),
(2, 1, 1564394186, 'USER', 'Change Password of admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`role_id`, `role`, `description`) VALUES
(1, 'admin', 'ADMINISTRATOR'),
(2, 'node', 'LoRa END POINT'),
(3, 'dcu', 'DISTRESS CONTROL UNIT'),
(4, 'cdcu', 'CENTRAL DISTRESS CONTROL UNIT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role_permission`
--

CREATE TABLE `tbl_role_permission` (
  `rp_id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `operation_name` varchar(100) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 for no permission 1 for permission',
  `node` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 for no permission 1 for permission',
  `dcu` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 for no permission 1 for permission',
  `cdcu` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 for no permission 1 for permission'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_role_permission`
--

INSERT INTO `tbl_role_permission` (`rp_id`, `module_name`, `operation_name`, `admin`, `node`, `dcu`, `cdcu`) VALUES
(1, 'PAGE', 'users', 1, 0, 0, 0),
(2, 'PAGE', 'dashboard', 1, 1, 1, 1),
(3, 'PAGE', 'change_password', 1, 1, 1, 1),
(6, 'PAGE', 'role_matrix', 1, 0, 0, 0),
(7, 'PAGE', 'messages', 1, 0, 0, 0),
(8, 'MENU', 'DASHBOARD', 1, 1, 1, 1),
(9, 'MENU', 'USER', 1, 0, 0, 0),
(10, 'MENU', 'ROLE', 1, 0, 0, 0),
(11, 'MENU', 'SETTINGS', 1, 0, 0, 0),
(12, 'MENU', 'BACKUP_DATA', 1, 0, 0, 0),
(13, 'ROLE', 'DELETE_ROLE', 1, 0, 0, 0),
(14, 'ROLE', 'DISPLAY_ROLE', 1, 0, 0, 0),
(15, 'USER', 'CREATE_USER', 1, 0, 0, 0),
(16, 'USER', 'DISPLAY_USER', 1, 0, 0, 0),
(17, 'USER', 'EDIT_USER', 1, 0, 0, 0),
(18, 'USER', 'RESET_PASSWORD', 1, 0, 0, 0),
(19, 'USER', 'DELETE_USER', 1, 0, 0, 0),
(20, 'PAGE', 'configuration', 1, 0, 0, 0),
(21, 'MENU', 'CONFIGURATION', 1, 0, 0, 0),
(22, 'PAGE', 'get_node_status', 1, 0, 0, 0),
(23, 'MENU', 'GET_NODE_STATUS', 1, 0, 0, 0),
(24, 'PAGE', 'send_alerts', 1, 0, 0, 0),
(25, 'MENU', 'SEND_ALERTS', 1, 0, 0, 0),
(26, 'PAGE', 'speech_message', 1, 0, 0, 0),
(27, 'MENU', 'SPEECH_MESSAGE', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `fk_role_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 for inactive 1 for active',
  `address` varchar(200) DEFAULT NULL,
  `is_password_renew` int(11) DEFAULT '0',
  `renew_password` varchar(200) DEFAULT NULL,
  `last_login` varchar(30) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` bigint(20) NOT NULL,
  `last_ip_address` varchar(30) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `passkey` varchar(20) DEFAULT NULL,
  `pincode` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `fk_role_id`, `username`, `password`, `fullname`, `email`, `phone`, `status`, `address`, `is_password_renew`, `renew_password`, `last_login`, `created_by`, `created_on`, `last_ip_address`, `latitude`, `longitude`, `passkey`, `pincode`) VALUES
(1, 1, 'admin@distress.com', '2f3e17c29171b5ae19b61170a4308969', 'admin', 'admin@distress.com', '9399393939', 1, 'BBSR', 0, NULL, '1564409414', 1, 16000303003, '192.168.0.104', NULL, NULL, NULL, NULL),
(2, 4, 'cdcu1@distress.com', '2f3e17c29171b5ae19b61170a4308969', 'Cdcu', 'cdcu1@distress.com', '9349939399', 1, NULL, 0, NULL, '1564226981', 1, 1563783578, '127.0.0.1', '20.285743', '85.857872', 'CDCU-2', '763635'),
(4, 3, 'dcu1@distress.com', '493f356defffbdeb29d3291bdf8b4c22', 'Dcu1', 'dcu1@distress.com', '9349939391', 1, NULL, 0, NULL, NULL, 1, 1563792462, '127.0.0.1', '20.295636', '85.841874', 'DCU-4', '763631'),
(5, 3, 'dcu2@distress.com', '76c4f80455b899aed4f0cfc972e3bba3', 'Dcu2', 'dcu2@distress.com', '9349939388', 1, NULL, 0, NULL, NULL, 1, 1563792495, '127.0.0.1', '20.277876', '85.843403', 'DCU-5', '763631'),
(6, 2, 'node1@distress.com', 'a87852ca86cc0678141500830760d58e', 'Node1', 'node1@distress.com', '9349939310', 1, NULL, 0, NULL, NULL, 1, 1563792550, '127.0.0.1', '20.304439', '85.822216', 'NODE-6', '763631'),
(7, 2, 'node2@distress.com', 'fdd55589d9cd2820872d73d11ccb53a9', 'Node2', 'node2@distress.com', '9349939311', 1, NULL, 0, NULL, NULL, 1, 1563792588, '127.0.0.1', '20.295959', '85.822439', 'NODE-7', '763631'),
(8, 2, 'node3@distress.com', '396d4a3c8d0d4075269f8fc2d92918df', 'Node3', 'node3@distress.com', '9349939312', 1, NULL, 0, NULL, NULL, 1, 1563792639, '127.0.0.1', '20.285430', '85.824008', 'NODE-8', '763632'),
(9, 2, 'node4@distress.com', '517c0f040fcc4d5ddada99c2e8797090', 'Node4', 'node4@distress.com', '9349939313', 1, NULL, 0, NULL, NULL, 1, 1563792675, '127.0.0.1', '20.269229', '85.824577', 'NODE-9', '763632');

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
-- Indexes for table `tbl_dcu_cdu_association`
--
ALTER TABLE `tbl_dcu_cdu_association`
  ADD PRIMARY KEY (`dcu_id`,`cdcu_id`);

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
-- Indexes for table `tbl_node_alerts`
--
ALTER TABLE `tbl_node_alerts`
  ADD PRIMARY KEY (`alert_id`);

--
-- Indexes for table `tbl_node_dcu_cdcu_association`
--
ALTER TABLE `tbl_node_dcu_cdcu_association`
  ADD UNIQUE KEY `Composite Unique` (`node_id`,`dcu_id`,`cdcu_id`);

--
-- Indexes for table `tbl_node_requests`
--
ALTER TABLE `tbl_node_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `tbl_node_request_details`
--
ALTER TABLE `tbl_node_request_details`
  ADD PRIMARY KEY (`node_request_id`);

--
-- Indexes for table `tbl_node_speech_message`
--
ALTER TABLE `tbl_node_speech_message`
  ADD PRIMARY KEY (`speech_msg_id`);

--
-- Indexes for table `tbl_node_weather_message`
--
ALTER TABLE `tbl_node_weather_message`
  ADD PRIMARY KEY (`wheather_msg_id`);

--
-- Indexes for table `tbl_operation_track`
--
ALTER TABLE `tbl_operation_track`
  ADD PRIMARY KEY (`track_id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tbl_role_permission`
--
ALTER TABLE `tbl_role_permission`
  ADD PRIMARY KEY (`rp_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `pass_key` (`passkey`);

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
--
-- AUTO_INCREMENT for table `tbl_node_alerts`
--
ALTER TABLE `tbl_node_alerts`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `tbl_node_requests`
--
ALTER TABLE `tbl_node_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `tbl_node_request_details`
--
ALTER TABLE `tbl_node_request_details`
  MODIFY `node_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `tbl_node_speech_message`
--
ALTER TABLE `tbl_node_speech_message`
  MODIFY `speech_msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_node_weather_message`
--
ALTER TABLE `tbl_node_weather_message`
  MODIFY `wheather_msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `tbl_operation_track`
--
ALTER TABLE `tbl_operation_track`
  MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_role_permission`
--
ALTER TABLE `tbl_role_permission`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

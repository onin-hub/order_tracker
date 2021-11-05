-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 01, 2020 at 01:00 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ot_database`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `adminOViewsPaid` (IN `_paid` VARCHAR(100), IN `_ship_date` VARCHAR(100))  NO SQL
BEGIN
SET SESSION sql_mode = '';

SELECT
Month, 
COUNT(*) as 'Order Month'
from `ordersview`
WHERE `o_status` = _paid
AND YEAR(`ship_date`) = _ship_date
GROUP by Month;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `adminOViewsVoided` (IN `_voided` VARCHAR(100), IN `_ship_date_voided` VARCHAR(100))  NO SQL
BEGIN
SET SESSION sql_mode = '';

SELECT
Month, 
COUNT(*) as 'Order Month'
from `voidedorders`
WHERE `o_status` = _voided
AND YEAR(`ship_date_voided`) = _ship_date_voided
GROUP by Month;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filterByOstatusAndDate` (IN `date_start` VARCHAR(100), IN `date_end` VARCHAR(100), IN `o_status` VARCHAR(100))  NO SQL
BEGIN
SET SESSION sql_mode = '';

SELECT *
from `orderdetailsviews`
WHERE `hub_order_dispatched_date`
BETWEEN date_start 
AND date_end 
AND `o_status` = o_status;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filterByOstatusAndDateForDelivery` (IN `date_start` VARCHAR(100), IN `date_end` VARCHAR(100), IN `o_status` VARCHAR(100))  NO SQL
BEGIN
SET SESSION sql_mode = '';

SELECT *
from `filterbyostatusanddatefordelivery`
WHERE `shipper_for_delivery_date`
BETWEEN date_start 
AND date_end 
AND `o_status` = o_status;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `orderVoided` (IN `_voided` VARCHAR(100), IN `_ship_date_voided` VARCHAR(100), IN `_hub_area` VARCHAR(100))  NO SQL
BEGIN
SET SESSION sql_mode = '';

SELECT
Month, 
COUNT(*) as 'Order Month'
from `voidedorders`
WHERE `o_status` = _voided
AND YEAR(`ship_date_voided`) = _ship_date_voided
AND `hub_area` = _hub_area
GROUP by Month;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewpaid` (IN `_paid` LONGTEXT, IN `_ship_date` LONGTEXT, IN `_hub_area` LONGTEXT)  NO SQL
BEGIN
SET SESSION sql_mode = '';

SELECT
Month, 
COUNT(*) as 'Order Month'
from `ordersview`
WHERE `o_status` = _paid
AND YEAR(`ship_date`) = _ship_date
AND `hub_area` = _hub_area
GROUP by Month;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `zipcodeSearch` (IN `searchThisZip` VARCHAR(100))  NO SQL
BEGIN
SET SESSION sql_mode = '';

SELECT `hub_area`,`zip_code`, 
LOCATE(searchThisZip, zip_code) AS "zipcodePositionStart"
FROM `hub_area_number` WHERE 
LOCATE(searchThisZip, zip_code) > 0;


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_satisfaction_data`
--

CREATE TABLE `customer_satisfaction_data` (
  `id` int(255) NOT NULL,
  `customer_rate_id` varchar(255) NOT NULL,
  `c_fullname` varchar(255) NOT NULL,
  `c_rating` varchar(255) NOT NULL,
  `cus_img` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_satisfaction_data`
--

INSERT INTO `customer_satisfaction_data` (`id`, `customer_rate_id`, `c_fullname`, `c_rating`, `cus_img`, `date_create`) VALUES
(1, '1', 'Louise  Sarmiento', '5', 'assets/img/5f44d5c4814dc.png', '2020-08-25 17:11:32');

-- --------------------------------------------------------

--
-- Stand-in structure for view `filterbyostatusanddatefordelivery`
-- (See below for the actual view)
--
CREATE TABLE `filterbyostatusanddatefordelivery` (
`id` int(11)
,`order_date` varchar(255)
,`order_number` varchar(255)
,`c_fullname` varchar(255)
,`c_pnumber_one` varchar(255)
,`c_pnumber_two` varchar(255)
,`c_pnumber_primary` varchar(255)
,`c_email` varchar(255)
,`order_note` text
,`c_address_one` text
,`c_address_two` text
,`c_billing_add_one` text
,`c_billing_add_two` text
,`c_zipcode` varchar(255)
,`c_city` varchar(255)
,`o_total_price` varchar(255)
,`o_status` varchar(255)
,`o_cancelled_at` varchar(255)
,`o_payment_gateway` varchar(255)
,`o_special_discount` varchar(255)
,`o_card_id_number` varchar(255)
,`o_card_discount` varchar(255)
,`o_card_discount_number` varchar(255)
,`property_note` text
,`variant_price` varchar(255)
,`variant_name` varchar(255)
,`product_name` varchar(255)
,`total_quantity_sold` varchar(255)
,`hub_area` varchar(255)
,`shipper_user_id` varchar(255)
,`remarks` text
,`hub_order_dispatched_date_time` varchar(255)
,`hub_pending_date_time_voided` varchar(255)
,`shipper_for_delivery_date_time` varchar(255)
,`shipper_for_delivery_date` varchar(10)
,`shipper_for_delivered_date_time` varchar(255)
,`shipper_for_voided_date_time` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `filterbyostatusanddateforpaid`
-- (See below for the actual view)
--
CREATE TABLE `filterbyostatusanddateforpaid` (
`id` int(11)
,`order_date` varchar(255)
,`order_number` varchar(255)
,`c_fullname` varchar(255)
,`c_pnumber_one` varchar(255)
,`c_pnumber_two` varchar(255)
,`c_pnumber_primary` varchar(255)
,`c_email` varchar(255)
,`order_note` text
,`c_address_one` text
,`c_address_two` text
,`c_billing_add_one` text
,`c_billing_add_two` text
,`c_zipcode` varchar(255)
,`c_city` varchar(255)
,`o_total_price` varchar(255)
,`o_status` varchar(255)
,`o_cancelled_at` varchar(255)
,`o_payment_gateway` varchar(255)
,`o_special_discount` varchar(255)
,`o_card_id_number` varchar(255)
,`o_card_discount` varchar(255)
,`o_card_discount_number` varchar(255)
,`property_note` text
,`variant_price` varchar(255)
,`variant_name` varchar(255)
,`product_name` varchar(255)
,`total_quantity_sold` varchar(255)
,`hub_area` varchar(255)
,`shipper_user_id` varchar(255)
,`remarks` text
,`hub_order_dispatched_date_time` varchar(255)
,`hub_pending_date_time_voided` varchar(255)
,`shipper_for_delivery_date_time` varchar(255)
,`shipper_for_delivered_date_time` varchar(255)
,`shipper_for_delivered_date` varchar(10)
,`shipper_for_voided_date_time` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `filterbyostatusanddateforvoided`
-- (See below for the actual view)
--
CREATE TABLE `filterbyostatusanddateforvoided` (
`id` int(11)
,`order_date` varchar(255)
,`order_number` varchar(255)
,`c_fullname` varchar(255)
,`c_pnumber_one` varchar(255)
,`c_pnumber_two` varchar(255)
,`c_pnumber_primary` varchar(255)
,`c_email` varchar(255)
,`order_note` text
,`c_address_one` text
,`c_address_two` text
,`c_billing_add_one` text
,`c_billing_add_two` text
,`c_zipcode` varchar(255)
,`c_city` varchar(255)
,`o_total_price` varchar(255)
,`o_status` varchar(255)
,`o_cancelled_at` varchar(255)
,`o_payment_gateway` varchar(255)
,`o_special_discount` varchar(255)
,`o_card_id_number` varchar(255)
,`o_card_discount` varchar(255)
,`o_card_discount_number` varchar(255)
,`property_note` text
,`variant_price` varchar(255)
,`variant_name` varchar(255)
,`product_name` varchar(255)
,`total_quantity_sold` varchar(255)
,`hub_area` varchar(255)
,`shipper_user_id` varchar(255)
,`remarks` text
,`hub_order_dispatched_date_time` varchar(255)
,`hub_pending_date_time_voided` varchar(255)
,`shipper_for_delivery_date_time` varchar(255)
,`shipper_for_delivered_date_time` varchar(255)
,`shipper_for_voided_date_time` varchar(255)
,`date_voided_by_hub_or_shipper` varchar(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `hub_area_number`
--

CREATE TABLE `hub_area_number` (
  `id` int(11) NOT NULL,
  `hub_area` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hub_area_number`
--

INSERT INTO `hub_area_number` (`id`, `hub_area`, `zip_code`) VALUES
(11, 'FO02 - NEPO', '2009'),
(12, 'FO03 - FIELDS MCARTHUR', '2009'),
(13, 'FO09 - DAU ', '2010,2026'),
(14, 'FO26 - SF BAYAN', '2000,2009'),
(15, 'FO15 - BALITI', '2000,2009,2001'),
(16, 'FOMP01 - DOLORES', '2000'),
(17, 'FO45 - STA. ANA (*STAND ALONE)', '2014,2021'),
(18, 'FO14 - APALIT', '2017,2018,2020,2019,2015,2016'),
(19, 'FO51 - MEYCAUAYAN', '3019,3004,3022,3023,3020'),
(20, 'FO54 - VALENZUELA', '1470,1440,1442'),
(21, 'FO61 - FAIRVIEW', '1420,1127,1123,1118'),
(22, 'FO79 - VISAYAS AVE.', '1104,1103,1100,1105,1110'),
(23, 'FO160 - ANNAPOLIS ', '1110,1500'),
(24, 'FO106 - TRABAJO MARKET', '1114,1113,1008'),
(25, 'FO68 - OLONGAPO MARKET', '2200'),
(26, 'FO73 - SUBIC CENTRO', '2200,2209,2208'),
(27, 'FO27 - PORAC', '2008'),
(28, 'FO23 - FLORIDA ', '2005,2006,2110,2112,2100,2105'),
(29, 'FO32 - GUAGUA', '2003,2005,2020,2002,1709'),
(30, 'FO119 - SAN GABRIEL', ''),
(31, 'FO155 - MABUHAY HOMES', '4114'),
(32, 'FO157 - SAN MIGUEL UNO', '4118'),
(33, 'FO125 - MABINI', '4024,4023,1773'),
(34, 'FO142 - BANLIC', '4026,4025,4027'),
(35, 'FO136 - LOS BANOS ', '4030'),
(36, 'FO133 - BINAKAYAN', '4103,4107,4104'),
(37, 'FO135 - SAN FRANCISCO', '4107,4114'),
(38, 'FO163 - SPRINGVILLE', '4135,4102'),
(39, 'FO153 - GREENWOODS ', '1224,1800'),
(40, 'FO154 - BFRESORT DRIVE', '1747,1700'),
(41, 'FO49 - SAN VICENTE', '2301,2300'),
(42, 'FO132 - URDANETA (*STAND ALONE) ', '2428'),
(43, 'FO34 - CAPAS (*STAND ALONE)', '2315'),
(44, 'FO33 - CONCEPCION (*STAND ALONE)', '2316'),
(45, 'FO165 - CARITAN', '3311');

-- --------------------------------------------------------

--
-- Table structure for table `not_available_item_history`
--

CREATE TABLE `not_available_item_history` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_fname_lname` varchar(255) NOT NULL,
  `hub_area` varchar(255) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `date_not_available` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `orderdetailsviews`
-- (See below for the actual view)
--
CREATE TABLE `orderdetailsviews` (
`id` int(11)
,`order_date` varchar(255)
,`order_number` varchar(255)
,`c_fullname` varchar(255)
,`c_pnumber_one` varchar(255)
,`c_pnumber_two` varchar(255)
,`c_pnumber_primary` varchar(255)
,`c_email` varchar(255)
,`order_note` text
,`c_address_one` text
,`c_address_two` text
,`c_billing_add_one` text
,`c_billing_add_two` text
,`c_zipcode` varchar(255)
,`c_city` varchar(255)
,`o_total_price` varchar(255)
,`o_status` varchar(255)
,`o_cancelled_at` varchar(255)
,`o_payment_gateway` varchar(255)
,`o_special_discount` varchar(255)
,`o_card_id_number` varchar(255)
,`o_card_discount` varchar(255)
,`o_card_discount_number` varchar(255)
,`property_note` text
,`variant_price` varchar(255)
,`variant_name` varchar(255)
,`product_name` varchar(255)
,`total_quantity_sold` varchar(255)
,`hub_area` varchar(255)
,`shipper_user_id` varchar(255)
,`remarks` text
,`hub_order_dispatched_date_time` varchar(255)
,`hub_order_dispatched_date` varchar(10)
,`hub_pending_date_time_voided` varchar(255)
,`shipper_for_delivery_date_time` varchar(255)
,`shipper_for_delivered_date_time` varchar(255)
,`shipper_for_voided_date_time` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ordersview`
-- (See below for the actual view)
--
CREATE TABLE `ordersview` (
`order_number` varchar(255)
,`o_status` varchar(255)
,`Month` int(2)
,`hub_area` varchar(255)
,`ship_date` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `c_fullname` varchar(255) DEFAULT NULL,
  `c_pnumber_one` varchar(255) DEFAULT NULL,
  `c_pnumber_two` varchar(255) DEFAULT NULL,
  `c_pnumber_primary` varchar(255) DEFAULT NULL,
  `c_email` varchar(255) DEFAULT NULL,
  `order_note` text,
  `c_address_one` text,
  `c_address_two` text,
  `c_billing_add_one` text,
  `c_billing_add_two` text,
  `c_zipcode` varchar(255) DEFAULT NULL,
  `c_city` varchar(255) DEFAULT NULL,
  `o_total_price` varchar(255) DEFAULT NULL,
  `o_status` varchar(255) DEFAULT NULL,
  `o_cancelled_at` varchar(255) DEFAULT NULL,
  `o_payment_gateway` varchar(255) DEFAULT NULL,
  `o_special_discount` varchar(255) DEFAULT NULL,
  `o_card_id_number` varchar(255) DEFAULT NULL,
  `o_card_discount` varchar(255) DEFAULT NULL,
  `o_card_discount_number` varchar(255) DEFAULT NULL,
  `property_note` text,
  `variant_price` varchar(255) DEFAULT NULL,
  `variant_name` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `total_quantity_sold` varchar(255) DEFAULT NULL,
  `hub_area` varchar(255) DEFAULT NULL,
  `shipper_user_id` varchar(255) DEFAULT NULL,
  `remarks` text,
  `hub_order_dispatched_date_time` varchar(255) DEFAULT NULL,
  `hub_pending_date_time_voided` varchar(255) DEFAULT NULL,
  `shipper_for_delivery_date_time` varchar(255) DEFAULT NULL,
  `shipper_for_delivered_date_time` varchar(255) DEFAULT NULL,
  `shipper_for_voided_date_time` varchar(255) DEFAULT NULL,
  `consolidator_date_time_voided_order` varchar(255) DEFAULT NULL,
  `date_time_voided_by_hub_and_shipper` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_import_history`
--

CREATE TABLE `order_import_history` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `hub_area` varchar(255) DEFAULT NULL,
  `order_number` text,
  `c_name` text,
  `date_import` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_fname_lname` varchar(255) NOT NULL,
  `user_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return_history_order`
--

CREATE TABLE `return_history_order` (
  `id` int(11) NOT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `c_fullname` varchar(255) DEFAULT NULL,
  `c_address_one` text,
  `c_address_two` text,
  `c_billing_add_one` text,
  `c_billing_add_two` text,
  `c_pnumber_primary` varchar(255) DEFAULT NULL,
  `c_pnumber_one` varchar(255) DEFAULT NULL,
  `c_pnumber_two` varchar(255) DEFAULT NULL,
  `c_zipcode` varchar(255) DEFAULT NULL,
  `date_returned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hub_area` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `return_history_order`
--

INSERT INTO `return_history_order` (`id`, `order_date`, `order_number`, `c_fullname`, `c_address_one`, `c_address_two`, `c_billing_add_one`, `c_billing_add_two`, `c_pnumber_primary`, `c_pnumber_one`, `c_pnumber_two`, `c_zipcode`, `date_returned`, `hub_area`, `remarks`) VALUES
(1, '2020/07/23', 'FOO3078', 'Louise  Sarmiento', 'B13 L7 Montreal St. Metro Clark Homes, Mawaque', '', 'B13 L7 Montreal St. Metro Clark Homes, Mawaque', '', '9063473575', '045 409 0050', '045 409 0050', '10', '2020-08-25 09:08:32', 'FO165 - CARITAN', 'test return'),
(2, '2020/07/23', 'FOO3078', 'Louise  Sarmiento', 'B13 L7 Montreal St. Metro Clark Homes, Mawaque', '', 'B13 L7 Montreal St. Metro Clark Homes, Mawaque', '', '9063473575', '045 409 0050', '045 409 0050', '10', '2020-08-25 09:09:40', 'FO119 - SAN GABRIEL', 'sample return');

-- --------------------------------------------------------

--
-- Table structure for table `users_table`
--

CREATE TABLE `users_table` (
  `id` int(11) NOT NULL,
  `first_name` varchar(65) DEFAULT NULL,
  `last_name` varchar(65) DEFAULT NULL,
  `user_username` varchar(65) DEFAULT NULL,
  `user_password` varchar(65) DEFAULT NULL,
  `user_contact_number` varchar(65) DEFAULT NULL,
  `user_role` varchar(65) DEFAULT NULL,
  `hub_area` varchar(65) DEFAULT NULL,
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`id`, `first_name`, `last_name`, `user_username`, `user_password`, `user_contact_number`, `user_role`, `hub_area`, `date_joined`) VALUES
(1, 'Onin', 'Tuvera', 'Admin', '1234', '09067100489', 'Admin', NULL, '2020-08-12 07:01:11'),
(17, 'Sundar', 'Pichai', 'supervisor', '1234', '23123213123', 'Hub Supervisor', 'FO119 - SAN GABRIEL', '2020-08-17 07:57:53'),
(18, 'Taylor', 'Otwell', 'shipper', '1234', '09067100489', 'Shipper', 'FO119 - SAN GABRIEL', '2020-08-18 08:33:31'),
(19, 'Mark', 'Zuckerberg', 'consolidator', '1234', '12312312312', 'Consolidator', '', '2020-08-19 00:30:18'),
(20, 'Super', 'Super', 'Super', '1234', '213123', 'Hub Supervisor', 'FO165 - CARITAN', '2020-08-25 09:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `user_log_in_history`
--

CREATE TABLE `user_log_in_history` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `log_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_log_in_history`
--

INSERT INTO `user_log_in_history` (`id`, `user_id`, `user_name`, `log_date_time`) VALUES
(1, '1', 'Onin Tuvera', '2020-08-24 08:32:57'),
(2, '1', 'Onin Tuvera', '2020-08-25 00:09:30'),
(3, '17', 'Sundar Pichai', '2020-08-25 00:10:43'),
(4, '20', 'Super Super', '2020-08-25 09:03:48'),
(5, '17', 'Sundar Pichai', '2020-08-25 09:09:07'),
(6, '18', 'Taylor Otwell', '2020-08-25 09:11:11');

-- --------------------------------------------------------

--
-- Stand-in structure for view `voidedorders`
-- (See below for the actual view)
--
CREATE TABLE `voidedorders` (
`order_number` varchar(255)
,`o_status` varchar(255)
,`Month` int(2)
,`hub_area` varchar(255)
,`ship_date_voided` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `filterbyostatusanddatefordelivery`
--
DROP TABLE IF EXISTS `filterbyostatusanddatefordelivery`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `filterbyostatusanddatefordelivery`  AS  select `order_details`.`id` AS `id`,`order_details`.`order_date` AS `order_date`,`order_details`.`order_number` AS `order_number`,`order_details`.`c_fullname` AS `c_fullname`,`order_details`.`c_pnumber_one` AS `c_pnumber_one`,`order_details`.`c_pnumber_two` AS `c_pnumber_two`,`order_details`.`c_pnumber_primary` AS `c_pnumber_primary`,`order_details`.`c_email` AS `c_email`,`order_details`.`order_note` AS `order_note`,`order_details`.`c_address_one` AS `c_address_one`,`order_details`.`c_address_two` AS `c_address_two`,`order_details`.`c_billing_add_one` AS `c_billing_add_one`,`order_details`.`c_billing_add_two` AS `c_billing_add_two`,`order_details`.`c_zipcode` AS `c_zipcode`,`order_details`.`c_city` AS `c_city`,`order_details`.`o_total_price` AS `o_total_price`,`order_details`.`o_status` AS `o_status`,`order_details`.`o_cancelled_at` AS `o_cancelled_at`,`order_details`.`o_payment_gateway` AS `o_payment_gateway`,`order_details`.`o_special_discount` AS `o_special_discount`,`order_details`.`o_card_id_number` AS `o_card_id_number`,`order_details`.`o_card_discount` AS `o_card_discount`,`order_details`.`o_card_discount_number` AS `o_card_discount_number`,`order_details`.`property_note` AS `property_note`,`order_details`.`variant_price` AS `variant_price`,`order_details`.`variant_name` AS `variant_name`,`order_details`.`product_name` AS `product_name`,`order_details`.`total_quantity_sold` AS `total_quantity_sold`,`order_details`.`hub_area` AS `hub_area`,`order_details`.`shipper_user_id` AS `shipper_user_id`,`order_details`.`remarks` AS `remarks`,`order_details`.`hub_order_dispatched_date_time` AS `hub_order_dispatched_date_time`,`order_details`.`hub_pending_date_time_voided` AS `hub_pending_date_time_voided`,`order_details`.`shipper_for_delivery_date_time` AS `shipper_for_delivery_date_time`,date_format(`order_details`.`shipper_for_delivery_date_time`,'%Y/%m/%d') AS `shipper_for_delivery_date`,`order_details`.`shipper_for_delivered_date_time` AS `shipper_for_delivered_date_time`,`order_details`.`shipper_for_voided_date_time` AS `shipper_for_voided_date_time` from `order_details` ;

-- --------------------------------------------------------

--
-- Structure for view `filterbyostatusanddateforpaid`
--
DROP TABLE IF EXISTS `filterbyostatusanddateforpaid`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `filterbyostatusanddateforpaid`  AS  select `order_details`.`id` AS `id`,`order_details`.`order_date` AS `order_date`,`order_details`.`order_number` AS `order_number`,`order_details`.`c_fullname` AS `c_fullname`,`order_details`.`c_pnumber_one` AS `c_pnumber_one`,`order_details`.`c_pnumber_two` AS `c_pnumber_two`,`order_details`.`c_pnumber_primary` AS `c_pnumber_primary`,`order_details`.`c_email` AS `c_email`,`order_details`.`order_note` AS `order_note`,`order_details`.`c_address_one` AS `c_address_one`,`order_details`.`c_address_two` AS `c_address_two`,`order_details`.`c_billing_add_one` AS `c_billing_add_one`,`order_details`.`c_billing_add_two` AS `c_billing_add_two`,`order_details`.`c_zipcode` AS `c_zipcode`,`order_details`.`c_city` AS `c_city`,`order_details`.`o_total_price` AS `o_total_price`,`order_details`.`o_status` AS `o_status`,`order_details`.`o_cancelled_at` AS `o_cancelled_at`,`order_details`.`o_payment_gateway` AS `o_payment_gateway`,`order_details`.`o_special_discount` AS `o_special_discount`,`order_details`.`o_card_id_number` AS `o_card_id_number`,`order_details`.`o_card_discount` AS `o_card_discount`,`order_details`.`o_card_discount_number` AS `o_card_discount_number`,`order_details`.`property_note` AS `property_note`,`order_details`.`variant_price` AS `variant_price`,`order_details`.`variant_name` AS `variant_name`,`order_details`.`product_name` AS `product_name`,`order_details`.`total_quantity_sold` AS `total_quantity_sold`,`order_details`.`hub_area` AS `hub_area`,`order_details`.`shipper_user_id` AS `shipper_user_id`,`order_details`.`remarks` AS `remarks`,`order_details`.`hub_order_dispatched_date_time` AS `hub_order_dispatched_date_time`,`order_details`.`hub_pending_date_time_voided` AS `hub_pending_date_time_voided`,`order_details`.`shipper_for_delivery_date_time` AS `shipper_for_delivery_date_time`,`order_details`.`shipper_for_delivered_date_time` AS `shipper_for_delivered_date_time`,date_format(`order_details`.`shipper_for_delivered_date_time`,'%Y/%m/%d') AS `shipper_for_delivered_date`,`order_details`.`shipper_for_voided_date_time` AS `shipper_for_voided_date_time` from `order_details` ;

-- --------------------------------------------------------

--
-- Structure for view `filterbyostatusanddateforvoided`
--
DROP TABLE IF EXISTS `filterbyostatusanddateforvoided`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `filterbyostatusanddateforvoided`  AS  select `order_details`.`id` AS `id`,`order_details`.`order_date` AS `order_date`,`order_details`.`order_number` AS `order_number`,`order_details`.`c_fullname` AS `c_fullname`,`order_details`.`c_pnumber_one` AS `c_pnumber_one`,`order_details`.`c_pnumber_two` AS `c_pnumber_two`,`order_details`.`c_pnumber_primary` AS `c_pnumber_primary`,`order_details`.`c_email` AS `c_email`,`order_details`.`order_note` AS `order_note`,`order_details`.`c_address_one` AS `c_address_one`,`order_details`.`c_address_two` AS `c_address_two`,`order_details`.`c_billing_add_one` AS `c_billing_add_one`,`order_details`.`c_billing_add_two` AS `c_billing_add_two`,`order_details`.`c_zipcode` AS `c_zipcode`,`order_details`.`c_city` AS `c_city`,`order_details`.`o_total_price` AS `o_total_price`,`order_details`.`o_status` AS `o_status`,`order_details`.`o_cancelled_at` AS `o_cancelled_at`,`order_details`.`o_payment_gateway` AS `o_payment_gateway`,`order_details`.`o_special_discount` AS `o_special_discount`,`order_details`.`o_card_id_number` AS `o_card_id_number`,`order_details`.`o_card_discount` AS `o_card_discount`,`order_details`.`o_card_discount_number` AS `o_card_discount_number`,`order_details`.`property_note` AS `property_note`,`order_details`.`variant_price` AS `variant_price`,`order_details`.`variant_name` AS `variant_name`,`order_details`.`product_name` AS `product_name`,`order_details`.`total_quantity_sold` AS `total_quantity_sold`,`order_details`.`hub_area` AS `hub_area`,`order_details`.`shipper_user_id` AS `shipper_user_id`,`order_details`.`remarks` AS `remarks`,`order_details`.`hub_order_dispatched_date_time` AS `hub_order_dispatched_date_time`,`order_details`.`hub_pending_date_time_voided` AS `hub_pending_date_time_voided`,`order_details`.`shipper_for_delivery_date_time` AS `shipper_for_delivery_date_time`,`order_details`.`shipper_for_delivered_date_time` AS `shipper_for_delivered_date_time`,`order_details`.`shipper_for_voided_date_time` AS `shipper_for_voided_date_time`,date_format(`order_details`.`date_time_voided_by_hub_and_shipper`,'%Y/%m/%d') AS `date_voided_by_hub_or_shipper` from `order_details` ;

-- --------------------------------------------------------

--
-- Structure for view `orderdetailsviews`
--
DROP TABLE IF EXISTS `orderdetailsviews`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `orderdetailsviews`  AS  select `order_details`.`id` AS `id`,`order_details`.`order_date` AS `order_date`,`order_details`.`order_number` AS `order_number`,`order_details`.`c_fullname` AS `c_fullname`,`order_details`.`c_pnumber_one` AS `c_pnumber_one`,`order_details`.`c_pnumber_two` AS `c_pnumber_two`,`order_details`.`c_pnumber_primary` AS `c_pnumber_primary`,`order_details`.`c_email` AS `c_email`,`order_details`.`order_note` AS `order_note`,`order_details`.`c_address_one` AS `c_address_one`,`order_details`.`c_address_two` AS `c_address_two`,`order_details`.`c_billing_add_one` AS `c_billing_add_one`,`order_details`.`c_billing_add_two` AS `c_billing_add_two`,`order_details`.`c_zipcode` AS `c_zipcode`,`order_details`.`c_city` AS `c_city`,`order_details`.`o_total_price` AS `o_total_price`,`order_details`.`o_status` AS `o_status`,`order_details`.`o_cancelled_at` AS `o_cancelled_at`,`order_details`.`o_payment_gateway` AS `o_payment_gateway`,`order_details`.`o_special_discount` AS `o_special_discount`,`order_details`.`o_card_id_number` AS `o_card_id_number`,`order_details`.`o_card_discount` AS `o_card_discount`,`order_details`.`o_card_discount_number` AS `o_card_discount_number`,`order_details`.`property_note` AS `property_note`,`order_details`.`variant_price` AS `variant_price`,`order_details`.`variant_name` AS `variant_name`,`order_details`.`product_name` AS `product_name`,`order_details`.`total_quantity_sold` AS `total_quantity_sold`,`order_details`.`hub_area` AS `hub_area`,`order_details`.`shipper_user_id` AS `shipper_user_id`,`order_details`.`remarks` AS `remarks`,`order_details`.`hub_order_dispatched_date_time` AS `hub_order_dispatched_date_time`,date_format(`order_details`.`hub_order_dispatched_date_time`,'%Y/%m/%d') AS `hub_order_dispatched_date`,`order_details`.`hub_pending_date_time_voided` AS `hub_pending_date_time_voided`,`order_details`.`shipper_for_delivery_date_time` AS `shipper_for_delivery_date_time`,`order_details`.`shipper_for_delivered_date_time` AS `shipper_for_delivered_date_time`,`order_details`.`shipper_for_voided_date_time` AS `shipper_for_voided_date_time` from `order_details` ;

-- --------------------------------------------------------

--
-- Structure for view `ordersview`
--
DROP TABLE IF EXISTS `ordersview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ordersview`  AS  select distinct `order_details`.`order_number` AS `order_number`,`order_details`.`o_status` AS `o_status`,month(`order_details`.`shipper_for_delivered_date_time`) AS `Month`,`order_details`.`hub_area` AS `hub_area`,`order_details`.`shipper_for_delivered_date_time` AS `ship_date` from `order_details` ;

-- --------------------------------------------------------

--
-- Structure for view `voidedorders`
--
DROP TABLE IF EXISTS `voidedorders`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `voidedorders`  AS  select distinct `order_details`.`order_number` AS `order_number`,`order_details`.`o_status` AS `o_status`,month(`order_details`.`date_time_voided_by_hub_and_shipper`) AS `Month`,`order_details`.`hub_area` AS `hub_area`,`order_details`.`date_time_voided_by_hub_and_shipper` AS `ship_date_voided` from `order_details` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_satisfaction_data`
--
ALTER TABLE `customer_satisfaction_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hub_area_number`
--
ALTER TABLE `hub_area_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `not_available_item_history`
--
ALTER TABLE `not_available_item_history`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_import_history`
--
ALTER TABLE `order_import_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_history_order`
--
ALTER TABLE `return_history_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_table_hub_area` (`hub_area`);

--
-- Indexes for table `user_log_in_history`
--
ALTER TABLE `user_log_in_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_satisfaction_data`
--
ALTER TABLE `customer_satisfaction_data`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hub_area_number`
--
ALTER TABLE `hub_area_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `not_available_item_history`
--
ALTER TABLE `not_available_item_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_import_history`
--
ALTER TABLE `order_import_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_history_order`
--
ALTER TABLE `return_history_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_log_in_history`
--
ALTER TABLE `user_log_in_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

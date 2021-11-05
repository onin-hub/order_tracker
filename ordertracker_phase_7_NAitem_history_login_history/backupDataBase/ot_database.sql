-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 24, 2020 at 02:49 AM
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
(1, '1', 'Arden Mary  Prado', '2', 'assets/img/pic1.png', '2020-07-24 09:25:22'),
(2, '7', 'Louise  Sarmiento', '2', 'assets/img/WIN_20200708_15_07_07_Pro.jpg', '2020-07-24 09:30:53'),
(3, '11', 'Louise  Sarmiento', '2', 'assets/img/pic4.jpg', '2020-07-24 10:44:57');

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
,`order_note` varchar(255)
,`c_address_one` varchar(255)
,`c_address_two` varchar(255)
,`c_billing_add_one` varchar(255)
,`c_billing_add_two` varchar(255)
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
,`property_note` varchar(255)
,`variant_price` varchar(255)
,`variant_name` varchar(255)
,`product_name` varchar(255)
,`total_quantity_sold` varchar(255)
,`hub_area` varchar(255)
,`shipper_user_id` varchar(255)
,`remarks` varchar(255)
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
,`order_note` varchar(255)
,`c_address_one` varchar(255)
,`c_address_two` varchar(255)
,`c_billing_add_one` varchar(255)
,`c_billing_add_two` varchar(255)
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
,`property_note` varchar(255)
,`variant_price` varchar(255)
,`variant_name` varchar(255)
,`product_name` varchar(255)
,`total_quantity_sold` varchar(255)
,`hub_area` varchar(255)
,`shipper_user_id` varchar(255)
,`remarks` varchar(255)
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
,`order_note` varchar(255)
,`c_address_one` varchar(255)
,`c_address_two` varchar(255)
,`c_billing_add_one` varchar(255)
,`c_billing_add_two` varchar(255)
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
,`property_note` varchar(255)
,`variant_price` varchar(255)
,`variant_name` varchar(255)
,`product_name` varchar(255)
,`total_quantity_sold` varchar(255)
,`hub_area` varchar(255)
,`shipper_user_id` varchar(255)
,`remarks` varchar(255)
,`hub_order_dispatched_date_time` varchar(255)
,`hub_pending_date_time_voided` varchar(255)
,`shipper_for_delivery_date_time` varchar(255)
,`shipper_for_delivered_date_time` varchar(255)
,`shipper_for_voided_date_time` varchar(255)
,`shipper_for_voided_date` varchar(10)
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
(122, 'FO102', '2000,2001,20022'),
(123, 'FO01', '2003,2004,2005'),
(124, 'FOO200', '2131,213123,4341,534345'),
(125, 'FO3000', '3000,2003,30001');

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
,`order_note` varchar(255)
,`c_address_one` varchar(255)
,`c_address_two` varchar(255)
,`c_billing_add_one` varchar(255)
,`c_billing_add_two` varchar(255)
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
,`property_note` varchar(255)
,`variant_price` varchar(255)
,`variant_name` varchar(255)
,`product_name` varchar(255)
,`total_quantity_sold` varchar(255)
,`hub_area` varchar(255)
,`shipper_user_id` varchar(255)
,`remarks` varchar(255)
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
  `order_note` varchar(255) DEFAULT NULL,
  `c_address_one` varchar(255) DEFAULT NULL,
  `c_address_two` varchar(255) DEFAULT NULL,
  `c_billing_add_one` varchar(255) DEFAULT NULL,
  `c_billing_add_two` varchar(255) DEFAULT NULL,
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
  `property_note` varchar(255) DEFAULT NULL,
  `variant_price` varchar(255) DEFAULT NULL,
  `variant_name` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `total_quantity_sold` varchar(255) DEFAULT NULL,
  `hub_area` varchar(255) DEFAULT NULL,
  `shipper_user_id` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `hub_order_dispatched_date_time` varchar(255) DEFAULT NULL,
  `hub_pending_date_time_voided` varchar(255) DEFAULT NULL,
  `shipper_for_delivery_date_time` varchar(255) DEFAULT NULL,
  `shipper_for_delivered_date_time` varchar(255) DEFAULT NULL,
  `shipper_for_voided_date_time` varchar(255) DEFAULT NULL
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
-- Table structure for table `users_table`
--

CREATE TABLE `users_table` (
  `id` int(11) NOT NULL,
  `first_name` varchar(65) NOT NULL,
  `last_name` varchar(65) NOT NULL,
  `user_username` varchar(65) NOT NULL,
  `user_password` varchar(65) NOT NULL,
  `user_contact_number` varchar(65) NOT NULL,
  `user_role` varchar(65) NOT NULL,
  `hub_area` varchar(65) NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`id`, `first_name`, `last_name`, `user_username`, `user_password`, `user_contact_number`, `user_role`, `hub_area`, `date_joined`) VALUES
(45, 'Onin', 'Tuvera', 'Onin', '1234', '09067100489', 'Admin', 'FO01', '2020-06-18 01:04:51'),
(47, 'Jose', 'Pacheco', 'jojo', '1234', '090767100489', 'Hub Supervisor', 'FO01', '2020-06-18 01:23:15'),
(48, 'Arnold', 'Clavio', 'shipper', '1234', '09067100489', 'Shipper', 'FO01', '2020-06-28 09:42:08'),
(49, 'Erwin', 'Dela Cruz', 'Erwin', 'password', '09067100489', 'Hub Supervisor', 'FO3000', '2020-07-10 08:25:46'),
(50, 'Paco', 'Paco', 'Paco', '1234', '09067100489', 'Shipper', 'FO3000', '2020-07-10 08:58:50');

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `filterbyostatusanddateforvoided`  AS  select `order_details`.`id` AS `id`,`order_details`.`order_date` AS `order_date`,`order_details`.`order_number` AS `order_number`,`order_details`.`c_fullname` AS `c_fullname`,`order_details`.`c_pnumber_one` AS `c_pnumber_one`,`order_details`.`c_pnumber_two` AS `c_pnumber_two`,`order_details`.`c_pnumber_primary` AS `c_pnumber_primary`,`order_details`.`c_email` AS `c_email`,`order_details`.`order_note` AS `order_note`,`order_details`.`c_address_one` AS `c_address_one`,`order_details`.`c_address_two` AS `c_address_two`,`order_details`.`c_billing_add_one` AS `c_billing_add_one`,`order_details`.`c_billing_add_two` AS `c_billing_add_two`,`order_details`.`c_zipcode` AS `c_zipcode`,`order_details`.`c_city` AS `c_city`,`order_details`.`o_total_price` AS `o_total_price`,`order_details`.`o_status` AS `o_status`,`order_details`.`o_cancelled_at` AS `o_cancelled_at`,`order_details`.`o_payment_gateway` AS `o_payment_gateway`,`order_details`.`o_special_discount` AS `o_special_discount`,`order_details`.`o_card_id_number` AS `o_card_id_number`,`order_details`.`o_card_discount` AS `o_card_discount`,`order_details`.`o_card_discount_number` AS `o_card_discount_number`,`order_details`.`property_note` AS `property_note`,`order_details`.`variant_price` AS `variant_price`,`order_details`.`variant_name` AS `variant_name`,`order_details`.`product_name` AS `product_name`,`order_details`.`total_quantity_sold` AS `total_quantity_sold`,`order_details`.`hub_area` AS `hub_area`,`order_details`.`shipper_user_id` AS `shipper_user_id`,`order_details`.`remarks` AS `remarks`,`order_details`.`hub_order_dispatched_date_time` AS `hub_order_dispatched_date_time`,`order_details`.`hub_pending_date_time_voided` AS `hub_pending_date_time_voided`,`order_details`.`shipper_for_delivery_date_time` AS `shipper_for_delivery_date_time`,`order_details`.`shipper_for_delivered_date_time` AS `shipper_for_delivered_date_time`,`order_details`.`shipper_for_voided_date_time` AS `shipper_for_voided_date_time`,date_format(`order_details`.`shipper_for_voided_date_time`,'%Y/%m/%d') AS `shipper_for_voided_date` from `order_details` ;

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `voidedorders`  AS  select distinct `order_details`.`order_number` AS `order_number`,`order_details`.`o_status` AS `o_status`,month(`order_details`.`shipper_for_voided_date_time`) AS `Month`,`order_details`.`hub_area` AS `hub_area`,`order_details`.`shipper_for_voided_date_time` AS `ship_date_voided` from `order_details` ;

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
-- Indexes for table `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_table_hub_area` (`hub_area`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_satisfaction_data`
--
ALTER TABLE `customer_satisfaction_data`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hub_area_number`
--
ALTER TABLE `hub_area_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

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
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

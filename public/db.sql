-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2017 at 08:30 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userfrosting`
--

-- --------------------------------------------------------

--
-- Table structure for table `uf_addition`
--

CREATE TABLE `uf_addition` (
  `id` int(255) NOT NULL,
  `addition_name` varchar(255) NOT NULL,
  `addition_value` int(255) NOT NULL,
  `is-deleted` tinyint(1) NOT NULL DEFAULT '0',
  `addition_type` int(255) NOT NULL,
  `addition_date` date NOT NULL,
  `addition_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_authorize_group`
--

CREATE TABLE `uf_authorize_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `hook` varchar(200) NOT NULL COMMENT 'A code that references a specific action or URI that the group has access to.',
  `conditions` text NOT NULL COMMENT 'The conditions under which members of this group have access to this hook.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uf_authorize_group`
--

INSERT INTO `uf_authorize_group` (`id`, `group_id`, `hook`, `conditions`) VALUES
(2, 2, 'uri_dashboard', 'always()'),
(3, 2, 'uri_users', 'always()'),
(4, 1, 'uri_account_settings', 'always()'),
(5, 1, 'update_account_setting', 'equals(self.id, user.id)&&in(property,[\"email\",\"locale\",\"password\"])'),
(6, 2, 'update_account_setting', 'always()'),
(7, 2, 'view_account_setting', 'always()'),
(8, 2, 'delete_account', 'always()'),
(9, 2, 'create_account', 'always()'),
(11, 2, 'uri_group_titles', 'always()'),
(12, 2, 'uri_unit_available', 'always()'),
(13, 1, 'uri_unit', 'always()'),
(14, 1, 'uri_reservation', 'always()'),
(15, 1, 'uri_checkbook', 'always()'),
(16, 1, 'uri_charts', 'always()'),
(17, 2, 'uri_site_settings', 'always()'),
(18, 2, 'uri_unit', 'always()'),
(19, 2, 'uri_charts', 'always()'),
(20, 2, 'uri_manage_groups', 'always()'),
(21, 2, 'uri_email_management', 'always()'),
(22, 2, 'uri_smtp_mail_config', 'always()'),
(23, 2, 'uri_currency_exchange', 'always()'),
(24, 2, 'uri_account_settings', 'always()'),
(25, 2, 'uri_checkbook', 'always()'),
(26, 2, 'uri_reservation', 'always()'),
(27, 2, 'uri_authorization', 'always()'),
(28, 2, 'uri_groups', 'always()'),
(29, 2, 'uri_authorization_settings', 'always()'),
(30, 2, 'update_group_setting', 'always()'),
(31, 2, 'view_group_setting', 'always()'),
(32, 2, 'uri_settings', 'always()'),
(33, 2, 'update_site_settings', 'always()'),
(34, 2, 'uri_discount', 'always()'),
(35, 2, 'uri_mssql_config', 'always()'),
(36, 2, 'uri_mysql_config', 'always()'),
(37, 2, 'uri_neighborhood', 'always()'),
(38, 2, 'uri_purchase', 'always()'),
(39, 1, 'uri_purchase', 'always()'),
(40, 2, 'uri_addition', 'always()'),
(41, 2, 'uri_upload', 'always()'),
(42, 2, 'uri_rented', 'always()'),
(43, 2, 'uri_contract1', 'always()'),
(44, 2, 'uri_contract2', 'always()'),
(45, 1, 'uri_contract1', 'always()'),
(46, 1, 'uri_contract2', 'always()');

-- --------------------------------------------------------

--
-- Table structure for table `uf_authorize_user`
--

CREATE TABLE `uf_authorize_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `hook` varchar(200) NOT NULL COMMENT 'A code that references a specific action or URI that the user has access to.',
  `conditions` text NOT NULL COMMENT 'The conditions under which the user has access to this action.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_cancel_reason`
--

CREATE TABLE `uf_cancel_reason` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `unit_id` int(255) NOT NULL,
  `flag` int(255) NOT NULL,
  `reason` text CHARACTER SET utf8 NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_configuration`
--

CREATE TABLE `uf_configuration` (
  `id` int(10) UNSIGNED NOT NULL,
  `plugin` varchar(50) NOT NULL COMMENT 'The name of the plugin that manages this setting (set to ''userfrosting'' for core settings)',
  `name` varchar(150) NOT NULL COMMENT 'The name of the setting.',
  `value` longtext NOT NULL COMMENT 'The current value of the setting.',
  `description` text NOT NULL COMMENT 'A brief description of this setting.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A configuration table, mapping global configuration options to their values.';

--
-- Dumping data for table `uf_configuration`
--

INSERT INTO `uf_configuration` (`id`, `plugin`, `name`, `value`, `description`) VALUES
(1, 'userfrosting', 'site_title', 'Rawabi Reservation System', 'The title of the site.  By default, displayed in the title tag, as well as the upper left corner of every user page.'),
(2, 'userfrosting', 'admin_email', 'asal2test@gmail.com', 'The administrative email for the site.  Automated emails, such as verification emails and password reset links, will come from this address.'),
(3, 'userfrosting', 'email_login', '1', 'Specify whether users can login via email address or username instead of just username.'),
(4, 'userfrosting', 'can_register', '0', 'Specify whether public registration of new accounts is enabled.  Enable if you have a service that users can sign up for, disable if you only want accounts to be created by you or an admin.'),
(5, 'userfrosting', 'enable_captcha', '1', 'Specify whether new users must complete a captcha code when registering for an account.'),
(6, 'userfrosting', 'require_activation', '1', 'Specify whether email verification is required for newly registered accounts.  Accounts created by another user never need to be verified.'),
(7, 'userfrosting', 'resend_activation_threshold', '0', 'The time, in seconds, that a user must wait before requesting that the account verification email be resent.'),
(8, 'userfrosting', 'reset_password_timeout', '10800', 'The time, in seconds, before a user\'s password reset token expires.'),
(9, 'userfrosting', 'create_password_expiration', '86400', 'The time, in seconds, before a new user\'s password creation token expires.'),
(10, 'userfrosting', 'default_locale', 'en_US', 'The default language for newly registered users.'),
(11, 'userfrosting', 'guest_theme', 'default', 'The template theme to use for unauthenticated (guest) users.'),
(12, 'userfrosting', 'minify_css', '0', 'Specify whether to use concatenated, minified CSS (production) or raw CSS includes (dev).'),
(13, 'userfrosting', 'minify_js', '0', 'Specify whether to use concatenated, minified JS (production) or raw JS includes (dev).'),
(14, 'userfrosting', 'version', '0.3.1.19', 'The current version of UserFrosting.'),
(15, 'userfrosting', 'author', 'Maysam', 'The author of the site.  Will be used in the site\'s author meta tag.'),
(16, 'userfrosting', 'show_terms_on_register', '1', 'Specify whether or not to show terms and conditions when registering.'),
(17, 'userfrosting', 'site_location', 'Ramallah', 'The nation or state in which legal jurisdiction for this site falls.'),
(18, 'userfrosting', 'install_status', 'complete', ''),
(19, 'userfrosting', 'root_account_config_token', '', ''),
(20, 'userFrosting', 'EmailList', 'asaltech@asaltech.com', 'this is the email list for this company'),
(23, 'userFrosting, 'site_logo', 'img', 'Logo of the system');
-- --------------------------------------------------------

--
-- Table structure for table `uf_contract1`
--

CREATE TABLE `uf_contract1` (
  `id` int(11) NOT NULL,
  `contractDate` date NOT NULL,
  `companyNum` varchar(150) NOT NULL,
  `systemUser` varchar(255) NOT NULL,
  `purchaser1` varchar(255) NOT NULL,
  `idType1` varchar(255) NOT NULL,
  `idNum1` varchar(255) NOT NULL,
  `idPlace1` varchar(255) NOT NULL,
  `idProDate1` date NOT NULL,
  `idExpDate1` date NOT NULL,
  `regNo1` varchar(150) NOT NULL,
  `registered1` varchar(255) NOT NULL,
  `passportNo1` varchar(225) NOT NULL,
  `country1` varchar(255) NOT NULL,
  `city1` varchar(255) NOT NULL,
  `regionName1` varchar(255) NOT NULL,
  `streetName1` varchar(255) NOT NULL,
  `homePhone1` varchar(255) NOT NULL,
  `workPhone1` varchar(255) NOT NULL,
  `mobileNum1` varchar(255) NOT NULL,
  `faxNum1` varchar(255) NOT NULL,
  `mailBox1` varchar(255) NOT NULL,
  `postalCode1` varchar(255) NOT NULL,
  `eMail1` varchar(255) NOT NULL,
  `purchaser2` varchar(255) NOT NULL,
  `idType2` varchar(255) NOT NULL,
  `idNum2` varchar(255) NOT NULL,
  `idPlace2` varchar(255) NOT NULL,
  `idProDate2` date NOT NULL,
  `idExpDate2` date NOT NULL,
  `regNo2` varchar(150) NOT NULL,
  `registered2` varchar(255) NOT NULL,
  `passportNo2` varchar(255) NOT NULL,
  `country2` varchar(255) NOT NULL,
  `city2` varchar(255) NOT NULL,
  `regionName2` varchar(255) NOT NULL,
  `streetName2` varchar(255) NOT NULL,
  `homePhone2` varchar(255) NOT NULL,
  `workPhone2` varchar(255) NOT NULL,
  `mobileNum2` varchar(255) NOT NULL,
  `faxNum2` varchar(255) NOT NULL,
  `mailBox2` varchar(255) NOT NULL,
  `postalCode2` varchar(255) NOT NULL,
  `eMail2` varchar(255) NOT NULL,
  `unitNum` varchar(150) NOT NULL,
  `unitArea` varchar(150) NOT NULL,
  `haiName` varchar(255) NOT NULL,
  `floorNum` varchar(255) NOT NULL,
  `landNum` varchar(255) NOT NULL,
  `hawdNum` varchar(255) NOT NULL,
  `hawdName` varchar(255) NOT NULL,
  `buildingNum` varchar(150) NOT NULL,
  `buildingsNum` varchar(255) NOT NULL,
  `unitDesc` varchar(300) NOT NULL,
  `damageFine` varchar(255) NOT NULL,
  `releaseDate` date NOT NULL,
  `priceTotal` varchar(255) NOT NULL,
  `pricePart1` varchar(255) NOT NULL,
  `pricePart2` varchar(255) NOT NULL,
  `pricePart3` varchar(255) NOT NULL,
  `delayPeriod` varchar(255) NOT NULL,
  `penaltyClause` varchar(255) NOT NULL,
  `systemUserIDNo` varchar(255) NOT NULL,
  `systemUserPassportNo` varchar(255) NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `companyFor` varchar(255) NOT NULL,
  `ownersUnionNum` varchar(255) NOT NULL,
  `ownersUnionProDate` date NOT NULL,
  `haiArea` varchar(255) NOT NULL,
  `checksNum` varchar(255) NOT NULL,
  `arabon` varchar(255) NOT NULL,
  `remainingAmountDelay` varchar(255) NOT NULL,
  `penefitCompensation` varchar(255) NOT NULL,
  `addPart6` varchar(150) NOT NULL,
  `addPartB` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_contract1_unit`
--

CREATE TABLE `uf_contract1_unit` (
  `id` int(11) NOT NULL,
  `contract1_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_contract2`
--

CREATE TABLE `uf_contract2` (
  `id` int(11) NOT NULL,
  `contract2Date` date NOT NULL,
  `baytiCompanyNumber` varchar(255) CHARACTER SET utf8 NOT NULL,
  `systemUser2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `renter1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_idType1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_idNum1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_idProDate1` date NOT NULL,
  `r_idPlace1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_passportNo1` varchar(255) NOT NULL,
  `r_idExpDate1` date NOT NULL,
  `r_country1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_city1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_streetName1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_regionName1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_workPhone1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_homePhone1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_mobileNum1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_faxNum1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_mailBox1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_eMail1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_postalCode1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `renter2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_idType2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_idNum2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_idProDate2` date NOT NULL,
  `r_idPlace2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_passportNo2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_idExpDate2` date NOT NULL,
  `r_country2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_city2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_streetName2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_regionName2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_workPhone2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_homePhone2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_mobileNum2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_faxNum2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_mailBox2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_eMail2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_postalCode2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_unitArea` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_haiName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_unitNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_floorNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_landNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_buildingNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_hawdNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_hawdName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_buildingsNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_unitDesc` varchar(255) CHARACTER SET utf8 NOT NULL,
  `rentPeriod` varchar(255) CHARACTER SET utf8 NOT NULL,
  `releasePeriod` varchar(255) CHARACTER SET utf8 NOT NULL,
  `startRentDate` date NOT NULL,
  `endRentDate` date NOT NULL,
  `r_totalPrice` varchar(255) CHARACTER SET utf8 NOT NULL,
  `additions` varchar(255) CHARACTER SET utf8 NOT NULL,
  `yy` varchar(255) CHARACTER SET utf8 NOT NULL,
  `paymentAPeriod` varchar(255) CHARACTER SET utf8 NOT NULL,
  `paymentA` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fromDateA` date NOT NULL,
  `toDateA` date NOT NULL,
  `paymentBPeriod` varchar(255) CHARACTER SET utf8 NOT NULL,
  `paymentB` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fromDateB` date NOT NULL,
  `toDateB` date NOT NULL,
  `paymentCPeriod` varchar(255) CHARACTER SET utf8 NOT NULL,
  `paymentC` varchar(255) CHARACTER SET utf8 NOT NULL,
  `fromDateC` date NOT NULL,
  `toDateC` date NOT NULL,
  `checksNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contract2Day` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_companyFor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_companyName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contract2_addPartB` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_checksNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sponsorName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sponsorAddress` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sponsorIdNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sponsorMobile` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_haiArea` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_HAO_num` varchar(255) CHARACTER SET utf8 NOT NULL,
  `r_HAO_date` varchar(255) CHARACTER SET utf8 NOT NULL,
  `rentPrice` int(255) NOT NULL,
  `serialNumberInit` int(255) NOT NULL,
  `serialNumberFinal` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_contract2_sponsors`
--

CREATE TABLE `uf_contract2_sponsors` (
  `id` int(11) NOT NULL,
  `sponsorName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sponsorIdNum` varchar(255) CHARACTER SET utf16 NOT NULL,
  `sponsorMobile` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sponsorAddress` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contract2_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_contract2_unit`
--

CREATE TABLE `uf_contract2_unit` (
  `id` int(11) NOT NULL,
  `contract2_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_discount`
--

CREATE TABLE `uf_discount` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` double NOT NULL,
  `password` varchar(255) NOT NULL,
  `is-deleted` tinyint(1) NOT NULL DEFAULT '0',
  `type` int(255) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_group`
--

CREATE TABLE `uf_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Specifies whether this permission is a default setting for new accounts.',
  `can_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Specifies whether this permission can be deleted from the control panel.',
  `theme` varchar(100) NOT NULL DEFAULT 'default' COMMENT 'The theme assigned to primary users in this group.',
  `landing_page` varchar(200) NOT NULL DEFAULT 'dashboard' COMMENT 'The page to take primary members to when they first log in.',
  `new_user_title` varchar(200) NOT NULL DEFAULT 'New User' COMMENT 'The default title to assign to new primary users.',
  `icon` varchar(100) NOT NULL DEFAULT 'fa fa-user' COMMENT 'The icon representing primary users in this group.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uf_group`
--

INSERT INTO `uf_group` (`id`, `name`, `is_default`, `can_delete`, `theme`, `landing_page`, `new_user_title`, `icon`) VALUES
(1, 'Sales officer', 2, 0, 'nyx', 'unit', 'New User', 'fa fa-user'),
(2, 'Sales Manager', 0, 0, 'nyx', 'dashboard', 'New Admin', 'fa fa-flag');

-- --------------------------------------------------------

--
-- Table structure for table `uf_group_user`
--

CREATE TABLE `uf_group_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Maps users to their group(s)';

--
-- Dumping data for table `uf_group_user`
--

INSERT INTO `uf_group_user` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 2),
(8, 7, 1),
(9, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `uf_mssql_config`
--

CREATE TABLE `uf_mssql_config` (
  `id` int(11) NOT NULL,
  `server` varchar(300) NOT NULL,
  `msdb` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uf_mssql_config`
--

INSERT INTO `uf_mssql_config` (`id`, `server`, `msdb`, `username`, `pass`) VALUES
(1, 'RASHA-BAZBAZ\\SQLEXPRESS2', 'Rawabi', 'sa', '20051986');

-- --------------------------------------------------------

--
-- Table structure for table `uf_neighborhoods`
--

CREATE TABLE `uf_neighborhoods` (
  `id` int(11) NOT NULL,
  `haiArabicName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `haiEnglishName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `haiArea` varchar(255) CHARACTER SET utf8 NOT NULL,
  `HAO_num` varchar(255) CHARACTER SET utf8 NOT NULL,
  `HAO_date` date NOT NULL,
  `haiBuildingsNum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `estContrDate` date NOT NULL,
  `land` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uf_neighborhoods`
--

INSERT INTO `uf_neighborhoods` (`id`, `haiArabicName`, `haiEnglishName`, `haiArea`, `HAO_num`, `HAO_date`, `haiBuildingsNum`, `estContrDate`, `land`) VALUES
(2, 'صوان', 'Suwan', '12345', '3321', '2017-05-17', '20', '0000-00-00', ''),
(3, 'ماكمتا', 'Makmata', '233', '1233', '2017-05-23', '19', '0000-00-00', ''),
(28, 'دليم', 'Dulaim', '5400', '543', '2017-05-01', '40', '0000-00-00', ''),
(30, 'وروار', 'warwar', '1', '44', '2017-07-27', '1', '2017-07-28', '');

-- --------------------------------------------------------

--
-- Table structure for table `uf_payments1`
--

CREATE TABLE `uf_payments1` (
  `id` int(11) NOT NULL,
  `paymentNum` varchar(255) NOT NULL,
  `paymentAmount` varchar(255) NOT NULL,
  `paymentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_payments1_unit`
--

CREATE TABLE `uf_payments1_unit` (
  `id` int(11) NOT NULL,
  `payments1_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_purchase`
--

CREATE TABLE `uf_purchase` (
  `id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `neighborhood` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_reservation`
--

CREATE TABLE `uf_reservation` (
  `id` int(11) NOT NULL,
  `collected_fees` varchar(150) NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT '$',
  `customer_type_of_payment` varchar(255) NOT NULL DEFAULT 'Cash',
  `customer_type_of_id` varchar(255) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `issued_by` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `reservation_date` date NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `total_price` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_reservation_unit`
--

CREATE TABLE `uf_reservation_unit` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `unit_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_reservation_user`
--

CREATE TABLE `uf_reservation_user` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_serial_number`
--

CREATE TABLE `uf_serial_number` (
  `id` int(255) NOT NULL,
  `serial` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_unit`
--

CREATE TABLE `uf_unit` (
  `id` int(11) NOT NULL,
  `building` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `floor` int(11) NOT NULL,
  `neighborhood` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `contract_type` tinyint(1) NOT NULL,
  `pdf-print-flag` tinyint(1) NOT NULL DEFAULT '0',
  `rawabi_code` varchar(255) NOT NULL,
  `building_type` varchar(255) NOT NULL,
  `unitDescription` varchar(255) NOT NULL,
  `tapu_code` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_units_images`
--

CREATE TABLE `uf_units_images` (
  `id` int(255) NOT NULL,
  `unit_id` int(255) NOT NULL,
  `img_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_unit_history`
--

CREATE TABLE `uf_unit_history` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `uid` int(11) NOT NULL,
  `action` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date` date NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_uploadedfiles`
--

CREATE TABLE `uf_uploadedfiles` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filepath` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `uf_user`
--

CREATE TABLE `uf_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `locale` varchar(10) NOT NULL DEFAULT 'en_US' COMMENT 'The language and locale to use for this user.',
  `primary_group_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'The id of this user''s primary group.',
  `secret_token` varchar(32) NOT NULL DEFAULT '' COMMENT 'The current one-time use token for various user activities confirmed via email.',
  `flag_verified` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Set to ''1'' if the user has verified their account via email, ''0'' otherwise.',
  `flag_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Set to ''1'' if the user''s account is currently enabled, ''0'' otherwise.  Disabled accounts cannot be logged in to, but they retain all of their data and settings.',
  `flag_password_reset` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Set to ''1'' if the user has an outstanding password reset request, ''0'' otherwise.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uf_user`
--

INSERT INTO `uf_user` (`id`, `user_name`, `display_name`, `email`, `title`, `locale`, `primary_group_id`, `secret_token`, `flag_verified`, `flag_enabled`, `flag_password_reset`, `created_at`, `updated_at`, `password`) VALUES
(1, 'admin', 'rasha bazbaz', 'test@asaltech.com', 'New User', 'en_US', 2, 'c34dd942596fac252f3dba6adf167ed9', 1, 1, 1, '2016-10-04 14:21:44', '2017-08-02 11:30:39', '$2y$10$eNL86OAHWzgKincOytGsiet4OR/nLeEJ/g7orTh673GGIqmhohERS'),
(7, 'asal', 'test asal', 'test@gmail.com', 'New User', 'en_US', 1, '8f506364b74fe418b797e1cef92122ae', 1, 1, 1, '2017-08-02 10:42:08', '2017-08-02 10:49:37', '$2y$10$HfCladdhvQoitfLQ1BJTquFhDyi7sKNzZc7xUWf6ob2n6uIDHH0Lm'),
(8, 'asalAdmin', 'asal admin', 'test@test.com', 'New User', 'en_US', 2, 'afbc02b30e66d2f9654758bf64d70373', 1, 1, 1, '2017-08-02 10:42:36', '2017-08-02 10:43:04', '$2y$10$E.H2r0eX.2piGwU0mdG1c.kNTB9G6Hzt4s9OIjb.UHNB9TRCayKq2');

-- --------------------------------------------------------

--
-- Table structure for table `uf_user_event`
--

CREATE TABLE `uf_user_event` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `event_type` varchar(255) NOT NULL COMMENT 'An identifier used to track the type of event.',
  `occurred_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uf_user_event`
--

INSERT INTO `uf_user_event` (`id`, `user_id`, `event_type`, `occurred_at`, `description`) VALUES
(434, 1, 'sign_in', '2017-08-01 12:49:05', 'User admin signed in at 2017-08-01 15:49:05.'),
(435, 1, 'sign_in', '2017-08-01 12:49:10', 'User admin signed in at 2017-08-01 15:49:10.'),
(436, 1, 'sign_in', '2017-08-01 12:52:28', 'User admin signed in at 2017-08-01 15:52:28.'),
(437, 1, 'sign_in', '2017-08-02 10:41:33', 'User admin signed in at 2017-08-02 13:41:33.'),
(438, 7, 'sign_up', '2017-08-02 10:42:08', 'User asal was created by admin on 2017-08-02 13:42:08.'),
(439, 7, 'password_reset_request', '2017-08-02 10:42:08', 'User asal requested a password reset on 2017-08-02 13:42:08.'),
(440, 8, 'sign_up', '2017-08-02 10:42:36', 'User asalAdmin was created by admin on 2017-08-02 13:42:36.'),
(441, 8, 'password_reset_request', '2017-08-02 10:42:36', 'User asalAdmin requested a password reset on 2017-08-02 13:42:36.'),
(442, 8, 'sign_in', '2017-08-02 10:43:13', 'User asalAdmin signed in at 2017-08-02 13:43:13.'),
(443, 1, 'sign_in', '2017-08-02 10:49:19', 'User admin signed in at 2017-08-02 13:49:19.'),
(444, 7, 'sign_in', '2017-08-02 10:49:44', 'User asal signed in at 2017-08-02 13:49:44.'),
(445, 7, 'sign_in', '2017-08-02 10:52:00', 'User asal signed in at 2017-08-02 13:52:00.'),
(446, 8, 'sign_in', '2017-08-02 10:52:08', 'User asalAdmin signed in at 2017-08-02 13:52:08.'),
(447, 1, 'sign_in', '2017-08-02 11:30:26', 'User admin signed in at 2017-08-02 14:30:26.'),
(448, 7, 'sign_in', '2017-08-02 12:02:15', 'User asal signed in at 2017-08-02 15:02:15.'),
(449, 7, 'sign_in', '2017-08-02 12:03:22', 'User asal signed in at 2017-08-02 15:03:22.'),
(450, 1, 'sign_in', '2017-08-02 12:03:30', 'User admin signed in at 2017-08-02 15:03:30.'),
(451, 7, 'sign_in', '2017-08-02 12:04:09', 'User asal signed in at 2017-08-02 15:04:09.'),
(452, 7, 'sign_in', '2017-08-02 12:08:55', 'User asal signed in at 2017-08-02 15:08:55.'),
(453, 8, 'sign_in', '2017-08-02 12:09:24', 'User asalAdmin signed in at 2017-08-02 15:09:24.'),
(454, 1, 'sign_in', '2017-08-02 12:21:26', 'User admin signed in at 2017-08-02 15:21:26.'),
(455, 1, 'sign_in', '2017-08-02 12:26:43', 'User admin signed in at 2017-08-02 15:26:43.'),
(456, 7, 'sign_in', '2017-08-02 12:26:59', 'User asal signed in at 2017-08-02 15:26:59.'),
(457, 1, 'sign_in', '2017-08-02 12:28:01', 'User admin signed in at 2017-08-02 15:28:01.'),
(458, 1, 'sign_in', '2017-08-02 12:32:38', 'User admin signed in at 2017-08-02 15:32:38.');

-- --------------------------------------------------------

--
-- Table structure for table `uf_user_rememberme`
--

CREATE TABLE `uf_user_rememberme` (
  `user_id` int(11) NOT NULL,
  `token` varchar(40) NOT NULL,
  `persistent_token` varchar(40) NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `uf_addition`
--
ALTER TABLE `uf_addition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_authorize_group`
--
ALTER TABLE `uf_authorize_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_authorize_user`
--
ALTER TABLE `uf_authorize_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_cancel_reason`
--
ALTER TABLE `uf_cancel_reason`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_configuration`
--
ALTER TABLE `uf_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_contract1`
--
ALTER TABLE `uf_contract1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_contract1_unit`
--
ALTER TABLE `uf_contract1_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_contract2`
--
ALTER TABLE `uf_contract2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_contract2_unit`
--
ALTER TABLE `uf_contract2_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_discount`
--
ALTER TABLE `uf_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_group`
--
ALTER TABLE `uf_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_group_user`
--
ALTER TABLE `uf_group_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_mssql_config`
--
ALTER TABLE `uf_mssql_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_neighborhoods`
--
ALTER TABLE `uf_neighborhoods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_payments1`
--
ALTER TABLE `uf_payments1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_purchase`
--
ALTER TABLE `uf_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_reservation`
--
ALTER TABLE `uf_reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_reservation_unit`
--
ALTER TABLE `uf_reservation_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_reservation_user`
--
ALTER TABLE `uf_reservation_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_serial_number`
--
ALTER TABLE `uf_serial_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_unit`
--
ALTER TABLE `uf_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_units_images`
--
ALTER TABLE `uf_units_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_unit_history`
--
ALTER TABLE `uf_unit_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_uploadedfiles`
--
ALTER TABLE `uf_uploadedfiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_user`
--
ALTER TABLE `uf_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_user_event`
--
ALTER TABLE `uf_user_event`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `uf_addition`
--
ALTER TABLE `uf_addition`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_authorize_group`
--
ALTER TABLE `uf_authorize_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `uf_authorize_user`
--
ALTER TABLE `uf_authorize_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_cancel_reason`
--
ALTER TABLE `uf_cancel_reason`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_configuration`
--
ALTER TABLE `uf_configuration`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `uf_contract1`
--
ALTER TABLE `uf_contract1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_contract1_unit`
--
ALTER TABLE `uf_contract1_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_contract2`
--
ALTER TABLE `uf_contract2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_contract2_unit`
--
ALTER TABLE `uf_contract2_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_discount`
--
ALTER TABLE `uf_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_group`
--
ALTER TABLE `uf_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `uf_group_user`
--
ALTER TABLE `uf_group_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `uf_mssql_config`
--
ALTER TABLE `uf_mssql_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `uf_neighborhoods`
--
ALTER TABLE `uf_neighborhoods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `uf_payments1`
--
ALTER TABLE `uf_payments1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_purchase`
--
ALTER TABLE `uf_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_reservation`
--
ALTER TABLE `uf_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_reservation_unit`
--
ALTER TABLE `uf_reservation_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_reservation_user`
--
ALTER TABLE `uf_reservation_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_unit`
--
ALTER TABLE `uf_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_units_images`
--
ALTER TABLE `uf_units_images`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_unit_history`
--
ALTER TABLE `uf_unit_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT for table `uf_uploadedfiles`
--
ALTER TABLE `uf_uploadedfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_user`
--
ALTER TABLE `uf_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `uf_user_event`
--
ALTER TABLE `uf_user_event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

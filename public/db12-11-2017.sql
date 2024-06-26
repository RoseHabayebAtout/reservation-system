-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2017 at 10:19 AM
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
(4, 2, 'uri_account_settings', 'always()'),
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
(24, 1, 'uri_account_settings', 'always()'),
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

--
-- Dumping data for table `uf_cancel_reason`
--

INSERT INTO `uf_cancel_reason` (`id`, `user_id`, `unit_id`, `flag`, `reason`, `date`) VALUES
(1, 1, 2989, 0, 'test', '2017-10-31'),
(2, 1, 2989, 0, 'test test', '2017-10-31');

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
(1, 'userfrosting', 'site_title', 'Rawabi Reservations & Contracts System', 'The title of the site.  By default, displayed in the title tag, as well as the upper left corner of every user page.'),
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
(15, 'userfrosting', 'author', 'AsalTech', 'The author of the site.  Will be used in the site\'s author meta tag.'),
(16, 'userfrosting', 'show_terms_on_register', '1', 'Specify whether or not to show terms and conditions when registering.'),
(17, 'userfrosting', 'site_location', 'Ramallah', 'The nation or state in which legal jurisdiction for this site falls.'),
(18, 'userfrosting', 'install_status', 'complete', ''),
(19, 'userfrosting', 'root_account_config_token', '', ''),
(20, 'userFrosting', 'ReservationEmailList', 'asaltech1@asaltech.com', 'this is the email list of reservation'),
(21, 'userFrosting', 'PurchaseEmailList', 'asaltech1@asaltech.com', 'this is the email list of purchase'),
(22, 'userFrosting', 'CancellationEmailList', 'asaltech1@asaltech.com', 'this is the email list of cancellation'),;
(24, 'userFrosting', 'CashReceiptEmailList', 'asaltech1@asaltech.com', 'this is the email list of cash receipt'),;
(23, 'userFrosting', 'site_logo', 'img', 'Logo of the system');

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
  `serialNumberFinal` int(255) NOT NULL,
  `r_companyNum` varchar(150) CHARACTER SET utf8 NOT NULL
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
(9, 8, 2),
(10, 9, 1);

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
(1, '172.22.1.144', 'DulaimFinishing', 'sa', 'm_1987zuhdi');

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
  `land` varchar(255) NOT NULL,
  `estContrNum` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uf_neighborhoods`
--

INSERT INTO `uf_neighborhoods` (`id`, `haiArabicName`, `haiEnglishName`, `haiArea`, `HAO_num`, `HAO_date`, `haiBuildingsNum`, `estContrDate`, `land`, `estContrNum`) VALUES
(2, 'صوان', 'Suwan', '12345', '3321', '2017-05-17', '20', '0000-00-00', '', ''),
(3, 'ماكمتا', 'Makmata', '233', '1233', '2017-05-23', '19', '0000-00-00', '', ''),
(28, 'دليم', 'Dulaim', '5400', '543', '2017-05-01', '40', '0000-00-00', '', '190'),
(30, 'وروار', 'warwar', '1', '44', '2017-07-27', '1', '2017-07-28', '', ''),
(31, 'ewt', 'terst', '150', '10', '2017-12-07', '12', '2017-12-22', '126', '152');

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
  `total_price` varchar(150) NOT NULL,
  `leadID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uf_reservation`
--

INSERT INTO `uf_reservation` (`id`, `collected_fees`, `currency`, `customer_type_of_payment`, `customer_type_of_id`, `customer_id`, `issued_by`, `customer_name`, `reservation_date`, `customer_address`, `phone_number`, `mobile`, `total_price`, `leadID`) VALUES
(3, '850', '$', 'Cash', '', '', '', 'زبون  رقم11', '2017-10-31', '', '', '', '12000', '85264fcbg ');

-- --------------------------------------------------------

--
-- Table structure for table `uf_reservation_unit`
--

CREATE TABLE `uf_reservation_unit` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `unit_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uf_reservation_unit`
--

INSERT INTO `uf_reservation_unit` (`id`, `reservation_id`, `unit_id`) VALUES
(3, 3, '2989');

-- --------------------------------------------------------

--
-- Table structure for table `uf_reservation_user`
--

CREATE TABLE `uf_reservation_user` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uf_reservation_user`
--

INSERT INTO `uf_reservation_user` (`id`, `reservation_id`, `user_id`) VALUES
(3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `uf_serial_number`
--

CREATE TABLE `uf_serial_number` (
  `id` int(255) NOT NULL,
  `serial` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uf_serial_number`
--

INSERT INTO `uf_serial_number` (`id`, `serial`) VALUES
(1, 795);

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
  `price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `tabo_area` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uf_unit`
--

INSERT INTO `uf_unit` (`id`, `building`, `unit`, `floor`, `neighborhood`, `size`, `available`, `contract_type`, `pdf-print-flag`, `rawabi_code`, `building_type`, `unitDescription`, `tapu_code`, `price`, `description`, `tabo_area`) VALUES
(2989, 1, '-1', 1, 'Dulaim', '192', 0, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2990, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2991, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2992, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2993, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2994, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2995, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2996, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2997, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2998, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '220', 12000, 'L2-2 -  - تراس 17م2 - حديقة  ?م2 - موقف داخلي', '250'),
(2999, 1, '-1', 2, 'Dulaim', '192', 1, 0, 0, '01-11', 'Zoya', 'الشقة الشرقية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكونة من مستويان المستوى الاول مساحته 175 متر مربع و المستوى الثاني مساحته 175متر مربع وفيها ترس في المستوى السفلي من الجهة الشمالية مساحته 4متر مربع وترس من الجهه الشرقية مساحته 25متر مربع ', '-112', 0, '', ''),
(3000, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '-111', 0, '', ''),
(3001, 1, '-2', 0, 'Dulaim', '119', 1, 0, 0, '01-21', 'Zoya', '', '', 0, '', ''),
(3002, 1, '-2', 0, 'Dulaim', '191', 1, 0, 0, '01-22', 'Zoya', '#N/A', '', 0, '', ''),
(3003, 1, '-2', 0, 'Dulaim', '80', 1, 0, 0, '01-23', 'Zoya', '#N/A', '', 0, '', ''),
(3004, 1, '2', 2, 'Dulaim', '252', 1, 0, 0, '01-51', 'Zoya', 'الشقة الشرقيه في الطابق الثاني عدا سطحها ،دوبلكس مكونه من مستويين،المستوى السفلي A-122مساحته 118متر مربع و المستوى العلوي B-122مساحته 105متر مربع ', '122', 0, '', ''),
(3005, 1, '2', 1, 'Dulaim', '256', 1, 0, 0, '01-52)', 'Zoya', 'الشقة الغربيه في الطابق الثاني عدا سطحها،دوبلكس مكونه من مستويين،المستوى السفلي A-121مساحته 113 متر مربع و المستوى العلوي في الطابق الثالث B-121مساحته 113متر مربع ', '121', 0, '', ''),
(3006, 1, '3', 1, 'Dulaim', '299', 1, 0, 0, '01-63)', 'Zoya', 'الشقة الجنوبية في الطابق الثالث عدا سطحها،دوبلكس مكونه من مستويين،المستوى العلويA-131مساحته 136 متر مربع والمستوى السفلي في الطابق الثانيB-131مساحته 127متر مربع ', '131', 0, '', ''),
(3007, 1, '4', 2, 'Dulaim', '237', 1, 0, 0, '01-71)', 'Zoya', 'الشقة الشرقية في الطابق الرابع عدا سطحها ،دوبلكس مكونه من مستويين،المستوى السفلي A-142مساحته 118متر مربع والمستوى العلوي في الطابق الخامس B142مساحته 91متر مربع كما يتبعه تراس في المستوى العلوي في الجهة الشماليه (1) مساحته 14 متر مربع ', '142', 0, '', ''),
(3008, 1, '4', 1, 'Dulaim', '241', 1, 0, 0, '01-72)', 'Zoya', 'الشقة الغربية في الطابق الرابع عدا سطحها،دوبلكس مكونة من مستويين،المستوى السفلي A-141مساحته 113متر مربع و المستوى العلوي في الطابق الخامس B-141مساحته 99 متر مربع كما يتبعها تراس في المستوى العلوي فقط في الجهه الشمالية (6)مساحته 14 متر مربع ', '141', 0, '', ''),
(3009, 1, '5', 1, 'Dulaim', '289', 1, 0, 0, '01-83)', 'Zoya', 'الشقة الجنوبية من الطابق الخامس عدا سطحها وهي نظام دوبلكس مكون من مستويين المستوى العلوي مساحته 127 متر مربع يتبعه ترس في المستوى العلوي من الجهة الغربية مساحته 5 متر مربع وترس من الجهة الشرقية مساحته 5 متر مربع و المستوى السفلي في الطابق الرابع مساحته 12', '151', 0, '', ''),
(3010, 2, '-1', 2, 'Dulaim', '198', 1, 0, 0, '02-11)', 'Marmar', 'الشقة الشرقيه في طابق التسوية الاولى عدا سطحها ،ويتبعه تراس في الجهه الشرقيه (A4)مساحته 29 متر مربع ويتبعه تراس من الجهه الشرقيه و درج (A5)مساحته 89 متر مربع ', '-0212', 0, '', ''),
(3011, 2, '-1', 1, 'Dulaim', '198', 1, 0, 0, '02-12)', 'Marmar', 'الشقة الغربية طابق التسوية الاولى عدا سطحها ويتبعها تراس في الجهه الشماليه و الغربيه (A1)مساحته 29 متر مربع وكما يتبعه تراس في الجهه الغربيه (A2)مساحته 32 متر مربع ويتبعه تراس ابغربية (A3)مساحته 24 متر مربع ', '-0211', 0, '', ''),
(3012, 2, '1', 2, 'Dulaim', '90', 1, 0, 0, '02-31)', 'Marmar', 'الشقة الشرقية في الطابق الاول عدا سطحها ويتبعها تراس في الجهه الشماليه (A11)مساحته 5متر مربع ', '0212', 0, '', ''),
(3013, 2, '1', 1, 'Dulaim', '182', 1, 0, 0, '02-32)', 'Marmar', 'الشقة الغربيه في الطابق الاول عدا سطحها ويتبعه تراس في الجهه الشماليه (A10)مساحته 5متر مربع ', '0211', 0, '', ''),
(3014, 2, '1', 2, 'Dulaim', '90', 1, 0, 0, '02-33)', 'Marmar', '#N/A', '', 0, '', ''),
(3015, 2, '2', 1, 'Dulaim', '182', 1, 0, 0, '02-41)', 'Marmar', 'الشقة الشرقية في الطابق الثاني عدا سطحها ', '0222', 0, '', ''),
(3016, 2, '2', 2, 'Dulaim', '90', 1, 0, 0, '02-42)', 'Marmar', 'الشقة الغربية في الطابق الثاني عدا سطحها ', '0221', 0, '', ''),
(3017, 2, '2', 1, 'Dulaim', '90', 1, 0, 0, '02-43)', 'Marmar', '#N/A', '', 0, '', ''),
(3032, 1, '-1', 2, 'Dulaim', '192', 1, 0, 0, '01-11', 'Zoya', 'الشقة الشرقية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكونة من مستويان المستوى الاول مساحته 175 متر مربع و المستوى الثاني مساحته 175متر مربع وفيها ترس في المستوى السفلي من الجهة الشمالية مساحته 4متر مربع وترس من الجهه الشرقية مساحته 25متر مربع ', '-112', 0, '', ''),
(3033, 1, '-1', 1, 'Dulaim', '192', 1, 0, 0, '01-12', 'Zoya', 'الشقة الغربية من طابق التسوية الاولى عدا سطحها نظام دوبلكس مكون من مستويان المستوى الاول مساحته 175متر مربع و المستوى الثاني مساحته 175متر مربع ويتبعها ترس في المستوى السفلي من الجهه الشمالية مساحته 4متر مربع وترس من الجهة الغربية مساحته 64 متر مربع ', '-111', 0, '', ''),
(3034, 1, '-2', 0, 'Dulaim', '119', 1, 0, 0, '01-21', 'Zoya', '', '', 0, '', ''),
(3035, 1, '-2', 0, 'Dulaim', '191', 1, 0, 0, '01-22', 'Zoya', '#N/A', '', 0, '', ''),
(3036, 1, '-2', 0, 'Dulaim', '80', 1, 0, 0, '01-23', 'Zoya', '#N/A', '', 0, '', ''),
(3037, 1, '2', 2, 'Dulaim', '252', 1, 0, 0, '01-51', 'Zoya', 'الشقة الشرقيه في الطابق الثاني عدا سطحها ،دوبلكس مكونه من مستويين،المستوى السفلي A-122مساحته 118متر مربع و المستوى العلوي B-122مساحته 105متر مربع ', '122', 0, '', ''),
(3038, 1, '2', 1, 'Dulaim', '256', 1, 0, 0, '01-52)', 'Zoya', 'الشقة الغربيه في الطابق الثاني عدا سطحها،دوبلكس مكونه من مستويين،المستوى السفلي A-121مساحته 113 متر مربع و المستوى العلوي في الطابق الثالث B-121مساحته 113متر مربع ', '121', 0, '', ''),
(3039, 1, '3', 1, 'Dulaim', '299', 1, 0, 0, '01-63)', 'Zoya', 'الشقة الجنوبية في الطابق الثالث عدا سطحها،دوبلكس مكونه من مستويين،المستوى العلويA-131مساحته 136 متر مربع والمستوى السفلي في الطابق الثانيB-131مساحته 127متر مربع ', '131', 0, '', ''),
(3040, 1, '4', 2, 'Dulaim', '237', 1, 0, 0, '01-71)', 'Zoya', 'الشقة الشرقية في الطابق الرابع عدا سطحها ،دوبلكس مكونه من مستويين،المستوى السفلي A-142مساحته 118متر مربع والمستوى العلوي في الطابق الخامس B142مساحته 91متر مربع كما يتبعه تراس في المستوى العلوي في الجهة الشماليه (1) مساحته 14 متر مربع ', '142', 0, '', ''),
(3041, 1, '4', 1, 'Dulaim', '241', 1, 0, 0, '01-72)', 'Zoya', 'الشقة الغربية في الطابق الرابع عدا سطحها،دوبلكس مكونة من مستويين،المستوى السفلي A-141مساحته 113متر مربع و المستوى العلوي في الطابق الخامس B-141مساحته 99 متر مربع كما يتبعها تراس في المستوى العلوي فقط في الجهه الشمالية (6)مساحته 14 متر مربع ', '141', 0, '', ''),
(3042, 1, '5', 1, 'Dulaim', '289', 1, 0, 0, '01-83)', 'Zoya', 'الشقة الجنوبية من الطابق الخامس عدا سطحها وهي نظام دوبلكس مكون من مستويين المستوى العلوي مساحته 127 متر مربع يتبعه ترس في المستوى العلوي من الجهة الغربية مساحته 5 متر مربع وترس من الجهة الشرقية مساحته 5 متر مربع و المستوى السفلي في الطابق الرابع مساحته 12', '151', 0, '', ''),
(3043, 2, '-1', 2, 'Dulaim', '198', 1, 0, 0, '02-11)', 'Marmar', 'الشقة الشرقيه في طابق التسوية الاولى عدا سطحها ،ويتبعه تراس في الجهه الشرقيه (A4)مساحته 29 متر مربع ويتبعه تراس من الجهه الشرقيه و درج (A5)مساحته 89 متر مربع ', '-0212', 0, '', ''),
(3044, 2, '-1', 1, 'Dulaim', '198', 1, 0, 0, '02-12)', 'Marmar', 'الشقة الغربية طابق التسوية الاولى عدا سطحها ويتبعها تراس في الجهه الشماليه و الغربيه (A1)مساحته 29 متر مربع وكما يتبعه تراس في الجهه الغربيه (A2)مساحته 32 متر مربع ويتبعه تراس ابغربية (A3)مساحته 24 متر مربع ', '-0211', 0, '', ''),
(3045, 2, '1', 2, 'Dulaim', '90', 1, 0, 0, '02-31)', 'Marmar', 'الشقة الشرقية في الطابق الاول عدا سطحها ويتبعها تراس في الجهه الشماليه (A11)مساحته 5متر مربع ', '0212', 0, '', ''),
(3046, 2, '1', 1, 'Dulaim', '182', 1, 0, 0, '02-32)', 'Marmar', 'الشقة الغربيه في الطابق الاول عدا سطحها ويتبعه تراس في الجهه الشماليه (A10)مساحته 5متر مربع ', '0211', 0, '', ''),
(3047, 2, '1', 2, 'Dulaim', '90', 1, 0, 0, '02-33)', 'Marmar', '#N/A', '', 0, '', ''),
(3048, 2, '2', 1, 'Dulaim', '182', 1, 0, 0, '02-41)', 'Marmar', 'الشقة الشرقية في الطابق الثاني عدا سطحها ', '0222', 0, '', ''),
(3049, 2, '2', 2, 'Dulaim', '90', 1, 0, 0, '02-42)', 'Marmar', 'الشقة الغربية في الطابق الثاني عدا سطحها ', '0221', 0, '', ''),
(3050, 2, '2', 1, 'Dulaim', '90', 1, 0, 0, '02-43)', 'Marmar', '#N/A', '', 0, '', '');

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

--
-- Dumping data for table `uf_unit_history`
--

INSERT INTO `uf_unit_history` (`id`, `user_name`, `uid`, `action`, `date`, `customer_name`) VALUES
(1, 'admin', 2989, 'Reserved', '2017-10-31', 'زبون  رقم11'),
(2, 'admin', 2989, 'Cancellation for Reason: test', '2017-10-31', ''),
(3, 'admin', 2989, 'Reserved', '2017-10-31', 'asdasd'),
(4, 'admin', 2989, 'Cancellation for Reason: test test', '2017-10-31', ''),
(5, 'admin', 2989, 'Reserved', '2017-10-31', 'زبون  رقم11');

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
(1, 'admin', 'noora dmedi', 'ndmedi@asaltech.com', 'New User', 'en_US', 2, '1f28bedda823040bac64625bfbf45a5e', 1, 1, 0, '2016-10-04 14:21:44', '2017-09-17 10:57:34', '$2y$10$dpog/tQedgaKpMeOjzGT1eOyKAfck0x9YlFoUWsV4B.ATQZBSwr6C'),
(7, 'asal', 'test asal', 'test@gmail.com', 'New User', 'en_US', 1, '8f506364b74fe418b797e1cef92122ae', 1, 1, 1, '2017-08-02 10:42:08', '2017-09-07 08:41:50', '$2y$10$c8bFdS/JN83eoY4vzEJUD.OiXcCZ2LnzwrBXyDFrY5MtbYNPyzk6m'),
(8, 'asalAdmin', 'asal admin', 'test@test.com', 'New User', 'en_US', 2, 'afbc02b30e66d2f9654758bf64d70373', 1, 1, 1, '2017-08-02 10:42:36', '2017-08-02 10:43:04', '$2y$10$E.H2r0eX.2piGwU0mdG1c.kNTB9G6Hzt4s9OIjb.UHNB9TRCayKq2'),
(9, 'asalTest', 'asalTest', 'asalTest@gmail.com', 'New User', 'en_US', 1, '661472e4c97833de5981148d44c41c98', 1, 1, 1, '2017-09-07 08:39:24', '2017-09-07 08:40:37', '$2y$10$HNaQ1gUWE4L7ZP78dZhMQOTVZKYSb7cFE2.k8ieOu8f12zSvjRak6');

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
(458, 1, 'sign_in', '2017-08-02 12:32:38', 'User admin signed in at 2017-08-02 15:32:38.'),
(459, 1, 'sign_in', '2017-08-06 05:22:51', 'User admin signed in at 2017-08-06 08:22:51.'),
(460, 1, 'sign_in', '2017-08-06 05:27:56', 'User admin signed in at 2017-08-06 08:27:56.'),
(461, 7, 'sign_in', '2017-08-06 07:13:01', 'User asal signed in at 2017-08-06 10:13:01.'),
(462, 1, 'sign_in', '2017-08-06 07:26:09', 'User admin signed in at 2017-08-06 10:26:09.'),
(463, 7, 'sign_in', '2017-08-06 07:29:28', 'User asal signed in at 2017-08-06 10:29:28.'),
(464, 1, 'sign_in', '2017-08-06 07:49:11', 'User admin signed in at 2017-08-06 10:49:11.'),
(465, 7, 'sign_in', '2017-08-06 07:50:11', 'User asal signed in at 2017-08-06 10:50:11.'),
(466, 1, 'sign_in', '2017-08-06 08:01:49', 'User admin signed in at 2017-08-06 11:01:49.'),
(467, 7, 'sign_in', '2017-08-06 08:06:55', 'User asal signed in at 2017-08-06 11:06:55.'),
(468, 1, 'sign_in', '2017-08-06 08:14:05', 'User admin signed in at 2017-08-06 11:14:05.'),
(469, 1, 'sign_in', '2017-08-06 11:32:53', 'User admin signed in at 2017-08-06 14:32:53.'),
(470, 7, 'sign_in', '2017-08-08 10:10:06', 'User asal signed in at 2017-08-08 13:10:06.'),
(471, 1, 'sign_in', '2017-08-08 10:47:04', 'User admin signed in at 2017-08-08 13:47:04.'),
(472, 1, 'sign_in', '2017-07-24 11:11:43', 'User admin signed in at 2017-07-24 14:11:43.'),
(473, 1, 'sign_in', '2017-08-08 13:51:11', 'User admin signed in at 2017-08-08 16:51:11.'),
(474, 1, 'sign_in', '2017-08-21 10:36:26', 'User admin signed in at 2017-08-21 13:36:26.'),
(475, 1, 'sign_in', '2017-08-22 07:56:12', 'User admin signed in at 2017-08-22 10:56:12.'),
(476, 7, 'sign_in', '2017-08-22 08:43:06', 'User asal signed in at 2017-08-22 11:43:06.'),
(477, 1, 'sign_in', '2017-08-22 10:29:56', 'User admin signed in at 2017-08-22 13:29:56.'),
(478, 7, 'sign_in', '2017-08-24 10:16:09', 'User asal signed in at 2017-08-24 13:16:09.'),
(479, 1, 'sign_in', '2017-08-24 10:16:30', 'User admin signed in at 2017-08-24 13:16:30.'),
(480, 1, 'sign_in', '2017-08-27 05:10:49', 'User admin signed in at 2017-08-27 08:10:49.'),
(481, 1, 'sign_in', '2017-08-27 06:32:27', 'User admin signed in at 2017-08-27 09:32:27.'),
(482, 1, 'sign_in', '2017-08-28 12:49:48', 'User admin signed in at 2017-08-28 15:49:48.'),
(483, 1, 'sign_in', '2017-08-29 05:26:39', 'User admin signed in at 2017-08-29 08:26:39.'),
(484, 1, 'sign_in', '2017-08-29 06:21:35', 'User admin signed in at 2017-08-29 09:21:35.'),
(485, 1, 'sign_in', '2017-08-29 06:45:39', 'User admin signed in at 2017-08-29 09:45:39.'),
(486, 1, 'sign_in', '2017-08-29 06:49:48', 'User admin signed in at 2017-08-29 09:49:48.'),
(487, 1, 'sign_in', '2017-08-29 07:20:07', 'User admin signed in at 2017-08-29 10:20:07.'),
(488, 1, 'sign_in', '2017-08-29 07:36:14', 'User admin signed in at 2017-08-29 10:36:14.'),
(489, 1, 'sign_in', '2017-08-29 13:20:16', 'User admin signed in at 2017-08-29 16:20:16.'),
(490, 1, 'sign_in', '2017-08-29 13:20:27', 'User admin signed in at 2017-08-29 16:20:27.'),
(491, 1, 'sign_in', '2017-09-05 05:09:49', 'User admin signed in at 2017-09-05 08:09:49.'),
(492, 1, 'sign_in', '2017-09-05 12:46:17', 'User admin signed in at 2017-09-05 15:46:17.'),
(493, 1, 'sign_in', '2017-09-05 13:43:22', 'User admin signed in at 2017-09-05 16:43:22.'),
(494, 1, 'sign_in', '2017-09-07 07:14:02', 'User admin signed in at 2017-09-07 10:14:02.'),
(495, 1, 'sign_in', '2017-09-07 07:19:51', 'User admin signed in at 2017-09-07 10:19:51.'),
(496, 1, 'sign_in', '2017-09-07 07:56:15', 'User admin signed in at 2017-09-07 10:56:15.'),
(497, 7, 'sign_in', '2017-09-07 08:22:36', 'User asal signed in at 2017-09-07 11:22:36.'),
(498, 1, 'sign_in', '2017-09-07 08:25:06', 'User admin signed in at 2017-09-07 11:25:06.'),
(499, 7, 'sign_in', '2017-09-07 08:28:11', 'User asal signed in at 2017-09-07 11:28:11.'),
(500, 1, 'sign_in', '2017-09-07 08:38:43', 'User admin signed in at 2017-09-07 11:38:43.'),
(501, 9, 'sign_up', '2017-09-07 08:39:24', 'User asalTest was created by admin on 2017-09-07 11:39:24.'),
(502, 9, 'password_reset_request', '2017-09-07 08:39:24', 'User asalTest requested a password reset on 2017-09-07 11:39:24.'),
(503, 1, 'sign_in', '2017-09-07 08:40:10', 'User admin signed in at 2017-09-07 11:40:10.'),
(504, 9, 'sign_in', '2017-09-07 08:40:55', 'User asalTest signed in at 2017-09-07 11:40:55.'),
(505, 7, 'sign_in', '2017-09-07 08:41:23', 'User asal signed in at 2017-09-07 11:41:23.'),
(506, 1, 'sign_in', '2017-09-07 08:42:18', 'User admin signed in at 2017-09-07 11:42:18.'),
(507, 1, 'sign_in', '2017-09-07 10:17:06', 'User admin signed in at 2017-09-07 13:17:06.'),
(508, 1, 'sign_in', '2017-09-07 10:19:08', 'User admin signed in at 2017-09-07 13:19:08.'),
(509, 1, 'sign_in', '2017-09-07 10:20:45', 'User admin signed in at 2017-09-07 13:20:45.'),
(510, 1, 'sign_in', '2017-09-07 10:22:00', 'User admin signed in at 2017-09-07 13:22:00.'),
(511, 1, 'sign_in', '2017-09-07 10:26:25', 'User admin signed in at 2017-09-07 13:26:25.'),
(512, 1, 'sign_in', '2017-09-07 10:52:26', 'User admin signed in at 2017-09-07 13:52:26.'),
(513, 1, 'sign_in', '2017-09-07 10:54:23', 'User admin signed in at 2017-09-07 13:54:23.'),
(514, 1, 'sign_in', '2017-09-07 10:55:06', 'User admin signed in at 2017-09-07 13:55:06.'),
(515, 1, 'sign_in', '2017-09-07 10:56:11', 'User admin signed in at 2017-09-07 13:56:11.'),
(516, 1, 'sign_in', '2017-09-07 10:56:35', 'User admin signed in at 2017-09-07 13:56:35.'),
(517, 1, 'sign_in', '2017-09-07 10:57:06', 'User admin signed in at 2017-09-07 13:57:06.'),
(518, 1, 'sign_in', '2017-09-07 11:04:43', 'User admin signed in at 2017-09-07 14:04:43.'),
(519, 1, 'sign_in', '2017-09-07 11:05:24', 'User admin signed in at 2017-09-07 14:05:24.'),
(520, 1, 'sign_in', '2017-09-07 11:17:28', 'User admin signed in at 2017-09-07 14:17:28.'),
(521, 1, 'sign_in', '2017-09-07 11:33:24', 'User admin signed in at 2017-09-07 14:33:24.'),
(522, 1, 'sign_in', '2017-09-07 11:36:49', 'User admin signed in at 2017-09-07 14:36:49.'),
(523, 1, 'sign_in', '2017-09-07 11:40:02', 'User admin signed in at 2017-09-07 14:40:02.'),
(524, 1, 'sign_in', '2017-09-07 11:45:21', 'User admin signed in at 2017-09-07 14:45:21.'),
(525, 1, 'sign_in', '2017-09-07 11:55:33', 'User admin signed in at 2017-09-07 14:55:33.'),
(526, 1, 'sign_in', '2017-09-07 11:55:54', 'User admin signed in at 2017-09-07 14:55:54.'),
(527, 1, 'sign_in', '2017-09-07 11:58:11', 'User admin signed in at 2017-09-07 14:58:11.'),
(528, 1, 'sign_in', '2017-09-07 11:58:34', 'User admin signed in at 2017-09-07 14:58:34.'),
(529, 1, 'sign_in', '2017-09-07 12:06:21', 'User admin signed in at 2017-09-07 15:06:21.'),
(530, 1, 'sign_in', '2017-09-07 12:09:51', 'User admin signed in at 2017-09-07 15:09:51.'),
(531, 1, 'sign_in', '2017-09-07 12:11:06', 'User admin signed in at 2017-09-07 15:11:06.'),
(532, 1, 'sign_in', '2017-09-07 12:12:03', 'User admin signed in at 2017-09-07 15:12:03.'),
(533, 1, 'sign_in', '2017-09-07 12:12:54', 'User admin signed in at 2017-09-07 15:12:54.'),
(534, 1, 'sign_in', '2017-09-07 12:15:49', 'User admin signed in at 2017-09-07 15:15:49.'),
(535, 1, 'sign_in', '2017-09-07 12:16:33', 'User admin signed in at 2017-09-07 15:16:33.'),
(536, 1, 'sign_in', '2017-09-07 12:18:41', 'User admin signed in at 2017-09-07 15:18:41.'),
(537, 1, 'sign_in', '2017-09-07 12:25:15', 'User admin signed in at 2017-09-07 15:25:15.'),
(538, 1, 'sign_in', '2017-09-07 12:26:05', 'User admin signed in at 2017-09-07 15:26:05.'),
(539, 1, 'sign_in', '2017-09-07 12:27:44', 'User admin signed in at 2017-09-07 15:27:44.'),
(540, 1, 'sign_in', '2017-09-07 12:41:09', 'User admin signed in at 2017-09-07 15:41:09.'),
(541, 1, 'sign_in', '2017-09-07 12:42:04', 'User admin signed in at 2017-09-07 15:42:04.'),
(542, 1, 'sign_in', '2017-09-07 12:44:04', 'User admin signed in at 2017-09-07 15:44:04.'),
(543, 1, 'sign_in', '2017-09-07 12:44:28', 'User admin signed in at 2017-09-07 15:44:28.'),
(544, 1, 'sign_in', '2017-09-07 12:46:57', 'User admin signed in at 2017-09-07 15:46:57.'),
(545, 1, 'sign_in', '2017-09-07 12:47:56', 'User admin signed in at 2017-09-07 15:47:56.'),
(546, 1, 'sign_in', '2017-09-07 12:48:29', 'User admin signed in at 2017-09-07 15:48:29.'),
(547, 1, 'sign_in', '2017-09-07 12:59:00', 'User admin signed in at 2017-09-07 15:59:00.'),
(548, 1, 'sign_in', '2017-09-07 13:01:43', 'User admin signed in at 2017-09-07 16:01:43.'),
(549, 1, 'sign_in', '2017-09-10 05:46:32', 'User admin signed in at 2017-09-10 08:46:32.'),
(550, 1, 'sign_in', '2017-09-10 05:59:45', 'User admin signed in at 2017-09-10 08:59:44.'),
(551, 1, 'sign_in', '2017-09-10 06:31:38', 'User admin signed in at 2017-09-10 09:31:38.'),
(552, 1, 'sign_in', '2017-09-10 06:33:05', 'User admin signed in at 2017-09-10 09:33:05.'),
(553, 1, 'sign_in', '2017-09-10 06:33:35', 'User admin signed in at 2017-09-10 09:33:35.'),
(554, 1, 'sign_in', '2017-09-10 06:36:00', 'User admin signed in at 2017-09-10 09:36:00.'),
(555, 1, 'sign_in', '2017-09-10 06:39:25', 'User admin signed in at 2017-09-10 09:39:25.'),
(556, 1, 'sign_in', '2017-09-10 06:41:41', 'User admin signed in at 2017-09-10 09:41:41.'),
(557, 1, 'sign_in', '2017-09-10 06:44:38', 'User admin signed in at 2017-09-10 09:44:38.'),
(558, 1, 'sign_in', '2017-09-10 06:59:52', 'User admin signed in at 2017-09-10 09:59:52.'),
(559, 1, 'sign_in', '2017-09-10 07:03:00', 'User admin signed in at 2017-09-10 10:03:00.'),
(560, 1, 'sign_in', '2017-09-10 07:11:12', 'User admin signed in at 2017-09-10 10:11:12.'),
(561, 1, 'sign_in', '2017-09-10 07:16:38', 'User admin signed in at 2017-09-10 10:16:38.'),
(562, 1, 'sign_in', '2017-09-10 07:18:28', 'User admin signed in at 2017-09-10 10:18:28.'),
(563, 1, 'sign_in', '2017-09-10 07:20:34', 'User admin signed in at 2017-09-10 10:20:34.'),
(564, 1, 'sign_in', '2017-09-10 07:23:27', 'User admin signed in at 2017-09-10 10:23:27.'),
(565, 1, 'sign_in', '2017-09-10 07:25:43', 'User admin signed in at 2017-09-10 10:25:43.'),
(566, 1, 'sign_in', '2017-09-10 07:27:38', 'User admin signed in at 2017-09-10 10:27:38.'),
(567, 1, 'sign_in', '2017-09-10 07:29:18', 'User admin signed in at 2017-09-10 10:29:18.'),
(568, 1, 'sign_in', '2017-09-10 07:31:18', 'User admin signed in at 2017-09-10 10:31:18.'),
(569, 1, 'sign_in', '2017-09-10 07:40:45', 'User admin signed in at 2017-09-10 10:40:45.'),
(570, 1, 'sign_in', '2017-09-10 07:42:23', 'User admin signed in at 2017-09-10 10:42:23.'),
(571, 1, 'sign_in', '2017-09-10 07:44:59', 'User admin signed in at 2017-09-10 10:44:59.'),
(572, 1, 'sign_in', '2017-09-10 07:47:44', 'User admin signed in at 2017-09-10 10:47:44.'),
(573, 1, 'sign_in', '2017-09-10 07:51:19', 'User admin signed in at 2017-09-10 10:51:19.'),
(574, 1, 'sign_in', '2017-09-10 07:58:07', 'User admin signed in at 2017-09-10 10:58:07.'),
(575, 1, 'sign_in', '2017-09-10 08:00:35', 'User admin signed in at 2017-09-10 11:00:35.'),
(576, 1, 'sign_in', '2017-09-10 08:02:07', 'User admin signed in at 2017-09-10 11:02:07.'),
(577, 1, 'sign_in', '2017-09-10 08:05:03', 'User admin signed in at 2017-09-10 11:05:03.'),
(578, 1, 'sign_in', '2017-09-10 08:09:14', 'User admin signed in at 2017-09-10 11:09:14.'),
(579, 1, 'sign_in', '2017-09-10 08:11:55', 'User admin signed in at 2017-09-10 11:11:55.'),
(580, 1, 'sign_in', '2017-09-10 08:14:10', 'User admin signed in at 2017-09-10 11:14:10.'),
(581, 1, 'sign_in', '2017-09-10 08:16:31', 'User admin signed in at 2017-09-10 11:16:31.'),
(582, 1, 'sign_in', '2017-09-10 08:20:04', 'User admin signed in at 2017-09-10 11:20:04.'),
(583, 1, 'sign_in', '2017-09-10 08:22:11', 'User admin signed in at 2017-09-10 11:22:11.'),
(584, 1, 'sign_in', '2017-09-10 08:25:58', 'User admin signed in at 2017-09-10 11:25:58.'),
(585, 1, 'sign_in', '2017-09-10 08:29:49', 'User admin signed in at 2017-09-10 11:29:49.'),
(586, 1, 'sign_in', '2017-09-10 08:31:15', 'User admin signed in at 2017-09-10 11:31:15.'),
(587, 1, 'sign_in', '2017-09-10 08:36:17', 'User admin signed in at 2017-09-10 11:36:17.'),
(588, 1, 'sign_in', '2017-09-10 08:38:46', 'User admin signed in at 2017-09-10 11:38:46.'),
(589, 1, 'sign_in', '2017-09-10 08:41:58', 'User admin signed in at 2017-09-10 11:41:58.'),
(590, 1, 'sign_in', '2017-09-10 08:43:16', 'User admin signed in at 2017-09-10 11:43:16.'),
(591, 1, 'sign_in', '2017-09-10 08:45:52', 'User admin signed in at 2017-09-10 11:45:52.'),
(592, 1, 'sign_in', '2017-09-10 08:48:38', 'User admin signed in at 2017-09-10 11:48:38.'),
(593, 1, 'sign_in', '2017-09-10 08:54:06', 'User admin signed in at 2017-09-10 11:54:06.'),
(594, 1, 'sign_in', '2017-09-10 08:55:09', 'User admin signed in at 2017-09-10 11:55:09.'),
(595, 1, 'sign_in', '2017-09-10 08:56:18', 'User admin signed in at 2017-09-10 11:56:18.'),
(596, 1, 'sign_in', '2017-09-10 08:57:21', 'User admin signed in at 2017-09-10 11:57:21.'),
(597, 1, 'sign_in', '2017-09-10 10:03:54', 'User admin signed in at 2017-09-10 13:03:54.'),
(598, 1, 'sign_in', '2017-09-10 10:16:28', 'User admin signed in at 2017-09-10 13:16:28.'),
(599, 1, 'sign_in', '2017-09-10 10:17:47', 'User admin signed in at 2017-09-10 13:17:47.'),
(600, 1, 'sign_in', '2017-09-10 10:18:01', 'User admin signed in at 2017-09-10 13:18:01.'),
(601, 1, 'sign_in', '2017-09-10 10:23:46', 'User admin signed in at 2017-09-10 13:23:46.'),
(602, 1, 'sign_in', '2017-09-10 10:25:28', 'User admin signed in at 2017-09-10 13:25:28.'),
(603, 1, 'sign_in', '2017-09-10 10:25:59', 'User admin signed in at 2017-09-10 13:25:59.'),
(604, 1, 'sign_in', '2017-09-10 10:33:30', 'User admin signed in at 2017-09-10 13:33:30.'),
(605, 1, 'sign_in', '2017-09-10 10:46:22', 'User admin signed in at 2017-09-10 13:46:22.'),
(606, 1, 'sign_in', '2017-09-10 10:47:55', 'User admin signed in at 2017-09-10 13:47:55.'),
(607, 1, 'sign_in', '2017-09-10 10:49:19', 'User admin signed in at 2017-09-10 13:49:19.'),
(608, 1, 'sign_in', '2017-09-10 10:52:39', 'User admin signed in at 2017-09-10 13:52:39.'),
(609, 1, 'sign_in', '2017-09-10 10:54:06', 'User admin signed in at 2017-09-10 13:54:06.'),
(610, 1, 'sign_in', '2017-09-10 11:47:45', 'User admin signed in at 2017-09-10 14:47:45.'),
(611, 1, 'sign_in', '2017-09-10 11:48:25', 'User admin signed in at 2017-09-10 14:48:25.'),
(612, 1, 'sign_in', '2017-09-10 11:49:00', 'User admin signed in at 2017-09-10 14:49:00.'),
(613, 1, 'sign_in', '2017-09-10 11:49:18', 'User admin signed in at 2017-09-10 14:49:18.'),
(614, 1, 'sign_in', '2017-09-10 11:50:11', 'User admin signed in at 2017-09-10 14:50:11.'),
(615, 1, 'sign_in', '2017-09-10 12:15:54', 'User admin signed in at 2017-09-10 15:15:54.'),
(616, 1, 'sign_in', '2017-09-10 12:22:02', 'User admin signed in at 2017-09-10 15:22:02.'),
(617, 1, 'sign_in', '2017-09-10 12:26:13', 'User admin signed in at 2017-09-10 15:26:13.'),
(618, 1, 'sign_in', '2017-09-10 12:34:13', 'User admin signed in at 2017-09-10 15:34:13.'),
(619, 1, 'sign_in', '2017-09-10 12:39:39', 'User admin signed in at 2017-09-10 15:39:39.'),
(620, 1, 'sign_in', '2017-09-10 12:49:24', 'User admin signed in at 2017-09-10 15:49:24.'),
(621, 1, 'sign_in', '2017-09-10 12:53:29', 'User admin signed in at 2017-09-10 15:53:29.'),
(622, 1, 'sign_in', '2017-09-10 13:02:29', 'User admin signed in at 2017-09-10 16:02:29.'),
(623, 1, 'sign_in', '2017-09-10 13:07:01', 'User admin signed in at 2017-09-10 16:07:01.'),
(624, 1, 'sign_in', '2017-09-10 13:28:41', 'User admin signed in at 2017-09-10 16:28:41.'),
(625, 1, 'sign_in', '2017-09-11 05:05:49', 'User admin signed in at 2017-09-11 08:05:49.'),
(626, 1, 'sign_in', '2017-09-11 06:26:50', 'User admin signed in at 2017-09-11 09:26:50.'),
(627, 1, 'sign_in', '2017-09-11 08:11:28', 'User admin signed in at 2017-09-11 11:11:28.'),
(628, 1, 'sign_in', '2017-09-11 08:28:57', 'User admin signed in at 2017-09-11 11:28:57.'),
(629, 1, 'sign_in', '2017-09-11 10:18:05', 'User admin signed in at 2017-09-11 13:18:05.'),
(630, 1, 'sign_in', '2017-09-11 11:26:10', 'User admin signed in at 2017-09-11 14:26:10.'),
(631, 1, 'sign_in', '2017-09-12 07:34:24', 'User admin signed in at 2017-09-12 10:34:24.'),
(632, 1, 'sign_in', '2017-09-12 07:50:56', 'User admin signed in at 2017-09-12 10:50:56.'),
(633, 1, 'sign_in', '2017-09-12 08:04:46', 'User admin signed in at 2017-09-12 11:04:46.'),
(634, 1, 'sign_in', '2017-09-12 11:07:22', 'User admin signed in at 2017-09-12 14:07:22.'),
(635, 1, 'sign_in', '2017-09-12 11:17:38', 'User admin signed in at 2017-09-12 14:17:38.'),
(636, 1, 'sign_in', '2017-09-12 11:55:04', 'User admin signed in at 2017-09-12 14:55:04.'),
(637, 1, 'sign_in', '2017-09-12 12:56:53', 'User admin signed in at 2017-09-12 15:56:53.'),
(638, 1, 'sign_in', '2017-09-13 05:39:26', 'User admin signed in at 2017-09-13 08:39:26.'),
(639, 1, 'sign_in', '2017-09-13 06:32:31', 'User admin signed in at 2017-09-13 09:32:31.'),
(640, 1, 'sign_in', '2017-09-13 07:08:49', 'User admin signed in at 2017-09-13 10:08:49.'),
(641, 1, 'sign_in', '2017-09-13 07:41:27', 'User admin signed in at 2017-09-13 10:41:27.'),
(642, 1, 'sign_in', '2017-09-13 08:34:43', 'User admin signed in at 2017-09-13 11:34:43.'),
(643, 1, 'sign_in', '2017-09-13 10:15:10', 'User admin signed in at 2017-09-13 13:15:10.'),
(644, 1, 'sign_in', '2017-09-13 10:48:10', 'User admin signed in at 2017-09-13 13:48:10.'),
(645, 7, 'sign_in', '2017-09-13 11:58:05', 'User asal signed in at 2017-09-13 14:58:05.'),
(646, 1, 'sign_in', '2017-09-13 11:59:09', 'User admin signed in at 2017-09-13 14:59:09.'),
(647, 7, 'sign_in', '2017-09-13 12:05:40', 'User asal signed in at 2017-09-13 15:05:40.'),
(648, 1, 'sign_in', '2017-09-13 12:07:50', 'User admin signed in at 2017-09-13 15:07:50.'),
(649, 7, 'sign_in', '2017-09-13 12:21:37', 'User asal signed in at 2017-09-13 15:21:37.'),
(650, 1, 'sign_in', '2017-09-13 12:25:07', 'User admin signed in at 2017-09-13 15:25:07.'),
(651, 7, 'sign_in', '2017-09-13 12:40:31', 'User asal signed in at 2017-09-13 15:40:31.'),
(652, 1, 'sign_in', '2017-09-13 12:42:05', 'User admin signed in at 2017-09-13 15:42:05.'),
(653, 1, 'sign_in', '2017-09-13 12:52:29', 'User admin signed in at 2017-09-13 15:52:29.'),
(654, 7, 'sign_in', '2017-09-13 12:53:12', 'User asal signed in at 2017-09-13 15:53:12.'),
(655, 1, 'sign_in', '2017-09-13 12:53:41', 'User admin signed in at 2017-09-13 15:53:41.'),
(656, 7, 'sign_in', '2017-09-13 13:12:11', 'User asal signed in at 2017-09-13 16:12:11.'),
(657, 1, 'sign_in', '2017-09-13 13:13:14', 'User admin signed in at 2017-09-13 16:13:14.'),
(658, 7, 'sign_in', '2017-09-13 13:14:16', 'User asal signed in at 2017-09-13 16:14:16.'),
(659, 1, 'sign_in', '2017-09-13 13:14:46', 'User admin signed in at 2017-09-13 16:14:46.'),
(660, 7, 'sign_in', '2017-09-13 13:15:24', 'User asal signed in at 2017-09-13 16:15:24.'),
(661, 1, 'sign_in', '2017-09-13 13:16:13', 'User admin signed in at 2017-09-13 16:16:13.'),
(662, 7, 'sign_in', '2017-09-13 13:19:20', 'User asal signed in at 2017-09-13 16:19:20.'),
(663, 1, 'sign_in', '2017-09-13 13:20:00', 'User admin signed in at 2017-09-13 16:20:00.'),
(664, 7, 'sign_in', '2017-09-13 13:37:17', 'User asal signed in at 2017-09-13 16:37:17.'),
(665, 1, 'sign_in', '2017-09-13 13:43:27', 'User admin signed in at 2017-09-13 16:43:27.'),
(666, 1, 'sign_in', '2017-09-14 07:10:45', 'User admin signed in at 2017-09-14 10:10:45.'),
(667, 1, 'sign_in', '2017-09-14 08:55:00', 'User admin signed in at 2017-09-14 11:55:00.'),
(668, 1, 'sign_in', '2017-09-14 10:01:11', 'User admin signed in at 2017-09-14 13:01:11.'),
(669, 1, 'sign_in', '2017-09-14 10:12:18', 'User admin signed in at 2017-09-14 13:12:18.'),
(670, 1, 'sign_in', '2017-09-14 10:34:07', 'User admin signed in at 2017-09-14 13:34:07.'),
(671, 1, 'sign_in', '2017-09-14 11:44:50', 'User admin signed in at 2017-09-14 14:44:50.'),
(672, 1, 'sign_in', '2017-09-14 11:46:25', 'User admin signed in at 2017-09-14 14:46:25.'),
(673, 1, 'sign_in', '2017-09-14 12:02:51', 'User admin signed in at 2017-09-14 15:02:51.'),
(674, 1, 'sign_in', '2017-09-17 05:08:18', 'User admin signed in at 2017-09-17 08:08:17.'),
(675, 7, 'sign_in', '2017-09-17 06:41:40', 'User asal signed in at 2017-09-17 09:41:40.'),
(676, 1, 'sign_in', '2017-09-17 07:19:59', 'User admin signed in at 2017-09-17 10:19:59.'),
(677, 1, 'sign_in', '2017-09-17 10:55:50', 'User admin signed in at 2017-09-17 13:55:50.'),
(678, 1, 'password_reset_request', '2017-09-17 10:56:22', 'User admin requested a password reset on 2017-09-17 13:56:17.'),
(679, 1, 'sign_in', '2017-09-17 10:57:34', 'User admin signed in at 2017-09-17 13:57:34.'),
(680, 7, 'sign_in', '2017-09-18 06:13:58', 'User asal signed in at 2017-09-18 09:13:58.'),
(681, 1, 'sign_in', '2017-09-18 12:10:01', 'User admin signed in at 2017-09-18 15:10:01.'),
(682, 1, 'sign_in', '2017-09-24 12:08:18', 'User admin signed in at 2017-09-24 15:08:18.'),
(683, 1, 'sign_in', '2017-10-01 12:02:12', 'User admin signed in at 2017-10-01 15:02:12.'),
(684, 1, 'sign_in', '2017-10-23 08:01:50', 'User admin signed in at 2017-10-23 11:01:50.'),
(685, 1, 'sign_in', '2017-10-23 08:15:10', 'User admin signed in at 2017-10-23 11:15:10.'),
(686, 1, 'sign_in', '2017-10-23 11:03:29', 'User admin signed in at 2017-10-23 14:03:29.'),
(687, 1, 'sign_in', '2017-10-23 11:48:50', 'User admin signed in at 2017-10-23 14:48:50.'),
(688, 1, 'sign_in', '2017-10-23 12:22:32', 'User admin signed in at 2017-10-23 15:22:32.'),
(689, 1, 'sign_in', '2017-10-23 12:57:49', 'User admin signed in at 2017-10-23 15:57:49.'),
(690, 1, 'sign_in', '2017-10-24 05:44:58', 'User admin signed in at 2017-10-24 08:44:58.'),
(691, 1, 'sign_in', '2017-10-24 06:30:06', 'User admin signed in at 2017-10-24 09:30:06.'),
(692, 1, 'sign_in', '2017-10-24 06:54:41', 'User admin signed in at 2017-10-24 09:54:41.'),
(693, 1, 'sign_in', '2017-10-24 07:33:11', 'User admin signed in at 2017-10-24 10:33:11.'),
(694, 7, 'sign_in', '2017-10-24 07:44:48', 'User asal signed in at 2017-10-24 10:44:48.'),
(695, 9, 'sign_in', '2017-10-24 07:45:04', 'User asalTest signed in at 2017-10-24 10:45:04.'),
(696, 1, 'sign_in', '2017-10-24 07:47:02', 'User admin signed in at 2017-10-24 10:47:01.'),
(697, 9, 'sign_in', '2017-10-24 07:54:03', 'User asalTest signed in at 2017-10-24 10:54:03.'),
(698, 1, 'sign_in', '2017-10-24 07:55:34', 'User admin signed in at 2017-10-24 10:55:34.'),
(699, 9, 'sign_in', '2017-10-24 08:09:11', 'User asalTest signed in at 2017-10-24 11:09:11.'),
(700, 1, 'sign_in', '2017-10-24 08:09:47', 'User admin signed in at 2017-10-24 11:09:47.'),
(701, 1, 'sign_in', '2017-10-24 08:10:35', 'User admin signed in at 2017-10-24 11:10:35.'),
(702, 1, 'sign_in', '2017-10-24 08:51:56', 'User admin signed in at 2017-10-24 11:51:56.'),
(703, 1, 'sign_in', '2017-10-24 09:01:47', 'User admin signed in at 2017-10-24 12:01:47.'),
(704, 1, 'sign_in', '2017-10-24 10:10:19', 'User admin signed in at 2017-10-24 13:10:19.'),
(705, 1, 'sign_in', '2017-10-24 10:48:08', 'User admin signed in at 2017-10-24 13:48:08.'),
(706, 1, 'sign_in', '2017-10-24 10:55:41', 'User admin signed in at 2017-10-24 13:55:41.'),
(707, 9, 'sign_in', '2017-10-24 10:56:43', 'User asalTest signed in at 2017-10-24 13:56:43.'),
(708, 1, 'sign_in', '2017-10-25 05:47:03', 'User admin signed in at 2017-10-25 08:47:03.'),
(709, 1, 'sign_in', '2017-10-25 06:00:36', 'User admin signed in at 2017-10-25 09:00:36.'),
(710, 1, 'sign_in', '2017-10-25 06:31:15', 'User admin signed in at 2017-10-25 09:31:15.'),
(711, 1, 'sign_in', '2017-10-25 07:03:44', 'User admin signed in at 2017-10-25 10:03:44.'),
(712, 1, 'sign_in', '2017-10-25 07:20:05', 'User admin signed in at 2017-10-25 10:20:05.'),
(713, 1, 'sign_in', '2017-10-25 08:00:34', 'User admin signed in at 2017-10-25 11:00:34.'),
(714, 1, 'sign_in', '2017-10-25 08:16:20', 'User admin signed in at 2017-10-25 11:16:20.'),
(715, 1, 'sign_in', '2017-10-25 08:24:36', 'User admin signed in at 2017-10-25 11:24:36.'),
(716, 1, 'sign_in', '2017-10-25 08:28:09', 'User admin signed in at 2017-10-25 11:28:09.'),
(717, 1, 'sign_in', '2017-10-25 08:30:39', 'User admin signed in at 2017-10-25 11:30:39.'),
(718, 1, 'sign_in', '2017-10-25 08:33:33', 'User admin signed in at 2017-10-25 11:33:33.'),
(719, 1, 'sign_in', '2017-10-25 08:40:31', 'User admin signed in at 2017-10-25 11:40:31.'),
(720, 1, 'sign_in', '2017-10-25 08:42:37', 'User admin signed in at 2017-10-25 11:42:37.'),
(721, 1, 'sign_in', '2017-10-25 08:43:49', 'User admin signed in at 2017-10-25 11:43:49.'),
(722, 1, 'sign_in', '2017-10-25 08:47:40', 'User admin signed in at 2017-10-25 11:47:40.'),
(723, 1, 'sign_in', '2017-10-25 08:54:49', 'User admin signed in at 2017-10-25 11:54:49.'),
(724, 1, 'sign_in', '2017-10-25 08:57:01', 'User admin signed in at 2017-10-25 11:57:01.'),
(725, 1, 'sign_in', '2017-10-25 09:00:45', 'User admin signed in at 2017-10-25 12:00:45.'),
(726, 1, 'sign_in', '2017-10-25 10:06:05', 'User admin signed in at 2017-10-25 13:06:05.'),
(727, 1, 'sign_in', '2017-10-25 10:09:41', 'User admin signed in at 2017-10-25 13:09:41.'),
(728, 1, 'sign_in', '2017-10-25 10:15:31', 'User admin signed in at 2017-10-25 13:15:31.'),
(729, 1, 'sign_in', '2017-10-25 10:16:30', 'User admin signed in at 2017-10-25 13:16:30.'),
(730, 1, 'sign_in', '2017-10-25 10:26:27', 'User admin signed in at 2017-10-25 13:26:27.'),
(731, 1, 'sign_in', '2017-10-25 10:29:06', 'User admin signed in at 2017-10-25 13:29:06.'),
(732, 1, 'sign_in', '2017-10-25 10:30:12', 'User admin signed in at 2017-10-25 13:30:12.'),
(733, 1, 'sign_in', '2017-10-25 10:35:35', 'User admin signed in at 2017-10-25 13:35:35.'),
(734, 1, 'sign_in', '2017-10-25 10:50:55', 'User admin signed in at 2017-10-25 13:50:55.'),
(735, 1, 'sign_in', '2017-10-25 10:54:20', 'User admin signed in at 2017-10-25 13:54:20.'),
(736, 1, 'sign_in', '2017-10-25 11:10:28', 'User admin signed in at 2017-10-25 14:10:28.'),
(737, 1, 'sign_in', '2017-10-25 11:13:46', 'User admin signed in at 2017-10-25 14:13:46.'),
(738, 1, 'sign_in', '2017-10-25 11:20:29', 'User admin signed in at 2017-10-25 14:20:29.'),
(739, 1, 'sign_in', '2017-10-25 11:21:18', 'User admin signed in at 2017-10-25 14:21:18.'),
(740, 1, 'sign_in', '2017-10-25 11:53:15', 'User admin signed in at 2017-10-25 14:53:15.'),
(741, 1, 'sign_in', '2017-10-25 13:14:18', 'User admin signed in at 2017-10-25 16:14:18.'),
(742, 1, 'sign_in', '2017-10-26 06:10:41', 'User admin signed in at 2017-10-26 09:10:41.'),
(743, 1, 'sign_in', '2017-10-26 13:20:24', 'User admin signed in at 2017-10-26 16:20:24.'),
(744, 1, 'sign_in', '2017-10-31 07:14:11', 'User admin signed in at 2017-10-31 09:14:11.'),
(745, 1, 'sign_in', '2017-10-31 07:21:05', 'User admin signed in at 2017-10-31 09:21:05.'),
(746, 1, 'sign_in', '2017-10-31 07:42:11', 'User admin signed in at 2017-10-31 09:42:11.'),
(747, 1, 'sign_in', '2017-10-31 08:26:16', 'User admin signed in at 2017-10-31 10:26:16.'),
(748, 1, 'sign_in', '2017-10-31 08:53:35', 'User admin signed in at 2017-10-31 10:53:35.'),
(749, 1, 'sign_in', '2017-10-31 09:23:21', 'User admin signed in at 2017-10-31 11:23:21.'),
(750, 1, 'sign_in', '2017-12-06 08:41:01', 'User admin signed in at 2017-12-06 10:41:01.'),
(751, 1, 'sign_in', '2017-12-06 12:10:48', 'User admin signed in at 2017-12-06 14:10:48.'),
(752, 1, 'sign_in', '2017-12-06 12:19:19', 'User admin signed in at 2017-12-06 14:19:19.'),
(753, 1, 'sign_in', '2017-12-06 12:34:08', 'User admin signed in at 2017-12-06 14:34:08.'),
(754, 1, 'sign_in', '2017-12-06 12:50:30', 'User admin signed in at 2017-12-06 14:50:30.'),
(755, 1, 'sign_in', '2017-12-06 13:10:55', 'User admin signed in at 2017-12-06 15:10:55.'),
(756, 1, 'sign_in', '2017-12-06 13:27:35', 'User admin signed in at 2017-12-06 15:27:35.'),
(757, 1, 'sign_in', '2017-12-06 14:09:24', 'User admin signed in at 2017-12-06 16:09:24.'),
(758, 1, 'sign_in', '2017-12-06 14:20:59', 'User admin signed in at 2017-12-06 16:20:59.'),
(759, 1, 'sign_in', '2017-12-06 14:32:54', 'User admin signed in at 2017-12-06 16:32:54.'),
(760, 1, 'sign_in', '2017-12-10 09:27:15', 'User admin signed in at 2017-12-10 11:27:15.'),
(761, 1, 'sign_in', '2017-12-10 10:54:00', 'User admin signed in at 2017-12-10 12:54:00.'),
(762, 1, 'sign_in', '2017-12-10 11:06:19', 'User admin signed in at 2017-12-10 13:06:19.'),
(763, 1, 'sign_in', '2017-12-10 12:26:11', 'User admin signed in at 2017-12-10 14:26:11.'),
(764, 1, 'sign_in', '2017-12-10 12:48:27', 'User admin signed in at 2017-12-10 14:48:27.');

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `uf_mssql_config`
--
ALTER TABLE `uf_mssql_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `uf_neighborhoods`
--
ALTER TABLE `uf_neighborhoods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `uf_reservation_unit`
--
ALTER TABLE `uf_reservation_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `uf_reservation_user`
--
ALTER TABLE `uf_reservation_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `uf_serial_number`
--
ALTER TABLE `uf_serial_number`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `uf_unit`
--
ALTER TABLE `uf_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3065;
--
-- AUTO_INCREMENT for table `uf_units_images`
--
ALTER TABLE `uf_units_images`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_unit_history`
--
ALTER TABLE `uf_unit_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `uf_uploadedfiles`
--
ALTER TABLE `uf_uploadedfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_user`
--
ALTER TABLE `uf_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `uf_user_event`
--
ALTER TABLE `uf_user_event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=765;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

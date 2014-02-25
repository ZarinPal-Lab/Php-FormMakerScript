-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 30, 2014 at 04:05 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `after_payment`
--

CREATE TABLE IF NOT EXISTS `after_payment` (
  `afterPaymentId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `afterPaymentFormId` int(10) unsigned NOT NULL,
  `afterPaymentContent` text,
  PRIMARY KEY (`afterPaymentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `contactId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contactName` varchar(255) NOT NULL,
  `contactEmail` varchar(255) NOT NULL,
  `contactSubject` varchar(255) NOT NULL,
  `contactContent` text NOT NULL,
  `contactIp` varchar(15) NOT NULL,
  `contactDate` int(10) unsigned NOT NULL,
  `contactRead` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`contactId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE IF NOT EXISTS `form` (
  `formId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `formName` varchar(255) NOT NULL,
  `formDescription` varchar(255) NOT NULL,
  `formTag` varchar(255) NOT NULL,
  `formContent` text,
  `formPriceValue` varchar(255) NOT NULL,
  `formPriceType` varchar(20) NOT NULL,
  `formStatus` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`formId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `moduleId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moduleName` varchar(255) NOT NULL,
  `moduleFileName` varchar(255) NOT NULL,
  `moduleType` varchar(255) NOT NULL,
  `moduleStatus` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`moduleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`moduleId`, `moduleName`, `moduleFileName`, `moduleType`, `moduleStatus`) VALUES
(1, 'اطلاع رسانی با ایمیل', 'email', 'notify', 0),
(2, 'درگاه زرین پال', 'zarinpal', 'payment', 1),
(3, 'اطلاع رسانی نوین پیامک', 'novinpayamak', 'notify', 0);

-- --------------------------------------------------------

--
-- Table structure for table `option`
--

CREATE TABLE IF NOT EXISTS `option` (
  `optionId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `optionName` varchar(255) NOT NULL,
  `optionValue` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`optionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `option`
--

INSERT INTO `option` (`optionId`, `optionName`, `optionValue`) VALUES
(1, 'title', 'فرم ساز پرداخت'),
(2, 'theme', 'default2'),
(3, 'defaultForm', '1'),
(4, 'perPage', '10'),
(5, 'smtpHost', 'smtp.mail.yahoo.com'),
(6, 'smtpPort', '465'),
(7, 'smtpSecure', 'ssl'),
(8, 'smtpUserName', 'admin@smtp.com'),
(9, 'smtpPassword', 'smtp pass'),
(10, 'adminMail', 'admin mail'),
(11, 'adminMobile', 'admin mobile');

-- --------------------------------------------------------

--
-- Table structure for table `save`
--

CREATE TABLE IF NOT EXISTS `save` (
  `saveId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saveFormId` int(10) unsigned NOT NULL,
  `saveName` varchar(255) NOT NULL,
  `saveEmail` varchar(255) NOT NULL,
  `saveMobile` varchar(255) DEFAULT NULL,
  `saveContent` varchar(255) DEFAULT NULL,
  `saveIp` varchar(15) NOT NULL,
  `saveDate` int(10) unsigned NOT NULL,
  PRIMARY KEY (`saveId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `trans`
--

CREATE TABLE IF NOT EXISTS `trans` (
  `transId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transFormId` int(10) unsigned NOT NULL,
  `transSaveId` int(10) unsigned NOT NULL,
  `transPrice` varchar(255) NOT NULL,
  `transModuleId` int(10) unsigned NOT NULL,
  `transAu` varchar(255) NOT NULL,
  `transGatewayAu` varchar(255) DEFAULT NULL,
  `transIp` varchar(15) NOT NULL,
  `transDate` int(10) unsigned NOT NULL,
  `transStatus` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`transId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `userName`, `userEmail`, `userPassword`) VALUES
(1, 'admin', 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

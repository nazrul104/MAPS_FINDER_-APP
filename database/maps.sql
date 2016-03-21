-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 28, 2014 at 01:56 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE IF NOT EXISTS `access` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_group_id` int(11) NOT NULL,
  `access_module_id` int(11) NOT NULL,
  `access_view` int(11) DEFAULT '0',
  `access_insert` int(11) DEFAULT '0',
  `access_update` int(11) DEFAULT '0',
  `access_delete` int(11) DEFAULT '0',
  PRIMARY KEY (`access_id`),
  KEY `access_group_id_idx` (`access_group_id`),
  KEY `access_module_id` (`access_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`access_id`, `access_group_id`, `access_module_id`, `access_view`, `access_insert`, `access_update`, `access_delete`) VALUES
(1, 1, 21, 1, 0, 0, 0),
(2, 1, 22, 1, 1, 1, 1),
(3, 1, 23, 1, 1, 1, 1),
(4, 1, 24, 1, 1, 0, 0),
(5, 1, 25, 1, 1, 1, 1),
(6, 2, 21, 1, 0, 0, 0),
(7, 1, 26, 1, 1, 1, 1),
(8, 2, 0, 1, 0, 0, 0),
(9, 2, 25, 1, 1, 0, 0),
(10, 2, 24, 0, 0, 0, 0),
(11, 1, 27, 1, 1, 1, 1),
(12, 2, 27, 0, 0, 0, 0),
(13, 2, 22, 1, 0, 0, 0),
(14, 2, 23, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(45) NOT NULL,
  `category_icon` varchar(20) NOT NULL,
  `category_marker` varchar(80) NOT NULL,
  `category_desc` text NOT NULL,
  `category_lan` char(4) NOT NULL,
  `category_dash` int(11) NOT NULL DEFAULT '0',
  `category_aktif` varchar(3) NOT NULL DEFAULT 'No',
  `category_created` varchar(45) NOT NULL,
  `category_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_icon`, `category_marker`, `category_desc`, `category_lan`, `category_dash`, `category_aktif`, `category_created`, `category_created_date`) VALUES
(1, 'Restaurants', '&#x69;', 'pin1.png', 'Category Restaurants', 'en', 1, 'Yes', 'admin', '2014-08-01 00:00:00'),
(2, 'Bars', '&#xf236;', 'pin1.png', 'Category Bars', 'en', 1, 'Yes', 'admin', '2014-08-01 00:00:00'),
(3, 'Coffee & Tea', '&#xf235;', 'pin1.png', 'Category Coffee & Tea', 'en', 1, 'Yes', 'admin', '2014-08-01 00:00:00'),
(4, 'Gas & Service Stations', '&#xf216;', 'pin1.png', 'Category Gas & Service Stations', 'en', 1, 'Yes', 'admin', '2014-08-01 00:00:00'),
(5, 'Drugstores', '&#xf27e;', 'pin1.png', 'Category Drugstores', 'en', 1, 'Yes', 'admin', '2014-08-01 00:00:00'),
(6, 'Store', '&#x2d;', 'pin1.png', 'Category Store', 'en', 1, 'Yes', 'admin', '2014-08-01 00:00:00'),
(7, 'ATM & Bank', '&#xf271;', 'pin1.png', 'Category ATM & Bank', 'en', 1, 'Yes', 'admin', '2014-08-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_markers_id` int(11) NOT NULL,
  `comment_name` varchar(45) NOT NULL,
  `comment_value` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment_active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment_markers_id`, `comment_name`, `comment_value`, `comment_date`, `comment_active`) VALUES
(1, 6, 'rizal saleh', 'test', '2014-04-16 08:05:14', 1),
(2, 6, 'ahmad', 'Sukses', '2014-08-27 13:42:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(45) DEFAULT NULL,
  `group_description` varchar(130) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `group_description`) VALUES
(1, 'admin', 'Administrator Access'),
(2, 'user', 'User Access');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `images_id` int(11) NOT NULL AUTO_INCREMENT,
  `images_markers_id` int(11) NOT NULL,
  `images_name` varchar(120) NOT NULL,
  `images_url` varchar(120) NOT NULL,
  `images_desc` text NOT NULL,
  `images_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`images_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`images_id`, `images_markers_id`, `images_name`, `images_url`, `images_desc`, `images_update`) VALUES
(7, 6, 'Favorite Dishes', '1376096783.png', 'A lot of the dishes', '2013-08-10 01:07:15'),
(8, 6, 'Roasting Pizza', '1376097112.png', 'Process of making a pizza', '2013-08-10 01:11:28'),
(9, 7, 'Momofuku Noodle Bar', '1376098044.png', 'Momofuku Noodle Bar', '2013-08-10 01:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_code` char(5) NOT NULL,
  `language_name` varchar(45) NOT NULL,
  `language_desc` text NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`language_id`, `language_code`, `language_name`, `language_desc`) VALUES
(1, 'de', 'German', 'German Language'),
(2, 'en', 'English', 'English Language');

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE IF NOT EXISTS `markers` (
  `markers_id` int(11) NOT NULL AUTO_INCREMENT,
  `markers_category_id` int(11) NOT NULL,
  `markers_name` varchar(45) NOT NULL,
  `markers_logo` varchar(80) NOT NULL,
  `markers_phone` varchar(40) NOT NULL,
  `markers_address` text NOT NULL,
  `markers_lat` double NOT NULL,
  `markers_lng` double NOT NULL,
  `markers_url` varchar(110) NOT NULL,
  `markers_catalogue` varchar(45) NOT NULL,
  `markers_desc` text NOT NULL,
  `markers_lan` char(5) NOT NULL,
  `markers_aktif` varchar(3) NOT NULL DEFAULT 'No',
  `markers_created` varchar(45) NOT NULL,
  `markers_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`markers_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `markers`
--

INSERT INTO `markers` (`markers_id`, `markers_category_id`, `markers_name`, `markers_logo`, `markers_phone`, `markers_address`, `markers_lat`, `markers_lng`, `markers_url`, `markers_catalogue`, `markers_desc`, `markers_lan`, `markers_aktif`, `markers_created`, `markers_created_date`) VALUES
(6, 1, 'MOTORINO PIZZA', '1376096388ino_pizza.png', '212/777-2644', '349 E. 12th St., at 1st Ave.East Village, New York, NY10003', 40.7302678, -73.9839388, 'www.motorinopizza.com', '', 'The Manhattan branch of the now-closed Williamsburg original has brought its impossibly high standards—and long lines—to a new borough.', 'en', 'Yes', 'admin', '2014-08-01 00:00:00'),
(7, 2, 'MOMOFUKU NOODLE BAR', '1376097444UKU.png', '212/777-7773', '1st Ave., between E. 10th and E. 11 Sts.East Village, New York, NY 10003-2949', 40.7292899122743, -73.9846172883606, 'www.momofuku.com', '', 'Chef-owner David Chang has created a shrine to ramen with this stylish 70-seat restaurant.', 'en', 'No', 'admin', '2014-08-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(45) DEFAULT NULL,
  `module_link` varchar(125) DEFAULT NULL,
  `module_order` int(11) NOT NULL,
  `module_icon` varchar(45) NOT NULL,
  `module_description` text,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `module_link`, `module_order`, `module_icon`, `module_description`) VALUES
(21, 'Dashboard', 'home', 1, 'icon-home-2', 'Dashboard Module'),
(22, 'Category', 'category', 2, 'icon-list', 'List Category Module'),
(23, 'Location List', 'location_list', 3, 'icon-checkin', 'Location List Module'),
(24, 'Comment List', 'comment_list', 4, 'icon-checkbox', 'Comment List Module'),
(25, 'Group Access', 'group', 5, 'icon-uniF00F', 'Group Access Module'),
(26, 'User', 'user', 6, 'icon-user', 'User Module'),
(27, 'Language', 'language', 7, 'icon-flag', 'Language Module');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `rating_markers_id` int(11) NOT NULL,
  `rating_value` float NOT NULL,
  PRIMARY KEY (`rating_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `rating_markers_id`, `rating_value`) VALUES
(3, 7, 1),
(2, 6, 5),
(4, 6, 5),
(5, 6, 5),
(6, 7, 3),
(7, 6, 5),
(8, 7, 4),
(9, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE IF NOT EXISTS `times` (
  `times_id` int(11) NOT NULL AUTO_INCREMENT,
  `times_day` int(11) NOT NULL,
  `times_open` time NOT NULL,
  `times_close` time NOT NULL,
  `times_markers_id` int(11) NOT NULL,
  PRIMARY KEY (`times_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `times`
--

INSERT INTO `times` (`times_id`, `times_day`, `times_open`, `times_close`, `times_markers_id`) VALUES
(1, 7, '08:20:00', '21:00:00', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) NOT NULL,
  `user_password` varchar(125) NOT NULL,
  `user_group` int(11) NOT NULL,
  `user_full_name` varchar(65) NOT NULL,
  `user_email` varchar(45) NOT NULL,
  `user_phone` varchar(16) NOT NULL,
  `user_address` text NOT NULL,
  `user_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_aktif` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_group`, `user_full_name`, `user_email`, `user_phone`, `user_address`, `user_update`, `user_aktif`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'administrator', 'admin@info.com', '+628923274274277', 'Makassar, Indonesia', '2014-04-17 15:45:51', 1),
(2, 'user', '21232f297a57a5a743894a0e4a801fc3', 2, 'user', 'user@info.com', '', '', '2014-08-22 05:47:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `view_rating`
--

CREATE VIEW  `view_rating` AS SELECT  `rating`.`rating_markers_id` AS  `rating_markers_id` , ROUND( AVG(  `rating`.`rating_value` ) , 0 ) AS  `total` , COUNT(  `rating`.`rating_markers_id` ) AS  `rating_user` 
FROM  `rating` 
GROUP BY  `rating`.`rating_markers_id` ;

--
-- Dumping data for table `view_rating`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

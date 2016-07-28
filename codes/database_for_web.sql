
-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 68.178.217.43
-- Generation Time: Jul 21, 2015 at 02:54 AM
-- Server version: 5.5.43
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `datingappdemo`
--
CREATE DATABASE `We meet` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `datingappdemo`;

-- --------------------------------------------------------

--
-- Table structure for table `t_add_friend`
--

CREATE TABLE `t_add_friend` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `entity_id` int(100) NOT NULL,
  `friend_fb_id` int(100) NOT NULL,
  `friend_name` varchar(100) NOT NULL,
  `friend_picture` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_add_friend`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_add_likes`
--

CREATE TABLE `t_add_likes` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `entity_id` int(50) NOT NULL,
  `like_id` varchar(100) NOT NULL,
  `like_name` varbinary(50) NOT NULL,
  `like_picture` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_add_likes`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_admin`
--

CREATE TABLE `t_admin` (
  `aid` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Admin id',
  `admin_username` varchar(30) NOT NULL COMMENT 'admin username',
  `admin_password` varchar(30) NOT NULL COMMENT 'admin password',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t_admin`
--

INSERT INTO `t_admin` VALUES(1, 'epb_admin', 'epbYouMe123!');
INSERT INTO `t_admin` VALUES(2, 'epb_admin', 'epbYouMe123!');


-- --------------------------------------------------------

--
-- Table structure for table `t_authtypes`
--

CREATE TABLE `t_authtypes` (
  `authType_id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT 'Authentication type',
  `authName` varchar(150) NOT NULL COMMENT 'Authentication name',
  PRIMARY KEY (`authType_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Types of authentications for the appl' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `t_authtypes`
--

INSERT INTO `t_authtypes` VALUES(1, 'Facebook');
INSERT INTO `t_authtypes` VALUES(2, 'Google+');

-- --------------------------------------------------------

--
-- Table structure for table `t_chatmessages`
--

CREATE TABLE `t_chatmessages` (
  `mid` int(30) NOT NULL AUTO_INCREMENT COMMENT 'Message id',
  `sender` int(25) NOT NULL COMMENT 'sender entity id',
  `receiver` int(25) NOT NULL COMMENT 'reciever entity id',
  `message` varchar(2000) NOT NULL COMMENT 'actual chat message ',
  `msg_dt` datetime NOT NULL COMMENT 'Date and time of message',
  `user1` varchar(100) NOT NULL,
  `user2` varchar(100) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains chat messages' AUTO_INCREMENT=12 ;

--
-- Dumping data for table `t_chatmessages`
--

INSERT INTO `t_chatmessages` VALUES(1, 1, 3, 'hi', '2015-05-26 13:32:43', '', '');
INSERT INTO `t_chatmessages` VALUES(2, 1, 4, 'hiu', '2015-07-06 19:31:50', '', '');
INSERT INTO `t_chatmessages` VALUES(3, 4, 1, 'hii', '2015-07-06 19:35:07', '', '');
INSERT INTO `t_chatmessages` VALUES(4, 1, 2, 'hi', '2015-07-08 18:51:47', '', '');
INSERT INTO `t_chatmessages` VALUES(5, 2, 1, 'hi', '2015-07-08 18:52:41', '', '');
INSERT INTO `t_chatmessages` VALUES(6, 1, 2, 'this is testing', '2015-07-08 19:02:21', '', '');
INSERT INTO `t_chatmessages` VALUES(7, 2, 1, 'ok', '2015-07-08 19:21:43', '', '');
INSERT INTO `t_chatmessages` VALUES(8, 2, 1, 'we can improve a few things', '2015-07-08 19:22:09', '', '');
INSERT INTO `t_chatmessages` VALUES(9, 2, 1, 'is everything else working good', '2015-07-08 19:22:17', '', '');
INSERT INTO `t_chatmessages` VALUES(10, 2, 1, 'is it finding the profiles??', '2015-07-08 19:22:55', '', '');
INSERT INTO `t_chatmessages` VALUES(11, 2, 1, 'last time it was not finding new profiles', '2015-07-08 19:23:10', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `t_city`
--

CREATE TABLE `t_city` (
  `City_Id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'City Id',
  `State_Id` int(7) DEFAULT NULL COMMENT 'State Id',
  `Country_Id` int(6) NOT NULL COMMENT 'Country Id',
  `City_Name` varchar(100) NOT NULL COMMENT 'City Name',
  PRIMARY KEY (`City_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Cities in all states around all the countries' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_city`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_country`
--

CREATE TABLE `t_country` (
  `Country_Id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'Country Id',
  `Country_Name` varchar(100) NOT NULL COMMENT 'Country name',
  PRIMARY KEY (`Country_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Country table' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_country`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_detail_user_ans`
--

CREATE TABLE `t_detail_user_ans` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `Entity_Id` int(100) NOT NULL,
  `d_id` int(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `user_ans` varchar(255) NOT NULL,
  `them` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `t_detail_user_ans`
--

INSERT INTO `t_detail_user_ans` VALUES(1, 1, 26, '', '52', '');
INSERT INTO `t_detail_user_ans` VALUES(2, 2, 26, '', '52', '');
INSERT INTO `t_detail_user_ans` VALUES(3, 3, 26, '', '52', '');
INSERT INTO `t_detail_user_ans` VALUES(4, 5, 1, '', '4', '');
INSERT INTO `t_detail_user_ans` VALUES(5, 5, 26, '', '52', '');
INSERT INTO `t_detail_user_ans` VALUES(6, 1, 1, '', '4', '');
INSERT INTO `t_detail_user_ans` VALUES(7, 1, 2, '', '8', '');
INSERT INTO `t_detail_user_ans` VALUES(8, 1, 3, '', '12', '');
INSERT INTO `t_detail_user_ans` VALUES(9, 1, 5, '', '18', '');
INSERT INTO `t_detail_user_ans` VALUES(10, 1, 6, '', '20', '');
INSERT INTO `t_detail_user_ans` VALUES(11, 1, 7, '', '23', '');
INSERT INTO `t_detail_user_ans` VALUES(12, 1, 9, '', '25', '');
INSERT INTO `t_detail_user_ans` VALUES(13, 1, 11, '', '27', '');
INSERT INTO `t_detail_user_ans` VALUES(14, 1, 18, '', '32', '');
INSERT INTO `t_detail_user_ans` VALUES(15, 1, 19, '', '34', '');
INSERT INTO `t_detail_user_ans` VALUES(16, 1, 20, '', '38', '');
INSERT INTO `t_detail_user_ans` VALUES(17, 1, 21, '', '42', '');
INSERT INTO `t_detail_user_ans` VALUES(18, 1, 22, '', '44', '');
INSERT INTO `t_detail_user_ans` VALUES(19, 1, 23, '', '46', '');
INSERT INTO `t_detail_user_ans` VALUES(20, 1, 24, '', '48', '');
INSERT INTO `t_detail_user_ans` VALUES(21, 1, 25, '', '50', '');

-- --------------------------------------------------------

--
-- Table structure for table `t_details`
--

CREATE TABLE `t_details` (
  `d_id` int(100) NOT NULL AUTO_INCREMENT,
  `details_ques` varchar(200) NOT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='t_details' AUTO_INCREMENT=27 ;

--
-- Dumping data for table `t_details`
--

INSERT INTO `t_details` VALUES(1, 'How would you describe yourself?');
INSERT INTO `t_details` VALUES(2, 'Rate your self-confidence trust');
INSERT INTO `t_details` VALUES(3, 'What is your favourite movie type?');
INSERT INTO `t_details` VALUES(5, 'Which makes for a better relationship?');
INSERT INTO `t_details` VALUES(6, 'Do you enjoy intense intellectual conversations?');
INSERT INTO `t_details` VALUES(7, 'Do you enjoy discussing politics?');
INSERT INTO `t_details` VALUES(9, 'Are you shy?');
INSERT INTO `t_details` VALUES(11, 'Would you prefer good things happening, or interesting things happening around you?');
INSERT INTO `t_details` VALUES(18, 'Do you like horror movies?');
INSERT INTO `t_details` VALUES(19, 'Is religion important in your life?');
INSERT INTO `t_details` VALUES(20, 'How often do you drink alcohol?');
INSERT INTO `t_details` VALUES(21, 'Have you ever been in love?');
INSERT INTO `t_details` VALUES(22, 'Are you a Vegetarian?');
INSERT INTO `t_details` VALUES(23, 'Is an astrological sign important in compatibility with someone?');
INSERT INTO `t_details` VALUES(24, 'Are you happy with your life?');
INSERT INTO `t_details` VALUES(25, 'Would you prefer to be good-looking or rich?');
INSERT INTO `t_details` VALUES(26, 'Do you think smoking is disgusting?');

-- --------------------------------------------------------

--
-- Table structure for table `t_details_ans`
--

CREATE TABLE `t_details_ans` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `d_id` int(100) NOT NULL,
  `detail_option` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `t_details_ans`
--

INSERT INTO `t_details_ans` VALUES(4, 1, 'Carefree');
INSERT INTO `t_details_ans` VALUES(5, 1, 'Intense');
INSERT INTO `t_details_ans` VALUES(8, 2, 'Very Very High');
INSERT INTO `t_details_ans` VALUES(9, 2, 'Higher than Average');
INSERT INTO `t_details_ans` VALUES(10, 2, 'Average');
INSERT INTO `t_details_ans` VALUES(11, 2, 'Below Average');
INSERT INTO `t_details_ans` VALUES(12, 3, 'Comedy');
INSERT INTO `t_details_ans` VALUES(13, 3, 'Horror');
INSERT INTO `t_details_ans` VALUES(14, 4, 'Extremely important');
INSERT INTO `t_details_ans` VALUES(15, 4, 'Somewhat important');
INSERT INTO `t_details_ans` VALUES(16, 4, 'Not Very Important');
INSERT INTO `t_details_ans` VALUES(17, 4, 'Not At all Important');
INSERT INTO `t_details_ans` VALUES(18, 5, 'Passion');
INSERT INTO `t_details_ans` VALUES(19, 5, 'Dediction');
INSERT INTO `t_details_ans` VALUES(20, 6, 'Rather not say');
INSERT INTO `t_details_ans` VALUES(21, 6, 'Yes');
INSERT INTO `t_details_ans` VALUES(22, 6, 'No');
INSERT INTO `t_details_ans` VALUES(23, 7, 'Yes');
INSERT INTO `t_details_ans` VALUES(24, 7, 'No');
INSERT INTO `t_details_ans` VALUES(25, 9, 'Yes');
INSERT INTO `t_details_ans` VALUES(26, 9, 'No');
INSERT INTO `t_details_ans` VALUES(27, 11, 'Good');
INSERT INTO `t_details_ans` VALUES(28, 11, 'Intresting');
INSERT INTO `t_details_ans` VALUES(29, 11, 'None of the above');
INSERT INTO `t_details_ans` VALUES(30, 12, 'No,it wouldn''t');
INSERT INTO `t_details_ans` VALUES(31, 12, 'Yes, It would');
INSERT INTO `t_details_ans` VALUES(32, 18, 'Yes');
INSERT INTO `t_details_ans` VALUES(33, 18, 'No');
INSERT INTO `t_details_ans` VALUES(34, 19, 'Yes');
INSERT INTO `t_details_ans` VALUES(35, 19, 'No');
INSERT INTO `t_details_ans` VALUES(36, 19, 'A little');
INSERT INTO `t_details_ans` VALUES(38, 20, 'All the time');
INSERT INTO `t_details_ans` VALUES(39, 20, 'Sometimes');
INSERT INTO `t_details_ans` VALUES(40, 20, 'Socially');
INSERT INTO `t_details_ans` VALUES(41, 20, 'Never');
INSERT INTO `t_details_ans` VALUES(42, 21, 'Yes');
INSERT INTO `t_details_ans` VALUES(43, 21, 'No');
INSERT INTO `t_details_ans` VALUES(44, 22, 'Yes');
INSERT INTO `t_details_ans` VALUES(45, 22, 'No');
INSERT INTO `t_details_ans` VALUES(46, 23, 'Yes');
INSERT INTO `t_details_ans` VALUES(47, 23, 'No');
INSERT INTO `t_details_ans` VALUES(48, 24, 'Yes');
INSERT INTO `t_details_ans` VALUES(49, 24, 'No');
INSERT INTO `t_details_ans` VALUES(50, 25, 'Good-looking');
INSERT INTO `t_details_ans` VALUES(51, 25, 'Rich');
INSERT INTO `t_details_ans` VALUES(52, 26, 'Yes');
INSERT INTO `t_details_ans` VALUES(53, 26, 'No');
INSERT INTO `t_details_ans` VALUES(54, 27, 'Yes');
INSERT INTO `t_details_ans` VALUES(55, 27, 'No');
INSERT INTO `t_details_ans` VALUES(56, 3, 'Romance');
INSERT INTO `t_details_ans` VALUES(57, 3, 'Action');
INSERT INTO `t_details_ans` VALUES(58, 9, 'A little bit');

-- --------------------------------------------------------

--
-- Table structure for table `t_dev_type`
--

CREATE TABLE `t_dev_type` (
  `dev_id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Device type id',
  `name` varchar(100) NOT NULL COMMENT 'Name of the device',
  PRIMARY KEY (`dev_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores device types which the appl can allow' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `t_dev_type`
--

INSERT INTO `t_dev_type` VALUES(1, 'Apple');
INSERT INTO `t_dev_type` VALUES(2, 'Android');

-- --------------------------------------------------------

--
-- Table structure for table `t_education`
--

CREATE TABLE `t_education` (
  `Education_Id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'User Education Id',
  `Entity_Id` int(25) NOT NULL COMMENT 'Entity_Id',
  `Education_City` varchar(50) DEFAULT NULL COMMENT 'Education city',
  `Education_Country` varchar(50) DEFAULT NULL COMMENT 'Education Country',
  `Education_Institute` varchar(250) DEFAULT NULL COMMENT 'Education Institute',
  `Education_Degree` varchar(100) NOT NULL COMMENT 'Education Degree',
  `Education_Start_Date` date NOT NULL COMMENT 'Education start date',
  `Education_End_Date` date NOT NULL COMMENT 'Education end date',
  PRIMARY KEY (`Education_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_education`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_entity`
--

CREATE TABLE `t_entity` (
  `Entity_Id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'Entity Identifier',
  `Status` tinyint(2) NOT NULL DEFAULT '1',
  `Unique_Identifier` varchar(100) NOT NULL COMMENT 'Unique identifier for the entity',
  `Password` varchar(25) DEFAULT NULL COMMENT 'User password. Not encrypted for this phase.',
  `Create_Dt` datetime DEFAULT NULL COMMENT 'Date/time of creation.',
  `Last_Active_Dt_Time` datetime DEFAULT NULL COMMENT 'Date/time of last activity',
  `Device_Type` tinyint(2) NOT NULL COMMENT 'Device Type',
  `Device_Id` varchar(250) NOT NULL COMMENT 'Device Id',
  `authType` tinyint(2) NOT NULL COMMENT 'Authentication type fk from authtypes',
  PRIMARY KEY (`Entity_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Entity identifier' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `t_entity`
--

INSERT INTO `t_entity` VALUES(1, 1, '527472867391278', '', '2015-05-26 06:33:15', '2015-07-08 12:53:26', 2, '', 1);
INSERT INTO `t_entity` VALUES(2, 1, '10153164253623879', '', '2015-05-26 06:43:20', '2015-05-26 07:09:22', 2, '', 1);
INSERT INTO `t_entity` VALUES(3, 1, '10205554814763871', '', '2015-05-26 07:03:41', '2015-05-26 07:03:41', 2, '', 1);
INSERT INTO `t_entity` VALUES(4, 1, '864525410259722', '', '2015-05-26 07:21:22', '2015-05-26 07:21:22', 2, '', 1);
INSERT INTO `t_entity` VALUES(5, 1, '454600394706518', '', '2015-05-26 07:54:02', '2015-05-26 07:54:02', 2, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_entity_details`
--

CREATE TABLE `t_entity_details` (
  `Entity_Id` int(25) NOT NULL COMMENT 'App User Id',
  `Fb_Id` varchar(150) DEFAULT NULL COMMENT 'User Facebook Id',
  `Google_Id` varchar(150) DEFAULT NULL COMMENT 'User Google Id',
  `First_Name` varchar(100) NOT NULL COMMENT 'User Firstname',
  `Last_Name` varchar(100) DEFAULT NULL COMMENT 'User Lastname',
  `Email` varchar(250) NOT NULL COMMENT 'User email address',
  `Country` varchar(70) DEFAULT NULL COMMENT 'Country from which the user is logging in',
  `City` varchar(70) DEFAULT NULL COMMENT 'City from which the user is logging in',
  `Current_Lat` varchar(30) DEFAULT NULL COMMENT 'Latitude for current logged in location',
  `Current_Long` varchar(30) DEFAULT NULL COMMENT 'Longitude for current logged in location',
  `Profile_Pic_Url` varchar(300) DEFAULT 'http://epbitservices.com/androidapps/datingapp/pics/default.png' COMMENT 'URL of the profile picture',
  `TagLine` varchar(400) DEFAULT NULL COMMENT 'Tag line for the user profile',
  `Sex` tinyint(1) NOT NULL COMMENT '1 - male, 2 - female',
  `Device_Type` int(50) NOT NULL,
  `pushtoken` varchar(700) NOT NULL COMMENT 'Quickblocks_Id',
  `Personal_Desc` varchar(600) DEFAULT NULL COMMENT 'Personal Description of the user',
  `DOB` date DEFAULT NULL COMMENT 'User Date of Birth',
  `Skill_Rating` tinyint(1) DEFAULT NULL COMMENT 'User skill rating',
  `Status` varchar(500) NOT NULL,
  PRIMARY KEY (`Entity_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='User details table';

--
-- Dumping data for table `t_entity_details`
--

INSERT INTO `t_entity_details` VALUES(1, '527472867391278', NULL, 'Rahul', 'Chaudhary', '', NULL, NULL, '28.675445', '77.30098500000001', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/v/t1.0-1/p200x200/223873_151234575015111_2132728420_n.jpg?oh=97aa24e114720540c26898b848b5b3f3&oe=560751E2&__gda__=1443708655_ed4acf79e1d58367da837534d7e801d0', NULL, 1, 2, 'APA91bE0qwVuuuuULb6gimyDhDdFOJ1_4oKDyU_mSm-t7lzi-mzmO3LR9S7iRvXsdtxlDHs5azGgA978npdZUNkvjScwEH2a--xGYXmYiTXKhDEkh3-y9Ib-7xwreHMMqJUNBIQvj3wS', NULL, '1994-07-08', NULL, '');
INSERT INTO `t_entity_details` VALUES(2, '10153164253623879', NULL, 'Krishan', 'Birmiwala', '', NULL, NULL, '28.67706053', '77.31824992', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/v/t1.0-1/p320x320/10898119_10152987068628879_2634722189869550462_n.jpg?oh=766cf91de2f7dc0533108dae07f6835d&oe=5607BBF7&__gda__=1438743916_7237d72f8836502b2ffdc51774dbb6fb', NULL, 2, 2, 'APA91bFgzjF_Q6AlkuJIBYvXrMEZywJ8dT9vl7m2TnTuv8jcilCUz1wkxdf8232G-sWPzAHqqtHfKoLVc-DBZxccgB4QGcHzYKj056ccIOy42AGyMZGi1yB17LVH1MWjP2EYprz_seyx3IaZGJS78QuoAcgXbSCc-g', NULL, '1990-05-26', NULL, '');
INSERT INTO `t_entity_details` VALUES(3, '10205554814763871', NULL, 'Gaurav', 'Gupta', '', NULL, NULL, '28.6770821', '77.3180237', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xtp1/v/t1.0-1/10398321_1189482931376_5786457_n.jpg?oh=3722a37700d69f058cd5b36d35b46a67&oe=55BFF922&__gda__=1443255102_fa0687732cb3f11b95edb887702a7400', NULL, 1, 2, 'APA91bHv603Sm2k3cJQFbTqVT56YF9ERs-mWcQwmY6nsAQqRdQ1jTW2U_8fQuvhE66-p2CP-42HZo9UcgO86AsmA_DPpUOStkKa0oJsbz7AV8JroRQq-2YPRNOqw7ohM90uSSMcS5mF00QdB5rJNSaNnVcrghFkSZA', NULL, '1990-05-26', NULL, '');
INSERT INTO `t_entity_details` VALUES(4, '864525410259722', NULL, 'Anuj', 'Garg', '', NULL, NULL, '28.6770898', '77.3180359', 'http://www.epbitservices.com/androidapps/datingapp/pics/profile_photo1.43331898E+12.jpg', NULL, 1, 2, 'APA91bF9LRylYTko4AQOVAACFQVzPwzD8lvu_29F8lRrqs1RtEJ9E42UkxAS-b-6R02WwUoyfpj5Z9I0DDRvydnUbhVzRDZxpa100HBoJUDrg_hfH-mbnWRNk6WhD08WhFeCrEsDTlOzY1Ect6cm36ZDhlVBUwWP0Q', NULL, '1989-05-26', NULL, '');
INSERT INTO `t_entity_details` VALUES(5, '454600394706518', NULL, 'Jitesh', 'Gautam', '', NULL, NULL, '0.0', '0.0', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfp1/v/t1.0-1/p200x200/10169461_295271237306102_6292773877554880919_n.jpg?oh=f24e4e4b0f970b9b5f510f2f992f8cbf&oe=56049710&__gda__=1443701371_24661a283cb5d7a7ab35ebd1afc915be', NULL, 2, 2, 'APA91bFYJoLmCDArXGtuJzwWbbRC75rVZybgsdn8xIvkrd3yjagW48xVC-vBx4D-j-OCcIkxX6zJ4mzccGZXplX2uPq0NUDK2dH3EtV2r5odXwZzAnuUkh69mppcKLtzGWbN7ucL4HIRTZqKBNtBkhnaPCKFTK6HUg', NULL, '1987-05-26', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `t_images`
--

CREATE TABLE `t_images` (
  `image_id` int(30) NOT NULL AUTO_INCREMENT COMMENT 'Image id',
  `entity_id` int(25) NOT NULL COMMENT 'Entity Id',
  `image_url` varchar(600) NOT NULL COMMENT 'Image url',
  `index_id` int(50) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contains user profile images' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `t_images`
--

INSERT INTO `t_images` VALUES(1, 1, 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/v/t1.0-1/p200x200/223873_151234575015111_2132728420_n.jpg?oh=97aa24e114720540c26898b848b5b3f3&oe=560751E2&__gda__=1443708655_ed4acf79e1d58367da837534d7e801d0', 0);
INSERT INTO `t_images` VALUES(2, 2, 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xaf1/v/t1.0-1/p320x320/10898119_10152987068628879_2634722189869550462_n.jpg?oh=766cf91de2f7dc0533108dae07f6835d&oe=5607BBF7&__gda__=1438743916_7237d72f8836502b2ffdc51774dbb6fb', 0);
INSERT INTO `t_images` VALUES(3, 3, 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xtp1/v/t1.0-1/10398321_1189482931376_5786457_n.jpg?oh=3722a37700d69f058cd5b36d35b46a67&oe=55BFF922&__gda__=1443255102_fa0687732cb3f11b95edb887702a7400', 0);
INSERT INTO `t_images` VALUES(5, 5, 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfp1/v/t1.0-1/p200x200/10169461_295271237306102_6292773877554880919_n.jpg?oh=f24e4e4b0f970b9b5f510f2f992f8cbf&oe=56049710&__gda__=1443701371_24661a283cb5d7a7ab35ebd1afc915be', 0);
INSERT INTO `t_images` VALUES(6, 4, 'http://www.epbitservices.com/androidapps/datingapp/pics/profile_photo1.43331898E+12.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_likes`
--

CREATE TABLE `t_likes` (
  `Like_Id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'Like Id for the user',
  `Entity1_Id` int(25) NOT NULL COMMENT 'User id who liked the other user',
  `Entity2_Id` int(25) NOT NULL COMMENT 'User id who is getting liked',
  `Like_Flag` tinyint(1) NOT NULL COMMENT '1 -> Liked, 2-> DisLiked, 3-> Liked by both, 4->blocked',
  `Like_DateTime` datetime NOT NULL COMMENT 'Date and time of the like',
  `Update_Dt` datetime NOT NULL COMMENT 'updated date time',
  `Dislike_Count` int(5) NOT NULL COMMENT 'Count of dislikes',
  PRIMARY KEY (`Like_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='List of mutual  likes' AUTO_INCREMENT=14 ;

--
-- Dumping data for table `t_likes`
--

INSERT INTO `t_likes` VALUES(1, 1, 2, 3, '2015-05-26 06:49:09', '2015-05-26 06:50:13', 0);
INSERT INTO `t_likes` VALUES(2, 2, 1, 3, '2015-05-26 06:50:13', '2015-05-26 06:50:13', 0);
INSERT INTO `t_likes` VALUES(3, 3, 2, 2, '2015-05-26 07:04:47', '2015-05-26 07:04:47', 0);
INSERT INTO `t_likes` VALUES(4, 3, 1, 3, '2015-05-26 07:04:50', '2015-05-26 08:02:22', 0);
INSERT INTO `t_likes` VALUES(5, 2, 3, 1, '2015-05-26 07:08:47', '2015-05-26 07:08:47', 0);
INSERT INTO `t_likes` VALUES(6, 4, 3, 1, '2015-05-26 07:23:01', '2015-05-26 07:23:01', 0);
INSERT INTO `t_likes` VALUES(7, 4, 2, 3, '2015-05-26 07:23:11', '2015-05-26 07:29:19', 0);
INSERT INTO `t_likes` VALUES(8, 4, 1, 3, '2015-05-26 07:23:17', '2015-05-26 07:30:31', 0);
INSERT INTO `t_likes` VALUES(9, 2, 4, 3, '2015-05-26 07:29:19', '2015-05-26 07:29:19', 0);
INSERT INTO `t_likes` VALUES(10, 1, 4, 3, '2015-05-26 07:30:31', '2015-05-26 07:30:31', 0);
INSERT INTO `t_likes` VALUES(11, 1, 3, 3, '2015-05-26 08:02:22', '2015-05-26 08:02:22', 0);
INSERT INTO `t_likes` VALUES(12, 1, 5, 1, '2015-05-26 08:06:44', '2015-05-26 08:06:44', 0);
INSERT INTO `t_likes` VALUES(13, 3, 4, 2, '2015-05-26 10:55:29', '2015-05-26 10:55:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_matches`
--

CREATE TABLE `t_matches` (
  `Match_Id` int(25) NOT NULL AUTO_INCREMENT COMMENT 'March Id',
  `Matched_entity1_Id` int(25) NOT NULL COMMENT 'First User who is participating in the match',
  `Matched_entity2_Id` int(25) NOT NULL COMMENT 'Second User who is participating in the match',
  `Mathc_requestor_Id` int(25) NOT NULL COMMENT 'User who is Match maker ',
  `Match_Type` tinyint(1) NOT NULL COMMENT '0 ->  normal match, 1 -> booty call match, 2 -> blind date match, 4 -> matchmaking',
  `Match_Date_Time` datetime NOT NULL COMMENT 'March date and time',
  `Status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'default = 0 = unblocked , 1 = unblocked and invite sent , 2 = invite declined 3 = invite accepted 4 = blocked',
  `Blind_Date_Location` varchar(400) DEFAULT NULL COMMENT 'This is the location for the blind date',
  PRIMARY KEY (`Match_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='List of Matches Per User' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_matches`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_notifications`
--

CREATE TABLE `t_notifications` (
  `notif_id` int(30) NOT NULL AUTO_INCREMENT COMMENT 'Notification id',
  `notif_type` tinyint(2) NOT NULL COMMENT '1 - like note, 2 - chat',
  `sender` int(11) NOT NULL COMMENT 'id of sender',
  `reciever` int(11) NOT NULL COMMENT 'id of reciever',
  `message` varchar(500) NOT NULL COMMENT 'notification message',
  `notif_dt` datetime NOT NULL COMMENT 'Notification date time',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - inactive',
  PRIMARY KEY (`notif_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `t_notifications`
--

INSERT INTO `t_notifications` VALUES(1, 3, 2, 1, 'Congratulations! You got a match in You&Me app!', '2015-05-26 06:50:13', 1);
INSERT INTO `t_notifications` VALUES(2, 3, 2, 4, 'Congratulations! You got a match in You&Me app!', '2015-05-26 07:29:19', 1);
INSERT INTO `t_notifications` VALUES(3, 3, 1, 4, 'Congratulations! You got a match in You&Me app!', '2015-05-26 07:30:31', 1);
INSERT INTO `t_notifications` VALUES(4, 3, 1, 3, 'Congratulations! You got a match in You&Me app!', '2015-05-26 08:02:22', 1);
INSERT INTO `t_notifications` VALUES(5, 2, 1, 3, 'hi', '2015-05-26 13:32:43', 1);
INSERT INTO `t_notifications` VALUES(6, 2, 1, 4, 'hiu', '2015-07-06 19:31:50', 1);
INSERT INTO `t_notifications` VALUES(7, 2, 4, 1, 'hii', '2015-07-06 19:35:07', 1);
INSERT INTO `t_notifications` VALUES(8, 2, 1, 2, 'hi', '2015-07-08 18:51:47', 1);
INSERT INTO `t_notifications` VALUES(9, 2, 2, 1, 'hi', '2015-07-08 18:52:41', 1);
INSERT INTO `t_notifications` VALUES(10, 2, 1, 2, 'this is testing', '2015-07-08 19:02:21', 1);
INSERT INTO `t_notifications` VALUES(11, 2, 2, 1, 'ok', '2015-07-08 19:21:43', 1);
INSERT INTO `t_notifications` VALUES(12, 2, 2, 1, 'we can improve a few things', '2015-07-08 19:22:09', 1);
INSERT INTO `t_notifications` VALUES(13, 2, 2, 1, 'is everything else working good', '2015-07-08 19:22:17', 1);
INSERT INTO `t_notifications` VALUES(14, 2, 2, 1, 'is it finding the profiles??', '2015-07-08 19:22:55', 1);
INSERT INTO `t_notifications` VALUES(15, 2, 2, 1, 'last time it was not finding new profiles', '2015-07-08 19:23:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_preferences`
--

CREATE TABLE `t_preferences` (
  `Entity_Id` int(25) NOT NULL COMMENT 'Entityid',
  `Preference_Sex` tinyint(1) NOT NULL COMMENT '1 - male, 2 - female',
  `Preference_lower_age` int(3) NOT NULL DEFAULT '0' COMMENT 'Prefered lower age',
  `Preference_upper_age` int(3) NOT NULL DEFAULT '0' COMMENT 'prefered upper age',
  `Preference_radius` double NOT NULL DEFAULT '10' COMMENT 'prefered radius',
  UNIQUE KEY `Entity_Id` (`Entity_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='List of PreferencesPer User';

--
-- Dumping data for table `t_preferences`
--

INSERT INTO `t_preferences` VALUES(1, 3, 18, 32, 80);
INSERT INTO `t_preferences` VALUES(2, 3, 18, 49, 100);
INSERT INTO `t_preferences` VALUES(3, 3, 22, 46, 9);
INSERT INTO `t_preferences` VALUES(4, 1, 18, 55, 100);
INSERT INTO `t_preferences` VALUES(5, 3, 18, 50, 79);

-- --------------------------------------------------------

--
-- Table structure for table `t_state`
--

CREATE TABLE `t_state` (
  `State_Id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'State Id',
  `Country_Id` int(6) NOT NULL COMMENT 'Country id',
  `state_name` varchar(100) NOT NULL COMMENT 'State name',
  PRIMARY KEY (`State_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='States list in all countries' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_state`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_statusmessages`
--

CREATE TABLE `t_statusmessages` (
  `sid` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Status id',
  `statusNumber` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - success, 1 - error',
  `statusMessage` varchar(400) NOT NULL COMMENT 'brief status message',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='status messages for the appl response' AUTO_INCREMENT=69 ;

--
-- Dumping data for table `t_statusmessages`
--

INSERT INTO `t_statusmessages` VALUES(1, 1, 'Mandatory field missing');
INSERT INTO `t_statusmessages` VALUES(2, 0, 'Login completed successfully');
INSERT INTO `t_statusmessages` VALUES(3, 0, 'Signup completed successfully');
INSERT INTO `t_statusmessages` VALUES(5, 1, 'Device type not supported');
INSERT INTO `t_statusmessages` VALUES(6, 1, 'Failed to login');
INSERT INTO `t_statusmessages` VALUES(7, 1, 'Problem in signing up');
INSERT INTO `t_statusmessages` VALUES(8, 1, 'Bad request, cannot be processed');
INSERT INTO `t_statusmessages` VALUES(9, 1, 'Session token expired, please login');
INSERT INTO `t_statusmessages` VALUES(10, 0, 'Details updated successfully.');
INSERT INTO `t_statusmessages` VALUES(11, 1, 'No data to update.');
INSERT INTO `t_statusmessages` VALUES(12, 1, 'Failed to update the data.');
INSERT INTO `t_statusmessages` VALUES(13, 0, 'Preferences updated successfully.');
INSERT INTO `t_statusmessages` VALUES(14, 1, 'Change any preferences to update.');
INSERT INTO `t_statusmessages` VALUES(15, 1, 'Failed to update the preferences.');
INSERT INTO `t_statusmessages` VALUES(16, 1, 'Please upload an image with valid extension');
INSERT INTO `t_statusmessages` VALUES(17, 1, 'Chunk size is larger than 512 kb.');
INSERT INTO `t_statusmessages` VALUES(18, 0, 'Image upload completed successfully.');
INSERT INTO `t_statusmessages` VALUES(19, 1, 'Please set your preference settings to find out matches around you.');
INSERT INTO `t_statusmessages` VALUES(20, 0, 'Matches Found!');
INSERT INTO `t_statusmessages` VALUES(21, 1, 'No matches in the vicinity! Please modify your search criteria!');
INSERT INTO `t_statusmessages` VALUES(22, 1, 'Search unsuccessful, error occured ');
INSERT INTO `t_statusmessages` VALUES(23, 0, 'Image deleted successfully');
INSERT INTO `t_statusmessages` VALUES(24, 1, 'Image not found');
INSERT INTO `t_statusmessages` VALUES(25, 1, 'Error in deleting the image');
INSERT INTO `t_statusmessages` VALUES(26, 0, 'Likes updated successfully');
INSERT INTO `t_statusmessages` VALUES(27, 1, 'Unable to insert likes');
INSERT INTO `t_statusmessages` VALUES(28, 1, 'Unable to modify likes');
INSERT INTO `t_statusmessages` VALUES(29, 0, 'Like sent!');
INSERT INTO `t_statusmessages` VALUES(30, 1, 'Unable to connect apple');
INSERT INTO `t_statusmessages` VALUES(31, 1, 'Invalid token, please login or register');
INSERT INTO `t_statusmessages` VALUES(32, 0, 'Profile updated successfully');
INSERT INTO `t_statusmessages` VALUES(33, 1, 'Nothing to update');
INSERT INTO `t_statusmessages` VALUES(34, 1, 'Failed to update profile');
INSERT INTO `t_statusmessages` VALUES(35, 0, 'Notification listed successfully');
INSERT INTO `t_statusmessages` VALUES(36, 1, 'Notification unavailable');
INSERT INTO `t_statusmessages` VALUES(37, 1, 'Server Error! Please try again after sometime!');
INSERT INTO `t_statusmessages` VALUES(38, 1, 'Provided FBid is unavailable');
INSERT INTO `t_statusmessages` VALUES(39, 1, 'Unable to find the profile');
INSERT INTO `t_statusmessages` VALUES(40, 0, 'Got the profile!');
INSERT INTO `t_statusmessages` VALUES(41, 0, 'Logged out successfully');
INSERT INTO `t_statusmessages` VALUES(42, 0, 'Location updated successfully');
INSERT INTO `t_statusmessages` VALUES(43, 1, 'Location already up to date');
INSERT INTO `t_statusmessages` VALUES(44, 0, 'Message sent!');
INSERT INTO `t_statusmessages` VALUES(45, 1, 'Failed to send message');
INSERT INTO `t_statusmessages` VALUES(46, 1, 'Unable to send push');
INSERT INTO `t_statusmessages` VALUES(47, 0, 'Got chat history!');
INSERT INTO `t_statusmessages` VALUES(48, 1, 'Chat history not found');
INSERT INTO `t_statusmessages` VALUES(49, 1, 'Queried user is deleted or inactive');
INSERT INTO `t_statusmessages` VALUES(50, 0, 'Matches found!');
INSERT INTO `t_statusmessages` VALUES(51, 1, 'Sorry, no matches found!');
INSERT INTO `t_statusmessages` VALUES(52, 0, 'User blocked successfully');
INSERT INTO `t_statusmessages` VALUES(53, 0, 'Got the settings!');
INSERT INTO `t_statusmessages` VALUES(54, 1, 'Sorry, settings not found.');
INSERT INTO `t_statusmessages` VALUES(55, 0, 'Congrats! You got a match');
INSERT INTO `t_statusmessages` VALUES(56, 0, 'Got the message!');
INSERT INTO `t_statusmessages` VALUES(57, 1, 'Message not found.');
INSERT INTO `t_statusmessages` VALUES(58, 0, 'User unblocked successfully.');
INSERT INTO `t_statusmessages` VALUES(59, 0, 'Session updated!');
INSERT INTO `t_statusmessages` VALUES(60, 1, 'Session not found, please signup to become a member.');
INSERT INTO `t_statusmessages` VALUES(61, 0, 'Question list');
INSERT INTO `t_statusmessages` VALUES(62, 0, 'Submit answer Successfully');
INSERT INTO `t_statusmessages` VALUES(63, 0, 'update answer Successfully');
INSERT INTO `t_statusmessages` VALUES(64, 0, 'Delete Account Successfully');
INSERT INTO `t_statusmessages` VALUES(65, 0, 'user Profile images');
INSERT INTO `t_statusmessages` VALUES(66, 0, 'NO user image uploded');
INSERT INTO `t_statusmessages` VALUES(67, 0, 'Updated status Successfully');
INSERT INTO `t_statusmessages` VALUES(68, 0, 'Already Updated');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_likes`
--

CREATE TABLE `t_user_likes` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `entity_id` int(25) NOT NULL,
  `like_id` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_user_likes`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_user_sessions`
--

CREATE TABLE `t_user_sessions` (
  `sid` int(20) NOT NULL AUTO_INCREMENT COMMENT 'Session id',
  `oid` int(20) NOT NULL COMMENT 'Object Id',
  `token` varchar(500) NOT NULL COMMENT 'Session token',
  `expiry_gmt` datetime NOT NULL COMMENT 'Session expiry date and time in GMT',
  `device` varchar(500) NOT NULL COMMENT 'Device on which session is generated',
  `type` int(4) NOT NULL COMMENT 'Type of device or platform',
  `push_token` varchar(700) DEFAULT NULL COMMENT 'Token for push notification',
  `create_date_gmt` datetime NOT NULL COMMENT 'Current date and time in GMT',
  `loggedIn` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 - logged in, 2 - logged out',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='stores multiple session token for all the users' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `t_user_sessions`
--

INSERT INTO `t_user_sessions` VALUES(1, 1, '00OO5TasSxcXBMiv1eV8GLi5TasSxcXBMiv1eV8GLi', '2015-05-28 06:33:15', '', 2, 'APA91bGordmGYdBIyrw2-FU4nGfAiXc_BKjb9Y7RLHW5LORMB7RV9p_Wt7jYJlPglTLB5RudK-NxZoqTm8J1-f9APwVF5Jz_Y3TQ0P-iX24AWEeIxA5Lg4qVLho-qeWwiJTxyJmJq4hKulMRqtPi0i2ValAZXBzYPw', '2015-05-26 06:33:15', 1);
INSERT INTO `t_user_sessions` VALUES(2, 2, '00bU26qEwXuRD1ZbU26qEwXuRD1ZCENH6iuCENH6iu', '2015-05-28 06:43:20', '', 2, 'APA91bE-fbiohAtVqj2UMaCf3OrhWzJiVMbwPHLwpcNccQ_-3yhIfLvvCcXQNXuOm1n7JmDzOFqMMaH0AKy70OSOZ0FCdCiB7Vfkb0SAtHLIed_UaWYkzpmsY9sEeBt_n7RllkrF7vQ-bKz7C2-PCOM4twKWslgbkA', '2015-05-26 06:43:20', 1);
INSERT INTO `t_user_sessions` VALUES(3, 3, '00V2awoz0V2awoz01KfxJcAaHRb1Q1KfxJcAaHRb1Q', '2015-05-28 07:03:41', '', 2, 'APA91bHv603Sm2k3cJQFbTqVT56YF9ERs-mWcQwmY6nsAQqRdQ1jTW2U_8fQuvhE66-p2CP-42HZo9UcgO86AsmA_DPpUOStkKa0oJsbz7AV8JroRQq-2YPRNOqw7ohM90uSSMcS5mF00QdB5rJNSaNnVcrghFkSZA', '2015-05-26 07:03:41', 1);
INSERT INTO `t_user_sessions` VALUES(4, 4, '00F0fraNNVURzDHMHHzoF0fraNNVURzDHMHHzokjkj', '2015-05-28 07:21:22', '', 2, 'APA91bF9LRylYTko4AQOVAACFQVzPwzD8lvu_29F8lRrqs1RtEJ9E42UkxAS-b-6R02WwUoyfpj5Z9I0DDRvydnUbhVzRDZxpa100HBoJUDrg_hfH-mbnWRNk6WhD08WhFeCrEsDTlOzY1Ect6cm36ZDhlVBUwWP0Q', '2015-05-26 07:21:22', 1);
INSERT INTO `t_user_sessions` VALUES(5, 5, '00l6OkUz03l6OkUz03MYkVd9IUuiRKMYkVd9IUuiRK', '2015-05-28 07:54:02', '', 2, 'APA91bFYJoLmCDArXGtuJzwWbbRC75rVZybgsdn8xIvkrd3yjagW48xVC-vBx4D-j-OCcIkxX6zJ4mzccGZXplX2uPq0NUDK2dH3EtV2r5odXwZzAnuUkh69mppcKLtzGWbN7ucL4HIRTZqKBNtBkhnaPCKFTK6HUg', '2015-05-26 07:54:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_work_experience`
--

CREATE TABLE `t_work_experience` (
  `Work_Id` int(25) NOT NULL AUTO_INCREMENT,
  `Entity_Id` int(25) NOT NULL COMMENT 'Entity_id',
  `Work_city` varchar(50) DEFAULT NULL,
  `work_country` varchar(50) DEFAULT NULL,
  `work_company` varchar(150) NOT NULL,
  `work_post` varchar(100) NOT NULL,
  `work_start_date` date DEFAULT NULL,
  `work_end_date` date DEFAULT NULL,
  PRIMARY KEY (`Work_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='List of work experience for each user' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `Generated with Vertabelo`
--


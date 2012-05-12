-- phpMyAdmin SQL Dump
-- version 3.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 12, 2012 at 02:13 PM
-- Server version: 5.5.15
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `final_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `datecreated` date NOT NULL,
  `datemodified` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `name`, `datecreated`, `datemodified`) VALUES
(1, 'r', '2012-05-09', '2012-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `blogposts`
--

CREATE TABLE IF NOT EXISTS `blogposts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `author` varchar(50) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `datecreated` datetime NOT NULL,
  `datemodified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blogposts`
--

INSERT INTO `blogposts` (`id`, `title`, `author`, `content`, `datecreated`, `datemodified`) VALUES
(1, 'b', '\r\nNotice: Undefined variable: _SESSION in /Library', 'b', '2012-05-09 14:18:56', '2012-05-09 14:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `datetime` datetime NOT NULL,
  `actionid` int(11) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`datetime`, `actionid`, `type`) VALUES
('2012-05-12 01:45:54', 4, 'photo'),
('2012-05-12 01:47:07', 5, 'photo'),
('2012-05-12 02:34:58', 6, 'photo'),
('2012-05-12 02:41:13', 7, 'photo'),
('2012-05-12 03:15:08', 8, 'photo'),
('2012-05-12 03:16:27', 9, 'photo'),
('2012-05-12 03:17:22', 10, 'photo'),
('2012-05-12 03:18:03', 11, 'photo'),
('2012-05-12 03:18:22', 12, 'photo'),
('2012-05-12 03:18:59', 13, 'photo'),
('2012-05-12 03:23:45', 14, 'photo'),
('2012-05-12 03:26:10', 15, 'photo'),
('2012-05-12 03:44:54', 16, 'photo'),
('2012-05-12 03:45:37', 17, 'photo'),
('2012-05-12 03:46:20', 18, 'photo');

-- --------------------------------------------------------

--
-- Table structure for table `notificationsViewed`
--

CREATE TABLE IF NOT EXISTS `notificationsViewed` (
  `username` varchar(50) NOT NULL,
  `lastViewed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notificationsViewed`
--

INSERT INTO `notificationsViewed` (`username`, `lastViewed`) VALUES
('11', '2012-05-12 01:51:00'),
('r', '2012-05-12 03:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `photoInAlbum`
--

CREATE TABLE IF NOT EXISTS `photoInAlbum` (
  `albumid` int(11) NOT NULL,
  `photoid` int(11) NOT NULL,
  KEY `albumid` (`albumid`,`photoid`),
  KEY `photoid` (`photoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `photoInAlbum`
--

INSERT INTO `photoInAlbum` (`albumid`, `photoid`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `photoInEvent`
--

CREATE TABLE IF NOT EXISTS `photoInEvent` (
  `eventid` int(11) NOT NULL,
  `photoid` int(11) NOT NULL,
  KEY `eventid` (`eventid`,`photoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(500) NOT NULL,
  `path_small` varchar(50) NOT NULL,
  `path_large` varchar(50) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `caption`, `path_small`, `path_large`, `dateadded`) VALUES
(1, 'omnom', '4fab380f07756bigmac.jpg', 'large_4fab380f07756bigmac.jpg', '2012-05-09 23:37:51'),
(2, 'f', '4fab384996b23bigmac.jpg', 'large_4fab384996b23bigmac.jpg', '2012-05-09 23:38:49'),
(3, '', '4fadf8c308641bigmac.jpg', 'large_4fadf8c308641bigmac.jpg', '2012-05-12 01:44:35'),
(4, '', '4fadf91212f85310305_10150425279654152_537189151_10', 'large_4fadf91212f85310305_10150425279654152_537189', '2012-05-12 01:45:54'),
(5, '', '4fadf95baa138yellowsubmarine.jpg', 'large_4fadf95baa138yellowsubmarine.jpg', '2012-05-12 01:47:07'),
(6, '', '4fae0491f268cyellowsubmarine.jpg', 'large_4fae0491f268cyellowsubmarine.jpg', '2012-05-12 02:34:58'),
(7, '', '4fae06096ddf5yellowsubmarine.jpg', 'large_4fae06096ddf5yellowsubmarine.jpg', '2012-05-12 02:41:13'),
(8, '', '4fae0dfc7b69dyellowsubmarine.jpg', 'large_4fae0dfc7b69dyellowsubmarine.jpg', '2012-05-12 03:15:08'),
(9, '', '4fae0e4abf7a1yellowsubmarine.jpg', 'large_4fae0e4abf7a1yellowsubmarine.jpg', '2012-05-12 03:16:27'),
(10, '', '4fae0e81ec41cyellowsubmarine.jpg', 'large_4fae0e81ec41cyellowsubmarine.jpg', '2012-05-12 03:17:22'),
(11, '', '4fae0eaadfc8dyellowsubmarine.jpg', 'large_4fae0eaadfc8dyellowsubmarine.jpg', '2012-05-12 03:18:03'),
(12, '', '4fae0ebe79a30yellowsubmarine.jpg', 'large_4fae0ebe79a30yellowsubmarine.jpg', '2012-05-12 03:18:22'),
(13, '', '4fae0ee357788yellowsubmarine.jpg', 'large_4fae0ee357788yellowsubmarine.jpg', '2012-05-12 03:18:59'),
(14, '', '4fae10017b46eyellowsubmarine.jpg', 'large_4fae10017b46eyellowsubmarine.jpg', '2012-05-12 03:23:45'),
(15, '', '4fae1092888e2yellowsubmarine.jpg', 'large_4fae1092888e2yellowsubmarine.jpg', '2012-05-12 03:26:10'),
(16, '', '4fae14f680dabbigmac.jpg', 'large_4fae14f680dabbigmac.jpg', '2012-05-12 03:44:54'),
(17, '', '4fae15210f606bigmac.jpg', 'large_4fae15210f606bigmac.jpg', '2012-05-12 03:45:37'),
(18, '', '4fae154c4baf4bigmac.jpg', 'large_4fae154c4baf4bigmac.jpg', '2012-05-12 03:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE IF NOT EXISTS `poll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `password`, `isAdmin`) VALUES
(1, 'admin', '', '', 'e99a18c428cb38d5f260853678922e03', 1),
(2, 'e', '', '', 'e1671797c52e15f763380b45e841ec32', 0),
(3, 'hello', '', '', '7d793037a0760186574b0282f2f435e7', 0),
(4, 'test', '', '', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(5, 'walrus', '', '', '1a1dc91c907325c69271ddf0c944bc72', 1),
(6, 'AB', 'jkj', 'jkjk', '0d61f8370cad1d412f80b84d143e1257', 0),
(7, 'fs', 'fdd', 'fds', '838ece1033bf7c7468e873e79ba2a3ec', 1),
(8, 'a', 'a', 'a', '0cc175b9c0f1b6a831c399e269772661', 0),
(9, 'notif', 'a', 'a', '0cc175b9c0f1b6a831c399e269772661', 0),
(10, 'no', 'a', 'a', '0cc175b9c0f1b6a831c399e269772661', 0),
(11, 'b', 'b', 'b', '92eb5ffee6ae2fec3ad71c777531578f', 0),
(13, 'w', 'w', 'w', 'f1290186a5d0b1ceab27f4e77c0c5d68', 0),
(15, 'q', 'q', 'q', '7694f4a66316e53c8cdd9d9954bd611d', 0),
(16, 'r', 'r', 'r', '4b43b0aee35624cd95b910189b3dc231', 0);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `voterid` int(11) NOT NULL,
  `candidateid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`voterid`, `candidateid`) VALUES
(1, 5);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `photoInAlbum`
--
ALTER TABLE `photoInAlbum`
  ADD CONSTRAINT `photoInAlbum_ibfk_2` FOREIGN KEY (`photoid`) REFERENCES `photos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `photoInAlbum_ibfk_1` FOREIGN KEY (`albumid`) REFERENCES `albums` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

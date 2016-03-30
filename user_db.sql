-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Mar 30, 2016 at 09:13 PM
-- Server version: 5.5.42-log
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `friend_request`
--

CREATE TABLE `friend_request` (
  `id` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(20) NOT NULL,
  `admin` int(11) NOT NULL,
  `user_two` int(11) DEFAULT '0',
  `user_three` int(11) DEFAULT '0',
  `user_four` int(11) DEFAULT '0',
  `user_five` int(11) DEFAULT '0',
  `is_full` varchar(10) NOT NULL DEFAULT 'not_full'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `admin`, `user_two`, `user_three`, `user_four`, `user_five`, `is_full`) VALUES
(5, 'Test2', 2, 10, 15, 19, 22, 'full'),
(6, 'Test3', 3, 6, 7, 0, 0, 'not_full'),
(7, 'Test4', 4, 21, 24, 28, 29, 'full'),
(8, 'Test', 1, 5, 0, 0, 0, 'not_full');

-- --------------------------------------------------------

--
-- Table structure for table `group_request`
--

CREATE TABLE `group_request` (
  `id` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_request`
--

INSERT INTO `group_request` (`id`, `from_user`, `to_user`) VALUES
(2, 1, 30),
(3, 1, 7),
(4, 1, 9),
(6, 1, 11),
(7, 1, 12),
(8, 1, 17),
(9, 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `in_group` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `in_group`) VALUES
(1, 'admin1@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 1),
(2, 'admin2@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 1),
(3, 'admin3@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 1),
(4, 'test4@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 1),
(5, 'test5@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 1),
(6, 'test6@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(7, 'test7@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(8, 'test8@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(9, 'test9@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(10, 'test10@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(11, 'test11@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(12, 'test12@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(13, 'test13@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(14, 'test14@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(15, 'test15@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(16, 'test16@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(17, 'test17@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(18, 'test18@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(19, 'test19@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(20, 'test20@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(21, 'test21@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(22, 'test22@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(23, 'test23@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(24, 'test24@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(25, 'test25@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(26, 'test26@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(27, 'test27@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(28, 'test28@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(29, 'test29@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(30, 'test30@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(31, 'test@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0),
(32, 'fuck@gmail.com', '0897ae4241cd88fd22355eb4c42925f8', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_request`
--
ALTER TABLE `friend_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_request`
--
ALTER TABLE `group_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `friend_request`
--
ALTER TABLE `friend_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `group_request`
--
ALTER TABLE `group_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

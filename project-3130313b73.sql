-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2019 at 07:30 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-3130313b73`
--

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--
DROP TABLE IF EXISTS `followers`;
CREATE TABLE `followers` (
  `id` int(255) UNSIGNED NOT NULL,
  `user_id` int(255) UNSIGNED NOT NULL,
  `follower_id` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `user_id`, `follower_id`) VALUES
(1, 6, 6),
(2, 7, 5),
(4, 6, 7),
(5, 7, 7),
(6, 5, 7),
(7, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `liker_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `post` int(11) NOT NULL,
  `body` varchar(255) NOT NULL,
  `posted_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post`, `body`, `posted_at`, `user_id`, `likes`) VALUES
(1, 'xdd', '2019-02-16 22:26:15', 6, 0),
(2, 'oh xpppp', '2019-02-16 22:26:21', 6, 0),
(3, 'this is my first post', '2019-02-16 22:29:10', 5, 0),
(4, 'fuck off', '2019-02-16 22:29:45', 7, 0),
(5, 'ddd', '2019-02-16 22:30:26', 7, 0),
(6, 'im gay', '2019-02-16 22:30:55', 7, 0),
(7, 'nice pp', '2019-02-16 22:31:31', 6, 0),
(8, 'im sam and have swag', '2019-02-16 22:31:36', 6, 0),
(9, '', '2019-02-16 22:31:37', 6, 0),
(10, 'nice pp', '2019-02-16 22:31:48', 6, 0),
(11, 'nice pp', '2019-02-16 22:32:40', 6, 0),
(12, 'nice pp', '2019-02-16 22:33:22', 6, 0),
(13, 'second\r\n', '2019-02-16 22:34:56', 5, 0),
(14, 'hello post', '2019-02-16 22:56:55', 7, 0),
(15, 'another post', '2019-02-17 21:49:35', 5, 0),
(16, 'like my post!', '2019-03-06 00:46:37', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--
DROP TABLE IF EXISTS `post_likes`;
CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `post_id`, `user_id`) VALUES
(9, 16, 5);

-- --------------------------------------------------------

--
-- Table structure for table `profile_image`
--
DROP TABLE IF EXISTS `profile_image`;
CREATE TABLE `profile_image` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `User_ID` int(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Surname` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Email`, `username`, `Forename`, `Surname`, `Password`, `image`) VALUES
(5, 'will3re@hotmail.com', 'willystaff', 'will', 'staff', 'snippers', 'tumblr_oxgy94NYhL1ujllspo1_250.jpg'),
(6, 'bob@gmail.com', 'mrbob', 'bob', 'bob', 'test', 'b7e3a3118f199f0ddd1261f2ef3db8a8_400x400.jpeg'),
(7, 'jonmccormack1999@hotmail.co.uk', 'jonnycool', 'Jon', 'McCormack', 'jonisgay', '_104058212_billysharp.jpg'),
(8, 'ethaniha@gmail.com', 'Ethan', 'Ethan', 'Richardson', '123456789', 'default.jpg'),
(9, 'glee3004@gmail.com', 'Greg_Lee', 'Gregory', 'Lee', '12345', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_comments`
--
DROP TABLE IF EXISTS `users_comments`;
CREATE TABLE `users_comments` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `posted_at` datetime NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_comments`
--

INSERT INTO `users_comments` (`id`, `body`, `user_id`, `posted_at`, `post_id`) VALUES
(1, 'first comment', 5, '2019-03-06 13:48:37', 16),
(2, 'second comment', 5, '2019-03-06 13:48:49', 16),
(3, 'third comment when we can unlike', 5, '2019-03-06 13:49:40', 16),
(4, 'new comment on another post', 5, '2019-03-06 14:07:05', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_image`
--
ALTER TABLE `profile_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users_comments`
--
ALTER TABLE `users_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `profile_image`
--
ALTER TABLE `profile_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users_comments`
--
ALTER TABLE `users_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

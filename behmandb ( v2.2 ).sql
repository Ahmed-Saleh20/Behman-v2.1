-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 31, 2020 at 11:14 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `behmandb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `post_id`, `user_id`, `comment`, `comment_author`, `date`) VALUES
(6, 22, 10, 'Depression (major depressive disorder) is a common and serious medical illness that negatively affects how you feel, the way you think and how you act. Fortunately, it is also treatable. Depression causes feelings of sadness and/or a loss of interest in a', 'doctor samy_mohamed_883013', '2020-03-12 01:52:44'),
(7, 20, 9, '2nt 3abet yad', 'doctor samy_mohamed_883013', '2020-03-19 18:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_content` varchar(500) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `likes` int(11) NOT NULL,
  `postShare` int(11) NOT NULL,
  `postType` int(11) NOT NULL,
  `privateTo` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `p_reports` int(11) NOT NULL,
  `AllowComment` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_content`, `post_date`, `likes`, `postShare`, `postType`, `privateTo`, `status`, `p_reports`, `AllowComment`, `cat_id`, `user_id`) VALUES
(20, 'What is Depression ?', '2020-03-21 17:32:25', 1, 0, 0, NULL, 0, 0, 0, 0, 9),
(22, 'What is Depression ?', '2020-03-21 17:30:33', 3, 0, 0, NULL, 0, 0, 0, 0, 10),
(25, 'Hello test post type!', '2020-03-25 19:54:31', 0, 0, 1, NULL, 0, 0, 0, 0, 9),
(27, 'aaaaaaaaaaaaa', '2020-03-26 04:41:58', 0, 0, 0, NULL, 0, 0, 0, 0, 8),
(28, 'ahmed', '2020-03-26 05:48:46', 0, 0, 3, 8, 0, 0, 0, 0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `rating_info`
--

CREATE TABLE `rating_info` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `rating_action` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating_info`
--

INSERT INTO `rating_info` (`user_id`, `post_id`, `rating_action`) VALUES
(8, 22, 'like'),
(9, 20, 'like'),
(9, 22, 'like'),
(11, 22, 'like');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `f_name` text NOT NULL,
  `l_name` text NOT NULL,
  `phone` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `user_name` text NOT NULL,
  `describe_user` varchar(255) NOT NULL,
  `Relationship` text NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_country` text NOT NULL,
  `user_gender` text NOT NULL,
  `user_birthday` text NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_cover` varchar(255) NOT NULL,
  `user_reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` text NOT NULL,
  `posts` text NOT NULL,
  `recovery_account` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `CV` varchar(255) DEFAULT NULL,
  `approved` int(11) DEFAULT NULL,
  `user_block` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `f_name`, `l_name`, `phone`, `address`, `user_name`, `describe_user`, `Relationship`, `user_pass`, `user_email`, `user_country`, `user_gender`, `user_birthday`, `user_image`, `user_cover`, `user_reg_date`, `status`, `posts`, `recovery_account`, `type`, `CV`, `approved`, `user_block`) VALUES
(8, 'Doctor Samy', 'Mohamed', '', '', 'doctor samy_mohamed_883013', 'Hello!! This is my default status', '........', '12345678', 'samy@gmail.com', 'Egypt', 'Male', '2019-11-28', '0zlg5gqv_400x400.jpg.58', 'ali.jpg.78', '2020-03-31 21:10:07', 'verified', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 1, NULL, 1, 1),
(9, 'User Ahmed', 'Maher', '', '', 'user ahmed_maher_697819', 'Hello!! This is my default status', 'Single', '12345678', 'ahmed@gmail.com', 'Egypt', 'Male', '2018-10-27', 'head_red.png.22', 'default_cover.jpg', '2020-03-31 20:55:44', 'verified', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, NULL, 0, 1),
(10, 'User Mo ', 'Karam', '', '', 'user mo _karam_933005', 'Hello!! This is my default status', '........', '12345678', 'mo@gmail.com', 'Egypt', 'Male', '2017-11-25', 'head_sun_flower.png.89', 'default_cover.jpg', '2020-03-19 19:32:24', 'verified', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, NULL, 1, 0),
(12, 'adel', 'ahmed', NULL, NULL, 'adel_ahmed_825871', 'Hello!! This is my default status', '........', '12345678', 'adel@gmail.com', 'Egypt', 'Male', '18/5/2000', 'default.png', 'default_cover.jpg', '2020-03-31 21:09:44', 'verified', 'no', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, NULL, 1, 0),
(14, 'sameh', 'ashraf', '0105578959', 'dsadadadsasdas', 'sameh_ashraf_994599', 'Hello!! This is my default status', '........', '12345678', 'sameh@gmail.com', 'Egypt', 'Male', '16/7/1990', 'default.png', 'default_cover.jpg', '2020-03-19 20:08:15', 'verified', 'no', 'ifyouaregootatsomethingdontdoitforfree45566677888', 1, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE `user_messages` (
  `id` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `msg_body` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `msg_seen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_messages`
--

INSERT INTO `user_messages` (`id`, `user_to`, `user_from`, `msg_body`, `date`, `msg_seen`) VALUES
(1, 3, 2, 'hi\r\n', '2020-03-01 11:49:05', 'no'),
(2, 3, 2, 'Hello', '2020-03-01 11:49:22', 'no'),
(3, 3, 2, 'hello', '2020-03-01 11:49:33', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `rating_info`
--
ALTER TABLE `rating_info`
  ADD UNIQUE KEY `UC_rating_info` (`user_id`,`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_messages`
--
ALTER TABLE `user_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

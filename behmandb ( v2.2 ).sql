-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2020 at 03:14 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `booked_chat`
--

CREATE TABLE `booked_chat` (
  `id` int(255) NOT NULL,
  `doc_id` int(255) NOT NULL,
  `cost` int(255) NOT NULL,
  `chat_time` int(255) NOT NULL,
  `chat_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `coming_private_chat`
--

CREATE TABLE `coming_private_chat` (
  `id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day_char` varchar(255) NOT NULL,
  `final_day` int(11) NOT NULL,
  `final_month` int(11) NOT NULL,
  `final_year` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `start_chat` varchar(255) NOT NULL,
  `start_minutes` varchar(255) NOT NULL,
  `am_pm` varchar(255) NOT NULL,
  `pm_am` varchar(255) NOT NULL,
  `was_booked_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `file_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `file_image` varchar(255) NOT NULL,
  `file_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`file_id`, `file`, `file_image`, `file_time`, `parent_id`, `user_id`) VALUES
(158, '06_Tree.ppsx', 'powerpoint.png', '2020-04-08 04:56:49', 71, 8),
(159, 'Sheet1.pdf', 'pdf.png', '2020-04-08 04:57:46', 71, 8),
(160, 'Sheet2.pdf', 'pdf.png', '2020-04-08 04:57:55', 71, 8),
(161, '9.rar', 'unknownfile.png', '2020-04-08 04:58:00', 71, 8),
(163, '1.docx', 'word.png', '2020-04-08 05:00:07', 71, 8),
(164, 'cola2 (1) (3).xls', 'excel.png', '2020-04-08 05:00:14', 71, 8),
(165, 'Lecture_1.pdf', 'pdf.png', '2020-04-08 05:01:30', 72, 8),
(166, 'Lecture_2.pdf', 'pdf.png', '2020-04-08 05:01:34', 72, 8),
(167, 'Lecture_4.pdf', 'pdf.png', '2020-04-08 05:01:38', 72, 8),
(168, 'Lecture_6.pdf', 'pdf.png', '2020-04-08 05:01:44', 72, 8),
(169, 'Lecture_7.pdf', 'pdf.png', '2020-04-08 05:01:48', 72, 8),
(170, 'Lecture_8.pdf', 'pdf.png', '2020-04-08 05:01:54', 72, 8);

-- --------------------------------------------------------

--
-- Table structure for table `folder`
--

CREATE TABLE `folder` (
  `folder_id` int(11) NOT NULL,
  `folder_name` varchar(255) NOT NULL,
  `folder_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `privacy` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `folder`
--

INSERT INTO `folder` (`folder_id`, `folder_name`, `folder_time`, `privacy`, `parent_id`, `user_id`) VALUES
(71, 'Data Structures', '2020-04-08 04:52:45', 1, 0, 8),
(72, 'Lectures', '2020-04-08 04:53:07', 1, 71, 8),
(73, 'Sections', '2020-04-08 04:53:13', 1, 71, 8),
(74, 'Statistics', '2020-04-08 05:02:38', 1, 0, 8),
(75, ' white-space: nowrap;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;overflow: hidden;text-overflow: ellipsis; white-', '2020-05-20 06:05:21', 1, 71, 8),
(78, 'parent 1', '2020-05-20 06:06:15', 1, 72, 8);

-- --------------------------------------------------------

--
-- Table structure for table `pctt`
--

CREATE TABLE `pctt` (
  `id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `day_char` varchar(255) NOT NULL,
  `availability` int(11) NOT NULL,
  `available_from` int(11) NOT NULL,
  `available_to` int(11) NOT NULL,
  `last_book` int(11) NOT NULL,
  `from_am_pm` int(11) NOT NULL,
  `to_am_pm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `list_id` int(11) NOT NULL,
  `list_name` varchar(255) NOT NULL,
  `list_pic` varchar(255) NOT NULL,
  `list_time` timestamp NULL DEFAULT current_timestamp(),
  `list_videos` int(255) NOT NULL,
  `privacy` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`list_id`, `list_name`, `list_pic`, `list_time`, `list_videos`, `privacy`, `user_id`) VALUES
(93, 'Favorite Songs 2019', 'songs.png.269', '2020-04-08 04:32:01', 6, 1, 8),
(95, 'انجازاتك', 'empty.jpg.337', '2020-04-08 05:08:44', 0, 1, 8),
(100, 'eee', 'default_playlist_image.jpg', '2020-06-29 11:45:22', 0, 1, 8);

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
(42, 'hhhhhhhhhhhhh', '2020-06-23 04:44:48', 1, 0, 1, NULL, 0, 0, 0, 0, 8),
(43, '', '2020-07-01 01:18:57', 0, 0, 3, 0, 0, 0, 0, 0, 10),
(44, '', '2020-07-03 00:30:30', 0, 0, 3, 8, 0, 0, 0, 0, 8),
(45, '', '2020-07-03 02:05:52', 0, 0, 3, 8, 0, 0, 0, 0, 8),
(46, 't', '2020-07-03 17:05:31', 0, 0, 1, NULL, 0, 0, 0, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `private_chat`
--

CREATE TABLE `private_chat` (
  `id` int(11) NOT NULL,
  `message_owner` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `private_chat`
--

INSERT INTO `private_chat` (`id`, `message_owner`, `chat_id`, `message`, `date`) VALUES
(85, 8, 73, 'j7', '2020-07-04 18:30:14'),
(82, 10, 73, 'b', '2020-07-04 17:20:12'),
(83, 10, 73, 'a', '2020-07-04 17:25:02'),
(84, 10, 73, 'we', '2020-07-04 18:25:50'),
(86, 8, 73, 'j7', '2020-07-04 18:30:14'),
(87, 10, 105, 'attt', '2020-07-04 23:55:18'),
(88, 10, 105, 'atttatt', '2020-07-04 23:55:21'),
(89, 10, 105, 'atttatt', '2020-07-04 23:55:24'),
(90, 10, 105, 'atttatt', '2020-07-04 23:55:27'),
(91, 10, 105, 'kkkkkkkkk', '2020-07-04 23:55:33'),
(92, 10, 105, 'eeeeeeeee', '2020-07-04 23:55:39'),
(93, 10, 105, 'ggggg', '2020-07-04 23:55:53');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `Doc_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Rate` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`Doc_ID`, `User_ID`, `Rate`) VALUES
(8, 10, 1),
(8, 10, 1),
(8, 10, 4),
(8, 10, 4),
(8, 10, 5),
(8, 10, 1),
(8, 10, 1),
(8, 10, 1),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 1),
(8, 10, 1),
(8, 10, 1),
(8, 10, 5),
(8, 10, 2),
(8, 10, 2),
(8, 10, 1),
(8, 10, 1),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 4),
(8, 10, 1),
(8, 10, 1);

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
(8, 25, 'like'),
(8, 27, 'like'),
(8, 37, 'like'),
(8, 42, 'like'),
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
  `user_block` int(11) NOT NULL,
  `private_chat` int(255) DEFAULT NULL,
  `credit_card` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `f_name`, `l_name`, `phone`, `address`, `user_name`, `describe_user`, `Relationship`, `user_pass`, `user_email`, `user_country`, `user_gender`, `user_birthday`, `user_image`, `user_cover`, `user_reg_date`, `status`, `posts`, `recovery_account`, `type`, `CV`, `approved`, `user_block`, `private_chat`, `credit_card`) VALUES
(8, 'Samy', 'Mohamed', '', '', 'doctor samy_mohamed_883013', 'Hello!! This is my default status', '........', '12345678', 'samy@gmail.com', 'Egypt', 'Male', '2019-11-28', '0zlg5gqv_400x400.jpg.58', 'ali.jpg.78', '2020-07-05 01:14:06', 'verified', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 1, NULL, 1, 1, 0, 0),
(9, 'Ahmed', 'Maher', '', '', 'user ahmed_maher_697819', 'Hello!! This is my default status', 'Single', '12345678', 'ahmed@gmail.com', 'Egypt', 'Male', '2018-10-27', 'head_red.png.22', 'default_cover.jpg', '2020-07-02 19:07:21', 'verified', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, NULL, 0, 1, 0, 0),
(10, 'Mo ', 'Karam', '', '', 'user mo _karam_933005', 'Hello!! This is my default status', '........', '12345678', 'mo@gmail.com', 'Egypt', 'Male', '2017-11-25', 'head_sun_flower.png.89', 'default_cover.jpg', '2020-07-05 01:14:10', 'verified', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, NULL, 1, 0, 0, 0),
(12, 'adel', 'ahmed', NULL, NULL, 'adel_ahmed_825871', 'Hello!! This is my default status', '........', '12345678', 'adel@gmail.com', 'Egypt', 'Male', '18/5/2000', 'default.png', 'default_cover.jpg', '2020-07-02 16:07:28', 'verified', 'no', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, NULL, 1, 0, 0, 0),
(14, 'sameh', 'ashraf', '0105578959', 'dsadadadsasdas', 'sameh_ashraf_994599', 'Hello!! This is my default status', '........', '12345678', 'sameh@gmail.com', 'Egypt', 'Male', '16/7/1990', 'default.png', 'default_cover.jpg', '2020-07-02 16:07:31', 'verified', 'no', 'ifyouaregootatsomethingdontdoitforfree45566677888', 1, NULL, 0, 0, 0, 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `video_id` int(11) NOT NULL,
  `video_title` varchar(255) NOT NULL,
  `video_desc` text DEFAULT NULL,
  `video` varchar(255) NOT NULL,
  `video_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `video_pic` varchar(255) NOT NULL,
  `video_duration_hours` int(11) NOT NULL,
  `video_duration_minutes` int(11) NOT NULL,
  `video_duration_seconds` int(11) NOT NULL,
  `views` int(255) NOT NULL,
  `playlist_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `video_title`, `video_desc`, `video`, `video_time`, `video_pic`, `video_duration_hours`, `video_duration_minutes`, `video_duration_seconds`, `views`, `playlist_id`, `user_id`) VALUES
(127, 'ya ghaly - Noran Tayeb', 'Description of video will appear hear: \r\n Description is the pattern of narrative development that aims to make vivid a place, object, character, or group. Description is one of four rhetorical modes, along with exposition, argumentation, and narration. In practice it would be difficult to write literature that drew on just one of the four basic modes', 'videoplayback.mp4.452', '2020-04-08 04:34:30', 'video_pic.452.png', 0, 3, 0, 32, 93, 8),
(128, 'Baby Shark', 'Description of video will appear hear: Description is the pattern of narrative development that aims to make vivid a place, object, character, or group. Description is one of four rhetorical modes, along with exposition, argumentation, and narration. In practice it would be difficult to write literature that drew on just one of the four basic modes', 'videoplayback (7).mp4.5', '2020-04-08 04:37:54', 'video_pic.5.png', 0, 2, 16, 7, 93, 8),
(129, 'Halaa Roushdy', 'Description of video will appear hear: Description is the pattern of narrative development that aims to make vivid a place, object, character, or group. Description is one of four rhetorical modes, along with exposition, argumentation, and narration. In practice it would be difficult to write literature that drew on just one of the four basic modes', 'videoplayback (4).mp4.32', '2020-04-08 04:39:46', 'video_pic.32.png', 0, 3, 20, 14, 93, 8),
(131, 'i used to believe', 'Description of video will appear hear: Description is the pattern of narrative development that aims to make vivid a place, object, character, or group. Description is one of four rhetorical modes, along with exposition, argumentation, and narration. In practice it would be difficult to write literature that drew on just one of the four basic modes', 'videoplayback (1).mp4.495', '2020-04-08 04:41:16', 'video_pic.495.png', 0, 0, 59, 10, 93, 8),
(132, 'See you again', 'Description of video will appear hear: Description is the pattern of narrative development that aims to make vivid a place, object, character, or group. Description is one of four rhetorical modes, along with exposition, argumentation, and narration. In practice it would be difficult to write literature that drew on just one of the four basic modes', 'videoplayback (3).mp4.145', '2020-04-08 04:42:45', 'video_pic.145.png', 0, 0, 38, 10, 93, 8),
(133, 'The Bearded Man', 'Description of video will appear hear: Description is the pattern of narrative development that aims to make vivid a place, object, character, or group. Description is one of four rhetorical modes, along with exposition, argumentation, and narration. In practice it would be difficult to write literature that drew on just one of the four basic modes', 'videoplayback (6).mp4.28', '2020-04-08 04:44:35', 'video_pic.28.png', 0, 2, 16, 3, 93, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_chat`
--
ALTER TABLE `booked_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doc_id` (`doc_id`);

--
-- Indexes for table `coming_private_chat`
--
ALTER TABLE `coming_private_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `folder_id` (`parent_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `folder`
--
ALTER TABLE `folder`
  ADD PRIMARY KEY (`folder_id`);

--
-- Indexes for table `pctt`
--
ALTER TABLE `pctt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doc_id` (`doc_id`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`list_id`),
  ADD KEY `playlist_ibfk_1` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `private_chat`
--
ALTER TABLE `private_chat`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `playlist_id` (`playlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_chat`
--
ALTER TABLE `booked_chat`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `coming_private_chat`
--
ALTER TABLE `coming_private_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
  MODIFY `folder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `pctt`
--
ALTER TABLE `pctt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=525;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `private_chat`
--
ALTER TABLE `private_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

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

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked_chat`
--
ALTER TABLE `booked_chat`
  ADD CONSTRAINT `booked_chat_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `file_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `folder` (`folder_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `file_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pctt`
--
ALTER TABLE `pctt`
  ADD CONSTRAINT `pctt_ibfk_1` FOREIGN KEY (`doc_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_ibfk_2` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`list_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

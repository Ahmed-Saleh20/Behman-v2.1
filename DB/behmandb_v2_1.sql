-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2020 at 01:47 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `behmandb_v2.1`
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

--
-- Dumping data for table `booked_chat`
--

INSERT INTO `booked_chat` (`id`, `doc_id`, `cost`, `chat_time`, `chat_number`) VALUES
(159, 37, 1, 1, 1),
(160, 37, 1, 1, 2),
(161, 37, 1, 1, 3),
(162, 38, 1, 1, 1),
(163, 38, 1, 1, 2),
(164, 38, 1, 1, 3);

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

--
-- Dumping data for table `coming_private_chat`
--

INSERT INTO `coming_private_chat` (`id`, `doc_id`, `user_id`, `day_char`, `final_day`, `final_month`, `final_year`, `cost`, `duration`, `start_chat`, `start_minutes`, `am_pm`, `pm_am`, `was_booked_on`) VALUES
(125, 38, 43, 'Monday', 6, 9, 2020, 1, 1, '1', '0', 'AM', 'AM', '2020-09-03 23:42:48');

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
(10, 51, 35, 'hi\r\n', 'Sam Ahmed', '2020-07-18 17:46:20'),
(11, 47, 32, 'Hello I am Sam', 'Sam Ahmed', '2020-07-18 17:48:43'),
(12, 49, 32, 'Good', 'dr.mohamed salem', '2020-07-20 00:04:11'),
(13, 76, 32, 'I advise you to sport, sport is very useful, you should read useful, science, knowledge and knowledge as well, all of which strengthen human intellectual, social and psychological skills.\r\n', 'Malisia  Gorge', '2020-07-23 16:27:16'),
(14, 67, 35, 'Treat him tight and firm and join him in a club', 'Malisia  Gorge', '2020-07-23 16:37:55'),
(15, 79, 32, 'Preserve the ten and do what you want after that ???? Try changing your life and longing for it. Let the change come from you and tell you originally. Leave the Facebook I am sure you will change your life.', 'Malisia  Gorge', '2020-07-23 18:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `connectus`
--

CREATE TABLE `connectus` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Subject` text NOT NULL,
  `Message` text NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `connectus`
--

INSERT INTO `connectus` (`ID`, `Name`, `Email`, `Subject`, `Message`, `Date`) VALUES
(1, 'Ahmed ', 'ahmed@gmail.com', 'ahmed ahmed', 'Thank you very much.', '2020-05-11'),
(2, 'Islam', 'admin@gmail.com', 'Great', 'That Is Nice Answer.', '2020-05-18'),
(3, 'Mohamed', 'admin@gmail.com', 'Thankful', 'Good Job,It is Helpful website.', '2020-05-18');

-- --------------------------------------------------------

--
-- Table structure for table `docrate`
--

CREATE TABLE `docrate` (
  `ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Doc_ID` int(11) NOT NULL,
  `Rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(171, '1.pdf', 'pdf.png', '2020-07-18 17:16:06', 80, 33),
(172, 'Ahmed CV.pdf', 'pdf.png', '2020-09-03 23:32:18', 83, 38);

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
(80, 'A1', '2020-07-18 17:15:45', 1, 0, 33),
(81, 'A3', '2020-07-23 15:54:21', 1, 0, 36),
(82, 'A5', '2020-07-23 16:27:52', 1, 0, 37),
(83, 'A1', '2020-09-03 23:31:53', 1, 0, 38);

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

--
-- Dumping data for table `pctt`
--

INSERT INTO `pctt` (`id`, `doc_id`, `day`, `day_char`, `availability`, `available_from`, `available_to`, `last_book`, `from_am_pm`, `to_am_pm`) VALUES
(532, 37, 1, 'Saturday', 1, 1, 7, 0, 1, 1),
(533, 37, 2, 'Sunday', 0, 0, 0, 0, 0, 0),
(534, 37, 3, 'Monday', 0, 0, 0, 0, 0, 0),
(535, 37, 4, 'Tuesday', 0, 0, 0, 0, 0, 0),
(536, 37, 5, 'Wednesday', 1, 1, 10, 0, 1, 1),
(537, 37, 6, 'Thursday', 0, 0, 0, 0, 0, 0),
(538, 37, 7, 'Friday', 1, 1, 9, 0, 1, 1),
(539, 38, 1, 'Saturday', 1, 1, 1, 0, 1, 1),
(540, 38, 2, 'Sunday', 1, 1, 1, 0, 1, 1),
(541, 38, 3, 'Monday', 1, 1, 1, 1, 1, 1),
(542, 38, 4, 'Tuesday', 0, 0, 0, 0, 0, 0),
(543, 38, 5, 'Wednesday', 0, 0, 0, 0, 0, 0),
(544, 38, 6, 'Thursday', 0, 0, 0, 0, 0, 0),
(545, 38, 7, 'Friday', 0, 0, 0, 0, 0, 0);

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
(101, 'A2', '368845.jpg.402', '2020-07-18 17:16:40', 0, 1, 33),
(102, 'Depression', 'art6.jpg.471', '2020-07-23 16:29:40', 0, 1, 37),
(103, 'P1', 'default_playlist_image.jpg', '2020-09-03 23:32:26', 0, 1, 38),
(104, 'P2', '28233264-45ed-4143-86ab-8ae83124b7b1-5e6fff57c894e-760x400.jpeg.44', '2020-09-03 23:34:22', 0, 1, 38);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_content` text NOT NULL,
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
(51, 'Hello This is ask private From Sam To Dr.Islam.', '2020-07-18 17:25:05', 0, 0, 3, 33, 0, 0, 0, 0, 35),
(64, 'I got married in a traditional marriage. I am 22 years old. My husband lives in the house of his mother&rsquo;s husband who supervised his upbringing and considers him his son. Several problems occurred between us shortly after marriage due to my excessive nervousness. I get attached to it and sit with him more than my husband and his mother, a good, respectful, cultured man, and as a whole in everything until his shape looks younger than his age, this problem is not that I have become loved and jealous of him even from my husband\'s mother and I intend to stay with him for long times and sit with him in his library on the pretext that I love books and love to There is a rapprochement between us and I became his counselor even in my clothes and he treats me like his daughter and even he ignores looking at me directly and always asks me to take care of my husband I hate my feeling this and I hope that I love my husband as I love him but this is outside my will I do not know what to do I love so much my life with him in this way but I am afraid of the next I fear that I will not love my husband even though he is a good man. I am very distracted. Is separation from this family the solution?', '2020-07-23 16:40:24', 2, 0, 1, NULL, 0, 0, 0, 4, 40),
(65, 'Hi ', '2020-07-23 16:40:19', 2, 0, 1, NULL, 0, 0, 0, 0, 40),
(66, 'I suffer a lot with my child, because he is naughty, a lot of movement, and he always abounds and destroys things. He does not play with children. He always keeps alone in his room, he listens to the mobile phone on things that have no value, I find that he has a goal that he likes to reach.', '2020-09-03 13:44:23', 0, 0, 2, NULL, 0, 0, 0, 1, 39),
(67, 'I suffer a lot with my child, because he is naughty, a lot of movement, and he always abounds and destroys things. He does not play with children. He always keeps alone in his room, he listens to the mobile phone on things that have no value, I find that he has a goal that he likes to reach.', '2020-07-23 16:39:16', 1, 0, 3, 37, 0, 0, 0, 1, 35),
(68, 'Welcome, I am a psychiatrist', '2020-07-23 16:39:21', 2, 0, 1, NULL, 0, 0, 0, 0, 37),
(70, 'I suffer from severe depression.', '2020-09-02 09:15:15', 1, 0, 2, NULL, 0, 0, 0, 2, 32),
(72, 'Welcome, I am a psychiatrist\r\n', '2020-07-23 16:40:06', 1, 0, 1, NULL, 0, 0, 0, 0, 36),
(73, 'I suffer from severe depression, I am very tired psychologically and feel pain, I am 31 years old now, I have done nothing in my life, I do not have a home, I am not married, and there is no advantage in my life. I can no longer work, there is an accumulation of work in the office, I have no motivation to work, and I no longer answer phone calls, even my friends and my calls as I sleep from six o\'clock in the evening and do not wake up until six o\'clock the next day, and if I woke up before that, I stayed in The bed of my depression. I can no longer live on my own and without a wife, I do not hide from you that the issue of the marital relationship has its effect, but I cannot see any girl who is not modest, because I feel very narrow and heart palpitations and tremors, and a new state of depression begins because I am unable to marry and spoil my day Entire.', '2020-07-23 16:40:10', 1, 0, 1, NULL, 0, 0, 0, 2, 32),
(75, 'Welcome, I am a psychiatrist', '2020-09-03 23:25:22', 1, 0, 1, NULL, 0, 0, 0, 0, 38),
(78, 'I have a problem with my son in learning because he is slow to understand and needs a great effort in learning.', '2020-09-03 14:49:30', 2, 0, 1, NULL, 0, 0, 0, 5, 35),
(80, 'I Have Depression. What can i do?', '2020-09-03 23:25:21', 0, 0, 3, 38, 0, 0, 0, 0, 43);

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
(33, 32, 4),
(33, 32, 4),
(33, 32, 5),
(33, 32, 5),
(33, 32, 2),
(33, 32, 5),
(33, 32, 5),
(33, 32, 4),
(33, 32, 5),
(33, 32, 4),
(33, 32, 1),
(33, 32, 1),
(33, 32, 1),
(33, 32, 1),
(33, 32, 1),
(33, 32, 1),
(38, 33, 3),
(38, 33, 3),
(37, 33, 5),
(37, 33, 5);

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
(11, 22, 'like'),
(23, 29, 'like'),
(32, 47, 'like'),
(32, 64, 'like'),
(32, 65, 'like'),
(32, 68, 'like'),
(32, 70, 'like'),
(32, 71, 'like'),
(32, 74, 'like'),
(32, 78, 'like'),
(33, 47, 'like'),
(33, 49, 'like'),
(35, 50, 'like'),
(37, 64, 'like'),
(37, 65, 'like'),
(37, 67, 'like'),
(37, 68, 'like'),
(37, 72, 'like'),
(37, 73, 'like'),
(37, 76, 'like'),
(37, 78, 'like'),
(43, 75, 'like');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `f_name` text DEFAULT NULL,
  `l_name` text DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `user_name` text DEFAULT NULL,
  `describe_user` varchar(255) DEFAULT NULL,
  `user_pass` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_country` text DEFAULT NULL,
  `user_gender` text DEFAULT NULL,
  `user_birthday` text DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_cover` varchar(255) DEFAULT NULL,
  `user_reg_date` timestamp NULL DEFAULT current_timestamp(),
  `posts` text DEFAULT NULL,
  `recovery_account` varchar(255) DEFAULT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `CV` varchar(255) DEFAULT NULL,
  `Approved` int(11) DEFAULT NULL,
  `Blocked` int(11) DEFAULT 0,
  `Reports` int(11) DEFAULT 0,
  `nComments` int(11) NOT NULL COMMENT 'Number of Comments',
  `nRating` int(11) NOT NULL COMMENT 'Total of rating',
  `private_chat` int(255) DEFAULT NULL,
  `credit_card` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `f_name`, `l_name`, `phone`, `address`, `user_name`, `describe_user`, `user_pass`, `user_email`, `user_country`, `user_gender`, `user_birthday`, `user_image`, `user_cover`, `user_reg_date`, `posts`, `recovery_account`, `GroupID`, `CV`, `Approved`, `Blocked`, `Reports`, `nComments`, `nRating`, `private_chat`, `credit_card`) VALUES
(15, 'Admin', 'Admin', NULL, NULL, 'Admin', '', '123', 'admin@gmail.com', '', '', '', '', '', '2020-05-08 02:01:34', '', '', 1, '', 1, 0, 0, 0, 0, NULL, NULL),
(32, 'Ahmed', 'Saleh', '01120719014', NULL, 'Ahmed Saleh', 'Hello!! This is my default status', '123', 'ahmed@gmail.com', 'Egypt', 'Male', '2000-08-26', 'user1.png.38', 'default_cover.jpg', '2020-07-18 14:58:01', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 3, NULL, 1, 0, 0, 0, 0, NULL, NULL),
(33, 'Islam', 'Ashraf', '01120719014', '12St Octobar', 'Islam Ashraf', 'Hello!! This is my default status', '123', 'Islam@gmail.com', 'Egypt', 'Male', '2000-06-02', '455-4554869_doctor-with-stethoscope-png-png-download-doctor-images.png.43', 'Cover1.png.jpg.38', '2020-07-18 16:01:02', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, '752_Ahmed CV.pdf', 1, 0, 0, 0, 0, NULL, NULL),
(34, 'Mohamed', 'Salem', '01122222222', '20st Octobar', 'Mohamed Salem', 'Hello!! This is my default status', '123', 'Mohamed@gmail.com', 'Egypt', 'Male', '2020-07-23', '515-5158817_telemedicine-doctor-hd-png-download.png.18', '368845.jpg.98', '2020-07-18 17:20:45', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, '752_Ahmed CV.pdf', 1, 0, 0, 1, 1, NULL, NULL),
(35, 'Sam', 'Ahmed', '01120719014', '6 Octobar', 'Sam Ahmed', 'Hello!! This is my default status', '123', 'Sam@gmail.com', 'Egypt', 'Female', '2020-07-07', 'young-executive-woman-profile-icon-vector-9692601.jpg.98', 'default_cover.jpg', '2020-07-18 17:24:09', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 3, NULL, 1, 0, 0, 0, 0, NULL, NULL),
(36, 'Steve ', 'Thomas', '01122222222', '6 Octobar', 'Steve  Thomas', 'Hello!! This is my default status', '123', 'Steve@gmail.com', 'Egypt', 'Male', '2020-07-15', '2.jpg.49', '2.jpg.1', '2020-07-23 15:14:54', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, '752_Ahmed CV.pdf', 1, 0, 0, 3, 6, NULL, NULL),
(37, 'Malisia ', 'Gorge', '01122222222', '12St Octobar', 'Malisia  Gorge', 'Hello!! This is my default status', '123', 'Malisia@gmail.com', 'Egypt', 'Female', '2020-07-15', 'beautiful-young-female-doctor-looking-camera-office_1301-7807.jpg.82', 'image-asset.jpeg.53', '2020-07-23 15:15:51', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, '752_Ahmed CV.pdf', 1, 0, 0, 2, 3, 1, 123),
(38, 'Mark ', 'Enim', '0112048520', '6 Octobar', 'Mark  Enim', 'Hello!! This is my default status', '123', 'Mark@gmail.com', 'United States of America', 'Male', '2020-07-21', 'images.PNG.93', 'unnamed.jpg.76', '2020-07-23 15:20:47', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, '103_Ahmed CV.pdf', 1, 0, 0, 0, 0, 1, 123),
(39, 'Tamem', 'Ahmed', NULL, NULL, 'Tamem Ahmed', 'Hello!! This is my default status', '123', 'Tamem@gmail.com', 'Egypt', 'Male', '2020-07-15', 'businessman-avatar-cartoon-vector-17729423.jpg.58', 'default_cover.jpg', '2020-07-23 15:21:51', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 3, NULL, 1, 0, 0, 0, 0, NULL, NULL),
(40, 'Salma', 'Thomas', NULL, NULL, 'Salma Thomas', 'Hello!! This is my default status', '123', 'Salma@gmail.com', 'Egypt', 'Female', '2020-07-06', 'young-executive-woman-profile-icon-vector-9692593.jpg.77', 'default_cover.jpg', '2020-07-23 15:22:32', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 3, '103_Ahmed CV.pdf', 1, 0, 0, 0, 0, NULL, NULL),
(42, 'Mostafa', 'Mohamed', '01016194020', '6 October', 'Mostafa Mohamed', 'Hello!! This is my default status', '123', 'Mostafa@gmail.com', 'Egypt', 'Male', '2020-07-06', '515-5158817_telemedicine-doctor-hd-png-download.png.18', 'default_cover.jpg', '2020-09-02 15:19:18', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 2, '103_Ahmed CV.pdf', NULL, 0, 0, 0, 0, NULL, NULL),
(43, 'Mohand', 'Ahmed', NULL, NULL, 'mohand ahmed- 764', 'Hello!! This is my default status', '12345678', 'Mohand@gmail.com', 'Egypt', 'Male', '2020-09-18', 'default.png', 'default_cover.jpg', '2020-09-03 23:21:36', 'yes', 'ifyouaregootatsomethingdontdoitforfree45566677888', 3, NULL, 1, 0, 0, 0, 0, 1, 12315);

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
-- Indexes for table `connectus`
--
ALTER TABLE `connectus`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `docrate`
--
ALTER TABLE `docrate`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `docid` (`Doc_ID`),
  ADD KEY `userid` (`User_ID`);

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `coming_private_chat`
--
ALTER TABLE `coming_private_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `connectus`
--
ALTER TABLE `connectus`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `docrate`
--
ALTER TABLE `docrate`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
  MODIFY `folder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `pctt`
--
ALTER TABLE `pctt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=546;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `private_chat`
--
ALTER TABLE `private_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
-- Constraints for table `docrate`
--
ALTER TABLE `docrate`
  ADD CONSTRAINT `docid` FOREIGN KEY (`Doc_ID`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userid` FOREIGN KEY (`User_ID`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

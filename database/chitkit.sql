-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 01:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chitkit`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `post_id`, `user_id`, `user_name`, `date`) VALUES
(1, 'Great', 27, 8, 'Henry', '2024-06-03 22:40:21'),
(2, 'Nice post', 27, 8, 'Henry', '2024-06-03 22:43:32'),
(3, 'Very true', 26, 8, 'Henry', '2024-06-03 22:46:01'),
(4, 'So beautiful', 1, 8, 'Henry', '2024-06-03 22:46:54'),
(9, 'Nice video', 31, 9, 'Jerry', '2024-06-06 16:19:20');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `user_id`, `follower_id`) VALUES
(5, 5, 8),
(7, 5, 9),
(11, 6, 7),
(13, 6, 8),
(12, 6, 10),
(9, 7, 5),
(6, 7, 8),
(10, 7, 10),
(8, 8, 9),
(14, 9, 8);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`) VALUES
(10, 3, 10),
(11, 4, 10),
(183, 15, 7),
(182, 16, 7),
(7, 26, 8),
(9, 26, 10),
(178, 27, 9),
(12, 28, 8),
(8, 28, 10),
(181, 31, 7),
(176, 31, 8),
(177, 31, 9),
(180, 36, 7),
(184, 36, 9),
(186, 37, 8),
(185, 37, 9);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `sender_id`, `receiver_id`, `date`) VALUES
(24, 'Hi', 8, 6, '2024-06-06 01:57:21'),
(25, 'Hello', 8, 6, '2024-06-06 02:00:07'),
(26, 'Hi', 8, 7, '2024-06-06 14:34:22'),
(27, 'Hello', 7, 8, '2024-06-06 14:34:40'),
(28, 'Who are you', 7, 8, '2024-06-06 14:34:47'),
(29, 'this is a test message', 8, 7, '2024-06-06 14:34:56'),
(30, 'Who are you talking to', 6, 8, '2024-06-06 14:35:28'),
(31, 'Are you online', 6, 8, '2024-06-06 14:38:23'),
(32, 'what are you doing', 6, 8, '2024-06-06 14:38:42');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `refrence_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `heading` varchar(300) NOT NULL,
  `content` text NOT NULL,
  `file_json_array` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`file_json_array`)),
  `user_id` int(11) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `heading`, `content`, `file_json_array`, `user_id`, `post_date`) VALUES
(1, 'Exploring the Hidden Gems of Tranquil Valley', 'Nestled amidst rolling hills and verdant landscapes lies Tranquil Valley, a serene haven that captivates the soul with its untouched beauty.', '[\"uploads/posts/7-665c52bd83cf20.23041421.jpg\"]', 7, '2024-06-02 22:08:10'),
(3, '', '', '[\"uploads/posts/7-665c54af73d3d5.69257717.jpg\"]', 7, '2024-06-02 22:08:10'),
(4, 'Discovering Hidden Gems', 'In a world of conformity, your uniqueness is your superpower. Embrace every quirk, every flaw, and every extraordinary part of you.', '[\"uploads/posts/7-665c557861c043.32456877.jpg\",\"uploads/posts/7-665c557861dae1.03832666.jpg\",\"uploads/posts/7-665c557861ed51.69727448.jpg\"]', 7, '2024-06-02 22:08:10'),
(5, '', '', '[\"uploads/posts/7-665c55b34c3470.17519643.jpg\"]', 7, '2024-06-02 22:08:10'),
(6, 'Discover the Serenity of Coastal Escapes', 'Escape the hustle and bustle of everyday life and embark on a journey to the tranquil shores of coastal getaways. With pristine beaches, breathtaking sunsets, and the soothing sound of waves, immerse yourself in a world of relaxation and rejuvenation.', '[]', 7, '2024-06-02 22:08:10'),
(7, 'Journey to the Heart of Kyoto: A Glimpse into Japan\'s Cultural Heritage', 'The serene landscapes of Japan, Kyoto stands as a testament to the country\'s rich cultural tapestry. With its tranquil temples, lush gardens, and timeless traditions, this ancient city offers a glimpse into Japan\'s storied past.', '[]', 7, '2024-06-02 22:08:10'),
(11, 'Dream It, See It: AI Art Generation Takes Off', 'AI image generators are turning words into stunning visuals. Simply describe your concept, and the AI creates a unique image, from photorealistic landscapes to fantastical creatures.', '[\"uploads\\/posts\\/8-665c9f3b9a3d34.50098048.jpg\",\"uploads\\/posts\\/8-665c9f3b9a52b8.54978060.jpg\",\"uploads\\/posts\\/8-665c9f3b9a6074.82402101.jpg\"]', 8, '2024-06-02 22:08:10'),
(12, '', '', '[\"uploads\\/posts\\/8-665c9f704ca652.27229356.jpg\"]', 8, '2024-06-02 22:08:10'),
(13, 'Coffee brewing, notes open, mind focused.   Crushing this study session!  Who\'s with me?  #studygram #motivated #examscoming', '', '[\"uploads\\/posts\\/8-665c9fa94d6598.61486597.jpg\"]', 8, '2024-06-02 22:08:10'),
(15, 'My AI version 😊', '', '[\"uploads\\/posts\\/9-665ca1282a1401.85043559.jpg\"]', 9, '2024-06-02 22:13:20'),
(16, 'The Quick Brown Fox Jumps Over the Lazy Dog', 'This is a classic example of a pangram, a sentence containing every letter of the alphabet. But why &quot;the quick brown fox jumps over the lazy dog&quot;?  The exact origin is debated, but some theories suggest it was used for testing typewriters and keyboards.', '[]', 5, '2024-06-02 22:32:12'),
(26, 'Reflections on Old Age', 'Old age is a phase of life often overlooked in the rush of modernity. Yet, it holds a quiet beauty, a depth of experience unmatched by any other stage. In its silence, old age speaks volumes, whispering tales of a lifetime lived.', '[]', 10, '2024-06-02 22:43:41'),
(27, '', 'The wrinkles etched upon weathered skin are not marks of decline but badges of honor, earned through years of laughter and tears. Each line tells a story, a chapter in the book of a person\'s journey.', '[\"uploads\\/posts\\/10-665ca866156aa2.05480102.jpg\"]', 10, '2024-06-02 22:44:14'),
(31, '', '', '[\"uploads\\/posts\\/8-666193bfe4c152.27915583.mp4\",\"uploads\\/posts\\/8-666193bfe4d950.81233222.mp4\"]', 8, '2024-06-06 16:17:27'),
(36, '', '', '[\"uploads\\/posts\\/7-666197f832d964.26526646.png\",\"uploads\\/posts\\/7-666197f832efc1.50396633.mp4\"]', 7, '2024-06-06 16:35:28'),
(37, '', '', '[\"uploads\\/posts\\/9-666198e8202ca0.03545139.png\"]', 9, '2024-06-06 16:39:28');

-- --------------------------------------------------------

--
-- Table structure for table `recents`
--

CREATE TABLE `recents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recent_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recents`
--

INSERT INTO `recents` (`id`, `user_id`, `recent_user_id`) VALUES
(14, 6, 7),
(15, 6, 8),
(16, 7, 8),
(11, 8, 6),
(9, 8, 7),
(4, 8, 9),
(7, 8, 10),
(13, 9, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `profile_picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `about`, `profile_picture`) VALUES
(5, 'test', 'test@gmail.com', '$2y$10$o4jvYlhqb0glLPbuJO8Ehem/JGlpQ4Bss92VvzZMZbBFA9nkte6Nm', 'this is test about', 'uploads/profile/5-665ca56913fb86.12184911.jpg'),
(6, 'Arif', 'arif@gmail.com', '$2y$10$qfNeVjJH59r6YtuzCRHKHuv4DUHfqheDxMzzvY2lw6DKJa7ecC5TC', 'Developer of chitkit.\r\nWebsite: https://arifpirxada.netlify.app/', ''),
(7, 'Justine', 'justine@gmail.com', '$2y$10$pOlppwnsK4DIk9uIaAmdXutCk36t7pYZ6xMD8OY0Un9kPJbfJqEOO', 'Not all who wander are wanderful!', 'uploads/profile/7-665c4d52eaddb7.97001894.jpg'),
(8, 'Henry', 'henry@gmail.com', '$2y$10$zfWfdWxkYL6trZ62v2w85.dJty8X0A1PlNj8uSHZkKNGsFqDFxR5K', 'Exploring the world now a days!', 'uploads/profile/8-665c9cc3bd6be5.60399648.jpg'),
(9, 'Jerry', 'jerry@gmail.com', '$2y$10$xcZ8nK0bYF2Oo0nhJ14rFeGW38hEaSi35Dl3D1ounQkoLokrFBbY2', 'Life is better with life again and again', 'uploads/profile/9-665ca48672a077.09061530.jpg'),
(10, 'Walter', 'walter@gmail.com', '$2y$10$Jggm7X6.K5AxSwSKy5X8CuNRA5dLxGOCJr9LT18KHyRvQaA1W0jo2', 'Life is and was full of randomness', 'uploads/profile/10-665ca7ced1b592.59807737.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `user_id` (`user_id`,`follower_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `posts` ADD FULLTEXT KEY `Search index` (`heading`,`content`);

--
-- Indexes for table `recents`
--
ALTER TABLE `recents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`recent_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `recents`
--
ALTER TABLE `recents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

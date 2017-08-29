-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2017 at 02:30 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evangeliko`
--

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_account`
--

CREATE TABLE `evangeliko_account` (
  `id` int(11) NOT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `first_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `landline_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interests` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `date_create` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_account`
--

INSERT INTO `evangeliko_account` (`id`, `user_create_id`, `first_name`, `last_name`, `email`, `mobile_no`, `landline_no`, `about`, `interests`, `date_create`, `enabled`) VALUES
(1, 1, 'Karlo', 'Laquian', 'karlo@laquian.com', NULL, NULL, NULL, '[\"Cars\",\"Finance\",\"Lifestyle\",\"Travel and Leisure\"]', '2017-07-16 14:23:53', 1),
(2, 1, 'Ashley', 'Co Kehyeng', 'tim@yap.com', NULL, NULL, NULL, '[\"Lifestyle\",\"Travel and Leisure\",\"Finance\"]', '2017-07-16 15:25:20', 1),
(3, 1, 'Rommel', 'Pascual', 'rommel@pascual.com', NULL, NULL, NULL, '[\"Cars\",\"Finance\",\"Travel and Leisure\"]', '2017-07-16 19:29:52', 1),
(4, 1, 'Karlo', 'Laquian', 'karlo2@laquian.com', NULL, NULL, NULL, '[\"Lifestyle\",\"Finance\"]', '2017-08-29 12:14:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_account_credit`
--

CREATE TABLE `evangeliko_account_credit` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_account_credit`
--

INSERT INTO `evangeliko_account_credit` (`id`, `account_id`, `user_create_id`, `amount`, `date_create`) VALUES
(1, 1, 1, '900.00', '2017-07-16 14:23:53'),
(2, 2, 1, '900.00', '2017-07-16 15:25:20'),
(3, 3, 1, '0.00', '2017-07-16 19:29:52'),
(4, 4, 1, '0.00', '2017-08-29 12:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_account_credit_history`
--

CREATE TABLE `evangeliko_account_credit_history` (
  `id` int(11) NOT NULL,
  `credit_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_account_credit_history`
--

INSERT INTO `evangeliko_account_credit_history` (`id`, `credit_id`, `user_create_id`, `amount`, `date_create`) VALUES
(1, 1, 2, '1000.00', '2017-07-16 14:51:29'),
(2, 2, 3, '500.00', '2017-07-16 16:56:22'),
(3, 2, 3, '500.00', '2017-07-16 16:59:16'),
(4, 2, 3, '1000.00', '2017-07-16 17:22:28'),
(5, 2, 3, '1000.00', '2017-07-16 17:26:25'),
(6, 1, 2, '1000.00', '2017-07-16 19:05:35'),
(7, 1, 2, '500.00', '2017-07-16 19:06:26'),
(8, 1, 2, '500.00', '2017-07-16 19:07:29');

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_account_interest`
--

CREATE TABLE `evangeliko_account_interest` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `interest_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_account_interest`
--

INSERT INTO `evangeliko_account_interest` (`id`, `account_id`, `interest_id`, `user_create_id`, `date_create`) VALUES
(1, 1, 2, 1, '2017-07-16 14:23:53'),
(2, 1, 5, 1, '2017-07-16 14:23:53'),
(3, 2, 2, 1, '2017-07-16 15:25:20'),
(4, 2, 5, 1, '2017-07-16 15:25:20'),
(5, 3, 1, 1, '2017-07-16 19:29:52'),
(6, 3, 3, 1, '2017-07-16 19:29:52'),
(7, 3, 5, 1, '2017-07-16 19:29:52'),
(8, 4, 2, 1, '2017-08-29 12:14:06'),
(9, 4, 3, 1, '2017-08-29 12:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_community`
--

CREATE TABLE `evangeliko_community` (
  `id` int(11) NOT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `interests` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `date_create` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_community`
--

INSERT INTO `evangeliko_community` (`id`, `user_create_id`, `slug`, `type`, `description`, `interests`, `date_create`, `enabled`, `name`) VALUES
(1, 2, 'mountain-trekking', 'Public', 'All about mountain trekking', '[\"Lifestyle\",\"Travel and Leisure\"]', '2017-07-16 14:56:54', 1, 'Mountain Trekking'),
(2, 3, 'food-parks', 'Private', 'Reviews of Food Parks', '[\"Lifestyle\",\"Food\"]', '2017-07-16 17:57:36', 1, 'Food Parks'),
(3, 3, 'mutual-funds', 'Private', 'Basics of Mutual Funds', '[\"Finance\"]', '2017-07-16 19:01:04', 1, 'Mutual Funds 101'),
(4, 2, 'car-maintenance', 'Private', 'Car Maintenance', '[\"Cars\",\"Travel and Leisure\"]', '2017-07-16 20:08:32', 1, 'Car Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_community_followers`
--

CREATE TABLE `evangeliko_community_followers` (
  `id` int(11) NOT NULL,
  `community_id` int(11) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `status` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_community_followers`
--

INSERT INTO `evangeliko_community_followers` (`id`, `community_id`, `follower_id`, `user_create_id`, `status`, `date_create`, `enabled`) VALUES
(1, 1, 1, NULL, 'Followed', '2017-07-16 14:56:54', 1),
(2, 1, 2, NULL, 'Followed', '2017-07-16 15:26:56', 1),
(3, 2, 2, NULL, 'Followed', '2017-07-16 17:57:36', 1),
(4, 2, 1, NULL, 'Followed', '2017-07-16 18:20:57', 1),
(5, 3, 2, NULL, 'Followed', '2017-07-16 19:01:04', 1),
(6, 3, 1, NULL, 'Followed', '2017-07-16 19:02:26', 1),
(8, 1, 3, NULL, 'Followed', '2017-07-16 19:39:07', 1),
(9, 3, 3, NULL, 'Followed', '2017-07-16 19:56:57', 1),
(10, 4, 1, NULL, 'Followed', '2017-07-16 20:08:32', 1),
(11, 4, 3, NULL, 'Pending', '2017-07-16 20:09:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_community_interest`
--

CREATE TABLE `evangeliko_community_interest` (
  `id` int(11) NOT NULL,
  `community_id` int(11) DEFAULT NULL,
  `interest_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_community_interest`
--

INSERT INTO `evangeliko_community_interest` (`id`, `community_id`, `interest_id`, `user_create_id`, `date_create`) VALUES
(1, 1, 2, 2, '2017-07-16 14:56:54'),
(2, 1, 5, 2, '2017-07-16 14:56:54'),
(3, 2, 2, 3, '2017-07-16 17:57:36'),
(4, 2, 4, 3, '2017-07-16 17:57:36'),
(5, 3, 3, 3, '2017-07-16 19:01:04'),
(6, 4, 1, 2, '2017-07-16 20:08:32'),
(7, 4, 5, 2, '2017-07-16 20:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_community_type`
--

CREATE TABLE `evangeliko_community_type` (
  `id` int(11) NOT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_community_type`
--

INSERT INTO `evangeliko_community_type` (`id`, `user_create_id`, `date_create`, `name`) VALUES
(1, 1, '2017-07-16 12:58:54', 'Public'),
(2, 1, '2017-07-16 12:58:54', 'Private');

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_credit_amount`
--

CREATE TABLE `evangeliko_credit_amount` (
  `id` int(11) NOT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_credit_amount`
--

INSERT INTO `evangeliko_credit_amount` (`id`, `user_create_id`, `date_create`, `price`) VALUES
(1, 1, '2017-07-16 12:58:54', '100.00'),
(2, 1, '2017-07-16 12:58:54', '500.00'),
(3, 1, '2017-07-16 12:58:54', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_friendship`
--

CREATE TABLE `evangeliko_friendship` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `friend_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_interest`
--

CREATE TABLE `evangeliko_interest` (
  `id` int(11) NOT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_interest`
--

INSERT INTO `evangeliko_interest` (`id`, `user_create_id`, `date_create`, `name`) VALUES
(1, 1, '2017-07-16 12:58:54', 'Cars'),
(2, 1, '2017-07-16 12:58:54', 'Lifestyle'),
(3, 1, '2017-07-16 12:58:54', 'Finance'),
(4, 1, '2017-07-16 12:58:54', 'Food'),
(5, 1, '2017-07-16 12:58:54', 'Travel and Leisure');

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_notifications`
--

CREATE TABLE `evangeliko_notifications` (
  `id` int(11) NOT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_notifications`
--

INSERT INTO `evangeliko_notifications` (`id`, `recipient_id`, `user_create_id`, `message`, `date_create`, `enabled`) VALUES
(2, 1, NULL, 'Rommel Pascual followed Mountain Trekking hive', '2017-07-16 19:39:07', 1),
(3, 3, NULL, 'You followed Mountain Trekking hive', '2017-07-16 19:39:07', 1),
(4, 2, NULL, 'Rommel Pascual wants to follow Mutual Funds 101 hive', '2017-07-16 19:56:57', 1),
(5, 3, NULL, 'You are now following Mutual Funds 101 hive.', '2017-07-16 20:02:39', 1),
(6, 3, NULL, 'Karlo Laquian recommended Car Maintenance hive.', '2017-07-16 20:09:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_posts`
--

CREATE TABLE `evangeliko_posts` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `community_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `post_message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `order_number` int(11) DEFAULT NULL,
  `post_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `post_title` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_posts`
--

INSERT INTO `evangeliko_posts` (`id`, `parent_id`, `community_id`, `account_id`, `user_create_id`, `post_message`, `order_number`, `post_type`, `amount`, `date_create`, `post_title`) VALUES
(1, NULL, 1, NULL, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eleifend tortor eget neque dictum ornare. Quisque pulvinar vestibulum lorem, at eleifend risus. Donec venenatis ornare sapien nec ullamcorper. Proin urna mi, fringilla nec leo ac, consectetur fringilla lectus. Maecenas ut iaculis erat. Vestibulum lacinia massa eget nisi facilisis, et feugiat odio porttitor. In facilisis risus eget augue accumsan, vitae facilisis nibh consequat. Donec ut augue auctor, ultrices enim aliquet, lacinia magna. Cras turpis turpis, sodales vestibulum magna at, rutrum imperdiet lorem. Donec vehicula nulla ut ex tincidunt mollis. Quisque sed turpis viverra, maximus orci at, sollicitudin sapien. Phasellus et orci ac ex ultricies euismod. Donec ac erat sit amet orci eleifend tristique.', NULL, 'Paid', '100.00', '2017-07-16 15:09:46', 'Welcome!'),
(2, NULL, 1, NULL, 2, 'This is a sample post', NULL, 'Free', '0.00', '2017-07-16 16:36:09', 'Sample Post'),
(3, 1, NULL, NULL, 3, 'This is a sample reply', NULL, 'free', '0.00', '2017-07-16 17:54:27', 'Welcome!'),
(4, NULL, 3, NULL, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc semper ut justo et malesuada. Praesent commodo purus ac dignissim ornare. Aenean nec libero condimentum, luctus ante a, feugiat erat. Nulla fermentum sagittis lacinia. Suspendisse potenti. Donec ac efficitur felis. In id dignissim ex. Curabitur lacinia neque nec neque tincidunt interdum. Mauris eget felis ex. ', NULL, 'Paid', '100.00', '2017-07-16 19:05:20', 'Welcome to Mutual Funds 101'),
(5, NULL, 3, NULL, 3, 'This is a sample post', NULL, 'Paid', '100.00', '2017-07-16 19:09:04', 'Sample Post');

-- --------------------------------------------------------

--
-- Table structure for table `evangeliko_post_type`
--

CREATE TABLE `evangeliko_post_type` (
  `id` int(11) NOT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evangeliko_post_type`
--

INSERT INTO `evangeliko_post_type` (`id`, `user_create_id`, `date_create`, `name`) VALUES
(1, 1, '2017-07-16 12:58:54', 'Free'),
(2, 1, '2017-07-16 12:58:54', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_access_tokens`
--

CREATE TABLE `oauth2_access_tokens` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_access_tokens`
--

INSERT INTO `oauth2_access_tokens` (`id`, `client_id`, `user_id`, `token`, `expires_at`, `scope`) VALUES
(1, 2, 5, 'MTA2OGJiODc2YzBiMTkzNDhkNTE2NWVmZmExNTNlMTFlMzU1Mzk1MGNiOTE0MTlmNmU1Yzk0YThjYzAyNmI4Ng', 1502839172, NULL),
(2, 3, 6, 'NWE4MzRhMTRiODUyMTY2YmQxMTdmNzM1MTVmN2QwZDRhYWJiNmE1YTEwNjQ3ZGNmZDI2MWI4MjA2NWY3ZDk4Zg', 1503519365, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_auth_codes`
--

CREATE TABLE `oauth2_auth_codes` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` longtext COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_clients`
--

CREATE TABLE `oauth2_clients` (
  `id` int(11) NOT NULL,
  `random_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uris` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allowed_grant_types` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_clients`
--

INSERT INTO `oauth2_clients` (`id`, `random_id`, `redirect_uris`, `secret`, `allowed_grant_types`) VALUES
(1, '3xaju6lomx44kw4800c8s8w4o0csc88kc8cwgksg8osow04g88', 'a:0:{}', '37duloqa2hmo4ckgcc80co80k8ccccw00goccwos0ws8c08k84', 'a:1:{i:0;s:8:\"password\";}'),
(2, '2op8ymt9nkcg4g8wkccws4g4w4k8g0sg8ss0k4okwgks44s000', 'a:0:{}', '9exzjovqhsg8040ogwgo0ws88os80kwscgs8gw4ooo00cwso0', 'a:1:{i:0;s:8:\"password\";}'),
(3, 'nm2sofmb8mosgccs0kwgco0cck0k84c0kw4g8cskok4cwcs8k', 'a:0:{}', '29q0og2wpllw8kgk4occ408sgskkwkkw840gkkksgocw0wwg88', 'a:1:{i:0;s:8:\"password\";}');

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_refresh_tokens`
--

CREATE TABLE `oauth2_refresh_tokens` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_refresh_tokens`
--

INSERT INTO `oauth2_refresh_tokens` (`id`, `client_id`, `user_id`, `token`, `expires_at`, `scope`) VALUES
(1, 2, 5, 'ZTA5ZWI4NjVlNTdiNjgwNDcyYzliNjgyODdmMTM2ZjNhN2JkZDI0ODU1MDkzN2U0NjgyMWE4MTZkZGI0NWNiNw', 1504012773, NULL),
(2, 3, 6, 'ZTQ0ZTYxNzBjOTYwNmQwOGFlYTFiNzkzOGRhMjBkMzE4MTM2YzcyNzMxYzZjMzYwM2ExMTcyMzRmMWZiODQ1OA', 1504692965, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_user`
--

CREATE TABLE `user_user` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_user`
--

INSERT INTO `user_user` (`id`, `account_id`, `username`, `username_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `name`, `email`, `email_canonical`) VALUES
(1, NULL, 'admin', 'admin', 1, '3UVeOVEuMdtjiEwB35cxw0xuLAzEz6G447V5K.bLFxU', 'gwkhsWAvnjY3ToBCBZGXhQ0ejBjR5Mr3ec66t/76vG993IPwqlFj2MNOWV+FsY8c1cW8F2QBSmoVRcR4iuN20A==', NULL, NULL, NULL, 'a:0:{}', 'Administrator', 'test@test.com', 'test@test.com'),
(2, 1, 'karlo@laquian.com', 'karlo@laquian.com', 1, 'eRdFRUMHHuJDQtv8j3AMtPY3fT2RnFuESYZbsCktWLg', 'U+vYV9M84osDBnTGUeSzvmGyaAu9udj7iqMnUkCn+t1bHHFlyQ6SVDl+8OJh6RPw1NN3uP42yy6kZZDP1pdnTg==', '2017-08-29 12:51:22', NULL, NULL, 'a:0:{}', 'Karlo Laquian', 'karlo@laquian.com', 'karlo@laquian.com'),
(3, 2, 'tim@yap.com', 'tim@yap.com', 1, '6giXDKFca3n5d15Qcb1TDx7.KDdxp60SRNEPtH5ua1w', 'xUZfKd6+xT4920n394c858DOE7gdWT3tvdIsEKnYtfONvIg89TIgnW6hJhIVsPUygb3l708Pg59tdgfE8sCbhA==', '2017-07-16 19:56:43', NULL, NULL, 'a:0:{}', 'Ashley Co Kehyeng', 'tim@yap.com', 'tim@yap.com'),
(4, 3, 'rommel@pascual.com', 'rommel@pascual.com', 1, 'WPRsVoK3dM9SEGQjekmoVMP77FfNVdh/mFLR2GPZpxQ', 'kThxJP4FgTimH8D2w0jq5czmd271Ser6DmzyCpT6VbRBezSt9gHwI1yA0c/+4qIGrM22kUyrhol4oJJUOOUGzA==', '2017-07-16 19:30:00', NULL, NULL, 'a:0:{}', 'Rommel Pascual', 'rommel@pascual.com', 'rommel@pascual.com'),
(5, NULL, 'karlo', 'karlo', 1, 'G30E/n7uegtpp5Y0sXY/Opd0/mWBmnrFjF8Yz/mLDDQ', 'R2kh5gQdV74Smod3LeihJfdc4cahC9w/ou1vsdzj4vrIaXdczsBGD3CqzT0Xnc/CE7SY2OdH8nawpgyqArCZgw==', NULL, NULL, NULL, 'a:0:{}', NULL, 'karlo@test.com', 'karlo@test.com'),
(6, NULL, 'karlo3', 'karlo3', 1, 'AHC7yG9Sdsts2saqFjUVo7JwbV13zTT/bL2oJK1EEOM', 'zPco+SrL4dQft0z04Z6XNYBZDpA3SoOrCVZPLf1WxvAak6npj7m3KcJP5XeMlKib0RD9UCVYaEOdEWkLiX4nOw==', NULL, NULL, NULL, 'a:0:{}', NULL, 'karlo3@test.com', 'karlo3@test.com'),
(7, 4, 'karlo2@laquian.com', 'karlo2@laquian.com', 1, 'Le27Yy5vO4KQLgY7AE.mGlI4TXqFJOnXZg.Mjf23al0', 'qoaN/ZITFWmUOqODyljpBfQHaEv0u34LlW0LQ0S3X3UGpQW/nQGUe9Eg20TK6i+YziVAKwrZIJX8yR4dOCDEKA==', '2017-08-29 12:16:31', NULL, NULL, 'a:0:{}', 'Karlo Laquian', 'karlo2@laquian.com', 'karlo2@laquian.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evangeliko_account`
--
ALTER TABLE `evangeliko_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A54242D3EEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_account_credit`
--
ALTER TABLE `evangeliko_account_credit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_65CFD9DC9B6B5FBA` (`account_id`),
  ADD KEY `IDX_65CFD9DCEEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_account_credit_history`
--
ALTER TABLE `evangeliko_account_credit_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8D77E0AFCE062FF9` (`credit_id`),
  ADD KEY `IDX_8D77E0AFEEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_account_interest`
--
ALTER TABLE `evangeliko_account_interest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9E8903669B6B5FBA` (`account_id`),
  ADD KEY `IDX_9E8903665A95FF89` (`interest_id`),
  ADD KEY `IDX_9E890366EEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_community`
--
ALTER TABLE `evangeliko_community`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_61C4A30BEEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_community_followers`
--
ALTER TABLE `evangeliko_community_followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3F7017F8FDA7B0BF` (`community_id`),
  ADD KEY `IDX_3F7017F8AC24F853` (`follower_id`),
  ADD KEY `IDX_3F7017F8EEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_community_interest`
--
ALTER TABLE `evangeliko_community_interest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F9346D2FDA7B0BF` (`community_id`),
  ADD KEY `IDX_1F9346D25A95FF89` (`interest_id`),
  ADD KEY `IDX_1F9346D2EEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_community_type`
--
ALTER TABLE `evangeliko_community_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_13B5C4B2EEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_credit_amount`
--
ALTER TABLE `evangeliko_credit_amount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5B17CE5BEEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_friendship`
--
ALTER TABLE `evangeliko_friendship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A4CB8229B6B5FBA` (`account_id`),
  ADD KEY `IDX_5A4CB8226A5458E8` (`friend_id`),
  ADD KEY `IDX_5A4CB822EEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_interest`
--
ALTER TABLE `evangeliko_interest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A2878AECEEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_notifications`
--
ALTER TABLE `evangeliko_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8480EFABE92F8F78` (`recipient_id`),
  ADD KEY `IDX_8480EFABEEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_posts`
--
ALTER TABLE `evangeliko_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6B48B6F3727ACA70` (`parent_id`),
  ADD KEY `IDX_6B48B6F3FDA7B0BF` (`community_id`),
  ADD KEY `IDX_6B48B6F39B6B5FBA` (`account_id`),
  ADD KEY `IDX_6B48B6F3EEFE5067` (`user_create_id`);

--
-- Indexes for table `evangeliko_post_type`
--
ALTER TABLE `evangeliko_post_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3F2FD31AEEFE5067` (`user_create_id`);

--
-- Indexes for table `oauth2_access_tokens`
--
ALTER TABLE `oauth2_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D247A21B5F37A13B` (`token`),
  ADD KEY `IDX_D247A21B19EB6921` (`client_id`),
  ADD KEY `IDX_D247A21BA76ED395` (`user_id`);

--
-- Indexes for table `oauth2_auth_codes`
--
ALTER TABLE `oauth2_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A018A10D5F37A13B` (`token`),
  ADD KEY `IDX_A018A10D19EB6921` (`client_id`),
  ADD KEY `IDX_A018A10DA76ED395` (`user_id`);

--
-- Indexes for table `oauth2_clients`
--
ALTER TABLE `oauth2_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth2_refresh_tokens`
--
ALTER TABLE `oauth2_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D394478C5F37A13B` (`token`),
  ADD KEY `IDX_D394478C19EB6921` (`client_id`),
  ADD KEY `IDX_D394478CA76ED395` (`user_id`);

--
-- Indexes for table `user_user`
--
ALTER TABLE `user_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F7129A8092FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_F7129A80C05FB297` (`confirmation_token`),
  ADD UNIQUE KEY `UNIQ_F7129A809B6B5FBA` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `evangeliko_account`
--
ALTER TABLE `evangeliko_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `evangeliko_account_credit`
--
ALTER TABLE `evangeliko_account_credit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `evangeliko_account_credit_history`
--
ALTER TABLE `evangeliko_account_credit_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `evangeliko_account_interest`
--
ALTER TABLE `evangeliko_account_interest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `evangeliko_community`
--
ALTER TABLE `evangeliko_community`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `evangeliko_community_followers`
--
ALTER TABLE `evangeliko_community_followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `evangeliko_community_interest`
--
ALTER TABLE `evangeliko_community_interest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `evangeliko_community_type`
--
ALTER TABLE `evangeliko_community_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `evangeliko_credit_amount`
--
ALTER TABLE `evangeliko_credit_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `evangeliko_friendship`
--
ALTER TABLE `evangeliko_friendship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `evangeliko_interest`
--
ALTER TABLE `evangeliko_interest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `evangeliko_notifications`
--
ALTER TABLE `evangeliko_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `evangeliko_posts`
--
ALTER TABLE `evangeliko_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `evangeliko_post_type`
--
ALTER TABLE `evangeliko_post_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `oauth2_access_tokens`
--
ALTER TABLE `oauth2_access_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `oauth2_auth_codes`
--
ALTER TABLE `oauth2_auth_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth2_clients`
--
ALTER TABLE `oauth2_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `oauth2_refresh_tokens`
--
ALTER TABLE `oauth2_refresh_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_user`
--
ALTER TABLE `user_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `evangeliko_account`
--
ALTER TABLE `evangeliko_account`
  ADD CONSTRAINT `FK_A54242D3EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_account_credit`
--
ALTER TABLE `evangeliko_account_credit`
  ADD CONSTRAINT `FK_65CFD9DC9B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`),
  ADD CONSTRAINT `FK_65CFD9DCEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_account_credit_history`
--
ALTER TABLE `evangeliko_account_credit_history`
  ADD CONSTRAINT `FK_8D77E0AFCE062FF9` FOREIGN KEY (`credit_id`) REFERENCES `evangeliko_account_credit` (`id`),
  ADD CONSTRAINT `FK_8D77E0AFEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_account_interest`
--
ALTER TABLE `evangeliko_account_interest`
  ADD CONSTRAINT `FK_9E8903665A95FF89` FOREIGN KEY (`interest_id`) REFERENCES `evangeliko_interest` (`id`),
  ADD CONSTRAINT `FK_9E8903669B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`),
  ADD CONSTRAINT `FK_9E890366EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_community`
--
ALTER TABLE `evangeliko_community`
  ADD CONSTRAINT `FK_61C4A30BEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_community_followers`
--
ALTER TABLE `evangeliko_community_followers`
  ADD CONSTRAINT `FK_3F7017F8AC24F853` FOREIGN KEY (`follower_id`) REFERENCES `evangeliko_account` (`id`),
  ADD CONSTRAINT `FK_3F7017F8EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`),
  ADD CONSTRAINT `FK_3F7017F8FDA7B0BF` FOREIGN KEY (`community_id`) REFERENCES `evangeliko_community` (`id`);

--
-- Constraints for table `evangeliko_community_interest`
--
ALTER TABLE `evangeliko_community_interest`
  ADD CONSTRAINT `FK_1F9346D25A95FF89` FOREIGN KEY (`interest_id`) REFERENCES `evangeliko_interest` (`id`),
  ADD CONSTRAINT `FK_1F9346D2EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`),
  ADD CONSTRAINT `FK_1F9346D2FDA7B0BF` FOREIGN KEY (`community_id`) REFERENCES `evangeliko_community` (`id`);

--
-- Constraints for table `evangeliko_community_type`
--
ALTER TABLE `evangeliko_community_type`
  ADD CONSTRAINT `FK_13B5C4B2EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_credit_amount`
--
ALTER TABLE `evangeliko_credit_amount`
  ADD CONSTRAINT `FK_5B17CE5BEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_friendship`
--
ALTER TABLE `evangeliko_friendship`
  ADD CONSTRAINT `FK_5A4CB8226A5458E8` FOREIGN KEY (`friend_id`) REFERENCES `evangeliko_account` (`id`),
  ADD CONSTRAINT `FK_5A4CB8229B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`),
  ADD CONSTRAINT `FK_5A4CB822EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_interest`
--
ALTER TABLE `evangeliko_interest`
  ADD CONSTRAINT `FK_A2878AECEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_notifications`
--
ALTER TABLE `evangeliko_notifications`
  ADD CONSTRAINT `FK_8480EFABE92F8F78` FOREIGN KEY (`recipient_id`) REFERENCES `evangeliko_account` (`id`),
  ADD CONSTRAINT `FK_8480EFABEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `evangeliko_posts`
--
ALTER TABLE `evangeliko_posts`
  ADD CONSTRAINT `FK_6B48B6F3727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `evangeliko_posts` (`id`),
  ADD CONSTRAINT `FK_6B48B6F39B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`),
  ADD CONSTRAINT `FK_6B48B6F3EEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`),
  ADD CONSTRAINT `FK_6B48B6F3FDA7B0BF` FOREIGN KEY (`community_id`) REFERENCES `evangeliko_community` (`id`);

--
-- Constraints for table `evangeliko_post_type`
--
ALTER TABLE `evangeliko_post_type`
  ADD CONSTRAINT `FK_3F2FD31AEEFE5067` FOREIGN KEY (`user_create_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `oauth2_access_tokens`
--
ALTER TABLE `oauth2_access_tokens`
  ADD CONSTRAINT `FK_D247A21B19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
  ADD CONSTRAINT `FK_D247A21BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `oauth2_auth_codes`
--
ALTER TABLE `oauth2_auth_codes`
  ADD CONSTRAINT `FK_A018A10D19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
  ADD CONSTRAINT `FK_A018A10DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `oauth2_refresh_tokens`
--
ALTER TABLE `oauth2_refresh_tokens`
  ADD CONSTRAINT `FK_D394478C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
  ADD CONSTRAINT `FK_D394478CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `user_user`
--
ALTER TABLE `user_user`
  ADD CONSTRAINT `FK_F7129A809B6B5FBA` FOREIGN KEY (`account_id`) REFERENCES `evangeliko_account` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

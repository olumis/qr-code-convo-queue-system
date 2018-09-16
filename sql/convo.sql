-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2018 at 11:15 PM
-- Server version: 10.2.14-MariaDB-log
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `convo`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `faculty` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_no` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `language_id` int(11) NOT NULL,
  `name` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` tinytext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`language_id`, `name`, `country`, `code`, `locale`, `filename`) VALUES
(1, 'Malay', 'Malaysia', 'ms', 'ms-MY', 'ms.php'),
(2, 'English', 'Great Britain', 'en', 'en-GB,en-US', 'en.php');

-- --------------------------------------------------------

--
-- Table structure for table `list_faculty`
--

CREATE TABLE `list_faculty` (
  `faculty_id` int(11) NOT NULL,
  `name` tinytext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `list_faculty`
--

INSERT INTO `list_faculty` (`faculty_id`, `name`) VALUES
(1, 'Engineering'),
(2, 'IT / Computer Sciences'),
(3, 'Business / Management / Finance'),
(4, 'Bioinformatics'),
(5, 'Accounting'),
(6, 'Law'),
(7, 'Creative Multimedia'),
(8, 'Cinematic Art'),
(9, 'Communication');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `page_id` int(11) NOT NULL,
  `page_name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_seourl` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`page_id`, `page_name`, `page_content`, `page_seourl`, `created_at`, `is_active`) VALUES
(1, 'About Us', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum et enim eu molestie. Donec sit amet nisi vel erat placerat sodales molestie vitae est. Praesent rutrum magna aliquam dictum condimentum. Etiam at congue enim, quis auctor enim. Sed tincidunt risus non velit gravida, ut fringilla sem hendrerit. Aenean tincidunt mollis massa ac bibendum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla interdum ut massa vel rhoncus. Nulla mattis ipsum ac vestibulum dapibus. Integer tincidunt sit amet tellus vitae lobortis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc tristique id diam sit amet sollicitudin. Proin varius ante cursus pretium maximus. Sed mi nibh, facilisis ut finibus elementum, laoreet id sapien. Vivamus lacinia diam a ipsum euismod lacinia. Nulla facilisi.</p><p><br></p><p>Morbi auctor lectus feugiat aliquet rhoncus. Duis quis odio bibendum, sodales neque ut, tempor nulla. Morbi nec ultricies ipsum. Pellentesque suscipit nunc quis turpis dapibus, at efficitur erat tincidunt. Etiam egestas neque vitae odio sollicitudin gravida. Vestibulum ut pretium nibh. Ut at risus sit amet quam maximus imperdiet ut a nisi. Sed cursus dui et lorem porttitor, in blandit lectus eleifend.</p><p><br></p><p>Curabitur imperdiet, lacus ac faucibus congue, sem neque elementum lectus, ut volutpat tellus tortor sit amet nibh. Quisque at dignissim purus. Sed non dolor hendrerit, posuere dolor eu, laoreet arcu. Proin turpis neque, lobortis eget nibh at, euismod pellentesque leo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla sed porta nisl. Aliquam erat volutpat. Donec malesuada placerat augue, eu vulputate velit mattis eu. Morbi pharetra turpis vitae libero malesuada, non consequat nunc pretium. Vivamus congue justo et gravida venenatis. Sed dapibus sem et urna venenatis, at tristique ipsum dignissim. Phasellus in efficitur sem. Donec rhoncus sagittis feugiat. Nunc scelerisque risus eu diam varius porta.</p><p><br></p><p>Aliquam vulputate tristique nisi sit amet consequat. Donec dapibus sapien id sem varius, nec accumsan nulla pharetra. Sed egestas vestibulum bibendum. Vivamus massa tellus, sollicitudin ac nibh sit amet, lacinia tempor eros. Sed pellentesque luctus tempor. Pellentesque sed elit lorem. Cras vulputate, nisi tempor viverra laoreet, lacus magna volutpat ipsum, et maximus nibh metus a lorem. Phasellus mattis sodales sem. Aenean consectetur turpis velit, ac interdum orci elementum ut. Quisque viverra ultricies arcu, molestie molestie odio fermentum vestibulum. In scelerisque libero placerat ante mollis malesuada. Suspendisse nisl diam, sollicitudin eget elementum vitae, suscipit vitae neque. Morbi risus justo, convallis eget sapien et, gravida iaculis erat. Vestibulum sed accumsan nisl.</p><p><br></p><p>Pellentesque quis orci elit. Nulla id lacus at ex laoreet vestibulum eu vel nulla. Praesent sit amet turpis condimentum, imperdiet nunc quis, feugiat lorem. Vestibulum malesuada dui nibh, et ullamcorper eros molestie sit amet. Duis euismod iaculis nisl, sed placerat leo. Cras euismod mi ultrices, interdum mauris a, ullamcorper lectus. Phasellus convallis pharetra nibh, at tristique nisl. Donec libero nunc, tincidunt sed imperdiet eu, vestibulum vel orci.</p><div><br></div>', 'about-us', '2018-08-08 19:33:55', 1),
(2, 'Terms and Condition', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum et enim eu molestie. Donec sit amet nisi vel erat placerat sodales molestie vitae est. Praesent rutrum magna aliquam dictum condimentum. Etiam at congue enim, quis auctor enim. Sed tincidunt risus non velit gravida, ut fringilla sem hendrerit. Aenean tincidunt mollis massa ac bibendum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla interdum ut massa vel rhoncus. Nulla mattis ipsum ac vestibulum dapibus. Integer tincidunt sit amet tellus vitae lobortis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc tristique id diam sit amet sollicitudin. Proin varius ante cursus pretium maximus. Sed mi nibh, facilisis ut finibus elementum, laoreet id sapien. Vivamus lacinia diam a ipsum euismod lacinia. Nulla facilisi.</p><p><br></p><p>Morbi auctor lectus feugiat aliquet rhoncus. Duis quis odio bibendum, sodales neque ut, tempor nulla. Morbi nec ultricies ipsum. Pellentesque suscipit nunc quis turpis dapibus, at efficitur erat tincidunt. Etiam egestas neque vitae odio sollicitudin gravida. Vestibulum ut pretium nibh. Ut at risus sit amet quam maximus imperdiet ut a nisi. Sed cursus dui et lorem porttitor, in blandit lectus eleifend.</p><p><br></p><p>Curabitur imperdiet, lacus ac faucibus congue, sem neque elementum lectus, ut volutpat tellus tortor sit amet nibh. Quisque at dignissim purus. Sed non dolor hendrerit, posuere dolor eu, laoreet arcu. Proin turpis neque, lobortis eget nibh at, euismod pellentesque leo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla sed porta nisl. Aliquam erat volutpat. Donec malesuada placerat augue, eu vulputate velit mattis eu. Morbi pharetra turpis vitae libero malesuada, non consequat nunc pretium. Vivamus congue justo et gravida venenatis. Sed dapibus sem et urna venenatis, at tristique ipsum dignissim. Phasellus in efficitur sem. Donec rhoncus sagittis feugiat. Nunc scelerisque risus eu diam varius porta.</p><p><br></p><p>Aliquam vulputate tristique nisi sit amet consequat. Donec dapibus sapien id sem varius, nec accumsan nulla pharetra. Sed egestas vestibulum bibendum. Vivamus massa tellus, sollicitudin ac nibh sit amet, lacinia tempor eros. Sed pellentesque luctus tempor. Pellentesque sed elit lorem. Cras vulputate, nisi tempor viverra laoreet, lacus magna volutpat ipsum, et maximus nibh metus a lorem. Phasellus mattis sodales sem. Aenean consectetur turpis velit, ac interdum orci elementum ut. Quisque viverra ultricies arcu, molestie molestie odio fermentum vestibulum. In scelerisque libero placerat ante mollis malesuada. Suspendisse nisl diam, sollicitudin eget elementum vitae, suscipit vitae neque. Morbi risus justo, convallis eget sapien et, gravida iaculis erat. Vestibulum sed accumsan nisl.</p><p><br></p><p>Pellentesque quis orci elit. Nulla id lacus at ex laoreet vestibulum eu vel nulla. Praesent sit amet turpis condimentum, imperdiet nunc quis, feugiat lorem. Vestibulum malesuada dui nibh, et ullamcorper eros molestie sit amet. Duis euismod iaculis nisl, sed placerat leo. Cras euismod mi ultrices, interdum mauris a, ullamcorper lectus. Phasellus convallis pharetra nibh, at tristique nisl. Donec libero nunc, tincidunt sed imperdiet eu, vestibulum vel orci.</p><div><br></div>', 'terms-and-condition', '2018-08-08 19:35:59', 1),
(3, 'Privacy Policy', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla rutrum et enim eu molestie. Donec sit amet nisi vel erat placerat sodales molestie vitae est. Praesent rutrum magna aliquam dictum condimentum. Etiam at congue enim, quis auctor enim. Sed tincidunt risus non velit gravida, ut fringilla sem hendrerit. Aenean tincidunt mollis massa ac bibendum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla interdum ut massa vel rhoncus. Nulla mattis ipsum ac vestibulum dapibus. Integer tincidunt sit amet tellus vitae lobortis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc tristique id diam sit amet sollicitudin. Proin varius ante cursus pretium maximus. Sed mi nibh, facilisis ut finibus elementum, laoreet id sapien. Vivamus lacinia diam a ipsum euismod lacinia. Nulla facilisi.</p><p><br></p><p>Morbi auctor lectus feugiat aliquet rhoncus. Duis quis odio bibendum, sodales neque ut, tempor nulla. Morbi nec ultricies ipsum. Pellentesque suscipit nunc quis turpis dapibus, at efficitur erat tincidunt. Etiam egestas neque vitae odio sollicitudin gravida. Vestibulum ut pretium nibh. Ut at risus sit amet quam maximus imperdiet ut a nisi. Sed cursus dui et lorem porttitor, in blandit lectus eleifend.</p><p><br></p><p>Curabitur imperdiet, lacus ac faucibus congue, sem neque elementum lectus, ut volutpat tellus tortor sit amet nibh. Quisque at dignissim purus. Sed non dolor hendrerit, posuere dolor eu, laoreet arcu. Proin turpis neque, lobortis eget nibh at, euismod pellentesque leo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla sed porta nisl. Aliquam erat volutpat. Donec malesuada placerat augue, eu vulputate velit mattis eu. Morbi pharetra turpis vitae libero malesuada, non consequat nunc pretium. Vivamus congue justo et gravida venenatis. Sed dapibus sem et urna venenatis, at tristique ipsum dignissim. Phasellus in efficitur sem. Donec rhoncus sagittis feugiat. Nunc scelerisque risus eu diam varius porta.</p><p><br></p><p>Aliquam vulputate tristique nisi sit amet consequat. Donec dapibus sapien id sem varius, nec accumsan nulla pharetra. Sed egestas vestibulum bibendum. Vivamus massa tellus, sollicitudin ac nibh sit amet, lacinia tempor eros. Sed pellentesque luctus tempor. Pellentesque sed elit lorem. Cras vulputate, nisi tempor viverra laoreet, lacus magna volutpat ipsum, et maximus nibh metus a lorem. Phasellus mattis sodales sem. Aenean consectetur turpis velit, ac interdum orci elementum ut. Quisque viverra ultricies arcu, molestie molestie odio fermentum vestibulum. In scelerisque libero placerat ante mollis malesuada. Suspendisse nisl diam, sollicitudin eget elementum vitae, suscipit vitae neque. Morbi risus justo, convallis eget sapien et, gravida iaculis erat. Vestibulum sed accumsan nisl.</p><p><br></p><p>Pellentesque quis orci elit. Nulla id lacus at ex laoreet vestibulum eu vel nulla. Praesent sit amet turpis condimentum, imperdiet nunc quis, feugiat lorem. Vestibulum malesuada dui nibh, et ullamcorper eros molestie sit amet. Duis euismod iaculis nisl, sed placerat leo. Cras euismod mi ultrices, interdum mauris a, ullamcorper lectus. Phasellus convallis pharetra nibh, at tristique nisl. Donec libero nunc, tincidunt sed imperdiet eu, vestibulum vel orci.</p><div><br></div>', 'privacy-policy', '2018-08-08 19:36:25', 1),
(4, '', '', '', '2018-09-14 14:39:13', 0),
(5, '', '', '', '2018-09-15 19:38:15', 0),
(6, '', '', '', '2018-09-15 20:22:34', 0),
(7, '', '', '', '2018-09-15 20:25:54', 0),
(8, '', '', '', '2018-09-15 21:53:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_password` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_vsalt` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_vcode` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified` int(1) NOT NULL DEFAULT 0,
  `is_superadmin` int(1) NOT NULL DEFAULT 0,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `qr_password`, `email_vsalt`, `email_vcode`, `email_verified`, `is_superadmin`, `is_active`, `created_at`) VALUES
(1, 'admin@gmail.com', '$2y$12$IddWogG8ZIu5YZP5q6o.aurPSUZqhTvfqWn/UNHF41awMIzHDMhI2', '2b5fd47f45c68aa02605ba018f03503a86657ca4c5f29dad006b031bd55614ada908f8a03f92ccb9b52d0c169a33173e495e0652fe4871097c7dbd67395cde0c', '6e1578397a77a2099a84ba26b70bb517', '747797df1e5956dafc1f1946578c7b1a', 0, 1, 1, '2018-09-09 00:04:17'),
(2, 'student01@gmail.com', '$2y$12$LNdGDab4F6d61aV9XcnztunO/9BuCSqqv4RtKAywhBYZkzDWRat2i', '069b58dc94679d74d2d7981c538ecbcf3451b858a67376adcfcd35e3301928578850c2b045f54151bfc186b476f59cb28501fdb7158307e22f8a3be6fab900ec', '0e53c851b9b2cd23ed3af15308442163', '9fe0315df963f8e3b3f6ffebd3b4992b', 0, 0, 1, '2018-09-14 15:34:19'),
(3, 'student02@gmail.com', '$2y$12$m2ozFnDsjWNaZi6jYhSmeutNi4UjSWHGfGQhXcna.dBjrcCCIe91i', '7200eabf23e616d832141abc60eded2e7a63f393bac0c7ba8a75c02102ad2112090dd7b56346599b25cf4869bcd41219e621d57d2e94bf54fe467c1eb4c96936', '5aef73c2fbac169dd5c8597da78d2d03', '3cddf6fa5e0e255cd060fb48d9ee5a9b', 0, 0, 1, '2018-09-14 15:36:38'),
(4, 'student03@gmail.com', '$2y$12$tIVht87EwrLfPsIdPOtbdOA4CgW3BiDsuKwCX.8.ZEZo0HKW5Oj22', '4abf62e45af041c6f5e3f7745d42bc23215234626384523c63dcecc26c8ec7ad8e9898350d834bd621cbf5d06fedf1aaae4fcb8a03f18405910e974030522367', '5f5f2886681ad07f4b31fad17ced412e', 'a6a86f7a19fec4dc4ff24ac39cc942ba', 0, 0, 1, '2018-09-14 15:38:54'),
(5, 'student04@gmail.com', '$2y$12$jn3YfoXGnWViyUitDgdNXe1sPwg56uHMJKVg.5QwTyhXARD3yt15S', '3c07c6aef3fca769e8125cf0080b73e5390e2bc4f6e6e7bb3890b3aead17e5fa57a01569cff37806a9545168fe9ef0f6595d71afac6e4ed3e4dfff04c6e15e25', '1259a0a0cd6b651524007926e8e7b8a8', '0cf0c461eae68761991b3e4fef0ae672', 0, 0, 1, '2018-09-14 17:50:07'),
(6, 'student05@gmail.com', '$2y$12$RSUfHRTLdOKvozmbUU3a2.WItKZ26MNodnyD16bV1ZbyWslXLC0A2', 'd2f21f0a7f6d8c8a8ec42e8b49e9de069dbba33a2c3c624c2823c1d3dc9eac10018c3a1f430fa00caced0a73bfb86907423dbe08e8650956661cf730e43aa22d', '91b53a5190f2fd362fc47cf8d5acbb3c', 'ff14e5fc3a375d21ded2b4bd38432b4e', 0, 0, 1, '2018-09-14 17:51:48'),
(7, 'student06@gmail.com', '$2y$12$tkAkj.mBSfWkWRd9vTHC6uK86Dnhp0ZKnLksAD7VSfk0kdmNU09/e', 'b87223ecc747555d7976664b5e1a9c66d0bddf2f1330ea960dc3e009a102470f9c50ca4684f7bb4f7eba0bdce441d8d9fd3bcbed1d7a567f81a1c5d34b38a10e', 'b029a762d98f8dff938fe5497a6312d2', 'eb347d7fd81149d86cda62ff25cbeef2', 0, 0, 1, '2018-09-14 17:53:12'),
(8, 'student07@gmail.com', '$2y$12$psKjc56aBVIMagrpwT0WIuAPklcxGG2KVHB4oQK9DNUSIl83z1LhC', 'fe6483e6716d15b5139922c10eb08c293efaf94be745355c38ebfddc5e04b505caf71ab6b3d5ecddc928870bd75583baafd9df64e7a32e974d22c363b2e44867', '6381c3c03a3e9f6492b26ad05e09da31', 'dd2ccbc3ca22db7459c0ca091a92ef52', 0, 0, 1, '2018-09-14 17:53:59'),
(9, 'student08@gmail.com', '$2y$12$n3FNGgI1.tfxYmeLWQCrnup0KXG0kwvPIWR/8LhMaa.iLdWzIMPmC', '94923fd2fc9ea9019f33ee5089914001ced85d62eb0f8fba90a6024ad18cbaaf40da3fcd7618f95535ccfce210eab353f9794a6aafbad6f052454ce8c16690db', 'ab93644a94e60f59e692a3a466945f00', 'caed32bca2ad6ab4ef9bb4fc79df3263', 0, 0, 1, '2018-09-14 17:54:51'),
(10, 'student09@gmail.com', '$2y$12$6i34KAnFTh3qHnS6RiHxIeHU.0/TS.Q8UI3zOiTENPkQdXR9OBS2a', '3f8c8e457ce72028ffe68e46696897a4c151200b141a4f3dc65bfe6cb5d61bdc7672a4904b0a5648da19b930412676d165e0c1846c12ee9e4ef9eb33a98d137c', '3c8a918a0f574a75280bce410cf17e2f', '67764d7de45d400b9f57352932020bfb', 0, 0, 1, '2018-09-14 17:55:37'),
(11, 'student10@gmail.com', '$2y$12$MgTmPVNQTWrujO25P1/hgeZryb.5mLNQyr1uTKZheYRs/K8Ulmx8.', '000c3b44303b1d3d958631599e2457df5842664d6fca1320cc3491117ced586aa90402475169ad09837ceaa65e1775d116a22e429197bbaf7ac0d9517cba0c04', '6f9cf56d2f51ed1155e178590e9e94e9', '5d2810f5776a10164f4d789806fc9093', 0, 0, 1, '2018-09-14 17:56:22'),
(13, 'student11@gmail.com', '$2y$12$uSGOdA4/xUfzi50swHhzz.O3a6pfg2FLhBlSaiC4bzff2EgXOyvga', '', 'ed1218f45e89e7e162a1038f92c13eb5', '255368b254d658aebca622b7eae9debf', 0, 0, 1, '2018-09-16 23:09:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_acl`
--

CREATE TABLE `user_acl` (
  `user_acl_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `acl_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_acl`
--

INSERT INTO `user_acl` (`user_acl_id`, `user_id`, `acl_id`) VALUES
(1, 1, 1),
(3, 1, 3),
(4, 1, 4),
(5, 2, 1),
(7, 2, 3),
(8, 3, 1),
(10, 3, 3),
(11, 4, 1),
(13, 4, 3),
(14, 5, 1),
(16, 5, 3),
(17, 6, 1),
(19, 6, 3),
(20, 7, 1),
(22, 7, 3),
(23, 8, 1),
(25, 8, 3),
(26, 9, 1),
(28, 9, 3),
(29, 10, 1),
(31, 10, 3),
(32, 11, 1),
(34, 11, 3),
(36, 13, 1),
(37, 13, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_attr`
--

CREATE TABLE `user_attr` (
  `user_attr_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` tinytext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_attr`
--

INSERT INTO `user_attr` (`user_attr_id`, `user_id`, `fullname`, `faculty`, `student_id`) VALUES
(1, 1, 'Super Admin', 'IT / Computer Sciences', '1011163151'),
(2, 2, 'LEE YAN HUI', 'IT / Computer Sciences', '1011163151'),
(3, 3, 'CHOO HING HOW', 'IT / Computer Sciences', '1011163151'),
(4, 4, 'NURUL DYANA BT ZAINUDIN', 'IT / Computer Sciences', '1011163151'),
(5, 5, 'WAN MARIA NADIA BT WAN ABDUL GHANI', 'IT / Computer Sciences', '1011163151'),
(6, 6, 'N HALIMATUSSA ADIAH BT ASTOR NUDDIN', 'IT / Computer Sciences', '1011163151'),
(7, 7, 'RASHIDATUL MUNIRAH BT HJ ABD RASHID', 'IT / Computer Sciences', '1011163151'),
(8, 8, 'TENGKU ZHAWANI BINTI TUNKU MANSOR', 'Engineering', '1011163151'),
(9, 9, 'RATHAA A/P ULAKANATHAN', 'Engineering', '1011163151'),
(10, 10, 'SARIFAH LIHAN', 'Engineering', '1011163151'),
(11, 11, 'HALIMATUN SAADIAH BINTI MOHD ZAINI', 'Engineering', '1011163151'),
(12, 13, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_image`
--

CREATE TABLE `user_image` (
  `user_image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dimension` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_image`
--

INSERT INTO `user_image` (`user_image_id`, `user_id`, `dimension`) VALUES
(2, 2, 'a:3:{s:5:\"large\";s:44:\"97ff3b01e17a97d75709a93dcb11ae23-600x397.jpg\";s:6:\"medium\";s:44:\"97ff3b01e17a97d75709a93dcb11ae23-500x331.jpg\";s:5:\"thumb\";s:44:\"97ff3b01e17a97d75709a93dcb11ae23-300x300.jpg\";}'),
(3, 3, 'a:3:{s:5:\"large\";s:44:\"6b757060a4b8a3233878fd98782694fa-600x401.jpg\";s:6:\"medium\";s:44:\"6b757060a4b8a3233878fd98782694fa-500x334.jpg\";s:5:\"thumb\";s:44:\"6b757060a4b8a3233878fd98782694fa-300x300.jpg\";}'),
(4, 4, 'a:3:{s:5:\"large\";s:44:\"6b4822b0fc23f1db9cfc7c8e1a4e6c4e-600x394.jpg\";s:6:\"medium\";s:44:\"6b4822b0fc23f1db9cfc7c8e1a4e6c4e-500x328.jpg\";s:5:\"thumb\";s:44:\"6b4822b0fc23f1db9cfc7c8e1a4e6c4e-300x300.jpg\";}'),
(5, 5, 'a:3:{s:5:\"large\";s:44:\"c8252a7fde5ae3d3877ecca912fa0b35-600x404.jpg\";s:6:\"medium\";s:44:\"c8252a7fde5ae3d3877ecca912fa0b35-500x337.jpg\";s:5:\"thumb\";s:44:\"c8252a7fde5ae3d3877ecca912fa0b35-300x300.jpg\";}'),
(6, 6, 'a:3:{s:5:\"large\";s:44:\"d5c7d0a18eefe70abd4c6ce3b7225d1d-600x401.jpg\";s:6:\"medium\";s:44:\"d5c7d0a18eefe70abd4c6ce3b7225d1d-500x334.jpg\";s:5:\"thumb\";s:44:\"d5c7d0a18eefe70abd4c6ce3b7225d1d-300x300.jpg\";}'),
(7, 7, 'a:3:{s:5:\"large\";s:44:\"c3eb1084802b52e1d3d2ad5d7f6c70e8-600x424.jpg\";s:6:\"medium\";s:44:\"c3eb1084802b52e1d3d2ad5d7f6c70e8-500x353.jpg\";s:5:\"thumb\";s:44:\"c3eb1084802b52e1d3d2ad5d7f6c70e8-300x300.jpg\";}'),
(8, 8, 'a:3:{s:5:\"large\";s:44:\"55acba9e8cee0c0c3eb9e0ee719b2968-600x407.jpg\";s:6:\"medium\";s:44:\"55acba9e8cee0c0c3eb9e0ee719b2968-500x339.jpg\";s:5:\"thumb\";s:44:\"55acba9e8cee0c0c3eb9e0ee719b2968-300x300.jpg\";}'),
(9, 9, 'a:3:{s:5:\"large\";s:44:\"5b9b1eca1dc7c872bac1428a20b8c715-600x401.jpg\";s:6:\"medium\";s:44:\"5b9b1eca1dc7c872bac1428a20b8c715-500x334.jpg\";s:5:\"thumb\";s:44:\"5b9b1eca1dc7c872bac1428a20b8c715-300x300.jpg\";}'),
(10, 10, 'a:3:{s:5:\"large\";s:44:\"bfec887e8a7c6cf3fe3697768f1ca5e7-600x396.jpg\";s:6:\"medium\";s:44:\"bfec887e8a7c6cf3fe3697768f1ca5e7-500x330.jpg\";s:5:\"thumb\";s:44:\"bfec887e8a7c6cf3fe3697768f1ca5e7-300x300.jpg\";}'),
(16, 1, 'a:3:{s:5:\"large\";s:44:\"02e253150f5a0958a8e7c702508e982b-600x375.jpg\";s:6:\"medium\";s:44:\"02e253150f5a0958a8e7c702508e982b-500x312.jpg\";s:5:\"thumb\";s:44:\"02e253150f5a0958a8e7c702508e982b-300x300.jpg\";}'),
(18, 11, 'a:3:{s:5:\"large\";s:44:\"a7bd1f2dc666116c8ea708e152128860-600x315.jpg\";s:6:\"medium\";s:44:\"a7bd1f2dc666116c8ea708e152128860-500x262.jpg\";s:5:\"thumb\";s:44:\"a7bd1f2dc666116c8ea708e152128860-300x300.jpg\";}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `list_faculty`
--
ALTER TABLE `list_faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_acl`
--
ALTER TABLE `user_acl`
  ADD PRIMARY KEY (`user_acl_id`);

--
-- Indexes for table `user_attr`
--
ALTER TABLE `user_attr`
  ADD PRIMARY KEY (`user_attr_id`);

--
-- Indexes for table `user_image`
--
ALTER TABLE `user_image`
  ADD PRIMARY KEY (`user_image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `list_faculty`
--
ALTER TABLE `list_faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_acl`
--
ALTER TABLE `user_acl`
  MODIFY `user_acl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user_attr`
--
ALTER TABLE `user_attr`
  MODIFY `user_attr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_image`
--
ALTER TABLE `user_image`
  MODIFY `user_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

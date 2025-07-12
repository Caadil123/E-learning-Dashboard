-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2025 at 08:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearningsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `Admin_name` varchar(20) NOT NULL,
  `Admin_email` varchar(50) DEFAULT NULL,
  `Admin_pass` varchar(50) DEFAULT NULL,
  `permissions` text NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `Admin_name`, `Admin_email`, `Admin_pass`, `permissions`, `is_deleted`) VALUES
(1, 'Omar Gooni', 'Admin@123', '1234', '1,2,3,4', 0);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_text` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `course_id`, `quiz_id`, `question_id`, `answer_text`, `is_correct`, `is_deleted`) VALUES
(1, 1, 1, 1, 'User Interface', 1, 0),
(2, 1, 1, 1, 'User Interaction', 0, 0),
(3, 1, 1, 1, ' User Integration', 0, 0),
(4, 1, 1, 1, 'Unified Interaction', 0, 0),
(5, 1, 1, 2, 'Making the interface colorful', 0, 0),
(6, 1, 1, 2, 'Ensuring the user has a smooth and meaningful experience', 1, 0),
(7, 1, 1, 2, 'Adding as many features as possible', 0, 0),
(8, 1, 1, 2, 'Prioritizing developer preferences over user needs', 0, 0),
(9, 1, 1, 3, 'Photoshop', 0, 0),
(10, 1, 1, 3, 'Microsoft Word', 0, 0),
(11, 1, 1, 3, 'Figma', 1, 0),
(12, 1, 1, 3, 'Excel', 0, 0),
(13, 1, 1, 4, 'Contrast', 0, 0),
(14, 1, 1, 4, 'Hierarchy', 0, 0),
(15, 1, 1, 4, 'Consistency', 1, 0),
(16, 1, 1, 4, 'Affordance', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Cat_name` varchar(30) DEFAULT NULL,
  `Cat_image` varchar(100) NOT NULL,
  `Cat_desc` longtext NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_by` int(11) NOT NULL,
  `deleted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Cat_name`, `Cat_image`, `Cat_desc`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `is_deleted`) VALUES
(1, 'design category', 'uploads/still-life-graphic-design-day_52683-160823.jpg', 'dhajdadahdaga', 1, '2025-07-02 00:02:54', 1, '2024-11-12 17:49:10', 0),
(2, 'data science category', 'uploads/Data sciece.jpg', 'wa category lagu bixiyo maadoyinka data science', 0, '2025-06-09 21:37:50', 0, '2025-06-09 21:37:50', 0),
(3, 'IT and software category', 'uploads/20140110_idp009_l.webp', 'Cloud computing is a technology that allows users to access and store data, applications, and services over the internet instead of relying on local computers or physical servers. It delivers computing services such as servers, storage, databases, networking, software, analytics, and artificial intelligence over the cloud (the internet) on a pay-as-you-go basis.', 0, '2025-07-02 12:36:16', 0, '2025-07-02 12:36:16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `describtion` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `title`, `describtion`, `user_id`, `course_id`, `create_at`, `is_deleted`) VALUES
(1, 'why we need figma?', 'ahadgajaghjad', 1, 1, '2025-04-09 08:08:22', 0),
(2, 'who is the fuck here', 'jdahdjkahdkajdhajd', 1, 1, '2025-04-09 08:12:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `ID` int(11) NOT NULL,
  `Content_name` varchar(100) NOT NULL,
  `Section_ID` int(11) DEFAULT NULL,
  `Course_ID` int(11) NOT NULL,
  `Content_time` varchar(50) NOT NULL,
  `lesson` varchar(50) NOT NULL,
  `Content_Video` varchar(100) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`ID`, `Content_name`, `Section_ID`, `Course_ID`, `Content_time`, `lesson`, `Content_Video`, `updated_by`, `updated_at`, `is_deleted`) VALUES
(1, 'Understanding UI/UX Design Principles', 1, 1, '3 minutes', 'Lesson 1', 'uploads/videos/course introduction.mp4', 0, '2024-11-12 17:56:41', 0),
(2, 'understanding basic probability', 2, 3, '3 minutes', 'Lesson 1', 'uploads/videos/Inroduction.mp4', 0, '2025-06-09 22:46:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `ID` int(11) NOT NULL,
  `Course_name` varchar(50) NOT NULL,
  `Course_image` longblob NOT NULL,
  `Category_ID` int(11) DEFAULT NULL,
  `Instructor_Id` int(11) DEFAULT NULL,
  `describtion` varchar(300) DEFAULT NULL,
  `Duration` varchar(20) NOT NULL,
  `Level` varchar(20) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`ID`, `Course_name`, `Course_image`, `Category_ID`, `Instructor_Id`, `describtion`, `Duration`, `Level`, `updated_by`, `updated_at`, `is_deleted`) VALUES
(1, 'UI UX design', 0x75706c6f6164732f55782044657369676e20696d616765322e706e67, 1, 2, 'Learn the art and science of creating user-friendly and visually appealing digital experiences. This category covers essential principles of User Interface (UI) Design and User Experience (UX) Design', '4 weeks', 'Begginner', 0, '2025-06-29 23:47:35', 0),
(2, 'Graphic design', 0x75706c6f6164732f323032322d31312d30352031312e3239202831292e6a7067, 1, 5, 'essdrtfgumji,k.', '4 weeks', 'intermediate', 0, '2025-03-01 10:15:15', 0),
(3, 'Probability', 0x75706c6f6164732f4765747479496d616765732d3436343230393932332d3539303736393239336466373863353435366163316565612e6a7067, 2, 6, 'wa maado xisaab ah lagu baranayo asaska probablitiga ', '6 weeks', 'intermediate', 0, '2025-06-09 21:39:41', 0),
(4, 'cloud computing', 0x75706c6f6164732f496d6167652035202833292e706e67, 3, 11, 'gaajdagdad', '6 weeks', 'Begginner', 0, '2025-07-02 12:42:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` date DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`ID`, `Student_ID`, `course_id`, `enrollment_date`, `is_deleted`) VALUES
(1, 1, 1, '2024-11-12', 0),
(2, 14, 1, '2025-03-01', 0),
(3, 15, 2, '2025-03-05', 0),
(4, 15, 1, '2025-03-05', 0),
(5, 16, 3, '2025-06-09', 0),
(6, 16, 1, '2025-06-10', 0),
(7, 18, 1, '2025-06-16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `ID` int(11) NOT NULL,
  `INS_name` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `Image` varchar(150) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`ID`, `INS_name`, `username`, `password`, `Image`, `is_deleted`) VALUES
(10, 'Upkar Lidder', 'ahmed12@gmail.com', '1234', 'uploads/front-view-male-student-red-checkered-shirt-with-backpack-holding-yellow-files-smiling-blue-wall_140725-42598.jpg', 0),
(11, 'Adan jeylani', 'adan@123', '123', 'uploads/Image 5 (2).png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`ID`, `name`, `icon`, `is_deleted`) VALUES
(1, 'Dashboard', 'fas fa-fw fa-tachometer-alt', 0),
(2, 'Students', 'fas fa-fw fa-user-graduate', 0),
(3, 'Users', 'fas fa-fw fa-user', 0),
(4, 'Categories', 'fas fa-fw fa-folder', 0),
(5, 'Courses', 'fas fa-fw fa-chalkboard', 0),
(6, 'Sections', 'fas fa-fw fa-th-list', 0),
(7, 'Contents', 'fas fa-fw fa-file-alt', 0),
(8, 'Enrollments', 'fas fa-fw fa-book-open', 0),
(10, 'Messages', 'fas fa-fw fa-envelope', 0),
(11, 'Manage_Quizzes', 'fas fa-question-circle', 0),
(12, 'quiz_results', 'fas fa-clipboard-lis', 1),
(13, 'Report', 'fas fa-file-alt', 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` varchar(400) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `FirstName`, `LastName`, `email`, `phone`, `message`, `is_deleted`) VALUES
(1, 'caadil', 'omar', 'abdirahimomar147@gmail.com', '616481717', 'waxan ahay arday ka helay maadada ui ux design', 0),
(2, 'Apdulahi', 'apshir', 'abdulahi@gmail.com', '6545454545', 'waxan ka helin koorsooyin ee is bedal sameeya koorsooyinkana hormariya', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `course_id`, `quiz_id`, `question_text`, `created_at`, `is_deleted`) VALUES
(1, 1, 1, 'What does UI stand for in UI/UX Design?', '2025-05-04 15:36:06', 0),
(2, 1, 1, 'Which of the following is a primary goal of UX design?', '2025-05-04 15:36:42', 0),
(3, 1, 1, 'Which tool is commonly used for creating wireframes and prototypes in UI/UX design?', '2025-05-04 15:37:02', 0),
(4, 1, 1, 'In UI design, which principle ensures that elements that are similar in function or nature should look similar?', '2025-05-04 15:37:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `course_id`, `section_id`, `title`, `description`, `created_at`, `is_deleted`) VALUES
(1, 1, 1, 'Quiz one', 'this quiz is about all lessons that you take in section ', '2025-05-03 16:20:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_completion`
--

CREATE TABLE `quiz_completion` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_completion`
--

INSERT INTO `quiz_completion` (`id`, `user_id`, `quiz_id`, `course_id`, `completed_at`) VALUES
(1, 1, 1, 1, '2025-05-29 14:09:11'),
(2, 15, 1, 1, '2025-06-10 20:25:35'),
(3, 18, 1, 1, '2025-06-16 09:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `user_id`, `quiz_id`, `course_id`, `score`, `completed_at`, `is_deleted`) VALUES
(1, 1, 1, 1, 50, '2025-06-30 07:44:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating_number` int(11) NOT NULL DEFAULT 0,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `course_id`, `user_id`, `rating_number`, `create_at`, `is_deleted`) VALUES
(1, 1, 1, 5, '2025-06-12 23:35:59', 0),
(2, 1, 14, 3, '2025-06-12 23:35:59', 0),
(3, 1, 15, 1, '2025-06-12 23:35:59', 0),
(4, 1, 16, 5, '2025-06-12 23:35:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `describtion` varchar(400) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `question_id` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `user_id`, `describtion`, `created_at`, `question_id`, `is_deleted`) VALUES
(1, 1, 'hhahdadgahdagadagdj', '2025-04-09 08:09:35', 1, 0),
(2, 1, 'ufhdfhjfhsfsjfhsfj', '2025-06-29 14:53:03', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`, `is_deleted`) VALUES
(1, 'Admin', 0),
(2, 'instructor', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `ID` int(11) NOT NULL,
  `Section_name` varchar(50) NOT NULL,
  `Course_ID` int(11) DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`ID`, `Section_name`, `Course_ID`, `updated_by`, `updated_at`, `is_deleted`) VALUES
(1, 'Inroductions of UI/UX desing', 1, 0, '2024-11-12 17:55:23', 0),
(2, 'Inroduction of probability', 3, 6, '2025-06-10 21:43:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `ID` int(11) NOT NULL,
  `STD_name` varchar(20) DEFAULT NULL,
  `STD_email` varchar(50) NOT NULL,
  `STD_pass` varchar(50) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `STD_name`, `STD_email`, `STD_pass`, `is_deleted`) VALUES
(1, 'Abdiwahab Osman ali', 'abdiwahab1452@gmail.com', '222', 0),
(2, 'caadil omar', 'abdirahimomar147@gmail.com', '2222', 0),
(3, 'Maxamed adan', 'moha22@gmail.com', '3333', 0),
(4, 'maria mire', 'maria@gmail.com5566', '1234', 0),
(5, 'nasra ahmed', 'nasra91@gmail.com', '321', 0),
(6, 'ahmed adan', 'ahmed@gmail.com', '258', 0),
(7, 'mayow ali', 'mayow@gmail.com', 'mayow123', 0),
(8, 'najma ali', 'najma@gmail.com', 'najma22', 0),
(9, 'nada hassan', 'nada@gmail.com', 'nada456', 0),
(10, 'Warsan osman', 'warsan@gmail.com', '555', 0),
(11, 'saabir omar', 'sabir@gmail.com', '444', 0),
(12, 'gooni', 'gooni@gmail.com', '123', 0),
(13, 'Abdirahman', 'abdirahman@gmail.com', '123', 0),
(14, 'geedi ahmed', 'geedi@gmail.com', '1122', 0),
(15, 'ashwaq ibrahim', 'ashuu@gmail.com', '123', 0),
(16, 'farah geedi', 'farahjamac@gmail.com', '123', 0),
(17, 'sara hussien', 'sara@gmail.com', '123', 0),
(18, 'ibrahim', 'ibrahim@gmail.com', '123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `submenus`
--

CREATE TABLE `submenus` (
  `ID` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `href` varchar(50) NOT NULL,
  `on_side` tinyint(4) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submenus`
--

INSERT INTO `submenus` (`ID`, `menu_id`, `label`, `href`, `on_side`, `is_deleted`) VALUES
(1, 1, 'Dashboard', 'index.php', 1, 0),
(2, 2, 'All Students', 'Students.php', 1, 0),
(3, 3, 'View all users', 'Allusers.php', 1, 1),
(4, 3, 'Modify users', 'Modifyusers.php', 1, 0),
(5, 4, 'View all Categories', 'Allcategories.php', 1, 1),
(6, 4, 'Manage Categories', 'Modifycategories.php', 1, 0),
(7, 5, 'View all Courses', 'Allcourses.php', 1, 1),
(8, 5, 'Manage Courses', 'Modifycourses.php', 1, 0),
(9, 6, 'View all Sections', 'AllSections.php', 1, 1),
(10, 6, 'Manage Sections', 'ModifySections.php', 1, 0),
(11, 7, 'View all Contents', 'Allcontents.php', 1, 1),
(18, 7, 'Manage Contents', 'Modifycontent.php', 1, 0),
(20, 8, 'View all Enrollments', 'Allenrollments.php', 1, 0),
(22, 10, 'View all messages', 'cards.php', 1, 0),
(23, 11, 'Manage Quizzes', 'ModifyQuiz.php', 1, 0),
(24, 11, 'Questions', 'quizQuestion.php', 1, 0),
(25, 11, 'answers', 'answers.php', 1, 0),
(26, 11, 'quiz_results', 'quiz_results.php', 1, 0),
(27, 13, 'View Report', 'admin_report.php', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permissions` text NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role_id`, `permissions`, `is_deleted`) VALUES
(1, 'omar gooni', 'omar34@gmail.com', 'bcbe3365e6ac95ea2c0343a2395834dd', 1, '1,2,4,6,8,10,18,20,22,23,24,25,26,27,insert-10,insert-18,update-10,update-18,delete-10,delete-18', 0),
(2, 'Caadil omar', 'caadil06@gmail.com', '202cb962ac59075b964b07152d234b70', 2, '1,10,18,23,24,25,26,delete-24', 0),
(3, 'Ahmed ali ', 'ahmed12@gmail.com', '202cb962ac59075b964b07152d234b70', 2, '1,10,18,delete-10,delete-18', 0),
(4, 'Ali Ahmed ', 'ali22@gmail.com', 'ef3659556771ab3185d43ecf431e3f3a', 2, '1,10,18,delete-10,delete-18', 0),
(5, 'Adan jeylani', 'adan@123', '202cb962ac59075b964b07152d234b70', 2, '', 0),
(6, 'Salma osman', 'salma@gmail.com', '202cb962ac59075b964b07152d234b70', 2, '1,10,18,23,24,25,26,delete-10,delete-18', 0),
(7, 'mayoo cabdi', 'mayo@gmail.com', '202cb962ac59075b964b07152d234b70', 2, '1,10,18,23,24,25,delete-10,delete-18,delete-23', 0),
(8, 'omar guure', 'guure12@gmail.com', 'd51b416788b6ee70eb0c381c06efc9f1', 1, '1,2,4,6,8,10,18,20,22,27', 0),
(9, 'mubarak', 'mubarak@gmail.com', '202cb962ac59075b964b07152d234b70', 2, '1,10,18,23,24,25,26,insert-26,update-26,delete-26', 0),
(10, 'maxamed', 'moha@gmailcom', '202cb962ac59075b964b07152d234b70', 2, '1,10,18,23,24,25,26', 0),
(11, 'farah hilowle', 'faraah@gmail.com', '202cb962ac59075b964b07152d234b70', 2, '1,10,18,23,24,25,26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_responses`
--

CREATE TABLE `user_responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `selected_answer_id` int(11) DEFAULT NULL,
  `response_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_responses`
--

INSERT INTO `user_responses` (`id`, `user_id`, `quiz_id`, `question_id`, `selected_answer_id`, `response_time`, `is_deleted`) VALUES
(1, 15, 1, 1, 4, '2025-04-14 04:53:26', 0),
(2, 1, 1, 4, 16, '2025-05-04 16:00:32', 0),
(3, 1, 1, 3, 12, '2025-05-04 16:39:56', 0),
(4, 1, 1, 2, 8, '2025-05-04 16:39:56', 0),
(5, 1, 1, 1, 4, '2025-05-04 16:39:56', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Admin_email` (`Admin_email`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Section_ID` (`Section_ID`),
  ADD KEY `Course_ID` (`Course_ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Course_name` (`Course_name`),
  ADD KEY `courses_ibfk_1` (`Category_ID`),
  ADD KEY `courses_ibfk_2` (`Instructor_Id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`username`),
  ADD KEY `INS_name` (`INS_name`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `quiz_completion`
--
ALTER TABLE `quiz_completion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_quiz_completion` (`user_id`,`quiz_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `replies_ibfk_2` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Section_name` (`Section_name`),
  ADD KEY `Course_ID` (`Course_ID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `STD_email` (`STD_email`),
  ADD KEY `STD_name` (`STD_name`,`STD_email`);

--
-- Indexes for table `submenus`
--
ALTER TABLE `submenus`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_progress` (`user_id`,`course_id`,`content_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `content_id` (`content_id`);

--
-- Indexes for table `user_responses`
--
ALTER TABLE `user_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `selected_answer_id` (`selected_answer_id`),
  ADD KEY `question_id` (`question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_completion`
--
ALTER TABLE `quiz_completion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `submenus`
--
ALTER TABLE `submenus`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_responses`
--
ALTER TABLE `user_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`),
  ADD CONSTRAINT `answers_ibfk_3` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`);

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `sections` (`ID`),
  ADD CONSTRAINT `quizzes_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`);

--
-- Constraints for table `quiz_completion`
--
ALTER TABLE `quiz_completion`
  ADD CONSTRAINT `quiz_completion_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `quiz_completion_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `quiz_completion_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`);

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `quiz_results_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `students` (`ID`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `students` (`ID`);

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`Course_ID`) REFERENCES `courses` (`ID`);

--
-- Constraints for table `submenus`
--
ALTER TABLE `submenus`
  ADD CONSTRAINT `submenus_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `user_progress_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`),
  ADD CONSTRAINT `user_progress_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `contents` (`ID`);

--
-- Constraints for table `user_responses`
--
ALTER TABLE `user_responses`
  ADD CONSTRAINT `user_responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `user_responses_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `user_responses_ibfk_4` FOREIGN KEY (`selected_answer_id`) REFERENCES `answers` (`id`),
  ADD CONSTRAINT `user_responses_ibfk_5` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

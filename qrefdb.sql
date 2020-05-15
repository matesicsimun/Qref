-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2020 at 08:18 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qrefdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `QuestionId` bigint(20) UNSIGNED NOT NULL,
  `Text` text NOT NULL,
  `IsCorrect` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`Id`, `QuestionId`, `Text`, `IsCorrect`) VALUES
(270, 114, 'Rusija', 1),
(271, 114, 'Ukrajina', 0),
(272, 114, 'Bjelorusija', 0),
(273, 114, 'Moldavija', 0),
(274, 115, 'PHP7', 0),
(275, 115, 'PHP6', 1),
(276, 115, 'PHP5', 0),
(277, 115, 'PHP4', 0),
(278, 116, 'James Cameron', 1),
(279, 116, 'Martin Scorsese', 0),
(280, 116, 'Michael Bay', 0),
(281, 116, 'Steven Spielberg', 0),
(282, 117, 'Govedinu', 1),
(283, 117, 'Tunu', 0),
(284, 117, 'Morskog psa', 0),
(285, 117, 'Školjke', 0),
(286, 118, 'Albanija', 0),
(287, 118, 'Kazahstan', 1),
(288, 118, 'Rusija', 0),
(289, 118, 'Alžir', 0),
(290, 119, 'Dagestan', 1),
(291, 119, 'Mordovia', 0),
(292, 119, 'Čečenija', 0),
(293, 119, 'Buryatia', 0),
(294, 120, 'GET', 0),
(295, 120, 'SEND', 0),
(296, 120, 'POST', 0),
(297, 120, 'PUT', 1),
(298, 121, 'Java', 0),
(299, 121, 'Perl', 0),
(300, 121, 'PHP', 0),
(301, 121, 'Python', 1),
(306, 122, 'Sylvester Stallone', 1),
(307, 123, 'Kiklop', 1),
(308, 124, '1956', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Id` int(11) NOT NULL,
  `AuthorId` bigint(20) UNSIGNED NOT NULL,
  `QuizId` varchar(120) NOT NULL,
  `Content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Id`, `AuthorId`, `QuizId`, `Content`) VALUES
(0, 12, '5ebeccdf18686', 'neki komentar');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `QuizId` varchar(120) NOT NULL,
  `Text` text NOT NULL,
  `Type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`Id`, `QuizId`, `Text`, `Type`) VALUES
(114, '5ebeccdf18686', 'U kojoj državi se nalazi grad Vladivostok?', 1),
(115, '5ebeccdf18686', 'Koja od ovih verzija programskog jezika PHP nikad nije izašla?', 1),
(116, '5ebeccdf18686', 'Tko je režirao film Terminator 2?', 1),
(117, '5ebeccdf18686', 'Wagyu je naziv za koju skupocjenu hranu?', 1),
(118, '5ebeccdf18686', 'Popularni fikcionalni lik Borat dolazi iz koje države?', 1),
(119, '5ebeccdf18686', 'Iz koje pokrajine u Rusiji dolazi slavni borac Khabib Nurmagomedov?', 1),
(120, '5ebeccdf18686', 'Koji od navedenih nizova označavaju HTTP metodu?', 2),
(121, '5ebeccdf18686', 'Koji od navedenih programskih jezika su interpretirani?', 2),
(122, '5ebeccdf18686', 'Kako se zove glumac koji glumi glavnog lika imena Rocky u istoimenom filu?', 3),
(123, '5ebeccdf18686', 'Protiv kojeg mitološkog bića imena Polifem se Odisej bori?', 3),
(124, '5ebeccdf18686', 'Koje godine je nastao ETF (godina bez točke)?', 3);

-- --------------------------------------------------------

--
-- Table structure for table `quizes`
--

CREATE TABLE `quizes` (
  `QuizId` varchar(120) NOT NULL,
  `AuthorId` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(120) NOT NULL,
  `Description` text NOT NULL,
  `CommentsEnabled` tinyint(1) NOT NULL,
  `IsPublic` tinyint(1) NOT NULL,
  `TimeLimit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizes`
--

INSERT INTO `quizes` (`QuizId`, `AuthorId`, `Name`, `Description`, `CommentsEnabled`, `IsPublic`, `TimeLimit`) VALUES
('5ebeccdf18686', 12, 'Test', 'Test quiz', 1, 1, 200);

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `SolverId` bigint(20) UNSIGNED NOT NULL,
  `QuizId` varchar(120) NOT NULL,
  `Percentage` float NOT NULL,
  `SolveDate` datetime NOT NULL,
  `AttemptNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statistics`
--

INSERT INTO `statistics` (`Id`, `SolverId`, `QuizId`, `Percentage`, `SolveDate`, `AttemptNumber`) VALUES
(19, 12, '5ebeccdf18686', 54.5455, '2020-05-15 19:59:07', 1),
(20, 12, '5ebeccdf18686', 63.6364, '2020-05-15 20:02:13', 1),
(21, 12, '5ebeccdf18686', 54.5455, '2020-05-15 20:02:37', 1),
(22, 12, '5ebeccdf18686', 63.6364, '2020-05-15 20:04:13', 1),
(23, 12, '5ebeccdf18686', 54.5455, '2020-05-15 20:05:02', 1),
(24, 12, '5ebeccdf18686', 54.5455, '2020-05-15 20:05:38', 1),
(25, 12, '5ebeccdf18686', 54.5455, '2020-05-15 20:06:46', 1),
(26, 12, '5ebeccdf18686', 54.5455, '2020-05-15 20:07:16', 1),
(27, 12, '5ebeccdf18686', 54.5455, '2020-05-15 20:08:12', 1),
(28, 12, '5ebeccdf18686', 63.6364, '2020-05-15 20:08:44', 1),
(29, 12, '5ebeccdf18686', 63.6364, '2020-05-15 20:09:44', 1),
(30, 12, '5ebeccdf18686', 63.6364, '2020-05-15 20:10:07', 1),
(31, 12, '5ebeccdf18686', 63.6364, '2020-05-15 20:10:37', 1),
(32, 12, '5ebeccdf18686', 54.5455, '2020-05-15 20:10:50', 1),
(33, 12, '5ebeccdf18686', 54.5455, '2020-05-15 20:11:29', 1),
(34, 12, '5ebeccdf18686', 54.5455, '2020-05-15 20:11:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `useranswer`
--

CREATE TABLE `useranswer` (
  `UserId` bigint(20) UNSIGNED NOT NULL,
  `QuestionId` bigint(20) UNSIGNED NOT NULL,
  `ChoiceId` bigint(20) UNSIGNED NOT NULL,
  `IsCorrect` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(60) NOT NULL,
  `Surname` varchar(60) NOT NULL,
  `BirthDate` date NOT NULL,
  `PasswordHash` varchar(120) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Name`, `Surname`, `BirthDate`, `PasswordHash`, `Email`, `Username`) VALUES
(12, 'Sambo', 'Sambo', '1997-08-01', '$2y$10$1q4kZS6HuB3ZyXB1NBPLxOBz.B8cMsldPDDoHd3h6uLZa3xNlGN56', 'samboking@gmail.com', 'Sambo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id` (`Id`),
  ADD KEY `QuestionId` (`QuestionId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CommenterId` (`AuthorId`) USING BTREE,
  ADD KEY `QuizCommentedId` (`QuizId`) USING BTREE;

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `QuizId` (`QuizId`);

--
-- Indexes for table `quizes`
--
ALTER TABLE `quizes`
  ADD PRIMARY KEY (`QuizId`),
  ADD KEY `AuthorId` (`AuthorId`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id` (`Id`),
  ADD KEY `SolverId` (`SolverId`),
  ADD KEY `QuizId` (`QuizId`) USING BTREE;

--
-- Indexes for table `useranswer`
--
ALTER TABLE `useranswer`
  ADD KEY `UserId` (`UserId`),
  ADD KEY `ChoiceId` (`ChoiceId`),
  ADD KEY `QuestionId` (`QuestionId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id` (`Id`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `choices`
--
ALTER TABLE `choices`
  ADD CONSTRAINT `QIDFK` FOREIGN KEY (`QuestionId`) REFERENCES `questions` (`Id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `CommentedQuizFK` FOREIGN KEY (`QuizId`) REFERENCES `quizes` (`QuizId`),
  ADD CONSTRAINT `CommenterFK` FOREIGN KEY (`AuthorId`) REFERENCES `users` (`Id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `QuizForeignKey` FOREIGN KEY (`QuizId`) REFERENCES `quizes` (`QuizId`);

--
-- Constraints for table `quizes`
--
ALTER TABLE `quizes`
  ADD CONSTRAINT `AuthorId` FOREIGN KEY (`AuthorId`) REFERENCES `users` (`Id`);

--
-- Constraints for table `useranswer`
--
ALTER TABLE `useranswer`
  ADD CONSTRAINT `CHIPK` FOREIGN KEY (`ChoiceId`) REFERENCES `choices` (`Id`),
  ADD CONSTRAINT `QuIDPK` FOREIGN KEY (`QuestionId`) REFERENCES `questions` (`Id`),
  ADD CONSTRAINT `UIDPK` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

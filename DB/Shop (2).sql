-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 13, 2018 at 04:49 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(12, 'nokia', 'aedf', 9, 5, 0, 0, 0),
(13, 'aevasdv', 'sgevase', 6, 0, 1, 0, 0),
(17, 'qwqd', 'dqwdq', 10, 0, 0, 0, 0),
(18, 'wqdqwds', 'Good Gamed', 10, 0, 0, 0, 0),
(20, 'eqdqed', 'Good Gamed', 14, 0, 0, 0, 0),
(21, 'ضثصصي', 'يضثي', 19, 0, 0, 0, 0),
(22, 'Games', 'Good Game', 0, 54, 0, 0, 0),
(23, 'Books', 'Different', 0, 20, 0, 0, 0),
(24, 'playstation', 'exelent Game', 22, 6, 0, 0, 0),
(25, 'History Books', 'good books', 23, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(1, '			\r\n		Hello', 1, '2018-04-13', 14, 43),
(2, '			Good Book\r\n		', 0, '2018-04-13', 13, 43),
(3, '			Good Book\r\n		', 0, '2018-04-13', 13, 43);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Tag` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `Tag`) VALUES
(13, 'Arabic Books', 'perfect Books', '120', '2018-04-13', 'egypt', '', '1', 0, 1, 23, 40, 'Famous'),
(14, 'MathBook', 'Cheap', '20', '2018-04-13', 'China', '', '3', 0, 1, 23, 43, 'book'),
(15, 'pes2016', 'Good Gamee', '54', '2018-04-13', 'German', '', '2', 0, 1, 24, 46, 'game'),
(16, 'pes2016', 'Good Gamesss', '212', '2018-04-13', 'Egypt', '', '2', 0, 0, 22, 43, 'qedqed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `TrustStatus` int(11) NOT NULL DEFAULT '0',
  `RegStatus` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(6, 'ahmed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'wsx@sj.com', 'aedq', 1, 0, 1, '0000-00-00', ''),
(39, 'Yousif', '36a27136f3015f5ed0e1fe268ad7a93a985196cf', 'y.aamerrr@yahoo.com', '', 0, 0, 1, '2018-04-11', ''),
(40, 'mohamedsalah', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mm@yahoo.com', '', 0, 0, 1, '2018-04-11', ''),
(43, 'midoo', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mooo@yahoo.com', '', 0, 0, 1, '2018-04-12', ''),
(44, 'mahmoud', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'y.aamerrr@yahoo.com', 'hoda', 0, 0, 1, '2018-04-13', '25237_fantastic-tropical-beach-background-1680x1050-190.jpg'),
(45, 'ahmedd', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'laetmaak@hotmail.com', 'JOsef', 0, 0, 1, '2018-04-13', '38249_29792131_944196329091602_4452487581235077512_n.jpg'),
(46, 'mody', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'jj@yahoo.com', '', 0, 0, 0, '2018-04-13', ''),
(47, 'josef', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'jio@yaoo.com', '', 0, 0, 0, '2018-04-13', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

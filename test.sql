-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2023 at 02:46 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `fontes`
--

CREATE TABLE `fontes` (
  `id` int(11) NOT NULL,
  `fonte` varchar(50) NOT NULL,
  `url` text NOT NULL,
  `exe_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fontes`
--

INSERT INTO `fontes` (`id`, `fonte`, `url`, `exe_url`) VALUES
(1, 'River', '', ''),
(2, 'Motorway', '', ''),
(3, 'Public', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `old_title` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `resumo` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `link` varchar(200) NOT NULL,
  `publicado` int(11) NOT NULL,
  `img` text NOT NULL,
  `fonte_id` int(11) NOT NULL,
  `user1` varchar(11) NOT NULL,
  `editing` int(11) NOT NULL,
  `temat_id` int(11) DEFAULT NULL,
  `guid` text NOT NULL,
  `new_date` datetime NOT NULL,
  `ave` text NOT NULL,
  `highlighted` text NOT NULL,
  `favoratibilidade` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `noticias`
--

INSERT INTO `noticias` (`id`, `title`, `old_title`, `text`, `resumo`, `estado`, `date`, `link`, `publicado`, `img`, `fonte_id`, `user1`, `editing`, `temat_id`, `guid`, `new_date`, `ave`, `highlighted`, `favoratibilidade`) VALUES
(1, 'Testing 1', '', 'This is just a normal test to see it work', 'LETS GOOOOOO', 1, '2023-07-11 00:00:00', '', 0, 'Img aaaaaaa       ', 1, 's', 0, NULL, '', '2023-09-12 14:06:52', '1', 'nao realcar', '1'),
(2, 'test 2', '', 'This evening in a river in a small vilage 2 elderly people fell', 'Some people fell in a river', 1, '2023-07-13 00:00:00', '', 0, 'Img bbbbbbbbbb   ', 1, 's', 0, NULL, '', '2023-07-19 23:15:36', '1', 'nao realcar', '1'),
(3, 'Test second source', '', 'Testing to see the second source works correctly', 'Its working correctly as it should', 1, '2023-09-11 00:00:00', '', 0, 'aaaaaa', 2, 'a', 0, NULL, '', '0000-00-00 00:00:00', '1', 'nao realcar', '1'),
(4, 'Test second source 2', '', 'There was a colision between 2 cars going up the m1', 'Accident in M1', 1, '2023-09-11 00:00:00', '', 0, 'aaaaaa', 2, 'a', 0, NULL, '', '0000-00-00 00:00:00', '1', 'nao realcar', '1'),
(5, 'Test third source', '', 'Very simple test', 'Its working correctly as it should', 1, '2023-09-11 00:00:00', '', 0, 'aaaaaa', 3, 'a', 0, NULL, '', '0000-00-00 00:00:00', '1', 'nao realcar', '1'),
(6, 'Swimming event', '', 'Hitting record high temperatures and a heatwaves the public pool of made up villave will have a free', 'next sunday public pool will be free', 1, '2023-09-11 00:00:00', '', 1, 'aaaaaa', 3, '[object HTM', 0, 0, '', '2023-09-12 14:44:36', '1', 'nao realcar', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tematicas`
--

CREATE TABLE `tematicas` (
  `id` int(11) NOT NULL,
  `tematica` text NOT NULL,
  `other_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tematicas`
--

INSERT INTO `tematicas` (`id`, `tematica`, `other_id`) VALUES
(4, 'people', 0),
(5, 'river', 0),
(6, 'M1', 0),
(7, 'heatwave', 0),
(8, 'elderly', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `logged` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`user_id`, `user_name`, `password`, `logged`) VALUES
(1, 'Asgardan', 'a', 1),
(2, 'Sully', 'a', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fontes`
--
ALTER TABLE `fontes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tematicas`
--
ALTER TABLE `tematicas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fontes`
--
ALTER TABLE `fontes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tematicas`
--
ALTER TABLE `tematicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

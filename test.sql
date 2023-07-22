-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2023 at 07:11 PM
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
(1, 'a', '', '');

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
  `temat_id` int(11) NOT NULL,
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
(1, 'Publicado', '', 'No contexto do desporto escolar', 'BORA CARALHO', 1, '2023-07-11 00:00:00', '', 0, 'Img aaaaaaa    ', 1, 'a', 1, 0, '', '2023-07-19 23:21:26', '1', 'realcar', '1'),
(2, 'ww', '', '12412412', 'bbb', 1, '2023-07-13 00:00:00', '', 0, 'Img bbbbbbbbbb   ', 1, 'a', 0, 0, '', '2023-07-19 23:15:36', '1', 'nao realcar', '1');

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
(1, 'Tema', 0),
(2, 'desporto', 959228515),
(3, 'escolar', 240295410);

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
(1, 'a', 'a', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tematicas`
--
ALTER TABLE `tematicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

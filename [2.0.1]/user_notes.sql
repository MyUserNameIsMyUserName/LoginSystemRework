-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 14, 2018 at 05:25 PM
-- Server version: 5.7.11-0ubuntu6
-- PHP Version: 7.0.4-7ubuntu2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_notess`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_notes`
--

CREATE TABLE `user_notes` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `note_content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_notes`
--

INSERT INTO `user_notes` (`id`, `owner_id`, `name`, `note_content`) VALUES
(1, 3, 'Aggi Southworth', 'asouthwor th0aso uthwor th0asou thworth0'),
(2, 2, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(3, 4, 'Ivett Westley', 'asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0'),
(4, 4, 'Libby Styant', 'asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0'),
(5, 1, 'Bernete Tisun', 'asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0'),
(6, 6, 'Carlen Ranklin', 'asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0'),
(7, 5, 'Ardra Nafzger', 'asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0'),
(8, 5, 'Aubert Tennison', 'asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0'),
(9, 3, 'Francklin Izod', 'asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0asouthworth0'),
(10, 3, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(11, 2, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(12, 5, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(13, 2, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(14, 4, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(15, 2, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(16, 5, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(17, 2, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(18, 4, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(19, 2, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(20, 3, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0'),
(21, 3, 'Thornie Diggons', 'asout hw orth0aso uth wo rth0aso uthworth0a sout hw ort h0asout hworth 0asout hworth0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_notes`
--
ALTER TABLE `user_notes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_notes`
--
ALTER TABLE `user_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

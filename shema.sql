-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2026 at 04:54 PM
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
-- Database: `portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorije`
--

CREATE TABLE `kategorije` (
  `id` int(11) NOT NULL,
  `naziv` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `kategorije`
--

INSERT INTO `kategorije` (`id`, `naziv`) VALUES
(4, 'Sport'),
(5, 'Kultura');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `ime` varchar(64) NOT NULL,
  `prezime` varchar(64) NOT NULL,
  `korisnicko_ime` varchar(64) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razina` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(2, 'Alojz', 'Rubinić', 'alojz.rubinic', '$2y$10$N/gekqtZSPOjtFFj7BV2AO/ezn6jjf6MfYdj2ePfX85VVtPqkOOgG', 1),
(8, 'Martin', 'Brdarić', 'martin.brdaric', '$2y$10$RbfGwhVs5i3IhFcECNqjrOx62evTRnhWRNd2kf8DT4FV.4mHSdzoO', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `naslov` varchar(128) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(64) NOT NULL,
  `arhiva` tinyint(1) NOT NULL DEFAULT 0,
  `idKategorije` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `arhiva`, `idKategorije`) VALUES
(9, '2026-06-16 19:14:29', 'USA REPORT 24SATA Alexandria bez \'vatrenih\' ne izgleda isto!', 'blah blah', 'ALEXANDRIA - Hrvatska nogometna reprezentacija nalazi se u Dallasu, gdje će u srijedu odigrati utakmicu prvog kola Svjetskog prvenstva protiv Engleske. Reporter 24sata, Hrvoje Tironi, i dalje je u Alexandriji. Javio nam se s dojmovima iz američkog grada koji sad izgleda sasvim drugačije nego prije tjedan dana', 'img_6a318475e53070.71992980.jpg', 1, 5),
(11, '2026-06-16 19:17:36', 'sdfs', 'fsdfsdf', 'sdfsdf', 'img_6a31853021e027.92332383.jpg', 0, 5),
(12, '2026-06-16 19:18:57', 'asff', 'asfa', 'ffAFAsf', 'img_6a31858196f622.55920319.jpg', 0, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategorije`
--
ALTER TABLE `kategorije`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vijest_kategorija` (`idKategorije`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorije`
--
ALTER TABLE `kategorije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD CONSTRAINT `fk_vijest_kategorija` FOREIGN KEY (`idKategorije`) REFERENCES `kategorije` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

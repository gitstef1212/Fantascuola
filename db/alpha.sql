-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2022 at 05:42 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fantint`
--

-- --------------------------------------------------------

--
-- Table structure for table `criteri`
--

CREATE TABLE `criteri` (
  `id` int(11) NOT NULL,
  `sigla` varchar(12) NOT NULL,
  `nome` varchar(12) NOT NULL,
  `punti` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `criteri`
--

INSERT INTO `criteri` (`id`, `sigla`, `nome`, `punti`) VALUES
(1, '6 .. 8.5', 'Da 6 a 8.5', 3),
(2, '>= 8.5', 'Sopra 8.5', 5),
(3, '<= 6', 'Sotto 6', 1),
(4, 'G', 'Giustifica', -3),
(5, 'V', 'Volontario', 1),
(6, 'x 2', 'Doppietta', 5),
(7, 'x 3', 'Tripletta', 7),
(8, 'INF', 'Infamata', -5),
(9, 'W-Win', 'I Settimana', 2),
(10, 'W-Sec', 'II Settimana', 1);

-- --------------------------------------------------------

--
-- Table structure for table `giocatori`
--

CREATE TABLE `giocatori` (
  `id` int(11) NOT NULL,
  `proprietario` int(11) DEFAULT NULL,
  `nome` varchar(25) NOT NULL,
  `punti` int(11) NOT NULL DEFAULT 0,
  `attivo` tinyint(1) NOT NULL DEFAULT 0,
  `ultimoVoto` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `giocatori`
--

INSERT INTO `giocatori` (`id`, `proprietario`, `nome`, `punti`, `attivo`, `ultimoVoto`) VALUES
(1, 2, 'Antonio Boscaro', 0, 1, '2022-10-05'),
(2, 1, 'Carlo Chillemi', 0, 1, '2022-10-06'),
(3, 1, 'Sofia Colucci', 0, 0, '0000-00-00'),
(4, 3, 'Paola D Angelo', 0, 1, '0000-00-00'),
(5, 3, 'Emanuele De Angelis', 0, 0, '0000-00-00'),
(6, 3, 'Alessio De Cesare', 0, 1, '0000-00-00'),
(7, 1, 'Silvia De Nardis', 0, 1, '2022-10-05'),
(8, 2, 'Delfo Galante', 0, 0, '0000-00-00'),
(9, 1, 'Mia Galante', 0, 0, '0000-00-00'),
(10, 3, 'Andrea Gardella', 0, 0, '0000-00-00'),
(11, 2, 'Chiara Gatto', 0, 0, '0000-00-00'),
(12, NULL, 'Matteo Giancristofaro', 0, 0, '0000-00-00'),
(13, 2, 'Stefano Manauzzi', 0, 1, '2022-10-06'),
(14, 3, 'Alessandra Mancini', 0, 0, '0000-00-00'),
(15, NULL, 'Gabriele Milani', 0, 0, '0000-00-00'),
(16, 1, 'Riccardo Pacchiarotti', 0, 0, '0000-00-00'),
(17, 1, 'Gabriele Paggiossi', 0, 0, '0000-00-00'),
(18, 3, 'Lorenzo Pazienza', 0, 1, '0000-00-00'),
(19, 2, 'Krystal Perna', 0, 1, '0000-00-00'),
(20, 1, 'Luca Pontesilli', 0, 1, '0000-00-00'),
(21, 2, 'Alessandro Quadrini', 0, 0, '0000-00-00'),
(22, 2, 'Beatrice Rizzuto', 0, 0, '0000-00-00'),
(23, NULL, 'Francesco Scaldarella', 0, 0, '0000-00-00'),
(24, 1, 'Lavinia Soldera', 0, 1, '0000-00-00'),
(25, 2, 'Martina Torre', 0, 1, '2022-10-05'),
(26, 3, 'Matteo Uccellini', 0, 1, '2022-10-06'),
(27, 3, 'Siria Zoratto', 0, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `materie`
--

CREATE TABLE `materie` (
  `id` int(11) NOT NULL,
  `nome` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materie`
--

INSERT INTO `materie` (`id`, `nome`) VALUES
(1, 'Matematica'),
(2, 'Fisica'),
(3, 'Scienze'),
(4, 'Arte'),
(5, 'Inglese'),
(6, 'Filosofia'),
(7, 'Latino'),
(8, 'Italiano'),
(9, 'Storia'),
(10, 'Ed Fisica'),
(11, 'Religione'),
(12, 'Ed Civica');

-- --------------------------------------------------------

--
-- Table structure for table `punti`
--

CREATE TABLE `punti` (
  `id` int(11) NOT NULL,
  `giocatore` int(11) DEFAULT NULL,
  `sfidante` int(11) NOT NULL,
  `evento` varchar(15) NOT NULL,
  `puntiii` int(11) NOT NULL,
  `materia` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `autore` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sfidanti`
--

CREATE TABLE `sfidanti` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nome` varchar(24) DEFAULT NULL,
  `punti` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sfidanti`
--

INSERT INTO `sfidanti` (`id`, `username`, `password`, `nome`, `punti`) VALUES
(1, 'FraBoss', '#n2Waf3UKf&08TAFj2', 'Francesco Scaldarella', 0),
(2, 'GinoPanino', 'baconcroccante', 'Gabriele Milani', 0),
(3, 'Giancro', 'Gigrossa', 'Matteo Giancristofaro', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `criteri`
--
ALTER TABLE `criteri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `giocatori`
--
ALTER TABLE `giocatori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materie`
--
ALTER TABLE `materie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `punti`
--
ALTER TABLE `punti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sfidanti`
--
ALTER TABLE `sfidanti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `criteri`
--
ALTER TABLE `criteri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `giocatori`
--
ALTER TABLE `giocatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `materie`
--
ALTER TABLE `materie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `punti`
--
ALTER TABLE `punti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `sfidanti`
--
ALTER TABLE `sfidanti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

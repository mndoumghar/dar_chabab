-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12 يونيو 2025 الساعة 02:17
-- إصدار الخادم: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dar_chabab`
--

-- --------------------------------------------------------

--
-- بنية الجدول `activites`
--

CREATE TABLE `activites` (
  `id` int(11) NOT NULL,
  `titre` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_activite` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `activites`
--

INSERT INTO `activites` (`id`, `titre`, `description`, `date_activite`, `image`) VALUES
(1, 'ورشة البرمجة', 'تعلم أساسيات البرمجة بلغة PHP', '2025-06-15', ''),
(2, 'sPORT DAKHLA', 'La péninsule de Dakhla, nichée au sud-ouest du Sahara marocain, offre des conditions optimales pour les sports nautiques, en particulier le surf et le kitesurf.\n', '2025-06-20', ''),
(4, 'CTF CYBER', 'Un concours de hacking (Capture The Flag) pour mettre à l\'épreuve les compétences des participants et encourager l\'innovation en cybersécurité.\n', '2025-06-24', 'IMG_5385.jpg');

-- --------------------------------------------------------

--
-- بنية الجدول `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_inscription` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `membres`
--

INSERT INTO `membres` (`id`, `nom`, `email`, `password`, `date_inscription`) VALUES
(1, 'mohamed', 'mohamedndomghar@gmail.com', '$2y$10$31nf7VpVuDe90b4wcma.zuuX9fHqriVr3n0XJEhzvFQugldEVyN0G', '2025-06-09 10:25:33'),
(2, 'mohamed', 'mohamed@gmail.com', '$2y$10$bOAhsPKeNzzh6Bpk4UXJP.4R3bxs3LnHWJvHO22rkb/Kq6Y3Rik3q', '2025-06-11 23:30:57'),
(3, 'kol', 'cxvx@bgf.com', '$2y$10$NZyGKnngixEvXTUXY55i1uU244NmTaQk8UigigJoXGfDjzJhOk.tS', '2025-06-12 00:00:56');

-- --------------------------------------------------------

--
-- بنية الجدول `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `membre_id` int(11) DEFAULT NULL,
  `salle_id` int(11) DEFAULT NULL,
  `date_reservation` date DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `statut` varchar(20) DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `reservations`
--

INSERT INTO `reservations` (`id`, `membre_id`, `salle_id`, `date_reservation`, `heure_debut`, `heure_fin`, `statut`) VALUES
(1, 1, 1, '2025-06-10', '10:27:00', '04:27:00', 'accepte'),
(2, 1, 2, '2025-06-10', '10:30:00', '02:28:00', 'en attente'),
(3, 1, 2, '2025-06-10', '11:27:00', '05:24:00', 'en attente'),
(4, 2, 3, '2025-06-12', '00:00:00', '02:00:00', 'en attente');

-- --------------------------------------------------------

--
-- بنية الجدول `salles`
--

CREATE TABLE `salles` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `capacite` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `salles`
--

INSERT INTO `salles` (`id`, `nom`, `capacite`, `description`) VALUES
(1, 'قاعة الرياضة', 50, 'قاعة مخصصة للرياضة والتمارين'),
(2, 'قاعة الحاسوب', 30, 'قاعة مجهزة بأجهزة الحاسوب'),
(3, 'قاعة الاجتماعات', 20, 'قاعة مخصصة للاجتماعات والورشات');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activites`
--
ALTER TABLE `activites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `membre_id` (`membre_id`),
  ADD KEY `salle_id` (`salle_id`);

--
-- Indexes for table `salles`
--
ALTER TABLE `salles` 
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activites`
--
ALTER TABLE `activites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`salle_id`) REFERENCES `salles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

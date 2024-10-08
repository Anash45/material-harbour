-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2024 at 01:04 AM
-- Server version: 8.0.35
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `material_harbour`
--

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE `conditions` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conditions`
--

INSERT INTO `conditions` (`id`, `name`) VALUES
(1, 'F'),
(2, 'H12'),
(3, 'H14'),
(4, 'H16'),
(5, 'H18'),
(6, 'H19'),
(7, 'H22'),
(8, 'H24'),
(9, 'H26'),
(10, 'H28'),
(11, 'H29'),
(12, 'H32'),
(13, 'H34'),
(14, 'H36'),
(15, 'H38'),
(16, 'H39'),
(17, 'O'),
(18, 'T1'),
(19, 'T2'),
(20, 'T3'),
(21, 'T31'),
(22, 'T351'),
(23, 'T3511'),
(24, 'T36'),
(25, 'T37'),
(26, 'T4'),
(27, 'T42'),
(28, 'T451'),
(29, 'T4511'),
(30, 'T5'),
(31, 'T510'),
(32, 'T511'),
(33, 'T51'),
(34, 'T52'),
(35, 'T54'),
(36, 'T6'),
(37, 'T61'),
(38, 'T611'),
(39, 'T62'),
(40, 'T651'),
(41, 'T6510'),
(42, 'T6511'),
(43, 'T652'),
(44, 'T7'),
(45, 'T73'),
(46, 'T7351'),
(47, 'T73511'),
(48, 'T7352'),
(49, 'T8'),
(50, 'T81'),
(51, 'T851'),
(52, 'T8511'),
(53, 'T86'),
(54, 'T87'),
(55, 'T9'),
(56, 'T10'),
(57, 'W');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`) VALUES
(1, 'BAR'),
(2, 'EXTRUSION'),
(3, 'PLATE'),
(4, 'ROD'),
(5, 'SHEET'),
(6, 'TUBE');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_phone` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `offers` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `company_name`, `location`, `contact_phone`, `offers`, `description`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Future Tech', 'FSD', '33994040353', 'Aluminium', 'Acdha cjhas hjsa dhsd sla dksf shdf dafhhd shf dsd fdjsf kdsf jsdf dsjkfdsjfhdsa', 'abc@xyz.com', '$2y$10$Ze6PvGOhqAheFACSYUDqTu5GB3Z8rs/knUAJxIZg63pTs5BhzG26q', '2024-06-28 21:16:05', '2024-06-28 21:16:05');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int NOT NULL,
  `material_standard` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `material_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '',
  `alloy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '',
  `condition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '',
  `form` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '',
  `supplier_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `material_standard`, `material_type`, `alloy`, `type`, `condition`, `form`, `supplier_id`, `created_at`, `updated_at`) VALUES
(23, 'Raw material', 'Aluminum', '1050', '', 'F', 'BAR', 1, '2024-06-28 22:39:30', '2024-06-28 22:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `material_types`
--

CREATE TABLE `material_types` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `material_types`
--

INSERT INTO `material_types` (`id`, `name`) VALUES
(1, 'Raw Material'),
(2, 'Milled Part'),
(3, 'Casting'),
(4, 'Weldment'),
(5, '3D Printing'),
(6, 'Machining'),
(7, 'Forging'),
(8, 'Molding');

-- --------------------------------------------------------

--
-- Table structure for table `raw_materials`
--

CREATE TABLE `raw_materials` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `raw_materials`
--

INSERT INTO `raw_materials` (`id`, `name`) VALUES
(1, 'Aluminum'),
(2, 'ALClad'),
(3, 'Carbon'),
(4, 'Epoxy'),
(5, 'Fiberglass'),
(6, 'Glass'),
(7, 'Phenolic'),
(8, 'Resin'),
(9, 'Stainless Steel'),
(10, 'Steel'),
(11, 'Titanium'),
(12, 'Plastic'),
(13, 'Rubber/ Elastomer');

-- --------------------------------------------------------

--
-- Table structure for table `rm_alloys`
--

CREATE TABLE `rm_alloys` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rm_alloys`
--

INSERT INTO `rm_alloys` (`id`, `name`) VALUES
(1, '1050'),
(2, '1060'),
(3, '1070'),
(4, '1100'),
(5, '1145'),
(6, '1199'),
(7, '1200'),
(8, '1230'),
(9, '1350'),
(10, '1370'),
(11, '1420'),
(12, '1421'),
(13, '1424'),
(14, '1430'),
(15, '1440'),
(16, '1441'),
(17, '1441K'),
(18, '1445'),
(19, '1450'),
(20, '1460'),
(21, 'V1461'),
(22, 'V1464'),
(23, 'V1469'),
(24, '2004'),
(25, '2011'),
(26, '2014'),
(27, '2017'),
(28, '2020'),
(29, '2024'),
(30, '2029'),
(31, '2036'),
(32, '2048'),
(33, '2055'),
(34, '2080'),
(35, '2090'),
(36, '2091'),
(37, '2094'),
(38, '2095'),
(39, '2097'),
(40, '2098'),
(41, '2099'),
(42, '2124'),
(43, '2195'),
(44, '2196'),
(45, '2197'),
(46, '2198'),
(47, '2218'),
(48, '2219'),
(49, '2297'),
(50, '2397'),
(51, '2224'),
(52, '2324'),
(53, '2319'),
(54, '2519'),
(55, '2524'),
(56, '2618'),
(57, '3003'),
(58, '3004'),
(59, '3005'),
(60, '3102'),
(61, '3103'),
(62, '3105'),
(63, '3203'),
(64, '4006'),
(65, '4007'),
(66, '4015'),
(67, '4032'),
(68, '4043'),
(69, '4047'),
(70, '4543'),
(71, '4643'),
(72, '5005'),
(73, '5010'),
(74, '5019'),
(75, '5024'),
(76, '5026'),
(77, '5050'),
(78, '5052'),
(79, '5056'),
(80, '5059'),
(81, '5083'),
(82, '5086'),
(83, '5154'),
(84, '5182'),
(85, '5252'),
(86, '5356'),
(87, '5454'),
(88, '5456'),
(89, '5457'),
(90, '5557'),
(91, '5754'),
(92, '6005'),
(93, '6005A'),
(94, '6009'),
(95, '6010'),
(96, '6013'),
(97, '6022'),
(98, '6060'),
(99, '6061'),
(100, '6063'),
(101, '6063A'),
(102, '6065'),
(103, '6066'),
(104, '6070'),
(105, '6081'),
(106, '6082'),
(107, '6101'),
(108, '6105'),
(109, '6113'),
(110, '6151'),
(111, '6162'),
(112, '6201'),
(113, '6205'),
(114, '6262'),
(115, '6351'),
(116, '6463'),
(117, '6951'),
(118, '7005'),
(119, '7010'),
(120, '7022'),
(121, '7034'),
(122, '7039'),
(123, '7049'),
(124, '7050'),
(125, '7055'),
(126, '7065'),
(127, '7068'),
(128, '7072'),
(129, '7075'),
(130, '7079'),
(131, '7085'),
(132, '7090'),
(133, '7091'),
(134, '7093'),
(135, '7116'),
(136, '7129'),
(137, '7150'),
(138, '7178'),
(139, '7255'),
(140, '7475'),
(141, '8006'),
(142, '8009'),
(143, '8011'),
(144, '8014'),
(145, '8019'),
(146, '8025'),
(147, '8030'),
(148, '8090'),
(149, '8091'),
(150, '8093'),
(151, '8176');

-- --------------------------------------------------------

--
-- Table structure for table `ss_alloys`
--

CREATE TABLE `ss_alloys` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ss_alloys`
--

INSERT INTO `ss_alloys` (`id`, `name`) VALUES
(1, '201'),
(2, '202'),
(3, '204'),
(4, '205'),
(5, '301'),
(6, '302'),
(7, '303'),
(8, '304'),
(9, '309'),
(10, '316'),
(11, '321'),
(12, '408'),
(13, '409'),
(14, '410'),
(15, '416'),
(16, '420'),
(17, '430'),
(18, '440'),
(19, '630');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contact_phone` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `offers` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `company_name`, `location`, `contact_phone`, `offers`, `description`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Supplier FT', 'LHR', '12341234123', 'Alclad', 'aks dhja djs dad jasdhd jd asj', 'abc@xyz.com', '$2y$10$FMTP.Ah60WhkmR836PtaUuZIvYM2l5q7WR89TOFhMfxQ.IxmHlwgy', '2024-06-28 21:30:21', '2024-06-28 21:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `s_alloys`
--

CREATE TABLE `s_alloys` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `s_alloys`
--

INSERT INTO `s_alloys` (`id`, `name`) VALUES
(1, '1008'),
(2, '1010'),
(3, '1012'),
(4, '1015'),
(5, '1018'),
(6, '1020'),
(7, '1025'),
(8, '1026'),
(9, '1070'),
(10, '1074'),
(11, '1075'),
(12, '1080'),
(13, '1090'),
(14, '1095'),
(15, '1213'),
(16, '1215'),
(17, '4130'),
(18, '4135'),
(19, '4140'),
(20, '4340'),
(21, '6150'),
(22, '8620'),
(23, '8630'),
(24, '8254'),
(25, '9310');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conditions`
--
ALTER TABLE `conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `material_types`
--
ALTER TABLE `material_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raw_materials`
--
ALTER TABLE `raw_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rm_alloys`
--
ALTER TABLE `rm_alloys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ss_alloys`
--
ALTER TABLE `ss_alloys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `s_alloys`
--
ALTER TABLE `s_alloys`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conditions`
--
ALTER TABLE `conditions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `material_types`
--
ALTER TABLE `material_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `raw_materials`
--
ALTER TABLE `raw_materials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rm_alloys`
--
ALTER TABLE `rm_alloys`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `ss_alloys`
--
ALTER TABLE `ss_alloys`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `s_alloys`
--
ALTER TABLE `s_alloys`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

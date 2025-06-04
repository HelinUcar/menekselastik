-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 10:05 PM
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
-- Database: `menekselastik`
--

-- --------------------------------------------------------

--
-- Table structure for table `home_page`
--

CREATE TABLE `home_page` (
  `id` int(11) NOT NULL,
  `main_video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `about_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `about_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `home_page`
--

INSERT INTO `home_page` (`id`, `main_video`, `about_title`, `about_content`) VALUES
(1, 'https://www.youtube.com/watch?v=TFJjBon_9Jo', 'Menekşe Lastik: Güvenli Sürüş İçin Profesyonel Hizmet', '<p class=\"about-four__text\">Lastik ve jant &ccedil;&ouml;z&uuml;mlerinde yılların deneyimiyle, aracınızın yol tutuşunu ve g&uuml;venliğini en &uuml;st seviyeye &ccedil;ıkarıyoruz. Lastik değişimi, balans ayarı, jant d&uuml;zeltme ve tamir hizmetlerimizle her zaman yanınızdayız.Lastik ve jant &ccedil;&ouml;z&uuml;mlerinde yılların deneyimiyle, aracınızın yol tutuşunu ve g&uuml;venliğini en &uuml;st seviyeye &ccedil;ıkarıyoruz. Lastik değişimi, balans ayarı, jant d&uuml;zeltme ve tamir hizmetlerimizle her zaman yanınızdayız.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`, `country`, `website`) VALUES
(1, 'Lassa', 'Türkiye', 'https://www.lassa.com.tr'),
(2, 'Bridgestone', 'Japonya', 'https://www.bridgestone.com.tr'),
(3, 'Dayton', 'ABD', 'https://www.dayton.com.tr');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'manager'),
(3, 'salesperson'),
(4, 'service');

-- --------------------------------------------------------

--
-- Table structure for table `seo_settings`
--

CREATE TABLE `seo_settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `google_verify` varchar(255) NOT NULL,
  `yandex_verify` varchar(255) NOT NULL,
  `google_api_key` varchar(255) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  `logo_text` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `name_prefix` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seo_settings`
--

INSERT INTO `seo_settings` (`id`, `title`, `description`, `keywords`, `google_verify`, `yandex_verify`, `google_api_key`, `place_id`, `logo_text`, `email`, `phone`, `whatsapp`, `facebook`, `instagram`, `name_prefix`) VALUES
(1, 'Menekşe Lastik | Bridgestone Bayisi', 'Menekşe Lastik, Ankara&#039;da lastik ve jant satışı, değişimi ve onarımı hizmetleri sunan güvenilir bir markadır. Kaliteli lastik ve jant çözümleriyle profesyonel servis anlayışıyla müşterilerine hizmet vermektedir.', 'Menekşe Lastik, lastik satışı, jant satışı, lastik değişimi, jant değişimi, lastik onarımı, jant onarımı, oto lastik servisi, Ankara lastik, Ankara jant, kış lastiği, yaz lastiği, 4 mevsim lastik, oto bakım, balans ayarı, jant düzeltme, lastik tamiri', 'google-site-verification', 'yandex-site-verification', 'AIzaSyCn15QowiP64kdJ9NVas4gJtwl47SH7DLM', 'ChIJp_6BldJL0xQRPr-b-5TaLwQ', 'Menekşe Lastik', 'info@menekselastik.com', '+90 (312) 511 24 44', '+90 (536) 060 00 37', 'https://www.facebook.com/p/Menek%C5%9Fe-Lastik-100069615523907/?locale=tr_TR', 'https://www.instagram.com/menekselastik/', 'menekse_lastik_');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `tire_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `warehouse_location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tires`
--

CREATE TABLE `tires` (
  `id` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `width` int(11) NOT NULL,
  `aspect_ratio` int(11) NOT NULL,
  `rim_diameter` varchar(10) NOT NULL,
  `load_index` varchar(10) DEFAULT NULL,
  `speed_rating` varchar(5) DEFAULT NULL,
  `season` enum('Yaz','Kış','Dört Mevsim') NOT NULL,
  `run_flat` tinyint(1) DEFAULT 0,
  `price` decimal(10,2) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userphoto` varchar(255) DEFAULT NULL,
  `useremail` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `usersurname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userphoto`, `useremail`, `username`, `usersurname`, `password`, `token`, `created_at`, `role_id`) VALUES
(1, NULL, 'helinduyguucar@gmail.com', 'Helin', 'Uçar', '$2y$10$s1H7Xycfr58715aUPSCd4epWQqxgBo/uPc7.pBqwY0nx4vMNyOyAO', '46edfa51e10ec67356498803b86017e473cb2eac9ed1e934d0ed471bb1d269abf11bf8c983adc1fc93d5810fbdc05724a0b2', '2021-02-01 13:46:21', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `home_page`
--
ALTER TABLE `home_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `seo_settings`
--
ALTER TABLE `seo_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tire_id` (`tire_id`);

--
-- Indexes for table `tires`
--
ALTER TABLE `tires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `useremail` (`useremail`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `home_page`
--
ALTER TABLE `home_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seo_settings`
--
ALTER TABLE `seo_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tires`
--
ALTER TABLE `tires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`tire_id`) REFERENCES `tires` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tires`
--
ALTER TABLE `tires`
  ADD CONSTRAINT `fk_tires_brands` FOREIGN KEY (`manufacturer_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tires_ibfk_1` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

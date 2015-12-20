-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 20 Ara 2015, 21:32:13
-- Sunucu sürümü: 5.5.46-0+deb8u1
-- PHP Sürümü: 5.6.14-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `gpstakipsistemi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
`idlocations` int(11) NOT NULL,
  `idusers` int(11) NOT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `locations`
--

INSERT INTO `locations` (`idlocations`, `idusers`, `latitude`, `longitude`, `time`) VALUES
(1, 6, '40.8793413', '29.2493802', '2015-12-05 00:00:00'),
(2, 6, '40.541029', '28.907594', '2015-12-05 02:00:00'),
(3, 6, '40.788675', '29.932083', '2015-12-06 00:00:00'),
(4, 6, '39.768084', '32.819092', '2015-12-07 00:00:00'),
(5, 6, '40.788968', '29.455594', '2015-12-05 00:00:00'),
(6, 3, '39.731451', '30.559926', '2015-12-05 01:00:00'),
(7, 3, '38.486888', '35.465306', '2015-12-20 19:00:00'),
(8, 3, '39.824327', '32.850560', '2015-12-18 00:00:00'),
(9, 3, '40.043355', '26.511449', '2015-12-03 00:00:00'),
(10, 3, '41.152778', '27.654027', '2015-12-05 01:20:00'),
(11, 3, '40.8793413', '29.249382', '2015-12-20 02:17:08'),
(12, 3, '40.8793413', '29.249382', '2015-12-20 02:12:24'),
(13, 3, '40.8793413', '29.249382', '2015-12-20 02:13:36'),
(14, 3, '40.8793413', '29.249382', '2015-12-20 19:24:08'),
(15, 6, '40.8632247', '29.2935463', '2015-12-20 19:27:37'),
(16, 6, '40.8631936', '29.2935833', '2015-12-20 19:33:34'),
(17, 6, '40.8632051', '29.2935744', '2015-12-20 19:38:34'),
(18, 7, '40.8632102', '29.2935813', '2015-12-20 19:41:57'),
(19, 6, '40.8631861', '29.293569', '2015-12-20 19:43:34'),
(20, 7, '40.8631668', '29.2935294', '2015-12-20 19:47:03'),
(21, 7, '40.8632111', '29.2935732', '2015-12-20 20:00:54'),
(22, 6, '40.8630852', '29.2932898', '2015-12-20 20:08:25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `location_now`
--

CREATE TABLE IF NOT EXISTS `location_now` (
`idlocationnow` int(11) NOT NULL,
  `idusers` int(11) DEFAULT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `location_now`
--

INSERT INTO `location_now` (`idlocationnow`, `idusers`, `latitude`, `longitude`, `time`) VALUES
(1, 1, '40.8793413', '29.249382', '2015-12-10 00:36:14'),
(2, 3, '40.8793413', '29.249382', '2015-12-21 02:24:23'),
(3, 6, '40.8632249', '29.2935758', '2015-12-20 20:12:29'),
(4, 7, '40.8632027', '29.2935459', '2015-12-20 20:04:25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`idusers` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `imei` varchar(45) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `web` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`idusers`, `name`, `surname`, `email`, `password`, `imei`, `status`, `web`, `created_at`) VALUES
(1, 'Ahmet', 'Çakırcı', 'ahmetcakirci@gmail.com', '$2y$10$jRRvv5Ng.AcO.1QLEFMXr./OFOcdtJtAgQIAfIIOuLUedcocGxh1G', '000000000000000', 1, 1, '2015-12-01 00:00:00'),
(3, 'Sami', 'Acar', 'sami.acar@samiacar.com', '$2y$10$TLDITj9TfsvixtyjclzavuzpNQlG/ojZYutK8xeBa5aaH.a/0FPSy', '123xcvdsf123213', 1, 1, '2015-12-03 19:20:09'),
(6, 'deneme', 'deneme', 'ahmetckrc@hotmail.com', '$2y$10$TyzSB1svjDdOLQeRJVUO2OVWav2PZcP1CEBGJuuYUTOEkOaVSCd5G', '355696058684354', 1, 0, '2015-12-15 17:26:42'),
(7, 'Barış', 'ÇAKIRCI', 'bariscakirci@gmail.com', '$2y$10$uDuR3gHI/fq4qXG6TjZRO.JhgRaXu7dsRM99gHvGmF0tsUHeKFCOi', '356829050740259', 1, 0, '2015-12-20 19:39:18');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `locations`
--
ALTER TABLE `locations`
 ADD PRIMARY KEY (`idlocations`);

--
-- Tablo için indeksler `location_now`
--
ALTER TABLE `location_now`
 ADD PRIMARY KEY (`idlocationnow`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`idusers`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `locations`
--
ALTER TABLE `locations`
MODIFY `idlocations` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- Tablo için AUTO_INCREMENT değeri `location_now`
--
ALTER TABLE `location_now`
MODIFY `idlocationnow` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
MODIFY `idusers` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

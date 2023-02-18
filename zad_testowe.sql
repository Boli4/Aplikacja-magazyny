-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Lut 2023, 18:52
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `zad_testowe`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `artykuły`
--

CREATE TABLE `artykuły` (
  `id_artykuły` int(11) NOT NULL,
  `nazwa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `artykuły`
--

INSERT INTO `artykuły` (`id_artykuły`, `nazwa`) VALUES
(1, 'Listwa drewniana'),
(2, 'Listwa PCV'),
(3, 'Taśma uszczelniająca'),
(4, 'Śruba'),
(5, 'Listwa przyszybowa'),
(6, 'Listwa aluminiowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `jednostki_miary`
--

CREATE TABLE `jednostki_miary` (
  `id_miara` int(11) NOT NULL,
  `nazwa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `jednostki_miary`
--

INSERT INTO `jednostki_miary` (`id_miara`, `nazwa`) VALUES
(1, 'Centymetr'),
(2, 'Metr'),
(3, 'Kilogram'),
(4, 'Milimetr');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `magazyny`
--

CREATE TABLE `magazyny` (
  `id_magazyny` int(11) NOT NULL,
  `nazwa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `magazyny`
--

INSERT INTO `magazyny` (`id_magazyny`, `nazwa`) VALUES
(1, 'Magazyn 1'),
(2, 'Magazyn 2'),
(3, 'Magazyn 3'),
(8, 'Magazyn 4');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `magazyny_user`
--

CREATE TABLE `magazyny_user` (
  `id_mu` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_magazyn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `magazyny_user`
--

INSERT INTO `magazyny_user` (`id_mu`, `id_user`, `id_magazyn`) VALUES
(1, 2, 2),
(2, 2, 3),
(3, 9, 2),
(6, 8, 8),
(7, 9, 8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przyjęcie`
--

CREATE TABLE `przyjęcie` (
  `id_artykuły` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `ilość` int(11) NOT NULL,
  `miara` text NOT NULL,
  `VAT` float NOT NULL,
  `cena` float NOT NULL,
  `plikSciezka` varchar(255) NOT NULL,
  `id_magazyn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `przyjęcie`
--

INSERT INTO `przyjęcie` (`id_artykuły`, `nazwa`, `ilość`, `miara`, `VAT`, `cena`, `plikSciezka`, `id_magazyn`) VALUES
(3, 'Listwa PCV', 12, 'Metr', 500, 800, '', 1),
(4, 'Śruba', 10, 'Kilogram', 500, 600, '', 3),
(6, 'Listwa drewniana', 5, 'Metr', 300, 500, '', 2),
(8, 'Listwa drewniana', 12, 'Centymetr', 32, 35, 'Mateusz_Bolingier_Zad2.pdf', 1),
(9, 'Śruba', 24, 'Kilogram', 325, 5362, 'w13.pdf', 2),
(10, 'Taśma uszczelniająca', 654, 'Metr', 548, 757, '', 2),
(11, 'Listwa przyszybowa', 436, 'Centymetr', 436, 6346, 'iiii.pdf', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_uzytkownicy` int(11) NOT NULL,
  `email` text NOT NULL,
  `haslo` text NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_uzytkownicy`, `email`, `haslo`, `admin`) VALUES
(1, 'admin@gmail.com', '$2a$10$xBo.xYEfIDUPVn85qnbLx.IeJAeCxSOFPw.Unv5KwS.ncYwilo0D.', 1),
(2, 'user@gmail.com', '$2y$10$Wa/8/CKyg9VM7zCmPIpt/erT9zfJUCE8foAN4L0Oj.yb4dCr6rH76', 0),
(6, 'fsdag@gsfda.dfhs', '$2y$10$r14sHMX.nbGvTqgfiXeuO.z9dO63PbGY3AcnPsZ3AkzmQwUQYG9BC', 0),
(7, 'gdsfg@kjh.hjk', '$2y$10$bEXGzcJ9HyrKLnkbONsfGu1QINQFvLbz1YaZwG5mV8s6GNLsbP7F2', 1),
(8, 'wdgfawsdg@hdgfj.pl', '$2y$10$BL1ixnr1fyHNskSuWOTneeOAJL5b04E3yWZt94r7Av3KNb9wn5Lr.', 1),
(9, 'dghdf@gjhfs.pl', '$2y$10$/YTgufEMYhOVIdmdWkSxF.WP9dN2X5e9XpxJqfLZk.oEGLmJd73tO', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wydanie`
--

CREATE TABLE `wydanie` (
  `id_wydanie` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `ilość` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `wydanie`
--

INSERT INTO `wydanie` (`id_wydanie`, `nazwa`, `ilość`) VALUES
(1, 'Listwa drewniana', 345);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `artykuły`
--
ALTER TABLE `artykuły`
  ADD PRIMARY KEY (`id_artykuły`);

--
-- Indeksy dla tabeli `jednostki_miary`
--
ALTER TABLE `jednostki_miary`
  ADD PRIMARY KEY (`id_miara`);

--
-- Indeksy dla tabeli `magazyny`
--
ALTER TABLE `magazyny`
  ADD PRIMARY KEY (`id_magazyny`);

--
-- Indeksy dla tabeli `magazyny_user`
--
ALTER TABLE `magazyny_user`
  ADD PRIMARY KEY (`id_mu`);

--
-- Indeksy dla tabeli `przyjęcie`
--
ALTER TABLE `przyjęcie`
  ADD PRIMARY KEY (`id_artykuły`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_uzytkownicy`);

--
-- Indeksy dla tabeli `wydanie`
--
ALTER TABLE `wydanie`
  ADD PRIMARY KEY (`id_wydanie`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `artykuły`
--
ALTER TABLE `artykuły`
  MODIFY `id_artykuły` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `jednostki_miary`
--
ALTER TABLE `jednostki_miary`
  MODIFY `id_miara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `magazyny`
--
ALTER TABLE `magazyny`
  MODIFY `id_magazyny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `magazyny_user`
--
ALTER TABLE `magazyny_user`
  MODIFY `id_mu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `przyjęcie`
--
ALTER TABLE `przyjęcie`
  MODIFY `id_artykuły` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_uzytkownicy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `wydanie`
--
ALTER TABLE `wydanie`
  MODIFY `id_wydanie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

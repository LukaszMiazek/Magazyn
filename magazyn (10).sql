-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 13 Maj 2022, 18:18
-- Wersja serwera: 10.4.8-MariaDB
-- Wersja PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `magazyn`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostawy`
--

CREATE TABLE `dostawy` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_poz` int(11) UNSIGNED DEFAULT NULL,
  `id_tow` int(11) UNSIGNED DEFAULT NULL,
  `id_prac` int(11) UNSIGNED DEFAULT NULL,
  `ilosc` double DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `ile` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `dostawy`
--

INSERT INTO `dostawy` (`id`, `id_poz`, `id_tow`, `id_prac`, `ilosc`, `data`, `ile`) VALUES
(11, 14, 14, 2, 3, '2022-04-23 22:00:20', NULL),
(12, 14, 14, 2, 3, '2022-04-23 22:24:06', NULL),
(14, 16, 15, 2, 4, '2022-05-07 13:47:39', NULL),
(15, 17, 1, 2, 5, '2022-05-09 15:11:53', NULL),
(16, 18, 11111, 2, 1, '2022-05-09 15:12:19', NULL),
(17, 19, 7, 2, 1, '2022-05-13 16:46:32', NULL),
(18, 20, 14, 2, 1, '2022-05-13 17:35:08', NULL),
(19, 1, 7, 2, 5, '2022-05-13 18:12:26', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(11) UNSIGNED NOT NULL,
  `nazwa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `kategoria`
--

INSERT INTO `kategoria` (`id`, `nazwa`) VALUES
(1, 'spodnie'),
(2, 'bluzy'),
(3, 'czapki'),
(4, 'rękawiczki'),
(5, 'obuwie'),
(6, 'skarpetki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klient`
--

CREATE TABLE `klient` (
  `id` int(11) UNSIGNED NOT NULL,
  `login` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `haslo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nazwisko` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `klient`
--

INSERT INTO `klient` (`id`, `login`, `haslo`, `imie`, `nazwisko`) VALUES
(1, 'KrzaM', 'haslo123', 'Marek', 'Krzak'),
(3, 'Mach', 'haslo123', 'Mariusz', 'Dach'),
(4, 'ZygTa', '123', 'Zygmund', 'Targ'),
(5, 'Akul', 'haslo123', 'Adam', 'Kukułka');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kompletacje`
--

CREATE TABLE `kompletacje` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_zam` int(11) UNSIGNED DEFAULT NULL,
  `id_poz` int(11) UNSIGNED DEFAULT NULL,
  `id_tow` int(11) UNSIGNED DEFAULT NULL,
  `id_prac` int(11) UNSIGNED DEFAULT NULL,
  `ilosc` tinyint(1) UNSIGNED DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `status` tinyint(1) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `kompletacje`
--

INSERT INTO `kompletacje` (`id`, `id_zam`, `id_poz`, `id_tow`, `id_prac`, `ilosc`, `data`, `status`) VALUES
(22, 29, 5, 14, 5, 1, '2022-05-07 21:18:09', 1),
(23, 29, 5, 14, 5, 1, '2022-05-07 21:20:50', 1),
(24, 30, 1, 7, 5, 1, '2022-05-07 21:20:58', 1),
(25, 30, 1, 7, 5, 1, '2022-05-07 21:26:18', 1),
(26, 30, 1, 7, 5, 1, '2022-05-07 21:26:21', 1),
(27, 30, 1, 7, 5, 1, '2022-05-07 21:26:22', 1),
(28, 30, 1, 7, 5, 1, '2022-05-07 21:26:23', 1),
(29, 30, 1, 7, 5, 1, '2022-05-07 21:26:24', 1),
(30, 30, 16, 15, 5, 1, '2022-05-07 21:26:25', 1),
(31, 30, 16, 15, 5, 1, '2022-05-07 21:26:42', 1),
(32, 30, 16, 15, 5, 1, '2022-05-07 21:26:44', 1),
(33, 31, 16, 15, 5, 1, '2022-05-07 21:30:20', 1),
(34, 31, 16, 15, 5, 1, '2022-05-07 21:30:21', 1),
(35, 31, 5, 14, 5, 1, '2022-05-07 21:30:23', 1),
(36, 31, 5, 14, 5, 1, '2022-05-07 21:30:24', 1),
(37, 31, 16, 15, 5, 1, '2022-05-07 21:30:25', 1),
(38, 31, 16, 15, 5, 1, '2022-05-07 21:30:25', 1),
(39, 31, 16, 15, 5, 1, '2022-05-07 21:30:26', 1),
(40, 36, 1, 7, 5, 1, '2022-05-07 21:30:28', 1),
(41, 30, 1, 7, 5, 1, '2022-05-07 21:46:41', 1),
(42, 30, 1, 7, 5, 1, '2022-05-07 21:48:10', 1),
(43, 30, 1, 7, 5, 1, '2022-05-07 21:48:12', 1),
(44, 30, 1, 7, 5, 1, '2022-05-07 21:48:30', 1),
(45, 30, 1, 7, 5, 1, '2022-05-07 21:48:39', 1),
(46, 30, 16, 15, 5, 1, '2022-05-07 21:48:42', 1),
(47, 30, 16, 15, 5, 1, '2022-05-07 21:48:46', 1),
(48, 36, 1, 7, 5, 1, '2022-05-07 21:48:53', 1),
(49, 30, 1, 7, 5, 1, '2022-05-07 21:50:22', 1),
(50, 30, 1, 7, 5, 1, '2022-05-09 10:34:55', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `magazyn`
--

CREATE TABLE `magazyn` (
  `id` int(11) UNSIGNED NOT NULL,
  `sektor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alejka` int(11) UNSIGNED DEFAULT NULL,
  `polka` int(11) UNSIGNED DEFAULT NULL,
  `box` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_tow` int(11) UNSIGNED DEFAULT NULL,
  `ilosc` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `magazyn`
--

INSERT INTO `magazyn` (`id`, `sektor`, `alejka`, `polka`, `box`, `id_tow`, `ilosc`) VALUES
(1, 'A', 1, 2, 'A', 7, 12),
(3, 'A', 1, 1, 'C', 7, 30),
(4, 'A', 1, 3, 'D', 7, 7),
(5, 'B', 67, 6, 'H', 14, 6),
(6, 'D', 5, 45, 'D', 29, 17),
(14, 'A', 1, 1, 'H', 14, 31),
(15, 'A', 5, 7, 'A', 7, 1),
(16, 'A', 14, 2, 'D', 15, 54),
(17, 'A', 1, 1, '1', 1, 5),
(19, 'A', 4, 6, 'A', 7, 1),
(20, 'A', 6, 6, '6', 14, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownik`
--

CREATE TABLE `pracownik` (
  `ID_PRACOWNIKA` int(11) NOT NULL,
  `IMIE` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `NAZWISKO` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `STANOWISKO` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `DATA_ZATRUDNIENIA` date NOT NULL,
  `HASLO` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `LOGIN` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `BLOKADA` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pracownik`
--

INSERT INTO `pracownik` (`ID_PRACOWNIKA`, `IMIE`, `NAZWISKO`, `STANOWISKO`, `DATA_ZATRUDNIENIA`, `HASLO`, `LOGIN`, `BLOKADA`) VALUES
(1, 'Jan', 'Kowalski', 'KSIEGOWY', '2000-03-01', 'haslo123', 'JKow', 0),
(2, 'Karol', 'Nowak', 'Magazynier', '2000-03-01', 'haslo123', 'KNow', 0),
(3, '-', '-', 'Administrator', '0000-00-00', 'ADMIN', 'ADMIN', 0),
(4, 'Paweł', 'Antczyk', 'Magazynier', '2000-03-01', 'haslo123', 'PAnt', 0),
(5, 'Tomsz', 'Pawelec', 'Kompleter', '0000-00-00', 'haslo123', 'TPaw', 0),
(8, 'Tom', 'Holender', 'KSIEGOWY', '2022-03-20', '123', 'TH', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sklad`
--

CREATE TABLE `sklad` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_zam` int(11) UNSIGNED DEFAULT NULL,
  `towar` int(11) UNSIGNED DEFAULT NULL,
  `ilosc` int(11) UNSIGNED DEFAULT NULL,
  `jest` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `sklad`
--

INSERT INTO `sklad` (`id`, `id_zam`, `towar`, `ilosc`, `jest`, `status`) VALUES
(8, 28, 15, 2, 2, 2),
(9, 28, 18, 1, 0, 3),
(10, 29, 14, 1, 1, 2),
(11, 30, 7, 5, 0, 1),
(12, 30, 18, 1, 0, 1),
(13, 30, 15, 2, 0, 1),
(14, 31, 15, 2, 2, 2),
(15, 31, 14, 2, 2, 2),
(16, 31, 15, 3, 3, 2),
(27, 36, 7, 2, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `towar`
--

CREATE TABLE `towar` (
  `id` int(11) UNSIGNED NOT NULL,
  `nazwa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cena` decimal(10,2) DEFAULT NULL,
  `opis` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategoria` int(11) NOT NULL,
  `kod` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `towar`
--

INSERT INTO `towar` (`id`, `nazwa`, `cena`, `opis`, `kategoria`, `kod`) VALUES
(7, 'Dresy', '40.00', 'czarne', 1, 'spo7'),
(14, 'Czapka', '12.46', 'Z daszkiem', 3, 'cza14'),
(15, 'Bluza', '35.00', 'Czerwona', 2, 'blu15'),
(16, 'Buty', '45.00', 'Mokasyny', 5, 'obu16'),
(19, 'Rękawiczki', '45.69', 'Skórzane', 4, 'ręk19'),
(20, 'Czapka zimowa', '86.60', 'Ciepła', 3, 'cza20'),
(24, 'krotkie', '45.00', 'czarne', 1, 'spo24'),
(46, 'sandałki', '222.00', 'tak', 5, 'obu46');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienie`
--

CREATE TABLE `zamowienie` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_klienta` int(11) UNSIGNED DEFAULT NULL,
  `data` date NOT NULL,
  `status` int(11) UNSIGNED DEFAULT NULL,
  `akt_komp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `zamowienie`
--

INSERT INTO `zamowienie` (`id`, `id_klienta`, `data`, `status`, `akt_komp`) VALUES
(28, 1, '2022-04-02', 3, 0),
(29, 1, '2022-04-02', 3, 0),
(30, 1, '2022-04-02', 1, 0),
(31, 1, '2022-04-02', 3, 0),
(36, 1, '2022-04-04', 1, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dostawy`
--
ALTER TABLE `dostawy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `kompletacje`
--
ALTER TABLE `kompletacje`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `magazyn`
--
ALTER TABLE `magazyn`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `pracownik`
--
ALTER TABLE `pracownik`
  ADD PRIMARY KEY (`ID_PRACOWNIKA`);

--
-- Indeksy dla tabeli `sklad`
--
ALTER TABLE `sklad`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `towar`
--
ALTER TABLE `towar`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `dostawy`
--
ALTER TABLE `dostawy`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `klient`
--
ALTER TABLE `klient`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `kompletacje`
--
ALTER TABLE `kompletacje`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT dla tabeli `magazyn`
--
ALTER TABLE `magazyn`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `pracownik`
--
ALTER TABLE `pracownik`
  MODIFY `ID_PRACOWNIKA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `sklad`
--
ALTER TABLE `sklad`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `towar`
--
ALTER TABLE `towar`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT dla tabeli `zamowienie`
--
ALTER TABLE `zamowienie`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

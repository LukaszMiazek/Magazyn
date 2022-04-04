-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Mar 2022, 18:31
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
(1, 'Jan', 'Kowalski', 'MAGAZYNIER', '2000-03-01', 'haslo123', 'JKow', 1),
(2, 'Karol', 'Nowak', 'Księgowy', '2000-03-01', 'haslo123', 'KNow', 0),
(3, '-', '-', 'Administrator', '0000-00-00', 'ADMIN', 'ADMIN', 0),
(4, 'Paweł', 'Antczyk', 'Magazynier', '2000-03-01', 'haslo123', 'PAnt', 0),
(5, 'Tomsz', 'Pawelec', 'Magazynier', '0000-00-00', 'haslo123', 'TPaw', 0),
(8, 'Tom', 'Holender', 'KSIEGOWY', '2022-03-20', '123', 'TH', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pracownik`
--
ALTER TABLE `pracownik`
  ADD PRIMARY KEY (`ID_PRACOWNIKA`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `pracownik`
--
ALTER TABLE `pracownik`
  MODIFY `ID_PRACOWNIKA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Creato il: Dic 07, 2016 alle 22:15
-- Versione del server: 10.1.19-MariaDB
-- Versione PHP: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_aegis`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appezzamento`
--

CREATE TABLE `appezzamento` (
  `idappezzamento` int(3) NOT NULL,
  `iduliveto` int(3) NOT NULL,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL,
  `note` text COLLATE utf8_bin NOT NULL,
  `mappa` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `appezzamento`
--

INSERT INTO `appezzamento` (`idappezzamento`, `iduliveto`, `nome`, `note`, `mappa`) VALUES
(1, 1, 'Appezzamento A', '', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `componente`
--

CREATE TABLE `componente` (
  `idcomponente` int(3) NOT NULL,
  `descrizione` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `nodo`
--

CREATE TABLE `nodo` (
  `idnodo` int(3) NOT NULL,
  `statonodo` int(1) NOT NULL,
  `indice-posizione` varchar(1) COLLATE utf8_bin NOT NULL,
  `gprs` tinyint(1) NOT NULL,
  `idappezzamento` int(3) NOT NULL,
  `x` text COLLATE utf8_bin,
  `y` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `nodo`
--

INSERT INTO `nodo` (`idnodo`, `statonodo`, `indice-posizione`, `gprs`, `idappezzamento`, `x`, `y`) VALUES
(1, 3, 'A', 1, 1, '0.4244791666666667', '-0.125'),
(2, 2, 'a', 0, 1, '0.668206765232975', '0.1611842105263158'),
(3, 2, 'a', 0, 1, '0.41193436379928317', '0.42105263157894735'),
(4, 3, 'a', 0, 1, '0.09971438172043011', '0.14473684210526316');

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica`
--

CREATE TABLE `notifica` (
  `idnotifica` int(3) NOT NULL,
  `titolo` varchar(50) COLLATE utf8_bin NOT NULL,
  `descrizione` varchar(100) COLLATE utf8_bin NOT NULL,
  `idutente` int(3) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `parametri`
--

CREATE TABLE `parametri` (
  `idparametro` int(11) NOT NULL,
  `umidita` int(11) NOT NULL,
  `mosche` int(11) NOT NULL,
  `temperatura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `possesso`
--

CREATE TABLE `possesso` (
  `idpossesso` int(3) NOT NULL,
  `idnodo` int(3) NOT NULL,
  `idcomponente` int(3) NOT NULL,
  `stato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `temperatura`
--

CREATE TABLE `temperatura` (
  `idtemperatura` int(3) NOT NULL,
  `data` datetime NOT NULL,
  `temperatura` int(11) NOT NULL,
  `idnodo` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `temperatura`
--

INSERT INTO `temperatura` (`idtemperatura`, `data`, `temperatura`, `idnodo`) VALUES
(1, '2016-11-10 00:00:00', 50, 1),
(2, '2016-11-11 00:00:00', 30, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `trappola`
--

CREATE TABLE `trappola` (
  `idtrappola` int(3) NOT NULL,
  `idnodo` int(3) NOT NULL,
  `conta` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `trappola`
--

INSERT INTO `trappola` (`idtrappola`, `idnodo`, `conta`, `data`) VALUES
(1, 1, 20, '2016-11-10 00:00:00'),
(2, 1, 40, '2016-11-11 00:00:00'),
(3, 1, 150, '2016-12-17 00:00:00'),
(4, 1, 25, '2016-12-18 00:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `uliveto`
--

CREATE TABLE `uliveto` (
  `iduliveto` int(3) NOT NULL,
  `descrizione` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `uliveto`
--

INSERT INTO `uliveto` (`iduliveto`, `descrizione`) VALUES
(1, 'Uliveto 1');

-- --------------------------------------------------------

--
-- Struttura della tabella `umidita`
--

CREATE TABLE `umidita` (
  `idumidita` int(3) NOT NULL,
  `data` datetime NOT NULL,
  `umidita` int(3) NOT NULL,
  `idnodo` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `umidita`
--

INSERT INTO `umidita` (`idumidita`, `data`, `umidita`, `idnodo`) VALUES
(1, '2016-11-10 00:00:00', 30, 1),
(2, '2016-11-11 00:00:00', 20, 1),
(3, '2016-11-12 00:00:00', 50, 1),
(4, '2016-11-14 00:00:00', 60, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `idutente` int(3) NOT NULL,
  `nome` varchar(30) COLLATE utf8_bin NOT NULL,
  `cognome` varchar(30) COLLATE utf8_bin NOT NULL,
  `ruolo` varchar(30) COLLATE utf8_bin NOT NULL,
  `username` varchar(25) COLLATE utf8_bin NOT NULL,
  `password` varchar(25) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`idutente`, `nome`, `cognome`, `ruolo`, `username`, `password`) VALUES
(1, 'Giulia', 'Trabba', 'user', 'user', 'user'),
(2, 'Amministratore', 'Generico', 'admin', 'admin', 'admin');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appezzamento`
--
ALTER TABLE `appezzamento`
  ADD PRIMARY KEY (`idappezzamento`),
  ADD KEY `iduliveto` (`iduliveto`);

--
-- Indici per le tabelle `componente`
--
ALTER TABLE `componente`
  ADD PRIMARY KEY (`idcomponente`);

--
-- Indici per le tabelle `nodo`
--
ALTER TABLE `nodo`
  ADD PRIMARY KEY (`idnodo`),
  ADD KEY `idappezzamento` (`idappezzamento`);

--
-- Indici per le tabelle `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`idnotifica`),
  ADD KEY `idutente` (`idutente`);

--
-- Indici per le tabelle `parametri`
--
ALTER TABLE `parametri`
  ADD PRIMARY KEY (`idparametro`);

--
-- Indici per le tabelle `possesso`
--
ALTER TABLE `possesso`
  ADD PRIMARY KEY (`idpossesso`),
  ADD KEY `idnodo` (`idnodo`),
  ADD KEY `idcomponente` (`idcomponente`);

--
-- Indici per le tabelle `temperatura`
--
ALTER TABLE `temperatura`
  ADD PRIMARY KEY (`idtemperatura`),
  ADD KEY `idnodo` (`idnodo`);

--
-- Indici per le tabelle `trappola`
--
ALTER TABLE `trappola`
  ADD PRIMARY KEY (`idtrappola`),
  ADD KEY `idnodo` (`idnodo`);

--
-- Indici per le tabelle `uliveto`
--
ALTER TABLE `uliveto`
  ADD PRIMARY KEY (`iduliveto`);

--
-- Indici per le tabelle `umidita`
--
ALTER TABLE `umidita`
  ADD PRIMARY KEY (`idumidita`),
  ADD KEY `idnodo` (`idnodo`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`idutente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `appezzamento`
--
ALTER TABLE `appezzamento`
  MODIFY `idappezzamento` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `componente`
--
ALTER TABLE `componente`
  MODIFY `idcomponente` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `nodo`
--
ALTER TABLE `nodo`
  MODIFY `idnodo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `idnotifica` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `parametri`
--
ALTER TABLE `parametri`
  MODIFY `idparametro` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `possesso`
--
ALTER TABLE `possesso`
  MODIFY `idpossesso` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `temperatura`
--
ALTER TABLE `temperatura`
  MODIFY `idtemperatura` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `trappola`
--
ALTER TABLE `trappola`
  MODIFY `idtrappola` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `uliveto`
--
ALTER TABLE `uliveto`
  MODIFY `iduliveto` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `umidita`
--
ALTER TABLE `umidita`
  MODIFY `idumidita` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `idutente` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appezzamento`
--
ALTER TABLE `appezzamento`
  ADD CONSTRAINT `esistenza_uliveto` FOREIGN KEY (`iduliveto`) REFERENCES `uliveto` (`iduliveto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `nodo`
--
ALTER TABLE `nodo`
  ADD CONSTRAINT `esistenza_appezzamento` FOREIGN KEY (`idappezzamento`) REFERENCES `appezzamento` (`idappezzamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `notifica`
--
ALTER TABLE `notifica`
  ADD CONSTRAINT `esistenza_utente_notifica` FOREIGN KEY (`idutente`) REFERENCES `utente` (`idutente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `temperatura`
--
ALTER TABLE `temperatura`
  ADD CONSTRAINT `esistenza_nodo_temperatura` FOREIGN KEY (`idnodo`) REFERENCES `nodo` (`idnodo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `trappola`
--
ALTER TABLE `trappola`
  ADD CONSTRAINT `esistenza_nodo_trappola` FOREIGN KEY (`idnodo`) REFERENCES `nodo` (`idnodo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `umidita`
--
ALTER TABLE `umidita`
  ADD CONSTRAINT `esistenza_nodo_umidita` FOREIGN KEY (`idnodo`) REFERENCES `nodo` (`idnodo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

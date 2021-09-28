-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 28, 2021 at 07:33 PM
-- Server version: 5.7.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ludotheque`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
                         `id` int(11) NOT NULL,
                         `name` varchar(100) DEFAULT NULL,
                         `email` varchar(100) DEFAULT NULL,
                         `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
    (1, 'admin', 'nandobiaccalli@gmail.com', '$2y$10$6/5w4uZiWzTkQGgtK/Qt3.MM/blVPYxlHO6k3KP3yverFc1AWVUYW');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
                          `id` int(11) NOT NULL,
                          `name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
                                        (1, 'Action'),
                                        (2, 'Aventure'),
                                        (3, 'RPG'),
                                        (4, 'Stratégie'),
                                        (5, 'Réflexion'),
                                        (6, 'Shooter'),
                                        (7, 'Sport'),
                                        (8, 'Plate-Forme'),
                                        (9, 'Simulation'),
                                        (10, 'Course'),
                                        (11, 'Combat'),
                                        (12, 'Gestion'),
                                        (13, 'MMO'),
                                        (14, 'Sandbox'),
                                        (15, 'Open World');

-- --------------------------------------------------------

--
-- Table structure for table `genres_jeux`
--

CREATE TABLE `genres_jeux` (
                               `id_genre` int(11) DEFAULT NULL,
                               `id_jeux` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genres_jeux`
--

INSERT INTO `genres_jeux` (`id_genre`, `id_jeux`) VALUES
                                                      (14, 2),
                                                      (9, 2),
                                                      (13, 1),
                                                      (11, 3),
                                                      (13, 3),
                                                      (15, 3),
                                                      (14, 3),
                                                      (1, 4),
                                                      (9, 4),
                                                      (11, 4),
                                                      (13, 4),
                                                      (15, 4);

-- --------------------------------------------------------

--
-- Table structure for table `jeuxvideos`
--

CREATE TABLE `jeuxvideos` (
                              `id` int(11) NOT NULL,
                              `name` varchar(200) DEFAULT NULL,
                              `description` text,
                              `image` varchar(255) DEFAULT NULL,
                              `prix` decimal(6,2) DEFAULT NULL,
                              `release_date` date DEFAULT NULL,
                              `editeur` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jeuxvideos`
--

INSERT INTO `jeuxvideos` (`id`, `name`, `description`, `image`, `prix`, `release_date`, `editeur`) VALUES
                                                                                                       (1, 'Black Desert Online', 'Black Desert est un MMORPG axé sur un système sandbox. Le jeu prend place dans un univers médiéval-fantastique inspiré de l\'Italie de la Renaissance au sein duquel deux pays s\'affrontent, la République de Calpheon et le royaume de Valence. La raison de leur conflit est la Pierre Noire, une source d\'énergie essentielle.', 'blackdesert.jpg', '9.99', '2017-05-24', 'Pearl Abyss'),
                                                                                                       (2, 'Satisfactory', 'Satisfactory est un jeu vidéo de simulation et de construction en vue à la première personne dans un monde ouvert développé par Coffee Stain Studios, qui ont créé également Goat Simulator. Le jeu est sorti le 19 mars 2019 en early access sur Windows. Il est jouable en solo ou en coopération de deux à quatre joueurs', '1465422592satisf.jpg', '26.99', '2019-03-19', 'Coffee Stain Studios'),
                                                                                                       (3, 'Rust', 'Rust est un jeu vidéo d\'aventure et de survie en multijoueur développé et édité par Facepunch Studios. Le jeu est d\'abord disponible en accès anticipé à partir de décembre 2013, puis sort sur ordinateur le 8 février 2018.', '2113674445rust.jpg', '39.99', '2013-12-11', 'Facepunch Studios Ltd'),
                                                                                                       (4, 'Elite Dangerous', 'Elite Dangerous  est un jeu vidéo de simulation spatiale (un « space sim ») de combat, de commerce et d\'exploration interstellaire, développé et édité par Frontier Developments et sorti en décembre 2014. Financé en partie sur la plateforme Kickstarter, le jeu constitue la quatrième édition de la franchise initiée par le jeu Elite, reconnu comme emblématique et fondateur du genre. Elite Dangerous est conçu et développé par David Braben, l\'un des deux co-créateurs de la série.', '1853708558elite.jpg', '24.99', '2014-12-16', 'Frontier Developments');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres_jeux`
--
ALTER TABLE `genres_jeux`
    ADD KEY `id_genre` (`id_genre`),
    ADD KEY `id_jeux` (`id_jeux`);

--
-- Indexes for table `jeuxvideos`
--
ALTER TABLE `jeuxvideos`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jeuxvideos`
--
ALTER TABLE `jeuxvideos`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `genres_jeux`
--
ALTER TABLE `genres_jeux`
    ADD CONSTRAINT `genres_jeux_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genres` (`id`),
    ADD CONSTRAINT `genres_jeux_ibfk_2` FOREIGN KEY (`id_jeux`) REFERENCES `jeuxvideos` (`id`);

-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.27-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para ecuabd
CREATE DATABASE IF NOT EXISTS `ecuabd` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `ecuabd`;

-- Volcando estructura para tabla ecuabd.reg_login
CREATE TABLE IF NOT EXISTS `reg_login` (
  `id_registro` int(11) NOT NULL AUTO_INCREMENT,
  `registrofecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `geolocalizacion` varchar(300) DEFAULT '',
  `idusuario` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_registro`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla ecuabd.reg_login: ~12 rows (aproximadamente)
INSERT INTO `reg_login` (`id_registro`, `registrofecha`, `geolocalizacion`, `idusuario`) VALUES
	(1, '2023-04-05 00:15:21', NULL, 0),
	(2, '2023-04-05 00:15:22', NULL, 0),
	(3, '2023-04-05 00:15:30', NULL, 0),
	(4, '2023-04-05 00:15:33', NULL, 0),
	(5, '2023-04-05 00:15:37', NULL, 0),
	(6, '2023-04-05 05:09:59', NULL, 0),
	(7, '2023-04-05 05:10:05', NULL, 0),
	(8, '2023-04-05 20:50:48', NULL, 0),
	(9, '2023-04-05 20:50:11', 'https://www.google.com.ec/maps/@-0.1756301,-78.4934746,19z?hl=es', 1),
	(10, '2023-04-05 21:00:05', 'https://www.google.com.ec/maps/@-0.1756301,-78.4934746,19z?hl=es', 1),
	(11, '2023-04-11 21:27:09', '', 1),
	(12, '2023-04-11 21:41:57', '', 1);

-- Volcando estructura para tabla ecuabd.rolapp
CREATE TABLE IF NOT EXISTS `rolapp` (
  `idrol` int(11) NOT NULL,
  `nomrol` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla ecuabd.rolapp: ~6 rows (aproximadamente)
INSERT INTO `rolapp` (`idrol`, `nomrol`) VALUES
	(0, 'registrado'),
	(1, 'usuario'),
	(2, 'admin'),
	(3, 'interno'),
	(4, 'anulado'),
	(5, 'bloqueado');

-- Volcando estructura para tabla ecuabd.tokendia
CREATE TABLE IF NOT EXISTS `tokendia` (
  `id_token` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla ecuabd.tokendia: ~3 rows (aproximadamente)
INSERT INTO `tokendia` (`id_token`, `token`, `fecha_hora`) VALUES
	(1, '4967cad07fcecc93f35459e7a1977a9a38df6cb774b5d526ea949573e1c69dd5', '2023-04-12 13:36:21'),
	(2, 'c78297c9c6b6ac3ccc6e4cad34f504ccb6626f2a9a15c9e3be41257b08c395d1', '2023-04-12 13:58:27'),
	(3, 'baf23345a0d78f061f425a26ce4e9050dd77607b59d217a3278213a0988e116d', '2023-04-13 14:50:15');

-- Volcando estructura para tabla ecuabd.userapp
CREATE TABLE IF NOT EXISTS `userapp` (
  `id_userapp` int(11) NOT NULL AUTO_INCREMENT,
  `mail_user` varchar(200) NOT NULL,
  `pass_user` varchar(100) NOT NULL,
  `rol_user` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_userapp`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla ecuabd.userapp: ~0 rows (aproximadamente)
INSERT INTO `userapp` (`id_userapp`, `mail_user`, `pass_user`, `rol_user`) VALUES
	(1, 'jhonnyminian@gmail.com', '$2y$10$MmL3/39X8nnDrsw3/35p0eBDSiGZAYWvZ/74fmPkLiAB6djj0TGC6', '1');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

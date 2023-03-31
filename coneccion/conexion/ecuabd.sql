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
	(1, 'jhonnyminian@gmail.com', '$2y$10$MmL3/39X8nnDrsw3/35p0eBDSiGZAYWvZ/74fmPkLiAB6djj0TGC6', '5');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

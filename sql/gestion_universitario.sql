-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para gestion_universitario
CREATE DATABASE IF NOT EXISTS `gestion_universitario` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gestion_universitario`;

-- Volcando estructura para tabla gestion_universitario.alumnos
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricula` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_carrera` int NOT NULL,
  `id_tutor` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `fk_alumno_carrera` (`id_carrera`),
  KEY `fk_alumno_tutor` (`id_tutor`),
  CONSTRAINT `fk_alumno_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_alumno_tutor` FOREIGN KEY (`id_tutor`) REFERENCES `tutores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla gestion_universitario.asesorias
CREATE TABLE IF NOT EXISTS `asesorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_carrera` int NOT NULL,
  `id_materia` int NOT NULL,
  `id_alumno` int NOT NULL,
  `id_asesor` int NOT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_asesoria` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_asesoria_carrera` (`id_carrera`),
  KEY `fk_asesora_materia` (`id_materia`),
  KEY `fk_asesoria_alumno` (`id_alumno`),
  KEY `fk_asesoria_asesor` (`id_asesor`),
  CONSTRAINT `fk_asesora_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_asesoria_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_asesoria_asesor` FOREIGN KEY (`id_asesor`) REFERENCES `tutores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_asesoria_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla gestion_universitario.carreras
CREATE TABLE IF NOT EXISTS `carreras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla gestion_universitario.materias
CREATE TABLE IF NOT EXISTS `materias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla gestion_universitario.materias_carrera
CREATE TABLE IF NOT EXISTS `materias_carrera` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_materia` int NOT NULL,
  `id_carrera` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cat_materia` (`id_materia`),
  KEY `fk_materia_carrera` (`id_carrera`),
  CONSTRAINT `fk_cat_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_materia_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla gestion_universitario.tutores
CREATE TABLE IF NOT EXISTS `tutores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_carrera` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tutor_carrera` (`id_carrera`),
  CONSTRAINT `fk_tutor_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla gestion_universitario.tutorias
CREATE TABLE IF NOT EXISTS `tutorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_carrera` int NOT NULL,
  `id_materia` int NOT NULL,
  `id_alumno` int NOT NULL,
  `id_tutor` int NOT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_tutoria` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tutoria_carrera` (`id_carrera`),
  KEY `fk_tutoria_alumno` (`id_alumno`),
  KEY `fk_tutoria_tutor` (`id_tutor`),
  KEY `fk_tutorias_materias` (`id_materia`),
  CONSTRAINT `fk_tutoria_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_tutoria_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_tutoria_tutor` FOREIGN KEY (`id_tutor`) REFERENCES `tutores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_tutorias_materias` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

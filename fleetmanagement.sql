/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `trip_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `bus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `seats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `bus_id` int(10) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `trips` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `start_city` int(10) unsigned DEFAULT NULL,
  `end_city` int(10) unsigned DEFAULT NULL,
  `bus_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `bookings` (`id`, `name`, `seat_id`, `trip_id`) VALUES
(1, 'marwan', 1, 3);
INSERT INTO `bookings` (`id`, `name`, `seat_id`, `trip_id`) VALUES
(6, 'test', 2, 2);
INSERT INTO `bookings` (`id`, `name`, `seat_id`, `trip_id`) VALUES
(7, 'test', 2, 3);
INSERT INTO `bookings` (`id`, `name`, `seat_id`, `trip_id`) VALUES
(8, 'test', 2, 4);

INSERT INTO `bus` (`id`, `name`) VALUES
(1, 'bus1');
INSERT INTO `bus` (`id`, `name`) VALUES
(2, 'bus2');


INSERT INTO `cities` (`id`, `name`) VALUES
(1, 'Cairo');
INSERT INTO `cities` (`id`, `name`) VALUES
(2, 'Giza');
INSERT INTO `cities` (`id`, `name`) VALUES
(3, 'AlFayyum');
INSERT INTO `cities` (`id`, `name`) VALUES
(4, 'AlMinya'),
(5, 'Asyut');

INSERT INTO `seats` (`id`, `name`, `bus_id`) VALUES
(1, 'a1', 1);
INSERT INTO `seats` (`id`, `name`, `bus_id`) VALUES
(2, 'a2', 1);
INSERT INTO `seats` (`id`, `name`, `bus_id`) VALUES
(3, 'a3', 1);
INSERT INTO `seats` (`id`, `name`, `bus_id`) VALUES
(4, 'b1', 1),
(5, 'b2', 1),
(6, 'b3', 1),
(7, 'c1', 1),
(8, 'c2', 1),
(9, 'c3', 1),
(10, 'd1', 1),
(11, 'd2', 1),
(12, 'd3', 1),
(13, 'x1', 2),
(14, 'x2', 2),
(15, 'x3', 2),
(16, 'x4', 2),
(17, 'y1', 2),
(18, 'y2', 2),
(19, 'y3', 2),
(20, 'y4', 2),
(21, 'z1', 2),
(22, 'z2', 2),
(23, 'z3', 2),
(24, 'z4', 2);

INSERT INTO `trips` (`id`, `start_city`, `end_city`, `bus_id`) VALUES
(2, 1, 3, 1);
INSERT INTO `trips` (`id`, `start_city`, `end_city`, `bus_id`) VALUES
(3, 3, 4, 1);
INSERT INTO `trips` (`id`, `start_city`, `end_city`, `bus_id`) VALUES
(4, 4, 5, 1);
INSERT INTO `trips` (`id`, `start_city`, `end_city`, `bus_id`) VALUES
(7, 1, 5, 2);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
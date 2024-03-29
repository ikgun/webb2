-- Information about the database I worked (exported from phpMyAdmin)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `webb2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `webb2`;

CREATE TABLE `cart_items` (
  `shopping_id` INT(10) NOT NULL AUTO_INCREMENT, 
  `session_id` INT(10) NOT NULL, 
  `product_id` INT(10) NOT NULL, 
  `quantity` INT(10) NOT NULL, 
  `item_total` int(10) UNSIGNED NOT NULL
  PRIMARY KEY (`shopping_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`),
  FOREIGN KEY (`session_id`) REFERENCES `sessions`(`session_id`),
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `products` (
  `product_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
  `name` VARCHAR(255) NOT NULL, 
  `price` FLOAT NOT NULL, 
  `img_src` VARCHAR(255) NOT NULL, 
  PRIMARY KEY (`product_id`),
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `sessions` (
  `session_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
  `user_id` int(10) DEFAULT NULL,   
  PRIMARY KEY (`session_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `users` (
  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
  `name` VARCHAR(255) NOT NULL, 
  `email` VARCHAR(255) NOT NULL, 
  `password` VARCHAR(255) NOT NULL, 
  PRIMARY KEY (`user_id`), 
  UNIQUE (`email`),
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

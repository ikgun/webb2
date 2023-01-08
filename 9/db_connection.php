<?php



$c1 = "CREATE TABLE `webb2`.`products` (
    `product_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(255) NOT NULL , 
    `price` FLOAT NOT NULL , 
    `img_src` VARCHAR(255) NOT NULL , 
    PRIMARY KEY (`product_id`),
    ) ENGINE = InnoDB;";

$c2 = "CREATE TABLE `webb2`.`cart_items` (
    `item_id` INT(10) NOT NULL AUTO_INCREMENT , 
    `session_id` INT(10) NOT NULL , 
    `product_id` INT(10) NOT NULL , 
    `quantity` INT(10) NOT NULL , 
    PRIMARY KEY (`item_id`),
    FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`),
    FOREIGN KEY (`session_id`) REFERENCES `sessions`(`session_id`),
    ) ENGINE = InnoDB;";

$c3 = "CREATE TABLE `webb2`.`sessions` (
    `session_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT , 
    `user_id` INT(10) NOT NULL , 
    PRIMARY KEY (`session_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
    ) ENGINE = InnoDB;";

$c4 = "CREATE TABLE `webb2`.`users` (
    `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(255) NOT NULL , 
    `email` VARCHAR(255) NOT NULL , 
    `password` VARCHAR(255) NOT NULL , 
    PRIMARY KEY (`user_id`), 
    UNIQUE (`email`),
    ) ENGINE = InnoDB;";
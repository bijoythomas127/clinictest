CREATE TABLE IF NOT EXISTS `patients` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) NOT NULL,
    `surname` VARCHAR(50) NOT NULL,
    `dob` DATE NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
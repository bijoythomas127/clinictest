CREATE TABLE IF NOT EXISTS `questions` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `question` TEXT NULL,
    `min_score` INT UNSIGNED NULL,
    `max_score` INT UNSIGNED NULL,
    `include_in_total_score` TINYINT DEFAULT TRUE,
    `order` INT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

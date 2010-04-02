CREATE TABLE `contacts` (
    `id` INT AUTO_INCREMENT,

    `first_name` VARCHAR(100),
    `last_name` VARCHAR(100),

    `email` VARCHAR(100),
    `cell` VARCHAR(20),

    `address_line1` VARCHAR(100),
    `address_line2` VARCHAR(100),
    `address_city` VARCHAR(100),
    `address_state` VARCHAR(100),
    `address_zip` VARCHAR(100),

    PRIMARY KEY (`id`)
) ENGINE=MyISAM;
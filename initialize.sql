CREATE TABLE IF NOT EXISTS `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `username` varchar(25),
    `email` varchar(320),
    `password` varchar(200),
    PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `communities` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(50),
    `type` varchar(50),
    `admin_id` int,
    PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `shop` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(50),
    `cost` int,
    `effect` float,
    `description` varchar(250),
    PRIMARY KEY (`id`)
);


INSERT INTO shop
    (`name`, `cost`, `effect`, `description`)
VALUES
    ('cursor', 100, 0.5, 'Clicks for you');


CREATE TABLE IF NOT EXISTS `membership` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int,
    `community_id` int,
    PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `purchased` (
    `id` int NOT NULL AUTO_INCREMENT,
    `community_id` int,
    `item_id` int,
    `count` int,
    PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `sessions` (
    `id` int NOT NULL AUTO_INCREMENT,
    `session_id` varchar(30),
    `email` varchar(320),
    PRIMARY KEY (`id`)
)


/*Change cost of item based on count*/



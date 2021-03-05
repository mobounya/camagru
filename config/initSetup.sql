CREATE DATABASE IF NOT EXISTS db_camagru;

USE db_camagru;

CREATE TABLE IF NOT EXISTS `db_camagru`.`members` (
    member_id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email VARCHAR (255) NOT NULL,
    username VARCHAR (255) NOT NULL,
    password VARCHAR (255) NOT NULL,
    verified boolean default 0 NOT NULL,
    notification boolean default 1 NOT NULL,
    INDEX (email)
);

CREATE TABLE IF NOT EXISTS `db_camagru`.`gallery` (
    gallery_id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    member_id INTEGER NOT NULL,
    image VARCHAR (255) NOT NULL,
    likes INTEGER DEFAULT 0,
    FOREIGN KEY (member_id) REFERENCES members (member_id)
);

CREATE TABLE IF NOT EXISTS `db_camagru`.`comments` (
    `gallery_id` INTEGER NOT NULL,
    `member_id` INTEGER NOT NULL,
    `comment` VARCHAR (255) NOT NULL,
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (gallery_id) REFERENCES gallery (gallery_id),
    FOREIGN KEY (member_id) REFERENCES members (member_id)
);

CREATE TABLE IF NOT EXISTS `db_camagru`.`likes` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    gallery_id INT NOT NULL,
    member_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(gallery_id) REFERENCES gallery(gallery_id),
    FOREIGN KEY(member_id) REFERENCES members(member_id),
    CONSTRAINT UK_LIKES UNIQUE(gallery_id, member_id)
);

CREATE TABLE IF NOT EXISTS `db_camagru`.`email_tokens` (
    email VARCHAR(255) PRIMARY KEY NOT NULL,
    token VARCHAR(255) NOT NULL,
    INDEX (email)
);

CREATE TABLE IF NOT EXISTS `db_camagru`.`reset` (
    email VARCHAR(255) PRIMARY KEY NOT NULL,
    token VARCHAR(255) NOT NULL,
    INDEX (email)
);
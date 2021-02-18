CREATE TABLE reset (
    email VARCHAR(255) PRIMARY KEY NOT NULL,
    token VARCHAR(255) NOT NULL,
    INDEX (email)
) engine = INNODB
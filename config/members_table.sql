CREATE TABLE members (
    member_id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email VARCHAR (255) NOT NULL,
    username VARCHAR (255) NOT NULL,
    password VARCHAR (255) NOT NULL,
    verified boolean default 0 NOT NULL,
    notification boolean default 1 NOT NULL,
    INDEX (email)
) engine = INNODB;
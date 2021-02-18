CREATE TABLE comments (
    `gallery_id` INTEGER NOT NULL,
    `member_id` INTEGER NOT NULL,
    `comment` VARCHAR (255) NOT NULL,
    `date` DATETIME NOT NULL DEFAULT NOW (),
    FOREIGN KEY (gallery_id) REFERENCES gallery (gallery_id),
    FOREIGN KEY (member_id) REFERENCES members (member_id)
);
CREATE TABLE gallery (
    gallery_id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    member_id INTEGER NOT NULL,
    image VARCHAR (255) NOT NULL,
    likes INTEGER DEFAULT 0,
    FOREIGN KEY (member_id) REFERENCES members (member_id)
);
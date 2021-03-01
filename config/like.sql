CREATE TABLE likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    gallery_id INT NOT NULL,
    member_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(gallery_id) REFERENCES gallery(gallery_id),
    FOREIGN KEY(member_id) REFERENCES members(member_id),
    CONSTRAINT UK_LIKES UNIQUE(gallery_id, member_id)
);
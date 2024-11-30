CREATE TABLE courses (
id CHAR(36) PRIMARY KEY,
name VARCHAR(255) NOT NULL,
description TEXT,
preview TEXT,
category_id CHAR(36) NOT NULL,
created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
);
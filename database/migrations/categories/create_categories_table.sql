CREATE TABLE categories (
id CHAR(36)PRIMARY KEY,
name VARCHAR(255) NOT NULL,
description TEXT,
parent_id CHAR(36) NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
CONSTRAINT fk_parent_category FOREIGN KEY (parent_id) REFERENCES categories (id) ON DELETE SET NULL
);
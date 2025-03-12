-- update default password to hashed password\

ALTER TABLE staff_login
MODIFY password VARCHAR(255) NOT NULL DEFAULT '$2y$10$[your_generated_hash_here]';

-- RESET DATABASE
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS buku;

-- TABLE USERS
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    PASSWORD VARCHAR(255) NOT NULL,
    ROLE ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul_buku VARCHAR(150) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    kategori ENUM('Novel', 'Komik', 'Pelajaran', 'Agama', 'Bisnis', 'Lainnya') NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    tanggal_masuk DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO users (username, email, PASSWORD, ROLE)
VALUES 
('admin', 'admin@gmail.com', '$2y$10$z1J9l0Zp8h3QmYvQpQ0x0u9dQhZl7k8Qm0v9x1c2y3z4a5b6c7d8e', 'admin');

INSERT INTO users (username, email, PASSWORD, ROLE)
VALUES 
('user1', 'user1@gmail.com', '$2y$10$K8m9p0QwE3rT5yUiOpAsDfGhJkLzXcVbNmQwErTyUiOpAsDfGhJk', 'user');

-- DATA BUKU
INSERT INTO buku (judul_buku, penulis, kategori, harga, stok, tanggal_masuk)
VALUES
('Laskar Pelangi', 'Andrea Hirata', 'Novel', 89000, 45, '2025-01-10'),
('Atomic Habits', 'James Clear', 'Bisnis', 135000, 20, '2025-02-10'),
('One Piece Vol. 100', 'Eiichiro Oda', 'Komik', 45000, 30, '2025-02-01');
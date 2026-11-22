-- Database: db_kopi_girimekar
CREATE DATABASE IF NOT EXISTS db_kopi_girimekar;
USE db_kopi_girimekar;

-- Tabel Petani
CREATE TABLE IF NOT EXISTS petani (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_petani VARCHAR(20) NOT NULL UNIQUE,
    nama_petani VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    luas_lahan DECIMAL(5,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Hasil Panen
CREATE TABLE IF NOT EXISTS panen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_petani VARCHAR(20) NOT NULL,
    tanggal_panen DATE NOT NULL,
    jumlah_panen_kg DECIMAL(10,2) NOT NULL,
    jenis_kopi ENUM('Arabika', 'Robusta', 'Liberika') DEFAULT 'Arabika',
    FOREIGN KEY (id_petani) REFERENCES petani(id_petani) ON DELETE CASCADE
);

-- Data Awal (Dummy Data)
INSERT INTO petani (id_petani, nama_petani, alamat, luas_lahan) VALUES
('PTN-001', 'Asep Sunandar', 'Blok Pasir Wangi, Giri Mekar', 2.50),
('PTN-002', 'Siti Aminah', 'Blok Cikawari, Giri Mekar', 1.75),
('PTN-003', 'Dedi Mulyadi', 'Blok Batu Kuda, Giri Mekar', 3.20);

INSERT INTO panen (id_petani, tanggal_panen, jumlah_panen_kg, jenis_kopi) VALUES
('PTN-001', '2026-08-15', 450.50, 'Arabika'),
('PTN-002', '2026-09-10', 310.00, 'Arabika'),
('PTN-003', '2026-10-05', 620.75, 'Robusta');

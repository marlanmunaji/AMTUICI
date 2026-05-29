-- Setup Database
CREATE DATABASE IF NOT EXISTS `amtuici`;
USE `amtuici`;

-- Setup Table: tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `judul_tugas` VARCHAR(255) NOT NULL,
  `kategori` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `tgl_mulai` DATE NOT NULL,
  `waktu_mulai` TIME NOT NULL,
  `tgl_deadline` DATE NOT NULL,
  `waktu_deadline` TIME NOT NULL,
  `tgl_selesai` DATE DEFAULT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'Belum Selesai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert sample data
INSERT INTO `tasks` (`judul_tugas`, `kategori`, `deskripsi`, `tgl_mulai`, `waktu_mulai`, `tgl_deadline`, `waktu_deadline`, `status`) VALUES
('Tugas ETS', 'Kuliah', 'Membuat Aplikasi Task Management Tugas.', '2026-05-29', '08:00:00', '2026-05-31', '23:59:00', 'Belum Selesai'),
('Desain Landing Page', 'Pekerjaan', 'Merancang UI/UX halaman beranda untuk klien baru.', '2026-05-28', '09:00:00', '2026-06-05', '17:00:00', 'Sedang Dikerjakan'),
('Beli Bahan Makanan', 'Pribadi', 'Membeli buah, sayur, dan susu di supermarket.', '2026-05-29', '16:00:00', '2026-05-29', '19:00:00', 'Selesai');

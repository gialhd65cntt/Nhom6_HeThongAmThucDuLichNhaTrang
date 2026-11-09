-- =============================================================================
-- HE THONG QUANG BA AM THUC VA DU LICH NHA TRANG (FINAL PRODUCTION SCHEMA)
-- MySQL 8.0.16+ / MariaDB 10.5+
-- =============================================================================

CREATE DATABASE IF NOT EXISTS `nhatrang_tourism` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `nhatrang_tourism`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. BANG NGUOI_DUNG
DROP TABLE IF EXISTS `nguoi_dung`;
CREATE TABLE `nguoi_dung` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ho_ten` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `mat_khau` VARCHAR(255) NOT NULL,
  `so_dien_thoai` VARCHAR(15) DEFAULT NULL,
  `anh_dai_dien` VARCHAR(255) DEFAULT NULL,
  `vai_tro` ENUM('admin', 'khach_hang') NOT NULL DEFAULT 'khach_hang',
  `diem_tich_luy` INT UNSIGNED NOT NULL DEFAULT 0,
  `trang_thai` ENUM('hoat_dong', 'bi_khoa') NOT NULL DEFAULT 'hoat_dong',
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. BANG DANH_MUC
DROP TABLE IF EXISTS `danh_muc`;
CREATE TABLE `danh_muc` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ten_danh_muc` VARCHAR(100) NOT NULL,
  `duong_dan` VARCHAR(120) NOT NULL UNIQUE,
  `loai_danh_muc` ENUM('am_thuc', 'du_lich') NOT NULL,
  `bieu_tuong` VARCHAR(100) DEFAULT NULL,
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. BANG DIA_DIEM
DROP TABLE IF EXISTS `dia_diem`;
CREATE TABLE `dia_diem` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `danh_muc_id` INT UNSIGNED NOT NULL,
  `ten_dia_diem` VARCHAR(200) NOT NULL,
  `duong_dan` VARCHAR(220) NOT NULL UNIQUE,
  `dia_chi` VARCHAR(255) NOT NULL,
  `vi_do` DECIMAL(10, 8) NOT NULL,
  `kinh_do` DECIMAL(11, 8) NOT NULL,
  `gia_thap_nhat` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
  `gia_cao_nhat` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
  `gio_mo_cua` TIME DEFAULT NULL,
  `gio_dong_cua` TIME DEFAULT NULL,
  `anh_dai_dien` VARCHAR(255) NOT NULL,
  `mo_ta_ngan` TEXT DEFAULT NULL,
  `noi_dung_chi_tiet` LONGTEXT DEFAULT NULL,
  `co_ban_ve` BOOLEAN NOT NULL DEFAULT FALSE,
  `trang_thai` ENUM('hien_thi', 'an') NOT NULL DEFAULT 'hien_thi',
  `luot_xem` INT UNSIGNED NOT NULL DEFAULT 0,
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `ft_tim_kiem` (`ten_dia_diem`, `dia_chi`, `mo_ta_ngan`),
  KEY `idx_dia_diem_trang_thai_luot_xem` (`trang_thai`, `luot_xem` DESC),
  CONSTRAINT `chk_dia_diem_gia` CHECK (`gia_thap_nhat` >= 0 AND `gia_cao_nhat` >= `gia_thap_nhat`),
  CONSTRAINT `chk_dia_diem_toa_do` CHECK (`vi_do` BETWEEN -90.00000000 AND 90.00000000 AND `kinh_do` BETWEEN -180.00000000 AND 180.00000000),
  CONSTRAINT `fk_dia_diem_danh_muc` FOREIGN KEY (`danh_muc_id`) REFERENCES `danh_muc` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. BANG HINH_ANH_DIA_DIEM
DROP TABLE IF EXISTS `hinh_anh_dia_diem`;
CREATE TABLE `hinh_anh_dia_diem` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dia_diem_id` BIGINT UNSIGNED NOT NULL,
  `duong_dan_anh` VARCHAR(255) NOT NULL,
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_hinh_anh_dia_diem` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. BANG GOI_VE
DROP TABLE IF EXISTS `goi_ve`;
CREATE TABLE `goi_ve` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dia_diem_id` BIGINT UNSIGNED NOT NULL,
  `ten_goi_ve` VARCHAR(150) NOT NULL,
  `mo_ta` TEXT DEFAULT NULL,
  `gia_nguoi_lon` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
  `gia_tre_em` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
  `trang_thai` ENUM('dang_ban', 'tam_dung') NOT NULL DEFAULT 'dang_ban',
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `chk_goi_ve_gia` CHECK (`gia_nguoi_lon` >= 0 AND `gia_tre_em` >= 0),
  CONSTRAINT `fk_goi_ve_dia_diem` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. BANG TON_KHO_VE
DROP TABLE IF EXISTS `ton_kho_ve`;
CREATE TABLE `ton_kho_ve` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `goi_ve_id` BIGINT UNSIGNED NOT NULL,
  `ngay_su_dung` DATE NOT NULL,
  `tong_so_ve` INT UNSIGNED NOT NULL DEFAULT 500,
  `so_ve_con_lai` INT UNSIGNED NOT NULL DEFAULT 500,
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_goi_ve_ngay` (`goi_ve_id`, `ngay_su_dung`),
  CONSTRAINT `chk_ton_kho_hop_le` CHECK (`so_ve_con_lai` <= `tong_so_ve`),
  CONSTRAINT `fk_ton_kho_goi_ve` FOREIGN KEY (`goi_ve_id`) REFERENCES `goi_ve` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. BANG DON_HANG (Tích hợp E-Voucher)
DROP TABLE IF EXISTS `don_hang`;
CREATE TABLE `don_hang` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ma_don_hang` VARCHAR(30) NOT NULL UNIQUE,
  `ma_qr` VARCHAR(255) DEFAULT NULL,
  `nguoi_dung_id` BIGINT UNSIGNED NOT NULL,
  `ten_khach_hang` VARCHAR(100) NOT NULL,
  `email_khach_hang` VARCHAR(100) NOT NULL,
  `sdt_khach_hang` VARCHAR(15) NOT NULL,
  `tong_tien` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
  `phuong_thuc_thanh_toan` ENUM('vnpay', 'momo', 'chuyen_khoan', 'tai_quay') NOT NULL,
  `trang_thai_thanh_toan` ENUM('cho_thanh_toan', 'cho_xac_nhan', 'da_thanh_toan', 'that_bai', 'da_hoan_tien') NOT NULL DEFAULT 'cho_thanh_toan',
  `trang_thai_don_hang` ENUM('moi_tao', 'cho_xac_nhan', 'da_xac_nhan', 'hoan_thanh', 'da_huy') NOT NULL DEFAULT 'moi_tao',
  `ghi_chu` TEXT DEFAULT NULL,
  `ngay_xoa` TIMESTAMP NULL DEFAULT NULL,
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `chk_don_hang_tong_tien` CHECK (`tong_tien` >= 0),
  CONSTRAINT `fk_don_hang_nguoi_dung` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. BANG CHI_TIET_DON_HANG (Thành tiền tính tự động - Store Generated)
DROP TABLE IF EXISTS `chi_tiet_don_hang`;
CREATE TABLE `chi_tiet_don_hang` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `don_hang_id` BIGINT UNSIGNED NOT NULL,
  `ton_kho_ve_id` BIGINT UNSIGNED NOT NULL,
  `ngay_tham_quan` DATE NOT NULL,
  `so_luong_nguoi_lon` INT UNSIGNED NOT NULL DEFAULT 0,
  `so_luong_tre_em` INT UNSIGNED NOT NULL DEFAULT 0,
  `don_gia_nguoi_lon` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
  `don_gia_tre_em` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
  `thanh_tien` DECIMAL(12, 2) GENERATED ALWAYS AS ((`so_luong_nguoi_lon` * `don_gia_nguoi_lon`) + (`so_luong_tre_em` * `don_gia_tre_em`)) STORED,
  PRIMARY KEY (`id`),
  CONSTRAINT `chk_chi_tiet_so_luong` CHECK ((`so_luong_nguoi_lon` + `so_luong_tre_em`) > 0),
  CONSTRAINT `chk_chi_tiet_don_gia` CHECK (`don_gia_nguoi_lon` >= 0 AND `don_gia_tre_em` >= 0),
  CONSTRAINT `fk_chi_tiet_don_hang` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_chi_tiet_ton_kho` FOREIGN KEY (`ton_kho_ve_id`) REFERENCES `ton_kho_ve` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. BANG GIAO_DICH_THANH_TOAN
DROP TABLE IF EXISTS `giao_dich_thanh_toan`;
CREATE TABLE `giao_dich_thanh_toan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `don_hang_id` BIGINT UNSIGNED NOT NULL,
  `cong_thanh_toan` ENUM('vnpay', 'momo', 'chuyen_khoan', 'tai_quay') NOT NULL,
  `ma_giao_dich` VARCHAR(100) DEFAULT NULL,
  `so_tien` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
  `loai_tien_te` VARCHAR(10) NOT NULL DEFAULT 'VND',
  `du_lieu_phan_hoi` TEXT DEFAULT NULL,
  `trang_thai` ENUM('dang_cho', 'thanh_cong', 'that_bai', 'da_huy', 'da_hoan_tien') NOT NULL DEFAULT 'dang_cho',
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_cong_ma_giao_dich` (`cong_thanh_toan`, `ma_giao_dich`),
  CONSTRAINT `chk_giao_dich_so_tien` CHECK (`so_tien` >= 0),
  CONSTRAINT `fk_giao_dich_don_hang` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hang` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. BANG DANH_GIA
DROP TABLE IF EXISTS `danh_gia`;
CREATE TABLE `danh_gia` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nguoi_dung_id` BIGINT UNSIGNED NOT NULL,
  `dia_diem_id` BIGINT UNSIGNED NOT NULL,
  `so_sao` TINYINT UNSIGNED NOT NULL,
  `noi_dung` TEXT NOT NULL,
  `hinh_anh` TEXT DEFAULT NULL,
  `trang_thai` ENUM('da_duyet', 'da_an') NOT NULL DEFAULT 'da_duyet',
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_mot_danh_gia_mot_nguoi` (`nguoi_dung_id`, `dia_diem_id`),
  CONSTRAINT `chk_danh_gia_so_sao` CHECK (`so_sao` BETWEEN 1 AND 5),
  CONSTRAINT `fk_danh_gia_nguoi_dung` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_danh_gia_dia_diem` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. BANG YEU_THICH (WISHLIST)
DROP TABLE IF EXISTS `yeu_thich`;
CREATE TABLE `yeu_thich` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nguoi_dung_id` BIGINT UNSIGNED NOT NULL,
  `dia_diem_id` BIGINT UNSIGNED NOT NULL,
  `ngay_tao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nguoidung_diadiem_yeuthich` (`nguoi_dung_id`, `dia_diem_id`),
  CONSTRAINT `fk_yeuthich_nguoidung` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yeuthich_dia_diem` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. BANG CHECK_IN_DIA_DIEM (GAMIFICATION & DIGITAL PASSPORT)
DROP TABLE IF EXISTS `check_in_dia_diem`;
CREATE TABLE `check_in_dia_diem` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nguoi_dung_id` BIGINT UNSIGNED NOT NULL,
  `dia_diem_id` BIGINT UNSIGNED NOT NULL,
  `vi_do_checkin` DECIMAL(10, 8) DEFAULT NULL,
  `kinh_do_checkin` DECIMAL(11, 8) DEFAULT NULL,
  `khoang_cach_m` INT UNSIGNED DEFAULT NULL,
  `diem_thuong` INT UNSIGNED NOT NULL DEFAULT 50,
  `ghi_chu` VARCHAR(255) DEFAULT NULL,
  `ngay_check_in` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_checkin_user` (`nguoi_dung_id`),
  KEY `idx_checkin_location` (`dia_diem_id`),
  KEY `idx_checkin_date` (`ngay_check_in`),
  CONSTRAINT `fk_checkin_user` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_checkin_location` FOREIGN KEY (`dia_diem_id`) REFERENCES `dia_diem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. BANG AI_CHAT_MESSAGES (LICH SU TRO CHUYEN AI TOUR)
DROP TABLE IF EXISTS `ai_chat_messages`;
CREATE TABLE `ai_chat_messages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `role` ENUM('user', 'model') NOT NULL,
  `message` LONGTEXT NOT NULL,
  `matched_locations` JSON NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_chat` (`user_id`, `id` DESC),
  CONSTRAINT `fk_aichat_user` FOREIGN KEY (`user_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. BANG AI_SAVED_ITINERARIES (LICH TRINH AI DA LUU)
DROP TABLE IF EXISTS `ai_saved_itineraries`;
CREATE TABLE `ai_saved_itineraries` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `tieu_de` VARCHAR(255) NOT NULL,
  `so_ngay` INT UNSIGNED NOT NULL DEFAULT 1,
  `phong_cach` VARCHAR(100) DEFAULT NULL,
  `ngan_sach` VARCHAR(100) DEFAULT NULL,
  `noi_dung_markdown` LONGTEXT NOT NULL,
  `dia_diem_ids` JSON NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_saved_tours` (`user_id`, `id` DESC),
  CONSTRAINT `fk_saved_tours_user` FOREIGN KEY (`user_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 15. TRIGGER: CHAN XOA TAI KHOAN QUAN TRI VIEN (ADMIN PROTECTION)
-- =============================================================================
DROP TRIGGER IF EXISTS `tg_chan_xoa_admin`;
DELIMITER $$
CREATE TRIGGER `tg_chan_xoa_admin`
BEFORE DELETE ON `nguoi_dung`
FOR EACH ROW
BEGIN
  IF OLD.vai_tro = 'admin' OR OLD.id = 1 THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'LỖI BẢO MẬT: Không thể xóa tài khoản Quản trị viên hệ thống!';
  END IF;
END$$
DELIMITER ;

SET FOREIGN_KEY_CHECKS = 1;


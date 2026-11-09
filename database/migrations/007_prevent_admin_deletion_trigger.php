<?php

require_once dirname(__DIR__, 2) . '/app/bootstrap.php';

use App\Config\Database;

try {
    $pdo = Database::getConnection();
    echo "Connected to database successfully.\n";

    // 1. Xóa trigger cũ nếu đã tồn tại để tránh xung đột
    $pdo->exec("DROP TRIGGER IF EXISTS `tg_chan_xoa_admin`");
    echo "Dropped existing trigger tg_chan_xoa_admin (if any).\n";

    // 2. Tạo trigger ngăn chặn xóa tài khoản admin hoặc tài khoản gốc (id = 1)
    $sql = "
    CREATE TRIGGER `tg_chan_xoa_admin`
    BEFORE DELETE ON `nguoi_dung`
    FOR EACH ROW
    BEGIN
        IF OLD.vai_tro = 'admin' OR OLD.id = 1 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'LỖI BẢO MẬT: Không thể xóa tài khoản Quản trị viên hệ thống!';
        END IF;
    END;
    ";

    $pdo->exec($sql);
    echo "Created trigger tg_chan_xoa_admin successfully.\n";

    echo "Migration 007 completed successfully.\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}

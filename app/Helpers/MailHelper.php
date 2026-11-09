<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailHelper
{
    /**
     * Gửi email xác nhận đặt vé và E-Voucher cho khách hàng qua SMTP thực tế
     */
    public static function guiEmailXacNhan(array $donHang, array $chiTiet = []): bool
    {
        $toEmail = $donHang['email_khach_hang'] ?? '';
        $toName  = $donHang['ten_khach_hang'] ?? 'Quý khách';
        $maDon   = $donHang['ma_don_hang'] ?? '';
        $tongTien = FormatHelper::tienTe((float)($donHang['tong_tien'] ?? 0));
        $sdtKhach = $donHang['sdt_khach_hang'] ?? '';
        $ngayTao = !empty($donHang['ngay_tao']) ? date('d/m/Y H:i', strtotime($donHang['ngay_tao'])) : date('d/m/Y H:i');

        if (empty($toEmail)) {
            return false;
        }

        $isPaid = ($donHang['trang_thai_thanh_toan'] ?? '') === 'da_thanh_toan';
        $isTaiQuay = ($donHang['phuong_thuc_thanh_toan'] ?? '') === 'tai_quay';

        if ($isTaiQuay && !$isPaid) {
            $subject = "[Nha Trang Staycation] Xác nhận đặt vé thành công (Thanh toán tại quầy) - Mã đơn #{$maDon}";
            $loiChao = "Cảm ơn bạn đã lựa chọn Nha Trang Staycation. Đơn đặt vé của bạn đã được ghi nhận thành công với hình thức <strong>Thanh toán tiền mặt tại quầy</strong>. Bạn vui lòng xuất trình mã đơn hàng hoặc phiếu E-Voucher điện tử bên dưới tại quầy tiếp đón để thanh toán và nhận vé vào cổng.";
            $trangThaiHtml = "<span style='color: #d97706; font-weight: 600; font-size: 13px;'>⏳ Chờ thanh toán tại quầy</span>";
            $tongTienLabel = "Tổng tiền thanh toán tại quầy:";
            $huongDan = "Khi tới điểm vui chơi / tham quan, bạn chỉ cần mở liên kết phiếu vé hoặc xuất trình mã đơn hàng cho nhân viên quầy tiếp đón để thanh toán tiền mặt và nhận vé vào cổng.<br>Mọi thắc mắc xin vui lòng liên hệ Hotline: <strong>1900 1234</strong> hoặc phản hồi email này.";
        } else {
            $subject = "[Nha Trang Staycation] Xác nhận đặt vé thành công - Mã đơn #{$maDon}";
            $loiChao = "Cảm ơn bạn đã lựa chọn Nha Trang Staycation. Đơn đặt vé của bạn đã được thanh toán thành công và vé điện tử E-Voucher đã sẵn sàng sử dụng.";
            $trangThaiHtml = "<span style='color: #10b981; font-weight: 600; font-size: 13px;'>✓ Đã thanh toán</span>";
            $tongTienLabel = "Tổng tiền đã thanh toán:";
            $huongDan = "Khi tới điểm vui chơi / tham quan, bạn chỉ cần mở liên kết trên và xuất trình mã QR trên điện thoại cho nhân viên soát vé.<br>Mọi thắc mắc xin vui lòng liên hệ Hotline: <strong>1900 1234</strong> hoặc phản hồi email này.";
        }

        // Xây dựng danh sách vé HTML
        $itemsHtml = '';
        if (!empty($chiTiet)) {
            $itemsHtml .= '<table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px;">';
            $itemsHtml .= '<thead><tr style="background-color: #f1f5f9; text-align: left;"><th style="padding: 10px; border-bottom: 2px solid #cbd5e1;">Dịch vụ / Gói vé</th><th style="padding: 10px; border-bottom: 2px solid #cbd5e1; text-align: center;">SL</th><th style="padding: 10px; border-bottom: 2px solid #cbd5e1; text-align: right;">Đơn giá</th><th style="padding: 10px; border-bottom: 2px solid #cbd5e1; text-align: right;">Thành tiền</th></tr></thead>';
            $itemsHtml .= '<tbody>';
            foreach ($chiTiet as $item) {
                $tenVe = htmlspecialchars($item['ten_goi_ve'] ?? 'Vé tham quan');
                $tenDiaDiem = htmlspecialchars($item['ten_dia_diem'] ?? '');
                $sl = (int)($item['so_luong'] ?? 1);
                $gia = FormatHelper::tienTe((float)($item['don_gia'] ?? 0));
                $tt = FormatHelper::tienTe((float)($item['thanh_tien'] ?? ($sl * (float)($item['don_gia'] ?? 0))));
                
                $itemsHtml .= "<tr>
                    <td style='padding: 10px; border-bottom: 1px solid #e2e8f0;'>
                        <strong>{$tenVe}</strong><br>
                        <span style='color: #64748b; font-size: 12px;'>{$tenDiaDiem}</span>
                    </td>
                    <td style='padding: 10px; border-bottom: 1px solid #e2e8f0; text-align: center;'>{$sl}</td>
                    <td style='padding: 10px; border-bottom: 1px solid #e2e8f0; text-align: right;'>{$gia}</td>
                    <td style='padding: 10px; border-bottom: 1px solid #e2e8f0; text-align: right; font-weight: bold; color: #137a8e;'>{$tt}</td>
                </tr>";
            }
            $itemsHtml .= '</tbody></table>';
        }

        $voucherUrl = url('voucher/' . $maDon);

        $messageBody = "
            <!DOCTYPE html>
            <html lang='vi'>
            <head>
                <meta charset='UTF-8'>
                <title>{$subject}</title>
            </head>
            <body style='font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #1e293b; background-color: #f8fafc; margin: 0; padding: 20px;'>
                <div style='max-width: 620px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;'>
                    <!-- Header -->
                    <div style='background: linear-gradient(135deg, #0b2545 0%, #137a8e 100%); color: #ffffff; padding: 28px 24px; text-align: center;'>
                        <h1 style='margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.5px;'>Nha Trang Staycation</h1>
                        <p style='margin: 6px 0 0 0; font-size: 14px; opacity: 0.9;'>Xác nhận đặt vé & Phiếu E-Voucher điện tử</p>
                    </div>

                    <!-- Nội dung chính -->
                    <div style='padding: 24px 28px;'>
                        <p style='font-size: 15px;'>Xin chào <strong>{$toName}</strong>,</p>
                        <p style='font-size: 14px; color: #475569;'>{$loiChao}</p>

                        <!-- Thông tin đơn hàng -->
                        <div style='background: #f1f5f9; border-radius: 8px; padding: 16px; margin: 20px 0;'>
                            <div style='display: flex; justify-content: space-between; margin-bottom: 8px;'>
                                <span style='color: #64748b; font-size: 13px;'>Mã đơn hàng:</span>
                                <strong style='color: #0b2545; font-size: 16px;'>#{$maDon}</strong>
                            </div>
                            <div style='display: flex; justify-content: space-between; margin-bottom: 8px;'>
                                <span style='color: #64748b; font-size: 13px;'>Thời gian đặt:</span>
                                <span style='font-size: 13px;'>{$ngayTao}</span>
                            </div>
                            <div style='display: flex; justify-content: space-between; margin-bottom: 8px;'>
                                <span style='color: #64748b; font-size: 13px;'>Trạng thái:</span>
                                {$trangThaiHtml}
                            </div>
                            <div style='display: flex; justify-content: space-between; padding-top: 8px; border-top: 1px dashed #cbd5e1;'>
                                <strong style='font-size: 14px;'>{$tongTienLabel}</strong>
                                <strong style='color: #ea580c; font-size: 18px;'>{$tongTien}</strong>
                            </div>
                        </div>

                        <!-- Chi tiết gói vé -->
                        {$itemsHtml}

                        <!-- Nút xem Voucher -->
                        <div style='text-align: center; margin: 32px 0 20px 0;'>
                            <a href='{$voucherUrl}' style='display: inline-block; background-color: #137a8e; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; padding: 12px 28px; border-radius: 30px; box-shadow: 0 4px 10px rgba(19, 122, 142, 0.3);'>
                                Xem & Tải Phiếu Vé Điện Tử E-Voucher
                            </a>
                        </div>

                        <p style='font-size: 13px; color: #64748b; text-align: center; margin-top: 24px; line-height: 1.5;'>
                            {$huongDan}
                        </p>
                    </div>

                    <!-- Footer -->
                    <div style='background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; text-align: center; font-size: 12px; color: #94a3b8;'>
                        © " . date('Y') . " Cổng Thông Tin Du Lịch & Ẩm Thực Nha Trang. All rights reserved.
                    </div>
                </div>
            </body>
            </html>
        ";

        // Ghi nhật ký email cục bộ
        $logDir = dirname(__DIR__, 2) . '/public/uploads';
        if (is_dir($logDir)) {
            $logContent = "[" . date('Y-m-d H:i:s') . "] Chuẩn bị gửi: {$toEmail} | Mã đơn: {$maDon} | Tiêu đề: {$subject}\n";
            @file_put_contents($logDir . '/email_logs.txt', $logContent, FILE_APPEND);
        }

        // 1. Gửi qua PHPMailer nếu có cấu hình SMTP thực tế
        $mailUsername = trim($_ENV['MAIL_USERNAME'] ?? '');
        $mailPassword = trim($_ENV['MAIL_PASSWORD'] ?? '');
        // Tự động loại bỏ khoảng trắng trong App Password do Google tạo
        $mailPassword = str_replace(' ', '', $mailPassword);

        if (!empty($mailUsername) && !empty($mailPassword) && class_exists(PHPMailer::class)) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $mailUsername;
                $mail->Password   = $mailPassword;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = (int)($_ENV['MAIL_PORT'] ?? 587);
                $mail->CharSet    = 'UTF-8';
                $mail->Timeout    = 15;

                $fromAddress = $_ENV['MAIL_FROM_ADDRESS'] ?? $mailUsername;
                $fromName    = $_ENV['MAIL_FROM_NAME'] ?? 'Nha Trang Tourism';
                $mail->setFrom($fromAddress, $fromName);
                $mail->addAddress($toEmail, $toName);
                $mail->addReplyTo($fromAddress, $fromName);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $messageBody;
                $mail->AltBody = "Xác nhận đặt vé #{$maDon}. Quý khách vui lòng xem vé tại: {$voucherUrl}";

                $mail->send();

                if (is_dir($logDir)) {
                    @file_put_contents($logDir . '/email_logs.txt', "[" . date('Y-m-d H:i:s') . "] THÀNH CÔNG: Đã gửi email thực tế qua SMTP tới {$toEmail}\n", FILE_APPEND);
                }
                return true;
            } catch (Exception $e) {
                if (is_dir($logDir)) {
                    @file_put_contents($logDir . '/email_logs.txt', "[" . date('Y-m-d H:i:s') . "] THẤT BẠI: Lỗi gửi SMTP PHPMailer: " . $e->getMessage() . "\n", FILE_APPEND);
                }
                return false;
            }
        }

        // 2. Dự phòng máy chủ hỗ trợ mail()
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=utf-8',
            'From: ' . ($_ENV['MAIL_FROM_NAME'] ?? 'Nha Trang Tourism') . ' <' . ($_ENV['MAIL_FROM_ADDRESS'] ?? 'support@nhatrangtourism.local') . '>'
        ];

        return @mail($toEmail, $subject, $messageBody, implode("\r\n", $headers));
    }

    /**
     * Gửi email thử nghiệm (Test SMTP connection)
     */
    public static function guiEmailThuNghiem(string $toEmail, string &$errorMsg = ''): bool
    {
        $mailUsername = trim($_ENV['MAIL_USERNAME'] ?? '');
        $mailPassword = trim($_ENV['MAIL_PASSWORD'] ?? '');
        $mailPassword = str_replace(' ', '', $mailPassword);

        if (empty($mailUsername) || empty($mailPassword)) {
            $errorMsg = 'Chưa cấu hình MAIL_USERNAME hoặc MAIL_PASSWORD trong file .env';
            return false;
        }

        if (!class_exists(PHPMailer::class)) {
            $errorMsg = 'Thư viện PHPMailer chưa được nạp';
            return false;
        }

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $mailUsername;
            $mail->Password   = $mailPassword;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = (int)($_ENV['MAIL_PORT'] ?? 587);
            $mail->CharSet    = 'UTF-8';
            $mail->Timeout    = 15;

            $fromAddress = $_ENV['MAIL_FROM_ADDRESS'] ?? $mailUsername;
            $fromName    = $_ENV['MAIL_FROM_NAME'] ?? 'Nha Trang Tourism';
            $mail->setFrom($fromAddress, $fromName);
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = '[Nha Trang Staycation] Kiểm tra kết nối SMTP thành công!';
            $mail->Body    = '<h3>Chúc mừng bạn!</h3><p>Hệ thống gửi email SMTP của <strong>Nha Trang Tourism</strong> đã được kết nối thành công và hoạt động hoàn hảo.</p><p>Thời gian thử nghiệm: ' . date('d/m/Y H:i:s') . '</p>';

            $mail->send();
            return true;
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            return false;
        }
    }
}

<footer class="bg-dark text-white mt-auto pt-5 pb-3">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold text-warning mb-3">
                    <i class="bi bi-water me-2"></i>Nha Trang Staycation
                </h5>
                <p class="text-white-50 small">
                    Nền tảng mã nguồn mở quảng bá địa điểm ẩm thực đặc sản và danh lam thắng cảnh TP. Nha Trang. 
                    Tích hợp bản đồ số tương tác Leaflet và hệ sinh thái đặt vé trực tuyến E-Voucher tiện lợi.
                </p>
                <div class="d-flex gap-3 fs-5 text-warning">
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-youtube"></i>
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-github"></i>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3 text-white">Khám Phá</h6>
                <ul class="list-unstyled small text-white-50 d-flex flex-column gap-2">
                    <li><a href="<?= url('locations?loai=am_thuc') ?>" class="text-white-50 text-decoration-none">Hải sản Bờ Kè</a></li>
                    <li><a href="<?= url('locations?loai=am_thuc') ?>" class="text-white-50 text-decoration-none">Bánh căn Tháp Bà</a></li>
                    <li><a href="<?= url('locations?loai=am_thuc') ?>" class="text-white-50 text-decoration-none">Nem nướng Ninh Hòa</a></li>
                    <li><a href="<?= url('locations?loai=am_thuc') ?>" class="text-white-50 text-decoration-none">Bún cá sứa Chợ Đầm</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-white">Điểm Đến & Tour</h6>
                <ul class="list-unstyled small text-white-50 d-flex flex-column gap-2">
                    <li><a href="<?= url('locations?loai=du_lich') ?>" class="text-white-50 text-decoration-none">VinWonders Hòn Tre</a></li>
                    <li><a href="<?= url('locations?loai=du_lich') ?>" class="text-white-50 text-decoration-none">Tháp Bà Ponagar</a></li>
                    <li><a href="<?= url('locations?loai=du_lich') ?>" class="text-white-50 text-decoration-none">Lặn ngắm san hô Hòn Mun</a></li>
                    <li><a href="<?= url('locations?loai=du_lich') ?>" class="text-white-50 text-decoration-none">Viện Hải Dương Học</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-white">Dự Án Học Tập</h6>
                <p class="text-white-50 small mb-2">
                    <strong>Môn học:</strong> Phát triển phần mềm mã nguồn mở<br>
                    <strong>Mô hình:</strong> Forking Workflow & MVC PHP<br>
                    <strong>Công nghệ:</strong> PHP 8, MariaDB, Leaflet.js, Bootstrap 5
                </p>
            </div>
        </div>

        <hr class="border-secondary">
        <div class="text-center text-white-50 small">
            &copy; <?= date('Y') ?> Nha Trang Staycation. Dự án Mã Nguồn Mở. All rights reserved.
        </div>
    </div>
</footer>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Leaflet.js JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<!-- Leaflet MarkerCluster JS -->
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<!-- Custom JS -->
<?php
$jsFile = dirname(__DIR__, 2) . '/public/assets/js/main.js';
$jsVersion = file_exists($jsFile) ? filemtime($jsFile) : time();
?>
<script src="<?= url('assets/js/main.js?v=' . $jsVersion) ?>"></script>

<!-- Trợ Lý AI Tour Floating Widget -->
<?php require_once __DIR__ . '/ai_floating_widget.php'; ?>
</body>
</html>


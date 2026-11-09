<?php
/**
 * @var array $stats
 * @var array $spotlightLocations
 * @var array $ticketActivities
 * @var array $topFood
 * @var array $topTravel
 * @var array $categories
 */
require_once dirname(__DIR__, 2) . '/layouts/header.php';
?>
<?php require_once dirname(__DIR__, 2) . '/layouts/navbar.php'; ?>

<!-- ========================================================
     1. HERO BANNER & AGODA-STYLE SEARCH CARD
     ======================================================== -->
<section class="agoda-hero">
    <div class="container">
        <div class="text-center text-white mb-2">
            <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-2 shadow-sm">
                <i class="bi bi-compass-fill me-1"></i>Nền Tảng Du Lịch & Ẩm Thực Thông Minh Nha Trang
            </span>
            <h1 class="agoda-hero-title mb-2">RONG CHƠI NHA TRANG, GIÁ VẪN "YÊU THƯƠNG"</h1>
            <p class="text-white-50 small mb-0" style="font-size: 1.05rem;">
                Hơn <?= $stats['totalLocations'] ?> tọa độ ẩm thực đặc sản, vé vui chơi kỷ lục và tour vịnh đảo xuất vé E-Voucher tức thì
            </p>
        </div>

        <!-- Khung Tìm Kiếm Phong Cách Agoda -->
        <div class="row justify-content-center">
            <div class="col-xxl-10 col-xl-11 col-lg-12">
                <div class="agoda-search-card">
                    <!-- Tab Switcher -->
                    <div class="d-flex flex-wrap gap-2 mb-3 pb-2 border-bottom">
                        <button type="button" class="agoda-tab-btn active" onclick="switchSearchTab('all', this)">
                            <i class="bi bi-grid me-1"></i>Tất Cả Trải Nghiệm
                        </button>
                        <button type="button" class="agoda-tab-btn" onclick="switchSearchTab('du_lich', this)">
                            <i class="bi bi-ticket-perforated me-1"></i>Vé Tham Quan & Tour
                        </button>
                        <button type="button" class="agoda-tab-btn" onclick="switchSearchTab('am_thuc', this)">
                            <i class="bi bi-cup-hot me-1"></i>Quán Ăn & Đặc Sản
                        </button>
                    </div>

                    <!-- Search Form -->
                    <form action="<?= url('locations') ?>" method="GET" id="homeSearchForm">
                        <input type="hidden" name="loai" id="searchLoaiInput" value="">

                        <div class="row g-2 align-items-center">
                            <!-- Ô Tìm kiếm từ khóa -->
                            <div class="col-lg-4 col-md-12">
                                <div class="search-field-box d-flex align-items-center gap-2">
                                    <i class="bi bi-search text-primary fs-5"></i>
                                    <div class="w-100">
                                        <label class="text-muted small d-block mb-0" style="font-size: 11px; font-weight: 600;">BẠN MUỐN ĐI ĐÂU HOẶC ĂN GÌ?</label>
                                        <input type="text" name="tu_khoa" class="form-control p-0 border-0 shadow-none fw-semibold text-dark" 
                                               placeholder="VinWonders, I-Resort, Nem nướng, Hải sản...">
                                    </div>
                                </div>
                            </div>

                            <!-- Ô Ngày tham quan -->
                            <div class="col-lg-3 col-sm-6">
                                <div class="search-field-box d-flex align-items-center gap-2">
                                    <i class="bi bi-calendar-event text-primary fs-5"></i>
                                    <div class="w-100">
                                        <label class="text-muted small d-block mb-0" style="font-size: 11px; font-weight: 600;">NGÀY DỰ KIẾN</label>
                                        <input type="date" class="form-control p-0 border-0 shadow-none fw-semibold text-dark" 
                                               value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Ô Khách tham quan -->
                            <div class="col-lg-3 col-sm-6">
                                <div class="search-field-box d-flex align-items-center gap-2">
                                    <i class="bi bi-people text-primary fs-5"></i>
                                    <div class="w-100">
                                        <label class="text-muted small d-block mb-0" style="font-size: 11px; font-weight: 600;">SỐ LƯỢNG</label>
                                        <select class="form-select p-0 border-0 shadow-none fw-semibold text-dark search-guest-select" name="so_luong" style="font-size: 14px; padding-right: 1.25rem !important;" aria-label="Chọn số lượng khách">
                                            <option value="1">1 người lớn</option>
                                            <option value="2" selected>2 người lớn</option>
                                            <option value="4">Gia đình (4 người)</option>
                                            <option value="10">Đoàn khách (10+)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Nút Tìm kiếm -->
                            <div class="col-lg-2 col-md-12">
                                <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold fs-6 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-search"></i>TÌM KIẾM
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Gợi ý tìm kiếm phổ biến -->
                    <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-2 border-top small text-muted">
                        <span class="fw-semibold text-dark"><i class="bi bi-fire text-danger me-1"></i>Xu hướng:</span>
                        <a href="<?= url('locations?tu_khoa=VinWonders') ?>" class="badge bg-light text-secondary text-decoration-none border px-2 py-1 rounded-pill">#VinWonders</a>
                        <a href="<?= url('locations?tu_khoa=I-Resort') ?>" class="badge bg-light text-secondary text-decoration-none border px-2 py-1 rounded-pill">#I-Resort Khoáng Nóng</a>
                        <a href="<?= url('locations?tu_khoa=Nhà+Hát+Đó') ?>" class="badge bg-light text-secondary text-decoration-none border px-2 py-1 rounded-pill">#Show Rối Mơ</a>
                        <a href="<?= url('locations?tu_khoa=Hải+Sản') ?>" class="badge bg-light text-secondary text-decoration-none border px-2 py-1 rounded-pill">#Hải Sản Bờ Kè</a>
                        <a href="<?= url('locations?tu_khoa=Hòn+Mun') ?>" class="badge bg-light text-secondary text-decoration-none border px-2 py-1 rounded-pill">#Lặn Biển Hòn Mun</a>
                        <a href="<?= url('locations?tu_khoa=Nem+Nướng') ?>" class="badge bg-light text-secondary text-decoration-none border px-2 py-1 rounded-pill">#Nem Nướng Ninh Hòa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     1.1. WIDGET THỜI TIẾT BIỂN & THỦY TRIỀU NHA TRANG (MARINE WEATHER & TIDE)
     ======================================================== -->
<?php if (!empty($weather)): ?>
<section class="container my-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white border">
        <div class="card-body p-3 p-lg-4">
            <div class="row g-3 align-items-center">
                <!-- Cột 1: Nhiệt độ & Thời tiết hiện tại -->
                <div class="col-lg-3 col-md-6 border-end">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 58px; height: 58px; flex-shrink: 0;">
                            <i class="bi <?= htmlspecialchars($weather['icon'] ?? 'bi-sun-fill text-warning') ?> fs-2"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-baseline gap-2">
                                <h2 class="fw-bold mb-0 text-dark"><?= $weather['temp'] ?? 29 ?>°C</h2>
                                <span class="text-muted small">Cảm giác: <?= $weather['feel'] ?? 31 ?>°C</span>
                            </div>
                            <div class="fw-semibold text-dark small">
                                <?= htmlspecialchars($weather['condition_vi']) ?>
                            </div>
                            <div class="text-muted" style="font-size: 11px;">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>Vịnh Nha Trang • Cập nhật <?= $weather['updated_at'] ?? date('H:i') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột 2: Sóng biển & Gió biển -->
                <div class="col-lg-3 col-md-6 border-end">
                    <div class="small text-muted mb-1 fw-semibold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">
                        <i class="bi bi-water text-info me-1"></i>Tình trạng biển
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-info-subtle text-info border border-info-subtle fw-semibold px-2 py-1">
                            <i class="bi bi-tsunami me-1"></i>Sóng: <?= htmlspecialchars($weather['wave_height']) ?>
                        </span>
                        <span class="badge bg-light text-secondary border fw-medium px-2 py-1">
                            <i class="bi bi-wind me-1"></i>Gió: <?= htmlspecialchars($weather['wind_speed']) ?> km/h
                        </span>
                    </div>
                    <p class="mb-0 text-success small fw-medium">
                        <i class="bi bi-shield-check me-1"></i><?= htmlspecialchars($weather['wave_status_vi']) ?>
                    </p>
                </div>

                <!-- Cột 3: Lịch Thủy triều trong ngày -->
                <div class="col-lg-3 col-md-6 border-end">
                    <div class="small text-muted mb-1 fw-semibold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">
                        <i class="bi bi-moisture text-primary me-1"></i>Lịch Thủy Triều Hôm Nay
                    </div>
                    <div class="d-flex justify-content-between align-items-center small mb-1">
                        <span class="text-muted">Triều lên (Nước lớn):</span>
                        <strong class="text-primary"><?= htmlspecialchars($weather['tide_high_1']) ?> & <?= htmlspecialchars($weather['tide_high_2']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center small">
                        <span class="text-muted">Triều rút (Nước ròng):</span>
                        <strong class="text-secondary"><?= htmlspecialchars($weather['tide_low_1']) ?> & <?= htmlspecialchars($weather['tide_low_2']) ?></strong>
                    </div>
                </div>

                <!-- Cột 4: Khuyến nghị du lịch biển -->
                <div class="col-lg-3 col-md-6">
                    <div class="p-2 rounded-3 bg-light border">
                        <div class="d-flex align-items-center gap-1 text-primary fw-semibold small mb-1">
                            <i class="bi bi-lightbulb-fill text-warning"></i>
                            <span>Khuyến nghị du lịch biển:</span>
                        </div>
                        <p class="text-muted mb-0 lh-sm" style="font-size: 11.5px;">
                            <?= htmlspecialchars($weather['recommendation_vi']) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ========================================================
     2. KHÁM PHÁ NHA TRANG THEO SỞ THÍCH (CIRCLE ICONS - AGODA STYLE)
     ======================================================== -->
<section class="container my-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h4 fw-bold text-dark mb-1">Khám phá Nha Trang theo cách của bạn</h2>
            <p class="text-muted small mb-0">Tự do lựa chọn hình thức du ngoạn biển đảo hoặc oanh tạc thiên đường ẩm thực</p>
        </div>
        <a href="<?= url('locations') ?>" class="text-primary small fw-semibold text-decoration-none">
            Xem tất cả &rarr;
        </a>
    </div>

    <div class="row g-3 row-cols-2 row-cols-sm-4 row-cols-lg-8 text-center">
        <!-- 1. Tour Biển Đảo -->
        <div class="col">
            <a href="<?= url('locations?danh_muc_id=4') ?>" class="circle-cat-item">
                <div class="circle-cat-icon text-info">
                    <i class="bi bi-compass"></i>
                </div>
                <span class="small fw-semibold">Tour Biển Đảo</span>
            </a>
        </div>

        <!-- 2. Khoáng Nóng & Tắm Bùn -->
        <div class="col">
            <a href="<?= url('dia-diem/i-resort-nha-trang') ?>" class="circle-cat-item">
                <div class="circle-cat-icon text-warning">
                    <i class="bi bi-water"></i>
                </div>
                <span class="small fw-semibold">Khoáng Nóng</span>
            </a>
        </div>

        <!-- 3. Công Viên Giải Trí -->
        <div class="col">
            <a href="<?= url('locations?danh_muc_id=6') ?>" class="circle-cat-item">
                <div class="circle-cat-icon text-primary">
                    <i class="bi bi-sun"></i>
                </div>
                <span class="small fw-semibold">Công Viên Giải Trí</span>
            </a>
        </div>

        <!-- 4. Hải Sản Tươi Sống -->
        <div class="col">
            <a href="<?= url('locations?danh_muc_id=1') ?>" class="circle-cat-item">
                <div class="circle-cat-icon text-danger">
                    <i class="bi bi-droplet-half"></i>
                </div>
                <span class="small fw-semibold">Hải Sản Tươi Sống</span>
            </a>
        </div>

        <!-- 5. Đặc Sản Truyền Thống -->
        <div class="col">
            <a href="<?= url('locations?danh_muc_id=2') ?>" class="circle-cat-item">
                <div class="circle-cat-icon text-success">
                    <i class="bi bi-cup-hot"></i>
                </div>
                <span class="small fw-semibold">Nem & Bánh Căn</span>
            </a>
        </div>

        <!-- 6. Di Tích & Văn Hóa -->
        <div class="col">
            <a href="<?= url('locations?danh_muc_id=5') ?>" class="circle-cat-item">
                <div class="circle-cat-icon text-secondary">
                    <i class="bi bi-bank"></i>
                </div>
                <span class="small fw-semibold">Tháp Bà & Di Tích</span>
            </a>
        </div>

        <!-- 7. Show Diễn Rối Mơ -->
        <div class="col">
            <a href="<?= url('dia-diem/nha-hat-do-nha-trang') ?>" class="circle-cat-item">
                <div class="circle-cat-icon text-primary">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
                <span class="small fw-semibold">Nhà Hát Đó</span>
            </a>
        </div>

        <!-- 8. Ăn Vặt & Tráng Miệng -->
        <div class="col">
            <a href="<?= url('locations?danh_muc_id=3') ?>" class="circle-cat-item">
                <div class="circle-cat-icon text-warning">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <span class="small fw-semibold">Ăn Vặt Phố Biển</span>
            </a>
        </div>
    </div>
</section>

<!-- ========================================================
     3. CÁC ĐIỂM ĐẾN NỔI BẬT Ở NHA TRANG (LARGE SPOTLIGHT CARDS)
     ======================================================== -->
<section class="container my-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h4 fw-bold text-dark mb-1">Các điểm đến nổi bật ở Nha Trang</h2>
            <p class="text-muted small mb-0">Địa danh biểu tượng không thể bỏ qua được cộng đồng du khách bình chọn cao nhất</p>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($spotlightList as $sp): ?>
            <div class="col-lg-3 col-md-6">
                <a href="<?= url('dia-diem/' . $sp['duong_dan']) ?>" class="text-decoration-none">
                    <div class="agoda-spotlight-card">
                        <img src="<?= htmlspecialchars(hinh_anh($sp['anh_dai_dien'])) ?>" alt="<?= htmlspecialchars($sp['ten_dia_diem']) ?>" class="agoda-spotlight-img" loading="lazy">
                        <div class="agoda-spotlight-overlay">
                            <span class="badge bg-warning text-dark px-2 py-1 rounded-pill small fw-bold mb-2 align-self-start">
                                <i class="bi bi-star-fill me-1"></i><?= number_format($sp['diem_danh_gia'], 1) ?> ⭐
                            </span>
                            <h3 class="h5 fw-bold text-white mb-1"><?= htmlspecialchars($sp['ten_dia_diem']) ?></h3>
                            <p class="text-white-50 small mb-0 line-clamp-1" style="font-size: 12px;">
                                <?= htmlspecialchars($sp['mo_ta_ngan']) ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ========================================================
     4. HOẠT ĐỘNG KHÔNG THỂ BỎ QUA & VÉ THAM QUAN ONLINE (AGODA STYLE)
     ======================================================== -->
<section class="py-5 agoda-activities-section">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill mb-2">
                    <i class="bi bi-lightning-charge-fill me-1"></i>Đặt vé tức thì - Nhận E-Voucher QR
                </span>
                <h2 class="h4 fw-bold text-dark mb-1">Hoạt động không thể bỏ qua ở Nha Trang</h2>
                <p class="text-muted small mb-0">Tiết kiệm thời gian xếp hàng tại cổng, xuất vé điện tử đối soát tiện lợi</p>
            </div>
            <div>
                <a href="<?= url('locations?co_ban_ve=1') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    Xem tất cả vé tham quan &rarr;
                </a>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($veOnlineList as $tk): ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="activity-item-card">
                        <div class="position-relative">
                            <img src="<?= htmlspecialchars(hinh_anh($tk['anh_dai_dien'])) ?>" alt="<?= htmlspecialchars($tk['ten_dia_diem']) ?>" class="activity-thumb" loading="lazy">
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-primary text-white small px-2 py-1 rounded-pill shadow-sm">
                                    <i class="bi bi-ticket-perforated me-1"></i>Vé Online
                                </span>
                            </div>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-warning text-dark small fw-bold px-2 py-1 rounded-pill shadow-sm">
                                    <i class="bi bi-star-fill text-dark me-1"></i><?= number_format($tk['diem_danh_gia'], 1) ?>
                                </span>
                            </div>
                        </div>

                        <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <span class="text-muted small d-block mb-1">
                                    <i class="bi bi-geo-alt me-1 text-danger"></i><?= htmlspecialchars($tk['ten_danh_muc']) ?>
                                </span>
                                <h3 class="fw-bold text-dark mb-1" style="font-size: 1rem;">
                                    <a href="<?= url('dia-diem/' . $tk['duong_dan']) ?>" class="text-dark text-decoration-none line-clamp-1">
                                        <?= htmlspecialchars($tk['ten_dia_diem']) ?>
                                    </a>
                                </h3>
                                <p class="text-muted small line-clamp-2 mb-3" style="font-size: 13px;">
                                    <?= htmlspecialchars($tk['ten_goi_ve'] ?? $tk['mo_ta_ngan']) ?>
                                </p>
                            </div>

                            <div class="pt-2 border-top d-flex align-items-center justify-content-between mt-auto">
                                <div>
                                    <span class="text-muted d-block" style="font-size: 11px;">Giá từ</span>
                                    <strong class="text-danger fs-6">
                                        <?= \App\Helpers\FormatHelper::tienTe((float)($tk['gia_nguoi_lon'] ?? $tk['gia_thap_nhat'])) ?>
                                    </strong>
                                </div>
                                <?php if (!empty($tk['goi_ve_id'])): ?>
                                    <a href="<?= url('booking/' . $tk['goi_ve_id']) ?>" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
                                        Đặt Vé
                                    </a>
                                <?php else: ?>
                                    <a href="<?= url('dia-diem/' . $tk['duong_dan']) ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        Chi Tiết
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========================================================
     5. BANNER CHƯƠNG TRÌNH ƯU ĐÃI & TIỆN ÍCH TRỌN GÓI (AGODA STYLE)
     ======================================================== -->
<section class="container my-5">
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="agoda-promo-banner promo-banner-1 shadow-sm">
                <div>
                    <span class="badge bg-white text-dark fw-bold rounded-pill px-3 py-1 mb-2">Ưu Đãi Mùa Hè</span>
                    <h3 class="h5 fw-bold mb-1">Combo Tour 3 Đảo & Lặn San Hô</h3>
                    <p class="small text-white-50 mb-0">Giảm đến 20% khi đặt trước cho đoàn gia đình</p>
                </div>
                <div class="mt-3">
                    <a href="<?= url('locations?danh_muc_id=4') ?>" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-dark">Khám phá ngay</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="agoda-promo-banner promo-banner-2 shadow-sm">
                <div>
                    <span class="badge bg-white text-dark fw-bold rounded-pill px-3 py-1 mb-2">Vé Hoàng Hôn</span>
                    <h3 class="h5 fw-bold mb-1">Cáp Treo VinWonders Sau 16h00</h3>
                    <p class="small text-white-50 mb-0">Ngắm trọn vịnh Nha Trang về đêm & show diễn Tata</p>
                </div>
                <div class="mt-3">
                    <a href="<?= url('dia-diem/vinwonders-nha-trang') ?>" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-dark">Đặt vé 560k</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="agoda-promo-banner promo-banner-3 shadow-sm">
                <div>
                    <span class="badge bg-white text-dark fw-bold rounded-pill px-3 py-1 mb-2">Thư Giãn</span>
                    <h3 class="h5 fw-bold mb-1">Khoáng Nóng I-Resort</h3>
                    <p class="small text-white-50 mb-0">Tắm bùn khoáng thiên nhiên phục hồi sức khỏe</p>
                </div>
                <div class="mt-3">
                    <a href="<?= url('dia-diem/i-resort-nha-trang') ?>" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-dark">Xem gói vé</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Tiện ích độc quyền hệ thống -->
    <div class="bg-white rounded-4 p-4 p-md-5 border shadow-sm">
        <h4 class="fw-bold text-dark text-center mb-4">Trải nghiệm du lịch thông minh cùng Nha Trang Staycation</h4>
        <div class="row g-4 text-center">
            <div class="col-md-3 col-sm-6">
                <div class="p-2">
                    <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Định Vị GPS Thông Minh</h6>
                    <p class="text-muted small mb-0">Tự động tính khoảng cách km từ vị trí của bạn tới từng quán ăn và thắng cảnh.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="p-2">
                    <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="bi bi-qr-code-scan"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">E-Voucher QR Điện Tử</h6>
                    <p class="text-muted small mb-0">Xuất vé điện tử tức thì trên điện thoại, hỗ trợ lưu PDF và in ấn chuẩn khổ A4/A5.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="p-2">
                    <div class="bg-warning-subtle text-warning-emphasis rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Thanh Toán VietQR An Toàn</h6>
                    <p class="text-muted small mb-0">Quét mã chuyển khoản Napas tiện lợi 1-click, đối soát tự động chính xác.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="p-2">
                    <div class="bg-info-subtle text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Đối Soát Quầy Nhanh Chóng</h6>
                    <p class="text-muted small mb-0">Nhân viên tiếp đón quét mã QR đổi vé vào cổng trong 3 giây, không lo phe vé.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     6. THIÊN ĐƯỜNG ẨM THỰC ĐẶC SẢN NHA TRANG (FOODIES SECTION)
     ======================================================== -->
<section class="container my-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-1 rounded-pill mb-2">
                <i class="bi bi-fire me-1"></i>Hương vị miền duyên hải
            </span>
            <h2 class="h4 fw-bold text-dark mb-1">Ẩm thực & Quán ăn trứ danh Nha Trang</h2>
            <p class="text-muted small mb-0">Được người dân địa phương và các tín đồ ẩm thực khuyên thử</p>
        </div>
        <a href="<?= url('locations?loai=am_thuc') ?>" class="text-primary small fw-semibold text-decoration-none">
            Xem tất cả quán ăn &rarr;
        </a>
    </div>

    <div class="row g-4">
        <?php foreach ($amThucList as $food): ?>
            <div class="col-lg-3 col-md-6">
                <div class="activity-item-card">
                    <div class="position-relative">
                        <img src="<?= htmlspecialchars(hinh_anh($food['anh_dai_dien'])) ?>" alt="<?= htmlspecialchars($food['ten_dia_diem']) ?>" class="activity-thumb" loading="lazy">
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger text-white small px-2 py-1 rounded-pill shadow-sm">
                                Ẩm Thực
                            </span>
                        </div>
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-white text-dark small fw-bold px-2 py-1 rounded-pill shadow-sm">
                                <?= \App\Helpers\FormatHelper::saoHtml((float)$food['diem_danh_gia']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                        <div>
                            <span class="text-muted small d-block mb-1"><?= htmlspecialchars($food['ten_danh_muc']) ?></span>
                            <h3 class="fw-bold text-dark mb-1" style="font-size: 1rem;">
                                <a href="<?= url('dia-diem/' . $food['duong_dan']) ?>" class="text-dark text-decoration-none line-clamp-1">
                                    <?= htmlspecialchars($food['ten_dia_diem']) ?>
                                </a>
                            </h3>
                            <p class="text-muted small line-clamp-2 mb-3" style="font-size: 12px;">
                                <i class="bi bi-geo-alt me-1 text-danger"></i><?= htmlspecialchars($food['dia_chi']) ?>
                            </p>
                        </div>

                        <div class="pt-2 border-top d-flex align-items-center justify-content-between mt-auto">
                            <span class="fw-bold small text-danger">
                                <?= \App\Helpers\FormatHelper::tienTe((float)$food['gia_thap_nhat']) ?> - <?= \App\Helpers\FormatHelper::tienTe((float)$food['gia_cao_nhat']) ?>
                            </span>
                            <a href="<?= url('dia-diem/' . $food['duong_dan']) ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ========================================================
     7. BẢN ĐỒ TƯƠNG TÁC SỐ NHA TRANG (LIVE INTERACTIVE MAP)
     ======================================================== -->
<section class="container my-5">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-3">
            <div>
                <span class="badge bg-info-subtle text-info-emphasis fw-bold px-3 py-1 rounded-pill mb-2">
                    <i class="bi bi-geo-fill me-1"></i>Bản đồ số du lịch Nha Trang
                </span>
                <h3 class="h4 fw-bold text-dark mb-1">Tọa độ 30 điểm tham quan & ẩm thực đặc sản</h3>
                <p class="text-muted small mb-0">Bấm vào từng ghim trên bản đồ để tra cứu tọa độ, mức giá và tìm đường đi</p>
            </div>
            <div>
                <a href="<?= url('locations') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-fullscreen me-1"></i>Mở rộng bản đồ toàn màn hình
                </a>
            </div>
        </div>

        <div class="map-frame" style="height: 480px;">
            <div id="map" style="width: 100%; height: 100%;"></div>
        </div>
    </div>
</section>

<script>
    window.APP_URL = "<?= rtrim(url(''), '/') ?>";

    function switchSearchTab(type, btn) {
        document.querySelectorAll('.agoda-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('searchLoaiInput').value = (type === 'all') ? '' : type;
    }
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>

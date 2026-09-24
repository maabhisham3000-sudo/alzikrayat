<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// تعريف مسار الأساس للمشروع تلقائياً لتجنب أي مشاكل في الروابط
$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . "/alzikrayat/public";
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الذكريات - تطبيق مشاركة الصور</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }
        /* ضمان تفاعل الأزرار ووضوح طبقاتها فوق أي عنصر */
        .navbar .btn, .navbar a {
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container-fluid px-4">
            
            <!-- الشعار وروابط التصفح جهة اليمين -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand fw-bold fs-4 ms-4 text-white" href="<?php echo $baseUrl; ?>/#home-section">📸 الذكريات</a>
                
                <ul class="navbar-nav flex-row">
                    <li class="nav-item me-3">
                        <a class="nav-link text-white" href="<?php echo $baseUrl; ?>/#home-section">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link text-white" href="<?php echo $baseUrl; ?>/#gallery-section">Gallery</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link text-white" href="<?php echo $baseUrl; ?>/#about-section">About Us</a>
                    </li>
                </ul>
            </div>

            <!-- عبارة الترحيب في المنتصف تماماً (باستخدام mx-auto) -->
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['user_name']) || isset($_SESSION['username'])): ?>
                <?php 
                    $username = $_SESSION['user_name'] ?? $_SESSION['username'] ?? $_SESSION['first_name'] ?? 'مستخدم';
                ?>
                <div class="mx-auto d-none d-lg-block">
                    <span class="text-white fw-semibold fs-5">
                        Hi, <span class="text-warning"><?= htmlspecialchars($username); ?></span>
                    </span>
                </div>
            <?php endif; ?>

            <!-- أزرار Login و Register أو زر Logout جهة اليسار -->
            <div class="d-flex align-items-center ps-3">
                <?php if (isset($_SESSION['user_id']) || isset($_SESSION['user_name']) || isset($_SESSION['username'])): ?>
                    <!-- عرض اسم المستخدم في الموبايل إذا الشاشة صغيرة، وزر Logout في اليسار للجميع -->
                    <div class="d-lg-none ms-2">
                        <span class="text-white fw-semibold">
                            Hi, <span class="text-warning"><?= htmlspecialchars($username); ?></span>
                        </span>
                    </div>
                    <a class="btn btn-light btn-sm text-danger fw-bold px-3 shadow-sm" href="<?php echo $baseUrl; ?>/logout">Logout</a>
                <?php else: ?>
                    <a class="btn btn-outline-light btn-sm px-3 fw-bold me-2" href="<?php echo $baseUrl; ?>/login">Login</a>
                    <a class="btn btn-light text-primary btn-sm px-3 fw-bold shadow-sm" href="<?php echo $baseUrl; ?>/register">Register</a>
                <?php endif; ?>
            </div>

        </div>
    </nav>

    <div class="container mb-5">
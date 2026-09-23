<?php
// التأكد من بدء الجلسة للتحقق من حالة المستخدم
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الذكريات - تطبيق مشاركة الصور</title>
    <!-- استدعاء Bootstrap 5 للتصميم المتجاوب -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- شريط التنقل العلوي (Navbar) المُحسّن والمنسق -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <!-- اسم التطبيق أو الشعار في أقصى اليمين -->
            <a class="navbar-brand fw-bold fs-4" href="/alzikrayat/public/">📸 الذكريات</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- محتوى الشريط -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- روابط التنقل الرئيسية -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active px-3" href="/alzikrayat/public/">الرئيسية</a>
                    </li>
                </ul>

                <!-- عناصر المستخدم في أقصى اليسار مع مسافة واضحة -->
                <ul class="navbar-nav align-items-center ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- إذا كان المستخدم مسجلاً للدخول -->
                        <li class="nav-item d-flex align-items-center gap-3">
                            <span class="text-white fw-semibold">
                                Hi, <span class="text-warning"><?php echo htmlspecialchars($_SESSION['first_name'] ?? ''); ?></span>
                            </span>
                            <a href="/alzikrayat/public/logout" class="btn btn-light btn-sm text-danger fw-bold px-3 shadow-sm">Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- إذا لم يكن المستخدم مسجلاً -->
                        <li class="nav-item">
                            <a href="/alzikrayat/public/login" class="btn btn-outline-light btn-sm fw-bold px-4">Please Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mb-5">